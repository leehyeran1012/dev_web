<?php
include_once('./_common.php');

$bo_table = $_POST["bo_table"];

$bo_table = $g5['write_prefix'] . $bo_table;

for ($i=1; $i<=10; $i++) {
    $var = "wr_$i";
    $$var = "";
    if (isset($_POST['wr_'.$i]) && settype($_POST['wr_'.$i], 'string')) {
        $$var = trim($_POST['wr_'.$i]);
    }
}

$wr_num = get_next_num($bo_table);
$wr_subject = html_purifier($_POST["wr_subject"]);
$wr_content = html_purifier($_POST["wr_content"]);

if($wr_3 == "") $wr_3 = "#3788d8";
if($wr_4 == "") $wr_4 = "#ffffff";

$sql = " insert into {$bo_table}
                set wr_num = '{$wr_num}',
                     wr_reply = '{$wr_reply}',
                     wr_comment = 0,
                     ca_name = '{$ca_name}',
                     wr_option = '{$wr_option}',
                     wr_subject = '{$wr_subject}',
                     wr_content = '{$wr_content}',
                     wr_seo_title = '{$wr_seo_title}',
                     mb_id = '{$member['mb_id']}',
                     wr_name = '{$wr_name}',
                     wr_datetime = '".G5_TIME_YMDHIS."',
                     wr_last = '".G5_TIME_YMDHIS."',
                     wr_ip = '{$_SERVER['REMOTE_ADDR']}',
                     wr_1 = '{$wr_1}',
                     wr_2 = '{$wr_2}',
                     wr_3 = '{$wr_3}',
                     wr_4 = '{$wr_4}',
                     wr_5 = '{$wr_5}',
                     wr_6 = '{$wr_6}',
                     wr_7 = '{$wr_7}',
                     wr_8 = '{$wr_8}',
                     wr_9 = '{$wr_9}',
                     wr_10 = '{$wr_10}' ";
    sql_query($sql);

die("{\"tdate\":\"{$wr_1}\",\"ok\":\"ok\"}");

