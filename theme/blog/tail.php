<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(isset($admin_use_tables) && in_array($bo_table, $admin_use_tables)) {
    require_once(G5_ADMIN_PATH.'/admin.tail2.php');
    return;
}
?>

		</div><!-- 왼쪽 끝-->
  <?php if($side_use) { ?>
		<div class="col-lg-12 col-xl-3"><!-- 오른쪽 시작-->

			  <div class="position-sticky" style="top: 2rem;">
					<div class="px-4 py-3 mb-3 bg-body-tertiary border rounded">
						<?php echo poll('theme/basic'); ?>
					</div>

					<!-- <div class="px-4 py-3 mb-3 bg-body-tertiary border rounded">
					  <p class="mb-1">다른 맵의 디자인을 참고해라. 이건 표절하라는게 아니다. 하지만 아이디어가 메말랐다고 생각되면 당신이 칭송하던 맵에 들어가 디자인을 참고해라. 후에 여러 가지 아이디어가 떠오를 것이고, 그 아이디어를 자신의 맵에 적용시키면 된다. Dave J.</p>
					</div> -->

					<div class="px-2 py-3 mb-3 bg-body-tertiary border rounded">
						  <?php  echo latest('theme/bs_webzine', 'notice', 3, 20); ?>
					</div>

					<div class="px-2 py-3 mb-3 bg-body-tertiary border rounded">
					     <p class="fw-bold text-dark-emphasis border-bottom pb-2">자료실</p>
						  <?php  echo latest('theme/bs_archive', 'notice', 5, 20); ?>
					</div>

					<div class="px-2 py-3 mb-3 bg-body-tertiary border rounded">
					    <p class="fw-bold text-dark-emphasis border-bottom pb-2">기타</p>
					</div>

					<div class="px-2 py-3 mb-3 bg-body-tertiary border rounded">
					    <p class="fw-bold text-dark-emphasis border-bottom pb-2">실시간 인기 검색어</p>
						<?php echo popular('theme/realtime_rank', 50, 30); ?>
					</div>

			  </div>

		</div><!-- 오른쪽 끝-->
<?php  } ?>
	</div>
	<script>
		function windowPopup(url) {
			var popOption = "top=10, left=10, width=500, height=600, status=no, menubar=no, toolbar=no, resizable=no";
			window.open(url, '새창', popOption);
		}
	</script>
</main>
	<div class="container py-5"></div>
	<div class="container-fluid border-top">
		<div class="container">
			  <footer class="row my-5">
				<div class="col-sm-12 col-md-3 mb-3 p-0">
					<p class="mb-2"><a href="<?=G5_URL?>"><img src="<?=G5_THEME_URL?>/img/logo2.png"  alt="..." style="width:230px"></a></p>
				</div>
				<div class="col-sm-12 col-md-4 mb-3">
					<p class="mb-1 text-body-secondary"><strong>회사명 : 회사명 / 대표 : 대표자명</strong></p>
					<p class="mb-1 text-body-secondary">주소  : OO도 OO시 OO구 OO동 123-45</p>
					<p class="mb-1 text-body-secondary">사업자 등록번호  : 123-45-67890</p>
					<p class="mb-1 text-body-secondary">전화 :  02-123-4567  팩스  : 02-123-4568</p>
					<p class="mb-1 text-body-secondary">통신판매업신고번호 :  제 OO구 - 123호</p>
					<p class="mb-1 text-body-secondary">개인정보관리책임자 :  정보책임자명</p>
				</div>

				<div class="col-5 col-md-2 mb-3">
				  <h5 class="fs-6 fw-bold mb-3">회사소개</h5>
				  <ul class="nav flex-column">
					<li class="nav-item fs-6 mb-1"><a href="<?php echo get_pretty_url('content', 'company'); ?>" class="nav-link p-0 text-body-secondary">회사소개</a></li>
					<li class="nav-item fs-6 mb-1"><a href="<?php echo get_pretty_url('content', 'privacy'); ?>" class="nav-link p-0 text-body-secondary">개인정보처리방침</a></li>
					<li class="nav-item fs-6 mb-1"><a href="<?php echo get_pretty_url('content', 'provision'); ?>" class="nav-link p-0 text-body-secondary">서비스이용약관</a></li>
				  </ul>
				</div>

				<div class="col-5 col-md-2 mb-3">
					<?php echo visit('theme/basic'); // 접속자집계 ?>
				</div>

				<div class="col-2 col-md-1 mb-3 text-end">
					<a href="#"><i class="bi bi-arrow-up-square-fill fs-1 text-danger"></i></a>
				</div>

				<div class="d-flex flex-column flex-sm-row justify-content-between p-0 py-2 my-4 border-top">
				  <p>&copy; 2023 Company, Inc. All rights reserved.</p>
				  <ul class="list-unstyled d-flex">
					<li class="ms-3"><a class="link-body-emphasis" href="#"><i class="bi bi-twitter fs-5"></i></a></li>
					<li class="ms-3"><a class="link-body-emphasis" href="#"><i class="bi bi-facebook fs-5"></i></a></li>
					<li class="ms-3"><a class="link-body-emphasis" href="#"><i class="bi bi-line fs-5"></i></a></li>
				  </ul>
				</div>
			  </footer>
		</div>
	</div>
