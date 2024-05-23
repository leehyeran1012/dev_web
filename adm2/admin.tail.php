<?php
if (!defined('_GNUBOARD_')) exit;
?>

		</div></div>
  </main>
  <script src="<?=G5_ADMIN_URL?>/css/main.js"></script>


<style>
  #footer {position:relative;}
  #footer .totop {position:fixed; bottom:50%; right:0px; z-index:99999;}
  #footer .totop a {margin:0 0 2px; padding:10px 5px; line-height:10px; font-size:15px; color:white; border:0; border-radius:3px; background:#a8a8a8; display:block; }
  #footer .totop a:hover {text-decoration:none; background:#bf042f}
  @media (max-width: 1199px) {
  .totop {display:none;}
}
</style>

<footer id="footer" class="footer d-none d-lg-block">
    <div class="copyright">&copy; Copyright <strong><span>회사명</span></strong> All Rights Reserved</div>
	<div class="totop"><a href="#">▲</a><a href="#footer">▼</a></div>
</footer>

<!-- } 콘텐츠 끝 -->
<?php
require_once G5_PATH . '/tail.sub.php';