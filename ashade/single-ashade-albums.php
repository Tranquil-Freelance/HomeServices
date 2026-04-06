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
	$back_state = Ashade_Core::get_prefer( 'ashade-back2top' );	
	$album_type = Ashade_Core::get_prefer( 'ashade-albums-type' );
	$gallery_type = Ashade_Core::get_rwmb( 'ashade-albums-media-type', 'images' );
	if ( 'mixed' == $gallery_type ) {
		$images = Ashade_Core::get_rwmb( 'ashade-albums-media' );
	} else if ( 'video' == $gallery_type ) {
		$images = Ashade_Core::get_rwmb( 'ashade-albums-video' );
	} else {
		$images = Ashade_Core::get_rwmb( 'ashade-albums-images' );
	}
    $content_layout = Ashade_Core::get_prefer( 'ashade-albums-content-layout' );	
	$next_post_link = Ashade_Core::get_mod( 'ashade-albums-next-post' );
    
	if ( ! empty($images) ) {
		if ( 'ribbon' == $album_type ) {
			# Ribbon Gallery
			$ribbon_style = Ashade_Core::get_prefer( 'ashade-albums-ribbon-layout' );
			if ( 'vertical' == $ribbon_style ) {
				$title_state = Ashade_Core::get_prefer( 'ashade-albums-rtitle' );
				if ( $title_state ) {
					get_template_part( 'template-parts/page-title' );
				}
				?>
				<div id="album-<?php the_ID(); ?>" <?php post_class( 'ashade-albums-carousel-wrap' ); ?>>
				<?php
					get_template_part( 'template-parts/albums/ribbon' );
				?>
				</div><!-- .ashade-albums-carousel-wrap -->
				<?php
				if ( $back_state ) {
					get_template_part( 'template-parts/back-to-top' );
				}
				get_template_part( 'template-parts/footer-part' ); 
			} else {
				?>
				<div id="album-<?php the_ID(); ?>" <?php post_class( 'ashade-albums-carousel-wrap' ); ?>>
				<?php
					get_template_part( 'template-parts/albums/ribbon' );
				?>
				</div><!-- .ashade-albums-carousel-wrap -->
				<?php
				get_template_part( 'template-parts/footer-part' ); 
			}
		} else if ( 'slider' == $album_type ) {
			# Slider Gallery	
			$title_state = Ashade_Core::get_prefer( 'ashade-albums-title' );
			if ( $title_state ) {
				get_template_part( 'template-parts/page-title' );
			}
			?>
			<div id="album-<?php the_ID(); ?>" <?php post_class( 'ashade-albums-slider-wrap' ); ?>>
			<?php
				get_template_part( 'template-parts/albums/slider' );
				get_template_part( 'template-parts/footer-part' ); 
			?>
			</div><!-- .ashade-albums-slider-wrap -->
			<?php
		} else {
			# Grid Galleries
			$title_state = Ashade_Core::get_prefer( 'ashade-albums-title' );
			$content_position = Ashade_Core::get_rwmb( 'ashade-albums-content-position', 'none' );
			// Vertical Page Title
			if ( $title_state && 'vertical' == $layout ) {
				get_template_part( 'template-parts/page-title' );
			}
			?>
			<main id="album-<?php the_ID(); ?>" <?php post_class( 'ashade-content-wrap ashade-content--' . esc_attr( $content_layout ) ) ?>>
				<div class="ashade-content-scroll">
					<?php
						if ( $title_state && 'horizontal' == $layout ) {
							get_template_part( 'template-parts/page-title' );
						}
					?>
					<div class="ashade-content">
					<?php
					$album_intro = Ashade_Core::get_rwmb( 'ashade-albums-intro' );
					$album_intro_align = Ashade_Core::get_rwmb( 'ashade-albums-intro-align' );
					
					if ( 'top' == $content_position ) {
						echo '<div class="ashade-albums-el-content">';
						the_content();
						echo '</div><!-- .ashade-albums-el-content -->';
					}

					if ( ! empty( $album_intro )) {
						?>
						<section class="ashade-section">
							<div class="ashade-row">
								<div class="ashade-col col-12">
									<p class="ashade-intro align-<?php echo esc_attr( $album_intro_align ); ?>"><?php echo nl2br( esc_html( $album_intro ) ); ?></p>
								</div><!-- .ashade-col -->
							</div><!-- .ashade-row -->
						</section><!-- .ashade-section -->
						<?php
					}

					if ( 'middle' == $content_position ) {
						echo '<div class="ashade-albums-el-content">';
						the_content();
						echo '</div><!-- .ashade-albums-el-content -->';
					}

					if ( 'grid' == $album_type ) {
						# Grid Gallery
						get_template_part( 'template-parts/albums/grid' );
					}
					if ( 'masonry' == $album_type ) {
						# Masonry Gallery
						get_template_part( 'template-parts/albums/masonry' );
					}
					if ( 'adjusted' == $album_type ) {
						# Adjusted Gallery
						get_template_part( 'template-parts/albums/adjusted' );
					}
					if ( 'bricks' == $album_type ) {
						# Bricks Gallery
						get_template_part( 'template-parts/albums/bricks' );
					}
					if ( 'justified' == $album_type ) {
						# Justified Gallery
						get_template_part( 'template-parts/albums/justified' );
					}
					if ( 'bottom' == $content_position ) {
						echo '<div class="ashade-albums-el-content">';
						the_content();
						echo '</div><!-- .ashade-albums-el-content -->';
					}
					
					// Next Post
					if ( $next_post_link ) {
						get_template_part( 'template-parts/albums/next-post' );
					}
					
					// Comments
					if ( Ashade_Core::get_prefer( 'ashade-albums-comments' ) ) {
						comments_template();
					}
					?>
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
			</main><!-- .ashade-content-wrap -->
			<?php 
			if ( $back_state && 'vertical' == $layout ) {
				get_template_part( 'template-parts/back-to-top' );
			}
		}
	} else {
		$title_state = Ashade_Core::get_prefer( 'ashade-albums-title' );
        if ( $title_state && 'vertical' == $layout ) {
            get_template_part( 'template-parts/page-title' );
        }
		?>
		<main id="album-<?php the_ID(); ?>" <?php post_class( 'ashade-content-wrap' ); ?>>
				<div class="ashade-content-scroll">
					<?php
						if ( $title_state && 'horizontal' == $layout ) {
							get_template_part( 'template-parts/page-title' );
						}
					?>
					<div class="ashade-content">
						<?php
						$content_position = Ashade_Core::get_rwmb( 'ashade-albums-content-position', 'none' );
						if ( 'top' == $content_position || 'middle' == $content_position ) {
							echo '<div class="ashade-albums-el-content">';
							the_content();
							echo '</div><!-- .ashade-albums-el-content -->';
						}
						if ( 'bottom' == $content_position ) {
							echo '<div class="ashade-albums-el-content">';
							the_content();
							echo '</div><!-- .ashade-albums-el-content -->';
						}
						?>
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
		</main><!-- .ashade-content-wrap -->
		<?php
        if ( $back_state && 'vertical' == $layout ) {
            get_template_part( 'template-parts/back-to-top' );
        }
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