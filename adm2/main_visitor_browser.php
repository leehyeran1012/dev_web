<!-- #adm_visit_os -->

<?php
include_once(G5_LIB_PATH.'/visit.lib.php');

$fr_date = date("Y-m-d",strtotime("-6 days"));
$to_date = date("Y-m-d");

$labels = $datas = $arr = array();

$sql = " select * from {$g5['visit_table']} where vi_date between '{$fr_date}' and '{$to_date}' ";
$result = sql_query($sql);

while ($row=sql_fetch_array($result)) {
    $s = $row['vi_browser'];

    if(!$s) $s = get_brow($row['vi_agent']);

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
	<li class="list-group-item bg-primary-subtle"><a href="<?php echo G5_ADMIN_URL ?>/visit_browser.php">
		<div class="d-flex justify-content-between">
			<div class="fw-bold text-dark">접속 브라우저  (최근 7일)</div>
			<div><i class="bi bi-plus-lg text-dark"></i></div>
		</div></a>
	</li>
	<li class="list-group-item py-4" style="height:280px">
		<canvas id="borwserchart"></canvas>
	</li>
</ul>

<script>
	const ctx10 = document.getElementById('borwserchart');
	new Chart(ctx10, {
		type: 'pie',
		data: {
			labels: ['<?=$pielabel?>'],
			datasets: [
				{
					label: '접속 브라우저',
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
