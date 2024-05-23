<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<script>
// 글자수 제한
var char_min = parseInt(<?= $comment_min ?>); // 최소
var char_max = parseInt(<?= $comment_max ?>); // 최대
</script>

<ol class="list-unstyled">
    <?php
    $cmt_amt = count($list);
    for ($i=0; $i<$cmt_amt; $i++) {
        $comment_id = $list[$i]['wr_id'];
		$comment_depth = strlen($list[$i]['wr_comment_reply']);
        $cmt_depth = strlen($list[$i]['wr_comment_reply']) * 50;
        $comment = $list[$i]['content'];

		$comment = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $comment);

		if($comment_depth > $comment_depth_old) echo '<ol class="list-unstyled ps-3 ps-lg-4">';
		if($comment_depth < $comment_depth_old) for($j=$comment_depth; $j<$comment_depth_old; $j++) echo '</ol>';

		$mb_info = get_member_info($list[$i]['mb_id'], $list[$i]['wr_name'], $list[$i]['wr_email'], $list[$i]['wr_homepage']);

		$list[$i]['datetime'] = substr($list[$i]['wr_datetime'],0,10) == G5_TIME_YMD ? substr($list[$i]['wr_datetime'], 11, 8) : substr($list[$i]['wr_datetime'], 2, 8);
     ?>
	<li class="mb-4">
		<div class="anchor">
			<a name="c_<?= $comment_id ?>"></a>
		</div>
		<div class="d-flex mb-4">
			<img class="comm-icon rounded me-3" src="<?= $mb_info['img'] ?>">
			<div class="comm-body w-100">
				<ul class="comm-name list-inline text-muted">
					<li class="list-inline-item">
						<a href="#" class="text-dark fw-bold" data-bs-toggle="dropdown"><?= get_text($list[$i]['wr_name']); ?></a>
						<?php if ($is_ip_view) { ?>
						<small class="text-muted">(<?= $list[$i]['ip']; ?>)</small>
						<?php } ?>
						<?= $mb_info['menu'] ?>
					</li>
					<li class="list-inline-item">
						<?php include(G5_THEME_PATH.'/skin/sns/view_comment_list.sns.skin.php'); ?>
					</li>
				</ul>
				<ul class="list-inline">
					<?php if (strstr($list[$i]['wr_option'], "secret")) { ?><img src="<?= $board_skin_url; ?>/img/icon_secret.gif" alt="비밀글"><?php } ?>
			        <?= $comment ?>
				</ul>
				<ul class="list-inline text-muted small pt-1 mb-2">
					<li class="list-inline-item"><i class="fa fa-clock-o"></i> <?= $list[$i]['datetime']; ?></li>

					<?php if ($list[$i]['is_reply']) { ?><li class="list-inline-item"><i class="fa fa-commenting-o"></i> <a href="<?= $c_reply_href;  ?>" onclick="comment_box('<?= $comment_id ?>', 'c'); return false;" class="text-muted">댓글</a></li><?php } ?>
					<?php if ($list[$i]['is_edit']) { ?><li class="list-inline-item"><i class="fa fa-pencil-square"></i> <a href="<?= $c_edit_href;  ?>" onclick="comment_box('<?= $comment_id ?>', 'cu'); return false;" class="text-muted">수정</a></li><?php } ?>
					<?php if ($list[$i]['is_del'])  { ?><li class="list-inline-item"><i class="fa fa-trash-o"></i> <a href="<?= $list[$i]['del_link'];  ?>" onclick="return comment_delete();" class="text-muted">삭제</a></li><?php } ?>
				</ul>
				<span id="edit_<?= $comment_id ?>" class=""></span><!-- 수정 -->
		        <span id="reply_<?= $comment_id ?>" class=""></span><!-- 답변 -->

		        <input type="hidden" value="<?= strstr($list[$i]['wr_option'],"secret") ?>" id="secret_comment_<?= $comment_id ?>">
		        <textarea id="save_comment_<?= $comment_id ?>" style="display:none"><?= get_text($list[$i]['content1'], 0) ?></textarea>
			</div>
		</div>
	</li>
	<?php
		$comment_depth_old = $comment_depth;
	 }

	for($j=1; $j<$comment_depth; $j++) echo '</ol>';
	?>
</ol>

