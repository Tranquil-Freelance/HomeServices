<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_cart' ); ?>
<form class="woocommerce-cart-form ashade-wc-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
	<div class="ashade-cart-page-wrap ashade-row"
		data-price-format = "<?php echo esc_attr( get_option( 'woocommerce_currency_pos' ) ); ?>" 
		data-price-dec = "<?php echo esc_attr( get_option( 'woocommerce_price_decimal_sep' ) ); ?>" 
		data-price-dec-num = "<?php echo esc_attr( get_option( 'woocommerce_price_num_decimals' ) ); ?>" 
		data-price-sep = "<?php echo esc_attr( get_option( 'woocommerce_price_thousand_sep' ) ); ?>" 
		data-price-symbol = "<?php echo esc_attr( get_woocommerce_currency_symbol() ); ?>">

		<div class="ashade-cart-page--content ashade-col col-8">
			<?php do_action( 'woocommerce_before_cart_table' ); ?>

			<ul class="ashade-cart-listing woocommerce-cart-form__contents cart">
			<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
					$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
					?>
					<li class="woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
						<div class="ashade-cart-item-inner">
							<div class="ashade-cart-item-info">
								<div class="ashade-cart-item--thmb">
									<?php
									$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

									if ( ! $product_permalink ) {
										echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
									} else {
										printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail ); // PHPCS: XSS ok.
									}
									?>
								</div><!-- .ashade-cart-item--thmb -->
								<div class="ashade-cart-item--name" data-title="<?php esc_attr_e( 'Product', 'ashade' ); ?>">
									<h5>
										<span><?php echo wc_get_product_category_list( $_product->get_id(), ', ', '<span>', '</span>' ); ?></span>
										<?php 
										if ( ! $product_permalink ) {
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
										} else {
											echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
										}
										do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
										// Backorder notification.
										if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
											echo '<div class="ashade-cart-item--notify">' . wp_kses_post( apply_filters( 'woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'ashade' ) . '</p>', $product_id ) ) . '</div>';
										}
										?>
									</h5>
								</div><!-- .ashade-cart-item--product-name -->
							</div><!-- .ashade-cart-item-info -->
							<div class="ashade-cart-item--qty-wrap <?php echo esc_attr( $_product->is_sold_individually() ? 'sell-alone' : ''); ?>">
								<?php
								# QTY Input
								if ( $_product->is_sold_individually() ) {
									$product_quantity = sprintf( '<input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								} else {
								?>
								<a href="#" class="ashade-cart-item--qty-plus"></a>
								<a href="#" class="ashade-cart-item--qty-minus"></a>
								<?php
									$product_quantity = woocommerce_quantity_input(
										array(
											'input_name'   => "cart[{$cart_item_key}][qty]",
											'input_value'  => $cart_item['quantity'],
											'max_value'    => $_product->get_max_purchase_quantity(),
											'min_value'    => '0',
											'product_name' => $_product->get_name(),
										),
										$_product,
										false
									);
								}
								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
								?>
								<h5 class="ashade-cart-item--qty-label">
									<?php 
										$count = $cart_item[ 'quantity' ];
										$price_value = $_product->get_price();
										$price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
									?>
									<span class="ashade-cart-item--qty">
										<span class="ashade-cart-item--qty-count"><?php echo esc_attr( $count ); ?></span>
										<span class="ashade-cart-item--qty-x">x</span>
										<span class="ashade-cart-item--qty-price" data-price="<?php echo esc_attr( $price_value ); ?>"><?php echo wp_specialchars_decode( $price ); ?></span>
									</span>
									<?php echo wc_price( $count * $price_value ); ?>
								</h5>
							</div><!-- .ashade-cart-item--qty -->
						</div><!-- .ashade-cart-item-inner -->
						
						<div class="ashade-product-remove-wrap product-remove">
							<?php
								echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
									'woocommerce_cart_item_remove_link',
									sprintf(
										'<a href="%s" class="ashade-cart-item--remove remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"></a>',
										esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
										esc_html__( 'Remove this item', 'ashade' ),
										esc_attr( $product_id ),
										esc_attr( $_product->get_sku() )
									),
									$cart_item_key
								);
							?>
						</div>
					</li>
					<?php
				}
			}
			?>
			</ul>
			<div class="ashade-cart-footer">
				<div class="ashade-cart-footer--lp">
					<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) ;?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="9.844" height="17.625" viewBox="0 0 9.844 17.625">
							<path id="prev" d="M2.25-17.812l1.125,1.125L-4.359-9,3.375-1.312,2.25-.187-6-8.437-6.469-9-6-9.562Z" transform="translate(6.469 17.813)" fill="#fff"/>
						</svg>
						<?php echo esc_html__( 'Continue Shopping', 'ashade' ) ;?>
					</a>
				</div><!-- .ashade-cart-footer--lp -->
				<div class="ashade-cart-footer--rp">
					<?php if ( wc_coupons_enabled() ) { ?>
						<div class="ashade-coupon-wrap coupon">
							<div class="ashade-coupon-wrap--input">
								<label for="coupon_code"><?php esc_html_e( 'Coupon code', 'ashade' ); ?></label>
								<input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Enter your code', 'ashade' ); ?>" />
							</div><!-- .ashade-coupon-wrap--input -->
							<div class="ashade-coupon-wrap--button">
								<button type="submit" class="button" name="apply_coupon"><?php esc_attr_e( 'Apply Coupon', 'ashade' ); ?></button>
								<?php do_action( 'woocommerce_cart_coupon' ); ?>
							</div><!-- .ashade-coupon-wrap--button -->
						</div><!-- .ashade-coupon-wrap -->
					<?php }
					wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' );
					do_action( 'woocommerce_after_cart_table' );
					?>
				</div><!-- .ashade-cart-footer--rp -->
			</div><!-- .ashade-cart-footer -->
		</div><!-- .ashade-cart-page--content -->
		<div class="ashade-cart-page--total ashade-col col-4">
			<?php do_action( 'woocommerce_before_cart_collaterals' ); ?>
			<div class="cart-collaterals">
				<?php
					woocommerce_cart_totals();
				?>
			</div>
		</div><!-- .ashade-cart-page--total -->
	</div><!-- .ashade-cart-page-wrap -->
	<?php 
		# Cross Selling Products
		add_filter( 'woocommerce_cross_sells_columns', 'ashade_cross_sales_num' );
		add_filter( 'woocommerce_cross_sells_total', 'ashade_cross_sales_num' );

		if ( ! function_exists( 'ashade_cross_sales_num' ) ) {
			function ashade_cross_sales_num() {
				return Ashade_Core::get_mod( 'ashade-wc-cross-columns' );
			}
		}
		
		woocommerce_cross_sell_display(); 
	?>
</form>
<?php do_action( 'woocommerce_after_cart' ); ?>
