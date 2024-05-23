<?php
if (!defined('_GNUBOARD_')) exit;

$g5_debug['php']['begin_time'] = $begin_time = get_microtime();

//왼쪽메뉴, 상단메뉴 테이블 생성 여부- 미사용시 false 로 설정
$admin_table_use = true;

require_once(G5_ADMIN_PATH . '/admin.head.sub.php');
include_once(G5_ADMIN_PATH.'/functions.php');

if($admin_table_use) {
	//왼쪽메뉴, 상단메뉴 테이블 생성파일--- 관리자메뉴 한번 실행 후 주석처리하세요.
	//require_once G5_ADMIN_PATH . '/menu_table_make.php';

	$top_path = "/admin_head_menu2.php";
	$left_path = "/admin_left_menu2.php";
} else {
	$top_path = "/admin_head_menu.php";
	$left_path = "/admin_left_menu.php";
}

?>

<script>
    var g5_admin_csrf_token_key = "<?php echo (function_exists('admin_csrf_token_key')) ? admin_csrf_token_key() : ''; ?>";
    var tempX = 0;
    var tempY = 0;

    function imageview(id, w, h) {
        menu(id);
        var el_id = document.getElementById(id);
        submenu = el_id.style;
        submenu.left = tempX - (w + 11);
        submenu.top = tempY - (h / 2);
        selectBoxVisible();
        if (el_id.style.display != 'none')
            selectBoxHidden(id);
    }
</script>

<!-- 콘텐츠 시작 -->
<header id="header" class="header fixed-top d-flex align-items-center">
	<?php require_once(G5_ADMIN_PATH . $top_path); ?>
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
    		<a href="javascript:history.back();"><span class="sound_only">뒤로가기</span></a> <?php echo get_head_title($g5['title']); ?>
    	</h2>
		</div>
    <?php } ?>
       <div class="card-body pt-2">
