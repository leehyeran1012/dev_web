
<!-- #adm_visit_os -->

<?php
include_once(G5_LIB_PATH.'/visit.lib.php');

$fr_date = date("Y-m-d",strtotime("-6 day"));
$to_date = date("Y-m-d");

$labels = $datas = $arr = array();

$sql = " select * from {$g5['visit_table']} where vi_date between '$fr_date' and '$to_date' ";
$result = sql_query($sql);

$result = sql_query($sql);
while ($row=sql_fetch_array($result)) {
    $s = $row['vi_os'];
    if(!$s) $s = get_os($row['vi_agent']);

    if( isset($arr[$s]) ){
        $arr[$s]++;
    } else {
        $arr[$s] = 1;
    }
}


if (count($arr)) {
	arsort($arr);
	foreach ($arr as $key=>$value) {
		$count = $arr[$key];

		if (!$key) $key = 'Unknown';

		$labels[] = $key;
		$datas[] = $count;
	}
}

$label = implode(",", $labels);
$pielabel = str_replace(",","','",$label);
$data = implode(",", $datas);

?>

<ul class="list-group">
	<li class="list-group-item bg-primary-subtle"><a href="<?php echo G5_ADMIN_URL ?>/visit_os.php">
		<div class="d-flex justify-content-between">
			<div class="fw-bold text-dark">접속 OS별 방문자 현황(최근 7일)</div>
			<div><i class="bi bi-plus-lg text-dark"></i></div>
		</div></a>
	</li>
	<li class="list-group-item" style="height:280px">
		<div class="container p-3">
			<canvas id="oschart" style="position: relative; height:250px; width:100%"></canvas>
		</div>
	</li>
</ul>

<script>
	const ctx5 = document.getElementById('oschart');
	new Chart(ctx5, {
		type: 'bar',
		data: {
			labels: ['<?=$pielabel?>'],
			datasets: [
				{
					label: 'OS별 방문자 현황',
					data: [<?=$data?>]
				}
			]
		},
		options: {
		//		 responsive: true,
			plugins: {
				title: {
					display: false,
				},
				legend: {
					position: 'bottom',
					padding: {
						bottom: 20
					}
				}
			},

		}
	});
</script>

<!-- #adm_visit_os -->
