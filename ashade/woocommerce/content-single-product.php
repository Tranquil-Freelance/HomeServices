<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;

global $product;

$in_stock = true;
if ( 'outofstock' == $product->get_stock_status() ) {
	$in_stock = false;
}
do_action( 'woocommerce_before_single_product' );
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'ashade-single-product', $product ); ?>>
	<div class="ashade-single-product--main">
		<?php
		if ( ! $in_stock ) {
			echo '<span class="ashade-soldout-label">' . esc_html__('Sold', 'ashade') . '</span>';
		}
		do_action( 'woocommerce_before_single_product_summary' );
		?>

		<div class="summary entry-summary">
			<div class="ashade-single-product--title">
				<h3>
					<?php 
					$rating_count = $product->get_rating_count();
					$review_count = $product->get_review_count();
					$average      = $product->get_average_rating();
					if ( $rating_count > 0 ) {
						echo '<span>';
						ashade_woo__widget_rating( $average );
						if ( comments_open() ) {
							//phpcs:disable ?>
							<a href="#reviews" class="woocommerce-review-link" rel="nofollow"><?php printf( _n( '%s review', '%s reviews', $review_count, 'ashade' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?></a>
							<?php // phpcs:enable
						}
						echo '</span>';
					}
					?>
					<?php the_title(); ?>
				</h3>
				<div class="ashade-single-product--price">
					<span><?php woocommerce_template_single_price(); ?></span>
				</div><!-- .ashade-single-product--price -->
			</div><!-- .ashade-single-product--title -->
			<div class="ashade-single-product--excerpt">
				<?php woocommerce_template_single_excerpt(); ?>
			</div><!-- .ashade-single-product--excerpt -->
			<div class="ashade-single-product--qty">
				<?php woocommerce_template_single_add_to_cart(); ?>
			</div><!-- .ashade-single-product--qty -->
			<div class="ashade-single-product--tags">
				<?php echo wc_get_product_tag_list( $product->get_id(), '', '', '' ); ?>
			</div>
		</div><!-- .entry-summary -->
		<div class="clear"></div>
	</div><!-- .ashade-single-product--main -->
	<?php
	woocommerce_output_product_data_tabs();
	if ( Ashade_Core::get_mod( 'ashade-wc-nav' ) ) {
	?>
	<nav class="ashade-post-navigation-wrap has-prev has-next ashade-wc-single-nav">
	<?php
		$prev = get_previous_post();
		?>
		<div class="ashade-prev-post-link">
			<div class="ashade-post-nav-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="9.844" height="17.625" viewBox="0 0 9.844 17.625">
					<path id="angle-left" d="M2.25-17.812l1.125,1.125L-4.359-9,3.375-1.312,2.25-.187-6-8.437-6.469-9-6-9.562Z" transform="translate(6.469 17.813)" fill="#ffffff"/>
				</svg>
			</div>
			<h6>
				<span><?php echo esc_html__( 'Return to', 'ashade' ); ?></span>
				<?php echo esc_html__( 'Product Listing', 'ashade' ); ?>
			</h6>
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) ;?>"></a>
		</div>
		<?php
		$next = get_next_post();
		?>
		<div class="ashade-next-post-link">
			<h6>
				<span><?php echo esc_html__( 'Proceed To', 'ashade' ); ?></span>
				<?php echo esc_html__( 'Shopping Cart', 'ashade' ); ?>
			</h6>
			<div class="ashade-post-nav-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="9.844" height="17.625" viewBox="0 0 9.844 17.625">
					<path id="angle-right" d="M-2.25-17.812,6-9.562,6.469-9,6-8.437-2.25-.187-3.375-1.312,4.359-9l-7.734-7.687Z" transform="translate(3.375 17.813)" fill="#ffffff"/>
				</svg>
			</div>
			<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'cart' ) ) ) ;?>"></a>
		</div>
		<?php
	?>
	</nav><!-- .ashade-post-navigation-wrap -->
	<?php
	}
	add_filter( 'woocommerce_upsell_display_args', 'ashade_upsall_count' );
	if ( ! function_exists( 'ashade_upsall_count' ) ) {
		function ashade_upsall_count( $args ) { 
			$args[ 'posts_per_page' ] = Ashade_Core::get_mod( 'ashade-wc-related-columns' );
			$args[ 'columns' ] = Ashade_Core::get_mod( 'ashade-wc-related-columns' );
			return $args;
		}
	}

	woocommerce_upsell_display();
	$related_products = Ashade_Core::get_mod( 'ashade-wc-related' );
	if ( $related_products ) {
		$posts_per_page = Ashade_Core::get_mod( 'ashade-wc-related-columns' );
		$args = array(
			'posts_per_page' => $posts_per_page,
			'columns'        => $posts_per_page,
			'orderby'        => 'rand', // @codingStandardsIgnoreLine.
		);
		woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
	}
	?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
