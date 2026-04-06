<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
	get_header();
	the_post();

	$bg_state = Ashade_Core::get_mod( 'ashade-attachment-bg' );
	$bg_opacity = Ashade_Core::get_mod( 'ashade-attachment-opacity' );
	$title_state = Ashade_Core::get_mod( 'ashade-attachment-title' );
	$caption_state = Ashade_Core::get_mod( 'ashade-attachment-caption' );
	$description_state = Ashade_Core::get_mod( 'ashade-attachment-descr' );

	$attachment = wp_get_attachment_url( get_the_ID(), 'full' );
	$meta = wp_get_attachment_metadata( get_the_ID() );
	$img_caption = get_the_excerpt();
	$img_description = get_the_content();
	$img_alt = get_post_meta( get_the_ID(), '_wp_attachment_image_alt', true );
	$w = $meta[ 'width' ];
	$h = $meta[ 'height' ];
	$ratio = $h/$w;

	if ( $bg_state ) {
		echo '
		<div 
			class="ashade-attachment-background ashade-page-background" 
			data-src="' . esc_url( $attachment ) . '"
			data-opacity="' . absint( $bg_opacity )/100  . '">
		</div>';
	} ?>
	<div class="ashade-page-title-wrap ashade-attachment-title-wrap">
        <h1 class="ashade-page-title">
			<?php 
			if ( $caption_state ) {
				echo '<span>' . ( ! empty( $img_caption ) ? esc_html( $img_caption ) : '&nbsp;' ) . '</span>';
			}
			if ( $title_state ) {
				the_title();
			}
            ?>
        </h1>
    </div><!-- .ashade-page-title-wrap -->
	<div id="attachment-<?php the_ID(); ?>" <?php post_class( 'ashade-attachment-wrap' ); ?>>
		<div class="ashade-attachment-inner">
			<div class="ashade-attachment" data-ratio="<?php echo esc_attr( $ratio ); ?>" data-width="<?php echo esc_attr( $w ); ?>" data-height="<?php echo esc_attr( $h ); ?>">
				<img src="<?php echo esc_url( $attachment ); ?>" width="<?php echo esc_attr( $w ); ?>" height="<?php echo esc_attr( $h ); ?>" alt="<?php echo esc_attr( $img_alt ); ?>"/>
				<?php if ( $description_state ) { ?>
				<div class="ashade-attachment-descr">
					<?php echo esc_html( $img_description ); ?>
				</div>
				<?php } ?>
			</div>
		</div><!-- .ashade-attachment-inner -->
	</div><!-- .ashade-attachment-wrap -->
<?php
	get_template_part( 'template-parts/footer-part' ); 
	get_template_part( 'template-parts/aside' );
	get_template_part( 'template-parts/page-ui' );

	get_footer();
?>