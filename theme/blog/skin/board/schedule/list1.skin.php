<?php
if(!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
$to_day = date("Y-m-d");
$cur_date = isset($_POST["cur_date"]) ? $_POST["cur_date"] : $to_day;

$bgcolors = ['#ff6633','#9900ff','#ffa94d','#0099ff','#cc6699','#00ccff','#99ff00','#006699','#330000','#ffffff'];
?>

<script src='<?=$board_skin_url?>/dist/index.global.js'></script>

<style type="text/css">
	thead {height:35px;background:#ffffcc !important}
	.fc-day-sun a {color: red; text-decoration: none;	}
	.fc-day-sat a {color: blue; text-decoration: none;}
	.fc-holiday, .holiday-text {color: #e74c3c;}
	.fc-daygrid-day-frame:hover{background:#ffffcc}
</style>
<form name='newloadForm' id='newloadForm' method='post' action='./board.php?bo_table=<?=$bo_table?>'>
     <input type='hidden' name='cur_date' id='cur_date' value=''>
</form>

<div class="container-fluid mb-5 pe-5">
<!-- <h3 class="mb-5"><?= $board['bo_subject'] ?></h3> -->
<div id='calendar'></div>
</div>

<!-- Modal -->
<div class="modal fade" id="eventModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true" data-bs-focus="false">
  <div class="modal-dialog modal-lg" style="max-width:560px">
    <div class="modal-content">
	<form action="#" name="eventform" id="eventform">
		<input type="hidden" name="bo_table" value="<?=$bo_table?>">
		<input type="hidden" name="id" id="eventId">
		<input type="hidden" name="wr_name" id="wr_name" value="관리자">
		<input type="hidden" name="allDay" id="allDay" value="true">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="eventModalLabel">일정등록</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-2">
		<div class="container">
			<div class="row">
				<div class="col-12 mb-3">
					 <div class="input-group">
						 <span class="input-group-text">제목</span>
						 <input type="text" class="form-control" name="wr_subject" id="wr_subject" required>
					</div>
				</div>
				<div  class="col-12 mb-3">
					 <div class="input-group">
						 <span class="input-group-text">내용</span>
						<textarea class="form-control" name="wr_content" id="wr_content" rows="5" required></textarea>
					</div>
				</div>
				<div  class="col-6 mb-3">
					 <div class="input-group">
						 <span class="input-group-text">시작일</span>
						<input type="text" class="form-control datepicker" id="wr_1" name="wr_1" required>
					</div>
				</div>
				<div  class="col-6 mb-3">
					 <div class="input-group">
						 <span class="input-group-text">종료일</span>
						<input type="text" class="form-control datepicker" id="wr_2" name="wr_2" required>
					</div>
				</div>
				<div  class="col-12 mb-3">
					<div id="color-group" class="form-group">
						 <div class="input-group">
						 <span class="input-group-text">배경색</span>
						 <?php foreach($bgcolors as $value) { ?>
							<div class="input-group-text" style="background:<?=$value?>"><input class="form-check-input fs-5" name="wr_3" type="radio" value="<?=$value?>"></div>
						<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-12 mb-3">
					<div id="textcolor-group" class="form-group">
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
	  </div>
      <div class="modal-footer bg-light" id="eventBtn">
		<button type="button" class="btn btn-primary">저장</button>
	  </div>
	</form>
    </div>
  </div>
</div>

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
				text: '일정보기',
				click: function() {
				view_form('<?=$to_day?>');
			}
		},
			mymonthsButton: {
				text: '월',
				click: function() {
					cal_reload('<?=$cur_date?>');
				//	location.href = "./board.php?bo_table=calendar";
				}
			}
		},
		headerToolbar: {
			left: 'prev,next today',
			center: 'title',
			right: 'mymonthButton mymonthsButton,timeGridWeek,timeGridDay,listWeek'
		},

		views: {
			timeGrid: {
				titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
			}
		},

		buttonText:{year:"년도",month:"월",week:"주",day:"일",today:"오늘",listWeek:"주별"},

		locale: 'ko',
		dayCellContent: function(arg){
//console.log(arg.date.getDate());
			return arg.date.getDate();
		},

		initialDate: '<?=$cur_date?>',
		navLinks: true,
		selectable: true,
		selectMirror: true,
		eventOrder:"order",	//정렬순서 -는 desc
		editable: true,
		dayMaxEvents: false, // allow "more" link when too many events

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
					successCallback( json );

					var datex = $(".fc-daygrid-day-number");

					var dates = [];
					document.querySelectorAll("[data-date]").forEach(function(element) {
						dates.push(element.dataset.date);
					});

					$.ajax( {
							url:  site_url+'/ajax_holiday.php',
							type: 'post',
							data: {
								tdate: dates[15],
								bo_table: '<?=$bo_table?>',
							},
							dataType: 'json',
							success: function (holiday) {

								for(i in dates) {

						//		var day = datex[i].innerText.replace("일", "");
						//		var day = parseInt(dates[i].substr(-2));

									if (holiday[dates[i]]) {
										var day = datex[i].innerText;
										datex[i].innerText = holiday[dates[i]] + "  " + day;
										datex[i].style.color = 'red';
										datex[i].className += ' holiday-text';

									}

								  }
								},
								error: function (xhr, error, thrown) {
								errorCallback( xhr, error, thrown );
								}
						});

				},
				error: function (xhr, error, thrown) {
				errorCallback( xhr, error, thrown );
				}

			});
		},

		select: function(arg) {
			save_method = "add";
			var start = arg.startStr;
			if (arg.endStr == null) {
				var end = start;
			} else {
				var end = arg.endStr;
			}
			var link = '<button type="button" class="btn btn-primary" id="btnSave" onclick="save()">등록</button>';
			$("#eventform")[0].reset();
			$('#wr_1').val(start);
			$('#wr_2').val(end);
			$("#eventBtn").html(link);
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
					var link = '<button class="btn btn-danger" onclick="delete_form('+id+')">삭제</button><button type="button" class="btn btn-primary" id="btnSave" onclick="save('+id+')">수정</button>';
					$('#eventId').val(id);
					$('#wr_subject').val(data.wr_subject);
					$('#wr_content').val(data.wr_content);
					$('#wr_1').val(data.wr_1);
					$('#wr_2').val(data.wr_2);
					$("#eventBtn").html(link);

					$(":radio[name='wr_3']").each(function() {
						var $this = $(this);
						if($this.val() == data.wr_3)
						$this.attr('checked', true);
					});

					$(":radio[name='wr_4']").each(function() {
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

		if($('#wr_subject').val() == "") {
			alert("제목을 입력해주세요");
			return;
		}

		if(save_method == 'add') {
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
	//			location.href = "./board.php?bo_table=<?=$bo_table?>&cur_date="+obj.tdate;
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
					bo_table: '<?=$bo_table?>',
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

		$("#monthModalLabel").text('일정표 ( '+dates[15].substr(0, 7)+' )');

		$.ajax({
			url : site_url+"/ajax_data_month.php",
			type: "POST",
			data: {
				tdate: dates[15],
				bo_table: '<?=$bo_table?>',
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