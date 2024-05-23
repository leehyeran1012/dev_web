<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$thumb_width = 297;
$thumb_height = 212;
$list_count = (is_array($list) && $list) ? count($list) : 0;
?>
<div class="container-fluid p-0">
	<div class="gallery_box">
    <?php
    for ($i=0; $i<$list_count; $i++) {

        $img_link_html = '';

        $wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);

        if( $i === 0 ) {
            $thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

            if($thumb['src']) {
                $img = $thumb['src'];
            } else {
                $img = G5_IMG_URL.'/no_img.png';
                $thumb['alt'] = '이미지가 없습니다.';
            }
            $img_content = '<img src="'.$img.'" alt="'.$thumb['alt'].'" >';
         //   $img_link_html = '<a href="'.$wr_href.'" class="lt_img" >'.run_replace('thumb_image_tag', $img_content, $thumb).'</a>';
        }
      ?>
		<div class="div">
			<a href="<?= $wr_href ?>" class="text-dark-emphasis">
				<img src="<?= $img ?>" alt="" width="98%">
				<h4><?php echo $list[$i]['subject'] ?></h4>
			</a>
		</div>
    <?php }  ?>
	</div>
</div>

<script>
$('.gallery_box').slick({
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