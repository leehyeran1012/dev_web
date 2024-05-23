<?php
include_once('./_common.php');

$id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
$wr_1 = html_purifier($_POST["wr_1"]);
$wr_2 = html_purifier($_POST["wr_2"]);

$que1 = sql_fetch("select wr_id,wr_subject,wr_content,mb_id,wr_name,wr_1,wr_2,wr_3,wr_4 from {$write_table} where wr_id = '{$id}'");

$tmb_id = $que1["mb_id"];

if($tmb_id == "guest") {
	sql_query("update {$write_table} set wr_1 = '{$wr_1}', wr_2 = '{$wr_2}'  where wr_id = '{$id}'");
} else {
	if($tmb_id == $member['mb_id']) {
		sql_query("update {$write_table} set wr_1 = '{$wr_1}', wr_2 = '{$wr_2}'  where wr_id = '{$id}'");
	} else {
		alert("본인 것만 수정가능합니다.");
		exit;
	}
}

$wr_1 = substr($wr_1,0,8)."01";

echo json_encode(array("tdate"=>$wr_1, "ok"=>"ok"));