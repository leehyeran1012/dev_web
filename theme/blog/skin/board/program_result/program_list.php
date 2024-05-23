<?php

  if($pcont[1] == 2) { ?>

 	<div class="col-sm-12 col-md-12 shadow p-4 mb-3 rounded mx-auto">
		<p class="fs-5 fw-bold mb-1"><i class="bi bi-patch-check-fill me-2"></i> <?=$pcont[7][0]?> <span class="text-danger">*</span></p>
		<div class="col-sm-12 px-md-3 py-2 lh-base px-sm-0">
			<select name="wr_1" id="wr_1" class="form-select form-select-lg text-primary rounded-0 fs-6" required>
			<option value=""><?=$pcont[7][1]?></option>
		<?php foreach($pcont[2] as $key=>$value) {
		  if (mb_strpos($value,"폐강")){
			$ddel = 1;
		  } else {
			$ddel = 0;
		  }
		$pcount = sql_fetch("select count(*) pnum from {$write_table} where wr_link2 = '".$p_id."' and wr_1 = '".($key+1)."'"); ?>
		<option value="<?= ($key+1) ?>"<?php if($wr_1==($key+1)) echo " selected"; ?><?php if($pcount['pnum'] >= $pcont[4] || $ddel==1) echo " disabled"; ?>> &nbsp;<?= trim($value) ?> (<?=$pcount['pnum']?>)</option>
		<?php } ?>
		</select>
		</div>
	</div>

<?php } elseif($pcont[1] == 3) {

	if(count($pcont[3]) > 1) {
		$prog_item = explode("^",$pcont[3][$wr_1-1]);
	} else {
		$prog_item = explode("^",$pcont[3][0]);
	}
?>

 	<div class="col-sm-12 col-md-12 shadow p-4 mb-3 rounded mx-auto">
		<p class="fs-5 fw-bold mb-1"><i class="bi bi-patch-check-fill me-2"></i> <?=$pcont[7][0]?> <span class="text-danger">*</span></p>
		<div class="col-sm-12 px-md-3 py-2 lh-base px-sm-0">
			<select name="wr_1" id="wr_1" class="form-select form-select-lg text-primary rounded-0 fs-6" required onchange="optionChange(<?=$p_id?>);">
			<option value=""><?=$pcont[7][1]?></option>
		<?php foreach($pcont[2] as $key=>$value) {
		  if (mb_strpos($value,"폐강")){
			$ddel = 1;
		  } else {
			$ddel = 0;
		  }

		$pcount = sql_fetch("select count(*) pnum from {$write_table} where wr_link2 = '".$p_id."' and wr_1 = '".($key+1)."'"); ?>
		<option value="<?= ($key+1) ?>"<?php if($wr_1==($key+1)) echo " selected"; ?><?php if($pcount['pnum'] >= $pcont[4] || $ddel==1) echo " disabled"; ?>> &nbsp;<?= trim($value) ?> (<?=$pcount['pnum']?>)</option>
		<?php } ?>
		</select>
		</div>
	</div>

	<div class="col-sm-12 col-md-12 shadow p-4 mb-3 rounded mx-auto">
		<p class="fs-5 fw-bold mb-1"><i class="bi bi-patch-check-fill me-2"></i> <?=$pcont[7][2]?> <span class="text-danger">*</span></p>
		<div class="col-sm-12 px-md-3 py-2 lh-base px-sm-0">
			<select name="wr_2" id="wr_2" class="form-select form-select-lg text-primary rounded-0 fs-6" required>
			<option value=""><?=$pcont[7][3]?></option>

		<?php foreach($prog_item as $key2=>$value2) {
		  if (mb_strpos($value2,"폐강")){
			$ddel = 1;
		  } else {
			$ddel = 0;
		  }

		$pcount = sql_fetch("select count(*) pnum from {$write_table} where wr_link2 = '".$p_id."' and wr_1 = '".$wr_1."' and wr_2 = '".($key2+1)."'"); ?>
		<option value="<?= ($key2+1) ?>"<?php if($wr_2==($key2+1)) echo " selected"; ?><?php if($pcount['pnum'] >= $pcont[5] || $ddel==1) echo " disabled"; ?>> &nbsp;<?= trim($value2) ?>  (<?=$pcount['pnum']?>)</option>
		<?php } ?>

		</select>
		</div>
	</div>

<?php } elseif($pcont[1] == 4) { ?>

	<div class="col-sm-12 col-md-12 shadow p-4 mb-3 rounded mx-auto">
		<p class="fs-5 fw-bold mb-1"><i class="bi bi-patch-check-fill me-2"></i> <?=$pcont[7][0]?> <span class="text-danger">*</span></p>
		<div class="col-sm-12 px-md-3 py-2 lh-base px-sm-0">
			<select name="wr_1" id="wr_1" class="form-select form-select-lg text-primary rounded-0 fs-6">
			<option value=""><?=$pcont[7][1]?></option>
		<?php foreach($pcont[2] as $key=>$value) {
		  if (mb_strpos($value,"폐강")){
			$ddel = 1;
		  } else {
			$ddel = 0;
		  }

		$pcount = sql_fetch("select count(*) pnum from {$write_table} where wr_link2 = '".$p_id."' and wr_1 = '".($key+1)."'"); ?>
		<option value="<?= ($key+1) ?>"<?php if($wr_1==($key+1)) echo " selected"; ?><?php if($pcount['pnum'] >= $pcont[4] || $ddel==1) echo " disabled"; ?>> &nbsp;<?= trim($value) ?> (<?=$pcount['pnum']?>)</option>
		<?php } ?>
		</select>
		</div>
	</div>

	<div class="col-sm-12 col-md-12 shadow p-4 mb-3 rounded mx-auto">
		<p class="fs-5 fw-bold mb-1"><i class="bi bi-patch-check-fill me-2"></i> <?=$pcont[7][2]?> <span class="text-danger">*</span></p>
		<div class="col-sm-12 px-md-3 py-2 lh-base px-sm-0">
		<select name="wr_2" id="wr_2" class="form-select form-select-lg text-primary rounded-0 fs-6">
			<option value=""><?=$pcont[7][3]?></option>
		<?php foreach($pcont[3] as $key=>$value) {
		  if (mb_strpos($value,"폐강")){
			$ddel = 1;
		  } else {
			$ddel = 0;
		  }

		$pcount = sql_fetch("select count(*) pnum from {$write_table} where wr_link2 = '".$p_id."' and wr_2 = '".($key+1)."'"); ?>
		<option value="<?= ($key+1) ?>"<?php if($wr_2==($key+1)) echo " selected"; ?><?php if($pcount['pnum'] >= $pcont[5] || $ddel==1) echo " disabled"; ?>> &nbsp;<?= trim($value) ?>  (<?=$pcount['pnum']?>)</option>
		<?php } ?>
		</select>
		</div>
	</div>

 <?php } ?>
