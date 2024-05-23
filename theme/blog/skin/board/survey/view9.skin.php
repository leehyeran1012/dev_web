<?php
if(!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/custom.css">', 0);

$que1 = sql_fetch("select wr_id,wr_subject,wr_content,wr_1, wr_5 from {$write_table} where wr_id = '{$wr_id}'");
$svcontents = str_replace("\r\n","",$que1['wr_1']);
$svcontents = explode("Q#",$svcontents);

$boa_table = $write_table."_result";

$result = sql_query("select * from $boa_table where wr_link2 = '{$wr_id}' order by wr_name");

$y = 0;

?>

<div class="container-fluid mb-5">

	<div class="row border-bottom pt-4 pb-2 mb-5">
		<div class="col-sm-12 col-md-6 fs-4 fw-bold"><i class="bi bi-flower2 text-warning me-2"></i><?= $que1["wr_subject"] ?></div>
		<div class="col-sm-12 col-md-6 text-end"><a class="btn btn-outline-secondary btn-sm" href="<?= get_pretty_url($bo_table); ?>">목록으로</a></div>
	</div>

	<div class="table-responsive">
	<table class="table mb-4 align-middle table-hover text-center" style="min-width:1200px">
		<thead class="table-light border-top">
			<tr>
				<th style="width: 5rem;">번호</th>
				<th style="width: 8rem;word-break: break-all;">참여자</th>
				<?php for($x=1; $x<count($svcontents); $x++) { ?>
				<th style="width: 15rem;">항목<?=$x?></th>
				<?php } ?>
				<th style="width: 5rem;">수정</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($result as $field) {
			$y++;
		?>
			<tr>
				<td><?= $y ?></td>
				<td style="word-break: break-all;"><?= $field['wr_name'] ?></td>
				<?php for($x=1; $x<count($svcontents); $x++) { ?>
				<td><?= $field['wr_'.$x] ?></td>
				<?php } ?>
				<td><a class="btn btn-outline-secondary btn-sm" href="<?= G5_BBS_URL ?>/write.php?w=u&bo_table=<?=$bo_table?>_result&wr_id=<?=$field['wr_id']?>&k_num=<?=$que1['wr_id']?>">수정</a></td>
			</tr>
			<?php } ?>
			<?php if ($y == 0) { echo '<tr><td colspan="4" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
		</tbody>
	</table>
	</div>
</div>
