
    function check_phone(id) {
        var input = $('#'+id).val();
        var phone_format = /^01([0|1|6|7|8|9])-?([0-9]{4})-?([0-9]{4})$/;
        if (phone_format.test(input)) {
			$('#'+id).val(input.replace(/^(\d{2,3})(\d{3,4})(\d{4})$/, `$1-$2-$3`));
		} else {	
			$('#'+id).focus();
			alert("전화번호가 잘못 입력 되었습니다.");			
        }
    }

	function getCheck(id, id2)  {
        var val1 = "";
        var val2 = "";
        var val3 = "";
        val1 = $("input[name=wrb"+id+"_"+id2+"]:checked").val();
        $("input[name=wrd"+id+"_"+id2+"]").each(function() {
            val2 = $("input[name=wrd"+id+"_"+id2+"]:checked").val();
        });

        val1 = val1 + "^" + val2;
        $("#wrk"+id+"_"+id2).val(val1);
        $("input[name='wrka"+id+"[]']").each(function(idx){
            if($(this).val()) {
                val3 = val3+"|"+$(this).val();
            }
        });
        $("#wr_val"+id).val(val3);
    }


	function getGitacheck(id) {

		var checkBoxArr = [];
		var val2 = "";

		$("input[name=wrd"+id+"]:checked").each(function(i){
			checkBoxArr.push($(this).val());
		});

		val2 = checkBoxArr.join("|");

		if(val2.indexOf('타') > 0) {
			val2 = val2 + "|" + $("#mtext_"+id).val();
		}

		$("#wr_val"+id).val(val2);
	}

	function toggleGitabox(id,id2) {

		if($("#wrd"+id+"_"+id2).is(":checked")) {
			$("#mtext_"+id).prop('disabled', false);
		} else {
			$("#mtext_"+id).prop('disabled', true);
			$("#mtext_"+id).val('');
			var tt = $("#wr_val"+id).val();
			if(tt.indexOf('타') > 0) {
				$("#wr_val"+id).val(tt.substr(0, tt.indexOf('기')-1));
			}
		}
	}

   function juso_execDaumPostcode() {
	 new daum.Postcode({
		oncomplete: function(data) {
			// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

			// 각 주소의 노출 규칙에 따라 주소를 조합한다.
			// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
			var addr = ''; // 주소 변수
			var extraAddr = ''; // 참고항목 변수

			//사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
			if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
				addr = data.roadAddress;
			} else { // 사용자가 지번 주소를 선택했을 경우(J)
				addr = data.jibunAddress;
			}

			// 사용자가 선택한 주소가 도로명 타입일때 참고항목을 조합한다.
			if(data.userSelectedType === 'R'){
			// 법정동명이 있을 경우 추가한다. (법정리는 제외)
			// 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
			if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
				extraAddr += data.bname;
			}
			// 건물명이 있고, 공동주택일 경우 추가한다.
			if(data.buildingName !== '' && data.apartment === 'Y'){
				extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
			}
			// 표시할 참고항목이 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
			if(extraAddr !== ''){
				extraAddr = ' (' + extraAddr + ')';
			}
			// 조합된 참고항목을 해당 필드에 넣는다.
				document.getElementById("juso3").value = extraAddr;

			} else {
				document.getElementById("juso3").value = '';
			}

			// 우편번호와 주소 정보를 해당 필드에 넣는다.
			document.getElementById('wr_postcode').value = data.zonecode;
			document.getElementById("juso1").value = addr;
			// 커서를 상세주소 필드로 이동한다.
			document.getElementById("juso2").focus();
			$('#wr_addr').val("("+$("#wr_postcode").val()+") "+$("#juso1").val());

		}
	}).open();
}

function jusointput() {
	$("#wr_addr2").val($("#wr_postcode").val()+"|"+$("#juso1").val()+", |"+$("#juso2").val()+"|"+$("#juso3").val());
}