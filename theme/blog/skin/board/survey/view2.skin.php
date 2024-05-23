<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$que1 = sql_fetch("select wr_id,wr_subject,wr_1, wr_5 from {$write_table} where wr_id = '{$wr_id}'");

$p_tnum = $que1['wr_5'];
$psubjects = str_replace("\r\n","",$que1['wr_1']);
$psubjects = explode("Q#",$psubjects);
unset($psubjects[0]);

$countall = sql_fetch("select count(*) countall from {$write_table}_result where wr_link2 = '{$wr_id}'");
if($countall['countall'] < 1) {
	alert('설문에 응답한 자료가 없습니다.', $return_url);
}

?>

<script src="<?= $board_skin_url ?>/chart.js"></script>
<script src="<?= $board_skin_url ?>/piechart_view.js"></script>

<div class="container-fluid">
<div class="row border-bottom pb-2 mb-3">
  <div class="col-sm-12 col-md-6 fw-bold mb-2 fs-5"><i class="bi bi-file-medical-fill me-2"></i> <?= $que1["wr_subject"] ?> 결과 보기</div>
  <div class="col-sm-12 col-md-6 text-end mb-2">
	  <a class="btn btn-outline-secondary btn-sm me-3" href="<?= get_pretty_url($bo_table); ?>">목록으로</a>
	  <?php if($p_tnum > 0) { ?><a class="btn btn-outline-success btn-sm me-2" href="<?= get_pretty_url($bo_table); ?>&wr_id=<?=$que1["wr_id"]?>&type=4">주관식보기</a><?php } ?>
	  <a class="btn btn-outline-danger btn-sm" href="<?= $board_skin_url ?>/delete.skin.php?bo_table=<?=$bo_table?>&g_num=<?=$que1["wr_id"]?>" onclick="return confirm('응답자료를 모두 삭제하시겠습니까?')" title="모두 삭제">응답자료삭제</a>
  </div>
</div>

<style>
	table {font-size: .9em;box-shadow: 0 2px 5px rgba(0,0,0,.25);width: 100%;border-collapse: collapse; border-radius: 5px; overflow: hidden;}
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
		<td colspan="2" class="text-start py-3 fs-5 fw-bold"><?=$key?>. <?= str_replace(["[[", "]]", "//"], "",$title) ?></td>
	</tr>
<?php
}
  if(count($pitem) > 1 && !strpos($value, "p")) {

	$pitem2 = implode("^",$pitem);
	$pitem2 = str_replace("c","",$pitem2);
	$pitem2 = str_replace(" ","",$pitem2);
	$pielabel = str_replace("^","','",$pitem2);

	$sql = "select wr_link2 ";
	 foreach($pitem as $key2=>$value2) {
		$sql = $sql." ,count(case when wr_{$key} like '%".$key2."%' then 1 end) ct".$key2;
	 }
	$sql = $sql." from {$write_table}_result where wr_link2 = '{$wr_id}'";

	$result = sql_fetch($sql);

	unset($result['wr_link2']);

	$piedata = implode(",", $result);
	$piedata2 = explode(",", $piedata);
?>
	<tr>
	<td class="py-3" style="width:450px"><div style="width:350px; height:200px;"><canvas id="myChart<?=$key?>"></canvas></div>
		<script>
			var id = <?=$key?>;
			var xv = ['<?= $pielabel ?>'];
			var yv = [<?= $piedata ?>];
			chart_view2(id, xv, yv);
		</script>
	</td>
	<td><div class="rtable"><table class="table text-center table-sm small mt-3" style="width:300px">
	  <thead>
	  <tr class="table-light text-secondary">
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
		$sql = "select wr_{$key} from {$write_table}_result where wr_link2 = '{$wr_id}' and wr_{$key} like '%기타%'";
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
	</table></div>
	</td>
</tr>
<?php } elseif(count($pitem) > 1 && strpos($value, "p")) {	//별점설문

	$clist = "";
	$result = sql_query("select wr_{$key} cc from {$write_table}_result where wr_link2 = '{$wr_id}'");
	foreach ($result as $field) {
		$clist .= $field["cc"]."|";
	}
	$clist2 = explode("|", $clist);
	$result_array = array_count_values($clist2);
?>
	<tr>
		<td colspan="2" class="ps-5 py-3">
			<table style="width:720px">
			<?php foreach($pitem as $key2=>$value2) { ?>
			<tr>
				<td class="fw-bold">◎ <?= str_replace("p","",$value2) ?></td>
			<?php for($t=5; $t>0; $t--) { ?>
				<td><?= str_repeat("☆", $t) ?><span class="text-danger">(
				<?php
					$cc= trim(str_replace("p","",$value2))."^".$t;
					if( in_array($cc, $clist2) ) {
						echo $result_array[$cc];
					} else {
						echo "0";
					}
				?>	)</span>
				</td>
			<?php } ?>
			</tr>
		<?php } ?>
		</table>
		</td>
	</tr>

<?php } else {
	if($p_tnum == 0 || ($p_tnum > 0 && $key < $p_tnum) ) {
?>
<tr>
	<td colspan="2" class="text-start ps-3">
	<?php
		$result = sql_query("select wr_{$key} from {$write_table}_result where wr_link2 = '{$wr_id}'");
		for ($i=0; $row = sql_fetch_array($result); $i++) {
			$list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
		}

		for ($i=0; $i<count($list); $i++) {
			if(strlen($list[$i]['wr_'.$key]) > 0) {
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