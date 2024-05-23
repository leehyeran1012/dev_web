<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$type = $_SESSION['type'];
$scach = ($config['cf_bbs_rewrite']) == 0 ? '&type='.$type : '?type='.$type;

include_once("$board_skin_path/write{$type}.skin.php");