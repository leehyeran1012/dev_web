<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($w == "") {
$wr_1 = "
Q# 그누보드를 애용 하시나요?
  ^ 매우그렇다
  ^ 그렇다
  ^ 보통이다
  ^ 아니다
  ^ 매우아니다

Q# 어떤 기능을 자주 사용하시나요?(모두 선택)
  ^c 스킨
  ^c 게시판
  ^c 영카트
  ^c 최신글
  ^c 인기글
  ^e 기타

Q# 다음은 그누보드 개선 관련 질문입니다.[[ 개선이 시급한 기능은?
^s

Q# 추가하면 좋을 기능이 있으면 제안해 주세요. ]] 예) 설명서 보충, 쳇GPT, 설문조사 등
^s

Q#  기타 의견이 있으면 적어 주세요.(#선택)
^t
";

$wr_2 = date("Y-m-d");
$wr_3 = date("Y-m-d");
$wr_4 = "00:00~23:59";
$wr_5 = 0;
$wr_6 = "이름,전화번호,주소";
$wr_7 = 0;
}

if ($w == 'u') {
    $wr_1 = get_text(html_purifier($write['wr_1']), 0);
    $wr_2 = $write['wr_2'];
    $wr_3 = $write['wr_3'];
    $wr_4 = $write['wr_4'];
    $wr_5 = $write['wr_5'];
    $wr_6 = $write['wr_6'];
    $wr_7 = $write['wr_7'];

}

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/custom.css">', 0);
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

?>

