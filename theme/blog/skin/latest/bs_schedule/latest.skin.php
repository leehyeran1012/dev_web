<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);

$bo_table = isset($_GET['bo_table']) ? $_GET['bo_table'] : '';
$today = date("Y-m-d");
$list = [];

$bo_table = $g5['write_prefix'] . $bo_table;
$bo_table2 = $g5['write_prefix'] . "sangdam_result";

$result = sql_query("select wr_id,wr_subject,wr_1,wr_2,wr_3,wr_4 from {$bo_table} where left(wr_1,10) = '{$today}' order by wr_1,wr_subject");

for ($i=0; $row = sql_fetch_array($result); $i++) {
	$list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
}

$result = sql_query("select wr_id,wr_name,wr_1,wr_2,wr_3,wr_4 from {$bo_table2} where left(wr_1,10) = '{$today}' order by wr_1, wr_2");

for ($i=0; $row = sql_fetch_array($result); $i++) {
	$list[$i] = get_list($row, $board, $latest_skin_url, $subject_len);
}

$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

    <?php for ($i=0; $i<$list_count; $i++) {  ?>

		<li>
			<a href="<?= get_pretty_url($bo_table, $list[$i]['wr_id']) ?>">
				<p class="stxt"><span>★ <?= $list[$i]['subject'] ?></p>
			</a>
		</li>

    <?php }  ?>
    <?php if ($list_count == 0) { //게시물이 없을 때  ?>
		<li>
			<p class="stxt"><br>게시물이 없습니다.</p>
		<li>
    <?php }  ?>

