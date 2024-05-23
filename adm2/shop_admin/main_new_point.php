<?php

    $sql_common = " from {$g5['point_table']} ";
    $sql_order = " order by po_id desc ";

    $sql = " select count(*) as cnt {$sql_common}  {$sql_order} ";
    $row = sql_fetch($sql);
    $total_count = $row['cnt'];

    $sql = " select * {$sql_common} {$sql_order} limit 4 ";
    $result = sql_query($sql);

    $colspan = 6;

    ?>

<ul class="list-group">
	<li class="list-group-item bg-primary-subtle"><a href="<?php echo G5_ADMIN_URL ?>/point_list.php">
		<div class="d-flex justify-content-between">
			<div class="fw-bold text-dark">최근 포인트 발생내역</div>
			<div><i class="bi bi-plus-lg text-dark"></i></div>
		</div></a>
	</li>
	<li class="list-group-item" style="height:280px">

    <table class="table table-bordered text-center mt-3">
      <tr>
			<th class="bg-light">회원아이디</th>
			<!-- <th class="bg-light">이름</th> -->
			<th class="bg-light">닉네임</th>
			<th class="bg-light">일시</th>
			<th class="bg-light">포인트 내용</th>
			<th class="bg-light">포인트</th>
			<th class="bg-light">포인트합</th>
		</tr>

		<?php
		$row2['mb_id'] = '';
		for ($i = 0; $row = sql_fetch_array($result); $i++) {
		if ($row2['mb_id'] != $row['mb_id']) {
		$sql2 = " select mb_id, mb_name, mb_nick, mb_email, mb_homepage, mb_point from {$g5['member_table']} where mb_id = '{$row['mb_id']}' ";
		$row2 = sql_fetch($sql2);
		}

		$mb_nick = get_sideview($row['mb_id'], $row2['mb_nick'], $row2['mb_email'], $row2['mb_homepage']);

		$link1 = $link2 = "";
		if (!preg_match("/^\@/", $row['po_rel_table']) && $row['po_rel_table']) {
		$link1 = '<a href="' . get_pretty_url($row['po_rel_table'], $row['po_rel_id']) . '" target="_blank">';
		$link2 = '</a>';
		}
		?>

		<tr>
			<td><a href="./point_list.php?sfl=mb_id&amp;stx=<?php echo $row['mb_id'] ?>"><?php echo $row['mb_id'] ?></a></td>
			<!-- <td class="td_mbname"><?php echo get_text($row2['mb_name']); ?></td> -->
			<td><div><?php echo $mb_nick ?></div></td>
			<td><?php echo $row['po_datetime'] ?></td>
			<td><?php echo $link1 . $row['po_content'] . $link2 ?></td>
			<td><?php echo number_format($row['po_point']) ?></td>
			<td><?php echo number_format($row['po_mb_point']) ?></td>
		</tr>

		<?php
		}

		if ($i == 0) {
		echo '<tr><td colspan="' . $colspan . '" class="empty_table">자료가 없습니다.</td></tr>';
		}
		?>

	</table>

	</li>
</ul>

