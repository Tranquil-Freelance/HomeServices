<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $post;

$heading = apply_filters( 'woocommerce_product_description_heading', __( 'Description', 'ashade' ) );

?>

<?php if ( $heading ) : ?>
	<h3>
		<span><?php echo esc_html__( 'Detailed Information', 'ashade' ); ?></span>
		<?php echo esc_html( $heading ); ?>
	</h3>
<?php endif; ?>

<?php the_content(); ?>
