<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;
?>
    <!-- Back to Top -->
    <div class="ashade-to-top-wrap ashade-back-wrap">
        <div class="ashade-back is-to-top">
            <span><?php echo esc_html__( 'Back to', 'ashade' ); ?></span>
            <span><?php echo esc_html__( 'Top', 'ashade' ); ?></span>
        </div>
        <?php 
        if ( is_single() && 'ashade-albums' == get_post_type() && Ashade_Core::get_mod( 'ashade-albums-back-state' ) ) {
            ?>
            <div class="ashade-back albums-go-back">
                <span><?php echo esc_html__( 'Return', 'ashade' ); ?></span>
                <span><?php echo esc_html__( 'Back', 'ashade' ); ?></span>
            </div>
            <?php
        }
        ?>
    </div>