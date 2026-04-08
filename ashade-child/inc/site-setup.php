<?php
/**
 * One-time builder: home-services pages, Ashade Home meta, main menu, images from Unsplash.
 * Runs once on first wp-admin load by an administrator (or add ?ashade_run_setup=1&_wpnonce=...).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Bump when starter content / migration logic changes (triggers one-time fix on existing sites). */
define( 'ASHADE_CHILD_STARTER_VERSION', 4 );

/**
 * Render / CI: set ASHADE_CHILD_AUTO_SETUP=1 so the first front-end hit (after WP is installed)
 * can run starter content + migrations without logging into wp-admin. Remove or set 0 after the site is correct.
 *
 * @return bool
 */
function ashade_child_auto_setup_env_enabled() {
	$v = getenv( 'ASHADE_CHILD_AUTO_SETUP' );
	if ( false === $v || '' === $v ) {
		return false;
	}
	$v = strtolower( trim( (string) $v ) );
	return in_array( $v, array( '1', 'true', 'yes', 'on' ), true );
}

/**
 * Run starter migrations (v3 then v4) with lock; used by admin hooks and headless auto-setup.
 */
function ashade_child_run_starter_migrations_now() {
	if ( get_transient( 'ashade_child_migrate_lock' ) ) {
		return;
	}
	set_transient( 'ashade_child_migrate_lock', 1, 120 );
	set_time_limit( 300 );
	try {
		$v = (int) get_option( 'ashade_child_starter_pack_version', 0 );
		if ( $v < 3 ) {
			ashade_child_run_starter_migration_v3();
		}
		$v = (int) get_option( 'ashade_child_starter_pack_version', 0 );
		if ( $v < ASHADE_CHILD_STARTER_VERSION ) {
			ashade_child_run_starter_migration_v4_contact_page();
		}
	} finally {
		delete_transient( 'ashade_child_migrate_lock' );
	}
}

/**
 * Headless: first requests after deploy apply DB changes (menu, pages, home meta) without wp-admin.
 */
function ashade_child_headless_autosetup() {
	if ( ! ashade_child_auto_setup_env_enabled() ) {
		return;
	}
	if ( ! is_blog_installed() || is_admin() ) {
		return;
	}
	if ( wp_doing_ajax() || wp_doing_cron() ) {
		return;
	}
	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return;
	}
	if ( get_transient( 'ashade_child_headless_lock' ) ) {
		return;
	}

	$need_initial = ! get_option( 'ashade_child_services_site_built' );
	$need_migrate = ! $need_initial && ( (int) get_option( 'ashade_child_starter_pack_version', 0 ) < ASHADE_CHILD_STARTER_VERSION );

	if ( ! $need_initial && ! $need_migrate ) {
		return;
	}

	set_transient( 'ashade_child_headless_lock', 1, 300 );
	set_time_limit( 300 );
	if ( function_exists( 'ignore_user_abort' ) ) {
		ignore_user_abort( true );
	}

	$admin_ids = get_users(
		array(
			'role'   => 'administrator',
			'number' => 1,
			'fields' => array( 'ID' ),
		)
	);
	if ( empty( $admin_ids ) ) {
		delete_transient( 'ashade_child_headless_lock' );
		return;
	}

	wp_set_current_user( (int) $admin_ids[0]->ID );

	try {
		if ( $need_initial ) {
			ashade_child_run_services_site_setup();
		} else {
			ashade_child_run_starter_migrations_now();
		}
	} finally {
		wp_set_current_user( 0 );
		delete_transient( 'ashade_child_headless_lock' );
	}
}
add_action( 'template_redirect', 'ashade_child_headless_autosetup', 0 );

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
 * Read home page Meta Box fields without the Meta Box plugin: Ashade_Core::get_rwmb() returns
 * defaults when RWMB_Loader is missing, even if setup stored values with update_post_meta().
 *
 * @param string     $key     Field id (e.g. ashade-home-bg-gallery).
 * @param mixed|null $default Same defaults as theme templates expect.
 * @return mixed
 */
function ashade_child_meta_value_is_present( $v ) {
	if ( null === $v || false === $v || '' === $v ) {
		return false;
	}
	if ( is_array( $v ) && 0 === count( $v ) ) {
		return false;
	}
	return true;
}

