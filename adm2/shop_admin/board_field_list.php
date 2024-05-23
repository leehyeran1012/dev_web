<?php
$sub_menu = "999500";
require_once './_common.php';

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

auth_check_menu($auth, $sub_menu, 'w');
check_demo();

$sql = " select count(*) as cnt from {$g5['board_table']} ";
$field = sql_fetch($sql);
$total_count = $field['cnt'];

$sql = " select * from {$g5['board_table']} ";
$result = sql_query($sql);

$g5['title'] = '여분필드 관리';
require_once G5_ADMIN_PATH . '/admin.head.php';

//테이블 여분필드수 체크
function extra_column_num2($bo_table) {
    $cnt = 0;
    $bo_table = G5_TABLE_PREFIX."write_".$bo_table;
    $colunms = sql_field_names($bo_table);
    foreach($colunms as $colunm) {
        if (preg_match('/(wr_[0-9])/', $colunm))  $cnt++;
    }
    return $cnt;
}
?>

<div class="local_ov01 local_ov">
    <span class="btn_ov01"><span class="ov_txt">생성된 게시판수</span><span class="ov_num"> <?= number_format($total_count) ?>개</span></span>
</div>
<div class="local_desc01 local_desc" style="width:650px">
    <p>여분필드 관리입니다. <strong>wr_11 ~ wr_끝번호</strong> 로 만들어집니다.<br>
	추가된 필드수를 줄이려면 끝번호에 줄일 숫자를 입력하세요.(10개 이하로는 줄일수 없습니다.)<br>
	필드를 줄이면 해당 필드 내용도 삭제되니 주의하세요.</p>
</div>

    <div class="tbl_head01 tbl_wrap">
        <table class="table table-hover align-middle" style="width:650px">
            <caption><?= $g5['title']; ?> 목록</caption>
            <thead>
                <tr>
                    <th width="70">연번</th>
                    <th width="150">TABLE</th>
                    <th width="150">현재 여분필드</th>
                    <th>추가할 끝번호(숫자만 입력)</th>
                    <th width="100">수정</th>
                </tr>
            </thead>
            <tbody>

           <?php  foreach ($result as $key=>$field) {
			   $fcnt = extra_column_num2($field['bo_table']);
			   if($fcnt > 10) {
				   $fnum = " text-primary";
			   } else {
				   $fnum = " text-muted";
			   }
			?>
			<form name="form<?=$key?>" action="./board_field_update.php" method="post">
			    <input type="hidden" name="bo_table" value="<?= $field['bo_table'] ?>">
			    <input type="hidden" name="org_fnum" value="<?= $fcnt ?>">
                    <tr>
                        <td class="text-center"><?= ($key+1) ?></td>
                        <td><?= $field['bo_table'] ?></td>
                        <td class="text-center fw-bold<?= $fnum ?>">wr_1 ~ wr_<?= $fcnt ?></td>
                        <td><input type="text" name="wr_end" value="" class="frm_input" maxlength="3" size="10" required></td>
                        <td class="text-center"><input type="submit" class="btn btn_02" value="수정"></td>
                    </tr>
				</form>
                <?php } ?>
            </tbody>
        </table>
    </div>

<?php
require_once './admin.tail.php';