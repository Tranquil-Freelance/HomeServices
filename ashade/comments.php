<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( comments_open() || get_comments_number() ) {
    function ashade_comment_form_fields( $fields ) {
        $comment_field = $fields[ 'comment' ];
        $comment_cookies = $fields[ 'cookies' ];
        unset( $fields[ 'url' ] );
        unset( $fields['comment'] );
        unset( $fields['cookies'] );
        $fields[ 'comment' ] = $comment_field;
        $fields[ 'cookies' ] = $comment_cookies;
        return $fields;
    }
        
    add_filter( 'comment_form_fields', 'ashade_comment_form_fields' );
    ?>
    <div id="ashade-comments">
        <?php
        if ( post_password_required() ) {
            return;
        }
        if ( have_comments() ) { 
			if ( 'ashade-clients' == get_post_type() ) {
            ?>
            <h3 class="ashade-comments-title align-center">
                <span><?php echo esc_html__( 'Our Conversation', 'ashade' ); ?></span>
                <?php echo get_comments_number() . ' ' . ( get_comments_number() == 1 ? esc_html__( 'Comment', 'ashade' ) : esc_html__( 'Comments', 'ashade' ) ); ?>
            </h3>
			<?php } else { ?>
			<h3 class="ashade-comments-title align-center">
                <span><?php echo esc_html__( 'What people talk', 'ashade' ); ?></span>
                <?php echo get_comments_number() . ' ' . ( get_comments_number() == 1 ? esc_html__( 'Comment', 'ashade' ) : esc_html__( 'Comments', 'ashade' ) ); ?>
            </h3>
			<?php } ?>

            <div class="ashade-comment-list">
                <?php
                wp_list_comments(
                    array(
                        'avatar_size' => 200,
                        'short_ping'  => true,
                        'style'       => 'div',
                        'depth'       => 3,
                        'callback'    => 'ashade_comments_template'
                    )
                );
                ?>
            </div><!-- .ashade-comment-list -->
        <?php 
            # Comment Navigation
            the_comments_navigation();
        }	
        # Show comment form after Comments
        if ( comments_open() ) {
			if ( 'ashade-clients' == get_post_type() ) {
				$title_before = '<h4 id="reply-title" class="ashade-comment-reply-title align-center"><span>' . esc_html__( 'Have Questions?', 'ashade' ) . '</span>';
				$title_reply = esc_html__( "Let's Discuss", 'ashade' );
			} else {
				$title_before = '<h4 id="reply-title" class="ashade-comment-reply-title align-center"><span>' . esc_html__( 'Tell us about your thoughts', 'ashade' ) . '</span>';
				$title_reply = esc_html__( 'Write message', 'ashade' );
			}
			$title_after = '</h4>';
            # Show comment form.
            comment_form(
                array(
                    'class_form'         => 'ashade-comment-form',
                    'title_reply_before' => $title_before,
                    'title_reply'        => $title_reply,
                    'title_reply_after'  => $title_after
                )
            );
		}
        ?>
    </div><!-- #ashade-comments -->

    <?php 
}
function ashade_comments_template( $comment, $args, $depth ) {
    ?>
    <div class="ashade-comment-item-wrap">
        <div <?php comment_class( 'ashade-comment-item' ); ?> id="comment-<?php comment_ID(); ?>">
            <div class="ashade-comment-author">
                <div class="ashade-comment-author__image">
                    <?php echo get_avatar( $comment->comment_author_email, $args[ 'avatar_size' ] ); ?>
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
                    <?php edit_comment_link( esc_attr__( 'Edit', 'ashade' ) ); ?>
                    <?php 
                    comment_reply_link(
                        array_merge( 
                            $args, array(
                                'reply_text' => esc_attr__( 'Reply', 'ashade' ),
                                'depth'      => $depth, 
                                'max_depth'  => $args[ 'max_depth' ]
                            )
                        )
                    ) 
                    ?>
                </div><!-- .ashade-comment-footer -->
                <?php comment_text(); ?>
            </div><!-- .ashade-comment-body -->
        </div><!-- .ashade-comment-item -->
    <?php
}
?>