function ashade_child_get_home_meta( $key, $default = null ) {
	$post_id = get_queried_object_id();
	if ( ! $post_id ) {
		return $default;
	}
	if ( class_exists( 'RWMB_Loader' ) && function_exists( 'rwmb_meta' ) ) {
		$v = rwmb_meta( $key, array(), $post_id );
		if ( ashade_child_meta_value_is_present( $v ) ) {
			return $v;
		}
	}
	$raw = get_post_meta( $post_id, $key, true );
	if ( ashade_child_meta_value_is_present( $raw ) ) {
		return $raw;
	}
	return $default;
}

/**
 * Attachment IDs saved at setup (hero, slide2, …) for services HTML + home works panel.
 *
 * @return array<string, int>
 */
function ashade_child_get_setup_attachment_ids() {
	$stored = get_option( 'ashade_child_setup_attachment_ids', array() );
	return is_array( $stored ) ? $stored : array();
}

/**
 * Hidden “works” panel on home (services copy).
 */
function ashade_child_home_works_panel_html() {
	$ids = ashade_child_get_setup_attachment_ids();
	$inner = ! empty( $ids ) ? ashade_child_build_services_page_html( $ids ) : ashade_child_services_page_html_fallback();
	return '<section class="ashade-section"><div class="ashade-row"><div class="ashade-col col-12">' . $inner . '</div></div></section>';
}

/**
 * Hidden contacts panel on home (intro, optional CF7, contact list).
 */
function ashade_child_home_contacts_panel_html() {
	if ( ! class_exists( 'Ashade_Core' ) ) {
		return '';
	}
	$state = ashade_child_get_home_meta( 'ashade-home-contacts-state', 'no' );
	if ( 'yes' !== $state && 'other' !== $state ) {
		return '';
	}
	$intro     = ashade_child_get_home_meta( 'ashade-home-contacts-intro' );
	$shortcode = ashade_child_get_home_meta( 'ashade-home-contacts-shortcode' );
	$list_on   = ashade_child_get_home_meta( 'ashade-home-contacts-list-state', 'no' );
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
				$lo    = ashade_child_get_home_meta( 'ashade-home-contacts-list-overhead' );
				$lt    = ashade_child_get_home_meta( 'ashade-home-contacts-list-title' );
				$icons = ashade_child_get_home_meta( 'ashade-home-contacts-list-icons' );
				$loc   = ashade_child_get_home_meta( 'ashade-home-contacts-list-location' );
				$ph    = ashade_child_get_home_meta( 'ashade-home-contacts-list-phone' );
				$em    = ashade_child_get_home_meta( 'ashade-home-contacts-list-email' );
				$soc   = ashade_child_get_home_meta( 'ashade-home-contacts-list-socials' );
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
		'about' => array(
			'url'   => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1920&q=80',
			'title' => 'Team collaboration',
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
	$id = (int) $id;
	update_post_meta( $id, '_ashade_child_src', md5( $url ) );
	return $id;
}

/**
 * Reuse an existing sideloaded image (same Unsplash URL) instead of duplicating in the media library.
 *
 * @param string $url
 * @return int Attachment ID or 0.
 */
function ashade_child_find_attachment_by_source_url( $url ) {
	global $wpdb;
	$h = md5( $url );
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
	$found = $wpdb->get_var(
		$wpdb->prepare(
			"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = %s AND meta_value = %s LIMIT 1",
			'_ashade_child_src',
			$h
		)
	);
	return $found ? (int) $found : 0;
}

/**
 * @return int Menu term ID currently shown in the header, or 0.
 */
function ashade_child_get_assigned_main_menu_id() {
	$locs = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! empty( $locs['main'] ) ) {
		return (int) $locs['main'];
	}
	return 0;
}

/**
 * Ensure all starter images exist; fills gaps in $ids from option + new sideloads.
 *
 * @param array<string, int> $existing
 * @return array<string, int>
 */
