<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$thumb_width = 280;
$thumb_height = 150;
$list_count = (is_array($list) && $list) ? count($list) : 0;

 for ($i=0; $i<$list_count; $i++) {

	$img_link_html = '';
	$wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);

	$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

	if($thumb['src']) {
		$img = $thumb['src'];
	} else {
		$img = G5_IMG_URL.'/no_img.png';
		$thumb['alt'] = '이미지가 없습니다.';
	}

?>

	<div class="item">
		<a href="<?= $wr_href ?>" target="_blank">
			<div class="img"><img src="<?= $img ?>" alt=""/></div>
			<dl class="txt" style="height:250px">
				<dd>
					<p class="btxt">학교명</p>
					<p class="stxt"><?= $list[$i]['wr_1'] ?></p>
				</dd>
				<dd>
					<p class="btxt">프로그램</p>
					<p class="stxt"><?= $list[$i]['subject'] ?></p>
				</dd>
				<dd>
					<p class="btxt">일자</p>
					<p class="stxt"><?= $list[$i]['wr_2'] ?></p>
				</dd>
				<dd>
					<p class="btxt">내용</p>
					<p class="stxt"><?= $list[$i]['wr_content'] ?></p>
				</dd>
			</dl>
		</a>
	</div>
    <?php }  ?>

    <?php if ($list_count == 0) { //게시물이 없을 때  ?>
	<div class="item">
		<a href="#">
			<div class="img"><img src="<?= G5_IMG_URL ?>/no_img.png" alt=""/></div>
		</a>
	</div>
    <?php }  ?>

