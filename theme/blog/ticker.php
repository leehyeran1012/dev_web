<script src="<?= G5_THEME_URL ?>/js/jquery.easy-ticker.min.js"></script>

<div class="myTicker alert alert-warning" role="alert">
    <div>
        <div class="py-3">List item 1</div>
        <div class="py-3">List item 2</div>
        <div class="py-3">List item 3</div>
        <div class="py-3">List item 4</div>
    </div>
</div>

<script>
$(document).ready(function(){    
    $('.myTicker').easyTicker({
        direction: 'up',
        easing: 'swing',
        speed: 'slow',
        interval: 2000,
        height: 'auto',
        visible: 1,
        mousePause: true,
    });
});	
</script>