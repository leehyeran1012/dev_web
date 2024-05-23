<?php
include_once('./_common.php');
include_once(G5_THEME_LIB_PATH.'/lunarcalendar.php');

$holiday = new Lunarcalendar();

$tdate = $_POST['tdate'];

$yymm =  substr($tdate,0,7);


$bo_table = "calendar";
$bo_table2 = "sangdam_result";

$bo_table = $g5['write_prefix'] . $bo_table;
$bo_table2 = $g5['write_prefix'] . $bo_table2;

$que1 = sql_query("select wr_subject,wr_1,wr_2,wr_content from {$bo_table} where left(wr_1,7) = '{$yymm}' order by wr_1,wr_subject");
$x=0;
echo "<table class='table table-bordered'>";
echo "<tr class='bg-light text-center'>
	<th>제목</th>
	<th>시작일자</th>
	<th>종료일자</th>
	<th>내용</th>
</tr>";

foreach($que1 as $field) {
$x++;

echo "<tr>
	<td>".$field['wr_subject']."</td>
	<td>".$field['wr_1']."</td>
	<td>".$field['wr_2']."</td>
	<td>".$field['wr_content']."</td>
</tr>";
}

if($x==0) {

echo "<tr>
	<td colspan='4' class='text-center'>자료가 없습니다.</td>
</tr>";
}

echo "</table>";