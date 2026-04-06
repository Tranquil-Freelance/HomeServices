<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
$ashade_sidebar = Ashade_Core::get_sidebar_position();
if ( 'none' == $ashade_sidebar || !is_active_sidebar( 'ashade-sidebar' ) ) {
	return;
}
?>
<div class="ashade-col col-3">
	<aside id="ashade-sidebar">
		<?php 
			if ( class_exists( 'WooCommerce' ) && is_woocommerce() ) {
				dynamic_sidebar( 'ashade-wc-sidebar' ); 
			} else {
				dynamic_sidebar( 'ashade-sidebar' ); 
			}
		?>
	</aside><!-- #ashade-sidebar -->
</div><!-- .ashade-col -->
