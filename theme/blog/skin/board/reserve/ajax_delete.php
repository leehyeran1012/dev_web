<?php
include_once('./_common.php');

$b_num = !empty($_GET["b_num"]) ? html_purifier($_GET["b_num"]) : 0;
$d_num = !empty($_GET["d_num"]) ? html_purifier($_GET["d_num"]) : 0;

$bot_table = $write_table."_result";
$boa_table = $bo_table."_result";

sql_query("delete from {$bot_table} where wr_id = '{$d_num}'");

sql_query(" delete from {$g5['board_new_table']} where bo_table = '{$boa_table}' and wr_parent = '{$d_num}'");

alert("취소 되었습니다.", G5_BBS_URL."/board.php?bo_table=$bo_table&wr_id=$b_num&type=9");