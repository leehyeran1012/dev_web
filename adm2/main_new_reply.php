
<!-- #adm_ new_reply -->

<?php

$datas = $datas2 = $labels = array();

$labels[] = date("d일",strtotime("-6 days"));
$labels[] = date("d일",strtotime("-5 days"));
$labels[] = date("d일",strtotime("-4 days"));
$labels[] = date("d일",strtotime("-3 days"));
$labels[] = date("d일",strtotime("-2 days"));
$labels[] = date("d일",strtotime("-1 days"));
$labels[] = date("오늘",strtotime($today));

$fr_date = date("Y-m-d",strtotime("-6 days"));
$to_date = date("Y-m-d");

$sql_bo_table = '';
if ($bo_table)
    $sql_bo_table = "and bo_table = '$bo_table'";

$sql  = " select substr(bn_datetime,1,10) as days, sum(if(wr_id=wr_parent,1,0)) as wcount, sum(if(wr_id=wr_parent,0,1)) as ccount from {$g5['board_new_table']} where substr(bn_datetime,1,10) between '$fr_date' and '$to_date' {$sql_bo_table} group by days order by bn_datetime ";
$result = sql_query($sql);
for ($i=0; $row=sql_fetch_array($result); $i++) {
	// 월-일

	$datas[] = $row['wcount'];
	$datas2[] = $row['ccount'];
}

$data = implode(",", $datas);
$data2 = implode(",", $datas2);
$labelt = implode(",", $labels);
$pielabel = str_replace(",","','",$labelt);
?>

<ul class="list-group">
	<li class="list-group-item bg-primary-subtle"><a href="<?php echo G5_ADMIN_URL ?>/write_count.php">
		<div class="d-flex justify-content-between">
			<div class="fw-bold text-dark">글, 댓글 현황 (최근 7일)</div>
			<div><i class="bi bi-plus-lg text-dark"></i></div>
		</div></a>
	</li>
	<li class="list-group-item" style="height:280px">
		<div class="container p-3">
			<canvas id="replychart" style="position: relative; height:250px; width:100%"></canvas>
		</div>
	</li>
</ul>

<script>
	const ctx9 = document.getElementById('replychart');
	new Chart(ctx9, {
		type: 'bar',
		data: {
			labels: ['<?=$pielabel?>'],
			datasets: [
				{
					label: '글등록',
					data: [<?=$data?>],
				},
				{
					label: '댓글등록',
					data: [<?=$data2?>],
				}
			]
		},
		options: {
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
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});
</script>