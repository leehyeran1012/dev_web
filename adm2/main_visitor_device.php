<?php

$labels = $datas = $arr = array();

$fr_date = date("Y-m-d",strtotime("-6 days"));
$to_date = date("Y-m-d");

$sql = " select * from {$g5['visit_table']} where vi_date between '{$fr_date}' and '{$to_date}' ";
$result = sql_query($sql);
while ($row=sql_fetch_array($result)) {
    $s = $row['vi_device'];
    if(!$s) $s = '기타';

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

		if (!$key) $key = '기타';

		$labels[] = $key;
		$datas[] = $count;
	}
}

$label = implode(",", $labels);
$pielabel = str_replace(",","','",$label);
$data = implode(",", $datas);

?>

<ul class="list-group">
	<li class="list-group-item bg-primary-subtle"><a href="<?php echo G5_ADMIN_URL ?>/visit_device.php">
		<div class="d-flex justify-content-between">
			<div class="fw-bold text-dark">접속 플랫폼 (모바일,태블릿,PC) (최근 7일)</div>
			<div><i class="bi bi-plus-lg text-dark"></i></div>
		</div></a>
	</li>
	<li class="list-group-item" style="height:280px">
		<div style="width:350px; height:250px;margin:auto;"><canvas id="devicechart"></canvas></div>
	</li>
</ul>

<script>
	const ctx7 = document.getElementById('devicechart');
	new Chart(ctx7, {
		type: 'pie',
		data: {
			labels: ['<?=$pielabel?>'],
			datasets: [
				{
					label: '접속 플랫폼',
					data: [<?=$data?>]
				}
			]
		},
		options: {
			maintainAspectRatio: false,
			plugins: {
			  legend: {
				position: 'right',
			  },
			  title: {
				display: false,
				text: ''
			  }
			}
		}
	});
</script>

<!-- #adm_visit_os -->
