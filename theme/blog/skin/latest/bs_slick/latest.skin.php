<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);

$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="container-fluid border rounded p-0">
	<a href="<?php echo get_pretty_url($bo_table); ?>">
		<div class="d-flex justify-content-between px-3 py-2 bg-light border-bottom">
		  <div class="fs-6 fw-bold text-dark"><?php echo $bo_subject ?></div>
		  <div><i class="bi bi-plus-lg text-dark"></i></div>
		</div>
	</a>
	<div class="gallery_box ps-2 pe-1 py-3">
    <?php for ($i=0; $i<$list_count; $i++) {
		$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], 320, 200, false, true);
		if(strlen($thumb['src']) < 3) $thumb['src'] = G5_IMG_URL.'/no_img.png';
        $wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);
      ?>
		<a href="<?= $wr_href ?>">
			<img src="<?= $thumb['src'] ?>" alt="" class="slick_img">
			<p class="text-dark-emphasis small pt-1"> <?php echo $list[$i]['subject'] ?></p>
		</a>
    <?php }  ?>
	</div>
</div>

<script>
$('.gallery_box').slick({
	slide: "div",
	infinite: true,
	slidesToShow: 4,
	slidesToScroll: 1,
	autoplay: true,
	arrows: false,
	responsive: [
	{
		breakpoint: 1180,
		settings: {
			slidesToShow: 1,
			slidesToScroll: 1,
			infinite: true,
			autoplay:true,
			arrows:false
		}
	},
	{
		breakpoint: 600,
		settings: {
			slidesToShow: 1,
			slidesToScroll: 1,
			infinite: true,
			autoplay:true,
			arrows:false
		}
	},
	]
});
</script>