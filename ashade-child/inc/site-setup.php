<?php
/**
 * One-time builder: home-services pages, Ashade Home meta, main menu, images from Unsplash.
 * Runs once on first wp-admin load by an administrator (or add ?ashade_run_setup=1&_wpnonce=...).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @param mixed $item Meta Box image field entry (ID int or array with ID).
 * @return int Attachment ID or 0.
 */
function ashade_child_attachment_id_from_rwmb_image( $item ) {
	if ( is_array( $item ) && isset( $item['ID'] ) ) {
		return (int) $item['ID'];
	}
	if ( is_numeric( $item ) ) {
		return (int) $item;
	}
	return 0;
}

/**
 * Hidden “works” panel on home (services copy).
 */
function ashade_child_home_works_panel_html() {
	return '<section class="ashade-section"><div class="ashade-row"><div class="ashade-col col-12">' . ashade_child_services_page_html() . '</div></div></section>';
}

/**
 * Hidden contacts panel on home (intro, optional CF7, contact list).
 */
function ashade_child_home_contacts_panel_html() {
	if ( ! class_exists( 'Ashade_Core' ) ) {
		return '';
	}
	$state = Ashade_Core::get_rwmb( 'ashade-home-contacts-state', 'no' );
	if ( 'yes' !== $state && 'other' !== $state ) {
		return '';
	}
	$intro     = Ashade_Core::get_rwmb( 'ashade-home-contacts-intro' );
	$shortcode = Ashade_Core::get_rwmb( 'ashade-home-contacts-shortcode' );
	$list_on   = Ashade_Core::get_rwmb( 'ashade-home-contacts-list-state', 'no' );
	$col_main  = ( 'yes' === $list_on ) ? '8' : '12';

	ob_start();
	?>
	<section class="ashade-section">
		<div class="ashade-row ashade-row-middle">
			<div class="ashade-col col-<?php echo esc_attr( $col_main ); ?>">
				<?php
				if ( ! empty( $intro ) ) {
					echo '<p class="ashade-intro align-center">' . nl2br( esc_html( $intro ) ) . '</p>';
				}
				if ( ! empty( $shortcode ) ) {
					echo '<div class="ashade-maintenance-form-wrap">';
					echo do_shortcode( $shortcode );
					echo '</div>';
				}
				?>
			</div>
			<?php if ( 'yes' === $list_on ) : ?>
				<?php
				$lo    = Ashade_Core::get_rwmb( 'ashade-home-contacts-list-overhead' );
				$lt    = Ashade_Core::get_rwmb( 'ashade-home-contacts-list-title' );
				$icons = Ashade_Core::get_rwmb( 'ashade-home-contacts-list-icons' );
				$loc   = Ashade_Core::get_rwmb( 'ashade-home-contacts-list-location' );
				$ph    = Ashade_Core::get_rwmb( 'ashade-home-contacts-list-phone' );
				$em    = Ashade_Core::get_rwmb( 'ashade-home-contacts-list-email' );
				$soc   = Ashade_Core::get_rwmb( 'ashade-home-contacts-list-socials' );
				?>
			<div class="ashade-col col-4">
				<div class="ashade-contact-details">
					<h4 class="ashade-contact-details__title">
						<span><?php echo esc_html( $lo ); ?></span>
						<?php echo esc_html( $lt ); ?>
					</h4>
					<ul class="ashade-contact-details__list <?php echo $icons ? 'has-labels' : ''; ?>">
						<?php if ( $loc ) : ?>
						<li>
							<?php if ( $icons ) { echo '<i class="ashade-contact-icon asiade-icon--location"></i>'; } ?>
							<?php echo esc_html( $loc ); ?>
						</li>
						<?php endif; ?>
						<?php if ( $ph ) : ?>
						<li>
							<?php if ( $icons ) { echo '<i class="ashade-contact-icon asiade-icon--phone"></i>'; } ?>
							<?php
							$tel = strtr(
								$ph,
								array(
									' ' => '',
									'(' => '',
									')' => '',
									'-' => '',
								)
							);
							echo '<a href="tel:' . esc_attr( $tel ) . '">' . esc_html( $ph ) . '</a>';
							?>
						</li>
						<?php endif; ?>
						<?php if ( $em ) : ?>
						<li>
							<?php if ( $icons ) { echo '<i class="ashade-contact-icon asiade-icon--email"></i>'; } ?>
							<a href="mailto:<?php echo esc_attr( sanitize_email( $em ) ); ?>"><?php echo esc_html( sanitize_email( $em ) ); ?></a>
						</li>
						<?php endif; ?>
						<?php if ( $soc ) : ?>
						<li class="ashade-contact-socials">
							<?php if ( $icons ) { echo '<i class="ashade-contact-icon asiade-icon--socials"></i>'; } ?>
							<?php Ashade_Core::the_social_links(); ?>
						</li>
						<?php endif; ?>
					</ul>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</section>
	<?php
	return ob_get_clean();
}

