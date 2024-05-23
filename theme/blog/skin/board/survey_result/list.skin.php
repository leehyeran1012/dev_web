<?php
if(!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
 add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/custom.css">', 0);

	$boa_table = str_replace("_result","",$write_table);
	$bot_table = str_replace("_result","",$bo_table);

	$today = date("Y-m-d");
	$mid = get_text($member['mb_id']);

	$tabid = isset($_GET["tabid"]) ? $_GET["tabid"] : 1;
	$page_rows = 3;	// 보여줄 게시글 수
	if ($page < 1) $page = 1; // 페이지가 없으면 1 페이지
	$from_record = ($page - 1) * $page_rows; // 시작 열을 구함

	if($tabid == 1) {	//진행중인 투표
		$sql = "select count(*) as cnt  from $boa_table where wr_3 >= '{$today}'";
		$tcount = sql_fetch($sql);
		$sql = "select wr_id,wr_subject, wr_2,wr_3,wr_5,wr_7 from $boa_table where wr_3 >= '{$today}' order by wr_3  limit {$from_record}, {$page_rows}";
		$result = sql_query($sql);
	} else {	//종료된 투표
		$sql = "select count(*) as cnt  from $boa_table where wr_3 < '{$today}'";
		$tcount = sql_fetch($sql);
		$sql = "select wr_id,wr_subject, wr_2,wr_3,wr_5,wr_7 from $boa_table where wr_3 < '{$today}' order by wr_3  limit {$from_record}, {$page_rows}";
		$result = sql_query($sql);
	}

	$total_count = $tcount["cnt"];	//총 레코드 수
	$total_page  = ceil($total_count / $page_rows);  // 전체 페이지 계산

	$write_pages = get_paging($page_rows, $page, $total_page, get_pretty_url($bo_table, '', $qstr.'&amp;tabid=1&amp;page='));

	//$write_pages = chg_paging($write_pages);	// 부트스트랩테마 사용시

	if($page == 1) {
		$c_num = $total_count;
	} else {
		$c_num = $total_count - ($page_rows * ($page-1));
	}

	$x = 0;
?>

<div class="container-fluid p-0 mb-5">

	<div class="d-flex border-bottom mt-3 mb-5">
		<div class="fs-4 fw-bold flex-grow-1">설문조사</div>
		<div>&nbsp;</div>
	</div>

	<div class="btn-group">
	  <a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&tabid=1&page=1" class="btn rounded-0 <?= ($tabid==1) ? "btn-success" : "btn-outline-secondary border-secondary-subtle"; ?>">진행중인 설문</a>
	  <a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bo_table?>&tabid=2&page=1" class="btn rounded-0 <?= ($tabid==2) ? "btn-success" : "btn-outline-secondary border-secondary-subtle"; ?>">종료된 설문</a>
	</div>

  <div class="container border">
	<table class="table mb-4 align-middle table-hover text-center">
		<thead>
			<tr>
				<th class="d-none d-xl-table-cell" style="width: 4rem;">번호</th>
				<th>설문제목</th>
				<th class="d-none d-xl-table-cell" style="width: 12rem;">설문기간</th>
				<th class="d-none d-xl-table-cell" style="width: 6rem;">설문참여</th>
			<?php if ($is_admin) {  ?>
				<th class="d-none d-xl-table-cell" style="width: 6rem;">결과보기</th>
				<th class="d-none d-xl-table-cell" style="width: 6rem;">상세보기</th>
			<?php } ?>
			</tr>
		</thead>
		<tbody>
	<?php foreach($result as $field) {

			$xx = $c_num-$x;

			if($tabid == 1) {
				if($field['wr_7'] == "0") {
					$btntitle = "참여하기";
					$btncolor = "success";
				} else {
					$btntitle = "신청하기";
					$btncolor = "primary";
				}

				//회원 참여 확인
				$rt = sql_fetch("select * from {$write_table} where wr_link2 = '{$field['wr_id']}' and mb_id = '{$mid}'");
				if($rt) {
					$btntitle = "참여함";
					$btncolor = "warning";
				} else {
					$btntitle = $btntitle;
				}
			}

			if($field['wr_5'] == 1) {
				$tp = 3;
			} else {
				$tp = 2;
			}

			$pconunt = sql_fetch("select count(*) pcount from {$write_table} where wr_link2 = '{$field['wr_id']}'");
		?>
			<tr>
				<td class="d-none d-xl-table-cell"><?= $xx ?></td>
				<td class="text-start text-dark-emphasis">
					<a href="<?=G5_BBS_URL?>/write.php?bo_table=<?=$bo_table?>&k_num=<?=$field['wr_id']?>" class="text-dark-emphasis" target="_blank"><?= $field['wr_subject'] ?></a>
					<ul class="list-inline text-muted small pt-2 d-block d-xl-none">
						<li class="list-inline-item">설문기간 : <?= substr($field['wr_2'],2) ?>~<?= substr($field['wr_3'],2) ?></li>
					</ul>
					<ul class="list-inline text-muted small pt-2 d-block d-xl-none">
						<li class="list-inline-item">
					<?php if($tabid == 1) { ?>
						<a href="<?=G5_BBS_URL?>/write.php?bo_table=<?=$bo_table?>&k_num=<?=$field['wr_id']?>" class="btn btn-<?=$btncolor?> btn-sm" target="_blank"><?=$btntitle?></a>
					<?php } else { ?>
						종료됨
					<?php } ?>
						</li>
					</ul>
				</td>
				<td class="d-none d-xl-table-cell small"><?= substr($field['wr_2'],2) ?>~<?= substr($field['wr_3'],2) ?></td>
				<td class="d-none d-xl-table-cell">
				<?php if($tabid == 1) { ?>
					<a href="<?=G5_BBS_URL?>/write.php?bo_table=<?=$bo_table?>&k_num=<?=$field['wr_id']?>" class="btn btn-<?=$btncolor?> btn-sm" target="_blank"><?=$btntitle?></a>
				<?php } else { ?>
					종료됨
				<?php } ?>
				</td>
			<?php if ($is_admin) {  ?>
				<td class="d-none d-xl-table-cell"><a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bot_table?>&wr_id=<?=$field['wr_id']?>&type=<?=$tp?>" class="btn btn-success btn-sm" target="_blank">보기(<?=$pconunt["pcount"]?>)</a></td>
				<td class="d-none d-xl-table-cell"><a href="<?=G5_BBS_URL?>/board.php?bo_table=<?=$bot_table?>&wr_id=<?=$field['wr_id']?>&type=9" class="btn btn-primary btn-sm px-3" target="_blank">보기</a></td>
			<?php } ?>
			</tr>
		<?php
				$x++;
			}

			if ($x == 0) {
				echo '<tr><td colspan="4" class="py-5">진행중인 투표가 없습니다.</td></tr>';
			}
		?>
		</tbody>
	</table>
	<div class="d-flex justify-content-end mb-2 pe-3"><?= $write_pages ?></div>
  </div>

</div>