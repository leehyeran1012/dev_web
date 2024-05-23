<?php
if(!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_LIB_PATH.'/thumbnail.lib.php');
include_once('apply.confirm.lib.php');
include_once('paging.php');

add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/custom.css">', 0);

$page = isset($_GET["page"])  ? $_GET["page"] : 1;

$boa_table = str_replace("_result","",$write_table);
$bot_table = str_replace("_result","",$bo_table);

$result2 = sql_fetch("select count(*) p_num from $boa_table");
$total_row = $result2["p_num"];

$page_row_num = 6;    // 한 페이지 게시글 수
$page_block_num = 5;    // 한 페이지 블럭 수
$start_num = ($page-1) * $page_row_num;		//시작번호 (page-1)에서 $page_row_num를 곱한다.

$result = sql_query("select wr_id,wr_subject,wr_4,wr_5,wr_8 from $boa_table order by wr_5 limit $start_num, $page_row_num");

?>
<style type="text/css">
	.imgwidth{height:250px}
	.pagination > li {display: inline-block;}
</style>

<div class="container-fluid p-0">

	<div class="d-flex border-bottom my-4">
	  <div class="fs-4 fw-bold flex-grow-1">프로그램 신청</div>
	  <div><a href="./board.php?bo_table=<?=$bo_table?>&type=2" class="btn btn-danger btn-sm">신청확인</a></div>
	</div>

	<p class="fw-normal text-muted mb-5 text-center">참여하고 싶은 프로그램을 클릭하여 신청하세요.</p>

	<div class="row">

	<?php foreach($result as $field) {

			$thumb = get_list_thumbnail($bot_table, $field['wr_id'], 386, 225, false, true);
			$openk = select_confirm($bot_table, $field['wr_id']);
			$wrk5 = explode("|", $field['wr_5']);
			$wrk8 = explode("|", $field['wr_8']);

			if(strlen($thumb['src']) < 3 ) $thumb['src'] = G5_THEME_URL."/img/main/m_bg02.jpg";
	?>

	<div class="col-sm-12 col-md-4 mb-3" data-aos="zoom-in" data-aos-delay="400">
		<?php if($openk[0] == 1) { ?><a href="void(0);" onclick="Swal.fire('지금은 신청 기간이 아닙니다.');return false;" title="접수 대기중입니다.">
		<?php } elseif ($openk[0] == 0) { ?><a href="<?= G5_BBS_URL; ?>/write.php?bo_table=<?=$bo_table?>&g_num=<?=$field['wr_id']?>" title="클릭하여 신청하세요." >
		<?php } elseif ($openk[0] == 2) { ?><a href="void(0);" onclick="Swal.fire('접수가 종료 되었습니다');return false;"  title="접수가 종료 되었습니다.">
		<?php } ?>

		<div class="card h-100 shadow bg-white border-0">
			<div class="img"><img class="card-img-top" src="<?= $thumb['src'] ?>" alt="..." style="height:180px" /></div>
			<div class="card-body p-3">
				<?php if($openk[0] == 1) { ?>
					<div class="badge bg-success bg-gradient rounded-pill mb-3">접수대기</div>
				<?php } elseif ($openk[0] == 0) { ?>
					<div class="badge bg-primary bg-gradient rounded-pill mb-3">신청하기</div>
				<?php } elseif ($openk[0] == 2) { ?>
					<div class="badge bg-secondary bg-gradient rounded-pill mb-3">접수종료</div>
				<?php } ?>

				<h5 class="card-title text-dark mb-3"><?= $field['wr_subject'] ?></h5>
				<p class="card-text text-dark mb-2"><?= $field['wr_4'] ?></p>
				<p class="card-text text-dark">대상 : &nbsp;<?= $wrk8[1] ?><br>장소 : &nbsp;<?= $wrk8[2] ?></p>
			</div>
			<div class="card-footer p-3 bg-light border-top-0">
				<div class="d-flex align-items-end justify-content-between">
					<div class="d-flex align-items-center">
						<img class="rounded-circle me-3" src="<?= $board_skin_url ?>/date1.png" width="40" alt="..." />
						<div class="small">
							<div class="text-dark small">신청기간 : &nbsp; <?= kdate_m_d_w($wrk5[0]) ?>~<?= kdate_m_d_w($wrk5[1]) ?> <?= (substr($wrk5[2],0,2) != "00") ? $wrk5[2] : ""; ?></div>
							<div class="text-dark small">운영기간 : &nbsp;<?= $wrk8[0] ?></div>
						</div>
					</div>
				</div>
			</div>
		</div></a>
	</div>

	<?php } ?>
		</div>
	</div>

	<div class="d-flex justify-content-center mt-3 mb-5">
		<?= paging($bo_table, $total_row, $page_row_num, $page_block_num, $page);  ?>
	</div>


<script>
	AOS.init({
	  duration: 1000
	});
</script>
