<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

# Theme Setup
if ( ! isset( $content_width ) ) $content_width = 1280;

if ( ! function_exists( 'ashade_setup' ) ) {
	function ashade_setup() {
		// i18n
		load_theme_textdomain( 'ashade', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'main' => esc_attr__( 'Main Menu', 'ashade' ),
		) );

		// Switch default core markup for search form, comment form, and comments
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		
		// Enable Shadowcore Video Galleries
		add_theme_support( 'shadowcore-video-galleries' );

		// Enable Shadowcore SEO Add-ons
		add_theme_support( 'shadowcore-seo' );

		// Load Theme Files
		require_once( get_template_directory() . '/inc/loader.php' );

        // Alternative Mobile Menu
        if ( Ashade_Core::get_mod( 'ashade-mobile-menu-alt' ) ) {
            register_nav_menus( array(
                'mobile' => esc_attr__( 'Mobile Menu', 'ashade' ),
            ) );
        }

		// Footer Menu
        if ( Ashade_Core::get_mod( 'ashade-footer-menu-position' ) !== 'none' ) {
            register_nav_menus( array(
                'ashade-footer' => esc_attr__( 'Footer Menu', 'ashade' ),
            ) );
        }

		// Disable Block Editor for Widgets
		if ( Ashade_Core::get_mod( 'ashade-gutenberg-widgets' ) ) {
			# Gutenberg plugin.
			add_filter( 'gutenberg_use_widgets_block_editor', '__return_false', 100 );
			# WP 5.8
			add_filter( 'use_widgets_block_editor', '__return_false' );
		}
        
		// WooCommerce Support
		if ( class_exists( 'WooCommerce' ) ) {
			add_theme_support( 
				'woocommerce', array (
					'thumbnail_image_width'  => 640,
					'thumbnail_image_height' => 640,
					'single_image_width'     => 960,
					'product_grid'           => array(
						'default_rows'    => 3,
						'min_rows'        => 1,
						'default_columns' => 3,
						'min_columns'     => 2,
						'max_columns'     => 4,
					),
				) 
			);
		}

		// Init Shadow Core
		if ( class_exists( 'Shadow_Core' ) ) {
			$theme_config = array(
				'theme_name' => 'Ashade',
				'theme_prefix' => 'ashade',
				'theme_settings' => true,
				'base_class_name' => 'Ashade_Core',
				'elementor' => array(
					'widgets' => array(
						'query-listing',
						'query-grid',
						'query-ribbon',
						'query-slider',
						'info-card',
						'info-card-grid',
						'blog-simple',
						'testimonials-grid',
						'testimonials-carousel',
						'before-after',
						'gallery-grid',
						'gallery-masonry',
						'gallery-justified',
						'gallery-bricks',
						'gallery-adjusted',
						'gallery-kenburns',
						'gallery-slider',
						'gallery-ribbon',
						'price-table',
						'countdown',
						'circle-progress',
					),
					'defaults' => array(
						// Price Table
						'shadow-price-table' => array(
							'price_spacing' => [
								'unit' => 'px',
			                    'size' => 6,
							],
							'mp_wrap_padding' => [
								'top' => '0',
								'right' => '0',
								'bottom' => '0',
								'left' => '0',
								'isLinked' => true,
								'unit' => 'px'
							],
							'mp_label_padding' => [ 
								'top' => '8',
								'right' => '16',
								'bottom' => '8',
								'left' => '16',
								'isLinked' => false,
								'unit' => 'px'
							],
							'mp_border_radius' => [
								'top' => '0',
								'right' => '0',
								'bottom' => '0',
								'left' => '0',
								'isLinked' => true,
								'unit' => 'px'
							]
						),
						// Query Listing
						'shadow-query-listing' => array(
							'post_types' => Array(
								'post' => esc_html__( 'Blog Post', 'ashade' ),
							),
							'image_size' => [ 'unit' => 'px', 'size' => 50 ],
							'post_meta__post_tag' => 'bottom',
							'head_swap' => 'yes',
							'listing_type' => 'small',
							'post_meta__date' => 'top',
							'post_meta__comments' => 'none',
							'post_meta__category' => 'top',
							'excerpt_spacing' => [ 'unit' => 'px', 'size' => 19 ],
							'footer_spacing' => [ 'unit' => 'px', 'size' => 18 ]
						),
						// Query Grid
						'shadow-query-grid' => array(
							'post_type' => 'ashade-albums',
							'post_types' => Array(
								'ashade-albums' => Ashade_Core::get_mod( 'ashade-cpt-albums-label' ),
								'post' => esc_html__( 'Blog Post', 'ashade' ),
								'product' => esc_html__( 'Product', 'ashade' ),
								'ashade-clients' => Ashade_Core::get_mod( 'ashade-cpt-clients-label' ),
							),
							'head_swap' => 'yes',
							'post_meta__albums-category' => 'yes',
							'post_meta__product_cat' => 'yes',
							'post_meta__category' => 'yes',
							'title_spacing' => [ 'unit' => 'px', 'size' => 0 ],
							'padding' => [ 'top' => '15', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => false, 'unit' => 'px' ],
						),
						// Query Ribbon
						'shadow-query-ribbon' => array(
							'post_type' => 'ashade-albums',
							'post_types' => Array(
								'ashade-albums' => Ashade_Core::get_mod( 'ashade-cpt-albums-label' ),
								'post' => esc_html__( 'Blog Post', 'ashade' ),
								'product' => esc_html__( 'Product', 'ashade' ),
								'ashade-clients' => Ashade_Core::get_mod( 'ashade-cpt-clients-label' ),
							),
							'post_meta__albums-category' => 'yes',
							'post_meta__product_cat' => 'yes',
							'post_meta__category' => 'yes',
							'head_swap' => 'yes',
							'title_spacing' => [ 'unit' => 'px', 'size' => 2 ],
							'padding' => [ 'top' => '30', 'right' => '40', 'bottom' => '30', 'left' => '40', 'isLinked' => false, 'unit' => 'px' ],
							'post_content' => 'bottom'
						),
						// Query Slider
						'shadow-query-slider' => array(
							'post_type' => 'ashade-albums',
							'post_types' => Array(
								'ashade-albums' => Ashade_Core::get_mod( 'ashade-cpt-albums-label' ),
								'post' => esc_html__( 'Blog Post', 'ashade' ),
								'product' => esc_html__( 'Product', 'ashade' ),
								'ashade-clients' => Ashade_Core::get_mod( 'ashade-cpt-clients-label' ),
							),
							'post_meta__albums-category' => 'yes',
							'post_meta__product_cat' => 'yes',
							'post_meta__category' => 'yes',
							'content_h_position' => 'center',
							'head_swap' => 'yes',
							'title_spacing' => [ 'unit' => 'px', 'size' => 2 ],
							'slider_nav' => 'text',
							'nav_v_position' => 'bottom',
							'nav_padding' => [ 'top' => '40', 'right' => '40', 'bottom' => '20', 'left' => '40', 'isLinked' => false, 'unit' => 'px' ],
						),
						// Gallery Slider
						'shadow-gallery-slider' => array(
							'caption_h_position' => 'center',
							'slider_nav' => 'text',
							'nav_padding' => [ 'top' => '40', 'right' => '40', 'bottom' => '20', 'left' => '40', 'isLinked' => false, 'unit' => 'px' ],
						)
					)
				),
				'widgets' => array( 'contact', 'about' ),
			);

			// Back support older versions
			$sc_version = explode('.', Shadow_Core::VERSION);
			if ( $sc_version[1] === '0' ) {
				$theme_config['elementor']['widgets'] = array(
					'countdown',
					'circle-progress',
					'info-card',
					'info-card-grid',
					'testimonials-grid',
					'testimonials-carousel',
					'before-after',
					'gallery-grid',
					'gallery-masonry',
					'gallery-justified',
					'gallery-bricks',
					'gallery-adjusted',
					'blog-simple',
				);
			}

			if ( Ashade_Core::get_mod( 'ashade-cpt-albums-state' ) ) {
				$theme_config[ 'cpt' ][ 'albums' ] = array(
					'cpt_name' => 'ashade-albums',
					'cpt_config' => array(
						'label' => Ashade_Core::get_mod( 'ashade-cpt-albums-label' ),
						'public' => true,
						'show_ui' => true,
						'show_ui_nav_menus' => true,
						'rewrite' => array(
							'slug' => Ashade_Core::get_mod( 'ashade-cpt-albums-slug' ),
							'with_front' => false
						),
						'hierarchical' => true,
						'menu_position' => 3,
						'supports' => array(
							'title',
							'thumbnail',
							'comments'
						)
					),
					'cpt_tax' => array(
						'tax_name' => Ashade_Core::get_mod( 'ashade-cpt-albums-category' ),
						'tax_post_name' => 'ashade-albums',
						'tax_array' => array(
							'hierarchical' => true,
							'label' => esc_attr__( 'Category', 'ashade' ),
							'singular_name' => esc_attr__( 'Category', 'ashade' ),
						)
					),
				);
			}
			if ( Ashade_Core::get_mod( 'ashade-cpt-clients-state' ) ) {
				$theme_config[ 'cpt' ][ 'clients' ] = array(
					'cpt_name' => 'ashade-clients',
					'cpt_config' => array(
						'label' => Ashade_Core::get_mod( 'ashade-cpt-clients-label' ),
						'public' => true,
						'show_ui' => true,
						'show_ui_nav_menus' => true,
						'rewrite' => array(
							'slug' => Ashade_Core::get_mod( 'ashade-cpt-clients-slug' ),
							'with_front' => false
						),
						'hierarchical' => true,
						'menu_position' => 4,
						'supports' => array(
							'title',
							'thumbnail',
							'comments',
						)
					),
				);
			}
			
			Shadow_Core::instance()->init( $theme_config );
		}
	}
}
add_action( 'after_setup_theme', 'ashade_setup' );

