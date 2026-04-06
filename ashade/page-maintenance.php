<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

get_header();
the_post();

$bg_image = Ashade_Core::get_rwmb( 'ashade-maintenance-bg-image' );
if ( ! empty( $bg_image ) ) {
	foreach ( $bg_image as $item ) {
		$bg_image_url = wp_get_attachment_url( $item[ 'ID' ] );
	}
} else {
	$bg_image_url = '';
}
$opacity = Ashade_Core::get_rwmb( 'ashade-maintenance-bg-opacity' );
$date = Ashade_Core::get_rwmb( 'ashade-maintenance-date' );

$contact_list_state = Ashade_Core::get_rwmb( 'ashade-maintenance-contacts-list-state' );
$page_title = Ashade_Core::get_rwmb( 'ashade-maintenance-title', 'default' );
if ( 'default' == $page_title ) {
	$title_state = Ashade_Core::get_mod( 'ashade-page-title' );
} else {
	$title_state = Ashade_Core::get_rwmb( 'ashade-maintenance-title' );
}
$message_state = Ashade_Core::get_rwmb( 'ashade-maintenance-contacts-state' );
?>
	<!-- Background -->
	<div 
		class="ashade-maintenance-background ashade-page-background is-image" 
		data-opacity="<?php echo absint( $opacity )/100; ?>" 
		<?php echo ( ! empty( $bg_image_url ) ? 'data-src="' . esc_url( $bg_image_url ) . '"' : null ); ?>>
	</div><!-- .ashade-home-background -->

	<!-- Title -->
	<?php if ( $title_state ) { ?>
	<div class="ashade-page-title-wrap">
		<h1 class="ashade-page-title">
			<span><?php echo ( ! empty( Ashade_Core::get_rwmb( 'ashade-page-subtitle' ) ) ? esc_html( Ashade_Core::get_rwmb( 'ashade-page-subtitle' ) ) : '&nbsp;' ); ?></span>
			<?php the_title(); ?>
		</h1>
	</div>
	<?php } ?>
	
	<main id="page-<?php the_ID(); ?>" <?php post_class( 'ashade-content-wrap' ); ?>>
		<div class="ashade-content-scroll">
			<div class="ashade-content">
				<section class="ashade-section">
                    <div class="ashade-row ashade-row-middle">
                        <div class="ashade-col col-<?php echo ( 'yes' == $contact_list_state ? '8' : '12' ); ?>">
							<?php if ( ! empty( $date ) ) { ?>
							<div id="ashade-coming-soon" data-labels='["<?php echo esc_attr__( 'Days', 'ashade' ); ?>", "<?php echo esc_attr__( 'Hours', 'ashade' ); ?>", "<?php echo esc_attr__( 'Minutes', 'ashade' ); ?>", "<?php echo esc_attr__( 'Seconds', 'ashade' ); ?>"]'>
								<!-- YEAR-MONTH-DAY -->
								<time><?php echo esc_attr( $date ); ?></time>
							</div>
                            <?php } ?>
                        </div><!-- .ashade-col -->
						<?php 
						if ( 'yes' == $contact_list_state ) { 
						$contact_list_overhead = Ashade_Core::get_rwmb( 'ashade-maintenance-contacts-list-overhead' );
						$contact_list_title = Ashade_Core::get_rwmb( 'ashade-maintenance-contacts-list-title' );
						$contact_list_icons = Ashade_Core::get_rwmb( 'ashade-maintenance-contacts-list-icons' );
						$contact_list_location = Ashade_Core::get_rwmb( 'ashade-maintenance-contacts-list-location' );
						$contact_list_phone = Ashade_Core::get_rwmb( 'ashade-maintenance-contacts-list-phone' );
						$contact_list_email = Ashade_Core::get_rwmb( 'ashade-maintenance-contacts-list-email' );
						$contact_list_socials = Ashade_Core::get_rwmb( 'ashade-maintenance-contacts-list-socials' );
						?>
                        <div class="ashade-col col-4">
                            <div class="ashade-contact-details">
                                <h4 class="ashade-contact-details__title">
                                    <span><?php echo esc_html( $contact_list_overhead ); ?></span>
                                    <?php echo esc_html( $contact_list_title ); ?>
                                </h4>
                                <ul class="ashade-contact-details__list <?php echo ( $contact_list_icons ? 'has-labels' : '' ); ?>">
                                   	<?php if ( $contact_list_location ) { ?>
                                    <li>
										<?php if ( $contact_list_icons ) { ?>
                                        <i class="ashade-contact-icon asiade-icon--location"></i>
										<?php } ?>
                                        <?php echo esc_html( $contact_list_location ); ?>
                                    </li>
                                    <?php } ?>
                                    <?php if ( $contact_list_phone ) { ?>
                                    <li>
										<?php if ( $contact_list_icons ) { ?>
                                        <i class="ashade-contact-icon asiade-icon--phone"></i>
										<?php } ?>
										<?php echo '<a href="tel:' . esc_attr( strtr( $contact_list_phone, [' ' => '', '(' => '', ')' => '', '-' => ''] ) ) . '">' . esc_attr( $contact_list_phone ) . '</a>'; ?>
                                    </li>
                                    <?php } ?>
                                    <?php if ( $contact_list_email ) { ?>
                                    <li>
										<?php if ( $contact_list_icons ) { ?>
                                        <i class="ashade-contact-icon asiade-icon--email"></i>
										<?php } ?>
										<?php echo '<a href="mailto:' . sanitize_email( $contact_list_email ) . '">' . sanitize_email( $contact_list_email ) . '</a>'; ?>
                                    </li>
                                    <?php } ?>
									<?php if ( $contact_list_socials ) { ?>
                                    <li class="ashade-contact-socials">
										<?php if ( $contact_list_icons ) { ?>
                                        <i class="ashade-contact-icon asiade-icon--socials"></i>
										<?php }
										Ashade_Core::the_social_links();
                                        ?>
                                    </li>
									<?php } ?>
                                </ul>
                            </div><!-- .ashade-contact-details -->
                        </div><!-- .ashade-col -->
						<?php } ?>
                    </div><!-- .ashade-row -->
				</section>
			</div><!-- .ashade-content -->
		</div><!-- .ashade-content-scroll -->
	</main>
    
	<?php get_template_part( 'template-parts/footer-part' ); ?>
	
    <?php if ( 'yes' == $message_state ) { 
		$message_overhead = Ashade_Core::get_rwmb( 'ashade-maintenance-contacts-overhead' );
		$message_title = Ashade_Core::get_rwmb( 'ashade-maintenance-contacts-title' );
		$message_close_overhead = Ashade_Core::get_rwmb( 'ashade-maintenance-close-overhead' );
		$message_close_title = Ashade_Core::get_rwmb( 'ashade-maintenance-close-title' );
		$message_intro = Ashade_Core::get_rwmb( 'ashade-maintenance-contacts-intro' );
		$message_intro_align = Ashade_Core::get_rwmb( 'ashade-maintenance-intro-align' );
		$message_shortcode = Ashade_Core::get_rwmb( 'ashade-maintenance-shortcode' );
	?>
    <div id="ashade-contacts-wrap">
    	<a href="#" class="ashade-contacts-close"></a>
    	<div class="ashade-content">
    		<div class="ashade-row">
				<div class="ashade-col col-12">
                    <?php 
                    if ( ! empty( $message_shortcode ) ) {
                        echo '<div class="ashade-maintenance-form-wrap">';
                        echo do_shortcode( $message_shortcode );
                        echo '</div><!-- .ashade-maintenance-form-wrap -->';
                    }
                    ?>
				</div><!-- .ashade-col -->
			</div><!-- .ashade-row -->
    	</div><!-- .ashade-content -->
    </div><!-- #ashade-contacts-wrap -->

    <div class="ashade-to-top-wrap ashade-back-wrap">
        <div class="ashade-back is-message">
            <span><?php echo esc_html( $message_overhead ); ?></span>
            <span><?php echo esc_html( $message_title ); ?></span>
        </div>
        <div class="ashade-back is-message-close">
            <span><?php echo esc_html( $message_close_overhead ); ?></span>
            <span><?php echo esc_html( $message_close_title ); ?></span>
        </div>
    </div>
	
	<?php } ?>

<?php
get_template_part( 'template-parts/aside' );
get_template_part( 'template-parts/page-ui' );

get_footer();