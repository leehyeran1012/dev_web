
<!-- #adm_visit_time -->

<?php
$fr_date = date("Y-m-d",strtotime("-2 day"));
$to_date = date("Y-m-d");

$sum_count = 0;
$arr = array();

$sql = " select vi_date, SUBSTRING(vi_time,1,2) as vi_hour, count(vi_id) as cnt
            from {$g5['visit_table']}
            where vi_date between '{$fr_date}' and '{$to_date}'
            group by vi_date, vi_hour
            order by vi_date, vi_hour ";

$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
    $arr[$row['vi_date']][$row['vi_hour']] = $row['cnt'];
    $sum_count += $row['cnt'];
}

$data1 = $data2 = $data3 = $data4 = $rates = [];

$k = 0;
if ($i) {
	for ($i=0; $i<24; $i++) {
		$hour = sprintf("%02d", $i);
		$count = isset($arr[$hour]) ? (int) $arr[$hour] : 0;
		$rate = ($count / $sum_count * 100);
		$s_rate = round($rate, 1);
		$data1[] = $hour;
	}
}

$k = 0;
if ($i) {
	$date = date("Y-m-d");
	for ($i=0; $i<24; $i++) {
		$hour = sprintf("%02d", $i);
		$count = isset($arr[$date][$hour]) ? (int) $arr[$date][$hour] : 0;
		$rate = ($count / $sum_count * 100);
		$s_rate = round($rate, 1);
		$data2[] = $count;
	}
}

$k = 0;
if ($i) {
	$date = date("Y-m-d",strtotime("-1 day"));
	for ($i=0; $i<24; $i++) {
		$hour = sprintf("%02d", $i);
		$count = isset($arr[$date][$hour]) ? (int) $arr[$date][$hour] : 0;
		$rate = ($count / $sum_count * 100);
		$s_rate = round($rate, 1);
		$data3[] = $count;
	}
}

$k = 0; if ($i) {
	$date = date("Y-m-d",strtotime("-2 day"));
	for ($i=0; $i<24; $i++) {
		$hour = sprintf("%02d", $i);
		$count = isset($arr[$date][$hour]) ? (int) $arr[$date][$hour] : 0;
		$rate = ($count / $sum_count * 100);
		$s_rate = round($rate, 1);
		$data4[] = $count;
	}
}

$data1 = implode(",", $data1);
$data2 = implode(",", $data2);
$data3 = implode(",", $data3);
$data4 = implode(",", $data4);
$pielabel = str_replace(",","','",$data1);
?>

<ul class="list-group">
	<li class="list-group-item bg-primary-subtle"><a href="<?php echo G5_ADMIN_URL ?>/visit_hour.php">
		<div class="d-flex justify-content-between">
			<div class="fw-bold text-dark">시간별 방문자 현황 (최근 3일)</div>
			<div><i class="bi bi-plus-lg text-dark"></i></div>
		</div></a>
	</li>
	<li class="list-group-item" style="height:280px">
		<div class="container p-3">
			<canvas id="timechart" style="position: relative; height:250px; width:100%"></canvas>
		</div>
	</li>
</ul>

<script>
	const ctx2 = document.getElementById('timechart');
	new Chart(ctx2, {
		type: 'line',
		data: {
			labels: ['<?=$pielabel?>'],
			datasets: [
				{
					label: '오늘',
					data: [<?=$data2?>],
					borderWidth: 1
				},
				{
					label: '어제',
					data: [<?=$data3?>],
					borderWidth: 1
				},
				{
					label: '그제',
					data: [<?=$data4?>],
					borderWidth: 1
				},
			]
		},
		options: {
		//	responsive: false,
			plugins: {
				title: {
					display: false,
				},
				legend: {
					//	display: false,
					position: 'bottom',
					padding: {
						bottom: 20
					}
				}
			},
			scales: {
				y: {
					min: 0,
					max: 10,
					ticks: {
					  stepSize: 1 // <----- This prop sets the stepSize
					}
				},

			}
		}
	});
</script>

<!-- #adm_visit_time -->
