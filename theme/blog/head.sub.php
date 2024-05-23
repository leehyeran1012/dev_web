<?php
if(isset($admin_use_tables) && in_array($bo_table, $admin_use_tables)) {
    include_once(G5_THEME_PATH.'/head.sub2.php');
} else {
    include_once(G5_THEME_PATH.'/head.sub1.php');
}