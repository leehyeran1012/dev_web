<?php
$sub_menu = "999200";
require_once './_common.php';

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

auth_check_menu($auth, $sub_menu, 'w');

check_demo();

$tnum = isset($_GET["mn"]) ? intval($_GET["mn"]) : 1;

$result = sql_query(" select * from {$g5['menu_table']} order by me_code ");

$g5['title'] = "홈메뉴설정";
require_once './admin.head.php';

$colspan = 9;
$sub_menu_info = '';
?>

<div class="local_desc01 local_desc">
    <p><strong>홈메뉴관리</strong><br><strong>주의!</strong> 메뉴설정 작업 후 반드시 <strong>확인</strong>을 누르셔야 저장됩니다.<br>게시판인경우 http://~~~~bbs/ 부분은 생략해도 됩니다. 자동으로 추가됨.<br>코드는 탑메뉴 2자리, 서브메뉴 4자리(앞 2자리는 탑메뉴코드), 3단메뉴 6자리(앞 4자리는 서브메뉴코드)로 구성하세요</p>
</div>

<form name="fmenulist" id="fmenulist" method="post" action="./menu_home_update.php" onsubmit="return fmenulist_submit(this);">
    <input type="hidden" name="token" value="">
    <div id="menulist" class="tbl_head01 tbl_wrap">
        <table class="table table-sm table-hover text-center">
            <caption><?php echo $g5['title']; ?> 목록</caption>
            <thead>
                <tr>
                    <th scope="col" style="width:3rem">순번</th>
                    <th scope="col" style="width:11rem">메뉴</th>
                    <th scope="col">링크</th>
                    <th scope="col" style="width:10rem">코드</th>
                    <th scope="col">새창</th>
                    <th scope="col">순서</th>
                    <th scope="col">PC사용</th>
                    <th scope="col">모바일사용</th>
                    <th scope="col">관리</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $row = sql_fetch_array($result); $i++) {
                    $bg = 'table-info';
                    $sub_menu_class = '';

                    if (strlen($row['me_code']) == 4) {
                        $sub_menu_class = ' ps-5';
						$bg = '';
                        $sub_menu_info = '<span class="sound_only">' . $row['me_name'] . '의 서브</span>';
                    } elseif (strlen($row['me_code']) == 6) {
                        $sub_menu_class = ' text-end';
						$bg = '';
                        $sub_menu_info = '<span class="sound_only">' . $row['me_name'] . '의 서브</span>';
                    }

                    $search  = array('"', "'");
                    $replace = array('&#034;', '&#039;');
                    $me_name = str_replace($search, $replace, $row['me_name']);
                ?>
                    <tr class="<?php echo $bg; ?> menu_list menu_group_<?php echo substr($row['me_code'], 0, 2); ?>">
                        <td><?= ($i+1) ?></td>
                        <td class="td_category">
                            <input type="hidden" name="code[]" value="<?php echo $row['me_id'] ?>">
                            <label for="me_name_<?php echo $i; ?>" class="sound_only"><?php echo $sub_menu_info; ?> 메뉴<strong class="sound_only"> 필수</strong></label>
                            <input type="text" name="me_name[]" value="<?php echo get_sanitize_input($me_name); ?>" id="me_name_<?php echo $i; ?>" required class="tbl_input full_input<?=$sub_menu_class?>">
                        </td>
                        <td>
                            <label for="me_link_<?php echo $i; ?>" class="sound_only">링크<strong class="sound_only"> 필수</strong></label>
                            <input type="text" name="me_link[]" value="<?php echo $row['me_link'] ?>" id="me_link_<?php echo $i; ?>" required class="tbl_input full_input">
                        </td>
                        <td>
                            <label for="me_link_<?php echo $i; ?>" class="sound_only">코드<strong class="sound_only"> 필수</strong></label>
                            <input type="text" name="me_code[]" value="<?php echo $row['me_code'] ?>" id="me_code_<?php echo $i; ?>" required class="tbl_input full_input">
                        </td>
                        <td class="td_mng">
                            <label for="me_target_<?php echo $i; ?>" class="sound_only">새창</label>
                            <select name="me_target[]" id="me_target_<?php echo $i; ?>">
                                <option value="self" <?php echo get_selected($row['me_target'], 'self', true); ?>>사용안함</option>
                                <option value="blank" <?php echo get_selected($row['me_target'], 'blank', true); ?>>사용함</option>
                            </select>
                        </td>
                        <td class="td_num">
                            <label for="me_order_<?php echo $i; ?>" class="sound_only">순서</label>
                            <input type="text" name="me_order[]" value="<?php echo $row['me_order'] ?>" id="me_order_<?php echo $i; ?>" class="tbl_input" size="5">
                        </td>
                        <td class="td_mng">
                            <label for="me_use_<?php echo $i; ?>" class="sound_only">PC사용</label>
                            <select name="me_use[]" id="me_use_<?php echo $i; ?>">
                                <option value="1" <?php echo get_selected($row['me_use'], '1', true); ?>>사용함</option>
                                <option value="0" <?php echo get_selected($row['me_use'], '0', true); ?>>사용안함</option>
                            </select>
                        </td>
                        <td class="td_mng">
                            <label for="me_mobile_use_<?php echo $i; ?>" class="sound_only">모바일사용</label>
                            <select name="me_mobile_use[]" id="me_mobile_use_<?php echo $i; ?>">
                                <option value="1" <?php echo get_selected($row['me_mobile_use'], '1', true); ?>>사용함</option>
                                <option value="0" <?php echo get_selected($row['me_mobile_use'], '0', true); ?>>사용안함</option>
                            </select>
                        </td>
                        <td class="td_mng">
                            <a  href="<?=G5_ADMIN_URL?>/menu_delete.php?mid=<?=$row['me_id']?>&dgb=1" class="btn_del_menu btn_02" onclick="return confirm('해당 메뉴를 삭제하시겠습니까?')">삭제</a>
                        </td>
                    </tr>
                <?php }  ?>
				<?php for($y=1; $y<=$tnum; $y++) { ?>
                    <tr class="table-info">
                        <td>추가</td>
                        <td class="td_category">
                            <input type="hidden" name="code[]" value="0">
                            <label for="me_name_<?php echo $i; ?>" class="sound_only"><?php echo $sub_menu_info; ?> 메뉴<strong class="sound_only"> 필수</strong></label>
                            <input type="text" name="me_name[]" value="" id="me_name_<?php echo $i; ?>" class="tbl_input full_input">
                        </td>
                        <td>
                            <label for="me_link_<?php echo $i; ?>" class="sound_only">링크<strong class="sound_only"> 필수</strong></label>
                            <input type="text" name="me_link[]" value="board.php?bo_table=" id="me_link_<?php echo $i; ?>" class="tbl_input full_input">
                        </td>
                        <td>
                            <label for="me_link_<?php echo $i; ?>" class="sound_only">코드<strong class="sound_only"> 필수</strong></label>
                            <input type="text" name="me_code[]" value="" id="me_code_<?php echo $i; ?>" class="tbl_input full_input">
                        </td>
                        <td class="td_mng">
                            <label for="me_target_<?php echo $i; ?>" class="sound_only">새창</label>
                            <select name="me_target[]" id="me_target_<?php echo $i; ?>">
                                <option value="self">사용안함</option>
                                <option value="blank">사용함</option>
                            </select>
                        </td>
                        <td class="td_num">
                            <label for="me_order_<?php echo $i; ?>" class="sound_only">순서</label>
                            <input type="text" name="me_order[]" value="0" id="me_order_<?php echo $i; ?>" class="tbl_input" size="5">
                        </td>
                        <td class="td_mng">
                            <label for="me_use_<?php echo $i; ?>" class="sound_only">PC사용</label>
                            <select name="me_use[]" id="me_use_<?php echo $i; ?>">
                                <option value="1">사용함</option>
                                <option value="0">사용안함</option>
                            </select>
                        </td>
                        <td class="td_mng">
                            <label for="me_mobile_use_<?php echo $i; ?>" class="sound_only">모바일사용</label>
                            <select name="me_mobile_use[]" id="me_mobile_use_<?php echo $i; ?>">
                                <option value="1">사용함</option>
                                <option value="0">사용안함</option>
                            </select>
                        </td>
                        <td class="td_mng"><?php if($y == 1) { ?>
							<div class="dropdown">
								  <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									추가
								  </button>
								  <ul class="dropdown-menu">
									<?php for($t=1; $t<=5; $t++) { ?>
									<li><a class="dropdown-item" href="<?=G5_ADMIN_URL?>/menu_home.php?mn=<?=$t?>"><?=$t?>개</a></li>
									<?php } ?>
								  </ul>
							</div><?php } ?>
						</td>
                    </tr>
				<?php }
                if ($i == 0) {
                    echo '<tr id="empty_menu_list"><td colspan="' . $colspan . '" class="empty_table">자료가 없습니다.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="btn_confirm01 btn_confirm">
        <input type="submit" name="act_button" value="확인" class="btn_submit btn ">
    </div>

</form>

<script>
    function fmenulist_submit(f) {

        var me_links = document.getElementsByName('me_link[]');
        var reg = /^javascript/;

        for (i = 0; i < me_links.length; i++) {

            if (reg.test(me_links[i].value)) {

                alert('링크에 자바스크립트문을 입력할수 없습니다.');
                me_links[i].focus();
                return false;
            }
        }

        return true;
    }
</script>

<?php
require_once './admin.tail.php';
