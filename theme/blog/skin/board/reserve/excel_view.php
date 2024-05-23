<?php
include_once('./_common.php');

set_include_path( get_include_path().PATH_SEPARATOR."..");
include_once("xlsxwriter.class.php");

$wr_id = !empty($_GET['g_num']) ? intval($_GET['g_num'])  : 0;
$titles = [];

$que1 = sql_fetch("select wr_id,wr_subject,wr_content,wr_1, wr_4 from {$write_table} where wr_id = '{$wr_id}'");
$t_date = $que1['wr_1'];
$titles2 = str_replace("\r\n","",$que1['wr_4']);

if(strlen($titles2) > 3) $titles = explode("|",$titles2);

$result = sql_query("select wr_id,wr_content,wr_name,wr_last,wr_1,wr_2,wr_3,wr_4,wr_5,wr_6,wr_7,wr_8,wr_9,wr_10 from {$write_table}_result where left(wr_1,7) = '{$t_date}' order by wr_name");

$header = [];
$widths = [];

$header["연번"] = 'integer';
$header["예약자	"] = 'string';
$header["	예약일자"] = 'string';
$header["	예약시간"] = 'string';
$header["	전화번호"] = 'string';
$header["	성별"] = 'string';

$widths[] = 10; $widths[] = 20; $widths[] = 20; $widths[] = 20; $widths[] = 20; $widths[] = 20;

if(count($titles) > 0) {
	foreach($titles as $key=>$value) {
		$item_array = explode("^",$value);
		$sub_title = $item_array[0];
		$title2 =  trim($sub_title);
		$header[$title2] = 'string';
		$widths[] = 20;
	}
}

$header["	요청사항"] = 'string';
$header["	신청일"] = 'string';

$widths[] = 50; $widths[] = 30;

$writer = new XLSXWriter();

$styles2 = array( 'font'=>'맑은 고딕','font-size'=>12, 'halign'=>'left', 'valign'=>'center', 'border'=>'left,right,top,bottom','wrap_text'=>true);

// 제목명은 모두 달라야 됨
//$header = array('학번' => 'string', '성명' => 'string', '내용' => 'string');

$styles1 = array('font'=>'맑은 고딕','font-size'=>12,'font-style'=>'bold', 'fill'=>'#ccff999', 'halign'=>'left', 'valign'=>'center', 'border'=>'left,right,top,bottom', 'widths'=>$widths);

$writer->writeSheetHeader('Sheet1', $header, $styles1);	//제목줄 서식 포함

$contents = [];
$x = 2;
$y = 0;

foreach ($result as $field) {
	$y++;
	$x = 5;
	$contents[] = $y;
	$contents[] = $field['wr_name'];
	$contents[] = $field['wr_1'];
	$contents[] = $field['wr_2'];
	$contents[] = $field['wr_3'];
	$contents[] = $field['wr_4'];

	if(count($titles) > 0) {
		foreach ($titles as $value) {
			$contents[] = str_replace("|", " ",$field['wr_'.$x]);
			$x++;
		}
	}
	$contents[] = $field['wr_content'];
	$contents[] = $field['wr_last'];

	$writer->writeSheetRow('Sheet1', $contents, $styles2);
	$contents = [];
}


$filename = $t_date."신청현황.xlsx";

$writer->writeToFile(G5_DATA_PATH.'/tmp/'.$filename);

$filepath = G5_DATA_PATH.'/tmp/'.$filename;
$filepath = addslashes($filepath);
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

$delete_file = G5_DATA_PATH.'/tmp/'.$filename;
if(file_exists($delete_file) ){
	@unlink($delete_file);
}