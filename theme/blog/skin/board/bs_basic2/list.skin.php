<?php
if(!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if($is_checkbox) $colspan++;
if($is_good) $colspan++;
if($is_nogood) $colspan++;

add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/custom.css">', 0);

$write_pages = chg_paging($write_pages);
?>

<div class="container">

	<div class="border rounded py-2 ps-4 bg-light mb-2"><h2 class="fs-5 fw-bold"><?= $board['bo_subject'] ?></h2></div>

	<?php if($is_category) {
		$category_href = get_pretty_url($bo_table);
	?>
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link <?php if($sca=='') echo 'active'; ?> text-dark" href="<?= $category_href ?>">전체</a>
		</li>
		<?php
			$categories = explode('|', $board['bo_category_list']);
			foreach($categories as $category) {
		?>
		<li class="nav-item">
			<a class="nav-link <?php if($category==$sca) echo 'active'; ?> text-dark" href="<?= get_pretty_url($bo_table,'','sca='.urlencode($category)); ?>"><?= $category ?></a>
		</li>
		<?php } ?>
	</ul>
	<?php } ?>

	<form name="fboardlist" id="fboardlist" action="<?= G5_BBS_URL ?>/board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
	<input type="hidden" name="bo_table" value="<?= $bo_table ?>">
	<input type="hidden" name="sfl" value="<?= $sfl ?>">
	<input type="hidden" name="stx" value="<?= $stx ?>">
	<input type="hidden" name="spt" value="<?= $spt ?>">
	<input type="hidden" name="sca" value="<?= $sca ?>">
	<input type="hidden" name="sst" value="<?= $sst ?>">
	<input type="hidden" name="sod" value="<?= $sod ?>">
	<input type="hidden" name="page" value="<?= $page ?>">
	<input type="hidden" name="sw" value="">

	<table class="table align-middle xs-full mb-4 text-center">
		<thead>
			<tr class="d-none d-md-table-row bg-light border-top">
				<?php if($is_checkbox) { ?>
				<th style="width: 3rem;">
					<input type="checkbox" id="chkall" onclick="if(this.checked) all_checked(true); else all_checked(false);" class="form-check-input">
				</th>
				<?php } ?>
				<th class="d-none d-md-table-cell" style="width: 6rem;">번호</th>
				<th>제목</th>
				<th class="d-none d-md-table-cell" style="width: 11rem;">글쓴이</th>
				<th class="d-none d-md-table-cell" style="width: 4rem;">조회</th>
				<?php if($is_good) { ?><th class="d-none d-md-table-cell" style="width: 4rem;">추천</th><?php } ?>
				<?php if($is_nogood) { ?><th class="d-none d-md-table-cell" style="width: 4rem;">비추</th><?php } ?>
				<th class="d-none d-md-table-cell" style="width: 6rem;">날짜</th>
			</tr>
		</thead>
		<tbody>
			<?php for ($i=0; $i<count($list); $i++) {
				$mb_info = get_member_info($list[$i]['mb_id'], $list[$i]['wr_name'], $list[$i]['wr_email'], $list[$i]['wr_homepage']);
			?>
			<tr class="<?php if($list[$i]['is_notice']) echo "table-primary"; ?>">
				<?php if($is_checkbox) { ?>
				<td class="d-none d-md-table-cell">
					<input type="checkbox" name="chk_wr_id[]" value="<?= $list[$i]['wr_id'] ?>" id="chk_wr_id_<?= $i ?>" class="form-check-input">
				</td>
				<?php } ?>
				<td class="d-none d-md-table-cell">
					<?php if($list[$i]['is_notice']) { ?>
					<i class="fa fa-bullhorn"></i>
					<?php } else if($wr_id == $list[$i]['wr_id']) { ?>
					<span class="text-danger">열람</span>
					<?php } else { ?>
					<?= $list[$i]['num'] ?>
					<?php } ?>
				</td>
				<td class="text-truncate text-start py-3">
					<?php if($is_category && $list[$i]['ca_name']) { ?>
					<a href="<?= $list[$i]['ca_name_href'] ?>" class="badge bg-primary"><?= $list[$i]['ca_name'] ?></a>
					<?php } ?>
					<?php if($list[$i]['wr_reply']) { ?>
					<span class="d-none d-md-inline">
						<?php for($j=1; $j<strlen($list[$i]['wr_reply']); $j++) echo '&nbsp;'; ?>
					</span>
					<?php } ?>
					<?= $list[$i]['icon_reply'] ?>
					<?php if(isset($list[$i]['icon_secret'])) echo rtrim($list[$i]['icon_secret']); ?>
					<a href="<?= $list[$i]['href'] ?>" class="text-dark"><?= $list[$i]['subject'] ?></a>
					<?php if($list[$i]['comment_cnt']) { ?>
					<span class="d-none d-md-inline-block badge bg-secondary"><?= $list[$i]['wr_comment']; ?></span>
					<?php } ?>
					<?php
					if($list[$i]['icon_new']) echo ' <span class="badge bg-danger"><i class="fa fa-bell"></i></span>';
			//		if(isset($list[$i]['icon_hot'])) echo ' <span class="badge bg-danger"><i class="fa fa-fire"></i></span>';
			//		if(isset($list[$i]['icon_file'])) echo ' <small class="text-muted"><i class="fa fa-download"></i></small>';
			//		if(isset($list[$i]['icon_link'])) echo ' <small class="text-muted"><i class="fa fa-link"></i></small>';
					?>
					<!-- 모바일 -->
					<ul class="list-inline small text-muted mt-1 mb-0 d-md-none">
						<li class="list-inline-item">
							<img class="list-icon rounded" src="<?= $mb_info['img'] ?>">
							<div class="dropdown d-inline">
								<a href="#" data-bs-toggle="dropdown" class="text-dark"><?= get_text($list[$i]['wr_name']); ?></a>
								<?= $mb_info['menu'] ?>
							</div>
						</li>
						<li class="list-inline-item"><i class="fa fa-eye"></i> <?= number_format($list[$i]['wr_hit']) ?></li>
						<li class="list-inline-item"><i class="fa fa-commenting-o"></i> <?= number_format($list[$i]['wr_comment']) ?></li>
						<?php if($list[$i]['wr_good']>0) { ?><li class="list-inline-item text-primary"><i class="fa fa-thumbs-up"></i> <?= $list[$i]['wr_good'] ?></li><?php } ?>
						<?php if($list[$i]['wr_nogood']>0) { ?><li class="list-inline-item text-secondary"><i class="fa fa-thumbs-down"></i> <?= $list[$i]['wr_nogood'] ?></li><?php } ?>
						<li class="list-inline-item float-end"><i class="fa fa-clock-o"></i> <?= $list[$i]['datetime2'] ?></li>
					</ul>
				</td>
				<td class="d-none d-md-table-cell">
					<img class="list-icon rounded" src="<?= $mb_info['img'] ?>">
					<div class="dropdown d-inline">
						<a href="#" data-bs-toggle="dropdown" class="text-dark"><?= get_text($list[$i]['wr_name']); ?></a>
						<?= $mb_info['menu'] ?>
					</div>
				</td>
				<td class="d-none d-md-table-cell"><?= number_format($list[$i]['wr_hit']) ?></td>
				<?php if($is_good) { ?><td class="d-none d-md-table-cell"><?= $list[$i]['wr_good'] ?></td><?php } ?>
				<?php if($is_nogood) { ?><td class="d-none d-md-table-cell"><?= $list[$i]['wr_nogood'] ?></td><?php } ?>
				<td class="d-none d-md-table-cell"><?= $list[$i]['datetime2'] ?></td>
			</tr>
			<?php } ?>
			<?php if(count($list) == 0) { echo '<tr><td colspan="'.$colspan.'">게시물이 없습니다.</td></tr>'; } ?>
		</tbody>
	</table>
<style type="text/css">
	.dropend:hover .dropdown-menu {display: block; margin-top: 0;}
</style>
	<?php if($write_pages) { ?>
	<div class="d-flex justify-content-between mb-4">
		<div>
			<div class="btn-group dropend">
			  <button type="button" class="btn btn-danger" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-gear"></i></button>
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
	<?php } ?>

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
								<option value="wr_name||wr_3"<?= get_selected($sfl, 'wr_name||wr_3'); ?>>이름+전화번호</option>
								<option value="wr_subject"<?= get_selected($sfl, 'wr_subject', true); ?>>제목</option>
								<option value="wr_content"<?= get_selected($sfl, 'wr_content'); ?>>내용</option>
								<option value="wr_subject||wr_content"<?= get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
								<option value="mb_id,1"<?= get_selected($sfl, 'mb_id,1'); ?>>아이디</option>
								<option value="wr_name,1"<?= get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
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
