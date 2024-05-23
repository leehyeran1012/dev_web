<?php
if($admin_table_use == false) {
    return;
}

$menu["menu999"] = array(
    array('999000', '관리추가설정', '' . G5_ADMIN_URL . '/auth_list2.php', 'auth_a'),
    array('999100', '권한관리2', '' . G5_ADMIN_URL . '/auth_list2.php', 'auth_list'),
    array('999200', '홈메뉴', '' . G5_ADMIN_URL . '/menu_home.php', 'menu_home'),
    array('999300', '왼쪽메뉴', '' . G5_ADMIN_URL . '/menu_left.php', 'menu_left'),
    array('999400', '관리자메뉴', '' . G5_ADMIN_URL . '/menu_admin.php', 'menu_admin'),
    array('999500', '필드추가', '' . G5_ADMIN_URL . '/board_field_list.php', 'board_field_list')
);