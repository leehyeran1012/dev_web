<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('lunarcalendar.php');
include_once('opentime.php');

add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/custom.css">', 0);

$holiday = new Lunarcalendar();
$to_day = date("Y-m-d");

$cdate = !empty($_GET["gomonth"]) ? html_purifier($_GET["gomonth"]) : date("Y-m");
$bot_table = str_replace("_result","",$write_table);

$ttime = sql_fetch("select wr_id,wr_2,wr_3,wr_4,wr_5,wr_6,wr_7,wr_8,wr_9 from {$bot_table} where wr_1 = '{$cdate}'");
$octimes =  explode("~", $ttime['wr_7']);		//오픈시간
$openp = open_confirm($ttime['wr_5'],$ttime['wr_6'],$ttime['wr_7']);

?>
<script>
	window.history.forward();
</script>
<script>
	$(document).on("keyup", ".tel", function() {		//휴대전화 자동 하이픈(-) 입력
		$(this).val($(this).val().replace(/[^0-9]/g, '').replace(/(^02|^0505|^1[0-9]{3}|^0[0-9]{2})([0-9]+)?([0-9]{4})$/,'$1-$2-$3').replace('--', '-'));
	});
</script>
<script src='<?=$board_skin_url?>/reserve.js'></script>

<div class="container p-0">

	<div class="d-flex border-bottom my-3">
	  <div class="fs-4 fw-bold flex-grow-1"><?= $board['bo_subject'] ?></div>
	  <div><a href="./board.php?bo_table=<?=$bo_table?>" class="btn btn-danger btn-sm">예약확인</a></div>
	</div>

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
    <input type="hidden" name="wr_subject" value="예약신청">
    <input type="hidden" name="wr_num" value="<?=$ttime['wr_id']?>">

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

	<div class="container mt-5 pt-3">
		<div class="row p-0 mb-5">
			<div class="col-sm-12 col-md-6 p-0 pe-3" id="calendar">
				<?php include_once("calendar.php"); ?>
			</div>
			<div class="col-sm-12 col-md-6 fs-5 ps-3 pt-2">
				<div class="border-bottom pb-2 fs-4 fw-bold mb-3"><i class="bi bi-front text-success me-2"></i>예약 항목 선택</div>
				<div id="ctime" style="height:224px">
					<p class="fs-6 text-danger">
						예약할 일자 선택후 예약 항목을 선택해 주세요.
						<input type="hidden" name="wr_1" value="<?= $wr_1 ?>"><input type="hidden" name="wr_2" value="<?= $wr_2 ?>">
					</p>
					<?php if($wr_1 <> "") { ?>
						<h4 class="mt-5 form-control-lg text-primary rounded-0 fs-6">예약 내역 :</h4>
						<h4 class="mt-3 form-control-lg text-primary rounded-0 fs-6"><?= $holiday->getWeekname2($wr_1) ?> &nbsp;<?= $wr_2 ?></h4>
					<?php } ?>
				</div>
				 <p class="fs-6 text-success">
					 * 예약신청기간 : &nbsp;<?= date("n. j", strtotime($ttime['wr_5'])) ?>(<?= $holiday->getWeekname($ttime['wr_5']) ?>) <?=$octimes[0]?> ~ <?= date("n. j", strtotime($ttime['wr_6'])) ?>(<?= $holiday->getWeekname($ttime['wr_6']) ?>)
				 </p>
				 <p class="fs-6 text-danger">
					 * 신청하신 후 사무실(000-000-0000)로 연락주세요.
				 </p>
			</div>
		</div>
	</div>

	<div class="col-sm-12 col-md-12 shadow p-4 mb-3 rounded mx-auto">
		<p class="fs-5 fw-bold mb-1"><i class="bi bi-patch-check-fill me-2"></i> 예약자성명 <span class="text-danger">*</span></p>
		<div class="col-sm-12 px-md-3 py-2 lh-base px-sm-0">
			<input type="text" name="wr_name" value="<?= $name ?>" id="wr_name" class="form-control form-control-lg text-primary rounded-0 fs-6 rounded-0 fs-6" required placeholder="성명">
		</div>
	</div>

	<div class="col-sm-12 col-md-12 shadow p-4 mb-3 rounded mx-auto">
		<p class="fs-5 fw-bold mb-1"><i class="bi bi-patch-check-fill me-2"></i> 연락처 <span class="text-danger">*</span></p>
		<div class="col-sm-12 px-md-3 py-2 lh-base px-sm-0">
			<input type="text" name="wr_3" id="wr_3" value="<?= $wr_3 ?>" placeholder="연락처" class="form-control form-control-lg text-primary rounded-0 fs-6 tel" required title="전화번호입력" onchange="check_phone('wr_3')">
		</div>
	</div>

	<div class="col-sm-12 col-md-12 shadow p-4 mb-3 rounded mx-auto">
		<p class="fs-5 fw-bold mb-1"><i class="bi bi-patch-check-fill me-2"></i>  성별 <span class="text-danger">*</span></p>
		<div class="col-sm-12 px-md-3 py-2 lh-base px-sm-0">
			<p class="my-1"><input type="radio" name="wr_4" class="form-check-input me-2" value="남" required title="남"<?= ($wr_4 == "남") ? " checked" : ""; ?>>남</p>
			<p class="my-1"><input type="radio" name="wr_4" class="form-check-input me-2" value="여" required title="여"<?= ($wr_4 == "여") ? " checked" : ""; ?>>여</p>
		</div>
	</div>

