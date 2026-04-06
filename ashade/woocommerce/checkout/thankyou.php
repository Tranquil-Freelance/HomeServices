<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-order">

	<?php
	if ( $order ) {
		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		
		if ( $order->has_status( 'failed' ) ) { ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'ashade' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="button pay"><?php esc_html_e( 'Pay', 'ashade' ); ?></a>
				<?php if ( is_user_logged_in() ) { ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="button pay"><?php esc_html_e( 'My account', 'ashade' ); ?></a>
				<?php } ?>
			</p>

			<?php } else { ?>

			<div class="ashade-wc-order-received woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received">
				<h2>
					<span><?php esc_html_e( 'Your order has been received.', 'ashade' ); ?></span>
					<?php esc_html_e( 'Thank you.', 'ashade' ); ?>
				</h2>
				<ul class="woocommerce-order-overview woocommerce-thankyou-order-details order_details">
					<li class="woocommerce-order-overview__order order">
						<h6>
							<span><?php esc_html_e( 'Order number:', 'ashade' ); ?></span>
							<strong><?php echo wp_specialchars_decode( $order->get_order_number() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
						</h6>
					</li>
					<li class="woocommerce-order-overview__date date">
						<h6>
							<span><?php esc_html_e( 'Date:', 'ashade' ); ?></span>
							<strong><?php echo wc_format_datetime( $order->get_date_created() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
						</h6>
					</li>
					<?php if ( is_user_logged_in() && $order->get_user_id() === get_current_user_id() && $order->get_billing_email() ) { ?>
						<li class="woocommerce-order-overview__email email">
							<h6>
								<span><?php esc_html_e( 'Email:', 'ashade' ); ?></span>
								<strong><?php echo wp_specialchars_decode( $order->get_billing_email() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
							</h6>
						</li>
					<?php } ?>
					<li class="woocommerce-order-overview__total total">
						<h6>
							<span><?php esc_html_e( 'Total:', 'ashade' ); ?></span>
							<strong><?php echo wp_specialchars_decode( $order->get_formatted_order_total() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></strong>
						</h6>
					</li>
					<?php if ( $order->get_payment_method_title() ) { ?>
						<li class="woocommerce-order-overview__payment-method method">
							<h6>
								<span><?php esc_html_e( 'Payment method:', 'ashade' ); ?></span>
								<strong><?php echo wp_kses_post( $order->get_payment_method_title() ); ?></strong>
							</h6>
						</li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>

		<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
		
		<div class="ashade-wc-order-sections-wrap">
			<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
		</div><!-- .ashade-wc-order-sections-wrap -->
		<?php } else { ?>

		<p class="woocommerce-notice woocommerce-notice--success woocommerce-thankyou-order-received"><?php echo apply_filters( 'woocommerce_thankyou_order_received_text', esc_html__( 'Thank you. Your order has been received.', 'ashade' ), null ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>

	<?php } ?>
</div>
