<?php

$x = 0;
$result = sql_query("select wr_subject, wr_content,wr_name,wr_1,wr_2 from {$write_table} where (left(wr_1,10) <= '{$to_day}' and left(wr_2,10) >= '{$to_day}')  order by wr_subject");

if($result) {
	foreach($result as $field) {
		if(strlen($field["wr_subject"]) > 0) $x++;
		if(strlen($field["wr_1"]) > 11 && substr($field["wr_2"],0,10) == $to_day) {
			echo "<p>☆ ".substr($field["wr_1"],11,5)." ".$field['wr_subject']."</p>";
		} elseif(strlen($field["wr_1"]) == 10 && substr($field["wr_2"],0,10) > $to_day) {
			echo "<p>☆ ".$field['wr_subject']."</p>";
		}
	}
}

if($x == 0) {
	echo "<p>● 오늘 일정이 없습니다.</p>";
}