function ashade_child_ensure_starter_images( array $existing = array() ) {
	$out = array_merge( array(), $existing );
	foreach ( ashade_child_setup_image_urls() as $key => $spec ) {
		if ( ! empty( $out[ $key ] ) && (int) $out[ $key ] > 0 ) {
			continue;
		}
		$reuse = ashade_child_find_attachment_by_source_url( $spec['url'] );
		if ( $reuse ) {
			$out[ $key ] = $reuse;
			continue;
		}
		if ( ! function_exists( 'download_url' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}
		$r = ashade_child_sideload_image( $spec['url'], $spec['title'] );
		if ( ! is_wp_error( $r ) ) {
			$out[ $key ] = (int) $r;
		}
	}
	return $out;
}

/**
 * Update Services / About / Journal / Contact body copy and featured images; refresh home slider meta.
 *
 * @param array<string, int> $ids
 */
function ashade_child_refresh_starter_pages_and_home_meta( array $ids ) {
	$service_keys = array( 'hero', 'slide2', 'slide3', 'services' );
	$svc_subset     = array_intersect_key( $ids, array_flip( $service_keys ) );
	$services_html  = ashade_child_build_services_page_html( $svc_subset );
	$about_img      = ! empty( $ids['about'] ) ? (int) $ids['about'] : 0;

	$p = get_page_by_path( 'services' );
	if ( $p ) {
		wp_update_post(
			array(
				'ID'           => (int) $p->ID,
				'post_content' => $services_html,
			)
		);
		if ( ! empty( $ids['services'] ) ) {
			set_post_thumbnail( (int) $p->ID, (int) $ids['services'] );
		}
	}
	$p = get_page_by_path( 'about' );
	if ( $p ) {
		wp_update_post(
			array(
				'ID'           => (int) $p->ID,
				'post_content' => ashade_child_build_about_page_html( $about_img ),
			)
		);
		if ( $about_img ) {
			set_post_thumbnail( (int) $p->ID, $about_img );
		}
	}
	$p = get_page_by_path( 'journal' );
	if ( $p ) {
		wp_update_post(
			array(
				'ID'           => (int) $p->ID,
				'post_content' => ashade_child_journal_page_html(),
			)
		);
		if ( ! empty( $ids['slide2'] ) ) {
			set_post_thumbnail( (int) $p->ID, (int) $ids['slide2'] );
		}
	}
	$p = get_page_by_path( 'contact' );
	if ( $p ) {
		wp_update_post(
			array(
				'ID'           => (int) $p->ID,
				'post_content' => ashade_child_contact_page_html(),
			)
		);
		if ( ! empty( $ids['slide3'] ) ) {
			set_post_thumbnail( (int) $p->ID, (int) $ids['slide3'] );
		}
	}

	$home_id = (int) get_option( 'page_on_front' );
	if ( ! $home_id ) {
		$hp = get_page_by_path( 'home' );
		$home_id = $hp ? (int) $hp->ID : 0;
	}
	$services_id = 0;
	$sp          = get_page_by_path( 'services' );
	if ( $sp ) {
		$services_id = (int) $sp->ID;
	}
	$gallery_ids = array();
	foreach ( array( 'hero', 'slide2', 'slide3', 'services' ) as $k ) {
		if ( ! empty( $ids[ $k ] ) ) {
			$gallery_ids[] = (int) $ids[ $k ];
		}
	}
	$hero_id = ! empty( $ids['hero'] ) ? (int) $ids['hero'] : 0;
	if ( $home_id ) {
		ashade_child_write_home_template_meta( $home_id, $services_id, $gallery_ids, $hero_id, 72 );
		if ( $hero_id ) {
			set_post_thumbnail( $home_id, $hero_id );
		}
	}

	$ids_to_store = array();
	foreach ( array( 'hero', 'slide2', 'slide3', 'services', 'about' ) as $k ) {
		if ( ! empty( $ids[ $k ] ) ) {
			$ids_to_store[ $k ] = (int) $ids[ $k ];
		}
	}
	update_option( 'ashade_child_setup_attachment_ids', $ids_to_store );
}

/**
 * One-time: fix duplicate nav (wipe menu assigned to “main”), ensure Unsplash IDs, rewrite page HTML with images.
 */
function ashade_child_run_starter_migration_v3() {
	$existing = ashade_child_get_setup_attachment_ids();
	$ids      = ashade_child_ensure_starter_images( $existing );
	ashade_child_refresh_starter_pages_and_home_meta( $ids );

	$menu_id = ashade_child_get_assigned_main_menu_id();
	if ( ! $menu_id ) {
		$menu_id = ashade_child_get_or_create_main_menu_id();
	}
	$home_id = (int) get_option( 'page_on_front' );
	if ( ! $home_id ) {
		$hp = get_page_by_path( 'home' );
		$home_id = $hp ? (int) $hp->ID : 0;
	}
	$services_id = 0;
	$sp          = get_page_by_path( 'services' );
	if ( $sp ) {
		$services_id = (int) $sp->ID;
	}
	$about_id = 0;
	$ap       = get_page_by_path( 'about' );
	if ( $ap ) {
		$about_id = (int) $ap->ID;
	}
	$blog_id = (int) get_option( 'page_for_posts' );
	$contact_id = 0;
	$cp         = get_page_by_path( 'contact' );
	if ( $cp ) {
		$contact_id = (int) $cp->ID;
	}
	if ( $menu_id ) {
		ashade_child_populate_main_menu( $menu_id, $home_id, $services_id, $about_id, $blog_id, $contact_id );
	}

	// Optional second header: keep mobile in sync so phones do not show old demo links.
	$locs = get_theme_mod( 'nav_menu_locations', array() );
	if ( ! empty( $locs['mobile'] ) && (int) $locs['mobile'] !== (int) $menu_id ) {
		$locs['mobile'] = (int) $menu_id;
		set_theme_mod( 'nav_menu_locations', $locs );
	}

	update_option( 'ashade_child_starter_pack_version', 3 );
}

/**
 * v4: restore the shorter Contact page copy (sites already on starter v3).
 */
function ashade_child_run_starter_migration_v4_contact_page() {
	$p = get_page_by_path( 'contact' );
	if ( $p ) {
		wp_update_post(
			array(
				'ID'           => (int) $p->ID,
				'post_content' => ashade_child_contact_page_html(),
			)
		);
	}
	update_option( 'ashade_child_starter_pack_version', ASHADE_CHILD_STARTER_VERSION );
	$uid = get_current_user_id();
	if ( $uid ) {
		set_transient( 'ashade_child_migrate_notice_' . $uid, 1, 300 );
	}
}

function ashade_child_maybe_run_starter_migration() {
	if ( ! get_option( 'ashade_child_services_site_built' ) ) {
		return;
	}
	if ( (int) get_option( 'ashade_child_starter_pack_version', 0 ) >= ASHADE_CHILD_STARTER_VERSION ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	ashade_child_run_starter_migrations_now();
}
add_action( 'admin_init', 'ashade_child_maybe_run_starter_migration', 0 );
add_action( 'template_redirect', 'ashade_child_maybe_run_starter_migration', 0 );

/**
 * Remove every item from a nav menu (fixes duplicate demo + setup links).
 *
 * @param int $menu_id Term ID of nav_menu.
 */
function ashade_child_delete_all_nav_menu_items( $menu_id ) {
	$menu_id = (int) $menu_id;
	if ( ! $menu_id ) {
		return;
	}
	$items = wp_get_nav_menu_items( $menu_id, array( 'post_status' => 'any' ) );
	if ( empty( $items ) || ! is_array( $items ) ) {
		return;
	}
	foreach ( $items as $item ) {
		if ( ! empty( $item->ID ) ) {
			wp_delete_post( (int) $item->ID, true );
		}
	}
}

/**
 * @return int Menu term ID.
 */
function ashade_child_get_or_create_main_menu_id() {
	$menu_name = 'Main Menu';
	$menu_id   = wp_create_nav_menu( $menu_name );
	if ( is_wp_error( $menu_id ) ) {
		foreach ( wp_get_nav_menus() as $m ) {
			if ( $m->name === $menu_name ) {
				return (int) $m->term_id;
			}
		}
		return 0;
	}
	return (int) $menu_id;
}

/**
 * Replace all links in Main Menu with Home Services pages.
 *
 * @param int $menu_id
 * @param int $home_id
 * @param int $services_id
 * @param int $about_id
 * @param int $blog_id
 * @param int $contact_id
 */
function ashade_child_populate_main_menu( $menu_id, $home_id, $services_id, $about_id, $blog_id, $contact_id ) {
	$menu_id = (int) $menu_id;
	if ( ! $menu_id ) {
		return;
	}
	ashade_child_delete_all_nav_menu_items( $menu_id );
	if ( $home_id ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => 'Home',
				'menu-item-object-id' => (int) $home_id,
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}
	if ( $services_id ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => 'Services',
				'menu-item-object-id' => (int) $services_id,
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}
	if ( $about_id ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => 'About',
				'menu-item-object-id' => (int) $about_id,
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}
	if ( $blog_id ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => 'Journal',
				'menu-item-object-id' => (int) $blog_id,
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}
	if ( $contact_id ) {
		wp_update_nav_menu_item(
			$menu_id,
			0,
			array(
				'menu-item-title'     => 'Contact',
				'menu-item-object-id' => (int) $contact_id,
				'menu-item-object'    => 'page',
				'menu-item-type'      => 'post_type',
				'menu-item-status'    => 'publish',
			)
		);
	}
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$locations['main'] = $menu_id;
	set_theme_mod( 'nav_menu_locations', $locations );
}

/**
 * Rebuild Main Menu from published pages (slugs: home, services, about, journal, contact).
 * For sites that already ran setup and have demo links stacked with ours.
 */
function ashade_child_rebuild_main_menu_from_slugs() {
	$home_id = (int) get_option( 'page_on_front' );
	if ( ! $home_id ) {
		$p = get_page_by_path( 'home' );
		$home_id = $p ? (int) $p->ID : 0;
	}
	$services_id = 0;
	$p           = get_page_by_path( 'services' );
	if ( $p ) {
		$services_id = (int) $p->ID;
	}
	$about_id = 0;
	$p        = get_page_by_path( 'about' );
	if ( $p ) {
		$about_id = (int) $p->ID;
	}
	$blog_id = (int) get_option( 'page_for_posts' );
	$contact_id = 0;
	$p          = get_page_by_path( 'contact' );
	if ( $p ) {
		$contact_id = (int) $p->ID;
	}
	$menu_id = ashade_child_get_assigned_main_menu_id();
	if ( ! $menu_id ) {
		$menu_id = ashade_child_get_or_create_main_menu_id();
	}
	if ( ! $menu_id ) {
		return;
	}
	ashade_child_populate_main_menu( $menu_id, $home_id, $services_id, $about_id, $blog_id, $contact_id );
}

/**
 * Rich Services page + home “works” panel using Ashade .ashade-service-item layout.
 *
 * @param array<string, int> $ids Keys: hero, slide2, slide3, services (attachment IDs).
 */
function ashade_child_build_services_page_html( array $ids ) {
	$blocks = array(
		array(
			'key'   => 'hero',
			'title' => __( 'Deep & recurring cleaning', 'ashade' ),
			'html'  => '<p>' . esc_html__( 'Scheduled housekeeping, move-in and move-out deep cleans, post-renovation dust control, and turnover cleaning for rentals. We bring supplies, work from a checklist you approve, and note maintenance issues we spot along the way.', 'ashade' ) . '</p><ul><li>' . esc_html__( 'Kitchens, baths, floors, and detail touchpoints', 'ashade' ) . '</li><li>' . esc_html__( 'Eco-friendly products on request', 'ashade' ) . '</li><li>' . esc_html__( 'Same crew when you choose recurring service', 'ashade' ) . '</li></ul>',
		),
		array(
			'key'   => 'slide2',
			'title' => __( 'Handyman & small repairs', 'ashade' ),
			'html'  => '<p>' . esc_html__( 'One visit for the “small stuff” that never gets scheduled: drywall patches, door adjustments, caulking, picture hanging, shelving, minor carpentry, and fixture swaps. We quote before we cut, and we protect floors and furniture while we work.', 'ashade' ) . '</p><ul><li>' . esc_html__( 'Hardware stores runs included on most jobs', 'ashade' ) . '</li><li>' . esc_html__( 'Licensed partners for plumbing & electrical when required', 'ashade' ) . '</li><li>' . esc_html__( 'Photo recap when the job is done', 'ashade' ) . '</li></ul>',
		),
		array(
			'key'   => 'slide3',
			'title' => __( 'Seasonal & preventative maintenance', 'ashade' ),
			'html'  => '<p>' . esc_html__( 'Twice-a-year tune-ups that prevent expensive surprises: gutters, downspouts, filters, weather-stripping, exterior walkthroughs, smoke/CO checks, and basic HVAC support between licensed service visits.', 'ashade' ) . '</p><ul><li>' . esc_html__( 'Spring and fall packages', 'ashade' ) . '</li><li>' . esc_html__( 'Written summary with photos', 'ashade' ) . '</li><li>' . esc_html__( 'Priority booking for bundle clients', 'ashade' ) . '</li></ul>',
		),
		array(
			'key'   => 'services',
			'title' => __( 'Concierge bundles for homes & small portfolios', 'ashade' ),
			'html'  => '<p>' . esc_html__( 'Combine cleaning, handyman blocks, and seasonal visits into one plan with a single point of contact. Ideal for busy homeowners, remote landlords, and small HOAs who want predictable care without managing five vendors.', 'ashade' ) . '</p><ul><li>' . esc_html__( 'Monthly or quarterly cadences', 'ashade' ) . '</li><li>' . esc_html__( 'Slack-style updates available', 'ashade' ) . '</li><li>' . esc_html__( 'Emergency triage queue for bundle members', 'ashade' ) . '</li></ul>',
		),
	);

	$out  = '<p class="ashade-intro align-center">' . esc_html__( 'Residential and light commercial care under one roof — clear scopes, steady crews, and photos when it matters. Tell us your priorities; we will propose a plan that fits your budget and calendar.', 'ashade' ) . '</p>';
	$out .= '<div class="ashade-child-services-stack">';

	foreach ( $blocks as $b ) {
		$aid = isset( $ids[ $b['key'] ] ) ? (int) $ids[ $b['key'] ] : 0;
		$url = $aid ? wp_get_attachment_image_url( $aid, 'large' ) : '';
		$out .= '<div class="ashade-service-item">';
		$out .= '<div class="ashade-service-item__image">';
		if ( $url ) {
			$out .= '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( $b['title'] ) . '" width="1200" height="800" loading="lazy" decoding="async" />';
		} else {
			$out .= '<div class="ashade-parallax-img" style="min-height:280px;background:#2a2a2e;"></div>';
		}
		$out .= '</div>';
		$out .= '<div class="ashade-service-item__content"><div class="ashade-service-item__content-inner">';
		$out .= '<h3>' . esc_html( $b['title'] ) . '</h3>';
		$out .= wp_kses_post( $b['html'] );
		$out .= '</div></div></div>';
	}

	$out .= '</div>';
	$out .= '<p class="ashade-intro align-center" style="margin-top:48px;"><strong>' . esc_html__( 'Ready when you are.', 'ashade' ) . '</strong> ' . esc_html__( 'Use Book a visit on the home screen or open Contact — we respond within one business day with a clear estimate.', 'ashade' ) . '</p>';

	return $out;
}

/**
 * @param int $img_id Attachment for optional image block.
 */
function ashade_child_build_about_page_html( $img_id = 0 ) {
	$img_id = (int) $img_id;
	$url    = $img_id ? wp_get_attachment_image_url( $img_id, 'large' ) : '';

	$html  = '<h2>' . esc_html__( 'Local crew, clear communication', 'ashade' ) . '</h2>';
	$html .= '<p>' . esc_html__( 'Home Services Co. grew out of a simple frustration: talented tradespeople, but chaotic scheduling, vague quotes, and no single owner for “everything else” around the house. We built a small, accountable team that shows up on time, explains trade-offs in plain language, and leaves every space tidier than we found it.', 'ashade' ) . '</p>';
	$html .= '<p>' . esc_html__( 'Whether you need a one-time deep clean, a punch list before guests arrive, or an ongoing relationship for your home or a handful of rental units, we treat the work like it matters — because it does. You get direct phone and email access, written scopes, and photo documentation on request.', 'ashade' ) . '</p>';
	$html .= '<h3>' . esc_html__( 'How we work', 'ashade' ) . '</h3>';
	$html .= '<ul><li>' . esc_html__( 'On-site or video walkthrough before larger jobs', 'ashade' ) . '</li><li>' . esc_html__( 'Itemized estimates — no mystery fees', 'ashade' ) . '</li><li>' . esc_html__( 'Respect for pets, kids, and work-from-home schedules', 'ashade' ) . '</li><li>' . esc_html__( 'Fully insured; COIs for property managers on request', 'ashade' ) . '</li></ul>';

	if ( $url ) {
		$html .= '<div class="ashade-service-item" style="margin-top:40px;">';
		$html .= '<div class="ashade-service-item__image"><img src="' . esc_url( $url ) . '" alt="' . esc_attr( __( 'Our team at work', 'ashade' ) ) . '" width="1200" height="800" loading="lazy" decoding="async" /></div>';
		$html .= '<div class="ashade-service-item__content"><div class="ashade-service-item__content-inner">';
		$html .= '<h3>' . esc_html__( 'On your block, on your schedule', 'ashade' ) . '</h3>';
		$html .= '<p>' . esc_html__( 'We serve metro neighborhoods and nearby suburbs by appointment. Same-week slots open up regularly for recurring clients.', 'ashade' ) . '</p>';
		$html .= '</div></div></div>';
	}

	return $html;
}

function ashade_child_run_services_site_setup() {
	if ( get_option( 'ashade_child_services_site_built' ) ) {
		return;
	}
	if ( get_transient( 'ashade_child_setup_running' ) ) {
		return;
	}
	set_transient( 'ashade_child_setup_running', 1, 600 );
	set_time_limit( 300 );

	try {
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

	$service_keys = array( 'hero', 'slide2', 'slide3', 'services' );
	$services_html = ashade_child_build_services_page_html( array_intersect_key( $ids, array_flip( $service_keys ) ) );
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

	$about_img = ! empty( $ids['about'] ) ? (int) $ids['about'] : 0;
	$about_id  = wp_insert_post(
		array(
			'post_title'   => 'About',
			'post_name'    => 'about',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => ashade_child_build_about_page_html( $about_img ),
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
			'post_content' => ashade_child_journal_page_html(),
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

	$ids_to_store = array();
	foreach ( array( 'hero', 'slide2', 'slide3', 'services', 'about' ) as $k ) {
		if ( ! empty( $ids[ $k ] ) ) {
			$ids_to_store[ $k ] = (int) $ids[ $k ];
		}
	}
	update_option( 'ashade_child_setup_attachment_ids', $ids_to_store );

	ashade_child_write_home_template_meta( $home_id, $svc_id, $gallery_ids, $hero_id, 72 );

	// Featured images for key pages (when sideload succeeded).
	if ( $hero_id ) {
		set_post_thumbnail( $home_id, $hero_id );
	}
	if ( ! is_wp_error( $services_id ) && $services_id && ! empty( $ids['services'] ) ) {
		set_post_thumbnail( (int) $services_id, (int) $ids['services'] );
	}
	if ( ! is_wp_error( $about_id ) && $about_id && $about_img ) {
		set_post_thumbnail( (int) $about_id, $about_img );
	}
	if ( ! is_wp_error( $blog_id ) && $blog_id && ! empty( $ids['slide2'] ) ) {
		set_post_thumbnail( (int) $blog_id, (int) $ids['slide2'] );
	}
	if ( ! is_wp_error( $contact_id ) && $contact_id && ! empty( $ids['slide3'] ) ) {
		set_post_thumbnail( (int) $contact_id, (int) $ids['slide3'] );
	}

	update_option( 'show_on_front', 'page' );
	update_option( 'page_on_front', (int) $home_id );
	if ( ! is_wp_error( $blog_id ) && $blog_id ) {
		update_option( 'page_for_posts', (int) $blog_id );
	}

	// Sample posts so Journal is not empty.
	$post1 = wp_insert_post(
		array(
			'post_title'    => 'Spring checklist for a healthier home',
			'post_status'   => 'publish',
			'post_type'     => 'post',
			'post_content'  => "<p>Filters, gutters, and weather-stripping — small tasks that prevent costly repairs later. We're sharing the checklist our teams use for seasonal tune-ups.</p><p>Start with HVAC: swap or clean filters, clear debris around outdoor units, and note any odd sounds before peak season. Then walk the roofline and gutters — overflow stains on siding often mean a clog upstream. Finally, check door and window weather-stripping; the fix is usually inexpensive and immediately improves comfort.</p>",
			'post_category' => array( 1 ),
		),
		true
	);
	if ( ! is_wp_error( $post1 ) && $post1 && ! empty( $ids['hero'] ) ) {
		set_post_thumbnail( (int) $post1, (int) $ids['hero'] );
	}
	$post2 = wp_insert_post(
		array(
			'post_title'    => 'When to call a pro vs. DIY for small repairs',
			'post_status'   => 'publish',
			'post_type'     => 'post',
			'post_content'  => '<p>Not every squeaky hinge needs a truck roll — but some jobs hide water, gas, or live wires behind the wall. We use a simple rule: if the failure could damage the structure, start a fire, or flood a room, stop and call a licensed specialist.</p><p>For cosmetic fixes, shelving, caulking, and hardware swaps, a handyman visit often saves a full day of YouTube and three trips to the store. We are happy to quote both ways so you can decide.</p>',
			'post_category' => array( 1 ),
		),
		true
	);
	if ( ! is_wp_error( $post2 ) && $post2 && ! empty( $ids['services'] ) ) {
		set_post_thumbnail( (int) $post2, (int) $ids['services'] );
	}

	$menu_id = ashade_child_get_or_create_main_menu_id();
	if ( $menu_id ) {
		ashade_child_populate_main_menu(
			$menu_id,
			(int) $home_id,
			( ! is_wp_error( $services_id ) && $services_id ) ? (int) $services_id : 0,
			( ! is_wp_error( $about_id ) && $about_id ) ? (int) $about_id : 0,
			( ! is_wp_error( $blog_id ) && $blog_id ) ? (int) $blog_id : 0,
			( ! is_wp_error( $contact_id ) && $contact_id ) ? (int) $contact_id : 0
		);
	}

	update_option( 'blogname', 'Home Services Co.' );
	update_option( 'blogdescription', 'Cleaning, repairs & seasonal care for your property.' );

	if ( wp_get_theme( 'ashade-child' )->exists() ) {
		switch_theme( 'ashade-child' );
	}

	update_option( 'ashade_child_services_site_built', 1 );
	update_option( 'ashade_child_starter_pack_version', ASHADE_CHILD_STARTER_VERSION );
	} finally {
		delete_transient( 'ashade_child_setup_running' );
	}
}

/**
 * Plain-text fallback when setup images are missing (e.g. sideload blocked).
 */
function ashade_child_services_page_html_fallback() {
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

/**
 * Services block for templates; uses stored attachment IDs after setup.
 */
function ashade_child_services_page_html() {
	$ids = ashade_child_get_setup_attachment_ids();
	if ( ! empty( $ids ) ) {
		return ashade_child_build_services_page_html( $ids );
	}
	return ashade_child_services_page_html_fallback();
}

function ashade_child_journal_page_html() {
	return <<<HTML
<p class="ashade-intro align-center">Seasonal checklists, honest repair advice, and short notes from the field — written for homeowners and small landlords who like fewer surprises.</p>
<p>Bookmark the Journal if you want a steady stream of practical tips between visits. We publish when we have something useful to say, not on a noisy marketing calendar.</p>
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

/**
 * Clear and rebuild Main Menu from front page + services/about/journal/contact pages (admin tool).
 */
function ashade_child_maybe_rebuild_main_menu() {
	if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( ! isset( $_GET['ashade_rebuild_main_menu'], $_GET['_wpnonce'] ) ) {
		return;
	}
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'ashade_rebuild_main_menu' ) ) {
		return;
	}
	ashade_child_rebuild_main_menu_from_slugs();
	wp_safe_redirect( admin_url( 'themes.php?ashade_menu_rebuilt=1' ) );
	exit;
}
add_action( 'admin_init', 'ashade_child_maybe_rebuild_main_menu', 2 );

function ashade_child_setup_admin_notice() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( get_option( 'ashade_child_services_site_built' ) ) {
		if ( isset( $_GET['ashade_setup_done'] ) ) {
			echo '<div class="notice notice-success is-dismissible"><p>Home Services starter content, menu, and home template settings were created. Review pages under <strong>Pages</strong> and customize your details.</p></div>';
		}
		if ( isset( $_GET['ashade_menu_rebuilt'] ) ) {
			echo '<div class="notice notice-success is-dismissible"><p><strong>Main Menu</strong> was cleared and rebuilt with Home, Services, About, Journal, and Contact. Open <strong>Appearance → Menus</strong> to verify.</p></div>';
		}
		$uid = get_current_user_id();
		if ( $uid && get_transient( 'ashade_child_migrate_notice_' . $uid ) ) {
			delete_transient( 'ashade_child_migrate_notice_' . $uid );
			echo '<div class="notice notice-success is-dismissible"><p><strong>Ashade Child:</strong> Starter content was refreshed (navigation, services images, and/or Contact page text). Reload the front of the site to review.</p></div>';
		}
		return;
	}
	$url = wp_nonce_url( admin_url( 'themes.php?ashade_run_setup=1' ), 'ashade_run_setup', '_wpnonce' );
	echo '<div class="notice notice-warning"><p><strong>Ashade Child:</strong> Build the service-business pages, menu, and home template (with Unsplash images)? <a href="' . esc_url( $url ) . '" class="button button-primary">Run setup</a></p></div>';
}
add_action( 'admin_notices', 'ashade_child_setup_admin_notice' );

/**
 * Persistent link: rebuild Main Menu (duplicate demo links).
 */
function ashade_child_setup_admin_menu_link() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( ! get_option( 'ashade_child_services_site_built' ) ) {
		return;
	}
	add_theme_page(
		__( 'Rebuild main menu', 'ashade' ),
		__( 'Rebuild main menu', 'ashade' ),
		'manage_options',
		'ashade-rebuild-menu',
		'ashade_child_rebuild_menu_screen'
	);
}
add_action( 'admin_menu', 'ashade_child_setup_admin_menu_link' );

function ashade_child_rebuild_menu_screen() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$url = wp_nonce_url( admin_url( 'themes.php?ashade_rebuild_main_menu=1' ), 'ashade_rebuild_main_menu', '_wpnonce' );
	echo '<div class="wrap"><h1>' . esc_html__( 'Rebuild main menu', 'ashade' ) . '</h1>';
	echo '<p>' . esc_html__( 'If your navigation shows duplicate items (for example demo links plus Home Services pages), use this to remove every item in Main Menu and add Home, Services, About, Journal, and Contact again.', 'ashade' ) . '</p>';
	echo '<p><a href="' . esc_url( $url ) . '" class="button button-primary">' . esc_html__( 'Rebuild Main Menu now', 'ashade' ) . '</a></p></div>';
}
