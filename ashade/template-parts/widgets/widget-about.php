<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$about_data = get_query_var( 'shadow_about' );
?>
<div class="ashade-widget--about">
	<div class="ashade-widget--about__head">
		<?php
		if ( ! empty( $about_data[ 'image_id' ] ) ) {
			$image_url = wp_get_attachment_image_url( $about_data[ 'image_id' ], 'large' );
			$thmb_width = 300;
			$thmb_height = 300;
			?>
			<div class="ashade-image ashade-div-image" data-src="<?php echo esc_url( $image_url ); ?>">
				<img
					src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20<?php echo absint( $thmb_width ); ?>%20<?php echo absint( $thmb_height ); ?>'%3E%3C/svg%3E" 
					width=<?php echo absint( $thmb_width ); ?> 
					height=<?php echo absint( $thmb_height ); ?> 
					alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ); ?>">
			</div><!-- .ashade-div-image -->
			<?php
		}
		?>
		<h5>
			<span><?php echo esc_html( ! empty( $about_data[ 'caption' ] ) ? $about_data[ 'caption' ] : '' ); ?></span>
			<?php echo esc_html( ! empty( $about_data[ 'title' ] ) ? $about_data[ 'title' ] : '' ); ?>
		</h5>
	</div>
	<div class="ashade-widget--about__content"><?php echo wp_specialchars_decode( ! empty( $about_data[ 'descr' ] ) ? $about_data[ 'descr' ] : '' ); ?></div>
</div>