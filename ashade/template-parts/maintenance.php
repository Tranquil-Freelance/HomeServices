<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( 1 == Ashade_Core::get_rwmb( 'ashade-maintenance-mode', false ) ) {
    $opacity = 0;
    if ( 'featured' === Ashade_Core::get_rwmb( 'ashade-maintenance-bg-usage' ) ) {
        $bg_image = wp_get_attachment_image_url( get_post_thumbnail_id(), 'full' );
        $opacity = Ashade_Core::get_rwmb( 'ashade-maintenance-opacity' );
    } else if ( 'default' === Ashade_Core::get_rwmb( 'ashade-maintenance-bg-usage' ) ) {
        $bg_image = Ashade_Core::get_mod( 'ashade-maintenance-bg' );
        $opacity = Ashade_Core::get_mod( 'ashade-maintenance-opacity' );
    } else {
        $bg_image = false;
    }
    $date   = Ashade_Core::get_rwmb( 'ashade-maintenance-page-date' );
    $labels = Ashade_Core::get_rwmb( 'ashade-maintenance-labels' );
} else {
    $bg_image = Ashade_Core::get_mod( 'ashade-maintenance-bg' );
    $opacity  = Ashade_Core::get_mod( 'ashade-maintenance-opacity' );
    $date     = Ashade_Core::get_mod( 'ashade-maintenance-page-date' );
    $labels   = Ashade_Core::get_mod( 'ashade-maintenance-labels' );
}

if ( Ashade_Core::get_rwmb( 'ashade-maintenance-contact-widget', 'default' ) == 'default' ) {
    $contact_list_state = Ashade_Core::get_mod( 'ashade-maintenance-contact-widget', 'default' );
    if ( $contact_list_state ) {
        $contact_overhead = Ashade_Core::get_mod( 'ashade-maintenance-contact-widget-overhead' );
        $contact_title = Ashade_Core::get_mod( 'ashade-maintenance-contact-widget-title' );
        $contact_address = Ashade_Core::get_mod( 'ashade-maintenance-contact-widget-location' );
        $contact_phone = Ashade_Core::get_mod( 'ashade-maintenance-contact-widget-phone' );
        $contact_email = Ashade_Core::get_mod( 'ashade-maintenance-contact-widget-email' );
        $contact_socials = Ashade_Core::get_mod( 'ashade-maintenance-contact-widget-socials' );
        $contact_icons = Ashade_Core::get_mod( 'ashade-maintenance-contact-widget-icons' );
    }
} else {
    $contact_list_state = Ashade_Core::get_rwmb( 'ashade-maintenance-contact-widget', 'default' );
    if ( $contact_list_state ) {
        $contact_overhead = Ashade_Core::get_rwmb( 'ashade-maintenance-contact-widget-overhead' );
        $contact_title = Ashade_Core::get_rwmb( 'ashade-maintenance-contact-widget-title' );
        $contact_address = Ashade_Core::get_rwmb( 'ashade-maintenance-contact-widget-location' );
        $contact_phone = Ashade_Core::get_rwmb( 'ashade-maintenance-contact-widget-phone' );
        $contact_email = Ashade_Core::get_rwmb( 'ashade-maintenance-contact-widget-email' );
        $contact_socials = Ashade_Core::get_rwmb( 'ashade-maintenance-contact-widget-socials' );
        $contact_icons = Ashade_Core::get_rwmb( 'ashade-maintenance-contact-widget-icons' );
    }
}

