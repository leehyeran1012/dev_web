<!doctype html>
<html lang="ko">
<head>
<title>상담카드</title>
<meta  charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="language" content="ko">
<meta name="viewport" content="initial-scale=1.0, width=device-width">
<meta name="naver-site-verification" content="c643adeda55cb4229057cb76b80144efbe4ef488">
<meta name="format-detection" content="telephone=no"><meta name="title" content="대구광역시 동구 진로진학 지원센터">
<meta name="author" content="http://www.dongguhope.co.kr">
<meta name="description" content="대구광역시 동구 진로진학 지원센터, 센터소개, 청소년 지원사업, 053-958-0607">
<link rel="canonical" href="http://www.dongguhope.co.kr">
<link rel="stylesheet" type="text/css" href="/gnuboardx/css/w3.css">
</head>

<body>
<?php
include "_common.php";

$bo_table = $_GET['bo_table'] ?? "";
$p_num = $_GET['g_num'] ?? 2;

$result = sql_query("select * from g5_write_{$bo_table} where wr_9 = '{$p_num}'");

while($field = sql_fetch_array($result)) {
?>
<div style='page-break-before:always'><br><br>
 <table class="w3-table w3-bordered-all" style="width:800px; margin:auto">
  <tr>
	<td colspan="4" class="w3-center"><h1>동구 진로진학 지원센터</h1></td>
  </tr>
  <tr>
	<th width="120" height="40" class="w3-center">학교명</th>
	<td class="w3-center w3-cell-middle"><?= $field['wr_2'] ?> &nbsp;<?= $field['wr_3'] ?>학년</td>
	<th width="120" class="w3-center">성명</th>
	<td class="w3-center w3-cell-middle"><?= $field['wr_name'] ?></td>
  </tr>
  <tr>
	<th width="120" height="40" class="w3-center">요청사항</th>
	<td colspan="3"> <?= $field['wr_content'] ?></td>
  </tr>
  <tr>
	<th width="120" height="40" class="w3-center">상담내용</th>
	<td colspan="3" height="500"></td>
  </tr>
  </table>
</div>

<?php }	?>

</body>
</html>