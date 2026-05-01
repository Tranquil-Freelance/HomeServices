<?php
/**
 * Ashade home landing: background, nav links, hidden works/contacts panels.
 * Markup must match theme JS (.ashade-home-link--a, #ashade-home-works, etc.).
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$opacity_raw = ashade_child_get_home_meta( 'ashade-home-bg-opacity', 75 );
$opacity     = absint( $opacity_raw ) / 100;
$bg_style    = ashade_child_get_home_meta( 'ashade-home-bg-style', 'static' );

$img_url = '';
$slides  = array();

if ( 'slider' === $bg_style ) {
	$gallery = ashade_child_get_home_meta( 'ashade-home-bg-gallery' );
	if ( is_array( $gallery ) ) {
		foreach ( $gallery as $item ) {
			$aid = ashade_child_attachment_id_from_rwmb_image( $item );
			if ( $aid ) {
				$u = wp_get_attachment_image_url( $aid, 'full' );
				if ( $u ) {
					$slides[] = $u;
				}
			}
		}
	}
	$order = ashade_child_get_home_meta( 'ashade-home-bg-gallery-order', 'normal' );
	if ( 'reverse' === $order ) {
		$slides = array_reverse( $slides );
	} elseif ( 'random' === $order ) {
		shuffle( $slides );
	}
} else {
	$static_imgs = ashade_child_get_home_meta( 'ashade-home-bg-image' );
	if ( is_array( $static_imgs ) ) {
		foreach ( $static_imgs as $item ) {
			$aid = ashade_child_attachment_id_from_rwmb_image( $item );
			if ( $aid ) {
				$u = wp_get_attachment_image_url( $aid, 'full' );
				if ( $u ) {
					$img_url = $u;
					break;
				}
			}
		}
	}
}

$trans = (int) ashade_child_get_home_meta( 'ashade-home-slider-transition', 2000 );
$delay = (int) ashade_child_get_home_meta( 'ashade-home-slider-delay', 4000 );
$zoom  = (float) ashade_child_get_home_meta( 'ashade-home-slider-zoom', 120 );
$zoom  = $zoom > 0 ? round( $zoom / 100, 2 ) : 1.2;

$back_oh  = ashade_child_get_home_meta( 'ashade-home-back-overhead', 'Return' );
$back_ttl = ashade_child_get_home_meta( 'ashade-home-back-title', 'Back' );

$works_state = ashade_child_get_home_meta( 'ashade-home-works-state', 'other' );
$works_state = is_scalar( $works_state ) ? (string) $works_state : 'other';
$show_works  = in_array( $works_state, array( 'yes', 'other' ), true );

$works_oh  = ashade_child_get_home_meta( 'ashade-home-works-overhead', 'what we do' );
$works_ttl = ashade_child_get_home_meta( 'ashade-home-works-title', 'Our Services' );

$contacts_state = ashade_child_get_home_meta( 'ashade-home-contacts-state', 'yes' );
$contacts_state = is_scalar( $contacts_state ) ? (string) $contacts_state : 'yes';
$show_contacts  = in_array( $contacts_state, array( 'yes', 'other' ), true );

$contacts_oh  = ashade_child_get_home_meta( 'ashade-home-contacts-overhead', 'get in touch' );
$contacts_ttl = ashade_child_get_home_meta( 'ashade-home-contacts-title', 'Request a quote' );

?>
<?php if ( 'slider' === $bg_style && count( $slides ) > 1 ) : ?>
	<div class="ashade-page-background" data-opacity="<?php echo esc_attr( $opacity ); ?>">
		<div class="ashade-kenburns-slider" data-transition="<?php echo esc_attr( $trans ); ?>" data-delay="<?php echo esc_attr( $delay ); ?>" data-zoom="<?php echo esc_attr( $zoom ); ?>">
			<?php foreach ( $slides as $src ) : ?>
				<div class="ashade-kenburns-slide" data-src="<?php echo esc_url( $src ); ?>"></div>
			<?php endforeach; ?>
		</div>
	</div>
<?php elseif ( $img_url ) : ?>
	<div class="ashade-page-background is-image" data-opacity="<?php echo esc_attr( $opacity ); ?>" data-src="<?php echo esc_url( $img_url ); ?>"></div>
<?php endif; ?>

<div class="ashade-page-title-wrap is-inactive">
	<h1 class="ashade-page-title is-inactive"><span>&nbsp;</span>&nbsp;</h1>
</div>

<section class="ashade-child-home-hero" aria-label="<?php esc_attr_e( 'Home services introduction', 'ashade' ); ?>">
	<p class="ashade-child-home-hero__eyebrow"><?php esc_html_e( 'Cleaning, repairs, and seasonal care', 'ashade' ); ?></p>
	<h2><?php esc_html_e( 'Reliable help for the jobs that keep your home running.', 'ashade' ); ?></h2>
	<p><?php esc_html_e( 'Book one trusted team for deep cleaning, handyman repairs, preventative maintenance, and property-care bundles. We scope the work clearly, protect your space, and send practical updates when the job is done.', 'ashade' ); ?></p>
	<div class="ashade-child-home-hero__actions">
		<a href="#" class="ashade-child-home-hero__button ashade-home-link--a" data-event="works"><?php esc_html_e( 'View services', 'ashade' ); ?></a>
		<a href="#" class="ashade-child-home-hero__button is-secondary ashade-home-link--a" data-event="contacts"><?php esc_html_e( 'Request a quote', 'ashade' ); ?></a>
	</div>
</section>

<?php if ( $show_works ) : ?>
<div class="ashade-home-link-wrap ashade-home-link--works is-inactive">
	<a href="#" class="ashade-home-link ashade-home-link--a" data-event="works">
		<span><?php echo esc_html( $works_oh ); ?></span>
		<span><?php echo esc_html( $works_ttl ); ?></span>
	</a>
</div>
<?php endif; ?>

<?php if ( $show_contacts ) : ?>
<div class="ashade-home-link-wrap ashade-home-link--contacts is-inactive">
	<a href="#" class="ashade-home-link ashade-home-link--a" data-event="contacts">
		<span><?php echo esc_html( $contacts_oh ); ?></span>
		<span><?php echo esc_html( $contacts_ttl ); ?></span>
	</a>
</div>
<?php endif; ?>

<div class="ashade-back-wrap ashade-home-return is-inactive">
	<a href="#" class="ashade-home-link ashade-home-link--a" data-event="back">
		<span><?php echo esc_html( $back_oh ); ?></span>
		<span><?php echo esc_html( $back_ttl ); ?></span>
	</a>
</div>

<div id="ashade-home-works">
	<?php echo ashade_child_home_works_panel_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- mixed HTML from setup ?>
</div>

<div id="ashade-home-contacts">
	<?php echo ashade_child_home_contacts_panel_html(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
</div>
