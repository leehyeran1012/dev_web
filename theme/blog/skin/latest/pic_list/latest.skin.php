<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

$list_count = (is_array($list) && $list) ? count($list) : 0;
?>
<div class="container-fluid p-0">
	<h4 class="mb-4 fs-6 fw-bold border-bottom pb-2"><a href="<?php echo get_pretty_url($bo_table); ?>" class="link text-dark-emphasis "><?php echo $bo_subject ?></a></h4>
  <div class="row">
   <?php
    for ($i=0; $i<$list_count; $i++) {
		$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], 320, 200, false, true);

		if($thumb['src']) {
			$img = $thumb['src'];
		} else {
			$img = getFirstImage($list[$i]['wr_content']);
		}

		if(strlen($img) < 3) $img = G5_IMG_URL.'/no_img.png';
	?>
    <div class="col-sm-12 col-md-3 mb-3 px-2">
		<div class="card">
		  <a href="<?= $list[$i]['href'] ?>" class="w-100"><img src="<?= $img ?>" class="card-img-top pic_img"></a>
		  <div class="card-body">
			<h5 class="card-title"><a href="<?=$list[$i]['href']?>" class="text-dark-emphasis fs-6 fw-bold"><?=$list[$i]['subject']?></a></h5>
			<p class="small"><?php echo $list[$i]['name'] ?> <?php echo $list[$i]['datetime2'] ?></p>
			<a href="<?php echo get_pretty_url($bo_table); ?>" class="btn btn-light btn-sm mt-2"><span class="sound_only"><?php echo $bo_subject ?></span>더보기 &raquo;</a>
		  </div>
		</div>
    </div>
<?php } ?>
  </div>
</div>