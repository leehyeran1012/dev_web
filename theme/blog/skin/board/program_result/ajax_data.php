<?php
include_once('./_common.php');
include_once('apply.confirm.lib.php');

$p_id = isset($_POST["p_id"])  ? $_POST["p_id"] : 0;
$w_id = isset($_POST["w_id"])  ? $_POST["w_id"] : 1;

$bo_table = str_replace("_result","",$bo_table);

$pcont = select_confirm($bo_table, $p_id);

if(count($pcont[3]) == 1) {
	$acount = 0;
} else {
	$acount = $w_id - 1;
}

$prog_cont2 = explode("^", $pcont[3][$acount]);

echo "<option value=''>".$pcont[7][1]."</option>";
foreach($prog_cont2 as $key=>$value) {
	  if (mb_strpos($value,"폐강")){
			$ddel = 1;
	  } else {
			$ddel = 0;
	  }
	$pcount = sql_fetch("select count(*) pnum from {$write_table} where wr_link2 = '".$p_id."' and wr_1 = '".$w_id."' and wr_2 = '".($key+1)."'");
	if($pcount['pnum'] >= $pcont[5] || $ddel==1) {
		$disabled = " disabled";
	} else {
		$disabled = "";
	}

  echo "<option value='".($key+1)."'".$disabled.">".$value." (".$pcount['pnum'].")</option>";
}
