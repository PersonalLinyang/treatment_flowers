<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once("assets/PHPMailer-master/src/Exception.php");
require_once("assets/PHPMailer-master/src/PHPMailer.php");
require_once("assets/PHPMailer-master/src/SMTP.php");

/*
 * カタログカスタム投稿タイプと関連タクソノミー追加
 */
function create_catalogue_type() {
	// 記事タイプ「カタログ」追加
	register_post_type('catalogue',
		array(
			'label' => 'カタログ',
			'public' => true,
			'has_archive' => true,
			'menu_position' => 7, 
			'supports' => [
				'title',
				'editor',
				'thumbnail',
				'custom-fields',
			]
		)
	);

	// タクソノミー「品種」追加
	register_taxonomy( 
		'kind',
		array('catalogue'),
		array(
//			'hierarchical' => true, //親子関係を設定
			'labels' => array(
				'name' => '品種',
				'edit_item' => '編集',
				'update_item' => '更新',
				'add_new_item' => '新規品種を追加'
			),
		) 
	);
}
add_action('init', 'create_catalogue_type');

/*
 * 商品投稿タイプと関連タクソノミー追加
 */
function create_product_type() {
	// 記事タイプ「商品」追加
	register_post_type('product',
		array(
			'label' => '商品',
			'public' => true,
			'has_archive' => true,
			'menu_position' => 8, 
			'supports' => [
				'title',
				'editor',
				'thumbnail',
				'custom-fields',
			]
		)
	);

	// タクソノミー「品種」追加
	register_taxonomy( 
		'product_kind',
		array('product'),
		array(
			'labels' => array(
				'name' => '品種',
				'edit_item' => '編集',
				'update_item' => '更新',
				'add_new_item' => '新規品種を追加'
			),
		) 
	);
}
add_action('init', 'create_product_type');

/*
 * ブログカスタム投稿タイプ追加
 */
function create_blog_type() {
	// 記事タイプ「カタログ」追加
	register_post_type('blog',
		array(
			'label' => 'ブログ',
			'public' => true,
			'has_archive' => true,
			'menu_position' => 9, 
			'supports' => [
				'title',
				'editor',
				'thumbnail',
				'revisions',
			]
		)
	);
}
add_action('init', 'create_blog_type');

/*
 * 管理画面にサムネイルの設定を入れる
 */
add_theme_support('post-thumbnails');

/*
 * リライトルール設定
 */
function custom_rewrite_basic(){
	// カタログ一覧ページ
	add_rewrite_rule('catalogue/(.+)/?$', 'index.php?kind=$matches[1]', 'top');
	// ブログ一覧ページ
	add_rewrite_rule('blog/page/(\d+)/?$', 'index.php?post_type=blog&paged=$matches[2]', 'top');
	// ブログ一覧ページ
	add_rewrite_rule('blog/(\d+)/?$', 'index.php?post_type=blog&p=$matches[1]', 'top');
}
add_action('init', 'custom_rewrite_basic');

/*
 * 省略URLから自動リダイレクト禁止
 */
function disable_redirect_canonical( $redirect_url )
{
    if ( is_404() ) {
        return false;
    }
}
add_filter("redirect_canonical", "disable_redirect_canonical");

/*
 * Wordpressヘッダアドミンバーを表示しない
 */
add_filter('show_admin_bar', '__return_false');

/*
 * ページャーメーション
 */
function pagenation($post_type='', $post_num_per_page=20, $paged=0){
	$count_posts = wp_count_posts($post_type);
	$published_posts = $count_posts->publish;
	$pages = ceil($published_posts / $post_num_per_page);
	
	if(1 != $pages){
		echo '<div class="pagenation-area"><ul class="pagenation-list">';
		if($paged > 0) {
			echo '<li class="pagenation-item pagenation-btn"><a href="/blog/page/' . strval($paged - 1) . '/""><</a></li>';
			echo '<li class="pagenation-item pagenation-btn"><a href="/blog/">1</a></li>';
		}
		if($paged > 3) {
			echo '<li class="pagenation-item">...</li>';
		}
		for($i = $paged - 2; $i < $paged; $i++) {
			if($i > 0) {
				echo '<li class="pagenation-item pagenation-btn"><a href="/blog/page/' . $i . '/"">' . strval($i + 1) . '</a></li>';
			}
		}
		echo '<li class="pagenation-item pagenation-btn active">' . strval($paged + 1) . '</li>';
		for($i = $paged + 1; $i < $paged + 3; $i++) {
			if($i < $pages - 1) {
				echo '<li class="pagenation-item pagenation-btn"><a href="/blog/page/' . $i . '/"">' . strval($i + 1) . '</a></li>';
			}
		}
		if($paged < $pages - 4) {
			echo '<li class="pagenation-item">...</li>';
		}
		if($paged < ($pages - 1)) {
			echo '<li class="pagenation-item pagenation-btn"><a href="/blog/page/' . strval($pages - 1) . '/">' . strval($pages) . '</a></li>';
			echo '<li class="pagenation-item pagenation-btn"><a href="/blog/page/' . strval($paged + 1) . '/"">></a></li>';
		}
		echo '</ul></div>';
	}
}

