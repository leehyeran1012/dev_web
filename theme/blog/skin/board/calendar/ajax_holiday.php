<?php
include_once('./_common.php');
include_once('holiday.php');

$holiday = new Holiday();

$tdate = isset($_POST["tdate"]) ? $_POST["tdate"] : date("Y-m-d");

$year = substr($tdate,0,4);
$month = substr($tdate,5,2);

$holidays = [];

for($i =1; $i<=31; $i++) {
	$f_date = sprintf('%04d-%02d-%02d', $year, $month, $i);
	$holiday_name = $holiday->getHolidayname($f_date);
	if($holiday_name) {
		$holidays[$f_date] = $holiday_name;
	}
}

echo json_encode($holidays);
