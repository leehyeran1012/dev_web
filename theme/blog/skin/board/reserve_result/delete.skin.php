<?php
include_once('./_common.php');

$sql = " delete from $write_table where wr_id = '$wr_id'";
sql_query($sql);

sql_query(" delete from {$g5['board_new_table']} where bo_table = '{$bo_table}' and wr_parent = '$wr_id' ");

alert("취소 되었습니다.","./board.php?bo_table=$bo_table&type=2&m_id=5060");