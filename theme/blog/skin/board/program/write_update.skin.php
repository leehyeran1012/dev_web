<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$wr_5 = implode('|', $_POST['wrk_1']);
$wr_6 = implode('|', $_POST['wrk_2']);
$wr_7 = implode('|', $_POST['wrk_3']);
$wr_8 = implode('|', $_POST['wrk_4']);


$sql10 = " update $write_table set wr_5 = '$wr_5', wr_6 = '$wr_6', wr_7 = '$wr_7', wr_8 = '$wr_8' where wr_id = '$wr_id'";
sql_query($sql10);

alert("저장 되었습니다..","./board.php?bo_table=$bo_table");
