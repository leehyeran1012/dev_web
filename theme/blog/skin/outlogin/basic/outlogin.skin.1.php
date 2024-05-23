<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
//add_stylesheet('<link rel="stylesheet" href="'.$outlogin_skin_url.'/style.css">', 0);
?>

<div class="container">
    	<h2 class="fs-5 fw-bold text-center mb-2"><span class="sound_only">회원</span>로그인</h2><span class="small ps-3"> 일반테스트아이디: test2, test3</span>
    <form name="foutlogin" action="<?php echo $outlogin_action_url ?>" onsubmit="return fhead_submit(this);" method="post" autocomplete="off">
		<div class="mb-2">
		  <input type="text" id="ol_id" name="mb_id" value="test"  class="form-control" placeholder="아이디">
		</div>
		<div class="mb-1">
		  <input class="form-control" type="password" name="mb_password" id="ol_pw" value="1111" placeholder="비밀번호">
		</div>
		<div>
		  <input type="submit" id="ol_submit" value="로그인" class="btn btn-primary w-100 my-3">
		</div>
	<?php
        // 소셜로그인 사용시 소셜로그인 버튼
        @include_once(get_social_skin_path().'/social_login.skin.php');
    ?>
	</form>
	<div>
		<div class="container p-0">
			<div class="row">
				<div class="col-12 small">
					<div class="form-check form-check-inline">
					  <input class="form-check-input" type="checkbox"  name="auto_login" value="1" id="auto_login">
					  <label class="form-check-label" for="auto_login">자동로그인</label>
					</div>
				</div>
				<div class="col-12 text-end small">
					<a href="<?php echo G5_BBS_URL ?>/register.php" class="link me-2">회원가입</a>
					<a href="<?php echo G5_BBS_URL ?>/password_lost.php" class="link">비번찾기</a>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
jQuery(function($) {

    var $omi = $('#ol_id'),
        $omp = $('#ol_pw'),
        $omi_label = $('#ol_idlabel'),
        $omp_label = $('#ol_pwlabel');

    $omi_label.addClass('ol_idlabel');
    $omp_label.addClass('ol_pwlabel');

    $("#auto_login").click(function(){
        if ($(this).is(":checked")) {
            if(!confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?"))
                return false;
        }
    });
});

function fhead_submit(f)
{
    if( $( document.body ).triggerHandler( 'outlogin1', [f, 'foutlogin'] ) !== false ){
        return true;
    }
    return false;
}
</script>
<!-- } 로그인 전 아웃로그인 끝 -->
