<?php
include_once('./_common.php');

$id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;

$que1 = sql_fetch("select wr_id,wr_subject,wr_content,mb_id,wr_name,wr_1,wr_2,wr_3,wr_4 from {$write_table} where wr_id = '{$id}'");

$tmb_id = $que1["mb_id"];

if($tmb_id == "guest") {
	echo json_encode($que1);
} else {
	if($tmb_id == $member['mb_id']) {
		echo json_encode($que1);
	} else {
		alert("본인 것만 수정가능합니다.");
	}
}