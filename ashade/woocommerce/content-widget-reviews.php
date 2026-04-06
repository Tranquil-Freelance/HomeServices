<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<li>
	<?php 
	do_action( 'woocommerce_widget_product_review_item_start', $args ); 
	$thumbnail_url = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'thumbnail' );
	?>

	<div class="ashade-product-list-item ashade-product-list-item--review <?php echo esc_attr( is_array( $thumbnail_url ) ? '' : 'no-thmb' ); ?>">
	<?php
		if ( is_array( $thumbnail_url ) ) {
	?>
		<div class="ashade-product-list-item--image">
			<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
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
			<span>
				<?php ashade_woo__widget_rating( intval( get_comment_meta( $comment->comment_ID, 'rating', true ) ) ); ?>
			</span>
			<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php echo wp_kses_post( $product->get_name() ); ?>
			</a>
			<?php
			if ( ! empty( $show_rating ) ) {
				
			}
			?>
		</div><!-- .ashade-product-list-item--title -->
	</div><!-- .ashade-product-list-item -->
	<?php do_action( 'woocommerce_widget_product_review_item_end', $args ); ?>
</li>
