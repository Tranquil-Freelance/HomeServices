<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

# Classes
require_once( get_template_directory() . '/inc/classes/class-base.php' );

# Customizer CSS
require_once( get_template_directory() . '/inc/custom-css.php' );

# TGM
require_once( get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php' );
require_once( get_template_directory() . '/inc/tgm/tgm-plugin-register.php' );

# Metaboxes
require_once( get_template_directory() . '/inc/metabox.php' );

# AJAX Functions
require_once( get_template_directory() . '/inc/ajax.php' );

# WooCommerce Functions
if ( class_exists( 'WooCommerce' ) ) {
	require_once( get_template_directory() . '/woocommerce/woo-core.php' );	
}

?>