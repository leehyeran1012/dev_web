<?php
include_once('./_common.php');

$tdate = $_POST['tdate'];
$bo_table = $_POST['bo_table'];
$tdate = substr($tdate,0,10);
$tdate = date("Y-m-d", strtotime("{$tdate} +10 days"));

$yymm = substr($tdate,0,7);

$bo_table = $g5['write_prefix'] . $bo_table;
$bo_table2 = $g5['write_prefix'] . "sangdam_result";

$datas = [];
$que1 = sql_query("select wr_id,wr_subject,wr_1,wr_2,wr_3,wr_4 from {$bo_table} where left(wr_1,7) = '{$yymm}' order by wr_1,wr_subject");
$x=0;
foreach($que1 as $field) {
$x++;
$datas[] = array("id"=>$field['wr_id'],"title"=>$field['wr_subject'], "start"=>$field['wr_1'], "end"=>$field['wr_2'], "color"=>$field['wr_3'], "textColor"=>$field['wr_4'], "order"=>$x);

}

$que1 = sql_query("select wr_id,wr_name,wr_1,wr_2,wr_3,wr_4 from {$bo_table2} where left(wr_1,7) = '{$yymm}' order by wr_1, wr_2");

foreach($que1 as $field) {
$x++;
$datas[] = array("id"=>$field['wr_id'],"title"=>"♠ ".$field['wr_name']." ".$field['wr_2'], "start"=>$field['wr_1'], "end"=>$field['wr_1'], "color"=>"white", "textColor"=>"blue", "order"=>$x);

}

echo json_encode($datas);
