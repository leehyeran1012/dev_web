<?php
$today = time();
$week = date("w");

$week_first = $today-($week*86400);

$fr_date = date("Y-m-d",$week_first-(86400*21));
$to_date = date("Y-m-d",$today);

$weekday = array ('일', '월', '화', '수', '목', '금', '토');

$sum_count = 0;
$arr = $week_arr = array();

$sql = " select * from {$g5['visit_sum_table']} where vs_date between '{$fr_date}' and '{$to_date}' group by vs_date order by vs_date ";
$result = sql_query($sql);

for ($i=0; $row=sql_fetch_array($result); $i++) {
    $arr[$row['vs_date']] = $row['vs_count'];
    $week_arr[date("w",strtotime($row['vs_date']))] += $row['vs_count'];

    $sum_count += $row['vs_count'];
}
?>

<ul class="list-group">
	<li class="list-group-item bg-primary-subtle"><a href="<?php echo G5_ADMIN_URL ?>/visit_week.php">
		<div class="d-flex justify-content-between">
			<div class="fw-bold text-dark">요일별 방문자 현황 (최근 4주)</div>
			<div><i class="bi bi-plus-lg text-dark"></i></div>
		</div></a>
	</li>
	<li class="list-group-item" style="height:280px">
		<div class="container p-3">
			<canvas id="weekchart" style="position: relative; height:250px; width:100%"></canvas>
		</div>
	</li>
</ul>

<?php
$data1 = $data2 = $data3 = $data4 = $rates = [];

for ($i=0; $i<7; $i++) {
	$count = isset($week_arr[$i]) ? (int) $week_arr[$i] : 0;
	$rate = ($count / $sum_count * 100);
	$s_rate = round($rate, 1);
	$rates[] = $weekday[$i]."(".$s_rate."%)";
}

 for ($d=$week_first; $d<($week_first+86400*7); $d+=86400) {
	 $count = $arr[date("Y-m-d",$d)];
	 if(!$count) $count=0;
	 $data1[] = $count;
}
for ($d=($week_first-86400*7); $d<($week_first); $d+=86400) {
	$count = $arr[date("Y-m-d",$d)];
	if(!$count) $count=0;
	 $data2[] = $count;
 }

for ($d=($week_first-86400*14); $d<($week_first-86400*7); $d+=86400) {
	$count = $arr[date("Y-m-d",$d)];
	if(!$count) $count=0;
	 $data3[] = $count;
}

for ($d=($week_first-86400*21); $d<($week_first-86400*14); $d+=86400) {
	$count = $arr[date("Y-m-d",$d)];
	if(!$count) $count=0;
	 $data4[] = $count;
}

$data1 = implode(",", $data1);
$data2 = implode(",", $data2);
$data3 = implode(",", $data3);
$data4 = implode(",", $data4);
$data5 = implode(",", $rates);
$pielabel = str_replace(",","','",$data5);

?>
<script>
	const ctx = document.getElementById('weekchart');
	new Chart(ctx, {
		type: 'line',
		data: {
			labels: ['<?=$pielabel?>'],
			datasets: [
				{
					label: '이번주',
					data: [<?=$data1?>],
					borderWidth: 1
				},
				{
					label: '저번주',
					data: [<?=$data2?>],
					borderWidth: 1
				},
				{
					label: '2주전',
					data: [<?=$data3?>],
					borderWidth: 1
				},
				{
					label: '3주전',
					data: [<?=$data4?>],
					borderWidth: 1
				}
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
					suggestedMax: 15,
					ticks: {
					  stepSize: 1 // <----- This prop sets the stepSize
					}
				}
			}
		}
	});
</script>

<!-- #adm_visit_week -->
