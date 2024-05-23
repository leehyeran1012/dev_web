<?php
include_once('./_common.php');

$p_id = isset($_POST["p_id"])  ? intval($_POST["p_id"]) : 0;
$s_value = isset($_POST["s_value"])  ? html_purifier($_POST["s_value"]) : "";

$bot_table = str_replace("_result","",$write_table);

$que1 = sql_fetch("select wr_id,wr_7 from {$bot_table} where wr_id = '{$p_id}'");

$c_val = explode("|", $que1["wr_7"]);
$c_id = trim($c_val[0]);

$pcount = sql_fetch("select count(*) pnum from {$write_table} where wr_link2 = '{$p_id}' and wr_{$c_id} = '{$s_value}'");

if($pcount['pnum'] >= intval($c_val[1])) {
		$pok = 1;
} else {
		$pok = 0;
}

echo json_encode(array("p_ok"=>$pok, "ok"=>"ok"));