var myVar = null;
$(function(){
	setTimeout(function() {
	  $('#doc').addClass('show');
	}, 350);
	$('#mainNavi').find('.after').hide();
	
	// bt-member
	$('.bt-member').click(function(){
		if($(this).hasClass('active')){
			$('.layer-member').stop().fadeOut('fast');
			 $(this).removeClass('active');
		}else{
			$('.layer-member').stop().fadeIn('fast');
			$(".layer-ov").bind("click",function(){
				 $('.layer-member').stop().fadeOut('fast');
				 $('.bt-member').removeClass('active');
			}).stop().fadeIn();
			 $(this).addClass('active');
		}
   });

   $('.layer-member').find('li > a').click(function(){
	  $('.layer-member').stop().fadeOut('fast');
	  $('.bt-member').removeClass('active');
   });


	// login & logout
	$('.nav').find('.login-btn').click(function(){
		$('.nav').find('.before').hide();
		$('.nav').find('.after').show();
		$('.nav').find('.bt-logout').css({'display':'inline-block'})
		$('.nav').find('.bt-login').hide();
	});
	$('.nav').find('.logout-btn').click(function(){
		$('.nav').find('.before').show();	
		$('.nav').find('.after').hide();
		$('.nav').find('.bt-login').css({'display':'inline-block'})
		$('.nav').find('.bt-logout').hide();
	});

	// f-fmaily
	$('.f-family > .sel').click(function() {
	  if ($(this).parent().hasClass('active')) {
		  $(this).parent().removeClass('active');
		  $(this).parent().find('ul').stop().fadeOut();
	  } else {
		   $(this).parent().addClass('active');
		   $(this).parent().find('ul').stop().fadeIn();
	  }
	}); 

	// allmenu script
	$('.bt-allmenu').bind("click",function(){
		if($(this).hasClass('active')){
			/*$(this).removeClass('active');
			$("body").css({"overflow":"visible"});  
			$('#header-wrap').removeClass('isOver');
			 $('#allmenu-wrap').stop().fadeOut();
			 setTimeout(function() {
			   $('#allmenu-wrap').removeClass('open');
			 }, 500);*/
		}else{
			 $(this).addClass('active');
			 $("body").css({"overflow":"hidden"});  
			 //$('#header-wrap').addClass('isOver');
			  $('#allmenu-wrap').stop().fadeIn().addClass('open')	
		}
		$('#doc').css({'z-index':'9999'});
	});
	$('#allmenu-wrap').find('.close').bind("click",function(){
		$('.bt-allmenu').removeClass('active');
		$("body").css({"overflow":"visible"});   
	    $('#allmenu-wrap').stop().fadeOut()
		setTimeout(function() {
		  $('#allmenu-wrap').removeClass('open');
		}, 500);
		
		$('#doc').css({'z-index':'8999'});
	});

	 // top-btn & scroll
	if($(".top-btn").length<1) $("<a href='#n' class='top-btn'><span class='blind'>top</span></a>").appendTo($("#doc"));
	$('.top-btn').click(function(){
		var docH = $('#doc').outerHeight();
		$("body, html").animate({
				scrollTop: 0
		}, 650)
	});
});	
$(window).scroll(function() {
	var position = $(window).scrollTop(); 
	var bodyWidth = document.documentElement.clientWidth; 
	if (position > 0){
		$('#header-wrap').addClass('fix');
	}else{
		$('#header-wrap').removeClass('fix');
	}
	if (position > 300){
		$('.top-btn').addClass('over');
	}else{
		$('.top-btn').removeClass('over');
	}
});
$(window).load(function(){
	var position = $(window).scrollTop(); 
	var bodyWidth = document.documentElement.clientWidth; 
	if (position > 0){
		$('#header-wrap').addClass('fix');
	}else{
		$('#header-wrap').removeClass('fix');
	}
	if (position > 300){
		$('.top-btn').addClass('over');
	}else{
		$('.top-btn').removeClass('over');
	}
});


function sizeControls(width) {
	width = parseInt(width);
	var bodyHeight = document.documentElement.clientHeight; 
	var bodyWidth = document.documentElement.clientWidth; 
	var docW = $('#doc').innerWidth();
	var navH01 = $('#mainNavi').outerHeight();
	
	
}
jQuery(function($){
	sizeControls($(this).width());
	$(window).resize(function() {
		if(this.resizeTO) {
			clearTimeout(this.resizeTO);
		}
		this.resizeTO = setTimeout(function() {
			$(this).trigger('resizeEnd');
		}, 10);
	});
});	
$(window).on('resizeEnd', function() {
	sizeControls($(this).width());
});
$(window).load( function() { 
	sizeControls($(this).width());
});



