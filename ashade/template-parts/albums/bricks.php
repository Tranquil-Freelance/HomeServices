<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$images = Ashade_Core::get_rwmb( 'ashade-albums-images' );
$lightbox_text_state = Ashade_Core::get_prefer( 'ashade-albums-lightbox-text' );
$caption = Ashade_Core::get_prefer( 'ashade-albums-caption' );
$bricks_layout = Ashade_Core::get_prefer( 'ashade-albums-layout' );
$lazy_state = Ashade_Core::get_mod( 'ashade-lazy-loader' );
$images_direction = Ashade_Core::get_prefer( 'ashade-albums-direction' );

$gallery_type = Ashade_Core::get_rwmb( 'ashade-albums-media-type', 'images' );
if ( 'mixed' == $gallery_type ) {
    $images = Ashade_Core::get_rwmb( 'ashade-albums-media' );
} else if ( 'video' == $gallery_type ) {
    $images = Ashade_Core::get_rwmb( 'ashade-albums-video' );
} else {
    $images = Ashade_Core::get_rwmb( 'ashade-albums-images' );
}
$lightbox_state = Ashade_Core::get_prefer( 'ashade-albums-lightbox' );
?>
<section class="ashade-section">
    <div class="ashade-gallery-bricks ashade-grid-caption--<?php echo esc_attr( $caption ); ?> is-<?php echo esc_attr( $bricks_layout ); ?>">
        <?php
        $thmb_image_width = 960;
        $thmb_image_height = 640;
        $gallery_id = mt_rand( 0, 99999 );
        $counter = 0;
		if ( 'reverse' == $images_direction ) {
			$images = array_reverse( $images );
		}
		if ( 'random' == $images_direction ) {
			shuffle( $images );
		}
        foreach ( $images as $item ) {
            $counter++;
			if ( '1x2' == $bricks_layout ) {
				if ( $counter > 3 ) $counter = 1;
				if ( $counter == 3 ) {
					$bricks_class = 'is-large';
					$thmb_image_width = 1440;
					$thmb_image_height = 960;
				} else {
					$bricks_class = 'is-small';
					$thmb_image_width = 960;
					$thmb_image_height = 640;
				}
			} else {
				if ( $counter > 5 ) $counter = 1;
				if ( $counter == 1 || $counter == 2) {
					$bricks_class = 'is-large';
				} else {
					$bricks_class = 'is-small';
				}
			}
            if ( 'mixed' == $gallery_type ) {
            # Mixed Gallery
                $has_image = false;
                $has_video = false;
                $media_post = false;
                $image_caption = '';
                $lightbox_text = '';
                $alt_text = '';

                // Get Values
                if ( ! empty( $item[ 'image' ] ) ) {
                    $has_image = true;
                    $img_ID    = $item[ 'image' ];
                }
                if ( ! empty( $item[ 'video' ] ) && ! empty( $item[ 'type' ] ) ) {
                    $has_video  = true;
                    $video_ID   = $item[ 'video' ];
                    $video_type = $item[ 'type' ];
                }
                if ( empty( $item[ 'video' ] ) && empty( $item[ 'image' ] ) ) {
                    $link_type = 'empty';
                }

                // Detect Post Type
                if ( $has_image && ! $has_video ) {
                    $link_type = 'image';
                } else if ( ! $has_image && $has_video ) {
                    $link_type = 'video';
                } else if ( $has_image && $has_video ) {
                    $link_type = 'mixed';
                }

                // Captions
                if ( $has_image ) {
                    $media_post = get_post( $img_ID );
                } else if ( $has_video && 'video' == $video_type ) {
                    $media_post = get_post( $video_ID );
                }
                if ( $media_post ) {
                    $image_caption = $media_post->post_excerpt;
                    if ( 'caption' == $lightbox_text_state ) {
                        $lightbox_text = $image_caption;
                    }
                    if ( 'descr' == $lightbox_text_state ) {
                        $lightbox_text = $media_post->post_content;
                    }
                }

                // Image Thumbnail
                if ( 'video' !== $link_type ) {
                    if ( $thmb_image_width < 1024) {
                        $image_url = wp_get_attachment_image_url( $img_ID, 'large' );
                    } else {
                        $image_url = wp_get_attachment_image_url( $img_ID, 'full' );
                    }
                    $alt_text = get_post_meta( $img_ID, '_wp_attachment_image_alt', true );
                    $meta = wp_get_attachment_metadata( $img_ID );
                }

                // Lightbox URL
                if ( 'image' == $link_type ) {
                    // For Image
                    $original_image_width = $meta[ 'width' ];
                    $original_image_height = $meta[ 'height' ];
                    $original_image_url = wp_get_attachment_url( $img_ID );
                } else if ( 'empty' !== $link_type ) {
                    // For Video
                    $original_image_url = false;

                    if ( 'video' == $video_type ) {
                        $original_image_url = wp_get_attachment_url( $video_ID );
                    }
                    if ( 'youtube' == $video_type ) {
                        $original_image_url = 'https://www.youtube.com/embed/' . esc_attr( $video_ID );
                    }
                    if ( 'vimeo' == $video_type ) {
                        $original_image_url = 'https://player.vimeo.com/video/' . esc_attr( $video_ID );
                    }
                }
            } else if ( 'video' == $gallery_type ) {
            # Video Gallery
                $link_type  = 'video';
                $video_ID   = $item[ 'ID' ];
                $video_type = 'video';
                $media_post = get_post( $video_ID );

                if ( $media_post ) {
                    $image_caption = $media_post->post_excerpt;
                    if ( 'caption' == $lightbox_text_state ) {
                        $lightbox_text = $image_caption;
                    }
                    if ( 'descr' == $lightbox_text_state ) {
                        $lightbox_text = $media_post->post_content;
                    }
                }

                $original_image_url = wp_get_attachment_url( $video_ID );
            } else if ( 'images' == $gallery_type ) {
            # Image Gallery
                $link_type = 'image';
                $image_post = get_post( $item[ 'ID' ] );
                $image_caption = $image_post->post_excerpt;
                $lightbox_text = '';
                if ( 'caption' == $lightbox_text_state ) {
                    $lightbox_text = $image_caption;
                }
                if ( 'descr' == $lightbox_text_state ) {
                    $lightbox_text = $image_post->post_content;
                }

                $alt_text = get_post_meta( $item[ 'ID' ], '_wp_attachment_image_alt', true );
                
                $original_image_url = wp_get_attachment_url( $item[ 'ID' ] );
                $meta = wp_get_attachment_metadata( $item[ 'ID' ] );
                $original_image_width = $meta[ 'width' ];
                $original_image_height = $meta[ 'height' ];
                if ( $thmb_image_width < 1024) {
                    $image_url = wp_get_attachment_image_url( $item[ 'ID' ], 'large' );
                } else {
                    $image_url = wp_get_attachment_image_url( $item[ 'ID' ], 'full' );
                }
            }
            if ( 'empty' !== $link_type ) {?>
                <div class="ashade-gallery-item ashade-grid-item ashade-grid-item--<?php echo esc_attr( $link_type ); ?> <?php echo esc_attr( $bricks_class ); ?>">
                    <div class="ashade-grid-item--inner">
                        <?php if ( $lightbox_state ) { ?>
                        <a 
                            href="<?php echo esc_url( $original_image_url ); ?>" 
                            class="ashade-lightbox-link" 
                            data-elementor-open-lightbox="no"
                            data-gallery = "grid_<?php echo esc_attr( $gallery_id ); ?>" 
                            <?php if ( ! empty( $lightbox_text ) ) { ?>
                            data-caption="<?php echo esc_attr( $lightbox_text ); ?>"
                            <?php } ?>
                            data-type="<?php echo esc_attr( $link_type ); ?>" 
                            <?php if ( 'image' == $link_type ) { ?>
                            data-size="<?php echo esc_attr( $original_image_width ) . 'x' . esc_attr( $original_image_height ); ?>"
                            <?php } else if ( 'image' !== $gallery_type ) { ?>
                            data-video-type="<?php echo esc_attr( $video_type ); ?>" 
                            <?php } ?>
                            >
                        </a>
                        <?php } ?>
                        <?php if ( 'video' == $link_type ) {
                            // No Image Thumbnail
                            if ( 'video' == $video_type ) {
                                // Video Thumbnail
                                ?>
                                <div class="ashade-grid-item-holder is-cover">
                                    <video class="ashade-video-preview" 
                                        src="<?php echo esc_url( $original_image_url ); echo wp_is_mobile() ? '#t=0.001' : ''; ?>"
                                        webkit-playsinline="true" 
                                        playsinline="true" muted loop></video>
                                    <img src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20<?php echo absint( $thmb_image_width ); ?>%20<?php echo absint( $thmb_image_height ); ?>'%3E%3C/svg%3E" width="<?php echo absint( $thmb_image_width ); ?>" height="<?php echo absint( $thmb_image_height ); ?>">
                                </div>
                                <?php
                            } else {
                                // Embeded Thumbnail
                                if ( 'vimeo' == $video_type ) {
                                    $thmb_request = wp_remote_get( "http://vimeo.com/api/v2/video/$video_ID.php" );
                                    $vimeo_thmb = unserialize( wp_remote_retrieve_body( $thmb_request ) );
                                    echo '<div class="ashade-grid-item-holder is-cover" data-src="' . esc_url( $vimeo_thmb[ 0 ][ 'thumbnail_large' ] ) . '">';
                                } else {
                                    echo '<div class="ashade-grid-item-holder is-cover" data-src="https://img.youtube.com/vi/' . esc_attr( $video_ID ) . '/0.jpg">';
                                }
                                    ?>
                                    <img src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20<?php echo absint( $thmb_image_width ); ?>%20<?php echo absint( $thmb_image_height ); ?>'%3E%3C/svg%3E" width="<?php echo absint( $thmb_image_width ); ?>" height="<?php echo absint( $thmb_image_height ); ?>">
                                </div>
                                <?php
                            }
                        } else { ?>
                        <div class="ashade-image <?php echo esc_attr( $lazy_state ? 'ashade-lazy' : 'ashade-div-image' ); ?>" data-src="<?php echo esc_url( $image_url ); ?>">
                            <img
                                src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20<?php echo absint( $thmb_image_width ); ?>%20<?php echo absint( $thmb_image_height ); ?>'%3E%3C/svg%3E" 
                                width=<?php echo absint( $thmb_image_width ); ?> 
                                height=<?php echo absint( $thmb_image_height ); ?> 
                                alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ); ?>">
                        </div><!-- .ashade-image -->
                        <?php } ?>
                        <div class="ashade-grid-caption"><?php echo esc_html( $image_caption ); ?></div>
                    </div>
                </div><!-- .ashade-gallery-item -->
            <?php
            }
        }
        ?>
    </div><!-- .ashade-grid -->
</section><!-- .ashade-section -->