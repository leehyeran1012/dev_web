<?php
$sub_menu = "999100";
require_once './_common.php';

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

$d_gb = isset($_GET['d_gb']) ? intval($_GET['d_gb']) : 0;
$mb_id = isset($_GET['mb_id']) ? strip_tags($_GET['mb_id']) : 0;

if($d_gb == 1) {

		$sql = " delete from {$g5['auth_table']} where mb_id = '" . $mb_id . "' ";
		sql_query($sql);

} else {

	$au_code = isset($_GET['au_code']) ? strip_tags($_GET['au_code']) : 0;

	$sql = " delete from {$g5['auth_table']} where mb_id = '{$mb_id}' and au_menu = '{$au_code}' ";
	sql_query($sql);

}

goto_url('./auth_list2.php?' . $qstr);
