
<!-- #adm_visit_os -->

<?php

$labels = $datas = [];
$sql = " select vi_referer, COUNT(vi_referer) as referer from {$g5['visit_table']} where vi_date >= '".date("Y-m-d",strtotime("-6 days") ) ."' group by left(vi_referer,10) ";

$result = sql_query($sql);
foreach($result as $field) {
    $labels[] = $field['vi_referer'] ? substr($field['vi_referer'],0,20) : '직접';
    $datas[] = $field['referer'];
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
		<div class="graph_wrap p-3">
			<div style="width:350px; height:250px;margin:auto;"><canvas id="refererchart"></canvas></div>
		</div>
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
