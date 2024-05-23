<?php
include_once("../head.php");

$gb = !empty($_GET["gb"]) ? intval($_GET["gb"]) : 0;

if($gb == 1) {

	$year =   !empty($_GET["year"]) ? intval($_GET["year"]) : 0;
	$month =   !empty($_GET["month"]) ? intval($_GET["month"]) : 0;

	$db->query("delete from $table_sangdamreg where left(s_date,4) < ? and stu_id in ('제외','설정','개설')", $year);

	$db->query("delete from $table_sangdamreg where left(s_date,4) = ? and s_month = ? and stu_id = '제외'", $year, $month);

	$postData = !empty($_POST["cont"]) ? $_POST["cont"] : "";

	if(!empty($postData)) {
		foreach ($postData as $value) {
			$value1 = explode("/", $purifier->purify($value));
			if($value1[3] == "제외") {
			$db->query("insert into $table_sangdamreg (s_date,s_week,s_time,stu_id,s_month ) values (?, ?, ?, ?, ?)", $value1[0], $value1[1], $value1[2], '제외', $month);
			}
		}
	}

	$db->query("delete from $table_sangdamreg where left(s_date,4) = ? and s_month < ? and stu_id = '제외'", $year, ($month-1));

} elseif($gb == 2) {

	$tomonth =   !empty($_GET["tomonth"]) ? $purifier->purify($_GET["tomonth"]) : 0;

	$day1  = !empty($_POST["day1"]) ? $purifier->purify($_POST["day1"]) : "1/25/25";
	$day1 = str_replace(" ","",$day1);

	$result = $db->query("select * from $table_sangdamreg where s_date = ? and stu_id = '설정'", $tomonth)->fetchArray();
	if($result) {
		$db->query("update $table_sangdamreg set s_time = ? where s_date = ? and stu_id = '설정'", $day1, $tomonth);
	} else {
		$db->query("insert into $table_sangdamreg (s_date,s_time,stu_id) values (?, ?, ?)", $tomonth, $day1, '설정');
	}

} elseif($gb == 3) {

	$tomonth =   !empty($_GET["tomonth"]) ? $purifier->purify($_GET["tomonth"]) : 0;
	$day1  = !empty($_POST["day2"]) ? $purifier->purify($_POST["day2"]) : "10:00,14:00,17:00,19:00";

	$result = $db->query("select * from $table_sangdamreg where s_date = ? and stu_id = '개설'", $tomonth)->fetchArray();
	if($result) {
		$db->query("update $table_sangdamreg set s_time = ? where s_date = ?", $day1, $tomonth);
	} else {
		$db->query("insert into $table_sangdamreg (s_date,s_time,stu_id) values (?, ?, ?)", $tomonth, $day1, '개설');
	}
}

$db->query("optimize table $table_sangdamreg");

$db->close();
?>
<script>
 alert('저장 되었습니다.');
 location.replace('sangdam_config.php?to_month=<?=$month?>');
</script>
<?php include_once("../foot.php"); ?>