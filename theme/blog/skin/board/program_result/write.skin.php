<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

include_once('apply.confirm.lib.php');


if ($wr_link1) {
	$check1 = explode("|", $wr_link1);
	$check2 = explode("|", $wr_7);

} else {
	$check1 = ["1","2"];
	$check2 = [];

}

$p_id = isset($_GET['g_num']) ? intval($_GET['g_num']) : 0;

if($w == "u") {
	$p_id = $write['wr_link2'];
	$bmsg = "수정하기";
}

$bot_table = str_replace("_result","",$bo_table);
$boa_table = $g5['write_prefix'] . $bot_table;

$que1 = sql_fetch("select wr_subject,wr_content,wr_3,wr_9 from {$boa_table} where wr_id = '{$p_id}'");

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);

//순서--> 0: 오픈, 1: 신청유형, 2: 선택1 내용, 3: 선택2 내용, 4: 선택1 정원,  5: 선택2 정원, 6: 선택 제목
$pcont = select_confirm($bot_table, $p_id);

$ook = isset($_GET["ook"]) ? $_GET["ook"] : 0;
?>

<?php if($ook == 1) { ?>
<script>
	Swal.fire({
	  title: '<span style="color:#ff6600">신청 실패 안내</span>',
	  text: "해당항목은 신청이 완료되었습니다. 다른 것을 선택해 주세요.",
	  icon: 'warning',
	  confirmButtonText: '확인',
	}).then((result) => {
	  if (result.isConfirmed) {
		  location.href = "./write.php?bo_table=<?=$bo_table?>&g_num=<?=$p_id?>";
	  }
	});
</script>
<?php } ?>

<script>
	$(document).on("keyup", ".tel", function() {		//휴대전화 자동 하이픈(-) 입력
		$(this).val($(this).val().replace(/[^0-9]/g, '').replace(/(^02|^0505|^1[0-9]{3}|^0[0-9]{2})([0-9]+)?([0-9]{4})$/,'$1-$2-$3').replace('--', '-'));
	});
</script>
<script src='<?=$board_skin_url?>/reserve.js'></script>

<div class="container-fluid p-0">
	<div class="col-sm-12 col-md-12 shadow p-4 mb-3 rounded mx-auto">
		<div class="col-sm-12 px-md-3 py-2 lh-base px-sm-0">
			<h4 class="text-primary fw-bold"><?= $que1['wr_subject'] ?> 신청</h4><hr>
		</div>
	</div>

	<div class="col-sm-12 col-md-12 shadow p-4 mb-3 rounded mx-auto">
		<p class="fs-5 fw-bold mb-1"><i class="bi bi-patch-check-fill text-danger me-2"></i> 신청안내:</p>
		<div class="col-sm-12 px-md-3 py-2 lh-base px-sm-0">
			<div class="border border-warning text-success rounded p-3 mb-3">
					<?= str_replace("\r\n","<br>",$que1['wr_3']) ?>
			</div>
		</div>
	</div>

	<form name="fwrite" id="fwrite" action="<?= $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off">
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
    <input type="hidden" name="wr_link2" value="<?= $p_id ?>">
    <input type="hidden" name="wr_subject" value="<?= $que1['wr_subject'] ?>">
    <input type="hidden" name="wr_gb" value="<?= $pcont[1] ?>">

	<div class="col-sm-12 col-md-12 shadow p-4 mb-3 rounded mx-auto">
		<p class="fs-5 fw-bold mb-1"><i class="bi bi-patch-check-fill me-2"></i> 개인 정보 이용 동의 <span class="text-danger">*</span></p>
		<div class="col-sm-12 px-md-3 py-2 lh-base px-sm-0">
			<textarea name="textarea" rows="3" class="form-control bg-light mb-2" disabled>개인 정보 이용 동의
			개인정보보호
			</textarea>
			<div class="mb-2">
				 <input class="form-check-input" type="checkbox" name="check1[]" value="1"<?= in_array("1", $check1) ? ' checked="checked"' : '' ?>> (필수) 개인정보 수집 및 이용에 동의합니다.<br>
				<input class="form-check-input" type="checkbox" name="check1[]" value="2"<?= in_array("2", $check1) ? ' checked="checked"' : '' ?>> (필수) 대상자가 아닌 경우 관리자에 의해 등록취소가 될 수 있습니다.
			</div>
		</div>
	</div>

<!-- 프로그램 신청 -->
	<?php include $board_skin_path."/program_list.php"; ?>
	<?php include $board_skin_path."/program_input.php"; ?>


	<div class="d-flex justify-content-center my-5">
		<input type="hidden" name="tcnum" id="tcnum" value="<?=$tc?>">
		<div class="btn-group">
			<input type="submit" value="신청하기" id="btn_submit" accesskey="s" class="btn btn-primary px-5 py-3">
			<a href="<?= get_pretty_url($bo_table); ?>" class="btn btn-secondary px-5 py-3">취소</a>
		</div>
	</div>

	</form>

</div>

	<div class="col-sm-12 col-md-12 shadow p-4 mb-5 rounded mx-auto">
		<p class="fs-5 fw-bold mb-4 text-success border-bottom border-opacity-50 pb-1">♣ 프로그램 안내</p>
		<div class="col-sm-12 px-md-3 py-2 lh-base px-sm-0">
			<?= $que1["wr_content"] ?>
		</div>
	</div>

<script>

    function fwrite_submit(f)
    {

		var wr_gb = f.wr_gb.value;
		var wr_1 = f.wr_1.value;
		var wr_2 = f.wr_2.value;

		if(wr_gb == 4) {
			if(wr_1 == "" && wr_2 == "" ) {
				alert("선택1,2중에 한개는 선택해 주세요.");
				$("#wr_1").focus();
				return false;
			}
		}

		var tstr = $("#tcnum").val();
		var arr = tstr.split(",");
		for(var i=1;i<arr.length;i++) {
			if ($("#wr_val" + arr[i]).val() == "") {
				alert(arr[i]+"번 문항을 입력해 주세요.");
				$("#wrd" + arr[i] + "_1").focus();
				return false;
			}
		}

         <?php echo $captcha_js;  ?>

        document.getElementById("btn_submit").disabled = "disabled";

        return true;
    }

	function optionChange(id) {

		var wid = $("#wr_1").val();
		$.ajax({
			url: '<?=$board_skin_url?>/ajax_data.php',
			type: 'POST',
			data: {
				"p_id": id,
				"w_id": wid,
				"bo_table": '<?=$bo_table?>',
			},
			async : false,
			dataType : 'html',
			success: function(data){
				$('#wr_2').html(data);
			},
		});
	}


    $('#pw').on('click',function(){
        $('#wr_password').toggleClass('active');
        if($('#wr_password').hasClass('active')){
            $(this).html('<i class="bi bi-eye-slash-fill fs-5"></i>')
			.next('#wr_password').attr('type',"text");
        }else{
            $(this).html('<i class="bi bi-eye-fill fs-5"></i>')
			.next('#wr_password').attr('type','password');
        }
    });

    </script>

<!-- } 게시물 작성/수정 끝 -->