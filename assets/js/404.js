$(document).ready(function(){
	function init_page() {
		var height_window = $(window)[0].innerHeight;
		var height_content = height_window - $('footer').height() - $('header')[0].clientHeight;
		$('.content-area').css('min-height', height_content);
		var margin_top = ($('.content-area')[0].clientHeight - $('.error-content-area')[0].clientHeight) / 2;
		if(margin_top < 0) {
			margin_top = 0;
		}
		$('.error-content-area').css('margin-top', margin_top);
	}
	
	init_page();

	$(window).resize(function() {
		init_page();
	});
});