?>
<div class="ashade-maintenance-wrap">
    <!-- Background -->
    <div 
		class="ashade-maintenance-background ashade-page-background is-image" 
		data-opacity="<?php echo absint( $opacity )/100; ?>" 
		<?php echo ( ! empty( $bg_image ) ? 'data-src="' . esc_url( $bg_image ) . '"' : null ); ?>>
	</div><!-- .ashade-home-background -->

    <!-- Title -->
	<div class="ashade-page-title-wrap">
		<h1 class="ashade-page-title">
			<span><?php echo ( ! empty( Ashade_Core::get_rwmb( 'ashade-page-subtitle' ) ) ? esc_html( Ashade_Core::get_rwmb( 'ashade-page-subtitle' ) ) : '&nbsp;' ); ?></span>
			<?php the_title(); ?>
		</h1>
	</div>

    <main id="page-<?php the_ID(); ?>" <?php post_class( 'ashade-content-wrap' ); ?>>
		<div class="ashade-content-scroll">
			<div class="ashade-content">
				<section class="ashade-section">
                    <div class="ashade-row ashade-row-middle">
                        <div class="ashade-col col-<?php echo esc_attr( $contact_list_state ? '8' : '12' ); ?>">
							<?php if ( ! empty( $date ) ) { ?>
							<div id="ashade-coming-soon" data-labels='["<?php echo esc_attr__( 'Days', 'ashade' ); ?>", "<?php echo esc_attr__( 'Hours', 'ashade' ); ?>", "<?php echo esc_attr__( 'Minutes', 'ashade' ); ?>", "<?php echo esc_attr__( 'Seconds', 'ashade' ); ?>"]'>
								<!-- YEAR-MONTH-DAY -->
								<time><?php echo esc_attr( $date ); ?></time>
							</div>
                            <?php } ?>
                        </div><!-- .ashade-col -->
						<?php 
						if ( $contact_list_state ) { 
						?>
                        <div class="ashade-col col-4">
                            <div class="ashade-contact-details">
                                <h4 class="ashade-contact-details__title">
                                    <span><?php echo esc_html( $contact_overhead ); ?></span>
                                    <?php echo esc_html( $contact_title ); ?>
                                </h4>
                                <ul class="ashade-contact-details__list <?php echo ( $contact_icons ? 'has-labels' : '' ); ?>">
                                   	<?php if ( $contact_address ) { ?>
                                    <li>
										<?php if ( $contact_icons ) { ?>
                                        <i class="ashade-contact-icon asiade-icon--location"></i>
										<?php } ?>
                                        <?php echo esc_html( $contact_address ); ?>
                                    </li>
                                    <?php } ?>
                                    <?php if ( $contact_phone ) { ?>
                                    <li>
										<?php if ( $contact_icons ) { ?>
                                        <i class="ashade-contact-icon asiade-icon--phone"></i>
										<?php } ?>
										<?php echo '<a href="tel:' . esc_attr( strtr( $contact_phone, [' ' => '', '(' => '', ')' => '', '-' => ''] ) ) . '">' . esc_attr( $contact_phone ) . '</a>'; ?>
                                    </li>
                                    <?php } ?>
                                    <?php if ( $contact_email ) { ?>
                                    <li>
										<?php if ( $contact_icons ) { ?>
                                        <i class="ashade-contact-icon asiade-icon--email"></i>
										<?php } ?>
										<?php echo '<a href="mailto:' . sanitize_email( $contact_email ) . '">' . sanitize_email( $contact_email ) . '</a>'; ?>
                                    </li>
                                    <?php } ?>
									<?php if ( $contact_socials ) { ?>
                                    <li class="ashade-contact-socials">
										<?php if ( $contact_icons ) { ?>
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

    <?php if ( Ashade_Core::get_mod( 'ashade-maintenance-contact-form' ) ) { 
		$message_overhead = Ashade_Core::get_mod( 'ashade-maintenance-contact-form-overhead' );
		$message_title = Ashade_Core::get_mod( 'ashade-maintenance-contact-form-title' );
		$message_close_overhead = Ashade_Core::get_mod( 'ashade-maintenance-contact-form-roverhead' );
		$message_close_title = Ashade_Core::get_mod( 'ashade-maintenance-contact-form-rtitle' );
		$message_shortcode = Ashade_Core::get_mod( 'ashade-maintenance-contact-form-shortcode' );
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
</div>
<?php

get_template_part( 'template-parts/page-ui' );