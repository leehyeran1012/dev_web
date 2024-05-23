<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (!$is_admin) alert("접근권한이 없습니다.", G5_URL);

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_ADMIN_PATH.'/functions.php');

if($admin_table_use) {
	$top_path = "/admin_head_menu2.php";
	$left_path = "/admin_left_menu2.php";
} else {
	$top_path = "/admin_head_menu.php";
	$left_path = "/admin_left_menu.php";
}

?>

<!-- 콘텐츠 시작 -->
<header id="header" class="header fixed-top d-flex align-items-center">
	<?php include_once(G5_ADMIN_PATH . $top_path); ?>
</header>
<aside id="sidebar" class="sidebar">
	<?php include_once(G5_ADMIN_PATH . $left_path); ?>
</aside>
<?php
// 접속자 집계(오늘)
$sql = " select vs_count as cnt from {$g5['visit_sum_table']} where vs_date = '".G5_TIME_YMD."' ";
$row = sql_fetch($sql);
$vi_today = isset($row['cnt']) ? $row['cnt'] : 0;

// 접속자 집계(전체)
$sql = " select sum(vs_count) as total from {$g5['visit_sum_table']} ";
$row = sql_fetch($sql);
$vi_sum = isset($row['total']) ? $row['total'] : 0;
?>
<main id="main" class="main pt-3">
	<p class="text-end mb-3 pe-2">오늘방문자 : <?php echo number_format($vi_today) ?> &nbsp;&nbsp;전체방문자 : <?php echo number_format($vi_sum) ?></p>
	<div class="card">
    <?php if (!defined("_INDEX_")) { ?>
	 <div class="border-bottom ps-4 py-3 mb-2">
    	<h2 class="fs-4 fw-bold ms-3 top" title="<?php echo get_text($g5['title']); ?>">
    		<a href="javascript:history.back();"><i class="bi bi-reply-fill" aria-hidden="true"></i><span class="sound_only">뒤로가기</span></a> <?php echo get_head_title($g5['title']); ?>
    	</h2>
		</div>
    <?php } ?>
		<div class="card-body pt-4">