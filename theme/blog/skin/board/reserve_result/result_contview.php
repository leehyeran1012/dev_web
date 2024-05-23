<?php
include "./_common.php";
?>
<!doctype html>
<html lang="ko">
<head>
<title>설문조사결과</title>
<meta  charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="language" content="ko">
<meta name="viewport" content="initial-scale=1.0, width=device-width">
<script type="text/javascript" src="<?=G5_URL?>/js/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=G5_URL?>/css/default.css">
<link rel="stylesheet" href="<?=G5_THEME_URL?>/css/bootstrap/css/bootstrap.min.css">
<script src="chart.js"></script>
<script src="piechart_view.js"></script>
</head>

<body>
<?php

$boa_table = $_GET['bo_table'] ?? "";
$poll_num = $_GET['g_num'] ?? 0;

$bo_table = $boa_table."_result";

$que1 = sql_fetch("select wr_subject,wr_1, wr_5, wr_6 from g5_write_".$boa_table." where wr_id = '".$poll_num."'");

$p_tnum = $que1['wr_5'];
$psubjects = str_replace("\r\n","",$que1['wr_1']);
$psubjects = explode("Q#",$psubjects);
unset($psubjects[0]);

$countall = sql_fetch("select count(*) countall from g5_write_".$bo_table." where wr_link2 = '".$poll_num."'");
if($countall['countall'] < 1) {
	alert('설문에 응답한 자료가 없습니다.', $return_url);
}

$sub_title =  explode(",",$que1['wr_6']);

$sfield = "wr_".$p_tnum;
foreach($sub_title as $key=>$value) {
	$sfield = $sfield.", wr_".($p_tnum+$key+1);
}
?>
<div class="d-flex justify-content-between border-bottom pt-4 pb-2 mb-5" style="width:1200px">
  <div class="fs-5 fw-bold"><i class="bi bi-file-medical-fill fs-4"></i> <?= $result["p_subject"] ?></div>
  <div><a href="list.php" class="btn btn-outline-secondary btn-sm me-2">목록으로</a>
  	<?php if($p_tnum > 0) { ?>
		<a href="result_contview2.php?p_no=<?=$result["p_no"]?>" class="btn btn-outline-success btn-sm me-2">특기사항보기</a>
	<?php } ?>
  <a class="btn btn-outline-danger btn-sm" href="result_delete.php?p_no=<?=$result["p_no"]?>" onclick="return confirm('신청자료를 모두 삭제하시겠습니까?')" title="모두 삭제">응답자료삭제</a></div>
</div>
<style>
	.qr{border: 10px solid #ff9900;}
	table {border: 1px #a39485 solid;font-size: .9em;box-shadow: 0 2px 5px rgba(0,0,0,.25);width: 100%;border-collapse: collapse; border-radius: 5px; overflow: hidden;}
	thead {font-weight: bold; color: #fff; background: #73685d;}
	td, th {padding: 0.5em .5em; vertical-align: middle; text-align:center}
	td {border-bottom: 1px solid rgba(0,0,0,.1);background: #fff;}
</style>

<br><br>

<div  style="width:800px; margin:auto">
<h1> 설문조사 결과 보기 </h1><br>
<h3 class="text-primary"><?= $que1['wr_subject'] ?></h3><br>


<table class="table table-bordered align-middle">
	<thead class="table-light">
		<tr>
			<th width='80'>연번</th>
		<?php foreach($sub_title as $key=>$value) { ?>
			<th<?php if($value<>"내용") echo " width='120'"; ?>><?=$value?></th>
		<? } ?>
		</tr>
	</thead>
	<tbody>
	<?php
$x = 0;
	if ($result) {
	foreach ($result as $field) {
	$x++;
?>
		<tr>
			<td><?= $x ?></td>
		<?php foreach($sub_title as $key=>$value) { ?>
			<td><?= $field["wr_".($p_tnum+$key)] ?></td>
		<? } ?>
		</tr>

<?php  } } else { ?>

		<tr>
			<td colspan="4">자료가 없습니다.</td>
		</tr>
<?php } ?>


</table>

<?php include_once("../foot.php"); ?>