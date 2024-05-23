<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

//add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);
$list_count = (is_array($list) && $list) ? count($list) : 0;


?>
<div class="list-group">
	<a href="<?php echo get_pretty_url($bo_table); ?>" class="list-group-item list-group-item-action bg-light">
		<div class="d-flex justify-content-between">
		  <div class="fw-bold text-dark"><?php echo $bo_subject ?></div>
		  <div><i class="bi bi-plus-lg text-dark"></i></div>
		</div>
	</a>
	<?php for ($i=0; $i<$list_count; $i++) {  ?>

	<a href="<?= get_pretty_url($bo_table, $list[$i]['wr_id']) ?>" class="list-group-item list-group-item-action">
		<div class="d-flex justify-content-between pt-2">
		  <div><?= $list[$i]['subject'] ?> <?php if ($list[$i]['icon_new']) { ?><span class="badge bg-danger-subtle text-danger-emphasis rounded-pill">N<span class="sound_only">새글</span></span><?php } ?></div>
		  <div class="small"><?= $list[$i]['datetime2'] ?></div>
		</div>
	</a>

    <?php }  ?>
    <?php if ($list_count == 0) { //게시물이 없을 때  ?>
		<li>
			<p class="stxt">게시물이 없습니다.</p>
		<li>
    <?php }  ?>

</div>