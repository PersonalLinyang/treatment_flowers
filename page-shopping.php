<?php
$user = wp_get_current_user();
if(!$user->ID) {
	session_start();
	$_SESSION['redirect_from_shopping'] = true;
	header('Location: /login/');
	exit;
}

$terms_kind = get_terms( 'product_kind', 
	array(
		'hide_empty' => 0,
		'orderby' => 'id',
		'order' => 'ASC',
	)
);

get_header();
?>
		<div class="kind-area">
			<div class="kind-title">花の種別で探す</div>
			<ul class="kind-list">
				<?php 
				$first = true;
				foreach($terms_kind as $term): 
				?>
				<li class="kind-item <?php if($first){echo 'active';} ?>" data-slug="<?php echo $term->slug;?>"><span><?php echo $term->name; ?></span></li>
				<?php 
				$first = false;
				endforeach;
				?>
			</ul>
		</div>
		<div class="content-area">
			<div class="shopping-form-area">
				<form id="form-shopping">
					<h2>SHOPS</h2>
					<div class="shopping-form-content" data-step="1">
						<div class="catalogue-list">
							<?php 
							$first = true;
							foreach($terms_kind as $term): 
							?>
							<div class="catalogue-kind-list catalogue-list-<?php echo $term->slug;?> <?php if($first){echo 'active';} ?>">
								<?php 
								$catalogues = get_posts(
									array(
										'post_type'=>'product', 
										'post_status' => 'publish', 
										'posts_per_page' => -1, 
										'tax_query' => array(
											array(
												'taxonomy' => 'product_kind',
												'field' => 'id',
												'terms' => $term->term_id
											)
										)
									)
								);
								if(count($catalogues) > 0):
									foreach($catalogues as $catalogue):
								?>
								<div class="catalogue-item">
									<div class="catalogue-item-image">
										<img src="<?php echo get_the_post_thumbnail_url($catalogue->ID); ?>" />
									</div>
									<div class="catalogue-item-info-area">
										<div class="catalogue-item-info">
											<div class="catalogue-item-info-title">品種</div>
											<div><?php echo $catalogue->post_title; ?></div>
										</div>
										<div class="catalogue-item-info">
											<div class="catalogue-item-info-title">等級</div>
											<div><?php echo get_post_meta($catalogue->ID, 'level', true); ?></div>
										</div>
										<div class="catalogue-item-info">
											<div class="catalogue-item-info-title">産地</div>
											<div><?php echo get_post_meta($catalogue->ID, 'origin', true); ?></div>
										</div>
										<div class="catalogue-item-info">
											<div class="catalogue-item-info-title">色名称</div>
											<div><?php echo get_post_meta($catalogue->ID, 'color', true); ?></div>
										</div>
										<div class="catalogue-item-info">
											<div class="catalogue-item-info-title">価格</div>
											<div>1本<span class="catalogue-item-info-price"><?php echo get_post_meta($catalogue->ID, 'price', true); ?></span><span class="font-red">円</span></div>
										</div>
										<div class="catalogue-item-info">
											<div class="catalogue-item-info-title">販売ロット数</div>
											<div>
												<?php echo get_post_meta($catalogue->ID, 'rot', true); ?>本
												<input type="hidden" name="rot_<?php echo $catalogue->ID; ?>" id="rot_<?php echo $catalogue->ID; ?>" value="<?php echo get_post_meta($catalogue->ID, 'rot', true); ?>" />
											</div>
										</div>
										<div class="catalogue-item-number">
											購入数
											<input class="number-input number-num" type="number" name="num_<?php echo $catalogue->ID; ?>" id="num_<?php echo $catalogue->ID; ?>" value="0" min="0" step="1" />
										</div>
									</div>
								</div>
								<?php 
									endforeach; 
								else:
								?>
								<div class="content-text">購入できる商品がございません。<br/>他の種別をご覧ください。</div>
								<?php endif;?>
							</div>
							<?php 
							$first = false;
							endforeach;
							?>
						</div>
						<div class="information-list">
							<div class="form-line">
								<div class="form-title">お名前<span class="important-mark">*</span></div>
								<div class="form-input">
									<input type="text" name="name" placeholder="お名前" />
									<span class="error-message error-name"></span>
								</div>
							</div>
							<div class="form-line">
								<div class="form-title">郵便番号<span class="important-mark">*</span></div>
								<div class="form-input">
									<input type="text" name="zipcode" placeholder="郵便番号" />
									<span class="error-message error-zipcode"></span>
								</div>
							</div>
							<div class="form-line">
								<div class="form-title">住所<span class="important-mark">*</span></div>
								<div class="form-input">
									<input type="text" name="address" placeholder="住所" />
									<span class="error-message error-address"></span>
								</div>
							</div>
							<div class="form-line">
								<div class="form-title">電話番号<span class="important-mark">*</span></div>
								<div class="form-input">
									<input type="text" name="tel" placeholder="電話番号" />
									<span class="error-message error-tel"></span>
								</div>
							</div>
							<div class="form-line">
								<div class="form-title">FAX番号</div>
								<div class="form-input">
									<input type="text" name="fax" placeholder="FAX番号" />
									<span class="error-message error-fax"></span>
								</div>
							</div>
							<div class="form-line">
								<div class="form-title">メッセージ</div>
								<div class="form-input">
									<textarea name="remarks" placeholder="メッセージ"></textarea>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="cart-area">
			<div class="cart-title">買い物カゴ</div>
			<div class="cart-list"><div class="cart-empty">買い物カゴは空です。<br/>お好きな商品をお選びください。</div></div>
			<div class="price-area">
				<div class="price-title">合計</div>
				<div class="price-result">￥<span class="price-result-number">0</span></div>
			</div>
			<div class="button-controller btn-controller-step1 active">
				<a class="button-btn btn-next">次へ</a>
			</div>
			<div class="button-controller btn-controller-step2">
				<a class="button-btn btn-return">戻る</a>
				<a class="button-btn btn-send">送信</a>
			</div>
		</div>
		<div class="error_popup"></div>
<?php
get_footer();
