<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;

DEFINE ( 'DEFAULT_LOGO_URL', get_template_directory_uri() . '/assets/img/logo.png' );
DEFINE ( 'DEFAULT_NULL_IMAGE', get_template_directory_uri() . '/assets/img/null.png' );

# Core Theme Class
if ( ! class_exists( 'Ashade_Core' ) ) :
	final class Ashade_Core {
		# Properties
		private static $customizer;
		private static $_instance = null;

		# Methods
		public static function instance() 
		{
			if ( is_null( self::$_instance ) )
				self::$_instance = new self();

			return self::$_instance;
		}

		public function init() {
			# Configure Web Fonts
			//$web_fonts = json_decode(file_get_contents(get_template_directory_uri() . '/assets/fonts/webfonts_names.json'));
			ob_start();
			include get_template_directory() . '/assets/fonts/webfonts_names.json';
			$font_file = ob_get_contents();
			$web_fonts = json_decode($font_file);
			ob_end_clean();

			$web_fonts_choices = array();
			$web_fonts_weight = array(
				'100' => '100',
				'200' => '200',
				'300' => '300',
				'400' => '400',
				'500' => '500',
				'600' => '600',
				'700' => '700',
				'800' => '800',
				'900' => '900',
				'normal' => 'Normal',
				'bold' => 'Bold',
			);
			foreach ($web_fonts as $font) {
				$web_fonts_choices[$font] = $font;
			}

			# Border Styles
			$border_style = array(
				'none' => 'None',
				'solid' => 'Solid',
				'double' => 'Double',
				'dotted' => 'Dotted',
				'dashed' => 'Dashed',
				'groove' => 'Groove'
			);
			
			# Font Usage
			$web_fonts_usage = array(
				'ashade-menu' => 'Menu Font',
				'ashade-content' => 'Content Font',
				'ashade-overheads' => 'Over Headings Font',
				'ashade-headings' => 'Headings'
			);
			
			self::$customizer = array (
				# SECTION: Logo
				'ashade-logo-section' => array (
					'type' => 'section',
					'title' => esc_attr__( 'Site Logo', 'ashade' ),
					'priority' => 20,
					'single' => true
				),
					# Logo Type
					'ashade-logo-type' => array (
						'type' => 'choose',
						'default' => 'image',
						'label' => esc_attr__( 'Logo Image', 'ashade' ),
						'custom_class' => 'shadow-same-switch3',
						'options' => array(
							'image' => esc_attr__( 'Image', 'ashade' ),
							'text' => esc_attr__( 'Text', 'ashade' ),
							'none' => esc_attr__( 'Hide', 'ashade' ),
						)
					),					
					# --- Divider ---
					'divider-logo-type' => array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
						'condition' => array(
							'ashade-logo-type' => 'image, text'
						)
					),
					# Logo Image
					'ashade-logo-url' => array (
						'type' => 'image',
						'default' => DEFAULT_LOGO_URL,
						'label' => esc_attr__( 'Logo Image', 'ashade' ),
						'condition' => array(
							'ashade-logo-type' => 'image'
						)
					),
					# Logo Retina
					'ashade-retina-logo' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Retina Logo', 'ashade' ),
						'description' => esc_attr__( 'Retina Ready Logo Image should be double size. Example: 220x80px logo will displays like 110x40px.', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
						'condition' => array(
							'ashade-logo-type' => 'image'
						)
					),
					# Logo Text Label
					'ashade-logo-text' => array (
						'type' => 'text',
						'default' => 'Your Logo',
						'label' => esc_attr__( 'Logo Text', 'ashade' ),
						'condition' => array(
							'ashade-logo-type' => 'text'
						)
					),
					# --- Divider ---
					'divider-logo-typo' => array (
						'type' => 'divider',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
						'condition' => array(
							'ashade-logo-type' => 'text'
						)
					),
					# Logo Font Family
					'ashade-logo-ff' => array(
						'type' => 'select',
						'default' => 'Roboto Condensed',
						'label' => esc_attr__( 'Font Family', 'ashade' ),
						'choices' => $web_fonts_choices,
						'condition' => array(
							'ashade-logo-type' => 'text'
						)
					),
					# Logo Font Weight
					'ashade-logo-fw' => array(
						'type' => 'select',
						'default' => '400',
						'description' => esc_attr__( 'Notice: Before choosing, make sure that the current font supports this weight.', 'ashade' ),
						'label' => esc_attr__( 'Font Weight', 'ashade' ),
						'choices' => $web_fonts_weight,
						'condition' => array(
							'ashade-logo-type' => 'text'
						)
					),
					# Logo Font Size
					'ashade-logo-fs' => array(
						'type' => 'number',
						'default' => '60',
						'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
						'options' => array(
							'style' => 'slider',
						),
						'condition' => array(
							'ashade-logo-type' => 'text'
						)
					),
					# Logo Line Height
					'ashade-logo-lh' => array(
						'type' => 'number',
						'default' => '65',
						'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
						'options' => array(
							'style' => 'slider',
						),
						'condition' => array(
							'ashade-logo-type' => 'text'
						)
					),
					# Logo Letter Spacing
					'ashade-logo-ls' => array(
						'type' => 'number',
						'default' => '0',
						'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
						'options' => array(
							'style' => 'slider',
							'min' => -100,
							'max' => 100,
							'step' => '1'
						),
						'condition' => array(
							'ashade-logo-type' => 'text'
						)
					),
					# Logo Uppercase
					'ashade-logo-u' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Uppercase', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
						'condition' => array(
							'ashade-logo-type' => 'text'
						)
					),
					# Logo Italic
					'ashade-logo-i' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Italic', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
						'condition' => array(
							'ashade-logo-type' => 'text'
						)
					),
					# Logo Color
					'ashade-logo-color' => array (
						'type' => 'color',
						'default' => '#ffffff',
						'label' => esc_attr__( 'Logo Color', 'ashade' ),
						'condition' => array (
							'ashade-logo-type' => 'text'
						)
					),
					# --- Divider ---
					'divider-logo-padding' => array (
						'type' => 'divider',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
						'condition' => array(
							'ashade-logo-type' => 'image, text'
						)
					),
					# Logo Padding
					'ashade-logo-padding' => array (
						'type' => 'dimension',
						'default' => '50/d/50/d',
						'label' => esc_attr__( 'Logo Padding', 'ashade' ),
						'disable' => array(
							'left' => 'yes',
							'right' => 'yes',
						),
						'condition' => array(
							'ashade-logo-type' => 'image, text'
						)
					),

				# PANEL: General
				'ashade-general-panel' => array (
					'type' => 'panel',
					'title' => esc_attr__( 'General Settings', 'ashade' ),
					'priority' => 25,
				),
					# SECTION: Admin
					'ashade-dashboard-section' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Dashboard Settings', 'ashade' ),
					),
						# TGMPA Nag
						'ashade-tgmpa-nag' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( "Theme' Plugins Notifications", 'ashade' ),
							'description' => esc_attr__( 'Turn off to hide recommended and required plugins notification at the top of the dashboard.', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Disable Block Editor for Widgets
						'ashade-gutenberg-widgets' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_html__( 'Disable Block editor for Widgets', 'ashade' ),
							'description' => esc_html__( 'Turning off this option, you will be able to edit sidebars with the Gutenberg Block editor, but it can break the visual part.', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),

					# SECTION: Preloader
					'ashade-preloader-section' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Preloading Settings', 'ashade' ),
					),
						# Lazy Loading
						'ashade-lazy-loader' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Lazy Image Loading', 'ashade' ),
							'description' => esc_attr__( 'With enabling this option your images will load only when they are into view. It helps to improve website loading speed.', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# --- Divider ---
						'divider-lazy-loader' => array (
							'type' => 'divider',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Page Loading Effect
						'ashade-loading-animation' => array (
							'type' => 'choose',
							'default' => 'full',
							'label' => esc_attr__( 'Page Loading Animations', 'ashade' ),
							'custom_class' => 'shadow-same-switch3',
							'options' => array(
								'full' => esc_attr__( 'Full', 'ashade' ),
								'fade' => esc_attr__( 'Fade', 'ashade' ),
								'none' => esc_attr__( 'None', 'ashade' ),
							)
						),	
						# --- Divider ---
						'divider-preloading' => array (
							'type' => 'divider',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Page Unloading Effect
						'ashade-unloading-animation' => array (
							'type' => 'choose',
							'default' => 'full',
							'label' => esc_attr__( 'Page Leaving Animations', 'ashade' ),
							'custom_class' => 'shadow-same-switch3',
							'options' => array(
								'full' => esc_attr__( 'Full', 'ashade' ),
								'fade' => esc_attr__( 'Fade', 'ashade' ),
								'none' => esc_attr__( 'None', 'ashade' ),
							)
						),	

					# SECTION: Content Features
					'ashade-content-features' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Content Features', 'ashade' ),
					),
						# Title and Back2Top Layout
						'ashade-title-layout' => array (
							'type' => 'choose',
							'default' => 'horizontal',
							'label' => esc_attr__( 'Title and Back to Top Layout', 'ashade' ),
							'custom_class' => 'shadow-same-switch2',
							'options' => array(
								'vertical' => esc_attr__( 'Vertical', 'ashade' ),
								'horizontal' => esc_attr__( 'Horizontal', 'ashade' ),
							)
						),
						# Magic Cursor
						'ashade-magic-cursor' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Magic Cursor', 'ashade' ),
							'description' => esc_attr__( 'Enable interactive mouse cursor, that changes its appearance depending on the current event', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Smooth Scroll
						'ashade-smooth-scroll' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Smooth Scroll', 'ashade' ),
							'description' => esc_attr__( 'Enable smooth content scrolling feature', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Smooth Scroll TouchDevices
						'ashade-native-touch-scroll' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Native Smooth Scroll for Touch', 'ashade' ),
							'description' => esc_attr__( 'Touch devices already have their own smooth scroll, and it is recommended to use this option to disable the additional smooth scroll for performance.', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array(
								'ashade-smooth-scroll' => true,
							),
						),
						# Back to Top
						'ashade-back2top' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Back to Top', 'ashade' ),
							'description' => esc_attr__( 'Enable "Back to Top" button', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Back to Top Mobile
						'ashade-back2top-mobile' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Back to Top on Mobile', 'ashade' ),
							'description' => esc_attr__( 'Enable "Back to Top" button for mobile layout.', 'ashade' ),
							'condition' => array(
								'ashade-back2top' => true,
								'ashade-title-layout' => 'vertical'
							),
							'custom_class' => 'shadow-title-switcher'
						),
						# Body Spotlight
						'ashade-spotlight' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Body Spotlight', 'ashade' ),
							'description' => esc_attr__( 'Add spotlight effect to body background', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Logo Color
						'ashade-spotlight-color' => array (
							'type' => 'color',
							'default' => '#28282E',
							'label' => esc_attr__( 'Spotlight Color', 'ashade' ),
							'condition' => array (
								'ashade-spotlight' => true
							)
						),

					# SECTION: Protection
					'ashade-protection-section' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Content Protection', 'ashade' ),
					),
						# Right Click Protection
						'ashade-protection-rclick' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Right Click Protection', 'ashade' ),
							'description' => esc_attr__( 'Disable website context menu.', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Right Click Protection Message
						'ashade-protection-rclick-message-state' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Show Message on Right Click', 'ashade' ),
							'description' => esc_attr__( 'Show an alert box with a message, when the user tries to make a right click action.', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array(
								'ashade-protection-rclick' => true
							)
						),
						# Right Click Protection
						'ashade-protection-rclick-message' => array (
							'type' => 'textarea',
							'default' => '',
							'label' => esc_attr__( 'Write your message', 'ashade' ),
							'condition' => array(
								'ashade-protection-rclick' => true,
								'ashade-protection-rclick-message-state' => true
							)
						),
						# --- Divider ---
						'divider-protection' => array (
							'type' => 'divider',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Image Drag Protection
						'ashade-protection-drag' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Image Dragging Protection', 'ashade' ),
							'description' => esc_attr__( 'Protecting your images from stealing, with dragging into the browser address bar.', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),

					# SECTION: Colors
					'ashade-lightbox-section' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Lightbox Settings', 'ashade' ),
					),
						# Lightbox Zoom Enabling
						'ashade-lightbox-zoom' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Enable Image Zoom', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Lightbox Overlay Click
						'ashade-overlay-closes' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Click Overlay to Close', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),

					# SECTION: Colors
					'ashade-colors-section' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Color Scheme', 'ashade' ),
					),
						# Scheme Color 01
						'ashade-color-scheme01' => array (
							'type' => 'color',
							'default' => '#000000',
							'label' => esc_attr__( 'Scheme Color 01', 'ashade' ),
							'description' => esc_attr__( 'Used for Body, Overlays, Input Background', 'ashade' ),
						),
						# Scheme Color 02
						'ashade-color-scheme02' => array (
							'type' => 'color',
							'default' => '#17171B',
							'label' => esc_attr__( 'Scheme Color 02', 'ashade' ),
							'description' => esc_attr__( 'Used for Blocks Background, Aside Background', 'ashade' ),
						),
						# Scheme Color 03
						'ashade-color-scheme03' => array (
							'type' => 'color',
							'default' => '#808080',
							'label' => esc_attr__( 'Scheme Color 03', 'ashade' ),
							'description' => esc_attr__( 'Used as Text Color in content and Inputs', 'ashade' ),
						),
						# Scheme Color 04
						'ashade-color-scheme04' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Scheme Color 04', 'ashade' ),
							'description' => esc_attr__( 'Used for Headings, Titles, Links, Main Menu, Some Hover Effects and bright Accents', 'ashade' ),
						),
						# Scheme Color 05
						'ashade-color-scheme05' => array (
							'type' => 'color',
							'default' => '#5C5C60',
							'label' => esc_attr__( 'Scheme Color 05', 'ashade' ),
							'description' => esc_attr__( 'Used for Overheads, Contact Icons Accent, etc', 'ashade' ),
						),
						# Scheme Color 06
						'ashade-color-scheme06' => array (
							'type' => 'color',
							'default' => '#313133',
							'label' => esc_attr__( 'Scheme Color 06', 'ashade' ),
							'description' => esc_attr__( 'Used for Input and Buttons Borders, Table Borders, etc', 'ashade' ),
						),

					# SECTION: Custom Post Type
					'ashade-cpt-section' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Custom Post Types', 'ashade' ),
						'description' => ( class_exists( 'Shadow_Core' ) ? null : esc_attr__( 'Note: To use that features you need to install and activate Shadow Core Plugin.', 'ashade' )),
					),
						# Albums Post Type Enable
						'ashade-cpt-albums-state' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Enable Albums Post Type', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Albums Post Type Label
						'ashade-cpt-albums-label' => array (
							'type' => 'text',
							'default' => 'Albums',
							'label' => esc_attr__( 'Albums Post Type Label', 'ashade' ),
							'condition' => array(
								'ashade-cpt-albums-state' => true,
							)
						),
						# Albums Post Type Slug
						'ashade-cpt-albums-slug' => array (
							'type' => 'text',
							'default' => 'albums',
							'label' => esc_attr__( 'Albums Post Type Slug', 'ashade' ),
							'description' => esc_attr__( 'Notice: use only lowercase', 'ashade' ),
							'condition' => array(
								'ashade-cpt-albums-state' => true,
							)
						),
						# Albums Category Slug
						'ashade-cpt-albums-category' => array (
							'type' => 'text',
							'default' => 'albums-category',
							'label' => esc_attr__( 'Albums Category Slug', 'ashade' ),
							'description' => esc_attr__( 'Notice: use only lowercase', 'ashade' ),
							'condition' => array(
								'ashade-cpt-albums-state' => true,
							)
						),
						# --- Divider ---
						'divider-cpt' => array (
							'type' => 'divider',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Clients Post Type Enable
						'ashade-cpt-clients-state' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Enable Clients Post Type', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Clients Post Type Label
						'ashade-cpt-clients-label' => array (
							'type' => 'text',
							'default' => 'Clients',
							'label' => esc_attr__( 'Clients Post Type Label', 'ashade' ),
							'condition' => array(
								'ashade-cpt-clients-state' => true,
							)
						),
						# Clients Post Type Slug
						'ashade-cpt-clients-slug' => array (
							'type' => 'text',
							'default' => 'clients',
							'label' => esc_attr__( 'Clients Post Type Slug', 'ashade' ),
							'description' => esc_attr__( 'Notice: use only lowercase', 'ashade' ),
							'condition' => array(
								'ashade-cpt-clients-state' => true,
							)
						),

				# PANEL: Typography
				'ashade-typography-panel' => array (
					'type' => 'panel',
					'title' => esc_attr__( 'Typography', 'ashade' ),
					'priority' => 30,
				),
					# SECTION: Menu Typography
					'ashade-typography-menu' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Main Menu', 'ashade' ),
					),
						# Menu Font Family
						'ashade-menu-ff' => array(
							'type' => 'select',
							'default' => 'Montserrat',
							'label' => esc_attr__( 'Font Family', 'ashade' ),
							'choices' => $web_fonts_choices,
						),
						# Menu Font Weight
						'ashade-menu-fw' => array(
							'type' => 'select',
							'default' => '500',
							'description' => esc_attr__( 'Notice: Before choosing, make sure that the current font supports this weight.', 'ashade' ),
							'label' => esc_attr__( 'Font Weight', 'ashade' ),
							'choices' => $web_fonts_weight
						),
						# Menu Font Size
						'ashade-menu-fs' => array(
							'type' => 'number',
							'default' => '12',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						# Menu Line Height
						'ashade-menu-lh' => array(
							'type' => 'number',
							'default' => '29',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						# Menu Letter Spacing
						'ashade-menu-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							)
						),
						# Menu Uppercase
						'ashade-menu-u' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Uppercase', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Menu Italic
						'ashade-menu-i' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Italic', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# --- Divider ---
						'divider-menu-colors' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Menu Customize Colors
						'ashade-menu-custom-colors' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Customize Colors?', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Default Color
						'ashade-menu-color-d' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Default Color', 'ashade' ),
							'condition' => array (
								'ashade-menu-custom-colors' => true
							)
						),
						# Default Opacity
						'ashade-menu-color-do' => array(
							'type' => 'number',
							'default' => '50',
							'label' => esc_attr__( 'Default Opacity, %', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 100,
							),
							'condition' => array (
								'ashade-menu-custom-colors' => true
							)
						),
						# Hover Color
						'ashade-menu-color-h' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Hover Color', 'ashade' ),
							'condition' => array (
								'ashade-menu-custom-colors' => true
							)
						),
						# Hover Opacity
						'ashade-menu-color-ho' => array(
							'type' => 'number',
							'default' => '100',
							'label' => esc_attr__( 'Hover Opacity, %', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 100,
							),
							'condition' => array (
								'ashade-menu-custom-colors' => true
							)
						),
						# Active Color
						'ashade-menu-color-a' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Active Color', 'ashade' ),
							'condition' => array (
								'ashade-menu-custom-colors' => true
							)
						),
						# Active Opacity
						'ashade-menu-color-ao' => array(
							'type' => 'number',
							'default' => '100',
							'label' => esc_attr__( 'Active Opacity, %', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 100,
							),
							'condition' => array (
								'ashade-menu-custom-colors' => true
							)
						),

					# SECTION: Content Typography
					'ashade-typography-content' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Content', 'ashade' ),
					),
						# Content Font Family
						'ashade-content-ff' => array(
							'type' => 'select',
							'default' => 'Montserrat',
							'label' => esc_attr__( 'Font Family', 'ashade' ),
							'choices' => $web_fonts_choices,
						),
						# Content Font Weight
						'ashade-content-fw' => array(
							'type' => 'select',
							'default' => '500',
							'description' => esc_attr__( 'Notice: Before choosing, make sure that the current font supports this weight.', 'ashade' ),
							'label' => esc_attr__( 'Font Weight', 'ashade' ),
							'choices' => $web_fonts_weight
						),
						# Content Font Size
						'ashade-content-fs' => array(
							'type' => 'number',
							'default' => '16',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						# Content Line Height
						'ashade-content-lh' => array(
							'type' => 'number',
							'default' => '28',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						# Content Letter Spacing
						'ashade-content-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							)
						),
						# Content Uppercase
						'ashade-content-u' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Uppercase', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Content Italic
						'ashade-content-i' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Italic', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Paragraph Bottom Spacing
						'ashade-content-spacing' => array(
							'type' => 'number',
							'default' => '28',
							'label' => esc_attr__( 'Paragraph Bottom Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 100,
							)
						),
						# --- Divider ---
						'divider-content-colors' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Content Customize Colors
						'ashade-content-custom-colors' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Customize Colors?', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Text Color
						'ashade-content-color-text' => array (
							'type' => 'color',
							'default' => '#808080',
							'label' => esc_attr__( 'Text Color', 'ashade' ),
							'condition' => array (
								'ashade-content-custom-colors' => true
							)
						),
						# Link Color
						'ashade-content-color-link' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Link Color', 'ashade' ),
							'condition' => array (
								'ashade-content-custom-colors' => true
							)
						),
						# Link Hover Color
						'ashade-content-color-hover' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Link Hover Color', 'ashade' ),
							'condition' => array (
								'ashade-content-custom-colors' => true
							)
						),

					# SECTION: Titles Typography
					'ashade-typography-titles' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Titles', 'ashade' ),
						'description' => esc_attr__( 'Font styles for page title, albums titles, etc.', 'ashade' ),
					),
						# Titles Font Family
						'ashade-titles-ff' => array(
							'type' => 'select',
							'default' => 'Roboto Condensed',
							'label' => esc_attr__( 'Font Family', 'ashade' ),
							'choices' => $web_fonts_choices,
						),
						# Titles Font Weight
						'ashade-titles-fw' => array(
							'type' => 'select',
							'default' => '700',
							'description' => esc_attr__( 'Notice: Before choosing, make sure that the current font supports this weight.', 'ashade' ),
							'label' => esc_attr__( 'Font Weight', 'ashade' ),
							'choices' => $web_fonts_weight
						),
						# Titles Uppercase
						'ashade-titles-u' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Uppercase', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Titles Italic
						'ashade-titles-i' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Italic', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						
					# SECTION: Overheads Typography
					'ashade-typography-overheads' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Over Headings', 'ashade' ),
					),
						# Overheads Font Family
						'ashade-overheads-ff' => array(
							'type' => 'select',
							'default' => 'Montserrat',
							'label' => esc_attr__( 'Font Family', 'ashade' ),
							'choices' => $web_fonts_choices,
						),
						# Overheads Font Weight
						'ashade-overheads-fw' => array(
							'type' => 'select',
							'default' => '700',
							'description' => esc_attr__( 'Notice: Before choosing, make sure that the current font supports this weight.', 'ashade' ),
							'label' => esc_attr__( 'Font Weight', 'ashade' ),
							'choices' => $web_fonts_weight
						),
						# Overheads Uppercase
						'ashade-overheads-u' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Uppercase', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Overheads Italic
						'ashade-overheads-i' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Italic', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# --- Divider ---
						'divider-overheads-colors' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Overheads Customize Colors
						'ashade-overheads-custom-colors' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Customize Colors?', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Overheads Color
						'ashade-overheads-color' => array (
							'type' => 'color',
							'default' => '#5C5C60',
							'label' => esc_attr__( 'Over Heading Color', 'ashade' ),
							'condition' => array (
								'ashade-overheads-custom-colors' => true
							)
						),
						# --- Overheads H1 ---
						'ashade-typography-overheads-h1-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding',
							'label' => esc_attr__( 'H1', 'ashade' ),
						),
						# Overheads H1 Font Size
						'ashade-overheads-h1-fs' => array(
							'type' => 'number',
							'default' => '16',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Overheads H1 Line Height
						'ashade-overheads-h1-lh' => array(
							'type' => 'number',
							'default' => '19',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Overheads H1 Letter Spacing
						'ashade-overheads-h1-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							)
						),
						#  Overheads H1 Bottom Spacing
						'ashade-overheads-h1-bs' => array(
							'type' => 'number',
							'default' => '-2',
							'label' => esc_attr__( 'Bottom Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -10,
								'max' => 30,
							)
						),
						# --- Overheads H2 ---
						'ashade-typography-overheads-h2-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding',
							'label' => esc_attr__( 'H2', 'ashade' ),
						),
						# Overheads H2 Font Size
						'ashade-overheads-h2-fs' => array(
							'type' => 'number',
							'default' => '14',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Overheads H2 Line Height
						'ashade-overheads-h2-lh' => array(
							'type' => 'number',
							'default' => '18',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Overheads H2 Letter Spacing
						'ashade-overheads-h2-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							)
						),
						#  Overheads H2 Bottom Spacing
						'ashade-overheads-h2-bs' => array(
							'type' => 'number',
							'default' => '-3',
							'label' => esc_attr__( 'Bottom Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -10,
								'max' => 30,
							)
						),
						# --- Overheads H3 ---
						'ashade-typography-overheads-h3-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding',
							'label' => esc_attr__( 'H3', 'ashade' ),
						),
						# Overheads H3 Font Size
						'ashade-overheads-h3-fs' => array(
							'type' => 'number',
							'default' => '14',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Overheads H3 Line Height
						'ashade-overheads-h3-lh' => array(
							'type' => 'number',
							'default' => '18',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Overheads H3 Letter Spacing
						'ashade-overheads-h3-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							)
						),
						#  Overheads H3 Bottom Spacing
						'ashade-overheads-h3-bs' => array(
							'type' => 'number',
							'default' => '-1',
							'label' => esc_attr__( 'Bottom Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -10,
								'max' => 30,
							)
						),
						# --- Overheads H4 ---
						'ashade-typography-overheads-h4-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding',
							'label' => esc_attr__( 'H4', 'ashade' ),
						),
						# Overheads H4 Font Size
						'ashade-overheads-h4-fs' => array(
							'type' => 'number',
							'default' => '12',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Overheads H4 Line Height
						'ashade-overheads-h4-lh' => array(
							'type' => 'number',
							'default' => '15',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Overheads H4 Letter Spacing
						'ashade-overheads-h4-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							)
						),
						#  Overheads H4 Bottom Spacing
						'ashade-overheads-h4-bs' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Bottom Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -10,
								'max' => 30,
							)
						),
						# --- Overheads H5 ---
						'ashade-typography-overheads-h5-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding',
							'label' => esc_attr__( 'H5', 'ashade' ),
						),
						# Overheads H5 Font Size
						'ashade-overheads-h5-fs' => array(
							'type' => 'number',
							'default' => '12',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Overheads H5 Line Height
						'ashade-overheads-h5-lh' => array(
							'type' => 'number',
							'default' => '15',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Overheads H5 Letter Spacing
						'ashade-overheads-h5-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							)
						),
						#  Overheads H5 Bottom Spacing
						'ashade-overheads-h5-bs' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Bottom Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -10,
								'max' => 30,
							)
						),
						# --- Overheads H6 ---
						'ashade-typography-overheads-h6-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding',
							'label' => esc_attr__( 'H6', 'ashade' ),
						),
						# Overheads H6 Font Size
						'ashade-overheads-h6-fs' => array(
							'type' => 'number',
							'default' => '10',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Overheads H6 Line Height
						'ashade-overheads-h6-lh' => array(
							'type' => 'number',
							'default' => '13',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Overheads H6 Letter Spacing
						'ashade-overheads-h6-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							)
						),
						#  Overheads H6 Bottom Spacing
						'ashade-overheads-h6-bs' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Bottom Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -10,
								'max' => 30,
							)
						),

					# SECTION: Headings Typography
					'ashade-typography-headings' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Headings', 'ashade' ),
					),
						# Headings Font Family
						'ashade-headings-ff' => array(
							'type' => 'select',
							'default' => 'Roboto',
							'label' => esc_attr__( 'Font Family', 'ashade' ),
							'choices' => $web_fonts_choices,
						),
						# Headings Font Weight
						'ashade-headings-fw' => array(
							'type' => 'select',
							'default' => '700',
							'description' => esc_attr__( 'Notice: Before choosing, make sure that the current font supports this weight.', 'ashade' ),
							'label' => esc_attr__( 'Font Weight', 'ashade' ),
							'choices' => $web_fonts_weight
						),
						# Headings Uppercase
						'ashade-headings-u' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Uppercase', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Headings Italic
						'ashade-headings-i' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Italic', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# --- Divider ---
						'divider-headings-colors' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Headings Customize Colors
						'ashade-headings-custom-colors' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Customize Colors?', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Headings Color
						'ashade-headings-color' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Heading Color', 'ashade' ),
							'condition' => array (
								'ashade-headings-custom-colors' => true
							)
						),
						# --- Headings H1 ---
						'ashade-typography-headings-h1-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding',
							'label' => esc_attr__( 'H1', 'ashade' ),
						),
						# Headings H1 Font Size
						'ashade-headings-h1-fs' => array(
							'type' => 'number',
							'default' => '60',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Headings H1 Line Height
						'ashade-headings-h1-lh' => array(
							'type' => 'number',
							'default' => '65',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Headings H1 Letter Spacing
						'ashade-headings-h1-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							)
						),
						#  Headings H1 Bottom Spacing
						'ashade-headings-h1-bs' => array(
							'type' => 'number',
							'default' => '34',
							'label' => esc_attr__( 'Bottom Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 0,
							)
						),
						# --- Headings H2 ---
						'ashade-typography-headings-h2-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding',
							'label' => esc_attr__( 'H2', 'ashade' ),
						),
						# Headings H2 Font Size
						'ashade-headings-h2-fs' => array(
							'type' => 'number',
							'default' => '50',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Headings H2 Line Height
						'ashade-headings-h2-lh' => array(
							'type' => 'number',
							'default' => '55',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Headings H2 Letter Spacing
						'ashade-headings-h2-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							)
						),
						#  Headings H2 Bottom Spacing
						'ashade-headings-h2-bs' => array(
							'type' => 'number',
							'default' => '28',
							'label' => esc_attr__( 'Bottom Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 0,
							)
						),
						# --- Headings H3 ---
						'ashade-typography-headings-h3-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding',
							'label' => esc_attr__( 'H3', 'ashade' ),
						),
						# Headings H3 Font Size
						'ashade-headings-h3-fs' => array(
							'type' => 'number',
							'default' => '40',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Headings H3 Line Height
						'ashade-headings-h3-lh' => array(
							'type' => 'number',
							'default' => '45',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Headings H3 Letter Spacing
						'ashade-headings-h3-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							)
						),
						#  Headings H3 Bottom Spacing
						'ashade-headings-h3-bs' => array(
							'type' => 'number',
							'default' => '25',
							'label' => esc_attr__( 'Bottom Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 0,
							)
						),
						# --- Headings H4 ---
						'ashade-typography-headings-h4-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding',
							'label' => esc_attr__( 'H4', 'ashade' ),
						),
						# Headings H4 Font Size
						'ashade-headings-h4-fs' => array(
							'type' => 'number',
							'default' => '30',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Headings H4 Line Height
						'ashade-headings-h4-lh' => array(
							'type' => 'number',
							'default' => '35',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Headings H4 Letter Spacing
						'ashade-headings-h4-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							)
						),
						#  Headings H4 Bottom Spacing
						'ashade-headings-h4-bs' => array(
							'type' => 'number',
							'default' => '20',
							'label' => esc_attr__( 'Bottom Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 0,
							)
						),
						# --- Headings H5 ---
						'ashade-typography-headings-h5-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding',
							'label' => esc_attr__( 'H5', 'ashade' ),
						),
						# Headings H5 Font Size
						'ashade-headings-h5-fs' => array(
							'type' => 'number',
							'default' => '24',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Headings H5 Line Height
						'ashade-headings-h5-lh' => array(
							'type' => 'number',
							'default' => '29',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Headings H5 Letter Spacing
						'ashade-headings-h5-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							)
						),
						#  Headings H5 Bottom Spacing
						'ashade-headings-h5-bs' => array(
							'type' => 'number',
							'default' => '18',
							'label' => esc_attr__( 'Bottom Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 0,
							)
						),
						# --- Headings H6 ---
						'ashade-typography-headings-h6-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding',
							'label' => esc_attr__( 'H6', 'ashade' ),
						),
						# Headings H6 Font Size
						'ashade-headings-h6-fs' => array(
							'type' => 'number',
							'default' => '20',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Headings H6 Line Height
						'ashade-headings-h6-lh' => array(
							'type' => 'number',
							'default' => '25',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							)
						),
						#  Headings H6 Letter Spacing
						'ashade-headings-h6-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							)
						),
						#  Headings H6 Bottom Spacing
						'ashade-headings-h6-bs' => array(
							'type' => 'number',
							'default' => '15',
							'label' => esc_attr__( 'Bottom Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 0,
							)
						),

					# SECTION: Blockquotes Typography
					'ashade-typography-blockquotes' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Blockquotes', 'ashade' ),
					),
						# Blockquotes Font Style
						'ashade-quotes-font' => array(
							'type' => 'select',
							'default' => 'ashade-content',
							'label' => esc_attr__( 'Use Font Family', 'ashade' ),
							'choices' => $web_fonts_usage
						),	
						# Blockquotes Font Size
						'ashade-quotes-fs' => array(
							'type' => 'number',
							'default' => '20',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							),
						),
						# Blockquotes Line Height
						'ashade-quotes-lh' => array(
							'type' => 'number',
							'default' => '32',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							),
						),
						# Blockquotes Letter Spacing
						'ashade-quotes-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							),
						),
						# Blockquotes Uppercase
						'ashade-quotes-u' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Uppercase', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Blockquotes Italic
						'ashade-quotes-i' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Italic', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# --- Divider ---
						'divider-quotes-typo' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Quote Symbol Size
						'ashade-quotes-symbol-size' => array(
							'type' => 'number',
							'default' => '80',
							'label' => esc_attr__( 'Quote Symbol Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 150
							),
						),
						# Blockquote Side Spacing
						'ashade-quotes-side-spacing' => array(
							'type' => 'number',
							'default' => '60',
							'label' => esc_attr__( 'Side Spacing, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 120
							),
						),
						# Blockquote Bottom Spacing
						'ashade-quotes-spacing' => array(
							'type' => 'number',
							'default' => '32',
							'label' => esc_attr__( 'Bottom Spacing, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 100
							),
						),
						# --- Citation Title ---
						'ashade-quotes-cite-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding2',
							'label' => esc_attr__( 'Citation', 'ashade' ),
						),
						# Citation Align
						'ashade-quotes-cite-align' => array (
							'type' => 'choose',
							'default' => 'right',
							'label' => esc_attr__( 'Citation Align', 'ashade' ),
							'custom_class' => 'shadow-same-switch3',
							'options' => array(
								'left' => esc_attr__( 'Left', 'ashade' ),
								'center' => esc_attr__( 'Center', 'ashade' ),
								'right' => esc_attr__( 'Right', 'ashade' ),
							)
						),					
						# Citation Top Spacing
						'ashade-quotes-cite-spacing' => array(
							'type' => 'number',
							'default' => '7',
							'label' => esc_attr__( 'Top Spacing, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 50
							),
						),
						# --- Divider ---
						'divider-quotes-cite' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Citation Font Style
						'ashade-quotes-cite-font' => array(
							'type' => 'select',
							'default' => 'ashade-overheads',
							'label' => esc_attr__( 'Use Font Family', 'ashade' ),
							'choices' => $web_fonts_usage
						),	
						# Citation Font Size
						'ashade-quotes-cite-fs' => array(
							'type' => 'number',
							'default' => '12',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							),
						),
						# Citation Line Height
						'ashade-quotes-cite-lh' => array(
							'type' => 'number',
							'default' => '18',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							),
						),
						# Citation Letter Spacing
						'ashade-quotes-cite-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							),
						),
						# Citation Uppercase
						'ashade-quotes-cite-u' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Uppercase', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Citation Italic
						'ashade-quotes-cite-i' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Italic', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# --- Divider ---
						'divider-quotes-colors' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Blockquote Customize Colors
						'ashade-quotes-custom-colors' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Customize Colors?', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Blockquotes Text Color
						'ashade-quotes-color-text' => array (
							'type' => 'color',
							'default' => '#808080',
							'label' => esc_attr__( 'Text Color', 'ashade' ),
							'condition' => array (
								'ashade-quotes-custom-colors' => true
							)
						),
						# Blockquotes Symbol Color
						'ashade-quotes-color-symbol' => array (
							'type' => 'color',
							'default' => '#5C5C60',
							'label' => esc_attr__( 'Symbol Color', 'ashade' ),
							'condition' => array (
								'ashade-quotes-custom-colors' => true
							)
						),
						# Blockquotes Citation Color
						'ashade-quotes-color-cite' => array (
							'type' => 'color',
							'default' => '#FFFFFF',
							'label' => esc_attr__( 'Citation Color', 'ashade' ),
							'condition' => array (
								'ashade-quotes-custom-colors' => true
							)
						),

					# SECTION: Dropcaps Typography
					'ashade-typography-dropcaps' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Dropcaps', 'ashade' ),
					),
						# Dropcaps Font Style
						'ashade-dropcap-font' => array(
							'type' => 'select',
							'default' => 'ashade-headings',
							'label' => esc_attr__( 'Use Font Family', 'ashade' ),
							'choices' => $web_fonts_usage
						),	
						# Dropcaps Font Size
						'ashade-dropcap-fs' => array(
							'type' => 'number',
							'default' => '75',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							),
						),
						# Dropcaps Line Height
						'ashade-dropcap-lh' => array(
							'type' => 'number',
							'default' => '80',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							),
						),
						# Dropcaps Letter Spacing
						'ashade-dropcap-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							),
						),
						# Dropcaps Uppercase
						'ashade-dropcap-u' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Uppercase', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Dropcaps Italic
						'ashade-dropcap-i' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Italic', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# --- Divider ---
						'divider-dropcap-typo' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Dropcaps Top Spacing
						'ashade-dropcap-top-spacing' => array(
							'type' => 'number',
							'default' => '-4',
							'label' => esc_attr__( 'Top Spacing, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -20,
								'max' => 20
							),
						),
						# Dropcaps Side Spacing
						'ashade-dropcap-side-spacing' => array(
							'type' => 'number',
							'default' => '20',
							'label' => esc_attr__( 'Side Spacing, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 100
							),
						),
						# Dropcaps Bottom Spacing
						'ashade-dropcap-bottom-spacing' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Bottom Spacing, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -20,
								'max' => 20
							),
						),
						# --- Divider ---
						'divider-dropcap-colors' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Dropcaps Customize Colors
						'ashade-dropcap-custom-colors' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Customize Colors?', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Dropcaps Text Color
						'ashade-dropcap-color' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Dropcap Color', 'ashade' ),
							'condition' => array (
								'ashade-dropcap-custom-colors' => true
							)
						),

					# SECTION: Tables Typography
					'ashade-typography-tables' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Tables', 'ashade' ),
					),
						# Border Collapse
						'ashade-tables-collapse' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Border Collapse', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Border Style
						'ashade-tables-bs' => array (
							'type' => 'select',
							'default' => 'solid',
							'label' => esc_attr__( 'Border Style', 'ashade' ),
							'choices' => $border_style,
						),
						# Border Width
						'ashade-tables-bw' => array(
							'type' => 'number',
							'default' => '1',
							'label' => esc_attr__( 'Border Width, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 1,
								'max' => 10
							),
							'condition' => array(
								'ashade-tables-bs' => 'solid,double,dotted,dashed,groove'
							)
						),
						# --- Divider ---
						'divider-tables-border' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Space Under Table
						'ashade-tables-spacing' => array(
							'type' => 'number',
							'default' => '28',
							'label' => esc_attr__( 'Bottom Spacing, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 100
							),
						),
						# Cell Padding
						'ashade-tables-cell-padding' => array (
							'type' => 'dimension',
							'default' => '10/20/10/20',
							'label' => esc_attr__( 'Cell Padding, PX', 'ashade' ),
							'locked' => 'no',
						),
						# Cell Align
						'ashade-tables-cell-align' => array (
							'type' => 'choose',
							'default' => 'center',
							'label' => esc_attr__( 'Cell Align', 'ashade' ),
							'custom_class' => 'shadow-same-switch3',
							'options' => array(
								'left' => esc_attr__( 'Left', 'ashade' ),
								'center' => esc_attr__( 'Center', 'ashade' ),
								'right' => esc_attr__( 'Right', 'ashade' ),
							)
						),
						# Cell Vertical Align
						'ashade-tables-cell-valign' => array (
							'type' => 'choose',
							'default' => 'middle',
							'label' => esc_attr__( 'Cell Vertical Align', 'ashade' ),
							'custom_class' => 'shadow-same-switch3',
							'options' => array(
								'top' => esc_attr__( 'Top', 'ashade' ),
								'middle' => esc_attr__( 'Middle', 'ashade' ),
								'bottom' => esc_attr__( 'Bottom', 'ashade' ),
							)
						),
						# --- Divider ---
						'divider-tables-colors' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Tables Customize Colors
						'ashade-tables-custom-colors' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Customize Colors?', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Table Border Color
						'ashade-tables-color-border' => array (
							'type' => 'color',
							'default' => '#313133',
							'label' => esc_attr__( 'Border Color', 'ashade' ),
							'condition' => array (
								'ashade-tables-custom-colors' => true,
								'ashade-tables-bs' => 'solid,double,dotted,dashed,groove'
							)
						),
						# Table Background Color
						'ashade-tables-color-bg' => array (
							'type' => 'color',
							'default' => '',
							'label' => esc_attr__( 'Background Color', 'ashade' ),
							'condition' => array (
								'ashade-tables-custom-colors' => true,
							)
						),
						# Table Text Color
						'ashade-tables-color-text' => array (
							'type' => 'color',
							'default' => '#808080',
							'label' => esc_attr__( 'Text Color', 'ashade' ),
							'condition' => array (
								'ashade-tables-custom-colors' => true,
							)
						),
						# Table Link Color
						'ashade-tables-color-link' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Link Color', 'ashade' ),
							'condition' => array (
								'ashade-tables-custom-colors' => true,
							)
						),
						# Table Link Hover Color
						'ashade-tables-color-hlink' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Link Hover Color', 'ashade' ),
							'condition' => array (
								'ashade-tables-custom-colors' => true,
							)
						),

					# SECTION: Lists Typography
					'ashade-typography-lists' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Lists', 'ashade' ),
					),
						# List Side Spacing
						'ashade-lists-side-spacing' => array(
							'type' => 'number',
							'default' => '17',
							'label' => esc_attr__( 'Side Spacing, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 100
							),
						),					
						# List Bottom Spacing
						'ashade-lists-bottom-spacing' => array(
							'type' => 'number',
							'default' => '28',
							'label' => esc_attr__( 'Bottom Spacing, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 100
							),
						),					
						# List Item Padding
						'ashade-lists-padding' => array (
							'type' => 'dimension',
							'default' => '0/0/0/13',
							'label' => esc_attr__( 'List Item Padding, PX', 'ashade' ),
							'locked' => 'no',
						),
						# List Style
						'ashade-lists-style' => array(
							'type' => 'select',
							'default' => 'disc',
							'label' => esc_attr__( 'Unordered List Style', 'ashade' ),
							'choices' => array(
								'disc' => 'Disc',
								'circle' => 'Circle',
								'square' => 'Square',
							),
						),
						# --- Divider ---
						'divider-lists01' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# List Customize Colors
						'ashade-lists-custom-colors' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Customize Colors?', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# List Text Color
						'ashade-lists-color-text' => array (
							'type' => 'color',
							'default' => '#808080',
							'label' => esc_attr__( 'Text Color', 'ashade' ),
							'condition' => array (
								'ashade-lists-custom-colors' => true,
							)
						),
						# List Link Color
						'ashade-lists-color-link' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Link Color', 'ashade' ),
							'condition' => array (
								'ashade-lists-custom-colors' => true,
							)
						),
						# List Link Hover Color
						'ashade-lists-color-hlink' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Link Hover Color', 'ashade' ),
							'condition' => array (
								'ashade-lists-custom-colors' => true,
							)
						),
				# PANEL: Forms and Fields
				'ashade-forms-panel' => array (
					'type' => 'panel',
					'title' => esc_attr__( 'Forms and Fields', 'ashade' ),
					'priority' => 35,
				),
					# SECTION: Form Fields
					'ashade-forms-input' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Form Fields', 'ashade' ),
					),
						# --- Fields Size Title ---
						'ashade-forms-input-title01' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding3',
							'label' => esc_attr__( 'Size', 'ashade' ),
						),
						# Fields Size
						'ashade-input-height' => array(
							'type' => 'number',
							'default' => '50',
							'label' => esc_attr__( 'Field Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 100
							),
						),	
						# Textarea Size
						'ashade-textarea-height' => array(
							'type' => 'number',
							'default' => '230',
							'label' => esc_attr__( 'Textarea Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 500
							),
						),	
						# Fields Spacing
						'ashade-input-spacing' => array(
							'type' => 'number',
							'default' => '20',
							'label' => esc_attr__( 'Bottom Spacing, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 100
							),
						),	
						# Field Item Padding
						'ashade-input-padding' => array (
							'type' => 'dimension',
							'default' => '15/20/15/20',
							'label' => esc_attr__( 'Item Padding, PX', 'ashade' ),
							'locked' => 'no',
						),
						# --- Fields Border Title ---
						'ashade-forms-input-title02' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding2',
							'label' => esc_attr__( 'Border', 'ashade' ),
						),
						# Border Style
						'ashade-input-bs' => array (
							'type' => 'select',
							'default' => 'solid',
							'label' => esc_attr__( 'Border Style', 'ashade' ),
							'choices' => $border_style,
						),
						# Border Width
						'ashade-input-bw' => array(
							'type' => 'number',
							'default' => '2',
							'label' => esc_attr__( 'Border Width, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 1,
								'max' => 10
							),
							'condition' => array(
								'ashade-input-bs' => 'solid,double,dotted,dashed,groove'
							)
						),
						# Border Radius
						'ashade-input-br' => array (
							'type' => 'dimension',
							'default' => '0/0/0/0',
							'label' => esc_attr__( 'Border Radius, PX', 'ashade' ),
							'locked' => 'yes',
						),
						# --- Fields Typography ---
						'ashade-forms-input-title03' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding2',
							'label' => esc_attr__( 'Typography', 'ashade' ),
						),
						# Fields Font Style
						'ashade-input-font' => array(
							'type' => 'select',
							'default' => 'ashade-content',
							'label' => esc_attr__( 'Use Font Family', 'ashade' ),
							'choices' => $web_fonts_usage
						),	
						# Fields Font Size
						'ashade-input-fs' => array(
							'type' => 'number',
							'default' => '14',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							),
						),
						# Fields Line Height
						'ashade-input-lh' => array(
							'type' => 'number',
							'default' => '16',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							),
						),
						# Fields Letter Spacing
						'ashade-input-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							),
						),
						# Fields Uppercase
						'ashade-input-u' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Uppercase', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Fields Italic
						'ashade-input-i' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Italic', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# --- Divider ---
						'divider-inputs01' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Fields Customize Colors
						'ashade-input-custom-colors' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Customize Colors?', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# --- Fields Color Title ---
						'ashade-forms-input-ctitle01' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding2',
							'label' => esc_attr__( 'Default State', 'ashade' ),
							'condition' => array (
								'ashade-input-custom-colors' => true,
							)
						),
						# Fields Background Color
						'ashade-input-color-bg' => array (
							'type' => 'color',
							'default' => '',
							'label' => esc_attr__( 'Background Color', 'ashade' ),
							'condition' => array (
								'ashade-input-custom-colors' => true,
							)
						),
						# Fields Text Color
						'ashade-input-color-text' => array (
							'type' => 'color',
							'default' => '#808080',
							'label' => esc_attr__( 'Text Color', 'ashade' ),
							'condition' => array (
								'ashade-input-custom-colors' => true,
							)
						),
						# Fields Border Color
						'ashade-input-color-border' => array (
							'type' => 'color',
							'default' => '#313133',
							'label' => esc_attr__( 'Border Color', 'ashade' ),
							'condition' => array (
								'ashade-input-custom-colors' => true,
								'ashade-input-bs' => 'solid,double,dotted,dashed,groove'
							)
						),
						# --- Fields Hover Color Title ---
						'ashade-forms-input-ctitle02' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding2',
							'label' => esc_attr__( 'Hover State', 'ashade' ),
							'condition' => array (
								'ashade-input-custom-colors' => true,
							)
						),
						# Fields Background Color
						'ashade-input-color-hbg' => array (
							'type' => 'color',
							'default' => '',
							'label' => esc_attr__( 'Hover Background Color', 'ashade' ),
							'condition' => array (
								'ashade-input-custom-colors' => true,
							)
						),
						# Fields Text Color
						'ashade-input-color-htext' => array (
							'type' => 'color',
							'default' => '#808080',
							'label' => esc_attr__( 'Hover Text Color', 'ashade' ),
							'condition' => array (
								'ashade-input-custom-colors' => true,
							)
						),
						# Fields Border Color
						'ashade-input-color-hborder' => array (
							'type' => 'color',
							'default' => '#5C5C60',
							'label' => esc_attr__( 'Hover Border Color', 'ashade' ),
							'condition' => array (
								'ashade-input-custom-colors' => true,
								'ashade-input-bs' => 'solid,double,dotted,dashed,groove'
							)
						),
						# --- Fields Focus Color Title ---
						'ashade-forms-input-ctitle03' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding2',
							'label' => esc_attr__( 'Focus State', 'ashade' ),
							'condition' => array (
								'ashade-input-custom-colors' => true,
							)
						),
						# Fields Background Color
						'ashade-input-color-fbg' => array (
							'type' => 'color',
							'default' => '',
							'label' => esc_attr__( 'Focus Background Color', 'ashade' ),
							'condition' => array (
								'ashade-input-custom-colors' => true,
							)
						),
						# Fields Text Color
						'ashade-input-color-ftext' => array (
							'type' => 'color',
							'default' => '#808080',
							'label' => esc_attr__( 'Focus Text Color', 'ashade' ),
							'condition' => array (
								'ashade-input-custom-colors' => true,
							)
						),
						# Fields Border Color
						'ashade-input-color-fborder' => array (
							'type' => 'color',
							'default' => '#5C5C60',
							'label' => esc_attr__( 'Focus Border Color', 'ashade' ),
							'condition' => array (
								'ashade-input-custom-colors' => true,
								'ashade-input-bs' => 'solid,double,dotted,dashed,groove'
							)
						),

					# SECTION: Form Button
					'ashade-forms-button' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Form Button', 'ashade' ),
					),
						# --- Button Size Title ---
						'ashade-forms-button-title01' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding3',
							'label' => esc_attr__( 'Size', 'ashade' ),
						),
						# Button Size
						'ashade-button-height' => array(
							'type' => 'number',
							'default' => '50',
							'label' => esc_attr__( 'Field Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 100
							),
						),	
						# Button Spacing
						'ashade-button-spacing' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Bottom Spacing, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 100
							),
						),	
						# Button Item Padding
						'ashade-button-padding' => array (
							'type' => 'dimension',
							'default' => '15/40/15/40',
							'label' => esc_attr__( 'Item Padding, PX', 'ashade' ),
							'locked' => 'no',
						),
						# --- Button Border Title ---
						'ashade-forms-button-title02' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding2',
							'label' => esc_attr__( 'Border', 'ashade' ),
						),
						# Button Border Style
						'ashade-button-bs' => array (
							'type' => 'select',
							'default' => 'solid',
							'label' => esc_attr__( 'Border Style', 'ashade' ),
							'choices' => $border_style,
						),
						# Button Border Width
						'ashade-button-bw' => array(
							'type' => 'number',
							'default' => '2',
							'label' => esc_attr__( 'Border Width, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 1,
								'max' => 10
							),
							'condition' => array(
								'ashade-button-bs' => 'solid,double,dotted,dashed,groove'
							)
						),
						# Button Border Radius
						'ashade-button-br' => array (
							'type' => 'dimension',
							'default' => '0/0/0/0',
							'label' => esc_attr__( 'Border Radius, PX', 'ashade' ),
							'locked' => 'yes',
						),
						# --- Button Typography ---
						'ashade-forms-button-title03' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding2',
							'label' => esc_attr__( 'Typography', 'ashade' ),
						),
						# Button Font Style
						'ashade-button-font' => array(
							'type' => 'select',
							'default' => 'ashade-headings',
							'label' => esc_attr__( 'Use Font Family', 'ashade' ),
							'choices' => $web_fonts_usage
						),	
						# Button Font Size
						'ashade-button-fs' => array(
							'type' => 'number',
							'default' => '14',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							),
						),
						# Button Line Height
						'ashade-button-lh' => array(
							'type' => 'number',
							'default' => '16',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							),
						),
						# Button Letter Spacing
						'ashade-button-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							),
						),
						# Button Uppercase
						'ashade-button-u' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Uppercase', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Button Italic
						'ashade-button-i' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Italic', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# --- Divider ---
						'divider-button01' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Button Customize Colors
						'ashade-button-custom-colors' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Customize Colors?', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# --- Button Color Title ---
						'ashade-forms-button-ctitle01' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding2',
							'label' => esc_attr__( 'Default State', 'ashade' ),
							'condition' => array (
								'ashade-button-custom-colors' => true,
							)
						),
						# Button Background Color
						'ashade-button-color-bg' => array (
							'type' => 'color',
							'default' => '',
							'label' => esc_attr__( 'Background Color', 'ashade' ),
							'condition' => array (
								'ashade-button-custom-colors' => true,
							)
						),
						# Button Text Color
						'ashade-button-color-text' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Text Color', 'ashade' ),
							'condition' => array (
								'ashade-button-custom-colors' => true,
							)
						),
						# Button Border Color
						'ashade-button-color-border' => array (
							'type' => 'color',
							'default' => '#313133',
							'label' => esc_attr__( 'Border Color', 'ashade' ),
							'condition' => array (
								'ashade-button-custom-colors' => true,
								'ashade-button-bs' => 'solid,double,dotted,dashed,groove'
							)
						),
						# --- Button Hover Color Title ---
						'ashade-forms-button-ctitle02' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding2',
							'label' => esc_attr__( 'Hover State', 'ashade' ),
							'condition' => array (
								'ashade-button-custom-colors' => true,
							)
						),
						# Button Background Color
						'ashade-button-color-hbg' => array (
							'type' => 'color',
							'default' => '',
							'label' => esc_attr__( 'Hover Background Color', 'ashade' ),
							'condition' => array (
								'ashade-button-custom-colors' => true,
							)
						),
						# Button Text Color
						'ashade-button-color-htext' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Hover Text Color', 'ashade' ),
							'condition' => array (
								'ashade-button-custom-colors' => true,
							)
						),
						# Button Border Color
						'ashade-button-color-hborder' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Hover Border Color', 'ashade' ),
							'condition' => array (
								'ashade-button-custom-colors' => true,
								'ashade-button-bs' => 'solid,double,dotted,dashed,groove'
							)
						),
					
					# SECTION: Notifications
					'ashade-forms-notify' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Form Notifications', 'ashade' ),
					),
						# Notifications Font Style
						'ashade-notify-font' => array(
							'type' => 'select',
							'default' => 'ashade-content',
							'label' => esc_attr__( 'Use Font Family', 'ashade' ),
							'choices' => $web_fonts_usage
						),	
						# Notifications Font Size
						'ashade-notify-fs' => array(
							'type' => 'number',
							'default' => '12',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							),
						),
						# Notifications Line Height
						'ashade-notify-lh' => array(
							'type' => 'number',
							'default' => '20',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							),
						),
						# Notifications Letter Spacing
						'ashade-notify-ls' => array(
							'type' => 'number',
							'default' => '0',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							),
						),
						# Notifications Uppercase
						'ashade-notify-u' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Uppercase', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Notifications Italic
						'ashade-notify-i' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Italic', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# --- Divider ---
						'divider-notify-01' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Notifications Customize Colors
						'ashade-notify-custom-colors' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Customize Colors?', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Notifications Default Color
						'ashade-notify-color-default' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Normal Color', 'ashade' ),
							'condition' => array (
								'ashade-notify-custom-colors' => true,
							)
						),
						# Notifications Default Color
						'ashade-notify-color-error' => array (
							'type' => 'color',
							'default' => '#CC4040',
							'label' => esc_attr__( 'Error Color', 'ashade' ),
							'condition' => array (
								'ashade-notify-custom-colors' => true,
							)
						),
				
				# SECTION: Header
				'ashade-header-section' => array (
					'type' => 'section',
					'single' => true,
					'priority' => 40,
					'title' => esc_attr__( 'Header Settings', 'ashade' ),
				),
                    # Alternative Mobile Menu
					'ashade-mobile-menu-alt' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Alternative Mobile Menu', 'ashade' ),
                        'description' => esc_attr__( 'If enabled alternative menu will be used for mobile devices instead of the main menu.', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
                    # --- Divider ---
					'divider-header-alt' => array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
					),
					# Sticky Header
					'ashade-header-sticky' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Sticky Header', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Sticky Header
					'ashade-header-sticky-hide' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Hide on Scroll Down', 'ashade' ),
						'description' => esc_attr__( 'If enabled, the header will hide on scroll down and shows again on scroll up.', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
						'condition' => array(
							'ashade-header-sticky' => true
						)
					),
					# Header Scroll State
					'ashade-header-scroll-state' => array (
						'type' => 'choose',
						'default' => 'transparent',
						'label' => esc_attr__( 'Header Background on Scroll', 'ashade' ),
						'custom_class' => 'shadow-same-switch3',
						'options' => array(
							'transparent' => esc_attr__( 'Transparent', 'ashade' ),
							'gradient' => esc_attr__( 'Gradient', 'ashade' ),
							'solid' => esc_attr__( 'Solid', 'ashade' ),
						),
						'condition' => array(
							'ashade-header-sticky' => true
						)
					),
					'ashade-header-background' => array (
						'type' => 'color',
						'default' => '#000000',
						'label' => esc_attr__( 'Header Background Color', 'ashade' ),
						'condition' => array (
							'ashade-header-sticky' => true,
							'ashade-header-scroll-state' => 'gradient,solid'
						)
					),

					# --- Divider ---
					'divider-header-00' => array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
					),
					# Header Layout
					'ashade-header-layout' => array (
						'type' => 'choose',
						'default' => 'layout01',
						'label' => esc_attr__( 'Header Layout', 'ashade' ),
						'style' => 'image',
						'config' => array(
							'columns' => 3,
							'margin' => 7,
						),
						'options' => array(
							'layout01' => array(
								'title' => esc_attr__( 'Logo Left (Menu Right)', 'ashade' ),
								'img' => get_template_directory_uri() . '/assets/img/admin/header01.svg',
								'img_active' => get_template_directory_uri() . '/assets/img/admin/header01a.svg',
							),
							'layout02' => array(
								'title' => esc_attr__( 'Logo Center (Menu Center)', 'ashade' ),
								'img' => get_template_directory_uri() . '/assets/img/admin/header02.svg',
								'img_active' => get_template_directory_uri() . '/assets/img/admin/header02a.svg',
							),
							'layout03' => array(
								'title' => esc_attr__( 'Logo Right (Menu Left)', 'ashade' ),
								'img' => get_template_directory_uri() . '/assets/img/admin/header03.svg',
								'img_active' => get_template_directory_uri() . '/assets/img/admin/header03a.svg',
							),
						)
					),	
					# --- Divider ---
					'divider-header-01' => array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
					),
					# Aside Bar State
					'ashade-aside-state' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Enable Aside Bar', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Aside Use Text Label
					'ashade-aside-label-type' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Use Text Label?', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Clients Notify Email
					'ashade-aside-label' => array (
						'type' => 'text',
						'default' => 'More',
						'label' => esc_attr__( 'Label Text', 'ashade' ),
						'condition' => array(
							'ashade-aside-label-type' => true
						)
					),
				
				# SECTION: Sidebar Settings
				'ashade-sidebar-section' => array (
					'type' => 'section',
					'single' => true,
					'priority' => 100,
					'title' => esc_attr__( 'Sidebar Settings', 'ashade' ),
				),
					# Sidebar State
					'ashade-sidebar-position' => array (
						'type' => 'choose',
						'default' => 'none',
						'label' => esc_attr__( 'Sidebar Position', 'ashade' ),
						'custom_class' => 'shadow-same-switch3',
						'options' => array(
							'left' => esc_attr__( 'Left', 'ashade' ),
							'none' => esc_attr__( 'None', 'ashade' ),
							'right' => esc_attr__( 'Right', 'ashade' ),
						)
					),

				# SECTION: Page Settings
				'ashade-page-section' => array (
					'type' => 'section',
					'single' => true,
					'priority' => 120,
					'title' => esc_attr__( 'Page Settings', 'ashade' ),
				),
					# Show Page Title
					'ashade-page-title' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Show Page Title', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# --- Divider ---
					'divider-page-01' => array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
					),
					# Content Under Header
					'ashade-page-cu' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Content Under Header', 'ashade' ),
						'description' => esc_attr__( 'If enabled content will ignore header height.', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Content Top Spacing
					'ashade-page-pt' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Content Top Spacing', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Content Bottom Spacing
					'ashade-page-pb' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Content Bottom Spacing', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# --- Divider ---
					'divider-page-02' => array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
					),
					# Alow Comments
					'ashade-page-comments' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Allow Comments', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),

				# PANEL: Blog Settings
				'ashade-blog-panel' => array (
					'type' => 'panel',
					'title' => esc_attr__( 'Blog Settings', 'ashade' ),
					'priority' => 125,
				),
					# SECTION: Blog Posts Listing
					'ashade-listing-section' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Posts Listing', 'ashade' ),
					),
						# Blog Layout
						'ashade-listing-thmb-size' => array (
							'type' => 'choose',
							'default' => 'small',
							'label' => esc_attr__( 'Post Thumbnail Size', 'ashade' ),
							'custom_class' => 'shadow-same-switch3',
							'options' => array(
								'small' => esc_attr__( 'Small', 'ashade' ),
								'medium' => esc_attr__( 'Medium', 'ashade' ),
								'large' => esc_attr__( 'Large', 'ashade' ),
							)
						),
						# --- Divider ---
						'divider-listing-00' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),		
						# Sidebar State
						'ashade-listing-sidebar' => array (
							'type' => 'choose',
							'default' => 'def',
							'label' => esc_attr__( 'Sidebar Position', 'ashade' ),
							'custom_class' => 'shadow-same-switch4',
							'options' => array(
								'def' => esc_attr__( 'Default', 'ashade' ),
								'none' => esc_attr__( 'None', 'ashade' ),
								'left' => esc_attr__( 'Left', 'ashade' ),
								'right' => esc_attr__( 'Right', 'ashade' ),
							)
						),
						# --- Divider ---
						'divider-listing-01' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Post Content Uder Header
						'ashade-listing-cu' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Content Uder Header', 'ashade' ),
							'description' => esc_attr__( 'If enabled content will ignore header height.', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Post Content Top Spacing
						'ashade-listing-pt' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Content Top Spacing', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Post Content Bottom Spacing
						'ashade-listing-pb' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Content Bottom Spacing', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# --- Divider ---
						'divider-listing-02' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Post Meta
						'ashade-listing-meta' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Show Post Meta', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Meta - Post Author
						'ashade-listing-meta-author' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Show Post Author', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array(
								'ashade-listing-meta' => true
							)
						),
						# Meta - Post Date
						'ashade-listing-meta-date' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Show Post Date', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array(
								'ashade-listing-meta' => true
							)
						),
						# Meta - Post Comments Count
						'ashade-listing-meta-comments' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Show Comments Count', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array(
								'ashade-listing-meta' => true
							)
						),
						# Meta - Post Category
						'ashade-listing-meta-category' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Show Post Category', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array(
								'ashade-listing-meta' => true
							)
						),
						# Meta - Post Tags
						'ashade-listing-meta-tags' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Show Post Tags', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array(
								'ashade-listing-meta' => true
							)
						),
						# --- Divider ---
						'divider-listing-03' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Post Excerpts
						'ashade-listing-excerpt' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Show Post Excerpts', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),

					# SECTION: Post Settings
					'ashade-post-section' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Single Post Settings', 'ashade' ),
					),
						# Post Content Uder Header
						'ashade-post-cu' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Content Under Header', 'ashade' ),
							'description' => esc_attr__( 'If enabled content will ignore header height.', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Post Content Top Spacing
						'ashade-post-pt' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Content Top Spacing', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Post Content Bottom Spacing
						'ashade-post-pb' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Content Bottom Spacing', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# --- Divider ---
						'divider-post-dimension' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Post Title
						'ashade-post-title' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Show Post Title', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# --- Divider ---
						'divider-post-title' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array(
								'ashade-post-title' => true
							)
						),
						# Post Featured Image
						'ashade-post-image' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Show Featured Image', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Post Navigation
						'ashade-post-nav' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Post Navigation', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Post Allow Comments
						'ashade-post-comments' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Allow Comments', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# --- Post Meta Title ---
						'ashade-post-meta-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding3',
							'label' => esc_attr__( 'Post Meta', 'ashade' ),
						),
						# Post Meta
						'ashade-post-meta' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Show Post Meta', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Meta - Post Author
						'ashade-post-meta-author' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Show Post Author', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array(
								'ashade-post-meta' => true
							)
						),
						# Meta - Post Date
						'ashade-post-meta-date' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Show Post Date', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array(
								'ashade-post-meta' => true
							)
						),
						# Meta - Post Category
						'ashade-post-meta-category' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Show Post Category', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array(
								'ashade-post-meta' => true
							)
						),
						# Meta - Post Tags
						'ashade-post-meta-tags' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Show Post Tags', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),

				# SECTION: Albums Settings
				'ashade-albums-section' => array (
					'type' => 'section',
					'single' => true,
					'priority' => 130,
					'title' => esc_attr__( 'Albums Settings', 'ashade' ),
					'description' => ( class_exists( 'Shadow_Core' ) ? null : esc_attr__( 'Note: To use that features you need to install and activate Shadow Core Plugin.', 'ashade' )),
				),
					# Albums Defeault Style
					'ashade-albums-type' => array(
						'type' => 'select',
						'default' => 'masonry',
						'label' => esc_attr__( 'Default Album Style', 'ashade' ),
						'choices' => array(
							'grid' => 'Grid',
							'masonry' => 'Masonry',
							'adjusted' => 'Adjusted',
							'bricks' => 'Bricks',
							'ribbon' => 'Ribbon',
							'slider' => 'Slider',
							'justified' => 'Justified',
						),
					),
					# Albums Items Gap Type
					'ashade-albums-gap' => array(
						'type' => 'select',
						'default' => 'theme',
						'label' => esc_attr__( 'Default Items Gap', 'ashade' ),
						'choices' => array(
							'theme' => 'Default by Theme',
							'custom' => 'Custom'
						),
						'condition' => array(
							'ashade-albums-type' => 'grid,masonry,adjusted,bricks,ribbon'
						),
					),
					# Items Gap (Grid)
					'ashade-albums-custom-gap' => array(
						'type' => 'number',
						'default' => '{"d":"40","t":"30","m":"20"}',
						'label' => esc_html__( 'Custom Gap, PX', 'ashade' ),
						'options' => array(
							'style' => 'slider',
							'responsive' => true,
							'min' => 0,
							'max' => 120,
						),
						'condition' => array(
							'ashade-albums-type' => 'grid,masonry,adjusted,bricks,ribbon',
							'ashade-albums-gap' => 'custom'
						),
					),
					# Items Border Radius
					'ashade-albums-br' => array(
						'type' => 'number',
						'default' => '{"d":"0","t":"0","m":"0"}',
						'label' => esc_html__( 'Items Border Radius, PX', 'ashade' ),
						'options' => array(
							'style' => 'slider',
							'responsive' => true,
							'min' => 0,
							'max' => 120,
						),
						'condition' => array(
							'ashade-albums-type' => 'grid,masonry,adjusted,bricks,justified,ribbon',
						),
					),
					# --- Divider ---
					'divider-albums-00' => array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
					),
                    # Albums Content Layout
					'ashade-albums-content-layout' => array(
						'type' => 'select',
						'default' => 'boxed',
						'label' => esc_attr__( 'Content Width', 'ashade' ),
                        'description' => esc_attr__( 'This option is actual for "Grid" layouts only.', 'ashade' ), 
						'choices' => array(
							'boxed' => 'Boxed',
							'fullwidth' => 'Fullwidth',
						),
                        'condition' => array(
							'ashade-albums-type' => 'grid,masonry,adjusted,bricks,justified'
						)
					),
					# Albums Defeault Style
					'ashade-albums-direction' => array (
						'type' => 'choose',
						'default' => 'normal',
						'label' => esc_attr__( 'Default Images Direction', 'ashade' ),
						'custom_class' => 'shadow-same-switch3',
						'options' => array(
							'normal' => esc_attr__( 'Normal', 'ashade' ),
							'reverse' => esc_attr__( 'Reverse', 'ashade' ),
							'random' => esc_attr__( 'Random', 'ashade' ),
						),
					),
					# --- Divider ---
					'divider-albums-01' => array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
					),
					# Albums Title
					'ashade-albums-title' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Album Title', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
						'condition' => array(
							'ashade-albums-type' => 'grid,masonry,adjusted,bricks,justified,slider'
						)
					),
					# Albums Title for Vertical Ribbon
					'ashade-albums-rtitle' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Album Title', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
						'condition' => array(
							'ashade-albums-type' => 'ribbon',
							'ashade-albums-ribbon-layout' => 'vertical',
						)
					),
					# Albums Back Button
					'ashade-albums-back-state' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Show Back Button', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Albums Next Post
					'ashade-albums-next-post' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Link to the Next Post', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
						'condition' => array(
							'ashade-albums-type' => 'grid,masonry,adjusted,bricks,justified',
						)
					),
					# --- Divider ---
					'divider-albums-dim01' => array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
					),
					# Content Under Header
					'ashade-albums-cu' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Content Under Header', 'ashade' ),
						'description' => esc_attr__( 'If enabled content will ignore header height.', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
						'condition' => array(
							'ashade-albums-type' => 'grid,masonry,adjusted,bricks,justified'
						)
					),
					# Content Top Spacing
					'ashade-albums-pt' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Content Top Spacing', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
						'condition' => array(
							'ashade-albums-type' => 'grid,masonry,adjusted,bricks,justified'
						)
					),
					# Content Bottom Spacing
					'ashade-albums-pb' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Content Bottom Spacing', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
						'condition' => array(
							'ashade-albums-type' => 'grid,masonry,adjusted,bricks,justified'
						)
					),
					# Content Bottom Spacing
					'ashade-albums-comments' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Allow Comments?', 'ashade' ),
						'description' => esc_attr__( 'Actual only for Grid Layouts (Grid, Masonry, Bricks, Adjusted and Justified)', 'ashade' ),
						'custom_class' => 'shadow-title-switcher'
					),
					# --- Divider ---
					'divider-albums-dim02' => array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
						'condition' => array(
							'ashade-albums-type' => 'grid,masonry,adjusted,bricks,justified'
						)
					),
					# Albums Columns
					'ashade-albums-columns' => array (
						'type' => 'choose',
						'default' => '3',
						'label' => esc_attr__( 'Columns Number', 'ashade' ),
						'custom_class' => 'shadow-same-switch3',
						'options' => array(
							'2' => esc_attr__( '2 Columns', 'ashade' ),
							'3' => esc_attr__( '3 Columns', 'ashade' ),
							'4' => esc_attr__( '4 Columns', 'ashade' ),
						),
						'condition' => array(
							'ashade-albums-type' => 'grid,masonry,adjusted'
						)
					),
					# Albums Bricks Layout
					'ashade-albums-layout' => array (
						'type' => 'choose',
						'default' => '1x2',
						'label' => esc_attr__( 'Bricks Layout', 'ashade' ),
						'custom_class' => 'shadow-same-switch2',
						'options' => array(
							'1x2' => esc_attr__( '1x2 Items', 'ashade' ),
							'2x3' => esc_attr__( '2x3 Items', 'ashade' ),
						),
						'condition' => array(
							'ashade-albums-type' => 'bricks'
						)
					),
					# Albums Photo Caption
					'ashade-albums-caption' => array (
						'type' => 'select',
						'default' => 'none',
						'label' => esc_attr__( 'Photos Caption', 'ashade' ),
						'choices' => array(
							'none' => esc_attr__( 'None', 'ashade' ),
							'under' => esc_attr__( 'Under Photo', 'ashade' ),
							'on_photo' => esc_attr__( 'On Photo', 'ashade' ),
							'on_hover' => esc_attr__( 'On Hover', 'ashade' ),
						),
						'condition' => array(
							'ashade-albums-type' => 'grid,masonry,adjusted,bricks'
						)
					),
					# Albums Photo Caption for Ribbon/Slider
					'ashade-albums-fs-caption' => array (
						'type' => 'select',
						'default' => 'none',
						'label' => esc_attr__( 'Photos Caption', 'ashade' ),
						'choices' => array(
							'none' => esc_attr__( 'None', 'ashade' ),
							'show' => esc_attr__( 'Show', 'ashade' ),
						),
						'condition' => array(
							'ashade-albums-type' => 'ribbon,slider'
						)
					),
					# Albums Lightbox State
					'ashade-albums-lightbox' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Open images in Lightbox', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
						'condition' => array(
							'ashade-albums-type' => 'grid,masonry,adjusted,bricks,justified'
						)
					),

					# Albums in Lightbox Show
					'ashade-albums-lightbox-text' => array (
						'type' => 'choose',
						'default' => 'none',
						'label' => esc_attr__( 'Text in Lightbox', 'ashade' ),
						'custom_class' => 'shadow-same-switch3',
						'options' => array(
							'none' => esc_attr__( 'None', 'ashade' ),
							'caption' => esc_attr__( 'Caption', 'ashade' ),
							'descr' => esc_attr__( 'Description', 'ashade' ),
						),
						'condition' => array(
							'ashade-albums-type' => 'grid,masonry,adjusted,bricks,justified',
							'ashade-albums-lightbox' => true
						)
					),
					# Albums Row Height
					'ashade-albums-rowHeight' => array(
						'type' => 'number',
						'default' => '250',
						'label' => esc_attr__( 'Approximate Row Height, PX', 'ashade' ),
						'options' => array(
							'style' => 'slider',
							'min' => '80',
							'max' => '1080',
						),
						'condition' => array(
							'ashade-albums-type' => 'justified'
						)
					),
					# Albums Spacing
					'ashade-albums-spacing' => array(
						'type' => 'number',
						'default' => '10',
						'label' => esc_attr__( 'Spacing, PX', 'ashade' ),
						'options' => array(
							'style' => 'slider',
							'min' => '0',
							'max' => '100',
						),
						'condition' => array(
							'ashade-albums-type' => 'justified'
						)
					),
					# Albums Justified Last Row
					'ashade-albums-lastRow' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Justified Last Row', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
						'condition' => array(
							'ashade-albums-type' => 'justified'
						)
					),
					# Albums Ribbon Layout
					'ashade-albums-ribbon-layout' => array (
						'type' => 'choose',
						'default' => 'large',
						'label' => esc_attr__( 'Layout', 'ashade' ),
						'custom_class' => 'shadow-same-switch3',
						'options' => array(
							'large' => esc_attr__( 'Large', 'ashade' ),
							'medium' => esc_attr__( 'Medium', 'ashade' ),
							'vertical' => esc_attr__( 'Vertical', 'ashade' ),
						),
						'condition' => array(
							'ashade-albums-type' => 'ribbon'
						)
					),
					# Albums Ribbon Lightbox
					'ashade-albums-ribbon-lightbox' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Allow Lightbox', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
						'condition' => array(
							'ashade-albums-type' => 'ribbon'
						)
					),
					# Albums Slider Navigation
					'ashade-albums-slider-nav' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Slider Navigation', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
						'condition' => array(
							'ashade-albums-type' => 'slider'
						)
					),
					# Albums Slider Effect
					'ashade-albums-slider-layout' => array (
						'type' => 'choose',
						'default' => 'parallax',
						'label' => esc_attr__( 'Slide Effect', 'ashade' ),
						'custom_class' => 'shadow-same-switch3',
						'options' => array(
							'parallax' => esc_attr__( 'Parallax', 'ashade' ),
							'fade' => esc_attr__( 'Fade', 'ashade' ),
							'simple' => esc_attr__( 'Simple', 'ashade' ),
						),
						'condition' => array(
							'ashade-albums-type' => 'slider'
						)
					),
					# --- Albums Meta Title ---
					'ashade-albums-meta-title' => array (
						'type' => 'custom_title',
						'custom_class' => 'shadow-title-on-divider shadow-title-padding2',
						'label' => esc_attr__( 'Album Meta', 'ashade' ),
					),
					# Meta - Album Author
					'ashade-albums-meta-author' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Show Album Author', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Meta - Album Date
					'ashade-albums-meta-date' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Show Album Date', 'ashade' ),
						'custom_class' => 'shadow-title-switcher'
					),
					# Meta - Album Category
					'ashade-albums-meta-category' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Show Album Category', 'ashade' ),
						'custom_class' => 'shadow-title-switcher'
					),

				# SECTION: Client Settings
				'ashade-client-section' => array (
					'type' => 'section',
					'single' => true,
					'priority' => 135,
					'title' => esc_attr__( 'Client Settings', 'ashade' ),
					'description' => ( class_exists( 'Shadow_Core' ) ? null : esc_attr__( 'Note: To use that features you need to install and activate Shadow Core Plugin.', 'ashade' )),
				),
					# Clients Page Title
					'ashade-client-title' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Show Page Title', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# --- Divider ---
					'divider-client-dim01' => array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
					),
					# Content Under Header
					'ashade-client-cu' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Content Under Header', 'ashade' ),
						'description' => esc_attr__( 'If enabled content will ignore header height.', 'ashade' ),
						'custom_class' => 'shadow-title-switcher'
					),
					# Content Top Spacing
					'ashade-client-pt' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Content Top Spacing', 'ashade' ),
						'custom_class' => 'shadow-title-switcher'
					),
					# Content Bottom Spacing
					'ashade-client-pb' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Content Bottom Spacing', 'ashade' ),
						'custom_class' => 'shadow-title-switcher'
					),
					# --- Divider ---
					'divider-client-dim02' => array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						)
					),
					# Clients Gallery Defeault Style
					'ashade-client-type' => array(
						'type' => 'select',
						'default' => 'masonry',
						'label' => esc_attr__( 'Default Gallery Style', 'ashade' ),
						'choices' => array(
							'grid' => 'Grid',
							'masonry' => 'Masonry',
							'adjusted' => 'Adjusted',
						),
					),
					# --- Divider ---
					'divider-client-01' => array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
					),
					# Clients Gallery Columns
					'ashade-client-columns' => array (
						'type' => 'choose',
						'default' => '3',
						'label' => esc_attr__( 'Columns Number', 'ashade' ),
						'custom_class' => 'shadow-same-switch3',
						'options' => array(
							'2' => esc_attr__( '2 Columns', 'ashade' ),
							'3' => esc_attr__( '3 Columns', 'ashade' ),
							'4' => esc_attr__( '4 Columns', 'ashade' ),
						),
						'condition' => array(
							'ashade-client-type' => 'grid,masonry,adjusted'
						)
					),
					# Clients Gallery Bricks Layout
					'ashade-client-layout' => array (
						'type' => 'choose',
						'default' => '1x2',
						'label' => esc_attr__( 'Bricks Layout', 'ashade' ),
						'custom_class' => 'shadow-same-switch2',
						'options' => array(
							'1x2' => esc_attr__( '1x2 Items', 'ashade' ),
							'2x3' => esc_attr__( '2x3 Items', 'ashade' ),
						),
						'condition' => array(
							'ashade-client-type' => 'bricks'
						)
					),
					# Clients Gallery Photo Caption
					'ashade-client-caption' => array (
						'type' => 'select',
						'default' => 'none',
						'label' => esc_attr__( 'Photos Caption', 'ashade' ),
						'choices' => array(
							'none' => esc_attr__( 'None', 'ashade' ),
							'under' => esc_attr__( 'Under Photo', 'ashade' ),
							'on_photo' => esc_attr__( 'On Photo', 'ashade' ),
							'on_hover' => esc_attr__( 'On Hover', 'ashade' ),
						),
					),
					# Clients Gallery Photo Caption Type
					'ashade-client-caption-type' => array (
						'type' => 'select',
						'default' => 'caption',
						'label' => esc_attr__( 'Field for Captions', 'ashade' ),
						'choices' => array(
							'title' => esc_attr__( 'Use Title', 'ashade' ),
							'caption' => esc_attr__( 'Use Caption', 'ashade' ),
							'descr' => esc_attr__( 'Use Description', 'ashade' ),
						),
					),
					# --- Divider ---
					'divider-client-02' => array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
					),
					# Filter State
					'ashade-client-filter' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Show Filter', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Filter Counters
					'ashade-client-filter-counter' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Show Images Count', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
						'condition' => array(
							'ashade-client-filter' => true
						)
					),
					# Approval Buttons
					'ashade-client-btns-approval' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Show Approval Buttons?', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Image Zoom Button
					'ashade-client-btns-zoom' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Show Image Zoom Button?', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Download Button
					'ashade-client-btns-download' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Show Download Button?', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Show Button
					'ashade-client-btns-state' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Buttons Always Visible?', 'ashade' ),
						'description' => esc_attr__( 'If disabled - buttons will be shown on item hover.', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Clients Comments
					'ashade-client-comments' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Allow Comments?', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# --- Divider ---
					'divider-client-03' => array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
					),
					# Clients Notify Button
					'ashade-client-notify' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Notify Button', 'ashade' ),
						'description' => ( class_exists( 'Shadow_Core' ) ? null : esc_attr__( 'Note: To use that function you need to install and activate Shadow Core Plugin.', 'ashade' )),
						'custom_class' => 'shadow-title-switcher',
					),
					# Clients Notify Email
					'ashade-client-email' => array (
						'type' => 'text',
						'default' => 'demo',
						'label' => esc_attr__( 'Email Address', 'ashade' ),
						'description' => esc_attr__( 'Your Email address, where notify email should be sent.', 'ashade' ),
						'condition' => array(
							'ashade-client-notify' => true
						)
					),
					# Clients Notify Include Links
					'ashade-client-includes' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Include Links to Images', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
						'description' => esc_attr__( 'Enabling this option will attach links to "approved" images in your notification email.', 'ashade' ),
						'condition' => array(
							'ashade-client-notify' => true
						)
					),

				# SECTION: Attachment Settings
				'ashade-attachment-section' => array (
					'type' => 'section',
					'single' => true,
					'priority' => 140,
					'title' => esc_attr__( 'Attachment Settings', 'ashade' ),
				),
					# Attachment Background
					'ashade-attachment-bg' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Show Background', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Attachment BG Opacity
					'ashade-attachment-opacity' => array(
						'type' => 'number',
						'default' => '20',
						'label' => esc_attr__( 'Background Opacity, %', 'ashade' ),
						'options' => array(
							'style' => 'slider',
							'min' => 0,
							'max' => 100
						),
						'condition' => array(
							'ashade-attachment-bg' => true
						)
					),
					# Attachment BG Blur
					'ashade-attachment-blur' => array(
						'type' => 'number',
						'default' => '5',
						'label' => esc_attr__( 'Background Blur', 'ashade' ),
						'options' => array(
							'style' => 'slider',
							'min' => 0,
							'max' => 10
						),
						'condition' => array(
							'ashade-attachment-bg' => true
						)
					),
					# --- Divider ---
					'divider-attachment-bg' => array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						)
					),
					# Attachment Title
					'ashade-attachment-title' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Show Title', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Attachment Caption
					'ashade-attachment-caption' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Show Caption', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Attachment Description
					'ashade-attachment-descr' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Show Description', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),

				# SECTION: 404 Page Settings
				'ashade-404-section' => array (
					'type' => 'section',
					'single' => true,
					'priority' => 145,
					'title' => esc_attr__( '404 Page', 'ashade' ),
				),
					# 404 Page Background
					'ashade-404-bg' => array (
						'type' => 'image',
						'default' => DEFAULT_NULL_IMAGE,
						'label' => esc_attr__( 'Background Image', 'ashade' )
					),
					# 404 Overlay Opacity
					'ashade-404-opacity' => array(
						'type' => 'number',
						'default' => '25',
						'label' => esc_attr__( 'Background Opacity, %', 'ashade' ),
						'options' => array(
							'style' => 'slider',
							'min' => 0,
							'max' => 100
						)
					),
					# --- Divider ---
					'divider-404-01' => array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
						'condition' => array(
							'ashade-logo-type' => 'image, text'
						)
					),
					# 404 Customize Colors
					'ashade-404-custom-colors' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Customize Colors?', 'ashade' ),
						'custom_class' => 'shadow-title-switcher'
					),
					# 404 Title Color
					'ashade-404-color-title' => array (
						'type' => 'color',
						'default' => '#ffffff',
						'label' => esc_attr__( '404 Title Color', 'ashade' ),
						'condition' => array (
							'ashade-404-custom-colors' => true
						)
					),
					# 404 Content Text Color
					'ashade-404-color-text' => array (
						'type' => 'color',
						'default' => '#c0c0c0',
						'label' => esc_attr__( 'Content Text Color', 'ashade' ),
						'condition' => array (
							'ashade-404-custom-colors' => true
						)
					),
				
				# SECTION: Maintenance Mode
				'ashade-maintenance-section' => array (
					'type' => 'section',
					'single' => true,
					'title' => esc_html__( 'Maintenance Mode', 'ashade' ),
					'priority' => 147,
				),
					# Maintenance Mode State
					'ashade-maintenance-mode' => array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_html__( 'Maintenance Mode', 'ashade' ),
						'description' => esc_html__( 'Turns on or off the maintenance mode on your website.', 'ashade' ),
						'custom_class' => 'shadow-title-switcher'
					),
					# Maintenance Page Background
					'ashade-maintenance-bg' => array (
						'type' => 'image',
						'default' => DEFAULT_NULL_IMAGE,
						'label' => esc_html__( 'Background Image', 'ashade' ),
					),
					# Maintenance Background Opacity
					'ashade-maintenance-opacity' => array(
						'type' => 'number',
						'default' => '13',
						'label' => esc_html__( 'Background Opacity, %', 'ashade' ),
						'options' => array(
							'style' => 'slider',
							'min' => 0,
							'max' => 100
						),
					),
					# Maintenance Date
					'ashade-maintenance-page-date' => array (
						'type' => 'date',
						'default' => '',
						'label' => esc_html__( 'Countdown Date', 'ashade' ),
						'description' => esc_html__( 'Shows countdown timer to selected date.', 'ashade' ),
						'condition' => array(
							'ashade-maintenance-mode' => true
						)
					),
					# Maintenance Countdown Labels
					'ashade-maintenance-labels' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_html__( 'Countdown Labels', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
						'condition' => array(
							'ashade-maintenance-mode' => true
						)
					),
					# --- Divider ---
					'divider-maintenance-contacts' => array (
						'type' => 'divider',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
					),
					# Maintenance Contact Widget
					'ashade-maintenance-contact-widget' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_html__( 'Show Contact Info', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Maintenance Contact Overhead
					'ashade-maintenance-contact-widget-overhead' => array (
						'type' => 'text',
						'default' => esc_html__( 'My Contacts and Socials', 'ashade' ),
						'label' => esc_html__( 'Contact List Overhead', 'ashade' ),
					),
					# Maintenance Contact Title
					'ashade-maintenance-contact-widget-title' => array (
						'type' => 'text',
						'default' => esc_html__( 'How to Find Me', 'ashade' ),
						'label' => esc_html__( 'Contact List Title', 'ashade' ),
					),
					# Maintenance Contact Widget Icons
					'ashade-maintenance-contact-widget-icons' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_html__( 'Show List Icons?', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Maintenance Contact: Address
					'ashade-maintenance-contact-widget-location' => array (
						'type' => 'text',
						'default' => '',
						'label' => esc_html__( 'Your Address', 'ashade' ),
					),
					# Maintenance Contact: Phone
					'ashade-maintenance-contact-widget-phone' => array (
						'type' => 'text',
						'default' => '',
						'label' => esc_html__( 'Your Phone', 'ashade' ),
					),
					# Maintenance Contact: Email
					'ashade-maintenance-contact-widget-email' => array (
						'type' => 'text',
						'default' => '',
						'label' => esc_html__( 'Your Email', 'ashade' ),
					),
					# Maintenance Contact: Socials
					'ashade-maintenance-contact-widget-socials' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_html__( 'Show Socials?', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# --- Divider ---
					'divider-maintenance-form' => array (
						'type' => 'divider',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						),
					),
					# Maintenance Contact Form State
					'ashade-maintenance-contact-form' => array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_html__( 'Enable Contact Form?', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					),
					# Maintenance Contact Form: Link Overhead
					'ashade-maintenance-contact-form-overhead' => array (
						'type' => 'text',
						'default' => esc_html__('Write Me Some', 'ashade'),
						'label' => esc_html__( 'Link Overhead', 'ashade' ),
					),
					# Maintenance Contact Form: Link Title
					'ashade-maintenance-contact-form-title' => array (
						'type' => 'text',
						'default' => esc_html__('Message', 'ashade'),
						'label' => esc_html__( 'Link Title', 'ashade' ),
					),
					# Maintenance Contact Form: Return Overhead
					'ashade-maintenance-contact-form-roverhead' => array (
						'type' => 'text',
						'default' => esc_html__('Close And', 'ashade'),
						'label' => esc_html__( 'Return Link Overhead', 'ashade' ),
					),
					# Maintenance Contact Form: Return Title
					'ashade-maintenance-contact-form-rtitle' => array (
						'type' => 'text',
						'default' => esc_html__('Return', 'ashade'),
						'label' => esc_html__( 'Return Link Title', 'ashade' ),
					),
					# Maintenance Contact Form: Return Title
					'ashade-maintenance-contact-form-shortcode' => array (
						'type' => 'text',
						'default' => '',
						'label' => esc_html__( 'Contact Form Shortcode', 'ashade' ),
						'callback' => 'wp_specialchars_decode'
					),


				# PANEL: Footer Settings
				'ashade-footer-panel' => array (
					'type' => 'panel',
					'title' => esc_attr__( 'Footer Settings', 'ashade' ),
					'priority' => 150,
				),
					# SECTION: Footer General
					'ashade-footer-general-section' => array (
						'type' => 'section',
						'title' => esc_attr__( 'General', 'ashade' ),
					),
						# Footer Padding
						'ashade-footer-padding' => array (
							'type' => 'dimension',
							'default' => '25/50/26/50',
							'label' => esc_attr__( 'Footer Padding, PX', 'ashade' ),
							'locked' => 'no',
						),

						# --- Footer Typography ---
						'ashade-footer-typography-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding2',
							'label' => esc_attr__( 'Typography', 'ashade' ),
						),
						# Footer Font Style
						'ashade-copyright-font' => array(
							'type' => 'select',
							'default' => 'ashade-headings',
							'label' => esc_attr__( 'Use Font Family', 'ashade' ),
							'choices' => $web_fonts_usage
						),	
						# Footer Font Size
						'ashade-copyright-fs' => array(
							'type' => 'number',
							'default' => '12',
							'label' => esc_attr__( 'Font Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							),
						),
						# Footer Line Height
						'ashade-copyright-lh' => array(
							'type' => 'number',
							'default' => '20',
							'label' => esc_attr__( 'Line Height, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
							),
						),
						# Footer Letter Spacing
						'ashade-copyright-ls' => array(
							'type' => 'number',
							'default' => '50',
							'label' => esc_attr__( 'Letter Spacing', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => -100,
								'max' => 100,
								'step' => '1'
							),
						),
						
					# SECTION: Copyright
					'ashade-footer-copyright-section' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Copyright', 'ashade' ),
					),
						# Footer Copyright Text
						'ashade-copyright-text' => array (
							'type' => 'text',
							'default' => '',
							'label' => esc_attr__( 'Copyright Text', 'ashade' ),
							'callback' => 'wp_specialchars_decode'
						),
						# Footer Copyright Position
						'ashade-copyright-pos' => array (
							'type' => 'choose',
							'default' => 'right',
							'label' => esc_attr__( 'Copyright Position', 'ashade' ),
							'custom_class' => 'shadow-same-switch3',
							'options' => array(
								'left' => esc_attr__( 'Left', 'ashade' ),
								'center' => esc_attr__( 'Center', 'ashade' ),
								'right' => esc_attr__( 'Right', 'ashade' ),
							)
						),
						# --- Copyright Typography ---
						'ashade-copyright-typography-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding2',
							'label' => esc_attr__( 'Typography', 'ashade' ),
						),
						# Footer Uppercase
						'ashade-copyright-u' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Uppercase', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Footer Italic
						'ashade-copyright-i' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Italic', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# --- Divider ---
						'divider-copyright-colors' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
						),
						# Copyright Customize Colors
						'ashade-copyright-custom-colors' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Customize Colors?', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# Copyright Default Color
						'ashade-copyright-color-text' => array (
							'type' => 'color',
							'default' => '#808080',
							'label' => esc_attr__( 'Copyright Text Color', 'ashade' ),
							'condition' => array (
								'ashade-copyright-custom-colors' => true,
							)
						),
						# Copyright Link Color
						'ashade-copyright-color-link' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Copyright Link Color', 'ashade' ),
							'condition' => array (
								'ashade-copyright-custom-colors' => true,
							)
						),
						# Copyright Link Hover Color
						'ashade-copyright-color-hlink' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Copyright Link Hover Color', 'ashade' ),
							'condition' => array (
								'ashade-copyright-custom-colors' => true,
							)
						),
					
					# SECTION: Footer Menu
					'ashade-footer-menu-section' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Footer Menu', 'ashade' ),
					),
						# Footer Menu Position
						'ashade-footer-menu-position' => array(
							'type' => 'select',
							'default' => 'none',
							'label' => esc_attr__( 'Footer Menu Position', 'ashade' ),
							'choices' => [
								'none' => esc_attr__( 'None', 'ashade' ),
								'before-copyright' => esc_attr__( 'Before Copyright', 'ashade' ),
								'after-copyright' => esc_attr__( 'After Copyright', 'ashade' ),
								'left' => esc_attr__( 'Left', 'ashade' ),
								'center' => esc_attr__( 'Center', 'ashade' ),
								'right' => esc_attr__( 'Right', 'ashade' ),
							]
						),
						# Footer Menu High Priority
						'ashade-footer-menu-priority' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'High Menu Priority', 'ashade' ),
							'description' => esc_attr__( 'The menu is placed before other items in the shared column if enabled.', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array (
								'ashade-footer-menu-position' => 'left, center, right',
							)
						),
						# Footer Menu Overlay
						'ashade-footer-menu-overlay' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Fading Content on Hover', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# --- Divider ---
						'divider-footer-menu00' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array (
								'ashade-footer-menu-position' => 'before-copyright, after-copyright, left, center, right',
							)
						),
						# Footer Menu Tablet
						'ashade-footer-menu-tablet' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Show on Tablets', 'ashade' ),
							'description' => esc_attr__( 'Large menus on small screens can disrupt the visual design.', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array (
								'ashade-footer-menu-position' => 'before-copyright, after-copyright, left, center, right',
							)
						),
						# Footer Menu Mobile
						'ashade-footer-menu-mobile' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Show on Mobile', 'ashade' ),
							'description' => esc_attr__( 'Large menus on small screens can disrupt the visual design.', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array (
								'ashade-footer-menu-position' => 'before-copyright, after-copyright, left, center, right',
							)
						),
						# Footer Menu Maintenance
						'ashade-footer-menu-maintenance' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Show on Maintenance', 'ashade' ),
							'description' => esc_attr__( 'Show or hide the menu when the maintenance mode is enabled.', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array (
								'ashade-footer-menu-position' => 'before-copyright, after-copyright, left, center, right',
							)
						),
						# --- Divider ---
						'divider-footer-menu01' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array (
								'ashade-footer-menu-position' => 'before-copyright, after-copyright, left, center, right',
							)
						),
						# Footer Uppercase
						'ashade-footer-menu-u' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Font: Uppercase', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# Footer Italic
						'ashade-footer-menu-i' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Font: Italic', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
						),
						# --- Divider ---
						'divider-footer-menu02' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array (
								'ashade-footer-menu-position' => 'left, center, right',
							)
						),
						# Footer Menu Customize Colors
						'ashade-footer-menu-custom-colors' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Customize Colors?', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array (
								'ashade-footer-menu-position' => 'left, center, right',
							)
						),
						# Footer Menu: Link Color
						'ashade-footer-menu-color' => array (
							'type' => 'color',
							'default' => '#808080',
							'label' => esc_attr__( 'Default Color', 'ashade' ),
							'condition' => array (
								'ashade-footer-menu-custom-colors' => true,
								'ashade-footer-menu-position' => 'left, center, right',
							)
						),
						# Footer Menu: Link Hover Color
						'ashade-footer-menu-hcolor' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Hover Color', 'ashade' ),
							'condition' => array (
								'ashade-footer-menu-custom-colors' => true,
								'ashade-footer-menu-position' => 'left, center, right',
							)
						),
						# Footer Menu: Link Active Color
						'ashade-footer-menu-acolor' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Active Color', 'ashade' ),
							'condition' => array (
								'ashade-footer-menu-custom-colors' => true,
								'ashade-footer-menu-position' => 'left, center, right',
							)
						),

					# SECTION: Socials
					'ashade-footer-socials-section' => array (
						'type' => 'section',
						'title' => esc_attr__( 'Socials', 'ashade' ),
					),
						# Footer Socials State
						'ashade-socials-state' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Enable Social Icons?', 'ashade' ),
							'custom_class' => 'shadow-title-switcher'
						),
						# --- Divider ---
						'divider-socials-main' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array (
								'ashade-socials-state' => true,
							)
						),
						# Footer Socials State
						'ashade-socials-target' => array (
							'type' => 'switcher',
							'default' => true,
							'label' => esc_attr__( 'Open in New Tab?', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array (
								'ashade-socials-state' => true,
							)
						),
						# Footer Socials Position
						'ashade-socials-pos' => array (
							'type' => 'choose',
							'default' => 'left',
							'label' => esc_attr__( 'Socials Position', 'ashade' ),
							'custom_class' => 'shadow-same-switch3',
							'options' => array(
								'left' => esc_attr__( 'Left', 'ashade' ),
								'center' => esc_attr__( 'Center', 'ashade' ),
								'right' => esc_attr__( 'Right', 'ashade' ),
							),
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Footer Socials Style
						'ashade-socials-style' => array (
							'type' => 'choose',
							'default' => 'text',
							'label' => esc_attr__( 'Socials Style', 'ashade' ),
							'custom_class' => 'shadow-same-switch2',
							'options' => array(
								'icon' => esc_attr__( 'Icon', 'ashade' ),
								'text' => esc_attr__( 'Text', 'ashade' ),
							),
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Footer Socials Icons Size
						'ashade-socials-size' => array(
							'type' => 'number',
							'default' => '20',
							'label' => esc_attr__( 'Icons Size, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 10,
								'max' => 100,
								'step' => '1'
							),
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'icon'
							)
						),
						# Footer Socials Spacing
						'ashade-socials-spacing' => array(
							'type' => 'number',
							'default' => '40',
							'label' => esc_attr__( 'Space Between Links, PX', 'ashade' ),
							'options' => array(
								'style' => 'slider',
								'min' => 0,
								'max' => 100,
								'step' => '1'
							),
							'condition' => array (
								'ashade-socials-state' => true,
							)
						),

						# --- Copyright Typography ---
						'ashade-socials-typography-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding2',
							'label' => esc_attr__( 'Typography', 'ashade' ),
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# Footer Uppercase
						'ashade-socials-u' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Uppercase', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# Footer Italic
						'ashade-socials-i' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Italic', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# --- Divider ---
						'divider-socials-colors' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array (
								'ashade-socials-state' => true,
							)
						),
						# Copyright Customize Colors
						'ashade-socials-custom-colors' => array (
							'type' => 'switcher',
							'default' => false,
							'label' => esc_attr__( 'Customize Colors?', 'ashade' ),
							'custom_class' => 'shadow-title-switcher',
							'condition' => array (
								'ashade-socials-state' => true,
							)
						),
						# Copyright Link Color
						'ashade-socials-color' => array (
							'type' => 'color',
							'default' => '#808080',
							'label' => esc_attr__( 'Default Color', 'ashade' ),
							'condition' => array (
								'ashade-socials-custom-colors' => true,
								'ashade-socials-state' => true,
							)
						),
						# Copyright Link Hover Color
						'ashade-socials-hcolor' => array (
							'type' => 'color',
							'default' => '#ffffff',
							'label' => esc_attr__( 'Hover Color', 'ashade' ),
							'condition' => array (
								'ashade-socials-custom-colors' => true,
								'ashade-socials-state' => true,
							)
						),
						# --- Social Links ---
						'ashade-footer-socials-title' => array (
							'type' => 'custom_title',
							'custom_class' => 'shadow-title-on-divider shadow-title-padding',
							'label' => esc_attr__( 'Social Links', 'ashade' ),
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Socials: Facebook URL
						'ashade-socials-facebook-url' => array (
							'type' => 'text',
							'default' => '',
							'label' => esc_attr__( 'Facebook URL', 'ashade' ),
							'callback' => 'esc_url',
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Socials: Facebook Label
						'ashade-socials-facebook-label' => array (
							'type' => 'text',
							'default' => 'Fb',
							'label' => esc_attr__( 'Facebook Label', 'ashade' ),
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# --- Divider ---
						'divider-footer-facebook' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array(
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# Socials: Twitter URL
						'ashade-socials-twitter-url' => array (
							'type' => 'text',
							'default' => '',
							'label' => esc_attr__( 'Twitter URL', 'ashade' ),
							'callback' => 'esc_url',
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Socials: Twitter Label
						'ashade-socials-twitter-label' => array (
							'type' => 'text',
							'default' => 'Tw',
							'label' => esc_attr__( 'Twitter Label', 'ashade' ),
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# --- Divider ---
						'divider-footer-twitter' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array(
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# Socials: LinkedIn URL
						'ashade-socials-linkedin-url' => array (
							'type' => 'text',
							'default' => '',
							'label' => esc_attr__( 'LinkedIn URL', 'ashade' ),
							'callback' => 'esc_url',
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Socials: LinkedIn Label
						'ashade-socials-linkedin-label' => array (
							'type' => 'text',
							'default' => 'Li',
							'label' => esc_attr__( 'LinkedIn Label', 'ashade' ),
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# --- Divider ---
						'divider-footer-linkedin' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array(
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# Socials: Instagram URL
						'ashade-socials-instagram-url' => array (
							'type' => 'text',
							'default' => '',
							'label' => esc_attr__( 'Instagram URL', 'ashade' ),
							'callback' => 'esc_url',
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Socials: Instagram Label
						'ashade-socials-instagram-label' => array (
							'type' => 'text',
							'default' => 'In',
							'label' => esc_attr__( 'Instagram Label', 'ashade' ),
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# --- Divider ---
						'divider-footer-instagram' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array(
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# Socials: YouTube URL
						'ashade-socials-youtube-url' => array (
							'type' => 'text',
							'default' => '',
							'label' => esc_attr__( 'YouTube URL', 'ashade' ),
							'callback' => 'esc_url',
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Socials: YouTube Label
						'ashade-socials-youtube-label' => array (
							'type' => 'text',
							'default' => 'Yt',
							'label' => esc_attr__( 'YouTube Label', 'ashade' ),
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# --- Divider ---
						'divider-footer-youtube' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array(
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# Socials: Pinterest URL
						'ashade-socials-pinterest-url' => array (
							'type' => 'text',
							'default' => '',
							'label' => esc_attr__( 'Pinterest URL', 'ashade' ),
							'callback' => 'esc_url',
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Socials: Pinterest Label
						'ashade-socials-pinterest-label' => array (
							'type' => 'text',
							'default' => 'Pn',
							'label' => esc_attr__( 'Pinterest Label', 'ashade' ),
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# --- Divider ---
						'divider-footer-pinterest' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array(
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# Socials: Tumblr URL
						'ashade-socials-tumblr-url' => array (
							'type' => 'text',
							'default' => '',
							'label' => esc_attr__( 'Tumblr URL', 'ashade' ),
							'callback' => 'esc_url',
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Socials: Tumblr Label
						'ashade-socials-tumblr-label' => array (
							'type' => 'text',
							'default' => 'Tm',
							'label' => esc_attr__( 'Tumblr Label', 'ashade' ),
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# --- Divider ---
						'divider-footer-tumblr' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array(
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# Socials: Flickr URL
						'ashade-socials-flickr-url' => array (
							'type' => 'text',
							'default' => '',
							'label' => esc_attr__( 'Flickr URL', 'ashade' ),
							'callback' => 'esc_url',
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Socials: Flickr Label
						'ashade-socials-flickr-label' => array (
							'type' => 'text',
							'default' => 'Fl',
							'label' => esc_attr__( 'Flickr Label', 'ashade' ),
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# --- Divider ---
						'divider-footer-flickr' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array(
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# Socials: VK URL
						'ashade-socials-vk-url' => array (
							'type' => 'text',
							'default' => '',
							'label' => esc_attr__( 'VK URL', 'ashade' ),
							'callback' => 'esc_url',
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Socials: VK Label
						'ashade-socials-vk-label' => array (
							'type' => 'text',
							'default' => 'Vk',
							'label' => esc_attr__( 'VK Label', 'ashade' ),
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# --- Divider ---
						'divider-footer-vk' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array(
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# Socials: Dribble URL
						'ashade-socials-dribbble-url' => array (
							'type' => 'text',
							'default' => '',
							'label' => esc_attr__( 'Dribble URL', 'ashade' ),
							'callback' => 'esc_url',
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Socials: Dribble Label
						'ashade-socials-dribbble-label' => array (
							'type' => 'text',
							'default' => 'Dr',
							'label' => esc_attr__( 'Dribble Label', 'ashade' ),
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# --- Divider ---
						'divider-footer-dribbble' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array(
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# Socials: Vimeo URL
						'ashade-socials-vimeo-url' => array (
							'type' => 'text',
							'default' => '',
							'label' => esc_attr__( 'Vimeo URL', 'ashade' ),
							'callback' => 'esc_url',
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Socials: Vimeo Label
						'ashade-socials-vimeo-label' => array (
							'type' => 'text',
							'default' => 'Vm',
							'label' => esc_attr__( 'Vimeo Label', 'ashade' ),
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# --- Divider ---
						'divider-footer-vimeo' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array(
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# Socials: 500px URL
						'ashade-socials-500px-url' => array (
							'type' => 'text',
							'default' => '',
							'label' => esc_attr__( '500px URL', 'ashade' ),
							'callback' => 'esc_url',
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Socials: 500px Label
						'ashade-socials-500px-label' => array (
							'type' => 'text',
							'default' => 'Px',
							'label' => esc_attr__( '500px Label', 'ashade' ),
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# --- Divider ---
						'divider-footer-500px' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array(
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# Socials: Xing URL
						'ashade-socials-xing-url' => array (
							'type' => 'text',
							'default' => '',
							'label' => esc_attr__( 'Xing URL', 'ashade' ),
							'callback' => 'esc_url',
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Socials: Xing Label
						'ashade-socials-xing-label' => array (
							'type' => 'text',
							'default' => 'Xn',
							'label' => esc_attr__( 'Xing Label', 'ashade' ),
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# --- Divider ---
						'divider-footer-xing' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array(
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# Socials: Patreon URL
						'ashade-socials-patreon-url' => array (
							'type' => 'text',
							'default' => '',
							'label' => esc_attr__( 'Patreon URL', 'ashade' ),
							'callback' => 'esc_url',
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Socials: Patreon Label
						'ashade-socials-patreon-label' => array (
							'type' => 'text',
							'default' => 'Pt',
							'label' => esc_attr__( 'Patreon Label', 'ashade' ),
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# --- Divider ---
						'divider-footer-patreon' => array (
							'type' => 'divider',
							'default' => '',
							'options' => array(
								'margin-top' => 10,
								'margin-bottom' => 5,
							),
							'condition' => array(
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
						# Socials: TikTok URL
						'ashade-socials-tiktok-url' => array (
							'type' => 'text',
							'default' => '',
							'label' => esc_attr__( 'TikTok URL', 'ashade' ),
							'callback' => 'esc_url',
							'condition' => array (
								'ashade-socials-state' => true
							)
						),
						# Socials: TikTok Label
						'ashade-socials-tiktok-label' => array (
							'type' => 'text',
							'default' => 'Tk',
							'label' => esc_attr__( 'TikTok Label', 'ashade' ),
							'condition' => array (
								'ashade-socials-state' => true,
								'ashade-socials-style' => 'text'
							)
						),
			);

			if ( class_exists( 'WooCommerce' ) ) {
				# SECTION: WooCommerce General
				self::$customizer['ashade-wc-general-section'] = array (
					'type' => 'section',
					'title' => esc_attr__( 'Ashade: Store General', 'ashade' ),
					'priority' => 210,
					'single' => 'is-woo'
				);
					# Shoping Cart in Header
					self::$customizer['ashade-wc-header-cart'] = array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Show Cart in Header', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					);
					# --- Divider ---
					self::$customizer['divider-wc-general01'] = array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						)
					);
					# Sale Labels
					self::$customizer['ashade-wc-sale-label'] = array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Show Sale Labels', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					);
					# Sold Out Labels
					self::$customizer['ashade-wc-sold-label'] = array (
						'type' => 'switcher',
						'default' => false,
						'label' => esc_attr__( 'Show Sold Out Labels', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					);
					# --- Divider ---
					self::$customizer['divider-wc-general02'] = array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						)
					);
					# Cross-Sells Columns
					self::$customizer['ashade-wc-cross-columns'] = array (
						'type' => 'choose',
						'default' => '3',
						'label' => esc_attr__( 'Cross-sells Columns', 'ashade' ),
						'custom_class' => 'shadow-same-switch4',
						'options' => array(
							'1' => esc_attr__( '1', 'ashade' ),
							'2' => esc_attr__( '2', 'ashade' ),
							'3' => esc_attr__( '3', 'ashade' ),
							'4' => esc_attr__( '4', 'ashade' ),
						),
						'condition' => array(
							'ashade-wc-related' => true,
						)
					);
				
				# SECTION: WooCommerce Loop
				self::$customizer['ashade-wc-listing-section'] = array (
					'type' => 'section',
					'title' => esc_attr__( 'Ashade: Product Listing', 'ashade' ),
					'priority' => 220,
					'single' => 'is-woo'
				);
					# Sidebar State
					self::$customizer['ashade-wc-sidebar'] = array (
						'type' => 'choose',
						'default' => 'none',
						'label' => esc_attr__( 'Product Listing Sidebar', 'ashade' ),
						'custom_class' => 'shadow-same-switch3',
						'options' => array(
							'left' => esc_attr__( 'Left', 'ashade' ),
							'none' => esc_attr__( 'None', 'ashade' ),
							'right' => esc_attr__( 'Right', 'ashade' ),
						)
					);
					# --- Divider ---
					self::$customizer['divider-wc-loop00'] = array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						)
					);
					# Buttons Type
					self::$customizer['ashade-wc-button-state'] = array (
						'type' => 'choose',
						'default' => 'always',
						'label' => esc_attr__( 'Buttons Type', 'ashade' ),
						'custom_class' => 'shadow-same-switch2',
						'options' => array(
							'always' => esc_attr__( 'Always Show', 'ashade' ),
							'hover' => esc_attr__( 'Show on Hover', 'ashade' ),
						)
					);
					# --- Divider ---
					self::$customizer['divider-wc-loop01'] = array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						)
					);
					# Zoom Button
					self::$customizer['ashade-wc-button-zoom'] = array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Zoom Button', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					);
					# Add to Cart Button
					self::$customizer['ashade-wc-button-add2cart'] = array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Add to Cart Button', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					);
					# --- Divider ---
					self::$customizer['divider-wc-loop02'] = array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						)
					);
					# Buttons Type
					self::$customizer['ashade-wc-titles-size'] = array (
						'type' => 'choose',
						'default' => 'h5',
						'label' => esc_attr__( 'Product Title Size', 'ashade' ),
						'custom_class' => 'shadow-same-switch3',
						'options' => array(
							'h4' => esc_attr__( 'Large', 'ashade' ),
							'h5' => esc_attr__( 'Medium', 'ashade' ),
							'h6' => esc_attr__( 'Small', 'ashade' ),
						)
					);
				
				# SECTION: WooCommerce Single
				self::$customizer['ashade-wc-single-section'] = array (
					'type' => 'section',
					'title' => esc_attr__( 'Ashade: Single Product', 'ashade' ),
					'priority' => 230,
					'single' => 'is-woo'
				);
					# Lightbox State
					self::$customizer['ashade-wc-lightbox'] = array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Product Gallery Lightbox', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					);
					# Gallery Columns
					self::$customizer['ashade-wc-gallery-columns'] = array (
						'type' => 'choose',
						'default' => '3',
						'label' => esc_attr__( 'Product Gallery Columns', 'ashade' ),
						'custom_class' => 'shadow-same-switch4',
						'options' => array(
							'1' => esc_attr__( '1', 'ashade' ),
							'2' => esc_attr__( '2', 'ashade' ),
							'3' => esc_attr__( '3', 'ashade' ),
							'4' => esc_attr__( '4', 'ashade' ),
						)
					);
					# --- Divider ---
					self::$customizer['divider-wc-single01'] = array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						)
					);
					# Navigation
					self::$customizer['ashade-wc-nav'] = array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Product Navigation', 'ashade' ),
						'description' => esc_attr__( 'Shows "Return to Shop" and "Proceed to Cart" buttons.', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					);
					# --- Divider ---
					self::$customizer['divider-wc-single02'] = array (
						'type' => 'divider',
						'default' => '',
						'options' => array(
							'margin-top' => 10,
							'margin-bottom' => 5,
						)
					);
					# Related Products
					self::$customizer['ashade-wc-related'] = array (
						'type' => 'switcher',
						'default' => true,
						'label' => esc_attr__( 'Show Related Products', 'ashade' ),
						'custom_class' => 'shadow-title-switcher',
					);
					# Related Products Columns
					self::$customizer['ashade-wc-related-columns'] = array (
						'type' => 'choose',
						'default' => '3',
						'label' => esc_attr__( 'Related Products Columns', 'ashade' ),
						'custom_class' => 'shadow-same-switch4',
						'options' => array(
							'1' => esc_attr__( '1', 'ashade' ),
							'2' => esc_attr__( '2', 'ashade' ),
							'3' => esc_attr__( '3', 'ashade' ),
							'4' => esc_attr__( '4', 'ashade' ),
						),
						'condition' => array(
							'ashade-wc-related' => true,
						)
					);
			}
			
			add_action( 'customize_register', [ $this, 'create_customizer'] );
		}
		public static function get_default( $id ) {
			if ( !isset( self::$customizer[$id]['default'] ) ) {
				die( esc_attr__( 'Get Default Error: Default value not specified for ', 'ashade' ) . $id );
			} else {
				return self::$customizer[$id]['default'];
			}
		}
		public static function get_mod( $id ) {
			$default = self::get_default( $id );
			return get_theme_mod( $id, $default );
		}
		public static function get_rwmb( $id, $default = null ) {
			if ( class_exists('RWMB_Loader') ) {
				if ( null == rwmb_meta( $id ) ) {
					return $default;
				} else {
					return rwmb_meta( $id );
				}
			} else {
				return $default;
			}
		}
		public static function get_prefer( $id ) {
			$rwmb = self::get_rwmb( $id );
			if ( is_null( $rwmb ) || $rwmb == 'default' )  {
				return self::get_mod( $id );
			} else {
				return $rwmb;
			}
		}
		public static function create_customizer( $wp_customize ) {
			if ( class_exists( 'Shadow_Customizer' ) ) {
				$shadow_customize = new Shadow_Customizer;
			}

			# Begin Create Customizer Options
			if ( is_array( self::$customizer ) ) {
				$current_panel = '';
				$current_section = '';
				foreach( self::$customizer as $id => $item ) {
					if ( $item['type'] == 'panel' ) {
						# Add Panel
						$current_panel = $id;

						$panel_args = array(
							'title' => $item['title'],
						);
						if ( !empty( $item['priority'] ) ) 
							$panel_args['priority'] = $item['priority'];

						$wp_customize->add_panel( $id, $panel_args );
					} else if ( $item['type'] == 'section' ) {
						# Add Section
						if ( empty( $current_panel ) && empty( $item['single'] ) )
							wp_die( esc_attr__( 'Ashade Core Error: Attempt to add not a single section outside of Panel. Section ID is: ', 'ashade' ) . $id );
						$current_section = $id;

						$section_args = array(
							'name' => $id,
							'title' => $item['title'],
						);
						if ( ! empty( $item['single'] ) && 'is-woo' === $item['single'] ) 
							$section_args['panel'] = 'woocommerce';
						if ( ! empty( $item['description'] ) ) 
							$section_args['description'] = $item['description'];
						if ( empty( $item['single'] ) ) 
							$section_args['panel'] = $current_panel;
						if ( ! empty( $item['priority'] ) ) 
							$section_args['priority'] = $item['priority'];

						$wp_customize->add_section( $id, $section_args );
					} else {
						# Add Setting
						if ( $item['type'] !== 'divider' && $item['type'] !== 'custom_title' ) {
							if ( !array_key_exists( 'default', $item ) )
								wp_die( esc_attr__( 'Ashade Core Error: Default value not specified for: ', 'ashade' ) . $id );
						} else {
							$item['default'] = '';
						}
						if ( empty( $item['callback'] ) ) {
							$callback = 'esc_attr';
						} else {
							$callback = $item['callback'];
						}

						$wp_customize->add_setting( $id, array(
							'default' => $item['default'],
							'capability' => (!empty($item['capability']) ? $item['capability'] : 'edit_theme_options'),
							'transport' => (!empty($item['transport']) ? $item['transport'] : 'refresh'),
							'sanitize_callback' => $callback
						));

						# Add Control
						if ( $current_section == null )
							wp_die( esc_attr__( 'Ashade Core Error: Attempt to add option outside of Section. Option ID: ', 'ashade' ) . $id );

						if ( class_exists( 'Shadow_Customizer' ) ) {
							# Use Shadow Customizer
							$shadow_customize->add_field( $wp_customize, $id, $item, $current_section );
	
						} else if ( $item['type'] !== 'divider' && $item['type'] !== 'custom_title' ) {
							# Use Default Customizer
							$item_args = array(
								'type' => $item['type'],
								'section' => $current_section,
								'settings' => $id
							);
							$item['type'];

							switch( $item[ 'type' ] ) {
								case 'switcher':
									$item_args[ 'type' ] = 'checkbox';
									break;
								case 'dimension':
									$item_args[ 'type' ] = 'text';
									break;
								case 'choose':
									$item_args[ 'type' ] = 'radio';
									if ( isset( $item[ 'style' ] ) && 'image' == $item[ 'style' ] ) {
										foreach ($item[ 'options' ] as $key => $value) {
											$item_args[ 'choices' ][ $key ] = $value[ 'title' ];
										}
									} else {
										$item_args[ 'choices' ] = $item['options'];
									}
									break;
							}

							if ( !empty( $item['label'] ) )
								$item_args['label'] = $item['label'];
							if ( !empty( $item['description'] ) )
								$item_args['description'] = $item['description'];
							if ( !empty( $item['active_callback'] ) )
								$item_args['active_callback'] = $item['active_callback'];
							if ( !empty( $item['choices'] ) )
								$item_args['choices'] = $item['choices'];
							if ( !empty( $item['input_attrs'] ) )
								$item_args['input_attrs'] = $item['input_attrs'];

							if ( $item['type'] == 'color' ) {
								$wp_customize->add_control(new WP_Customize_Color_Control (
									$wp_customize,
									$id,
									$item_args
								) );
							} else if ( $item['type'] == 'upload' ) {
								$wp_customize->add_control(new WP_Customize_Upload_Control (
									$wp_customize,
									$id,
									$item_args
								) );
							} else if ( $item['type'] == 'image' ) {
								$wp_customize->add_control(new WP_Customize_Image_Control (
									$wp_customize,
									$id,
									$item_args
								) );
							} else {
								$wp_customize->add_control(new WP_Customize_Control (
									$wp_customize,
									$id,
									$item_args
								) );
							}
						}
					}
				}
			}
		}
		public static function get_body_class() {
			$this_body_class = array(
				'ashade-body',
				( self::get_mod( 'ashade-protection-rclick' ) ? 'ashade-rcp' : null ),
				( self::get_mod( 'ashade-protection-drag' ) ? 'ashade-idp' : null ),
				( self::get_mod( 'ashade-lazy-loader' ) ? 'shadowcore-lazy--yes' : null ),
				'ashade-loading--' . esc_attr(self::get_mod('ashade-loading-animation')),
				'ashade-unloading--' . esc_attr(self::get_mod('ashade-unloading-animation')),
				'ashade-header--' . esc_attr(self::get_mod('ashade-header-layout')),
				( self::get_mod( 'ashade-smooth-scroll' ) ? 'ashade-smooth-scroll' : null ),
				( self::get_mod( 'ashade-native-touch-scroll' ) ? 'ashade-native-touch-scroll' : null ),
				( self::get_mod( 'ashade-header-sticky' ) ? 'ashade-header-sticky' : 'ashade-header-scrollable' ),
				( self::get_mod( 'ashade-header-sticky-hide' ) ? 'ashade-header-hos' : '' ),
				( self::get_mod( 'ashade-overlay-closes' ) ? 'pswp-close-by-overlay' : null ),
				( self::get_mod( 'ashade-lightbox-zoom' ) ? 'pswp-click-to-zoom' : null ),
			);
			if ( is_home() ) {
				# Default Blog Listing
				if ( self::get_mod('ashade-spotlight') )
					array_push( $this_body_class, 'has-spotlight' );
				if ( self::get_mod('ashade-listing-cu') )
					array_push( $this_body_class, 'no-header-padding' );
				if ( self::get_mod('ashade-listing-pt') == false)
					array_push( $this_body_class, 'no-top-padding' );
				if ( self::get_mod('ashade-listing-pb') == false )
					array_push( $this_body_class, 'no-bottom-padding' );
				array_push( $this_body_class, 'ashade-sidebar--' . esc_attr( self::get_mod( 'ashade-listing-sidebar' ) ) );
				array_push( $this_body_class, 'ashade-layout--' . esc_attr( self::get_mod( 'ashade-title-layout' ) ) );

			} else if ( is_single() ) {
				# Single Post Listing
				if ( self::get_prefer('ashade-spotlight') )
					array_push($this_body_class, 'has-spotlight');
				if ( 'ashade-albums' == get_post_type() ) {
					# Albums Post Type
					if ( self::get_prefer( 'ashade-albums-cu' ) )
						array_push( $this_body_class, 'no-header-padding' );
					if ( self::get_prefer( 'ashade-albums-pt' ) == false )
						array_push( $this_body_class, 'no-top-padding' );
					if ( self::get_prefer( 'ashade-albums-pb') == false )
						array_push( $this_body_class, 'no-bottom-padding' );
					array_push( $this_body_class, 'ashade-sidebar--none' );

					$album_type = self::get_prefer( 'ashade-albums-type' );
					if ( 'ribbon' == $album_type && 'vertical' == self::get_prefer( 'ashade-albums-ribbon-layout' ) ) {
						array_push( $this_body_class, 'ashade-layout--vertical' );
					} else {
						array_push( $this_body_class, 'ashade-layout--' . esc_attr( self::get_prefer( 'ashade-title-layout' ) ) );
					}
					if ( self::get_mod( 'ashade-albums-back-state' ) ) {
						array_push( $this_body_class, 'ashade-albums-back' );
					}
					array_push( $this_body_class, 'ashade-albums-template' );
					array_push( $this_body_class, 'ashade-albums-template ashade-albums-template--' . esc_attr( self::get_prefer( 'ashade-albums-type' ) ) );
				} else if ( 'ashade-clients' == get_post_type() ) {
					# Client Post Type
					if ( self::get_prefer('ashade-client-cu') )
						array_push( $this_body_class, 'no-header-padding' );
					if ( self::get_prefer('ashade-client-pt') == false )
						array_push( $this_body_class, 'no-top-padding' );
					if ( self::get_prefer('ashade-client-pb') == false )
						array_push( $this_body_class, 'no-bottom-padding' );
					array_push( $this_body_class, 'ashade-sidebar--none' );
					array_push( $this_body_class, 'ashade-layout--' . esc_attr( self::get_prefer( 'ashade-title-layout' ) ) );
				} else {
					# All Other Post Types
					if ( self::get_prefer( 'ashade-post-cu' ) )
						array_push( $this_body_class, 'no-header-padding' );
					if ( self::get_prefer( 'ashade-post-pt' ) == false )
						array_push( $this_body_class, 'no-top-padding' );
					if ( self::get_prefer( 'ashade-post-pb' ) == false )
						array_push( $this_body_class, 'no-bottom-padding' );
					array_push( $this_body_class, 'ashade-sidebar--' . esc_attr( self::get_prefer( 'ashade-sidebar-position' ) ) );
					array_push( $this_body_class, 'ashade-layout--' . esc_attr( self::get_prefer( 'ashade-title-layout' ) ) );
				}
			} else if ( is_page() ) {
				# Page
				if ( is_page_template( 'page-home.php' ) ) {
					if ( self::get_rwmb( 'ashade-spotlight-home', 'default' ) !== 'default' ) {
						if ( self::get_rwmb( 'ashade-spotlight-home' ) )
							array_push( $this_body_class, 'has-spotlight' );
					} else {
						if ( self::get_mod( 'ashade-spotlight' ) )
							array_push( $this_body_class, 'has-spotlight' );
					}
				} else if ( is_page_template( 'page-maintenance.php' ) ) {
					if ( self::get_rwmb( 'ashade-spotlight-maintenance', 'default' ) !== 'default' ) {
						if ( self::get_rwmb( 'ashade-spotlight-maintenance' ) )
							array_push( $this_body_class, 'has-spotlight' );
					} else {
						if ( self::get_mod( 'ashade-spotlight' ) )
							array_push( $this_body_class, 'has-spotlight' );
					}
				} else if ( is_page_template( 'page-albums.php' ) ) {
					if ( self::get_rwmb( 'ashade-al-spotlight', 'default' ) !== 'default' ) {
						if ( self::get_rwmb( 'ashade-al-spotlight' ) )
							array_push( $this_body_class, 'has-spotlight' );
					} else {
						if ( self::get_mod( 'ashade-spotlight' ) )
							array_push( $this_body_class, 'has-spotlight' );
					}
			 	} else {
					if ( self::get_prefer( 'ashade-spotlight' ) )
						array_push( $this_body_class, 'has-spotlight' );
				}

				if ( is_page_template( 'page-albums.php' ) ) {
					# Album Listing: CU
					if ( self::get_rwmb( 'ashade-al-cu', 'default' ) !== 'default' ) {
						if ( self::get_rwmb( 'ashade-al-cu' ) )
							array_push( $this_body_class, 'no-header-padding' );
					} else {
						if ( self::get_prefer( 'ashade-page-cu' ) )
							array_push( $this_body_class, 'no-header-padding' );
					}

					# Album Listing: PT
					if ( self::get_rwmb( 'ashade-al-pt', 'default' ) !== 'default' ) {
						if ( self::get_rwmb( 'ashade-al-pt' ) == false )
							array_push( $this_body_class, 'no-top-padding' );
					} else {
						if ( self::get_prefer( 'ashade-page-pt' ) == false )
							array_push( $this_body_class, 'no-top-padding' );
					}
					
					# Album Listing: PB
					if ( self::get_rwmb( 'ashade-al-pt', 'default' ) !== 'default' ) {
						if ( self::get_rwmb( 'ashade-al-pb' ) == false )
							array_push( $this_body_class, 'no-bottom-padding' );
					} else {
						if ( self::get_prefer( 'ashade-page-pb' ) == false )
							array_push( $this_body_class, 'no-bottom-padding' );
					}

					
				} else {
					if ( self::get_prefer( 'ashade-page-cu' ) )
						array_push( $this_body_class, 'no-header-padding' );
					if ( self::get_prefer( 'ashade-page-pt' ) == false )
						array_push( $this_body_class, 'no-top-padding' );
					if ( self::get_prefer( 'ashade-page-pb' ) == false )
						array_push( $this_body_class, 'no-bottom-padding' );
				}

				if ( is_page_template( 'page-home.php' ) ) {
					# Home Template
					array_push( $this_body_class, 'ashade-home-template' );
					array_push( $this_body_class, 'ashade-layout--vertical' );
				} else if ( is_page_template( 'page-maintenance.php' ) ) {
					# Maintenance Template
					$key = array_search( 'ashade-smooth-scroll', $this_body_class );
					if (false !== $key) {
						unset( $this_body_class[$key] );
					}
					array_push( $this_body_class, 'is-centered' );
					array_push( $this_body_class, 'ashade-maintenance-wrap' );
					array_push( $this_body_class, 'ashade-layout--vertical' );
					if ( self::get_rwmb( 'ashade-maintenance-menu' ) == false ) {
						array_push( $this_body_class, 'ashade-hide-menu' );
					}
				} else if ( is_page_template( 'page-albums.php' ) ) {
					# Albums Listing Template
					$al_type = Ashade_Core::get_rwmb( 'ashade-al-type' );
					$al_layout = Ashade_Core::get_rwmb( 'ashade-al-title-layout', 'default' );
					if ( 'ribbon' == $al_type || 'slider' == $al_type ) {
						array_push( $this_body_class, 'ashade-layout--vertical' );
					} else {
						if ( $al_layout == 'default' ) {
							array_push( $this_body_class, 'ashade-layout--' . esc_attr( self::get_mod( 'ashade-title-layout' ) ) );
						} else {
							array_push( $this_body_class, 'ashade-layout--' . esc_attr( $al_layout ) );
						}
						
					}
					array_push( $this_body_class, 'ashade-albums-template' );
					array_push( $this_body_class, 'ashade-albums-template--' . esc_attr( $al_type ) );
				} else {
					array_push( $this_body_class, 'ashade-sidebar--' . esc_attr( self::get_prefer( 'ashade-sidebar-position' ) ) );
					array_push( $this_body_class, 'ashade-layout--' . esc_attr( self::get_prefer( 'ashade-title-layout' ) ) );
				}
			} else if ( is_attachment() ) {
				# Attachment
				if ( self::get_mod('ashade-spotlight') )
					array_push( $this_body_class, 'has-spotlight' );
					array_push( $this_body_class, 'ashade-layout--' . esc_attr( self::get_mod( 'ashade-title-layout' ) ) );
			} else {
				# All others (archives, search, etc.)
				if ( self::get_mod( 'ashade-spotlight' ) )
					array_push( $this_body_class, 'has-spotlight' );
				if ( self::get_mod( 'ashade-listing-cu' ) )
					array_push( $this_body_class, 'no-header-padding');
				if ( self::get_mod( 'ashade-listing-pt' ) == false )
					array_push( $this_body_class, 'no-top-padding' );
				if ( self::get_mod( 'ashade-listing-pb' ) == false )
					array_push( $this_body_class, 'no-bottom-padding' );
				array_push( $this_body_class, 'ashade-sidebar--' . esc_attr( self::get_mod( 'ashade-listing-sidebar' ) ) );
				array_push( $this_body_class, 'ashade-layout--' . esc_attr( self::get_mod( 'ashade-title-layout' ) ) );
			}

			return $this_body_class;
		}
		public static function get_sidebar_position() {
			$ashade_sidebar = 'none';
			if ( class_exists( 'WooCommerce' ) && is_woocommerce() ) {
				if ( is_shop() ) {
					$ashade_sidebar = esc_attr( self::get_mod( 'ashade-wc-sidebar' ) );
				} else {
					$ashade_sidebar = 'none';
				}
			} else {
				if ( is_home() ) {
					$ashade_sidebar = esc_attr( self::get_mod( 'ashade-listing-sidebar' ) );
					if ( 'def' == $ashade_sidebar ) {
						$ashade_sidebar = esc_attr( self::get_prefer( 'ashade-sidebar-position' ) );
					}
				} else if ( is_single() ) {
					if ( 'ashade-albums' == get_post_type() || 'ashade-clients' == get_post_type() ) {
						$ashade_sidebar = 'none';
					} else {
						$ashade_sidebar = esc_attr( self::get_prefer( 'ashade-sidebar-position' ) );
					}
				} else if ( is_page() ) {
					$ashade_sidebar = esc_attr( self::get_prefer( 'ashade-sidebar-position' ) );
				} else if ( is_attachment() ) {
					$ashade_sidebar = 'none';
				} else {
					$ashade_sidebar = esc_attr( self::get_mod( 'ashade-listing-sidebar' ) );
					if ( 'def' == $ashade_sidebar ) {
						$ashade_sidebar = esc_attr( self::get_prefer( 'ashade-sidebar-position' ) );
					}
				}
			}

			return $ashade_sidebar;
		}
		public static function get_menu_wrap() {
			$menu_wrap  = '<ul id="%1$s" class="%2$s">';
			$menu_wrap .= '%3$s';
			if ( class_exists( 'WooCommerce' ) ) {
				$header_cart = self::get_mod('ashade-wc-header-cart');
				if ( $header_cart ) {
					$menu_wrap .= '
					<li class="ashade-wc-header-cart-wrap">
						<a href="'. wc_get_cart_url() .'" class="ashade-wc-header-cart">
							<span class="ashade-wc-header-cart--counter" data-count="'. WC()->cart->get_cart_contents_count() .'">'. WC()->cart->get_cart_contents_count() .'</span>
						</a>
					</li>';
				}
			}
			if ( self::get_mod('ashade-aside-state') ) {
				if ( self::get_mod('ashade-aside-label-type') ) {
					$menu_wrap .= '
					<li class="ashade-aside-toggler-wrap">
						<a href="#" class="ashade-aside-toggler ashade-aside-toggler--label">
							'. esc_attr( self::get_mod('ashade-aside-label') ) .'
						</a>
					</li>';
				} else {
					$menu_wrap .= '
					<li class="ashade-aside-toggler-wrap">
						<a href="#" class="ashade-aside-toggler ashade-aside-toggler--icon">
							<span class="ashade-aside-toggler__icon01"></span>
							<span class="ashade-aside-toggler__icon02"></span>
							<span class="ashade-aside-toggler__icon03"></span>
						</a>
					</li>';
				}
			}
			$menu_wrap .= '</ul>';

			return $menu_wrap;
		}
		public static function get_settings_page() {
			$support_system = false;
			?>
			<div class="ashade-theme-settings-wrap">
				<h2><?php echo esc_html__( 'Thank you for choosing Ashade Theme', 'ashade' ); ?></h2>
				<p class="about-description"><?php echo esc_html__( 'Here we have assembled some useful links to setup your website with our theme.', 'ashade' ); ?></p>
				<div class="ashade-theme-settings-row">
					<div class="ashade-theme-settings-col">
						<h3><?php echo esc_html__( 'Get Started', 'ashade' ); ?></h3>
						<?php if ( class_exists( 'OCDI_Plugin' ) ) { ?>
							<p><?php echo esc_html__( 'To import theme dummy content press the button below.', 'ashade' ); ?></p>
							<a href="<?php echo esc_url( get_admin_url( null, 'themes.php?page=pt-one-click-demo-import' ) ); ?>" class="ashade-admin-button"><?php echo esc_html__( 'Import Demo Content', 'ashade' ); ?></a>
							<p class="ashade-button-subtext"><?php echo esc_html__( 'You can always do that from', 'ashade' ) . ' <strong>' . esc_html__( 'Appearance', 'ashade' ) . ' -> <a href="' . esc_url( get_admin_url( null, 'themes.php?page=pt-one-click-demo-import' ) ) . '">' . esc_html__( 'Import Demo Data', 'ashade' )  . '</a></strong>'; ?></p>
						<?php } else { ?>
							<p><?php echo esc_html__( 'To import theme dummy content you need to install and activate "One Click Demo Import" plugin.', 'ashade' ); ?></p>
							<a href="<?php echo esc_url( get_admin_url( null, 'themes.php?page=tgmpa-install-plugins' ) ); ?>" class="ashade-admin-button"><?php echo esc_html__( 'Install Plugins', 'ashade' ); ?></a>                            
                        <?php } ?>
					</div><!-- .ashade-theme-settings-col -->
					<div class="ashade-theme-settings-col">
						<h3><?php echo esc_html__( 'Theme Settings', 'ashade' ); ?></h3>
						<p><?php echo esc_html__( 'All theme settings are available in Customizer.', 'ashade' ); ?></p>
                        <a href="<?php echo esc_url( get_admin_url( null, 'customize.php' ) ); ?>" class="ashade-admin-button"><?php echo esc_html__( 'Customize Theme Settings', 'ashade' ); ?></a>
						<p><?php echo esc_html__( 'To reset Theme Settings press the button below. But notice: this action is irreversible. Also will clean Main Menu option, so you will need to choose Main Menu once again.', 'ashade' ); ?></p>
                        <a href="<?php echo esc_js( 'javascript:void(0)' ); ?>" id="ashade-reset-settings" class="ashade-admin-button ashade-reset-button ashade-settings--reset" data-confirm="<?php echo esc_html__( 'Are you sure? This action is irreversible.', 'ashade' ); ?>"><?php echo esc_html__( 'Reset Theme Settings', 'ashade' ); ?></a>

					</div><!-- .ashade-theme-settings-col -->
					<div class="ashade-theme-settings-col">
						<h3><?php echo esc_html__( 'Customer Help', 'ashade' ); ?></h3>
						<p><?php echo esc_html__( 'Read our documentation. It will help you and will answer many questions.', 'ashade' ); ?></p>
						<a href="<?php echo esc_url( 'https://docs.shadow-themes.com/wp/ashade/' ); ?>" class="ashade-admin-button" target="_blank"><?php echo esc_html__( 'Theme Documentation', 'ashade' ); ?></a>
						<?php if ( $support_system ) { ?>
						<p><?php echo esc_html__( 'Still got any questions or find some issues? Please, let us know!', 'ashade' ); ?></p>
						<a href="<?php echo esc_url( 'https://support.shadow-themes.com' ); ?>" class="ashade-admin-button"><?php echo esc_html__( 'Customers Support', 'ashade' ); ?></a>
						<?php } ?>
					</div><!-- .ashade-theme-settings-col -->
				</div><!-- .ashade-theme-settings-row -->
			</div>
			<?php
		}

		public static function get_fimage_url() {
			$fimage_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );
			if ( is_array($fimage_url) ) {
				return $fimage_url[0];
			} else {
				return false;
			}
		}
		public static function get_fimage_thmb_url() {
			$fimage_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' );
			if ( is_array($fimage_url) ) {
				return $fimage_url[0];
			} else {
				return false;
			}
		}
		public static function output_escaped( $data ) {
			return $data;
		}

		public static function the_social_links() {
			$socials_style = self::get_mod( 'ashade-socials-style' );
			$target = self::get_mod( 'ashade-socials-target' ) ? '_blank' : '_self';

			if ( ! empty( self::get_mod( 'ashade-socials-facebook-url' ) ) ) {
				echo '
					<a class="ashade-social--facebook is-'. esc_attr( $socials_style ) .'" href="' . esc_url( self::get_mod( 'ashade-socials-facebook-url' ) ). '" target="' . esc_attr( $target ) . '">';
						if ( 'text' == $socials_style ) {
							echo esc_attr( self::get_mod( 'ashade-socials-facebook-label' ) );
						}
						if ( 'icon' == $socials_style ) {
							echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
								<path id="facebook-square" d="M89.286,32H10.714A10.714,10.714,0,0,0,0,42.714v78.571A10.714,10.714,0,0,0,10.714,132H41.35V98H27.288V82H41.35V69.8c0-13.873,8.259-21.536,20.908-21.536a85.193,85.193,0,0,1,12.393,1.08V62.964h-6.98c-6.877,0-9.022,4.268-9.022,8.645V82H74L71.547,98H58.65v34H89.286A10.714,10.714,0,0,0,100,121.286V42.714A10.714,10.714,0,0,0,89.286,32Z" transform="translate(0 -32)" fill="#fff"/>
							</svg>';
						}
					echo '</a>';
			}
			if ( ! empty( self::get_mod( 'ashade-socials-twitter-url' ) ) ) {
				echo '
					<a class="ashade-social--twitter is-'. esc_attr( $socials_style ) .'" href="' . esc_url( self::get_mod( 'ashade-socials-twitter-url' ) ) . '" target="' . esc_attr( $target ) . '">';
						if ( 'text' == $socials_style ) {
							echo esc_attr( self::get_mod( 'ashade-socials-twitter-label' ) );
						}
						if ( 'icon' == $socials_style ) {
							echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
							<path id="twitter-square" d="M89.286,32H10.714A10.717,10.717,0,0,0,0,42.714v78.571A10.717,10.717,0,0,0,10.714,132H89.286A10.717,10.717,0,0,0,100,121.286V42.714A10.717,10.717,0,0,0,89.286,32ZM78.371,67.446c.045.625.045,1.272.045,1.9C78.415,88.7,63.683,111,36.763,111a41.46,41.46,0,0,1-22.478-6.562,30.842,30.842,0,0,0,3.527.179,29.351,29.351,0,0,0,18.17-6.25A14.659,14.659,0,0,1,22.3,88.205a15.778,15.778,0,0,0,6.607-.268A14.641,14.641,0,0,1,17.188,73.563v-.179a14.63,14.63,0,0,0,6.607,1.853,14.609,14.609,0,0,1-6.518-12.187,14.457,14.457,0,0,1,1.987-7.388A41.568,41.568,0,0,0,49.442,70.973,14.671,14.671,0,0,1,74.42,57.6a28.687,28.687,0,0,0,9.286-3.527,14.6,14.6,0,0,1-6.429,8.058,29.133,29.133,0,0,0,8.438-2.277A30.814,30.814,0,0,1,78.371,67.446Z" transform="translate(0 -32)" fill="#fff"/>
						  </svg>';
						}
					echo '</a>';
			}
			if ( ! empty( self::get_mod( 'ashade-socials-linkedin-url' ) ) ) {
				echo '
					<a class="ashade-social--linkedin is-'. esc_attr( $socials_style ) .'" href="' . esc_url( self::get_mod( 'ashade-socials-linkedin-url' ) ) . '" target="' . esc_attr( $target ) . '">';
						if ( 'text' == $socials_style ) {
							echo esc_attr( self::get_mod( 'ashade-socials-linkedin-label' ) );
						}
						if ( 'icon' == $socials_style ) {
							echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
							<path id="linkedin-square" d="M92.857,32H7.121A7.174,7.174,0,0,0,0,39.21v85.58A7.174,7.174,0,0,0,7.121,132H92.857A7.193,7.193,0,0,0,100,124.79V39.21A7.193,7.193,0,0,0,92.857,32ZM30.223,117.714H15.4V69.991H30.246v47.723ZM22.813,63.473a8.594,8.594,0,1,1,8.594-8.594A8.6,8.6,0,0,1,22.813,63.473Zm62.969,54.241H70.96V94.5c0-5.536-.112-12.656-7.7-12.656-7.723,0-8.906,6.027-8.906,12.254v23.616H39.531V69.991H53.75v6.518h.2c1.987-3.75,6.83-7.7,14.04-7.7,15,0,17.79,9.888,17.79,22.746Z" transform="translate(0 -32)" fill="#fff"/>
						  </svg>';
						}
					echo '</a>';
			}
			if ( ! empty( self::get_mod( 'ashade-socials-youtube-url' ) ) ) {
				echo '
					<a class="ashade-social--youtube is-'. esc_attr( $socials_style ) .'" href="' . esc_url(self::get_mod( 'ashade-socials-youtube-url' ) ) . '" target="' . esc_attr( $target ) . '">';
						if ( 'text' == $socials_style ) {
							echo esc_attr( self::get_mod( 'ashade-socials-youtube-label' ) );
						}
						if ( 'icon' == $socials_style ) {
							echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
							<path id="youtube-square" d="M41.7,69.969l21.25,12.076L41.7,94.121ZM100,42.714v78.571A10.717,10.717,0,0,1,89.286,132H10.714A10.717,10.717,0,0,1,0,121.286V42.714A10.717,10.717,0,0,1,10.714,32H89.286A10.717,10.717,0,0,1,100,42.714ZM90.625,82.067s0-13.3-1.7-19.687a10.189,10.189,0,0,0-7.187-7.232C75.424,53.429,50,53.429,50,53.429s-25.424,0-31.741,1.719a10.189,10.189,0,0,0-7.187,7.232c-1.7,6.362-1.7,19.687-1.7,19.687s0,13.3,1.7,19.688a10.042,10.042,0,0,0,7.187,7.121c6.317,1.7,31.741,1.7,31.741,1.7s25.424,0,31.741-1.719a10.042,10.042,0,0,0,7.188-7.121c1.7-6.362,1.7-19.665,1.7-19.665Z" transform="translate(0 -32)" fill="#fff"/>
						  </svg>';
						}
					echo '</a>';
			}
			if ( ! empty( self::get_mod( 'ashade-socials-instagram-url' ) ) ) {
				echo '
					<a class="ashade-social--instagram is-'. esc_attr( $socials_style ) .'" href="' . esc_url( self::get_mod( 'ashade-socials-instagram-url' ) ) . '" target="' . esc_attr( $target ) . '">';
						if ( 'text' == $socials_style ) {
							echo esc_attr( self::get_mod( 'ashade-socials-instagram-label' ) );
						}
						if ( 'icon' == $socials_style ) {
							echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
							<path id="instagram-square" d="M90-1080H10a10.011,10.011,0,0,1-10-10v-80a10.011,10.011,0,0,1,10-10H90a10.011,10.011,0,0,1,10,10v80A10.011,10.011,0,0,1,90-1080Zm-39.5-87c-6.679,0-12.606.1-15.469.263-7.005.333-11.851,2.2-15.711,6.04-3.835,3.821-5.7,8.667-6.057,15.711-.352,6.216-.352,24.721,0,30.938.333,7.024,2.2,11.869,6.057,15.71s8.7,5.706,15.711,6.057c2.867.163,8.794.264,15.468.264s12.6-.1,15.468-.264c7.024-.333,11.87-2.2,15.711-6.057,3.836-3.835,5.7-8.681,6.057-15.71.352-6.213.352-24.708,0-30.92-.333-7.024-2.2-11.87-6.057-15.711-3.836-3.836-8.682-5.7-15.711-6.057C63.106-1166.9,57.179-1167,50.5-1167Zm6.638,68.273c-1.4,0-2.747-.014-3.937-.026H53.18c-.971-.01-1.889-.019-2.672-.019s-1.709.009-2.614.018c-1.166.011-2.487.024-3.863.024-5.024,0-12.109-.16-15.625-1.547a12.666,12.666,0,0,1-7.128-7.128c-1.679-4.233-1.586-13.379-1.525-19.431.01-.974.019-1.895.019-2.671s-.009-1.662-.018-2.614c-.058-6.075-.146-15.256,1.523-19.489a12.663,12.663,0,0,1,7.128-7.127c3.505-1.391,10.51-1.552,15.474-1.552,1.4,0,2.746.014,3.936.026h.022c.971.01,1.888.019,2.671.019s1.709-.009,2.614-.018c1.166-.011,2.487-.024,3.863-.024,5.024,0,12.11.161,15.627,1.548a12.666,12.666,0,0,1,7.128,7.127c1.679,4.234,1.586,13.38,1.525,19.431-.01.975-.019,1.9-.019,2.672s.009,1.7.019,2.672c.061,6.058.154,15.212-1.525,19.431a12.671,12.671,0,0,1-7.128,7.128C69.106-1098.888,62.1-1098.727,57.138-1098.727Zm-6.63-50.006a19.246,19.246,0,0,0-19.224,19.225,19.246,19.246,0,0,0,19.224,19.225,19.247,19.247,0,0,0,19.225-19.225A19.247,19.247,0,0,0,50.508-1148.733ZM70.52-1154a4.489,4.489,0,0,0-4.484,4.484,4.489,4.489,0,0,0,4.484,4.484A4.489,4.489,0,0,0,75-1149.52,4.489,4.489,0,0,0,70.52-1154ZM50.508-1117.01a12.512,12.512,0,0,1-12.5-12.5,12.513,12.513,0,0,1,12.5-12.5,12.513,12.513,0,0,1,12.5,12.5A12.513,12.513,0,0,1,50.508-1117.01Z" transform="translate(0 1180)" fill="#fff"/>
						  </svg>';
						}
					echo '</a>';
			}
			if ( ! empty( self::get_mod( 'ashade-socials-pinterest-url' ) ) ) {
				echo '
					<a class="ashade-social--pinterest is-'. esc_attr( $socials_style ) .'" href="' . esc_url(self::get_mod( 'ashade-socials-pinterest-url' ) ) . '" target="' . esc_attr( $target ) . '">';
						if ( 'text' == $socials_style ) {
							echo esc_attr( self::get_mod( 'ashade-socials-pinterest-label' ) );
						}
						if ( 'icon' == $socials_style ) {
							echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
							<path id="pinterest-square" d="M100,42.714v78.571A10.717,10.717,0,0,1,89.286,132H34.464c2.188-3.661,5-8.929,6.116-13.237C41.25,116.2,44,105.728,44,105.728c1.786,3.415,7.009,6.295,12.567,6.295C73.1,112.022,85,96.821,85,77.938c0-18.1-14.777-31.652-33.795-31.652C27.545,46.286,15,62.156,15,79.455c0,8.036,4.286,18.036,11.116,21.228,1.049.491,1.585.268,1.83-.737.179-.759,1.116-4.487,1.518-6.205a1.617,1.617,0,0,0-.379-1.562A21.366,21.366,0,0,1,25,79.679c0-12.1,9.152-23.795,24.754-23.795,13.46,0,22.9,9.174,22.9,22.3,0,14.821-7.478,25.089-17.232,25.089-5.379,0-9.4-4.442-8.125-9.911,1.54-6.518,4.531-13.549,4.531-18.259,0-11.83-16.853-10.2-16.853,5.58a20.029,20.029,0,0,0,1.629,8.147C29.6,118.473,28.549,118.853,30,131.821l.491.179H10.714A10.717,10.717,0,0,1,0,121.286V42.714A10.717,10.717,0,0,1,10.714,32H89.286A10.717,10.717,0,0,1,100,42.714Z" transform="translate(0 -32)" fill="#fff"/>
						  </svg>';
						}
					echo '</a>';
			}
			if ( ! empty( self::get_mod( 'ashade-socials-tumblr-url' ) ) ) {
				echo '
					<a class="ashade-social--tumblr is-'. esc_attr( $socials_style ) .'" href="' . esc_url( self::get_mod( 'ashade-socials-tumblr-url' ) ) . '" target="' . esc_attr( $target ) . '">';
						if ( 'text' == $socials_style ) {
							echo esc_attr( self::get_mod( 'ashade-socials-tumblr-label' ) );
						}
						if ( 'icon' == $socials_style ) {
							echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
							<path id="tumblr-square" d="M89.286,32H10.714A10.717,10.717,0,0,0,0,42.714v78.571A10.717,10.717,0,0,0,10.714,132H89.286A10.717,10.717,0,0,0,100,121.286V42.714A10.717,10.717,0,0,0,89.286,32ZM70.915,113.295c-1.9,2.031-6.964,4.42-13.594,4.42-16.853,0-20.513-12.388-20.513-19.621V78H30.179a1.391,1.391,0,0,1-1.384-1.384V67.134A2.354,2.354,0,0,1,30.379,64.9c8.661-3.058,11.362-10.6,11.763-16.339.112-1.54.915-2.277,2.232-2.277h9.888a1.391,1.391,0,0,1,1.384,1.384V63.741H67.232a1.391,1.391,0,0,1,1.384,1.384V76.531a1.391,1.391,0,0,1-1.384,1.384H55.6V96.509c0,4.777,3.3,7.478,9.487,5a2.99,2.99,0,0,1,1.786-.312A1.464,1.464,0,0,1,67.9,102.29l3.08,8.973C71.205,111.978,71.429,112.759,70.915,113.295Z" transform="translate(0 -32)" fill="#fff"/>
						  </svg>';
						}
					echo '</a>';
			}
			if ( ! empty( self::get_mod( 'ashade-socials-flickr-url' ) ) ) {
				echo '
					<a class="ashade-social--flickr is-'. esc_attr( $socials_style ) .'" href="' . esc_url( self::get_mod( 'ashade-socials-flickr-url' ) ) . '" target="' . esc_attr( $target ) . '">';
						if ( 'text' == $socials_style ) {
							echo esc_attr( self::get_mod( 'ashade-socials-flickr-label' ) );
						}
						if ( 'icon' == $socials_style ) {
							echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
							<path id="flickr-square" d="M89.286,32H10.714A10.717,10.717,0,0,0,0,42.714v78.571A10.717,10.717,0,0,0,10.714,132H89.286A10.717,10.717,0,0,0,100,121.286V42.714A10.717,10.717,0,0,0,89.286,32ZM32.254,96.063A14.174,14.174,0,1,1,46.429,81.888,14.166,14.166,0,0,1,32.254,96.063Zm35.491,0A14.174,14.174,0,1,1,81.92,81.888,14.166,14.166,0,0,1,67.746,96.063Z" transform="translate(0 -32)" fill="#fff"/>
						  </svg>';
						}
					echo '</a>';
			}
			if ( ! empty( self::get_mod( 'ashade-socials-vk-url' ) ) ) {
				echo '
					<a class="ashade-social--vk is-'. esc_attr( $socials_style ) .'" href="' . esc_url( self::get_mod( 'ashade-socials-vk-url' ) ) . '" target="' . esc_attr( $target ) . '">';
						if ( 'text' == $socials_style ) {
							echo esc_attr( self::get_mod( 'ashade-socials-vk-label' ) );
						}
						if ( 'icon' == $socials_style ) {
							echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
							<path id="vk-square" d="M90-1080H10a10.011,10.011,0,0,1-10-10v-80a10.011,10.011,0,0,1,10-10H90a10.011,10.011,0,0,1,10,10v80A10.011,10.011,0,0,1,90-1080Zm-31.012-40.812c1.143,0,3.234.55,8.173,5.3,1.659,1.659,2.912,3.052,3.919,4.172,2.4,2.671,3.5,3.889,5.688,3.889h8.2a3.154,3.154,0,0,0,2.636-.977,2.756,2.756,0,0,0,.2-2.5c-1.26-3.925-8.309-11.131-11.32-14.208l-.006-.007c-.7-.712-1.156-1.182-1.247-1.31-1.207-1.553-.872-2.241,0-3.648.088-.082,10.044-14.193,11.056-18.879a2.448,2.448,0,0,0-.146-2.2,2.777,2.777,0,0,0-2.332-.817h-8.2a3.529,3.529,0,0,0-3.564,2.326c-.011.026-1.073,2.6-2.826,5.914a56.969,56.969,0,0,1-7.254,10.863c-1.955,1.955-2.814,2.52-3.829,2.52-.526,0-1.309-.627-1.309-2.354v-16.248c0-2.174-.648-3.021-2.311-3.021H41.626a1.968,1.968,0,0,0-2.089,1.88,3.165,3.165,0,0,0,.978,1.968,9.214,9.214,0,0,1,2.28,6.037v12.085c0,2.663-.489,3.132-1.517,3.132-1.355,0-3.718-2.457-6.321-6.572a76.215,76.215,0,0,1-7.24-15.342c-.768-2.161-1.519-3.189-3.7-3.189h-8.2a3.048,3.048,0,0,0-2.283.7,2.208,2.208,0,0,0-.529,1.622c0,2.419,3.072,13.365,12.963,27.219,6.548,9.4,15.9,15.009,25.02,15.009,5.441,0,5.862-1.322,5.862-3.189,0-1.4-.011-2.6-.02-3.662-.035-3.873-.049-5.476.583-6.113A2.14,2.14,0,0,1,58.988-1120.812Z" transform="translate(0 1180)" fill="#fff"/>
						  </svg>';
						}
					echo '</a>';
			}
			if ( ! empty( self::get_mod( 'ashade-socials-dribbble-url' ) ) ) {
				echo '
					<a class="ashade-social--dribbble is-'. esc_attr( $socials_style ) .'" href="' . esc_url( self::get_mod( 'ashade-socials-dribbble-url' ) ) . '" target="' . esc_attr( $target ) . '">';
						if ( 'text' == $socials_style ) {
							echo esc_attr( self::get_mod( 'ashade-socials-dribbble-label' ) );
						}
						if ( 'icon' == $socials_style ) {
							echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
							<path id="dribbble-square" d="M20.134,75.795a30.6,30.6,0,0,1,16.9-21.362A196.9,196.9,0,0,1,48.348,72.067a113.712,113.712,0,0,1-28.214,3.728ZM70.223,59.232A30.4,30.4,0,0,0,42.857,52.4,164.188,164.188,0,0,1,54.241,70.259C65.089,66.174,69.665,60.013,70.223,59.232ZM31.272,106.107a30.448,30.448,0,0,0,30.647,4.018A125.936,125.936,0,0,0,55.4,87c-12.3,4.2-20.937,12.589-24.129,19.107ZM53.326,81.955c-.759-1.741-1.607-3.46-2.478-5.179a111.7,111.7,0,0,1-31.339,4.33c0,.313-.022.625-.022.938a30.451,30.451,0,0,0,7.835,20.4c4.955-8.46,14.978-17.388,26-20.491Zm7.79,3.638a130.438,130.438,0,0,1,5.915,21.741,30.538,30.538,0,0,0,13.08-20.446A44.509,44.509,0,0,0,61.116,85.594Zm-4.531-10.8c1.071,2.188,1.853,3.973,2.679,5.982a71.1,71.1,0,0,1,21.25.982,30.215,30.215,0,0,0-6.9-19C72.969,63.629,67.857,70.17,56.585,74.79ZM100,42.714v78.571A10.717,10.717,0,0,1,89.286,132H10.714A10.717,10.717,0,0,1,0,121.286V42.714A10.717,10.717,0,0,1,10.714,32H89.286A10.717,10.717,0,0,1,100,42.714ZM85.714,82A35.714,35.714,0,1,0,50,117.714,35.762,35.762,0,0,0,85.714,82Z" transform="translate(0 -32)" fill="#fff"/>
						  </svg>';
						}
					echo '</a>';
			}
			if ( ! empty( self::get_mod( 'ashade-socials-vimeo-url' ) ) ) {
				echo '
					<a class="ashade-social--vimeo is-'. esc_attr( $socials_style ) .'" href="' . esc_url( self::get_mod( 'ashade-socials-vimeo-url' ) ) . '" target="' . esc_attr( $target ) . '">';
						if ( 'text' == $socials_style ) {
							echo esc_attr( self::get_mod( 'ashade-socials-vimeo-label' ) );
						}
						if ( 'icon' == $socials_style ) {
							echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
							<path id="vimeo-square" d="M89.286,32H10.714A10.717,10.717,0,0,0,0,42.714v78.571A10.717,10.717,0,0,0,10.714,132H89.286A10.717,10.717,0,0,0,100,121.286V42.714A10.717,10.717,0,0,0,89.286,32ZM85.67,65.393Q85.2,75.806,71.094,93.942q-14.565,18.917-24.643,18.929c-4.174,0-7.679-3.839-10.558-11.518-5.625-20.6-8.013-32.679-12.656-32.679-.536,0-2.411,1.116-5.6,3.371l-3.348-4.33c8.237-7.232,16.094-15.268,21-15.714q8.337-.8,10.268,11.406c4.576,28.929,6.607,33.3,14.911,20.2,2.991-4.732,4.6-8.3,4.8-10.781.759-7.321-5.714-6.83-10.089-4.955Q60.435,50.627,75.29,51.107c7.344.223,10.8,5,10.379,14.286Z" transform="translate(0 -32)" fill="#fff"/>
						  </svg>';
						}
					echo '</a>';
			}
			if ( ! empty( self::get_mod( 'ashade-socials-500px-url' ) ) ) {
				echo '
					<a class="ashade-social--500px is-'. esc_attr( $socials_style ) .'" href="' . esc_url( self::get_mod( 'ashade-socials-500px-url' ) ) . '" target="' . esc_attr( $target ) . '">';
						if ( 'text' == $socials_style ) {
							echo esc_attr( self::get_mod( 'ashade-socials-500px-label' ) );
						}
						if ( 'icon' == $socials_style ) {
							echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
							<path id="_500px-square" data-name="500px-square" d="M90-1080H10a10.011,10.011,0,0,1-10-10v-80a10.011,10.011,0,0,1,10-10H90a10.011,10.011,0,0,1,10,10v80A10.011,10.011,0,0,1,90-1080Zm-66.308-42.306a3.457,3.457,0,0,0-2.442.871.891.891,0,0,0-.242.726C23.273-1104.344,37.815-1092,54.834-1092a33.7,33.7,0,0,0,24.224-10.256,1.25,1.25,0,0,0,.036-1.38,3.409,3.409,0,0,0-2.494-2,.949.949,0,0,0-.691.276,30.014,30.014,0,0,1-21.3,8.958,29.493,29.493,0,0,1-9.686-1.629,29.081,29.081,0,0,1-8.673-4.784,30.882,30.882,0,0,1-10.851-18.4.923.923,0,0,0-.454-.8A2.368,2.368,0,0,0,23.692-1122.306Zm10.7,2.432a5.11,5.11,0,0,0-1.424.291c-1.025.344-1.518.657-1.7,1.078-.224.516.007,1.2.575,2.436a23.5,23.5,0,0,0,22.373,14.832c12.023,0,24.8-8.547,24.8-24.385,0-15.394-12.631-24.593-24.842-24.593a24.952,24.952,0,0,0-18.179,8.027h-.046v-20.218H69.9c1.263,0,1.263-1.729,1.263-2.3,0-1.525-.425-2.3-1.263-2.3H33.194a1.6,1.6,0,0,0-1.6,1.6v28.417c0,.93,1.172,1.549,2.175,1.8a5.687,5.687,0,0,0,1.2.149,1.958,1.958,0,0,0,1.851-1.065l.009-.013.076-.091a48.313,48.313,0,0,1,3.225-3.636,19.967,19.967,0,0,1,14.224-5.857,19.927,19.927,0,0,1,14.193,5.857,20,20,0,0,1,5.9,14.193,19.876,19.876,0,0,1-5.857,14.148,20.319,20.319,0,0,1-14.287,5.863,19.362,19.362,0,0,1-10.114-2.806c0-3.4-.033-6.17-.062-8.614a71.448,71.448,0,0,1,.244-10.193,9.022,9.022,0,0,1,2.5-5.167,9.762,9.762,0,0,1,7.4-3.346,10.755,10.755,0,0,1,7.153,2.76,9.833,9.833,0,0,1,3.227,7.371,11.178,11.178,0,0,1-.991,5.016,6.96,6.96,0,0,1-2.785,2.98c-2.1,1.245-5.133,1.8-9.824,1.8a.9.9,0,0,0-.254-.037c-.827,0-1.494,1.147-1.7,2.227-.164.851-.076,1.866.663,2.162a16.3,16.3,0,0,0,4.6.675,14.928,14.928,0,0,0,14.952-14.869,14.811,14.811,0,0,0-14.863-14.726c-8.011,0-14.678,6.292-14.863,14.026v14.284h-.046a17.768,17.768,0,0,1-3.7-6.132C35.425-1119.325,35.219-1119.874,34.389-1119.874Zm19.752-2.933h0c.527.519.964.953,1.315,1.3l.022.022c1.624,1.612,1.655,1.643,2.054,1.643a2.67,2.67,0,0,0,1.892-1.463,1.125,1.125,0,0,0-.264-1.306l-2.632-2.633,2.769-2.768a.969.969,0,0,0,.093-1.087,2.636,2.636,0,0,0-2-1.519.757.757,0,0,0-.557.217l-2.722,2.723c-.626-.633-1.108-1.126-1.494-1.523-1.356-1.39-1.409-1.444-1.776-1.444a3.144,3.144,0,0,0-2,1.687.812.812,0,0,0,.112.944l2.768,2.768c-.6.594-1.085,1.067-1.475,1.446-1.412,1.376-1.629,1.588-1.629,1.992a1.846,1.846,0,0,0,.738,1.2c.041.037.074.068.1.093a1.984,1.984,0,0,0,1.292.67h.034c.423,0,.45-.027,1.857-1.453l.008-.008c.387-.393.87-.881,1.493-1.5Zm.661-31.943a28.35,28.35,0,0,1,12.426,2.909,38.106,38.106,0,0,1,7.035,4.506,4.813,4.813,0,0,0,1.282.873,4.2,4.2,0,0,0,2.414-2.217,1.041,1.041,0,0,0-.239-1.251c-8.256-7.883-18.49-9.06-23.856-9.06a32.236,32.236,0,0,0-8.683,1.1c-2.181.633-3.569,1.435-3.712,2.145a4.912,4.912,0,0,0,.975,2.754,1.164,1.164,0,0,0,.865.455,1.044,1.044,0,0,0,.38-.075A31.233,31.233,0,0,1,54.8-1154.751Z" transform="translate(0 1180)" fill="#fff"/>
						  </svg>';
						}
					echo '</a>';
			}
			if ( ! empty( self::get_mod( 'ashade-socials-xing-url' ) ) ) {
				echo '
					<a class="ashade-social--xing is-'. esc_attr( $socials_style ) .'" href="' . esc_url( self::get_mod( 'ashade-socials-xing-url' ) ) . '" target="' . esc_attr( $target ) . '">';
						if ( 'text' == $socials_style ) {
							echo esc_attr( self::get_mod( 'ashade-socials-xing-label' ) );
						}
						if ( 'icon' == $socials_style ) {
							echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
							<path id="xing-square" d="M89.286,32H10.714A10.717,10.717,0,0,0,0,42.714v78.571A10.717,10.717,0,0,0,10.714,132H89.286A10.717,10.717,0,0,0,100,121.286V42.714A10.717,10.717,0,0,0,89.286,32ZM31.339,96.33h-10.4a1.5,1.5,0,0,1-1.339-2.3l11-19.353c.022,0,.022-.022,0-.045L23.594,62.58a1.421,1.421,0,0,1,1.339-2.254h10.4a3.322,3.322,0,0,1,2.879,1.942l7.121,12.344q-.435.77-11.183,19.688c-.781,1.384-1.719,2.031-2.813,2.031Zm49.04-47.79L57.433,88.875v.045l14.621,26.563a1.43,1.43,0,0,1-1.339,2.254h-10.4a3.2,3.2,0,0,1-2.879-1.942L42.7,88.942q.77-1.373,23.08-40.692a3.2,3.2,0,0,1,2.79-1.942H79.04a1.426,1.426,0,0,1,1.339,2.232Z" transform="translate(0 -32)" fill="#fff"/>
						  </svg>';
						}
					echo '</a>';
			}
			if ( ! empty( Ashade_Core::get_mod( 'ashade-socials-patreon-url' ) ) ) {
				echo '
					<a class="ashade-social--patreon is-'. esc_attr( $socials_style ) .'" href="' . esc_url( Ashade_Core::get_mod( 'ashade-socials-patreon-url' ) ) . '" target="' . esc_attr( $target ) . '">';
					if ( 'text' == $socials_style ) {
						echo esc_attr( Ashade_Core::get_mod( 'ashade-socials-patreon-label' ) );
					}
					if ( 'icon' == $socials_style ) {
						echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
						<path d="M2157.287-8038h-78.572A10.726,10.726,0,0,1,2068-8048.714v-78.572a10.644,10.644,0,0,1,3.137-7.576,10.645,10.645,0,0,1,7.577-3.139h78.572A10.725,10.725,0,0,1,2168-8127.286v78.572a10.645,10.645,0,0,1-3.137,7.575A10.641,10.641,0,0,1,2157.287-8038Zm-72.278-80.53v61.081h19.231v-61.081ZM2131-8119a21.89,21.89,0,0,0-8.566,1.728,21.921,21.921,0,0,0-6.991,4.716,21.919,21.919,0,0,0-4.716,6.993A21.886,21.886,0,0,0,2109-8097a21.886,21.886,0,0,0,1.728,8.563,21.919,21.919,0,0,0,4.716,6.993,21.955,21.955,0,0,0,6.991,4.716A21.89,21.89,0,0,0,2131-8075a21.865,21.865,0,0,0,8.562-1.728,21.937,21.937,0,0,0,6.993-4.716,21.919,21.919,0,0,0,4.714-6.993A21.859,21.859,0,0,0,2153-8097a21.86,21.86,0,0,0-1.73-8.564,21.919,21.919,0,0,0-4.714-6.993,21.917,21.917,0,0,0-6.993-4.716A21.865,21.865,0,0,0,2131-8119Zm-40.069,55.624v-49.231h7.385v49.231h-7.385ZM2131-8081a15.9,15.9,0,0,1-11.315-4.687A15.9,15.9,0,0,1,2115-8097a15.9,15.9,0,0,1,4.685-11.315A15.9,15.9,0,0,1,2131-8113a15.9,15.9,0,0,1,11.313,4.685A15.9,15.9,0,0,1,2147-8097a15.9,15.9,0,0,1-4.687,11.313A15.9,15.9,0,0,1,2131-8081Z" transform="translate(-2068 8138)" fill="#fff"/>
					  </svg>';
					}
				echo '</a>
				';
			}
			if ( ! empty( Ashade_Core::get_mod( 'ashade-socials-tiktok-url' ) ) ) {
				echo '
					<a class="ashade-social--tiktok is-'. esc_attr( $socials_style ) .'" href="' . esc_url( Ashade_Core::get_mod( 'ashade-socials-tiktok-url' ) ) . '" target="' . esc_attr( $target ) . '">';
					if ( 'text' == $socials_style ) {
						echo esc_attr( Ashade_Core::get_mod( 'ashade-socials-tiktok-label' ) );
					}
					if ( 'icon' == $socials_style ) {
						echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
						<path d="M89.286,32H10.714A10.717,10.717,0,0,0,0,42.714v78.571A10.717,10.717,0,0,0,10.714,132H89.286A10.717,10.717,0,0,0,100,121.286V42.714A10.717,10.717,0,0,0,89.286,32ZM66.816,69.637s.161,23.283,0,26.078a42.664,42.664,0,0,1-1.616,9.058c-2.073,5.486-4.4,7.908-10.114,11.922s-11.458,3.469-15.117,3.187a25.465,25.465,0,0,1-12.907-5.609,25.531,25.531,0,0,1-7.457-11.263c-1.266-3.865-1.156-11.177.327-15.442s4.186-7.341,7.574-10.379a20.733,20.733,0,0,1,8.423-4.621,43.087,43.087,0,0,1,5.775-.845c1.688-.036,4.43,0,4.43,0V85.6s-5.462-1.506-8.491.414-5.125,4.25-5.765,8.014a11,11,0,0,0,2.779,9.558c2.155,2.052,4.668,3.523,7.046,3.585a12.019,12.019,0,0,0,8.1-2.395c3.02-2.235,3.157-3.925,3.555-6.416s0-54.606,0-54.606H66.816S66.792,51.4,72.427,56.8a20.892,20.892,0,0,0,12.859,5.531V75.516a51.59,51.59,0,0,1-9.909-1.9,41.462,41.462,0,0,1-8.561-3.982Z" transform="translate(0 -32)" fill="#fff"/>
					  </svg>';
					}
				echo '</a>
				';
			}
		}

		public static function get_maintenance_status() {
			$status = false;
			if ( is_404() ) {
				return false;
			} else {
				if ( class_exists( 'WooCommerce' ) && is_woocommerce() ) {
					$status = self::get_mod( 'ashade-maintenance-mode', false );
				} else {
					if ( is_category() || is_search() || is_home() || is_archive() || is_attachment() ) {
						$status  = self::get_mod( 'ashade-maintenance-mode', false );
					} else {
						$status = self::get_prefer( 'ashade-maintenance-mode', 0 );
					}
				}
			}
			return $status;
		}

		public static function get_footer_column( $content ) {
			# Get Menu with High Priority
			if ( in_array('menu', $content ) && self::get_mod('ashade-footer-menu-priority') ) {
				self::get_footer_menu();
			}
			if ( in_array('socials', $content ) ) {
				self::get_footer_socials();
			}
			if ( in_array('copyright', $content ) ) {
				self::get_copyright();
			}
			# Get Menu with Low Priority
			if ( in_array('menu', $content ) && ! self::get_mod('ashade-footer-menu-priority') ) {
				self::get_footer_menu();
			}
		}

		private static function get_footer_menu() {
			$menu_location = get_nav_menu_locations();
			if ( isset( $menu_location[ 'ashade-footer' ] ) && 0 !== $menu_location[ 'ashade-footer' ] ) {
				wp_nav_menu( array(
					'theme_location' => 'ashade-footer', 
					'menu_class' => 'ashade-footer-menu',
					'depth' => '3',
					'container_class' => 'ashade-footer-menu-wrap' . (self::get_mod( 'ashade-footer-menu-tablet' ) ? ' show-on-tablet' : '') . (self::get_mod( 'ashade-footer-menu-mobile' ) ? ' show-on-mobile' : '')
				));
			} else {
				if ( current_user_can( 'manage_options' ) ) {
					echo '<div class="ashade-no-menu">' . esc_html__( 'Footer Menu is not selected. Please create and select menu in ', 'ashade' ) . '<a target="_blank" href="' . esc_url( get_admin_url( null, 'nav-menus.php' ) ) . '">' . esc_html__( 'Appearance -> Menus', 'ashade' ) . '</a>' . '</div>';
				}
			}
		}
		private static function get_copyright() {
				$menu_position = Ashade_Core::get_mod( 'ashade-footer-menu-position' );
				$has_menu = false;
				if ( $menu_position == 'before-copyright' || $menu_position == 'after-copyright' ) {
					$has_menu = true;
				}
				?>
				<div class="ashade-footer__copyright<?php echo esc_attr( $has_menu ? ' has-menu' : ''); ?>">
					<?php
						if ( $menu_position == 'before-copyright' ) {
							self::get_footer_menu();
						}
						if ( strlen( Ashade_Core::get_mod( 'ashade-copyright-text' ) ) ) {
							echo '<div class="ashade-footer__copyright-text">' . wp_specialchars_decode( Ashade_Core::get_mod( 'ashade-copyright-text' ) ) . '</div>'; 
						}
						if ( $menu_position == 'after-copyright') {
							self::get_footer_menu();
						}
					?>
				</div>
        	<?php
		}

		private static function get_footer_socials() {
			$socials_style = Ashade_Core::get_mod( 'ashade-socials-style' );
			?>
			<div class="ashade-footer__socials">
				<ul class="ashade-socials ashade-socials--<?php echo esc_attr( $socials_style ); ?>">
					<?php
						$target = Ashade_Core::get_mod( 'ashade-socials-target' ) ? '_blank' : '_self';
						if ( ! empty( Ashade_Core::get_mod( 'ashade-socials-facebook-url' ) ) ) {
							echo '
							<li>
								<a class="ashade-social--facebook" href="' . esc_url( Ashade_Core::get_mod( 'ashade-socials-facebook-url' ) ). '" target="' . esc_attr( $target ) . '">';
								if ( 'text' == $socials_style ) {
									echo esc_attr( Ashade_Core::get_mod( 'ashade-socials-facebook-label' ) );
								}
								if ( 'icon' == $socials_style ) {
									echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
										<path id="facebook-square" d="M89.286,32H10.714A10.714,10.714,0,0,0,0,42.714v78.571A10.714,10.714,0,0,0,10.714,132H41.35V98H27.288V82H41.35V69.8c0-13.873,8.259-21.536,20.908-21.536a85.193,85.193,0,0,1,12.393,1.08V62.964h-6.98c-6.877,0-9.022,4.268-9.022,8.645V82H74L71.547,98H58.65v34H89.286A10.714,10.714,0,0,0,100,121.286V42.714A10.714,10.714,0,0,0,89.286,32Z" transform="translate(0 -32)" fill="#fff"/>
									</svg>';
								}
							echo '</a>
							</li>
							';
						}
						if ( ! empty( Ashade_Core::get_mod( 'ashade-socials-twitter-url' ) ) ) {
							echo '
							<li>
								<a class="ashade-social--twitter" href="' . esc_url( Ashade_Core::get_mod( 'ashade-socials-twitter-url' ) ) . '" target="' . esc_attr( $target ) . '">';
								if ( 'text' == $socials_style ) {
									echo esc_attr( Ashade_Core::get_mod( 'ashade-socials-twitter-label' ) );
								}
								if ( 'icon' == $socials_style ) {
									echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
									<path id="twitter-square" d="M89.286,32H10.714A10.717,10.717,0,0,0,0,42.714v78.571A10.717,10.717,0,0,0,10.714,132H89.286A10.717,10.717,0,0,0,100,121.286V42.714A10.717,10.717,0,0,0,89.286,32ZM78.371,67.446c.045.625.045,1.272.045,1.9C78.415,88.7,63.683,111,36.763,111a41.46,41.46,0,0,1-22.478-6.562,30.842,30.842,0,0,0,3.527.179,29.351,29.351,0,0,0,18.17-6.25A14.659,14.659,0,0,1,22.3,88.205a15.778,15.778,0,0,0,6.607-.268A14.641,14.641,0,0,1,17.188,73.563v-.179a14.63,14.63,0,0,0,6.607,1.853,14.609,14.609,0,0,1-6.518-12.187,14.457,14.457,0,0,1,1.987-7.388A41.568,41.568,0,0,0,49.442,70.973,14.671,14.671,0,0,1,74.42,57.6a28.687,28.687,0,0,0,9.286-3.527,14.6,14.6,0,0,1-6.429,8.058,29.133,29.133,0,0,0,8.438-2.277A30.814,30.814,0,0,1,78.371,67.446Z" transform="translate(0 -32)" fill="#fff"/>
								</svg>';
								}
							echo '</a>
							</li>
							';
						}
						if ( ! empty( Ashade_Core::get_mod( 'ashade-socials-linkedin-url' ) ) ) {
							echo '
							<li>
								<a class="ashade-social--linkedin" href="' . esc_url( Ashade_Core::get_mod( 'ashade-socials-linkedin-url' ) ) . '" target="' . esc_attr( $target ) . '">';
								if ( 'text' == $socials_style ) {
									echo esc_attr( Ashade_Core::get_mod( 'ashade-socials-linkedin-label' ) );
								}
								if ( 'icon' == $socials_style ) {
									echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
									<path id="linkedin-square" d="M92.857,32H7.121A7.174,7.174,0,0,0,0,39.21v85.58A7.174,7.174,0,0,0,7.121,132H92.857A7.193,7.193,0,0,0,100,124.79V39.21A7.193,7.193,0,0,0,92.857,32ZM30.223,117.714H15.4V69.991H30.246v47.723ZM22.813,63.473a8.594,8.594,0,1,1,8.594-8.594A8.6,8.6,0,0,1,22.813,63.473Zm62.969,54.241H70.96V94.5c0-5.536-.112-12.656-7.7-12.656-7.723,0-8.906,6.027-8.906,12.254v23.616H39.531V69.991H53.75v6.518h.2c1.987-3.75,6.83-7.7,14.04-7.7,15,0,17.79,9.888,17.79,22.746Z" transform="translate(0 -32)" fill="#fff"/>
								</svg>';
								}
							echo '</a>
							</li>
							';
						}
						if ( ! empty( Ashade_Core::get_mod( 'ashade-socials-youtube-url' ) ) ) {
							echo '
							<li>
								<a class="ashade-social--youtube" href="' . esc_url(Ashade_Core::get_mod( 'ashade-socials-youtube-url' ) ) . '" target="' . esc_attr( $target ) . '">';
								if ( 'text' == $socials_style ) {
									echo esc_attr( Ashade_Core::get_mod( 'ashade-socials-youtube-label' ) );
								}
								if ( 'icon' == $socials_style ) {
									echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
									<path id="youtube-square" d="M41.7,69.969l21.25,12.076L41.7,94.121ZM100,42.714v78.571A10.717,10.717,0,0,1,89.286,132H10.714A10.717,10.717,0,0,1,0,121.286V42.714A10.717,10.717,0,0,1,10.714,32H89.286A10.717,10.717,0,0,1,100,42.714ZM90.625,82.067s0-13.3-1.7-19.687a10.189,10.189,0,0,0-7.187-7.232C75.424,53.429,50,53.429,50,53.429s-25.424,0-31.741,1.719a10.189,10.189,0,0,0-7.187,7.232c-1.7,6.362-1.7,19.687-1.7,19.687s0,13.3,1.7,19.688a10.042,10.042,0,0,0,7.187,7.121c6.317,1.7,31.741,1.7,31.741,1.7s25.424,0,31.741-1.719a10.042,10.042,0,0,0,7.188-7.121c1.7-6.362,1.7-19.665,1.7-19.665Z" transform="translate(0 -32)" fill="#fff"/>
								</svg>';
								}
							echo '</a>
							</li>
							';
						}
						if ( ! empty( Ashade_Core::get_mod( 'ashade-socials-instagram-url' ) ) ) {
							echo '
							<li>
								<a class="ashade-social--instagram" href="' . esc_url( Ashade_Core::get_mod( 'ashade-socials-instagram-url' ) ) . '" target="' . esc_attr( $target ) . '">';
								if ( 'text' == $socials_style ) {
									echo esc_attr( Ashade_Core::get_mod( 'ashade-socials-instagram-label' ) );
								}
								if ( 'icon' == $socials_style ) {
									echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
									<path id="instagram-square" d="M90-1080H10a10.011,10.011,0,0,1-10-10v-80a10.011,10.011,0,0,1,10-10H90a10.011,10.011,0,0,1,10,10v80A10.011,10.011,0,0,1,90-1080Zm-39.5-87c-6.679,0-12.606.1-15.469.263-7.005.333-11.851,2.2-15.711,6.04-3.835,3.821-5.7,8.667-6.057,15.711-.352,6.216-.352,24.721,0,30.938.333,7.024,2.2,11.869,6.057,15.71s8.7,5.706,15.711,6.057c2.867.163,8.794.264,15.468.264s12.6-.1,15.468-.264c7.024-.333,11.87-2.2,15.711-6.057,3.836-3.835,5.7-8.681,6.057-15.71.352-6.213.352-24.708,0-30.92-.333-7.024-2.2-11.87-6.057-15.711-3.836-3.836-8.682-5.7-15.711-6.057C63.106-1166.9,57.179-1167,50.5-1167Zm6.638,68.273c-1.4,0-2.747-.014-3.937-.026H53.18c-.971-.01-1.889-.019-2.672-.019s-1.709.009-2.614.018c-1.166.011-2.487.024-3.863.024-5.024,0-12.109-.16-15.625-1.547a12.666,12.666,0,0,1-7.128-7.128c-1.679-4.233-1.586-13.379-1.525-19.431.01-.974.019-1.895.019-2.671s-.009-1.662-.018-2.614c-.058-6.075-.146-15.256,1.523-19.489a12.663,12.663,0,0,1,7.128-7.127c3.505-1.391,10.51-1.552,15.474-1.552,1.4,0,2.746.014,3.936.026h.022c.971.01,1.888.019,2.671.019s1.709-.009,2.614-.018c1.166-.011,2.487-.024,3.863-.024,5.024,0,12.11.161,15.627,1.548a12.666,12.666,0,0,1,7.128,7.127c1.679,4.234,1.586,13.38,1.525,19.431-.01.975-.019,1.9-.019,2.672s.009,1.7.019,2.672c.061,6.058.154,15.212-1.525,19.431a12.671,12.671,0,0,1-7.128,7.128C69.106-1098.888,62.1-1098.727,57.138-1098.727Zm-6.63-50.006a19.246,19.246,0,0,0-19.224,19.225,19.246,19.246,0,0,0,19.224,19.225,19.247,19.247,0,0,0,19.225-19.225A19.247,19.247,0,0,0,50.508-1148.733ZM70.52-1154a4.489,4.489,0,0,0-4.484,4.484,4.489,4.489,0,0,0,4.484,4.484A4.489,4.489,0,0,0,75-1149.52,4.489,4.489,0,0,0,70.52-1154ZM50.508-1117.01a12.512,12.512,0,0,1-12.5-12.5,12.513,12.513,0,0,1,12.5-12.5,12.513,12.513,0,0,1,12.5,12.5A12.513,12.513,0,0,1,50.508-1117.01Z" transform="translate(0 1180)" fill="#fff"/>
								</svg>';
								}
							echo '</a>
							</li>
							';
						}
						if ( ! empty( Ashade_Core::get_mod( 'ashade-socials-pinterest-url' ) ) ) {
							echo '
							<li>
								<a class="ashade-social--pinterest" href="' . esc_url(Ashade_Core::get_mod( 'ashade-socials-pinterest-url' ) ) . '" target="' . esc_attr( $target ) . '">';
								if ( 'text' == $socials_style ) {
									echo esc_attr( Ashade_Core::get_mod( 'ashade-socials-pinterest-label' ) );
								}
								if ( 'icon' == $socials_style ) {
									echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
									<path id="pinterest-square" d="M100,42.714v78.571A10.717,10.717,0,0,1,89.286,132H34.464c2.188-3.661,5-8.929,6.116-13.237C41.25,116.2,44,105.728,44,105.728c1.786,3.415,7.009,6.295,12.567,6.295C73.1,112.022,85,96.821,85,77.938c0-18.1-14.777-31.652-33.795-31.652C27.545,46.286,15,62.156,15,79.455c0,8.036,4.286,18.036,11.116,21.228,1.049.491,1.585.268,1.83-.737.179-.759,1.116-4.487,1.518-6.205a1.617,1.617,0,0,0-.379-1.562A21.366,21.366,0,0,1,25,79.679c0-12.1,9.152-23.795,24.754-23.795,13.46,0,22.9,9.174,22.9,22.3,0,14.821-7.478,25.089-17.232,25.089-5.379,0-9.4-4.442-8.125-9.911,1.54-6.518,4.531-13.549,4.531-18.259,0-11.83-16.853-10.2-16.853,5.58a20.029,20.029,0,0,0,1.629,8.147C29.6,118.473,28.549,118.853,30,131.821l.491.179H10.714A10.717,10.717,0,0,1,0,121.286V42.714A10.717,10.717,0,0,1,10.714,32H89.286A10.717,10.717,0,0,1,100,42.714Z" transform="translate(0 -32)" fill="#fff"/>
								</svg>';
								}
							echo '</a>
							</li>
							';
						}
						if ( ! empty( Ashade_Core::get_mod( 'ashade-socials-tumblr-url' ) ) ) {
							echo '
							<li>
								<a class="ashade-social--tumblr" href="' . esc_url( Ashade_Core::get_mod( 'ashade-socials-tumblr-url' ) ) . '" target="' . esc_attr( $target ) . '">';
								if ( 'text' == $socials_style ) {
									echo esc_attr( Ashade_Core::get_mod( 'ashade-socials-tumblr-label' ) );
								}
								if ( 'icon' == $socials_style ) {
									echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
									<path id="tumblr-square" d="M89.286,32H10.714A10.717,10.717,0,0,0,0,42.714v78.571A10.717,10.717,0,0,0,10.714,132H89.286A10.717,10.717,0,0,0,100,121.286V42.714A10.717,10.717,0,0,0,89.286,32ZM70.915,113.295c-1.9,2.031-6.964,4.42-13.594,4.42-16.853,0-20.513-12.388-20.513-19.621V78H30.179a1.391,1.391,0,0,1-1.384-1.384V67.134A2.354,2.354,0,0,1,30.379,64.9c8.661-3.058,11.362-10.6,11.763-16.339.112-1.54.915-2.277,2.232-2.277h9.888a1.391,1.391,0,0,1,1.384,1.384V63.741H67.232a1.391,1.391,0,0,1,1.384,1.384V76.531a1.391,1.391,0,0,1-1.384,1.384H55.6V96.509c0,4.777,3.3,7.478,9.487,5a2.99,2.99,0,0,1,1.786-.312A1.464,1.464,0,0,1,67.9,102.29l3.08,8.973C71.205,111.978,71.429,112.759,70.915,113.295Z" transform="translate(0 -32)" fill="#fff"/>
								</svg>';
								}
							echo '</a>
							</li>
							';
						}
						if ( ! empty( Ashade_Core::get_mod( 'ashade-socials-flickr-url' ) ) ) {
							echo '
							<li>
								<a class="ashade-social--flickr" href="' . esc_url( Ashade_Core::get_mod( 'ashade-socials-flickr-url' ) ) . '" target="' . esc_attr( $target ) . '">';
								if ( 'text' == $socials_style ) {
									echo esc_attr( Ashade_Core::get_mod( 'ashade-socials-flickr-label' ) );
								}
								if ( 'icon' == $socials_style ) {
									echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
									<path id="flickr-square" d="M89.286,32H10.714A10.717,10.717,0,0,0,0,42.714v78.571A10.717,10.717,0,0,0,10.714,132H89.286A10.717,10.717,0,0,0,100,121.286V42.714A10.717,10.717,0,0,0,89.286,32ZM32.254,96.063A14.174,14.174,0,1,1,46.429,81.888,14.166,14.166,0,0,1,32.254,96.063Zm35.491,0A14.174,14.174,0,1,1,81.92,81.888,14.166,14.166,0,0,1,67.746,96.063Z" transform="translate(0 -32)" fill="#fff"/>
								</svg>';
								}
							echo '</a>
							</li>
							';
						}
						if ( ! empty( Ashade_Core::get_mod( 'ashade-socials-vk-url' ) ) ) {
							echo '
							<li>
								<a class="ashade-social--vk" href="' . esc_url( Ashade_Core::get_mod( 'ashade-socials-vk-url' ) ) . '" target="' . esc_attr( $target ) . '">';
								if ( 'text' == $socials_style ) {
									echo esc_attr( Ashade_Core::get_mod( 'ashade-socials-vk-label' ) );
								}
								if ( 'icon' == $socials_style ) {
									echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
									<path id="vk-square" d="M90-1080H10a10.011,10.011,0,0,1-10-10v-80a10.011,10.011,0,0,1,10-10H90a10.011,10.011,0,0,1,10,10v80A10.011,10.011,0,0,1,90-1080Zm-31.012-40.812c1.143,0,3.234.55,8.173,5.3,1.659,1.659,2.912,3.052,3.919,4.172,2.4,2.671,3.5,3.889,5.688,3.889h8.2a3.154,3.154,0,0,0,2.636-.977,2.756,2.756,0,0,0,.2-2.5c-1.26-3.925-8.309-11.131-11.32-14.208l-.006-.007c-.7-.712-1.156-1.182-1.247-1.31-1.207-1.553-.872-2.241,0-3.648.088-.082,10.044-14.193,11.056-18.879a2.448,2.448,0,0,0-.146-2.2,2.777,2.777,0,0,0-2.332-.817h-8.2a3.529,3.529,0,0,0-3.564,2.326c-.011.026-1.073,2.6-2.826,5.914a56.969,56.969,0,0,1-7.254,10.863c-1.955,1.955-2.814,2.52-3.829,2.52-.526,0-1.309-.627-1.309-2.354v-16.248c0-2.174-.648-3.021-2.311-3.021H41.626a1.968,1.968,0,0,0-2.089,1.88,3.165,3.165,0,0,0,.978,1.968,9.214,9.214,0,0,1,2.28,6.037v12.085c0,2.663-.489,3.132-1.517,3.132-1.355,0-3.718-2.457-6.321-6.572a76.215,76.215,0,0,1-7.24-15.342c-.768-2.161-1.519-3.189-3.7-3.189h-8.2a3.048,3.048,0,0,0-2.283.7,2.208,2.208,0,0,0-.529,1.622c0,2.419,3.072,13.365,12.963,27.219,6.548,9.4,15.9,15.009,25.02,15.009,5.441,0,5.862-1.322,5.862-3.189,0-1.4-.011-2.6-.02-3.662-.035-3.873-.049-5.476.583-6.113A2.14,2.14,0,0,1,58.988-1120.812Z" transform="translate(0 1180)" fill="#fff"/>
								</svg>';
								}
							echo '</a>
							</li>
							';
						}
						if ( ! empty( Ashade_Core::get_mod( 'ashade-socials-dribbble-url' ) ) ) {
							echo '
							<li>
								<a class="ashade-social--dribbble" href="' . esc_url( Ashade_Core::get_mod( 'ashade-socials-dribbble-url' ) ) . '" target="' . esc_attr( $target ) . '">';
								if ( 'text' == $socials_style ) {
									echo esc_attr( Ashade_Core::get_mod( 'ashade-socials-dribbble-label' ) );
								}
								if ( 'icon' == $socials_style ) {
									echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
									<path id="dribbble-square" d="M20.134,75.795a30.6,30.6,0,0,1,16.9-21.362A196.9,196.9,0,0,1,48.348,72.067a113.712,113.712,0,0,1-28.214,3.728ZM70.223,59.232A30.4,30.4,0,0,0,42.857,52.4,164.188,164.188,0,0,1,54.241,70.259C65.089,66.174,69.665,60.013,70.223,59.232ZM31.272,106.107a30.448,30.448,0,0,0,30.647,4.018A125.936,125.936,0,0,0,55.4,87c-12.3,4.2-20.937,12.589-24.129,19.107ZM53.326,81.955c-.759-1.741-1.607-3.46-2.478-5.179a111.7,111.7,0,0,1-31.339,4.33c0,.313-.022.625-.022.938a30.451,30.451,0,0,0,7.835,20.4c4.955-8.46,14.978-17.388,26-20.491Zm7.79,3.638a130.438,130.438,0,0,1,5.915,21.741,30.538,30.538,0,0,0,13.08-20.446A44.509,44.509,0,0,0,61.116,85.594Zm-4.531-10.8c1.071,2.188,1.853,3.973,2.679,5.982a71.1,71.1,0,0,1,21.25.982,30.215,30.215,0,0,0-6.9-19C72.969,63.629,67.857,70.17,56.585,74.79ZM100,42.714v78.571A10.717,10.717,0,0,1,89.286,132H10.714A10.717,10.717,0,0,1,0,121.286V42.714A10.717,10.717,0,0,1,10.714,32H89.286A10.717,10.717,0,0,1,100,42.714ZM85.714,82A35.714,35.714,0,1,0,50,117.714,35.762,35.762,0,0,0,85.714,82Z" transform="translate(0 -32)" fill="#fff"/>
								</svg>';
								}
							echo '</a>
							</li>
							';
						}
						if ( ! empty( Ashade_Core::get_mod( 'ashade-socials-vimeo-url' ) ) ) {
							echo '
							<li>
								<a class="ashade-social--vimeo" href="' . esc_url( Ashade_Core::get_mod( 'ashade-socials-vimeo-url' ) ) . '" target="' . esc_attr( $target ) . '">';
								if ( 'text' == $socials_style ) {
									echo esc_attr( Ashade_Core::get_mod( 'ashade-socials-vimeo-label' ) );
								}
								if ( 'icon' == $socials_style ) {
									echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
									<path id="vimeo-square" d="M89.286,32H10.714A10.717,10.717,0,0,0,0,42.714v78.571A10.717,10.717,0,0,0,10.714,132H89.286A10.717,10.717,0,0,0,100,121.286V42.714A10.717,10.717,0,0,0,89.286,32ZM85.67,65.393Q85.2,75.806,71.094,93.942q-14.565,18.917-24.643,18.929c-4.174,0-7.679-3.839-10.558-11.518-5.625-20.6-8.013-32.679-12.656-32.679-.536,0-2.411,1.116-5.6,3.371l-3.348-4.33c8.237-7.232,16.094-15.268,21-15.714q8.337-.8,10.268,11.406c4.576,28.929,6.607,33.3,14.911,20.2,2.991-4.732,4.6-8.3,4.8-10.781.759-7.321-5.714-6.83-10.089-4.955Q60.435,50.627,75.29,51.107c7.344.223,10.8,5,10.379,14.286Z" transform="translate(0 -32)" fill="#fff"/>
								</svg>';
								}
							echo '</a>
							</li>
							';
						}
						if ( ! empty( Ashade_Core::get_mod( 'ashade-socials-500px-url' ) ) ) {
							echo '
							<li>
								<a class="ashade-social--500px" href="' . esc_url( Ashade_Core::get_mod( 'ashade-socials-500px-url' ) ) . '" target="' . esc_attr( $target ) . '">';
								if ( 'text' == $socials_style ) {
									echo esc_attr( Ashade_Core::get_mod( 'ashade-socials-500px-label' ) );
								}
								if ( 'icon' == $socials_style ) {
									echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
									<path id="_500px-square" data-name="500px-square" d="M90-1080H10a10.011,10.011,0,0,1-10-10v-80a10.011,10.011,0,0,1,10-10H90a10.011,10.011,0,0,1,10,10v80A10.011,10.011,0,0,1,90-1080Zm-66.308-42.306a3.457,3.457,0,0,0-2.442.871.891.891,0,0,0-.242.726C23.273-1104.344,37.815-1092,54.834-1092a33.7,33.7,0,0,0,24.224-10.256,1.25,1.25,0,0,0,.036-1.38,3.409,3.409,0,0,0-2.494-2,.949.949,0,0,0-.691.276,30.014,30.014,0,0,1-21.3,8.958,29.493,29.493,0,0,1-9.686-1.629,29.081,29.081,0,0,1-8.673-4.784,30.882,30.882,0,0,1-10.851-18.4.923.923,0,0,0-.454-.8A2.368,2.368,0,0,0,23.692-1122.306Zm10.7,2.432a5.11,5.11,0,0,0-1.424.291c-1.025.344-1.518.657-1.7,1.078-.224.516.007,1.2.575,2.436a23.5,23.5,0,0,0,22.373,14.832c12.023,0,24.8-8.547,24.8-24.385,0-15.394-12.631-24.593-24.842-24.593a24.952,24.952,0,0,0-18.179,8.027h-.046v-20.218H69.9c1.263,0,1.263-1.729,1.263-2.3,0-1.525-.425-2.3-1.263-2.3H33.194a1.6,1.6,0,0,0-1.6,1.6v28.417c0,.93,1.172,1.549,2.175,1.8a5.687,5.687,0,0,0,1.2.149,1.958,1.958,0,0,0,1.851-1.065l.009-.013.076-.091a48.313,48.313,0,0,1,3.225-3.636,19.967,19.967,0,0,1,14.224-5.857,19.927,19.927,0,0,1,14.193,5.857,20,20,0,0,1,5.9,14.193,19.876,19.876,0,0,1-5.857,14.148,20.319,20.319,0,0,1-14.287,5.863,19.362,19.362,0,0,1-10.114-2.806c0-3.4-.033-6.17-.062-8.614a71.448,71.448,0,0,1,.244-10.193,9.022,9.022,0,0,1,2.5-5.167,9.762,9.762,0,0,1,7.4-3.346,10.755,10.755,0,0,1,7.153,2.76,9.833,9.833,0,0,1,3.227,7.371,11.178,11.178,0,0,1-.991,5.016,6.96,6.96,0,0,1-2.785,2.98c-2.1,1.245-5.133,1.8-9.824,1.8a.9.9,0,0,0-.254-.037c-.827,0-1.494,1.147-1.7,2.227-.164.851-.076,1.866.663,2.162a16.3,16.3,0,0,0,4.6.675,14.928,14.928,0,0,0,14.952-14.869,14.811,14.811,0,0,0-14.863-14.726c-8.011,0-14.678,6.292-14.863,14.026v14.284h-.046a17.768,17.768,0,0,1-3.7-6.132C35.425-1119.325,35.219-1119.874,34.389-1119.874Zm19.752-2.933h0c.527.519.964.953,1.315,1.3l.022.022c1.624,1.612,1.655,1.643,2.054,1.643a2.67,2.67,0,0,0,1.892-1.463,1.125,1.125,0,0,0-.264-1.306l-2.632-2.633,2.769-2.768a.969.969,0,0,0,.093-1.087,2.636,2.636,0,0,0-2-1.519.757.757,0,0,0-.557.217l-2.722,2.723c-.626-.633-1.108-1.126-1.494-1.523-1.356-1.39-1.409-1.444-1.776-1.444a3.144,3.144,0,0,0-2,1.687.812.812,0,0,0,.112.944l2.768,2.768c-.6.594-1.085,1.067-1.475,1.446-1.412,1.376-1.629,1.588-1.629,1.992a1.846,1.846,0,0,0,.738,1.2c.041.037.074.068.1.093a1.984,1.984,0,0,0,1.292.67h.034c.423,0,.45-.027,1.857-1.453l.008-.008c.387-.393.87-.881,1.493-1.5Zm.661-31.943a28.35,28.35,0,0,1,12.426,2.909,38.106,38.106,0,0,1,7.035,4.506,4.813,4.813,0,0,0,1.282.873,4.2,4.2,0,0,0,2.414-2.217,1.041,1.041,0,0,0-.239-1.251c-8.256-7.883-18.49-9.06-23.856-9.06a32.236,32.236,0,0,0-8.683,1.1c-2.181.633-3.569,1.435-3.712,2.145a4.912,4.912,0,0,0,.975,2.754,1.164,1.164,0,0,0,.865.455,1.044,1.044,0,0,0,.38-.075A31.233,31.233,0,0,1,54.8-1154.751Z" transform="translate(0 1180)" fill="#fff"/>
								</svg>';
								}
							echo '</a>
							</li>
							';
						}
						if ( ! empty( Ashade_Core::get_mod( 'ashade-socials-xing-url' ) ) ) {
							echo '
							<li>
								<a class="ashade-social--xing" href="' . esc_url( Ashade_Core::get_mod( 'ashade-socials-xing-url' ) ) . '" target="' . esc_attr( $target ) . '">';
								if ( 'text' == $socials_style ) {
									echo esc_attr( Ashade_Core::get_mod( 'ashade-socials-xing-label' ) );
								}
								if ( 'icon' == $socials_style ) {
									echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
									<path id="xing-square" d="M89.286,32H10.714A10.717,10.717,0,0,0,0,42.714v78.571A10.717,10.717,0,0,0,10.714,132H89.286A10.717,10.717,0,0,0,100,121.286V42.714A10.717,10.717,0,0,0,89.286,32ZM31.339,96.33h-10.4a1.5,1.5,0,0,1-1.339-2.3l11-19.353c.022,0,.022-.022,0-.045L23.594,62.58a1.421,1.421,0,0,1,1.339-2.254h10.4a3.322,3.322,0,0,1,2.879,1.942l7.121,12.344q-.435.77-11.183,19.688c-.781,1.384-1.719,2.031-2.813,2.031Zm49.04-47.79L57.433,88.875v.045l14.621,26.563a1.43,1.43,0,0,1-1.339,2.254h-10.4a3.2,3.2,0,0,1-2.879-1.942L42.7,88.942q.77-1.373,23.08-40.692a3.2,3.2,0,0,1,2.79-1.942H79.04a1.426,1.426,0,0,1,1.339,2.232Z" transform="translate(0 -32)" fill="#fff"/>
								</svg>';
								}
							echo '</a>
							</li>
							';
						}
						if ( ! empty( Ashade_Core::get_mod( 'ashade-socials-patreon-url' ) ) ) {
							echo '
							<li>
								<a class="ashade-social--patreon" href="' . esc_url( Ashade_Core::get_mod( 'ashade-socials-patreon-url' ) ) . '" target="' . esc_attr( $target ) . '">';
								if ( 'text' == $socials_style ) {
									echo esc_attr( Ashade_Core::get_mod( 'ashade-socials-patreon-label' ) );
								}
								if ( 'icon' == $socials_style ) {
									echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
									<path d="M2157.287-8038h-78.572A10.726,10.726,0,0,1,2068-8048.714v-78.572a10.644,10.644,0,0,1,3.137-7.576,10.645,10.645,0,0,1,7.577-3.139h78.572A10.725,10.725,0,0,1,2168-8127.286v78.572a10.645,10.645,0,0,1-3.137,7.575A10.641,10.641,0,0,1,2157.287-8038Zm-72.278-80.53v61.081h19.231v-61.081ZM2131-8119a21.89,21.89,0,0,0-8.566,1.728,21.921,21.921,0,0,0-6.991,4.716,21.919,21.919,0,0,0-4.716,6.993A21.886,21.886,0,0,0,2109-8097a21.886,21.886,0,0,0,1.728,8.563,21.919,21.919,0,0,0,4.716,6.993,21.955,21.955,0,0,0,6.991,4.716A21.89,21.89,0,0,0,2131-8075a21.865,21.865,0,0,0,8.562-1.728,21.937,21.937,0,0,0,6.993-4.716,21.919,21.919,0,0,0,4.714-6.993A21.859,21.859,0,0,0,2153-8097a21.86,21.86,0,0,0-1.73-8.564,21.919,21.919,0,0,0-4.714-6.993,21.917,21.917,0,0,0-6.993-4.716A21.865,21.865,0,0,0,2131-8119Zm-40.069,55.624v-49.231h7.385v49.231h-7.385ZM2131-8081a15.9,15.9,0,0,1-11.315-4.687A15.9,15.9,0,0,1,2115-8097a15.9,15.9,0,0,1,4.685-11.315A15.9,15.9,0,0,1,2131-8113a15.9,15.9,0,0,1,11.313,4.685A15.9,15.9,0,0,1,2147-8097a15.9,15.9,0,0,1-4.687,11.313A15.9,15.9,0,0,1,2131-8081Z" transform="translate(-2068 8138)" fill="#fff"/>
								</svg>';
								}
							echo '</a>
							</li>
							';
						}
						if ( ! empty( Ashade_Core::get_mod( 'ashade-socials-tiktok-url' ) ) ) {
							echo '
							<li>
								<a class="ashade-social--tiktok" href="' . esc_url( Ashade_Core::get_mod( 'ashade-socials-tiktok-url' ) ) . '" target="' . esc_attr( $target ) . '">';
								if ( 'text' == $socials_style ) {
									echo esc_attr( Ashade_Core::get_mod( 'ashade-socials-tiktok-label' ) );
								}
								if ( 'icon' == $socials_style ) {
									echo '<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100">
									<path d="M89.286,32H10.714A10.717,10.717,0,0,0,0,42.714v78.571A10.717,10.717,0,0,0,10.714,132H89.286A10.717,10.717,0,0,0,100,121.286V42.714A10.717,10.717,0,0,0,89.286,32ZM66.816,69.637s.161,23.283,0,26.078a42.664,42.664,0,0,1-1.616,9.058c-2.073,5.486-4.4,7.908-10.114,11.922s-11.458,3.469-15.117,3.187a25.465,25.465,0,0,1-12.907-5.609,25.531,25.531,0,0,1-7.457-11.263c-1.266-3.865-1.156-11.177.327-15.442s4.186-7.341,7.574-10.379a20.733,20.733,0,0,1,8.423-4.621,43.087,43.087,0,0,1,5.775-.845c1.688-.036,4.43,0,4.43,0V85.6s-5.462-1.506-8.491.414-5.125,4.25-5.765,8.014a11,11,0,0,0,2.779,9.558c2.155,2.052,4.668,3.523,7.046,3.585a12.019,12.019,0,0,0,8.1-2.395c3.02-2.235,3.157-3.925,3.555-6.416s0-54.606,0-54.606H66.816S66.792,51.4,72.427,56.8a20.892,20.892,0,0,0,12.859,5.531V75.516a51.59,51.59,0,0,1-9.909-1.9,41.462,41.462,0,0,1-8.561-3.982Z" transform="translate(0 -32)" fill="#fff"/>
								</svg>';
								}
							echo '</a>
							</li>
							';
						}
					?>
				</ul>
			</div>
			<?php
		}
	}
	Ashade_Core::instance()->init();
endif;
?>