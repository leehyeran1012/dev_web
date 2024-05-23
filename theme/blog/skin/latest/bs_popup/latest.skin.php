<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);

$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

		<ul class="nav nav-tabs">
		  <li class="nav-item"><a class="nav-link active" href="#gallery_box2">팝업존</a></li>
		</ul>
			<div class="gallery_box2" id="gallery_box2">
			<?php for ($i=0; $i<$list_count; $i++) {

				$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], 320, 200, false, true);
				if(strlen($thumb['src']) < 3) $thumb['src'] = G5_IMG_URL.'/no_img.png';

				$wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);
			  ?>
				<div>
					<a href="<?= $wr_href ?>">
						<img src="<?= $thumb['src'] ?>" alt="" class="rounded" width="100%" height="220">
						<!-- <p class="small pt-1"> <?php echo $list[$i]['subject'] ?><?=$i?></p> -->
					</a>
				</div>
			<?php }  ?>
			</div>

<script>
$('.gallery_box2').slick({
	slide: "div",
	infinite: true,
	slidesToShow: 1,
	slidesToScroll: 1,
	autoplay: true,
	arrows: false,
	speed: 2500,
	fade: true,
	cssEase: 'linear',
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
