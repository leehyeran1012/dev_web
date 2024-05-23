<?php

// 신청관련 체크 함수(오픈시간, 신청수 체크 등)
function open_confirm($odate,$cdate,$octime) {

	$nowDate = date("Y-m-d H:i:s");	//현재시간

	if(strlen(trim($octime)) < 11)  $octime = "00:00~23:59";

	$octimes =  explode("~",$octime);		//오픈시간
	$oDate = "{$odate} {$octimes[0]}:00";		//오픈일자
	$cDate = "{$cdate} {$octimes[1]}:00";		//종료일자

	$nowtime = strtotime($nowDate);
	$opentime = strtotime($oDate);
	$closetime = strtotime($cDate);

	if ($opentime > $nowtime) {
	   $open_ok = 1;		//신청시작전
	} else {
		if ($closetime >= $nowtime) {
			$open_ok = 0;		 //신청가능
		 } else {
			$open_ok = 2;		//신청종료
		}
	}

	return $open_ok;
}

function kdate_m_d_w(string $value)
{
	$yoil = array("일","월","화","수","목","금","토");
	$s_week = $yoil[date("w", strtotime($value))];
	$t_date = date("n. j",strtotime($value)).".(".$s_week.")";
	return $t_date;
}