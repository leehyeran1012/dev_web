<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/custom.css">', 0);
?>
<script>
	window.history.forward();
</script>
<script>
	$(document).on("keyup", ".tel", function() {		//휴대전화 자동 하이픈(-) 입력
		$(this).val($(this).val().replace(/[^0-9]/g, '').replace(/(^02|^0505|^1[0-9]{3}|^0[0-9]{2})([0-9]+)?([0-9]{4})$/,'$1-$2-$3').replace('--', '-'));
	});
</script>
<script src='<?=$board_skin_url?>/survey.js'></script>
<script src="<?=$board_skin_url?>/jquery-qrcode-0.18.0.min.js"></script>

<?php

$k_num = isset($_GET["k_num"]) ? intval($_GET["k_num"]) : 0;

if($k_num == 0) {
	goto_url("./board.php?bo_table={$bo_table}");
}

if ($is_member) {
	$sname = get_text($member['mb_id']);
} else {
	$sname = "A".date("YmdHis",time()).rand(100,999);
}

$bot_table = str_replace("_result","",$bo_table);
$boa_table = str_replace("_result","",$write_table);

if($w == "") {

	$que1 = sql_fetch("select * from {$write_table} where wr_link2 = '{$k_num}' and mb_id = '{$sname}'");
	if($que1) {
		alert("이미 설문에 참여하셨습니다. 변경하시려면 수정하세요.",G5_BBS_URL."/write.php?w=u&bo_table={$bo_table}&wr_id={$que1['wr_id']}&k_num={$k_num}");
	}
}

$que1 = sql_fetch("select wr_subject, wr_content, wr_1,wr_2,wr_3,wr_4,wr_7 from {$boa_table} where wr_id = '{$k_num}'");
$pcontent = $que1['wr_content'];

$svcontents = str_replace("\r\n","",$que1['wr_1']);
$svcontents = explode("Q#",$svcontents);

$selgb = $que1['wr_7'];	//신청제한

