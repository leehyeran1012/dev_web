  <div class="d-flex justify-content-between">
	  <div class="pt-2">
            <span class="badge bg-dark-subtle text-dark-emphasis">P<?php echo $page ?>-T<?php echo number_format($total_count) ?></span>
	  </div>
	  <div>
            <?php if ($rss_href) { ?><a href="<?php echo $rss_href ?>" class="btn_b01 btn" title="RSS"><i class="fa fa-rss" aria-hidden="true"></i><span class="sound_only">RSS</span></a><?php } ?>
            <button type="button" class="btn_bo_sch btn_b01 btn" title="게시판 검색" data-bs-toggle="modal" data-bs-target="#search"><i class="fa fa-search" aria-hidden="true"></i><span class="sound_only">게시판 검색</span></button>
            <?php if ($write_href) { ?><a href="<?php echo $write_href ?>" class="btn_b01 btn" title="글쓰기"><i class="fa fa-pencil" aria-hidden="true"></i><span class="sound_only">글쓰기</span></a><?php } ?>
        	<?php if ($is_admin == 'super' || $is_auth) {  ?>
			<div class="btn-group dropstart">
			  <button type="button" class="btn btn-sm rounded" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-gear"></i></button>
			  <ul class="dropdown-menu" style="min-width:70px">
				<?php if($is_checkbox) { ?>
					<li><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="dropdown-item"><i class="fa fa-trash-o"></i> 삭제</button></li>
					<li><button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="dropdown-item"><i class="fa fa-file"></i> 복사</button></li>
					<li><button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class="dropdown-item"><i class="fa fa-arrows-alt"></i> 이동</button></li>
					<?php } ?>
					<li><button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#search"><i class="fa fa-search"></i> 검색</button></li>
					<?php if($list_href) { ?><li><a href="<?= $list_href ?>" class="dropdown-item"><i class="fa fa-list" aria-hidden="true"></i> 목록</a></li><?php } ?>
					<?php if($write_href) { ?><li><a href="<?= $write_href ?>" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true"></i> 글쓰기</a></li><?php } ?>
			  </ul>
			</div>
		        <?php } ?>
        	</li>
	  </div>
  </div>