# Ashade Sidebar Init
if ( ! function_exists( 'ashade_register_sidebars' ) ) {
	function ashade_register_sidebars() {
		register_sidebar( array(
			'id'            => 'ashade-sidebar',
			'name'          => esc_attr__( 'Sidebar', 'ashade' ),
			'description'   => esc_attr__( 'Default sidebar widgets.', 'ashade' ),
			'before_widget' => '<div id="%1$s" class="ashade-widget %2$s">',
			'after_widget'  => '</div><!-- .ashade-widget -->',
			'before_title'  => '<h5 class="ashade-widget-title">',
			'after_title'   => '</h5>',
		) );
		register_sidebar( array(
			'id'            => 'ashade-aside-bar',
			'name'          => esc_attr__( 'Aside Bar', 'ashade' ),
			'description'   => esc_attr__( 'Widgets for toggled aside panel.', 'ashade' ),
			'before_widget' => '<div id="%1$s" class="ashade-widget %2$s">',
			'after_widget'  => '</div><!-- .ashade-widget -->',
			'before_title'  => '<h5 class="ashade-widget-title">',
			'after_title'   => '</h5>',
		) );
		if ( class_exists( 'WooCommerce' ) ) {
			register_sidebar( array(
				'id'            => 'ashade-wc-sidebar',
				'name'          => esc_attr__( 'WooCommerce Sidebar', 'ashade' ),
				'description'   => esc_attr__( 'Widgets for WooCommerce product listing.', 'ashade' ),
				'before_widget' => '<div id="%1$s" class="ashade-widget %2$s">',
				'after_widget'  => '</div><!-- .ashade-widget -->',
				'before_title'  => '<h5 class="ashade-widget-title">',
				'after_title'   => '</h5>',
			) );
		}
	}
}
add_action( 'widgets_init', 'ashade_register_sidebars' );

