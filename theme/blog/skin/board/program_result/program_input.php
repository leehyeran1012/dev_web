	<div class="col-sm-12 col-md-12 shadow p-4 mb-3 rounded mx-auto">
		<p class="fs-5 fw-bold mb-1"><i class="bi bi-patch-check-fill me-2"></i> 신청자성명 <span class="text-danger">*</span></p>
		<div class="col-sm-12 px-md-3 py-2 lh-base px-sm-0">
			<input type="text" name="wr_name" value="<?= $name ?>" id="wr_name" class="form-control form-control-lg text-primary rounded-0 fs-6" required placeholder="신청자 성명">
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
	$svtitles2 = str_replace("\r\n","",$que1['wr_9']);

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
			<input type="text" name="mtext_<?=$xx?>" id="mtext_<?=$xx?>" value="<?=$gt?>" disabled  class="form-check-input ms-2" title="기타내용" style="width:250px;height:30px;" title="기타내용" onchange='getGitacheck(<?=$xx?>)'></p>

	<?php } elseif (substr($value2,0,1) == "h") {  ?>

		<p class="my-1"><input type="text" name="wr_<?= $xx ?>" value="<?= ${"wr_".$xx} ?>" id="wr_<?= $xx ?>" placeholder="<?=$sub_title2?>" class="form-control form-control-lg text-primary rounded-0 fs-6 tel" required  title="전화번호입력" onchange="check_phone('wr_<?=$xx?>')"></p>

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
				<div class="col-sm-12 col-xl-5 mb-2 px-md-3 px-sm-0"><input type="text" class="form-control form-control-lg text-primary rounded-0 fs-6" id="juso1" value="<?=$addrs[1]?>" placeholder="주소"></div>
				<div class="col-sm-12 col-xl-3 mb-2 px-md-3 px-sm-0"><input type="text" class="form-control form-control-lg text-primary rounded-0 fs-6" id="juso2" value="<?=$addrs[2]?>" placeholder="나머지 주소" onblur="jusointput()"></div>
				<div class="col-sm-12 col-xl-4 mb-2 px-md-3 px-sm-0"><input type="text" class="form-control form-control-lg text-primary rounded-0 fs-6" id="juso3" value="<?=$addrs[3]?>" placeholder="참고항목"></div>
			</div>

			<input type="hidden" id="wr_addr2" name="wr_<?=$xx?>" value="<?=$addrs1?>">
			<input type="hidden" id="wr_addr" name="wr_kx"  value="">
			<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

	<?php } else { ?>

		<p class="my-1"><input type="text" name="wr_<?= $xx ?>" value="<?= ${"wr_".$xx} ?>" id="wr_<?= $xx ?>" placeholder="<?=$sub_title2?>" class="form-control form-control-lg text-primary rounded-0 fs-6" required title="내용입력"></p>

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
			<textarea name="wr_content" rows="3" class="form-control form-control-lg text-primary rounded-0 fs-6" required><?=$content?></textarea>
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