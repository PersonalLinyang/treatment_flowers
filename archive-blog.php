<?php

$posts_per_page = get_option('posts_per_page');
$blogs = get_posts(
	array(
		'post_type'=>'blog', 
		'post_status' => 'publish', 
		'posts_per_page' => $posts_per_page, 
		'offset' => $paged * $posts_per_page,
	)
);

get_header();
?>
		<div class="content-area">
			<div class="blog-area">
				<h2>BLOG</h2>
			<?php if(count($blogs) > 0): ?>
				<div class="blog_contents">
					<ul class="blog_contents_list">
					<?php foreach($blogs as $index => $blog): ?>
						<li class="blog_content">
							<!-- ブログ画像と日付 -->
							<div class="blog_content_img_container">
								<!-- ブログ画像 -->
								<img class="blog_content_img" src="<?php echo get_the_post_thumbnail_url($blog->ID); ?>">
								<!-- ブログ日付 -->
								<div class="blog_content_date">
									<?php echo sprintf('%02d', $index + $posts_per_page * $paged) ?>
									<div class="blog_content_date_line"></div>
									<?php echo date('Y年n月j日', strtotime($blog->post_date)); ?>
								</div>
							</div>
							<!-- ブログタイトル -->
							<div class="blog_content_title">
								<a href="/blog/<?php echo $blog->ID; ?>/"<?php if(mb_strlen($blog->post_title) > 14): ?> title="<?php echo $blog->post_title;?>"<?php endif;?>>
									<?php 
									if(mb_strlen($blog->post_title) > 14) {
										echo mb_substr($blog->post_title, 0, 13).'...'; 
									} else {
										echo $blog->post_title; 
									}
									?>
								</a>
							</div>
							<!-- ブログ記事の内容 -->
							<div class="blog_content_detail">
								<?php 
								if(mb_strlen(strip_shortcodes($blog->post_content)) > 48) {
								echo mb_substr(strip_shortcodes($blog->post_content), 0, 46).'...'; 
								} else {
								echo strip_shortcodes($blog->post_content); 
								}
								?>
							</div>
						</li>
					<?php endforeach; ?>
					</ul>
				</div>
 				<?php pagenation('blog', $posts_per_page, $paged);?>
			<?php else: ?>
				<div class="content-text">申し訳ございません。<br/>現在ブログはまだ投稿されておりません。</div>
			<?php endif; ?>
			</div>
		</div>
<?php
get_footer();