/*
 * Ajax送信先URL設定
 */
function add_my_ajaxurl() {
?>
	<script>
		var ajaxurl = '<?php echo admin_url( 'admin-ajax.php'); ?>';
	</script>
<?php
}
add_action( 'wp_head', 'add_my_ajaxurl', 1 );

/*
 * ログインAjax処理
 */
function func_login(){
	$result = true;
	$error_list = array();

	// バリデーション
	if($_POST['user_login'] == '') {
		$result = false;
		$error_list['user_login'] = 'ユーザー名を入力してください';
	} else if(!get_user_by('login', $_POST['user_login'])) {
		$result = false;
		$error_list['user_login'] = 'ユーザー名が登録されていません';
	}
	if($_POST['user_pass'] == '') {
		$result = false;
		$error_list['user_pass'] = 'パスワードを入力してください';
	}
	
	// ログイン
	if($result) {
		$creds = array();
		$creds['user_login'] = $_POST['user_login'];
		$creds['user_password'] = $_POST['user_pass'];
		$creds['remember'] = true;
		$user = wp_signon($creds, true);
		if(is_wp_error($user)) {
			$result = false;
			$error_list['user_pass'] = 'パスワードが間違っています';
		}
	}
	
	// ログイン後リダイレクト先を取得
	session_start();
	if($_SESSION['login_redirect']) {
		$redirct_to = $_SESSION['login_redirect'];
	} else {
		$redirct_to = '/';
	}
	
	// リポジトリ出力
	$response = array(
		'result' => $result,
		'redirect_to' => $redirct_to,
		'errors' => $error_list,
	);
	echo json_encode($response);
	die();
}
add_action('wp_ajax_login', 'func_login');
add_action('wp_ajax_nopriv_login', 'func_login');

/*
 * 会員登録Ajax処理
 */
function func_register(){
	$result = true;
	$error_list = array();

	if($_POST['user_login'] == '') {
		$result = false;
		$error_list['user_login'] = 'ユーザー名を入力してください。';
	} else if(mb_strlen($_POST['user_login']) > 60) {
		$result = false;
		$error_list['user_login'] = 'ユーザー名は60文字を超えられません。';
	} else if(!preg_match("/^[a-zA-Z0-9-_@]+$/", $_POST['user_login'])) {
		$result = false;
		$error_list['user_login'] = 'このユーザー名は使用できない文字を含んでいます。';
	} else if(get_user_by('login', $_POST['user_login'])) {
		$result = false;
		$error_list['user_login'] = 'このユーザー名はすでに登録されています。';
	}

	if($_POST['user_email'] == '') {
		$result = false;
		$error_list['user_email'] = 'メールアドレスを入力してください。';
	} else if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['user_email'])) {
		$result = false;
		$error_list['user_email'] = 'メールアドレスが不正です。';
	} else if(get_user_by('login', $_POST['user_login'])) {
		$result = false;
		$error_list['user_email'] = 'このメールアドレスはすでに登録されています。';
	}

	if($_POST['user_pass'] == '') {
		$result = false;
		$error_list['user_pass'] = 'パスワードを入力してください。';
	} else if(!preg_match("/^[a-zA-Z0-9!#\$%&'()\*\+-\.\/:;<=>\?@\[\]\^_`{|}~]+$/", $_POST['user_pass'])) {
		$result = false;
		$error_list['user_pass'] = 'このユーザー名は使用できない文字を含んでいます。';
	}
	
	if($result) {
		wp_insert_user(array(
			'user_login' => $_POST['user_login'],
			'user_pass' => $_POST['user_pass'],
			'user_email' => $_POST['user_email'],
			'first_name' => $_POST['first_name'],
			'last_name' => $_POST['last_name'],
			'display_name' => $_POST['last_name'] . ' ' . $_POST['first_name'],
			'show_admin_bar_front' => 'false',
			'role' => 'subscriber',
		));
		$creds = array();
		$creds['user_login'] = $_POST['user_login'];
		$creds['user_password'] = $_POST['user_pass'];
		$creds['remember'] = true;
		
		wp_signon($creds, true);
	}
	
	// ログイン後リダイレクト先を取得
	session_start();
	if($_SESSION['login_redirect']) {
		$redirct_to = $_SESSION['login_redirect'];
	} else {
		$redirct_to = '/';
	}
	
	$response = array(
		'result' => $result,
		'redirect_to' => $redirct_to,
		'errors' => $error_list,
	);
	echo json_encode($response);

	die();
}
add_action('wp_ajax_register', 'func_register');
add_action('wp_ajax_nopriv_register', 'func_register');

