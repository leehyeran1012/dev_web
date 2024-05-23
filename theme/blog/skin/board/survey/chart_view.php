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
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="chart.js"></script>
<script src="piechart_view.js"></script>
</head>
<body>
<?php

$poll_num = isset($_GET['g_num'])  ? intval($_GET['g_num']) : 0;

$que1 = sql_fetch("select wr_id,wr_subject,wr_1, wr_5 from {$write_table} where wr_id = '{$poll_num}'");

$p_tnum = $que1['wr_5'];
$psubjects = str_replace("\r\n","",$que1['wr_1']);
$psubjects = explode("Q#",$psubjects);
unset($psubjects[0]);

$countall = sql_fetch("select count(*) countall from {$write_table}_result where wr_link2 = '{$poll_num}'");
if($countall['countall'] < 1) {
	alert('설문에 응답한 자료가 없습니다.', $return_url);
}

?>
<div class="container" style="width:900px">

<div class="d-flex justify-content-between border-bottom pt-4 pb-2 mb-5">
  <div class="fs-5 fw-bold"><i class="bi bi-file-medical-fill"></i> <?= $que1["wr_subject"] ?> 설문조사 결과 보기</div>
  <div><a href="<?= get_pretty_url($bo_table); ?>" class="btn btn-outline-secondary btn-sm me-3">목록으로</a>
  <?php if($p_tnum > 0) { ?>
		<a href="result_contview.php?bo_table=<?=$bo_table?>&g_num=<?=$que1["wr_id"]?>" class="btn btn-outline-success btn-sm me-2">특기사항보기</a>
	<?php } ?>
  <a class="btn btn-outline-danger btn-sm" href="result_delete.php?p_no=<?=$p_no?>" onclick="return confirm('신청자료를 모두 삭제하시겠습니까?')" title="모두 삭제">응답자료삭제</a></div>
</div>
<style>
	table {border: 1px #a39485 solid;font-size: .9em;box-shadow: 0 2px 5px rgba(0,0,0,.25);width: 100%;border-collapse: collapse; border-radius: 5px; overflow: hidden;}
	thead {font-weight: bold; color: #fff; background: #73685d;}
	td, th {padding: 0.5em .5em; vertical-align: middle; text-align:center}
	td {border-bottom: 1px solid rgba(0,0,0,.1);background: #fff;}
</style>

<table class="table">

<?php foreach($psubjects as $key=>$value) {
	$gitas = explode("^",$value);
	$value = str_replace("^e 기타","",$value);
	$value = str_replace("c ","",$value);
	$pitem = explode("^",$value);
	$title = $pitem[0];
	unset($pitem[0]);

if($p_tnum == 0 || ($p_tnum > 0 && $key < $p_tnum) ) {
?>
	<tr>
		<td colspan="2" class="text-start py-2 fs-5 fw-bold"><?=$key?>. <?= $title ?></td>
	</tr>
<?php
}
	if(count($pitem) > 1) {
	$pitem2 = implode("^",$pitem);
	$pitem2 = str_replace("c","",$pitem2);
	$pitem2 = str_replace(" ","",$pitem2);
	$pielabel = str_replace("^","','",$pitem2);
	$pielabel = "['".trim($pielabel)."']";

	$sql = "select wr_link2 ";
	 foreach($pitem as $key2=>$value2) {
		$sql = $sql." ,count(case when wr_{$key} like '%".$key2."%' then 1 end) ct".$key2;
	 }
	$sql = $sql." from {$write_table}_result where wr_link2 = '{$poll_num}'";

	$result = sql_fetch($sql);

	unset($result['wr_link2']);
	$cc = implode(",",$result);

	$piedata = "[".$cc."]";
	$piedata2 = explode(",",$cc);
?>
	<tr>
	<td class="py-3"><div style="width:350px; height:200px;margin:auto;"><canvas id="myChart<?=$key?>"></canvas></div>
		<script>
			var id = <?=$key?>;
			var xv = <?= $pielabel ?>;
			var yv = <?= $piedata ?>;
			chart_view2(id, xv, yv);
		</script>
	</td>
	<td><table class="table text-center table-sm small mt-3" style="width:300px">
	  <thead>
	  <tr class="bg-light text-secondary">
		<th>응답</th>
		<th>응답수</th>
		<th>만족도</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach($pitem as $key2=>$value2) { ?>
	<tr>
		<td><?= $value2 ?></td>
		<td><?= $piedata2[$key2-1] ?></td>
		<td><?= round((($piedata2[$key2-1] / $countall['countall']) * 100),0); ?>%</td>
	</tr>
	<?php } ?>
	<?php if (mb_strpos(end($gitas), "기타") !== false ) {

		$cont2 = "";
		$sql = "select wr_{$key} from {$write_table}_result where wr_link2 = '{$poll_num}' and wr_{$key} like '%기타%'";
		$result = sql_query($sql);
		foreach($result as $value2) {
			$cont = explode("|",$value2["wr_".$key]);
			$cont2 = $cont2.", ".end($cont);
		}
		$cont2 = substr($cont2,1);
		$cont2 = str_replace("기타:","",$cont2);

		if(strlen($cont2) > 2) {
	?>
		<tr>
			<td colspan="3" class="text-start py-2"><span class="fw-bold text-success">기타:</span><?= $cont2 ?></td>
		</tr>
	<?php } } ?>
	</tbody>
	</table>
	</td>
</tr>
<?php } else {
	if($p_tnum == 0 || ($p_tnum > 0 && $key < $p_tnum) ) {
?>
<tr>
	<td colspan="2" class="text-start ps-3">
	<?php
		$result = sql_query("select wr_{$key} from {$write_table}_result where wr_link2 = '{$poll_num}' and char_length(wr_{$key}) > 3");
		for ($i=0; $row = sql_fetch_array($result); $i++) {
			$list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
		}

		for ($i=0; $i<count($list); $i++) {
			if(strlen($list[$i]['wr_'.$key]) > 2) {
			echo "* ".$list[$i]['wr_'.$key]."<br>";
			}
		}
	 ?>
	</td>
</tr>
<?php } } } ?>
</table>

<div style="height:120px">&nbsp;</div>
</div>

</body>
</html>