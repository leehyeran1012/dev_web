
<div>
<h1>감사합니다.</h1>
</div>

<script>
	history.pushState(null, null, "http://현재페이지URL을 입력하세요.");
	window.onpopstate = function(event) {
	history.go(1);
};
</script>