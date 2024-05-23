<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post">
<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="spt" value="<?php echo $spt ?>">
<input type="hidden" name="sca" value="<?php echo $sca ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="sw" value="">

<?php

$year = isset($_GET["year"]) ? intval($_GET["year"]) : date("Y");

$sql = " select distinct left(wr_1,4) as wr_1 from {$write_table} order by wr_1 desc ";
$years = sql_query($sql);

?>

<div class="d-flex border-bottom mt-3 mb-5">
	<div class="fs-4 fw-bold flex-grow-1"><?= $board['bo_subject'] ?></div>
	<div>&nbsp;</div>
</div>
<!-- <div class="text-end">
<?php if($is_admin) { ?><a href="<?= $write_href ?>" class="btn btn-primary btn-sm mb-2"><i class="fa fa-pencil" aria-hidden="true"></i> 연혁추가</a><?php } ?>
</div> -->
<div class="container-fluid p-0 border">
	<div class="bg-light pt-3">
		<ul class="nav nav-tabs">
		  <li class="nav-item" style="width:20px">&nbsp;</li>
		<?php foreach($years as $field) { ?>
		  <li class="nav-item"><a class="nav-link fs-5<?= ($year == $field['wr_1']) ? ' active text-primary fw-bold' : ' text-secondary'; ?>" href="<?= G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&year=<?=$field['wr_1']?>"><?=$field['wr_1']?></a></li>
		<?php } ?>
		<?php if($is_admin) { ?><a href="<?= $write_href ?>" class="btn btn-danger btn-sm mt-3 ms-auto me-2"><i class="fa fa-pencil" aria-hidden="true"></i> 등록</a><?php } ?>
		</ul>
	</div>
	<div class="row mt-4">
		<div class="col-md-2 fs-3 fw-bold text-info text-center"><?= $year ?></div>
		<div class="col-md-10">
			<div class="row">
			<?php
				$month1 = "";
				$sql = " select wr_id,wr_subject,wr_content,wr_1 from {$write_table} where left(wr_1, 4) = '".$year."' order by wr_1 ";
				$result = sql_query($sql);
				foreach($result as $key=>$field) {

				$month = date("m", strtotime($field["wr_1"]));
				$day = date("d", strtotime($field["wr_1"]));
				if($month1 ==  $month) $month = "";
			?>
				<div class="col-md-1 fs-4 fw-bold text-info ps-4"><?php if($month <> "") { ?><span class="px-2 py-1 bg-light rounded-circle"><?= $month ?></span><?php } ?></div>
				<div class="col-md-11 pe-3">

					  <a class="btn" data-bs-toggle="collapse" href="#collapseE<?=$key?>" role="button" aria-expanded="false" aria-controls="collapseE<?=$key?>">
						<span class="text-primary fw-bold me-4"><?= $day ?></span><?= $field["wr_subject"] ?>
					  </a>
					<div class="collapse" id="collapseE<?=$key?>">
					  <div class="card card-body overflow-hidden">
						<?= $field["wr_content"] ?>
						  <?php if ($is_admin) { ?>
						  <a href="<?= G5_BBS_URL ?>/write.php?w=u&bo_table=<?=$bo_table?>&wr_id=<?=$field["wr_id"]?>&page=" class="btn btn-danger btn-sm mt-3 ms-auto" style="width:30px" title="수정"><i class="fa fa-pencil-square-o"></i></a>
						  <?php } ?>
					  </div>
					</div>

					<!-- <div class="accordion accordion-flush" id="accordionFlush<?=$key?>">
						<div class="accordion-item">
							<h2 class="accordion-header"><button class="accordion-button py-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#his<?=$key?>" aria-expanded="false" aria-controls="his<?=$key?>"><span class="text-primary fw-bold me-4"><?= $day ?></span> <?= $field["wr_subject"] ?></button></h2>
							<div id="his<?=$key?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlush<?=$key?>">
								<div class="accordion-body border rounded overflow-hidden"><?= $field["wr_content"] ?><?php if ($is_admin) { ?><a href="<?= G5_BBS_URL ?>/write.php?w=u&bo_table=<?=$bo_table?>&wr_id=<?=$field["wr_id"]?>&page=" class="btn btn-danger btn-sm mt-3"><i class="fa fa-pencil-square-o"></i> 수정</a><?php } ?></div>
							</div>
						</div>
					</div> -->
				</div><!-- <div class="col-md-11"> -->
			<?php
				if($month ==  "") {
					$month1 = $month1;
				} else {
					$month1 = $month;
				}
			}
			?>
			</div><!-- <div class="row"> -->
		</div><!-- <div class="col-md-10"> -->
	</div><br><!-- <div class="row border"> -->
</div>
<div class="py-3">&nbsp;</div>
</form>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
