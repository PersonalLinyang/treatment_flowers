<?php
/*
 * ヘッダ部分
 */
$terms_kind = get_terms( 'kind', 
	array(
		'hide_empty' => 0,
		'orderby' => 'id',
		'order' => 'ASC',
	)
);
?><!doctype html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link rel="profile" href="https://gmpg.org/xfn/11" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/common.css" />
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/common.js"></script>
		<?php if(is_front_page()): ?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/front.css" />
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/background-blur.min.js" defer></script>
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/front.js"></script>
		<?php endif; ?>
		<?php if(is_page('shopping')): ?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/shopping.css" />
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/shopping.js"></script>
		<?php endif; ?>
		<?php if(is_page('contact')): ?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/contact.css" />
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/contact.js"></script>
		<?php endif; ?>
		<?php if(is_page('login')): ?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/login.css" />
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/login.js"></script>
		<?php endif; ?>
		<?php if(is_page('register')): ?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/register.css" />
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/register.js"></script>
		<?php endif; ?>
		<?php if(is_page('complete')): ?>
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/complete.js"></script>
		<?php endif; ?>
		<?php if(is_404() || (is_post_type_archive('catalogue') && !is_tax('kind'))): ?>
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/404.js"></script>
		<?php endif; ?>
		<?php if(is_tax('kind')): ?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/colorbox.css" />
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/catalogue.css" />
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.colorbox.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/catalogue.js"></script>
		<?php endif; ?>
		<?php if(is_post_type_archive('blog')): ?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/blog_list.css" />
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/blog_list.js"></script>
		<?php endif; ?>
		<?php if(is_singular('blog')): ?>
		<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/blog_single.css" />
		<script src="<?php echo get_template_directory_uri(); ?>/assets/js/blog_single.js"></script>
		<?php endif; ?>
		<?php wp_head(); ?>
	</head>

	<body>
		<header<?php if(!is_front_page()): ?> class="cusotm_header"<?php endif; ?>>
			<nav class="header_nav">
				<ul class="nav_contents">
					<?php if(is_front_page()): ?>
					<li id="concept_nav" class="nav_content"><a class="nav_content_a">CONCEPT</a></li>
					<li id="shops_nav" class="nav_content"><a class="nav_content_a">SHOPS</a></li>
					<li id="blog_nav" class="nav_content"><a class="nav_content_a">BLOG</a></li>
					<li id="company_nav" class="nav_content"><a class="nav_content_a">COMPANY</a></li>
					<?php else: ?>
					<li id="home_nav" class="nav_content"><a class="nav_content_a" href="/">HOME</a></li>
					<li id="shops_nav" class="nav_content"><a class="nav_content_a" href="/shopping/">SHOPS</a></li>
					<li id="blog_nav" class="nav_content"><a class="nav_content_a" href="/blog/">BLOG</a></li>
					<?php endif; ?>
					<li id="catalog_nav" class="nav_content">
						<a>CATALOG</a>
						<ul class="catalog_list">
							<?php
								foreach($terms_kind as $term): 
							?>
								<li><a href="/catalogue/<?php echo $term->slug;?>"><?php echo $term->name; ?></a></li>
							<?php endforeach;?>
						</ul>
					</li>
					<li id="contact_nav" class="nav_content"><a class="nav_content_a" href="/contact/">CONTACT</a></li>
				</ul>
			</nav>
		</header>
		<img src="<?php echo get_theme_file_uri('/assets/img/bg_shop.jpg'); ?>" alt="" class="shops_bg">