<?php
/**
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

require_once get_stylesheet_directory() . '/inc/site-setup.php';

# Enqueue Styles and Scripts
if ( ! function_exists( 'ashade_child_enqueue_styles' ) ) {
	add_action( 'wp_enqueue_scripts', 'ashade_child_enqueue_styles' );
	function ashade_child_enqueue_styles() {
		# Define Parent Style
		$parent_style = 'ashade-style-parent';
		wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );

		# Define Child Styles
		$child_style_path = get_stylesheet_directory() . '/style.css';
		wp_enqueue_style( 'ashade-style-child',
			get_stylesheet_directory_uri() . '/style.css',
			array( $parent_style ),
			file_exists( $child_style_path ) ? filemtime( $child_style_path ) : wp_get_theme()->get( 'Version' )
		);

		# Define Child Script
		$child_script_path = get_stylesheet_directory() . '/js/ashade-child.js';
		wp_enqueue_script(
			'ashade-child-js',
			get_stylesheet_directory_uri() . '/js/ashade-child.js',
			array( 'jquery' ),
			file_exists( $child_script_path ) ? filemtime( $child_script_path ) : wp_get_theme()->get( 'Version' ),
			true
		);
	}
}
