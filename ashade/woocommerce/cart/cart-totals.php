<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

defined( 'ABSPATH' ) || exit;

?>
<div class="ashade-cart-totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<h4>
		<span><?php esc_html_e( 'Shopping Summary', 'ashade' ); ?></span>
		<?php esc_html_e( 'Cart Totals', 'ashade' ); ?>
	</h4>

	<ul class="ashade-cart-total--list">
		<li class="ashade-ctl--subtotal">
			<span><?php esc_html_e( 'Subtotal:', 'ashade' ); ?></span>
			<span><?php wc_cart_totals_subtotal_html(); ?></span>
		</li>
		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) { ?>
			<li class="ashade-ctl--discount cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
				<span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
				<span><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
			</li>
		<?php } 
			if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) {
				do_action( 'woocommerce_cart_totals_before_shipping' );
				wc_cart_totals_shipping_html();
				do_action( 'woocommerce_cart_totals_after_shipping' );
			 } else if ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) { 
		?>
			<li class="shipping-title">
				<span><?php esc_html_e( 'Shipping:', 'ashade' ); ?></span>
			</li>
			<?php woocommerce_shipping_calculator(); ?>
		<?php } ?>
		<?php foreach ( WC()->cart->get_fees() as $fee ) { ?>
			<li class="fee">
				<span><?php echo esc_html( $fee->name ); ?></span>
				<span><?php wc_cart_totals_fee_html( $fee ); ?></span>
			</li>
		<?php } ?>
		<?php
		if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) {
			$taxable_address = WC()->customer->get_taxable_address();
			$estimated_text  = '';

			if ( WC()->customer->is_customer_outside_base() && ! WC()->customer->has_calculated_shipping() ) {
				/* translators: %s location. */
				$estimated_text = sprintf( ' <small>' . esc_html__( '(estimated for %s)', 'ashade' ) . '</small>', WC()->countries->estimated_for_prefix( $taxable_address[0] ) . WC()->countries->countries[ $taxable_address[0] ] );
			}
			if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) {
				foreach ( WC()->cart->get_tax_totals() as $code => $tax ) { // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited
					?>
					<li class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
						<span><?php echo esc_html( $tax->label ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
						<span><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
					</li>
					<?php
				}
			} else {
				?>
				<li class="tax-total">
					<span><?php echo esc_html( WC()->countries->tax_or_vat() ) . $estimated_text; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
					<span><?php wc_cart_totals_taxes_total_html(); ?></sp>
				</li>
				<?php
			}
		}
		do_action( 'woocommerce_cart_totals_before_order_total' ); ?>
		<li class="order-total">
			<span><?php esc_html_e( 'Total:', 'ashade' ); ?></span>
			<span><?php wc_cart_totals_order_total_html(); ?></span>
		</li>
		<?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>
	</ul>
	<div class="ashade-wc-total-buttons">
		<div class="ashade-wc-total-buttons--lp">
			<button type="submit" class="button" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'ashade' ); ?>">
				<?php esc_html_e( 'Update cart', 'ashade' ); ?>
			</button>
			<?php 
				do_action( 'woocommerce_cart_actions' );
				wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' );
				do_action( 'woocommerce_after_cart_table' );
			?>
		</div><!-- .ashade-wc-total-buttons--lp -->
		<div class="ashade-wc-total-buttons--rp">
			<div class="wc-proceed-to-checkout">
				<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="checkout-button button alt wc-forward">
					<?php esc_html_e( 'Checkout', 'ashade' ); ?>
				</a>
			</div>
		</div><!-- .ashade-wc-total-buttons--rp -->
	</div><!-- .ashade-wc-total-buttons -->
	<?php do_action( 'woocommerce_after_cart_totals' ); ?>
</div><!-- .ashade-cart-totals -->