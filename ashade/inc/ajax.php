<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'ashade_reset_mods' ) ) {
	add_action( 'wp_ajax_ashade_reset_mods', 'ashade_reset_mods' );
	add_action( 'wp_ajax_nopriv_ashade_reset_mods', 'ashade_reset_mods' );
    
	function ashade_reset_mods() {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_attr__( 'Your permissions level is not enough to enter this page.', 'ashade' ) );
		} else {
            remove_theme_mods();
        }
		
		die( esc_attr__( 'Theme Settings has reset to defaults.', 'ashade' ) );
	}
}

add_action('wp_ajax_ashade_client_approval', 'ashade_client_approval');
add_action('wp_ajax_nopriv_ashade_client_approval', 'ashade_client_approval');
if ( ! function_exists( 'ashade_client_approval' ) ) {
	function ashade_client_approval()
	{
		# Get $_POST variables
		$post_id = absint( $_POST[ 'post_id' ] );
		$item_id = absint( $_POST[ 'item_id' ] );
		$event = esc_attr( $_POST[ 'event' ] );
		$option = get_option( 'ashade_client_images' );
		
		# Check, if option is set before
		if ( ! $option ) {
			add_option( 'ashade_client_images' );
		}
		
		# Work with Option
		if ( 'delete' == $event ) {
			delete_option( 'ashade_client_images' );
		} else {
			if ( 'reset' == $event ) {
				unset( $option[ $post_id ][ $item_id ] );
			} else {
				$option[ $post_id ][ $item_id ] = esc_attr( $event );
			}
			update_option( 'ashade_client_images', $option );
		}

		# Exit
		die($option);
	}
}

if ( class_exists( 'WooCommerce' ) ) {
	# WooCommerce Functions
	if ( ! function_exists( 'ashade_update_cart' ) ) {
		add_action( 'wp_ajax_ashade_update_cart', 'ashade_update_cart' );
		add_action( 'wp_ajax_nopriv_ashade_update_cart', 'ashade_update_cart' );
		
		function ashade_update_cart() {
			global $woocommerce;
			$count = $woocommerce->cart->get_cart_contents_count();
			echo esc_attr( $count );
			die();
		}
	}
}
?>