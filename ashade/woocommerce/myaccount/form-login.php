<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="ashade-woo-login-wrap">
	<div class="ashade-woo-login-head">
		<h4 class="ashade-woo-customer-signin">
			<span><?php esc_html_e( 'Welcome!', 'ashade' ); ?></span>
			<?php esc_html_e( 'Sign In', 'ashade' ); ?>
		</h4>
		<h4 class="is-inactive ashade-woo-customer-register">
			<span><?php esc_html_e( 'New Customer?', 'ashade' ); ?></span>
			<?php esc_html_e( 'Register', 'ashade' ); ?>
		</h4>
	</div><!-- .ashade-woo-login-head -->

	<form class="ashade-wc-login-form ashade-wc-signin-form woocommerce-form woocommerce-form-login login is-active <?php echo ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ? 'wc-registration-allowed' : null ); ?>" method="post">
		<?php do_action( 'woocommerce_login_form_start' ); ?>

		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="username"><?php esc_html_e( 'Username or email address', 'ashade' ); ?>&nbsp;<span class="required">*</span></label>
			<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="password"><?php esc_html_e( 'Password', 'ashade' ); ?>&nbsp;<span class="required">*</span></label>
			<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
		</p>

		<?php do_action( 'woocommerce_login_form' ); ?>

		<div class="ashade-wc-login-form--footer">
			<div class="ashade-wc-login-form-row">
				<div class="ashade-wc-login-form--remember">
					<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" />
					<label class="woocommerce-form__label woocommerce-form-login__rememberme" for="rememberme">
						<?php esc_html_e( 'Remember me', 'ashade' ); ?>
					</label>
					<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				</div>
				<div class="woocommerce-LostPassword lost_password">
					<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'ashade' ); ?></a>
				</div><!-- .lost_password -->
			</div>
			<button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Sign In', 'ashade' ); ?>"><?php esc_html_e( 'Sign In', 'ashade' ); ?></button>
		</div><!-- .ashade-wc-login-form--footer -->

		<?php do_action( 'woocommerce_login_form_end' ); ?>
	</form>
	<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>
	<form method="post" class="ashade-wc-login-form ashade-wc-register-form woocommerce-form woocommerce-form-register register is-inactive" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

			<?php do_action( 'woocommerce_register_form_start' ); ?>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_username"><?php esc_html_e( 'Username', 'ashade' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
				</p>

			<?php endif; ?>

			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
				<label for="reg_email"><?php esc_html_e( 'Email address', 'ashade' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>

			<?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

				<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
					<label for="reg_password"><?php esc_html_e( 'Password', 'ashade' ); ?>&nbsp;<span class="required">*</span></label>
					<input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
				</p>

			<?php else : ?>

				<p class="ashade-wc-register--password-notify"><?php esc_html_e( 'A password will be sent to your email address.', 'ashade' ); ?></p>

			<?php endif; ?>

			<?php do_action( 'woocommerce_register_form' ); ?>

			<div class="ashade-wc-register-form--button">
				<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
				<button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'ashade' ); ?>"><?php esc_html_e( 'Register', 'ashade' ); ?></button>
			</div>

			<?php do_action( 'woocommerce_register_form_end' ); ?>

		</form>
	<?php endif; ?>
</div><!-- .ashade-woo-login-wrap -->

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
