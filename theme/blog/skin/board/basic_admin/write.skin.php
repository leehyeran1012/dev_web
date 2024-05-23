<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/custom.css">', 0);

?>

<div class="container-fluid">

	<form name="fwrite" id="fwrite" action="<?= $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
	<input type="hidden" name="uid" value="<?= get_uniqid(); ?>">
	<input type="hidden" name="w" value="<?= $w ?>">
	<input type="hidden" name="bo_table" value="<?= $bo_table ?>">
	<input type="hidden" name="wr_id" value="<?= $wr_id ?>">
	<input type="hidden" name="sca" value="<?= $sca ?>">
	<input type="hidden" name="sfl" value="<?= $sfl ?>">
	<input type="hidden" name="stx" value="<?= $stx ?>">
	<input type="hidden" name="spt" value="<?= $spt ?>">
	<input type="hidden" name="sst" value="<?= $sst ?>">
	<input type="hidden" name="sod" value="<?= $sod ?>">
	<input type="hidden" name="page" value="<?= $page ?>">

	<?php
	$option = '';
	$option_hidden = '';
	if ($is_notice || $is_html || $is_secret || $is_mail) {
		$option = '';
		if ($is_notice) {

			$option .= '<div class="form-check form-check-inline"><input type="checkbox" id="notice" name="notice" value="1" class="form-check-input" '.$notice_checked.'><label class="form-check-label" for="notice">공지</label></div>';
		}

		if ($is_html) {
			if ($is_dhtml_editor) {
				$option_hidden .= '<input type="hidden" value="html1" name="html">';
			} else {
				$option .= '<div class="form-check form-check-inline"><input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" class="form-check-input" '.$html_checked.'><label class="form-check-label" for="html">HTML</label></div>';
			}
		}

		if ($is_secret) {
			if ($is_admin || $is_secret==1) {
				$option .= '<div class="form-check form-check-inline"><input type="checkbox" id="secret" name="secret" value="secret" class="form-check-input" '.$secret_checked.'><label class="form-check-label" for="secret">비밀글</label></div>';
			} else {
				$option_hidden .= '<input type="hidden" name="secret" value="secret">';
			}
		}

		if ($is_mail) {
			$option .= '<div class="form-check form-check-inline"><input type="checkbox" id="mail" name="mail" value="mail" class="form-check-input" '.$recv_email_checked.'><label class="form-check-label" for="mail">답변메일받기</label></div>';
		}
	}

	echo $option_hidden;
	?>

	<?php if ($is_category) { ?>
	<div class="row mb-2">
		<label class="col-sm-1 col-form-label">분류</label>
		<div class="col-sm-11">
			<select class="form-select" name="ca_name" id="ca_name" required>
				<option value="">분류를 선택하세요</option>
				<?= $category_option ?>
			</select>
		</div>
	</div>
	<?php } ?>

	<?php if ($is_name) { ?>
	<div class="row mb-2">
		<label class="col-sm-1 col-form-label d-none d-lg-block">이름</label>
		<div class="col-sm-11">
			<input class="form-control" type="text" name="wr_name" value="<?= $name ?>" id="wr_name" required placeholder="이름">
		</div>
	</div>
	<?php } ?>

	<?php if ($is_password) { ?>
	<div class="row mb-2">
		<label class="col-sm-1 col-form-label">비밀번호</label>
		<div class="col-sm-11">
			<input class="form-control" type="password" name="wr_password" id="wr_password" <?= $password_required ?> placeholder="비밀번호">
		</div>
	</div>
	<?php } ?>

	<?php if ($is_email) { ?>
	<div class="row mb-2">
		<label class="col-sm-1 col-form-label">이메일</label>
		<div class="col-sm-11">
			<input class="form-control" type="email" name="wr_email" value="<?= $email ?>" id="wr_email" placeholder="이메일">
		</div>
	</div>
	<?php } ?>

	<?php if ($is_homepage) { ?>
	<div class="row mb-2">
		<label class="col-sm-1 col-form-label">홈페이지</label>
		<div class="col-sm-11">
			<input class="form-control" type="url" name="wr_homepage" value="<?= $homepage ?>" id="wr_homepage" placeholder="홈페이지">
		</div>
	</div>
	<?php } ?>

	<?php if ($option) { ?>
	<div class="row mb-2">
		<label class="col-sm-1 col-form-label d-none d-lg-block">옵션</label>
		<div class="col-sm-11 pt-2">
			<?= $option ?>
		</div>
	</div>
	<?php } ?>

	<div class="row mb-3">
		<label class="col-sm-1 col-form-label d-none d-lg-block">제목</label>
		<div class="col-sm-11">
			<div id="autosave_wrapper">
				<div class="input-group">
					<input class="form-control" type="text" name="wr_subject" value="<?= $subject ?>" id="wr_subject" required placeholder="제목">
					<?php if ($is_member) { // 임시 저장된 글 기능 ?>
					<script src="<?= G5_JS_URL; ?>/autosave.js"></script>
					<?php if($editor_content_js) echo $editor_content_js; ?>
					<button type="button" id="btn_autosave" class="btn btn-outline-primary" style="width:140px">임시저장 (<span id="autosave_count"><?= $autosave_count; ?></span>)</button>
					<?php } ?>
				</div>

				<div id="autosave_pop">
					<strong>임시 저장된 글 목록</strong>
					<ul></ul>
					<div><button type="button" class="autosave_close">닫기</button></div>
				</div>
			</div>
		</div>
	</div>

	<?php for ($i=1; $i<10; $i++) if($board['bo_'.$i.'_subj']) { ?>
	<div class="row mb-2">
		<label class="col-sm-1 col-form-label"><?= $board['bo_'.$i.'_subj']; ?></label>
		<div class="col-sm-11">
			<input class="form-control" type="text" name="wr_<?= $i ?>" value="<?= ($w=='u' ? $write['wr_'.$i] : $board['bo_'.$i]); ?>" id="wr_<?= $i ?>">
		</div>
	</div>
	<?php } ?>

	<div class="row mb-3">
		<label class="col-sm-1 col-form-label d-none d-lg-block">내용</label>
		<div class="wr_content col-sm-11 <?= $is_dhtml_editor ? $config['cf_editor'] : ''; ?>">
			<?php if($write_min || $write_max) { ?>
			<!-- 최소/최대 글자 수 사용 시 -->
			<small>이 게시판은 최소 <strong><?= $write_min; ?></strong>글자 이상, 최대 <strong><?= $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</small>
			<?php } ?>
			<?php if(!$is_dhtml_editor) $editor_html = str_replace('<textarea id="wr_content" name="wr_content"', '<textarea id="wr_content" name="wr_content" class="form-control"', $editor_html); ?>
			<?= $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
			<?php if($write_min || $write_max) { ?>
			<!-- 최소/최대 글자 수 사용 시 -->
			<div class="d-flex justify-content-end"><small><span id="char_count"></span> 글자</small></div>
			<?php } ?>
		<br></div>
	</div>

	<?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
	<div class="row mb-2">
		<label class="col-sm-1 col-form-label d-none d-lg-block">링크<?= $i?></label>
		<div class="col-sm-11">
			<input class="form-control" type="url" name="wr_link<?= $i ?>" value="<?php if($w=="u"){ echo $write['wr_link'.$i];} ?>" id="wr_link<?= $i ?>" placeholder="링크<?= $i?> 주소를 입력해주세요.">
		</div>
	</div>
	<?php } ?>

	<?php

		$file_count = 2;
		$file = get_file($bo_table, $wr_id);
		if($file_count < $file['count']) {
			$file_count = $file['count'];
		}

		for($i=0;$i<$file_count;$i++){
			if(! isset($file[$i])) {
				$file[$i] = array('file'=>null, 'source'=>null, 'size'=>null, 'bf_content' => null);
			}
		}
	?>

	<?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
	<div class="row mb-2">
		<label class="col-sm-1 col-form-label d-none d-lg-block">파일<?= $i+1 ?></label>
		<div class="col-sm-11">
			<div class="input-group">
				<input class="form-control" type="file" name="bf_file[]" id="bf_file_<?= $i+1 ?>" title="<?= $upload_max_filesize ?> 이하만 업로드 가능" data-default="<?= ($w == 'u') ? $file[$i]['source'] : ''; ?>">
				<?php if ($is_file_content) { ?>
				<input class="form-control" type="text" name="bf_content[]" value="<?= ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." placeholder="파일 설명을 입력해주세요.">
				<?php } ?>
			</div>
			<?php if($w == 'u' && $file[$i]['file']) { ?>
			<div class="pt-1">
			<input type="checkbox" class="form-check-input" id="bf_file_del<?= $i ?>" name="bf_file_del[<?=$i?>]" value="1">
			<label class="form-check-label" for="bf_file_del<?= $i ?>"><?= $file[$i]["source"] ?>(<?= $file[$i]["size"] ?>) 파일 삭제</label>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php } ?>

	<?php if ($is_use_captcha) { ?>
	<div class="row mb-2">
		<label class="col-sm-1 col-form-label">보안</label>
		<div class="col-sm-11">
			<?= $captcha_html ?>
		</div>
	</div>
	<?php } ?>

	<div class="d-flex justify-content-end my-4">
		<div class="btn-group xs-100">
			<input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn btn-primary">
			<a href="<?= get_pretty_url($bo_table); ?>" class="btn btn-outline-primary">취소</a>
		</div>
	</div>

	</form>

