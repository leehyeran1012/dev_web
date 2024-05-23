<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$list_count = (is_array($list) && $list) ? count($list) : 0;
?>
<div class="container p-0">
   <h4 class="fw-bold fs-6 text-dark-emphasis border-bottom pb-2">최신글</h4>

   <?php
    for ($i=0; $i<$list_count; $i++) {
		$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], 320, 200, false, true);
		if(strlen($thumb['src']) < 3) $thumb['src'] = G5_IMG_URL.'/no_img.png';
		$content = str_replace("&nbsp;", " ", $list[$i]['wr_content']);
	?>
  <div class="row border-bottom pt-3">
    <div class="col-sm-12 col-md-5 mb-3"><img src="<?= $thumb['src'] ?>" class="card-img-top"></div>
    <div class="col-sm-12 col-md-7 mb-3 pe-0">
		<p class="small fw-bold"><a href="<?=$list[$i]['href']?>" class="text-dark-emphasis"><?= get_text(cut_str($list[$i]['subject'],13)) ?></a></p>
		<p class="small"><?php echo get_text(cut_str(strip_tags($content),13)) ?></p>
		<p class="mt-2 small"><span class="me-3"><?php echo $list[$i]['name'] ?></span> <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $list[$i]['datetime2'] ?></p>
    </div>
  </div>
<?php } ?>
</div>