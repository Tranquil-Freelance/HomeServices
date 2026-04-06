<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$images = Ashade_Core::get_rwmb( 'ashade-albums-images' );
$ribbon_style = Ashade_Core::get_prefer( 'ashade-albums-ribbon-layout' );
$lazy_state = Ashade_Core::get_mod( 'ashade-lazy-loader' );
$gallery_id = mt_rand( 0, 99999 );
$images_direction = Ashade_Core::get_prefer( 'ashade-albums-direction' );
wp_enqueue_script( 'ashade-ribbon' );

$lightbox = Ashade_Core::get_prefer( 'ashade-albums-ribbon-lightbox' );

if ( 'vertical' !== $ribbon_style ) {
    if ( Ashade_Core::get_mod( 'ashade-albums-back-state' ) ) {
        ?>
        <div class="ashade-ribbon-return ashade-back-wrap">
            <div class="ashade-back albums-go-back">
                <span><?php echo esc_html__( 'Return', 'ashade' ); ?></span>
                <span><?php echo esc_html__( 'Back', 'ashade' ); ?></span>
            </div>
        </div><!-- .ashade-back-wrap -->
        <?php
    }
}
$gallery_type = Ashade_Core::get_rwmb( 'ashade-albums-media-type', 'images' );
$caption_state = Ashade_Core::get_prefer( 'ashade-albums-fs-caption' );

if ( 'mixed' == $gallery_type ) {
    $images = Ashade_Core::get_rwmb( 'ashade-albums-media' );
    wp_enqueue_script( 'vimeo-player', 'https://player.vimeo.com/api/player.js', array( 'jquery' ), false, true );
    wp_enqueue_script( 'youtube-player', 'https://www.youtube.com/iframe_api', array( 'jquery' ), false, true );
} else if ( 'video' == $gallery_type ) {
    $images = Ashade_Core::get_rwmb( 'ashade-albums-video' );
} else {
    $images = Ashade_Core::get_rwmb( 'ashade-albums-images' );
}		
?>


