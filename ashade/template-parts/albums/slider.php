<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$images = Ashade_Core::get_rwmb( 'ashade-albums-images' );
$slider_layout = Ashade_Core::get_prefer( 'ashade-albums-slider-layout' );
$slider_nav = Ashade_Core::get_prefer( 'ashade-albums-slider-nav' );
$images_direction = Ashade_Core::get_prefer( 'ashade-albums-direction' );
$fit = Ashade_Core::get_rwmb( 'ashade-albums-slider-fit', 'cover' );
$overlay = Ashade_Core::get_rwmb( 'ashade-albums-slider-overlay', 'show' );

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
wp_enqueue_script( 'ashade-slider' );

if ( Ashade_Core::get_mod( 'ashade-albums-back-state' ) ) {
    ?>
    <div class="ashade-slider-return ashade-back-wrap">
        <div class="ashade-back albums-go-back">
            <span><?php echo esc_html__( 'Return', 'ashade' ); ?></span>
            <span><?php echo esc_html__( 'Back', 'ashade' ); ?></span>
        </div>
    </div><!-- .ashade-back-wrap -->
    <?php
}
?>
    <div class="ashade-albums-slider ashade-slider--<?php echo esc_attr( $fit ); ?> is-<?php echo esc_attr( $slider_layout ); ?>" id="slider-<?php echo mt_rand( 0, 99999 ); ?>">
        <?php 
		if ( 'reverse' == $images_direction ) {
			$images = array_reverse( $images );
		}
		if ( 'random' == $images_direction ) {
			shuffle( $images );
		}
        foreach ( $images as $item ) {
			$image_caption = '';
			$video_caption = '';
			
            if ( 'mixed' == $gallery_type ) {
            # Mixed Gallery
                $has_image = false;
                $media_post = false;
                $alt_text = '';
                $video_ratio = 0.5625;

                // Detect Type
                if ( ! empty( $item[ 'video' ] ) ) {
                    $slide_type = 'video';
                    $video_ID   = $item[ 'video' ];
                    $video_type = $item[ 'type' ];
                    if ( 'video' == $video_type ) {
                        $image_url = wp_get_attachment_url( $video_ID );
						
						$post = get_post( $video_ID );
						$video_caption = $post->post_excerpt;
						wp_reset_query();
                    } else {
                        $image_url = esc_attr( $video_ID );
                    }
                } else if ( ! empty( $item[ 'image' ] ) ) {
                    $slide_type = 'image';
                    $image_url  = wp_get_attachment_url( $item[ 'image' ] );
					
					$post = get_post( $item[ 'image' ] );
					$image_caption = $post->post_excerpt;
					wp_reset_query();
                } else {
                    $slide_type = 'empty';
                }
            } else if ( 'video' == $gallery_type ) {
            # Video Gallery
                $slide_type = $video_type = 'video';
                $video_ID   = $item[ 'ID' ];
                $image_url  = wp_get_attachment_url( $video_ID );
                $media_meta = wp_get_attachment_metadata( $video_ID );
				
				$post = get_post( $video_ID );
				$video_caption = $post->post_excerpt;
				wp_reset_query();
            } else {
            # Image Gallery
                $slide_type = 'image';
                $image_url  = wp_get_attachment_url( $item[ 'ID' ] );
				
				$post = get_post( $item[ 'ID' ] );
				$image_caption = $post->post_excerpt;
				wp_reset_query();
            }
        
            if ( 'empty' !== $slide_type ) { 
            ?>
                <div class="ashade-album-item">
                    <?php 
                    if ( 'image' == $slide_type ) {
                        echo '<div class="ashade-album-item__image" data-src="' . esc_url( $image_url ) . '"></div>';
                    } else {
                        if ( 'video' == $video_type ) {
                            ?>
                            <div class="ashade-album-item__image ashade-album-item__video">
                                <video class="ashade-video-preview" 
                                        src="<?php echo esc_url( $image_url ); ?>"
                                        webkit-playsinline="true" 
                                        playsinline="true" muted loop></video>
                                <?php if ( 'show' == Ashade_Core::get_rwmb( 'ashade-albums-video-unmute', 'hide' ) && array_key_exists( 'audio', $media_meta ) ) { ?>
                                    <a href="#" class="ashade-video-unmute is-mutted">
                                        <i class="dashicons dashicons-controls-volumeon"></i>
                                        <i class="dashicons dashicons-controls-volumeoff"></i>
                                    </a>
                                <?php } ?>
                            </div>
                            <?php
                        } else {
                            echo '<div class="ashade-album-item__image ashade-album-item__embed ashade-album-item__embed--' . esc_attr( $video_type ) . '" data-video-id="' . esc_attr( $image_url ) . '"></div>';
                        }
                    }
				
					if ( 'show' == $caption_state && ( ! empty( $image_caption ) || ! empty( $video_caption ) ) ) { ?>
						<div class="ashade-slide-caption">
							<h4><?php
						if ( ! empty( $image_caption ) ) {
							echo esc_html( $image_caption );
						} else if ( ! empty( $video_caption ) ) {
							echo esc_html( $video_caption );
						}
						?></h4>
						</div>
						<?php
					}
                    if ( 'show' == $overlay ) {
                    ?>
                    <div class="ashade-album-item__overlay"></div>
                    <?php } ?>
                </div><!-- .ashade-album-item -->
            <?php
            }
        } 
        ?>
    </div><!-- .ashade-albums-slider -->
<?php if ( $slider_nav ) { ?>
<a href="#" class="ashade-slider-prev"><?php echo esc_html__( 'Prev', 'ashade' ); ?></a>
<a href="#" class="ashade-slider-next"><?php echo esc_html__( 'Next', 'ashade' ); ?></a>
<?php } ?>