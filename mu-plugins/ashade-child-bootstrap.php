<?php
/**
 * Plugin Name: Ashade Child bootstrap
 * Description: Loads child theme starter/migration code before themes run so it works even when Ashade parent is active. Enables Render headless auto-setup (ASHADE_CHILD_AUTO_SETUP).
 *
 * @package Ashade_Child
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ashade_child_setup = WP_CONTENT_DIR . '/themes/ashade-child/inc/site-setup.php';
if ( is_readable( $ashade_child_setup ) ) {
	require_once $ashade_child_setup;
}
