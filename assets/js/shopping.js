$(document).ready(function(){
	// サイトタイプを確定
	function get_site_type() {
		var width_window = $(window)[0].innerWidth;
		var site_type = '';
		if(width_window > 1200) {
			site_type = 'pc';
		} else if(width_window > 599) {
			site_type = 'tablet';
		} else {
			site_type = 'sp';
		}
		return site_type;
	}
	
	// 商品リスト初期化
	function init_catalogue_list(site_type) {
		var max_item_num = 1;
		if(site_type =='pc' || site_type =='tablet') {
			max_number = 3;
		}
		if(site_type =='sp') {
			max_number = 2;
		}
		
		if(!$('.catalogue-list').hasClass('catalogue-list-' + site_type)) {
			$('.catalogue-list').removeClass('catalogue-list-pc');
			$('.catalogue-list').removeClass('catalogue-list-tablet');
			$('.catalogue-list').removeClass('catalogue-list-sp');
			$('.catalogue-list').addClass('catalogue-list-' + site_type);
			
			$('.catalogue-kind-list').each(function(){
				var catalogue_list = $(this).find('.catalogue-item');
				var move_counter = 1;
				catalogue_list.each(function(){
					if(move_counter == 1) {
						$(this).closest('.catalogue-kind-list').append('<div class="catalogue-group catalogue-group-' + site_type + '"></div>');
					}
					$(this).appendTo($(this).closest('.catalogue-kind-list').find('.catalogue-group-' + site_type + ':last'));
					if(move_counter == max_number) {
						move_counter = 1;
					} else {
						move_counter++;
					}
				});

				if(site_type !='pc') {
					$(this).find('.catalogue-group-pc').remove();
				}
				if(site_type !='tablet') {
					$(this).find('.catalogue-group-tablet').remove();
				}
				if(site_type !='sp') {
					$(this).find('.catalogue-group-sp').remove();
				}
			});
		}
	}
	
	// コンテンツエリア初期化
	function init_content_area(site_type) {
		var width_window = $(window)[0].innerWidth;
		var height_window = $(window)[0].innerHeight;

		// コンテンツエリア最小高さ調整(footerを底揃える)
		var height_content = height_window - $('footer')[0].clientHeight;
		if (site_type == 'pc') {
			// 80 = kind-area.margin-top
			height_content = height_content - 80;
		} else {
			height_content = height_content - $('header')[0].clientHeight - $('.kind-title')[0].clientHeight - $('.cart-area')[0].clientHeight;
		}
		$('.content-area').css('min-height', height_content);
		
		// スライドパーツ幅調整
		if (site_type == 'pc') {
			if($('.shopping-form-content').attr('data-step') == '1') {
				$('.shopping-form-content').css('margin-left', 0);
				$('h2').css('margin-left', 0);
				$('.shopping-form-area').css('width', 800);
				$('.shopping-form-area').css('margin-left', 200);
			} else {
				$('.shopping-form-content').css('margin-left', -800);
				$('h2').css('margin-left', 200);
				$('.shopping-form-area').css('width', 1000);
				$('.shopping-form-area').css('margin-left', 0);
			}
			$('.shopping-form-content').css('width', 1800);
			$('.catalogue-list').css('width', 800);
			$('.information-list').css('width', 1000);
		} else {
			if($('.shopping-form-content').attr('data-step') == '1') {
				$('.shopping-form-content').css('margin-left', 0);
			} else {
				$('.shopping-form-content').css('margin-left', -width_window);
			}
			$('h2').css('margin-left', 0);
			$('.shopping-form-area').css('width', 'auto');
			$('.shopping-form-area').css('margin-left', 0);
			$('.shopping-form-content').css('width', width_window * 2);
			$('.catalogue-list').css('width', width_window);
			$('.information-list').css('width', width_window);
		}

		// 空白種別掲示文縦中央揃え
		var content_text = $('.catalogue-kind-list.active').find('.content-text');
		if(content_text.length) {
			var margin_top = (height_content - content_text[0].clientHeight) / 2 - $('h2')[0].clientHeight;
			if(margin_top < 0) {
				margin_top = 0;
			}
			$('.content-text').css('margin-top', margin_top);
		}
	}
	
	// サイドバー初期化
	function init_sidebar(site_type) {
		var width_window = $(window)[0].innerWidth;
		var height_window = $(window)[0].innerHeight;
		var height_content = $('.content-area')[0].clientHeight;
		var height_header = $('header')[0].clientHeight;
		var height_cart_title = $('.cart-title')[0].clientHeight;
		var height_cart_area = $('.cart-area')[0].clientHeight;
		var width_cart_title = $('.cart-title')[0].clientWidth;
		var height_price_area = $('.price-area')[0].clientHeight;
		var width_button_area = $('.button-controller.active')[0].clientWidth;
		var height_button_area = $('.button-controller.active')[0].clientHeight;
		var scrolltop = $(window).scrollTop();
		
		// 種別リストの高さ
		var height_kind_list = 0;
		if((scrolltop + height_window) > (height_content + height_header)) {
			// footerを超えた場合
			// 90 = kind-list.padding(20) + kind-title.border(3) + kind-title.margin-top(67)
			height_kind_list = height_content - scrolltop - 90;
			if (site_type == 'pc') {
				height_kind_list = height_kind_list - height_cart_title - 20;
			}
		} else {
			// footerを超えない場合
			// 90 = kind-list.padding(20) + kind-title.border(3) + kind-title.margin-top(67)
			height_kind_list = height_window - height_header - height_cart_title - 90;
			if (site_type == 'pc') {
				height_kind_list = height_kind_list - 20;
			}
		}
		$('.kind-list').css('max-height', height_kind_list);
		
		// カゴリストのサイズ
		var height_cart_list = height_kind_list;
		if (site_type == 'pc') {
			height_cart_list = height_cart_list - height_price_area - height_button_area;
		}
		$('.cart-list').css('max-height', height_cart_list);
		if (site_type == 'pc') {
			$('.cart-list').css('height', height_cart_list);
			$('.content-area').css('margin-bottom', 0);
		} else {
			$('.cart-list').css('height', 'auto');
			$('.content-area').css('margin-bottom', height_cart_area);
		}
		
		// カゴリストの位置
		if (site_type == 'pc') {
			$('.cart-area').css('bottom', 'auto');
			$('.cart-list').css('bottom', 'auto');
		} else {
			var bottom_cart_area = 0;
			var bottom_cart_list = height_cart_area;
			if((scrolltop + height_window) > (height_content + height_header + height_cart_title + height_cart_area)) {
				// footerを超えた場合
				bottom_cart_area = scrolltop + height_window - height_content - height_header - height_cart_title - height_cart_area;
				bottom_cart_list = bottom_cart_area + bottom_cart_list;
				$('.cart-area').css('bottom', bottom_cart_area);
				$('.cart-list').css('bottom', bottom_cart_list);
			} else {
				// footerを超えない場合
				$('.cart-area').css('bottom', bottom_cart_area);
				$('.cart-list').css('bottom', bottom_cart_list);
			}
		}
		
		// サイドバースライド表示
		$('.kind-title').unbind();
		$('.cart-title').unbind();
		if (site_type == 'pc') {
			$('.kind-title').removeClass('active');
			$('.kind-list').show();
			$('.cart-title').removeClass('active');
			$('.cart-list').show();
		} else {
			if($('.kind-title').hasClass('active')) {
				$('.kind-list').show();
			} else {
				$('.kind-list').hide();
			}
			if($('.cart-title').hasClass('active')) {
				$('.cart-list').show();
			} else {
				$('.cart-list').hide();
			}
			$('.kind-title').click(function(){
				if($(this).hasClass('active')) {
					$(this).removeClass('active');
					$('.kind-list').slideUp();
				} else {
					$(this).addClass('active');
					$('.kind-list').slideDown();
					$('.cart-title').removeClass('active');
					$('.cart-list').slideUp();
				}
			});
			$('.cart-title').click(function(){
				if($(this).hasClass('active')) {
					$(this).removeClass('active');
					$('.cart-list').slideUp();
				} else {
					$(this).addClass('active');
					$('.cart-list').slideDown();
					$('.kind-title').removeClass('active');
					$('.kind-list').slideUp();
				}
			});
		}
	}
	
	// カゴリスト整理（タブレットの場合高さ揃いの2列表示）
	function init_cart_list(site_type) {
		if(site_type =='tablet') {
			var cart_list = $('.cart-item');
			var move_counter = 1;
			$('.cart-group').addClass('old');
			cart_list.each(function(){
				if(move_counter == 1) {
					$('.cart-list').append('<div class="cart-group"></div>');
				}
				$(this).appendTo($('.cart-group:last'));
				if(move_counter == 2) {
					move_counter = 1;
				} else {
					move_counter++;
				}
			});
			$('.cart-group.old').remove();
		}
	}
	
	function init_page() {
		// サイトタイプを確定
		var site_type = get_site_type();
		
		// 商品を組み分けて表示(行内高さ揃い)
		init_catalogue_list(site_type);
		// コンテンツエリア初期化
		init_content_area(site_type);
		// サイドバー初期化
		init_sidebar(site_type);
		// カゴを組み分けて表示(行内高さ揃い)
		init_cart_list(site_type);
	}
	
	init_page();

	$(window).resize(function() {
		init_page();
	});

	$(window).scroll(function() {
		// サイトタイプを確定
		var site_type = get_site_type();
		init_sidebar(site_type);
	});
	
	// お花の種別を切り替え
	$('.kind-item').click(function() {
		var site_type = get_site_type();
		var kind_slug = $(this).data('slug');

		$('.kind-item').removeClass('active');
		$(this).addClass('active');
		$('.catalogue-kind-list').removeClass('active');
		$('.catalogue-list-' + kind_slug).addClass('active');
		$('body, html').animate({ scrollTop: 0 }, 300);
		
		var site_type = get_site_type();
		if (site_type == 'tablet' || site_type == 'sp') {
			$('.kind-list').slideUp();
			$('.kind-title').removeClass('active');
		}
		init_sidebar(site_type);
	});

	// 購入数入力値変更
	$('.number-input').change(function() {
		var site_type = get_site_type();
		var catalogue_id = $(this)[0].name.replace('num_', '').replace('rot_', '');
		var num_obj = $('#num_' + catalogue_id);
		var rot_obj = $('#rot_' + catalogue_id);
		if (num_obj.val() >= 1 && rot_obj.val() >= 1) {
			$('.cart-empty').remove();
			var number = parseInt(rot_obj.val()) * parseInt(num_obj.val());
			var price = parseInt(rot_obj.val()) * parseInt(num_obj.val()) * parseInt($(this).closest('.catalogue-item-info-area').find('.catalogue-item-info-price').text());
			if($('.cart-item-' + catalogue_id).length == 0) {
				var html_cart_item = '<div class="cart-item cart-item-' + catalogue_id + '">';
				html_cart_item += '<div class="cart-item-title">' + num_obj.closest('.catalogue-item-info-area').find('.catalogue-item-title').text() + '</div>';
				html_cart_item += '<div class="cart-item-info">';
				html_cart_item += '<div class="cart-item-number">購入数 <span class="cart-item-number-value">' + number + '</span></div>';
				html_cart_item += '<div class="cart-item-price">合計 <span class="cart-item-price-value">' + price + '</span> 円</div>';
				html_cart_item += '</div>';
				html_cart_item += '<div class="cart-item-image"><img src="' + $(this).closest('.catalogue-item').find('.catalogue-item-image').find('img').attr('src') + '" /></div>';
				html_cart_item += '</div>';
				$('.cart-list').append(html_cart_item);
				init_cart_list(site_type);
			} else {
				$('.cart-item-' + catalogue_id).find('.cart-item-number-value').html(number);
				$('.cart-item-' + catalogue_id).find('.cart-item-price-value').html(price);
			}
		} else {
			$('.cart-item-' + catalogue_id).remove();
			if($('.cart-item').length == 0) {
				$('.cart-list').append('<div class="cart-empty">買い物カゴは空です。<br/>お好きな商品をお選びください。</div>');
			} else {
				init_cart_list(site_type);
			}
		}
		var price_total = 0;
		$('.cart-item-price-value').each(function() {
			price_total += parseInt($(this).html());
		});
		$('.price-result-number').html(price_total);
		$(this).val(parseInt(num_obj.val()));
	});
	
	// 次へボタンクリック
	$('.btn-next').click(function(){
		if($('.cart-item').length == 0) {
			$('.error_popup').html('買いたいお花の数を選んでください').fadeIn();
			setTimeout(function(){$('.error_popup').fadeOut();}, 3000);
		} else {
			var site_type = get_site_type();
			var slide_width = $('.catalogue-list').width();
			$('.shopping-form-content').animate({ marginLeft: -slide_width }, {queue: false, duration : 300});
			$('.kind-area').hide();
			if (site_type == 'pc') {
				$('.shopping-form-area').css('height', 800);
				$('h2').animate({ marginLeft: 200 }, {queue: false, duration : 300});
				$('.shopping-form-area').animate({ width: 1000 }, {queue: false, duration : 300});
				$('.shopping-form-area').animate({ marginLeft: 0 }, {queue: false, duration : 300});
			} else if (site_type == 'talbet') {
				$('.shopping-form-area').css('height', 700);
			} else {
				$('.shopping-form-area').css('height', 800);
			}
			$('.shopping-form-content').attr('data-step', '2');
			$('.btn-controller-step1').slideUp();
			$('.btn-controller-step2').slideDown();
			$('.btn-controller-step1').removeClass('active');
			$('.btn-controller-step2').addClass('active');
			$('body, html').animate({ scrollTop: 0 }, 300);
			init_sidebar(site_type);
		}
	});
	
	// 戻るボタンクリック
	$('.btn-return').click(function(){
		var site_type = get_site_type();
		$('.shopping-form-content').animate({ marginLeft: 0 }, {queue: false, duration : 300});
		$('.shopping-form-area').css('height', 'auto');
		if (site_type == 'pc') {
			$('.kind-area').show();
			$('h2').animate({ marginLeft: 0 }, {queue: false, duration : 300});
			$('.shopping-form-area').animate({ width: 800 }, {queue: false, duration : 300});
			$('.shopping-form-area').animate({ marginLeft: 200 }, {queue: false, duration : 300});
		}
		$('.shopping-form-content').attr('data-step', '1');
		$('.btn-controller-step1').slideDown();
		$('.btn-controller-step2').slideUp();
		$('.btn-controller-step1').addClass('active');
		$('.btn-controller-step2').removeClass('active');
		$('body, html').animate({ scrollTop: 0 }, 300);
		init_sidebar(site_type);
	});

	// 送信ボタンクリック
	$('.btn-send').click( function(event){
		// クリックイベントをこれ以上伝播させない
		event.preventDefault();

		// POSTデータ作成
		var fd = new FormData();
		$('#form-shopping').find('input').each(function() {
			fd.append($(this)[0].name, $(this).val());
		});
		$('#form-shopping').find('textarea').each(function() {
			fd.append($(this)[0].name, $(this).val());
		});

		// functions.phpのshoppingアクションに送信
		fd.append('action', 'shopping');

		// エラー出力を全部消す
		$('#form-shopping').find('.error-message').html('');
		$('#form-shopping').find('.form-input').removeClass('has-error');

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
					window.location.href = "/shopping/complete/";
				} else {
					$.each(res['errors'], function(key, value) {
						$('.error-' + key).html(value);
						$('.error-' + key).closest('.form-input').addClass('has-error');
					});
					if(res['popup']) {
						$('.error_popup').html(res['popup']).fadeIn();
						setTimeout(function(){$('.error_popup').fadeOut();}, 3000);
					}
				}
			},
			error: function( response ){
				$('.error_popup').html('システムエラーが発生しました<br/>しばらく待ってから再度お試しください').fadeIn();
				setTimeout(function(){$('.error_popup').fadeOut();}, 3000);
			}
		});
		return false;
	});
});