# Ashade Scripts and Styles
if ( ! function_exists( 'ashade_scripts' ) ) {
	function ashade_scripts() {
		# Register Styles
		wp_register_style( 'justified-gallery', get_template_directory_uri() . '/assets/css/lib/justifiedGallery.min.css' );

		# Enqueue Styles
        wp_enqueue_style( 'dashicons' );
		wp_enqueue_style( 'ashade-style', get_stylesheet_uri() );
		wp_enqueue_style( 'ashade-responsive', get_template_directory_uri() . '/assets/css/responsive.css' );
		wp_enqueue_style( 'photoswipe', get_template_directory_uri() . '/assets/css/lib/photoswipe.css' );
		wp_enqueue_style( 'photoswipe-skin', get_template_directory_uri() . '/assets/css/lib/default-skin/default-skin.css' );

		# Add WooCommerce Style, if activated
		if ( class_exists( 'WooCommerce' ) ) {
			wp_enqueue_style('ashade-woocommerce', get_template_directory_uri() . '/assets/css/ashade-woo.css');
			wp_enqueue_style( 'ashade-woocommerce-responsive', get_template_directory_uri() . '/assets/css/responsive-woo.css' );
		}
		
		# Fonts
		$ashade_fonts = '';
		$ashade_fonts_array = array();
		$ashade_fonts_options = array(
			'ashade-logo',
			'ashade-menu',
			'ashade-content',
			'ashade-titles',
			'ashade-overheads',
			'ashade-headings'
		);
		foreach ( $ashade_fonts_options as $id ) {
			if ( isset( $ashade_fonts_array[ Ashade_Core::get_mod( $id . '-ff' ) ] ) ) {
				$pos = strpos( $ashade_fonts_array[ Ashade_Core::get_mod( $id . '-ff' ) ], Ashade_Core::get_mod( $id . '-fw' ) );
				if ( $pos === false ) {
					$ashade_fonts_array[ Ashade_Core::get_mod( $id . '-ff' ) ] .= ',' . Ashade_Core::get_mod( $id . '-fw' );
				}
			} else {
				$ashade_fonts_array[ Ashade_Core::get_mod( $id . '-ff' ) ] = ':' . Ashade_Core::get_mod( $id . '-fw' );
			}
		}
		foreach ( $ashade_fonts_array as $name => $attr ) {
			$ashade_fonts .= esc_attr( $name ) . esc_attr( $attr ) . '|';
		}
		
		$ashade_fonts_url = add_query_arg( 'family', urlencode( substr( $ashade_fonts, 0, -1 ) ), '//fonts.googleapis.com/css' );
		wp_enqueue_style( 'ashade-google-fonts', esc_url( $ashade_fonts_url ), null, null );

		# Customizer Styles
		if ( class_exists( 'Ashade_CSS' ) ) {
			$ashade_custom_css = Ashade_CSS::get_custom_css();
			wp_add_inline_style( 'ashade-style', $ashade_custom_css );
		}

		# Scripts
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
        
        # Enqueue Lib Scripts
		wp_enqueue_script( 'photoswipe', get_template_directory_uri() . '/assets/js/lib/photoswipe.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'photoswipe-ui', get_template_directory_uri() . '/assets/js/lib/photoswipe-ui-default.min.js', array( 'jquery', 'photoswipe' ), false, true );
		wp_enqueue_script( 'gsap', get_template_directory_uri() . '/assets/js/lib/gsap.min.js', array( 'jquery', 'wp-mediaelement' ), false, true );
		wp_register_script( 'masonry', get_template_directory_uri() . '/assets/js/lib/masonry.min.js', array( 'jquery', 'imagesloaded' ) );
		wp_register_script( 'jquery-justified-gallery', get_template_directory_uri() . '/assets/js/lib/jquery.justifiedGallery.min.js', array( 'jquery', 'imagesloaded' ) );
		
		# Register Lib Scripts
		wp_register_script( 'ashade-ribbon', get_template_directory_uri() . '/assets/js/ashade-ribbon.js', array( 'jquery' ), false, true );
		wp_register_script( 'ashade-slider', get_template_directory_uri() . '/assets/js/ashade-slider.js', array( 'jquery' ), false, true );
        
        # Theme Scripts
		wp_enqueue_script( 'ashade-core-js', get_template_directory_uri() . '/assets/js/core.js', array( 'jquery' ), false, true );
		global $post;
        wp_localize_script( 'ashade-core-js', 'ashade_urls', array(
			'template' => esc_url( get_template_directory_uri() ),
			'ajax' => esc_url( admin_url( 'admin-ajax.php' ) ),
			'post_id' => (is_object( $post ) ? $post->ID : '0'),
			'ajax_nonce' => wp_create_nonce('ashade_security_code'),
		) );
		# Add WooCommerce Scripts, if activated
		if ( class_exists( 'WooCommerce' ) ) {
			wp_enqueue_script('ashade-woocommerce-js', get_template_directory_uri() . '/assets/js/ashade-woo.js', array( 'jquery' ), false, true );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'ashade_scripts' );

# Ashade Block Editor JS
if ( ! function_exists( 'ashade_block_editor_enqueue' ) ) {
	function ashade_block_editor_enqueue() {
		wp_enqueue_script( 'ashade-block-editor-js', get_template_directory_uri() . '/assets/js/admin/block-editor.js', array( 'jquery', 'wp-data', 'wp-blocks', 'wp-element', 'wp-editor' ), wp_rand(), true );
	}
}
add_action( 'enqueue_block_editor_assets', 'ashade_block_editor_enqueue' );

# Ashade Admin Scripts and Styles
if ( ! function_exists( 'ashade_scripts_admin' ) ) {
	function ashade_scripts_admin() {
		// Styles
		if ( class_exists('RWMB_Loader') ) {
			wp_enqueue_style( 'ashade-rwmb', get_template_directory_uri() . '/assets/css/admin/rwmb.css' );
		}
		wp_enqueue_style( 'ashade-admin-css', get_template_directory_uri() . '/assets/css/admin/admin.css' );
		
		// Scripts
		if ( class_exists('RWMB_Loader') ) {
			wp_enqueue_script( 'ashade-rwmb-tabs', get_template_directory_uri() . '/assets/js/admin/rwmb-tabs.js', array( 'jquery' ), false, true );
		}
		wp_enqueue_script( 'ashade-admin-js', get_template_directory_uri() . '/assets/js/admin/admin.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-sortable' ), false, true );
	}
}
add_action( 'admin_enqueue_scripts', 'ashade_scripts_admin' );

# Ashade Admin Body
if ( ! function_exists( 'ashade_admin_body' ) ) {
	function ashade_admin_body( $classes ) {
		$template_class = str_ireplace( 'template-', '', basename( get_page_template_slug(get_the_ID()), '.php' ) );
		$post_format = get_post_format( get_the_ID() );
		$post_format_class = '';

		if ( ! empty($post_format)) {
			$post_format_class = $post_format . '-pf';
		}
		if ( Ashade_Core::get_mod( 'ashade-tgmpa-nag', true ) == false ) {
			$tgm_class = 'ashade-hide-tgmpa-nag';
		} else {
			$tgm_class = '';
		}
		return $classes . $template_class . $post_format_class . ' theme_name_' . strtolower( wp_get_theme() ) . ' ' . $tgm_class;
	}
}
add_filter( 'admin_body_class', 'ashade_admin_body' );

# Ashade Body Class
if ( ! function_exists( 'ashade_body' ) ) {
	function ashade_body( $classes ) {
		return array_merge( $classes, Ashade_Core::get_body_class() );
	}
	add_filter( 'body_class', 'ashade_body' );
}

# Activate Theme Settings in Appearance Menu
if ( ! function_exists( 'ashade_activate_menu' ) ) {
    function ashade_activate_menu() {
        // $page_title, $menu_title, $capability, $menu_slug, $function
        add_theme_page( 'Ashade Photography', 'Ashade Photography', 'administrator', 'ashade_settings', 'ashade_theme_settings' );
    }
}
add_action( 'admin_menu', 'ashade_activate_menu' );

if ( ! function_exists( 'ashade_theme_settings' ) ) {
    function ashade_theme_settings() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( esc_attr__( 'Your permissions level is not enough to enter this page.', 'ashade' ) );
        }
        
        Ashade_Core::get_settings_page();
    }
}

