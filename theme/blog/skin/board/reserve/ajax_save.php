<?php
include_once('./_common.php');

$id = !empty($_POST["id"]) ? $_POST["id"] : 0;
$wr_num = get_next_num($write_table);
$wr_subject = html_purifier($_POST["wr_subject"]);
$wr_content = html_purifier($_POST["wr_content"]);
$wr_name = html_purifier($_POST["wr_name"]);
$wr_1 = html_purifier($_POST["wr_1"]);
$wr_3 = html_purifier($_POST["wr_3"]);
$wr_4 = html_purifier($_POST["wr_4"]);
$wr_5 = html_purifier($_POST["wr_5"]);
$wr_6 = html_purifier($_POST["wr_6"]);
$wr_7 = html_purifier($_POST["wr_7"]);
$wr_8 = html_purifier($_POST["wr_8"]);
$wr_9 = html_purifier($_POST["wr_9"]);

if($id == 0) {

	$sql = " insert into {$write_table}
                set wr_num = '{$wr_num}',
                     wr_comment = 0,
                     wr_option = 'html1',
                     wr_subject = '{$wr_subject}',
                     wr_content = '{$wr_content}',
                     wr_seo_title = '{$wr_subject}',
                     mb_id = '{$member['mb_id']}',
                     wr_name = '{$wr_name}',
                     wr_datetime = '".G5_TIME_YMDHIS."',
                     wr_last = '".G5_TIME_YMDHIS."',
                     wr_ip = '{$_SERVER['REMOTE_ADDR']}',
                     wr_1 = '{$wr_1}',
                     wr_3 = '{$wr_3}',
                     wr_4 = '{$wr_4}',
                     wr_5 = '{$wr_5}',
                     wr_6 = '{$wr_6}',
                     wr_7 = '{$wr_7}',
                     wr_8 = '{$wr_8}',
                     wr_9 = '{$wr_9}' ";
	sql_query($sql);

    //$wr_id = sql_insert_id();

    // 부모 아이디에 UPDATE
    //sql_query(" update $write_table set wr_parent = '$wr_id' where wr_id = '$wr_id' ");

    // 새글 INSERT
    //sql_query(" insert into {$g5['board_new_table']} ( bo_table, wr_id, wr_parent, bn_datetime, mb_id ) values ( '{$bo_table}', '{$wr_id}', '{$wr_id}', '".G5_TIME_YMDHIS."', '{$member['mb_id']}' ) ");

    // 게시글 1 증가
   // sql_query("update {$g5['board_table']} set bo_count_write = bo_count_write + 1 where bo_table = '{$bo_table}'");

} else {

    $sql = " update {$write_table} set wr_3 = '{$wr_3}', wr_4 = '{$wr_4}', wr_5 = '{$wr_5}', wr_6 = '{$wr_6}', wr_7 = '{$wr_7}', wr_8 = '{$wr_8}', wr_9 = '{$wr_9}' where wr_id = '{$id}' ";
	sql_query($sql);
}

echo json_encode(array("ok"=>"ok"));