<div class="fixed-bottom text-center py-2 bg-light d-block d-md-none">
  <div class="row">
    <div class="col"><a href="<?=G5_URL?>" class="link border-0 rounded"><i class="bi bi-house-door fs-5"></i></a></div>
    <div class="col">
 		<div class="btn-group dropend">
		  <a class="link border-0 rounded" data-bs-toggle="dropdown" aria-expanded="false" title="클릭메뉴"><i class="bi bi-grid-fill fs-5"></i></a>
		  <ul class="dropdown-menu" style="min-width:150px">
			<li><a class="dropdown-item small" href="<?= G5_BBS_URL ?>/faq.php">FAQ</a></li>
			<li><a class="dropdown-item small" href="<?= G5_BBS_URL ?>/qalist.php">1:1문의</a></li>
			<li><a class="dropdown-item small" href="<?= G5_BBS_URL ?>/current_connect.php">접속자</a></li>
			<li><a class="dropdown-item small" href="<?= G5_BBS_URL ?>/new.php">새글</a></li>
		  </ul>
		</div>
	</div>
    <div class="col">
 			<div class="btn-group dropstart">
			  <a class="link border-0 rounded" data-bs-toggle="dropdown" aria-expanded="false" title="클릭메뉴"><i class="bi bi-gear fs-5"></i></a>
			  <ul class="dropdown-menu" style="min-width:150px">
				<?php if ($is_member) {  ?>
				<li><a class="dropdown-item small" href="#" onclick="windowPopup('<?= G5_BBS_URL ?>/point.php')">포인트 (<?php echo number_format($member['mb_point']); ?>)</a></li>
				<li><a class="dropdown-item small" href="#" onclick="windowPopup('<?= G5_BBS_URL ?>/memo.php')">쪽지 (0)</a></li>
				<li><a class="dropdown-item small" href="#" onclick="windowPopup('<?= G5_BBS_URL ?>/scrap.php')">스크랩</a></li>
				<li><a class="dropdown-item small" href="<?= G5_BBS_URL ?>/member_confirm.php?url=<?= G5_BBS_URL ?>/register_form.php">정보수정</a></li>
				<li><a class="dropdown-item text-primary small" href="<?= G5_BBS_URL ?>/logout.php">로그아웃</a></li>
				<?php if ($is_admin) {  ?>
				<li><a class="dropdown-item small" href="<?= correct_goto_url(G5_ADMIN_URL); ?>"><strong>관리자 모드</strong></a></li>
				<?php } } else {  ?>
				<li><a class="dropdown-item small" href="<?= G5_BBS_URL ?>/login.php">로그인</a></li>
				<li><a class="dropdown-item small" href="<?= G5_BBS_URL ?>/register.php">회원가입</a></li>
				<?php } ?>
			  </ul>
			</div>
	</div>
    <div class="col"><a href="<?=G5_BBS_URL?>/content.php?co_id=map" class="link border-0 rounded"><i class="bi bi-geo-alt fs-5"></i></a></div>
    <div class="col">&nbsp;</div>
  </div>
</div>

<script>
	AOS.init({ duration: 1000 });
</script>

<?php
if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>
<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>
<!-- } 하단 끝 -->

<?php
include_once(G5_THEME_PATH."/tail.sub.php");