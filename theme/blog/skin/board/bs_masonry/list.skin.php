<?php
if(!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/custom.css">', 0);

$write_pages = chg_paging($write_pages);
?>

<div class="container p-0">

	<div class="d-flex border-bottom mt-3 mb-5">
	  <div class="fs-4 fw-bold flex-grow-1"><?= $board['bo_subject'] ?></div>
	  <div>&nbsp;</div>
	</div>

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
			<a class="nav-link <?php if($category==$sca) echo 'active'; ?>" href="<?= get_pretty_url($bo_table,'','sca='.urlencode($category)); ?>"><?= $category ?></a>
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

	<div class="row">
	<?php
		for ($i=0; $i<count($list); $i++) {
			$mb_info = get_member_info($list[$i]['mb_id'], $list[$i]['wr_name'], $list[$i]['wr_email'], $list[$i]['wr_homepage']);
			$thumb = get_list_thumbnail($board['bo_table'], $list[$i]['wr_id'], 320, 240, false, true);

			if($thumb['src']) {
				$img = $thumb['src'];
			} else {
				$img = getFirstImage($list[$i]['wr_content']);
			}

			if(strlen($img) < 3) $img = G5_IMG_URL.'/no_img.png';

	?>
		<div class="col-md-6 col-lg-4 mb-4">
			<div class="card">
				<div class="corner-card">
					<?php if($list[$i]['icon_new']) { ?>
					<div class="corner-ribbon shadow">NEW</div>
					<?php } ?>
					<a href="<?= $list[$i]['href'] ?>" class="w-100"><img src="<?= $img ?>" class="card-img-top"></a>
				</div>
				<div class="card-body">
					<div class="card-title text-truncate py-2">
						<?php if($is_checkbox) { ?>
						<input type="checkbox" name="chk_wr_id[]" value="<?= $list[$i]['wr_id'] ?>" id="chk_wr_id_<?= $i ?>" class="form-check-input">
						<?php } ?>
						<a href="<?= $list[$i]['href'] ?>" class="text-dark"><?= $list[$i]['subject'] ?></a>
					</div>
					<div class="d-flex justify-content-between">
						<small class="text-muted">
							<img class="list-icon rounded" src="<?= $mb_info['img'] ?>">
							<div class="dropdown d-inline">
								<a href="#" data-bs-toggle="dropdown" class="text-dark"><?= get_text($list[$i]['wr_name']); ?></a>
								<?= $mb_info['menu'] ?>
							</div>
						</small>
						<small class="text-muted text-right">
							<i class="fa fa-clock-o"></i> <?= $list[$i]['datetime2'] ?>
							<i class="fa fa-eye pl-1"></i> <?= number_format($list[$i]['wr_hit']) ?>
							<i class="fa fa-commenting-o pl-1"></i> <?= number_format($list[$i]['wr_comment']) ?>
						</small>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	</div>

	<div class="d-flex justify-content-between mb-4">
		<div>
			<div class="btn-group dropend">
			  <button type="button" class="btn btn-danger rounded" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-gear"></i></button>
			  <ul class="dropdown-menu" style="min-width:60px">
				<?php if($is_checkbox) { ?>
					<li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="dropdown-item"><i class="fa fa-trash-o"></i> 삭제</button></li>
					<li><button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="dropdown-item"><i class="fa fa-file"></i> 복사</button></li>
					<li><button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class="dropdown-item"><i class="fa fa-arrows-alt"></i> 이동</button></li>
					<?php } ?>
					<li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#search"><i class="fa fa-search"></i> 검색</button></li>
					<?php if($list_href) { ?><li><a href="<?= $list_href ?>" class="dropdown-item"><i class="fa fa-list" aria-hidden="true"></i> 목록</a></li><?php } ?>
					<?php if($write_href) { ?><li><a href="<?= $write_href ?>" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i> 글쓰기</a></li><?php } ?>
			  </ul>
			</div>
		</div>
		<div><?= $write_pages;  ?></div>
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