<?php if ($is_comment_write) {
    if($w == '')
        $w = 'c';
?>

<div id="bo_vc_w" class="mb-4">
	<form name="fviewcomment" id="fviewcomment" action="<?= $comment_action_url; ?>" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off">
    <input type="hidden" name="w" value="<?= $w ?>" id="w">
    <input type="hidden" name="bo_table" value="<?= $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?= $wr_id ?>">
    <input type="hidden" name="comment_id" value="<?= $c_id ?>" id="comment_id">
    <input type="hidden" name="sca" value="<?= $sca ?>">
    <input type="hidden" name="sfl" value="<?= $sfl ?>">
    <input type="hidden" name="stx" value="<?= $stx ?>">
    <input type="hidden" name="spt" value="<?= $spt ?>">
    <input type="hidden" name="page" value="<?= $page ?>">
    <input type="hidden" name="is_good" value="">

	<div class="mb-2">
		<textarea id="wr_content" name="wr_content" maxlength="10000" required class="form-control required" rows="3" placeholder="댓글내용을 입력해주세요"><?= $c_wr_content; ?></textarea>
	</div>

	<div id="comment_info" class="row collapse">
		<div class="col-md-6">
			<?php if ($is_guest) { ?>
			<div class="input-group mb-2">
				<input type="text" name="wr_name" value="<?= get_cookie("ck_sns_name"); ?>" id="wr_name" required class="form-control" placeholder="이름">
				<input type="password" name="wr_password" id="wr_password" required class="form-control" placeholder="비밀번호">
			</div>
			<?php }	?>

			<div class="form-check mb-2">
				<input type="checkbox" name="wr_secret" value="secret" id="wr_secret" class="form-check-input">
				<label class="form-check-label" for="wr_secret">비밀글 사용</label>
			</div>

			<?php if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) { ?>
			<div class="mb-2">
				<span id="bo_vc_send_sns"></span>
			</div>
			<?php } ?>

			<?php if ($is_guest) { ?>
			<div class="mb-2">
				<?= $captcha_html; ?>
			</div>
			<?php } ?>
		</div>

		<div class="col-md-6">
			<input type="submit" class="btn btn-primary float-end" value="댓글등록">
		</div>
	</div>
	</form>
</div>

<script>
var save_before = '';
var save_html = document.getElementById('bo_vc_w').innerHTML;

function good_and_write()
{
    var f = document.fviewcomment;
    if (fviewcomment_submit(f)) {
        f.is_good.value = 1;
        f.submit();
    } else {
        f.is_good.value = 0;
    }
}

function fviewcomment_submit(f)
{
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

    f.is_good.value = 0;

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "subject": "",
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        f.wr_content.focus();
        return false;
    }

    // 양쪽 공백 없애기
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
    document.getElementById('wr_content').value = document.getElementById('wr_content').value.replace(pattern, "");
    if (char_min > 0 || char_max > 0)
    {
        check_byte('wr_content', 'char_count');
        var cnt = parseInt(document.getElementById('char_count').innerHTML);
        if (char_min > 0 && char_min > cnt)
        {
            alert("댓글은 "+char_min+"글자 이상 쓰셔야 합니다.");
            return false;
        } else if (char_max > 0 && char_max < cnt)
        {
            alert("댓글은 "+char_max+"글자 이하로 쓰셔야 합니다.");
            return false;
        }
    }
    else if (!document.getElementById('wr_content').value)
    {
        alert("댓글을 입력하여 주십시오.");
        return false;
    }

    if (typeof(f.wr_name) != 'undefined')
    {
        f.wr_name.value = f.wr_name.value.replace(pattern, "");
        if (f.wr_name.value == '')
        {
            alert('이름이 입력되지 않았습니다.');
            f.wr_name.focus();
            return false;
        }
    }

    if (typeof(f.wr_password) != 'undefined')
    {
        f.wr_password.value = f.wr_password.value.replace(pattern, "");
        if (f.wr_password.value == '')
        {
            alert('비밀번호가 입력되지 않았습니다.');
            f.wr_password.focus();
            return false;
        }
    }

    <?php if($is_guest) echo chk_captcha_js();  ?>

    set_comment_token(f);

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}

function comment_box(comment_id, work)
{
    var el_id,
        form_el = 'fviewcomment',
        respond = document.getElementById(form_el);

    // 댓글 아이디가 넘어오면 답변, 수정
    if (comment_id)
    {
        if (work == 'c')
            el_id = 'reply_' + comment_id;
        else
            el_id = 'edit_' + comment_id;
    }
    else
        el_id = 'bo_vc_w';

    if (save_before != el_id)
    {
        if (save_before)
        {
            document.getElementById(save_before).style.display = 'none';
        }

        document.getElementById(el_id).style.display = '';
        document.getElementById(el_id).appendChild(respond);
        //입력값 초기화
        document.getElementById('wr_content').value = '';

        // 댓글 수정
        if (work == 'cu')
        {
            document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
            if (typeof char_count != 'undefined')
                check_byte('wr_content', 'char_count');
            if (document.getElementById('secret_comment_'+comment_id).value)
                document.getElementById('wr_secret').checked = true;
            else
                document.getElementById('wr_secret').checked = false;
        }

        document.getElementById('comment_id').value = comment_id;
        document.getElementById('w').value = work;

        if(save_before)
            $("#captcha_reload").trigger("click");

        save_before = el_id;
    }
}

function comment_delete()
{
    return confirm("이 댓글을 삭제하시겠습니까?");
}

comment_box('', 'c'); // 댓글 입력폼이 보이도록 처리하기위해서 추가 (root님)

<?php if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) { ?>

$(function() {
    // sns 등록
    $("#bo_vc_send_sns").load(
		"<?= G5_THEME_URL; ?>/skin/sns/view_comment_write.sns.skin.php?bo_table=<?= $bo_table; ?>",
        function() {
            save_html = document.getElementById('bo_vc_w').innerHTML;
        }
    );
});
<?php } ?>

$(function() {
	$("#wr_content").focus(function(){
		$("#comment_info").collapse("show");
	});
});

</script>
<?php }else{ if($board['bo_comment_level'] == 2) { ?>
<div id="bo_vc_w" class="mb-4">
	<div class="input-group mb-2">
		<textarea id="wr_content" name="wr_content" disabled class="form-control required" rows="3" placeholder="로그인 후 댓글내용을 입력해주세요"></textarea>
	</div>
</div>
<?php }} ?>