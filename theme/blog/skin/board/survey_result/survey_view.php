<?php
include "./_common.php";
?>
<!doctype html>
<html lang="ko">
<head>
<title>설문조사결과</title>
<meta  charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="language" content="ko">
<meta name="viewport" content="initial-scale=1.0, width=device-width">
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php

$k_num = isset($_GET["k_num"]) ? intval($_GET["k_num"]) : 0;

$sname = "A".date("YmdHis",time()).rand(1000,9999);
$boa_table = str_replace("_result","",$bo_table);
$boa_table = $g5['write_prefix'] . $boa_table;

$que1 = sql_fetch("select wr_subject, wr_content, wr_1 from {$boa_table} where wr_id = '{$k_num}'");
$pcontent = $que1['wr_content'];

$svcontents = str_replace("\r\n","",$que1['wr_1']);
$svcontents = explode("Q#",$svcontents);

?>
<script>
	window.history.forward();
</script>
<script>
	 function check_submit(){
		var tcstr = document.getElementById('tcnum').value;
		if(tcstr == "0") {
			return true;
		} else {
			var arr = tcstr.split(",");
			for(var i=1;i<arr.length;i++){
				var fid = "wrk_" + arr[i];
				var fkid = "pa" + arr[i] + "_1";
				if (document.getElementById(fid).value == "") {
					alert(arr[i]+"번 문항을 입력해 주세요.");
					document.getElementById(fkid).focus();
					return false;
				}
			}
			return true;
		}
	 }
</script>
<div class="container mt-5 fs-5">
    <h2 class="sound_only"><?= $g5['title'] ?></h2>

    <!-- 게시물 작성/수정 시작 { -->
    <form name="fwrite" id="fwrite" action="http://localhost/zinzingnb/bbs/write_update.php" onsubmit="return fwrite_submit(this);" method="post" autocomplete="off" style="width:<?= $width; ?>">
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

<style>
	.qr{padding:5px; border: 10px solid #ff9900;}
</style>
	<div class="row">
		<div class="col-md-8 col-sm-12 mb-5">
			<h1><?= $que1['wr_subject'] ?></h1><br>
			<p><?= $pcontent ?></p>
			<p style="color:red"><br>※ 선택항목을 제외한 모든 문항을 입력하셔야 저장됩니다.</p>
		</div>
		<div class="col-md-4 col-sm-12 mb-5 qrcode">
			<img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode(G5_BBS_URL.'/write.php?bo_table='.$bo_table.'&k_num='.$k_num.'&size=250x250') ?>" class="qr">
		</div>
	</div>


<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.qrcode/1.0/jquery.qrcode.min.js"></script>
<div style="border: 8px solid green;padding:10px; width:236px">
<div class="qr_area"></div>
</div>
<script>
    $(function() {
        $('.qr_area').qrcode({   //qrcode 시작
            render : "canvas",      //table, canvas 형식 두 종류가 있다.
            width : 200,            //넓이 조절
            height : 200,           //높이 조절
            text   : "<?= urlencode(G5_BBS_URL.'/write.php?bo_table='.$bo_table.'&k_num='.$k_num) ?>"
        });
    });
</script> -->

<?php
$xx = $tc = 0;
	foreach($svcontents as $key=>$value) {

		$item_array = explode("^",$value);
		if (strpos($item_array[0], "[[") !== false ) {
			$sub_titlek = explode("[[",$item_array[0]);
			$sub_titleh = $sub_titlek[0];
			$sub_title = str_replace("//","<br><br>",$sub_titlek[1]);
		} else {
			$sub_title = str_replace("//","<br><br>",$item_array[0]);
		}

		if (mb_strpos($sub_title, "선택") !== false ) {
			$selok = 0;
			$sub_title = str_replace("(선택)","<span class='text-danger'> (선택)</span>",$sub_title);
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

		if (substr($value2,0,1) == "c") { ?>
			<p class="my-1"><input type="checkbox" name="wrd_<?= $xx ?>" id="pa<?= $xx ?>_<?=$key2 ?>" class="form-check-input mx-2" value="<?= $key2 ?>" onclick='getCheck<?=$xx?>(<?=$xx?>)'><?= mb_substr(trim($value2),1) ?></p>
		<?php } elseif (substr($value2,0,1) == "e") {	?>
			<p class="my-1"><input type="checkbox" name="wrd_<?=$xx?>" id="pa<?= $xx ?>_<?=$key2 ?>" class="form-check-input mx-2" value="기타:" onclick='toggleTextbox<?=$xx?>(this)'> 기타 <input type="text" name="mtext_<?=$xx?>" id="mtext_<?=$xx?>" value="" disabled class="form-check-input ms-2" title="내용을 입력해 주세요." style="width:350px;height:30px;" onchange='getCheck<?=$xx?>(<?=$xx?>)'></p>
			<input type="hidden" id="wrk_<?=$xx?>" name="wr_<?=$xx?>" value="">
			<script>
			  function getCheck<?=$key?>(id)  {
				var checkBoxArr = [];
				var result = "";
				var wrk = "wrk_"+id;
				var mtext = "mtext_"+id;
				$("input[name=wrd_"+id+"]:checked").each(function(i){
					checkBoxArr.push($(this).val());
				});

				result = checkBoxArr.join("|");
				if(result.indexOf('타') > 0) {
				result = result + " " + document.getElementById(mtext).value;
				}
				document.getElementById(wrk).value = result;
			 }

			 function toggleTextbox<?=$xx?>(checkbox) {
				  const textbox_elem = document.getElementById('mtext_<?=$xx?>');
				  textbox_elem.disabled = checkbox.checked ? false : true;
				  if(textbox_elem.disabled) {
					textbox_elem.value = null;
				  }else {
					textbox_elem.focus();
				  }
				}
			</script>
	<?php  } elseif (substr($value2,0,1) == "t") {  ?>
		<p class="my-1"><textarea name="wr_<?= $xx ?>" class="form-control" rows="5"<?php if($selok == 1) echo " required";?>><?= trim(str_replace("t","",$value2)) ?></textarea></p>
	<?php  } elseif (substr($value2,0,1) == "s") {  ?>
		<p class="my-1"><input type="text" name="wr_<?= $xx ?>" value="" class="form-control mx-2"<?php if($selok == 1) echo " required";?>></p>
	<?php  } else { ?>
		<p class="my-1"><input type="radio" name="wr_<?= $xx ?>" class="form-check-input mx-2" value="<?= $key2 ?>"<?php if($selok == 1) echo " required";?>><?= trim($value2) ?></p>
<?php } } } ?>
		</div>
	</div>
<?php  } } ?>


