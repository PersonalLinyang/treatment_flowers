$(document).ready(function(){
	// ヘッダカタログメニュー展開
  $("#catalog_nav").hover(function() {
    $(this).children('ul').slideDown();
  }, function () {
    $(this).children('ul').slideUp();
  });
	
	// scrollstopイベント定義 スクロールが終了する際に動く
	var scrollStopEvent = new $.Event("scrollstop");
	var delay = 200;
	var timer;
	function scrollStopEventTrigger(){
		if (timer) {
			clearTimeout(timer);
		}
		timer = setTimeout(function(){$(window).trigger(scrollStopEvent)}, delay);
	}
	$(window).on("scroll", scrollStopEventTrigger);
	$("body").on("touchmove", scrollStopEventTrigger);
	
	// ヘッダ左右スクロール対応
	$(window).on("scroll", function(){
		// ブラウザ広さ
		var width_window = $(window)[0].innerWidth;
		if(width_window < 1000) {
			var scroll_left = $(document).scrollLeft();
			$('.header-area').css('left', 0 - scroll_left);
		}
	});

	// フッタカタログメニュー展開
	$('.footer-menu-catalogue').click(function(){
		if($('.footer-menu-catalogue-list').hasClass('active')) {
			$('.footer-menu-catalogue-list').slideUp();
			$('.footer-menu-catalogue-list').removeClass('active');
		} else {
			$('.footer-menu-catalogue-list').slideDown();
			$('.footer-menu-catalogue-list').addClass('active');
		}
	});
});