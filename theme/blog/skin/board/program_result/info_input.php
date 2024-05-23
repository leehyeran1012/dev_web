	<div class="row mb-3">
		<div class="col-sm-2">성명 <span class='text-danger'>*</span></div>
		<div class="col-sm-10">
			<input type="text" name="wr_name" value="<?= $name ?>" id="wr_name" class="form-control required text-primary" required placeholder="신청자 성명">
		</div>
	</div>
<?php
	$xx = 2;
	$tc = $tel = $mailok = 0;

	$subtitles = str_replace("\r\n","",$que1["wr_9"]);
	$subtitles = explode("Q#",$subtitles);

	foreach($subtitles as $key=>$value) {

		$item_array = explode("^",$value);

		$sub_title = str_replace("//","<br><br>",$item_array[0]);

		if (mb_strpos($sub_title, "#선택") !== false ) {
			$selok = 0;
			$sub_title = str_replace("(#선택)","<span class='text-danger'> (선택)</span>",$sub_title);
		} else {
			$selok = 1;	//필수항목
			$sub_title = $sub_title."<span class='text-danger'>*</span>";
		}

		if($key > 0) {

		$xx++;

		if (mb_strpos($sub_title, "전화") !== false || mb_strpos($sub_title, "연락") !== false) $tel = $xx;

		if (strpos($value, "^c") !== false ) $tc = $tc.",".$xx;
?>

	<div class="row mb-3">
		<div class="col-sm-2"><?=$sub_title?></div>
		<div class="col-sm-10">

	<?php
	foreach($item_array as $key2=>$value2)  {

	if($key2 > 0) {

		$k_value = ${"wr_".$xx};

		if (substr($value2,0,1) == "c") { ?>
			<input type="checkbox" name="wrd_<?= $xx ?>" id="pa<?= $xx ?>_<?=$key2 ?>" class="form-check-input me-1" value="<?= trim(str_replace("c","",$value2)) ?>" onclick='getCheck<?=$xx?>(<?=$xx?>)' <?php if(strpos("rr".$k_value, trim(str_replace("c","",$value2))))  echo " checked"; ?>><span class="me-3"><?= str_replace("c","",trim($value2)) ?></span>
		<?php } elseif (substr($value2,0,1) == "e") {

				if(strpos("rr".$k_value, "기타")) {
					$gita = str_replace("기타: ","",end(explode("|", $k_value)));
				} else {
					$gita = "";
				}
		?>
			<input type="checkbox" name="wrd_<?=$xx?>" id="pa<?= $xx ?>_<?=$key2 ?>" class="form-check-input me-1" value="기타:" onclick='toggleTextbox<?=$xx?>(this)' <?php if(strpos("rr".$k_value, "기타"))  echo " checked"; ?>> 기타 <input type="text" name="mtext_<?=$xx?>" id="mtext_<?=$xx?>" value="<?=$gita?>" <?php if($gita == "") echo "disabled"; ?> class="form-check-input ms-1" title="내용입력" style="width:350px;height:30px;" onchange='getCheck<?=$xx?>(<?=$xx?>)'>
			<input type="hidden" id="wrk_<?=$xx?>" name="wr_<?=$xx?>" value="<?=$k_value?>">
			<script>
			  function getCheck<?=$xx?>(id)  {
				var checkBoxArr = [];
				var result = "";
				var wrk = "wrk_"+id;
				var mtext = "mtext_"+id;
				$("input[name=wrd_"+id+"]:checked").each(function(i){
					checkBoxArr.push($(this).val());
				});

				result = checkBoxArr.join("|");
				if(result.indexOf('타') > 0) {
				result = result + " " + document.getElementById(mtext).value;
				}
				document.getElementById(wrk).value = result;
			 }

			 function toggleTextbox<?=$xx?>(checkbox) {
				  const textbox_elem = document.getElementById('mtext_<?=$xx?>');
				  textbox_elem.disabled = checkbox.checked ? false : true;
				  if(textbox_elem.disabled) {
					textbox_elem.value = null;
				  }else {
					textbox_elem.focus();
				  }
				}
			</script>
	<?php } elseif (substr($value2,0,1) == "t") {  ?>
		<textarea name="wr_<?= $xx ?>" class="form-control" rows="5"<?php if($selok == 1) echo " required";?>><?= $k_value ?></textarea>
	<?php } elseif (substr($value2,0,1) == "s") { ?>
		<input type="text" name="wr_<?= $xx ?>" value="<?= $k_value ?>" id="wr_<?= $xx ?>" class="form-control"<?php if($selok == 1) echo " required";?> <?php if($tel == $xx) echo "onclick='addClassName(\"wr_{$xx}\")'  onblur='check_phone_number(\"wr_{$xx}\");'"; ?>>
	<?php } else { ?>
		<input type="radio" name="wr_<?= $xx ?>" class="form-check-input me-2" value="<?= trim($value2) ?>"<?php if($selok == 1) echo " required";?> <?php if(trim($k_value) == trim($value2)) echo " checked"; ?>><span class="me-3"><?= trim($value2) ?></span>
<?php } } } ?>
		</div>
	</div>
<?php  } } ?>