<?php
$catalogues = get_posts(
	array(
		'post_type'=>'product', 
		'post_status' => 'publish', 
		'posts_per_page' => 6, 
		'meta_query' => array(
			array(
				'key' => 'quantity', 
				'value' => '0',
				'compare' => '>',
			),
		),
	)
);

$blogs = get_posts(
	array(
		'post_type'=>'blog', 
		'post_status' => 'publish', 
		'posts_per_page' => 6, 
	)
);

get_header();
?>

<div id="loading_container" class="loading_container">
  <img src="<?php echo get_theme_file_uri('/assets/img/logo.svg'); ?>" alt="" class="logo">
  <img src="<?php echo get_theme_file_uri('/assets/img/logo_text.svg'); ?>" alt="" class="logo_text">
  <img src="<?php echo get_theme_file_uri('/assets/img/bg_shop.jpg'); ?>" alt="" class="loading_bg">
</div>

<!-- SNSナビゲーション 開始 -->
<ul class="sns_nav">
  <li class="sns_icon">
    <a href="">
			<img src="<?php echo get_theme_file_uri('/assets/img/icon/facebook.svg'); ?>" alt="" class="white_icon">
			<img src="<?php echo get_theme_file_uri('/assets/img/icon/facebook_black.svg'); ?>" alt="" class="black_icon" style="display: none;">
		</a>
  </li>
  <li class="sns_icon">
    <a href="">
			<img src="<?php echo get_theme_file_uri('/assets/img/icon/instagram.svg'); ?>" alt="" class="white_icon">
			<img src="<?php echo get_theme_file_uri('/assets/img/icon/instagram_black.svg'); ?>" alt="" class="black_icon" style="display: none;">
		</a>
  </li>
</ul> 
<!-- SNSナビゲーション終了 -->

<div class="cover"></div>

<div class="main_container">
  <!-- ファーストビュー開始 -->
  <div class="first_view_container video_wrapper">
    <img src="<?php echo get_theme_file_uri('/assets/img/bg_flower.jpg'); ?>" alt="" style="width: 100vw; height: 100vh;">
    <div class="filter"></div>
    <div class="logos">
      <img src="<?php echo get_theme_file_uri('/assets/img/icon/logo_white.svg'); ?>" class="logo_white" alt="">
      <img src="<?php echo get_theme_file_uri('/assets/img/icon/logo_text_white.svg'); ?>" class="logo_white_text" alt="">
    </div>
  </div>


<!-- コンセプト -->
<div class="concept_container">
  <!-- PROLOGUE -->
  <div class="concept_detail_wrapper_1">
    <div class="concept_detail">
      <div class="concept_detail_title">PROLOGUE</div>
      <div class="concept_detail_text">
        <p>
          2019年11月11日、私たちはTHE TREAT FLOWERSという<br>
          切花を取扱う組織としてスタート致しました。
        </p>
        <p>
          THE TREAT FLOWERSという名前には<br>
          “おもてなしのお花”という意味合いが込められています。
        </p>
        <p>
          人生の様々な節目を彩るお花であるからこそ<br>
          特別な瞬間にふさわしい“本物のお花”を飾って欲しい。
        </p>
        <p>
          世界中の様々な産地のお花を一つひとつ丁寧に<br>
          私たち自身の目で確認し、<br>
          真心を込めて育てられたお花だけを集めました。
        </p>
        <p>
          「大切な人の大切な瞬間を彩るな人の大切な瞬間を彩るお花だからこそ、 <br>
          最高のお花で飾るお手伝いがしたい」
        </p>
        <p>すべてはこの想いから始まりました</p>
      </div>
    </div>
  </div>
  <!-- THE WORLD OF TREAT -->
  <div class="concept_detail_wrapper_2">
    <div class="concept_detail">
      <div class="concept_detail_title">THE WORLD OF TREAT</div>
      <div class="concept_detail_text">
        <p>
          大切な人に、自信をもっておすすめ出来るお花だけを集めた<br>
          フラワーカンパニーをつくりたい。
        </p>
        <p>
          世界中を巡り、生産者を訪ね、一本一本お花を<br>
          選んでいくことから私たちはスタートしました。<br>
          お花は正直です。
        </p>
        <p>
          同じお花であれど作り手の心が花にはっきりと現れます。<br>
          そんな真心込めて育てられたお花だけを見出しお届けする。<br>
          一本一本のお花は、言い換えるならば「真心のバトン」
        </p>
        <p>
          大切にしたのは、私たちが心から愛せる<br>
          「真心のバトン」を持つ本物かどうかということです。</p>
        <p>
          生産者様からスタートする真心のバトンが、表現者様を経て大切な方の元へ。
        </p>
        <p>
          私たちも、そんな真心のバトンを持つリレーの走者でありたい。
        </p>
      </div>
    </div>
  </div>
</div>
<!-- ファーストビュー終了 -->

<!-- SHOPS開始 -->
<div class="shop_container">
  <div class="shop_header">
    <img class="shop_header_img" src="<?php echo get_theme_file_uri('/assets/img/icon/shops.svg'); ?>"></img>
  </div>
  <!-- 商品リスト -->
  <div class="shop_contents">
    <ul class="shop_contents_list">
      <!-- 商品詳細 -->
      <?php if(count($catalogues) > 0): ?>
        <?php foreach($catalogues as $catalogue): ?>

          <li class="shop_content">
            <img src="<?php echo get_the_post_thumbnail_url($catalogue->ID); ?>" alt="" class="shop_content_img" />
            <div class="shop_content_name"><?php echo $catalogue->post_title; ?></div>
            <div class="shop_content_price">¥<?php echo get_post_meta($catalogue->ID, 'price', true); ?></div>
          </li>

        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
  </div>
  <!-- viewmoreボタン -->
  <div class="btn_container">
    <a href="/shopping/" class="btn_viewmore">View More</a>
  </div>
