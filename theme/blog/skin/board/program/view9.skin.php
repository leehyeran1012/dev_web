<?php
if(!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('apply.confirm.lib.php');

$que1 = sql_fetch("select wr_id,wr_subject from {$write_table} where wr_id = '{$wr_id}'");

//순서--> 0: 오픈, 1: 신청유형, 2: 선택1 내용, 3: 선택2 내용, 4: 선택1 정원,  5: 선택2 정원, 6: 1인당신청수 7: 선택 제목 8: 접수항목
$openk = select_confirm($bo_table, $wr_id);

$boa_table = $write_table."_result";

$result = sql_query("select wr_id,wr_subject,wr_content,wr_name,wr_last,wr_1,wr_2,wr_3,wr_4,wr_5,wr_6,wr_7,wr_8,wr_9,wr_10 from {$boa_table} where wr_link2 = '{$wr_id}' order by wr_name");

$y = 0;

set_session('ss_delete_token', $token = uniqid(time()));

?>
<style type="text/css">
	.details {display: none;}
	.expand-btn::after {content: "+";}
	.collapse-btn::after {content: "-";}
</style>
<div class="container-fluid mb-5">

		<div class="row border-bottom pt-4 pb-2 mb-5">
		  <div class="col-sm-12 col-md-6 fs-4 fw-bold"><i class="bi bi-file-medical-fill me-2"></i>신청결과(<?= $que1["wr_subject"] ?>)</div>
		  <div class="col-sm-12 col-md-6 text-end"><a class="btn btn-outline-success btn-sm me-3" href="<?= $board_skin_url ?>/excel_view.php?bo_table=<?=$bo_table?>&g_num=<?=$wr_id?>">엑셀로저장</a><a class="btn btn-outline-secondary btn-sm" href="<?= get_pretty_url($bo_table); ?>">목록으로</a></div>
		</div>

		<div class="table-responsive">
		 <table class="table mb-4 align-middle table-hover text-center" style="min-width:1200px">
			<thead class="table-light border-top">
			<tr>
				<th style="width: 5rem;">번호</th>
				<th style="width: 6rem;">신청자</th>
				<?php if($openk[1] > 1) { ?>
				<th style="width: 6rem;">선택1</th>
				<th style="width: 6rem;">선택2</th>
				<?php } ?>
				<th style="width: 6rem;">전화번호</th>
				<th style="width: 6rem;">성별</th>
				<?php
				if(count($openk[8]) > 0) {
				foreach($openk[8] as $key=>$value) {
					$item_array = explode("^",$value);
					$sub_title = $item_array[0]; ?>
				<th style="width: 6rem;"><?= trim($sub_title) ?></th>
				<?php } } ?>
				<th style="width: 4rem;">수정</th>
				<th style="width: 4rem;">예약취소</th>
				<th style="width: 4rem;">추가자료</th>
			</tr>
			</thead>
			<tbody>
		<?php foreach($result as $field) {
			$y++;
			$x = 5;

			$wrk1 = intval($field['wr_1']) - 1;
			$wrk2 = intval($field['wr_2']) - 1;
			if(count($openk[3]) == 1) $wrk1 = 0;

			$p_items = explode("^", $openk[3][$wrk1]);

		?>
			<tr>
				<td><?= $y ?></td>
				<td><a href="<?=G5_BBS_URL?>/write.php?w=u&bo_table=<?=$bo_table?>_result&wr_id=<?=$field['wr_id']?>" target="_blank"><?= $field['wr_name'] ?></a></td>
				<?php if($openk[1] > 1) { ?>
				<td><?= $openk[2][$wrk1] ?></td>
				<td><?= $p_items[$wrk2] ?></td>
				<?php } ?>
				<td><?= $field['wr_3'] ?></td>
				<td><?= $field['wr_4'] ?></td>

			<?php
			if(count($openk[8]) > 0) {
				foreach($openk[8] as $key=>$value) {

			?>
				<td><?= str_replace(["|","기타:"], " ",$field['wr_'.$x]) ?></td>
				<?php
				$x++;
			} }
			?>
				<td><a href="<?=G5_BBS_URL?>/write.php?w=u&bo_table=<?=$bo_table?>_result&wr_id=<?=$field['wr_id']?>" class="btn btn-outline-success btn-sm px-3" target="_blank">수정</a></td>
				<td><a href="<?= $board_skin_url ?>/ajax_delete.php?bo_table=<?=$bo_table?>&b_num=<?=$wr_id?>&d_num=<?=$field['wr_id']?>" onclick="return confirm('해당 신청자료를 삭제하시겠습니까? 삭제한 자료는 복구할 수 없습니다.')" class="btn btn-outline-danger btn-sm px-3">취소</a></td>
				<td><button class="btn btn-outline-secondary fs-5 p-0 expand-btn" onclick="toggleDetails(this)" style="width:40px"></button></td>
			</tr>
			<tr class="details">
			  <td>&nbsp;</td>
			  <td class="text-start py-2" colspan="9"><table class="table table-borderless table-sm text-start">
				<tr><td width="100"></td><td></td></tr>
				<tr><td>요청사항</td><td><?= $field['wr_content'] ?></td></tr>
				<tr><td>신청일자</td><td><?= $field['wr_last'] ?></td></tr>
			  </table></td>
			</tr>
			<?php } ?>
			<?php if (count($result) == 0) { echo '<tr><td colspan="6" class="empty_table">게시물이 없습니다.</td></tr>'; } ?>
			</tbody>
		</table>
	</div>
</div>

<script>
	function toggleDetails(button) {
	  const detailsRow = button.parentNode.parentNode.nextElementSibling;
	  detailsRow.classList.toggle("details");
	  button.classList.toggle("expand-btn");
	  button.classList.toggle("collapse-btn");
	}
</script>