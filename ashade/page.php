<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! post_password_required() ) {
	$ashade_sidebar = Ashade_Core::get_sidebar_position();
	$layout = Ashade_Core::get_prefer( 'ashade-title-layout' );
	$title_state = Ashade_Core::get_prefer( 'ashade-page-title' );
	$back_state = Ashade_Core::get_prefer( 'ashade-back2top' );
	if ( class_exists( 'WooCommerce' ) && ( is_cart() || is_checkout() || is_account_page() ) ) {
		$ashade_sidebar = 'none';
	}
	get_header();
	the_post();
	if ( $title_state && 'vertical' == $layout ) {
		get_template_part( 'template-parts/page-title' );
	}
	?>
		<main id="page-<?php the_ID(); ?>" <?php post_class( 'ashade-content-wrap' ); ?>>
			<div class="ashade-content-scroll">
				<?php
					if ( $title_state && 'horizontal' == $layout ) {
						get_template_part( 'template-parts/page-title' );
					}
				?>
				<div class="ashade-content">
					<div class="ashade-row <?php echo ( 'left' == $ashade_sidebar ? 'is-reverse' : '' ); ?>">
						<div class="ashade-col col-<?php echo ( 'none' == $ashade_sidebar ? '12' : '9' ); ?>">
							<?php 
								if ( class_exists( 'WooCommerce' ) && is_account_page() ) {
									echo '<div class="ashade-wc-account-wrap">';
									the_content(); 
									echo '</div>';
								} else {
									the_content(); 
								}
							?>
							<!-- Post Navs -->
							<div class="clear"></div>
							<nav class="ashade-post-nav"><?php wp_link_pages(); ?></nav>
							<!-- Post Comments -->
							<?php
							// If comments are open or we have at least one comment, load up the comment template.
							if ( Ashade_Core::get_prefer( 'ashade-page-comments' ) ) {
								comments_template();
							}
							?>
						</div><!-- .ashade-col -->
						<?php get_sidebar(); ?>
					</div><!-- .ashade-row -->
				</div><!-- .ashade-content -->
				<?php 
				if ( $back_state && 'horizontal' == $layout ) {
					get_template_part( 'template-parts/back-to-top' );
				}
				if ( $back_state && 'vertical' == $layout ) {
					get_template_part( 'template-parts/back-to-top-mobile' );
				}
				get_template_part( 'template-parts/footer-part' ); 
				?>
			</div><!-- .ashade-content-scroll -->
		</main>
	<?php

	if ( $back_state && 'vertical' == $layout ) {
		get_template_part( 'template-parts/back-to-top' );
	}

	get_template_part( 'template-parts/aside' );
	get_template_part( 'template-parts/page-ui' );

	get_footer();
} else {
	# Protected Page
	get_header();
	get_template_part( 'template-parts/protected' );
	get_template_part( 'template-parts/aside' );
	get_template_part( 'template-parts/page-ui' );
	get_footer();
}