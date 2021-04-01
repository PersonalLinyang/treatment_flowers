$(document).ready(function(){
	
	if (!CSS.supports("backdrop-filter", "blur(50px)")) {
		$('.cover').backgroundBlur({
			imageURL: 'https://treatflowers.sakura.ne.jp/wp-content/themes/themetreatflowers/assets/img/first_view.jpg',
			blurAmount: 30
		});
	}

	setTimeout(() => {
		$('#loading_container').fadeOut(function () {
			$('#loading_container').remove()
		})
	}, 2000)

	setTimeout(() => {
		$('.loading_bg').fadeIn(800);
	}, 300);

	const h = $(window).height();
	const animationDuration = 500

	const headerHeight = $('header').height();
	const conceptTop = $('.concept_container').offset().top;
	const shopsTop = $('.shop_container').offset().top;
	const blogTop = $('.blog_container').offset().top;
	const companyTop = $('.company_container').offset().top;

	$('#concept_nav').click(function () {
		$('html').animate({scrollTop: conceptTop - headerHeight}, 500)
	})

	$('#shops_nav').click(function () {
		$('html').animate({scrollTop: shopsTop - headerHeight}, 500)
	})

	$('#blog_nav').click(function () {
		$('html').animate({scrollTop: blogTop - headerHeight * 2}, 500)
	})

	$('#company_nav').click(function () {
		$('html').animate({scrollTop: companyTop - headerHeight * 2}, 500)
	})

	$("#catalog_nav").hover(function() {
		$(this).children('ul').slideDown();
	}, function () {
		$(this).children('ul').slideUp();
	});

	$(window).scroll(function() {
		if ($(this).scrollTop() > 50 && $('.filter').is(':visible') && $('.filter').is(':animated') === false) {
			$('.filter').stop().fadeOut(animationDuration);
			$('.cover').stop().fadeIn(animationDuration);
		} else if ($(this).scrollTop() < 50 && $('.filter').is(':visible') == false && $('.filter').is(':animated') === false) {
			$('.filter').stop().fadeIn(animationDuration);
			$('.cover').stop().fadeOut(animationDuration);
		}

		if ($(this).scrollTop() + h * 0.8 > shopsTop && $('.shops_bg').is(':visible') === false && $('.shops_bg').is(':animated') === false) {
			$('.logos').hide();
			$('.cover').stop().fadeOut(animationDuration);
			$('.shops_bg').stop().fadeIn(animationDuration);
			$('header').addClass('cusotm_header')
			$('.black_icon').show()
			$('.white_icon').hide()
		} else if ($(this).scrollTop() + h * 0.8 < shopsTop && $('.shops_bg').is(':visible') && $('.shops_bg').is(':animated') === false) {
			$('.logos').show();
			$('.cover').stop().fadeIn(animationDuration);
			$('.shops_bg').stop().fadeOut(animationDuration);
			$('header').removeClass('cusotm_header')
			$('.black_icon').hide()
			$('.white_icon').show()
		}
		
		$('.concept_detail_wrapper_1').css('opacity', ($(this).scrollTop() + $(window)[0].innerHeight - $('.concept_detail_wrapper_1').offset().top) / $('.concept_detail_wrapper_1')[0].clientHeight);
		
		$('.concept_detail_wrapper_2').css('opacity', ($(this).scrollTop() + $(window)[0].innerHeight - $('.concept_detail_wrapper_2').offset().top) / $('.concept_detail_wrapper_2')[0].clientHeight);

	});

});