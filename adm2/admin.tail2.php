<?php
if (!defined('_GNUBOARD_')) exit;
?>

		</div></div>
  </main>
  <script src="<?=G5_ADMIN_URL?>/css/main.js"></script>

<footer id="footer" class="footer d-none d-lg-block">
    <div class="copyright">&copy; Copyright <strong><span>회사명</span></strong> All Rights Reserved</div>
	<div class="totop"><a href="#">▲</a><a href="#footer">▼</a></div>
</footer>

<!-- } 콘텐츠 끝 -->

<?php if ($is_admin == 'super') {  ?><!-- <div style='float:left; text-align:center;'>RUN TIME : <?php echo get_microtime()-$begin_time; ?><br></div> --><?php }  ?>

<?php run_event('tail_sub'); ?>

</body>
</html>
<?php echo html_end(); // HTML 마지막 처리 함수 : 반드시 넣어주시기 바랍니다.