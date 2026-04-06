<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

defined( 'ABSPATH' ) || exit;

?>
<ul class="woocommerce-checkout-review-order-table">
	<?php
	do_action( 'woocommerce_review_order_before_cart_contents' );

	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

		if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
			?>
			<li class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
				<span class="product-name">
					<?php echo apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php echo apply_filters( 'woocommerce_checkout_cart_item_quantity', ' <strong class="product-quantity">' . sprintf( '&times;&nbsp;%s', $cart_item['quantity'] ) . '</strong>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					<?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</span>
				<span class="product-total">
					<?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
				</span>
			</li>
			<?php
		}
	}

	do_action( 'woocommerce_review_order_after_cart_contents' );
	?>
	<li class="woocommerce-checkout-review-order-table--footer">
		<ul>
			<li class="cart-subtotal">
				<span><?php esc_html_e( 'Subtotal', 'ashade' ); ?></span>
				<span><?php wc_cart_totals_subtotal_html(); ?></span>
			</li>

			<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
				<li class="cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
					<span><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
					<span><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
				</li>
			<?php endforeach; ?>

			<?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>

				<?php do_action( 'woocommerce_review_order_before_shipping' ); ?>

				<?php wc_cart_totals_shipping_html(); ?>

				<?php do_action( 'woocommerce_review_order_after_shipping' ); ?>

			<?php endif; ?>

			<?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
				<li class="fee">
					<span><?php echo esc_html( $fee->name ); ?></span>
					<span><?php wc_cart_totals_fee_html( $fee ); ?></span>
				</li>
			<?php endforeach; ?>

			<?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
				<?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
					<?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited ?>
						<li class="tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
							<span><?php echo esc_html( $tax->label ); ?></span>
							<span><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
						</li>
					<?php endforeach; ?>
				<?php else : ?>
					<li class="tax-total">
						<span><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
						<span><?php wc_cart_totals_taxes_total_html(); ?></span>
					</li>
				<?php endif; ?>
			<?php endif; ?>

			<?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

			<li class="order-total">
				<span><?php esc_html_e( 'Total', 'ashade' ); ?></span>
				<span><?php wc_cart_totals_order_total_html(); ?></span>
			</li>
		</ul>
	</li>
</ul>
<?php do_action( 'woocommerce_review_order_after_order_total' ); ?>