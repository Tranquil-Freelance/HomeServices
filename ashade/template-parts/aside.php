<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( Ashade_Core::get_mod( 'ashade-aside-state' ) ) {
	?>
	<aside id="ashade-aside">
       	<a href="#" class="ashade-aside-close"><?php echo esc_html__( 'Close Sidebar', 'ashade' ); ?></a>
        <div class="ashade-aside-inner">
        	<div class="ashade-aside-content">
       			<?php dynamic_sidebar( 'ashade-aside-bar' ); ?>
        	</div><!-- .ashade-aside-content -->
        </div><!-- .ashade-aside-inner -->
    </aside>
	<?php
}
?>