<?php
$svtitles = [];
$svtitles2 = str_replace("\r\n","",$ttime['wr_4']);

if(strlen($svtitles2) > 3)  $svtitles = explode("|",$svtitles2);


if(count($svtitles) > 0) {

	$xx = 5;	//추가항목 시작번호 - 1

	foreach($svtitles as $key=>$value) {

		$cm = 0;
		$item_array = explode("^",$value);
		$sub_title = $item_array[0];
		$sub_title2 = trim($sub_title);

		$sub_title = $sub_title."<span class='text-danger'>*</span>";

		if (strpos($value, "^c") !== false ) $tc = $tc.",".$xx;

 ?>
	<div class="col-sm-12 col-md-12 shadow p-4 mb-3 rounded mx-auto">
		<p class="fs-5 fw-bold mb-1"><i class="bi bi-patch-check-fill me-2"></i> <?=$sub_title?></p>
		<div class="col-sm-12 px-md-3 py-2 lh-base px-sm-0">
<?php
		foreach($item_array as $key2=>$value2)  {

		if($key2 > 0) {

		$svalue = trim(substr($value2,1));

		if (substr($value2,0,1) == "r") { ?>

		<p class="my-1"><input type="radio" name="wr_<?= $xx ?>" class="form-check-input me-2" value="<?= $svalue ?>" required title="<?= $key2 ?>"<?= (${"wr_".$xx} == $svalue) ? " checked" : ""; ?>><?= $svalue ?></p>

	<?php } elseif (substr($value2,0,1) == "c") {
		$chks1 = ${"wr_".$xx};
		$chks = [];
		if($chks1) $chks = explode("|", $chks1);
		$cm++;
?>
<?php if($cm == 1) { ?>
		<input type="hidden" id="wr_val<?=$xx?>" name="wr_<?=$xx?>" value="<?= $chks1 ?>">
<?php } ?>

		<p class="my-1"><input type="checkbox" name="wrd<?= $xx ?>" id="wrd<?= $xx ?>_<?=$key2 ?>" class="form-check-input me-2" value="<?= $svalue ?>" onclick='getGitacheck(<?=$xx?>)' title="<?= $svalue ?>"<?= in_array($svalue, $chks) ? " checked" : ""; ?>><?= $svalue ?></p>
		<?php } elseif (substr($value2,0,1) == "e") {
				//기타란
				if(mb_strpos($chks1, '타')) {
					$gc = 1;
					$gt = end($chks);
				} else {
					$gc = 0;
					$gt = "";
				}
			?>
			<p class="my-1"><input type="checkbox" name="wrd<?= $xx ?>" id="wrd<?= $xx ?>_<?=$key2 ?>" class="form-check-input me-2" value="기타:" onclick='toggleGitabox(<?=$xx?>,<?=$key2?>)' title="기타 선택"<?= ($gc == 1) ? " checked" : "" ?>> 기타
			<input type="text" name="mtext_<?=$xx?>" id="mtext_<?=$xx?>" value="<?=$gt?>" disabled class="form-check-input ms-2" title="기타내용" style="width:350px;height:30px;" onchange='getGitacheck(<?=$xx?>)'></p>

	<?php } elseif (substr($value2,0,1) == "h") {  ?>

		<p class="my-1"><input type="text" name="wr_<?= $xx ?>" value="<?= ${"wr_".$xx} ?>" id="wr_<?= $xx ?>" placeholder="<?=$sub_title2?>" class="form-control form-control-lg text-primary rounded-0 fs-6 tel" required  title="전화번호" onchange="check_phone('wr_<?=$xx?>')"></p>

	<?php } elseif (substr($value2,0,1) == "t") {  ?>

		<p class="my-1"><textarea name="wr_<?= $xx ?>" class="form-control" rows="5" required><?= ${"wr_".$xx} ?></textarea></p>

	<?php } elseif (substr($value2,0,1) == "a") {
		$addrs1 = ${"wr_".$xx};
		$addrs = [];
		if($addrs1) $addrs = explode("|", $addrs1);
	?>
			<div class="input-group mb-2 px-md-1 px-sm-0" style="width:200px">
			  <input type="text" class="form-control form-control-lg text-primary rounded-0 fs-6" id="wr_postcode" value="<?=$addrs[0]?>" placeholder="우편번호" aria-label="우편번호" aria-describedby="button-addon2" required>
			  <button class="btn btn-purple rounded-0" type="button" id="button-addon2" onclick="juso_execDaumPostcode()">찾기</button>
			</div>
			<div class="row">
				<div class="col-sm-12 col-xl-5 mb-2 px-md-3 px-sm-0"><input type="text" class="form-control form-control-lg text-primary rounded-0 fs-6 rounded-0 fs-6" id="juso1" value="<?=$addrs[1]?>" placeholder="주소"></div>
				<div class="col-sm-12 col-xl-3 mb-2 px-md-3 px-sm-0"><input type="text" class="form-control form-control-lg text-primary rounded-0 fs-6 rounded-0 fs-6" id="juso2" value="<?=$addrs[2]?>" placeholder="나머지 주소" onblur="jusointput()"></div>
				<div class="col-sm-12 col-xl-4 mb-2 px-md-3 px-sm-0"><input type="text" class="form-control form-control-lg text-primary rounded-0 fs-6 rounded-0 fs-6" id="juso3" value="<?=$addrs[3]?>" placeholder="참고항목"></div>
			</div>

			<input type="hidden" id="wr_addr2" name="wr_<?=$xx?>" value="<?=$addrs1?>">
			<input type="hidden" id="wr_addr" name="wr_kx"  value="">
			<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

	<?php } else { ?>

		<p class="my-1"><input type="text" name="wr_<?= $xx ?>" value="<?= ${"wr_".$xx} ?>" id="wr_<?= $xx ?>" placeholder="<?=$sub_title2?>" class="form-control form-control-lg text-primary rounded-0 fs-6 rounded-0 fs-6" required title="내용입력"></p>

	<?php  } } } ?>
		</div>
	</div>
<?php
		$xx++;
		}
	}
