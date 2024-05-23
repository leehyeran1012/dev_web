<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$latest_skin_url.'/style.css">', 0);

$list_count = (is_array($list) && $list) ? count($list) : 0;
?>

<div class="row">
    <div class="col-sm-12 col-md-7 mt-3">
		<ul class="nav nav-tabs">
		  <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#notice">공지사항</a></li>
		  <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#qna">묻고답하기</a></li>
		  <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#free">자유게시판</a></li>
		</ul>
		<div class="tab-content">
		  <div class="tab-pane fade show active" id="notice">
				<?php  echo latest('theme/bs_list', 'notice', 5, 23); ?>
		  </div>
		  <div class="tab-pane fade" id="qna">
				<?php  echo latest('theme/bs_list', 'qa', 5, 23); ?>
		  </div>
		  <div class="tab-pane fade" id="free">
				<?php  echo latest('theme/bs_list', 'free', 5, 23); ?>
		  </div>
		</div>
    </div>
    <div class="col-sm-12 col-md-5 mt-3">
		<?php  echo latest('theme/bs_popup', 'gallery', 15, 23); ?>
    </div>
</div>
