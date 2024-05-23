<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/custom.css">', 0);

$view['content'] = conv_content($view['wr_content'], $html, false);
if (strstr($sfl, 'content'))
    $view['content'] = search_font($stx, $view['content']);

$mb_info = get_member_info($view['mb_id'], $view['wr_name'], $view['wr_email'], $view['wr_homepage']);
?>

<?php if(isset($g5['ads']) && $g5['ads'] && strpos($view['wr_option'], 'secret')===false) { ?>
<div class="mb-4"><?=$g5['ads']?></div>
<?php } ?>

<div class="container-fluid">

	<p class="mb-3 border-bottom pb-2 fs-4 fw-bold"><?= cut_str(get_text($view['wr_subject']), 70); ?></p>

	<div class="d-flex mb-5 border-bottom pb-3">
		<img class="view-icon rounded me-3" src="<?= $mb_info['img'] ?>">
		<div>
			<ul class="list-inline mb-0">
				<li class="list-inline-item">
					<a href="#" data-bs-toggle="dropdown" class="text-muted fs-6"><?= get_text($view['wr_name']); ?></a>
					<?php if ($is_ip_view) { ?>
					<small class="text-muted">(<?= $ip ?>)</small>
					<?php } ?>
					<?= $mb_info['menu'] ?>
				</li>
			</ul>
			<ul class="list-inline text-muted small pt-1">
				<li class="list-inline-item"><i class="bi bi-clock me-2"></i><?= $view['datetime'] ?></li>
				<li class="list-inline-item"><i class="bi bi-eye-fill me-2"></i><?= number_format($view['wr_hit']) ?> 회</li>
				<li class="list-inline-item"><i class="bi bi-chat-dots me-2"></i><?= number_format($view['wr_comment']) ?> 건</li>
			</ul>
		</div>
		<div class="ms-auto">
			<div class="btn-group dropstart">
			  <button type="button" class="btn btn-danger btn-sm rounded" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-gear"></i></button>
			  <ul class="dropdown-menu" style="min-width:60px!important">
				<li><a href="<?= $list_href ?>" class="dropdown-item"><i class="fa fa-list"></i> 목록</a></li>
			<?php if ($update_href || $delete_href || $copy_href || $move_href || $search_href) { ?>
				<?php if ($update_href) { ?><li><a href="<?= $update_href ?>" class="dropdown-item"><i class="fa fa-pencil-square-o"></i> 수정</a></li><?php } ?>
				<?php if ($delete_href) { ?><li><a href="<?= $delete_href ?>" onclick="del(this.href); return false;" class="dropdown-item"><i class="fa fa-trash-o"></i> 삭제</a></li><?php } ?>
				<?php if ($copy_href) { ?><li><a href="<?= $copy_href ?>" onclick="board_move(this.href); return false;" class="dropdown-item"><i class="fa fa-copy"></i> 복사</a></li><?php } ?>
				<?php if ($move_href) { ?><li><a href="<?= $move_href ?>" onclick="board_move(this.href); return false;" class="dropdown-item"><i class="fa fa-arrows-alt"></i> 이동</a></li><?php } ?>
				<?php if ($search_href) { ?><li><a href="<?= $search_href ?>" class="dropdown-item"><i class="fa fa-search"></i> 검색</a></li><?php } ?>
			<?php } ?>

				<?php if ($scrap_href) { ?><li><a href="<?= $scrap_href;  ?>" target="_blank" class="dropdown-item" onclick="win_scrap(this.href); return false;"><i class="fa fa-clipboard"></i> 스크랩</a></li><?php } ?>
				<?php if ($reply_href) { ?><li><a href="<?= $reply_href ?>" class="dropdown-item"><i class="fa fa-reply"></i> 답변</a></li><?php } ?>
				<?php if ($write_href) { ?><li><a href="<?= $write_href ?>" class="dropdown-item"><i class="fa fa-pencil"></i> 글쓰기</a></li><?php } ?>
			  </ul>
			</div>
		</div>
	</div>
	<?php
	$attach = '';

	for ($i=1; $i<10; $i++)
		if($board['bo_'.$i.'_subj'] && $write['wr_'.$i])
			$attach .= '
	<tr>
		<th style="width: 6rem;">'.$board['bo_'.$i.'_subj'].'</th>
		<td>'.$write['wr_'.$i].'</td>
	</tr>';

	if($attach) echo '<table class="table mb-4"><tbody>'.$attach.'</tbody></table>';
	?>

	<div id="bo_v_con" class="mb-5" style="min-height:300px">
		<?php
		// 파일 출력
		for ($i=0; $i<=count($view['file']); $i++)
			if (isset($view['file'][$i]['view']) && $view['file'][$i]['view'])
				echo '<img class="img-fluid d-block" src="'.$view['file'][$i]['path'].'/'.$view['file'][$i]['file'].'">';

		// 본문 내용
		echo str_replace('<img ', '<img class="img-fluid d-block" ', $view['content']);
		?>
	</div>

	<?php if ($is_signature) { ?>
	<div class="mb-4">
		<p><?= $signature ?></p>
	</div>
	<?php } ?>

	<?php if($board['bo_use_good'] || $board['bo_use_nogood']) { ?>
	<div class="mb-4 pt-4 text-center">
		<?php if($board['bo_use_good']) { ?>
		<a href="<?= $good_href?>" id="good_button" class="btn btn-outline-primary <?php if(!$good_href) echo 'disabled'; ?>"><i class="bi bi-hand-thumbs-up"></i> <strong><?= number_format($view['wr_good']); ?></strong></a>
		<b id="bo_v_act_good"></b>
		<?php } ?>
		<?php if($board['bo_use_nogood']) { ?>
		<a href="<?= $nogood_href?>" id="nogood_button" class="btn btn-outline-secondary <?php if(!$nogood_href) echo 'disabled'; ?>"><i class="bi bi-hand-thumbs-down"></i> <strong><?= number_format($view['wr_nogood']); ?></strong></a>
		<b id="bo_v_act_nogood"></b>
		<?php } ?>
	</div>
	<?php } ?>

      <?php
    $cnt = 0;
    if ($view['file']['count']) {
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
	?>

    <?php if($cnt) { ?>
    <!-- 첨부파일 시작 { -->
   <div class="container-fluid p-0 mb-3">
        <ul class="list-group">
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {

				$ff_link = explode("sst=",$view['file'][$i]['href']);
         ?>
            <li class="list-group-item">
               	<i class="fa fa-folder-open" aria-hidden="true"></i>
                <a href="<?= $ff_link[0]  ?>" class="view_file_download">
                    <strong><?= $view['file'][$i]['source'] ?></strong> <?= $view['file'][$i]['content'] ?> (<?= $view['file'][$i]['size'] ?>)
                </a>               
                <span class="float-end"><?= $view['file'][$i]['download'] ?>회 | <?= substr($view['file'][$i]['datetime'],2,8) ?></span>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </div>
    <!-- } 첨부파일 끝 -->
    <?php } ?>

    <?php if(isset($view['link']) && array_filter($view['link'])) { ?>
    <!-- 관련링크 시작 { -->
    <div class="container-fluid rounded p-0 mb-3">
        <!-- <h2>관련링크</h2> -->
        <ul class="list-group">
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = cut_str($view['link'][$i], 70);
            ?>
            <li class="list-group-item">
                <i class="fa fa-link" aria-hidden="true"></i>
                <a href="<?= $view['link_href'][$i] ?>" target="_blank">
                    <strong><?= $link ?></strong>
                </a>
                <span class="float-end"><?= $view['link_hit'][$i] ?>회</span>
            </li>
            <?php
            }
        }
        ?>
        </ul>
    </div>
    <!-- } 관련링크 끝 -->
    <?php } ?>

	<?php include_once(G5_THEME_PATH."/skin/sns/view.sns.skin.php"); ?>

	<?php if ($prev_href || $next_href) { ?>
	<ul class="list-group mb-4">
		<?php if ($prev_href) { ?><li class="list-group-item"><small class="text-muted"><i class="bi bi-caret-up-fill"></i><span class="d-none d-md-inline"> 이전글</span></small> <a href="<?= $prev_href ?>" class="text-dark"><?= $prev_wr_subject;?></a> <small class="float-end text-muted d-none d-md-inline"><?= str_replace('-', '.', substr($prev_wr_date, '2', '8')); ?></small></li><?php } ?>
		<?php if ($next_href) { ?><li class="list-group-item"><small class="text-muted"><i class="bi bi-caret-down-fill"></i><span class="d-none d-md-inline"> 다음글</span></small> <a href="<?= $next_href ?>" class="text-dark"><?= $next_wr_subject;?></a> <small class="float-end text-muted d-none d-md-inline"><?= str_replace('-', '.', substr($next_wr_date, '2', '8')); ?></small></li><?php } ?>
	</ul>
	<?php } ?>

	<?php if(isset($g5['ads']) && $g5['ads'] && strpos($view['wr_option'], 'secret')===false) { ?>
	<div class="mb-4"><?=$g5['ads']?></div>
	<?php } ?>

	<?php
	// 코멘트 입출력
	include_once(G5_BBS_PATH.'/view_comment.php');
	?>

</div>

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?= number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
$(function() {
    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    //sns공유
    $(".btn_share").click(function(){
        $("#bo_v_sns").fadeIn();

    });

    $(document).mouseup(function (e) {
        var container = $("#bo_v_sns");
        if (!container.is(e.target) && container.has(e.target).length === 0){
        container.css("display","none");
        }
    });
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));

				/*
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
				*/
            }
        }, "json"
    );
}
</script>