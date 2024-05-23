<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$wr_2 = implode('|', $cont);
$wr_2 = html_purifier($wr_2);

$sql = " update $write_table set wr_2 = '{$wr_2}' where wr_id = '{$wr_id}'";
sql_query($sql);

alert("저장 되었습니다.","./write.php?w=u&bo_table={$bo_table}&wr_id={$wr_id}&ym={$wr_1}");
