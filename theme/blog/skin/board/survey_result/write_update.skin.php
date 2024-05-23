<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if($w == "") {
	alert("설문응답이 제출되었습니다. 감사합니다.", "./board.php?bo_table={$bo_table}&type=1");
} else {
	alert("응답이 수정되었습니다.", "./board.php?bo_table={$bo_table}&type=1");
}