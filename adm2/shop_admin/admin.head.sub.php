<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$g5_debug['php']['begin_time'] = $begin_time = get_microtime();

if (!isset($g5['title'])) {
    $g5['title'] = $config['cf_title'];
    $g5_head_title = $g5['title'];
}
else {
    $g5_head_title = $g5['title']; // 상태바에 표시될 제목
    $g5_head_title .= " | ".$config['cf_title'];
}

$g5['title'] = strip_tags($g5['title']);
$g5_head_title = strip_tags($g5_head_title);
// 현재 접속자
// 게시판 제목에 ' 포함되면 오류 발생
$g5['lo_location'] = addslashes($g5['title']);
if (!$g5['lo_location'])
    $g5['lo_location'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
$g5['lo_url'] = addslashes(clean_xss_tags($_SERVER['REQUEST_URI']));
if (strstr($g5['lo_url'], '/'.G5_ADMIN_DIR.'/') || $is_admin == 'super') $g5['lo_url'] = '';

?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" sizes="16x16" href="<?= G5_THEME_URL ?>/img/favicon.png">
	<?php if($config['cf_add_meta']) echo $config['cf_add_meta'].PHP_EOL; ?>
	<title><?= $g5_head_title; ?></title>
	<script>
	var g5_url       = "<?= G5_URL ?>";
	var g5_bbs_url   = "<?= G5_BBS_URL ?>";
	var g5_theme_lib_url   = "<?= G5_THEME_LIB_PATH ?>";
	var g5_is_member = "<?= isset($is_member)?$is_member:''; ?>";
	var g5_is_admin  = "<?= isset($is_admin)?$is_admin:''; ?>";
	var g5_is_mobile = "<?= G5_IS_MOBILE ?>";
	var g5_bo_table  = "<?= isset($bo_table)?$bo_table:''; ?>";
	var g5_sca       = "<?= isset($sca)?$sca:''; ?>";
	var g5_editor    = "<?= ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
	var g5_cookie_domain = "<?= G5_COOKIE_DOMAIN ?>";

	<?php if(defined('G5_IS_ADMIN')) { ?>
	var g5_admin_url = "<?= G5_ADMIN_URL; ?>";
	<?php } ?>
	</script>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
	add_stylesheet('<link rel="stylesheet" href="'.G5_ADMIN_URL.'/css/admin_mode.css">', 0);
	add_javascript('<script src="'.G5_JS_URL.'/jquery-1.12.4.min.js"></script>', 0);
	add_javascript('<script src="'.G5_JS_URL.'/jquery-migrate-1.4.1.min.js"></script>', 0);
	add_javascript('<script src="'.G5_JS_URL.'/common.js?ver='.G5_JS_VER.'"></script>', 0);
	add_javascript('<script src="'.G5_JS_URL.'/wrest.js?ver='.G5_JS_VER.'"></script>', 0);
	add_javascript('<script src="'.G5_JS_URL.'/placeholders.min.js"></script>', 0);
	add_javascript('<script src="'.G5_ADMIN_URL.'/admin.js"></script>', 0);

	if(!defined('G5_IS_ADMIN'))
		echo $config['cf_add_script'];
?>

</head>
<body<?= isset($g5['body_script']) ? $g5['body_script'] : ''; ?>>
