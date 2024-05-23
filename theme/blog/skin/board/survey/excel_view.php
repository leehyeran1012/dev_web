<?php
include_once('./_common.php');

set_include_path( get_include_path().PATH_SEPARATOR."..");
include_once("xlsxwriter.class.php");

$wr_id = !empty($_GET['g_num']) ? intval($_GET['g_num'])  : 0;

$result2 = sql_fetch("select wr_id, wr_subject, wr_1, wr_5, wr_6 from {$write_table} where wr_id = '{$wr_id}'");

$p_tnum = $result2['wr_5'];
$sub_title =  explode(",",$result2['wr_6']);
$p_subject =  str_replace(" ","",$result2['wr_subject']);
$p_subject =  str_replace(",","",$p_subject);

$sfield = "wr_".$p_tnum;
$header = [];
$widths = [];
$header["연번"] = 'string';
$widths[] = 20;

foreach($sub_title as $key=>$value) {
	$sfield = $sfield.", wr_".($p_tnum+$key+1);
	$header[$value] = 'string';
	$widths[] = 20;
}

$result = sql_query("select * from {$write_table}_result where wr_link2 = '{$wr_id}' order by wr_{$p_tnum}");

$writer = new XLSXWriter();

$styles2 = array( 'font'=>'맑은 고딕','font-size'=>12, 'halign'=>'center', 'valign'=>'center', 'border'=>'left,right,top,bottom','wrap_text'=>true);

// 제목명은 모두 달라야 됨

$styles1 = array('font'=>'맑은 고딕','font-size'=>12,'font-style'=>'bold', 'fill'=>'#ccff999', 'halign'=>'center', 'valign'=>'center', 'border'=>'left,right,top,bottom', 'widths'=>$widths);
//$header = array('학번' => 'string', '성명' => 'string', '내용' => 'string');
$writer->writeSheetHeader('Sheet1', $header, $styles1);	//제목줄 서식 포함

$contents = [];

foreach ($result as $key=>$field) {
	$contents[] = $key+1;
	foreach ($sub_title as $key2=>$value) {
		$contents[] = str_replace("|","",$field['wr_'.($p_tnum+$key2)]);
	}
	$writer->writeSheetRow('Sheet1', $contents, $styles2);
	$contents = [];
}


$filename = $p_subject.".xlsx";

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