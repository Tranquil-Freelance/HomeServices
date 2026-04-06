<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

defined( 'ABSPATH' ) || exit;

$formatted_destination    = isset( $formatted_destination ) ? $formatted_destination : WC()->countries->get_formatted_address( $package['destination'], ', ' );
$has_calculated_shipping  = ! empty( $has_calculated_shipping );
$show_shipping_calculator = ! empty( $show_shipping_calculator );
$calculator_text          = '';
?>
<li class="ashade-shipping-methods">
	<span><?php echo wp_kses_post( $package_name ); ?></span>
	<span data-title="<?php echo esc_attr( $package_name ); ?>">
		<?php if ( $available_methods ) : ?>
			<span id="shipping_method" class="woocommerce-shipping-methods">
				<?php foreach ( $available_methods as $method ) : 
					if ( 1 < count( $available_methods ) ) {
						echo '<div class="ashade-wc-total-shipping-method-wrap">';
						printf( '<input type="radio" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method is-default" %4$s />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ), checked( $method->id, $chosen_method, false ) ); // WPCS: XSS ok.
					} else {
						echo '<div class="ashade-wc-total-shipping-method-wrap is-single">';
						printf( '<input type="hidden" name="shipping_method[%1$d]" data-index="%1$d" id="shipping_method_%1$d_%2$s" value="%3$s" class="shipping_method is-default" />', $index, esc_attr( sanitize_title( $method->id ) ), esc_attr( $method->id ) ); // WPCS: XSS ok.
					}
					printf( '<label for="shipping_method_%1$s_%2$s" class="is-link">%3$s</label>', $index, esc_attr( sanitize_title( $method->id ) ), wc_cart_totals_shipping_method_label( $method ) ); // WPCS: XSS ok.
					echo '</div><!-- .ashade-wc-total-shipping-method-wrap -->';
					do_action( 'woocommerce_after_shipping_rate', $method, $index );
				endforeach; ?>
			</span>
		<?php
		elseif ( ! $has_calculated_shipping || ! $formatted_destination ) :
			if ( is_cart() && 'no' === get_option( 'woocommerce_enable_shipping_calc' ) ) {
				echo wp_kses_post( apply_filters( 'woocommerce_shipping_not_enabled_on_cart_html', __( 'Shipping costs are calculated during checkout.', 'ashade' ) ) );
			} else {
				echo wp_kses_post( apply_filters( 'woocommerce_shipping_may_be_available_html', __( 'Enter your address to view shipping options.', 'ashade' ) ) );
			}
		elseif ( ! is_cart() ) :
			echo wp_kses_post( apply_filters( 'woocommerce_no_shipping_available_html', __( 'There are no shipping options available. Please ensure that your address has been entered correctly, or contact us if you need any help.', 'ashade' ) ) );
		else :
			// Translators: $s shipping destination.
			echo wp_kses_post( apply_filters( 'woocommerce_cart_no_shipping_available_html', sprintf( esc_html__( 'No shipping options were found for %s.', 'ashade' ) . ' ', '<strong>' . esc_html( $formatted_destination ) . '</strong>' ) ) );
			$calculator_text = esc_html__( 'Enter a different address', 'ashade' );
		endif;
		?>
	</span>
</li>
<?php if ( is_cart() ) : ?>
	<li class="woocommerce-shipping-destination">
		<?php
		if ( $formatted_destination ) {
			// Translators: $s shipping destination.
			echo '<span>' . esc_html__( 'Shipping to:', 'ashade' ) . '</span>';
			echo '<span>' . esc_html( $formatted_destination ) . '</span>';
			$calculator_text = esc_html__( 'Change address', 'ashade' );
		} else {
			echo wp_kses_post( apply_filters( 'woocommerce_shipping_estimate_html', __( 'Shipping options will be updated during checkout.', 'ashade' ) ) );
		}
		?>
	</li>
<?php endif;
if ( $show_package_details ) : 
	echo '<li class="woocommerce-shipping-contents"><small>' . esc_html( $package_details ) . '</small></li>'; 
endif;
if ( $show_shipping_calculator ) : ?>
	<li class="ashade-wc-total-address--edit">
		<?php woocommerce_shipping_calculator( $calculator_text ); ?>
	</li>
<?php endif; ?>