/*
 * お問い合わせAjax処理
 */
function func_contact(){
	$result = true;
	$error_list = array();
	$email_admin = 'postmaster@treatflowers.sakura.ne.jp';
	$email_shop = 'personal.yanglin@gmail.com';

	if($_POST['name'] == '') {
		$result = false;
		$error_list['name'] = '名前を入力してください。';
	}

	if($_POST['zipcode'] == '') {
		$result = false;
		$error_list['zipcode'] = '郵便番号を入力してください。';
	} else if(!preg_match("/^\d{3}-?\d{4}$/", $_POST['zipcode'])) {
		$result = false;
		$error_list['zipcode'] = '郵便番号が不正です。';
	}

	if($_POST['address'] == '') {
		$result = false;
		$error_list['address'] = '住所を入力してください。';
	}

	if($_POST['tel'] == '') {
		$result = false;
		$error_list['tel'] = '電話番号を入力してください。';
	} else if(!preg_match("/^0\d{2,3}-?\d{1,4}-?\d{4}$/", $_POST['tel'])) {
		$result = false;
		$error_list['tel'] = '電話番号が不正です。';
	}

	if($_POST['email'] == '') {
		$result = false;
		$error_list['email'] = 'メールアドレスを入力してください。';
	} else if(!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['email'])) {
		$result = false;
		$error_list['email'] = 'メールアドレスが不正です。';
	}
	
	if($result) {
		$body = $_POST['name'] . '様より<br/>';
		$body .= '下記の通りお問合せを頂きました。<br/>';
		$body .= '土曜、日曜、祝祭日を除き1営業日以内にご回答させて頂きます。<br/>';
		$body .= 'また、お急ぎの場合にはLINEの弊社公式アカウントからもお問い合わせ頂くことが可能です。<br/><br/>';
		$body .= '----------------------------------<br/>';
		$body .= 'お名前：' . $_POST['name'] . '<br/>';
		$body .= '携帯番号：' . $_POST['tel'] . '<br/>';
		$body .= '郵便番号：' . $_POST['zipcode'] . '<br/>';
		$body .= '住所：' . $_POST['address'] . '<br/>';
		$body .= 'メール:' . $_POST['email'] . '<br/>';
		$body .= 'お問合せ内容：' . $_POST['message'] . '<br/><br/>';
		$body .= '----------------------------------<br/>';
		$body .= 'THE TREAT FLOWERS sales@treatflowers.com<br/>';
		
		// 顧客へメール送信
		$mailer_customer = new PHPMailer(true);
		$mailer_customer->CharSet = 'UTF-8';
		$mailer_customer->setFrom($email_admin, mb_encode_mimeheader('THE TREAT FLOWERSオンラインショップ'));
		$mailer_customer->addAddress($_POST['email']);
		$mailer_customer->isHTML(true);
		$mailer_customer->Subject = '【THE TREAT FLOWERSネット卸販売】 お問い合わせありがとうございます';
		$mailer_customer->Body = $body;
		$mailer_customer->send();
		
		// お店へメール送信
		$mailer_shop = new PHPMailer(true);
		$mailer_shop->CharSet = 'UTF-8';
		$mailer_shop->setFrom($email_admin, mb_encode_mimeheader('THE TREAT FLOWERSオンラインショップ'));
		$mailer_shop->addAddress($email_shop);
		$mailer_shop->isHTML(true);
		$mailer_shop->Subject = '【THE TREAT FLOWERSネット卸販売】 お問い合わせありがとうございます';
		$mailer_shop->Body = $body;
		$mailer_shop->send();
	}
	
	$response = array(
		'result' => $result,
		'errors' => $error_list,
	);
	echo json_encode($response);

	// dieしておかないと末尾に余計なデータ「0」が付与されるので注意
	die();
}
add_action('wp_ajax_contact', 'func_contact');
add_action('wp_ajax_nopriv_contact', 'func_contact');

