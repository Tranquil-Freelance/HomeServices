<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( $upsells ) : ?>
	<section class="ashade-up-sells up-sells upsells products">

		<h3>
			<span><?php esc_html_e( 'People who bought it', 'ashade' ); ?></span>
			<?php esc_html_e( 'Also Buying', 'ashade' ); ?>
		</h3>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $upsells as $upsell ) : ?>

				<?php
				$post_object = get_post( $upsell->get_id() );

				setup_postdata( $GLOBALS['post'] =& $post_object );

				wc_get_template_part( 'content', 'product' );
				?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</section>

	<?php
endif;

wp_reset_postdata();
