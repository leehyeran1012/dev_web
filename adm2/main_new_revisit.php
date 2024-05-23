
<!-- #adm_ new_revisit -->

<?php

$sql_common =" select vs_date, vs_count as tot from {$g5['visit_sum_table']} where vs_date between";

// 오늘 신규방문자
$sql = "$sql_common '" . date("Y-m-d") . "' and '" . date("Y-m-d") . "'";
$result = sql_fetch($sql);
$result = $result ? $result : ['tot'=>0];

// 어제 신규방문자
$sql = "$sql_common '" . date("Y-m-d",strtotime("-1 day")) . "' and '" . date("Y-m-d",strtotime("-1 day")) . "'";
$result_1 = sql_fetch($sql);
$result_1 = $result_1 ? $result_1 : ['tot'=>0];

// -2일
$sql = "$sql_common '" . date("Y-m-d",strtotime("-2 day")) . "' and '" . date("Y-m-d",strtotime("-2 day")) . "'";
$result_2 = sql_fetch($sql);
$result_2 = $result_2 ? $result_2 : ['tot'=>0];

// -3일
$sql = "$sql_common '" . date("Y-m-d",strtotime("-3 day")) . "' and '" . date("Y-m-d",strtotime("-3 day")) . "'";
$result_3 = sql_fetch($sql);
$result_3 = $result_3 ? $result_3 : ['tot'=>0];

// -4일
$sql = "$sql_common '" . date("Y-m-d",strtotime("-4 day")) . "' and '" . date("Y-m-d",strtotime("-4 day")) . "'";
$result_4 = sql_fetch($sql);
$result_4 = $result_4 ? $result_4 : ['tot'=>0];

// -5일
$sql = "$sql_common '" . date("Y-m-d",strtotime("-5 day")) . "' and '" . date("Y-m-d",strtotime("-5 day")) . "'";
$result_5 = sql_fetch($sql);
$result_5 = $result_5 ? $result_5 : ['tot'=>0];

// -6일
$sql = "$sql_common '" . date("Y-m-d",strtotime("-6 day")) . "' and '" . date("Y-m-d",strtotime("-6 day")) . "'";
$result_6 = sql_fetch($sql);
$result_6 = $result_6 ? $result_6 : ['tot'=>0];

$datas = [];
$datas[] = $result_6['tot'];
$datas[] = $result_5['tot'];
$datas[] = $result_4['tot'];
$datas[] = $result_3['tot'];
$datas[] = $result_2['tot'];
$datas[] = $result_1['tot'];
$datas[] = $result['tot'];
$data = implode(",", $datas);

$labels = [];
$labels[] = date("d일",strtotime("-6 days"));
$labels[] = date("d일",strtotime("-5 days"));
$labels[] = date("d일",strtotime("-4 days"));
$labels[] = date("d일",strtotime("-3 days"));
$labels[] = date("d일",strtotime("-2 days"));
$labels[] = date("d일",strtotime("-1 days"));
$labels[] = date("오늘",strtotime($today));

$labelt = implode(",", $labels);
$pielabel = str_replace(",","','",$labelt);

// 오늘 신규회원
$today = G5_TIME_YMD;
$mb_re = sql_fetch(" select count(*) as cnt from {$g5['member_table']} where LEFT(mb_datetime, 10)='$today' ");

// 어제 신규회원
$day1 = date('Y-m-d',strtotime("-1 days"));
$mb_re1 = sql_fetch(" select count(*) as cnt from {$g5['member_table']} where LEFT(mb_datetime, 10)='$day1' ");

// -2일
$day2 = date('Y-m-d',strtotime("-2 days"));
$mb_re2 = sql_fetch(" select count(*) as cnt from {$g5['member_table']} where LEFT(mb_datetime, 10)='$day2' ");

// -3일
$day3 = date('Y-m-d',strtotime("-3 days"));
$mb_re3 = sql_fetch(" select count(*) as cnt from {$g5['member_table']} where LEFT(mb_datetime, 10)='$day3' ");

// -4일
$day4 = date('Y-m-d',strtotime("-4 days"));
$mb_re4 = sql_fetch(" select count(*) as cnt from {$g5['member_table']} where LEFT(mb_datetime, 10)='$day4' ");

// -5일
$day5 = date('Y-m-d',strtotime("-5 days"));
$mb_re5 = sql_fetch(" select count(*) as cnt from {$g5['member_table']} where LEFT(mb_datetime, 10)='$day5' ");

// -6일
$day6 = date('Y-m-d',strtotime("-6 days"));
$mb_re6 = sql_fetch(" select count(*) as cnt from {$g5['member_table']} where LEFT(mb_datetime, 10)='$day6' ");


$datas2 = [];
$datas2[] = $mb_re6['cnt'];
$datas2[] = $mb_re5['cnt'];
$datas2[] = $mb_re4['cnt'];
$datas2[] = $mb_re3['cnt'];
$datas2[] = $mb_re2['cnt'];
$datas2[] = $mb_re1['cnt'];
$datas2[] = $mb_re['cnt'];
$data2 = implode(",", $datas2);
?>

<ul class="list-group">
	<li class="list-group-item bg-primary-subtle"><a href="#">
		<div class="d-flex justify-content-between">
			<div class="fw-bold text-dark">신규방문 vs 신규회원 (최근 7일)</div>
			<div><i class="bi bi-plus-lg text-dark"></i></div>
		</div></a>
	</li>
	<li class="list-group-item" style="height:280px">
		<div class="container p-3">
			<canvas id="revisitchart" style="position: relative; height:250px; width:100%"></canvas>
		</div>
	</li>
</ul>

<script>
	const ctx3 = document.getElementById('revisitchart');
	new Chart(ctx3, {
		type: 'bar',
		data: {
			labels: ['<?=$pielabel?>'],
			datasets: [
				{
					label: '신규방문',
					data: [<?=$data?>],
				},
				{
					label: '신규회원',
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


<!-- #adm_ new_revisit -->
