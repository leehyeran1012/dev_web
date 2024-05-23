<?php

// 신청관련 체크 함수(오픈시간, 신청수 체크 등)
function select_confirm($bo_table, $pid) {

	$prog_cont =  [];

	$que1 = sql_fetch("select wr_1, wr_2, wr_5, wr_6, wr_7, wr_9 from g5_write_{$bo_table} where wr_id = '{$pid}'");
	$proglist = str_replace("\r\n","",$que1['wr_1']);

	$fornum = intval($que1['wr_2']);			//신청수 계산 구분자
	$anums = explode("|", $que1['wr_6']);
	$stuallnum = intval($anums[0]);		//선택1 정원
	$stuallnum2 = intval($anums[1]);		//선택2 정원
	$stuallnum3 = intval($anums[2]);		//1인당신청수

	$selects = explode("|", $que1['wr_7']);

	$sub_title = [];
	$svcontents = str_replace("\r\n","",$que1["wr_9"]);
	$svcontents = str_replace("#선택","선택",$svcontents);
	$svcontents = explode("|",$svcontents);
	foreach($svcontents as $key=>$value) {
		$item_array = explode("^",$value);
		$sub_title[] = trim($item_array[0]);
	}

	//오픈시간

	$open_ok =  open_confirm($que1['wr_5']);

	if($fornum == 2) {

		$prog_cont = explode("|", $proglist);

	 } elseif($fornum == 3) {

		$prog_conts = explode("D#", $proglist);
		$prog_cont = explode("|", $prog_conts[0]);
		if(strpos($prog_conts[1],"|")) {
			$prog_cont2 = explode("|", $prog_conts[1]);
		} else {
			$prog_cont2[0] = $prog_conts[1];
		}

	 } elseif($fornum == 4) {

		$prog_conts = explode("D#", $proglist);
		$prog_cont = explode("|", $prog_conts[0]);
		$prog_cont2 = explode("|", $prog_conts[1]);
	}

	//순서--> 0: 오픈, 1: 신청유형, 2: 선택1 내용, 3: 선택2 내용, 4: 선택1 정원,  5: 선택2 정원, 6: 1인당신청수 7: 선택 제목 8: 접수항목
	$parray = [$open_ok,$fornum,$prog_cont,$prog_cont2,$stuallnum,$stuallnum2,$stuallnum3,$selects,$sub_title];

	return $parray;
}


function open_confirm($sdate) {

	$tdate = str_replace(" ", "", $sdate);
	$tdate = trim($tdate);
	$tdate = explode("|", $tdate);

	$oc_time = explode("~",$tdate[2]);
	$nowDate = date("Y-m-d H:i:s");	//현재시간
	$oDate = "{$tdate[0]} {$oc_time[0]}:00";		//오픈시간
	$cDate = "{$tdate[1]} {$oc_time[1]}:00";		//종료시간

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
	$t_date = date("n",strtotime($value)).". ".date("j",strtotime($value)).".(".$s_week.")";
	return $t_date;
}