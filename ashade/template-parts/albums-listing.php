<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit; 

$lazy_state = Ashade_Core::get_mod( 'ashade-lazy-loader' );
?>
<div id="post-<?php echo esc_attr( get_the_ID() ); ?>" <?php post_class( 'ashade-post-preview ashade-album-preview' ); ?>>
	<div class="ashade-album-preview-inner">
	<?php
	$category_list = get_the_terms( get_the_id(), Ashade_Core::get_mod( 'ashade-cpt-albums-category' ) );
        $category_string = '';
        if ( is_array( $category_list ) ) {
            foreach ( $category_list as $cat ) {
                $category_string .= $cat->name . ", ";
            }
            $category_string = substr( $category_string, 0, -2 );
        } else {
            $category_string = esc_attr__( 'Uncategorized', 'ashade' );
        }
		# Select Cover Image
    	$featured_image_meta = wp_get_attachment_metadata( get_post_thumbnail_id() );
		$thmb_url = wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' );
		
		if ( ! $thmb_url ) {
			// Try to get Alternative
			$cover_image = Ashade_Core::get_rwmb( 'ashade-albums-image' );
			if ( ! empty( $cover_image ) ) {
				foreach ( $cover_image as $item ) {
					$featured_image_meta = wp_get_attachment_metadata( $item[ 'ID' ] );
					$thmb_url = wp_get_attachment_image_url( $item[ 'ID' ], 'large' );
				}
			} else {
				// Try to get inside image
				$gallery_type = Ashade_Core::get_rwmb( 'ashade-albums-media-type', 'images' );
				$imgID = false;
				if ( 'mixed' == $gallery_type ) {
					$images = Ashade_Core::get_rwmb( 'ashade-albums-media' );
					foreach ( $images as $item ) {
						if ( !$imgID && !empty( $item[ 'image' ] ) ) {
							$imgID = $item[ 'image' ];
						}
					}
				} else if ( 'images' == $gallery_type ) {
					$images = Ashade_Core::get_rwmb( 'ashade-albums-images' );
					foreach ( $images as $item ) {
						if ( !$imgID && $item[ 'ID' ] ) {
							$imgID = $item[ 'ID' ];
						}
					}
				}
				if ( $imgID ) {
					$featured_image_meta = wp_get_attachment_metadata( $imgID );
					$thmb_url = wp_get_attachment_image_url( $imgID, 'large' );
				}
			}
		}

		if ( $thmb_url ) {
			$thmb_width = 640;
			$thmb_height = 640;
			?>
			<div class="ashade-album-preview__image">
				<div class="ashade-image <?php echo esc_attr( $lazy_state ? 'ashade-lazy' : 'ashade-div-image' ); ?>" data-src="<?php echo esc_url( $thmb_url ); ?>">
					<a href="<?php echo esc_url( get_permalink() ); ?>">
					<img
						src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20<?php echo absint( $thmb_width ); ?>%20<?php echo absint( $thmb_height ); ?>'%3E%3C/svg%3E" 
						width=<?php echo absint( $thmb_width ); ?> 
						height=<?php echo absint( $thmb_height ); ?> 
						alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ); ?>">
					</a>
				</div><!-- .ashade-image -->
			</div>
			<?php
		}
		?>
		<div class="ashade-album-preview__content">
			<h5 class="ashade-post-preview-title">
				<span><?php echo ( ! empty( $category_string ) ? $category_string : '&nbsp;'); ?></span>
				<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
			</h5>
		</div>
	</div>
</div><!-- .ashade-post-listing-item -->
