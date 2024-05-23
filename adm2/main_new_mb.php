<?php
$new_member_rows = 4;

$sql_common = " from {$g5['member_table']} ";

$sql_search = " where (1) ";

if ($is_admin != 'super') {
    $sql_search .= " and mb_level <= '{$member['mb_level']}' ";
}

if (!$sst) {
    $sst = "mb_datetime";
    $sod = "desc";
}

$sql_order = " order by {$sst} {$sod} ";

$sql = " select count(*) as cnt {$sql_common}";
$row = sql_fetch($sql);
$total_count = $row['cnt'];

// 탈퇴회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_leave_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$leave_count = $row['cnt'];

// 차단회원수
$sql = " select count(*) as cnt {$sql_common} {$sql_search} and mb_intercept_date <> '' {$sql_order} ";
$row = sql_fetch($sql);
$intercept_count = $row['cnt'];

$sql = " select * {$sql_common} {$sql_search} {$sql_order} limit {$new_member_rows} ";
$result = sql_query($sql);

// 오늘 가입회원수
$today = G5_TIME_YMD;
$qq = sql_fetch(" select count(*) as cnt from {$g5['member_table']} where LEFT(mb_datetime, 10)='$today' ");

// 오늘 탈퇴회원수
$today = str_replace('-','',G5_TIME_YMD);
$leave = sql_fetch(" select count(*) as cnt from {$g5['member_table']} where LEFT(mb_leave_date, 10)='$today' ");

$colspan = 6;
?>

<ul class="list-group">
	<li class="list-group-item bg-primary-subtle"><a href="<?php echo G5_ADMIN_URL ?>/member_list.php">
		<div class="d-flex justify-content-between">
			<div class="fw-bold text-dark">신규가입 회원 현황</div>
			<div><i class="bi bi-plus-lg text-dark"></i></div>
		</div></a>
	</li>
	<li class="list-group-item" style="height:280px">

    <table class="table table-bordered text-center mt-3">
      <tr>
        <th class="bg-light">아이디</th>
        <th class="bg-light">이름</th>
        <th class="bg-light">휴대폰</th>
        <th class="bg-light">가입일</th>
        <th class="bg-light">최종접속</th>
        <th class="bg-light">권한</th>
      </tr>
      <?php for ($i = 0; $row = sql_fetch_array($result); $i++) {  ?>
      <tr>
        <td><?php echo $row['mb_id'] ?></td>
        <td><?php echo get_text($row['mb_name']) ?></td>
        <td><?php echo $row['mb_hp'] ?></td>
        <td><?php echo substr($row['mb_datetime'], 0, 10) ?></td>
        <td><?php echo substr($row['mb_today_login'], 0, 10) ?></td>
        <td><?php echo $row['mb_level'] ?></td>
      </tr>
      <?php
           }
            if ($i == 0) {
                echo '<tr><td colspan="' . $colspan . '" class="empty_table">자료가 없습니다.</td></tr>';
            }
        ?>
       </table>
	   <table class="text-center">
		<tr>
			<td><p class="fs-5 text-primary"><?php echo number_format($total_count) ?></p>전체회원</td>
			<td><p class="fs-5 text-success"><?php echo number_format($qq['cnt']) ?></p>오늘 가입회원</td>
			<td><p class="fs-5 text-warning"><?php echo number_format($leave['cnt']) ?></p>오늘 탈퇴회원</td>
			<td><p class="fs-5 text-danger"><?php echo number_format($leave_count) ?></p>총 탈퇴회원</td>
		</tr>
		</table>

	</li>
</ul>


<!-- #adm_new member -->
