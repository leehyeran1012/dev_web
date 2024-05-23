<?php
include_once('./_common.php');

$id = isset($_POST["id"]) ? intval($_POST["id"]) : 0;

$wr_1 = html_purifier($_POST["wr_1"]);
$wr_2 = html_purifier($_POST["wr_2"]);

$sql = " update {$write_table} set wr_1 = '{$wr_1}', wr_2 = '{$wr_2}'  where wr_id = '{$id}' ";
sql_query($sql);

echo json_encode(array("tdate"=>$wr_1, "ok"=>"ok"));