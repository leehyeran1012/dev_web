<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($is_admin || $is_member) {

	$wr_name = html_purifier($_POST["wr_name"]);
	$wr_password = get_encrypt_string(html_purifier($_POST["wr_password"]));

	sql_query("update $write_table set mb_id = 'guest', wr_name = '{$wr_name}', wr_password = '{$wr_password}' where wr_id = '{$wr_id}'");
}

if($w == "u") {

	//여기에 문자보내기 구문 추가

	alert("수정 되었습니다.","./board.php?bo_table={$bo_table}");

} else {

	$pdate = substr($wr_1,0,7);
	$bot_table = str_replace("_result","",$write_table);

	$unum = sql_fetch("select wr_1,wr_8 from {$bot_table} where wr_1 = '{$pdate}'");
	$stnum = intval($unum["wr_8"]);

	$pcount = sql_fetch("select count(*) p_num from {$write_table} where wr_1 = '{$wr_1}' and wr_2 = '{$wr_2}'");

	if($pcount['p_num'] >= ($stnum+1)) {
		$pok = 1;
	} else {
		$pok = 0;
	}

	if($pok == 1) {

		sql_query(" delete from {$write_table} where wr_id = '{$wr_id}'");
		sql_query(" delete from {$g5['board_new_table']} where wr_id = '{$wr_id}'");

		alert("신청실패!!! 해당 항목은 신청이 완료되었습니다. 다른 항목을 신청해 주세요.", "./write.php?bo_table={$bo_table}");

	} else {

		//여기에 문자보내기 구문 추가

		alert("신청이 접수되었습니다. 감사합니다.","./board.php?bo_table={$bo_table}");

	}
}
