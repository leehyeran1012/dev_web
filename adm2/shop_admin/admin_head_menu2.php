<?php
	if(strpos($_SERVER['PHP_SELF'], "bbs") !== false) {
		require_once G5_ADMIN_PATH . '/_common.php';
	}
?>
<!-- <style type="text/css">
 .navbar .dropdown-submenu.dropend .dropdown-menu{border-radius:.5rem;box-shadow:var(--bs-box-shadow);left:100%;min-width:10rem;right:auto;top:-18px}
 .navbar .navbar-nav .dropend>.dropdown-menu{transform:translateY(10px)}
 .navbar .dropdown-submenu:hover>.dropdown-menu{opacity:1;transform:translateY(10px);visibility:visible}}
 .dropdown-toggle:after{float: right}
 .dropend .dropdown-toggle:after{border: 0;content: "\F231"; display: inline-block;font-family:bootstrap-icons!important;font-size:10px;margin-top:5px;float: right}
</style> -->

	<div class="d-flex align-items-center justify-content-between">
		<a href="<?=G5_ADMIN_URL?>/main.php" class="logo d-flex align-items-center d-none d-xl-block"><span class="fs-5 ps-2">ADMINISTRATOR</span></a>
		 <i class="bi bi-list toggle-sidebar-btn"></i><span class="fs-5 ps-5 fw-bold d-block d-lg-none text-success">ADMIN</span>
	</div>
	<div class="d-none d-lg-block">

		<nav class="navbar navbar-expand-lg">
			<div class="container-fluid ps-4">
				<ul class="navbar-nav me-auto">
		<?php
		if($is_admin == "super") {
			$ad_menus = sql_query(" select * from {$g5['menu_admin']} where length(me_code)= 2 and me_use = 1 order by me_code ");

			foreach($ad_menus as $field) {

				$sql2 = " select * from {$g5['menu_admin']} where length(me_code) = 4 and left(me_code,2) = '".$field["me_code"]."' and me_use = 1 order by me_code ";
				$ad_submenus = sql_query($sql2);

			 if(sql_num_rows($ad_submenus) == 0) { ?>
				<li class="nav-item pe-2"><a class="nav-link fw-bold" href="<?= admin_link($field['me_link']); ?>" target="_<?= $field['me_target']; ?>"><?= $field['me_name'] ?></a></li>
			<?php } else { ?>
				<li class="nav-item dropdown pe-2">
				<a class="nav-link dropdown-toggle fw-bold" href="<?= admin_link($field['me_link']); ?>" target="_<?= $field['me_target']; ?>"><?= $field['me_name'] ?></a>
					<ul class="dropdown-menu shadow border-success">
			<?php  foreach($ad_submenus as $key2=>$field2) {

						$sql3 = " select * from {$g5['menu_admin']} where length(me_code) = 6 and left(me_code,4) = '".$field2["me_code"]."' and me_use = 1 order by me_code ";
						$ad_submenus2 = sql_query($sql3);

				 if(sql_num_rows($ad_submenus2) == 0) { ?>
					<li><a class="dropdown-item" href="<?= admin_link($field2['me_link']); ?>" target="_<?= $field2['me_target']; ?>"><?= $field2['me_name'] ?></a></li>
				<?php } else { ?>
					<li class="dropdown-submenu dropend">
						<a class="dropdown-item dropdown-toggle" href="#"><?= $field2['me_name'] ?></a>
						<ul class="dropdown-menu">
					<?php  foreach($ad_submenus2 as $field3) {	?>
						<li><a class="dropdown-item" href="<?= admin_link($field3['me_link']); ?>" target="_<?= $field3['me_target']; ?>"><?= $field3['me_name'] ?></a></li>
					<?php } ?>
					</ul>
				</li>
			<!-- accordion 메뉴사용시
				<li><div class="accordion accordion-flush" id="accordion3<?=$key2?>">
				  <div class="accordion-item">
					<h2 class="accordion-header ps-2"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse3<?=$key2?>" aria-expanded="false" aria-controls="flush-collapse3<?=$key2?>"><span class="small"><?= $field2['me_name'] ?></span></button></h2>
					<div id="flush-collapse3<?=$key2?>" class="accordion-collapse collapse" data-bs-parent="#accordion3<?=$key2?>">
						<div class="accordion-body p-0 ps-2 pe-1">
							<div class="list-group list-group-flush border rounded">
						<?php  foreach($ad_submenus2 as $field3) {	?>
					<a  class="list-group-item list-group-item-action py-1 ps-4 border-0" href="<?= admin_link($field3['me_link']); ?>" target="_<?= $field3['me_target']; ?>">- <?= $field3['me_name'] ?></a>
				<?php } ?>
					</div></div></div></div></div>
				</li> -->
				<?php } } ?>
						</ul>
					</li>
			<?php  } }

		 } else {

			$ads_menus = sql_query(" select distinct left(me_code,2) mcode from {$g5['auth_table']} left join {$g5['menu_admin']} on au_menu = me_acode where mb_id = '{$member['mb_id']}' order by au_menu ");

			foreach($ads_menus as $field) {

				$top_title = sql_fetch("select me_name from {$g5['menu_admin']} where me_code = '".$field["mcode"]."'");

				$sql2 = " select * from {$g5['auth_table']} left join {$g5['menu_admin']} on au_menu = me_acode  where left(me_code,2) = '".$field["mcode"]."' and mb_id = '{$member['mb_id']}' order by au_menu ";
				$ads_submenus = sql_query($sql2);

			?>
				<li class="nav-item dropdown pe-2">
				<a class="nav-link dropdown-toggle fw-bold" href="<?= admin_link($field['me_link']); ?>"><?= $top_title['me_name'] ?></a>
					<ul class="dropdown-menu shadow border-success">
				<?php foreach($ads_submenus as $field2) { ?>
				<li class="nav-item pe-2"><a class="nav-link fw-bold" href="<?= admin_link($field2['me_link']); ?>"><?= $field2['me_name'] ?></a></li>
				<?php  } ?>
				</ul>
				</li>
		<?php  }	}  ?>
				</ul>
			</div>
		</nav>
	</div>
	<nav class="ms-auto">
		<ul class="d-flex align-items-center">
			<li class="nav-item me-2"><a class="btn btn-info btn-sm" href="<?=G5_URL?>" title="홈페이지로" target="_blank"><i class="bi bi-house-door"></i></a></li>
			<li class="nav-item"><a class="me-3 btn btn-purple btn-sm small" href="<?=G5_URL?>/bbs/logout.php"><span>로그아웃</span></a></li>
		</ul>
	</nav>
