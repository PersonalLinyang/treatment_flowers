<?php
get_header();
?>
		<div class="content-area">
			<div class="contact-form-area">
				<h2>CONTACT</h2>
				<form id="form-contact">
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
						<div class="form-title">携帯番号<span class="important-mark">*</span></div>
						<div class="form-input">
							<input type="text" name="tel" placeholder="携帯番号" />
							<span class="error-message error-tel"></span>
						</div>
					</div>
					<div class="form-line">
						<div class="form-title">メール<span class="important-mark">*</span></div>
						<div class="form-input">
							<input type="text" name="email" placeholder="メール" />
							<span class="error-message error-email"></span>
						</div>
					</div>
					<div class="form-line">
						<div class="form-title">お問合せ内容</div>
						<div class="form-input">
							<textarea name="message" placeholder="お問合せ内容"></textarea>
						</div>
					</div>
				</form>
				<div class="button-controller">
					<div class="btn-contact button-btn">送信</div>
				</div>
			</div>
		</div>
		<div class="error_popup"></div>
<?php
get_footer();
