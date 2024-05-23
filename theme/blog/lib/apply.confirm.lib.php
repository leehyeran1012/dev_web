<?php

// 신청관련 체크 함수(오픈시간, 신청수 체크 등)
function select_confirm($pid) {

	$prog_cont =  [];

	$que1 = sql_fetch("select wr_1, wr_2 from g5_write_program where wr_id = '{$pid}'");
	$configs = str_replace("\r\n","",$que1['wr_1']);
	$configs = explode("Q#", $configs);

	$anums = explode("|", $configs[6]);
	$fornum = intval($anums[0]);			//신청수 계산 구분자
	$stuallnum = intval($anums[1]);		//선택1 정원
	$stuallnum2 = intval($anums[2]);		//선택2 정원
	$selnum_gb = $anums[3];		//1인당신청수
	$select1 =  $anums[4];		//세부선택1 제목
	$select2 =  $anums[5];		//세부선택2 제목

	//오픈시간
	$tdate = explode("~",$configs[1]);
	$opentime = strtotime(trim($tdate[0]));
	$closetime = strtotime(trim($tdate[1]));
	$nowtime = strtotime(date("Y-m-d"));

	if ($opentime > $nowtime) {
	   $open_ok = 1;		//신청시작전
	} else {
		if ($closetime >= $nowtime) {
			$open_ok = 0;		 //신청가능
		 } else {
			$open_ok = 2;		//신청종료
		}
	}

//프로그램 설정

	$proglist = str_replace("\r\n","",$que1['wr_2']);


	if($fornum == 2) {
		$prog_cont = explode("|", $proglist);

	 } elseif($fornum == 3) {

		$prog_conts = explode("D#", $proglist);
		$prog_cont = explode("|", $prog_conts[0]);
		$prog_cont2 = explode("|", $prog_conts[1]);

	 } elseif($fornum == 4) {

		$prog_cont = explode("|", $proglist);
	}

	//순서--> 0: 오픈, 1: 선택1 내용, 2: 선택1 정원, 3: 선택2 정원,  4,5: 선택1, 선택2 제목, 6: 신청구분, 7: 선택2 내용
	$parray = [$open_ok,$prog_cont,$stuallnum,$stuallnum2,$select1,$select2,$fornum,$prog_cont2];

	return $parray;
}

function kdate_m_d_w(string $value)
{
	$yoil = array("일","월","화","수","목","금","토");
	$s_week = $yoil[date("w", strtotime($value))];
	$t_date = date("n",strtotime($value)).". ".date("j",strtotime($value)).".(".$s_week.")";
	return $t_date;
}