<?php if ($is_use_captcha) { //자동등록방지  ?>
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
	<input type="submit" value="제출하기" id="btn_submit" accesskey="s" class="btn btn-primary" style="width:200px;height:60px">
</div>

</form>

<script>
    <?php if($write_min || $write_max) { ?>
    // 글자수 제한
    var char_min = parseInt(<?= $write_min; ?>); // 최소
    var char_max = parseInt(<?= $write_max; ?>); // 최대
    check_byte("wr_content", "char_count");

    $(function() {
        $("#wr_content").on("keyup", function() {
            check_byte("wr_content", "char_count");
        });
    });

    <?php } ?>
    function html_auto_br(obj)
    {
        if (obj.checked) {
            result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
            if (result)
                obj.value = "html2";
            else
                obj.value = "html1";
        }
        else
            obj.value = "";
    }

    function fwrite_submit(f)
    {
		var tstr = document.getElementById('tcnum').value;
		var arr = tstr.split(",");
		for(var i=1;i<arr.length;i++) {
			var fid = "wrk_" + arr[i];
			var fkid = "pa" + arr[i] + "_1";
			if (document.getElementById(fid).value == "") {
				alert(arr[i]+"번 문항을 입력해 주세요.");
				document.getElementById(fkid).focus();
				return false;
			}
		}

		<?= $editor_js; ?>

        var subject = "";
        var content = "";
        $.ajax({
            url: g5_bbs_url+"/ajax.filter.php",
            type: "POST",
            data: {
                "subject": f.wr_subject.value,
                "content": f.wr_content.value
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function(data, textStatus) {
                subject = data.subject;
                content = data.content;
            }
        });

        if (subject) {
            alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
            f.wr_subject.focus();
            return false;
        }

        if (content) {
            alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
            if (typeof(ed_wr_content) != "undefined")
                ed_wr_content.returnFalse();
            else
                f.wr_content.focus();
            return false;
        }

        if (document.getElementById("char_count")) {
            if (char_min > 0 || char_max > 0) {
                var cnt = parseInt(check_byte("wr_content", "char_count"));
                if (char_min > 0 && char_min > cnt) {
                    alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
                    return false;
                }
                else if (char_max > 0 && char_max < cnt) {
                    alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
                    return false;
                }
            }
        }


        <?= $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }


</script>
</div>
<!-- } 게시물 작성/수정 끝 -->

</body>
</html>