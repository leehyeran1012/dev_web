<?php
$sub_menu = "999200";
require_once './_common.php';

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

check_demo();
auth_check_menu($auth, $sub_menu, "w");
check_admin_token();

$group_code = null;
$primary_code = null;
$count = isset($_POST['code']) ? count($_POST['code']) : 0;

for ($i = 0; $i < $count; $i++) {
    $_POST = array_map_deep('trim', $_POST);

    if (preg_match('/^javascript/i', preg_replace('/[ ]{1,}|[\t]/', '', $_POST['me_link'][$i]))) {
        $_POST['me_link'][$i] = G5_URL;
    }

	$code = intval($_POST['code'][$i]);
    $_POST['me_link'][$i] = is_array($_POST['me_link']) ? clean_xss_tags(clean_xss_attributes(preg_replace('/[ ]{2,}|[\t]/', '', $_POST['me_link'][$i]), 1)) : '';
    $_POST['me_link'][$i] = html_purifier($_POST['me_link'][$i]);

    $me_name = is_array($_POST['me_name']) ? strip_tags($_POST['me_name'][$i]) : '';
    $me_code = is_array($_POST['me_code']) ? strip_tags($_POST['me_code'][$i]) : '';
    $me_link = (preg_match('/^javascript/i', $_POST['me_link'][$i]) || preg_match('/script:/i', $_POST['me_link'][$i])) ? G5_URL : strip_tags(clean_xss_attributes($_POST['me_link'][$i]));

    if (!$me_code || !$me_name || !$me_link) {
        continue;
    }

	if($code > 0) {
		// 메뉴 수정
		$sql = " update {$g5['menu_table']}
					set me_code         = '" . $me_code . "',
						me_name         = '" . $me_name . "',
						me_link         = '" . $me_link . "',
						me_target       = '" . sql_real_escape_string(strip_tags($_POST['me_target'][$i])) . "',
						me_order        = '" . sql_real_escape_string(strip_tags($_POST['me_order'][$i])) . "',
						me_use          = '" . sql_real_escape_string(strip_tags($_POST['me_use'][$i])) . "',
						me_mobile_use   = '" . sql_real_escape_string(strip_tags($_POST['me_mobile_use'][$i])) . "' where me_id = '" . $code . "' ";
		sql_query($sql);

	} else {
		// 메뉴 등록
		$sql = " insert into {$g5['menu_table']}
					set me_code         = '" . $me_code . "',
						me_name         = '" . $me_name . "',
						me_link         = '" . $me_link . "',
						me_target       = '" . sql_real_escape_string(strip_tags($_POST['me_target'][$i])) . "',
						me_order        = '" . sql_real_escape_string(strip_tags($_POST['me_order'][$i])) . "',
						me_use          = '" . sql_real_escape_string(strip_tags($_POST['me_use'][$i])) . "',
						me_mobile_use   = '" . sql_real_escape_string(strip_tags($_POST['me_mobile_use'][$i])) . "' ";
		sql_query($sql);
	}
}

//run_event('admin_menu_list_update');

goto_url('./menu_home.php');
