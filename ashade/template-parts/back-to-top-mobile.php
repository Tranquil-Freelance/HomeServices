<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( Ashade_Core::get_mod( 'ashade-back2top-mobile' ) ) {
?>
    <!-- Back to Top Mobile -->
    <div class="ashade-to-top-wrap ashade-back-wrap ashade-mobile-b2t">
        <div class="ashade-back is-to-top">
            <span><?php echo esc_html__( 'Back to', 'ashade' ); ?></span>
            <span><?php echo esc_html__( 'Top', 'ashade' ); ?></span>
        </div>
    </div>
<?php 
}
?>