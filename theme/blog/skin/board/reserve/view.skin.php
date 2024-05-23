<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$_SESSION['type'] = '';
if(empty(isset($type))) $type = 1;
$_SESSION['type'] = $type;
$scach = ($config['cf_bbs_rewrite']) == 0 ? '&type='.$type : '?type='.$type;

include_once($board_skin_path."/view{$type}.skin.php");