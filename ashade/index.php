<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
$layout = Ashade_Core::get_mod( 'ashade-title-layout' );
$title_state = Ashade_Core::get_mod( 'ashade-page-title' );
$ashade_sidebar = Ashade_Core::get_sidebar_position();
$back_state = Ashade_Core::get_mod( 'ashade-back2top' );

get_header();

if ( $title_state && 'vertical' == $layout ) {
	get_template_part( 'template-parts/page-title' );
}
?>
	<main class="ashade-content-wrap">
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
						if ( is_home() && ! is_front_page() ) :
								?>
								<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
								<?php
							endif;
						?>
						<div class="ashade-blog-listing">
						<?php
						if ( have_posts() ) :

							/* Start the Loop */
							while ( have_posts() ) :
								the_post();
								get_template_part( 'template-parts/post-listing' );

							endwhile;

							echo get_the_posts_pagination( array(
								'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="9.844" height="17.625" viewBox="0 0 9.844 17.625"><path id="angle-left" d="M2.25-17.812l1.125,1.125L-4.359-9,3.375-1.312,2.25-.187-6-8.437-6.469-9-6-9.562Z" transform="translate(6.469 17.813)" fill="#ffffff"/></svg>',
								'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="9.844" height="17.625" viewBox="0 0 9.844 17.625"><path id="angle-right" d="M-2.25-17.812,6-9.562,6.469-9,6-8.437-2.25-.187-3.375-1.312,4.359-9l-7.734-7.687Z" transform="translate(3.375 17.813)" fill="#ffffff"/></svg>',
							) );
						else :
							# Show when no posts found
							echo '<p>' . esc_html__( 'You do not have any posts. Create your first post to show here.', 'ashade' ) . '</p>';
						endif;
						?>
						</div><!-- .ashade-blog-listing -->
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
