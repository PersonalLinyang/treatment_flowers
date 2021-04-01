$(document).ready(function(){
	function init_page() {
		var height_window = $(window)[0].innerHeight;
		var height_content = height_window - $('footer').height() - $('header')[0].clientHeight;
		$('.content-area').css('min-height', height_content);
		var margin_top = ($('.content-area')[0].clientHeight - $('.register-form-area')[0].clientHeight) / 2;
		if(margin_top < 0) {
			margin_top = 0;
		}
		$('.register-form-area').css('margin-top', margin_top);
	}
	
	// 登録ボタンクリック
	$( '.btn-register' ).click( function(event){
		// クリックイベントをこれ以上伝播させない
		event.preventDefault();

		// POSTデータ作成
		var fd = new FormData();
		$('#form-register').find('input').each(function() {
			fd.append($(this)[0].name, $(this).val());
		});

		// functions.phpのregisterアクションに送信
		fd.append('action', 'register');

		// エラー出力を全部消す
		$('#form-register').find('.error-message').html('');
		$('#form-register').find('.form-input').removeClass('has-error');

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
					window.location.href = res['redirect_to'];
				} else {
					$.each(res['errors'], function(key, value) {
						$('.error-' + key).html(value);
						$('.error-' + key).closest('.form-input').addClass('has-error');
					});
				}
			},
			error: function( response ){
				$('.error_popup').html('システムエラーが発生しました<br/>しばらく待ってから再度お試しください').fadeIn();
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