<?php
$sub_menu = "999100";
require_once './_common.php';

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

auth_check_menu($auth, $sub_menu, 'd');

check_demo();

$me_id = isset($_GET["mid"]) ? intval($_GET["mid"]) : 0;
$dgb = isset($_GET["dgb"]) ? intval($_GET["dgb"]) : 0;

if($dgb == 1) {

    sql_query(" delete from {$g5['menu_table']} where me_id='{$me_id}' ");
	goto_url('./menu_home.php');


} elseif($dgb == 2) {

    sql_query(" delete from {$g5['menu_table2']} where me_id='{$me_id}' ");
	goto_url('./menu_left.php');

} elseif($dgb == 3) {

    sql_query(" delete from {$g5['menu_admin']} where me_id='{$me_id}' ");
	goto_url('./menu_admin.php');
}