</div>
<!-- SHOPS終了 -->

<!-- BLOG開始 -->
<div class="blog_container">
  <div class="blog_header">
    <img src="<?php echo get_theme_file_uri('/assets/img/icon/blog.svg'); ?>" alt="" class="blog_header_img">
  </div>
  <?php if(count($blogs) > 0): ?>
    <div class="blog_contents">
      <ul class="blog_contents_list">
        <?php foreach($blogs as $index => $blog): ?>
          <!-- ブログ記事 1-->
          <li class="blog_content">
            <!-- ブログ画像と日付 -->
            <div class="blog_content_img_container">
              <!-- ブログ画像 -->
              <img class="blog_content_img" src="<?php echo get_the_post_thumbnail_url($blog->ID); ?>">
              <!-- ブログ日付 -->
              <div class="blog_content_date">
                <?php echo sprintf('%02d', $index) ?>
                <div class="blog_content_date_line"></div>
                <?php echo date('Y年n月j日', strtotime($blog->post_date)); ?>
              </div>
            </div>
            <!-- ブログタイトル -->
            <div class="blog_content_title">
              <?php 
              if(mb_strlen($blog->post_title) > 14) {
                echo mb_substr($blog->post_title, 0, 13).'...'; 
              } else {
                echo $blog->post_title; 
              }
              ?>
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
    <!-- viewmoreボタン -->
    <div class="btn_container">
      <a href="/blog/" class="btn_viewmore">View More</a>
    </div>
  <?php else: ?>
    <div class="no_blog">申し訳ございません。<br/>現在ブログはまだ投稿されておりません。</div>
  <?php endif; ?>
</div>
<!-- BLOG終了 -->

<!-- 自己紹介 -->
<div class="profile_container">
  <h3 class="title">代表からのメッセージ</h3>
  <div class="profile_content_container">
    <div class="profile_detail_container">
      <p class="profile_text">私達が過ごす毎日の日常は勿論、<br>
        人生の様々なシーンを彩る為に不可欠なお花。<br>
        贈り物や冠婚葬祭など、大切な「誰か」の為に、贈り主様の思いをカタチにすべく努力を重ねる作り手の皆様。<br>
        こうした「真心のバトンの一走者」として弊社がお役立ちさせて頂く限りは、生産者様の体温が感じられるようなお花を取り扱いたい。<br>
        こうした思いから、2019年に小さなお店からスタートし、お陰様で現在は切花輸入商社として多くの志を共にするフラワービジネスに携わる方々と良い関係性を保ちつつ、国内市場においても切花仲卸業を担わせて頂いております。<br>
        お花が役立つ場面は多々あれど、最終的なゴールは「お花をお受け取りになられた方やご覧になった方の心に彩りを与えるため」と言えるのではないでしょうか。<br>
        弊社TREATの社名の単語は直訳すると「取り扱う」ですとか「整える」ですが、私は「おもてなし」の意味を込めました。<br>
        日本が世界に誇るおもてなしの心を大切に、<br>
        役割の違いはあれど、共に同じ共通のゴールを目指し、より多くの皆様と共に手と手を取り合って前進して参りたいと存じます。</p>
      <p class="profile_text profile_name">株式会社TREAT  代表取締役社長　中本吉保</p>
      <img src="<?php echo get_theme_file_uri('/assets/img/sign.png'); ?>" alt="" class="sign_img">
    </div>
    <img src="<?php echo get_theme_file_uri('/assets/img/profile.jpg'); ?>" alt="" class="profile_img">
  </div>
</div>

<!-- company開始 -->
<div class="company_container">
  <div class="company_contents">
    <img src="<?php echo get_theme_file_uri('/assets/img/icon/company_text2.svg'); ?>" alt="" class="company_head">
    <img src="<?php echo get_theme_file_uri('/assets/img/icon/company_text.svg'); ?>" alt="" class="company_head_sp">
    <img src="<?php echo get_theme_file_uri('/assets/img/icon/company.png'); ?>" alt="" class="company_contents_img">
    <div class="company_detail_container">
      <img src="<?php echo get_theme_file_uri('/assets/img/logo_text.svg'); ?>" alt="" class="company_name_logo">
      <ul class="company_detail_container_text">
        <li class="item_container">
        <span class="item">称号</span>
        <span class="item_detail">THE TREAT FLOWERS</span>
        </li>
        <li class="item_container">
          <span class="item">設立</span>
          <span class="item_detail">1983年</span>
        </li>
        <li class="item_container">
          <span class="item">住所</span>
          <span class="item_detail">
            <p>本社 : 和歌山県東牟婁郡那智勝浦浜ノ宮862-22</p>
            <p>支社 : 広島県広島市南区宇品西5-12-2-1403</p>
          </span>
        </li>
        <li class="item_container">
          <span class="item">電話</span>
          <span class="item_detail">
            <p>本社 : 0735-52-0006</p>
            <p>支社 : 082-298-1885</p>
          </span>
        </li>
        <li class="item_container">
          <span class="item">FAX</span>
          <span class="item_detail">
            0735-52-4748
          </span>
        </li>
        <li class="item_container">
          <span class="item">役員</span>
          <span class="item_detail">
            <p>代表取締役社長 中本 吉保</p>
            <p>取締役副社長 真部 陽子</p>
            <p>広島支社支店長 中山 麻衣</p>
          </span>
        </li>
      </ul>
    </div>
  </div>
</div>
<!-- company終了 -->

<?php

get_footer();
