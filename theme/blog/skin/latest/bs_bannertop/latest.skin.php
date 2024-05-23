<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);

$list_count = (is_array($list) && $list) ? count($list) : 0;

?>

<?php for ($i=0; $i<$list_count; $i++) {
	$img_link_html = '';
	$wr_href = get_pretty_url($bo_table, $list[$i]['wr_id']);

	$thumb = get_list_thumbnail($bo_table, $list[$i]['wr_id'], $thumb_width, $thumb_height, false, true);

	if($thumb['src']) {
		$img = $thumb['src'];
	} else {
		$img = getFirstImage($list[$i]['wr_content']);
	}

	if(strlen($img) < 3) $img = G5_IMG_URL.'/no_img.png';
?>

    <div class="container-fluid">
      <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm" style="height:250px">
        <div class="col-sm-12 col-md-6 p-4 d-flex flex-column">
			  <strong class="d-inline-block mb-1 text-primary-emphasis fs-4 fw-bold"><?= $list[$i]['subject'] ?></strong>
			  <p class="mb-2 text-body-secondary small"><?php echo $list[$i]['name'] ?> <?php echo $list[$i]['datetime2'] ?></p>
			  <p class="mb-auto"><?= strip_tags($list[$i]['wr_content'],"<br>") ?></p>
			  <a href="<?=$wr_href?>" class="icon-link gap-1 icon-link-hover stretched-link">더보기 <svg class="bi"><use xlink:href="#chevron-right"/></svg></a>
        </div>
        <div class="col-sm-12 col-md-6 ps-3 align-items-center d-none d-lg-block">
			<img src="<?=$img?>" alt="" style="width:100%;height:250px">
        </div>
      </div>
    </div>

<?php }  ?>