<div class="ashade-albums-carousel is-<?php echo esc_attr( $ribbon_style ); ?>" id="ribbon-<?php echo mt_rand( 0, 99999 ); ?>">
    <?php 
	if ( 'reverse' == $images_direction ) {
		$images = array_reverse( $images );
	}
	if ( 'random' == $images_direction ) {
		shuffle( $images );
	}
    foreach ( $images as $object ) {		
		$item = Array(
			'image' => false,
			'video' => false,
			'thmb'  => false,
			'link'  => false,
		);
		
		# Set Basic Item
		if ( 'mixed' == $gallery_type ) {
			# Mixed Gallery			
			if ( ! empty( $object[ 'video' ] ) ) {
				if ( 'video' == $object[ 'type' ] ) {
					$item['video'] = Array(
						'type' => 'video',
						'id' => $object[ 'video' ]
					);
					$item['link'] = Array(
						'type' => 'video',
					);
				} else {
					$item['video'] = Array(
						'type' => $object[ 'type' ],
						'id' => $object[ 'video' ]
					);
					$item['link'] = Array(
						'type' => 'video',
					);
				}
			}
			
			if ( ! empty( $object[ 'image' ] ) ) {
				$item['image'] = Array(
					'id' =>$object[ 'image' ]
				);
				if ( ! $item['link'] ) {
					$item['link'] = Array(
						'type' => 'image',
					);
				}
			}
		} else if ( 'video' == $gallery_type ) {
			# Only Video
			$item['video'] = Array(
				'type' => 'video',
				'id' => $object[ 'ID' ]
			);
			$item['link'] = Array(
				'type' => 'video',
			);
		} else {
			# Ony Images
			$item['image'] = Array(
				'id' => $object[ 'ID' ]
			);
			$item['link'] = Array(
				'type' => 'image',
			);
		}
		
		# Set Image Data
		if ( $item['image'] ) {
			$post = get_post( $item['image']['id'] );
			$meta = wp_get_attachment_metadata( $item['image']['id'] );	
			$item['image']['url']     = wp_get_attachment_url( $item['image']['id'] );
			$item['image']['width']   = $meta[ 'width' ];
			$item['image']['height']  = $meta[ 'height' ];
			$item['image']['caption'] = $post->post_excerpt;
			$item['image']['descr']   = $post->post_content;
			$item['image']['alt']     = get_post_meta( $item['image']['id'], '_wp_attachment_image_alt', true );
			wp_reset_query();
		}
		
		# Set Video Data
		if ( $item['video'] ) {
			if ( 'video' == $item['video']['type'] ) {
				# Self-Hosted Video
				$meta = wp_get_attachment_metadata( $item['video']['id'] );
				$item['video']['width']  = $meta[ 'width' ];
				$item['video']['height'] = $meta[ 'height' ];
				$item['video']['url']    = wp_get_attachment_url( $item['video']['id'] );
				if ( $item['image'] ) {
					$item['video']['caption'] = $item['image']['caption'];
					$item['video']['descr']   = $item['image']['descr'];
					$item['video']['alt']     = $item['image']['alt'];
				} else {
					$post = get_post( $item['video']['id'] );
					$item['video']['caption'] = $post->post_excerpt;
					$item['video']['descr']   = $post->post_content;
					$item['video']['alt']     = $item['video']['type'];
					wp_reset_query();
				}
			} else {
				# Embeded Video
				if ( 'youtube' == $item['video']['type'] ) {
					$item['video']['url'] = 'https://www.youtube.com/embed/' . $item['video']['id'];
				} else {
					$item['video']['url'] = 'https://player.vimeo.com/video/' . $item['video']['id'];
				}
				$item['video']['width']   = 1920;
				$item['video']['height']  = 1080;
				
				if ( $item['image'] ) {
					$item['video']['caption'] = $item['image']['caption'];
					$item['video']['descr']   = $item['image']['descr'];
					$item['video']['alt']     = $item['image']['alt'];
				} else {
					$item['video']['caption'] = '';
					$item['video']['descr']   = '';
					$item['video']['alt']     = $item['video']['type'];
				}
			}
		}
		
		# Link and Render
		if ( $item['link'] ) {
			# Set Link
			if ( 'image' == $item['link']['type'] && $item['image'] ) {
				# Link to Image
				$item['link']['url']     = $item['image'][ 'url' ];
				$item['link']['caption'] = $item['image'][ 'caption' ];
				$item['link']['size']    = $item['image']['width'] . 'x' . $item['image']['height'];
			} else {
				# Link to Video
				$item['link']['url']     = $item['video'][ 'url' ];
				$item['link']['caption'] = $item['video'][ 'caption' ];
				$item['link']['size']    = $item['video']['width'] . 'x' . $item['video']['height'];
			}
			
			# Render Slide
			?>
			<div class="ashade-album-item" data-type="<?php echo esc_attr( $item['link']['type'] ); ?>">
				<div class="ashade-album-item__inner">
				<?php 
				if ( $lightbox ) { 
				# Link if Lightbox is Enbaled
					$type = $item['link']['type'];
					$break_link = false;
					?>
					<a 
					href="<?php echo esc_url( $item['link']['url'] ); ?>" 
					data-gallery = "ribbon-<?php echo esc_attr( $gallery_id ); ?>" 
					<?php if ( ! empty( $item['link']['caption'] ) ) { ?>
					data-caption="<?php echo esc_attr( $item['link']['caption'] ); ?>" 
					<?php } ?>
					data-type="<?php echo esc_attr( $type ); ?>" 
					data-size="<?php echo esc_attr( $item[$type]['width'] ) . 'x' . esc_attr( $item[$type]['height'] ); ?>" 
					<?php if ( 'image' !== $type ) { ?>
					data-video-type="<?php echo esc_attr( $item['video']['type'] ); ?>" 
					<?php } ?>
					data-elementor-open-lightbox="no"
					class="ashade-lightbox-link">
					
					<?php					
						# Image Thumbnail
						if ( $item['image'] ) {
							# Use predefined image
							?>
							<img 
								<?php if ( $lazy_state ) { ?>
								src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20<?php echo absint( $item['image']['width'] ); ?>%20<?php echo absint( $item['image']['height'] ); ?>'%3E%3C/svg%3E"
								data-src="<?php echo esc_url( $item['image']['url'] ); ?>"
								class="ashade-lazy" 
								<?php } else { ?>
								src="<?php echo esc_url( $item['image']['url'] ); ?>"
								<?php } ?>
								alt="<?php echo esc_attr( $item['image']['alt'] ); ?>" 
								width="<?php echo absint( $item['image']['width'] ); ?>" 
								height="<?php echo absint( $item['image']['height'] ); ?>">
							<?php
						} else if ( 'video' !== $item['video']['type']) {
							# Generate image for Embeded
							if ( 'vimeo' == $item['video']['type'] ) {
								# Vimeo Thumbnail
								$videoID = $item['video']['id'];
								$thmb_request = wp_remote_get( "http://vimeo.com/api/v2/video/$videoID.php" );
								$vimeo_thmb = unserialize( wp_remote_retrieve_body( $thmb_request ) );
								$image_url = $vimeo_thmb[ 0 ][ 'thumbnail_large' ];
							} else {
								# YouTube Thumbnail
								$image_url = 'https://img.youtube.com/vi/' . esc_attr( $item['video']['id'] ) . '/0.jpg';
							}
							?>
							<img 
								src="<?php echo esc_url( $image_url ); ?>"
								alt="<?php echo esc_attr( $item['video']['alt'] ); ?>" 
								width="<?php echo absint( $item['video']['width'] ); ?>" 
								height="<?php echo absint( $item['video']['height'] ); ?>">
							<?php
						} else {
							# Show Self-Hosted Video
							?>
							<div class="ashade-grid-item-holder is-cover">
								<video class="ashade-video-preview" 
									src="<?php echo esc_url( $item['video']['url'] ); ?>"
									webkit-playsinline="true" 
									playsinline="true" muted loop></video>
								<img src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20<?php echo absint( $item['video']['width'] ); ?>%20<?php echo absint( $item['video']['height'] ); ?>'%3E%3C/svg%3E" width="<?php echo absint( $item['video']['width'] ); ?>" height="<?php echo absint( $item['video']['height'] ); ?>">
							</div><!-- .ashade-grid-item-holder -->
							<?php
						}
					?>
					</a>
					<?php
					} else {	
						# Image Slide
						if ( 'image' == $item['link']['type'] ) {
							# Use predefined image
							?>
							<img 
								<?php if ( $lazy_state ) { ?>
								src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20<?php echo absint( $item['image']['width'] ); ?>%20<?php echo absint( $item['image']['height'] ); ?>'%3E%3C/svg%3E"
								data-src="<?php echo esc_url( $item['image']['url'] ); ?>"
								class="ashade-lazy" 
								<?php } else { ?>
								src="<?php echo esc_url( $item['image']['url'] ); ?>"
								<?php } ?>
								alt="<?php echo esc_attr( $item['image']['alt'] ); ?>" 
								width="<?php echo absint( $item['image']['width'] ); ?>" 
								height="<?php echo absint( $item['image']['height'] ); ?>">
							<?php
						} else if ( 'video' == $item['video']['type'] ) {
							# Self Hosted Slide
							?>
							<div class="ashade-grid-item-holder is-cover">
								<video class="ashade-video-preview" 
									src="<?php echo esc_url( $item['video']['url'] ); ?>"
									webkit-playsinline="true" 
									playsinline="true" muted loop></video>
								<img src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20<?php echo absint( $item['video']['width'] ); ?>%20<?php echo absint( $item['video']['height'] ); ?>'%3E%3C/svg%3E" width="<?php echo absint( $item['video']['width'] ); ?>" height="<?php echo absint( $item['video']['height'] ); ?>">
							</div><!-- .ashade-grid-item-holder -->
							<?php
						} else {
							# Embeded Video Slide
							?>
							<div class="ashade-slide-embed ashade-slide-embed--<?php echo esc_attr( $item['video']['type'] ); ?>" data-video-id="<?php echo esc_attr( $item['video']['id'] ); ?>">
                                <img src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20<?php echo absint( $item['video']['width'] ); ?>%20<?php echo absint( $item['video']['height'] ); ?>'%3E%3C/svg%3E" width="<?php echo absint( $item['video']['width'] ); ?>" height="<?php echo absint( $item['video']['height'] ); ?>">
                            </div>
							<?php
						}
					}
			
					# Video Mute Button
					if ( $item['video'] && 'video' == $item['video']['type'] ) {
						if ( 'show' == Ashade_Core::get_rwmb( 'ashade-albums-video-unmute', 'hide' ) ) { ?>
							<a href="#" class="ashade-video-unmute is-mutted">
								<i class="dashicons dashicons-controls-volumeon"></i>
								<i class="dashicons dashicons-controls-volumeoff"></i>
							</a>
							<?php
						}	
					}
				
					# Slide Caption
					if ( 'show' == $caption_state && ( ! empty( $item['image']['caption'] ) || ! empty( $item['video']['caption'] ) ) ) { ?>
						<div class="ashade-slide-caption">
							<h5><?php
						if ( $item['image'] && ! empty( $item['image']['caption'] ) ) {
							echo esc_html( $item['image']['caption'] );
						} else if ( $item['video'] && ! empty( $item['video']['caption'] ) ) {
							echo esc_html( $item['video']['caption'] );
						}
						?></h5>
						</div>
						<?php
					}
					?>
				</div><!-- .ashade-album-item__inner -->
			</div><!-- .ashade-album-item -->
			<?php
		} else {
			# ERROR: Object is not OK
			?>
			<div class="ashade-album-item ashade-album-item--empty" data-type="no-link"></div>
			<?php
		}
    } 
    ?>
</div><!-- .ashade-albums-carousel -->
