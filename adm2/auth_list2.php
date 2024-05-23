<?php
$sub_menu = "999100";
require_once "./_common.php";

auth_check_menu($auth, $sub_menu, 'w');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

$x = $xx = 0;
$c_user = isset($_GET["c_user"]) ? html_purifier($_GET["c_user"]) : "all";

if($c_user == "all") {
	$sql = " select count(*) as cnt  from {$g5['auth_table']} ";
} else {
	$sql = " select count(*) as cnt  from {$g5['auth_table']} where mb_id = '{$c_user}' ";
}

$tcount = sql_fetch($sql);

$total_count = $tcount["cnt"];	//총 레코드 수
$rows = 10;
$total_page  = ceil($total_count / $rows);
if ($page < 1) {
    $page = 1;
}
$from_record = ($page - 1) * $rows; // 시작 열을 구함

if($c_user == "all") {
	$sql = "select * from {$g5['auth_table']} a left join {$g5['menu_admin']} b on a.au_menu = b.me_acode where length(me_code) > 2 order by mb_id, me_acode limit {$from_record}, {$rows}";
} else {
	$sql = "select * from {$g5['auth_table']} a left join {$g5['menu_admin']} b on a.au_menu = b.me_acode where mb_id = '{$c_user}' and  length(me_code) > 2 order by me_acode";
}
$result2 = sql_query($sql);

$g5['title'] = "관리권한설정";
require_once './admin.head.php';

