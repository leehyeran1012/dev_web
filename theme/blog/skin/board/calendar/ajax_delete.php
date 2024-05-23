<?php
include_once('./_common.php');

$id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;
$tdate = isset($_POST['tdate']) ? $_POST['tdate'] : date("Y-m-d");

sql_query(" delete from {$write_table} where wr_id = '{$id}'");

echo json_encode(array("tdate"=>$tdate, "ok"=>"ok"));