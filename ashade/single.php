<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! post_password_required() ) {
	get_header();
	the_post();
	$ashade_sidebar = Ashade_Core::get_sidebar_position();
	$layout = Ashade_Core::get_prefer( 'ashade-title-layout' );
	$title_state = Ashade_Core::get_prefer( 'ashade-post-title' );
	$back_state = Ashade_Core::get_prefer( 'ashade-back2top' );

	if ( $title_state && 'vertical' == $layout ) {
		get_template_part( 'template-parts/page-title' );
	}
	?>
		<main id="post-<?php the_ID(); ?>" <?php post_class( 'ashade-content-wrap' ); ?>>
			<div class="ashade-content-scroll">
				<?php
					if ( $title_state && 'horizontal' == $layout ) {
						get_template_part( 'template-parts/page-title' );
					}
				?>
				<div class="ashade-content">
					<div class="ashade-row <?php echo ( 'left' == $ashade_sidebar ? 'is-reverse' : '' ); ?>">
						<div class="ashade-col col-<?php echo ( 'none' == $ashade_sidebar ? '12' : '9' ); ?>">
							<!-- Post Featured Image -->
							<?php
							if ( Ashade_Core::get_prefer( 'ashade-post-image' ) && Ashade_Core::get_fimage_url() ) {
								$featured_image_url = Ashade_Core::get_fimage_url();
								echo '
								<div class="ashade-post-featured-image">
									<img src="'. wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' ) . '" alt="' . esc_attr( get_the_title() ) . '">
								</div>
								';
							}
							?>

							<!-- Post Content -->
							<div class="ashade-post-content-wrap">
								<div class="ashade-post-content">
									<?php the_content(); ?>
								</div>
								<div class="clear"></div>
								<nav class="ashade-post-nav">
									<?php wp_link_pages(); ?>
								</nav>
							</div>

							<?php if ( Ashade_Core::get_prefer( 'ashade-post-meta-tags' ) ) { ?>
							<!-- Post Tags -->
							<div class="ashade-post-footer">
								<div class="ashade-post__tags"><?php the_tags( '', '', '' ); ?></div>
							</div><!-- .ashade-post-footer -->
							<?php } ?>

							<?php if ( Ashade_Core::get_prefer( 'ashade-post-nav' ) ) { ?>
							<!-- Post Navigation -->
							<nav class="ashade-post-navigation-wrap <?php echo ( strlen( get_previous_post_link() ) > 0 ? 'has-prev' : '' ) . ' ' . ( strlen( get_next_post_link() ) > 0 ? 'has-next' : '' ); ?>"><?php
								if ( strlen(get_previous_post_link()) > 0 ) {
									$prev = get_previous_post();
									?>
									<div class="ashade-prev-post-link">
										<div class="ashade-post-nav-icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="9.844" height="17.625" viewBox="0 0 9.844 17.625">
												<path id="angle-left" d="M2.25-17.812l1.125,1.125L-4.359-9,3.375-1.312,2.25-.187-6-8.437-6.469-9-6-9.562Z" transform="translate(6.469 17.813)" fill="#ffffff"/>
											</svg>
										</div>
										<h6>
											<span><?php echo esc_html__( 'Previous Post', 'ashade' ); ?></span>
											<?php echo get_the_title( $prev->ID ); ?>
										</h6>
										<a href="<?php echo esc_url( get_permalink( $prev->ID ) ); ?>" title="<?php echo esc_attr( get_the_title( $prev->ID ) ); ?>"></a>
									</div>
									<?php
								}
								if ( strlen( get_next_post_link() ) > 0 ) {
									$next = get_next_post();
									?>
									<div class="ashade-next-post-link">
										<h6>
											<span><?php echo esc_html__( 'Next Post', 'ashade' ); ?></span>
											<?php echo get_the_title( $next->ID ); ?>
										</h6>
										<div class="ashade-post-nav-icon">
											<svg xmlns="http://www.w3.org/2000/svg" width="9.844" height="17.625" viewBox="0 0 9.844 17.625">
												<path id="angle-right" d="M-2.25-17.812,6-9.562,6.469-9,6-8.437-2.25-.187-3.375-1.312,4.359-9l-7.734-7.687Z" transform="translate(3.375 17.813)" fill="#ffffff"/>
											</svg>
										</div>
										<a href="<?php echo esc_url( get_permalink( $next->ID ) ); ?>" title="<?php echo esc_attr( get_the_title( $next->ID ) ); ?>"></a>
									</div>
									<?php
								}
							?></nav><!-- .ashade-post-navigation-wrap -->
							<?php } ?>
							<!-- Post Comments -->
							<?php
							// If comments are open or we have at least one comment, load up the comment template.
							if ( Ashade_Core::get_prefer( 'ashade-post-comments' ) ) {
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