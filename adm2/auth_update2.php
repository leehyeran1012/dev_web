<?php
$sub_menu = "999100";
require_once './_common.php';
require_once G5_LIB_PATH . '/mailer.lib.php';

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}
check_demo();
auth_check_menu($auth, $sub_menu, "w");
check_admin_token();

$u_gb = isset($_GET['u_gb']) ? intval($_GET['u_gb']) : 0;

if($u_gb == 1) {

	$post_count_chk = (isset($_POST['chk']) && is_array($_POST['chk'])) ? count($_POST['chk']) : 0;
	$chk            = (isset($_POST['chk']) && is_array($_POST['chk'])) ? $_POST['chk'] : array();
	$act_button     = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';

	if (!$post_count_chk) {
		alert($act_button . " 하실 항목을 하나 이상 체크하세요.");
	}


	if ($is_admin != 'super') {
		alert('최고관리자만 접근 가능합니다.');
	}

	if ($act_button === "선택수정") {

		auth_check_menu($auth, $sub_menu, 'w');

		for ($i = 0; $i < $post_count_chk; $i++) {
			// 실제 번호를 넘김
		   $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;

			$mb_id = isset($_POST['mb_id'][$k]) ? strip_tags($_POST['mb_id'][$k]) : "";
			$au_code = isset($_POST['au_code'][$k]) ? strip_tags($_POST['au_code'][$k]) : "";
			$mb_auth = isset($_POST['mb_auth'][$k]) ? strip_tags($_POST['mb_auth'][$k]) : "r";

			$sql = " update {$g5['auth_table']} set au_auth = '{$mb_auth}' where mb_id = '{$mb_id}' and au_menu = '{$au_code}' ";
			sql_query($sql);
		}

	} elseif ($act_button === "선택삭제") {

		auth_check_menu($auth, $sub_menu, 'd');

		$mb_id = isset($_POST['mb_id']) ? strip_tags($_POST['mb_id']) : '';

		for ($i = 0; $i < $post_count_chk; $i++) {

		   $k = isset($_POST['chk'][$i]) ? (int) $_POST['chk'][$i] : 0;

			$mb_id = isset($_POST['mb_id'][$k]) ? strip_tags($_POST['mb_id'][$k]) : 0;
			$au_code = isset($_POST['au_code'][$k]) ? strip_tags($_POST['au_code'][$k]) : 0;

			$sql = " delete from {$g5['auth_table']} where mb_id = '{$mb_id}' and au_menu = '{$au_code}' ";
			sql_query($sql);

		}
	}

} else {

	$count = isset($_POST['code']) ? count($_POST['code']) : 0;
	$mb_id = isset($_POST['mb_id']) ? strip_tags($_POST['mb_id']) : '';

	$mb = get_member($mb_id);
	if (!$mb['mb_id']) {
		alert('존재하는 회원아이디가 아닙니다.');
	}

	for ($i = 0; $i < $count; $i++) {

		$me_auth = !empty($_POST['me_auth'][$i]) ? strip_tags($_POST['me_auth'][$i]) : '';
		$au_acode = !empty($_POST['au_acode'][$i]) ? strip_tags($_POST['au_acode'][$i]) : '';

		if ($me_auth == '') continue;

		$result = sql_fetch(" select count(*) cnt from {$g5['auth_table']} where mb_id = '{$mb_id}' and au_menu = '{$au_acode}' ");

		if($result["cnt"] > 0) {
			sql_query(" update {$g5['auth_table']}	set au_auth = '{$me_auth}' where mb_id = '{$mb_id}' and au_menu = '{$au_acode}' ");
		} else {
			sql_query(" insert into {$g5['auth_table']}	set mb_id = '{$mb_id}', au_menu = '{$au_acode}', au_auth = '{$me_auth}' ");
		}

	}
}

//sql_query(" OPTIMIZE TABLE `$g5['auth_table']` ");

// 세션을 체크하여 하루에 한번만 메일알림이 가게 합니다.
if (str_replace('-', '', G5_TIME_YMD) !== get_session('adm_auth_update')) {
    $site_url = preg_replace('/^www\./', '', strtolower($_SERVER['SERVER_NAME']));
    $to_email = 'gnuboard@' . $site_url;

    mailer($config['cf_admin_email_name'], $to_email, $config['cf_admin_email'], '[' . $config['cf_title'] . '] 관리권한설정 알림', '<p><b>[' . $config['cf_title'] . '] 관리권한설정 변경 안내</b></p><p style="padding-top:1em">회원 아이디 ' . $mb['mb_id'] . ' 에 관리권한이 추가 되었습니다.</p><p style="padding-top:1em">' . G5_TIME_YMDHIS . '</p><p style="padding-top:1em"><a href="' . G5_URL . '" target="_blank">' . $config['cf_title'] . '</a></p>', 1);

    set_session('adm_auth_update', str_replace('-', '', G5_TIME_YMD));
}

run_event('adm_auth_update', $mb);

goto_url('./auth_list2.php?' . $qstr);
