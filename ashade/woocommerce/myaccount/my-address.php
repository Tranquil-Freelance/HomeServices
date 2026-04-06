<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$customer_id = get_current_user_id();

if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing'  => __( 'Billing address', 'ashade' ),
			'shipping' => __( 'Shipping address', 'ashade' ),
		),
		$customer_id
	);
} else {
	$get_addresses = apply_filters(
		'woocommerce_my_account_get_addresses',
		array(
			'billing' => __( 'Billing address', 'ashade' ),
		),
		$customer_id
	);
}

$oldcol = 1;
$col    = 1;
?>

<p>
	<?php echo apply_filters( 'woocommerce_my_account_my_address_description', esc_html__( 'The following addresses will be used on the checkout page by default.', 'ashade' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</p>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	<div class="u-columns woocommerce-Addresses col2-set addresses">
<?php endif; ?>

<?php foreach ( $get_addresses as $name => $address_title ) : ?>
	<?php
		$address = wc_get_account_formatted_address( $name );
		$col     = $col * -1;
		$oldcol  = $oldcol * -1;
	?>

	<div class="u-column<?php echo esc_attr( $col ) < 0 ? 1 : 2; ?> col-<?php echo esc_attr( $oldcol ) < 0 ? 1 : 2; ?> woocommerce-Address">
		<header class="woocommerce-Address-title title">
			<h4>
				<span><a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address', $name ) ); ?>" class="edit"><?php echo esc_attr( $address ) ? esc_html__( 'Edit Address', 'ashade' ) : esc_html__( 'Add Address', 'ashade' ); ?></a></span>
				<?php echo esc_html( $address_title ); ?>
			</h4>
		</header>
		<address>
			<?php
				echo esc_attr( $address ) ? wp_kses_post( $address ) : esc_html_e( 'You have not set up this type of address yet.', 'ashade' );
			?>
		</address>
	</div>

<?php endforeach; ?>

<?php if ( ! wc_ship_to_billing_address_only() && wc_shipping_enabled() ) : ?>
	</div>
	<?php
endif;
