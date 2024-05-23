<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$content_skin_url.'/style.css">', 0);
?>

<div class="container p-0">
<?php
if(is_file(G5_THEME_PATH.'/docs/'.$co_id.'.php')) {
	include G5_THEME_PATH.'/docs/'.$co_id.'.php';
 } else {  ?>
    <header>
        <h1><?php echo $g5['title']; ?></h1>
    </header>
    <div id="ctt_con">
        <?php echo $str; ?>
    </div>
<?php } ?>
</div>