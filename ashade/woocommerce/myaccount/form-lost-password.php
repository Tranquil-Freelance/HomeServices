<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>

<form method="post" class="woocommerce-ResetPassword lost_reset_password">
	<p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.', 'ashade' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>

	<div class="ashade-wc-lost-password-form-fields">
		<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
			<label for="user_login"><?php esc_html_e( 'Username or email', 'ashade' ); ?></label>
			<input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" />
		</p>

		<?php do_action( 'woocommerce_lostpassword_form' ); ?>

		<p class="woocommerce-form-row form-row">
			<input type="hidden" name="wc_reset_password" value="true" />
			<button type="submit" class="woocommerce-Button button" value="<?php esc_attr_e( 'Reset password', 'ashade' ); ?>"><?php esc_html_e( 'Reset password', 'ashade' ); ?></button>
		</p>
	</div>

	<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
</form>
<?php
do_action( 'woocommerce_after_lost_password_form' );
