<?php
include_once('./_common.php');

$id = isset($_POST["id"]) ? html_purifier($_POST["id"]) : 0;

$que1 = sql_fetch("select wr_id,wr_1,wr_3,wr_4,wr_5,wr_6,wr_7,wr_8,wr_9 from {$write_table} where wr_id = '{$id}'");

echo json_encode($que1);