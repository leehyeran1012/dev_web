<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(isset($admin_use_tables) && in_array($bo_table, $admin_use_tables)) {
    require_once(G5_ADMIN_PATH.'/admin.head2.php');
	return;
}

include_once(G5_THEME_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');

include_once(G5_THEME_PATH.'/functions.php');
include_once(G5_THEME_PATH.'/theme_mode.php'); // 화면 모드

if(defined('_INDEX_')) {
	include G5_THEME_PATH.'/newwin.inc.php'; // 팝업레이어
}

if(!defined('_INDEX_')) {
?>
<script>
	$(function() {
		 $("html, body").animate({scrollTop:250}, '1000');
	});
</script>
<?php } ?>

<div class="container">
  <header class="lh-1 py-3">
	<div class="row">
      <div class="col-12 pt-sm-2 pt-md-5">      </div>
	</div>
    <div class="row justify-content-between align-items-center">
      <div class="col-sm-12 col-md-4 mb-3 logo_img ps-md-5 d-none d-md-block">
        <a class="link-secondary" href="<?=G5_URL?>"><img src="<?=G5_URL?>/img/logo.png"  alt="logo"></a>
      </div>
      <div class="col-sm-12 col-md-4 text-center mb-3 d-none d-md-block">
		<?php include_once(G5_THEME_PATH.'/search_form.php'); ?>
      </div>
      <div class="col-sm-12 col-md-4 mb-3 ps-5 d-none d-md-block">
		<div class="d-flex justify-content-center"><?php include(G5_THEME_PATH.'/top_sub_menu.php'); ?></div>
      </div>
    </div>
  </header>

<?php include_once(G5_THEME_PATH.'/header_menu.php'); ?>

</div>

<main class="container">

<?php
	//사이드메뉴 사용여부

	$side_use = true;	//사이드메뉴 사용
	$target_url = $_SERVER['REQUEST_URI'];

	// if(defined('_INDEX_'))  $side_use = false;	// index.php 사이드메뉴 미사용시 설정

	// 사이드메뉴 미사용 게시판 설정 - 배열에 추가
	$no_sides = array("calendar");

	if(!empty($no_sides)) {
		foreach($no_sides as $value) {
		  if (strpos($target_url, $value) === false) {
			$side_use = true;
		  } else {
			$side_use = false;
			break;
		  }
		}
	}
?>
	<div class="row">
		<div class="d-block d-md-none mt-5"></div>
		<div class="col-lg-12 col-xl-9">
		  <div class="mb-4 rounded text-body-emphasis bg-body-secondary overflow-hidden">
				<?php include_once(G5_THEME_PATH.'/carousel.php'); ?>
		  </div>
		</div>
		<div class="col-lg-12 col-xl-3">
			<div class="px-4 py-3 mb-3 bg-body-tertiary border rounded d-none d-md-block">
				<?php echo outlogin("theme/basic");?>
			</div>
		</div>
	</div>

	<div class="row">
	<?php if($side_use) { ?>
		<div class="col-lg-12 col-xl-9">		
	<?php } else { ?>
		<div class="col-lg-12 pt-3">
	<?php } ?>
