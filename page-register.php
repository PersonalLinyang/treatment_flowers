<?php
$user = wp_get_current_user();
if($user->ID) {
	$redirect_to = '/';
	if($_SERVER['HTTP_REFERER']) {
		$redirect_to = $_SERVER['HTTP_REFERER'];
	}
	header('Location: ' . $redirect_to);
	exit;
}

session_start();
if($_SESSION['redirect_from_shopping']) {
	$_SESSION['login_redirect'] = '/shopping/';
	$_SESSION['redirect_from_shopping'] = false;
} elseif($_SERVER['HTTP_REFERER']) {
	if(strpos($_SERVER['HTTP_REFERER'], 'login') === false) {
		$_SESSION['login_redirect'] = $_SERVER['HTTP_REFERER'];
	}
} elseif(!$_SESSION['login_redirect']) {
	$_SESSION['login_redirect'] = '/';
}

get_header();
?>
		<div class="content-area">
			<div class="register-form-area">
				<h2>REGISTER</h2>
				<form id="form-register">
					<div class="form-line">
						<div class="form-title">ユーザ名</div>
						<div class="form-input">
							<input type="text" name="user_login" placeholder="ユーザー名:英数字と「-」「_」「@」だけを使ってください" />
							<span class="error-message error-user_login"></span>
						</div>
					</div>
					<div class="form-line">
						<div class="form-title">メールアドレス</div>
						<div class="form-input">
							<input type="text" name="user_email" placeholder="メールアドレス" />
							<span class="error-message error-user_email"></span>
						</div>
					</div>
					<div class="form-line">
						<div class="form-title">姓</div>
						<div class="form-input">
							<input type="text" name="last_name" placeholder="姓" />
						</div>
					</div>
					<div class="form-line">
						<div class="form-title">名</div>
						<div class="form-input">
							<input type="text" name="first_name" placeholder="名" />
						</div>
					</div>
					<div class="form-line">
						<div class="form-title">パスワード</div>
						<div class="form-input">
							<input type="password" name="user_pass" placeholder="パスワード" />
							<span class="error-message error-user_pass"></span>
						</div>
					</div>
				</form>
				<div class="button-controller">
					<div class="btn-register button-btn">登録</div>
					<a href='/login/'><div class="btn-login button-btn">ログイン</div></a>
				</div>
			</div>
		</div>
		<div class="error_popup"></div>
<?php
get_footer();
