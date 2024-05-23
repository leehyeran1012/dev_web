<?php
include_once('./_common.php');

$wr_num = get_next_num($bo_table);
$wr_1 = html_purifier($_POST["wr_1"]);
$wr_3 = html_purifier($_POST["wr_3"]);
$wr_name = "관리자";

$sql = " insert into {$write_table}
                set wr_num = '{$wr_num}',
                     wr_name = '{$wr_name}',
                     wr_datetime = '".G5_TIME_YMDHIS."',
                     wr_last = '".G5_TIME_YMDHIS."',
                     wr_ip = '{$_SERVER['REMOTE_ADDR']}',
                     wr_1 = '{$wr_1}',
                     wr_3 = '{$wr_3}' ";
    sql_query($sql);

alert("등록 되었습니다.", G5_URL."/bbs/board.php?bo_table=$bo_table&ym={$wr_1}");
