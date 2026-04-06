<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! $product_attributes ) {
	return;
}
?>
<table class="ashade-wc-product-attributes">
	<?php foreach ( $product_attributes as $product_attribute_key => $product_attribute ) : ?>
		<tr class="woocommerce-product-attributes-item woocommerce-product-attributes-item--<?php echo esc_attr( $product_attribute_key ); ?>">
			<th class="woocommerce-product-attributes-item__label"><?php echo wp_kses_post( $product_attribute['label'] ); ?></th>
			<td class="woocommerce-product-attributes-item__value"><?php echo wp_kses_post( $product_attribute['value'] ); ?></td>
		</tr>
	<?php endforeach; ?>
</table>
