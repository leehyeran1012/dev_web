<?php
include_once('./_common.php');

$subject = strip_tags($_POST['subject']);
$content = strip_tags($_POST['content']);
$pid = $_POST['pid'];
$wr_6 = $_POST['wr_6'];
$wr_7 = $_POST['wr_7'];


//$filter = explode(",", strtolower(trim($config['cf_filter'])));
// strtolower 에 의한 한글 변형으로 아래 코드로 대체 (곱슬최씨님이 알려 주셨습니다.)
$filter = explode(",", trim($config['cf_filter']));
for ($i=0; $i<count($filter); $i++) {
    $str = $filter[$i];

    // 제목 필터링 (찾으면 중지)
    $subj = "";
    $pos = stripos($subject, $str);
    if ($pos !== false) {
        $subj = $str;
        break;
    }

    // 내용 필터링 (찾으면 중지)
    $cont = "";
    $pos = stripos($content, $str);
    if ($pos !== false) {
        $cont = $str;
        break;
    }
}

$bo_table = "g5_write_program";
$bot_table = $bo_table."_result";

$que1 = sql_fetch("select wr_1 from {$bo_table} where wr_id = '{$pid}'");
$configs = str_replace("\r\n","",$que1['wr_1']);
$configs = explode("Q#", $configs);
$anums = explode("|", $configs[6]);
$fornum = intval($anums[0]);		//신청수 계산 구분자
$stuallnum = $anums[1];		//선택1정원
$stuallnum2 = $anums[2];		//선택2정원
$selnum_gb = $anums[3];		//1인당신청수

if($fornum == 1) {

	$pcount = sql_fetch("select count(*) pnum from {$bot_table} where wr_9 = '{$pid}'");
	if($pcount['pnum'] >= $stuallnum) {
		$pok = "1";
	} else {
		$pok = "0";
	}

	$pok1 = "0";

} elseif($fornum == 2) {

	$pcount = sql_fetch("select count(*) pnum from {$bot_table} where wr_9 = '{$pid}' and wr_6 = '{$wr_6}'");

	if($pcount['pnum'] >= $stuallnum) {
		$pok = "1";
	} else {
		$pok = "0";
	}
	$pok1 = "0";

} elseif($fornum == 3) {

	$pcount = sql_fetch("select count(*) pnum from {$bot_table} where wr_9 = '{$pid}' and wr_6 = '{$wr_6}' and wr_7 = '{$wr_7}'");

	if($pcount['pnum'] >= $stuallnum2) {
		$pok = "1";
	} else {
		$pok = "0";
	}
	$pok1 = "0";

} elseif($fornum == 4) {

	$pcount1 = sql_fetch("select count(*) pnum from {$bot_table} where wr_9 = '{$pid}' and wr_6 = '{$wr_6}'");
	$pcount2 = sql_fetch("select count(*) pnum from {$bot_table} where wr_9 = '{$pid}' and wr_7 = '{$wr_7}'");

	if($pcount1['pnum'] >= $stuallnum) {
		$pok = "1";
	} else {
		$pok = "0";
	}

	if($pcount2['pnum'] >= $stuallnum2) {
		$pok1 = "1";
	} else {
		$pok1 = "0";
	}

}

die("{\"subject\":\"$subj\",\"content\":\"$cont\",\"pok\":\"$pok\",\"pok1\":\"$pok1\"}");

?>