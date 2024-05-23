
<!-- #adm_visit_os -->

<?php

$labels = $datas = [];
//$sql = " select vi_os, COUNT(vi_os) os from {$g5['visit_table']} where vi_date >= '".date("Y-m-d",strtotime("-6 days") ) ."' ";
$sql = " select vi_os, COUNT(vi_os) as os from {$g5['visit_table']} where vi_os <> '' group by vi_os ";

$result = sql_query($sql);
foreach($result as $field) {
    $labels[] = $field['vi_os'];
    $datas[] = $field['os'];
}

$label = implode(",", $labels);
$pielabel = str_replace(",","','",$label);
$data = implode(",", $datas);

?>

<ul class="list-group">
	<li class="list-group-item bg-primary-subtle"><a href="<?php echo G5_ADMIN_URL ?>/visit_os.php">
		<div class="d-flex justify-content-between">
			<div class="fw-bold text-dark">접속 OS별 방문자 현황</div>
			<div><i class="bi bi-plus-lg text-dark"></i></div>
		</div></a>
	</li>
	<li class="list-group-item" style="height:280px">
		<div class="graph_wrap p-3">
			<canvas id="oschart" style="position: relative; height:250px; width:100%"></canvas>
		</div>
	</li>
</ul>

 <!-- <h3>접속 OS별 방문자 현황(최근 7일)<a href="<?php echo G5_ADMIN_URL ?>/visit_os.php"></a></h3>
 <div class="graph_wrap p-3">
	<canvas id="oschart" style="position: relative; height:250px; width:100%"></canvas>
</div> -->

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
