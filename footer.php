<?php
/*
 * フッタ部分
 */
$terms_kind = get_terms( 'kind', 
	array(
		'hide_empty' => 0,
		'orderby' => 'id',
		'order' => 'ASC',
	)
);
?>
		<footer>
			<div class="footer_img_container">
				<img src="<?php echo get_theme_file_uri('/assets/img/icon/icon.svg'); ?>" alt="" class="footer_logo_img" />
			</div>
			<div class="footer_text_container">
				<div class="footer_text">
					2021 THE TREAT FLOWERS.co
				</div>
			</div>
		</footer>
	<?php wp_footer(); ?>
	</body>
</html>
