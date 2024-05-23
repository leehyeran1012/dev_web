<?php
include_once('./_common.php');
include_once('apply.confirm.lib.php');

set_include_path( get_include_path().PATH_SEPARATOR."..");
include_once("xlsxwriter.class.php");
$writer = new XLSXWriter();


$g_num = !empty($_GET['g_num']) ? intval($_GET['g_num'])  : 0;

$boa_table = $g5['write_prefix'].$bo_table;
$bot_table = $g5['write_prefix'].$bo_table."_result";

$ptitle = sql_fetch("select wr_subject from {$boa_table} where wr_id = '{$g_num}'");

$wr_subject = str_replace(" ","",$ptitle['wr_subject']);
$filename = $wr_subject.".xlsx";
$filepath1 = G5_DATA_PATH."/tmp/".$filename;

$openk = select_confirm($bo_table, $g_num);

$header = [];
$widths = [];

// 제목줄은 명칭이 모두 달라야 됨

$header["연번"] = 'integer';
$header["신청자	"] = 'string';
$widths[] = 10; $widths[] = 15;
if($openk[1] > 1) {
$header["	선택1"] = 'string';
$header["	선택2"] = 'string';
$widths[] = 25; $widths[] = 20;
}
$header["	전화번호"] = 'string';
$header["	성별"] = 'string';
$widths[] = 20; $widths[] = 10;

if(count($openk[8]) > 0) {
	foreach($openk[8] as $key=>$value) {
		$item_array = explode("^",$value);
		$sub_title = trim($item_array[0]);
		$header[$sub_title] = 'string';
		$widths[] = 20;
	 }
 }

$header['요청사항'] = 'string';
$header['신청일자'] = 'string';
$widths[] = 25;
$widths[] = 25;

$result = sql_query("select wr_id,wr_subject,wr_content,wr_name,wr_last,wr_1,wr_2,wr_3,wr_4,wr_5,wr_6,wr_7,wr_8,wr_9,wr_10 from {$bot_table} where wr_link2 = '{$g_num}' order by wr_name");


$styles1 = array('font'=>'맑은 고딕','font-size'=>12,'font-style'=>'bold', 'fill'=>'#ccff999', 'halign'=>'center', 'valign'=>'center', 'border'=>'left,right,top,bottom', 'widths'=>$widths);
$styles2 = array( 'font'=>'맑은 고딕','font-size'=>12, 'halign'=>'center', 'valign'=>'center', 'border'=>'left,right,top,bottom','wrap_text'=>true);

//제목줄 설정 서식 포함
$writer->writeSheetHeader('Sheet1', $header, $styles1);

// 내용 입력

	$contents = [];

	foreach ($result as $field) {

		$y++;
		$x = 5;

		$wrk1 = intval($field['wr_1']) - 1;
		$wrk2 = intval($field['wr_2']) - 1;
		if(count($openk[3]) == 1) $wrk1 = 0;

		$p_items = explode("^", $openk[3][$wrk1]);

		$contents[] = $y;
		$contents[] = $field['wr_name'];
	if($openk[1] > 1) {
		$contents[] = $openk[2][$wrk1];
		$contents[] = $p_items[$wrk2];
	}
		$contents[] = $field['wr_3'];
		$contents[] = $field['wr_4'];

		if(count($openk[8]) > 0) {
			foreach($openk[8] as $key=>$value) {
				$contents[] = str_replace(["|","기타:"], " ",$field['wr_'.$x]);
				$x++;
			}
		}

		$contents[] = $field['wr_content'];
		$contents[] = $field['wr_last'];

		$writer->writeSheetRow('Sheet1', $contents, $styles2);
		$contents = [];
	}

$writer->writeToFile($filepath1);

$filepath = addslashes($filepath1);
$original = urlencode($filename);

if(preg_match("/msie/i", $_SERVER["HTTP_USER_AGENT"]) && preg_match("/5\.5/", $_SERVER["HTTP_USER_AGENT"])) {
    header("content-type: doesn/matter");
    header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-transfer-encoding: binary");
} else if (preg_match("/Firefox/i", $_SERVER["HTTP_USER_AGENT"])){
    header("content-type: file/unknown");
    header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"".basename($filename)."\"");
    header("content-description: php generated data");
} else {
    header("content-type: file/unknown");
    header("content-length: ".filesize("$filepath"));
    header("content-disposition: attachment; filename=\"$original\"");
    header("content-description: php generated data");
}
header("pragma: no-cache");
header("expires: 0");
flush();

$fp = fopen($filepath, "rb");

if (!fpassthru($fp)) {
    fclose($fp);
}

//파일 삭제
if(file_exists($filepath1)) {
	@unlink($filepath1);
}