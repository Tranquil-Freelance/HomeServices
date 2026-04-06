<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 * Template Name: Ashade Home Template
 */

get_header();
the_post();
?>
    <main id="page-<?php the_ID(); ?>" <?php post_class( 'ashade-content-wrap' ); ?>>
        <div class="ashade-content-scroll">
            <div class="ashade-content">
                <div class="ashade-row">
                    <div class="ashade-col col-12">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
            <?php get_template_part( 'template-parts/footer-part' ); ?>
        </div>
    </main>
<?php

get_template_part( 'template-parts/aside' );
get_template_part( 'template-parts/page-ui' );

get_footer();