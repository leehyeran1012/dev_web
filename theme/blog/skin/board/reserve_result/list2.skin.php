  <?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once(G5_THEME_LIB_PATH.'/lunarcalendar.php');
$holiday = new Lunarcalendar();

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

$today = getdate();
$month = $today['mon'];
$b_day = $today['mday'];
$year = $today['year'];

if($b_day > 25) {
	$month = $month+1;
}

if($month ==12) {
	$year = $year+1;
	$month = 1;
}

$month2 = sprintf("%02d",$month);

$ym = $year."-".$month2;

$to_day = date("Y-m-d");

$day = 1;
$date = $ym."-01";
$time = strtotime($date);
$start_week = date('w', $time); // 시작 요일
$total_day = date('t', $time); // 현재 달의 총 날짜


$times = array("10:00","14:00","17:00","19:00");

$bot_table = str_replace("_result","",$write_table);

$result2 = sql_fetch("select wr_id, wr_2 from {$bot_table} where wr_1 = '{$ym}'");
if($result) {
	$stimes = explode("|",$result2["wr_2"]);
} else {
	$stimes = [];
}

if(isset($_POST["stu_id"])) {
	$_SESSION['stu_id'] = $_POST["stu_id"];
}

$stu_id = isset($_SESSION['stu_id']) ? $_SESSION['stu_id'] : "";
$wr_id = isset($_POST['wr_id']) ? $_POST["wr_id"] : 0;

$wd = isset($_POST["wd"]) ? $_POST["wd"] : 0;

if ($wd ==1)  {

    $wr_name = $_POST['wr_name'];
    $wr_1 = $_POST['wr_1'];
    $wr_2 = $_POST['wr_2'];
    $wr_num = get_next_num($write_table);

  $sql = " insert into $write_table
                set  wr_num = '$wr_num',
					 wr_subject = '상담신청',
                     wr_name = '$stu_id',
                     wr_content = '상담신청',
					 wr_datetime = '".G5_TIME_YMDHIS."',
                     wr_last = '".G5_TIME_YMDHIS."',
                     wr_ip = '{$_SERVER['REMOTE_ADDR']}',
                     wr_1 = '$wr_1',
                     wr_2 = '$wr_2'	 ";
    sql_query($sql);

    $wr_id = sql_insert_id();

    // 부모 아이디에 UPDATE
    sql_query(" update $write_table set wr_parent = '$wr_id' where wr_id = '$wr_id' ");

    // 새글 INSERT
    sql_query(" insert into {$g5['board_new_table']} ( bo_table, wr_id, wr_parent, bn_datetime, mb_id ) values ( '{$bo_table}', '{$wr_id}', '{$wr_id}', '".G5_TIME_YMDHIS."', '{$member['mb_id']}' ) ");

    // 게시글 1 증가
    sql_query("update {$g5['board_table']} set bo_count_write = bo_count_write + 1 where bo_table = '{$bo_table}'");
}
//$stu_id = "";
?>

<script>
	if (sessionStorage.reLoad) {
		sessionStorage.clear();
		location.href = "<?= $_SERVER['REQUEST_URI']; ?>";
	}
</script>

<div class="container">

<?php if($stu_id == "") { ?>
<form name='form1' method='post' action="./board.php?bo_table=sangdam_result&m_id=5050&type=2">

<table class="table table-bordered mx-auto mt-3" style="width:360px">
	<tr>
		<td class="bg-light text-center fs-4 fw-bold text-secondary">진진에듀컨설팅</td>
	</tr>
	<tr>
		<td class="text-success text-center py-4"><h4 class="mb-3"><?= intval(substr($ym,-2))?>월 컨설팅 신청</h4>
		<h6 class="text-danger fs-6">학교명+성명을 입력하시고 신청하세요.<br> (예, 경북고홍길동)</h6></td>
	</tr>
	<tr>
		<th>
			<input class="form-control text-center fs-5 p-2" type="text" name="stu_id" value="" maxlength="15" placeholder="OO고홍길동" required="" title="학교명+성명">
		</th>
	</tr>
	<tr>
		<th height="50"><button class="btn btn-success fs-5" style="width:100%;height:60px">신청하기</button></th>
	</tr>
</table>
</form>
<?php } else { ?>
<table class="table table-bordered table-hover text-center align-middle mx-auto" style="width:500px">
	<tr>
		<td colspan="3" class="text-success fs-5 fw-bold py-3"><?= $stu_id?>님 <?= intval(substr($ym,-2))?> 월 신청현황</td>
	</tr>
	<tr class="table-light">
		<th>상담일자</th>
		<th>상담시간</th>
		<th>신청취소</th>
	</tr>
<?php

$result1 = sql_query("select * from {$write_table} where wr_name = '{$stu_id}' and left(wr_1,7) = '{$ym}' order by wr_1");

if (sql_num_rows($result1) > 0) {
foreach ($result1 as $key=>$field) {

set_session('ss_delete_token', $token = uniqid(time()));
$delete_href ='./delete.php?bo_table='.$bo_table.'&wr_id='.$field['wr_id'].'&token='.$token.'&page='.$page.urldecode($qstr);

?>
	<tr>
		<td><?=$field['wr_1']?>(<?=$holiday->getWeekname($field['wr_1'])?>)</td>
		<td><?=$field['wr_2']?></td>
		<?php if(strtotime($field['wr_1']) >= $time) { ?>
			<td class="text-center"><a href="<?= $delete_href ?>" class="btn btn-outline-warning" onclick="return confirm('신청을 취소 하시겠습니까?'); return false;">신청취소</a></td>
		<?php	} else { ?>
			<td class="text-center">-</td>
		<?php } ?>
	</tr>
<?php } } else { ?>
	<tr>
		<td colspan="4" class="text-warning text-center py-3">신청한 자료가 없습니다.</td>
	</tr>
<?php } ?>

</table><br>

	<table class="table table-bordered table-hover align-middle mx-auto text-center" style="width:500px">
      <thead class="bg-light">
		<th width="100">일자</th>
		<th>상담시간</th>
      </thead>
	 <tbody>

	<?php for ($day = 1; $day <= $total_day; $day++) {

		$c_date = sprintf('%04d-%02d-%02d', $year, $month, $day);
		$wk_name = $holiday->getWeekname($c_date);
		if($wk_name == "일") {
			$wcolor = " class='text-danger'";
		} elseif($wk_name == "토") {
			$wcolor = " class='text-primary'";
		} else {
			$wcolor = "";
		}
		if($c_date > $to_day) {
	?>
	<tr>
		<td<?=$wcolor?>><?= $day ?>(<?= $wk_name ?>)</td>
		<td class="text-start">
		<div class="row text-start">
			<?php foreach($times as $key=>$value) {
				$result = sql_fetch("select * from {$write_table} where wr_1 = '{$c_date}' and wr_2 = '{$times[$key]}' order by wr_2");
				if(!$result && !in_array($c_date.$value, $stimes)) { ?>
				<div class="col-3">
				<form name="form<?=$day?><?=$key?>" method="post">
					<input type="hidden" name="wr_name" value="<?= $stu_id ?>">
					<input type="hidden" name="wr_1" value="<?=$c_date ?>">
					<input type="hidden" name="wr_2" value="<?= $value ?>">
					<input type="hidden" name="wd" value="1">
					<button class="btn btn-outline-success" onclick=sessionStorage.reLoad=1><?=$times[$key]?></button>
				</form></div>
			<?php } }	  ?>
			</div>
		</td>
	</tr>
<?php } } ?>
    </tbody>
</table>
<?php } ?>

</div>