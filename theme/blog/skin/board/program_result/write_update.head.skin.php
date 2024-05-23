<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$bot_table = str_replace("_result","", $write_table);
$que1 = sql_fetch("select wr_id,wr_6 from $bot_table where wr_id = '{$wr_link2}'");
$anums = explode("|", $que1['wr_6']);
$stuallnum = intval($anums[2]);		//1인당 신청수

if($w == "") {
	$que2 = sql_fetch("select count(wr_name) p_num from $write_table where wr_name = '{$wr_name}' and wr_3 = '{$wr_3}'");
	if($que2["p_num"] >= $stuallnum) {
		alert("이미 신청한 자료가 있습니다. 변경하시려면 신청확인에서 수정하세요.","./board.php?bo_table=$bo_table");
	}
}