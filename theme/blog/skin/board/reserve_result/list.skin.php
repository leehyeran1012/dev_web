<?php
if(!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/custom.css">', 0);

$result = "";
$list = $titles = [];
$y = 0;

$c_user = isset($_POST['c_user']) ? html_purifier($_POST['c_user']) : '';
$c_pw = isset($_POST['c_pw']) ? html_purifier($_POST['c_pw']) : '';

$boa_table = str_replace("_result","",$write_table);
$tomon = date("Y-m");
$que1 = sql_fetch("select wr_id, wr_4 from {$boa_table} where wr_1 = '{$tomon}'");
$titles2 = str_replace("\r\n","",$que1['wr_4']);

if(strlen($titles2) > 3) $titles = explode("|",$titles2);

if($c_user <> "" && $c_pw <> "") {
	$result = sql_query("select wr_id,wr_subject,wr_content,wr_password,wr_name,wr_1,wr_2,wr_3,wr_4,wr_5,wr_6,wr_7,wr_8,wr_9,wr_10,wr_last from $write_table where wr_name = '{$c_user}'");
}

?>

<div class="container-fluid">

<?php if($c_user == "" && !$result) { ?>

	<div class="container mb-5">
		<div class="row">
			<div class="col-sm-12 col-md-4 mx-auto">
			<div class="card shadow">
			  <div class="card-body px-md-5">
				<form name="fboardlist2" id="fboardlist2" action="./board.php?bo_table=<?= $bo_table?>" method="post">
					<p class="fs-3 fw-bold py-3 text-center">예약확인</p>
					<div class="form-floating mb-3">
					  <input type="text" name="c_user" class="form-control text-center" id="floatingInput" placeholder="예약자성명" aria-label="예약자성명" required>
					  <label for="floatingInput">예약자성명</label>
					</div>
					<div class="form-floating mb-3">
					  <input type="password" name="c_pw" class="form-control text-center" id="floatingPassword" placeholder="비밀번호" aria-label="비밀번호" required>
					  <label for="floatingPassword">비밀번호</label>
					</div>
					<div class="mb-3 mt-4 text-center">
					 <button type="submit" class="btn btn-primary px-5">예약확인</button>
					</div>
				</form>
			</div>
			</div>
		</div>
		</div>
	</div>

<?php } else {
 set_session('ss_delete_token', $token = uniqid(time()));
?>
	<h3 class="mb-5 border-bottom pb-2 fw-bold"><i class="bi bi-flower2 text-warning"></i> <?= $board['bo_subject'] ?></h3>

<div class="table-responsive">
     <table class="table mb-4 align-middle table-hover text-center" style="min-width:1200px">
        <thead class="table-light border-top">
			<tr>
				<th style="width: 5rem;">번호</th>
				<th style="width: 5rem;">예약자</th>
				<th style="width: 6rem;">예약일자</th>
				<th style="width: 5rem;">예약시간</th>
				<th style="width: 5rem;">전화번호</th>
				<th style="width: 5rem;">성별</th>
				<?php
				if(count($titles) > 0) {
				foreach($titles as $key=>$value) {
					$item_array = explode("^",$value);
					$sub_title = $item_array[0]; ?>
				<th style="width: 6rem;"><?= trim($sub_title) ?></th>
				<?php } } ?>
				<th style="width: 10rem;">요청사항</th>
				<th style="width: 5rem;">신청일</th>
				<th style="width: 5rem;">수정</th>
				<th style="width: 5rem;">예약취소</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($result as $field) {

			if (check_password($c_pw, $field["wr_password"])) {
				$y++;
				$x = 5;
				$delete_href = G5_BBS_URL.'/delete.php?bo_table='.$bo_table.'&amp;wr_id='.$field['wr_id'].'&amp;token='.$token.'&amp;page='.$page;
			?>
			<tr>
				<td><?= $y ?></td>
				<td><?= $field['wr_name'] ?></td>
				<td><?= $field['wr_1'] ?></td>
				<td><?= $field['wr_2'] ?></td>
				<td><?= $field['wr_3'] ?></td>
				<td><?= $field['wr_4'] ?></td>
				<?php
				if(count($titles) > 0) {
				foreach($titles as $key=>$value) { 	?>
				<td><?= str_replace("|", " ",$field['wr_'.$x]) ?></td>
				<?php
						$x++;
				} } ?>
				<td><?= $field['wr_content'] ?></td>
				<td><?= $field['wr_last'] ?></td>
				<td><a href="./password.php?w=u&bo_table=<?=$bo_table?>&wr_id=<?=$field['wr_id']?>" class="btn btn-outline-success btn-sm px-3">수정</a></td>
				<td><a href="<?= $delete_href ?>" onclick="del(this.href); return false;" class="btn btn-outline-danger btn-sm px-3">취소</a></td>
			</tr>
			<?php } } ?>
			<?php if($x == 0) { echo '<tr><td colspan="11" height="100">예약 신청한 자료가 없습니다.</td></tr>'; } ?>
		</tbody>
	</table>
</div>

<p class="text-end mb-5"><?php if($write_href) { ?><a href="<?= $write_href ?>" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> 예약신청</a><?php } ?></p>

<?php } ?>
</div>