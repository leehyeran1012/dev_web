<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_LIB_PATH.'/lunarcalendar.php');
$holiday = new Lunarcalendar();

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
include_once(G5_PLUGIN_PATH.'/jquery-ui/datepicker.php');

$day = 1;
$yymon = html_purifier($_GET["ym"]);
$date = $yymon."-01";
$wr_id = isset($_GET["wr_id"]) ? intval($_GET["wr_id"]) : 0;

$time = strtotime($date);
$start_week = date('w', $time); // 시작 요일
$total_day = date('t', $time); // 현재 달의 총 날짜
$total_week = ceil(($total_day + $start_week) / 7);  // 달의 총 주수

$result2 = sql_fetch("select wr_id,wr_1,wr_2,wr_3,wr_4,wr_5,wr_6,wr_7,wr_8,wr_9,wr_10 from {$write_table} where wr_id = {$wr_id}");
$times = explode("|",$result2["wr_3"]);
if($result2) {
	$stimes = explode("|",$result2["wr_2"]);
} else {
	$stimes = [];
}

?>
<style type="text/css">
	.ui-datepicker{z-index: 10000 !important};
</style>
<div class="container-fluid mb-5">

	<div class="row mb-2">
		<div class="col-md-5">
				<p class="text-success"><?php if($result2["wr_3"] != "") { ?>※ 예약 제외 항목에 체크후 저장하세요.<?php } else { ?>※ 예약 항목을 먼저 등록하세요.<?php } ?></p>
		</div>
		<div class="col-md-3">
				<p class="text-center fs-5 fw-bold"><?=$yymon?></p>
		</div>
		<div class="col-md-4 text-end">
			<?php if(!$result2) { ?>
			<a href='#' class='btn btn-outline-primary btn-sm' onclick="add_form('<?=$yymon?>')">예약설정등록</a>
			<?php } else { ?>
			<a href='#' class='btn btn-outline-danger btn-sm' onclick="edit_form('<?=$result2["wr_id"]?>')">예약설정관리</a>
			<?php } ?>
		</div>
	</div>

    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?= $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" autocomplete="off" style="width:<?= $width; ?>">
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
    <input type="hidden" name="wr_subject" value="<?= $result2["wr_1"] ?> 예약설정">
    <input type="hidden" name="wr_content" value="<?= $result2["wr_1"] ?> 예약설정">
    <input type="hidden" name="wr_1" value="<?= $result2["wr_1"] ?>">
    <input type="hidden" name="wr_3" value="<?= $result2["wr_3"] ?>">
    <input type="hidden" name="wr_4" value="<?= $result2["wr_4"] ?>">
    <input type="hidden" name="wr_5" value="<?= $result2["wr_5"] ?>">
    <input type="hidden" name="wr_6" value="<?= $result2["wr_6"] ?>">
    <input type="hidden" name="wr_7" value="<?= $result2["wr_7"] ?>">
    <input type="hidden" name="wr_8" value="<?= $result2["wr_8"] ?>">

	<?php
    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) {
        $option = '';
        if ($is_notice) {
            $option .= "\n".'<input type="checkbox" class="form-check-input" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label for="notice">공지</label>';
        }

        if ($is_html) {
            if ($is_dhtml_editor) {
                $option_hidden .= '<input type="hidden" value="html1" name="html">';
            } else {
                $option .= "\n".'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="html">html</label>';
            }
        }

    }

    echo $option_hidden;

 if($wr_id > 0) { ?>
<div class="table-responsive-sm">
	<table class="table table-bordered" style="min-width:800px">
      <thead class="table-light text-center">
        <tr>
            <th width='14.3%' class="text-danger">일</th>
            <th width='14.3%'>월</th>
            <th width='14.3%'>화</th>
            <th width='14.3%'>수</th>
            <th width='14.3%'>목</th>
            <th width='14.3%'>금</th>
            <th width='14.3%' class="text-primary">토</th>
        </tr>
     </thead>
     <tbody>

	<?php for ($i = 0; $i < $total_week; $i++) { ?>
	<tr>
	<?php for ($k = 0; $k < 7; $k++) { ?>
		<td height="150">
		<?php if ( ($day > 1 || $k >= $start_week) && $total_day >= $day ) {

				if($k == 0) {
					$wcolor = " text-danger";
				} elseif($k == 6) {
					$wcolor = " text-primary";
				} else {
					$wcolor = "";
				}
				$mday = sprintf('%02d', $day);
				$c_date = $yymon."-".$mday;
				//휴일
				$holiday_name = $holiday->getHolidayname($c_date);
				if ($holiday_name) {
					$wcolor = " text-danger";
					$holiday_name = "<span class='text-danger small me-2'> ".$holiday_name."</span>";
				} else {
					$holiday_name = "";
				}
				$weekday = $holiday->getWeekname($c_date);
			?>
				<div class="mb-2 text-start<?=$wcolor?>"><?= $day++; ?> <?=$holiday_name ?></div>
			<?php foreach($times as $key=>$value) {

				$result = sql_fetch("select count(*) cc from {$write_table}_result where wr_1 = '{$c_date}' and wr_2 = '{$value}'");
				if($result["cc"] > 0) {
					$aok = " disabled";
					$msg = "<span class='text-danger'> (".$result["cc"].")</span>";
				} else {
					$aok = "";
					$msg = "";
				}

				if(in_array( $c_date.$value, $stimes)) {
					$checked = " checked".$aok;
				} else {
					$checked = "".$aok;
				}
			?>
				<input class="form-check-input" type="checkbox" name="cont[]" value="<?= $c_date ?><?= $value ?>"<?= $checked ?>><span class="me-3"> <?=$value?><?=$msg?></span><br>
			<?php  } } ?>
		</td>
	<?php } ?>
	</tr>
<?php } ?>
    </tbody>
</table>
</div>
	<?php if ($is_use_captcha) { ?>
	<div class="row mb-2">
		<label class="col-sm-1 col-form-label">보안</label>
		<div class="col-sm-11">
			<?= $captcha_html ?>
		</div>
	</div>
	<?php }  ?>

	<div class="container text-center my-4">
			<input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn btn-primary rounded-0 py-3 px-5">
	</div>
<?php }  ?>
	</form>
