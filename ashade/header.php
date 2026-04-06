<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<?php 
	if ( Ashade_Core::get_fimage_url() ) { 
    	$featured_image_meta = wp_get_attachment_metadata( get_post_thumbnail_id() );
	?>
		<meta property="og:image" content="<?php echo esc_url( Ashade_Core::get_fimage_url() ); ?>" />
		<meta property="og:image:width" content="<?php esc_attr( $featured_image_meta[ 'width' ] ); ?>" />
		<meta property="og:image:height" content="<?php esc_attr( $featured_image_meta[ 'height' ] ); ?>" />
	<?php }	?>
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<?php
	# Maintenance Mode
	if ( Ashade_Core::get_maintenance_status() && ! current_user_can( 'edit_posts' ) ) {
		get_template_part( 'template-parts/maintenance' );
		wp_footer();
		echo '</body>';
		echo '</html>';
		die();
	}
	?>
    <?php get_template_part( 'template-parts/header-part' ); ?>
