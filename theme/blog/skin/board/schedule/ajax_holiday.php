<?php
include_once('./_common.php');
include_once('holiday.php');

$holiday = new Holiday();

$tdate = $_POST['tdate'];
$bo_table = $_POST['bo_table'];
$tdate = substr($tdate,0,10);
$tdate = date("Y-m-d", strtotime("{$tdate} +10 days"));

$year = substr($tdate,0,4);
$month = substr($tdate,5,2);

$bo_table = $g5['write_prefix'] . $bo_table;
$holidays = [];

for($i =1; $i<=31; $i++) {
	$f_date = sprintf('%04d-%02d-%02d', $year, $month, $i);
	$holiday_name = $holiday->getHolidayname($f_date);
	if($holiday_name) {
		$holidays[$f_date] = $holiday_name;
	}
}

echo json_encode($holidays);