# Excerpt More Text
function ashade_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'ashade_excerpt_more' );

# Remove 'Protected:' text
add_filter( 'protected_title_format', 'ashade_remove_protected_text' );
function ashade_remove_protected_text() {
	return '%s';
}

# Debug Functions
if ( ! function_exists( 'print_pre' ) )
{
	function print_pre ( $array ) 
	{
		echo '<pre>';
		print_r( $array );
		echo '</pre>';
	}
}

# Admin Body Class
add_filter( 'admin_body_class', 'ashade_admin_body_class' );
function ashade_admin_body_class( $classes ) {
	if ( 'page' == get_post_type() ) {
		$template_slug = get_page_template_slug();
		if ( ! empty ( $template_slug ) ) {
			$page_template_class = 'template--' . strstr( $template_slug, '.', true );
			$classes .= ' ' . $page_template_class;
		}
	}
	if ( 'ashade-albums' == get_post_type() ) {
		$classes .= ' is-' . esc_attr( Ashade_Core::get_prefer( 'ashade-albums-type' ) );
	}
    return $classes;
}

# Demo Import Settings
if ( class_exists( 'OCDI_Plugin' ) ) {
	add_filter( 'pt-ocdi/import_files', 'ashade_dummy_files' );
	function ashade_dummy_files() {
		return array(
			array(
				'import_file_name'           => esc_attr__( 'Ashade Dummy Content', 'ashade' ),
				'categories'                 => array( 'Ashade Content' ),
				'import_file_url'            => 'https://docs.shadow-themes.com/dummy/ashade2/content.xml',
				'import_widget_file_url'     => 'https://docs.shadow-themes.com/dummy/ashade2/widgets.wie',
				'import_customizer_file_url' => 'https://docs.shadow-themes.com/dummy/ashade2/customizer.dat',
				'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ) . 'screenshot.jpg',
				'import_notice'              => esc_attr__( 'Please, be sure that all required plugins are installed and activated before importing demo content.', 'ashade' ),
				'preview_url'                => 'https://demo.shadow-themes.com/wp/ashade/',
			),
		);
	}

	add_action( 'pt-ocdi/after_import', 'ashade_after_import_setup' );
	function ashade_after_import_setup() {
		// Assign menus to their locations.
		$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
	
		set_theme_mod( 'nav_menu_locations', array(
				'main' => $main_menu->term_id, // replace 'main-menu' here with the menu location identifier from register_nav_menu() function
			)
		);
	
		// Assign front page and posts page (blog page).
		$front_page_id = get_page_by_title( 'Home with Video' );
		$blog_page_id  = get_page_by_title( 'Stories' );
		
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
		update_option( 'page_for_posts', $blog_page_id->ID );
	}

	add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
}

