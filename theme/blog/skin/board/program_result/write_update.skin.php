<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('apply.confirm.lib.php');

if($is_admin || $is_member) {

	$wr_name = html_purifier($_POST["wr_name"]);
	$wr_password = get_encrypt_string(html_purifier($_POST["wr_password"]));

	sql_query("update $write_table set mb_id = 'guest', wr_name = '{$wr_name}', wr_password = '{$wr_password}' where wr_id = '{$wr_id}'");
}

$wr_link1 = implode('|', $_POST['check1']);
$wr_1 = html_purifier($_POST['wr_1']);

sql_query("update $write_table set wr_5 = '$wr_5', wr_link1 = '$wr_link1' where wr_id = '{$wr_id}'");

$boa_table = str_replace("_result","",$bo_table);

//순서--> 0: 오픈, 1: 신청유형, 2: 선택1 내용, 3: 선택2 내용, 4: 선택1 정원,  5: 선택2 정원, 6: 1인당신청수 7: 선택 제목
$pcont = select_confirm($boa_table, $wr_link2);

$pok = $pok1 = 0;

if($pcont[1] == 1) {

	$pcount = sql_fetch("select count(*) pnum from $write_table where wr_link2 = '{$wr_link2}'");
	if($pcount['pnum'] >= ($pcont[4]+1)) {
		$pok = 1;
	} else {
		$pok = 0;
	}

	$pok1 = 0;

} elseif($pcont[1] == 2) {

	$pcount = sql_fetch("select count(*) pnum from $write_table where wr_link2 = '{$wr_link2}' and wr_1 = '{$wr_1}'");

	if($pcount['pnum'] >= ($pcont[4]+1)) {
		$pok = 1;
	} else {
		$pok = 0;
	}

	$pok1 = 0;

} elseif($pcont[1] == 3) {

	$pcount = sql_fetch("select count(*) pnum from $write_table where wr_link2 = '{$wr_link2}' and wr_1 = '{$wr_1}' and wr_2 = '{$wr_2}'");

	if($pcount['pnum'] >= ($pcont[5]+1)) {
		$pok = 1;
	} else {
		$pok = 0;
	}

	$pok1 = 0;

} elseif($pcont[1] == 4) {

	$pcount1 = sql_fetch("select count(*) pnum from $write_table where wr_link2 = '{$wr_link2}' and wr_1 = '{$wr_1}'");
	$pcount2 = sql_fetch("select count(*) pnum from $write_table where wr_link2 = '{$wr_link2}' and wr_2 = '{$wr_2}'");

	if($pcount1['pnum'] >= ($pcont[4]+1)) {
		$pok = 1;
	} else {
		$pok = 0;
	}

	if($pcount2['pnum'] >= ($pcont[5]+1)) {
		$pok1 = 1;
	} else {
		$pok1 = 0;
	}

}

if($w == "u") {
	alert("수정 되었습니다.","./board.php?bo_table={$bo_table}");
} else {
	if($pok == 1 || $pok1 ==1) {
		sql_query(" delete from {$write_table} where wr_id = '{$wr_id}'");
		alert("신청실패!!! 해당항목은 신청이 완료되었습니다.","./write.php?bo_table={$bo_table}&g_num={$wr_link2}&ook=1");
	} else {
		alert("신청이 접수되었습니다. 감사합니다.","./board.php?bo_table={$bo_table}");
	}
}