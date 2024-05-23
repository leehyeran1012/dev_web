<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>

<ul class="list-group bg-warning">
	<?php for ($i=0; $i<count($list); $i++) {  ?>
	<li class="list-group-item d-flex justify-content-between align-items-center">
		<a href="<?php echo $list[$i]['href'] ?>"><?php echo $list[$i]['subject'] ?></a>
		<span><?php echo $list[$i]['datetime2'] ?></span>
	</li>
	<?php } ?>
</ul>