</div>

<!-- Modal -->

<div class="modal fade" id="eventModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true" data-bs-focus="false">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
	<form action="#" name="eventform" id="eventform">
		<input type="hidden" name="bo_table" value="<?=$bo_table?>">
		<input type="hidden" name="id" id="eventId">
		<input type="hidden" name="wr_1" id="wr_1" value="<?=$yymon?>">
		<input type="hidden" name="wr_name" id="wr_name" value="관리자">
		<input type="hidden" name="wr_subject" id="wr_subject" value="<?=$yymon?> 예약설정">
		<input type="hidden" name="wr_content" id="wr_content" value="<?=$yymon?> 예약설정">

	  <div class="modal-header bg-light py-2">
        <span class="modal-title" id="eventModalLabel"><i class="bi bi-gear-fill me-2"></i>접수항목설정</span>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-3 px-2">
		<div class="container">
			<div class="row">

				<div class="col-12 mb-2">
				<?php if($wr_3 =="") $wr_3 = "항목1|항목2|항목3"; ?>
					<p>신청항목( 신청받을 항목을 | 로 연결해서 입력 )</p>
					<textarea class="form-control text-primary" name="wr_3" id="wr_3" rows="1" title="접수항목" required><?=$wr_3?></textarea>
				</div>
				<div class="col-sm-12 mb-2">
					<?php if($wr_5 == "") $wr_5 = $date; ?>
					<?php if($wr_6 == "") $wr_6 = $date; ?>
					  <p>접수기간</p>
					  <div class="input-group text-start">
						<input class="form-control text-primary" type="text" name="wr_5" id="wr_5" maxlength="10" value="<?= $wr_5 ?>" title="시작일자" required>
						<span class="input-group-text">~</span>
						<input class="form-control text-primary" type="text" name="wr_6" id="wr_6" maxlength="10" value="<?= $wr_6 ?>" title="종료일자" required>
					</div>
				</div>
				<div class="col-sm-12 mb-2">
					<?php if($wr_7 == "") $wr_7 = "00:00~23:59"; ?>
					<?php if($wr_8 == "") $wr_8 = 1; ?>
					<p>접수시작~종료시간</p>
					<input class="form-control text-primary" type="text" name="wr_7" id="wr_7" maxlength="13" value="<?= $wr_7 ?>" title="시작-종료시간" required>
				</div>
				<div class="col-sm-12 mb-2">
					<?php if($wr_8 == "") $wr_8 = 1; ?>
					<p>신청항목당 정원</p>
					<input type="text" class="form-control text-primary" name="wr_8" id="wr_8" value="<?=$wr_8?>" title="숫자만 입력" required>
				</div>
				<div class="col-sm-12 mb-2">
					<?php if($wr_9 == "") $wr_9 = 1; ?>
					<p>예약불가능 일수(0은 당일, 1은 다음날부터 신청 가능 ~~)</p>
					<input class="form-control text-primary" type="text" name="wr_9" id="wr_9" maxlength="3" value="<?= $wr_9 ?>" title="숫자만 입력" required>
				</div>

				<div class="col-12 mb-2">
					<?php if($wr_4 =="") $wr_4 = "예악자성명 ^s| 연락처 ^h| 성별 ^r 남 ^r 여| 예약인원 ^s| 주소 ^a"; ?>
					<p>추가접수 항목</p>
					<textarea class="form-control text-primary" name="wr_4" id="wr_4" rows="2" title="접수항목" required><?=$wr_4?></textarea>
				</div>

				<div class="accordion accordion-flush" id="acd1">
				  <div class="accordion-item border">
					<h2 class="accordion-header">
					  <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#acd2" aria-expanded="false" aria-controls="acd2">추가접수항목 설명</button>
					</h2>
					<div id="acd2" class="accordion-collapse collapse" data-bs-parent="#acd1">
					  <div class="accordion-body">
							<p class="text-primary mb-1 small">
							※ 성명, 전화번호, 성별, 비밀번호, 요청사항은 입력 제외(기본)
							<br>※ 접수받을 항목과 구분자를 | 로 구분해서 입력.(끝에는 안붙임)
							<br>※ 입력구분자: ^s(단문), ^t(장문), ^r(한개선택), ^c(복수선택), ^e(기타), ^h(휴대전화번호), ^a(주소)
							<br>※ 추가항목이 없으면 공란으로 둠
							<br>※ 예약불가능 일수 항목은 오늘기준 예약 불가능 일수를 설정(0은 당일신청가능, 1은 다음날부터 신청가능, 2는 그다음날부터 신청가능 ~~ )
							</p>
					  </div>
					</div>
				  </div>

				</div>

			</div>
		</div>
	  </div>
      <div class="modal-footer bg-light py-1" id="eventBtn">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
		<button type="button" class="btn btn-primary" id="btnSave" onclick="save()">등록</button>
	  </div>
	</form>
    </div>
  </div>
