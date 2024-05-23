<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가;
$admin_table_use = true;
$admin_use_tables = array("notice","survey","program");
$g5['menu_admin'] = G5_TABLE_PREFIX.'menu_admin'; // 관리자 상단메뉴 테이블
$g5['menu_table2'] = G5_TABLE_PREFIX.'menu2'; // 관리자 왼쪽메뉴 테이블