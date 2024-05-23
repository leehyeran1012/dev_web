<?php
if(!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$to_day = date("Y-m-d");
$cur_date = isset($_GET["cur_date"]) ? $_GET["cur_date"] : $to_day;

$prev_date = date("Y-m-d", strtotime("{$cur_date} -1 month"));
$next_date = date("Y-m-d", strtotime("{$cur_date} +1 month"));

?>
<script src='<?=$board_skin_url?>/dist/index.global.js'></script>
<style type="text/css">
	thead {height:35px;background:#ffffcc !important}
	.fc-day-sun a {color: red; text-decoration: none;	}
	.fc-day-sat a {color: blue; text-decoration: none;}
	.fc-holiday, .holiday-text {color: #e74c3c;}
</style>

<div class="container mb-5">
<h2 class="fw-bold mb-5"><?= $board['bo_subject'] ?></h2>

<div id='calendar'></div>

<script>
$(function() {
	var datex = document.getElementsByTagName("td");
	$.ajax( {
		url:  site_url+'/ajax_holiday.php',
		type: 'post',
		data: {
			tdate: '<?=$cur_date?>',
		},
		dataType: 'json',
		success: function (holiday) {
			for(var i=1;i<datex.length;i++) {
			var x = i * 2;
			if (datex[i].getAttribute('data-date') in holiday) {
				var day = document.querySelector('#fc-dom-'+x).innerText;
				document.querySelector('#fc-dom-'+x).innerText = holiday[datex[i].getAttribute('data-date')]+"  "+day;
				document.querySelector('#fc-dom-'+x).style.color = 'red';
				document.querySelector('#fc-dom-'+x).className += ' holiday-text';
				}
			}
		},
		error: function (xhr, error, thrown) {
		errorCallback( xhr, error, thrown );
		}
	});
});
</script>
<!-- Modal -->
<div class="modal fade" id="eventModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true" data-bs-focus="false">
  <div class="modal-dialog modal-md">
	<form action="#" name="form" id="form">
	<input type="hidden" name="bo_table" value="<?=$bo_table?>">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title" id="eventModalLabel">일정등록</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-2">
			<input type="hidden" name="id" id="eventId">
			<input type="hidden" name="username" id="username" value="관리자">
			<input type="hidden" name="allDay" id="allDay" value="true">

			<div  class="row">
			<div  class="col-12 mb-2">
				<label class="control-label" for="wr_subject">제목</label>
				<div id="title-group" class="form-group">
					<input type="text" class="form-control" name="wr_subject" id="wr_subject" required placeholder="제목">
				</div>
			</div>
			<div  class="col-12 mb-2">
				<div id="desc-group" class="form-group">
					<label class="control-label" for="wr_content">상세내용</label>
					<textarea class="form-control" name="wr_content" id="wr_content" rows="5"></textarea>
				</div>
			</div>
			<div  class="col-6 mb-2">
				<div id="start-group" class="form-group">
					<label class="control-label" for="wr_1">시작일</label>
					<input type="text" class="form-control datepicker" id="wr_1" name="wr_1">
				</div>
			</div>
			<div  class="col-6 mb-2">
				<div id="end-group" class="form-group">
					<label class="control-label" for="wr_2">종료일</label>
					<input type="text" class="form-control datepicker" id="wr_2" name="wr_2">
				</div>
			</div>
			<div  class="col-6 mb-2">
				<div id="color-group" class="form-group">
					<label class="control-label" for="wr_3">배경색</label><br>
					<select class="form-select" name="wr_3" id="wr_3">
						<option value="#d25565" style="color:#d25565;">빨간색</option>
						<option value="#9775fa" style="color:#9775fa;">보라색</option>
						<option value="#ffa94d" style="color:#ffa94d;">주황색</option>
						<option value="#74c0fc" style="color:#74c0fc;">파란색</option>
						<option value="#f06595" style="color:#f06595;">핑크색</option>
						<option value="#63e6be" style="color:#63e6be;">연두색</option>
						<option value="#a9e34b" style="color:#a9e34b;">초록색</option>
						<option value="#4d638c" style="color:#4d638c;">남색</option>
						<option value="#495057" style="color:#495057;">검정색</option>
					</select>
				</div>
			</div>
			<div  class="col-6 mb-2">
				<div id="textcolor-group" class="form-group">
					<label class="control-label" for="wr_4">글자색</label>
					<select class="form-select" name="wr_4" id="wr_4">
						<option value="#ffffff">흰색</option>
						<option value="#d25565" style="color:#d25565;">빨간색</option>
						<option value="#9775fa" style="color:#9775fa;">보라색</option>
						<option value="#ffa94d" style="color:#ffa94d;">주황색</option>
						<option value="#74c0fc" style="color:#74c0fc;">파란색</option>
						<option value="#f06595" style="color:#f06595;">핑크색</option>
						<option value="#63e6be" style="color:#63e6be;">연두색</option>
						<option value="#a9e34b" style="color:#a9e34b;">초록색</option>
						<option value="#4d638c" style="color:#4d638c;">남색</option>
						<option value="#495057" style="color:#495057;">검정색</option>
					</select>
				</div>
			</div>

	  </div>
      <div class="modal-footer bg-light" id="eventBtn"></div>
    </div>
	</form>
  </div>
</div>


<script>

	var save_method;
	var site_url ="<?= $board_skin_url ?>";

	document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
	  customButtons: {
		mytodayButton: {
		  text: '오늘',
		  click: function() {
			  location.href = "./board.php?bo_table=calendar&cur_date=<?=$to_day?>";
		  }
		},
		mymonthButton: {
		  text: '월',
		  click: function() {
			  location.href = "./board.php?bo_table=calendar&cur_date=<?=$to_day?>";
		  }
		}
	  },

      headerToolbar: {
        left: 'mytodayButton',
        center: 'title',
        right: 'mymonthButton prev,timeGridWeek,timeGridDay,listWeek,next'
      },

	buttonText:{year:"년도",month:"월",week:"주",day:"일"},

	titleFormat : function(date) {
	  return date.date.year +"년 "+(date.date.month +1)+"월";
	},
locale: 'ko',
		  timeZone: 'Asia/Seoul',
	initialDate: '<?=$cur_date?>',
//	initialView: 'timeGridWeek',
	navLinks: true,
	selectable: true,
	selectMirror: true,
//	eventOrder:"order",	//정렬순서 -는 desc
	select: function(arg) {
		save_method = "add";
		 var start = arg.startStr;
         if (arg.endStr == null) {
            var end = start;
         } else {
            var end = arg.endStr;
         }
		var link = '<button type="button" class="btn btn-primary" id="btnSave" onclick="save()">등록</button>';
		$("#form")[0].reset();
		$('#wr_1').val(start);
		$('#wr_2').val(end);
		$("#eventBtn").html(link);
		$("#eventModal").modal("show");
      },

      editable: true,
      dayMaxEvents: false, // allow "more" link when too many events

	events: function(info, successCallback, failureCallback) {

			$.ajax( {
				url:  site_url+'/ajax_data.php',
				type: 'post',
              data: {
				  "tdate": info.startStr,
				},
				dataType: 'json',
				success: function (json) {
					successCallback( json );
				},
				error: function (xhr, error, thrown) {
					errorCallback( xhr, error, thrown );
				}
			});

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
				  "id": arg.event.id,
				  "wr_1": start,
				  "wr_2": end,
				  "bo_table": '<?=$bo_table?>',
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
				"id": id,
				"wr_subject" : arg.event._def.title,
				"wr_1": start,
				"wr_2": end,
				"bo_table": '<?=$bo_table?>',
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
				"id": id,
				"bo_table": '<?=$bo_table?>',
			 },
              success: function(data) {
				  console.log(data);
					var link = '<button class="btn btn-danger" onclick="delete_form('+id+')">삭제</button><button type="button" class="btn btn-primary" id="btnSave" onclick="save('+id+')">수정</button>';
					$('#eventId').val(id);
                    $('#wr_subject').val(data.wr_subject);
                    $('#wr_content').val(data.wr_content);
                    $('#wr_1').val(data.wr_1);
                    $('#wr_2').val(data.wr_2);
					$("#eventBtn").html(link);
					$.each($('#wr_3 option'),function(a,b){
						if($(this).val() == data.wr_3){
							$(this).attr('selected',true);
						}
					});
					$.each($('#wr_4 option'),function(a,b){
						if($(this).val() == data.wr_4){
							$(this).attr('selected',true);
						}
					});

                    $('#eventModal').modal("show");
                }
            });

              calendar.refetchEvents();
        }

    });

    calendar.render();

  });

	function save(id) {
		var url;
		var formdata = new FormData(document.querySelector('#form'));

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
				$("#modal_form").modal("hide");
				location.reload();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert("데이터 처리중 에러가 발생했습니다.");
			}
		});
	}

	function delete_form(id) {
		if(confirm("자료를 삭제하시겠습니까?")) {

			$.ajax({
				url : site_url+"/ajax_delete.php",
				type: "POST",
				data: {
					 "id": id,
					"bo_table": '<?=$bo_table?>',
				 },
				success: function(res) {
					$("#modal_form").modal("hide");
			//		location.reload();
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert("삭제 도중 에러가 발생했습니다.");
				}
			});
		}
	}
</script>
</div></div>