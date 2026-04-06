<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}

?>
<li>
	<?php 
	do_action( 'woocommerce_widget_product_item_start', $args ); 
	$thumbnail_url = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'thumbnail' );
	?>

	<div class="ashade-product-list-item <?php echo esc_attr( is_array( $thumbnail_url ) ? '' : 'no-thmb' ); ?>">
	<?php
		if ( is_array( $thumbnail_url ) ) {
	?>
		<div class="ashade-product-list-item--image">
			<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
				<img 
					src="<?php echo esc_url( $thumbnail_url[0] ); ?>" 
					alt="<?php echo esc_attr( $product->get_name() ); ?>" 
					width="<?php echo esc_attr( $thumbnail_url[1] ); ?>" 
					height="<?php esc_attr( $thumbnail_url[2] ); ?>">
			</a>
		</div><!-- .ashade-product-list-item--image -->
	<?php 
		} 
	?>
		<div class="ashade-product-list-item--title">
			<?php
			if ( ! empty( $show_rating ) ) {
				ashade_woo__widget_rating( $product->get_average_rating() );
			}
			?>
			<span>
				<?php 
				echo wp_specialchars_decode( $product->get_price_html() ); // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
				?>
			</span>
			<a href="<?php echo esc_url( $product->get_permalink() ); ?>">
				<?php echo wp_kses_post( $product->get_name() ); ?>
			</a>
		</div><!-- .ashade-product-list-item--title -->
	</div><!-- .ashade-product-list-item -->
	
	<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>
</li>
