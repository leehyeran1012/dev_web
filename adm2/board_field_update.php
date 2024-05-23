<?php
$sub_menu = "999500";
require_once './_common.php';

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

check_demo();
auth_check_menu($auth, $sub_menu, "w");
check_admin_token();

$bo_table = $_POST['bo_table'];
$wr_end = str_replace("wr_","",$_POST['wr_end']);
$wr_end = intval($wr_end);
$org_fnum = intval($_POST['org_fnum']);
$wr_start = $org_fnum + 1;

if($wr_end < 10) $wr_end = 10;

$write_table = $g5['write_prefix'] . $bo_table; // 게시판 테이블명

if($wr_end > $org_fnum) {
	for ($k=$wr_start; $k<=$wr_end; $k++) {
		$cols = sql_fetch(" SHOW COLUMNS FROM {$write_table} LIKE 'wr_{$k}' ");
		if(!isset($cols)) {
			sql_query(" ALTER TABLE {$write_table} ADD wr_{$k} varchar(255) NOT NULL DEFAULT '' ");
		}
	}

} else {
	for($k=$org_fnum; $k > $wr_end; $k--) {
		$cols = sql_fetch(" SHOW COLUMNS FROM {$write_table} LIKE 'wr_{$k}' ");
		if(isset($cols)) {
			sql_query(" ALTER TABLE {$write_table} DROP wr_{$k} ");
		}
	}
}

alert('여분필드를 수정했습니다.');