<?php
	if(strpos($_SERVER['PHP_SELF'], "bbs") !== false) {
		require_once G5_ADMIN_PATH . '/_common.php';
	}

	$ad_menus = "";

	$left_menus = sql_query(" select * from {$g5['menu_table2']} where length(me_code) = 2 and me_use = 1 order by me_code ");
	$ad_menus = sql_query(" select * from {$g5['menu_admin']} where length(me_code) = 2 and me_use = 1 order by me_code ");
?>

<div class="card mt-3" style="width:250px !important;">
	<div class="card-header btn-purple py-2 d-flex justify-content-between fw-bold">관리자메뉴<a class="text-white" href="<?=G5_ADMIN_URL?>/menu_left.php" title="메뉴등록"><i class="bi bi-gear"></i></a></div>
	<div class="card-body py-3">
		<h2 class="accordion-header"><a  class="accordion-button fw-bold collapsed px-3" href="<?=G5_ADMIN_URL?>/main.php"><i class="bi bi-gear me-2 text-danger"></i>관리자</a></h2>
		<?php
			foreach($left_menus as $key=>$field) {

				$sql2 = " select * from {$g5['menu_table2']} where length(me_code)= 4 and left(me_code,2) = '".$field["me_code"]."' and me_use = 1 order by me_code ";
				$left_submenus = sql_query($sql2);

			if(sql_num_rows($left_submenus) == 0) { ?>
				<h2 class="accordion-header"><a  class="accordion-button fw-bold collapsed px-3" href="<?= admin_link($field['me_link']); ?>" target="_<?= $field['me_target']; ?>"><i class="bi bi-gear me-2"></i><?= $field['me_name'] ?></a></h2>
			<?php  } else { ?>
				<div class="accordion accordion-flush" id="accordionLeft2<?=$key?>">
				<div class="accordion-item">
					<h2 class="accordion-header"><button class="accordion-button fw-bold collapsed px-3" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse2<?=$key?>" aria-expanded="false" aria-controls="flush-collapse2<?=$key?>"><i class="bi bi-gear me-2"></i><?= $field['me_name'] ?></button></h2>
					<div id="flush-collapse2<?=$key?>" class="accordion-collapse collapse" data-bs-parent="#accordionLeft2<?=$key?>">
						<div class="accordion-body py-2">
							<div class="list-group list-group-flush">
					<?php foreach($left_submenus as $field2) {

							$sql3 = " select * from {$g5['menu_table2']} where length(me_code)= 6 and left(me_code,4) = '".$field2["me_code"]."' and me_use = 1 order by me_code ";
							$left_submenus2 = sql_query($sql3);

					 if(sql_num_rows($left_submenus2) == 0) { ?>
						<a class="list-group-item list-group-item-action py-1 border-0" href="<?= admin_link($field2['me_link']); ?>" target="_<?= $field2['me_target']; ?>"><i class="bi bi-brightness-low-fill me-2"></i><?= $field2['me_name'] ?></a>
					<?php } else { ?>
						<div class="accordion accordion-flush" id="accordionLeft3<?=$key2?>">
						  <div class="accordion-item">
							<h2 class="accordion-header ps-2"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse3<?=$key2?>" aria-expanded="false" aria-controls="flush-collapse3<?=$key2?>"><i class="bi bi-brightness-low-fill me-2"></i><?= $field2['me_name'] ?></button></h2>
							<div id="flush-collapse3<?=$key2?>" class="accordion-collapse collapse" data-bs-parent="#accordionLeft3<?=$key2?>">
								<div class="accordion-body p-0 ps-2">
									<div class="list-group list-group-flush border rounded ps-2">
								<?php  foreach($left_submenus2 as $field3) { ?>
							<a class="list-group-item list-group-item-action py-1 border-0" href="<?= admin_link($field3['me_link']); ?>" target="_<?= $field3['me_target']; ?>">- <?= $field3['me_name'] ?></a>
						<?php } ?>
							</div></div></div></div></div>
				<?php } } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
	<?php } }

	if(sql_num_rows($left_menus) == 0) { ?>
		<p class="p-3 text-danger"> 관리자메뉴 옆 아이콘을 클릭하여 메뉴를 등록하세요.</p>
	<?php } ?>
		</div>
	</div>
