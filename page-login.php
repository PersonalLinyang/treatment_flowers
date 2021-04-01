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
	if(strpos($_SERVER['HTTP_REFERER'], 'register') === false) {
		$_SESSION['login_redirect'] = $_SERVER['HTTP_REFERER'];
	}
} elseif(!$_SESSION['login_redirect']) {
	$_SESSION['login_redirect'] = '/';
}

get_header();
?>
		<div class="content-area">
			<div class="login-form-area">
				<h2>LOGIN</h2>
				<form id="form-login">
					<div class="form-line">
						<div class="form-title">ユーザ名</div>
						<div class="form-input">
							<input type="text" name="user_login" placeholder="ユーザ名" />
							<span class="error-message error-user_login"></span>
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
					<div class="btn-login button-btn">ログイン</div>
					<a href='/register/'><div class="btn-register button-btn">新規で会員登録</div></a>
				</div>
			</div>
		</div>
		<div class="error_popup"></div>
<?php
get_footer();
