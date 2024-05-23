<?php
include_once('./_common.php');

$id = $_POST["id"] ?? 3;

$bo_table = $_POST["bo_table"];

$bo_table = $g5['write_prefix'] . $bo_table;

$que1 = sql_fetch("select wr_id,wr_subject,wr_content,wr_1,wr_2,wr_3,wr_4 from {$bo_table} where wr_id = '{$id}'");

echo json_encode($que1);