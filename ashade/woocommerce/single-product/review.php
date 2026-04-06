<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>
<div <?php comment_class( 'ashade-comment-item-wrap' ); ?> id="ashade-comment-<?php comment_ID(); ?>">
	<div <?php comment_class( 'ashade-comment-item' ); ?>>
		<div class="ashade-comment-author">
			<div class="ashade-comment-author__image">
				<?php echo get_avatar( $comment->comment_author_email, 200 ); ?>
			</div>
			<div class="ashade-comment-author__name">
				<h6>
					<span><?php echo get_comment_date(); ?></span>
					<i class="ashade-post-author-label"><?php echo esc_html__( 'Author', 'ashade' ); ?></i>
					<?php echo get_comment_author(); ?>
				</h6>
			</div>
		</div><!-- .ashade-comment-author -->
		<div class="ashade-comment-body">
			<div class="ashade-comment-tools">
				<?php 
					ashade_woo__widget_rating( intval( get_comment_meta( $comment->comment_ID, 'rating', true ) ) );
				?>
				<?php edit_comment_link( esc_attr__( 'Edit', 'ashade' ) ); ?>
			</div><!-- .ashade-comment-footer -->
			<?php comment_text(); ?>
		</div><!-- .ashade-comment-body -->
	</div><!-- .ashade-comment-item -->
</div>