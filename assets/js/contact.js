$(document).ready(function(){
	function init_page() {
		var height_window = $(window)[0].innerHeight;
		var height_content = height_window - $('footer').height() - $('header')[0].clientHeight;
		$('.content-area').css('min-height', height_content);
		var margin_top = ($('.content-area')[0].clientHeight - $('.contact-form-area')[0].clientHeight) / 2;
		if(margin_top < 0) {
			margin_top = 0;
		}
		$('.contact-form-area').css('margin-top', margin_top);
	}
	
	// 送信ボタンクリック
	$('.btn-contact').click( function(event){
		// クリックイベントをこれ以上伝播させない
		event.preventDefault();

		// POSTデータ作成
		var fd = new FormData();
		$('#form-contact').find('input').each(function() {
			fd.append($(this)[0].name, $(this).val());
		});
		$('#form-contact').find('textarea').each(function() {
			fd.append($(this)[0].name, $(this).val());
		});

		// functions.phpのcontactアクションに送信
		fd.append('action', 'contact');

		// エラー出力を全部消す
		$('#form-contact').find('.error-message').html('');
		$('#form-contact').find('.form-input').removeClass('has-error');

		// ajaxの通信
		$.ajax({
			type: 'POST',
			url: ajaxurl,
			data: fd,
			processData: false,
			contentType: false,
			success: function( response ){
				var res = JSON.parse(response);
				if(res['result'] == true) {
					window.location.href = "/contact/complete/";
				} else {
					$.each(res['errors'], function(key, value) {
						$('.error-' + key).html(value);
						$('.error-' + key).closest('.form-input').addClass('has-error');
					});
				}
			},
			error: function( response ){
				$('.error_popup').html('システムエラーが発生しました<br/>しばらく待って再送信してお願い致します').fadeIn();
				setTimeout(function(){$('.error_popup').fadeOut();}, 3000);
			}
		});
		return false;
	});
	
	init_page();

	$(window).resize(function() {
		init_page();
	});
});