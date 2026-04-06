<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $product;

$heading = apply_filters( 'woocommerce_product_additional_information_heading', __( 'Additional info', 'ashade' ) );

?>

<?php if ( $heading ) : ?>
	<h3>
		<span><?php echo esc_html__( 'Want to learn more?', 'ashade' ); ?></span>
		<?php echo esc_html( $heading ); ?>
	</h3>
<?php endif; ?>

<?php do_action( 'woocommerce_product_additional_information', $product ); ?>
