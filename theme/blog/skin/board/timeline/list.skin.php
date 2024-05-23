<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/add_style.css">', 0);
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>



<div class="container text-center">
  <div class="row align-items-center">
    <div class="col">      One of three columns    </div>
    <div class="col">
      <div class="vr"></div>
    </div>
    <div class="col">      One of three columns    </div>
  </div>
</div>
<br><br>

<div class="main-content">
	<div class="page-content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-12">
					<div>
						<h5>중앙 타임라인</h5>
						<div class="timeline">
							<?php
							for($i = 0;$i < count($list);$i += 1) { ?>
							<div class="timeline-item <?php echo $i % 2 == 0?'left':'right'?>">
								<i class="icon"><i class="fa <?php echo $list[$i]['wr_1']?>"></i></i>
								<div class="date"><?php echo $list[$i]['wr_2'] != ""?$list[$i]['wr_2']."년":""?> <?php echo $list[$i]['wr_3'] != ""?$list[$i]['wr_3']."월":""?> <?php echo $list[$i]['wr_3'] != ""?$list[$i]['wr_3']."일":""?></div>
								<div class="content">
									<div class="d-flex">
										<!--
										<div class="flex-shrink-0">
											<?php echo get_member_profile_img($list[$i]['mb_id']) ?>
										</div>
										-->
										<div class="flex-grow-1 ms-3">
											<h5><?php echo $list[$i]['wr_subject']?></h5>
											<p class="text-muted mb-2"><?php echo $list[$i]['wr_content']?></p>
											<?php if($write_href) { ?><a href="<?php echo G5_BBS_URL?>/write.php?bo_table=<?php echo $bo_table?>&w=u&wr_id=<?php echo $list[$i]['wr_id']?>">[수정]</a><?php } ?>
										</div>
									</div>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

 <?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn_b01 btn" title="글쓰기"><i class="fa fa-pencil" aria-hidden="true"></i> <span class="">글쓰기</span></a><?php } ?>