//필수정보 입력 확인
function essential() {

	for(var i=0; i<$('.essential').length; i++) {
		var $e = $('.essential').eq(i);
		if($e.prop('disabled')) continue;
		switch($e.prop('tagName')) {
			case 'INPUT' : 
				switch($e.attr('type')) {
					case 'text' : 
					case 'file' : 
					case 'hidden' : 
					case 'password' : 
					case 'number' : 
						if(!trim($e.val())) {
							alert('['+ $e.attr('title') +'] 필수 입력입니다');
							$e.focus();
							return false;
						}
						if($e.attr('minlength')) {
							if($e.val().length < $e.attr('minlength')) {
								alert($e.attr('minlength') + '자 이상 입력해주세요');
								$e.focus();
								return false;
							}
						}
						break;
					case 'radio' :
					case 'checkbox' :
						var $name = $e.attr('name');
						if($('[name="' + $name + '"]:checked').length < 1) {
							$('[name="' + $name + '"]:eq(0)').focus();
							alert('['+ $e.attr('title') + '] 필수 선택입니다');
							return false;
						}
						break;
				}
				break;
			case 'SELECT' : 
				if(!$e.val()) {
					alert('['+ $e.attr('title') +'] 필수 선택입니다');
					$e.focus();
					return false;
				}
				break;
			case 'TEXTAREA' :
				if(!trim($e.val()) || trim($e.val()) == '<p>&nbsp;</p>') {
					alert('['+ $e.attr('title') +'] 필수 입력입니다');
					$e.focus();
					return false;
				}
				break;
		}
	}
	return true;

}
//필수정보 입력 확인 : 폼 아이디 추가
function essential2(id) {

	if(!id || id == undefined) {
		alert('FORM ID가 지정되지 않았습니다.');
		return false;
	} else {
		for(var i=0; i<$('#' + id + ' .essential').length; i++) {
			var $e = $('#' + id + ' .essential').eq(i);
			if($e.prop('disabled')) continue;
			switch($e.prop('tagName')) {
				case 'INPUT' : 
					switch($e.attr('type')) {
						case 'text' : 
						case 'hidden' : 
						case 'password' : 
						case 'number' : 
							if(!$.trim($e.val())) {
								alert('['+ $e.attr('title') +'] 필수 입력입니다');
								$e.focus();
								return false;
							}
							if($e.attr('minlength')) {
								if($.trim($e.val()).length < $e.attr('minlength')) {
									alert($e.attr('minlength') + '자 이상 입력해주세요 - ' + $e.attr('title'));
									$e.focus();
									return false;
								}
							}
							break;
						case 'radio' :
						case 'checkbox' :
							var $name = $e.attr('name');
							if($('[name="' + $name + '"]:checked').length < 1) {
								$('[name="' + $name + '"]:eq(0)').focus();
								alert('['+ $e.attr('title') +'] 필수 선택입니다');
								return false;
							}
							break;
					}
					break;
				case 'SELECT' : 
					if(!$e.val()) {
						alert('['+ $e.attr('title') +'] 필수 선택입니다');
						$e.focus();
						return false;
					}
					break;
				case 'TEXTAREA' :
					if(!$.trim($e.val()) || $.trim($e.val()) == '<p>&nbsp;</p>') {
						alert('['+ $e.attr('title') +'] 필수 입력입니다');
						$e.focus();
						return false;
					}
					break;
			}
		}
		return true;
	}

}

//loading -loading css 추가해야함
function loading(md) {
	switch(md) {
		case 'show' : 
			if($('#LOADINGAREA').length == 0) {
				var sHtml = '';
				sHtml += '<div id="LOADINGAREA">';
				sHtml += ' <div class="load-wrapp">';
				sHtml += '	<div class="load-4">';
				sHtml += '		<div class="ring-1">';
				sHtml += '		</div>';
				sHtml += '	</div>';
				sHtml += ' </div>';
				sHtml += '	<div class="loadingbg"></div>';
				sHtml += '</div>';
				$('body').append(sHtml);
			}
			$('#LOADINGAREA').show();
			break;
		case 'hide' : 
			$('#LOADINGAREA').hide();
			break;
		default : 
			break;
	}
}


/**
 *  에러(다이얼로그) 설정
 * @param string, string, string
 */
function doError(title, msg, id){ //, frm
    //title:[레이어타이틀], msg:[메시지], id[input필드명], frm[form명]
    openMsgDialog(msg, title, id, "");
}

/**
 *  에러(쓰기) 설정
 * @param string, string
 */
function doErrorWrite(msg, sId){
    $("#"+sId).html(msg);
    $("#"+sId).show();
}

function openMsgDialog(msg, title, id, completeFnc){ //, cancelFnc
    if( !!title ){
        $('.layer-vAlrim .is-top .title').html(title);
        $('.layer-vAlrim .is-con .id').html('<p>'+msg+'</p>');
        openLayerPopup(".layer-vAlrim" ,id);
    } else {
        $('.layer-wrap.joinEnd .is-con').html(msg)
        $('.layer-wrap.joinEnd .is-btm').html(completeFnc)
        openLayerPopup(".layer-wrap.joinEnd" ,id);
    }
}

function openLayerPopup(popupID,returnTarget) {
    $(popupID).bPopup({
        positionStyle: "fixed",
        closeClass: "layer-close",
        follow: [false, false],
        position: [false, false],
        modalColor: "transparent",
        onClose: function() { if(!!returnTarget) {$(returnTarget).focus(); } }
    });
}