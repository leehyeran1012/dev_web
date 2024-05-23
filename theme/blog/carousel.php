<?php
	$car_titles = ["메뉴1","메뉴2","메뉴3","메뉴4","메뉴5","커뮤니티"];
	$sub_titles = ["메뉴1 설명","메뉴2 설명","메뉴3 설명","메뉴4 설명","메뉴5 설명","메뉴6 설명"];
	$bg_img = ["c_bg01.jpg","c_bg02.jpg","c_bg03.jpg","c_bg04.jpg","c_bg05.jpg","c_bg06.jpg"];
	$text_align = ["text-start","text-center","text-end","text-start","text-center","text-end"];
	$font_color = ["text-black","text-dark","text-white","text-success","text-danger","text-primary"];
?>

<div class="row">
	<div class="col-sm-12 col-md-12 p-0">
		<div id="myCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
			<div class="carousel-inner">
				<?php foreach($car_titles as $key=>$value) { ?>
				<div class="carousel-item<?php if($key==0) echo " active";?>">
					<img src="<?=G5_THEME_URL?>/img/carousel/<?=$bg_img[$key]?>" class="ca_img"  alt="...">
					<div class="container">
						<div class="carousel-caption <?=$text_align[$key]?>">
							<h1 class="fs-2 fw-bold <?=$font_color[$key]?>">부트스트랩 블로그 테마</h1>
							<p class="py-3 fs-5 text-dark opacity-75"><?= $car_titles[$key] ?></p>
							<p class="fs-5 <?=$font_color[$key]?>"><?= $sub_titles[$key] ?></p>
							<p class="mt-3"><a class="btn btn-danger btn-sm" href="#">더보기 &raquo;</a></p>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
				<span class="carousel-control-prev-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Previous</span>
			</button>
			<button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
				<span class="carousel-control-next-icon" aria-hidden="true"></span>
				<span class="visually-hidden">Next</span>
			</button>
		</div>
	</div>
</div>