function open_confirm($sdate, $edate, $otime) {

	$oc_time = explode("~",$otime);
	$nowDate = date("Y-m-d H:i:s");	//현재시간
	$oDate = "{$sdate} {$oc_time[0]}:00";		//오픈시간
	$cDate = "{$edate} {$oc_time[1]}:00";		//종료시간

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

$open_ok = open_confirm($que1['wr_2'], $que1['wr_3'], $que1['wr_4']);

if($open_ok > 0) {
	alert("지금은 설문기간이 아닙니다.","./board.php?bo_table={$bo_table}");
}
?>

<div class="container p-0 mt-5">
    <h2 class="sound_only"><?= $g5['title'] ?></h2>

    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="<?= $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" autocomplete="off" style="width:<?= $width; ?>">
    <input type="hidden" name="uid" value="<?= get_uniqid(); ?>">
    <input type="hidden" name="w" value="<?= $w ?>">
    <input type="hidden" name="bo_table" value="<?= $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?= $wr_id ?>">
    <input type="hidden" name="sca" value="<?= $sca ?>">
    <input type="hidden" name="sfl" value="<?= $sfl ?>">
    <input type="hidden" name="stx" value="<?= $stx ?>">
    <input type="hidden" name="spt" value="<?= $spt ?>">
    <input type="hidden" name="sst" value="<?= $sst ?>">
    <input type="hidden" name="sod" value="<?= $sod ?>">
    <input type="hidden" name="page" value="<?= $page ?>">
    <input type="hidden" name="wr_subject" value="<?= $que1['wr_subject'] ?>">
    <input type="hidden" name="wr_name" value="<?= $sname ?>">
    <input type="hidden" name="wr_link2" value="<?= $k_num ?>">
    <input type="hidden" name="wr_content" value="<?= $que1['wr_subject'] ?>">
    <input type="hidden" name="svy_gb" value="<?= $selgb ?>">

	<?php

    $option = '';
    $option_hidden = '';
    if ($is_notice || $is_html || $is_secret || $is_mail) {
        $option = '';
        if ($is_notice) {
            $option .= "\n".'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label for="notice">공지</label>';
        }

        if ($is_html) {
            if ($is_dhtml_editor) {
                $option_hidden .= '<input type="hidden" value="html1" name="html">';
            } else {
                $option .= "\n".'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="html">HTML</label>';
            }
        }

        if ($is_secret) {
            if ($is_admin || $is_secret==1) {
                $option .= "\n".'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'."\n".'<label for="secret">비밀글</label>';
            } else {
                $option_hidden .= '<input type="hidden" name="secret" value="secret">';
            }
        }

        if ($is_mail) {
            $option .= "\n".'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'."\n".'<label for="mail">답변메일받기</label>';
        }
    }

    echo $option_hidden;
    ?>

	<div class="row">
		<div class="col-sm-12 col-md-8 mb-5">
			<h1><?= $que1['wr_subject'] ?></h1><br>
			<p><?= $pcontent ?></p>
			<p style="color:red"><br>※ 선택항목을 제외한 모든 문항을 입력하셔야 저장됩니다.</p>
		</div>
		<div class="col-sm-12 col-md-4 mb-5">
			<div class="qr">
				<div id="qr_area"></div>
			</div>
			<script>
				$(function() {
					$('#qr_area').qrcode({
						render : "canvas",      // canvas image div 형식 3 종류가 있다.
						width : 200,            //넓이 조절
						height : 200,           //높이 조절
						fill: '#000',
						text : "<?=G5_BBS_URL?>/write.php?bo_table=<?=$bo_table?>&k_num=<?=$k_num?>",
					});
				});
			</script>
		</div>
	</div>

<?php

	$xx = $tc = $tc2 = $yy = 0;

	foreach($svcontents as $key=>$value) {

		$tt = $cm = 0;

		$item_array = explode("^",$value);
		if (strpos($item_array[0], "[[") !== false ) {
			$sub_titlek = explode("[[",$item_array[0]);
			$sub_titleh = $sub_titlek[0];
			$sub_title = str_replace("//","<br><br>",$sub_titlek[1]);
		} else {
			$sub_title = str_replace("//","<br><br>",$item_array[0]);
		}

		if (mb_strpos($sub_title, "#선택") !== false ) {
			$selok = 0;
			$sub_title = str_replace("(#선택)","<span class='text-danger'> (선택)</span>",$sub_title);
		} else {
			$selok = 1;	//필수항목
			if (strpos($sub_title, "]]") !== false ) {
				$sub_titlekk = explode("]]",$sub_title);
				$sub_title = $sub_titlekk[0]."<span class='text-danger'>*</span><div class='border bg-light fs-6 rounded p-3 mx-3 my-3'>".$sub_titlekk[1]."</div>";
			} else {
				$sub_title = $sub_title."<span class='text-danger'>*</span>";
			}
		}

	if($key > 0) {

		$xx++;

		if (strpos($value, "^c") !== false ) $tc = $tc.",".$xx;
		if (strpos($value, "^p") !== false ) $tc2 = $tc2.",".$xx;

	 if (strpos($item_array[0], "[[") !== false ) { ?>
		<div class="shadow py-3 mb-3 rounded">
			<h5 class="text-center text-success fw-bold"><?=str_replace("//","<br>",$sub_titleh) ?></h5>
		</div>
	<?php } ?>
	<div class="col-sm-12 shadow p-4 mb-3 rounded">
		<p><span class="btn btn-success rounded-circle" style="padding:0px;width:26px;height:26px"><?=$xx?></span> <?=$sub_title?></p>
		<div class="col-sm-12 px-3 py-2 lh-base">

<?php
		foreach($item_array as $key2=>$value2)  {

		if($key2 > 0) {

		$svalue = mb_substr(trim($value2),1);

		if (substr($value2,0,1) == "c") {
		$cm++;
		$cv = explode("|",${"wr_{$xx}"});
	?>
		<?php if($cm == 1) { ?>
			<input type="hidden" id="wr_val<?=$xx?>" name="wr_<?=$xx?>" value="<?=${"wr_{$xx}"}?>">
		<?php } ?>

			<p class="my-1">
				<input type="checkbox" name="wrd<?= $xx ?>" id="wrd<?= $xx ?>_<?=$key2 ?>" class="form-check-input mx-2" value="<?= $key2 ?>" onclick='getGitacheck(<?=$xx?>)' title="<?= $svalue ?>"<?php if(in_array($key2, $cv)) echo " checked"; ?>><?= $svalue ?>
			</p>
		<?php } elseif (substr($value2,0,1) == "e") {	//기타란

			if(in_array("기타:", $cv)) {
				$eg = 1;
				$ev =  end($cv);
			} else {
				$eg = 0;
				$ev =  "";
			}
			?>
			<p class="my-1">
				<input type="checkbox" name="wrd<?= $xx ?>" id="wrd<?= $xx ?>_<?=$key2 ?>" class="form-check-input mx-2" value="기타:" onclick='toggleGitabox(<?=$xx?>,<?=$key2?>)' title="기타 선택"<?php if($eg==1) echo " checked"; ?>>
				기타	<input type="text" name="mtext_<?=$xx?>" id="mtext_<?=$xx?>" value="<?= $ev ?>"<?php echo ($eg==1) ? "" : " disabled"; ?> class="form-check-input ms-2" title="기타내용" style="width:350px;height:30px;" onchange='getGitacheck(<?=$xx?>)'>
			</p>
		<?php  } elseif (substr($value2,0,1) == "p") {		//별점
			$tt++;
			$cv = str_replace("|","^",${"wr_{$xx}"});
			$cv2 = explode("^",$cv);
			$cv3 = explode("|",${"wr_{$xx}"});

			foreach($cv2 as $k=>$v) {
				if($v == trim(mb_substr($value2,1))) {
					$kk = 1;
					$kv = $cv2[$k+1];
					$dgg = trim(mb_substr($value2,1))."^".$kv;
					break;
				} else {
					$kk = 0;
					$kv = 0;
					$dgg = "";
				}
			}

		?>
			<div>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="checkbox" name="wrb<?= $xx ?>_<?=$tt?>" id="wrb<?= $xx ?>_<?=$tt ?>"  value="<?= trim(mb_substr($value2,1)) ?>" onclick='toggleChecktbox(<?=$xx?>,<?=$tt?>)' title="<?= $svalue ?>"<?php if($kk==1) echo " checked"; ?>>
				  <label class="form-check-label" for="wrb<?= $xx ?>_<?=$tt ?>"><?= $svalue ?></label>
				</div>
			<?php for($t=5; $t>0; $t--) {
				$yy++;
			?>
				<div class="form-check form-check-inline">
				  <input class="form-check-input" type="radio" name="wrd<?= $xx ?>_<?= $tt ?>" id="wrc_<?=$yy?>" value="<?= $t ?>"<?php echo ($kk==1) ? "" : " disabled"; ?> onclick='getCheck(<?=$xx?>,<?=$tt?>)' title="별 <?= $t ?>개"<?php echo ($kk==1 && $t ==$kv) ? " checked" : ""; ?>>
				  <label class="form-check-label lbl<?= $xx ?>_<?= $tt ?>" for="wrc_<?=$yy?>"><?= str_repeat("☆", $t) ?></label>
				</div>
			<?php } ?>
				<input type="hidden" id="wrk<?= $xx ?>_<?=$tt?>" name="wrka<?= $xx ?>[]" value="<?=$dgg?>">
		 </div>
		<?php if($tt == 1) { ?>
			<input type="hidden" id="wr_val<?= $xx ?>" name="wr_<?= $xx ?>" value="<?=${"wr_{$xx}"}?>">
		<?php } ?>

	<?php } elseif (substr($value2,0,1) == "s") {	//단문텍스트  ?>
		<p class="my-1">
			<input type="text" name="wr_<?= $xx ?>" value="<?= ${"wr_{$xx}"} ?>" class="form-control mx-2"<?php if($selok == 1) echo " required";?> title="내용입력">
		</p>
	<?php } elseif (substr($value2,0,1) == "h") {	//휴대폰  ?>
		<p class="my-1">
			<input type="text" name="wr_<?= $xx ?>" id="wr_<?= $xx ?>" value="<?= ${"wr_{$xx}"} ?>" class="form-control tel mx-2"<?php if($selok == 1) echo " required";?>  title="전화번호입력" onchange="check_phone('wr_<?=$xx?>')">
		</p>
	<?php } elseif (substr($value2,0,1) == "t") {	//긴글  ?>
		<p class="my-1">
			<textarea name="wr_<?= $xx ?>" class="form-control" rows="5"<?php if($selok == 1) echo " required";?>><?= ${"wr_{$xx}"} ?></textarea>
		</p>
	<?php } elseif (substr($value2,0,1) == "a") {	//주소
			$cv = explode("|",${"wr_{$xx}"});
	?>
			<div class="input-group mb-2" style="width:200px">
			  <input type="text" class="form-control" id="wr_postcode" value="<?= trim($cv[0]) ?>" placeholder="우편번호" aria-label="우편번호" aria-describedby="button-addon2"<?php if($selok == 1) echo " required";?>>
			  <button class="btn btn-success" type="button" id="button-addon2" onclick="juso_execDaumPostcode()">찾기</button>
			</div>
			<div class="input-group mb-2">
				<input type="text" class="form-control" id="juso1" value="<?= trim($cv[1]) ?>" placeholder="주소"<?php if($selok == 1) echo " required";?>>
				<input type="text" class="form-control" id="juso2" value="<?= trim(str_replace(", ","",$cv[2])) ?>" placeholder="나머지 주소" onfocusout="jusointput()">
			</div>
			<input type="text" class="form-control" id="juso3" value="<?= trim($cv[3]) ?>" placeholder="참고항목">
			<input type="hidden" id="wr_addr" name="wr_<?=$xx?>" value="<?= ${"wr_{$xx}"} ?>">
			<script src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>

	<?php } else {		//신청

		if($selgb == "0") {  ?>
			<p class="my-1">
				<input type="radio" name="wr_<?= $xx ?>" class="form-check-input mx-2" value="<?= $key2 ?>"<?php if($selok == 1) echo " required";?> title="<?= $key2 ?>"<?php if(${"wr_{$xx}"} == $key2) echo " checked"; ?>><?= trim($value2) ?>
			</p>
	   <?php } else {

		    $s_id = $xx;
			$p_snum = explode("|",$selgb);
			$pval = trim($value2);
			$countall = sql_fetch("select count(*) cn from {$write_table} where wr_link2 = '{$k_num}' and wr_{$xx} = '{$pval}'");

			if($xx == $p_snum[0] && $countall["cn"] >= $p_snum[1]) {
				if(${"wr_{$xx}"} == trim($value2)) {
					$dgb = "";
				} else {
					$dgb = " disabled";
				}
				$msg1 = "<span class='text-danger'> **신청마감됨</span>";
				$num1 = "<span class='text-success'> (".$countall["cn"]."/".$p_snum[1].")</span>";
			} elseif($xx == $p_snum[0] && $countall["cn"] < $p_snum[1]) {
				$dgb = "";
				$msg1 = "";
				$num1 = "<span class='text-success'> (".$countall["cn"]."/".$p_snum[1].")</span>";
			}
		?>
		<p class="my-1">
			<input type="radio" name="wr_<?= $xx ?>" class="form-check-input mx-2" value="<?= trim($value2) ?>"<?php if($selok == 1) echo " required";?> title="<?= trim($value2) ?>"<?=$dgb?><?php if(${"wr_{$xx}"} == trim($value2)) echo " checked"; ?>><?= trim($value2) ?><?=$num1?><?=$msg1?>
		</p>
	<?php } } } } ?>
		</div>
	</div>
<?php } } ?>

<?php if ($is_use_captcha) {  ?>
<div class="wr_box_wrap write_div3">
	<span class="wr_t capcha_tit">자동등록방지</span>
	<div class="wr_c">
		<div class="write_div" style="padding:5px">
			<?= $captcha_html ?>
		</div>
	</div>
</div>
<?php } ?>

<div class="text-center fs-5 text-danger my-5">- 참여해 주셔서 감사합니다 -</div>

<div class="container text-center mb-5">
	<input type="hidden" name="tcnum" id="tcnum" value="<?=$tc?>">
	<input type="hidden" name="tcnum2" id="tcnum2" value="<?=$tc2?>">
	<input type="submit" value="제출하기" id="btn_submit" accesskey="s" class="btn btn-primary" style="width:200px;height:60px">
</div>

</form>

<script>

    function fwrite_submit(f)
    {
		var tstr = $("#tcnum").val();
		var arr = tstr.split(",");
		for(var i=1;i<arr.length;i++) {
			if ($("#wr_val" + arr[i]).val() == "") {
				alert(arr[i]+"번 문항을 입력해 주세요.");
				$("#wrd" + arr[i] + "_1").focus();
				return false;
			}
		}

		var tstr2 = $("#tcnum2").val();
		var arr2 = tstr2.split(",");
		for(var i=1;i<arr2.length;i++) {
			if ($("#wr_val" + arr2[i]).val() == "") {
				alert(arr2[i]+"번 문항을 입력해 주세요.");
				$("#wrb" + arr2[i] + "_1").focus();
				return false;
			}
		}

        var svy_gb =f.svy_gb.value;

        if (svy_gb != 0) {

			var p_ok =  "";
			$.ajax({
				url: "<?= $board_skin_url ?>/ajax_confirm.php",
				type: "POST",
				data: {
					p_id: "<?=$k_num?>",
					s_value: f.wr_<?=$s_id?>.value,
					bo_table: "<?=$bo_table?>",
				},
				dataType: "json",
				async: false,
				cache: false,
				success: function(data) {
					p_ok = data.p_ok;
					console.log(data.ok);
				}
			});

			if (p_ok == 1) {
				console.log(p_ok);
				alert("정원초과입니다. 다른 것을 선택해 주세요.");
				f.wr_<?=$s_id?>[0].focus();
				return false;
			}
		}

        <?= $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }

</script>
</div>
<!-- } 게시물 작성/수정 끝 -->