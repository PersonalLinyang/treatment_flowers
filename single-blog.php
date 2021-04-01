<?php
$prev_post = get_previous_post();
$next_post = get_next_post();

get_header();
?>

		<div class="content-area">
			<?php 
			if(have_posts()): 
				while(have_posts()):
					the_post(); 
			?>
			<h2><?php the_title(); ?></h2>

			<time class="time_blog" datetime="<?php the_time('Y-m-d'); ?>"><?php the_time('Y年m月d日'); ?></time>
			<div class="blog-image"><?php the_post_thumbnail('full'); ?></div>
			<div class="blog-content"><?php the_content(); ?></div>

			<?php 
				endwhile; 
			endif; 
			?>

			<div class="button-controller">
				<?php if($prev_post): ?>
				<a href="/blog/<?php echo $prev_post->ID; ?>/"<?php if(mb_strlen($prev_post->post_title) > 14): ?> title="<?php echo $prev_post->post_title;?>"<?php endif;?>>
					<div class="button-btn blog-link-prev">
						<div>前の記事</div>
						<div>
							<?php 
							if(mb_strlen($prev_post->post_title) > 14) {
								echo mb_substr($prev_post->post_title, 0, 13).'...'; 
							} else {
								echo $prev_post->post_title; 
							}
							?>
						</div>
					</div>
				</a>
				<?php endif; ?>
				<?php if($next_post): ?>
				<a href="/blog/<?php echo $next_post->ID; ?>/"<?php if(mb_strlen($next_post->post_title) > 14): ?> title="<?php echo $next_post->post_title;?>"<?php endif;?>>
					<div class="button-btn blog-link-next">
						<div>次の記事</div>
						<div>
							<?php 
							if(mb_strlen($next_post->post_title) > 14) {
								echo mb_substr($next_post->post_title, 0, 13).'...'; 
							} else {
								echo $next_post->post_title; 
							}
							?>
						</div>
					</div>
				</a>
				<?php endif; ?>
			</div>
		</div>

<?php
get_footer();
