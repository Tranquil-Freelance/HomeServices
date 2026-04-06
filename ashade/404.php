<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
get_header();
?>
    <div 
        class="ashade-404-background ashade-page-background" 
        data-src="<?php echo esc_url( Ashade_Core::get_mod( 'ashade-404-bg' ) ); ?>" 
        data-opacity="<?php echo absint( Ashade_Core::get_mod( 'ashade-404-opacity' ) )/100; ?>">
    </div>
    <div class="ashade-404-wrap">
        <div class="ashade-404-inner">
            <div class="ashade-404-return-wrap ashade-back-wrap">
                <div class="ashade-back is-404-return" data-home="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <span><?php echo esc_html__( 'Previous Page', 'ashade' ); ?></span>
                    <span><?php echo esc_html__( 'Return', 'ashade' ); ?></span>
                </div>
            </div><!-- .ashade-404-return-wrap -->
            <div class="ashade-404-text">
                <h1><?php echo esc_html__( '404', 'ashade' ); ?></h1>
                <span><?php echo esc_html__( 'Oops! Page not found', 'ashade' ); ?></span>
            </div><!-- .ashade-404-text -->
            <div class="ashade-404-home-wrap ashade-back-wrap">
                <div class="ashade-back is-404-home" data-href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <span><?php echo esc_html__( 'Return To', 'ashade' ); ?></span>
                    <span><?php echo esc_html__( 'Home', 'ashade' ); ?></span>
                </div>
            </div><!-- .ashade-404-home-wrap -->
        </div><!-- .ashade-404-inner -->
    </div><!-- .ashade-404-wrap -->
<?php
get_template_part( 'template-parts/footer-part' );
get_template_part( 'template-parts/aside' );
get_template_part( 'template-parts/page-ui' );

get_footer();
