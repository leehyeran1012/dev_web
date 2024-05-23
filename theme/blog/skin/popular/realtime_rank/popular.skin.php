<?php
if (!defined("_GNUBOARD_")) exit; // 개별페이지 접근 불가

add_stylesheet('<link rel="stylesheet" href="'.$popular_skin_url.'/style.css">', 0);
?>
<style>
	article, div, span, em, ol, li, a{
		margin:0;
		padding:0;
		border:0;
		vertical-align:baseline;
		background:transparent;
		font-style:normal
	}
</style>
<article>
	<div class="content_box rank_box popular_rank" id="popular_rank1">
		<div class="box_tit">
			<h3 class="tit">&nbsp;</h3>
			<span class="box_menu">
				<a href="javascript:void(0);" class="popular_rank1 rank1RankTab on">10일</a>
				<a href="javascript:void(0);" class="popular_rank2 rank2RankTab ">20일</a>
				<a href="javascript:void(0);" class="popular_rank3 rank3RankTab ">30일</a>
			</span>
		</div>
		<ol class="rank_list rank1 pr_1">
			<?php

			$pop_cnt  = 50;	// 검색어 몇개
			$date_cnt = 10;	//몇일 동안
			$date_gap = date("Y-m-d", G5_SERVER_TIME - ($date_cnt * 86400));
			$sql = " select pp_word, count(*) as cnt from {$g5['popular_table']} where pp_date between '$date_gap' and '".G5_TIME_YMD."' group by pp_word order by cnt desc, pp_word limit 0, $pop_cnt ";
			$result = sql_query($sql);
			for ($i=0; $row=sql_fetch_array($result); $i++) {
				$list[$i] = $row;
			}

			$date_gap_old = date("Y-m-d", strtotime($date_gap) - ($date_cnt * 86400));
			$old = array();
			$sql2 = " select pp_word, count(*) as cnt from {$g5['popular_table']} where pp_date between '{$date_gap_old}' and '{$date_gap}' group by pp_word order by cnt desc, pp_word limit 0, 100 ";
			$qry2 = sql_query($sql2);
			$count = sql_num_rows($qry2);
			for ($j=0; $row2=sql_fetch_array($qry2); $j++) {
				$old[$j] = $row2;
			}

			$sero_rows = 10;
			$rank1_num = 1;
			for ($i=0; $i<$pop_cnt; $i++) {

				for ($j=0; $j<$count; $j++) {
					if ($old[$j]['pp_word'] == $list[$i]['pp_word']) {
						break;
					}
				}

				if (!is_array($list[$i])) continue;

				if($sero_rows) {
					if($i > 0 && $i%$sero_rows == 0) {
						$rank1_num++;
						echo '</ol>'.PHP_EOL;
						echo '<ol class="rank_list rank1 g_'.$rank1_num.'" style="display:none">'.PHP_EOL;
					}
				}

				$list[$i]['pp_word'] = urldecode($list[$i]['pp_word']);
				$list[$i]['pp_rank'] = $i + 1;
				if ($count == $j) {
					$list[$i]['old_pp_rank'] = 0;
					$list[$i]['rank_gap'] = 0;
				} else {
					$list[$i]['old_pp_rank'] = $j + 1;
					$list[$i]['rank_gap'] = $list[$i]['old_pp_rank'] - $list[$i]['pp_rank'];
				}

				if ($list[$i]['rank_gap'] > 0)
					$list[$i]['ico_ranking'] = "up";
				else if ($list[$i]['rank_gap'] < 0)
					$list[$i]['ico_ranking'] = "down";
				else if ($list[$i]['old_pp_rank'] == 0)
					$list[$i]['ico_ranking'] = "new";
				else if ($list[$i]['rank_gap'] == 0)
					$list[$i]['ico_ranking'] = "nogap";
			?>
			<li>
				<a href="<?php echo G5_BBS_URL?>/search.php?sfl=wr_subject&sop=and&stx=<?php echo urlencode($list[$i]['pp_word'])?>" class="busygall text-dark-emphasis" section_code="main_count">
				<span class="rank_num"><em><?php echo $i+1;?></em></span>
				<span class="rank_txt"><?php echo $list[$i]['pp_word']?></span>
				<span class="rank_state"><?php if ($list[$i]['ico_ranking'] != "new" && $list[$i]['ico_ranking'] != "nogap") { echo abs($list[$i]['rank_gap']); }?></span>
				<span class="sp_img ico_ranking <?php echo $list[$i]['ico_ranking'];?>"></span>
				</a>
			</li>
			<?php } ?>
		</ol>
		<ol class="rank_list rank2 pr_2" style="display:none">
			<?php

			$pop_cnt  = 50;	// 검색어 몇개
			$date_cnt = 20;		//몇일 동안
			$date_gap = date("Y-m-d", G5_SERVER_TIME - ($date_cnt * 86400));
			$sql = " select pp_word, count(*) as cnt from {$g5['popular_table']} where pp_date between '$date_gap' and '".G5_TIME_YMD."' group by pp_word order by cnt desc, pp_word limit 0, $pop_cnt ";
			$result = sql_query($sql);
			for ($i=0; $row=sql_fetch_array($result); $i++) {
				$list[$i] = $row;
			}

			$date_gap_old = date("Y-m-d", strtotime($date_gap) - ($date_cnt * 86400));
			$old = array();
			$sql2 = " select pp_word, count(*) as cnt from {$g5['popular_table']} where pp_date between '{$date_gap_old}' and '{$date_gap}' group by pp_word order by cnt desc, pp_word limit 0, 100 ";
			$qry2 = sql_query($sql2);
			$count = sql_num_rows($qry2);
			for ($j=0; $row2=sql_fetch_array($qry2); $j++) {
				$old[$j] = $row2;
			}

			$sero_rows = 10;
			$rank2_num = 1;
			for ($i=0; $i<$pop_cnt; $i++) {

				for ($j=0; $j<$count; $j++) {
					if ($old[$j]['pp_word'] == $list[$i]['pp_word']) {
						break;
					}
				}

				if (!is_array($list[$i])) continue;

				if($sero_rows) {
					if($i > 0 && $i%$sero_rows == 0) {
						$rank2_num++;
						echo '</ol>'.PHP_EOL;
						echo '<ol class="rank_list rank2 m_'.$rank2_num.'" style="display:none">'.PHP_EOL;
					}
				}

				$list[$i]['pp_word'] = urldecode($list[$i]['pp_word']);
				$list[$i]['pp_rank'] = $i + 1;
				if ($count == $j) {
					$list[$i]['old_pp_rank'] = 0;
					$list[$i]['rank_gap'] = 0;
				} else {
					$list[$i]['old_pp_rank'] = $j + 1;
					$list[$i]['rank_gap'] = $list[$i]['old_pp_rank'] - $list[$i]['pp_rank'];
				}

				if ($list[$i]['rank_gap'] > 0)
					$list[$i]['ico_ranking'] = "up";
				else if ($list[$i]['rank_gap'] < 0)
					$list[$i]['ico_ranking'] = "down";
				else if ($list[$i]['old_pp_rank'] == 0)
					$list[$i]['ico_ranking'] = "new";
				else if ($list[$i]['rank_gap'] == 0)
					$list[$i]['ico_ranking'] = "nogap";
			?>
			<li>
				<a href="<?php echo G5_BBS_URL?>/search.php?sfl=wr_subject&sop=and&stx=<?php echo urlencode($list[$i]['pp_word'])?>" class="busygall" section_code="main_count">
				<span class="rank_num"><em><?php echo $i+1;?></em></span>
				<span class="rank_txt"><?php echo $list[$i]['pp_word']?></span>
				<span class="rank_state"><?php if ($list[$i]['ico_ranking'] != "new" && $list[$i]['ico_ranking'] != "nogap") { echo abs($list[$i]['rank_gap']); }?></span>
				<span class="sp_img ico_ranking <?php echo $list[$i]['ico_ranking'];?>"></span>
				</a>
			</li>
			<?php } ?>
		</ol>
		<ol class="rank_list rank3 pr_3" style="display:none">
			<?php

			$pop_cnt  = 50;	// 검색어 몇개
			$date_cnt = 30;		//몇일 동안
			$date_gap = date("Y-m-d", G5_SERVER_TIME - ($date_cnt * 86400));
			$sql = " select pp_word, count(*) as cnt from {$g5['popular_table']} where pp_date between '$date_gap' and '".G5_TIME_YMD."' group by pp_word order by cnt desc, pp_word limit 0, $pop_cnt ";
			$result = sql_query($sql);
			for ($i=0; $row=sql_fetch_array($result); $i++) {
				$list[$i] = $row;
			}

			$date_gap_old = date("Y-m-d", strtotime($date_gap) - ($date_cnt * 86400));
			$old = array();
			$sql2 = " select pp_word, count(*) as cnt from {$g5['popular_table']} where pp_date between '{$date_gap_old}' and '{$date_gap}' group by pp_word order by cnt desc, pp_word limit 0, 100 ";
			$qry2 = sql_query($sql2);
			$count = sql_num_rows($qry2);
			for ($j=0; $row2=sql_fetch_array($qry2); $j++) {
				$old[$j] = $row2;
			}

			$sero_rows = 10;
			$rank3_num = 1;
			for ($i=0; $i<$pop_cnt; $i++) {

				for ($j=0; $j<$count; $j++) {
					if ($old[$j]['pp_word'] == $list[$i]['pp_word']) {
						break;
					}
				}

				if (!is_array($list[$i])) continue;

				if($sero_rows) {
					if($i > 0 && $i%$sero_rows == 0) {
						$rank3_num++;
						echo '</ol>'.PHP_EOL;
						echo '<ol class="rank_list rank3 mi_'.$rank3_num.'" style="display:none">'.PHP_EOL;
					}
				}

				$list[$i]['pp_word'] = urldecode($list[$i]['pp_word']);
				$list[$i]['pp_rank'] = $i + 1;
				if ($count == $j) {
					$list[$i]['old_pp_rank'] = 0;
					$list[$i]['rank_gap'] = 0;
				} else {
					$list[$i]['old_pp_rank'] = $j + 1;
					$list[$i]['rank_gap'] = $list[$i]['old_pp_rank'] - $list[$i]['pp_rank'];
				}

				if ($list[$i]['rank_gap'] > 0)
					$list[$i]['ico_ranking'] = "up";
				else if ($list[$i]['rank_gap'] < 0)
					$list[$i]['ico_ranking'] = "down";
				else if ($list[$i]['old_pp_rank'] == 0)
					$list[$i]['ico_ranking'] = "new";
				else if ($list[$i]['rank_gap'] == 0)
					$list[$i]['ico_ranking'] = "nogap";
			?>
			<li>
				<a href="<?php echo G5_BBS_URL?>/search.php?sfl=wr_subject&sop=and&stx=<?php echo urlencode($list[$i]['pp_word'])?>" class="busygall" section_code="main_count">
				<span class="rank_num"><em><?php echo $i+1;?></em></span>
				<span class="rank_txt"><?php echo $list[$i]['pp_word']?></span>
				<span class="rank_state"><?php if ($list[$i]['ico_ranking'] != "new" && $list[$i]['ico_ranking'] != "nogap") { echo abs($list[$i]['rank_gap']); }?></span>
				<span class="sp_img ico_ranking <?php echo $list[$i]['ico_ranking'];?>"></span>
				</a>
			</li>
			<?php } ?>
		</ol>
		<div class="box_bottom rank_more" popular_type="g" page="1" style="width:100%;">11위 - 20위</div>
	</div>
