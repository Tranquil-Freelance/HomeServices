<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists('RWMB_Loader') ) {
	return;
}

if ( !function_exists( 'ashade_register_meta_boxes' ) ) {
	# Add Metaboxes
	add_filter( 'rwmb_meta_boxes', 'ashade_register_meta_boxes' );
	function ashade_register_meta_boxes( $meta_boxes ) {
		$terms = get_terms( Ashade_Core::get_mod( 'ashade-cpt-albums-category' ) , array('taxonomy' => 'Category') );
		$albums_categ = array( 'all' => esc_attr__( 'All', 'ashade' ) );

		if ( is_array( $terms ) && count( $terms ) > 0 ) {
			foreach ( $terms as $cat ) {
				$albums_categ[ $cat->slug ] = $cat->name;
			}
		} else {
			$albums_categ = array( 'none' => esc_attr__( 'You have no categories yet.', 'ashade' ) );
		}

		# Page Settings
		$meta_boxes[] = array(
			'id'         => 'ashade-page-settings',
			'title'      => esc_attr__( 'Page Settings', 'ashade' ),
			'post_types' => 'page',
			'context'    => 'side',
			'fields' 	 => array(
				# Sub Title
				array(
                    'id'    => 'ashade-page-subtitle',
                    'name' => esc_attr__('Page Overhead', 'ashade'),
                    'type'  => 'text',
					'placeholder' => esc_attr__('Page Overhead', 'ashade'),
                ),
				# Spotlight
				array(
					'id' => 'ashade-spotlight',
					'name' => esc_attr__( 'Spotlight State', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					)
				),
				array(
					'type' => 'divider',
				),
				# Content Under Header
				array(
					'id' => 'ashade-page-cu',
					'name' => esc_attr__( 'Content Under Header', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					)
				),
				# Content Top Spacing
				array(
					'id' => 'ashade-page-pt',
					'name' => esc_attr__( 'Content Top Spacing', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					)
				),
				# Content Bottom Spacing
				array(
					'id' => 'ashade-page-pb',
					'name' => esc_attr__( 'Content Bottom Spacing', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					)
				),
				array(
					'type' => 'divider',
				),
				# Title and Back to Top Layout
				array(
					'id' => 'ashade-title-layout',
					'name' => esc_attr__( 'Title and Back to Top Layout', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' 	 => esc_attr__( 'Default', 'ashade' ),
						'vertical' 	 => esc_attr__( 'Vertical', 'ashade' ),
						'horizontal' => esc_attr__( 'Horizontal', 'ashade' )
					)
				),
				# Show Page Title
				array(
					'id' => 'ashade-page-title',
					'name' => esc_attr__( 'Show Page Title', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					)
				),
				# Show Back to Top
				array(
					'id' => 'ashade-back2top',
					'name' => esc_attr__( 'Back to Top', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					)
				),
				array(
					'type' => 'divider',
				),
				# Sidebar Position
				array(
					'id' => 'ashade-sidebar-position',
					'name' => esc_attr__( 'Sidebar Position', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						'none' 	  => esc_attr__( 'None', 'ashade' ),
						'right'   => esc_attr__( 'Right', 'ashade' ),
						'left' 	  => esc_attr__( 'Left', 'ashade' )
					)
				),
				array(
					'type' => 'divider',
				),
				# Allow Comments
				array(
					'id' => 'ashade-page-comments',
					'name' => esc_attr__( 'Allow Comments', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					)
				),
			)
		);
		
		# Home Template Settings
		$meta_boxes[] = array(
			'id'         => 'ashade-home-template-settings',
			'title'      => esc_attr__( 'Home Template Settings', 'ashade' ),
			'post_types' => 'page',
			'class'		 => 'ashade-home-template-rwmb',
			'context'    => 'normal',
			'fields' 	 => array(
				# Tab General
				array(
					'type' => 'heading',
					'name' => esc_attr__( 'General Settings', 'ashade' ),
					'desc' => '<span class="ashade-rwmb-tab">tab-home-general</span>'
				),
					# Spotlight
					array(
						'id' => 'ashade-spotlight-home',
						'name' => esc_attr__( 'Spotlight State', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					# Background Opacity
					array(
						'name' => esc_attr__('Background Opacity', 'ashade'),
						'id'   => 'ashade-home-bg-opacity',
						'type' => 'slider',
						'prefix' => false,
						'suffix' => ' %',
						'js_options' => array(
							'min'   => 0,
							'max'   => 100,
							'step'  => 1,
						),
						'std' => 75,
						// 'clone' => true,
					),
					array(
						'type' => 'divider',
					),
					# Background Style
					array(
						'id' => 'ashade-home-bg-style',
						'name' => esc_attr__( 'Background Style', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'static' => esc_attr__( 'Static Image', 'ashade' ),
							'video'  => esc_attr__( 'Video', 'ashade' ),
							'slider' => esc_attr__( 'Photo Gallery', 'ashade' )
						)
					),
					# Poster Image
					array(
						'id' => 'ashade-home-bg-poster',
						'name' => esc_attr__('Select Poster Image', 'ashade'),
						'type' => 'image_advanced',
						'force_delete' => false,
						'max_file_uploads' => 1,
						'max_status' => false,
						'image_size' => 'thumbnail',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-bg-style' => 'video',
							)),
						)
					),
					# Static Image
					array(
						'id' => 'ashade-home-bg-image',
						'name' => esc_attr__('Select Background Image', 'ashade'),
						'type' => 'image_advanced',
						'force_delete' => false,
						'max_file_uploads' => 1,
						'max_status' => false,
						'image_size' => 'thumbnail',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-bg-style' => 'static',
							)),
						)
					),
					# Gallery Images
					array(
						'id' => 'ashade-home-bg-gallery',
						'name' => esc_attr__('Add Images', 'ashade'),
						'type' => 'image_advanced',
						'force_delete' => false,
						'max_status' => false,
						'max_file_uploads' => false,
						'image_size' => 'thumbnail',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-bg-style' => 'slider',
							)),
						)
					),
					# Images Order
					array(
						'id' => 'ashade-home-bg-gallery-order',
						'name' => esc_attr__( 'Images Order', 'ashade' ),
						'type' => 'select',
						'std' => 'normal',
						'options' => array(
							'normal' => esc_attr__( 'Normal', 'ashade' ),
							'reverse'  => esc_attr__( 'Reverse', 'ashade' ),
							'random' => esc_attr__( 'Random', 'ashade' )
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-bg-style' => 'slider',
							)),
						)
					),
					# Video
					array(
						'id' => 'ashade-home-bg-video',
						'name' => esc_attr__('Select Video', 'ashade'),
						'type' => 'video',
						'force_delete' => false,
						'max_file_uploads' => 1,
						'max_status' => false,
						'image_size' => 'thumbnail',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-bg-style' => 'video',
							)),
						)
					),
					# Video on Mobile
					array(
						'id' => 'ashade-home-bg-video-mobile',
						'name' => esc_attr__( 'For Mobile Browsers', 'ashade' ),
						'type' => 'select',
						'std' => 'yes',
						'options' => array(
							'yes' => esc_attr__( 'Show Video', 'ashade' ),
							'no'  => esc_attr__( 'Show Poster', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-bg-style' => 'video',
							)),
						)
					),
					# Video Background Fit
					array(
						'id' => 'ashade-home-bg-video-fit',
						'name' => esc_attr__( 'Background Fit', 'ashade' ),
						'type' => 'select',
						'std' => 'cover',
						'options' => array(
							'cover' => esc_attr__( 'Cover', 'ashade' ),
							'fit-all'  => esc_attr__( 'Fit Always', 'ashade' ),
							'fit-v' => esc_attr__( 'Fit Vertical', 'ashade' ),
							'fit-h' => esc_attr__( 'Fit Horizontal', 'ashade' )
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-bg-style' => 'video',
							)),
						)
					),
					# Kenburns Transition
					array(
						'name' => esc_attr__('Slider Transition Speed, ms', 'ashade'),
						'id'   => 'ashade-home-slider-transition',
						'type' => 'number',
						'min'  => 100,
						'step' => 100,
						'std'  => 2000,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-bg-style' => 'slider',
							)),
						)
					),
					# Kenburns Delay
					array(
						'name' => esc_attr__('Slider Delay, ms', 'ashade'),
						'id'   => 'ashade-home-slider-delay',
						'type' => 'number',
						'min'  => 100,
						'step' => 100,
						'std'  => 4000,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-bg-style' => 'slider',
							)),
						)
					),
					# Kenburns Zoom Level
					array(
						'name' => esc_attr__('Zoom Level, %', 'ashade'),
						'id'   => 'ashade-home-slider-zoom',
						'type' => 'number',
						'min'  => 100,
						'max'  => 200,
						'step' => 1,
						'std'  => 120,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-bg-style' => 'slider',
							)),
						)
					),
					array(
						'type' => 'divider',
					),
					# Back Overhead
					array(
						'id'    => 'ashade-home-back-overhead',
						'name' => esc_attr__('Back Label Overhead', 'ashade'),
						'type'  => 'text',
						'std' => esc_attr__('Return', 'ashade'),
						'placeholder' => esc_attr__('Back Label Overhead', 'ashade'),
					),
					# Back Title
					array(
						'id'    => 'ashade-home-back-title',
						'name' => esc_attr__('Back Label Title', 'ashade'),
						'type'  => 'text',
						'std' => esc_attr__('Back', 'ashade'),
						'placeholder' => esc_attr__('Back Label Title', 'ashade'),
					),
					array(
						'type' => 'divider',
					),
					# Customize Colors
					array(
						'id' => 'ashade-home-custom-colors',
						'name' => esc_attr__( 'Links Color', 'ashade' ),
						'type' => 'select',
						'std' => 'default',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'custom'  => esc_attr__( 'Custom', 'ashade' ),
						),
					),
					array(
						'id' => 'ashade-home-color-link01',
						'name' => esc_attr__( 'Link Upper Part (Normal)', 'ashade' ),
						'type' => 'color',
						'alpha_channel' => true,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-custom-colors' => 'custom',
							)),
						)
					),
					array(
						'id' => 'ashade-home-color-link02',
						'name' => esc_attr__( 'Link Main Part (Normal)', 'ashade' ),
						'type' => 'color',
						'alpha_channel' => true,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-custom-colors' => 'custom',
							)),
						)
					),
					array(
						'id' => 'ashade-home-color-link01h',
						'name' => esc_attr__( 'Link Upper Part (Hover)', 'ashade' ),
						'type' => 'color',
						'alpha_channel' => true,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-custom-colors' => 'custom',
							)),
						)
					),
					array(
						'id' => 'ashade-home-color-link02h',
						'name' => esc_attr__( 'Link Main Part (Hover)', 'ashade' ),
						'type' => 'color',
						'std' => '#ff00ff',
						'alpha_channel' => true,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-custom-colors' => 'custom',
							)),
						)
					),
					
				
				# Tab Works
				array(
					'type' => 'heading',
					'name' => esc_attr__( 'Works Settings', 'ashade' ),
					'desc' => '<span class="ashade-rwmb-tab">tab-home-works</span>'
				),
					# Works State
					array(
						'id'   	  => 'ashade-home-works-state',
						'name'	  => esc_attr__( 'Show Works on Home?', 'ashade' ),
						'type'	  => 'select',
						'std'	  => 'yes',
						'options' => array(
							'yes' => esc_attr__( 'Yes', 'ashade' ),
							'no'  => esc_attr__( 'No', 'ashade' ),
							'other'  => esc_attr__( 'Link to Other Page', 'ashade' ),
							'external'  => esc_attr__( 'Link to External Page', 'ashade' ),
						),
					),
					# Select Other Page
					array(
						'name'        => esc_attr__( 'Select a Page', 'ashade' ),
						'id'          => 'ashade-home-works-page',
						'type'        => 'post',
					
						# Post type.
						'post_type'   => 'page',
					
						# Field type.
						'field_type'  => 'select_advanced',
					
						# Placeholder, inherited from `select_advanced` field.
						'placeholder' => esc_attr__( 'Select a Page', 'ashade' ),
					
						# Query arguments. See https://codex.wordpress.org/Class_Reference/WP_Query
						'query_args'  => array(
							'post_status'    => 'publish',
							'posts_per_page' => - 1,
						),

						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-works-state' => 'other',
							)),
						)
					),
					# Works External Link
					array(
						'id' => 'ashade-home-works-external',
						'name' => esc_attr__('Link to External Page', 'ashade'),
						'type'  => 'text',
						'placeholder' => esc_attr__('https://example.com/', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-works-state' => 'external',
							)),
						)
					),
					# Works External Link Target
					array(
						'id'        => 'ashade-home-works-external-blank',
						'name'      => esc_attr__('Open link in new tab?', 'ashade'),
						'type'      => 'switch',
						'std'		=> true,
						'style'     => 'rounded',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-works-state' => 'external',
							)),
						)
					),

					# Works Link Position
					array(
						'name' => esc_attr__('Link Position', 'ashade'),
						'id'   => 'ashade-home-works-position',
						'type' => 'slider',
						'prefix' => false,
						'suffix' => ' %',
						'js_options' => array(
							'min'   => 0,
							'max'   => 100,
							'step'  => 1,
						),
						'std' => 33,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-works-state' => 'yes,other,external',
							)),
						)
					),

					# Works Overhead
					array(
						'id' => 'ashade-home-works-overhead',
						'name' => esc_attr__('Works Label Overhead', 'ashade'),
						'type'  => 'text',
						'std' => esc_attr__('My Photo Portfolio', 'ashade'),
						'placeholder' => esc_attr__('Works Label Overhead', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-works-state' => 'yes,other,external',
							)),
						)
					),
					# Works Title
					array(
						'id' => 'ashade-home-works-title',
						'name' => esc_attr__('Works Label Title', 'ashade'),
						'type'  => 'text',
						'std' => esc_attr__('Explore Works', 'ashade'),
						'placeholder' => esc_attr__('Works Label Title', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-works-state' => 'yes,other,external',
							)),
						)
					),
					# Works Intro
					array(
						'id' => 'ashade-home-works-intro',
						'name' => esc_attr__('Works Intro  Description', 'ashade'),
						'type'  => 'textarea',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-works-state' => 'yes',
							)),
						)
					),
					# Select Categories
					array(
						'name'    => esc_attr__( 'Select Categories', 'ashade' ),
						'id'      => 'ashade-home-works-categs',
						'type'    => 'checkbox_list',
						'std'	  => 'all',
						'options' => $albums_categ,
						'inline'  => true,
						'class'	  => 'ashade-albums-select-categ',
						'select_all_none' => false,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-works-state' => 'yes',
							)),
						)
					),
					array(
						'id' => 'ashade-home-works-categs-labels',
						'name' => esc_attr__( 'Category Labels', 'ashade' ),
						'type' => 'select',
						'std' => 'date',
						'options' => array(
							'show' => esc_attr__( 'Show', 'ashade' ),
							'hide' => esc_attr__( 'Hide', 'ashade' ),
						),
					),
					array(
						'type' => 'divider',
					),
					# Gallery Order By
					array(
						'id' => 'ashade-home-works-orderby',
						'name' => esc_attr__( 'Sort Works By', 'ashade' ),
						'type' => 'select',
						'std' => 'date',
						'options' => array(
							'date' => esc_attr__( 'Date', 'ashade' ),
							'title' => esc_attr__( 'Title', 'ashade' ),
							'rand' => esc_attr__( 'Random', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-works-state' => 'yes',
							)),
						)
					),
					# Gallery Order
					array(
						'id' => 'ashade-home-works-order',
						'name' => esc_attr__( 'Works Order', 'ashade' ),
						'type' => 'select',
						'std' => 'DESC',
						'options' => array(
							'DESC' => esc_attr__( 'Descending', 'ashade' ),
							'ASC' => esc_attr__( 'Ascending', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-works-state' => 'yes',
							)),
						)
					),
					array(
						'type' => 'divider',
					),
					# Gallery Type
					array(
						'id'   	  => 'ashade-home-works-type',
						'name'	  => esc_attr__( 'Gallery Style', 'ashade' ),
						'type'	  => 'select',
						'options' => array(
							'grid'	   => esc_attr__( 'Grid', 'ashade' ),
							'masonry'  => esc_attr__( 'Masonry', 'ashade' ),
							'adjusted' => esc_attr__( 'Adjusted', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-works-state' => 'yes',
							)),
						)
					),
					# Filter Type
					array(
						'id'   	  => 'ashade-home-works-filter',
						'name'	  => esc_attr__( 'Filter State', 'ashade' ),
						'type'	  => 'select',
						'std' 	  => 'hide',
						'options' => array(
							'hide' => esc_attr__( 'Hide', 'ashade' ),
							'show' => esc_attr__( 'Show', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-works-state' => 'yes',
							)),
						)
					),
					# Gallery Columns
					array(
						'id'   => 'ashade-home-works-columns',
						'name' => esc_attr__( 'Columns Count', 'ashade' ),
						'type' => 'select',
						'std' => '3',
						'options' => array(
							'2'   => esc_attr__( '2 Columns', 'ashade' ),
							'3'   => esc_attr__( '3 Columns', 'ashade' ),
							'4'   => esc_attr__( '4 Columns', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-works-state' => 'yes',
							)),
						)
					),
					array(
						'type' => 'divider',
					),
					# Gap Style
					array(
						'id' => 'ashade-home-works-gap',
						'name' => esc_attr__( 'Default Items Gap', 'ashade' ),
						'type' => 'select',
						'std' => 'default',
						'options' => array(
							'theme' => 'Default by Theme',
							'custom' => 'Custom'
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-works-state' => 'yes',
							)),
						)
					),
					# Custom Items Gap
					array(
						'id'   => 'ashade-home-works-custom-gap',
						'name' => esc_html__( 'Custom Gap, PX', 'ashade' ),
						'type' => 'hidden',
						'std' => '40x30x20',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-works-state' => 'yes',
								'ashade-home-works-gap' => 'custom'
							)),
							'data-ashade-responsive' => 'number',
							'data-min' => 0,
							'data-max' => 120,
							'data-default' => '40x30x20'
						)
					),
					# Items Border Radius
					array(
						'id'   => 'ashade-home-works-br',
						'name' => esc_html__( 'Items Border Radius, PX', 'ashade' ),
						'type' => 'hidden',
						'std' => '0x0x0',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-works-state' => 'yes',
							)),
							'data-ashade-responsive' => 'number',
							'data-min' => 0,
							'data-max' => 120,
							'data-default' => '0x0x0'
						)
					),

				# Tab Contacts
				array(
					'type' => 'heading',
					'name' => esc_attr__( 'Contacts Settings', 'ashade' ),
					'desc' => '<span class="ashade-rwmb-tab">tab-home-contacts</span>'
				),
					# Contacts State
					array(
						'id'   	  => 'ashade-home-contacts-state',
						'name'	  => esc_attr__( 'Show Contacts on Home?', 'ashade' ),
						'type'	  => 'select',
						'options' => array(
							'yes' => esc_attr__( 'Yes', 'ashade' ),
							'no'  => esc_attr__( 'No', 'ashade' ),
							'other'  => esc_attr__( 'Link to Other Page', 'ashade' ),
							'external'  => esc_attr__( 'Link to External Page', 'ashade' ),
						),
					),

					# Select Other Page
					array(
						'name'        => esc_attr__( 'Select a Page', 'ashade' ),
						'id'          => 'ashade-home-contacts-page',
						'type'        => 'post',
					
						# Post type.
						'post_type'   => 'page',
					
						# Field type.
						'field_type'  => 'select_advanced',
					
						# Placeholder, inherited from `select_advanced` field.
						'placeholder' => esc_attr__( 'Select a Page', 'ashade' ),
					
						# Query arguments. See https://codex.wordpress.org/Class_Reference/WP_Query
						'query_args'  => array(
							'post_status'    => 'publish',
							'posts_per_page' => - 1,
						),

						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-contacts-state' => 'other',
							)),
						)
					),
					# Contacts External Link
					array(
						'id' => 'ashade-home-contacts-external',
						'name' => esc_attr__('Link to External Page', 'ashade'),
						'type'  => 'text',
						'placeholder' => esc_attr__('https://example.com/', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-contacts-state' => 'external',
							)),
						)
					),
					# Contacts External Link Target
					array(
						'id'        => 'ashade-home-contacts-external-blank',
						'name'      => esc_attr__('Open link in new tab?', 'ashade'),
						'type'      => 'switch',
						'std'		=> true,
						'style'     => 'rounded',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-contacts-state' => 'external',
							)),
						)
					),
					
					# Contacts Link Position
					array(
						'name' => esc_attr__('Link Position', 'ashade'),
						'id'   => 'ashade-home-contacts-position',
						'type' => 'slider',
						'prefix' => false,
						'suffix' => ' %',
						'js_options' => array(
							'min'   => 0,
							'max'   => 100,
							'step'  => 1,
						),
						'std' => 66,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-contacts-state' => 'yes,other,external',
							)),
						)
					),
					# Contacts Overhead
					array(
						'id' => 'ashade-home-contacts-overhead',
						'name' => esc_attr__('Contacts Label Overhead', 'ashade'),
						'type'  => 'text',
						'std' => esc_attr__('How to find me', 'ashade'),
						'placeholder' => esc_attr__('Contacts Label Overhead', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-contacts-state' => 'yes,other,external',
							)),
						)
					),
					# Contacts Title
					array(
						'id' => 'ashade-home-contacts-title',
						'name' => esc_attr__('Contacts Label Title', 'ashade'),
						'type'  => 'text',
						'std' => esc_attr__('My Contacts', 'ashade'),
						'placeholder' => esc_attr__('Contacts Label Title', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-contacts-state' => 'yes,other,external',
							)),
						)
					),
					# Contacts Intro
					array(
						'id' => 'ashade-home-contacts-intro',
						'name' => esc_attr__('Contacts Intro  Description', 'ashade'),
						'type'  => 'textarea',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-contacts-state' => 'yes',
							)),
						)
					),
					array(
						'type' => 'divider',
					),
					# Contacts Form Shortcode
					array(
						'id' => 'ashade-home-contacts-shortcode',
						'name' => esc_attr__('Contact Form Shortcode', 'ashade'),
						'placeholder' => '[contact-form-7 id="2020" title="Contact form"]',
						'type'  => 'text',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-contacts-state' => 'yes',
							)),
						)
					),
					array(
						'type' => 'divider',
					),
					# Contacts List State
					array(
						'id'   	  => 'ashade-home-contacts-list-state',
						'name'	  => esc_attr__( 'Show Contact Info List?', 'ashade' ),
						'type'	  => 'select',
						'options' => array(
							'yes' => esc_attr__( 'Yes', 'ashade' ),
							'no'  => esc_attr__( 'No', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-contacts-state' => 'yes',
							)),
						)
					),
					# Contacts List Overhead
					array(
						'id' => 'ashade-home-contacts-list-overhead',
						'name' => esc_attr__('Contact List Overhead', 'ashade'),
						'type'  => 'text',
						'placeholder' => esc_attr__('Contact List Overhead', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-contacts-state' => 'yes',
								'ashade-home-contacts-list-state' => 'yes',
							)),
						)
					),
					# Contacts List Title
					array(
						'id' => 'ashade-home-contacts-list-title',
						'name' => esc_attr__('Contact List Title', 'ashade'),
						'type'  => 'text',
						'placeholder' => esc_attr__('Contact List Title', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-contacts-state' => 'yes',
								'ashade-home-contacts-list-state' => 'yes',
							)),
						)
					),
					# Contacts List Icons
					array(
						'id'        => 'ashade-home-contacts-list-icons',
						'name'      => esc_attr__('Show List Icons?', 'ashade'),
						'type'      => 'switch',						
						'style'     => 'rounded',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-contacts-state' => 'yes',
								'ashade-home-contacts-list-state' => 'yes',
							)),
						)
					),
					# Contacts List Address
					array(
						'id' => 'ashade-home-contacts-list-location',
						'name' => esc_attr__('Your Address', 'ashade'),
						'type'  => 'text',
						'placeholder' => esc_attr__('Your Address', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-contacts-state' => 'yes',
								'ashade-home-contacts-list-state' => 'yes',
							)),
						)
					),
					# Contacts List Phone
					array(
						'id' => 'ashade-home-contacts-list-phone',
						'name' => esc_attr__('Your Phone', 'ashade'),
						'type'  => 'text',
						'placeholder' => esc_attr__('Your Phone', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-contacts-state' => 'yes',
								'ashade-home-contacts-list-state' => 'yes',
							)),
						)
					),
					# Contacts List Email
					array(
						'id' => 'ashade-home-contacts-list-email',
						'name' => esc_attr__('Your Email', 'ashade'),
						'type'  => 'text',
						'placeholder' => esc_attr__('Your Email', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-contacts-state' => 'yes',
								'ashade-home-contacts-list-state' => 'yes',
							)),
						)
					),
					# Contacts List Socials
					array(
						'id'        => 'ashade-home-contacts-list-socials',
						'name'      => esc_attr__('Show Socials?', 'ashade'),
						'type'      => 'switch',						
						'style'     => 'rounded',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-home-contacts-state' => 'yes',
								'ashade-home-contacts-list-state' => 'yes',
							)),
						)
					),
			)
		);
		
		# Albums Listing Settings
		$meta_boxes[] = array(
			'id'         => 'ashade-albums-template-settings',
			'title'      => 'Albums Listing Settings',
			'post_types' => 'page',
			'class'		 => 'ashade-albums-template-rwmb',
			'context'    => 'normal',
			'fields' 	 => array(
				# Tab Album Listing Settings
				array(
					'type' => 'heading',
					'name' => esc_attr__( 'Listing Settings', 'ashade' ),
					'desc' => '<span class="ashade-rwmb-tab">tab-al-settings</span>'
				),
					# Select Categories
					array(
						'name'    => esc_attr__( 'Select Categories', 'ashade' ),
						'id'      => 'ashade-al-categs',
						'type'    => 'checkbox_list',
						'std'	  => 'all',
						'options' => $albums_categ,
						'inline'  => true,
						'class'	  => 'ashade-albums-select-categ',
						'select_all_none' => false,
					),
					array(
						'type' => 'divider',
					),
					# Categs Labels
					array(
						'id' => 'ashade-al-categs-labels',
						'name' => esc_attr__( 'Category Labels', 'ashade' ),
						'type' => 'select',
						'std' => 'date',
						'options' => array(
							'show' => esc_attr__( 'Show', 'ashade' ),
							'hide' => esc_attr__( 'Hide', 'ashade' ),
						),
					),
					array(
						'type' => 'divider',
					),
					# Albums Order By
					array(
						'id' => 'ashade-al-orderby',
						'name' => esc_attr__( 'Sort Albums By', 'ashade' ),
						'type' => 'select',
						'std' => 'date',
						'options' => array(
							'date' => esc_attr__( 'Date', 'ashade' ),
							'title' => esc_attr__( 'Title', 'ashade' ),
							'rand' => esc_attr__( 'Random', 'ashade' ),
						)
					),
					# Albums Order
					array(
						'id' => 'ashade-al-order',
						'name' => esc_attr__( 'Albums Order', 'ashade' ),
						'type' => 'select',
						'std' => 'DESC',
						'options' => array(
							'DESC' => esc_attr__( 'Descending', 'ashade' ),
							'ASC' => esc_attr__( 'Ascending', 'ashade' ),
						)
					),
					array(
						'type' => 'divider',
					),
					# Albums Cover
					array(
						'id' => 'ashade-al-cover',
						'name' => esc_attr__( 'Albums Cover', 'ashade' ),
						'type' => 'select',
						'std' => 'featured',
						'options' => array(
							'featured' => esc_attr__( 'Use Featured Images', 'ashade' ),
							'custom' => esc_attr__( 'Use Alternative (if specified)', 'ashade' ),
						)
					),
					# Albums Intro
					array(
						'id' => 'ashade-al-intro',
						'name' => esc_attr__('Intro  Description', 'ashade'),
						'type'  => 'textarea',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'grid,masonry,adjusted',
							)),
						)
					),
					# Albums Listing Intro Alignment
					array(
						'id' => 'ashade-al-intro-align',
						'name' => esc_attr__( 'Intro Description Alignment', 'ashade' ),
						'type' => 'select',
						'std' => 'center',
						'options' => array(
							'center' => esc_attr__( 'Center', 'ashade' ),
							'left' => esc_attr__( 'Left', 'ashade' ),
							'right' => esc_attr__( 'Right', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'grid,masonry,adjusted',
							)),
						)
					),
					# Albums Listing Intro Alignment
					array(
						'id' => 'ashade-al-intro-width',
						'name' => esc_attr__( 'Limit Intro Width', 'ashade' ),
						'type' => 'select',
						'std' => 'yes',
						'options' => array(
							'yes' => esc_attr__( 'Yes', 'ashade' ),
							'no' => esc_attr__( 'No', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'grid,masonry,adjusted',
							)),
						)
					),
					array(
						'type' => 'divider',
					),
					# Gallery Type
					array(
						'id' => 'ashade-al-type',
						'name' => esc_attr__( 'Listing Type', 'ashade' ),
						'type' => 'select',
						'std' => 'grid',
						'options' => array(
							'grid' => esc_attr__( 'Grid', 'ashade' ),
							'masonry' => esc_attr__( 'Masonry', 'ashade' ),
							'adjusted' => esc_attr__( 'Adjusted', 'ashade' ),
							'ribbon' => esc_attr__( 'Ribbon', 'ashade' ),
							'slider' => esc_attr__( 'Slider', 'ashade' ),
						)
					),
					# Gallery Content Width
					array(
						'id' => 'ashade-al-content-width',
						'name' => esc_attr__( 'Content Width', 'ashade' ),
						'descr' => esc_attr__( 'This option is actual for "Grid" layouts only.', 'ashade' ), 
						'type' => 'select',
						'std' => 'boxed',
						'options' => array(
							'boxed' => esc_attr__( 'Boxed', 'ashade' ),
							'fullwidth' => esc_attr__( 'Fullwidth', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'grid,masonry,adjusted',
							)),
						)
					),
					array(
						'type' => 'divider',
					),
					# Gap Style
					array(
						'id' => 'ashade-al-gap',
						'name' => esc_attr__( 'Default Items Gap', 'ashade' ),
						'type' => 'select',
						'std' => 'default',
						'options' => array(
							'theme' => 'Default by Theme',
							'custom' => 'Custom'
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'grid,masonry,adjusted,ribbon',
							)),
						)
					),
					# Custom Items Gap
					array(
						'id'   => 'ashade-al-custom-gap',
						'name' => esc_html__( 'Custom Gap, PX', 'ashade' ),
						'type' => 'hidden',
						'std' => '40x30x20',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'grid,masonry,adjusted,ribbon',
								'ashade-al-gap' => 'custom'
							)),
							'data-ashade-responsive' => 'number',
							'data-min' => 0,
							'data-max' => 120,
							'data-default' => '40x30x20'
						)
					),
					# Items Border Radius
					array(
						'id'   => 'ashade-al-br',
						'name' => esc_html__( 'Items Border Radius, PX', 'ashade' ),
						'type' => 'hidden',
						'std' => '0x0x0',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'grid,masonry,adjusted,ribbon',
							)),
							'data-ashade-responsive' => 'number',
							'data-min' => 0,
							'data-max' => 120,
							'data-default' => '0x0x0'
						)
					),
					array(
						'type' => 'divider',
					),
					# Ribbon Style
					array(
						'id' => 'ashade-al-ribbon-style',
						'name' => esc_attr__( 'Ribbon Style', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'large' => esc_attr__( 'Large', 'ashade' ),
							'medium' => esc_attr__( 'Medium', 'ashade' ),
							'vertical' => esc_attr__( 'Vertical', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'ribbon',
							)),
						)
					),
					# Link Style
					array(
						'id' => 'ashade-al-ribbon-link',
						'name' => esc_attr__( 'Link Style', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'button' => esc_attr__( 'Explore Link', 'ashade' ),
							'link' => esc_attr__( 'Entire Item', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'ribbon,slider',
							)),
						)
					),
					# Ribbon Vertical on Mobile
					array(
						'id' => 'ashade-al-ribbon-mobile',
						'name'      => esc_attr__('Vertical Layout for Mobile', 'ashade'),
						'type'      => 'switch',						
						'style'     => 'rounded',
						'std'		=> 0,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'ribbon',
							)),
						)
					),
					# Slider Style
					array(
						'id' => 'ashade-al-slider-style',
						'name' => esc_attr__( 'Slider Style', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'parallax' => esc_attr__( 'Parallax', 'ashade' ),
							'fade' => esc_attr__( 'Fade', 'ashade' ),
							'simple' => esc_attr__( 'Simple', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'slider',
							)),
						)
					),
					# Slider Navigation
					array(
						'id' => 'ashade-al-slider-nav',
						'name' => esc_attr__( 'Slider Navigation', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'show' => esc_attr__( 'Show', 'ashade' ),
							'hide' => esc_attr__( 'Hide', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'slider',
							)),
						)
					),
					# Albums Slider Fit
					array(
						'id' => 'ashade-al-slider-fit',
						'name' => esc_attr__( 'Content Fitting', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'cover'   => esc_attr__( 'Cover', 'ashade' ),
							'fit-all' => esc_attr__( 'Fit Always', 'ashade' ),
							'fit-v'   => esc_attr__( 'Fit Vertical', 'ashade' ),
							'fit-h'   => esc_attr__( 'Fit Horizontal', 'ashade' )
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'slider',
							)),
						)
					),
					# Grid Filter
					array(
						'id' => 'ashade-al-filter',
						'name' => esc_attr__( 'Filter State', 'ashade' ),
						'type' => 'select',
						'std' => 'hide',
						'options' => array(
							'hide' => esc_attr__( 'Hide', 'ashade' ),
							'show' => esc_attr__( 'Show', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'grid,masonry,adjusted',
							)),
						)
					),
					# Grid Columns
					array(
						'id' => 'ashade-al-grid-columns',
						'name' => esc_attr__( 'Grid Columns', 'ashade' ),
						'type' => 'select',
						'options' => array(
							2 => esc_attr__( '2 Columns', 'ashade' ),
							3 => esc_attr__( '3 Columns', 'ashade' ),
							4 => esc_attr__( '4 Columns', 'ashade' ),
						),
						'std' => 3,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'grid,masonry,adjusted',
							)),
						)
					),
					array(
						'type' => 'divider',
					),
					# Crop Grid Images
					array(
						'id' => 'ashade-al-grid-crop',
						'name' => esc_attr__( 'Customize Image Crop', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'yes' => esc_attr__( 'Yes', 'ashade' ),
							'no' => esc_attr__( 'No', 'ashade' ),
						),
						'std' => 'no',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'grid,masonry,adjusted',
							)),
						)
					),
					# Crop Image Width
					array(
						'name' => esc_attr__('Image Width', 'ashade'),
						'id'   => 'ashade-al-grid-width',
						'type' => 'number',
						'min'  => 100,
						'step' => 1,
						'std'  => 960,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'grid,masonry,adjusted',
								'ashade-al-grid-crop' => 'yes'
							)),
						)
					),
					# Crop Image Height
					array(
						'name' => esc_attr__('Image Height', 'ashade'),
						'id'   => 'ashade-al-grid-height',
						'type' => 'number',
						'min'  => 100,
						'step' => 1,
						'std'  => 640,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-al-type' => 'grid',
								'ashade-al-grid-crop' => 'yes'
							)),
						)
					),
				# Tab Album Listing Layout
				array(
					'type' => 'heading',
					'name' => esc_attr__( 'Layout Settings', 'ashade' ),
					'desc' => '<span class="ashade-rwmb-tab">tab-al-layout</span>'
				),
					# Spotlight
					array(
						'id' => 'ashade-al-spotlight',
						'name' => esc_attr__( 'Spotlight State', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					# Content Under Header
					array(
						'id' => 'ashade-al-cu',
						'name' => esc_attr__( 'Content Under Header', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					# Content Top Spacing
					array(
						'id' => 'ashade-al-pt',
						'name' => esc_attr__( 'Content Top Spacing', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					# Content Bottom Spacing
					array(
						'id' => 'ashade-al-pb',
						'name' => esc_attr__( 'Content Bottom Spacing', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					array(
						'type' => 'divider',
					),
					# Title State
					array(
						'id' => 'ashade-al-page-title',
						'name' => esc_attr__( 'Page Title', 'ashade' ),
						'type' => 'select',
						'std' => 'default',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					# Title Layout
					array(
						'id' => 'ashade-al-title-layout',
						'name' => esc_attr__( 'Title and Back to Top Layout', 'ashade' ),
						'type' => 'select',
						'std' => 'default',
						'options' => array(
							'default' 	 => esc_attr__( 'Default', 'ashade' ),
							'vertical' 	 => esc_attr__( 'Vertical', 'ashade' ),
							'horizontal' => esc_attr__( 'Horizontal', 'ashade' )
						)
					),
					# Show Back to Top
					array(
						'id' => 'ashade-al-back2top',
						'name' => esc_attr__( 'Back to Top', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
			)
		);

		# Albums Settings
		$meta_boxes[] = array(
			'id'         => 'ashade-album-post-settings',
			'title'      => esc_attr__( 'Album Settings', 'ashade' ),
			'post_types' => 'ashade-albums',
			'context'    => 'normal',
			'fields' 	 => array(
				# Tab Album Content
				array(
					'type' => 'heading',
					'name' => esc_attr__( 'Album Content', 'ashade' ),
					'desc' => '<span class="ashade-rwmb-tab">tab-album-content</span>'
				),
					# Elementor Content Position
					array(
						'id' => 'ashade-albums-content-position',
						'name' => esc_attr__( 'Elementor Content Position', 'ashade' ),
						'type' => 'select',
						'std' => 'none',
						'options' => array(
							'none' => esc_attr__( 'None', 'ashade' ),
							'top' => esc_attr__( 'At the Top', 'ashade' ),
							'middle' => esc_attr__( 'After Intro', 'ashade' ),
							'bottom' => esc_attr__( 'After Gallery', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'default,grid,masonry,adjusted,bricks,justified',
							)),
						)
					),
					# Albums Intro
					array(
						'id' => 'ashade-albums-intro',
						'name' => esc_attr__('Intro Description', 'ashade'),
						'type'  => 'textarea',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'default,grid,masonry,adjusted,bricks,justified',
							)),
						)
					),
					# Album Intro Align
					array(
						'id' => 'ashade-albums-intro-align',
						'name' => esc_attr__( 'Intro Description Alignment', 'ashade' ),
						'type' => 'select',
						'std' => 'center',
						'options' => array(
							'left' => esc_attr__( 'Left', 'ashade' ),
							'center' => esc_attr__( 'Center', 'ashade' ),
							'right' => esc_attr__( 'Right', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'default,grid,masonry,adjusted,bricks,justified',
							)),
						)
					),
					array(
						'type' => 'divider',
					),
					# Album Media Type
					array(
						'id' => 'ashade-albums-media-type',
						'name' => esc_attr__( 'Album Media Type', 'ashade' ),
						'type' => 'select',
						'std' => 'images',
						'options' => array(
							'images' => esc_attr__( 'Images Only', 'ashade' ),
							'mixed' => esc_attr__( 'Mixed and Embed', 'ashade' ),
							'video' => esc_attr__( 'Video Only', 'ashade' ),
						),
					),
					array(
						'type' => 'divider',
					),
					# Albums Images
					array(
						'id' => 'ashade-albums-images',
						'name' => esc_attr__('Add Images', 'ashade'),
						'type' => 'image_advanced',
						'force_delete' => false,
						'max_status' => false,
						'image_size' => 'thumbnail',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-media-type' => 'images',
							)),
						)
					),
					# Albums Videos
					array(
						'id' => 'ashade-albums-video',
						'name' => esc_attr__('Add Videos', 'ashade'),
						'type' => 'video',
						'force_delete' => false,
						'max_status' => false,
						'max_file_uploads' => -1,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-media-type' => 'video',
							)),
						)
					),
					# Albums Mixed Content
					array(
					    'id'      => 'ashade-albums-media',
						'class'   => 'ashade-mixed-media',
					    'name'    => esc_attr__('Add Media', 'ashade'),
						'type'    => 'fieldset_text',
					    'options' => array(
					        'image'  => esc_attr__('Image', 'ashade'),
					        'video'  => esc_attr__('Video', 'ashade'),
							'type'    => esc_attr__('Type', 'ashade'),
						),
						'before' => '<div 
							data-button-select  = "'. esc_attr__('Select', 'ashade') .'" 
							data-button-update  = "'. esc_attr__('Change', 'ashade') .'" 
							data-button-add     = "'. esc_attr__('Add New Item', 'ashade') .'" 
							data-button-remove  = "'. esc_attr__('Remove', 'ashade') .'" 
							data-select-image   = "'. esc_attr__('Select Image', 'ashade') .'" 
							data-select-video   = "'. esc_attr__('Select Video', 'ashade') .'" 
							data-select-embed   = "'. esc_attr__('Embed Video', 'ashade') .'" 
							data-selected-image = "'. esc_attr__('Selected Image', 'ashade') .'" 
							data-selected-video = "'. esc_attr__('Selected Video', 'ashade') .'" 
							data-or             = "'. esc_attr__('or', 'ashade') .'" 
							data-embed-intro    = "'. esc_attr__('Insert YouTube or Vimeo video link url.', 'ashade') .'" 
							data-embed-insert   = "'. esc_attr__('Insert', 'ashade') .'" 
							data-embed-example  = "'. esc_attr__('Example:', 'ashade') .'" 
							data-embed-youtube  = "'. esc_attr__('https://www.youtube.com/watch?v=m6ZY7gSXwYE', 'ashade') .'" 
							data-embed-vimeo    = "'. esc_attr__('https://vimeo.com/285444981', 'ashade') .'" 
							class = "ashade-mixed-media-l18n"></div>',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-media-type' => 'mixed',
							)),
						),
						'add_button' => esc_attr__('+ Add Item', 'ashade'),
						'clone'      => true,
						'sort_clone' => true
					),
					# Images Direction
					array(
						'id' => 'ashade-albums-direction',
						'name' => esc_attr__( 'Images Direction', 'ashade' ),
						'type' => 'select',
						'std' => 'default',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'normal' => esc_attr__( 'Normal', 'ashade' ),
							'reverse' => esc_attr__( 'Reverse', 'ashade' ),
							'random' => esc_attr__( 'Random', 'ashade' ),
						),
						'attributes' => array(
							'data-default' => esc_attr( Ashade_Core::get_mod( 'ashade-albums-direction' ) ),
						)
					),
					array(
						'type' => 'divider',
					),
					# Album Style
					array(
						'id' => 'ashade-albums-type',
						'name' => esc_attr__( 'Album Style', 'ashade' ),
						'type' => 'select',
						'std' => 'default',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'grid' => esc_attr__( 'Grid', 'ashade' ),
							'masonry' => esc_attr__( 'Masonry', 'ashade' ),
							'adjusted' => esc_attr__( 'Adjusted', 'ashade' ),
							'bricks' => esc_attr__( 'Bricks', 'ashade' ),
							'ribbon' => esc_attr__( 'Ribbon', 'ashade' ),
							'slider' => esc_attr__( 'Slider', 'ashade' ),
							'justified' => esc_attr__( 'Justified', 'ashade' ),
						),
						'attributes' => array(
							'data-default' => esc_attr( Ashade_Core::get_mod( 'ashade-albums-type' ) ),
						)
					),
					# Gap Style
					array(
						'id' => 'ashade-albums-gap',
						'name' => esc_attr__( 'Default Items Gap', 'ashade' ),
						'type' => 'select',
						'std' => 'default',
						'options' => array(
							'theme' => 'Default by Theme',
							'custom' => 'Custom'
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'grid,masonry,adjusted,bricks,ribbon',
							)),
						)
					),
					# Custom Items Gap
					array(
						'id'   => 'ashade-albums-custom-gap',
						'name' => esc_html__( 'Custom Gap, PX', 'ashade' ),
						'type' => 'hidden',
						'std' => '40x30x20',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'grid,masonry,adjusted,bricks,ribbon',
								'ashade-albums-gap' => 'custom'
							)),
							'data-ashade-responsive' => 'number',
							'data-min' => 0,
							'data-max' => 120,
							'data-default' => '40x30x20'
						)
					),
					# Items Border Radius
					array(
						'id'   => 'ashade-albums-br',
						'name' => esc_html__( 'Items Border Radius, PX', 'ashade' ),
						'type' => 'hidden',
						'std' => '0x0x0',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'grid,masonry,adjusted,bricks,ribbon,justified',
							)),
							'data-ashade-responsive' => 'number',
							'data-min' => 0,
							'data-max' => 120,
							'data-default' => '0x0x0'
						)
					),
                    # Content Layout
					array(
						'id' => 'ashade-albums-content-layout',
						'name' => esc_attr__( 'Content Width', 'ashade' ),
                        'descr' => esc_attr__( 'This option is actual for "Grid" layouts only.', 'ashade' ), 
						'type' => 'select',
						'std' => 'default',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'boxed' => esc_attr__( 'Boxed', 'ashade' ),
							'fullwidth' => esc_attr__( 'Fullwidth', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'default,grid,masonry,adjusted,bricks,justified',
							)),
						)
					),
					array(
						'type' => 'divider',
					),
					# Album Columns
					array(
						'id' => 'ashade-albums-columns',
						'name' => esc_attr__( 'Columns Number', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'2' => esc_attr__( '2 Columns', 'ashade' ),
							'3' => esc_attr__( '3 Columns', 'ashade' ),
							'4' => esc_attr__( '4 Columns', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'grid,masonry,adjusted'
							)),
						)
					),
					# Album Bricks Layout
					array(
						'id' => 'ashade-albums-layout',
						'name' => esc_attr__( 'Bricks Layout', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'1x2' => esc_attr__( '1x2 Items', 'ashade' ),
							'2x3' => esc_attr__( '2x3 Items', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'bricks'
							)),
						)
					),
					# Album Items Caption
					array(
						'id' => 'ashade-albums-caption',
						'name' => esc_attr__( 'Album Items Caption', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'none' => esc_attr__( 'None', 'ashade' ),
							'under' => esc_attr__( 'Under Photo', 'ashade' ),
							'on_photo' => esc_attr__( 'On Photo', 'ashade' ),
							'on_hover' => esc_attr__( 'On Hover', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'grid,masonry,adjusted,bricks'
							)),
						)
					),
					# Album Items Caption Ribbon/Slider
					array(
						'id' => 'ashade-albums-fs-caption',
						'name' => esc_attr__( 'Album Items Caption', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'none' => esc_attr__( 'None', 'ashade' ),
							'show' => esc_attr__( 'Show', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'ribbon,slider'
							)),
						)
					),
					# Albums Grid Lightbox State
					array(
						'id' => 'ashade-albums-lightbox',
						'name' => esc_attr__( 'Allow Lightbox', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'grid,masonry,adjusted,bricks,justified'
							)),
						)
					),
					# Album Text in Lightbox
					array(
						'id' => 'ashade-albums-lightbox-text',
						'name' => esc_attr__( 'Text in Lightbox', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'none' => esc_attr__( 'None', 'ashade' ),
							'caption' => esc_attr__( 'Caption', 'ashade' ),
							'descr' => esc_attr__( 'Description', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'grid,masonry,adjusted,bricks,justified',
							)),
						)
					),
					# Album Comments
					array(
						'id' => 'ashade-albums-comments',
						'name' => esc_attr__( 'Allow Comments?', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'grid,masonry,adjusted,bricks,justified'
							)),
						)
					),

					# Albums Row Height State
					array(
						'id' => 'ashade-albums-rowHeight-state',
						'name' => esc_attr__( 'Row Height', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'custom' => esc_attr__( 'Custom', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'justified'
							)),
						)
					),
					# Albums Row Height
					array(
						'name' => esc_attr__('Approximate Row Height, PX', 'ashade'),
						'id'   => 'ashade-albums-rowHeight',
						'type' => 'number',
						'min'  => 80,
						'max' => 1080,
						'step' => 1,
						'std'  => 250,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'justified',
								'ashade-albums-rowHeight-state' => 'custom',
							)),
						)
					),
					# Albums Items Spacing State
					array(
						'id' => 'ashade-albums-spacing-state',
						'name' => esc_attr__( 'Item Spacing', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'custom' => esc_attr__( 'Custom', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'justified'
							)),
						)
					),
					# Albums Items Spacing
					array(
						'name' => esc_attr__('Set Item Spacing, PX', 'ashade'),
						'id'   => 'ashade-albums-spacing',
						'type' => 'number',
						'min'  => 0,
						'step' => 1,
						'std'  => 10,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'justified',
								'ashade-albums-spacing-state' => 'custom',
							)),
						)
					),
					# Albums Justified Last Row
					array(
						'id' => 'ashade-albums-lastRow',
						'name' => esc_attr__( 'Justified Last Row', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'justified'
							)),
						)
					),
					# Albums Ribbon Layout
					array(
						'id' => 'ashade-albums-ribbon-layout',
						'name' => esc_attr__( 'Ribbon Layout', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'large' => esc_attr__( 'Large', 'ashade' ),
							'medium' => esc_attr__( 'Medium', 'ashade' ),
							'vertical' => esc_attr__( 'Vertical', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'ribbon'
							)),
						)
					),
					# Albums Ribbon Lightbox
					array(
						'id' => 'ashade-albums-ribbon-lightbox',
						'name' => esc_attr__( 'Allow Lightbox', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'ribbon',
							)),
						)
					),
                    # Albums Slider Opacity State
					array(
						'id' => 'ashade-albums-slider-opacity-state',
						'name' => esc_attr__( 'Slider Opacity', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' 	  => esc_attr__( 'Default', 'ashade' ),
							'none' 	  => esc_attr__( 'None', 'ashade' ),
							'custom' 	  => esc_attr__( 'Custom', 'ashade' )
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'slider'
							)),
						)
					),
                    # Albums Slider Opacity
					array(
						'name' => esc_attr__('Set Slider Opacity', 'ashade'),
						'id'   => 'ashade-albums-slider-opacity',
						'type' => 'slider',
						'prefix' => false,
						'suffix' => ' %',
						'js_options' => array(
							'min'   => 0,
							'max'   => 100,
							'step'  => 1,
						),
						'std' => 75,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'slider',
                                'ashade-albums-slider-opacity-state' => 'custom'
							)),
						)
					),
                    # Albums Slider Overlay
					array(
						'id' => 'ashade-albums-slider-overlay',
						'name' => esc_attr__( 'Slider Overlay', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'show' 	  => esc_attr__( 'Show', 'ashade' ),
							'hide' 	  => esc_attr__( 'Hide', 'ashade' )
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'slider'
							)),
						)
					),
					# Albums Slider Navigation
					array(
						'id' => 'ashade-albums-slider-nav',
						'name' => esc_attr__( 'Slider Navigation', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'slider'
							)),
						)
					),
					# Albums Slider Effect
					array(
						'id' => 'ashade-albums-slider-layout',
						'name' => esc_attr__( 'Slide Effect', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'parallax' => esc_attr__( 'Parallax', 'ashade' ),
							'fade' => esc_attr__( 'Fade', 'ashade' ),
							'simple' => esc_attr__( 'Simple', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'slider'
							)),
						)
					),
					# Albums Slider Fit
					array(
						'id' => 'ashade-albums-slider-fit',
						'name' => esc_attr__( 'Content Fitting', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'cover'   => esc_attr__( 'Cover', 'ashade' ),
							'fit-all' => esc_attr__( 'Fit Always', 'ashade' ),
							'fit-v'   => esc_attr__( 'Fit Vertical', 'ashade' ),
							'fit-h'   => esc_attr__( 'Fit Horizontal', 'ashade' )
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'slider'
							)),
						)
					),
                    # Albums Video UnMute Button
					array(
						'id' => 'ashade-albums-video-unmute',
						'name' => esc_attr__( 'Show Mute/Unmute Video Button', 'ashade' ),
                        'descr' => esc_attr__('This option is actual only for the video files from the Media Library.', 'ashade'),
						'type' => 'select',
						'options' => array(
							'hide' => esc_attr__( 'Hide', 'ashade' ),
							'show' => esc_attr__( 'Show', 'ashade' )
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'ribbon,slider',
                                'ashade-albums-media-type' => 'video,mixed'
							)),
						)
					),
					array(
						'type' => 'divider',
					),
					# Alternative Cover
					array(
						'id' => 'ashade-albums-image',
						'descr' => esc_attr__('This image is used for album listing if "Alternative Cover" is chosen. Is useful to add album cover in the different orientation, than featured image.', 'ashade'),
						'name' => esc_attr__('Select Alternate Cover', 'ashade'),
						'type' => 'image_advanced',
						'force_delete' => false,
						'max_file_uploads' => 1,
						'max_status' => false,
						'image_size' => 'thumbnail',
					),

				# Tab Page Layout
				array(
					'type' => 'heading',
					'name' => esc_attr__( 'Page Layout', 'ashade' ),
					'desc' => '<span class="ashade-rwmb-tab">tab-album-page-layout</span>'
				),
					# Spotlight
					array(
						'id' => 'ashade-spotlight',
						'name' => esc_attr__( 'Spotlight State', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					array(
						'type' => 'divider',
					),
					# Content Under Header
					array(
						'id' => 'ashade-albums-cu',
						'name' => esc_attr__( 'Content Under Header', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					# Content Top Spacing
					array(
						'id' => 'ashade-albums-pt',
						'name' => esc_attr__( 'Content Top Spacing', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					# Content Bottom Spacing
					array(
						'id' => 'ashade-albums-pb',
						'name' => esc_attr__( 'Content Bottom Spacing', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					array(
						'type' => 'divider',
					),
					# Title and Back to Top Layout
					array(
						'id' => 'ashade-title-layout',
						'name' => esc_attr__( 'Title and Back to Top Layout', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' 	 => esc_attr__( 'Default', 'ashade' ),
							'vertical' 	 => esc_attr__( 'Vertical', 'ashade' ),
							'horizontal' => esc_attr__( 'Horizontal', 'ashade' )
						)
					),
					# Show Album Title
					array(
						'id' => 'ashade-albums-title',
						'name' => esc_attr__( 'Show Album Title', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'default,grid,masonry,adjusted,bricks,justified,slider'
							)),
						)
					),
					# Show Album Title Ribbon Vertical
					array(
						'id' => 'ashade-albums-rtitle',
						'name' => esc_attr__( 'Show Album Title', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'ribbon',
								'ashade-albums-ribbon-layout' => 'vertical',
							)),
						)
					),
					# Show Back to Top
					array(
						'id' => 'ashade-back2top',
						'name' => esc_attr__( 'Back to Top', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
				
				# Tab Meta
				array(
					'type' => 'heading',
					'name' => esc_attr__( 'Album Meta', 'ashade' ),
					'desc' => '<span class="ashade-rwmb-tab">tab-album-meta</span>'
				),
					# META: Album Author
					array(
						'id' => 'ashade-albums-meta-author',
						'name' => esc_attr__( 'Show Album Author', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					# META: Album Date
					array(
						'id' => 'ashade-albums-meta-date',
						'name' => esc_attr__( 'Show Album Date', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					# META: Album Category
					array(
						'id' => 'ashade-albums-meta-category',
						'name' => esc_attr__( 'Show Album Category', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
			)
		);

		# Clients Settings
		$meta_boxes[] = array(
			'id'         => 'ashade-client-post-settings',
			'title'      => esc_attr__( 'Client Settings', 'ashade' ),
			'post_types' => 'ashade-clients',
			'context'    => 'normal',
			'fields' 	 => array(
				# Sub Title
				array(
                    'id'    => 'ashade-page-subtitle',
                    'name' => esc_attr__('Page Overhead', 'ashade'),
                    'type'  => 'text',
					'placeholder' => esc_attr__('Page Overhead', 'ashade'),
                ),
				# Tab Album Content
				array(
					'type' => 'heading',
					'name' => esc_attr__( 'Client Photo Gallery', 'ashade' ),
					'desc' => '<span class="ashade-rwmb-tab">tab-client-content</span>'
				),
					# Client Page Background
					array(
						'id' => 'ashade-client-bg-state',
						'name' => esc_attr__( 'Page Background', 'ashade' ),
						'type' => 'select',
						'std' => 'featured',
						'options' => array(
							'none' => esc_attr__( 'None', 'ashade' ),
							'featured' => esc_attr__( 'Use Featured Image', 'ashade' ),
							'custom' => esc_attr__( 'Use Custom Image', 'ashade' ),
						)
					),
					# Client Page Background Image
					array(
						'id' => 'ashade-client-bg-image',
						'name' => esc_attr__('Select Background Image', 'ashade'),
						'type' => 'image_advanced',
						'force_delete' => false,
						'max_file_uploads' => 1,
						'max_status' => false,
						'image_size' => 'thumbnail',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-client-bg-state' => 'custom',
							)),
						)
					),
					# Background Opacity
					array(
						'name' => esc_attr__('Background Opacity', 'ashade'),
						'id'   => 'ashade-client-bg-opacity',
						'type' => 'slider',
						'prefix' => false,
						'suffix' => ' %',
						'js_options' => array(
							'min'   => 0,
							'max'   => 100,
							'step'  => 1,
						),
						'std' => 15,
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-client-bg-state' => 'featured,custom',
							)),
						)
					),
					array(
						'type' => 'divider',
					),
					# Elementor Content Position
					array(
						'id' => 'ashade-client-content-position',
						'name' => esc_attr__( 'Elementor Content Position', 'ashade' ),
						'type' => 'select',
						'std' => 'none',
						'options' => array(
							'none' => esc_attr__( 'None', 'ashade' ),
							'top' => esc_attr__( 'At the Top', 'ashade' ),
							'middle' => esc_attr__( 'After Intro', 'ashade' ),
							'bottom' => esc_attr__( 'After Gallery', 'ashade' ),
						),
					),
					# Client Intro
					array(
						'id' => 'ashade-client-intro',
						'name' => esc_attr__('Intro  Description', 'ashade'),
						'type'  => 'textarea',
					),
					# Client Intro Align
					array(
						'id' => 'ashade-client-intro-align',
						'name' => esc_attr__( 'Intro Description Alignment', 'ashade' ),
						'type' => 'select',
						'std' => 'center',
						'options' => array(
							'left' => esc_attr__( 'Left', 'ashade' ),
							'center' => esc_attr__( 'Center', 'ashade' ),
							'right' => esc_attr__( 'Right', 'ashade' ),
						)
					),
					array(
						'type' => 'divider',
					),
					# Client Images
					array(
						'id' => 'ashade-client-images',
						'name' => esc_attr__('Add Images', 'ashade'),
						'type' => 'image_advanced',
						'force_delete' => false,
						'max_status' => false,
						'image_size' => 'thumbnail',
					),
					array(
						'type' => 'divider',
					),
					# Client Gallery Style
					array(
						'id' => 'ashade-client-type',
						'name' => esc_attr__( 'Gallery Style', 'ashade' ),
						'type' => 'select',
						'std' => 'default',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'grid' => esc_attr__( 'Grid', 'ashade' ),
							'masonry' => esc_attr__( 'Masonry', 'ashade' ),
							'adjusted' => esc_attr__( 'Adjusted', 'ashade' ),
						)
					),
					array(
						'type' => 'divider',
					),
					# Client Gallery Columns
					array(
						'id' => 'ashade-client-columns',
						'name' => esc_attr__( 'Columns Number', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'2' => esc_attr__( '2 Columns', 'ashade' ),
							'3' => esc_attr__( '3 Columns', 'ashade' ),
							'4' => esc_attr__( '4 Columns', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-client-type' => 'grid,masonry,adjusted'
							)),
						)
					),
					# Client Bricks Gallery Layout
					array(
						'id' => 'ashade-client-layout',
						'name' => esc_attr__( 'Bricks Layout', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'1x2' => esc_attr__( '1x2 Items', 'ashade' ),
							'2x3' => esc_attr__( '2x3 Items', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-client-type' => 'bricks'
							)),
						)
					),
					# Client Items Caption
					array(
						'id' => 'ashade-client-caption',
						'name' => esc_attr__( 'Gallery Items Caption', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'none' => esc_attr__( 'None', 'ashade' ),
							'under' => esc_attr__( 'Under Photo', 'ashade' ),
							'on_photo' => esc_attr__( 'On Photo', 'ashade' ),
							'on_hover' => esc_attr__( 'On Hover', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'grid,masonry,adjusted,bricks'
							)),
						)
					),
					# Client Items Caption Type
					array(
						'id' => 'ashade-client-caption-type',
						'name' => esc_attr__( 'Field for Captions', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'title' => esc_attr__( 'Use Title', 'ashade' ),
							'caption' => esc_attr__( 'Use Caption', 'ashade' ),
							'descr' => esc_attr__( 'Use Description', 'ashade' ),
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'grid,masonry,adjusted,bricks'
							)),
						)
					),

				# Tab Buttons
				array(
					'type' => 'heading',
					'name' => esc_attr__( 'Buttons and Filter', 'ashade' ),
					'desc' => '<span class="ashade-rwmb-tab">tab-client-buttons</span>'
				),
					# Buttons: Show Filter
					array(
						'id' => 'ashade-client-filter',
						'name' => esc_attr__( 'Show Filter?', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Show', 'ashade' ),
							false 	  => esc_attr__( 'Hide', 'ashade' )
						)
					),
					# Buttons: Show Filter Counter
					array(
						'id' => 'ashade-client-filter-counter',
						'name' => esc_attr__( 'Show Images Count (in filter)', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Show', 'ashade' ),
							false 	  => esc_attr__( 'Hide', 'ashade' )
						)
					),
					# Buttons: Approval Buttons
					array(
						'id' => 'ashade-client-btns-approval',
						'name' => esc_attr__( 'Show Approval Buttons?', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Show', 'ashade' ),
							false 	  => esc_attr__( 'Hide', 'ashade' )
						)
					),
					# Buttons: Zoom Button
					array(
						'id' => 'ashade-client-btns-zoom',
						'name' => esc_attr__( 'Show Image Zoom Button?', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Show', 'ashade' ),
							false 	  => esc_attr__( 'Hide', 'ashade' )
						)
					),
					# Buttons: Download Button
					array(
						'id' => 'ashade-client-btns-download',
						'name' => esc_attr__( 'Show Download Button?', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Show', 'ashade' ),
							false 	  => esc_attr__( 'Hide', 'ashade' )
						)
					),
					# Buttons Always Shown?
					array(
						'id' => 'ashade-client-btns-state',
						'name' => esc_attr__( 'Buttons State?', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Always Shown', 'ashade' ),
							false 	  => esc_attr__( 'Show on Hover', 'ashade' )
						)
					),
					
				# Tab Notify
				array(
					'type' => 'heading',
					'name' => esc_attr__( 'Notification Settings', 'ashade' ),
					'desc' => '<span class="ashade-rwmb-tab">tab-client-meta</span>'
				),
					# Notify: Button State
					array(
						'id' => 'ashade-client-notify',
						'name' => esc_attr__( 'Show Notify Button?', 'ashade' ),
						'desc' => ( class_exists( 'Shadow_Core' ) ? null : esc_attr__( 'Note: To use that function you need to install and activate Shadow Core Plugin.', 'ashade' )), 
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					# Notify: Email State
					array(
						'id' => 'ashade-client-email-state',
						'name' => esc_attr__( 'Use Default Email?', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							'custom'  => esc_attr__( 'Custom', 'ashade' ),
						)
					),
					# Notify: Email Address
					array(
						'id'    => 'ashade-client-email',
						'name' => esc_attr__('Email Address', 'ashade'),
						'type'  => 'text',
						'placeholder' => esc_attr__('email@example.com', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-client-email-state' => 'custom'
							)),
						)
					),
					# Notify: Include Links
					array(
						'id' => 'ashade-client-includes',
						'name' => esc_attr__( 'Include Images Links?', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),

				# Tab Page Layout
				array(
					'type' => 'heading',
					'name' => esc_attr__( 'Page Layout', 'ashade' ),
					'desc' => '<span class="ashade-rwmb-tab">tab-client-page-layout</span>'
				),
					# Spotlight
					array(
						'id' => 'ashade-spotlight',
						'name' => esc_attr__( 'Spotlight State', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					array(
						'type' => 'divider',
					),
					# Content Under Header
					array(
						'id' => 'ashade-client-cu',
						'name' => esc_attr__( 'Content Under Header', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					# Content Top Spacing
					array(
						'id' => 'ashade-client-pt',
						'name' => esc_attr__( 'Content Top Spacing', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					# Content Bottom Spacing
					array(
						'id' => 'ashade-client-pb',
						'name' => esc_attr__( 'Content Bottom Spacing', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					array(
						'type' => 'divider',
					),
					# Title and Back to Top Layout
					array(
						'id' => 'ashade-title-layout',
						'name' => esc_attr__( 'Title and Back to Top Layout', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' 	 => esc_attr__( 'Default', 'ashade' ),
							'vertical' 	 => esc_attr__( 'Vertical', 'ashade' ),
							'horizontal' => esc_attr__( 'Horizontal', 'ashade' )
						)
					),
					# Show Album Title
					array(
						'id' => 'ashade-client-title',
						'name' => esc_attr__( 'Show Page Title', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-albums-type' => 'default,grid,masonry,adjusted,bricks'
							)),
						)
					),
					# Show Back to Top
					array(
						'id' => 'ashade-back2top',
						'name' => esc_attr__( 'Back to Top', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					array(
						'type' => 'divider',
					),
					# Allow Comments
					array(
						'id' => 'ashade-client-comments',
						'name' => esc_attr__( 'Allow Comments?', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
			)
		);

		# Post General Settings
		$meta_boxes[] = array(
			'id'         => 'ashade-post-settings-general',
			'title'      => esc_attr__( 'Post Settings', 'ashade' ),
			'post_types' => 'post',
			'context'    => 'side',
			'closed' 	 => true,
			'fields' 	 => array(
				# Spotlight
				array(
					'id' => 'ashade-spotlight',
					'name' => esc_attr__( 'Spotlight State', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					)
				),
				array(
					'type' => 'divider',
				),
				# Content Under Header
				array(
					'id' => 'ashade-post-cu',
					'name' => esc_attr__( 'Content Under Header', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					)
				),
				# Content Top Spacing
				array(
					'id' => 'ashade-post-pt',
					'name' => esc_attr__( 'Content Top Spacing', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					)
				),
				# Content Bottom Spacing
				array(
					'id' => 'ashade-post-pb',
					'name' => esc_attr__( 'Content Bottom Spacing', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					)
				),
				array(
					'type' => 'divider',
				),
				# Title and Back to Top Layout
				array(
					'id' => 'ashade-title-layout',
					'name' => esc_attr__( 'Title and Back to Top Layout', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' 	 => esc_attr__( 'Default', 'ashade' ),
						'vertical' 	 => esc_attr__( 'Vertical', 'ashade' ),
						'horizontal' => esc_attr__( 'Horizontal', 'ashade' )
					)
				),
				# Show Album Title
				array(
					'id' => 'ashade-post-title',
					'name' => esc_attr__( 'Show Album Title', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					),
				),
				# Show Back to Top
				array(
					'id' => 'ashade-back2top',
					'name' => esc_attr__( 'Back to Top', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					)
				),
				array(
					'type' => 'divider',
				),
				array(
					'id' => 'ashade-sidebar-position',
					'name' => esc_attr__( 'Sidebar Position', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						'left' => esc_attr__( 'Left', 'ashade' ),
						'none' => esc_attr__( 'None', 'ashade' ),
						'right' => esc_attr__( 'Right', 'ashade' ),
					)
				),
				array(
					'type' => 'divider',
				),
				# Post Featured Image
				array(
					'id' => 'ashade-post-image',
					'name' => esc_attr__( 'Show Featured Image', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					),
				),
				# Post Navigation
				array(
					'id' => 'ashade-post-nav',
					'name' => esc_attr__( 'Post Navigation', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					),
				),
				# Post Allow Comments
				array(
					'id' => 'ashade-post-comments',
					'name' => esc_attr__( 'Allow Comments', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					),
				),
			)
		);
		# Post Meta Settings
		$meta_boxes[] = array(
			'id'         => 'ashade-post-settings-meta',
			'title'      => esc_attr__( 'Post Meta', 'ashade' ),
			'post_types' => 'post',
			'context'    => 'side',
			'closed' 	 => true,
			'fields' 	 => array(
				# Post Meta
				array(
					'id' => 'ashade-post-meta',
					'name' => esc_attr__( 'Show Post Meta', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					),
				),
				# Meta - Post Author
				array(
					'id' => 'ashade-post-meta-author',
					'name' => esc_attr__( 'Show Post Author', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					),
				),
				# Meta - Post Date
				array(
					'id' => 'ashade-post-meta-date',
					'name' => esc_attr__( 'Show Post Date', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					),
				),
				# Meta - Post Category
				array(
					'id' => 'ashade-post-meta-category',
					'name' => esc_attr__( 'Show Post Category', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					),
				),
				# Meta - Post Tags
				array(
					'id' => 'ashade-post-meta-tags',
					'name' => esc_attr__( 'Show Post Tags', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_attr__( 'Default', 'ashade' ),
						true 	  => esc_attr__( 'Yes', 'ashade' ),
						false 	  => esc_attr__( 'No', 'ashade' )
					),
				),
			)
		);

		# Maintenance Template Settings
		$meta_boxes[] = array(
			'id'         => 'ashade-maintenance-template-settings',
			'title'      => esc_attr__( 'Maintenance Settings', 'ashade' ),
			'post_types' => 'page',
			'class'		 => 'ashade-maintenance-template-rwmb',
			'context'    => 'normal',
			'fields' 	 => array(
				# Tab General
				array(
					'type' => 'heading',
					'name' => esc_attr__( 'Content Settings', 'ashade' ),
					'desc' => '<span class="ashade-rwmb-tab">tab-maintenance-general</span>'
				),
					# Spotlight
					array(
						'id' => 'ashade-spotlight-maintenance',
						'name' => esc_attr__( 'Spotlight State', 'ashade' ),
						'type' => 'select',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					# Menu State
					array(
						'id'   => 'ashade-maintenance-menu',
						'name' => esc_attr__( 'Main Menu State', 'ashade' ),
						'type' => 'select',
						'std'  => true,
						'options' => array(
							true 	  => esc_attr__( 'Show', 'ashade' ),
							false 	  => esc_attr__( 'Hide', 'ashade' )
						)
					),
					# Page Title
					array(
						'id'   => 'ashade-maintenance-title',
						'name' => esc_attr__( 'Page Title', 'ashade' ),
						'type' => 'select',
						'std' => 'default',
						'options' => array(
							'default' => esc_attr__( 'Default', 'ashade' ),
							true 	  => esc_attr__( 'Yes', 'ashade' ),
							false 	  => esc_attr__( 'No', 'ashade' )
						)
					),
					array(
						'type' => 'divider',
					),
					# Background Image
					array(
						'id' => 'ashade-maintenance-bg-image',
						'name' => esc_attr__('Select Background Image', 'ashade'),
						'type' => 'image_advanced',
						'force_delete' => false,
						'max_file_uploads' => 1,
						'max_status' => false,
						'image_size' => 'thumbnail',
					),
					# Background Opacity
					array(
						'name' => esc_attr__('Background Opacity', 'ashade'),
						'id'   => 'ashade-maintenance-bg-opacity',
						'type' => 'slider',
						'prefix' => false,
						'suffix' => ' %',
						'js_options' => array(
							'min'   => 0,
							'max'   => 100,
							'step'  => 1,
						),
						'std' => 13,
					),
					array(
						'type' => 'divider',
					),
					array(
						'name'       => esc_attr__( 'Select Date', 'ashade' ),
						'id'         => 'ashade-maintenance-date',
						'type'       => 'date',
						// Date picker options. See here http://api.jqueryui.com/datepicker
						'js_options' => array(
							'dateFormat'      => 'yy-mm-dd',
							'showButtonPanel' => false,
						),
						'save_format' => 'Y-m-d',
						'inline' => false,
						'timestamp' => false,
					),
					array(
						'type' => 'divider',
					),
					# Contacts List State
					array(
						'id'   	  => 'ashade-maintenance-contacts-list-state',
						'name'	  => esc_attr__( 'Show Contact Info List?', 'ashade' ),
						'type'	  => 'select',
						'options' => array(
							'yes' => esc_attr__( 'Yes', 'ashade' ),
							'no'  => esc_attr__( 'No', 'ashade' ),
						),
					),
					# Contacts List Overhead
					array(
						'id' => 'ashade-maintenance-contacts-list-overhead',
						'name' => esc_attr__('Contact List Overhead', 'ashade'),
						'type'  => 'text',
						'placeholder' => esc_attr__('Contact List Overhead', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-maintenance-contacts-list-state' => 'yes',
							)),
						)
					),
					# Contacts List Title
					array(
						'id' => 'ashade-maintenance-contacts-list-title',
						'name' => esc_attr__('Contact List Title', 'ashade'),
						'type'  => 'text',
						'placeholder' => esc_attr__('Contact List Title', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-maintenance-contacts-list-state' => 'yes',
							)),
						)
					),
					# Contacts List Icons
					array(
						'id'        => 'ashade-maintenance-contacts-list-icons',
						'name'      => esc_attr__('Show List Icons?', 'ashade'),
						'type'      => 'switch',						
						'style'     => 'rounded',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-maintenance-contacts-list-state' => 'yes',
							)),
						)
					),
					# Contacts List Address
					array(
						'id' => 'ashade-maintenance-contacts-list-location',
						'name' => esc_attr__('Your Address', 'ashade'),
						'type'  => 'text',
						'placeholder' => esc_attr__('Your Address', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-maintenance-contacts-list-state' => 'yes',
							)),
						)
					),
					# Contacts List Phone
					array(
						'id' => 'ashade-maintenance-contacts-list-phone',
						'name' => esc_attr__('Your Phone', 'ashade'),
						'type'  => 'text',
						'placeholder' => esc_attr__('Your Phone', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-maintenance-contacts-list-state' => 'yes',
							)),
						)
					),
					# Contacts List Email
					array(
						'id' => 'ashade-maintenance-contacts-list-email',
						'name' => esc_attr__('Your Email', 'ashade'),
						'type'  => 'text',
						'placeholder' => esc_attr__('Your Email', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-maintenance-contacts-list-state' => 'yes',
							)),
						)
					),
					# Contacts List Socials
					array(
						'id'        => 'ashade-maintenance-contacts-list-socials',
						'name'      => esc_attr__('Show Socials?', 'ashade'),
						'type'      => 'switch',						
						'style'     => 'rounded',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-maintenance-contacts-list-state' => 'yes',
							)),
						)
					),

				# Tab Contacts
				array(
					'type' => 'heading',
					'name' => esc_attr__( 'Contact Form Settings', 'ashade' ),
					'desc' => '<span class="ashade-rwmb-tab">tab-maintenance-contacts</span>'
				),
					# Contact State
					array(
						'id'   	  => 'ashade-maintenance-contacts-state',
						'name'	  => esc_attr__( 'Enable Contact Form?', 'ashade' ),
						'type'	  => 'select',
						'options' => array(
							'yes' => esc_attr__( 'Yes', 'ashade' ),
							'no'  => esc_attr__( 'No', 'ashade' ),
						),
					),
					array(
						'type' => 'divider',
					),
					# Contact Link Overhead
					array(
						'id' => 'ashade-maintenance-contacts-overhead',
						'name' => esc_attr__('Link Overhead', 'ashade'),
						'type'  => 'text',
						'std' => esc_attr__('Write Me Some', 'ashade'),
						'placeholder' => esc_attr__('Link Overhead', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-maintenance-contacts-state' => 'yes',
							)),
						)
					),
					# Contact Link Title
					array(
						'id' => 'ashade-maintenance-contacts-title',
						'name' => esc_attr__('Link Title', 'ashade'),
						'type'  => 'text',
						'std' => esc_attr__('Message', 'ashade'),
						'placeholder' => esc_attr__('Link Title', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-maintenance-contacts-state' => 'yes',
							)),
						)
					),
					array(
						'type' => 'divider',
					),
					# Contact Close Overhead
					array(
						'id' => 'ashade-maintenance-close-overhead',
						'name' => esc_attr__('Close Overhead', 'ashade'),
						'type'  => 'text',
						'std' => esc_attr__('Close And', 'ashade'),
						'placeholder' => esc_attr__('Link Overhead', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-maintenance-contacts-state' => 'yes',
							)),
						)
					),
					# Contact Close Title
					array(
						'id' => 'ashade-maintenance-close-title',
						'name' => esc_attr__('Close Title', 'ashade'),
						'type'  => 'text',
						'std' => esc_attr__('Return', 'ashade'),
						'placeholder' => esc_attr__('Link Title', 'ashade'),
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-maintenance-contacts-state' => 'yes',
							)),
						)
					),
					array(
						'type' => 'divider',
					),
					# Contacts Form Shortcode
					array(
						'id' => 'ashade-maintenance-shortcode',
						'name' => esc_attr__('Contact Form Shortcode', 'ashade'),
						'placeholder' => '[contact-form-7 id="2020" title="Contact form"]',
						'type'  => 'text',
						'attributes' => array(
							'data-ashade-condition' => json_encode(array(
								'ashade-maintenance-contacts-state' => 'yes',
							)),
						)
					),
			)
		);

		# Local Maintenance
		$meta_boxes[] = array(
			'id'         => 'ashade-page-settings-maintenance',
			'title'      => esc_html__( 'Maintenance Settings', 'ashade' ),
			'post_types' => 'page,post,ashade-albums',
			'context'    => 'side',
			'closed' 	 => true,
			'priority'   => 'low',
			'fields' 	 => array(
				# Maintenance Mode
				array(
					'id' => 'ashade-maintenance-mode',
					'name' => esc_html__( 'Maintenance Mode', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'ashade' ),
						true 	  => esc_html__( 'Yes', 'ashade' ),
						false 	  => esc_html__( 'No', 'ashade' )
					)
				),
				# Maintenance Background
				array(
					'id' => 'ashade-maintenance-bg-usage',
					'name' => esc_html__( 'Background Image', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default'  => esc_html__( 'Use Default', 'ashade' ),
						'featured' => esc_html__( 'Use Featured Image', 'ashade' ),
						'none'     => esc_html__( 'None', 'ashade' )
					),
					'attributes' => array(
						'data-ashade-condition' => json_encode(array(
							'ashade-maintenance-mode' => '1'
						)),
					)
				),
				# Overlay Opacity
				array(
					'name' => esc_html__('Background Opacity, %', 'ashade'),
					'id'   => 'ashade-maintenance-opacity',
					'type' => 'slider',
					'prefix' => false,
					'suffix' => ' %',
					'js_options' => array(
						'min'   => 0,
						'max'   => 100,
						'step'  => 1,
					),
					'std' => 10,
					'attributes' => array(
						'data-ashade-condition' => json_encode(array(
							'ashade-maintenance-mode' => '1',
							'ashade-maintenance-bg-usage' => 'featured'
						)),
					)
				),
				# Maintenance Counter Date
				array(
					'name'       => esc_html__( 'Countdown Date', 'ashade' ),
					'id'         => 'ashade-maintenance-page-date',
					'type'       => 'date',
					'js_options' => array(
						'dateFormat'      => 'yy-mm-dd',
						'showButtonPanel' => false,
					),
					'save_format' => 'Y-m-d',
					'inline' => false,
					'timestamp' => false,
					'attributes' => array(
						'data-ashade-condition' => json_encode(array(
							'ashade-maintenance-mode' => '1'
						)),
					)
				),
				# Maintenance Labels
				array(
					'id' => 'ashade-maintenance-labels',
					'name' => esc_html__( 'Show Countdown Labels', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'ashade' ),
						true 	  => esc_html__( 'Yes', 'ashade' ),
						false 	  => esc_html__( 'No', 'ashade' )
					),
					'attributes' => array(
						'data-ashade-condition' => json_encode(array(
							'ashade-maintenance-mode' => '1'
						)),
					)
				),
				array(
					'type' => 'divider',
				),
				# Maintenance Contact Widget
				array(
					'id' => 'ashade-maintenance-contact-widget',
					'name' => esc_html__( 'Show Contact Info', 'ashade' ),
					'type' => 'select',
					'options' => array(
						'default' => esc_html__( 'Default', 'ashade' ),
						true 	  => esc_html__( 'Custom', 'ashade' ),
						false 	  => esc_html__( 'No', 'ashade' )
					),
					'attributes' => array(
						'data-ashade-condition' => json_encode(array(
							'ashade-maintenance-mode' => '1'
						)),
					)
				),
				# Contacts List Overhead
				array(
					'id' => 'ashade-maintenance-contact-widget-overhead',
					'name' => esc_attr__('Contact List Overhead', 'ashade'),
					'type'  => 'text',
					'std' => Ashade_Core::get_mod('ashade-maintenance-contact-widget-overhead'),
					'placeholder' => esc_attr__('Contact List Overhead', 'ashade'),
					'attributes' => array(
						'data-ashade-condition' => json_encode(array(
							'ashade-maintenance-mode' => '1',
							'ashade-maintenance-contact-widget' => '1'
						)),
					)
				),
				# Contacts List Title
				array(
					'id' => 'ashade-maintenance-contact-widget-title',
					'name' => esc_attr__('Contact List Title', 'ashade'),
					'type'  => 'text',
					'std' => Ashade_Core::get_mod('ashade-maintenance-contact-widget-title'),
					'placeholder' => esc_attr__('Contact List Title', 'ashade'),
					'attributes' => array(
						'data-ashade-condition' => json_encode(array(
							'ashade-maintenance-mode' => '1',
							'ashade-maintenance-contact-widget' => '1'
						)),
					)
				),
				# Contacts List Icons
				array(
					'id'        => 'ashade-maintenance-contact-widget-icons',
					'name'      => esc_attr__('Show List Icons?', 'ashade'),
					'type'      => 'switch',
					'std'		=> 1,				
					'style'     => 'rounded',
					'attributes' => array(
						'data-ashade-condition' => json_encode(array(
							'ashade-maintenance-mode' => '1',
							'ashade-maintenance-contact-widget' => '1'
						)),
					)
				),
				# Contacts List Address
				array(
					'id' => 'ashade-maintenance-contact-widget-location',
					'name' => esc_attr__('Your Address', 'ashade'),
					'type'  => 'text',
					'placeholder' => esc_attr__('Your Address', 'ashade'),
					'std' => Ashade_Core::get_mod('ashade-maintenance-contact-widget-location'),
					'attributes' => array(
						'data-ashade-condition' => json_encode(array(
							'ashade-maintenance-mode' => '1',
							'ashade-maintenance-contact-widget' => '1'
						)),
					)
				),
				# Contacts List Phone
				array(
					'id' => 'ashade-maintenance-contact-widget-phone',
					'name' => esc_attr__('Your Phone', 'ashade'),
					'type'  => 'text',
					'std' => Ashade_Core::get_mod('ashade-maintenance-contact-widget-phone'),
					'placeholder' => esc_attr__('Your Phone', 'ashade'),
					'attributes' => array(
						'data-ashade-condition' => json_encode(array(
							'ashade-maintenance-mode' => '1',
							'ashade-maintenance-contact-widget' => '1'
						)),
					)
				),
				# Contacts List Email
				array(
					'id' => 'ashade-maintenance-contact-widget-email',
					'name' => esc_attr__('Your Email', 'ashade'),
					'type'  => 'text',
					'std' => Ashade_Core::get_mod('ashade-maintenance-contact-widget-email'),
					'placeholder' => esc_attr__('Your Email', 'ashade'),
					'attributes' => array(
						'data-ashade-condition' => json_encode(array(
							'ashade-maintenance-mode' => '1',
							'ashade-maintenance-contact-widget' => '1'
						)),
					)
				),
				# Contacts List Socials
				array(
					'id'        => 'ashade-maintenance-contact-widget-socials',
					'name'      => esc_attr__('Show Socials?', 'ashade'),
					'type'      => 'switch',						
					'style'     => 'rounded',
					'std'		=> 1,
					'attributes' => array(
						'data-ashade-condition' => json_encode(array(
							'ashade-maintenance-mode' => '1',
							'ashade-maintenance-contact-widget' => '1'
						)),
					)
				),
			)
		);

		return $meta_boxes;
	}
}
?>