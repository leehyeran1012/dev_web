<?php
include_once('./_common.php');

$id = $_POST["id"];

$bo_table = $_POST["bo_table"];

$bo_table = $g5['write_prefix'] . $bo_table;

$wr_subject = html_purifier($_POST["wr_subject"]);
$wr_content = html_purifier($_POST["wr_content"]);

for ($i=1; $i<=10; $i++) {
    $var = "wr_$i";
    $$var = "";
    if (isset($_POST['wr_'.$i]) && settype($_POST['wr_'.$i], 'string')) {
        $$var = trim($_POST['wr_'.$i]);
    }
}

    $sql = " update {$write_table}
                set wr_subject = '{$wr_subject}',
                     wr_content = '{$wr_content}',
                     wr_1 = '{$wr_1}',
                     wr_2 = '{$wr_2}',
                     wr_3 = '{$wr_3}',
                     wr_4 = '{$wr_4}',
                     wr_5 = '{$wr_5}',
                     wr_6 = '{$wr_6}',
                     wr_7 = '{$wr_7}',
                     wr_8 = '{$wr_8}',
                     wr_9 = '{$wr_9}',
                     wr_10= '{$wr_10}'
              where wr_id = '{$id}' ";
    sql_query($sql);

die("{\"tdate\":\"{$wr_1}\",\"ok\":\"ok\"}");
