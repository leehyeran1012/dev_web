<?php
if(!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once('apply.confirm.lib.php');

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if($is_checkbox) $colspan++;
if($is_good) $colspan++;
if($is_nogood) $colspan++;

add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/custom.css">', 0);

$write_pages = chg_paging($write_pages);
$bot_table = str_replace("_result","",$bo_table);

?>

<div class="container-fluid">

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

     <table class="table mb-4 align-middle table-hover text-center">
        <thead class="table-light border-top">
			<tr>
				<th style="width: 3rem;"><input type="checkbox" id="chkall" onclick="if(this.checked) all_checked(true); else all_checked(false);" class="form-check-input"></th>
				<th class="d-none d-xl-table-cell" style="width: 6rem;">번호</th>
				<th>프로그램명</th>
				<th class="d-none d-xl-table-cell" style="width: 10rem;">신청기간</th>
				<th class="d-none d-xl-table-cell" style="width: 8rem;">설정수정</th>
				<th class="d-none d-xl-table-cell" style="width: 8rem;">결과보기</th>
				<th class="d-none d-xl-table-cell" style="width: 8rem;">신청결과</th>
			</tr>
		</thead>
		<tbody>
			<?php for ($i=0; $i<count($list); $i++) {

				$pconunt = sql_fetch("select count(*) pcount from {$write_table}_result where wr_link2 = '{$list[$i]['wr_id']}'");
				$gigan = explode("|", $list[$i]['wr_5']);

			?>
			<tr class="<?php if($list[$i]['is_notice']) echo "table-primary"; ?>">
				<td><input type="checkbox" name="chk_wr_id[]" value="<?= $list[$i]['wr_id'] ?>" id="chk_wr_id_<?= $i ?>" class="form-check-input"></td>
				<td class="d-none d-xl-table-cell"><?= $list[$i]['num'] ?></td>
				<td class="text-start"><a href="./write.php?w=u&bo_table=<?=$bo_table?>&wr_id=<?= $list[$i]['wr_id'] ?>" class="text-dark"><?= $list[$i]['subject'] ?></a>
 					<ul class="list-inline text-muted small pt-2 d-block d-xl-none">
						<li class="list-inline-item">신청기간: <?= date("n. j", strtotime($gigan[0])) ?> ~ <?= date("n. j", strtotime($gigan[1])) ?></li>
					</ul>
 					<ul class="list-inline text-muted small pt-2 pb-2 d-block d-xl-none">
						<li class="list-inline-item"><a href="./write.php?w=u&bo_table=<?=$bo_table?>&wr_id=<?= $list[$i]['wr_id'] ?>" class="btn btn-outline-success btn-sm">수정하기</a></li>
						<li class="list-inline-item"><a href="./board.php?bo_table=<?=$bot_table?>&wr_id=<?= $list[$i]['wr_id'] ?>&type=9" class="btn btn-outline-primary btn-sm<?= ($pconunt["pcount"] == 0) ? " disabled" : ""; ?>">결과보기(<?=$pconunt["pcount"]?>)</a></li>
						<li class="list-inline-item"><a href="<?= $board_skin_url?>/excel_view.php?bo_table=<?=$bo_table?>&g_num=<?=$list[$i]['wr_id']?>" class="btn btn-outline-success btn-sm">엑셀다운</a></li>
					</ul>
				</td>
				<td class="d-none d-xl-table-cell"><?= date("n. j", strtotime($gigan[0])) ?> ~ <?= date("n. j", strtotime($gigan[1])) ?></td>
				<td class="d-none d-xl-table-cell"><a href="./write.php?w=u&bo_table=<?=$bo_table?>&wr_id=<?= $list[$i]['wr_id'] ?>" class="btn btn-outline-success btn-sm">수정하기</a></td>
				<td class="d-none d-xl-table-cell"><a href="./board.php?bo_table=<?=$bot_table?>&wr_id=<?= $list[$i]['wr_id'] ?>&type=9" class="btn btn-outline-primary btn-sm<?= ($pconunt["pcount"] == 0) ? " disabled" : ""; ?>">결과보기(<?=$pconunt["pcount"]?>)</a></td>
				<td class="d-none d-xl-table-cell"><a href="<?= $board_skin_url?>/excel_view.php?bo_table=<?=$bo_table?>&g_num=<?=$list[$i]['wr_id']?>" class="btn btn-outline-success btn-sm">엑셀다운</a></td>
			</tr>
			<?php } ?>
			<?php if(count($list) == 0) { echo '<tr><td colspan="'.$colspan.'">게시물이 없습니다.</td></tr>'; } ?>
		</tbody>
	</table>

	<div class="d-flex justify-content-center justify-content-sm-end mb-4">
		<?= $write_pages;  ?>
	</div>

	<div class="d-flex flex-sm-row flex-column justify-content-sm-between mb-4">
		<div class="d-flex justify-content-center mb-2 mb-sm-0">
			<?php if($is_checkbox) { ?>
			<div class="btn-group xs-100">
				<button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn btn-danger"><i class="fa fa-trash-o"></i> 삭제</button>
				<button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="btn btn-success"><i class="fa fa-file"></i> 복사</button>
			</div>
			<?php } ?>
		</div>
		<div class="d-flex justify-content-center">
			<div class="btn-group xs-100">
				<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#search"><i class="fa fa-search"></i> 검색</button>
				<?php if($write_href) { ?><a href="<?= $write_href ?>" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> 등록하기</a><?php } ?>
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