/*
 * ショッピングAjax処理
 */
function func_shopping(){
	$result = true;
	$cart_list = array();
	$error_list = array();
	$popup = '';
	$email_admin = 'postmaster@treatflowers.sakura.ne.jp';
	$email_shop = 'personal.yanglin@gmail.com';

	if($_POST['name'] == '') {
		$result = false;
		$error_list['name'] = 'お名前を入力してください。';
	}

	if($_POST['zipcode'] == '') {
		$result = false;
		$error_list['zipcode'] = '郵便番号を入力してください。';
	} else if(!preg_match("/^\d{3}-?\d{4}$/", $_POST['zipcode'])) {
		$result = false;
		$error_list['zipcode'] = '郵便番号が不正です。';
	}

	if($_POST['address'] == '') {
		$result = false;
		$error_list['address'] = '住所を入力してください。';
	}

	if($_POST['tel'] == '') {
		$result = false;
		$error_list['tel'] = '電話番号を入力してください。';
	} else if(!preg_match("/^0\d{2,3}-?\d{1,4}-?\d{4}$/", $_POST['tel'])) {
		$result = false;
		$error_list['tel'] = '電話番号が不正です。';
	}

	if($_POST['fax'] != '' && !preg_match("/^0\d{2,3}-?\d{1,4}-?\d{4}$/", $_POST['fax'])) {
		$result = false;
		$error_list['fax'] = 'FAX番号が不正です。';
	}
	
	$quantity_error_flag = false;
	foreach($_POST as $key => $value) {
		if(strpos($key, 'num_') !== false) {
			$catalogue_id = str_replace('num_', '', $key);
			if(preg_match('/^[0-9]+$/', $_POST[$key]) && preg_match('/^[0-9]+$/', $catalogue_id)) {
				$key_rot = 'rot_' . $catalogue_id;
				if(array_key_exists($key_rot, $_POST)) {
					if(preg_match('/^[0-9]+$/', $_POST[$key_rot])) {
						$num_val = intval($_POST[$key]);
						$rot_val = intval($_POST[$key_rot]);
						if($num_val > 0 && $rot_val > 0) {
							$catalogue = get_post(intval($catalogue_id));
							if($catalogue) {
								$price = get_post_meta($catalogue->ID, 'price', true);
								$quantity = intval(get_post_meta($catalogue->ID, 'quantity', true));
								$a = $num_val * $rot_val;
								if(($num_val * $rot_val) > $quantity) {
									$quantity_error_flag = true;
									break;
								}
								$cart = array(
									'id' => $catalogue->ID,
									'code' => get_post_meta($catalogue->ID, 'code', true),
									'name' => $catalogue->post_title,
									'quantity' => $quantity,
									'num' => $num_val,
									'rot' => $rot_val,
									'price' => intval($price)
								);
								array_push($cart_list, $cart);
							}
						}
					}
				}
			}
		}
	}
	
	if($quantity_error_flag) {
		$result = false;
		$popup = '買いたいお花の数は在庫数を超えています、最新の在庫数を確認してから、再度注文してお願い致します';
	} elseif(count($cart_list) == 0) {
		$result = false;
		$popup = '買いたいお花の数を選んでください';
	}
	
	if($result) {
		$user = wp_get_current_user();
		$body_data = '';
		$price_total = 0;
		foreach($cart_list as $cart) {
			$price_sub_total = $cart['rot'] * $cart['num'] * $cart['price'];
			$price_total += $price_sub_total + ceil($price_sub_total * 0.1);
		}
		
		// メール内容作成
		$body = '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br/><br/>';
		$body .= 'THE TREATFLOWERS　オンラインショップ　　　　ご注文の確認のおしらせ<br/><br/>';
		$body .= '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br/><br/>';
		$body .= 'この度はご注文いただき誠にありがとうございます。<br/>';
		$body .= '下記ご注文内容にお間違えがないかご確認下さい。<br/>';
		$body .= '納期等につきましては、改めて担当者よりご連絡させて頂きます。<br/><br/>';
		$body .= '************************************************<br/>';
		$body .= '　ご請求金額<br/>';
		$body .= '************************************************<br/><br/>';
		$body .= 'ご注文番号：' . uniqid() . '<br/>';
		$body .= 'お支払い合計:￥' . $price_total . '<br/>';
		$body .= 'メッセージ：<br/>' . nl2br($_POST['remarks']) . '<br/><br/>';
		$body .= '************************************************<br/>';
		$body .= '　ご注文商品明細<br/>';
		$body .= '************************************************<br/>';
		foreach($cart_list as $cart) {
			$price_sub_total = $cart['rot'] * $cart['num'] * $cart['price'];
			$body .= '<br/>商品コード: ' . $cart['code'] . '<br/>';
			$body .= '商品名: ' . $cart['name'] . '<br/>';
			$body .= '単価：' . $cart['price'] . '<br/>';
			$body .= '数量：' . $cart['rot'] . 'ロット×' . $cart['num'] . '本<br/>';
			$body .= '-------------------------------------------------<br/>';
			$body .= '小　計 ￥' . $price_sub_total . '<br/>';
			$body .= '(消費税 ￥' . ceil($price_sub_total * 0.1) . ')<br/>';
		}
		$body .= '============================================<br/>';
		$body .= '合　計 ￥' . $price_total . '<br/><br/>';
		$body .= '※ 送料につきましては、別途ご請求させて頂きます。<br/><br/>';
		$body .= '※※※ ご注意ください ※※※<br/>';
		$body .= 'ネット販売の商品に関しましては、<br/>';
		$body .= '店頭販売も行っているため、ご注文いただいた品が完売している場合がございます。<br/>';
		$body .= '完売している場合は、追って担当者からご連絡いたしますがあらかじめご了承ください。<br/><br/>';
		$body .= '************************************************<br/>';
		$body .= '　ご注文者情報<br/>';
		$body .= '************************************************<br/>';
		$body .= '　お名前　：' . $_POST['name'] . '様<br/>';
		$body .= '　郵便番号：〒' . $_POST['zipcode'] . '<br/>';
		$body .= '　住所　　：' . $_POST['address'] . '<br/>';
		$body .= '　電話番号：' . $_POST['tel'] . '<br/>';
		$body .= '　FAX番号 ：' . $_POST['fax'] . '<br/>';
		$body .= '　メールアドレス：' . $user->user_email . '<br/><br/>';
		$body .= 'ご質問やご不明な点がございましたら、<br/>';
		$body .= 'お気軽に下記までお問い合わせくださいませ。<br/><br/>';
		$body .= '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br/>';
		$body .= '■ ご注文内容、その他お問い合わせ先<br/>';
		$body .= '━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br/><br/>';
		$body .= '　THE TREAT FLOWERSオンラインショップ<br/><br/>';
		$body .= '　〒649-5314　和歌山県東牟婁郡那智勝浦町浜ノ宮862-22<br/>';
		$body .= '　TEL:0735-52-0006　　FAX:0735-52-4748<br/><br/>';
		$body .= 'ご連絡はホームページのお問合せフォームをご利用ください。';
		
		// 顧客へメール送信
		$mailer_customer = new PHPMailer(true);
		$mailer_customer->CharSet = 'UTF-8';
		$mailer_customer->setFrom($email_admin, mb_encode_mimeheader('THE TREAT FLOWERSオンラインショップ'));
		$mailer_customer->addAddress($user->user_email);
		$mailer_customer->isHTML(true);
		$mailer_customer->Subject = '【THE TREAT FLOWERSネット卸販売】 ご注文ありがとうございます';
		$mailer_customer->Body = $body;
		$mailer_customer->send();
		
		// お店へメール送信
		$mailer_shop = new PHPMailer(true);
		$mailer_shop->CharSet = 'UTF-8';
		$mailer_shop->setFrom($email_admin, mb_encode_mimeheader('THE TREAT FLOWERSオンラインショップ'));
		$mailer_shop->addAddress($email_shop);
		$mailer_shop->isHTML(true);
		$mailer_shop->Subject = '【THE TREAT FLOWERSネット卸販売】 ご注文ありがとうございます';
		$mailer_shop->Body = $body;
		$mailer_shop->send();
	}
	
	foreach($cart_list as $cart) {
		update_post_meta($cart['id'], 'quantity', strval($cart['quantity'] - ($cart['rot'] * $cart['num'])));
	}
	
	$response = array(
		'result' => $result,
		'errors' => $error_list,
		'popup' => $popup
	);
	echo json_encode($response);

	// dieしておかないと末尾に余計なデータ「0」が付与されるので注意
	die();
}
add_action('wp_ajax_shopping', 'func_shopping');
add_action('wp_ajax_nopriv_shopping', 'func_shopping');