/**
 * @param int   $home_id
 * @param int   $services_id
 * @param int[] $gallery_ids Attachment IDs for slider (or single).
 * @param int   $hero_id     Fallback static image.
 */
function ashade_child_write_home_template_meta( $home_id, $services_id, $gallery_ids, $hero_id, $opacity = 72 ) {
	if ( ! $home_id ) {
		return;
	}
	$use_rwmb = function_exists( 'rwmb_set_meta' );
	$set_meta = function ( $key, $value ) use ( $home_id, $use_rwmb ) {
		if ( $use_rwmb ) {
			rwmb_set_meta( $home_id, $key, $value );
		} else {
			update_post_meta( $home_id, $key, $value );
		}
	};

	$gallery_ids = array_values( array_filter( array_map( 'absint', (array) $gallery_ids ) ) );

	if ( count( $gallery_ids ) > 1 ) {
		$set_meta( 'ashade-home-bg-style', 'slider' );
		$set_meta( 'ashade-home-bg-gallery', $gallery_ids );
		$set_meta( 'ashade-home-bg-gallery-order', 'normal' );
		$set_meta( 'ashade-home-slider-transition', 2200 );
		$set_meta( 'ashade-home-slider-delay', 4500 );
		$set_meta( 'ashade-home-slider-zoom', 115 );
	} elseif ( $hero_id ) {
		$set_meta( 'ashade-home-bg-style', 'static' );
		$set_meta( 'ashade-home-bg-image', array( $hero_id ) );
	} elseif ( count( $gallery_ids ) === 1 ) {
		$set_meta( 'ashade-home-bg-style', 'static' );
		$set_meta( 'ashade-home-bg-image', array( $gallery_ids[0] ) );
	}

	$set_meta( 'ashade-home-bg-opacity', $opacity );

	$set_meta( 'ashade-home-back-overhead', 'welcome' );
	$set_meta( 'ashade-home-back-title', 'Home' );

	$set_meta( 'ashade-home-works-state', 'other' );
	if ( $services_id ) {
		$set_meta( 'ashade-home-works-page', $services_id );
	}
	$set_meta( 'ashade-home-works-overhead', 'what we do' );
	$set_meta( 'ashade-home-works-title', 'Our Services' );
	$set_meta( 'ashade-home-works-position', 36 );

	$set_meta( 'ashade-home-contacts-state', 'yes' );
	$set_meta( 'ashade-home-contacts-overhead', 'get in touch' );
	$set_meta( 'ashade-home-contacts-title', 'Book a visit' );
	$set_meta(
		'ashade-home-contacts-intro',
		'Tell us what you need — deep cleaning, handyman repairs, seasonal maintenance, or a bundled home-care plan. We reply within one business day.'
	);
	$set_meta( 'ashade-home-contacts-list-state', 'yes' );
	$set_meta( 'ashade-home-contacts-list-overhead', 'reach us' );
	$set_meta( 'ashade-home-contacts-list-title', 'Home Services' );
	$set_meta( 'ashade-home-contacts-list-icons', 1 );
	$set_meta( 'ashade-home-contacts-list-location', 'Serving metro & surrounding neighborhoods — on-site visits by appointment.' );
	$set_meta( 'ashade-home-contacts-list-phone', '(555) 014-2270' );
	$set_meta( 'ashade-home-contacts-list-email', 'hello@homeservices.example' );
	$set_meta( 'ashade-home-contacts-list-socials', 1 );
	$set_meta( 'ashade-home-contacts-position', 68 );
}

/**
 * Unsplash Source URLs — direct downloads, license: https://unsplash.com/license
 * Themed for residential / commercial property services (maintenance, cleaning, repairs).
 */
function ashade_child_setup_image_urls() {
	return array(
		'hero' => array(
			'url'   => 'https://images.unsplash.com/photo-1581578731548-c64695cc6952?w=1920&q=80',
			'title' => 'Professional cleaning team',
		),
		'slide2' => array(
			'url'   => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?w=1920&q=80',
			'title' => 'Home repair and tools',
		),
		'slide3' => array(
			'url'   => 'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?w=1920&q=80',
			'title' => 'HVAC maintenance',
		),
		'services' => array(
			'url'   => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=1920&q=80',
			'title' => 'Modern home exterior care',
		),
	);
}

