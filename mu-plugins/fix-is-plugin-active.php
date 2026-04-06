<?php
/**
 * Fix: Ensure is_plugin_active() is available early for Elementor.
 */
if ( ! function_exists( 'is_plugin_active' ) ) {
    require_once ABSPATH . 'wp-admin/includes/plugin.php';
}
