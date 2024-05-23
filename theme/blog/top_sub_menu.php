<ul id="hd_qnb">
	<!-- <li><a href="<?= G5_BBS_URL ?>/faq.php" title="알림" class="pushmsg" title="알림"><i class="fa fa-bell-o" aria-hidden="true"></i><span>알림</span><strong class="pushmsg-num">1</strong></a></li> -->
	<li><a href="<?= G5_BBS_URL ?>/faq.php" title="FAQ"><i class="fa fa-question" aria-hidden="true"></i><span>FAQ</span></a></li>
	<li><a href="<?= G5_BBS_URL ?>/qalist.php" title="1:1문의"><i class="fa fa-comments" aria-hidden="true"></i><span>1:1문의</span></a></li>
	<li><a href="<?= G5_BBS_URL ?>/current_connect.php" class="visit" title="접속자"><i class="fa fa-users" aria-hidden="true"></i><span>접속자</span><strong class="visit-num"><?= connect('theme/basic'); ?></strong></a></li>
	<li><a href="<?= G5_BBS_URL ?>/new.php" title="새글"><i class="fa fa-history" aria-hidden="true"></i><span>새글</span></a></li>
	<div class="btn-group dropstart">
		<button type="button" class="btn btn-primary ms-2" data-bs-toggle="dropdown" aria-expanded="false" title="클릭메뉴"><i class="fa fa-cog fa-spin" aria-hidden="true"></i></button>
		<ul class="dropdown-menu" style="min-width:150px">
		<?php if ($is_member) {  ?>
			<li><a class="dropdown-item small" href="#" onclick="windowPopup('<?= G5_BBS_URL ?>/point.php')">포인트 (<?php echo number_format($member['mb_point']); ?>)</a></li>
			<li class="py-1"><a class="dropdown-item small" href="#" onclick="windowPopup('<?= G5_BBS_URL ?>/memo.php')">쪽지 (0)</a></li>
			<li><a class="dropdown-item small" href="#" onclick="windowPopup('<?= G5_BBS_URL ?>/scrap.php')">스크랩</a></li>
			<li class="py-1"><a class="dropdown-item small" href="<?= G5_BBS_URL ?>/member_confirm.php?url=<?= G5_BBS_URL ?>/register_form.php">정보수정</a></li>
			<li><a class="dropdown-item text-primary small" href="<?= G5_BBS_URL ?>/logout.php">로그아웃</a></li>
			<?php if ($is_admin) {  ?>
			<li class="pt-3"><a class="dropdown-item small" href="<?= correct_goto_url(G5_ADMIN_URL); ?>"><strong>관리자 모드</strong></a></li>
			<?php } } else {  ?>
			<li><a class="dropdown-item small" href="<?= G5_BBS_URL ?>/login.php">로그인</a></li>
			<li class="py-1"><a class="dropdown-item small" href="<?= G5_BBS_URL ?>/register.php">회원가입</a></li>
		<?php } ?>
		</ul>
	</div>
</ul>