?>
	<div class="col-sm-12 col-md-12 shadow p-4 mb-3 rounded mx-auto">
		<p class="fs-5 fw-bold mb-1"><i class="bi bi-patch-check-fill me-2"></i> 요청사항 <span class="text-danger">*</span></p>
		<div class="col-sm-12 px-md-3 py-2 lh-base px-sm-0">
			<?php if($content == "") $content = "요청사항이 있으면 적어주세요."; ?>
			<textarea name="wr_content" rows="3" class="form-control form-control-lg text-primary rounded-0 fs-6 rounded-0 fs-6" required><?=$content?></textarea>
		</div>
	</div>
	<div class="col-sm-12 col-md-12 shadow p-4 mb-3 rounded mx-auto">
		<p class="fs-5 fw-bold mb-1"><i class="bi bi-patch-check-fill me-2"></i> 비밀번호 <span class="text-danger">*</span></p>
		<div class="col-sm-12 px-md-3 py-2 lh-base px-sm-0">
			<div class="input-group mb-3">
			  <span class="input-group-text rounded-0" id="pw" title="글자 보이기/숨기기 토글"><i class='bi bi-eye-slash-fill fs-5'></i></span>
			  <input type="password" name="wr_password" id="wr_password" class="form-control form-control-lg text-primary rounded-0 fs-6 required" placeholder="비밀번호-신청확인시 필요" required aria-label="비밀번호" aria-describedby="pw">
			</div>
		</div>
	</div>

<?php if ($is_use_captcha) {  ?>
	<div class="col-sm-12 col-md-12 shadow p-4 mb-3 rounded mx-auto">
		<p class="fs-5 fw-bold mb-1"><i class="bi bi-patch-check-fill me-2"></i> 자동등록방지 <span class="text-danger">*</span></p>
		<div class="col-sm-12 px-md-3 py-2 lh-base px-sm-0">
			<?= $captcha_html ?>
		</div>
	</div>
<?php } ?>

	<div class="d-flex justify-content-center my-5">
	<?php if($openp == 0) { ?>
		<input type="hidden" name="tcnum" id="tcnum" value="<?=$tc?>">
		<input type="submit" value="예약저장" id="btn_submit" accesskey="s" class="btn btn-primary px-5 py-2 rounded-0">
	<?php } ?>
	</div>

	</form>

<script>

    function fwrite_submit(f)
    {

		var wr_2 = f.wr_2.value;

		if(wr_2 === "") {
            alert("예약항목을 선택해 주세요.");
            return false;
		}

		var tstr = $("#tcnum").val();
		var arr = tstr.split(",");
		for(var i=1;i<arr.length;i++) {
			if ($("#wr_val" + arr[i]).val() == "") {
				alert(arr[i]+"번 문항을 입력해 주세요.");
				$("#wrd" + arr[i] + "_1").focus();
				return false;
			}
		}

        <?= $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }

	function optionChange(id) {
		$.ajax({
			url: '<?=$board_skin_url?>/ajax_data.php',
			type: 'POST',
			data: {
				"c_date": id,
				"bo_table": '<?=$bo_table?>',
			},
			async : false,
			dataType : 'html',
			success: function(data){
				$('.btn-blue').removeClass('btn-blue');
				$('#ctime').html(data);
				$('#'+id).addClass('btn-blue');
			},
		});
	}


    $('#pw').on('click',function(){
        $('#wr_password').toggleClass('active');
        if($('#wr_password').hasClass('active')){
            $(this).html('<i class="bi bi-eye-slash-fill fs-5"></i>')
			.next('#wr_password').attr('type',"text");
        }else{
            $(this).html('<i class="bi bi-eye-fill fs-5"></i>')
			.next('#wr_password').attr('type','password');
        }
    });
</script>

</div>
<!-- } 게시물 작성/수정 끝 -->