<script>
$(document).ready(function(){
  $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>
<div class="container-fluid mb-5">

	<p class="text-end mb-2"><a class="btn btn-outline-secondary btn-sm" href="<?= get_pretty_url($bo_table); ?>">목록으로</a></p>

    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?= $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?= $width; ?>">
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
            $option .= "\n".'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label for="notice">공지</label>';
        }

        if ($is_html) {
            if ($is_dhtml_editor) {
                $option_hidden .= '<input type="hidden" value="html1" name="html">';
            } else {
                $option .= "\n".'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="html">HTML</label>';
            }
        }

        if ($is_secret) {
            if ($is_admin || $is_secret==1) {
                $option .= "\n".'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'."\n".'<label for="secret">비밀글</label>';
            } else {
                $option_hidden .= '<input type="hidden" name="secret" value="secret">';
            }
        }

        if ($is_mail) {
            $option .= "\n".'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'."\n".'<label for="mail">답변메일받기</label>';
        }
    }

    echo $option_hidden;
 ?>

	<div class="row mb-3">
		<div class="col-sm-12 col-xl-1">설문명</div>
		<div class="col-sm-12 col-xl-11">
			<input type="text" name="wr_subject" value="<?= $subject ?>" id="wr_subject" class="form-control required" size="50" maxlength="100" placeholder="설문명" required>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-sm-12 col-xl-1">설문기간</div>
		<div class="col-sm-12 col-xl-11">
			<div class="row">
				  <div class="input-group text-start fs-5" style="width:600px">
					  <input class="form-control text-center" type="text" name="wr_2" id="wr_2" maxlength="10" value="<?= $wr_2 ?>" required>
					  <span class="input-group-text">~</span>
					  <input class="form-control text-center" type="text" name="wr_3" id="wr_3" maxlength="10" value="<?= $wr_3 ?>" required>
					  <span class="input-group-text">시작~종료시간</span>
					  <input class="form-control text-center" type="text" name="wr_4" id="wr_4" maxlength="20" value="<?= $wr_4 ?>" required>
				 </div>
			</div>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-sm-12 col-xl-1">설문안내</div>
		<div class="col-sm-12 col-xl-11">
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
	<div class="row mb-3">
		<div class="col-sm-12 col-xl-1">구분자</div>
		<div class="col-sm-12 col-xl-11">
			<table class="table table-bordered text-center m-0">
				<tr>
					<td><span title="문항구분자" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="문항구분자">Q#</span></td>
					<td><span title="라디오박스" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="라디오박스">^</span></td>
					<td><span title="체크박스" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="체크박스">^c</span></td>
					<td><span title="기타란 텍스트" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="기타란 텍스트">^e</span></td>
					<td><span title="주소" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Daum 주소입력창">^a</span></td>
					<td><span title="전화번호" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="전화번호">^h</span></td>
					<td><span title="별점설문" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="별점설문">^p</span></td>
					<td><span title="텍스트 1줄" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="텍스트 1줄">^s</span></td>
					<td><span title="텍스트 3줄" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="텍스트 3줄">^t</span></td>
					<td><span title="안내문구 넣기" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="안내문구 넣기">[[</span></td>
					<td><span title="예시문구 넣기" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="예시문구 넣기">]]</span></td>
					<td><span title="줄바꿈표시" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="줄바꿈표시">//</span></td>
					<td><span title="선택문항-질문끝에 입력" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="선택문항-질문끝에 입력">(#선택)</span></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-sm-12 col-xl-1">설문내용</div>
		<div class="col-sm-12 col-xl-11">
			<textarea name="wr_1" id="wr_1" rows="20" class="form-control" title="설문내용"><?= $wr_1 ?></textarea>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col-sm-12 col-xl-1">기타설정</div>
		<div class="col-sm-12 col-xl-11">
			<div class="input-group text-start fs-5">
				<span class="input-group-text">주관식시작번호</span>
				<input type="text" name="wr_5" value="<?= $wr_5 ?>" id="wr_5" class="form-control text-center required" maxlength="2" value="<?= $wr_5 ?>" required>
				<span class="input-group-text">표제목</span>
				<input type="text" name="wr_6" value="<?= $wr_6 ?>" id="wr_6" class="form-control text-center required" maxlength="20" value="<?= $wr_6 ?>">
				<span class="input-group-text">신청폼설정(문항번호|정원)</span>
				<input type="text" name="wr_7" value="<?= $wr_7 ?>" id="wr_7" class="form-control text-center required" maxlength="20" value="<?= $wr_7 ?>">

			</div>
			<p class="text-success pt-2">*** 주관식 설문은 표로 출력되고 엑셀로 저장할 수 있음
			<br>*** 모두 주관식이면 1, 문항 뒤에 포함하려면 주관식 시작번호 입력, 필요 없으면 0 입력
			<br>*** 표제목은 주관식 문항수와 같아야 됨( 콤마(,)로 연결 )
			<br>*** 신청폼설정은 정원을 제햔해야 할 경우 사용. 주관식시작번호: 1, 표제목 입력, 신청항목문항번호|정원 입력, 필요없으면 0 입력
			</p>
		</div>
	</div>
	<div class="d-flex justify-content-center my-4">
		<div class="btn-group">
			<input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn btn-primary rounded-0 py-2 px-5 me-3">
			<a href="<?= get_pretty_url($bo_table); ?>" class="btn btn-secondary rounded-0 py-2 px-5">목록으로</a>
		</div>
	</div>
</form>
</div>
<div class="container mb-5">
<div class="accordion accordion-flush mt-5 border" id="accordionFlushExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="flush-headingOne">
      <button class="accordion-button fs-5 bg-light px-3" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
        ※ 설문 입력 설명서
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
      <div class="accordion-body p-0">
			<table class="table text-start">
			  <tbody>
			  <tr>
				<th class="table-light border-top">※ 작성예시1</th>
			  </tr>
			  <tr>
				<td class="ps-3">
					▶ ^ 구분자는 한개 선택형(radio)<br>
					Q# 그누보드를 애용 하십니까?<br>
					  ^ 매우그렇다<br>
					  ^ 그렇다<br>
					  ^ 보통이다<br>
					  ^ 아니다<br>
					  ^ 매우아니다<br><br>

					▶ ^c 구분자는 2개 이상 선택형(checkbox)<br>
					Q# 어떤 기능이 가장 마음에 드십니까?(모두 선택)<br>
					  ^c 스킨<br>
					  ^c 게시판<br>
					  ^c 영카트<br>
					  ^c 최신글<br>
					  ^c 인기글<br>
					  ^e 기타<br><br>

					▶ ^p 항목별 별점 평가 설문형 <br>
					Q# 어떤 기능이 가장 마음에 드십니까?(모두 선택)<br>
					  ^p 국어<br>
					  ^p 수학<br>
					  ^p 영어<br>
					  ^p 사회<br>
					  ^p 과학<br><br>

					▶ ^s 구분자는 주관식 1줄형(text)<br>
					▶ [[ 구분자는 [[ 앞 부분이 별도 칸으로 분리되어 나오고 뒷 부분이 질문 문항이 됩니다.<br><br>

					Q# 다음은 그누보드 개선 관련 질문입니다. [[ 개선이 시급한 기능은?<br>
					^s<br><br>

					▶ ^a 구분자는 Daum 주소입력 스크립트<br>
					Q# 주소는? <br>
					^a<br><br>

					▶ ^h 구분자는 전화번호 입력<br>
					Q# 전화번호는? <br>
					^h<br><br>

					▶ ]] 구분자는 ]] 앞부분이 질문이고 뒷 부분이 질문 밑에 별도 칸으로 분리되어 보입니다.<br>

					Q# 추가하면 좋을 기능이 있으면 제안해 주세요. ]] 예) 설명서 보충, 쳇GPT, 설문조사 등<br>
					^s<br><br>

					▶ ^t 구분자는 주관식 3줄형(textarea)<br>

					Q# 기타 의견이 있으면 적어 주세요.(#선택)  선택형은 질문 끝에 (#선택) 입력<br>
					^t<br><br>

					<span class="text-danger">***구분자 다음에는 한 칸 띄우고 내용을 입력하세요. 줄바꿈 하려면 줄바꿈 할 위치에 // 를 추가해주세요.<br>***주관식 입력란에 기본값을 넣어 주려면 한칸 띄우고 기본값을 입력하세요.(예) ^s 내용, ^t 내용)</span>
				</td>
			  </tr>
			  <tr>
				<th class="table-light">※  작성예시2 (모두 주관식인 경우)</th>
			  </tr>
			  <tr>
				<td class="ps-3">
					Q# 이름을 입력해 주세요.<br>
					^s<br><br>

					Q# 전화번호를 입력해 주세요.<br>
					^h<br><br>

					Q# 주소를 입력해 주세요.<br>
					^a<br><br>

					Q# 소감문을 적어 주세요. ]] 이번 행사에 참여하여~~~~함.<br>
					^t 이번 행사에 참여하여 ~~~함.	<br><br>
					<span class="text-danger">**주관식 입력란에 기본값을 넣어 주려면 한칸 띄우고 기본값을 입력하세요.(예) ^s 내용, ^t 내용)</span>
				</td>
			  </tr>
			</tbody>
			</table>
	  </div>
    </div>
  </div>
</div>
</div>
<script>
$(function(){
    $("#wr_2, #wr_3").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99"});
});

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

<!-- } 게시물 작성/수정 끝 -->