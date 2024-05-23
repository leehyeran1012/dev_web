<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/custom.css">', 0);
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

if($w == "") {

$wr_1 = "5.23(화) 17:30-18:20)|
5.23(화) 18:30-19:20|
5.23(화) 19:30-20:20|
5.26(금) 19:30-20:20|
5.26(금) 20:30-21:20
D#
상담강사 A^상담강사 B^상담강사 C^상담강사 D^상담강사 E^상담강사 F";

$wr_9 = "학교명 ^s | 학년 ^r 1학년  ^r 2학년 ^r 3학년 | 참석자 ^c 학생 ^c 학부모 ^e 기타";

$wr_2 = "1";
$wr_3 = "1일 4회 운영합니다.(1인당 50분 상담)";

$wrk_1 = [date("Y-m-d"),date("Y-m-d"),"00:00~23:59"];
$wrk_2 = ["40","40","1"];
$wrk_3 = ["선택1","선택하세요","선택2","선택1을 먼저 선택하세요."];
$wrk_4 =  ["7.5~7.10 09:00~15:00","희망자","행사장소"];
}

if ($w == 'u') {
    $wr_1 = get_text(html_purifier($write['wr_1']), 0);

	$wrk_1 = explode("|",$wr_5);
	$wrk_2 = explode("|",$wr_6);
	$wrk_3 = explode("|",$wr_7);
	$wrk_4 = explode("|",$wr_8);
}
?>


<div class="container">

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
	}

	echo $option_hidden;
?>

	<div class="row mb-3">
		<div class="col-sm-2">프로그램명</div>
		<div class="col-sm-10">
			<input type="text" name="wr_subject" value="<?= $subject ?>" id="wr_subject" required class="form-control required" size="50" maxlength="100" placeholder="프로그램명">
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-sm-2">프로그램명 간략설명</div>
		<div class="col-sm-10">
			<input type="text" name="wr_4" value="<?= $wr_4 ?>" required class="form-control required" maxlength="100" placeholder="프로그램 설명">
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-sm-2">신청유형</div>
		<div class="col-sm-10">
			<div class="container border rounded-2 py-2">
				<div class="form-check form-check-inline pe-3">
				  <input class="form-check-input fs-5 me-2" type="radio" name="wr_2" id="r1" value="1"<?php if($wr_2 == 1) echo " checked"; ?> title="그냥 신청만 받는 경우">
				  <label class="form-check-label" for="r1" title="그냥 신청만 받는 경우">선택없이 신청</label>
				</div>
				<div class="form-check form-check-inline pe-3">
				  <input class="form-check-input fs-5 me-2" type="radio" name="wr_2" id="r2" value="2"<?php if($wr_2 == 2) echo " checked"; ?> title="여러개 항목중 하나 선택하는 경우">
				  <label class="form-check-label" for="r2" title="여러개 항목중 하나 선택하는 경우">선택1만 사용</label>
				</div>
				<div class="form-check form-check-inline pe-3">
				  <input class="form-check-input fs-5 fs-5 me-2" type="radio" name="wr_2" id="r3" value="3"<?php if($wr_2 == 3) echo " checked"; ?> title="선택1의 선택에 따라 선택2가 검색되는 경우">
				  <label class="form-check-label" for="r3" title="선택1의 선택에 따라 선택2가 검색되는 경우">선택1, 2 연동형</label>
				</div>
				<div class="form-check form-check-inline pe-3">
				  <input class="form-check-input fs-5 fs-5 me-2" type="radio" name="wr_2" id="r4" value="4"<?php if($wr_2 == 4) echo " checked"; ?> title="선택1, 선택2 각각 신청 받는 경우">
				  <label class="form-check-label" for="r4" title="선택1, 선택2 각각 신청 받는 경우">선택1, 2 각각 선택</label>
				</div>
			</div>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-sm-2">신청기간</div>
		<div class="col-sm-10">
			<div class="input-group text-start fs-5">
				<input class="form-control" type="text" name="wrk_1[]" id="d1" maxlength="10" value="<?= $wrk_1[0] ?>" required>
				<span class="input-group-text">~</span>
				<input class="form-control" type="text" name="wrk_1[]" id="d2" maxlength="10" value="<?= $wrk_1[1] ?>" required>
				<span class="input-group-text">시작~종료시간</span>
				<input class="form-control" type="text" name="wrk_1[]" maxlength="20" value="<?= $wrk_1[2] ?>" required>
			</div>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-sm-2">신청정원</div>
		<div class="col-sm-10">
			<div class="input-group text-start fs-5">
				<span class="input-group-text">선택1</span>
				<input class="form-control" type="text" name="wrk_2[]" maxlength="5" value="<?= $wrk_2[0] ?>" required>
				<span class="input-group-text">선택2</span>
				<input class="form-control" type="text" name="wrk_2[]" maxlength="5" value="<?= $wrk_2[1] ?>" required>
				<span class="input-group-text">1인당</span>
				<input class="form-control" type="text" name="wrk_2[]" maxlength="5" value="<?= $wrk_2[2] ?>" required>
			</div>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-sm-2">선택1 타이틀</div>
		<div class="col-sm-10">
			<div class="input-group text-start fs-5">
				<span class="input-group-text">제목</span>
				<input class="form-control" type="text" name="wrk_3[]" maxlength="30" value="<?= $wrk_3[0] ?>" required>
				<span class="input-group-text">안내</span>
				<input class="form-control" type="text" name="wrk_3[]" maxlength="50" value="<?= $wrk_3[1] ?>" required>
			</div>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-sm-2">선택2 타이틀</div>
		<div class="col-sm-10">
			<div class="input-group text-start fs-5">
				<span class="input-group-text">제목</span>
				<input class="form-control" type="text" name="wrk_3[]" maxlength="30" value="<?= $wrk_3[2] ?>" required>
				<span class="input-group-text">안내</span>
				<input class="form-control" type="text" name="wrk_3[]" maxlength="50" value="<?= $wrk_3[3] ?>" required>
			</div>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-sm-2">운영일정</div>
		<div class="col-sm-10">
			<div class="input-group text-start fs-5">
				<span class="input-group-text">일정</span>
				<input class="form-control" type="text" name="wrk_4[]" maxlength="30" value="<?= $wrk_4[0] ?>" required>
				<span class="input-group-text">대상</span>
				<input class="form-control" type="text" name="wrk_4[]" maxlength="30" value="<?= $wrk_4[1] ?>" required>
				<span class="input-group-text">장소</span>
				<input class="form-control" type="text" name="wrk_4[]" maxlength="30" value="<?= $wrk_4[2] ?>" required>
			</div>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-sm-2">신청유의사항</div>
		<div class="col-sm-10">
			<textarea name="wr_3" rows="2" class="form-control" title="자료입력"><?= $wr_3 ?></textarea>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-sm-2">접수항목</div>
		<div class="col-sm-10">
			<textarea name="wr_9" rows="1" class="form-control" title="신청항목"><?= $wr_9 ?></textarea>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-sm-2">프로그램 설정</div>
		<div class="col-sm-10">
			<textarea name="wr_1" id="wr_1" rows="12" class="form-control" title="프로그램설정"><?= $wr_1 ?></textarea>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col-sm-2">프로그램 안내</div>
		<div class="col-sm-10">
			<div class="wr_content <?= $is_dhtml_editor ? $config['cf_editor'] : ''; ?>">
            <?php if($write_min || $write_max) { ?>
            <!-- 최소/최대 글자 수 사용 시 -->
            <p id="char_count_desc">이 게시판은 최소 <strong><?= $write_min; ?></strong>글자 이상, 최대 <strong><?= $write_max; ?></strong>글자 이하까지 글을 쓰실 수 있습니다.</p>
            <?php } ?>
            <?= $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
            <?php if($write_min || $write_max) { ?>
            <!-- 최소/최대 글자 수 사용 시 -->
            <div id="char_count_wrap"><span id="char_count"></span>글자</div>
            <?php } ?>
        </div>
		</div>
	</div>
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
	<div class="row mb-3">
		<div class="col-sm-2">보안</div>
		<div class="col-sm-10">
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

