<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<ul class="list-group list-group-flush mt-3">
	<?php for ($i=0; $i<count($list); $i++) {  ?>
	<li>
		<a href="<?php echo $list[$i]['href'] ?>" class="text-dark-emphasis fs-7"><i class="bi bi-<?=($i+1)?>-square-fill fs-6 mx-2 text-purple"></i><?php echo get_text(cut_str($list[$i]['subject'],17)) ?></a>
	</li>
	<?php } ?>
</ul>
