$(document).ready(function(){
	function init_page() {
		var height_window = $(window)[0].innerHeight;
		var height_content = height_window - $('footer').height() - $('header')[0].clientHeight;
		$('.content-area').css('min-height', height_content);
	}
	
	init_page();

	$(window).resize(function() {
		init_page();
	});
});