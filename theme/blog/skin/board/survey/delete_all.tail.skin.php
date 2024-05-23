<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

foreach($tmp_array as $key=>$value) {
	sql_query("delete from {$write_table}_result where wr_link2 = '{$value}'");
}

alert("자료가 삭제되었습니다.", "./board.php?bo_table=$bo_table");
