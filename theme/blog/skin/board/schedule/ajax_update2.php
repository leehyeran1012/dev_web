<?php
include_once('./_common.php');

$id = $_POST["id"];

$bo_table = $_POST["bo_table"];

$bo_table = $g5['write_prefix'] . $bo_table;

$wr_1 = $_POST["wr_1"];
$wr_2 = $_POST["wr_2"];

$sql = " update {$bo_table} set wr_1 = '{$wr_1}', wr_2 = '{$wr_2}'  where wr_id = '{$id}' ";
sql_query($sql);

die("{\"tdate\":\"{$wr_1}\",\"ok\":\"ok\"}");