</div>


 <script>
	$(function(){
		$("#wr_5, #wr_6").datepicker({ changeMonth: true, changeYear: true, dateFormat: "yy-mm-dd", showButtonPanel: true, yearRange: "c-99:c+99"});
	});
	var save_method;
	var site_url ="<?= $board_skin_url ?>";

    function fwrite_submit(f)
    {
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

         <?= $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }


	function add_form(date) {
		save_method = "add";
		var link = '<button type="button" class="btn btn-primary" id="btnSave" onclick="save()">등록</button>';
		$("#eventform")[0].reset();
		$("#eventModal").modal("show");
	}

	function save() {

		var formdata = new FormData(document.querySelector('#eventform'));

		$.ajax({
			url : site_url+"/ajax_save.php",
			type: "POST",
			data: formdata,
			processData: false,
			contentType: false,
			success: function(data) {
				$("#modal_form").modal("hide");
				alert("등록되었습니다.");
				location.reload();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert("데이터 처리중 에러가 발생했습니다.");
			}
		});
	}

	function edit_form(id) {

		$.ajax({
			url : site_url+"/ajax_edit.php",
			type: "post",
			data: {
				id: id,
				bo_table: '<?=$bo_table?>',
			},
			dataType: "JSON",
			success: function(data) {
				$("#eventId").val(data.wr_id);
				$("#wr_3").val(data.wr_3);
				$("#wr_4").val(data.wr_4);
				$("#wr_5").val(data.wr_5);
				$("#wr_6").val(data.wr_6);
				$("#wr_7").val(data.wr_7);
				$("#eventModal").modal("show");
				$("#btnSave").text("수정");
			},
				error: function (jqXHR, textStatus, errorThrown)
			{
				console.log(jqXHR);
				alert("데이터 처리중 에러가 발생했습니다.");
			}
		});
	}

  </script>


<!-- } 게시물 작성/수정 끝 -->