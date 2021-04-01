<?php
$terms_kind = get_terms( 'kind', 
	array(
		'hide_empty' => 0,
		'orderby' => 'id',
		'order' => 'ASC',
	)
);

$queried_object = get_queried_object();

$catalogues = get_posts(
	array(
		'post_type'=>'catalogue', 
		'post_status' => 'publish', 
		'posts_per_page' => -1, 
		'tax_query' => array(
			array(
				'taxonomy' => 'kind',
				'field' => 'id',
				'terms' => $queried_object->term_id
			)
		)
	)
);

get_header();
?>
		<div class="kind-area">
			<div class="kind-title">花の種別で探す</div>
			<ul class="kind-list">
				<?php 
				foreach($terms_kind as $term): 
					if($queried_object->term_id == $term->term_id):
				?>
				<li class="kind-item active" data-slug="<?php echo $term->slug;?>">
					<?php echo $term->name; ?>
				</li>
				<?php else: ?>
				<li class="kind-item" data-slug="<?php echo $term->slug;?>">
					<a href="/catalogue/<?php echo $term->slug;?>/"><?php echo $term->name; ?></a>
				</li>
				<?php 
					endif;
				endforeach;
				?>
			</ul>
		</div>
		<div class="content-area">
			<div class="catalogue-content-area">
				<h2>CATALOGUE</h2>
				<?php 
				if(count($catalogues)):
					foreach($catalogues as $catalogue): 
				?>
				<div class="catalogue-item">
					<div class="catalogue-item-image">
						<a class="catalogue-colorbox" href="<?php echo get_the_post_thumbnail_url($catalogue->ID); ?>">
							<img src="<?php echo get_the_post_thumbnail_url($catalogue->ID); ?>" />
						</a>
					</div>
					<div class="catalogue-item-info-area">
						<div class="catalogue-item-title"><?php echo $catalogue->post_title; ?></div>
					</div>
				</div>
				<?php 
					endforeach;
				else: 
				?>
				<div class="content-text"><?php echo $queried_object->name; ?>のお花はまだ登録されていません。<br/>別の種別のカタログをご覧ください。</div>
				<?php endif; ?>
			</div>
		</div>
<?php
get_footer();
