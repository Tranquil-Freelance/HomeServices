<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

?>
<div id="post-<?php echo esc_attr( get_the_ID() ); ?>" <?php post_class( 'ashade-post-preview' ); ?>>
	<div class="ashade-preview-header">
		<?php
		if ( Ashade_Core::get_fimage_thmb_url() ) {
			echo '
			<div class="ashade-preview-featured-image">
				<a href="' . esc_url( get_permalink() ) . '">
					<img src="' . esc_url( Ashade_Core::get_fimage_thmb_url() ) . '" alt="' . esc_attr( get_the_title() ) . '">
				</a>
			</div>
			';
		}
		?>
		<h4 class="ashade-post-preview-title">
			<span>
				<?php echo get_the_date(); ?>
			</span>
			<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_title(); ?></a>
		</h4>
	</div>
	<div class="ashade-post-preview-content">
		<?php echo get_the_excerpt(); ?>
	</div><!-- .ashade-post-preview-content -->
	<div class="ashade-post-preview-footer">
		<div class="ashade-post-preview-footer--rp">
			<a class="ashade-post-preview-more ashade-learn-more" href="<?php echo esc_url( get_permalink() ); ?>">
				<?php echo esc_html__( 'Learn More', 'ashade' ); ?>
			</a>
		</div>
	</div><!-- .ashade-post-preview-footer -->
</div><!-- .ashade-post-listing-item -->
