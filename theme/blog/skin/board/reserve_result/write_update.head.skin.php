<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('./_common.php');

$wrk_1 = substr($wr_1,0,7);
$que1 = sql_fetch("select count(wr_name) p_num from $write_table where wr_name = '{$wr_name}' and wr_3 = '{$wr_3}' and left(wr_1,7) = '{$wrk_1}'");

if($w == "" && $que1["p_num"] >= 1) {

	alert("이미 예약한 자료가 있습니다. 변경하시려면 신청내역에서 수정하세요.","./board.php?bo_table=$bo_table");

}