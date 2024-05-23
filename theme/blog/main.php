
<?php include_once(G5_THEME_PATH.'/ticker.php'); ?>

<div class="container-fluid p-0 mb-4" data-aos="fade-up">
	<div class="row">
		<div class="col-sm-12 col-md-6 mb-3">
			<?php  echo latest('theme/bs_notice', 'notice', 4, 20); ?>
		</div>
		<div class="col-sm-12 col-md-6 mb-4">
			<?php  echo latest('theme/bs_notice', 'free', 4, 20); ?>
		</div>
	</div>
</div>

<div class="container-fluid p-0 mb-4" data-aos="fade-up">
	<?php  echo latest('theme/pic_list', 'gallery', 4, 23); ?>
</div>

<div class="container-fluid p-0 mb-4" data-aos="fade-up">
	<?php  echo latest('theme/bs_slick', 'gallery', 24, 15); ?>
</div>

<div class="container-fluid p-0 mb-4" data-aos="fade-up">
	<?php  echo latest('theme/bs_tab', 'notice', 4, 23); ?>
</div>

