<?php

$fr_date = date("Y-m-d",strtotime("-6 days"));
$to_date = date("Y-m-d");

$labels = $datas = $arr = array();

$sql = " select * from {$g5['visit_table']} where vi_date between '{$fr_date}' and '{$to_date}' ";
$result = sql_query($sql);

while ($row=sql_fetch_array($result)) {
    $str = $row['vi_referer'];
    preg_match("/^http[s]*:\/\/([\.\-\_0-9a-zA-Z]*)\//", $str, $match);
    $s = isset($match[1]) ? $match[1] : 0;
    $s = preg_replace("/^(www\.|search\.|dirsearch\.|dir\.search\.|dir\.|kr\.search\.|myhome\.)(.*)/", "\\2", $s);

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

		if (!$key) $key = '직접';

		$labels[] = $key;
		$datas[] = $count;
	}
}

$label = implode(",", $labels);
$pielabel = str_replace(",","','",$label);
$data = implode(",", $datas);

?>

<ul class="list-group">
	<li class="list-group-item bg-primary-subtle"><a href="<?php echo G5_ADMIN_URL ?>/visit_domain.php">
		<div class="d-flex justify-content-between">
			<div class="fw-bold text-dark">접속 경로별 방문자 현황 (최근 7일)</div>
			<div><i class="bi bi-plus-lg text-dark"></i></div>
		</div></a>
	</li>
	<li class="list-group-item" style="height:280px">
		<div style="width:350px; height:280px;margin:auto;"><canvas id="refererchart"></canvas></div>
	</li>
</ul>

<script>
	const ctx6 = document.getElementById('refererchart');
	new Chart(ctx6, {
		type: 'doughnut',
		data: {
			labels: ['<?=$pielabel?>'],
			datasets: [
				{
					label: '접속 경로별 방문자',
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