/**
 * @param string $url
 * @param string $title
 * @param int    $post_id Attach to this post as featured/thumbnail context.
 * @return int|\WP_Error Attachment ID or error.
 */
function ashade_child_sideload_image( $url, $title, $post_id = 0 ) {
	if ( ! function_exists( 'media_handle_sideload' ) ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';
	}
	$tmp = download_url( $url );
	if ( is_wp_error( $tmp ) ) {
		return $tmp;
	}
	$file_array = array(
		'name'     => sanitize_file_name( $title ) . '.jpg',
		'tmp_name' => $tmp,
	);
	$id = media_handle_sideload( $file_array, $post_id, $title );
	if ( is_wp_error( $id ) ) {
		@unlink( $file_array['tmp_name'] );
		return $id;
	}
	return (int) $id;
}

function ashade_child_run_services_site_setup() {
	$images = ashade_child_setup_image_urls();
	$ids    = array();
	foreach ( $images as $key => $spec ) {
		$r = ashade_child_sideload_image( $spec['url'], $spec['title'] );
		if ( is_wp_error( $r ) ) {
			continue;
		}
		$ids[ $key ] = $r;
	}

	$home_id = wp_insert_post(
		array(
			'post_title'   => 'Home',
			'post_name'    => 'home',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '<!-- Landing UI is output by the child theme page-home.php + home-landing.php. -->',
		),
		true
	);
	if ( is_wp_error( $home_id ) ) {
		return;
	}
	update_post_meta( $home_id, '_wp_page_template', 'page-home.php' );

	$services_html = ashade_child_services_page_html();
	$services_id   = wp_insert_post(
		array(
			'post_title'   => 'Services',
			'post_name'    => 'services',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => $services_html,
		),
		true
	);

	$about_id = wp_insert_post(
		array(
			'post_title'   => 'About',
			'post_name'    => 'about',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => ashade_child_about_page_html(),
		),
		true
	);

	$contact_id = wp_insert_post(
		array(
			'post_title'   => 'Contact',
			'post_name'    => 'contact',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => ashade_child_contact_page_html(),
		),
		true
	);

	$blog_id = wp_insert_post(
		array(
			'post_title'   => 'Journal',
			'post_name'    => 'journal',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '<p>Updates, seasonal tips, and news from our crew.</p>',
		),
		true
	);

	$gallery_ids = array();
	foreach ( array( 'hero', 'slide2', 'slide3', 'services' ) as $k ) {
		if ( ! empty( $ids[ $k ] ) ) {
			$gallery_ids[] = (int) $ids[ $k ];
		}
	}
	$hero_id = ! empty( $ids['hero'] ) ? (int) $ids['hero'] : 0;
	$svc_id  = ( ! is_wp_error( $services_id ) && $services_id ) ? (int) $services_id : 0;

	ashade_child_write_home_template_meta( $home_id, $svc_id, $gallery_ids, $hero_id, 72 );

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', (int) $home_id );
	if ( ! is_wp_error( $blog_id ) && $blog_id ) {
		update_option( 'page_for_posts', (int) $blog_id );
	}

	// Sample post so Journal is not empty.
	wp_insert_post(
		array(
			'post_title'   => 'Spring checklist for a healthier home',
			'post_status'  => 'publish',
			'post_type'    => 'post',
			'post_content' => "<p>Filters, gutters, and weather-stripping — small tasks that prevent costly repairs later. We're sharing the checklist our teams use for seasonal tune-ups.</p>",
			'post_category'=> array( 1 ),
		)
	);

	$menu_name = 'Main Menu';
	$menu_id   = wp_create_nav_menu( $menu_name );
	if ( is_wp_error( $menu_id ) ) {
		$menus = wp_get_nav_menus();
		foreach ( $menus as $m ) {
			if ( $m->name === $menu_name ) {
				$menu_id = (int) $m->term_id;
				break;
			}
		}
	}
	if ( ! is_wp_error( $menu_id ) && $menu_id ) {
		wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => 'Home', 'menu-item-object-id' => (int) $home_id, 'menu-item-object' => 'page', 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );
		if ( ! is_wp_error( $services_id ) && $services_id ) {
			wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => 'Services', 'menu-item-object-id' => (int) $services_id, 'menu-item-object' => 'page', 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );
		}
		if ( ! is_wp_error( $about_id ) && $about_id ) {
			wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => 'About', 'menu-item-object-id' => (int) $about_id, 'menu-item-object' => 'page', 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );
		}
		if ( ! is_wp_error( $blog_id ) && $blog_id ) {
			wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => 'Journal', 'menu-item-object-id' => (int) $blog_id, 'menu-item-object' => 'page', 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );
		}
		if ( ! is_wp_error( $contact_id ) && $contact_id ) {
			wp_update_nav_menu_item( $menu_id, 0, array( 'menu-item-title' => 'Contact', 'menu-item-object-id' => (int) $contact_id, 'menu-item-object' => 'page', 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish' ) );
		}
		$locations = get_theme_mod( 'nav_menu_locations', array() );
		$locations['main'] = (int) $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
	}

	update_option( 'blogname', 'Home Services Co.' );
	update_option( 'blogdescription', 'Cleaning, repairs & seasonal care for your property.' );
	update_option( 'ashade_child_services_site_built', 1 );
}

