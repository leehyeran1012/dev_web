<?php

//	$total_row = 100;         // 총 게시글 수
//	$now_page = 1;          // 현재 페이지 번호

function paging($bo_table, $total_row, $page_row_num, $page_block_num, $now_page) {

    $total_page = ceil($total_row/$page_row_num);             // 총 페이지
    $total_black = ceil($total_page/$page_block_num);      // 총 블럭

    $now_block = ceil($now_page/$page_block_num);                         // 현재 페이지의 블럭
    $start_page = (($now_block*$page_block_num)-($page_block_num-1));      // 가져올 페이지의 시작번호
    $last_page = ($now_block*$page_block_num);                        // 가져올 마지막 페이지 번호

    $prev_page = ($now_block*$page_block_num)-$page_block_num;             // 이전 블럭 이동시 첫 페이지
    $next_page = ($now_block*$page_block_num)+1;                      // 다음 블럭 이동시 첫 페이지

    // 이전 10개
?>

<nav aria-label='Page navigation'>
  <ul class='pagination'>

<?php
   if($total_row > 0) {
    if($now_block > 1) {
?>
     <li class='page-item'><a class='page-link' href="./board.php?bo_table=<?=$bo_table?>&page=<?=$prev_page?>" title='이전 10개' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>
<?php
	}

    // 페이지 리스트
    if($last_page < $total_page) {
        $for_end=$last_page;
    } else {
        $for_end=$total_page;
    }

    for($i=$start_page; $i<=$for_end; $i++) { ?>
		<li class='page-item'><a  href='./board.php?bo_table=<?=$bo_table?>&page=<?=$i?>' class='page-link<?= ($now_page == $i) ? " active disabled" : ""; ?>'><?=$i ?></a></li>
<?php
    }
    if($now_block < $total_black) { ?>
    <li class='page-item'><a  class='page-link' href="./board.php?bo_table=<?=$bo_table?>&page=<?=$next_page?>" title='다음 10개' aria-label='Next'> <span aria-hidden='true'>&raquo;</span></a></li>
<?php } } } ?>
 </ul>
</nav>
