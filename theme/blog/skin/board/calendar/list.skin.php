<?php
if(!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

include_once("holiday.php");
$holiday = new Holiday();

$to_day = date("Y-m-d");
$wname = $holiday->getWeekname($to_day);
$cur_date = isset($_POST["cur_date"]) ? $_POST["cur_date"] : $to_day;
$bgcolors = ["#ff6633","#9900ff","#ffa94d","#0099ff","#cc6699","#00ccff","#99ff00","#006699","#330000","#ffffff"];

?>
<link rel="stylesheet" href="<?= $board_skin_url ?>/dist/jquery-ui.min.css">
<script src="<?= $board_skin_url ?>/dist/jquery-ui.min.js"></script>
<script src="<?= $board_skin_url ?>/dist/index.global.min.js"></script>
<script src="<?= $board_skin_url ?>/dist/datepicker.js"></script>
<script src="<?= $board_skin_url ?>/dist/popper.min.js"></script>
<script src="<?= $board_skin_url ?>/dist/tippy-bundle.umd.min.js"></script>

<style type="text/css">
/*	table{background:#ffffff!important}	*/
	a {color:#717171;}
	thead {height:45px;background:#eaeaea!important}
	.fc-day-sun a {color: red; text-decoration: none;	}
	.fc-day-sat a {color: blue; text-decoration: none;}
/* .fc-day-mon a {color: #ff6699; text-decoration: none; } */
	.fc-holiday, .holiday-text {color: #e74c3c;}
	.fc-daygrid-day-frame:hover{background:#ffffcc}
	.modal-open .ui-datepicker{z-index: 2000!important}

/* 반응형 추가 */
	@media(max-width: 767px) {
	.fc .fc-toolbar {display: flex;flex-direction: column; justify-content: center; align-items: center;}
	}
</style>

<form name="newloadForm" id="newloadForm" method="post" action="./board.php?bo_table=<?=$bo_table?>">
     <input type="hidden" name="cur_date" id="cur_date" value="">
</form>

<div class="container-fluid mb-5">
	<h4 class="mb-5 border-bottom pb-2 fw-bold"><i class="bi bi-flower2 text-warning"></i> 행사일정표</h4>
	<div class="container-fluid mb-5">
	  <div class="row">
		<div class=" bg-info pt-2 text-center" style="width:155px">
			<h5 class="fw-bold text-danger"><?=date("n. j")?>(<?=$wname?>)</h5>
			<h5 class="fw-bold">오늘의 일정</h5>
		</div>
		<div class="col ps-4 py-2 bg-light">
		<?php include_once("ajax_today.php"); ?>
		</div>
	  </div>
	</div>
<div id='calendar'></div>
</div>

<!-- Modal  관리자만 사용시 아래 주석 제거-->
<?php // if($admin_href) { ?>
<div class="modal fade" id="eventModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true" data-bs-focus="false">
  <div class="modal-dialog modal-lg" style="max-width:580px">
    <div class="modal-content">
	<form action="#" name="eventform" id="eventform">
		<input type="hidden" name="bo_table" value="<?=$bo_table?>">
		<input type="hidden" name="id" id="eventId">
		<input type="hidden" name="wr_name" id="wr_name" value="관리자">
		<input type="hidden" name="allDay" id="allDay" value="true">
      <div class="modal-header bg-light py-2">
        <h5 class="modal-title" id="eventModalLabel"><i class="fa fa-calendar-plus-o" aria-hidden="true"></i> 일정등록</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-2">
		<div class="container">
			<div class="row">
				<div class="col-12 mb-2">
					 <div class="input-group">
						 <span class="input-group-text" style="width:68px">제 목</span>
						 <input type="text" class="form-control" name="wr_subject" id="wr_subject" required>
					</div>
				</div>
				<div class="col-12 mb-2">
					 <div class="input-group">
						 <span class="input-group-text" style="width:68px">내 용</span>
						<textarea class="form-control" name="wr_content" id="wr_content" rows="5" required></textarea>
					</div>
				</div>
				<div class="col-12 mb-2">
					 <div class="input-group">
						 <span class="input-group-text">시작일</span>
						<input type="text" class="form-control datepicker" id="wr_1" name="wr_1" required>

						 <span class="input-group-text">종료일</span>
						<input type="text" class="form-control datepicker" id="wr_2" name="wr_2" required>
					</div>
				</div>
				<div class="col-12 mb-2">
					 <div class="input-group">
						 <span class="input-group-text">배경색</span>
						 <?php foreach($bgcolors as $value) { ?>
						<div class="input-group-text" style="background:<?=$value?>"><input class="form-check-input fs-5" name="wr_3" type="radio" value="<?=$value?>"></div>
						<?php } ?>
					</div>
				</div>
				<div class="col-12 mb-2">
					 <div class="input-group">
						 <span class="input-group-text">글자색</span>
						 <?php foreach($bgcolors as $value) { ?>
						<div class="input-group-text" style="background:<?=$value?>"><input class="form-check-input fs-5" name="wr_4" type="radio" value="<?=$value?>"></div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	  </div>
      <div class="modal-footer bg-light py-1" id="eventBtn">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
		<button type="button" class="btn btn-primary" id="btnSave" onclick="save()">등록</button>
	  </div>
	</form>
    </div>
  </div>
</div>
<?php // } ?>

<div class="modal fade" id="monthModal" aria-hidden="true" aria-labelledby="monthModalLabel" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h1 class="modal-title fs-5" id="monthModalLabel">일정표</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="monthModalBody">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">닫기</button>
      </div>
    </div>
  </div>
</div>

<script>

	var save_method;
	var site_url ="<?= $board_skin_url ?>";

	document.addEventListener('DOMContentLoaded', function() {
		var calendarEl = document.getElementById('calendar');
		var calendar = new FullCalendar.Calendar(calendarEl, {

		customButtons: {
			mymonthButton: {
				text: '일정',
				click: function() {
				view_form('<?=$to_day?>');
			}
		},
			mymonthsButton: {
				text: '월',
				click: function() {
					var datex = $(".fc-daygrid-day-number");
					var dates = [];
					document.querySelectorAll("[data-date]").forEach(function(element) {
						dates.push(element.dataset.date);
					});
					cal_reload(dates[10]);
			//		location.href = "./board.php?bo_table=<?=$bo_table?>&cur_date="+dates[10];
				}
			}
		},
		headerToolbar: {
			left: 'prev,next,today',
			center: 'title',
			right: 'mymonthButton,mymonthsButton,timeGridWeek,timeGridDay,listWeek'
		},

		views: {
			timeGrid: {
				titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
			}
		},

		buttonText:{year:"년도",month:"월",week:"주",day:"일",today:"오늘",listWeek:"주별"},

		locale: 'ko',
		dayCellContent: function(arg){
			return arg.date.getDate();
		},

		initialDate: '<?=$cur_date?>',
		navLinks: true,
		selectable: true,
		selectMirror: true,
		eventOrder:"order,start,-duration",	//정렬순서 -는 desc
		editable: true,
		dayMaxEvents: false, // allow "more" link when too many events
		height: "auto",

		eventDidMount: function(info) {
            tippy(info.el, {
                content:  info.event.extendedProps.description,	//이벤트 디스크립션을 툴팁으로 가져옵니다.
				allowHTML: true,
            });
        },

		events: function(info, successCallback, failureCallback) {
			$.ajax({
				url:  site_url+'/ajax_data.php',
				type: 'post',
				data: {
					tdate: info.startStr,
					bo_table: '<?=$bo_table?>',
				},
				dataType: 'json',
				success: function (json) {
			//			console.log(json);
					successCallback( json );

					var dates = [];
					var datex = $(".fc-daygrid-day-number");
					document.querySelectorAll("[data-date]").forEach(function(element) {
						dates.push(element.dataset.date);
					});

					$.ajax( {
						url:  site_url+'/ajax_holiday.php',
						type: 'post',
						data: {
							tdate: dates[10],
							bo_table: '<?=$bo_table?>',
						},
						dataType: 'json',
						success: function (holiday) {
							for(i in holiday) {
								var element = dates.findIndex(v => v === i);
								var day = datex[element].innerText;
								if(day.length > 3) day = day.substr(-1);
								datex[element].innerText = day + ' ' + holiday[dates[element]];
								datex[element].style.color = 'red';
								datex[element].className += ' holiday-text';
							}
						},
						error: function (jqXHR, textStatus, errorThrown) {
							alert("데이터 처리중 에러가 발생했습니다.");
						}
					});
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert("데이터 처리중 에러가 발생했습니다.");
				}
			});
		},

		//타이들에 html 적용(문제점이 시간일정에 시간이 안나옴)
	//	eventContent: function( info ) {
    //      return {html: info.event.title};
	//	},

		select: function(arg) {
			save_method = "add";
			var start = arg.startStr;
			if (arg.endStr == null) {
				var end = start;
			} else {
				var end = arg.endStr;
			}
			$('#wr_1').val(start);
			$('#wr_2').val(end);
			$("#eventModal").modal("show");
		},

		eventDrop: function(arg) {
			var start = arg.event.startStr;
			if (arg.event.endStr == "") {
				var end = start;
			} else {
				var end = arg.event.endStr;
			}

			$.ajax({
				url: site_url+'/ajax_update2.php',
				type:"post",
				data: {
					id: arg.event.id,
					wr_1: start,
					wr_2: end,
					bo_table: '<?=$bo_table?>',
				},
			});
		},

		eventResize: function(arg) {
			var id = arg.event.id;
			var start = arg.event.startStr;
			if (arg.event.endStr == "") {
				var end = start;
			} else {
				var end = arg.event.endStr;
			}

			$.ajax({
				url: site_url+'/ajax_update2.php',
				type:"POST",
				data: {
					id: id,
					wr_subject : arg.event._def.title,
					wr_1: start,
					wr_2: end,
					bo_table: '<?=$bo_table?>',
				}
			});
		},

		eventClick: function(arg) {
			var id = arg.event.id;
			if(id == 0) return;

			save_method = "update";
			$('#eventId').val(id);
			$('#deleteEvent').attr('data-id', id);

			$.ajax({
				url: site_url+'/ajax_edit.php',
				type:"POST",
				dataType: 'json',
				data: {
					id: id,
					bo_table: '<?=$bo_table?>',
				},
				success: function(data) {
					var link = '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">취소</button> <button class="btn btn-danger" onclick="delete_form('+id+')">삭제</button><button type="button" class="btn btn-primary" id="btnSave" onclick="save('+id+')">수정</button>';
					$('#eventId').val(id);
					$('#wr_subject').val(data.wr_subject);
					$('#wr_content').val(data.wr_content);
					$('#wr_name').val(data.wr_name);
					$('#wr_name2').text("등록자");
					$('#wr_1').val(data.wr_1);
					$('#wr_2').val(data.wr_2);
					$("#eventBtn").html(link);

					$("input[name='wr_3']").each(function() {
						var $this = $(this);
						if($this.val() == data.wr_3)
						$this.attr('checked', true);
					});

					$("input[name='wr_4']").each(function() {
						var $this = $(this);
						if($this.val() == data.wr_4)
						$this.attr('checked', true);
					});

					$('#eventModal').modal("show");
				  }
			  });
			}
		});
		calendar.render();
	});

	function save(id) {
		var url;
		var formdata = new FormData(document.querySelector('#eventform'));

		if($("#wr_subject").val() == "") {
			alert("제목을 입력해주세요");
			$("#wr_subject").focus();
			return;
		}

		if($("#wr_name").val() == "") {
			alert("이름을 입력해주세요");
			$("#wr_name").focus();
			return;
		}

		if(save_method == "add") {
			url = site_url+"/ajax_save.php";
		} else	{
			url = site_url+"/ajax_update.php";
		}

		$.ajax({
			url : url,
			type: "POST",
			data: formdata,
			processData: false,
			contentType: false,
			success: function(data) {
				$("#eventModal").modal("hide");
				const obj = JSON.parse(data);
				cal_reload(obj.tdate);
		//		location.href = "./board.php?bo_table=<?=$bo_table?>&cur_date="+obj.tdate;
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert("데이터 처리중 에러가 발생했습니다.");
			}
		});
	}

	function delete_form(id) {

		var dates = [];
		document.querySelectorAll("[data-date]").forEach(function(element) {
			dates.push(element.dataset.date);
		});

		if(confirm("자료를 삭제하시겠습니까?")) {
			$.ajax({
				url : site_url+"/ajax_delete.php",
				type: "POST",
				data: {
					id: id,
					tdate: dates[10],
					bo_table: "<?=$bo_table?>",
				},
				success: function(data) {
					$("#eventModal").modal("hide");
					const obj = JSON.parse(data);
					cal_reload(obj.tdate);
			//		location.href = "./board.php?bo_table=<?=$bo_table?>&cur_date="+obj.tdate;
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert("삭제 도중 에러가 발생했습니다.");
				}
			});
		}
	}

	function view_form(id) {

		var dates = [];
		document.querySelectorAll("[data-date]").forEach(function(element) {
			dates.push(element.dataset.date);
		});

		$("#monthModalLabel").text("일정표 ( "+dates[15].substr(0, 7)+" )");

		$.ajax({
			url : site_url+"/ajax_data_month.php",
			type: "POST",
			data: {
				tdate: dates[15],
				bo_table: "<?=$bo_table?>",
			},
			success: function(resp) {
				$("#monthModalBody").html(resp);
				$("#monthModal").modal("show");
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert("에러가 발생했습니다.");
			}
		});
	}

	function cal_reload(cdate) {
		$("#cur_date").val(cdate);
		$("#newloadForm").submit();
	}

</script>