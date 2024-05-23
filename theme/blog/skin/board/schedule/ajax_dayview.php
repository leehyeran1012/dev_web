<?php
include_once('./_common.php');

$cdate = $_POST["id"];

$bo_table = $_POST["bo_table"];

$bo_table = $g5['write_prefix'] . $bo_table;

$que1 = sql_fetch("select wr_1,wr_2,wr_3,wr_4,wr_5,wr_6,wr_7 from {$bo_table} where wr_1 = '{$cdate2}'");

return json_encode($que1);