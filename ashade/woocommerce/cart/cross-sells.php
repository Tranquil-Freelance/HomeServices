<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

defined( 'ABSPATH' ) || exit;

if ( $cross_sells ) : 
?>

	<div class="ashade-cross-sells cross-sells">

		<h3>
			<span><?php echo esc_html__( 'You may be interested in', 'ashade' ); ?></span>
			<?php esc_html_e( 'Related Products', 'ashade' ); ?>
		</h3>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $cross_sells as $cross_sell ) : ?>

				<?php
					$post_object = get_post( $cross_sell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.OverrideProhibited, Squiz.PHP.DisallowMultipleAssignments.Found

					wc_get_template_part( 'content', 'product' );
				?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>
	<?php
endif;

wp_reset_postdata();