function ashade_child_services_page_html() {
	return <<<HTML
<h2>Residential &amp; light commercial care</h2>
<p>We keep properties presentable, safe, and running smoothly — without you juggling five different vendors.</p>

<h3>Deep &amp; recurring cleaning</h3>
<p>Move-in/out cleans, post-renovation dust control, and scheduled maintenance for busy households and rental units.</p>

<h3>Handyman &amp; small repairs</h3>
<p>Drywall touch-ups, fixture swaps, caulking, shelving, minor carpentry, and the “we’ll get it done” tasks that pile up.</p>

<h3>Seasonal &amp; preventative maintenance</h3>
<p>Gutter checks, filter replacements, weather-stripping, exterior walkthroughs, and simple HVAC support between pro service visits.</p>

<h3>Concierge bundles</h3>
<p>One plan: recurring visits plus a priority queue for urgent fixes — ideal for homeowners and property managers.</p>

<p><strong>Ready?</strong> Use <em>Book a visit</em> on the home screen or open the Contact page — we’ll scope the work and send a clear estimate.</p>
HTML;
}

function ashade_child_about_page_html() {
	return <<<HTML
<h2>Local crew, clear communication</h2>
<p>Home Services Co. started from a simple frustration: great tradespeople, but chaotic scheduling and vague quotes. We built a team that shows up on time, explains options in plain language, and leaves the space cleaner than we found it.</p>
<p>Whether you need a one-time deep clean or an ongoing relationship for your home or small portfolio, we treat every job like it matters — because it does.</p>
HTML;
}

function ashade_child_contact_page_html() {
	return <<<HTML
<h2>Contact</h2>
<p><strong>Phone:</strong> (555) 014-2270<br><strong>Email:</strong> hello@homeservices.example</p>
<p>We typically respond within one business day. For urgent leaks or electrical hazards, please call emergency services first.</p>
<p><em>Add a Contact Form 7 shortcode here after installing the plugin if you want a form on this page.</em></p>
HTML;
}

function ashade_child_maybe_schedule_services_setup() {
	if ( get_option( 'ashade_child_services_site_built' ) ) {
		return;
	}
	if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( isset( $_GET['ashade_run_setup'] ) && isset( $_GET['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'ashade_run_setup' ) ) {
		set_time_limit( 300 );
		ashade_child_run_services_site_setup();
		wp_safe_redirect( admin_url( 'themes.php?ashade_setup_done=1' ) );
		exit;
	}
}
add_action( 'admin_init', 'ashade_child_maybe_schedule_services_setup', 1 );

function ashade_child_setup_admin_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( get_option( 'ashade_child_services_site_built' ) ) {
		if ( isset( $_GET['ashade_setup_done'] ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>Home Services starter content, menu, and home template settings were created. Review pages under <strong>Pages</strong> and customize your details.</p></div>';
		}
		return;
	}
	$url = wp_nonce_url( admin_url( 'themes.php?ashade_run_setup=1' ), 'ashade_run_setup', '_wpnonce' );
	echo '<div class="notice notice-warning"><p><strong>Ashade Child:</strong> Build the service-business pages, menu, and home template (with Unsplash images)? <a href="' . esc_url( $url ) . '" class="button button-primary">Run setup</a></p></div>';
}
add_action( 'admin_notices', 'ashade_child_setup_admin_notice' );
