<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<li <?php wc_product_cat_class( '', $category ); ?>>
	<?php
	$items_count = $category->count;
	?>
	<div class="ashade-woo-loop-item">
		<div class="ashade-woo-loop-item__image-wrap">
			<a href="<?php echo esc_url( get_term_link( $category, 'product_cat' ) ); ?>">
				<?php woocommerce_subcategory_thumbnail( $category ); ?>
			</a>
		</div><!-- .ashade-woo-loop-item__image-wrap -->
		<div class="ashade-woo-loop-item__footer">
			<h5 class="ashade-woo-loop-item__title">
				<a href="<?php echo esc_url( get_term_link( $category, 'product_cat' ) ); ?>">
					<span><?php echo esc_html( $items_count ) . ' ' . ( $items_count == 1 ? esc_attr__( 'Product', 'ashade' ) : esc_attr__( 'Products', 'ashade' ) ); ?></span>
					<?php echo esc_html( $category->name ); ?>
				</a>
			</h5>
		</div><!-- .ashade-woo-loop-item__footer -->
	</div><!-- .ashade-product-loop-item -->
</li>
