
<!-- #adm_visit_os -->

<?php

$labels = $datas = [];
$sql = " select vi_device, COUNT(vi_device) as device from {$g5['visit_table']} where vi_device <> '' group by vi_device ";
$result = sql_query($sql);

foreach($result as $field) {
    $labels[] = $field['vi_device'];
    $datas[] = $field['device'];
}

$label = implode(",", $labels);
$pielabel = str_replace(",","','",$label);
$data = implode(",", $datas);

?>

<ul class="list-group">
	<li class="list-group-item bg-primary-subtle"><a href="<?php echo G5_ADMIN_URL ?>/visit_device.php">
		<div class="d-flex justify-content-between">
			<div class="fw-bold text-dark">접속 플랫폼 (모바일,태블릿,PC)</div>
			<div><i class="bi bi-plus-lg text-dark"></i></div>
		</div></a>
	</li>
	<li class="list-group-item" style="height:280px">
		<div class="graph_wrap p-3">
			<div style="width:350px; height:250px;margin:auto;"><canvas id="devicechart"></canvas></div>
		</div>
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

</div>

<!-- #adm_visit_os -->
