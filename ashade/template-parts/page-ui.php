<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( Ashade_Core::get_mod( 'ashade-aside-state' ) ) {
	echo '<div class="ashade-aside-overlay"></div>';
}
if ( Ashade_Core::get_mod( 'ashade-magic-cursor' ) ) {
	?>
	<div class="ashade-cursor is-inactive">
    	<span class="ashade-cursor-circle"></span>
    	<span class="ashade-cursor-slider">
    		<svg xmlns="http://www.w3.org/2000/svg" width="9.844" height="17.625" viewBox="0 0 9.844 17.625" class="ashade-cursor-prev">
  				<path d="M2.25-17.812l1.125,1.125L-4.359-9,3.375-1.312,2.25-.187-6-8.437-6.469-9-6-9.562Z" transform="translate(6.469 17.813)" fill="#fff"/>
			</svg>
   			<svg xmlns="http://www.w3.org/2000/svg" width="9.844" height="17.625" viewBox="0 0 9.844 17.625" class="ashade-cursor-next">
  				<path d="M-2.25-17.812,6-9.562,6.469-9,6-8.437-2.25-.187-3.375-1.312,4.359-9l-7.734-7.687Z" transform="translate(3.375 17.813)" fill="#fff"/>
			</svg>
    	</span>
    	<span class="ashade-cursor-close ashade-cursor-label"><?php echo esc_html__( 'Close', 'ashade' ); ?></span>
    	<span class="ashade-cursor-zoom ashade-cursor-label"><?php echo esc_html__( 'Zoom', 'ashade' ); ?></span>
    </div>
	<?php
}
?>
<div class="ashade-menu-overlay"></div>
