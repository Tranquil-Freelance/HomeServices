<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$product_tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $product_tabs ) ) : ?>

	<div class="ashade-wc-tabs-wrap wc-tabs-wrapper">
		<ul class="ashade-wc-tabs wc-tabs" role="tablist">
			<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
				<li class="<?php echo esc_attr( $key ); ?>_tab ashade-wc-tab-item" id="tab-title-<?php echo esc_attr( $key ); ?>" role="tab" aria-controls="tab-<?php echo esc_attr( $key ); ?>" data-tab="#product-<?php echo esc_attr( $key ); ?>">
					<span><?php echo wp_kses_post( apply_filters( 'woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key ) ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php foreach ( $product_tabs as $key => $product_tab ) : ?>
			<div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr( $key ); ?> panel entry-content wc-tab" id="tab-<?php echo esc_attr( $key ); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr( $key ); ?>">
				<?php
				if ( isset( $product_tab['callback'] ) ) {
					call_user_func( $product_tab['callback'], $key, $product_tab );
				}
				?>
			</div>
		<?php endforeach; ?>

		<?php do_action( 'woocommerce_product_after_tabs' ); ?>
	</div>

<?php endif; ?>
