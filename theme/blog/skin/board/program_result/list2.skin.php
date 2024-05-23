<?php
if(!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once('apply.confirm.lib.php');

//add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/custom.css">', 0);

$result = "";
$list = $titles = [];
$y = 0;

$c_user = isset($_POST['c_user']) ? html_purifier($_POST['c_user']) : '';
$c_pw = isset($_POST['c_pw']) ? html_purifier($_POST['c_pw']) : '';

$bot_table = str_replace("_result","",$bo_table);

if($c_user <> "" && $c_pw <> "") {
	$result = sql_query("select wr_id,wr_subject,wr_content,wr_password,wr_link2,wr_name,wr_1,wr_2,wr_3,wr_4,wr_5,wr_6,wr_7,wr_8,wr_9,wr_10,wr_last from $write_table where wr_name = '{$c_user}'");
}

?>

<div class="container-fluid">
	<p class="fs-3 fw-bold text-center mb-3">신청확인</p>
<?php if($c_user == "" && !$result) { ?>

	<form name="fboardlist2" id="fboardlist2" action="./board.php?bo_table=<?= $bo_table?>&type=2" method="post">
		<div class="container mb-5">
			<div class="row">
			  <div class="col-md-3 mb-2">
				<input type="text" name="c_user" class="form-control text-center" id="floatingInput" placeholder="신청자성명" aria-label="신청자성명" required>
			  </div>
			  <div class="col-md-3 mb-2">
				<input type="password" name="c_pw" class="form-control text-center" id="floatingPassword" placeholder="비밀번호" aria-label="비밀번호" required>
			  </div>
			  <div class="col-md-2 mb-2 text-center">
				<button type="submit" class="btn btn-primary">신청확인</button>
			  </div>
			</div>
		</div>
	</form>

<?php } else {
 set_session('ss_delete_token', $token = uniqid(time()));
?>
	<h3 class="mb-5 border-bottom pb-2 fw-bold"><i class="bi bi-flower2 text-warning"></i> <?= $board['bo_subject'] ?></h3>

<div class="table-responsive">
	<?php foreach ($result as $field) {

			if (check_password($c_pw, $field["wr_password"])) {
				$y++;
				$x = 5;
				$delete_href = G5_BBS_URL.'/delete.php?bo_table='.$bo_table.'&amp;wr_id='.$field['wr_id'].'&amp;token='.$token.'&amp;page='.$page;

				$openk = select_confirm($bot_table, $field["wr_link2"]);

				$wrk1 = intval($field['wr_1']) - 1;
				$wrk2 = intval($field['wr_2']) - 1;
				if(count($openk[3]) == 1) $wrk1 = 0;

				$p_items = explode("^", $openk[3][$wrk1]);
			?>
     <table class="table mb-4 align-middle table-hover text-center" style="min-width:1200px">
        <thead class="table-light border-top">
			<tr>
				<th style="width: 5rem;">번호</th>
				<th style="width: 5rem;">프로그램명</th>
				<th style="width: 5rem;">신청자</th>
				<?php if($openk[1] > 1) { ?>
				<th style="width: 6rem;">선택1</th>
				<th style="width: 5rem;">선택2</th>
				<?php } ?>
				<th style="width: 5rem;">전화번호</th>
				<th style="width: 5rem;">성별</th>
				<?php
				if(count($openk[8]) > 0) {
				foreach($openk[8] as $key=>$value) {
					$item_array = explode("^",$value);
					$sub_title = $item_array[0]; ?>
				<th style="width: 6rem;"><?= trim($sub_title) ?></th>
				<?php } } ?>
				<th style="width: 10rem;">요청사항</th>
				<th style="width: 5rem;">신청일</th>
				<th style="width: 5rem;">수정</th>
				<th style="width: 5rem;">신청취소</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><?= $y ?></td>
				<td><?= $field['wr_subject'] ?></td>
				<td><?= $field['wr_name'] ?></td>
				<?php if($openk[1] > 1) { ?>
				<td><?= $openk[2][$wrk1] ?></td>
				<td><?= $p_items[$wrk2] ?></td>
				<?php } ?>
				<td><?= $field['wr_3'] ?></td>
				<td><?= $field['wr_4'] ?></td>
				<?php
				if(count($openk[8]) > 0) {
				foreach($openk[8] as $key=>$value) { 	?>
				<td><?= str_replace("|", " ",$field['wr_'.$x]) ?></td>
				<?php
						$x++;
				} } ?>
				<td><?= $field['wr_content'] ?></td>
				<td><?= $field['wr_last'] ?></td>
				<td><a href="./password.php?w=u&bo_table=<?=$bo_table?>&wr_id=<?=$field['wr_id']?>" class="btn btn-outline-success btn-sm px-3">수정</a></td>
				<td><a href="<?= $delete_href ?>" onclick="del(this.href); return false;" class="btn btn-outline-danger btn-sm px-3">취소</a></td>
			</tr>
			<?php if($x == 0) { echo '<tr><td colspan="11" height="100">예약 신청한 자료가 없습니다.</td></tr>'; } ?>
		</tbody>
	</table>
<?php } } ?>

<?php if($x == 0) {  ?>
<div class="text-danger fs-5 p-5 text-center border mb-5"> 신청한 자료가 없습니다. </div>
<?php } ?>

</div>

<p class="text-end mt-3 mb-5"><a href="<?= G5_BBS_URL ?>/board.php?bo_table=<?=$bo_table?>" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> 신청하기</a></p>

<?php } ?>
</div>