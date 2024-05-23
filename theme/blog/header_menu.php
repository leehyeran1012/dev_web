<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$menu_datas = sql_query(" select * from {$g5['menu_table']} where length(me_code) = 2 and me_use = 1 order by me_code ");

?>
<style type="text/css">
 .navbar .dropdown-submenu.dropend .dropdown-menu{border-radius:.5rem;box-shadow:var(--bs-box-shadow);left:100%;min-width:10rem;right:auto;top:-18px}
 .navbar .navbar-nav .dropend>.dropdown-menu{transform:translateY(10px)}
 .navbar .dropdown-submenu:hover>.dropdown-menu{opacity:1;transform:translateY(10px);visibility:visible}}
 .dropdown-toggle:after{float: right}
 .dropend .dropdown-toggle:after{border: 0;content: "\F231"; display: inline-block;font-family:bootstrap-icons!important;font-size:10px;margin-top:5px;float: right}
</style>
<div class="py-0 px-3 mb-4 border border-secondary-subtle border-1 rounded d-none d-md-block">
	<nav class="navbar navbar-expand-lg d-none d-md-block">
	  <div class="container-fluid p-0">
	  <span class="d-block d-md-none fw-bold">메뉴관리</span>
		<button class="navbar-toggler ms-auto border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
		  <span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav me-auto">
			<?php foreach( $menu_datas as $field ) {

					$sql2 = " select * from {$g5['menu_table']} where length(me_code)= 4 and left(me_code,2) = '".$field["me_code"]."' and me_use = 1 order by me_code ";
					$menu_submenus = sql_query($sql2);

					if(sql_num_rows($menu_submenus) == 0) { ?>
						<li class="nav-item"><a class="nav-link fs-6 link-body-emphasis fw-bold me-4" href="<?= home_link($field['me_link']); ?>" target="_<?= $field['me_target']; ?>"><?= $field['me_name'] ?></a></li>
					<?php } else {  ?>
					<li class="nav-item dropdown pe-3">
					<a class="nav-link dropdown-toggle fs-6 link-body-emphasis fw-bold" href="<?= home_link($field['me_link']); ?>" target="_<?= $field['me_target']; ?>"><?= $field['me_name'] ?></a>
						<ul class="dropdown-menu shadow border-success">
					<?php foreach($menu_submenus as $field2) {
							$sql3 = " select * from {$g5['menu_table']} where length(me_code)= 6 and left(me_code,4) = '".$field2["me_code"]."' and me_use = 1 order by me_code ";
							$menu_submenus2 = sql_query($sql3);

						 if(sql_num_rows($menu_submenus2) == 0) { ?>
							<li><a class="dropdown-item" href="<?= home_link($field2['me_link']); ?>" target="_<?= $field2['me_target']; ?>"><?= $field2['me_name'] ?></a></li>
						<?php } else { ?>
						<li class="dropdown-submenu dropend">
							<a class="dropdown-item dropdown-toggle" href="#"><?= $field2['me_name'] ?></a>
							<ul class="dropdown-menu">
								<?php  foreach($menu_submenus2 as $field3) {	?>
								<li><a class="dropdown-item" href="<?= home_link($field3['me_link']); ?>" target="_<?= $field3['me_target']; ?>"><?= $field3['me_name'] ?></a></li>
								<?php } ?>
							</ul>
						</li>

					<!-- accordion 메뉴 사용시
						<li><div class="accordion accordion-flush" id="accordionLeft3<?=$key2?>">
						  <div class="accordion-item">
							<h2 class="accordion-header"><button class="accordion-button collapsed p-0 py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse3<?=$key2?>" aria-expanded="false" aria-controls="flush-collapse3<?=$key2?>"><?= $field2['me_name'] ?></button></h2>
							<div id="flush-collapse3<?=$key2?>" class="accordion-collapse collapse" data-bs-parent="#accordionLeft3<?=$key2?>">
								<div class="accordion-body p-0">
									<div class="list-group list-group-flush ps-2">
								<?php  foreach($menu_submenus2 as $field3) {	?>
									<a class="list-group-item list-group-item-action py-2 border-0" href="<?= $sub_link2 ?>" target="_<?= $field3['me_target']; ?>">- <?= $field3['me_name'] ?></a>
								<?php } ?>
							</div></div></div></div></div>
						</li> -->
				<?php } } ?>
							</ul>
						</li>
				<?php  }  } ?>

					<li class="nav-item dropdown dropdown-fullwidth">
					  <a class="nav-link link-body-emphasis px-2" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-bars fs-4" aria-hidden="true"></i></a>
					  <div class="dropdown-menu shadow border-success">
						<div class="row py-3 px-5">
						<?php foreach( $menu_datas as $field ) {

								$sql2 = " select * from {$g5['menu_table']} where length(me_code)= 4 and left(me_code,2) = '".$field["me_code"]."' and me_use = 1 order by me_code ";
								$menu_submenus = sql_query($sql2);

								if(sql_num_rows($menu_submenus) == 0) { ?>
									<div class="col"><a class="fs-6 link-body-emphasis fw-bold me-4" href="<?= home_link($field['me_link']); ?>" target="_<?= $field['me_target']; ?>"><?= $field['me_name'] ?></a></div>
								<?php } else {  ?>
								 <div class="col">
									<p class="mb-1"><a class="fs-6 link-body-emphasis fw-bold" href="<?= home_link($field['me_link']); ?>" target="_<?= $field['me_target']; ?>"><?= $field['me_name'] ?></a></p>

								<?php foreach($menu_submenus as $key2=>$field2) {

									$sql3 = " select * from {$g5['menu_table']} where length(me_code)= 6 and left(me_code,4) = '".$field2["me_code"]."' and me_use = 1 order by me_code ";
									$menu_submenus2 = sql_query($sql3);

									 if(sql_num_rows($menu_submenus2) == 0) { ?>
										<p class="py-1"><a class="fs-6 link-body-emphasis" href="<?= home_link($field2['me_link']); ?>" target="_<?= $field2['me_target']; ?>"><?= $field2['me_name'] ?></a></p>
									<?php } else { ?>
							<ul>
							<li class="dropdown-submenu dropend">
								<a class="dropdown-item dropdown-toggle fs-6 ps-0" href="#"><?= $field2['me_name'] ?></a>
								<ul class="dropdown-menu">
									<?php  foreach($menu_submenus2 as $field3) {	?>
									<li><a class="dropdown-item" href="<?= home_link($field3['me_link']); ?>" target="_<?= $field3['me_target']; ?>"><?= $field3['me_name'] ?></a></li>
									<?php } ?>
								</ul>
							</li>
							</ul>

<!--
							<div class="accordion accordion-flush" id="accordionmaLeft3<?=$key2?>">
							  <div class="accordion-item py-2">
								<h2 class="accordion-header"><button class="accordion-button collapsed p-0 pe-3" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsemg3<?=$key2?>" aria-expanded="false" aria-controls="flush-collapsemg3<?=$key2?>"><?= $field2['me_name'] ?></button></h2>
								<div id="flush-collapsemg3<?=$key2?>" class="accordion-collapse collapse" data-bs-parent="#accordionmaLeft3<?=$key2?>">
									<div class="accordion-body p-0 pt-2">
										<div class="list-group list-group-flush p-0">
									<?php  foreach($menu_submenus2 as $field3) {	?>
								<a class="list-group-item list-group-item-action link-body-emphasis p-0 py-1 border-0 small" href="<?= home_link($field3['me_link']); ?>" target="_<?= $field3['me_target']; ?>">- <?= $field3['me_name'] ?></a>
							<?php } ?>
								</div></div></div></div></div> -->

					<?php } } ?>
								</div>
							<?php  }  } ?>
								<div class="col"><img src="<?=G5_THEME_URL?>/img/happydow/sir-happy-dow-10.png" alt="happydow"></div>
						</div>
					  </div>
					</li>

			</ul>

			<form role="search">
				<a href="#" target="_blank" class="me-2"><img src="<?=G5_THEME_URL?>/img/layout/f-sns01.png" style="width:30px"></a>
				<a href="#" target="_blank" class="me-2"><img src="<?=G5_THEME_URL?>/img/layout/f-sns02.png" style="width:30px"></a>
				<a href="#" target="_blank" class="me-2"><img src="<?=G5_THEME_URL?>/img/layout/f-sns03.png" style="width:30px"></a>
				<a href="#" target="_blank"><img src="<?=G5_THEME_URL?>/img/layout/f-sns04.png" style="width:30px"></a>
			</form>
		</div>
	  </div>
	</nav>
 </div>
