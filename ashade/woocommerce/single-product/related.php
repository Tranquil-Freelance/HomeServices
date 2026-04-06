<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( $related_products ) : ?>

	<section class="related products">

		<?php
		$heading = apply_filters( 'woocommerce_product_related_products_heading', __( 'Related Products', 'ashade' ) );

		if ( $heading ) :
			?>
			<h3>
				<span><?php echo esc_html__( 'You may also like', 'ashade' ); ?></span>
				<?php echo esc_html( $heading ); ?>
			</h3>
		<?php endif; ?>
		
		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $related_products as $related_product ) : ?>

					<?php
					$post_object = get_post( $related_product->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

					wc_get_template_part( 'content', 'product' );
					?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</section>
	<?php
endif;

wp_reset_postdata();
