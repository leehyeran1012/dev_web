<?php
if(!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once('apply.confirm.lib.php');

add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/custom.css">', 0);

$write_pages = chg_paging($write_pages);
?>
<style type="text/css">
	.imgwidth{height:250px}
</style>
<div class="container">

	<!-- <h2 class="text-center fw-bold mb-5"><?= $board['bo_subject'] ?></h2>
 -->
	<?php
		if($is_category) {
			$category_href = get_pretty_url($bo_table);
	?>

	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link <?php if($sca=='') echo 'active'; ?>" href="<?= $category_href ?>">전체</a>
		</li>
		<?php
			$categories = explode('|', $board['bo_category_list']);
			foreach($categories as $category) {
		?>
		<li class="nav-item">
			<a class="nav-link <?php if($category==$sca) echo 'active'; ?>" href="<?php get_pretty_url($bo_table,'','sca='.urlencode($category)); ?>"><?= $category ?></a>
		</li>
		<?php } ?>
	</ul>
	<?php } ?>

	<form name="fboardlist" id="fboardlist" action="<?= G5_BBS_URL; ?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
	<input type="hidden" name="bo_table" value="<?= $bo_table ?>">
	<input type="hidden" name="sfl" value="<?= $sfl ?>">
	<input type="hidden" name="stx" value="<?= $stx ?>">
	<input type="hidden" name="spt" value="<?= $spt ?>">
	<input type="hidden" name="sca" value="<?= $sca ?>">
	<input type="hidden" name="sst" value="<?= $sst ?>">
	<input type="hidden" name="sod" value="<?= $sod ?>">
	<input type="hidden" name="page" value="<?= $page ?>">
	<input type="hidden" name="sw" value="">

<section class="p-0 py-5" data-aos="fade-up">
	<div class="container p-0 my-5">
		<div class="row gx-5 justify-content-center">
			<div class="col-lg-8 col-xl-6">
				<div class="text-center">
					<h2 class="fw-bolder">프로그램 신청</h2>
					<p class="lead fw-normal text-muted mb-5">신청하세요.</p>
				</div>
			</div>
		</div>

		<div class="row">
	<?php
		for ($i=0; $i<count($list); $i++) {
			$mb_info = get_member_info($list[$i]['mb_id'], $list[$i]['wr_name'], $list[$i]['wr_email'], $list[$i]['wr_homepage']);
			$thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], 386, 225, false, true);
			$openk = select_confirm($bo_table, $list[$i]['wr_id']);
			$wrk5 = explode("|", $list[$i]['wr_5']);
			$wrk8 = explode("|", $list[$i]['wr_8']);

	?>
			<?php if($openk[0] == 1) { ?><a href="void(0);" onclick="Swal.fire('지금은 신청 기간이 아닙니다.');return false;" title="접수 대기중입니다.">
			<?php } elseif ($openk[0] == 0) { ?><a href="<?= G5_BBS_URL; ?>/write.php?bo_table=<?=$bo_table?>_result&g_num=<?=$list[$i]['wr_id']?>" title="클릭하여 신청하세요." >
			<?php } elseif ($openk[0] == 2) { ?><a href="void(0);" onclick="Swal.fire('접수가 종료 되었습니다');return false;"  title="접수가 종료 되었습니다.">
			<?php } ?>
			<div class="col-lg-4 mb-5" data-aos="zoom-in" data-aos-delay="400">
				<div class="card h-100 shadow border-0">
				<div class="img"><img class="card-img-top" src="<?= $thumb['src'] ?>" alt="..." /></div>
				<div class="card-body p-4">
					<?php if($openk[0] == 1) { ?>
						<div class="badge bg-success bg-gradient rounded-pill mb-3">접수대기</div>
					<?php } elseif ($openk[0] == 0) { ?>
						<div class="badge bg-primary bg-gradient rounded-pill mb-3">신청하기</div>
					<?php } elseif ($openk[0] == 2) { ?>
						<div class="badge bg-secondary bg-gradient rounded-pill mb-3">접수종료</div>
					<?php } ?>

					<?php if($write_href) { ?>
					<a class="text-decoration-none link-dark stretched-link" href="<?= $list[$i]['href'] ?>"><h5 class="card-title mb-3"><?= $list[$i]['subject'] ?></h5></a>
					<?php } else { ?>
					<h5 class="card-title mb-3"><?= $list[$i]['subject'] ?></h5>
					<?php } ?>
					<p class="card-text mb-0"><?= $list[$i]['wr_4'] ?>
					<br><br>
					대상 : &nbsp;<?= $wrk8[1] ?><br>
					장소 : &nbsp;<?= $wrk8[2] ?></p>
				</div>
				<div class="card-footer p-4 pt-0 bg-transparent border-top-0">
					<div class="d-flex align-items-end justify-content-between">
						<div class="d-flex align-items-center">
							<img class="rounded-circle me-3" src="https://dummyimage.com/40x40/ced4da/6c757d" alt="..." />
							<div class="small">
								<div class="text-muted">신청기간 : &nbsp;<?= $wrk5[0] ?>~<?= $wrk5[1] ?> <?= $wrk5[2] ?></div>
								<div class="text-muted">운영기간 : &nbsp;<?= $wrk8[0] ?></div>
							</div>
						</div>
					</div>
				</div>
			</div></a>
		</div>
	<?php } ?>
		</div>
	</div>