</article>

<script>

function number_format(data) {

    var tmp = '';
    var number = '';
    var cutlen = 3;
    var comma = ',';
    var i;

    len = data.length;
    mod = (len % cutlen);
    k = cutlen - mod;
    for (i=0; i<data.length; i++)
    {
        number = number + data.charAt(i);

        if (i < data.length - 1)
        {
            k++;
            if ((k % cutlen) == 0)
            {
                number = number + comma;
                k = 0;
            }
        }
    }

    return number;
}

$(function(){

	$('.rank1RankTab').click(function(){
		$(this).siblings().removeClass('on');
		$(this).addClass('on');
		$('.popular_rank .rank_list').hide();
		$('.popular_rank .pr_1').show();
		$('.rank_more').attr('popular_type', 'g');
		$('.rank_more').attr('page','1');
		$('.rank_more').text('11위 - 20위');

	});

	$('.rank2RankTab').click(function(){
		if($('.rank_list.rank2').index() < 0) {
			return false;
		}

		$(this).siblings().removeClass('on');
		$(this).addClass('on');
		$('.popular_rank .rank_list').hide();
		$('.popular_rank .pr_2').show();
		$('.rank_more').attr('popular_type', 'm');
		$('.rank_more').attr('page','1');
		$('.rank_more').text('11위 - 20위');
	});

	$('.rank3RankTab').click(function(){
		$(this).siblings().removeClass('on');
		$(this).addClass('on');
		$('.popular_rank .rank_list').hide();
		$('.popular_rank .pr_3').show();
		$('.rank_more').attr('popular_type', 'mi');
		$('.rank_more').attr('page','1');
		$('.rank_more').text('11위 - 20위');
	});

	$('.rank_more').click(function(){
		var type = $(this).attr('popular_type');
		var page = number_format($(this).attr('page'));

		if(page > 4) page = 1;
		else page++;

		$('.popular_rank .rank_list').hide();
		$('.popular_rank .'+type+'_'+page).show();

		if(page == 1) $('.rank_more').text('11위 - 20위');
		else if(page == 2) $('.rank_more').text('21위 - 30위');
		else if(page == 3) $('.rank_more').text('31위 - 40위');
		else if(page == 4) $('.rank_more').text('41위 - 50위');
		else $('.rank_more').text('1위 - 10위')

		$('.rank_more').attr('page',page)

	});

});
</script>