?>
<style type="text/css">
	label {font-size: 18px;line-height: 2rem;padding: 0.2em 0.4em;}
	[type="radio"], span {vertical-align: middle;}
	[type="radio"] {appearance: none; border: max(1px, 0.1em) solid #a4a4a4; border-radius: 50%; width: 1.15em; height: 1.15em; transition: border 0.5s ease-in-out;}
	[type="radio"]:checked {border: 0.4em solid tomato;}
	[type="radio"]:focus-visible {outline-offset: max(2px, 0.1em); outline: max(2px, 0.1em) dotted tomato;}
	[type="radio"]:hover {box-shadow: 0 0 0 max(4px, 0.2em) #ffccff; cursor: pointer;}
	[type="radio"]:hover + span {cursor: pointer;}
	.btn_fixed_top{margin:0 20px;text-align:left;padding-bottom:10px;}
</style>

<div class="local_ov01 local_ov">
    <span class="btn_ov01"><span class="ov_txt">설정된 관리권한</span><span class="ov_num"><?= number_format($total_count) ?>건</span></span>
	<p class="mt-2 mb-4">*** 여기에 설정된 권한은 그누보드의 권한을 사용합니다.  보기(r), 수정(rw), 삭제(rd), 모두(rwd)</p>
</div>
	<div class="container-fluid px-3">
		<div class="row">
			<div class="col-2">
				<select class="form-select rounded-0 fs-7 fw-bold bg-light mb-2" name="c_user" aria-label="사용자선택" onchange="window.location.href=this.value">
					  <option value="./auth_list2.php"<?= ($c_user == "all") ? " selected" : ""; ?>> &nbsp;모두보기</option>
				<?php
					$sql = "select distinct mb_id from {$g5['auth_table']} order by mb_id";
					$users = sql_query($sql);
					foreach($users as $field) { ?>
					  <option value="./auth_list2.php?c_user=<?=$field["mb_id"]?>"<?= ($c_user == $field["mb_id"]) ? " selected" : ""; ?>> &nbsp;<?= $field["mb_id"] ?></option>
				<?php } ?>
				</select>
			</div>
			<div class="col">
			<?php if($c_user <> "all") { ?>
			<a href="./auth_list_delete2.php?mb_id=<?=$c_user?>&d_gb=1" class="btn btn_01" onclick="return confirm('<?=$c_user?>님 권한을 삭제하시겠습니까? 삭제후에는 복구할 수 없습니다.')"><?=$c_user?>님 권한 모두삭제</a>
			<?php } ?>
			</div>
		</div>

	<form name="fboardlist" id="fboardlist" action="./auth_update2.php?u_gb=1" onsubmit="return fboardlist_submit(this);" method="post">
		<input type="hidden" name="sst" value="<?= $sst ?>">
		<input type="hidden" name="sod" value="<?= $sod ?>">
		<input type="hidden" name="sfl" value="<?= $sfl ?>">
		<input type="hidden" name="stx" value="<?= $stx ?>">
		<input type="hidden" name="page" value="<?= $page ?>">
		<input type="hidden" name="token" value="">

        <table class="table table-bordered text-center table-hover fs-7 align-middle">
            <caption><?= $g5['title']; ?> 목록</caption>
            <thead>
                <tr>
                    <th class="bg-light" width="80">
                        <label for="chkall" class="sound_only">게시판 전체</label>
                        <input type="checkbox" name="chkall" value="1" id="chkall" onclick="check_all(this.form)">
                    </th>
                    <th class="bg-light" width="140">아이디</th>
                    <th class="bg-light" width="250">메뉴명</th>
                    <th class="text-start ps-3 bg-light">권한</th>
                </tr>
            </thead>
            <tbody>
         	<?php foreach($result2 as $key=>$field) { ?>

                    <tr>
                        <td class="td_chk">
                            <label for="chk_<?= $key; ?>" class="sound_only"><?= get_text($field["me_name"]) ?></label>
                            <input type="checkbox" name="chk[]" value="<?= $key ?>" id="chk_<?= $key ?>">
                        </td>
                        <td><?= $field["mb_id"] ?></td>
                        <td class="text-start ps-3"><?=$field["me_acode"]?> <?= $field["me_name"] ?></td>
                        <td class="text-start ps-3">
							<input type="hidden" name="mb_id[<?= $key ?>]" value="<?=$field["mb_id"]?>">
							<input type="hidden" name="au_code[<?= $key ?>]" value="<?=$field["au_menu"]?>">
							<input type="radio" name="mb_auth[<?= $key ?>]" value="r"<?= ($field["au_auth"]=="r") ? " checked" : ""; ?> onclick='toggleCheckt(<?=$key?>)'><span class="me-2"> 보기</span>
							<input type="radio" name="mb_auth[<?= $key ?>]" value="r,w"<?= ($field["au_auth"]=="r,w") ? " checked" : ""; ?> onclick='toggleCheckt(<?=$key?>)'><span class="me-3"> 수정</span>
							<input type="radio" name="mb_auth[<?= $key ?>]" value="r,d"<?= ($field["au_auth"]=="r,d") ? " checked" : ""; ?> onclick='toggleCheckt(<?=$key?>)'><span class="me-2"> 삭제</span>
							<input type="radio" name="mb_auth[<?= $key ?>]" value="r,w,d"<?= ($field["au_auth"]=="r,w,d") ? " checked" : ""; ?> onclick='toggleCheckt(<?=$key?>)'> 모두
						</td>
                    </tr>
                <?php
						$x++;
				}  ?>
            </tbody>
        </table>

    <div class="text-start">
        <input type="submit" name="act_button" value="선택수정" onclick="document.pressed=this.value" class="btn_02 btn">
        <input type="submit" name="act_button" value="선택삭제" onclick="document.pressed=this.value" class="btn_01 btn">
    </div>

</form>

	<div class="d-flex justify-content-end p-0 mb-2">
	<?php
		$pagelist = get_paging($rows, $page, $total_page, $_SERVER['SCRIPT_NAME'] . '?' . $qstr . '&amp;page=');
		echo $pagelist;
	?>
	</div>
</div>
<br>
<div class="local_ov01 local_ov">
    <span class="btn_ov01"><span class="ov_txt">관리권한 추가</span><span class="ov_num">회원 아이디 입력 후 해당 메뉴에 대한 권한을 체크한 후 저장하세요. 보기(r), 수정(rw), 삭제(rd), 모두(rwd)</span></span>
</div>

<div class="container-fluid px-3">
<form name="fauthlist" id="fauthlist" method="post" action="./auth_update2.php"  onsubmit="return fwrite_submit(this);">
    <input type="hidden" name="token" value="">

<div class="container-fluid">

	<div class="row border">
		<div class="col-1 text-center bg-light pt-3 fw-bold border-end">회원 ID</div>
		<div class="col-2 bg-light py-2"><input type="text" name="mb_id" class="form-control border border-primary-subtle text-center text-primary fs-5 rounded-0" title="아이디" required style="ime-mode:inactive;"></div>
		<div class="col-9 bg-light py-2">&nbsp;</div>
	</div>
	<div class="row border">
		<div class="col">
		<?php
		$tt = 0;
		$ad_menus = sql_query(" select * from {$g5['menu_admin']} where length(me_code) = 2 and length(me_acode) = 6 and me_use = 1 order by me_code ");
		foreach($ad_menus as $key=>$field) {
			$sql2 = " select * from {$g5['menu_admin']} where length(me_code) = 4 and left(me_code,2) = '".$field["me_code"]."' and length(me_acode) = 6 and me_use = 1 order by me_code ";
			$ad_submenus = sql_query($sql2);
		 if($key==0) { ?>
			<div class="row mb-3">
		 <?php } elseif($key==5) { ?>
			</div>
			<div class="row mb-2">
		<?php } ?>

			<div class="col p-0">
				<ul class="list-group">
				  <li class="list-group-item border-0 fw-bold bg-light"><?= $field["me_name"]?></li>
				<?php foreach($ad_submenus as $key2=>$field2) {
						$sql3 = " select * from {$g5['menu_admin']} where length(me_code) = 6 and left(me_code,4) = '".$field2["me_code"]."' and length(me_acode) = 6 and me_use = 1 order by me_code ";
						$ad_submenus2 = sql_query($sql3);
				 if(sql_num_rows($ad_submenus2) == 0) { ?>

				  <li class="list-group-item small border-0 p-0 ps-3"><strong><?= $field2['me_name'] ?></strong>
						<input type="hidden" name="code[]" value="<?= $field2["me_id"] ?>">
						<input type="hidden" name="au_name[]" value="<?= $field2["me_name"] ?>">
						<input type="hidden" name="au_acode[]" value="<?= $field2["me_acode"] ?>">
				  </li>
				  <li class="list-group-item list-group-item-action small border-0 p-0 mb-2 ps-3 text-primary">
						<input type="radio" name="me_auth[<?= $tt ?>]" value="r"><span>보기</span>
						<input type="radio" name="me_auth[<?= $tt ?>]" value="r,w"><span>수정</span>
						<input type="radio" name="me_auth[<?= $tt ?>]" value="r,d"><span>삭제</span>
						<input type="radio" name="me_auth[<?= $tt ?>]" value="r,w,d"><span>모두</span>
					</li>
				<?php } else {
				  foreach($ad_submenus2 as $field3) { ?>
				  <li class="list-group-item small border-0 p-0 ps-3"><strong><?= $field3['me_name'] ?></strong>
						<input type="hidden" name="code[]" value="<?= $field3["me_id"] ?>">
						<input type="hidden" name="au_name[]" value="<?= $field3["me_name"] ?>">
						<input type="hidden" name="au_acode[]" value="<?= $field3["me_acode"] ?>">
				  </li>
				  <li class="list-group-item list-group-item-action small border-0 p-0 ps-3 mb-2 text-primary">
						<input type="radio" name="me_auth[<?= $tt ?>]" value="r"><span>보기</span>
						<input type="radio" name="me_auth[<?= $tt ?>]" value="r,w"><span>수정</span>
						<input type="radio" name="me_auth[<?= $tt ?>]" value="r,d"><span>삭제</span>
						<input type="radio" name="me_auth[<?= $tt ?>]" value="r,w,d"><span>모두</span>
					</li>
			<?php
				$tt++;
			  }
				$tt--;
			}
				$tt++;
		 } ?>
				</ul>
			</div>

		<?php } ?>
				</div>
			</div>
		</div>

	</div>


	<div class="btn_confirm write_div mt-3">
		<button type="submit" id="btn_submit" accesskey="s" class="btn_submit btn">작성완료</button>
	</div>
</form>
<div>

<script>
    function fboardlist_submit(f) {
        if (!is_checked("chk[]")) {
            alert(document.pressed + " 하실 항목을 하나 이상 선택하세요.");
            return false;
        }

        if (document.pressed == "선택삭제") {
            if (!confirm("선택한 자료를 정말 삭제하시겠습니까?")) {
                return false;
            }
        }
        return true;
    }

     function fwrite_submit(f)
    {
        document.getElementById("btn_submit").disabled = "disabled";
        return true;
    }

	function toggleCheckt(id) {
		  $("#chk_"+id).prop("checked", true);
    }
</script>

<?php
require_once './admin.tail.php';
