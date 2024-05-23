<?php
	if(strpos($_SERVER['PHP_SELF'], "bbs") !== false) {
		require_once G5_ADMIN_PATH . '/_common.php';
	}
	// 메뉴함수
	function print_menu($key, $no = '') {
		global $menu;

		$str = print_menu2($key, $no);
		return $str;
	}

	function print_menu2($key, $no = '') {
		global $menu, $auth_menu, $is_admin, $auth, $g5, $sub_menu;

		$str = "<ul class='dropdown-menu shadow border-success'>";
		for ($i = 1; $i < count($menu[$key]); $i++) {
			if (!isset($menu[$key][$i])) {
				continue;
			}

			if ($is_admin != 'super' && (!array_key_exists($menu[$key][$i][0], $auth) || !strstr($auth[$menu[$key][$i][0]], 'r'))) {
				continue;
			}

			$str .= '<li><a class="dropdown-item" href="' . $menu[$key][$i][2] . '">' . $menu[$key][$i][1] . '</a></li>';
			$auth_menu[$menu[$key][$i][0]] = $menu[$key][$i][1];
		}
		$str .= "</ul>";

		return $str;
	}

?>
	<div class="d-flex align-items-center justify-content-between">
		<a href="<?=G5_ADMIN_URL?>/index.php" class="logo d-flex align-items-center d-none d-xl-block"><span class="fs-5 ps-3">ADMINISTRATOR</span></a>
		 <i class="bi bi-list toggle-sidebar-btn"></i><span class="fs-5 ps-3 fw-bold d-block d-lg-none text-success">ADMIN</span>
	</div>
	<div class="d-none d-lg-block">
		<nav class="navbar navbar-expand-lg">
			<div class="container-fluid ps-4">
				<ul class="navbar-nav me-auto">
				<?php
					if($is_admin != "super") {
						$auth_temp = array();
						foreach($auth as $key=>$value) {
							array_push($auth_temp, substr($key, 0, 3));
						}
					}

					foreach ($amenu as $key => $value) {	?>
					<li class="nav-item dropdown">
					<?php if($is_admin == "super") { ?>
						<a class="nav-link dropdown-toggle fw-bold" href="<?php echo $menu['menu' . $key][0][2]?>"><?php echo $menu['menu' . $key][0][1]; ?></a>
					<?php } else {
					 if(in_array($key, $auth_temp)) { ?>
						<a class="nav-link dropdown-toggle fw-bold" href="<?php echo $menu['menu' . $key][0][2]?>"><?php echo $menu['menu' . $key][0][1]; ?></a>
					<?php } } ?>
						<?php echo print_menu('menu' . $key, 1); ?>
					</li>
				<?php } ?>
				</ul>
			</div>
		</nav>
	</div>
	<nav class="ms-auto">
		<ul class="d-flex align-items-center">
			<li class="nav-item me-3"><a class="nav-link" href="<?=G5_URL?>" title="홈페이지로" target="_blank"><span><i class="bi bi-browser-edge fs-4 text-success"></i></span></a></li>
			<li class="nav-item"><a class="me-3 btn btn-purple btn-sm link-opacity-75-hover" href="<?=G5_URL?>/bbs/logout.php"><span>로그아웃</span></a></li>
		</ul>
	</nav>