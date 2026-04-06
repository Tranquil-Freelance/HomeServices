<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit; 

$thmb_size = Ashade_Core::get_mod( 'ashade-listing-thmb-size' );

$meta_state = Ashade_Core::get_mod( 'ashade-listing-meta' );
$meta_author = Ashade_Core::get_mod( 'ashade-listing-meta-author' );
$meta_date = Ashade_Core::get_mod( 'ashade-listing-meta-date' );
$meta_comments = Ashade_Core::get_mod( 'ashade-listing-meta-comments' );
$meta_category = Ashade_Core::get_mod( 'ashade-listing-meta-category' );
$meta_tags = Ashade_Core::get_mod( 'ashade-listing-meta-tags' );

$excerpt_state = Ashade_Core::get_mod( 'ashade-listing-excerpt' );
$h = 'h4';
if ( 'medium' == $thmb_size ) {
	$h = 'h4';
}
?>
<div id="post-<?php echo esc_attr( get_the_ID() ); ?>" <?php post_class( 'ashade-post-preview thmb-size--'. esc_attr( $thmb_size ) ); ?>>
	<div class="ashade-preview-header">
		<?php
		if ( Ashade_Core::get_fimage_thmb_url() ) {
			if ( 'small' == $thmb_size ) {
				echo '
				<div class="ashade-preview-featured-image">
					<a href="' . esc_url( get_permalink() ) . '">
						<img src="' . esc_url( Ashade_Core::get_fimage_thmb_url() ) . '" alt="' . esc_attr( get_the_title() ) . '">
					</a>
				</div>
				';
			}
			if ( 'medium' == $thmb_size ) {
				$thmb_url = wp_get_attachment_image_url( get_post_thumbnail_id(), 'large' );
				$thmb_width = 310;
				$thmb_height = 310;
				?>
				<div class="ashade-preview-featured-image is-medium">
					<div class="ashade-image ashade-div-image" data-src="<?php echo esc_url( $thmb_url ); ?>">
						<a href="<?php echo esc_url( get_permalink() ); ?>">
							<img
								src="data:image/svg+xml,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20viewBox='0%200%20<?php echo absint( $thmb_width ); ?>%20<?php echo absint( $thmb_height ); ?>'%3E%3C/svg%3E" 
								width=<?php echo absint( $thmb_width ); ?> 
								height=<?php echo absint( $thmb_height ); ?> 
								alt="<?php echo esc_attr( get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true ) ); ?>">
						</a>
					</div><!-- .ashade-div-image -->
				</div>
				<?php
			}
			if ( 'large' == $thmb_size ) {
				$featured_image_url = Ashade_Core::get_fimage_url();
				if ( $featured_image_url ) {
					echo '
					<div class="ashade-preview-featured-image is-medium">
						<a href="' . esc_url( get_permalink() ) . '">
							<img src="' . esc_url( $featured_image_url ) . '" alt="' . esc_attr( get_the_title() ) . '">
						</a>
					</div>
					';
				}
			}
		}
		?>
		<<?php echo esc_attr( $h ); ?> class="ashade-post-preview-title">
			<?php if ( $meta_state ) { ?>
			<span>
				<?php if ( $meta_date ) { ?>
				<span class="ashade-preview-meta ashade-post-meta">
					<?php echo get_the_date(); ?>
				</span>
				<?php } ?>
				<?php if ( $meta_category ) { ?>
				<span>
					<?php echo esc_html__( 'in', 'ashade' ); ?> <?php the_category( ', ' ); ?>
				</span>
				<?php } ?>
				<?php if ( $meta_author ) { ?>
				<span class="ashade-preview-meta ashade-post-meta">
					<?php echo esc_html__( 'by', 'ashade' ); ?> <?php echo get_the_author_posts_link(); ?>
				</span>
				<?php } ?>
			</span>
			<?php } ?>
			<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
		</<?php echo esc_attr( $h ); ?>>
	</div>
	<?php if ( $excerpt_state ) { ?>
	<div class="ashade-post-preview-content">
		<?php echo get_the_excerpt(); ?>
	</div><!-- .ashade-post-preview-content -->
	<?php } ?>
	<div class="ashade-post-preview-footer">
		<div class="ashade-post-preview-footer--lp">
			<?php if ( $meta_comments ) { ?>
			<div class="ashade-post-preview__comments">
				<?php 
				$comments_count = get_comments_number();
				echo '<a href="' . esc_url( get_permalink() ) . '">'. absint( $comments_count ) . ' ' . ( $comments_count == '1' ? esc_html__( 'Comment', 'ashade' ) : esc_html__( 'Comments', 'ashade' ) ) . '</a>';
				?>
			</div>
			<?php } ?>
			<?php if ( $meta_tags ) { ?>
			<div class="ashade-post-preview__tags">
				<?php the_tags( '<span>' . esc_html__( 'Tagged in ', 'ashade' ), ', ', '</span>' ); ?>
			</div>
			<?php } ?>
		</div>
		<div class="ashade-post-preview-footer--rp">
			<a class="ashade-post-preview-more ashade-learn-more" href="<?php echo esc_url( get_permalink() ); ?>">
				<?php echo esc_html__( 'Learn More', 'ashade' ); ?>
			</a>
		</div>
	</div><!-- .ashade-post-preview-footer -->
</div><!-- .ashade-post-listing-item -->
