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
	
	// カタログリスト初期化
	function init_catalogue_list(site_type) {
		if(!$('.catalogue-content-area').hasClass('catalogue-content-area-' + site_type)) {
			var max_item_num = 1;
			if(site_type =='pc') {
				max_number = 4;
			}
			if(site_type =='tablet') {
				max_number = 3;
			}
			if(site_type =='sp') {
				max_number = 2;
			}
			$('.catalogue-content-area').removeClass('catalogue-content-area-pc');
			$('.catalogue-content-area').removeClass('catalogue-content-area-tablet');
			$('.catalogue-content-area').removeClass('catalogue-content-area-sp');
			$('.catalogue-content-area').addClass('catalogue-content-area-' + site_type);
			var catalogue_list = $('.catalogue-item');
			var move_counter = 1;
			catalogue_list.each(function(){
				if(move_counter == 1) {
					$('.catalogue-content-area').append('<div class="catalogue-group catalogue-group-' + site_type + '"></div>');
				}
				$(this).appendTo('.catalogue-group-' + site_type + ':last');
				if(move_counter == max_number) {
					move_counter = 1;
				} else {
					move_counter++;
				}
			});
			if(site_type !='pc') {
				$('.catalogue-group-pc').remove();
			}
			if(site_type !='tablet') {
				$('.catalogue-group-tablet').remove();
			}
			if(site_type !='sp') {
				$('.catalogue-group-sp').remove();
			}
		}
	}
	
	// コンテンツエリア初期化
	function init_content_area(site_type) {
		var height_window = $(window)[0].innerHeight;

		// コンテンツエリア最小高さ調整(footerを底揃える)
		var height_content = height_window - $('footer')[0].clientHeight;
		if (site_type == 'pc') {
			// 80 = kind-area.margin-top
			height_content = height_content - 80;
		} else {
			height_content = height_content - $('header')[0].clientHeight - $('.kind-title')[0].clientHeight;
		}
		$('.content-area').css('min-height', height_content);

		// 空白種別掲示文縦中央揃え
		if($('.content-text').length) {
			var margin_top = ($('.content-area')[0].clientHeight - $('.content-text')[0].clientHeight) / 2 - $('h2')[0].clientHeight;
			if(margin_top < 0) {
				margin_top = 0;
			}
			$('.content-text').css('margin-top', margin_top);
		}
	}
	
	// サイドバー初期化
	function init_sidebar(site_type) {
		var height_window = $(window)[0].innerHeight;
		var height_content = $('.content-area')[0].clientHeight;
		var height_header = $('header')[0].clientHeight;
		var height_kind_title = $('.kind-title')[0].clientHeight;
		var scrolltop = $(window).scrollTop();
		
		// 種別リストの高さ
		var height_kind_list = 0;
		if((scrolltop + height_window) > (height_content + height_header)) {
			// footerを超えた場合
			// 96 = kind-list.padding(20) + kind-title.border(3) + kind-title.margin-top(73)
			height_kind_list = height_content - scrolltop - 90;
			if (site_type == 'pc') {
				height_kind_list = height_kind_list - height_kind_title - 20;
			}
		} else {
			// footerを超えない場合
			// 96 = kind-list.padding(20) + kind-title.border(3) + kind-title.margin-top(73)
			height_kind_list = height_window - height_header - height_kind_title - 96;
			if (site_type == 'pc') {
				height_kind_list = height_kind_list - 20;
			}
		}
		$('.kind-list').css('max-height', height_kind_list);
		
		// サイドバースライド表示
		$('.kind-title').unbind();
		if (site_type == 'pc') {
			$('.kind-title').removeClass('active');
			$('.kind-list').show();
		} else {
			if($('.kind-title').hasClass('active')) {
				$('.kind-list').show();
			} else {
				$('.kind-list').hide();
			}
			$('.kind-title').click(function(){
				if($(this).hasClass('active')) {
					$(this).removeClass('active');
					$('.kind-list').slideUp();
				} else {
					$(this).addClass('active');
					$('.kind-list').slideDown();
				}
			});
		}
	}
	
	// カタログ各行動的に表示
	function init_catalogue_group(site_type) {
		$('.catalogue-group').each(function(){
			var width_window = $(window)[0].innerWidth;
			var height_group = $(this)[0].clientHeight;
			var height_window = $(window)[0].innerHeight;
			var scrolltop = $(window).scrollTop();
			var scrollbottom = scrolltop + height_window;
			var grouptop = $(this).offset().top;
			var groupbottom = grouptop + height_group;
			var ratio = 0;
			var blank_size = 0;
			if (site_type == 'pc') {
				blank_size = 34;
			} else {
				blank_size = width_window * 0.1;
			}
			if (scrollbottom < grouptop) {
				$(this).css('margin-left', blank_size);
				$(this).css('margin-right', -blank_size);
				$(this).css('opacity', 0);
			} else if (scrollbottom <= groupbottom) {
				ratio = (scrollbottom - grouptop) / height_group;
				var margin = blank_size - (blank_size * ratio);
				$(this).css('margin-left', margin);
				$(this).css('margin-right', -margin);
				$(this).css('opacity', ratio);
			} else {
				$(this).css('margin-left', 0);
				$(this).css('margin-right', 0);
				$(this).css('opacity', 1);
			}
		});
	}
	
	// ページ初期化
	function init_page() {
		// サイトタイプを確定
		var site_type = get_site_type();
		
		// カタログを組み分けて表示(行ない高さ揃い)
		init_catalogue_list(site_type);
		// コンテンツエリア初期化
		init_content_area(site_type);
		// サイドバー初期化
		init_sidebar(site_type);
		// カタログ各行動的に表示
		init_catalogue_group(site_type);
	}
	
	// Colorbox初期化
	function init_colorbox() {
		var site_type = get_site_type();
	}
	
	init_page();

	$(window).resize(function() {
		init_page();
	});

	$(window).scroll(function() {
		// サイトタイプを確定
		var site_type = get_site_type();
		init_sidebar(site_type);
		init_catalogue_group(site_type)
	});
	
	$('.catalogue-item-image a').colorbox({
		rel: 'catalogue-colorbox',
		maxWidth: '80%',
		maxHeight: '80%',
		opacity: 0.7,
		onComplete: function() {
			var height_window = $(window)[0].innerHeight;
			var height_colorbox = $('#colorbox')[0].clientHeight;
			$('#colorbox').css('position', 'fixed');
			$('#colorbox').css('top', (height_window - height_colorbox) / 2);
		}
	});
	$('#cboxCurrent').remove();
});