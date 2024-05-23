<?php
include_once('./_common.php');

$tdate = isset($_POST['tdate']) ? $_POST['tdate'] : date("Y-m-d");
$tdate = substr($tdate,0,10);
$tdate = date("Y-m-d", strtotime("{$tdate} +10 days"));
$yymm = substr($tdate,0,7);

$datas = [];
$result = sql_query("select wr_id,wr_subject,wr_content,wr_name,wr_1,wr_2,wr_3,wr_4 from {$write_table} where left(wr_1,7) = '{$yymm}' order by wr_subject");

$x=0;

foreach($result as $field) {
	$x++;
	$datas[] = array("id"=>$field['wr_id'],"title"=>$field['wr_subject'], "start"=>$field['wr_1'], "end"=>$field['wr_2'], "description"=>nl2br($field['wr_content']), "color"=>$field['wr_3'], "textColor"=>$field['wr_4'],"order"=>1);
}

//다른 테이블 자료 추가시 아래처럼 추가하면 됨
//$result = sql_query("select wr_id,wr_subject,wr_content,wr_name,wr_datetime from {$g5['write_prefix']}free where left(wr_datetime,7) = '{$yymm}' order by wr_datetime,wr_subject");
//foreach ($result as $field) {
//	$datas[] = array("id"=>0,"title"=>$field['wr_subject'], "start"=>substr($field['wr_datetime'],0,10), "end"=>substr($field['wr_datetime'],0,10), "description"=>$field['wr_content'], "color"=>"#ffffff", "textColor"=>"#009900","order"=>2);
//}

echo json_encode($datas);