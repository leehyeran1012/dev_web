<?php
include_once('./_common.php');

$d_num = !empty($_GET["d_num"]) ? html_purifier($_GET["d_num"]) : 0;
$d_date = !empty($_GET["d_date"]) ? html_purifier($_GET["d_date"]) : 0;

$bot_table = $write_table."_result";
$boa_table = $bo_table."_result";

sql_query("delete from {$write_table} where wr_id = '{$d_num}'");
sql_query("delete from {$bot_table} where left(wr_1,7)  = '{$d_date}'");

sql_query(" delete from {$g5['board_new_table']} where bo_table = '{$bo_table}' and wr_parent = '{$d_num}'");
sql_query(" delete from {$g5['board_new_table']} where bo_table = '{$boa_table}' and wr_parent = '{$d_num}'");

alert("삭제 되었습니다.", G5_URL."/bbs/board.php?bo_table={$bo_table}");
