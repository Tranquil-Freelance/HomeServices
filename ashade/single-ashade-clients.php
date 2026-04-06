<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! post_password_required() ) {
	get_header();
	the_post();
	
	$layout = Ashade_Core::get_prefer( 'ashade-title-layout' );
	$title_state = Ashade_Core::get_prefer( 'ashade-client-title' );
	$back_state = Ashade_Core::get_prefer( 'ashade-back2top' );
	$lazy_state = Ashade_Core::get_mod( 'ashade-lazy-loader' );
	
	$bg_state = Ashade_Core::get_rwmb( 'ashade-client-bg-state' );
	if ( 'custom' == $bg_state ) {
		$bg_image = Ashade_Core::get_rwmb( 'ashade-client-bg-image' );
		if ( ! empty( $bg_image ) ) {
            foreach ( $bg_image as $item ) {
                $bg_image_url = wp_get_attachment_url( $item[ 'ID' ] );
            }
        } else {
            $bg_image_url = '';
        }
	}
	if ( 'featured' == $bg_state ) {
		$bg_image_url = Ashade_Core::get_fimage_url();
	}
	
	if ( 'none' !== $bg_state ) {
		$bg_opacity = Ashade_Core::get_rwmb( 'ashade-client-bg-opacity' );
		?>
		<div 
            class="ashade-page-background" 
            data-opacity="<?php echo absint( $bg_opacity )/100; ?>" 
            <?php echo ( ! empty( $bg_image_url ) ? 'data-src="' . esc_url( $bg_image_url ) . '"' : null ); ?>>
        </div><!-- .ashade-home-background -->
		<?php
	}

	$content_position = Ashade_Core::get_rwmb( 'ashade-client-content-position', 'none' );
	
	$images = Ashade_Core::get_rwmb( 'ashade-client-images' );
	$gallery_type = Ashade_Core::get_prefer( 'ashade-client-type' );
	if ( 'masonry' == $gallery_type )  {
		wp_enqueue_script( 'masonry' );
	}
	if ( 'bricks' == $gallery_type )  {
		if ( 'default' == Ashade_Core::get_rwmb( 'ashade-client-type' ) ) {
			$gallery_layout = 'is-' . Ashade_Core::get_mod( 'ashade-client-layout' );
		} else {
			$gallery_layout = 'is-' . Ashade_Core::get_rwmb( 'ashade-client-layout' );
		}
	} else {
		if ( 'default' == Ashade_Core::get_rwmb( 'ashade-client-type' ) ) {
			$gallery_layout = 'ashade-grid-' . Ashade_Core::get_mod( 'ashade-client-columns' ) . 'cols';
		} else {
			$gallery_layout = 'ashade-grid-' . Ashade_Core::get_rwmb( 'ashade-client-columns' ) . 'cols';
		}
	}
	$gallery_caption = Ashade_Core::get_prefer( 'ashade-client-caption' );
	$caption_type = Ashade_Core::get_prefer( 'ashade-client-caption-type', 'caption' );
	
	$filter_state = Ashade_Core::get_prefer( 'ashade-client-filter' );
	$filter_counters = Ashade_Core::get_prefer( 'ashade-client-filter-counter' );
	$button_approval = Ashade_Core::get_prefer( 'ashade-client-btns-approval' );
	$button_zoom = Ashade_Core::get_prefer( 'ashade-client-btns-zoom' );
	$button_download = Ashade_Core::get_prefer( 'ashade-client-btns-download' );
	$button_state = Ashade_Core::get_prefer( 'ashade-client-btns-state' );
	
	if ( 'custom' == Ashade_Core::get_rwmb( 'ashade-client-email-state' ) ) {
		$email_address = Ashade_Core::get_rwmb( 'ashade-client-email' );
	} else {
		$email_address = Ashade_Core::get_mod( 'ashade-client-email' );
	}
	$includes = Ashade_Core::get_prefer( 'ashade-client-includes' );

	$client_data = array(
		'mailto'   => $email_address,
		'includes' => ( Ashade_Core::get_prefer( 'ashade-client-includes' ) ? 'yes' : 'no' ),
		'from' 	   => get_bloginfo( 'name' ),
		'subject'  => esc_attr__( 'Client Notification', 'ashade' ),
		'message'  => get_the_title() . ' ' . esc_attr__( 'has finished work with photos selection. Client page link is: ', 'ashade' ),
		'url' 	   => '',
		'images'   => '',
		'photos_title'  => esc_attr__( 'List of approved items:', 'ashade' ),
		'no_photos'     => esc_attr__( 'Client does not approve any photo.', 'ashade' ),
		'done_message'  => esc_attr__( 'Notification was sent.', 'ashade' ),
		'error_message' => esc_attr__( 'Error occurred. Notification was not sent.', 'ashade' ),
	);

	$gallery_id = 'ashade-client-' . mt_rand( 0, 99999 );

	if ( $title_state && 'vertical' == $layout ) {
		get_template_part( 'template-parts/page-title' );
	}
	?>
		<main id="client-<?php the_ID(); ?>" <?php post_class( 'ashade-content-wrap' ); ?>>
			<div class="ashade-content-scroll">
				<?php
					if ( $title_state && 'horizontal' == $layout ) {
						get_template_part( 'template-parts/page-title' );
					}
				?>
				<div class="ashade-content">
					<?php
					# Top Elementor Content
					if ( 'top' == $content_position ) {
						echo '<div class="ashade-clients-el-content">';
						the_content();
						echo '</div><!-- .ashade-clients-el-content -->';
					}
					$intro = Ashade_Core::get_rwmb( 'ashade-client-intro' );
					$intro_align = Ashade_Core::get_rwmb( 'ashade-client-intro-align' );
					if ( ! empty( $intro )) {
					?>
					<section class="ashade-section">
						<div class="ashade-row">
							<div class="ashade-col col-12">
								<p class="ashade-intro align-<?php echo esc_attr( $intro_align ); ?>"><?php echo nl2br( esc_html( $intro ) ); ?></p>
							</div><!-- .ashade-col -->
						</div><!-- .ashade-row -->
					</section><!-- .ashade-section -->
					<?php 
					}

					# Middle Elementor Content
					if ( 'middle' == $content_position ) {
						echo '<div class="ashade-clients-el-content">';
						the_content();
						echo '</div><!-- .ashade-clients-el-content -->';
					}

					# Filter State
					if ( $filter_state ) { ?>
					<!-- Client Gallery Filter -->
						<div class="ashade-filter-wrap <?php echo esc_attr( $filter_counters ? 'ashade-filter-counters' : '' ); ?>" data-id="<?php echo esc_attr( $gallery_id ); ?>" data-label="<?php echo esc_attr__( 'Filter', 'ashade' ); ?>">
							<a href="#" data-category="*" class="is-active"><?php echo esc_html__( 'All', 'ashade' ); ?></a>
							<a href="#" data-category=".is-liked"><?php echo esc_html__( 'Accepted', 'ashade' ); ?></a>
							<a href="#" data-category=".is-disliked"><?php echo esc_html__( 'Rejected', 'ashade' ); ?></a>
							<a href="#" data-category=".is-unviewed"><?php echo esc_html__( 'Unverified', 'ashade' ); ?></a>
						</div><!-- .ashade-filter-wrap -->
					<?php } ?>

					<!-- Client Gallery Section -->
					<?php
					$client_option = get_option( 'ashade_client_images' );
					if ( 'bricks' == $gallery_type )  {
					# Bricks (Disabled)
						$counter = 0;
					?>
					<div class="
							ashade-gallery-bricks ashade-client-grid ashade-grid-caption--<?php echo esc_attr( $gallery_caption ); ?> 
							ashade-client-buttons--<?php echo esc_attr( $button_state ? 'visible' : 'hover' ); ?>   
							<?php echo esc_attr( $gallery_layout ); ?>">
					<?php
					} else {
					# Grid / Masonry / Adjusted
					?>
					<div class="
							ashade-grid ashade-client-grid ashade-grid-caption--<?php echo esc_attr( $gallery_caption ); ?> 
							ashade-client-buttons--<?php echo esc_attr( $button_state ? 'visible' : 'hover' ); ?> 
							<?php echo ( esc_attr( $filter_state ) ? 'has-filter' : '' ); ?> 
							<?php echo esc_attr( $gallery_layout ); ?> 
							<?php echo ( 'masonry' == $gallery_type ? 'is-masonry' : '' ); ?> 
							<?php echo ( 'adjusted' == $gallery_type ? 'ashade-gallery-adjusted' : '' ); ?>" data-id="<?php echo esc_attr( get_the_ID() ); ?>" id="<?php echo esc_attr( $gallery_id ); ?>">
					<?php						
					}
					
					foreach ( $images as $item ) {
						$bricks_class = '';
						$image_post = get_post( $item[ 'ID' ] );
						if ( 'title' == $caption_type ) {
							$image_caption = $image_post->post_title;
						} else if ( 'descr' == $caption_type ) {
							$image_caption = $image_post->post_content;
						} else {
							$image_caption = $image_post->post_excerpt;
						}
						$meta = wp_get_attachment_metadata( $item[ 'ID' ] );
						$original_image_width = $meta[ 'width' ];
						$original_image_height = $meta[ 'height' ];
						$original_image_ratio = $original_image_height/$original_image_width;
						$current_state = '';

						$current_state = 'is-unviewed';

						if ( is_array ( $client_option ) ) {
							if ( ! array_key_exists( get_the_ID(), $client_option ) ) {
								$client_option[ get_the_ID() ] = Array();
							}
							$this_client_option = $client_option[ get_the_ID() ];
							if ( isset( $this_client_option[ $item[ 'ID' ] ] ) ) {
								if ( 'like' ==  $this_client_option[ $item[ 'ID' ] ] ) {
									$current_state = 'is-liked';
								} 
								if ( 'dislike' ==  $this_client_option[ $item[ 'ID' ] ] ) {
									$current_state = 'is-disliked';
								}
							}
						}
						
						if ( 'bricks' == $gallery_type )  {
							$counter++;
							if ( $counter > 5 ) $counter = 1;
							if ( $counter == 1 || $counter == 2) {
								$bricks_class = 'is-large';
							} else {
								$bricks_class = 'is-small';
							}
							$thmb_image_width = 960;
							$thmb_image_height = 640;
						} else if ( 'grid' !== $gallery_type ) {
							$thmb_image_width = 960;
							$thmb_image_height = $thmb_image_width*$original_image_ratio;
						} else {
							$thmb_image_width = 960;
							$thmb_image_height = 640;
						}

						$image_url = wp_get_attachment_image_url( $item[ 'ID' ], 'large' );
						?>
						<div class="ashade-gallery-item ashade-grid-item ashade-client-item <?php echo esc_attr( $bricks_class ); ?> <?php echo esc_attr( $current_state ); ?>" data-id="<?php echo esc_attr( $item[ 'ID' ] ); ?>">
							<div class="ashade-client-item-inner-wrap">
								<div class="ashade-client-item-inner">
									<div class="ahshade-client-image-wrap">
										<div class="ashade-image <?php echo esc_attr( $lazy_state ? 'ashade-lazy' : 'ashade-div-image' ); ?>" data-src="<?php echo esc_url( $image_url ); ?>">
											<img
												src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20<?php echo absint( $thmb_image_width ); ?>%20<?php echo absint( $thmb_image_height ); ?>'%3E%3C/svg%3E" 
												width=<?php echo absint( $thmb_image_width ); ?> 
												height=<?php echo absint( $thmb_image_height ); ?> 
												alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ); ?>">
										</div><!-- .ashade-image -->
									</div>
									<div class="ahshade-client-toolbar">
										<?php if ( $button_approval ) { ?>
										<div class="ahshade-client-like-wrap">
											<a href="#" class="ahshade-client-like" data-id="<?php echo esc_attr( $item[ 'ID' ] ); ?>"></a>
										</div>
										<div class="ahshade-client-dislike-wrap">
											<a href="#" class="ahshade-client-dislike" data-id="<?php echo esc_attr( $item[ 'ID' ] ); ?>"></a>
										</div>
										<?php } ?>
										<?php if ( $button_download ) { ?>
										<div class="ahshade-client-download-wrap">
											<a href="<?php echo esc_url( wp_get_attachment_url( $item[ 'ID' ] ) ); ?>" class="ahshade-client-download" download></a>
										</div>
										<?php } ?>
										<?php if ( $button_zoom ) { ?>
										<div class="ahshade-client-zoom-wrap">
											<a 
												href="<?php echo esc_url( wp_get_attachment_url( $item[ 'ID' ] ) ); ?>" 
												data-elementor-open-lightbox="no" 
												data-gallery = "grid_<?php echo esc_attr( $gallery_id ); ?>" 
												data-caption="<?php echo esc_attr( $image_caption ); ?>" 
												data-size="<?php echo esc_attr( $original_image_width ) . 'x' . esc_attr( $original_image_height ); ?>"
												class="ahshade-client-zoom ashade-lightbox-link">
											</a>
										</div>
										<?php } ?>
									</div><!-- .ashade-client-toolbar -->
									<?php if ( 'under' !== $gallery_caption && 'none' !== $gallery_caption ) { ?>
									<div class="ashade-grid-caption"><?php echo esc_html( $image_caption ); ?></div>
									<?php } ?>
								</div><!-- .ashade-client-item-inner -->
								<?php if ( 'under' == $gallery_caption ) { ?>
									<div class="ashade-grid-caption"><?php echo esc_html( $image_caption ); ?></div>
								<?php } ?>
							</div><!-- .ashade-client-item-inner-wrap -->
						</div><!-- .ashade-client-item -->
						<?php
					}
					?>
					</div><!-- .ashade-grid-<?php echo esc_attr( $gallery_type ); ?> -->
					
					<!-- Notify Button -->
					<?php
					if ( class_exists( 'Shadow_Core' ) && Ashade_Core::get_prefer( 'ashade-client-notify' ) ) {
						?>
						<div class="ashade-client-notify-wrap align-center">
							<a 
								href="#" 
								class="ashade-button ashade-author-notify-button"
								data-client="<?php echo htmlspecialchars( json_encode( $client_data ), ENT_QUOTES ); ?>"><?php echo esc_html__('Notify Photographer', 'ashade'); ?></a>
							<div class="ashade-client-notify-message"></div>
						</div>
						<?php
					}

					# Bottom Elementor Content
					if ( 'bottom' == $content_position ) {
						echo '<div class="ashade-clients-el-content">';
						the_content();
						echo '</div><!-- .ashade-clients-el-content -->';
					}
					?>
					<!-- Post Comments -->
					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( Ashade_Core::get_prefer( 'ashade-client-comments' ) ) {
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