</section>

	<div class="d-flex justify-content-center justify-content-sm-end mb-4">
		<?= $write_pages;  ?>
	</div>

	<div class="d-flex flex-sm-row flex-column justify-content-sm-between mb-4">
		<div class="d-flex justify-content-center mb-2 mb-sm-0">
			<?php if($is_checkbox) { ?>
			<div class="btn-group xs-100">
				<!-- <button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn btn-danger"><i class="fa fa-trash-o"></i> 삭제</button>
				<button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="btn btn-danger"><i class="fa fa-file"></i> 복사</button>
				<button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class="btn btn-danger"><i class="fa fa-arrows-alt"></i> 이동</button> -->
			</div>
			<?php } ?>
		</div>
		<div class="d-flex justify-content-center">
			<div class="btn-group xs-100">
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#search"><i class="fa fa-search"></i> 검색</button>
				<?php if($list_href) { ?><a href="<?= $list_href ?>" class="btn btn-primary"><i class="fa fa-list" aria-hidden="true"></i> 목록</a><?php } ?>
				<?php if($write_href) { ?><a href="<?= $write_href ?>&m_id=<?=$m_ida?>" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> 글쓰기</a><?php } ?>
				<?php if($admin_href) { ?><a href="<?= $admin_href ?>" class="btn btn-danger"><i class="fa fa-cog" aria-hidden="true"></i> 관리자</a><?php } ?>
			</div>
		</div>
	</div>

	</form>

	<!-- Search Modal -->
	<form name="fsearch" method="get">
	<input type="hidden" name="bo_table" value="<?= $bo_table ?>">
	<input type="hidden" name="sca" value="<?= $sca ?>">
	<input type="hidden" name="sop" value="and">
	<div id="search" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><i class="fa fa-search"></i> 검색어 입력</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="input-group">
						<div class="input-group-text bg-white">
							<select class="form-select bg-transparent border-0" name="sfl" id="sfl">
								<option value="wr_subject"<?= get_selected($sfl, 'wr_subject', true); ?>>제목</option>
								<option value="wr_content"<?= get_selected($sfl, 'wr_content'); ?>>내용</option>
								<option value="wr_subject||wr_content"<?= get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
								<option value="mb_id,1"<?= get_selected($sfl, 'mb_id,1'); ?>>아이디</option>
								<option value="mb_id,0"<?= get_selected($sfl, 'mb_id,0'); ?>>아이디(코)</option>
								<option value="wr_name,1"<?= get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
								<option value="wr_name,0"<?= get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
							</select>
						</div>
						<input type="text" name="stx" value="<?= stripslashes($stx) ?>" required id="stx" class="form-control" size="25" maxlength="20" placeholder="검색어">
					</div>
				</div>
				<div class="modal-footer">
					<div>
						<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> 검색</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	</form>

</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<?php if($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if(f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if(f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if(!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if(!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = g5_bbs_url+"/board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if(sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = g5_bbs_url+"/move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
