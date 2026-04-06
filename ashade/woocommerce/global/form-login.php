<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

defined( 'ABSPATH' ) || exit;

if ( is_user_logged_in() ) {
	return;
}

?>
<form class="ashade-wc-login-form ashade-wc-login-form--global woocommerce-form woocommerce-form-login login" method="post" <?php echo ( esc_attr( $hidden ) ) ? 'style="display:none;"' : ''; ?>>

	<?php do_action( 'woocommerce_login_form_start' ); ?>

	<?php echo ( esc_attr( $message ) ) ? wpautop( wptexturize( $message ) ) : ''; // @codingStandardsIgnoreLine ?>

	<label for="username"><?php esc_html_e( 'Username or email', 'ashade' ); ?>&nbsp;<span class="required">*</span></label>
	<input type="text" class="input-text" name="username" id="username" autocomplete="username" />
	<label for="password"><?php esc_html_e( 'Password', 'ashade' ); ?>&nbsp;<span class="required">*</span></label>
	<input class="input-text" type="password" name="password" id="password" autocomplete="current-password" />
	
	<div class="clear"></div>

	<?php do_action( 'woocommerce_login_form' ); ?>

	<div class="ashade-wc-login-form--footer">
		<div class="form-row">
			<button type="submit" class="woocommerce-button button woocommerce-form-login__submit" name="login" value="<?php esc_attr_e( 'Login', 'ashade' ); ?>"><?php esc_html_e( 'Login', 'ashade' ); ?></button>
			<label class="woocommerce-form__label woocommerce-form__label-for-checkbox woocommerce-form-login__rememberme">
				<input class="woocommerce-form__input woocommerce-form__input-checkbox" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'Remember me', 'ashade' ); ?></span>
			</label>
			<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
			<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ); ?>" />
		</div>
		<div class="lost_password">
			<a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'ashade' ); ?></a>
		</div>
	</div>

	<div class="clear"></div>

	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>