</div>

<!-- 관리자메뉴 -->
<div class="d-block  d-lg-none">
	<div class="card mt-3" style="width:250px !important;">
		<div class="card-header btn-teal py-2">설정관리</div>
			<div class="card-body py-3" style="width:250px !important;">
			<?php foreach ($ad_menus as $key => $field) {

				$sql2 = " select * from {$g5['menu_admin']} where length(me_code) = 4 and left(me_code,2) = '".$field["me_code"]."' and me_use = 1 order by me_code ";
				$ad_submenus = sql_query($sql2);

			if(sql_num_rows($ad_submenus) == 0) { ?>
				<h2 class="accordion-header"><a  class="accordion-button fw-bold collapsed px-3" href="<?= admin_link($field['me_link']); ?>" target="_<?= $field['me_target']; ?>"><i class="bi bi-gear me-2"></i><?= $field['me_name'] ?></a></h2>
			<?php  } else { ?>
			<div class="accordion accordion-flush" id="accordionadLeft2<?=$key?>">
				<div class="accordion-item">
					<h2 class="accordion-header"><button class="accordion-button collapsed fw-bold px-3" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsead2<?=$key?>" aria-expanded="false" aria-controls="flush-collapsead2<?=$key?>"><i class="bi bi-gear me-2"></i><?= $field['me_name'] ?></button></h2>
					<div id="flush-collapsead2<?=$key?>" class="accordion-collapse collapse" data-bs-parent="#accordionadLeft2<?=$key?>">
						<div class="accordion-body py-2">
							<div class="list-group list-group-flush">
							<?php foreach($ad_submenus as $field2) {

								$sql3 = " select * from {$g5['menu_admin']} where length(me_code) = 6 and left(me_code,4) = '".$field2["me_code"]."' and me_use = 1 order by me_code ";
								$ad_submenus2 = sql_query($sql3);

					 if(sql_num_rows($ad_submenus2) == 0) { ?>
							<a class="list-group-item list-group-item-action py-1 border-0" href="<?= admin_link($field2['me_link']); ?>" target="_<?= $field2['me_target']; ?>"><i class="bi bi-brightness-low-fill me-2"></i><?= $field2['me_name'] ?></a>
					<?php } else { ?>
						<div class="accordion accordion-flush" id="accordionadLeft3<?=$key2?>">
						  <div class="accordion-item">
							<h2 class="accordion-header ps-2"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsead3<?=$key2?>" aria-expanded="false" aria-controls="flush-collapsead3<?=$key2?>"><i class="bi bi-brightness-low-fill me-2"></i><?= $field2['me_name'] ?></button></h2>
							<div id="flush-collapsead3<?=$key2?>" class="accordion-collapse collapse" data-bs-parent="#accordionadLeft3<?=$key2?>">
								<div class="accordion-body p-0 ps-2">
									<div class="list-group list-group-flush border rounded ps-2">
								<?php foreach($ad_submenus2 as $field3) { ?>
									<a class="list-group-item list-group-item-action py-1 border-0" href="<?= admin_link($field3['me_link']); ?>" target="_<?= $field3['me_target']; ?>">- <?= $field3['me_name'] ?></a>
								<?php } ?>
							</div></div></div></div></div>
				<?php } } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php } } ?>
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
		<p class="mb-2"><span class="fw-bold me-2">호스팅만료</span> <?php echo $end_date; ?></p>
		<p class="mb-2"><span class="fw-bold me-4">남은기간</span><?php echo $d_day; ?>일</p>
		<p class="mb-3"><span class="fw-bold me-4">그누버전</span><?php echo $print_version; ?></p>
		<a href="#" class="btn btn-primary btn-sm fs-7 me-2" target="_blank">호스팅 연장</a><a href="javascript:windowPopup9();" class="btn btn-success btn-sm fs-7">트래픽</a>
  </div>
</div>

<script type="text/javascript">
	function windowPopup9(){
		window.open('#', 'window팝업', 'width=600, height=300, menubar=no, status=no, toolbar=no');
	}
</script>
<div class="py-5 mb-3">&nbsp;</div>