<div class="container mb-5">
<div class="accordion accordion-flush mt-5 border" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button fs-5 bg-light px-3" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
        ※ 입력 설명서
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
      <div class="accordion-body p-3">

			<p class="text-primary">● 신청기준</p>
			<p>선택무(선택하는 것 없이 신청 받는 경우)<br>
			선택1(여러개 중에 하나 선택할 경우)<br>
			선택1, 2 연동(선택1 선택에 따라 선택2를 선택하게 하는 경우)<br>
			선택1, 2 각각 선택(선택1, 선택2 를 각각 선택할 경우)</p><br>

			<p class="text-primary">● 접수항목(이름, 연락처,성별,요청사항, 비밀번호는 제외 - 기본)</p>
			<p>질문과 응답을 | 로 구분해서 입력</p>
			<p>응답구분자: ^s(단문), ^t(장문), ^r(1개 선택), ^c(다수선택), ^e(기타입력), ^a(주소입력)</p>
			<p>예시: 학교명 ^s | 학년  ^r 1학년  ^r 2학년 ^r 3학년 | 참석자 ^c 학생 ^c 학부모 ^e 기타 | 주소 ^a</p><br>

			<p class="text-primary">● 선택1형인 경우</p>
			<p>항목1|<br>
			항목2|<br>
			항목3|<br>
			항목4<br><br>

			<p class="text-primary">● 선택1, 2연동형인 경우 예시(각 항목에 응답이 모두 같을 경우)</p>
			<p>항목1|<br>
			항목2|<br>
			항목3|<br>
			항목4<br>
			D#<br>
			응답 A^응답 B^응답 C^응답 D^응답 E^응답 F</p><br>

			<p class="text-primary">● 선택1, 2연동형인 경우 예시(응답이 다를 경우, 항목이 4개면 응답도 4개라야 됨)</p>
			<p>항목1|<br>
			항목2|<br>
			항목3|<br>
			항목4<br>
			D#<br>
			응답1 A^응답1 B^응답1 C^응답1 D^응답1 E|<br>
			응답2 A^응답2 B^응답2 C^응답2 D^응답2 E|<br>
			응답3 A^응답3 B^응답3 C^응답3 D^응답3 E|<br>
			응답4 A^응답4 B^응답4 C^응답4 D^응답4 E</p><br>

			<p class="text-primary">● 선택1, 2 각각 선택인 경우(항목 2개 별도 설정)</p>
			<p>A항목1|<br>
			A항목2|<br>
			A항목3|<br>
			A항목4<br>
			D#<br>
			B항목1|<br>
			B항목2|<br>
			B항목3|<br>
			B항목4</p>

	  </div>
    </div>
  </div>
</div>
</div>

<script>
	$(function(){
		$("#d1, #d2").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonpanel: true, yearRange: "c-99:c+99"});
	});
function fwrite_submit(f)
{
	<?= $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

	var subject = "";
	var content = "";
	$.ajax({
		url: g5_bbs_url+"/ajax.filter.php",
		type: "pOST",
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

	<?= $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

	document.getElementById("btn_submit").disabled = "disabled";

	return true;
}

</script>
