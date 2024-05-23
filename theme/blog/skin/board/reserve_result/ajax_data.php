<?php
include_once('./_common.php');
include_once('lunarcalendar.php');
include_once('opentime.php');

$holiday = new Lunarcalendar();

$cdate = html_purifier($_POST["c_date"]);
$cdate2 = substr($cdate, 0, 7);
$to_day = date("Y-m-d");

$bot_table = str_replace("_result","",$write_table);

$que1 = sql_fetch("select wr_1,wr_2,wr_3,wr_5,wr_6,wr_7,wr_8 from {$bot_table} where wr_1 = '{$cdate2}'");
$stimes = explode("|", $que1['wr_2']);
$times = explode("|", $que1['wr_3']);
$octimes =  explode("~", $que1['wr_7']);		//오픈시간
$pnum = intval($que1['wr_8']);	//항목당 신청수

$openk = open_confirm($que1['wr_5'],$que1['wr_6'],$que1['wr_7']);

$x = 0;

if($openk == 1) {

echo "<div><p class='pt-3 fs-4 text-primary'>아직 오픈 전입니다.</p><p class='fs-4 text-primary'>예약시작은<br> <span class='text-danger'>".$holiday->getWeekname2($que1['wr_5'])." ".$octimes[0]."</span> 부터입니다.</p><input type='hidden' name='wr_2' value=''></div>";

} elseif($openk == 2) {

echo "<div><p class='pt-5 fs-4 text-primary'>예약이 종료되었습니다.</p><input type='hidden' name='wr_2' value=''></div>";

} else {
	echo "<p class='mb-4 text-danger'>예약할 항목을 선택(클릭)하세요.</p>
	<h3 class='text-success mb-4'>".$holiday->getWeekname2($cdate)."</h3>
	<input type='hidden' name='wr_1' value='{$cdate}'>";

	foreach($times as $key=>$value) {
		$rcount = sql_fetch("select count(*) p_num from {$write_table} where wr_1 = '{$cdate}' and wr_2 = '{$times[$key]}'");
		if($cdate >= $to_day && $rcount['p_num'] < $pnum && !in_array($cdate.$value, $stimes)) {
		$x++;
	?>
	<input type='radio' name='wr_2' class='btn-check mb-2' id='btn-check<?=$key?>' value='<?=$value?>' autocomplete='off'>
	<label class='btn btn-outline-primary btn-hover px-3 py-2 me-3 mb-2' for='btn-check<?=$key?>'><?=$value?></label>

	<?php } }

	if($x == 0) echo "신청이 완료되었습니다.";
}