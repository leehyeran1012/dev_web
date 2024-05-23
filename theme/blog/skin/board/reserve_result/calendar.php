<?php

$year = substr($cdate,0,4);
$month1 = substr($cdate,5,2);
$month = intval($month1);

$day = 1;
$date = "$cdate-01";
$time = strtotime($date);
$start_week = date('w', $time); // 시작 요일
$total_day = date('t', $time); // 현재 달의 총 날짜
$total_week = ceil(($total_day + $start_week) / 7);  // 달의 총 주수

if($month == 1) {
	$premonth = ($year-1)."-12";
	$nextmonth = $year."-02";
} elseif($month == 12) {
	$premonth = $year."-11";
	$nextmonth = ($year+1)."-01";
} else {
	$month1 = sprintf("%02d",($month-1));
	$month2 = sprintf("%02d",($month+1));
	$premonth = $year."-".$month1;
	$nextmonth = $year."-".$month2;
}

$tgigan = intval($ttime['wr_9']);
if($tgigan > 0) {
	$to_day2 = date("Y-m-d", strtotime("+{$tgigan} days"));
} else {
	$to_day2 = date("Y-m-d");
}

$sc = $sc2 = 0;

$ctcount = count(explode("|", $ttime['wr_3']));
$ncount = intval($ttime['wr_8']);		//항목당 신청수
$allsum = $ncount * $ctcount;	//총 신청수

?>
<div class="table-responsive">
<table class="table table-borderless text-center table-sm">
	<thead>
		<tr class="align-middle" style="height:60px">
			<th class="text-start"><a href="./write.php?bo_table=<?= $bo_table ?>&gomonth=<?=$premonth?>" class="link ms-3"><i class="bi bi-arrow-left-circle fs-3"></i></a></th>
			<th colspan="5" class="text-center fs-4"><?=$year?>년 <?=$month?>월</th>
			<th class="text-end"><a href="./write.php?bo_table=<?= $bo_table ?>&gomonth=<?=$nextmonth?>" class="link me-3"><i class="bi bi-arrow-right-circle fs-3"></i></a></th>
		</tr>
		<tr class="fs-5">
			<th class="text-danger">일</th>
			<th>월</th>
			<th>화</th>
			<th>수</th>
			<th>목</th>
			<th>금</th>
			<th class="text-primary">토</th>
		</tr>
	</thead>
	<tbody>
	<?php for ($i = 0; $i < $total_week; $i++) { ?><tr>
		<?php for ($k = 0; $k < 7; $k++) { ?><td>
			<?php if ( ($day > 1 || $k >= $start_week) && $total_day >= $day ) {

				$c_date = sprintf('%04d-%02d-%02d', $year, $month, $day);

				if($k == 0) {
					$wcolor = "circle_s";
				} elseif($k == 6) {
					$wcolor = "circle_f";
				} else {
					$wcolor = "circle";
				}

				$holiday_name = $holiday->getHolidayname($c_date);
				if ($holiday_name) {
					$wcolor = "circle_s";
				}

				$sc = intval(substr_count($ttime["wr_2"], $c_date));	//신청제외 항목수
				$que2 = sql_fetch("select count(*) as ct from $write_table where wr_1 = '{$c_date}'");
				$sc2 =  intval($que2["ct"]);	//신청항목수

				if($c_date < $to_day2 || (($sc * $ncount)  + $sc2) >= $allsum) {
					$wcolor = "circle_fs";
					$disabled = " disabled";
				} else {
					$disabled = "";
				}

				if($c_date == $to_day) $wcolor = "btn-yellow";
		?>
				<button type="button" class="mx-auto text-center border-0 <?=$wcolor?> text-decoration-none" id="<?=$c_date?>" onclick="optionChange('<?=$c_date?>');"<?=$disabled?>><?=$day++;?></button>
				<?php	 } ?></td>
			<?php } ?></tr>
		<?php } ?>
	</tbody>
</table>
</div>