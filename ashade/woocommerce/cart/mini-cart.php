<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_mini_cart' ); ?>

<?php if ( ! WC()->cart->is_empty() ) : ?>
	<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr( $args['list_class'] ); ?>">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
				$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
				$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				$thumbnail_url 	   = wp_get_attachment_image_src( get_post_thumbnail_id( $_product->get_id() ), 'thumbnail' );
				?>
				<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
					<div class="ashade-mini-cart-item <?php echo esc_attr( is_array( $thumbnail_url ) ? '' : 'no-thmb' ); ?>">
						<?php if ( is_array( $thumbnail_url ) ) { ?>
						<div class="ashade-mini-cart-item--image">
							<?php
							if ( empty( $product_permalink ) ) {
								echo '<img src="'. esc_url( $thumbnail_url[0] ) .'" alt="'. esc_attr( $_product->get_name() ) .'" width="'. esc_attr( $thumbnail_url[1] ) .'" height="'. esc_attr( $thumbnail_url[2] ) .'">';
							} else {
								echo '
								<a href="'. esc_url( $product_permalink ) .'">
									<img src="'. esc_url( $thumbnail_url[0] ) .'" alt="'. esc_attr( $_product->get_name() ) .'" width="'. esc_attr( $thumbnail_url[1] ) .'" height="'. esc_attr( $thumbnail_url[2] ) .'">
								</a>
								';
							}
							?>
						</div><!-- .ashade-mini-cart-item--image -->
						<?php } ?>
						<div class="ashade-mini-cart-item--title">
							<?php echo apply_filters( 'woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf( '%s &times; %s', $cart_item['quantity'], $product_price ) . '</span>', $cart_item, $cart_item_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							<a href="<?php echo esc_url( $product_permalink ); ?>">
								<?php echo esc_html( $product_name); ?>
							</a>
						</div><!-- .ashade-mini-cart-item--title -->
					<?php
						echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
							'woocommerce_cart_item_remove_link',
							sprintf(
								'<a href="%s" class="remove remove_from_cart_button ashade-mini-cart-item--remove" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s">&times;</a>',
								esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
								esc_attr__( 'Remove this item', 'ashade' ),
								esc_attr( $product_id ),
								esc_attr( $cart_item_key ),
								esc_attr( $_product->get_sku() )
							),
							$cart_item_key
						);
						echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
					?>
					</div><!-- .ashade-mini-cart-item -->
				</li>
				<?php
			}
		}
		
		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</ul>

	<p class="woocommerce-mini-cart__total total">
		<?php
		/**
		 * Hook: woocommerce_widget_shopping_cart_total.
		 *
		 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
		 */
		do_action( 'woocommerce_widget_shopping_cart_total' );
		?>
	</p>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<p class="woocommerce-mini-cart__buttons buttons"><?php do_action( 'woocommerce_widget_shopping_cart_buttons' ); ?></p>

	<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

<?php else : ?>

	<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'ashade' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
