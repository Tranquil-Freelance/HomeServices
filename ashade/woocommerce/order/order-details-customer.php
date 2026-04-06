<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$show_shipping = ! wc_ship_to_billing_address_only() && $order->needs_shipping_address();
?>
<section class="woocommerce-customer-details">

	<?php if ( $show_shipping ) : ?>

	<section class="woocommerce-columns woocommerce-columns--2 woocommerce-columns--addresses col2-set addresses">
		<div class="woocommerce-column woocommerce-column--1 woocommerce-column--billing-address col-1">

	<?php endif; ?>

	<h4 class="woocommerce-column__title"><?php esc_html_e( 'Billing address', 'ashade' ); ?></h4>

	<address>
		<?php echo wp_kses_post( $order->get_formatted_billing_address( esc_html__( 'N/A', 'ashade' ) ) ); ?>

		<?php if ( $order->get_billing_phone() ) : ?>
			<p class="woocommerce-customer-details--phone"><?php echo esc_html( $order->get_billing_phone() ); ?></p>
		<?php endif; ?>

		<?php if ( $order->get_billing_email() ) : ?>
			<p class="woocommerce-customer-details--email"><?php echo esc_html( $order->get_billing_email() ); ?></p>
		<?php endif; ?>
	</address>

	<?php if ( $show_shipping ) : ?>

		</div><!-- /.col-1 -->

		<div class="woocommerce-column woocommerce-column--2 woocommerce-column--shipping-address col-2">
			<h4 class="woocommerce-column__title"><?php esc_html_e( 'Shipping address', 'ashade' ); ?></h4>
			<address>
				<?php echo wp_kses_post( $order->get_formatted_shipping_address( esc_html__( 'N/A', 'ashade' ) ) ); ?>
			</address>
		</div><!-- /.col-2 -->

	</section><!-- /.col2-set -->

	<?php endif; ?>

	<?php do_action( 'woocommerce_order_details_after_customer_details', $order ); ?>

</section>
