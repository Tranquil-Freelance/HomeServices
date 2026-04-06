<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'ashade' ) ) );
	return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
	<div class="ashade-row">
		<div class="ashade-col col-6">
			<?php if ( $checkout->get_checkout_fields() ) { ?>
				<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
				<div id="customer_details">
					<?php do_action( 'woocommerce_checkout_billing' ); ?>
					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				</div><!-- #customer_details -->
				<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
			<?php } ?>
		</div><!-- .ashade-col -->
		<div class="ashade-col col-6">
			<div class="ashade-your-order-wrap">
				<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>	
				<h4 id="order_review_heading"><?php esc_html_e( 'Your order', 'ashade' ); ?></h4>
				<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
				<div id="order_review" class="woocommerce-checkout-review-order">
					<div class="ashade-wc-checkout-order">
						<?php do_action( 'woocommerce_checkout_order_review' ); ?>
					</div><!-- .ashade-wc-checkout-order -->
				</div>
				<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
			</div>
		</div><!-- .ashade-col -->
	</div><!-- .ashade-row -->
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
