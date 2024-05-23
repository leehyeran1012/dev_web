<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
#add_stylesheet('<link rel="stylesheet" href="'.$member_skin_url.'/style.css">', 0);
?>
<style media="screen">
input[type=text]:focus,input[type=password]:focus, textarea:focus,select:focus {
-webkit-box-shadow:none !important;
-moz-box-shadow:none !important;
box-shadow:none !important;
border:none !important;
border-bottom: 2px #fff solid !important;
}
.mbskin {
  position: absolute;
  background: linear-gradient(#141e30, #243b55);
  top: 50%;
  left: 50%;
  width: 400px;
  padding: 40px;
  color:#fff;
  transform: translate(-50%, -50%);
  box-sizing: border-box;
  box-shadow: 0 15px 25px rgba(0,0,0,.6);
  border-radius: 10px;
}
.mbskin_box h1 {
  margin: 0 0 30px;
  padding: 0;
  color: #fff;
  text-align: center;
  font-size:2rem;
}

.mbskin_box .user-box {
  position: relative;
}

.mbskin_box .user-box input {
  width: 100%;
  padding: 10px 0;
  font-size: 16px;
  color: #fff;
  margin-bottom: 30px;
  border: none;
  border-bottom: 1px solid #fff;
  outline: none;
  background: transparent;
}
.mbskin_box .user-box label {
  position: absolute;
  top:0;
  left: 0;
  padding: 10px 0;
  font-size: 16px;
  color: #fff;
  pointer-events: none;
  transition: .5s;
}

.mbskin_box .user-box input:focus ~ label,
.mbskin_box .user-box input:valid ~ label {
  top: -20px;
  left: 0;
  color: #03e9f4;
  font-size: 12px;
}
.mbskin_box a{
  color: #03e9f4
}
/**/
.mbskin_box .wavebtn {
  width: 100%;
  position: relative;
  display: inline-block;
  padding: 10px 20px;
  background: transparent;
  border: 0;
  color: #03e9f4;
  font-size: 16px;
  text-decoration: none;
  text-transform: uppercase;
  overflow: hidden;
  transition: .5s;
  margin-top: 40px;
  margin-bottom: 20px;
  letter-spacing: 4px

}

.mbskin_box .wavebtn:hover {
  background: #03e9f4;
  color: #fff;
  border-radius: 5px;
  box-shadow: 0 0 5px #03e9f4,
              0 0 25px #03e9f4,
              0 0 50px #03e9f4,
              0 0 100px #03e9f4;
}

.mbskin_box .wavebtn span {
  position: absolute;
  display: block;
}

.mbskin_box .wavebtn span:nth-child(1) {
  top: 0;
  left: -100%;
  width: 100%;
  height: 2px;
  background: linear-gradient(90deg, transparent, #03e9f4);
  animation: btn-anim1 1s linear infinite;
}

@keyframes btn-anim1 {
  0% {
    left: -100%;
  }
  50%,100% {
    left: 100%;
  }
}

.mbskin_box .wavebtn span:nth-child(2) {
  top: -100%;
  right: 0;
  width: 2px;
  height: 100%;
  background: linear-gradient(180deg, transparent, #03e9f4);
  animation: btn-anim2 1s linear infinite;
  animation-delay: .25s
}

@keyframes btn-anim2 {
  0% {
    top: -100%;
  }
  50%,100% {
    top: 100%;
  }
}

.mbskin_box .wavebtn span:nth-child(3) {
  bottom: 0;
  right: -100%;
  width: 100%;
  height: 2px;
  background: linear-gradient(270deg, transparent, #03e9f4);
  animation: btn-anim3 1s linear infinite;
  animation-delay: .5s
}

@keyframes btn-anim3 {
  0% {
    right: -100%;
  }
  50%,100% {
    right: 100%;
  }
}

.mbskin_box .wavebtn span:nth-child(4) {
  bottom: -100%;
  left: 0;
  width: 2px;
  height: 100%;
  background: linear-gradient(360deg, transparent, #03e9f4);
  animation: btn-anim4 1s linear infinite;
  animation-delay: .75s
}

@keyframes btn-anim4 {
  0% {
    bottom: -100%;
  }
  50%,100% {
    bottom: 100%;
  }
}
</style>
<!-- 로그인 시작 { -->
<div id="mb_login" class="mbskin">
    <div class="mbskin_box">
      <h1><?php echo $g5['title'] ?></h1>
      <form name="flogin" action="<?php echo $login_action_url ?>" onsubmit="return flogin_submit(this);" method="post">
        <input type="hidden" name="url" value="<?php echo $login_url ?>">

        <div class="user-box">
                <input type="text" name="mb_id" id="login_id" value="test" required>
                <label for="login_id">아이디</label>
        </div>

        <div class="user-box">
          <input type="password" name="mb_password" id="login_pw" value="1111" required>
          <label for="login_pw">비밀번호</label>
        </div>

        <button type="submit" class="wavebtn"><span></span>
      <span></span>
      <span></span>
      <span></span>로그인</button>
        <p class="text">아직 비회원이시면 <a href="<?php echo G5_BBS_URL ?>/register.php">회원가입</a>을 하세요. </p>
      </form>
      <?php# @include_once(get_social_skin_path().'/social_login.skin.php'); // 소셜로그인 사용시 소셜로그인 버튼 ?>
  </div>
</div>
<script>
jQuery(function($){
    $("#login_auto_login").click(function(){
        if (this.checked) {
            this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
        }
    });
});

function flogin_submit(f)
{
    if( $( document.body ).triggerHandler( 'login_sumit', [f, 'flogin'] ) !== false ){
        return true;
    }
    return false;
}
</script>
<!-- } 로그인 끝 -->
