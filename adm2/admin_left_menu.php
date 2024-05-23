<?php
	if(strpos($_SERVER['PHP_SELF'], "bbs") !== false) {
		require_once G5_ADMIN_PATH . '/_common.php';
	}
	// 메뉴함수
	function print_menu3($key, $no = '') {
		global $menu;

		$str = print_menu4($key, $no);
		return $str;
	}

	function print_menu4($key, $no = '') {
		global $menu, $auth_menu, $is_admin, $auth, $g5, $sub_menu;

		$str = "";
		for ($i = 1; $i < count($menu[$key]); $i++) {
			if (!isset($menu[$key][$i])) {
				continue;
			}

			if ($is_admin != 'super' && (!array_key_exists($menu[$key][$i][0], $auth) || !strstr($auth[$menu[$key][$i][0]], 'r'))) {
				continue;
			}

			$str .= '<a class="list-group-item list-group-item-action py-1 border-0" href="' . $menu[$key][$i][2] . '"><i class="bi bi-brightness-low-fill me-2"></i>' . $menu[$key][$i][1] . '</a>'.PHP_EOL;
			$auth_menu[$menu[$key][$i][0]] = $menu[$key][$i][1];
		}
		return $str;
	}

?>
<style type="text/css">
	.accordion-header > .accordion-button {outline: none !important;box-shadow: none !important;padding:10px;}
	.accordion-button:hover {background-color: #f6f9ff !important;box-shadow: none !important;}
	.accordion-button:active, .accordion-button:focus {outline: none !important;box-shadow: none !important;background-color: #f6f9ff !important;}
	.accordion-button::after {background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-plus' viewBox='0 0 16 16'%3E%3Cpath d='M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z'/%3E%3C/svg%3E");}
	.accordion-button:not(.collapsed)::after {background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-dash' viewBox='0 0 16 16'%3E%3Cpath d='M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z'/%3E%3C/svg%3E");}
	.accordion-button::after {transition: all 0.5s;}
</style>

<div class="card mt-3" style="width:250px !important;">
	<div class="card-header btn-purple py-2 d-flex justify-content-between fw-bold">관리자메뉴<a class="text-white" href="<?= G5_ADMIN_URL ?>" title="메뉴등록"><i class="bi bi-gear"></i></a></div>
	<div class="card-body py-3">
		<h2 class="accordion-header"><a class="accordion-button fw-bold collapsed px-3" href="<?= G5_ADMIN_URL ?>/main.php"><i class="bi bi-gear me-2 text-danger"></i>관리자</a></h2>
		<h2 class="accordion-header"><a class="accordion-button fw-bold collapsed px-3" href="<?= G5_BBS_URL ?>/board.php?bo_table=free" target="_self"><i class="bi bi-gear me-2"></i>메뉴1</a></h2>
		<h2 class="accordion-header"><a class="accordion-button fw-bold collapsed px-3" href="<?= G5_BBS_URL ?>/board.php?bo_table=free" target="_self"><i class="bi bi-gear me-2"></i>메뉴2</a></h2>

<!-- 아코디언메뉴 -->
		<div class="accordion accordion-flush" id="accordion01">
			<div class="accordion-item">
				<h2 class="accordion-header"><button class="accordion-button collapsed fw-bold px-3" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collap01" aria-expanded="true" aria-controls="flush-collap01"><i class="bi bi-gear me-2"></i>메뉴3</button></h2>
				<div id="flush-collap01" class="accordion-collapse collapse" data-bs-parent="#accordion01">
					<div class="accordion-body py-1">

						<div class="list-group list-group-flush">

							<a class="list-group-item list-group-item-action py-2 border-0" href="<?= G5_BBS_URL ?>/board.php?bo_table=free" target="_self"><i class="bi bi-brightness-low-fill me-2"></i>서브메뉴1</a>

<!-- 예시 참고하여 추가해 주세요. 추가시 숫자를 변경해 줘야 됨 -->
<!--  서브메뉴2 -->

							<div class="accordion accordion-flush" id="accordionLeft01">
								<div class="accordion-item">
									<h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapa01" aria-expanded="false" aria-controls="flush-collapa01"><i class="bi bi-brightness-low-fill ms-1 me-2"></i>서브메뉴2</button></h2>
									<div id="flush-collapa01" class="accordion-collapse collapse" data-bs-parent="#accordionLeft01">
										<div class="accordion-body p-0 ps-2">
											<div class="list-group list-group-flush border rounded ps-2">
												<a class="list-group-item list-group-item-action py-1 border-0" href="<?= G5_BBS_URL ?>/board.php?bo_table=free" target="_self">- 메뉴1</a>
												<a class="list-group-item list-group-item-action py-1 border-0" href="<?= G5_BBS_URL ?>/board.php?bo_table=free" target="_self">- 메뉴2</a>
											</div>
										</div>
									</div>
								</div>
							</div>
<!--  서브메뉴3 끝 -->
<!--  서브메뉴3 -->
							<div class="accordion accordion-flush" id="accordionLeft02">
								<div class="accordion-item">
									<h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapa02" aria-expanded="false" aria-controls="flush-collapa02"><i class="bi bi-brightness-low-fill ms-1 me-2"></i>서브메뉴3</button></h2>
									<div id="flush-collapa02" class="accordion-collapse collapse" data-bs-parent="#accordionLeft02">
										<div class="accordion-body p-0 ps-2">
											<div class="list-group list-group-flush border rounded ps-2">
												<a class="list-group-item list-group-item-action py-1 border-0" href="<?= G5_BBS_URL ?>/board.php?bo_table=free" target="_self">- 메뉴1</a>
												<a class="list-group-item list-group-item-action py-1 border-0" href="<?= G5_BBS_URL ?>/board.php?bo_table=free" target="_self">- 메뉴2</a>
											</div>
										</div>
									</div>
								</div>
							</div>
<!--  서브메뉴3 끝 -->
							<a class="list-group-item list-group-item-action py-2 border-0" href="<?= G5_BBS_URL ?>/board.php?bo_table=free" target="_self"><i class="bi bi-brightness-low-fill me-2"></i>서브메뉴1</a>

						</div>
					</div>
				</div>
			</div>
		</div>
		<h2 class="accordion-header"><a class="accordion-button fw-bold collapsed px-3" href="<?= G5_ADMIN_URL ?>/poll_list.php" target="_self"><i class="bi bi-gear me-2"></i>투표관리</a></h2>
	</div>
</div>

<!-- 관리자메뉴 -->
<div class="d-block  d-lg-none">
	<div class="card mt-3" style="width:250px !important;">
		<div class="card-header btn-teal py-2 fs-6">설정관리</div>
			<div class="card-body py-3" style="width:250px !important;">
			<?php
				$mm = 10;
				foreach ($amenu as $key => $value) {
				$mm++;
			?>
			<div class="accordion accordion-flush" id="accordionFlush<?=$mm?>">
				<div class="accordion-item">
					<h2 class="accordion-header"><button class="accordion-button collapsed fw-bold px-3 fs-6" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?=$mm?>" aria-expanded="false" aria-controls="flush-collapse<?=$mm?>"><i class="bi bi-gear me-2"></i><?php echo $menu['menu' . $key][0][1]; ?></button></h2>
					<div id="flush-collapse<?=$mm?>" class="accordion-collapse collapse" data-bs-parent="#accordionFlush<?=$mm?>">
						<div class="accordion-body py-2">
							<div class="list-group list-group-flush">
							<?php echo print_menu3('menu' . $key, 1); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			</div>
		</div>
	</div>
</div>

<div class="card mt-3" style="width:250px !important;">
  <div class="card-header btn-blue py-2">호스팅 관리</div>
  <div class="card-body py-3" style="width:250px !important;">
		<?php
			$print_version = ($is_admin == 'super') ? G5_GNUBOARD_VER : '';
			$end_date = (date("Y",time())+1).'-07-22';
			$d_day = floor(( strtotime(substr($end_date,0,10)) - strtotime(date('Y-m-d')) )/86400);
		?>
		<div>
		<p class="mb-2"><span class="fw-bold me-2">호스팅만료</span> <?php echo $end_date; ?></p>
		<p class="mb-2"><span class="fw-bold me-4">남은기간</span><?php echo $d_day; ?>일</p>
		<p><span class="fw-bold me-4">그누버전</span><?php echo $print_version; ?></p>
		<a href="#" class="btn btn-primary mt-3 btn-sm me-2" target="_blank">호스팅 연장</a><a href="javascript:windowPopup9();" class="btn btn-success mt-3 btn-sm">트래픽</a>
		</div>
  </div>
</div>

<script type="text/javascript">
	function windowPopup9(){
		window.open('#', 'window팝업', 'width=600, height=300, menubar=no, status=no, toolbar=no');
	}
</script>
<div class="py-5 mb-3">&nbsp;</div>
