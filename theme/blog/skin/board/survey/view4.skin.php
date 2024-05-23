<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$que1 = sql_fetch("select wr_id, wr_subject, wr_1, wr_5, wr_6 from {$write_table} where wr_id = '{$wr_id}'");

$p_tnum = $que1['wr_5'];
$psubjects = str_replace("\r\n","",$que1['wr_1']);
$psubjects = explode("Q#",$psubjects);
unset($psubjects[0]);

$countall = sql_fetch("select count(*) countall from {$write_table}_result where wr_link2 = '{$wr_id}'");
if($countall['countall'] < 1) {
	alert('설문에 응답한 자료가 없습니다.', $return_url);
}

$sub_title =  explode(",",$que1['wr_6']);

$sfield = "wr_".$p_tnum;
foreach($sub_title as $key=>$value) {
	$sfield = $sfield.", wr_".($p_tnum+$key+1);
}
?>
<div class="container-fluid">

<div class="d-flex justify-content-between border-bottom pb-2 mb-3">
  <div class="fs-5 fw-bold"><i class="bi bi-file-medical-fill"></i> <?= $que1["wr_subject"] ?> 설문조사 결과 보기</div>
  <div>
	  <a class="btn btn-outline-secondary btn-sm me-3" href="<?= get_pretty_url($bo_table); ?>">목록으로</a>
	  <a class="btn btn-outline-success btn-sm me-3" href="<?= $board_skin_url ?>/excel_view.php?bo_table=<?=$bo_table?>&g_num=<?=$que1["wr_id"]?>">엑셀로저장</a>
	  <a class="btn btn-outline-danger btn-sm" href="<?= $board_skin_url ?>/delete.skin.php?bo_table=<?=$bo_table?>&g_num=<?=$que1["wr_id"]?>" onclick="return confirm('신청자료를 모두 삭제하시겠습니까?')" title="모두 삭제">응답자료삭제</a>
  </div>
</div>

<div class="table-responsive">
<table class="table align-middle text-center" style="min-width:1000px">
	<thead class="table-light">
		<tr>
			<th width='80'>연번</th>
		<?php foreach($sub_title as $key=>$value) { ?>
			<th<?php if($value<>"내용") echo " width='120'"; ?>><?=$value?></th>
		<?php } ?>
		</tr>
	</thead>
	<tbody>
	<?php

$result = sql_query("select * from {$write_table}_result where wr_link2 = '{$wr_id}'");

$x = 0;
	if ($result) {
	foreach ($result as $field) {
	$x++;
?>
		<tr>
			<td><?= $x ?></td>
		<?php foreach($sub_title as $key=>$value) { ?>
			<td><?= $field["wr_".($p_tnum+$key)] ?></td>
		<?php } ?>
		</tr>

<?php  } } else { ?>

		<tr>
			<td colspan="4">자료가 없습니다.</td>
		</tr>
<?php } ?>

</table>
</div>

<div style="height:120px">&nbsp;</div>
</div>