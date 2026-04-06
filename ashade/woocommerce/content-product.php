<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $product;

# Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$ashade_buttons = esc_attr( Ashade_Core::get_mod( 'ashade-wc-button-state' ) );
$in_stock = true;
if ( 'outofstock' == $product->get_stock_status() ) {
	$in_stock = false;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
	<div class="ashade-woo-loop-item ashade-wc-tools--<?php echo esc_attr( $ashade_buttons ); ?>">
		<div class="ashade-woo-loop-item__image-wrap">
			<?php 
				if ( ! $in_stock ) {
					echo '<span class="ashade-soldout-label">' . esc_html__('Sold', 'ashade') . '</span>';
				} else {
					wc_get_template( 'loop/sale-flash.php' );
				}
			?>
			<a href="<?php echo esc_url( apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product ) ); ?>">
				<?php woocommerce_template_loop_product_thumbnail(); ?>
			</a>
			<div class="ashade-wc-loop-item__view">
				<h6>
					<span><?php esc_attr_e( 'Item Added', 'ashade' ); ?></span>
					<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'cart' ) ) ) ;?>"><?php esc_attr_e( 'View Cart', 'ashade' ); ?></a>
				</h6>
			</div><!-- .ashade-wc-loop-item__view -->
			<div class="ashade-woo-loop-item__tools">
				<?php 
				if ( Ashade_Core::get_mod( 'ashade-wc-button-zoom' ) ) {
					$full_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $product->get_id() ), 'single-post-thumbnail' );
				?>
				<a 
					href="<?php echo esc_url( $full_image_url[0] ); ?>" 
					data-elementor-open-lightbox="no" 
					data-caption="<?php the_title(); ?> - <?php echo get_woocommerce_currency_symbol() . $product->get_price(); ?>" 
					data-size="<?php echo esc_attr( $full_image_url[1] ) . 'x' . esc_attr( $full_image_url[2] ); ?>" 
					class="ashade-lightbox-link ashade-woo-loop-item__details">
					<svg xmlns="http://www.w3.org/2000/svg" width="22.531" height="22.531" viewBox="0 0 22.531 22.531">
						<path d="M10.445-19.3a8.426,8.426,0,0,1,6.18-2.57A8.426,8.426,0,0,1,22.8-19.3a8.426,8.426,0,0,1,2.57,6.18,8.426,8.426,0,0,1-2.57,6.18,8.426,8.426,0,0,1-6.18,2.57A8.475,8.475,0,0,1,11.1-6.344l-6.945,7L2.844-.656l7-6.945a8.475,8.475,0,0,1-1.969-5.523A8.426,8.426,0,0,1,10.445-19.3Zm11.129,1.23a6.744,6.744,0,0,0-4.949-2.051,6.744,6.744,0,0,0-4.949,2.051,6.744,6.744,0,0,0-2.051,4.949,6.744,6.744,0,0,0,2.051,4.949,6.744,6.744,0,0,0,4.949,2.051,6.744,6.744,0,0,0,4.949-2.051,6.744,6.744,0,0,0,2.051-4.949A6.744,6.744,0,0,0,21.574-18.074ZM15.75-16.625H17.5V-14h2.625v1.75H17.5v2.625H15.75V-12.25H13.125V-14H15.75Z" transform="translate(-2.844 21.875)" fill="gray"/>
					</svg>
				</a>
				<?php } ?>
				<span></span>
				<?php 
				if ( $in_stock && Ashade_Core::get_mod( 'ashade-wc-button-add2cart' ) ) {
					$args = array();
					$defaults = array(
						'quantity'   => 1,
						'class'      => implode(
							' ',
							array_filter(
								array(
									'button',
									'ashade-woo-loop-item__add2cart',
									'product_type_' . $product->get_type(),
									$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
									$product->supports( 'ajax_add_to_cart' ) && $product->is_purchasable() && $product->is_in_stock() ? 'ajax_add_to_cart' : '',
								)
							)
						),
						'attributes' => array(
							'data-product_id'  => $product->get_id(),
							'data-product_sku' => $product->get_sku(),
							'aria-label'       => $product->add_to_cart_description(),
							'rel'              => 'nofollow',
						),
					);
		
					$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );
		
					if ( isset( $args['attributes']['aria-label'] ) ) {
						$args['attributes']['aria-label'] = wp_strip_all_tags( $args['attributes']['aria-label'] );
					}
				?>
				<a 
					href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" 
					data-quantity="1" 
					class="<?php echo esc_attr( isset( $args['class'] ) ? $args['class'] : 'button ashade-woo-loop-item__add2cart' ); ?>"
					<?php echo isset( $args['attributes'] ) ? wc_implode_html_attributes( $args['attributes'] ) : '' ?>>
					<svg xmlns="http://www.w3.org/2000/svg" width="21.656" height="17.5" viewBox="0 0 21.656 17.5" class="ashade-woo-icon--a2c">
						<path d="M3.5-18.375H5.469a1.708,1.708,0,0,1,1.066.355,1.5,1.5,0,0,1,.574.957l2.3,9.188H20.344l2.078-7.875h1.859l-2.3,8.313a1.5,1.5,0,0,1-.574.957,1.708,1.708,0,0,1-1.066.355H9.406A1.708,1.708,0,0,1,8.34-6.48a1.5,1.5,0,0,1-.574-.957l-2.3-9.187H3.5a.852.852,0,0,1-.629-.246.852.852,0,0,1-.246-.629.852.852,0,0,1,.246-.629A.852.852,0,0,1,3.5-18.375ZM17.391-5.359a2.531,2.531,0,0,1,1.859-.766,2.531,2.531,0,0,1,1.859.766A2.531,2.531,0,0,1,21.875-3.5a2.531,2.531,0,0,1-.766,1.859,2.531,2.531,0,0,1-1.859.766,2.531,2.531,0,0,1-1.859-.766A2.531,2.531,0,0,1,16.625-3.5,2.531,2.531,0,0,1,17.391-5.359Zm-7.875,0a2.531,2.531,0,0,1,1.859-.766,2.531,2.531,0,0,1,1.859.766A2.531,2.531,0,0,1,14-3.5a2.531,2.531,0,0,1-.766,1.859,2.531,2.531,0,0,1-1.859.766,2.531,2.531,0,0,1-1.859-.766A2.531,2.531,0,0,1,8.75-3.5,2.531,2.531,0,0,1,9.516-5.359ZM14-18.375h1.75v2.625h2.625V-14H15.75v2.625H14V-14H11.375v-1.75H14ZM12.25-3.5a.773.773,0,0,0-.875-.875A.773.773,0,0,0,10.5-3.5a.773.773,0,0,0,.875.875A.773.773,0,0,0,12.25-3.5Zm7.875,0a.773.773,0,0,0-.875-.875.773.773,0,0,0-.875.875.773.773,0,0,0,.875.875A.773.773,0,0,0,20.125-3.5Z" transform="translate(-2.625 18.375)" fill="gray"/>
					</svg>
					<span class="ashade-woo-icon--a2c-progress"></span>
					
					<svg xmlns="http://www.w3.org/2000/svg" width="24.063" height="17.609" viewBox="0 0 24.063 17.609" class="ashade-woo-icon--a2c-done">
						  <path data-name="Path 9" d="M.089-.069,7.124,6.916l15.7-15.8" transform="translate(0.263 9.234)" fill="none" stroke="#808080" stroke-width="2"/>
					</svg>
				</a>
				<?php } ?>
			</div><!-- .ashade-woo-loop-item__tools -->
		</div><!-- .ashade-woo-loop-item__image-wrap -->
		<div class="ashade-woo-loop-item__footer">
			<?php 
			$h = Ashade_Core::get_mod( 'ashade-wc-titles-size' );
			echo '<'. esc_attr( $h ) .' class="ashade-woo-loop-item__title">';
			?>
				<?php echo wc_get_product_category_list( $product->get_id(), ', ', '<span>', '</span>' ); ?>
				<a href="<?php echo esc_url( apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product ) ); ?>">
					<?php the_title(); ?>
				</a>
			<?php echo '</'. esc_attr( $h ) .'>'; ?>
			<div class="ashade-woo-loop-item__price">
				<?php wc_get_template( 'loop/price.php' ); ?>
			</div>
		</div><!-- .ashade-woo-loop-item__footer -->
	</div><!-- .ashade-product-loop-item -->
</li>
