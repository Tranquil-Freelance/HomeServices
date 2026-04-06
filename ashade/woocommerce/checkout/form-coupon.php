<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) { // @codingStandardsIgnoreLine.
	return;
}

?>
<div class="woocommerce-form-coupon-toggle">
	<?php wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'ashade' ) . ' <a href="#" class="showcoupon">' . esc_html__( 'Click here to enter your code', 'ashade' ) . '</a>' ), 'notice' ); ?>
</div>

<form class="checkout_coupon woocommerce-form-coupon" method="post" style="display:none">

	<p><?php esc_html_e( 'If you have a coupon code, please apply it below.', 'ashade' ); ?></p>
	
	<div class="ashade-wc-form-wrap">
		<p class="form-row form-row-first">
			<input type="text" name="coupon_code" class="input-text" placeholder="<?php esc_attr_e( 'Coupon code', 'ashade' ); ?>" id="coupon_code" value="" />
		</p>
		<p class="form-row form-row-last">
			<button type="submit" class="button" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'ashade' ); ?>"><?php esc_html_e( 'Apply coupon', 'ashade' ); ?></button>
		</p>
	</div>

	<div class="clear"></div>
</form>
