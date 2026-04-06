<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$thmb_size = Ashade_Core::get_mod( 'ashade-listing-thmb-size' );
$post_settings = get_query_var( 'shadowcore_simple_blog' );
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
		<h4 class="ashade-post-preview-title">
			<span><?php
				if ( 'yes' == $post_settings[ 'meta_post_date' ] ) {
					echo '
					<span class="ashade-preview-meta ashade-post-meta">
						' . get_the_date() . '
					</span>	
					';
				}
				if ( 'yes' == $post_settings[ 'meta_post_category' ] ) {
					?>
					<span>
						<?php 
						echo esc_html__( 'in', 'ashade' ) . ' '; 
						the_category( ', ' );
						?>
					</span>
					<?php
				}
				if ( 'yes' == $post_settings[ 'meta_post_author' ] ) {
					echo '
					<span class="ashade-preview-meta ashade-post-meta">
						' . esc_html__( 'by', 'ashade' ) . ' ' . get_the_author_posts_link() . '
					</span>
					';
				}
			?></span>
			<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
		</h4>
	</div>
	<div class="ashade-post-preview-content">
		<?php 
		if ( 'yes' == $post_settings[ 'post_excerpt' ] ) {
			echo get_the_excerpt(); 
		}
		?>
	</div><!-- .ashade-post-preview-content -->
	<div class="ashade-post-preview-footer">
		<div class="ashade-post-preview-footer--lp">
			<?php if ( 'yes' == $post_settings[ 'meta_post_comments' ] ) { ?>
			<div class="ashade-post-preview__comments">
				<?php 
				$comments_count = get_comments_number();
				echo '<a href="' . esc_url( get_permalink() ) . '">'. absint( $comments_count ) . ' ' . ( $comments_count == '1' ? esc_html__( 'Comment', 'ashade' ) : esc_html__( 'Comments', 'ashade' ) ) . '</a>';
				?>
			</div>
			<?php } ?>
			<?php if ( 'yes' == $post_settings[ 'meta_post_tags' ] ) { ?>
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