</div>

<script>
<?php if($write_min || $write_max) { ?>
// 글자수 제한
var char_min = parseInt(<?= $write_min; ?>); // 최소
var char_max = parseInt(<?= $write_max; ?>); // 최대
check_byte("wr_content", "char_count");

$(function() {
	$("#wr_content").on("keyup", function() {
		check_byte("wr_content", "char_count");
	});
});

<?php } ?>
function html_auto_br(obj)
{
	if (obj.checked) {
		result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
		if (result)
			obj.value = "html2";
		else
			obj.value = "html1";
	}
	else
		obj.value = "";
}

function fwrite_submit(f)
{
	<?= $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

	var subject = "";
	var content = "";
	$.ajax({
		url: g5_bbs_url+"/ajax.filter.php",
		type: "POST",
		data: {
			"subject": f.wr_subject.value,
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

	if (subject) {
		alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
		f.wr_subject.focus();
		return false;
	}

	if (content) {
		alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
		if (typeof(ed_wr_content) != "undefined")
			ed_wr_content.returnFalse();
		else
			f.wr_content.focus();
		return false;
	}

	if (document.getElementById("char_count")) {
		if (char_min > 0 || char_max > 0) {
			var cnt = parseInt(check_byte("wr_content", "char_count"));
			if (char_min > 0 && char_min > cnt) {
				alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
				return false;
			}
			else if (char_max > 0 && char_max < cnt) {
				alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
				return false;
			}
		}
	}

	<?= $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

	document.getElementById("btn_submit").disabled = "disabled";

	return true;
}
</script>
