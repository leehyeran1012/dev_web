  <?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_LIB_PATH.'/lunarcalendar.php');
$holiday = new Lunarcalendar();

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

$today = getdate();
$b_mon = $today['mon'];
$b_day = $today['mday'];
$b_year = $today['year'];
if ($year < 1) { // 오늘의 달력 일때
  $month = $b_mon;
  $mday = $b_day;
  $year = $b_year;
}

if(!$year) 	$year = date("Y");

$month1 = sprintf("%02d",$month);

$day = 1;
$date = "$year-$month1-01";
$time = strtotime($date);
$start_week = date('w', $time); // 시작 요일
$total_day = date('t', $time); // 현재 달의 총 날짜
$total_week = ceil(($total_day + $start_week) / 7);  // 달의 총 주수


$times = array("10:00","14:00","17:00","19:00");
$to_day = date("Y-m-d");
$bcolor = "";
if($month ==1) {
	$preyear =  $year-1;
	$premonth = 12;
} elseif($month ==12) {
	$nextyear = $year+1;
	$nextmonth = 1;
} else {
	$preyear =  $year;
	$premonth = $month-1;
	$nextyear = $year;
	$nextmonth = $month+1;
}

$bot_table = str_replace("_result","",$write_table);
$ym = substr($date, 0, 7);
$result2 = sql_fetch("select wr_id, wr_2 from {$bot_table} where wr_1 = '{$ym}'");
if($result) {
	$stimes = explode("|",$result2["wr_2"]);
} else {
	$stimes = [];
}
?>

<div class="container p-0">

	<h3 class="text-success text-center my-3">상담신청(<?=$year?>)</h3>

	<div class="row mb-3 px-2">
	  <div class="col-md text-center">
		<a href="<?= $_SERVER['PHP_SELF'] ?>?bo_table=<?=$bo_table?>&m_id=3050&year=<?=($year-1)?>&month=<?=$month?>" class="btn btn-outline-secondary btn-sm me-2" title="이전년도"><i class="bi bi-chevron-double-left"></i></a>
		<a href="<?= $_SERVER['PHP_SELF'] ?>?bo_table=<?=$bo_table?>&m_id=3050&year=<?=$preyear?>&month=<?=$premonth?>" class="btn btn-outline-secondary btn-sm me-2" title="이전달"><i class="bi bi-chevron-left"></i></a>
		<a href="#" class="btn btn-success btn-sm px-3"><?=$month?>월</a>
		<a href="<?= $_SERVER['PHP_SELF'] ?>?bo_table=<?=$bo_table?>&m_id=3050&year=<?=$nextyear?>&month=<?=$nextmonth?>" class="btn btn-outline-secondary btn-sm ms-2"  disabled title="다음달"><i class="bi bi-chevron-right"></i></a>
		<a href="<?= $_SERVER['PHP_SELF'] ?>?bo_table=<?=$bo_table?>&m_id=3050&year=<?=($year+1)?>&month=<?=$month?>" class="btn btn-outline-secondary btn-sm ms-2" title="다음년도"><i class="bi bi-chevron-double-right"></i></a>
		<a href="<?= $_SERVER['PHP_SELF'] ?>?bo_table=<?=$bo_table?>&m_id=3050&year=<?=$b_year?>&month=<?=$b_mon?>" class="btn btn-secondary btn-sm ms-2" title="다음년도">오늘</a>
		</div>
	</div>

	<table class="table table-bordered">
      <thead>
        <tr class="bg-light text-center">
            <th width='14.3%' class="text-danger">일</th>
            <th width='14.3%'>월</th>
            <th width='14.3%'>화</th>
            <th width='14.3%'>수</th>
            <th width='14.3%'>목</th>
            <th width='14.3%'>금</th>
            <th width='14.3%' class="text-primary">토</th>
        </tr>
     </thead>
     <tbody>

	<?php for ($i = 0; $i < $total_week; $i++) { ?>
	<tr>
	<?php for ($k = 0; $k < 7; $k++) { ?>
		<td height="150">
		<?php if ( ($day > 1 || $k >= $start_week) && $total_day >= $day ) {

				if($k == 0) {
					$wcolor = " text-danger";
				} elseif($k == 6) {
					$wcolor = " text-primary";
				} else {
					$wcolor = "";
				}

				$c_date = sprintf('%04d-%02d-%02d', $year, $month, $day);
				if($c_date == $to_day) $bcolor = " <i class='bi bi-hearts text-danger'></i>";

				//휴일
				$holiday_name = $holiday->getHolidayname($c_date);
				if ($holiday_name) {
					$wcolor = " text-danger";
					$holiday_name = "<span class='text-danger small me-2'> ".$holiday_name."</span>";
				} else {
					$holiday_name = "";
				}
			?>
				<div class="mb-4 text-start<?=$wcolor?>"><?= $day++; ?> <?=$holiday_name ?> &nbsp;<?= $bcolor ?></div>
				<div class="text-center">
			<?php foreach($times as $key=>$value) {
				$result = sql_fetch("select * from {$write_table} where wr_1 = '{$c_date}' and wr_2 = '{$times[$key]}' order by wr_2");
				if($c_date > $to_day && !$result && !in_array($c_date.$value, $stimes)) { ?>
				<a href="<?=$write_href?>&f_date=<?=$c_date?>&f_time=<?=$times[$key]?>&m_id=5010" class="btn btn-outline-success me-2 mb-2"><?=$times[$key]?></a>
			<?php } }
				$bcolor = "";
		 } ?></div>
		</td>
	<?php } ?>
	</tr>
<?php } ?>
    </tbody>
</table>

</div>