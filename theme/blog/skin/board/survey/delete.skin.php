<?php
include_once('./_common.php');

$g_num = isset($_GET["g_num"]) ? intval($_GET["g_num"]) : 0;

sql_query("delete from {$write_table}_result where wr_link2 = '{$g_num}'");

alert("자료가 삭제 되었습니다.", G5_BBS_URL."/board.php?bo_table=$bo_table");