# Add a pingback url auto-discovery header for single posts, pages, or attachments.
function ashade_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'ashade_pingback_header' );

# Templates, to disable Editor
if ( ! function_exists( 'ashade_de_templates' ) ) {
	function ashade_de_templates( $post_id ) {
		$templates = array(
			'page-home.php',
			'page-albums.php',
			'page-maintenance.php',
		);

		return in_array( get_page_template_slug( $post_id ), $templates );
	}
}
# Disable Block Editor
if ( ! function_exists( 'ashade_remove_block_editor' ) ) {
	add_filter( 'gutenberg_can_edit_post_type', 'ashade_remove_block_editor', 10, 2 );
	add_filter( 'use_block_editor_for_post_type', 'ashade_remove_block_editor', 10, 2 );
	function ashade_remove_block_editor( $editor, $pt ) {
		if ( ! ( is_admin() && ! empty( $_GET[ 'post' ] ) ) )
			return $editor;

		if ( ashade_de_templates( $_GET[ 'post' ] ) )
			$editor = 0;

		return $editor;
	}
}
# Disable Classic Editor
if ( ! function_exists( 'ashade_remove_classic_editor' ) ) {
	add_action( 'admin_head', 'ashade_remove_classic_editor' );
	function ashade_remove_classic_editor() {
		$current = get_current_screen();
		if ( 'page' !== $current->id || ! isset( $_GET[ 'post' ] ) )
			return;

		if ( ashade_de_templates( $_GET[ 'post' ] ) ) {
			remove_post_type_support( 'page', 'editor' );
		}
	}
}

# Theme Prefix
if ( ! function_exists( 'st_get_theme_prefix' ) ) {
	function st_get_theme_prefix() {
		return 'ashade';
	}
}

# Image Placeholder
if ( ! function_exists( 'ashade_get_image_ph' ) ) {
	function ashade_get_image_ph( $w = 1, $h = 1 ) {
		return rawurlencode(str_replace(["\r", "\n"], ' ', '<svg xmlns="http://www.w3.org/2000/svg" width="'. $w .'" height="'. $h .'" viewBox="0 0 '. $w .' '. $h .'"></svg>'));
	}
}