<!-- 모바일메뉴 -->
<nav class="navbar navbar-expand-lg bg-light  fixed-top d-block d-md-none" aria-label="Offcanvas navbar large">
	<div class="container-fluid">
		<a class="navbar-brand" href="<?=G5_URL?>"><img src="<?=G5_URL?>/img/logo.png"  alt="logo"></a>
		<i class="bi bi-chat-dots-fill fs-4 ms-auto me-3"></i>
		<button class="navbar-toggler border-0 bg-info" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
			<div class="offcanvas-header">
				<h5 class="offcanvas-title" id="offcanvasNavbarLabel"><img src="<?=G5_URL?>/img/logo.png"  alt="..."></h5>
				<button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
			</div>
			<div class="mx-auto mt-3"><?php include(G5_THEME_PATH.'/top_sub_menu.php'); ?></div>
			<div class="offcanvas-body p-0">
				<div class="accordion accordion-flush" id="accordionflush">
					<h1 id="mlogo">&nbsp;</h1>
					<div class="accordion-item"></div>
					<?php foreach( $menu_datas as $key=>$field ) {

							$sql2 = " select * from {$g5['menu_table']} where length(me_code)= 4 and left(me_code,2) = '".$field["me_code"]."' and me_use = 1 order by me_code ";
							$menu_submenus = sql_query($sql2);

					if(sql_num_rows($menu_submenus) == 0) { ?>
						<div class="accordion-item">
							<div class="list-group py-3 ps-3"><a class="nav-link fs-6 text-dark-emphasis fw-bold ms-1" href="<?= home_link($field['me_link']); ?>" target="_<?= $field['me_target']; ?>"><?= $field['me_name'] ?></a></div>
						</div>
					<?php } else {  ?>
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-heading<?=$key?>">
							<button class="accordion-button collapsed text-dark-emphasis fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?=$key?>" aria-expanded="false" aria-controls="flush-collapse<?=$key?>"><?= $field['me_name'] ?></button>
							</h2>
							<div id="flush-collapse<?=$key?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?=$key?>" data-bs-parent="#accordionflush">
								<div class="accordion-body p-0">
									<div class="list-group">
								<?php foreach($menu_submenus as $key2=>$field2) {

									$sql3 = " select * from {$g5['menu_table']} where length(me_code)= 6 and left(me_code,4) = '".$field2["me_code"]."' and me_use = 1 order by me_code ";
									$menu_submenus2 = sql_query($sql3);

							 if(sql_num_rows($menu_submenus2) == 0) { ?>
								<a href="<?= home_link($field2['me_link']); ?>" class="list-group-item list-group-item-action ps-4" target="_<?= $field2['me_target']; ?>"><i class="bi bi-dot"></i><?= $field2['me_name'] ?></a>
							<?php } else { ?>
								<div class="accordion accordion-flush" id="accordionmLeft3<?=$key2?>">
								  <div class="accordion-item">
									<h2 class="accordion-header"><button class="accordion-button collapsed py-2 ps-4 pe-5" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsemg3<?=$key2?>" aria-expanded="false" aria-controls="flush-collapsemg3<?=$key2?>"><i class="bi bi-dot"></i><?= $field2['me_name'] ?></button></h2>
									<div id="flush-collapsemg3<?=$key2?>" class="accordion-collapse collapse" data-bs-parent="#accordionmLeft3<?=$key2?>">
										<div class="accordion-body p-0">
											<div class="list-group list-group-flush">
										<?php  foreach($menu_submenus2 as $field3) {	?>
								<a class="list-group-item list-group-item-action link-body-emphasis py-2 ps-5 border-0" href="<?= home_link($field3['me_link']); ?>" target="_<?= $field3['me_target']; ?>">- <?= $field3['me_name'] ?></a>
							<?php } ?>
								</div></div></div></div></div>
						<?php } } ?>
							</div>
						</div>
					</div>
				</div>

			<?php  }  } ?>

				<div class="container border-bottom text-center">
				  <div class="row text-center">
					<div class="col py-1 border-end"><i class="fa fa-bell-o fa-lg" aria-hidden="true"></i><p class="small mt-1">알림</p></div>
					<div class="col py-1 border-end"><i class="fa fa-bookmark-o fa-lg" aria-hidden="true"></i><p class="small mt-1">스크랩</p></div>
					<div class="col py-1 border-end"><i class="fa fa-comments-o fa-lg" aria-hidden="true"></i><p class="small mt-1">쪽지</p></div>
					<div class="col py-1">
						<?php if ($is_member) { ?>
						<a class="link text-white" href="<?= G5_BBS_URL ?>/logout.php"><i class="fa fa-user-o fa-lg" aria-hidden="true"></i><p class="small mt-1">로그아웃</p></a>
						<?php } else { ?>
						<a class="link text-white" href="<?= G5_BBS_URL ?>/login.php"><i class="fa fa-user-o fa-lg" aria-hidden="true"></i><p class="small mt-1">로그인</p></a>
						<?php } ?>
					</div>
				  </div>
				</div>
				 <div class="text-center mt-3"><a href="<?=G5_URL?>"><img src="<?=G5_THEME_URL?>/img/logo2.png"  alt="..." style="width:230px"></a></div>
				 <div class="text-center my-5 py-5">&nbsp;</div>
			</div>
		</div>
	</div>
</nav>