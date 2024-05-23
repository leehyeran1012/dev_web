<?php
include_once('./_common.php');

$tdate = isset($_POST['tdate']) ? $_POST['tdate'] : date("Y-m-d");
$yymm =  substr($tdate,0,7);

$que1 = sql_query("select wr_subject,wr_1,wr_2,wr_content from {$write_table} where left(wr_1,7) = '{$yymm}' order by wr_1,wr_subject");
$x=0;
?>
<table class='table table-bordered text-center'>
	<tr class='bg-light text-center'>
		<th>제목</th>
		<th width="200">일자</th>
		<th>내용</th>
	</tr>
<?php
foreach($que1 as $field) {
$x++;
?>
<tr>
	<td><?= $field['wr_subject'] ?></td>
	<td><?= date("y.n.j",strtotime(substr($field['wr_1'],0,10))) ?>~<?= date("y.n.j",strtotime(substr($field['wr_2'],0,10))) ?></td>
	<td><?= $field['wr_content'] ?></td>
</tr>
<?php
}

if($x==0) {

echo "<tr>
	<td colspan='3' class='text-center'>자료가 없습니다.</td>
</tr>";
}
?>
</table>