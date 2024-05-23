<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
?>

<p class="fs-6 fw-bold mb-3">접속자집계</p>
<ul class="nav flex-column">
	<li class="nav-item d-flex justify-content-between align-items-center mb-1">
		<span class="fs-6 text-body-secondary">오늘</span>
		<span class="badge bg-primary rounded-pill"><?php echo number_format($visit[1]) ?></span>
	</li>
	<li class="nav-item d-flex justify-content-between align-items-center mb-1">
		<span class="fs-6 text-body-secondary">어제</span>
		<span class="badge bg-primary rounded-pill"><?php echo number_format($visit[2]) ?></span>
	</li>
	<li class="nav-item d-flex justify-content-between align-items-center mb-1">
		<span class="fs-6 text-body-secondary">최대</span>
		<span class="badge bg-primary rounded-pill"><?php echo number_format($visit[3]) ?></span>
	</li>
	<li class="nav-item d-flex justify-content-between align-items-center mb-1">
		<span class="fs-6 text-body-secondary">전체</span>
		<span class="badge bg-primary rounded-pill"><?php echo number_format($visit[4]) ?></span>
	</li>
</ul>
