<?php
include_once('./_common.php');

$id = $_POST["id"];
$tdate = $_POST["tdate"];

$bo_table = $_POST["bo_table"];
$bo_table = $g5['write_prefix'] . $bo_table;

sql_query(" delete from {$bo_table} where wr_id = '{$id}'");

die("{\"tdate\":\"{$tdate}\",\"ok\":\"ok\"}");
