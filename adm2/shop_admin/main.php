<?php
$sub_menu = '100000';
require_once './_common.php';

@require_once './safe_check.php';

if (function_exists('social_log_file_delete')) {
    social_log_file_delete(86400);      //소셜로그인 디버그 파일 24시간 지난것은 삭제
}

$g5['title'] = '관리자메인';
require_once './admin.head.php';

?>

<div class="container-fluid mt-3">
	<div class="row g-3 mb-3">
		<div class="col-sm-12 col-md-6">
			<?php include_once('./main_latest.php'); ?>
		</div>
		<div class="col-sm-12 col-md-6">
			<?php include_once('./main_new_mb.php'); ?>
		</div>
		<div class="col-sm-12 col-md-6">
			<?php include_once('./main_visitor_day.php'); ?>
		</div>
		<div class="col-sm-12 col-md-6">
			<?php include_once('./main_visitor_time.php'); ?>
		</div>
		<div class="col-sm-12 col-md-6">
			<?php include_once('./main_new_revisit.php'); ?>
		</div>
		<div class="col-sm-12 col-md-6">
			<?php include_once('./main_visitor_url.php'); ?>
		</div>
		<div class="col-sm-12 col-md-6">
			<?php include_once('./main_visitor_os.php'); ?>
		</div>
		<div class="col-sm-12 col-md-6">
			<?php include_once('./main_access_device.php'); ?>
		</div>
		<div class="col-sm-12 col-md-6">
			<?php include_once('./main_new_point.php'); ?>
		</div>
		<div class="col-sm-12 col-md-6">

		</div>
	</div>

</div>

<?php
require_once './admin.tail.php';
