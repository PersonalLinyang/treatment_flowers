<?php
$parent_id = $post->post_parent;
$parent_slug = get_post($parent_id)->post_name;
get_header();
?>
		<div class="content-area">
			<div class="complete-content-area">
			<?php if($parent_slug == 'shopping'): ?>
				<h2>SHOPS</h2>
				<div class="content-text">
					お買い上げいただきありがとうございます。<br/>
					ご注文は完了致しました。<br/>
					詳細内容はメールでお送りしております。<br/>
					弊社からの連絡をお待ちください。
				</div>
				<div class="content-text"><a href="/shopping/" class="content-link">買い物を続ける</a></div>
			<?php elseif($parent_slug == 'contact'): ?>
				<h2>CONTACT</h2>
				<div class="content-text">お問い合わせ完了しました。<br/>確認用のメールを送信いたしました。<br/>弊社からの連絡をお待ちください。</div>
				<div class="content-text"><a href="/contact/" class="content-link">別の内容をお問い合わせする</a></div>
			<?php endif; ?>
			</div>
		</div>
<?php
get_footer();
