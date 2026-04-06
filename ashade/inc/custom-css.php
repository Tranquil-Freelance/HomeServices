<?php
/**
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Ashade_CSS' ) ) :
	final class Ashade_CSS {
		public static function get_value( $id ) {
			return Ashade_Core::get_mod( $id );
		}
		public static function get_font( $id ) {
			$font_style = '
				font-family: "'. esc_attr( self::get_value( $id . '-ff' ) ) .'";
				font-weight: '. absint( self::get_value( $id . '-fw' ) ) .';
				font-size: '. absint( self::get_value( $id . '-fs' ) ) .'px;
				line-height: '. absint( self::get_value( $id . '-lh' ) ) .'px;';
			if ( null !== self::get_value( $id . '-ls' ) ) {
				$font_style .= 'letter-spacing: '. absint( self::get_value( $id . '-fs' ) ) * ( self::get_value( $id . '-ls' )/1000 ) .'px;';
			}
			if ( null !== self::get_value( $id . '-u' ) ) {
				$font_style .= 'text-transform: '. ( self::get_value( $id . '-u' ) ? 'uppercase' : 'none' ) .';';
			}
			if ( null !== self::get_value( $id . '-i' ) ) {
				$font_style .= 'font-style: '. ( self::get_value( $id . '-i' ) ? 'italic' : 'normal' ) .';';
			}
			return $font_style;
		}
		public static function get_font_usage( $id ) {
			$usage =  self::get_value( $id . '-font' );
			$font_style = '
				font-family: "'. esc_attr( self::get_value( $usage . '-ff' ) ) .'";
				font-weight: '. absint( self::get_value( $usage . '-fw' ) ) .';
				font-size: '. absint( self::get_value( $id . '-fs' ) ) .'px;
				line-height: '. absint( self::get_value( $id . '-lh' ) ) .'px;';
			if ( null !== self::get_value( $id . '-ls' ) ) {
				$font_style .= 'letter-spacing: '. absint( self::get_value( $id . '-fs' ) ) * ( self::get_value( $id . '-ls' )/1000 ) .'px;';
			}
			if ( null !== self::get_value( $id . '-u' ) ) {
				$font_style .= 'text-transform: '. ( self::get_value( $id . '-u' ) ? 'uppercase' : 'none' ) .';';
			}
			if ( null !== self::get_value( $id . '-i' ) ) {
				$font_style .= 'font-style: '. ( self::get_value( $id . '-i' ) ? 'italic' : 'normal' ) .';';
			}
			return $font_style;
		}
		public static function get_overhead( $size ) {
			$overhead = '
				font-size: '. absint( self::get_value( 'ashade-overheads-' . $size . '-fs' ) ) .'px;
				line-height: '. absint( self::get_value( 'ashade-overheads-' . $size . '-lh' ) ) .'px;
				letter-spacing: '. absint( self::get_value( 'ashade-overheads-' . $size . '-fs' ) ) * ( self::get_value( 'ashade-overheads-' . $size . '-ls' )/1000 ) .'px;
				margin: 0 0 '. esc_attr( self::get_value( 'ashade-overheads-' . $size . '-bs' ) ) .'px 0;
			';
			return $overhead;
		}
		public static function get_heading( $size, $modofy = false ) {
			if ( ! $modofy ) {
				$modofy = 1;
			}
			$heading = '
			font-size: '. absint( self::get_value( 'ashade-headings-' . $size . '-fs' ) ) * $modofy . 'px;
			line-height: '. absint( self::get_value( 'ashade-headings-' . $size . '-lh' ) ) * $modofy . 'px;
			letter-spacing: '. absint( self::get_value( 'ashade-headings-' . $size . '-fs' ) ) * ( self::get_value( 'ashade-headings-' . $size . '-ls' )/1000 ) .'px;
			margin: 0 0 '. absint( self::get_value( 'ashade-headings-' . $size . '-bs' ) ) .'px 0;
			';

			return $heading;
		}
		public static function get_rgba( $hex, $alpha = null ) {
			$hex      = str_replace( '#', '', $hex );
			$length   = strlen( $hex );
			$rgb[ 'r' ] = hexdec( $length == 6 ? substr( $hex, 0, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 0, 1 ), 2 ) : 0 ) );
			$rgb[ 'g' ] = hexdec( $length == 6 ? substr( $hex, 2, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 1, 1 ), 2 ) : 0 ) );
			$rgb[ 'b' ] = hexdec( $length == 6 ? substr( $hex, 4, 2 ) : ( $length == 3 ? str_repeat( substr( $hex, 2, 1 ), 2 ) : 0 ) );

			if ( null !== $alpha ) {
				$rgb[ 'a' ] = $alpha;
			}

			return implode( array_keys( $rgb ) ) . '(' . implode( ', ', $rgb ) . ')';
		}

		public static function get_compare( $size, $type, $attr, $value ) {
			$check = absint( self::get_value( 'ashade-'. $type .'-' . $size . '-' . $attr ) );
			return ( $check < $value ? $check : $value);
		}
		public static function get_custom_css() {
			$ashade_styles = '';
			# Used for Body, Overlays, Input Background
			# 000000
			$color_scheme01 = self::get_value( 'ashade-color-scheme01' );

			# Used for Blocks Background, Aside Background
			# 17171B
			$color_scheme02 = self::get_value( 'ashade-color-scheme02' );

			# Used as Text Color in content and Inputs
			# 808080
			$color_scheme03 = self::get_value( 'ashade-color-scheme03' );

			# Used for Headings, Titles, Links, Main Menu, Some Hover Effects and bright Accents
			# FFFFFF
			$color_scheme04 = self::get_value( 'ashade-color-scheme04' );

			# Used for Overheads, Contact Icons Accent, etc
			# 5C5C60
			$color_scheme05 = self::get_value( 'ashade-color-scheme05' );

			# Used for Input and Buttons Borders, Table Borders, etc
			# 313133
			$color_scheme06 = self::get_value( 'ashade-color-scheme06' );

			# Logo
			$logo_padding = explode( "/", self::get_value( 'ashade-logo-padding' ) );
			$ashade_styles .= '
			header#ashade-header .ashade-header-inner {
				padding-top: '. $logo_padding[0] .'px;
				padding-bottom: '. $logo_padding[2] .'px;
			}
			.ashade-header--layout02 header#ashade-header .ashade-header-inner .ashade-logo-block {
				padding-bottom: '. $logo_padding[2] .'px;
			}
			';
			$ashade_styles .= '
			/* --- Text Logo --- */
			.ashade-text-logo {
				white-space: nowrap;
				color: '. esc_attr( self::get_value( 'ashade-logo-color' ) ) .';
				'. self::get_font( 'ashade-logo' ) .'
			}
			';

			# Body
			$ashade_styles .= '
			body.elementor-editor-active,
			body.elementor-page,
			body.elementor-page.elementor-default {
				--e-global-color-primary: '. esc_attr( $color_scheme04 ) .';
				--e-global-color-secondary: '. esc_attr( $color_scheme04 ) .'80;
				--e-global-color-text: '. esc_attr( $color_scheme03 ) .';
				--e-global-color-accent: '. esc_attr( $color_scheme04 ) .';
			}

			body {
				background: '. esc_attr( $color_scheme01 ) .';
				color: '. esc_attr( $color_scheme03 ) .';
				'. self::get_font( 'ashade-content' ) .'
			}
			body.ashade-spotlight--yes:before,
			body.has-spotlight:before {
				background: radial-gradient(ellipse at left top, '. self::get_value( 'ashade-spotlight-color' ) .' 0%, '. esc_attr( $color_scheme01 ) .'00 70%);
			}
			.shadowcore-price-item--head {
				background: radial-gradient(circle at left top, '. self::get_value( 'ashade-spotlight-color' ) .' 0%, '. self::get_value( 'ashade-spotlight-color' ) .'00 80%);
			}
			';

			# Header Background
			$header_bg_color = self::get_value( 'ashade-header-background' );
			$ashade_styles .= '
			body.ashade-header-sticky .ashade-header--solid .ashade-header-inner {
				background: '. esc_attr( self::get_rgba( $header_bg_color, 0 ) ) .';
			}
			body.ashade-header-sticky .ashade-header--solid.is-faded .ashade-header-inner {
				background: '. esc_attr( self::get_rgba( $header_bg_color, 1 ) ) .';
			}
			body.ashade-header-sticky .ashade-header--gradient .ashade-header-inner {
				background-image: linear-gradient(to bottom, '. esc_attr( self::get_rgba( $header_bg_color, 1 ) ) .' 0%, '. esc_attr( self::get_rgba( $header_bg_color, 0 ) ) .' 49%, '. esc_attr( self::get_rgba( $header_bg_color, 0 ) ) .' 100%);
			}
			';

			# Color Scheme
			$ashade_styles .= '
			/* --- Scheme Color 01 --- */
			.shadowcore-price-item-mp-label,
			.bypostauthor .ashade-post-author-label {
				color: '. esc_attr( $color_scheme01 ) .';
			}
			.ahshade-client-image-wrap,
			ul.ashade-select__list li,
			.shadowcore-before-after-divider {
				background: '. esc_attr( $color_scheme01 ) .';
			}
			.ashade-select,
			select,
			input,
			textarea {
				background: '. esc_attr( self::get_rgba( $color_scheme01, 0 ) ) .';
			}
			.ashade-radio-wrap:hover,
			.ashade-checkbox-wrap:hover,
			.ashade-select:hover,
			.is-active .ashade-select,
			input:focus,
			input:hover,
			textarea:hover,
			textarea:focus {
				background: '. esc_attr( self::get_rgba( $color_scheme01, 0.5 ) ) .';
			}
			.ashade-categories-overlay,
			.ashade-aside-overlay,
			.ashade-menu-overlay,
			.ashade-home-block-overlay {
				background: '. esc_attr( self::get_rgba( $color_scheme01, 0.85 ) ) .';
			}
			.ahshade-client-toolbar,
			.ashade-home-block-overlay {
				background: '. esc_attr( self::get_rgba( $color_scheme01, 0.75 ) ) .';
			}
			.ashade-albums-slider-wrap .ashade-album-item .ashade-button,
			.ashade-albums-carousel-wrap .ashade-album-item .ashade-button {
				border-color: '. esc_attr( $color_scheme04, 0.25 ) .';
				background: '. esc_attr( self::get_rgba( $color_scheme01, 0.2 ) ) .';
			}

			.ashade-albums-carousel .ashade-slide-caption {
				background: linear-gradient(180deg, '. esc_attr( self::get_rgba( $color_scheme01, 0 ) ) .' 0%, '. esc_attr( self::get_rgba( $color_scheme01, 0.7 ) ) .' 100%);
			}
			.ashade-albums-carousel-wrap .ashade-album-item__overlay,
			.ashade-albums-slider-wrap .ashade-album-item__overlay {
				background: linear-gradient(-90deg, '. esc_attr( self::get_rgba( $color_scheme01, 0 ) ) .' 0%, '. esc_attr( self::get_rgba( $color_scheme01, 1 ) ) .' 100%);
			}
			.ashade-grid-caption--on_photo .ashade-grid-caption,
			.ashade-grid-caption--on_hover .ashade-grid-caption {
				background: linear-gradient(180deg, '. esc_attr( self::get_rgba( $color_scheme01, 0 ) ) .' 0%, '. esc_attr( self::get_rgba( $color_scheme01, 0.75 ) ) .' 100%);
			}
			.ashade-grid-caption--on_photo .ashade-client-item .ashade-grid-caption,
			.ashade-grid-caption--on_hover .ashade-client-item .ashade-grid-caption {
				background: linear-gradient(180deg, '. esc_attr( self::get_rgba( $color_scheme01, 0 ) ) .' 0%, '. esc_attr( self::get_rgba( $color_scheme01, 0.5 ) ) .' 100%);
			}

			/* --- Scheme Color 02 --- */
			.shadowcore-price-item,
			.shadowcore-ribbon-item--image.no-post-thmb,
			.shadowcore-grid-image.no-post-thmb,
			.shadowcore-pli-image-add--yes .shadowcore-posts-listing--medium .shadowcore-pli-image.shadowcore-pli-image--port:before,
			.shadowcore-pli-image-add--yes .shadowcore-posts-listing--large .shadowcore-pli-image.shadowcore-pli-image--port:before,
			.ashade-filter-wrap.ashade-filter-counters li:after,
			.ashade-filter-wrap.ashade-filter-counters a:after,
			.ashade-filter-wrap.ashade-filter-counters .ashade-mobile-filter-value:after,
			.ashade-grid-item-holder,
			.thmb-size--medium .ashade-post-preview-content,
			body .elementor-progress-wrapper,
			tt,
			kbd,
			code,
			.ashade-comment-body,
			.ashade-service-item .ashade-service-item__content,
			.shadowcore-service-card__content,
			.shadowcore-testimonials-grid .shadowcore-testimonials-item__content,
			.calendar_wrap td,
			aside#ashade-aside,
			.calendar_wrap td,
			.wp-caption {
				background: '. esc_attr( $color_scheme02 ) .';
			}

			/* --- Scheme Color 03 --- */
			body .elementor-widget-toggle .elementor-toggle .elementor-tab-content,
			body .elementor-widget-tabs .elementor-tab-content,
			body .elementor-widget-accordion .elementor-accordion .elementor-tab-content,
			body .elementor-widget-text-editor,
			body .elementor-widget-icon-list .elementor-icon-list-item,
			body .elementor-widget-icon-list .elementor-icon-list-text,
			body .elementor-widget-image-box .elementor-image-box-content .elementor-image-box-description,
			body .elementor-widget-testimonial .elementor-testimonial-content,
			body .elementor-widget-icon-box .elementor-icon-box-content .elementor-icon-box-description,
			tt,
			kbd,
			code,
			pre,
			.ashade-comment-form p.comment-form-cookies-consent label,
			.ashade-comment-form .logged-in-as a,
			.ashade-comment-form .comment-notes,
			.ashade-comment-form .logged-in-as,
			.ashade-contact-details__list a,
			.widget_archive a,
			.widget_categories a,
			.widget_meta a,
			.widget_nav_menu a,
			.widget_pages a,
			.widget_recent_entries a,
			.widget_recent_comments a,
			ul.wp-block-archives-list a,
			ul.wp-block-categories-list a,
			ul.wp-block-latest-posts a,
			.ashade-select,
			.ashade-more-categories a,
			.ashade-comment-tools a,
			select,
			input,
			textarea,
			.shadowcore-pli-meta a,
			blockquote {
				color: '. esc_attr( $color_scheme03 ) .';
			}
			.ashade-contact-details__list li a svg path,
			.ashade-protected-form-inner .ashade-protected-input-wrap > a svg path,
			.ashade-post-navigation-wrap .ashade-post-nav-icon svg path,
			nav.pagination .nav-links a svg path,
			.ashade-select-wrap svg path,
			.ashade-search-form svg path {
				fill: '. esc_attr( $color_scheme03 ) .';
			}
			input::-webkit-input-placeholder {
				color: '. esc_attr( $color_scheme03 ) .';
			}
			input::-moz-placeholder {
				color: '. esc_attr( $color_scheme03 ) .';
			}
			input::-ms-input-placeholder {
				color: '. esc_attr( $color_scheme03 ) .';
			}
			textarea::-webkit-input-placeholder {
				color: '. esc_attr( $color_scheme03 ) .';
			}
			textarea::-moz-placeholder {
				color: '. esc_attr( $color_scheme03 ) .';
			}
			textarea::-ms-input-placeholder {
				color: '. esc_attr( $color_scheme03 ) .';
			}

			/* --- Scheme Color 04 --- */
			.shadowcore-progress-counter,
			.shadowcore-testimonials-item__author--name,
			.shadowcore-service-card__label,
			body .elementor-widget-tabs .elementor-tab-title.elementor-active,
			body .elementor-widget-toggle .elementor-toggle .elementor-tab-title.elementor-active,
			body .elementor-widget-accordion .elementor-accordion .elementor-tab-title.elementor-active,
			body .elementor-widget-progress .elementor-title,
			body .elementor-widget-counter .elementor-counter-number-wrapper,
			body .elementor-widget-icon-list .elementor-icon-list-icon i,
			body .elementor-widget-image-box .elementor-image-box-content .elementor-image-box-title,
			.ashade-client-notify-wrap .ashade-client-notify-message,
			.ashade-comment-form .logged-in-as a:hover,
			.ashade-comment-form label,
			.ashade-comment-form .comment-notes span.required,
			.ashade-comment-tools a:hover,
			.ashade-more-categories a.ashade-more-categories-close,
			.ashade-more-categories a:hover,
			.ashade-post__tags a,
			.post-nav-links span,
			nav.pagination .nav-links span.page-numbers.current,
			.post-nav-links a:hover,
			nav.pagination .nav-links a:hover,
			.ashade-nothing-found span,
			.ashade-contact-details__list a:hover,
			.calendar_wrap th
			.tagcloud a,
			.widget_rss cite,
			.ashade-aside-close:hover,
			ul.ashade-select__list li:hover,
			.ashade-contact-form__response,
			.ashade-button,
			button,
			input[type="button"],
			input[type="reset"],
			input[type="submit"],
			body .wp-block-file a.wp-block-file__button,
			blockquote cite,
			cite,
			a,
			a:hover,
			.ashade-smooth-scroll .wp-block-cover-image.has-parallax,
			.ashade-smooth-scroll .wp-block-cover.has-parallax,
			.wp-block-cover-image,
			.wp-block-cover,
			.calendar_wrap th,
			var {
				color: '. esc_attr( $color_scheme04 ) .';
			}
			a.ashade-mobile-menu-button svg rect {
				fill: '. esc_attr( $color_scheme04 ) .';
			}
			nav.ashade-nav ul li a {
				color: '. esc_attr( self::get_rgba( $color_scheme04, 0.5 ) ) .';
			}
			.ashade-footer-inner > div > .ashade-footer-menu-wrap .ashade-footer-menu li:hover > a,
			.ashade-footer-inner > div > .ashade-footer-menu-wrap .ashade-footer-menu li.current-menu-parent > a,
			.ashade-footer-inner > div > .ashade-footer-menu-wrap .ashade-footer-menu li.current-menu-item > a,
			.ashade-footer-inner > div > .ashade-footer-menu-wrap .ashade-footer-menu li.current-menu-ancestor > a,
			nav.ashade-nav ul.main-menu li:hover > a,
			nav.ashade-nav ul.main-menu li.current-menu-parent > a,
			nav.ashade-nav ul.main-menu li.current-menu-item > a,
			nav.ashade-nav ul.main-menu li.current-menu-ancestor > a {
				color: '. esc_attr( self::get_rgba( $color_scheme04, 1 ) ) .';
			}
			.shadowcore-coming-soon__count,
			body span.wpcf7-form-control-wrap span.wpcf7-not-valid-tip,
			body .elementor-widget-image-gallery .gallery-item .gallery-caption,
			body .elementor-widget-testimonial .elementor-testimonial-name,
			.widget_archive a[aria-current="page"],
			.widget_categories a[aria-current="page"],
			.widget_meta a[aria-current="page"],
			.widget_nav_menu a[aria-current="page"],
			.widget_pages a[aria-current="page"],
			.widget_recent_entries a[aria-current="page"],
			.widget_recent_comments a[aria-current="page"],
			.widget_rss a[aria-current="page"],
			ul.wp-block-archives-list a[aria-current="page"],
			ul.wp-block-categories-list a[aria-current="page"],
			ul.wp-block-latest-posts a[aria-current="page"],
			.widget_archive a:hover,
			.widget_categories a:hover,
			.widget_meta a:hover,
			.widget_nav_menu a:hover,
			.widget_pages a:hover,
			.widget_recent_entries a:hover,
			.widget_recent_comments a:hover,
			.widget_rss a:hover,
			ul.wp-block-archives-list a:hover,
			ul.wp-block-categories-list a:hover,
			ul.wp-block-latest-posts a:hover,
			.ashade-back-wrap.is-loaded .ashade-back.is-to-top:hover span:last-child,
			.ashade-back-wrap.is-loaded .ashade-back:hover span:last-child,
			body .elementor-widget-text-editor.elementor-drop-cap-view-framed .elementor-drop-cap,
			body .elementor-widget-text-editor.elementor-drop-cap-view-default .elementor-drop-cap,
			.is-dropcap::first-letter,
			.ashade-mobile-title-wrap h1 > span > span a:hover,
			.ashade-page-title-wrap h1 > span > span a:hover,
			.ashade-post-preview-footer .ashade-post-preview-footer--lp a:hover,
			.shadowcore-blog-listing .ashade-post-preview-title > span a:hover,
			.ashade-blog-listing .ashade-post-preview-title > span a:hover,
			.ashade-grid-caption,
			.shadowcore-grid-caption,
			nav.ashade-mobile-menu ul.main-menu > li > a,
			.ashade-cursor span.ashade-cursor-label,
			.calendar_wrap #prev,
			.calendar_wrap #next,
			.ashade-slider-prev,
			.ashade-slider-next,
			.ashade-counter-value,
			.ashade-home-link span:last-child,
			.ashade-back span:last-child,
			.ashade-progress-counter,
			.ashade-albums-carousel-wrap .ashade-album-item__title h2,
			.ashade-albums-carousel-wrap .ashade-album-item__title h2 span,
			.ashade-albums-slider-wrap .ashade-album-item__explore a,
			.ashade-albums-slider-wrap .ashade-album-item__title h2,
			.ashade-albums-slider-wrap .ashade-album-item__explore a span,
			.ashade-albums-slider-wrap .ashade-album-item__title h2 span,
			body .elementor-widget-icon-box .elementor-icon-box-content .elementor-icon-box-title,
			.shadowcore-pgi__title,
			.shadowcore-pri__title,
			.shadowcore-psi__title,
			.shadowcore-ribbon-caption,
			.shadowcore-kenburns-caption,
			.shadowcore-slider-caption,
			.shadowcore-price-item--heading,
			.shadowcore-price-item--price,
			.shadowcore-price-item--list-heading,
			h1, h2, h3, h4, h5, h6 {
				color: '. esc_attr( $color_scheme04 ) .';
			}

			.shadowcore-progress-item-wrap svg circle:last-child {
				stroke: '. esc_attr( $color_scheme04 ) .';
			}
			.ashade-contact-details__list li a:hover svg path,
			.ashade-socials a svg path,
			.ashade-protected-form-inner .ashade-protected-input-wrap > a:hover svg path,
			.ashade-post-navigation-wrap > div:hover .ashade-post-nav-icon svg path,
			nav.pagination .nav-links a:hover svg path,
			.ashade-search-form svg:hover path {
				fill: '. esc_attr( $color_scheme04 ) .';
			}
			body:not(.has-to-top) .ashade-back-wrap .ashade-back.is-to-top span:last-child,
			.ashade-home-link--works.is-inactive.is-loaded .ashade-home-link:hover span:first-child,
			.ashade-home-link--works.is-inactive.is-loaded span:first-child,
			.ashade-home-link--works.is-inactive span:first-child,
			.ashade-home-link--works span:first-child,
			.ashade-home-link--works.is-inactive.is-loaded .ashade-home-link:hover span:last-child,
			.ashade-home-link--works.is-inactive.is-loaded span:last-child,
			.ashade-home-link--works.is-inactive span:last-child,
			.ashade-home-link--works span:last-child,
			.ashade-home-link--contacts.is-inactive.is-loaded .ashade-home-link:hover span:first-child,
			.ashade-home-link--contacts.is-inactive.is-loaded span:first-child,
			.ashade-home-link--contacts.is-inactive span:first-child,
			.ashade-home-link--contacts span:first-child,
			.ashade-home-link--contacts.is-inactive.is-loaded .ashade-home-link:hover span:last-child,
			.ashade-home-link--contacts.is-inactive.is-loaded span:last-child,
			.ashade-home-link--contacts.is-inactive span:last-child,
			.ashade-home-link--contacts span:last-child,
			.ashade-back-wrap.is-loaded .ashade-back.in-action.is-to-top span:last-child,
			.ashade-back-wrap.is-loaded .ashade-back.in-action span:last-child,
			.has-to-top .ashade-back-wrap.is-loaded .ashade-back.in-action.is-to-top span:last-child,
			.has-to-top .ashade-back-wrap.is-loaded .ashade-back.in-action span:last-child,
			.ashade-back-wrap .ashade-back span:last-child {
				color: '. esc_attr( self::get_rgba( $color_scheme04, 0 ) ) .';
			}
			.shadowcore-price-item--price-descr,
			.ashade-albums-template--slider .ashade-page-title-wrap a,
			.ashade-albums-template--slider .ashade-page-title-wrap.is-loaded h1 span,
			.single-ashade-clients .ashade-page-title-wrap.is-loaded h1 span {
				color: '. esc_attr( self::get_rgba( $color_scheme04, 0.3 ) ) .';
			}
			.ashade-mobile-title-wrap h1,
			.ashade-page-title-wrap h1,
			.ashade-home-link--works.is-loaded span:last-child,
			.ashade-home-link--contacts.is-loaded span:last-child,
			.ashade-footer-inner a,
			.ashade-footer-inner,
			.ashade-back-wrap.is-loaded .ashade-back:not(.is-to-top) span:last-child,
			.has-to-top .ashade-back-wrap.is-loaded .ashade-back.is-to-top span:last-child {
				color: '. esc_attr( self::get_rgba( $color_scheme04, 0.5 ) ) .';
			}
			.ashade-home-link--works.is-loaded span:first-child,
			.ashade-home-link--contacts.is-loaded span:first-child {
				color: '. esc_attr( self::get_rgba( $color_scheme04, 0.6 ) ) .';
			}
			.shadowcore-slider-nav a,
			.ashade-404-text span {
				color: '. esc_attr( self::get_rgba( $color_scheme04, 0.75 ) ) .';
			}
			.ashade-home-link--works.is-loaded .ashade-home-link:hover span:first-child,
			.ashade-home-link--contacts.is-loaded .ashade-home-link:hover span:first-child {
				color: '. esc_attr( self::get_rgba( $color_scheme04, 0.8 ) ) .';
			}
			.shadowcore-slider-nav a:hover,
			.ashade-back-wrap.is-loaded .ashade-back:hover span:last-child,
			.ashade-footer-inner a:hover,
			.ashade-albums-template--slider .ashade-page-title-wrap a:hover {
				color: '. esc_attr( self::get_rgba( $color_scheme04, 1 ) ) .';
			}
			.ashade-home-link--works.is-loaded .ashade-home-link:hover span:last-child,
			.ashade-home-link--contacts.is-loaded .ashade-home-link:hover span:last-child {
				color: '. esc_attr( $color_scheme04 ) .';
			}
			.ashade-post-navigation-wrap > div:hover .ashade-post-nav-icon,
			.ashade-post__tags a:hover,
			.post-nav-links span,
			nav.pagination .nav-links span.page-numbers.current,
			.ashade-albums-carousel-wrap .ashade-album-item .ashade-button,
			.tagcloud a:hover,
			.ashade-button:hover,
			button:hover,
			input[type="button"]:hover,
			input[type="reset"]:hover,
			input[type="submit"]:hover,
			body .wp-block-file a.wp-block-file__button:hover {
				border-color: '. esc_attr( $color_scheme04 ) .';
			}
			.ashade-grid-item-holder span:before {
				border-color: transparent transparent transparent '. esc_attr( $color_scheme04 ) .';
			}
			.shadowcore-price-item-mp-label,
			.ashade-albums-carousel-progress > div,
			.ashade-aside-close:hover:before,
			.ashade-aside-close:hover:after,
			a.ashade-aside-toggler span,
			a.ashade-aside-toggler span:nth-child(2):before,
			a.ashade-aside-toggler span:nth-child(2):after {
				background: '. esc_attr( $color_scheme04 ) .';
			}
			.ashade-post-navigation-wrap.has-prev.has-next:before,
			.ashade-albums-slider-wrap .ashade-album-item__explore:before,
			.ashade-albums-slider-wrap .ashade-album-item__title:before,
			.ashade-albums-carousel-wrap .ashade-album-item__title:before,
			.ashade-home-link-wrap:before,
			body:not(.ashade-layout--horizontal) .ashade-back-wrap:before,
			body.ashade-layout--horizontal .ashade-back-wrap:before,
			body.ashade-layout--horizontal .ashade-page-title-wrap.ashade-page-title--is-alone h1:before,
			body.ashade-layout--horizontal .ashade-page-title-wrap.ashade-page-title--is-alone h1:after,
			.ashade-mobile-title-wrap h1 > span > span:before,
			.ashade-page-title-wrap h1 > span > span:before,
			nav.ashade-nav ul.sub-menu ul.sub-menu:before,
			.ashade-mobile-title-wrap:before,
			.ashade-page-title-wrap:before {
				background: '. esc_attr( self::get_rgba( $color_scheme04, 0.15 ) ) .';
			}
			.shadowcore-testimonials-carousel .tns-nav button {
				background: '. esc_attr( self::get_rgba( $color_scheme04, 0.25 ) ) .';
			}
			.shadowcore-testimonials-carousel .tns-nav button.tns-nav-active {
				background: '. esc_attr( self::get_rgba( $color_scheme04, 0.75 ) ) .';
			}
			.shadowcore-testimonials-carousel .tns-nav button:hover {
				background: '. esc_attr( self::get_rgba( $color_scheme04, 0.5 ) ) .';
			}
			#ashade-comments {
				border-color: '. esc_attr( self::get_rgba( $color_scheme04, 0.15 ) ) .';
			}
			body .swiper-pagination-bullet {
				background: '. esc_attr( $color_scheme04 ) .';
			}

			form.wpcf7-form.in-process:before {
				border-color: '. esc_attr( self::get_rgba( $color_scheme04, 0.5 ) ) .';
				border-top-color: '. esc_attr( self::get_rgba( $color_scheme04, 1 ) ) .';
			}

			/* --- Scheme Color 05 --- */
			body span.wpcf7-form-control-wrap span.wpcf7-not-valid-tip:before {
				border-color: transparent transparent '. esc_attr( $color_scheme05 ) .' transparent;
			}
			.shadowcore-coming-soon__label,
			.shadowcore-progress-label,
			.shadowcore-testimonials-item__author--name span,
			.shadowcore-service-card__label span,
			body .elementor-widget-tabs .elementor-tab-title,
			body .elementor-widget-toggle .elementor-toggle .elementor-tab-title,
			body .elementor-widget-accordion .elementor-accordion .elementor-tab-title,
			body .elementor-widget-testimonial .elementor-testimonial-job,
			body .elementor-widget-counter .elementor-counter-title,
			.calendar_wrap caption,
			ul.wp-block-categories-list li,
			.widget_categories li,
			.widget_pages li,
			.widget_nav_menu li,
			.widget_rss li,
			blockquote:before,
			.ashade-mobile-title-wrap h1 > span > span a,
			.ashade-page-title-wrap h1 > span > span a,
			.ashade-post-preview-footer .ashade-post-preview-footer--lp a,
			.shadowcore-blog-listing .ashade-post-preview-title > span a,
			.ashade-blog-listing .ashade-post-preview-title > span a,
			.ashade-post-preview-footer .ashade-post-preview-footer--lp,
			.ashade-counter-label,
			.ashade-progress-label,
			label,
			legend,
			.ashade-aside-close,
			blockquote:before,
			.ashade-back span:first-child,
			span.rss-date,
			h1 span,
			h2 span,
			h3 span,
			h4 span,
			h5 span,
			h6 span,
			.shadowcore-pgi__meta,
			.shadowcore-pli-meta div,
			time.wp-block-latest-comments__comment-date,
			time.wp-block-latest-posts__post-date,
			strike,
			.calendar_wrap caption,
			body .elementor-star-rating i:before,
			del {
				color: '. esc_attr( $color_scheme05 ) .';
			}
			body:not(.has-to-top) .ashade-back-wrap .ashade-back.is-to-top span:first-child,
			.ashade-back-wrap.is-loaded .ashade-back.in-action.is-to-top span:first-child,
			.ashade-back-wrap.is-loaded .ashade-back.in-action span:first-child,
			.has-to-top .ashade-back-wrap.is-loaded .ashade-back.in-action.is-to-top span:first-child,
			.has-to-top .ashade-back-wrap.is-loaded .ashade-back.in-action span:first-child,
			.ashade-back-wrap .ashade-back span:first-child {
				color: '. esc_attr( self::get_rgba( $color_scheme05, 0 ) ) .';
			}
			.ashade-back-wrap.is-loaded .ashade-back:not(.is-to-top) span:first-child,
			.has-to-top .ashade-back-wrap.is-loaded .ashade-back.is-to-top span:first-child {
				color: '. esc_attr( self::get_rgba( $color_scheme05, 1 ) ) .';
			}
			.shadowcore-ribbon-description,
			.shadowcore-kenburns-description,
			.shadowcore-slider-description,
			.shadowcore-psi__meta,
			.shadowcore-pri__meta,
			.ashade-back-wrap.ashade-ribbon-return.is-loaded .ashade-back:not(.is-to-top) span:first-child,
			.ashade-back-wrap.ashade-slider-return.is-loaded .ashade-back:not(.is-to-top) span:first-child {
				color: '. esc_attr( self::get_rgba( $color_scheme04, 0.7 ) ) .';
			}
			.ashade-back-wrap.ashade-ribbon-return.is-loaded .ashade-back:not(.is-to-top):hover span:first-child,
			.ashade-back-wrap.ashade-slider-return.is-loaded .ashade-back:not(.is-to-top):hover span:first-child {
				color: '. esc_attr( self::get_rgba( $color_scheme04, 1 ) ) .';
			}

			body span.wpcf7-form-control-wrap span.wpcf7-not-valid-tip,
			body .elementor-widget-progress .elementor-progress-wrapper .elementor-progress-bar,
			.bypostauthor .ashade-post-author-label,
			.ashade-checkbox-wrap:hover:before,
			.ashade-checkbox-wrap:hover:after,
			.ashade-radio-wrap:hover:before {
				background: '. esc_attr( $color_scheme05 ) .';
			}
			.post-nav-links a:hover,
			nav.pagination .nav-links a:hover,
			.ashade-contact-icon,
			.ashade-aside-close:before,
			.ashade-aside-close:after,
			.ashade-radio-wrap:hover,
			.ashade-checkbox-wrap:hover,
			.ashade-select:hover,
			.is-active .ashade-select,
			input:focus,
			input:hover,
			textarea:hover,
			textarea:focus,
			.is-active ul.ashade-select__list {
				border-color: '. esc_attr( $color_scheme05 ) .';
			}

			/* --- Scheme Color 06 --- */
			.shadowcore-progress-item-wrap svg circle:first-child {
				stroke: '. esc_attr( $color_scheme06 ) .';
			}
			body .elementor-toggle .elementor-tab-title,
			body .elementor-widget-tabs .elementor-tab-mobile-title,
			body .elementor-widget-tabs .elementor-tab-desktop-title.elementor-active,
			body .elementor-widget-tabs .elementor-tab-title:before,
			body .elementor-widget-tabs .elementor-tab-title:after,
			body .elementor-widget-tabs .elementor-tab-content,
			body .elementor-widget-tabs .elementor-tabs-content-wrapper,
			body .elementor-widget-tabs .elementor-tab-title:after,
			body .elementor-widget-tabs .elementor-tab-title:before,
			body .elementor-accordion .elementor-accordion-item,
			body .elementor-accordion .elementor-tab-content,
			body .elementor-toggle .elementor-tab-content,e
			body .elementor-toggle .elementor-tab-title,
			hr,
			.wp-caption,
			ul.ashade-select__list li,
			.ashade-post-navigation-wrap .ashade-post-nav-icon,
			.ashade-post__tags a,
			.post-nav-links a,
			nav.pagination .nav-links a,
			nav.pagination .nav-links span,
			.ashade-post-preview.sticky .ashade-preview-header:before,
			.tagcloud a,
			.ashade-radio-wrap,
			.ashade-checkbox-wrap,
			ul.ashade-select__list,
			.ashade-button,
			button,
			input[type="button"],
			input[type="reset"],
			input[type="submit"],
			body .wp-block-file a.wp-block-file__button,
			.ashade-select,
			select,
			input,
			textarea,
			table th,
			.wp-block-table.is-style-stripes {
				border-color: '. esc_attr( $color_scheme06 ) .';
			}
			.ashade-aside--right .calendar_wrap td,
			.ashade-comment-tools a.comment-edit-link:after,
			.ashade-comment-author__image,
			nav.pagination .nav-links > a:before,
			nav.pagination .nav-links > span:before,
			.ashade-albums-carousel-progress,
			.ashade-aside--right .calendar_wrap td,
			ul.wp-block-categories-list li ul:before,
			.widget_categories li ul:before,
			.widget_pages li ul:before,
			.widget_nav_menu li ul:before,
			.widget_rss li ul:before,
			.ashade-checkbox-wrap:before,
			.ashade-checkbox-wrap:after,
			.ashade-radio-wrap:before {
				background: '. esc_attr( $color_scheme06 ) .';
			}

			/* TYPOGRAPHY
			   ---------- */
			';

			# Main Menu
			$ashade_styles .= '
				/* --- Main Menu --- */
				nav.ashade-nav ul li a {
					'. self::get_font( 'ashade-menu' ) .'
				}
			';
			if ( self::get_value( 'ashade-menu-custom-colors' ) ) {
				$ashade_styles .= '
				nav.ashade-nav ul li a {
					color: '. esc_attr( self::get_rgba( self::get_value( 'ashade-menu-color-d' ), self::get_value( 'ashade-menu-color-do' )/100 ) ) .';
				}
				nav.ashade-nav ul.main-menu li:hover > a {
					color: '. esc_attr( self::get_rgba( self::get_value( 'ashade-menu-color-h' ), self::get_value( 'ashade-menu-color-ho' )/100 ) ) .';
				}
				nav.ashade-nav ul.main-menu li.current-menu-parent > a,
				nav.ashade-nav ul.main-menu li.current-menu-item > a,
				nav.ashade-nav ul.main-menu li.current-menu-ancestor > a {
					color: '. esc_attr( self::get_rgba( self::get_value( 'ashade-menu-color-a' ), self::get_value( 'ashade-menu-color-ao' )/100 ) ) .';
				}
				';
			}

			# Typography
			$ashade_styles .= '
			/* --- Content Typography --- */
			p,
			.ashade-widget--about__head {
				margin: 0 0 '. absint( self::get_value( 'ashade-content-spacing' ) ) .'px 0;
			}
			aside .ashade-widget--about__content,
			aside .ashade-widget p {
				font-size: '. ( absint( self::get_value( 'ashade-content-fs' ) ) - 1 ) .'px;
				line-height: '. absint( self::get_value( 'ashade-content-lh' ) ) .'px;
			}
			aside .ashade-widget--contacts .ashade-contact-details__list li {
				font-size: '. ( absint( self::get_value( 'ashade-content-fs' ) ) - 2 ) .'px;
			}
			a.ashade-category-more {
				font-size: '. absint( self::get_value( 'ashade-content-fs' ) ) .'px;
			}

			hr {
				margin-top: '. absint( self::get_value( 'ashade-content-spacing' ) )*2 .'px;
				margin-bottom: '. absint( self::get_value( 'ashade-content-spacing' ) )*2 .'px;
			}
			.wp-block-media-text,
			ul.wp-block-gallery,
			.wp-block-cover,
			.wp-block-cover.aligncenter,
			div.aligncenter.wp-block-cover,
			.wp-block-button,
			.ashade-widget p,
			.ashade-widget--contacts .ashade-contact-details__list {
				margin-bottom: '. absint( self::get_value( 'ashade-content-spacing' ) ) .'px;
			}
			.ashade-widget--contacts .ashade-contact-details__list {
				margin: 0;
			}
			';
			if ( self::get_value( 'ashade-content-custom-colors' ) ) {
				$ashade_styles .= '
				body,
				body .elementor-widget-toggle .elementor-toggle .elementor-tab-content,
				body .elementor-widget-tabs .elementor-tab-content,
				body .elementor-widget-accordion .elementor-accordion .elementor-tab-content,
				body .elementor-widget-text-editor,
				body .elementor-widget-icon-list .elementor-icon-list-item,
				body .elementor-widget-image-box .elementor-image-box-content .elementor-image-box-description,
				body .elementor-widget-testimonial .elementor-testimonial-content,
				body .elementor-widget-icon-box .elementor-icon-box-content .elementor-icon-box-description,
				.ashade-comment-form p.comment-form-cookies-consent label,
				.ashade-comment-form .logged-in-as a,
				.ashade-comment-form .comment-notes,
				.ashade-comment-form .logged-in-as,
				.ashade-contact-details__list a,
				.widget_archive a,
				.widget_categories a,
				.widget_meta a,
				.widget_nav_menu a,
				.widget_pages a,
				.widget_recent_entries a,
				.widget_recent_comments a,
				ul.wp-block-archives-list a,
				ul.wp-block-categories-list a,
				ul.wp-block-latest-posts a,
				.ashade-select,
				.ashade-more-categories a,
				.ashade-comment-tools a {
					color: '. esc_attr( self::get_value( 'ashade-content-color-text' ) ) .';
				}
				.ashade-protected-form-inner .ashade-protected-input-wrap > a svg path,
				.ashade-post-navigation-wrap .ashade-post-nav-icon svg path,
				nav.pagination .nav-links a svg path,
				.ashade-select-wrap svg path,
				.ashade-search-form svg path {
					fill: '. esc_attr( self::get_value( 'ashade-content-color-text' ) ) .';
				}
				a {
					color: '. esc_attr( self::get_value( 'ashade-content-color-link' ) ) .';
					transition: color 0.3s;
				}
				a:hover {
					color: '. esc_attr( self::get_value( 'ashade-content-color-hover' ) ) .';
				}
				';
			}
			$ashade_styles .= '
			/* --- Overheads Typography --- */
			.shadowcore-coming-soon__label,
			.shadowcore-progress-label,
			.shadowcore-testimonials-item__author--name span,
			.shadowcore-service-card__label span,
			body .elementor-widget-tabs .elementor-tab-title,
			body .elementor-widget-toggle .elementor-toggle .elementor-tab-title,
			body .elementor-widget-accordion .elementor-accordion .elementor-tab-title,
			body .elementor-widget-image-gallery .gallery-item .gallery-caption,
			body .elementor-widget-testimonial .elementor-testimonial-job,
			body .elementor-widget-counter .elementor-counter-title,
			.ashade-post-preview-footer .ashade-post-preview-footer--lp,
			.ashade-albums-slider-wrap .ashade-album-item__explore a span,
			.ashade-counter-label,
			.ashade-progress-label,
			.ashade-home-link span:first-child,
			label,
			legend,
			.ashade-aside-close,
			blockquote:before,
			.ashade-back span:first-child,
			span.rss-date,
			time.wp-block-latest-comments__comment-date,
			time.wp-block-latest-posts__post-date,
			.shadowcore-pli-meta div,
			.shadowcore-pgi__meta,
			.shadowcore-pri__meta,
			.shadowcore-psi__meta,
			.shadowcore-price-item--price-descr,
			.shadowcore-price-item--list-heading,
			h1 span,
			h2 span,
			h3 span,
			h4 span,
			h5 span,
			h6 span {
				font-family: '. esc_attr( self::get_value( 'ashade-overheads-ff' ) ) .';
				font-weight: '. esc_attr( self::get_value( 'ashade-overheads-fw' ) ) .';
				text-transform: '. ( self::get_value( 'ashade-overheads-u' ) ? 'uppercase' : 'none' ) .';
				font-style: '. ( self::get_value( 'ashade-overheads-i' ) ? 'italic' : 'normal' ) .';
			';
				if ( self::get_value( 'ashade-overheads-custom-colors' ) ) {
					$ashade_styles .= 'color: ' . esc_attr( self::get_value( 'ashade-overheads-color' ) );
				}
			$ashade_styles .= '
			}
			.ashade-counter-label,
			h1 span {
				'. self::get_overhead( 'h1' ) .'
			}
			.ashade-albums-slider .ashade-album-item__explore span,
			.ashade-home-link span:first-child,
			.ashade-back span:first-child,
			h2 span {
				'. self::get_overhead( 'h2' ) .'
			}
			.shadowcore-price-item--list-heading,
			.shadowcore-psi__meta,
			.shadowcore-pri__meta,
			h3 span {
				'. self::get_overhead( 'h3' ) .'
			}
			.shadowcore-price-item--price-descr,
			.shadowcore-pli-meta div,
			.shadowcore-service-card__label span,
			.ashade-post-preview-footer span,
			.ashade-post-preview-footer a,
			h4 span {
				'. self::get_overhead( 'h4' ) .'
			}
			.shadowcore-price-item-mp-label,
			.shadowcore-pgi__meta,
			h5 span {
				'. self::get_overhead( 'h5' ) .'
			}
			.shadowcore-testimonials-item__author--name span,
			body .elementor-widget-testimonial .elementor-testimonial-job,
			time.wp-block-latest-comments__comment-date,
			time.wp-block-latest-posts__post-date,
			h6 span {
				'. self::get_overhead( 'h6' ) .'
			}

			/* --- Headings Typography --- */
			.ashade-albums-slider .ashade-album-item__explore,
			.shadowcore-coming-soon__count,
			.shadowcore-progress-counter,
			.shadowcore-testimonials-item__author--name,
			.shadowcore-service-card__label,
			body .elementor-widget-heading .elementor-heading-title,
			body .elementor-widget-testimonial .elementor-testimonial-name,
			body .elementor-widget-counter .elementor-counter-number-wrapper,
			.ashade-grid-caption,
			.shadowcore-grid-caption,
			nav.ashade-mobile-menu ul.main-menu > li > a,
			.ashade-cursor span.ashade-cursor-label,
			.calendar_wrap #prev,
			.calendar_wrap #next,
			.ashade-slider-prev,
			.ashade-slider-next,
			.shadowcore-slider-nav a,
			.ashade-counter-value,
			.ashade-home-link span:last-child,
			body .elementor-widget-text-editor.elementor-drop-cap-view-framed .elementor-drop-cap,
			body .elementor-widget-text-editor.elementor-drop-cap-view-default .elementor-drop-cap,
			.is-dropcap::first-letter,
			.ashade-back span:last-child,
			.ashade-progress-counter,
			body .elementor-widget-image-box .elementor-image-box-content .elementor-image-box-title,
			body .elementor-widget-progress .elementor-title,
			.shadowcore-pgi__title,
			.shadowcore-psi__title,
			.shadowcore-pri__title,
			.shadowcore-ribbon-caption,
			.shadowcore-kenburns-caption,
			.shadowcore-slider-caption,
			.shadowcore-price-item--heading,
			.shadowcore-price-item--price-descr,
			.shadowcore-price-item--price,
			h1, h2, h3, h4, h5, h6 {
				font-family: '. esc_attr( self::get_value( 'ashade-headings-ff' ) ) .';
				font-weight: '. esc_attr( self::get_value( 'ashade-headings-fw' ) ) .';
				text-transform: '. ( self::get_value( 'ashade-headings-u' ) ? 'uppercase' : 'none' ) .';
				font-style: '. ( self::get_value( 'ashade-headings-i' ) ? 'italic' : 'normal' ) .';
				';
				if ( self::get_value( 'ashade-headings-custom-colors' ) ) {
					$ashade_styles .= 'color: ' . esc_attr( self::get_value( 'ashade-headings-color' ) );
				}
			$ashade_styles .= '
			}
			body .elementor-widget-text-editor.elementor-drop-cap-view-framed .elementor-drop-cap,
			body .elementor-widget-text-editor.elementor-drop-cap-view-default .elementor-drop-cap,
			body .elementor-widget-heading h1.elementor-heading-title,
			.elementor-widget-icon-box .elementor-icon-box-content h1.elementor-icon-box-title span,
			.is-dropcap::first-letter,
			h1 {
				'. self::get_heading( 'h1' ) .'
			}
			.shadowcore-price-item--price,
			body .elementor-widget-heading h2.elementor-heading-title,
			.elementor-widget-icon-box .elementor-icon-box-content h2.elementor-icon-box-title span,
			.ashade-albums-slider .ashade-album-item__explore,
			.ashade-home-link span:last-child,
			.ashade-back span:last-child,
			h2 {
				'. self::get_heading( 'h2' ) .'
			}
			.shadowcore-ribbon-caption,
			.shadowcore-kenburns-caption,
			.shadowcore-slider-caption,
			.shadowcore-psi__title,
			.shadowcore-pri__title,
			body .elementor-widget-heading h3.elementor-heading-title,
			.elementor-widget-icon-box .elementor-icon-box-content h3.elementor-icon-box-title span,
			h3 {
				'. self::get_heading( 'h3' ) .'
			}
			body .elementor-widget-heading h4.elementor-heading-title,
			.shadowcore-progress-counter,
			.shadowcore-service-card__label,
			.elementor-widget-icon-box .elementor-icon-box-content h4.elementor-icon-box-title span,
			.ashade-slider-prev,
			.ashade-slider-next,
			.shadowcore-slider-nav a,
			.ashade-progress-counter,
			h4 {
				'. self::get_heading( 'h4' ) .'
			}
			.shadowcore-price-item--heading,
			.shadowcore-pgi__title,
			body .elementor-widget-heading h5.elementor-heading-title,
			.elementor-widget-icon-box .elementor-icon-box-content h5.elementor-icon-box-title span,
			nav.ashade-mobile-menu ul.main-menu > li > a,
			h5 {
				'. self::get_heading( 'h5' ) .'
			}
			body .elementor-widget-heading h6.elementor-heading-title,
			.shadowcore-testimonials-item__author--name,
			body .elementor-widget-testimonial .elementor-testimonial-name,
			body .elementor-widget-progress .elementor-title,
			.elementor-widget-icon-box .elementor-icon-box-content h6.elementor-icon-box-title span,
			.calendar_wrap #prev,
			.calendar_wrap #next,
			h6 {
				'. self::get_heading( 'h6' ) .'
			}
			.shadowcore-ribbon-caption,
			.shadowcore-kenburns-caption,
			.shadowcore-slider-caption,
			.shadowcore-psi__title,
			.shadowcore-pri__title,
			.shadowcore-pgi__title,
			body .elementor-widget-heading h1.elementor-heading-title:last-child,
			body .elementor-widget-heading h2.elementor-heading-title:last-child,
			body .elementor-widget-heading h3.elementor-heading-title:last-child,
			body .elementor-widget-heading h4.elementor-heading-title:last-child,
			body .elementor-widget-heading h5.elementor-heading-title:last-child,
			body .elementor-widget-heading h6.elementor-heading-title:last-child,
			.ashade-col h1:last-child,
			.ashade-col h2:last-child,
			.ashade-col h3:last-child,
			.ashade-col h4:last-child,
			.ashade-col h5:last-child,
			.ashade-col h6:last-child {
				margin: 0;
			}

			/* --- Titles --- */
			.ashade-mobile-title-wrap h1,
			.ashade-page-title-wrap h1,
			.ashade-home-link-wrap span:last-child,
			.ashade-albums-carousel-wrap .ashade-album-item__title h2,
			.ashade-albums-slider-wrap .ashade-album-item__explore a,
			.ashade-albums-slider-wrap .ashade-album-item__title h2,
			.bypostauthor .ashade-post-author-label {
				font-family: '. esc_attr( self::get_value( 'ashade-titles-ff' ) ) .';
				font-weight: '. esc_attr( self::get_value( 'ashade-titles-fw' ) ) .';
				text-transform: '. ( self::get_value( 'ashade-titles-u' ) ? 'uppercase' : 'none' ) .';
				font-style: '. ( self::get_value( 'ashade-titles-i' ) ? 'italic' : 'normal' ) .';
			}

			/* --- Blockquote Typography --- */
			blockquote {
				'. self::get_font_usage( 'ashade-quotes' ) .'
				padding: 0 0 0 '. absint( self::get_value( 'ashade-quotes-side-spacing' ) ) .'px;
				margin: 0 0 '. absint( self::get_value( 'ashade-quotes-spacing' ) ) .'px 0;
			}
			blockquote:before {
				font-size: '. absint( self::get_value( 'ashade-quotes-symbol-size' ) ) .'px;
				line-height: '. absint( self::get_value( 'ashade-quotes-symbol-size' ) ) .'px;
			}
			blockquote cite {
				'. self::get_font_usage( 'ashade-quotes-cite' ) .'
				text-align: '. esc_attr( self::get_value( 'ashade-quotes-cite-align' ) ) .';
				padding: '. absint( self::get_value( 'ashade-quotes-cite-spacing' ) ) .'px 0 0 0;
			}
			';
			if ( self::get_value( 'ashade-quotes-custom-colors' ) ) {
				$ashade_styles .= '
				blockquote {
					color: '. esc_attr( self::get_value( 'ashade-quotes-color-text' ) ) .';
				}
				blockquote:before {
					color: '. esc_attr( self::get_value( 'ashade-quotes-color-symbol' ) ) .';
				}
				cite,
				blockquote cite {
					color: '. esc_attr( self::get_value( 'ashade-quotes-color-cite' ) ) .';
				}
				';
			}

			$ashade_styles .= '
			/* --- Dropcap Typography --- */
			body .elementor-widget-text-editor.elementor-drop-cap-view-framed .elementor-drop-cap,
			body .elementor-widget-text-editor.elementor-drop-cap-view-default .elementor-drop-cap,
			.is-dropcap::first-letter {
				margin: '. esc_attr( self::get_value( 'ashade-dropcap-top-spacing' ) ) .'px '. esc_attr( self::get_value( 'ashade-dropcap-side-spacing' ) ) .'px '. esc_attr( self::get_value( 'ashade-dropcap-bottom-spacing' ) ) .'px 0;
				'. self::get_font_usage( 'ashade-dropcap' ) .'
				'. ( self::get_value( 'ashade-dropcap-custom-colors' ) ? 'color: ' . esc_attr( self::get_value( 'ashade-dropcap-color' ) ) . ';' : '' ) .'
			}
			';

			$table_padding = explode( "/", self::get_value( 'ashade-tables-cell-padding' ) );
			$ashade_styles .= '
			/* --- Table Typography --- */
			table {
				text-align: center;
				border-style: '. esc_attr( self::get_value( 'ashade-tables-bs' ) ) .';
				'. ( self::get_value( 'ashade-tables-bs' ) !== 'none' ? 'border-width: ' . esc_attr( self::get_value( 'ashade-tables-bw' ) ) . 'px;' : '' ) .'
				border-collapse: '. ( self::get_value( 'ashade-tables-collapse' ) ? 'collapse' : 'separate' ) .';
				margin: 0 0 '. esc_attr( self::get_value( 'ashade-tables-spacing' ) ) .'px 0;
			}
			table th,
			table td {
				border-style: '. esc_attr( self::get_value( 'ashade-tables-bs' ) ) .';
				'. ( self::get_value( 'ashade-tables-bs' ) !== 'none' ? 'border-width: ' . esc_attr( self::get_value( 'ashade-tables-bw' ) ) . 'px;' : '' ) .'
				padding: '. esc_attr( $table_padding[0] ) .'px '. esc_attr( $table_padding[1] ) .'px '. esc_attr( $table_padding[2] ) .'px '. esc_attr( $table_padding[3] ) .'px;
				text-align: '. esc_attr( self::get_value( 'ashade-tables-cell-align' ) ) .';
				vertical-align: '. esc_attr( self::get_value( 'ashade-tables-cell-valign' ) ) .';
			}
			';
			if ( self::get_value( 'ashade-tables-custom-colors' ) ) {
			$ashade_styles .= '
			table th,
			table td {
				background: '. esc_attr( self::get_value( 'ashade-tables-color-bg' ) ) .';
				color: '. esc_attr( self::get_value( 'ashade-tables-color-text' ) ) .';
			}
			table,
			.wp-block-table.is-style-stripes,
			table th,
			table td {
				border-color: '. esc_attr( self::get_value( 'ashade-tables-color-border' ) ) .';
			}
			table a {
				color: '. esc_attr( self::get_value( 'ashade-tables-color-link' ) ) .';
				transition: color 0.3s;
			}
			table a:hover {
				color: '. esc_attr( self::get_value( 'ashade-tables-color-hlink' ) ) .';
			}
			';
			}

			$list_padding = explode( "/", self::get_value( 'ashade-lists-padding' ) );
			$ashade_styles .= '
			/* --- List Typography --- */
			ol,
			ul {
				padding: 0 0 0 '. esc_attr( self::get_value( 'ashade-lists-side-spacing' ) ) .'px;
				margin: 0 0 '. esc_attr( self::get_value( 'ashade-lists-bottom-spacing' ) ) .'px 0;
			}
			ol li,
			ul li {
				padding: '. esc_attr( $list_padding[0] ) .'px '. esc_attr( $list_padding[1] ) .'px '. esc_attr( $list_padding[2] ) .'px '. esc_attr( $list_padding[3] ) .'px;
				'. ( self::get_value( 'ashade-lists-custom-colors' ) ? 'color: ' . esc_attr( self::get_value( 'ashade-lists-color-text' ) ) . ';' : '' ) .'
			}
			ul li {
				list-style: '. esc_attr( self::get_value( 'ashade-lists-style' ) ) .';
			}
			';
			if ( self::get_value( 'ashade-lists-custom-colors' ) ) {
			$ashade_styles .= '
			ol li a,
			ul li a {
				color: ' . esc_attr( self::get_value( 'ashade-lists-color-link' ) ) . ';
			}
			ol li a:hover,
			ul li a:hover {
				color: ' . esc_attr( self::get_value( 'ashade-lists-color-hlink' ) ) . ';
			}
			';
			}

			# Forms and Fields
			$input_br = explode( "/", self::get_value( 'ashade-input-br' ) );
			$input_padding = explode( "/", self::get_value( 'ashade-input-padding' ) );
			$ashade_styles .= '
			/* --- Forms and Fields --- */
			.ashade-select,
			select,
			input,
			textarea {
				height: '. absint( self::get_value( 'ashade-input-height' ) ) .'px;
				border-style: '. esc_attr( self::get_value( 'ashade-input-bs' ) ) .';
				'. ( self::get_value( 'ashade-input-bs' ) !== 'none' ? 'border-width: ' . esc_attr( self::get_value( 'ashade-input-bw' ) ) . 'px;' : '' ) .'
				border-radius: '. esc_attr( $input_br[0] ) .'px '. esc_attr( $input_br[1] ) .'px '. esc_attr( $input_br[2] ) .'px '. esc_attr( $input_br[3] ) .'px;
				padding: '. esc_attr( $input_padding[0] ) .'px '. esc_attr( $input_padding[1] ) .'px '. esc_attr( $input_padding[2] ) .'px '. esc_attr( $input_padding[3] ) .'px;
				margin: 0 0 '. absint( self::get_value( 'ashade-input-spacing' ) ) .'px 0;
				'. self::get_font_usage( 'ashade-input' ) .'
			}
			textarea {
				height: '. absint( self::get_value( 'ashade-textarea-height' ) ) .'px;
			}
			';
			if ( self::get_value( 'ashade-input-custom-colors' ) ) {
				$ashade_styles .= '
				input::-webkit-input-placeholder {
				color: '. esc_attr( self::get_value( 'ashade-input-color-text' ) ) .';
				}
				input::-moz-placeholder {
					color: '. esc_attr( self::get_value( 'ashade-input-color-text' ) ) .';
				}
				input::-ms-input-placeholder {
					color: '. esc_attr( self::get_value( 'ashade-input-color-text' ) ) .';
				}
				textarea::-webkit-input-placeholder {
					color: '. esc_attr( self::get_value( 'ashade-input-color-text' ) ) .';
				}
				textarea::-moz-placeholder {
					color: '. esc_attr( self::get_value( 'ashade-input-color-text' ) ) .';
				}
				textarea::-ms-input-placeholder {
					color: '. esc_attr( self::get_value( 'ashade-input-color-text' ) ) .';
				}
				.ashade-select,
				select,
				input,
				textarea {
					color: '. esc_attr( self::get_value( 'ashade-input-color-text' ) ) .';
					background-color: '. esc_attr( self::get_value( 'ashade-input-color-bg' ) ) .';
					border-color: '. esc_attr( self::get_value( 'ashade-input-color-border' ) ) .';
				}
				.ashade-select:hover,
				select:hover,
				input:hover,
				textarea:hover {
					color: '. esc_attr( self::get_value( 'ashade-input-color-htext' ) ) .';
					background-color: '. esc_attr( self::get_value( 'ashade-input-color-hbg' ) ) .';
					border-color: '. esc_attr( self::get_value( 'ashade-input-color-hborder' ) ) .';
				}
				.ashade-select:focus,
				select:focus,
				input:focus,
				textarea:focus {
					color: '. esc_attr( self::get_value( 'ashade-input-color-ftext' ) ) .';
					background-color: '. esc_attr( self::get_value( 'ashade-input-color-fbg' ) ) .';
					border-color: '. esc_attr( self::get_value( 'ashade-input-color-fborder' ) ) .';
				}
				';
			}

			$buttons_padding = explode( "/", self::get_value( 'ashade-button-padding' ) );
			$buttons_br = explode( "/", self::get_value( 'ashade-button-br' ) );
			$ashade_styles .= '
			.tagcloud a,
			.ashade-post__tags a,
			.ashade-button,
			button,
			input[type="button"],
			input[type="reset"],
			input[type="submit"],
			body .wp-block-file a.wp-block-file__button {
				height: '. absint( self::get_value( 'ashade-button-height' ) ) .'px;
				margin: 0 0 '. absint( self::get_value( 'ashade-button-spacing' ) ) .'px 0;
				background: transparent;
				border-style: '. esc_attr( self::get_value( 'ashade-button-bs' ) ) .';
				'. ( self::get_value( 'ashade-button-bs' ) !== 'none' ? 'border-width: ' . esc_attr( self::get_value( 'ashade-button-bw' ) ) . 'px;' : '' ) .'
				border-radius: '. esc_attr( $buttons_br[0] ) .'px '. esc_attr( $buttons_br[1] ) .'px '. esc_attr( $buttons_br[2] ) .'px '. esc_attr( $buttons_br[3] ) .'px;
				padding: '. esc_attr( $buttons_padding[0] ) .'px '. esc_attr( $buttons_padding[1] ) .'px '. esc_attr( $buttons_padding[2] ) .'px '. esc_attr( $buttons_padding[3] ) .'px;
				'. self::get_font_usage( 'ashade-button' ) .'
			}
			.ashade-comment-tools a {
				'. self::get_font_usage( 'ashade-button' ) .'
			}
			.ashade-comment-tools a {
				font-size: 12px;
				line-height: 20px;
			}
			';
			if ( self::get_value( 'ashade-button-custom-colors' ) ) {
			$ashade_styles .= '
			.ashade-button,
			button,
			input[type="button"],
			input[type="reset"],
			input[type="submit"],
			body .wp-block-file a.wp-block-file__button {
				color: '. esc_attr( self::get_value( 'ashade-button-color-text' ) ) .';
				background-color: '. esc_attr( self::get_value( 'ashade-button-color-bg' ) ) .';
				border-color: '. esc_attr( self::get_value( 'ashade-button-color-border' ) ) .';
			}
			.ashade-button:hover,
			button:hover,
			input[type="button"]:hover,
			input[type="reset"]:hover,
			input[type="submit"]:hover,
			body .wp-block-file a.wp-block-file__button:hover {
				color: '. esc_attr( self::get_value( 'ashade-button-color-htext' ) ) .';
				background-color: '. esc_attr( self::get_value( 'ashade-button-color-hbg' ) ) .';
				border-color: '. esc_attr( self::get_value( 'ashade-button-color-hborder' ) ) .';
			}
			';
			}
			$ashade_styles .= '
			body .wpcf7-response-output,
			body .wpcf7-response-output.wpcf7-validation-errors {
				color: '. esc_attr( $color_scheme04 ) .';
			}
			span.wpcf7-not-valid-tip,
			.wpcf7-response-output.wpcf7-validation-errors {
				'. self::get_font_usage( 'ashade-notify' ) .'
			}
			';
			if ( self::get_value( 'ashade-notify-custom-colors' ) ) {
				$ashade_styles .= '
				span.wpcf7-not-valid-tip {
					color: '. esc_attr( self::get_value( 'ashade-notify-color-error' ) ) .';
				}
				.wpcf7-response-output.wpcf7-validation-errors {
					color: '. esc_attr( self::get_value( 'ashade-notify-color-default' ) ) .';
				}
			';
			}

			# 404
			if ( self::get_value( 'ashade-404-custom-colors' ) ) {
			$ashade_styles .= '
				.ashade-404-text h1 {
					color: '. esc_attr( self::get_value( 'ashade-404-color-title' ) ) .';
				}
				.ashade-404-text span {
					color: '. esc_attr( self::get_value( 'ashade-404-color-text' ) ) .';
				}
			';
			}

			# Footer
			$footer_padding = explode( "/", self::get_value( 'ashade-footer-padding' ) );
			$ashade_styles .= '
			.ashade-footer-inner {
				'. self::get_font_usage( 'ashade-copyright' ) .'
				text-transform: none;
				font-style: normal;
				padding: '. esc_attr( $footer_padding[0] ) .'px '. esc_attr( $footer_padding[1] ) .'px '. esc_attr( $footer_padding[2] ) .'px '. esc_attr( $footer_padding[3] ) .'px;
			}
			.ashade-footer-inner .ashade-socials.ashade-socials--text {
				text-transform: '. ( self::get_value( 'ashade-socials-u' ) ? 'uppercase' : 'none' ) .';
				font-style: '. ( self::get_value( 'ashade-socials-i' ) ? 'italic' : 'normal' ) .';
			}
			.ashade-footer-inner .ashade-footer__copyright {
				text-transform: '. ( self::get_value( 'ashade-copyright-u' ) ? 'uppercase' : 'none' ) .';
				font-style: '. ( self::get_value( 'ashade-copyright-i' ) ? 'italic' : 'normal' ) .';
			}
			.ashade-footer-inner ul li {
				padding: 0;
				margin: 0 '. absint( self::get_value( 'ashade-socials-spacing' ) ) .'px 0 0;
				list-style: none;
			}
			.ashade-contact-details__list li a svg,
			.ashade-footer-inner ul.ashade-socials--icon a {
				width: '. absint( self::get_value( 'ashade-socials-size' ) ) .'px;
				height: '. absint( self::get_value( 'ashade-socials-size' ) ) .'px;
			}
			.ashade-footer-inner .ashade-footer-menu {
				text-transform: '. ( self::get_value( 'ashade-footer-menu-u' ) ? 'uppercase' : 'none' ) .';
				font-style: '. ( self::get_value( 'ashade-footer-menu-i' ) ? 'italic' : 'normal' ) .';
			}
			';
			if ( self::get_value( 'ashade-footer-menu-custom-colors' ) ) {
				$ashade_styles .= '
				.ashade-footer-inner > div > .ashade-footer-menu-wrap li > a {
					color: '. esc_attr( self::get_value( 'ashade-footer-menu-color' ) ) .';
				}
				.ashade-footer-inner > div > .ashade-footer-menu-wrap li:hover > a {
					color: '. esc_attr( self::get_value( 'ashade-footer-menu-hcolor' ) ) .';
				}
				.ashade-footer-inner > div > .ashade-footer-menu-wrap .ashade-footer-menu li:hover > a,
				.ashade-footer-inner > div > .ashade-footer-menu-wrap .ashade-footer-menu li.current-menu-parent > a,
				.ashade-footer-inner > div > .ashade-footer-menu-wrap .ashade-footer-menu li.current-menu-item > a,
				.ashade-footer-inner > div > .ashade-footer-menu-wrap .ashade-footer-menu li.current-menu-ancestor > a {
					color: '. esc_attr( self::get_value( 'ashade-footer-menu-acolor' ) ) .';
				}
				';
			}
			if ( self::get_value( 'ashade-copyright-custom-colors' ) ) {
				$ashade_styles .= '
				.ashade-footer-inner .ashade-footer__copyright {
					color: '. esc_attr( self::get_value( 'ashade-copyright-color-text' ) ) .';
				}
				.ashade-footer-inner .ashade-footer__copyright a {
					color: '. esc_attr( self::get_value( 'ashade-copyright-color-link' ) ) .';
				}
				.ashade-footer-inner .ashade-footer__copyright a:hover {
					color: '. esc_attr( self::get_value( 'ashade-copyright-color-hlink' ) ) .';
				}
				';
			}
			if ( self::get_value( 'ashade-socials-custom-colors' ) ) {
				$ashade_styles .= '
				.ashade-socials a {
					color: '. esc_attr( self::get_value( 'ashade-socials-color' ) ) .';
				}
				.ashade-socials a:hover {
					color: '. esc_attr( self::get_value( 'ashade-socials-hcolor' ) ) .';
				}
				.ashade-socials a svg path {
					fill: '. esc_attr( self::get_value( 'ashade-socials-color' ) ) .';
				}
				.ashade-socials a:hover svg path {
					fill: '. esc_attr( self::get_value( 'ashade-socials-hcolor' ) ) .';
				}
				';
			}

			# Additional
			$ashade_styles .= '
			.ashade-attachment-background.ashade-page-background {
				filter: blur('. esc_attr( self::get_value( 'ashade-attachment-blur' ) ) .'px);
			}
			.blocks-gallery-caption,
			.wp-block-embed figcaption,
			.wp-block-image figcaption {
				color: '. esc_attr( $color_scheme04 ) .';
			}
			';

			# Albums Grid Filter
			$ashade_styles .= '
				/* --- Main Menu --- */
				.ashade-filter-wrap a {
					color: '. esc_attr( self::get_rgba( $color_scheme04, 0.5 ) ) .';
					'. self::get_font( 'ashade-menu' ) .'
				}
				.ashade-filter-wrap a:hover,
				.ashade-filter-wrap a.is-active {
					color: '. esc_attr( self::get_rgba( $color_scheme04, 1 ) ) .';
				}
				.ashade-mobile-filter {
					border: 2px solid '. esc_attr( $color_scheme06 ) .';
					background: '. esc_attr( $color_scheme01 ) .';
				}
				.ashade-mobile-filter .ashade-mobile-filter-label {
					background: '. esc_attr( $color_scheme06 ) .';
					color: '. esc_attr( $color_scheme04 ) .';
				}
				.ashade-mobile-filter-wrap svg path {
					fill: '. esc_attr( $color_scheme04 ) .';
				}
				.ashade-mobile-filter-list {
					border: 2px solid '. esc_attr( $color_scheme06 ) .';
					background: '. esc_attr( $color_scheme01 ) .';
				}
				.ashade-mobile-filter-list li {
					border-top: 2px solid '. esc_attr( $color_scheme06 ) .';
				}
				.ashade-mobile-filter-list li.is-active {
					color: '. esc_attr( $color_scheme04 ) .';
				}
				.ashade-mobile-filter-list li:first-child {
					border-top: none;
				}
			';
			if ( self::get_value( 'ashade-menu-custom-colors' ) ) {
				$ashade_styles .= '
				nav.ashade-nav ul li a {
					color: '. esc_attr( self::get_rgba( self::get_value( 'ashade-menu-color-d' ), self::get_value( 'ashade-menu-color-do' )/100 ) ) .';
				}
				nav.ashade-nav ul.main-menu li:hover > a {
					color: '. esc_attr( self::get_rgba( self::get_value( 'ashade-menu-color-h' ), self::get_value( 'ashade-menu-color-ho' )/100 ) ) .';
				}
				';
			}

			# Elementor
			$ashade_styles .= '
			body .elementor-widget-heading .elementor-heading-title,
			body .elementor-widget-icon.elementor-view-framed .elementor-icon,
			body .elementor-widget-icon.elementor-view-default .elementor-icon {
				color: '. esc_attr( self::get_value( 'ashade-headings-custom-colors' ) ? self::get_value( 'ashade-headings-color' ) : $color_scheme04 ) .';
			}
			body .elementor-widget-heading .elementor-heading-title > span,
			body .elementor-widget-icon.elementor-view-framed .elementor-icon > span,
			body .elementor-widget-icon.elementor-view-default .elementor-icon > span {
				color: '. esc_attr( self::get_value( 'ashade-overheads-custom-colors' ) ? self::get_value( 'ashade-overheads-color' ) : $color_scheme05 ) .';
			}
			body .elementor-widget-icon-box.elementor-view-framed .elementor-icon,
			body .elementor-widget-icon-box.elementor-view-default .elementor-icon {
				fill: '. esc_attr( $color_scheme04 ) .';
				color: '. esc_attr( $color_scheme04 ) .';
				border-color: '. esc_attr( $color_scheme04 ) .';
			}
			body .elementor-widget-icon-box.elementor-view-stacked .elementor-icon {
				background: '. esc_attr( $color_scheme05 ) .';
			}
			body .elementor-widget-toggle .elementor-toggle .elementor-tab-content,
			body .elementor-widget-tabs .elementor-tab-content,
			body .elementor-widget-accordion .elementor-accordion .elementor-tab-content,
			body .elementor-widget-text-editor,
			body .elementor-widget-icon-list .elementor-icon-list-item,
			body .elementor-widget-image-box .elementor-image-box-content .elementor-image-box-description,
			body .elementor-widget-testimonial .elementor-testimonial-content,
			body .elementor-widget-icon-box .elementor-icon-box-content .elementor-icon-box-description {
				'. self::get_font( 'ashade-content' ) .'
			}
			';

			$buttons_padding = explode( "/", self::get_value( 'ashade-button-padding' ) );
			$buttons_br = explode( "/", self::get_value( 'ashade-button-br' ) );
			$ashade_styles .= '
			body .elementor-widget-button a.elementor-button,
			body .elementor-widget-button .elementor-button,
			body .elementor-button {
				color: '. esc_attr( $color_scheme04 ) .';
				background-color: '. esc_attr( $color_scheme06 ) .';
				margin: 0 0 '. absint( self::get_value( 'ashade-button-spacing' ) ) .'px 0;
				'. self::get_font_usage( 'ashade-button' ) .'
			}
			body .elementor-widget-button a.elementor-button:hover,
			body .elementor-widget-button .elementor-button:hover,
			body .elementor-button:hover {
				color: '. esc_attr( $color_scheme04 ) .';
				background-color: '. esc_attr( $color_scheme06 ) .';
			}
			body .elementor-button.elementor-size-md {
				height: '. absint( self::get_value( 'ashade-button-height' ) ) .'px;
				padding: '. esc_attr( $buttons_padding[0] ) .'px '. esc_attr( $buttons_padding[1] ) .'px '. esc_attr( $buttons_padding[2] ) .'px '. esc_attr( $buttons_padding[3] ) .'px;
				'. self::get_font_usage( 'ashade-button' ) .'
			}

			.shadowcore-progress-label {
				font-size: '. ( absint( self::get_value( 'ashade-content-fs' ) ) ) .'px;
				line-height: '. absint( self::get_value( 'ashade-content-lh' ) ) .'px;
			}
			';

			# Home Links
			if ( is_page_template( 'page-home.php' ) ) {
				if ( 'custom' == Ashade_Core::get_rwmb( 'ashade-home-custom-colors', 'default' ) ) {
					$ashade_styles .= '
						.ashade-home-link--works.is-loaded span:first-child,
						.ashade-home-link--contacts.is-loaded span:first-child {
							color: '. esc_attr( Ashade_Core::get_rwmb( 'ashade-home-color-link01' ) ) .';
						}
						.ashade-home-link--works.is-loaded .ashade-home-link:hover span:first-child,
						.ashade-home-link--contacts.is-loaded .ashade-home-link:hover span:first-child {
							color: '. esc_attr( Ashade_Core::get_rwmb( 'ashade-home-color-link01h' ) ) .';
						}
						.ashade-home-link--works.is-loaded span:last-child,
						.ashade-home-link--contacts.is-loaded span:last-child {
							color: '. esc_attr( Ashade_Core::get_rwmb( 'ashade-home-color-link02' ) ) .';
						}
						.ashade-home-link--works.is-loaded .ashade-home-link:hover span:last-child,
						.ashade-home-link--contacts.is-loaded .ashade-home-link:hover span:last-child {
							color: '. esc_attr( Ashade_Core::get_rwmb( 'ashade-home-color-link02h' ) ) .';
						}
					';
				}
				$ashade_styles .= '
				.ashade-home-link--works.ashade-home-link-wrap {
					left: calc('. esc_attr( Ashade_Core::get_rwmb( 'ashade-home-works-position', '33.33' ) ) .'% - 21px);
				}
				.ashade-home-link--contacts.ashade-home-link-wrap {
					left: calc('. esc_attr( Ashade_Core::get_rwmb( 'ashade-home-contacts-position', '66.66' ) ) .'% - 21px);
				}
				';
			}
            if ( 'custom' == Ashade_Core::get_rwmb( 'ashade-albums-slider-opacity-state', 'default' ) ) {
                $ashade_styles .= '
                .ashade-albums-slider .ashade-album-item .ashade-album-item__image {
                    opacity: '. esc_attr( Ashade_Core::get_rwmb( 'ashade-albums-slider-opacity', '75' ) * 0.01 ) .';
                }
                ';
            }
            if ( 'none' == Ashade_Core::get_rwmb( 'ashade-albums-slider-opacity-state', 'default' ) ) {
                $ashade_styles .= '
                .ashade-albums-slider .ashade-album-item .ashade-album-item__image {
                    opacity: 1;
                }
                ';
            }

			# WP Block
			$ashade_styles .= '
			.wp-block-button .wp-block-button__link {
				min-height: '. absint( self::get_value( 'ashade-button-height' ) ) .'px;
				margin: 0 0 '. absint( self::get_value( 'ashade-button-spacing' ) ) .'px 0;
				border-style: '. esc_attr( self::get_value( 'ashade-button-bs' ) ) .';
				'. ( self::get_value( 'ashade-button-bs' ) !== 'none' ? 'border-width: ' . esc_attr( self::get_value( 'ashade-button-bw' ) ) . 'px;' : '' ) .'
				border-radius: '. esc_attr( $buttons_br[0] ) .'px '. esc_attr( $buttons_br[1] ) .'px '. esc_attr( $buttons_br[2] ) .'px '. esc_attr( $buttons_br[3] ) .'px;
				padding: '. esc_attr( $buttons_padding[0] ) .'px '. esc_attr( $buttons_padding[1] ) .'px '. esc_attr( $buttons_padding[2] ) .'px '. esc_attr( $buttons_padding[3] ) .'px;
				'. self::get_font_usage( 'ashade-button' ) .'
			}
			.wp-block-button:not(.is-style-outline) .wp-block-button__link {
				border: none;
				line-height: '. ( absint( self::get_value( 'ashade-button-lh' ) ) + ( absint( self::get_value( 'ashade-button-bw' ) ) * 2 ) ) .'px;
			}
			.wp-block-button .wp-block-button__link:not(.has-text-color) {
				color: '. esc_attr( $color_scheme04 ) .';
			}
			.wp-block-button .wp-block-button__link:not(.has-background) {
				background-color: '. esc_attr( $color_scheme06 ) .';
			}
			.wp-block-button .wp-block-button__link:hover {
				border-color: '. esc_attr( $color_scheme04 ) .';
			}
			';
			if ( $buttons_br[0] == 0 && $buttons_br[1] == 0 && $buttons_br[2] == 0 && $buttons_br[3] == 0 ) {
				$ashade_styles .= '
					.wp-block-button .wp-block-button__link {
						border-radius: '. absint( self::get_value( 'ashade-button-height' ) )/2 .'px;
					}
				';
			}
			$ashade_styles .= '
			body .wp-block-button.is-style-outline .wp-block-button__link,
			body .wp-block-button.is-style-outline .wp-block-button__link:hover {
				background: transparent;
				border-color: initial;
			}
			body .wp-block-button.is-style-squared .wp-block-button__link {
				border-radius: 0;
			}
			';

			# Gallery Gaps and Border Radius
			if ( is_single() && 'ashade-albums' == get_post_type() ) {
				$al_type = Ashade_Core::get_rwmb( 'ashade-albums-type' );
				$custom_gap = false;
				$gap = false;
				$br = false;

				if ( 'default' === $al_type ) {
					// Default Album Settings
					$gapType = Ashade_Core::get_mod( 'ashade-albums-gap' );
					$o_br = json_decode( stripslashes( html_entity_decode( Ashade_Core::get_mod( 'ashade-albums-br' ) ) ), true );
					$br = array( $o_br['d'], $o_br['t'], $o_br['m'] );
					if ( $gapType == 'custom' ) {
						$custom_gap = true;
						$o_gap = json_decode( stripslashes( html_entity_decode( Ashade_Core::get_mod( 'ashade-albums-custom-gap' ) ) ), true );
						$gap = array( $o_gap['d'], $o_gap['t'], $o_gap['m'] );
					}
				} else {
					// Custom Values
					$gapType = Ashade_Core::get_rwmb( 'ashade-albums-gap', 'theme' );
					$br = explode('x', Ashade_Core::get_rwmb( 'ashade-albums-br', '0x0x0' ) );
					if ( $gapType == 'custom' ) {
						$custom_gap = true;
						$gap = explode('x', Ashade_Core::get_rwmb( 'ashade-albums-custom-gap' ) );
					}
				}
				if ( is_array( $br ) ) {
					$ashade_styles .= '
						.ashade-gallery-bricks .ashade-gallery-item,
						.ashade-grid .ashade-grid-item--inner,
						.justified-gallery > a, 
						.justified-gallery > div, 
						.justified-gallery > figure,
						.ashade-albums-carousel-wrap .ashade-album-item__inner {
							border-radius: '. absint($br[0] ) .'px;
						}
						@media only screen and (max-width: 1200px) {
							.ashade-gallery-bricks .ashade-gallery-item,
							.ashade-grid .ashade-grid-item--inner,
							.justified-gallery > a, 
							.justified-gallery > div, 
							.justified-gallery > figure,
							.ashade-albums-carousel-wrap .ashade-album-item__inner {
								border-radius: '. absint($br[1] ) .'px;
							}	
						}
						@media only screen and (max-width: 767px) {
							.ashade-gallery-bricks .ashade-gallery-item,
							.ashade-grid .ashade-grid-item--inner,
							.justified-gallery > a, 
							.justified-gallery > div, 
							.justified-gallery > figure,
							.ashade-albums-carousel-wrap .ashade-album-item__inner {
								border-radius: '. absint($br[2] ) .'px;
							}
						}
					';
				}
				if ( $custom_gap && is_array( $gap ) ) {
					$ashade_styles .= '
						.ashade-albums-carousel-wrap .ashade-album-item__inner {
							margin: 0 '. absint($gap[0]) .'px 0 0;
						}
						.ashade-albums-template--ribbon .ashade-albums-carousel-wrap .ashade-albums-carousel.is-vertical div.ashade-album-item .ashade-album-item__inner {
							margin: 0 0 '. absint($gap[0]) .'px 0;
						}
						.ashade-gallery-bricks,
						.ashade-grid {
							margin: -'. (0.5 * absint($gap[0])) .'px;
						}
						.ashade-gallery-bricks .ashade-gallery-item,
						.ashade-grid .ashade-grid-item {
							margin: '. (0.5 * absint($gap[0])) .'px;
						}
						.ashade-gallery-bricks.is-1x2 .ashade-gallery-item:nth-child(3n) {
							width: calc(100% - '. absint($gap[0]) .'px);
						}
						.ashade-gallery-bricks.is-1x2 .ashade-gallery-item,
						.ashade-grid-2cols .ashade-grid-item {
							width: calc(50% - '. absint($gap[0]) .'px);
						}
						.ashade-grid-3cols .ashade-grid-item {
							width: calc(33.33% - '. absint($gap[0]) .'px);
						}
						.ashade-grid-4cols .ashade-grid-item {
							width: calc(25% - '. absint($gap[0]) .'px);
						}

						@media only screen and (max-width: 1200px) {
							body .ashade-albums-carousel-wrap .ashade-album-item__inner {
								margin: 0 '. absint($gap[1]) .'px 0 0;
							}
							html .ashade-albums-template--ribbon .ashade-albums-carousel-wrap .ashade-albums-carousel.is-vertical div.ashade-album-item .ashade-album-item__inner {
								margin: 0 0 '. absint($gap[1]) .'px 0;
							}
							body .ashade-gallery-bricks,
							body .ashade-grid {
								margin: -'. (0.5 * absint($gap[1])) .'px;
							}
							body .ashade-gallery-bricks .ashade-gallery-item,
							body .ashade-grid .ashade-grid-item {
								margin: '. (0.5 * absint($gap[1])) .'px;
							}
							body .ashade-gallery-bricks.is-1x2 .ashade-gallery-item:nth-child(3n) {
								width: calc(100% - '. absint($gap[1]) .'px);
							}
							body .ashade-gallery-bricks.is-1x2 .ashade-gallery-item,
							body .ashade-grid-2cols .ashade-grid-item {
								width: calc(50% - '. absint($gap[1]) .'px);
							}
							body .ashade-grid-3cols .ashade-grid-item {
								width: calc(33.33% - '. absint($gap[1]) .'px);
							}
							body .ashade-grid-4cols .ashade-grid-item {
								width: calc(25% - '. absint($gap[1]) .'px);
							}
						}
						@media only screen and (max-width: 960px) {
							body .ashade-grid-2cols .ashade-grid-item,
							body .ashade-grid-3cols .ashade-grid-item,
							body .ashade-grid-4cols .ashade-grid-item,
							body .ashade-grid-5cols .ashade-grid-item {
								width: calc(50% - '. absint($gap[1]) .'px);
							}
						}
						@media only screen and (max-width: 767px) {
							body .ashade-albums-carousel-wrap .ashade-album-item__inner {
								margin: 0 '. absint($gap[2]) .'px 0 0;
							}
							html .ashade-albums-template--ribbon .ashade-albums-carousel-wrap .ashade-albums-carousel.is-vertical div.ashade-album-item .ashade-album-item__inner {
								margin: 0 0 '. absint($gap[2]) .'px 0;
							}
							body .ashade-gallery-bricks {
								margin: -'. (0.5 * absint($gap[2])) .'px;
							}
							body .ashade-grid {
								margin: -'. (0.5 * absint($gap[2])) .'px 0;
							}
							body .ashade-gallery-bricks .ashade-gallery-item {
								margin: '. (0.5 * absint($gap[2])) .'px;
							}
							body .ashade-grid .ashade-grid-item {
								margin: '. (0.5 * absint($gap[2])) .'px 0;
							}
							body .ashade-grid-2cols .ashade-grid-item,
							body .ashade-grid-3cols .ashade-grid-item,
							body .ashade-grid-4cols .ashade-grid-item {
								width: 100%;
							}
							body .ashade-gallery-bricks.is-1x2 .ashade-gallery-item:nth-child(3n) {
								width: calc(100% - '. absint($gap[2]) .'px);
							}
							body .ashade-gallery-bricks.is-2x3 .ashade-gallery-item.is-large,
							body .ashade-gallery-bricks.is-1x2 .ashade-gallery-item {
								width: calc(50% - '. absint($gap[2]) .'px);
							}
							body .ashade-gallery-bricks.is-2x3 .ashade-gallery-item.is-small {
								width: calc(33.33% - '. absint($gap[2]) .'px);
							}
						}
					';
				}
			}

			# Albums Listing Gaps and Border Radius
			if ( is_page() && is_page_template( 'page-albums.php' ) ) {
				$gapType = Ashade_Core::get_rwmb( 'ashade-al-gap', 'theme' );
				$br = explode('x', Ashade_Core::get_rwmb( 'ashade-al-br', '0x0x0' ) );
				if ( is_array( $br ) ) {
					$ashade_styles .= '
						.ashade-albums-carousel-wrap .ashade-album-item__inner,
						.ashade-album-item .ashade-album-item__image {
							border-radius: '. absint($br[0] ) .'px;
						}
						@media only screen and (max-width: 1200px) {
							.ashade-albums-carousel-wrap .ashade-album-item__inner,
							.ashade-album-item .ashade-album-item__image {
								border-radius: '. absint($br[1] ) .'px;
							}	
						}
						@media only screen and (max-width: 767px) {
							.ashade-albums-carousel-wrap .ashade-album-item__inner,
							.ashade-album-item .ashade-album-item__image {
								border-radius: '. absint($br[2] ) .'px;
							}
						}
					';
				}
				if ( $gapType == 'custom' ) {
					$custom_gap = true;
					$gap = explode('x', Ashade_Core::get_rwmb( 'ashade-al-custom-gap' ) );
					if ( $custom_gap && is_array( $gap ) ) {
						$ashade_styles .= '
						.ashade-grid {
							margin: -'. (0.5 * absint($gap[0])) .'px;
						}
						.ashade-grid .ashade-grid-item {
							margin: '. (0.5 * absint($gap[0])) .'px;
						}
						.ashade-grid-2cols .ashade-grid-item {
							width: calc(50% - '. absint($gap[0]) .'px);
						}
						.ashade-grid-3cols .ashade-grid-item {
							width: calc(33.33% - '. absint($gap[0]) .'px);
						}
						.ashade-grid-4cols .ashade-grid-item {
							width: calc(25% - '. absint($gap[0]) .'px);
						}
						.ashade-albums-carousel-wrap .ashade-album-item__inner {
							margin: 0 '. absint($gap[0]) .'px 0 0;
						}

						@media only screen and (max-width: 1200px) {
							body .ashade-grid {
								margin: -'. (0.5 * absint($gap[1])) .'px;
							}
							body .ashade-grid .ashade-grid-item {
								margin: '. (0.5 * absint($gap[1])) .'px;
							}
							body .ashade-grid-2cols .ashade-grid-item {
								width: calc(50% - '. absint($gap[1]) .'px);
							}
							body .ashade-grid-3cols .ashade-grid-item {
								width: calc(33.33% - '. absint($gap[1]) .'px);
							}
							body .ashade-grid-4cols .ashade-grid-item {
								width: calc(25% - '. absint($gap[1]) .'px);
							}
							body .ashade-grid-5cols .ashade-grid-item {
								width: calc(20% - '. absint($gap[1]) .'px);
							}
							body .ashade-albums-carousel-wrap .ashade-album-item__inner {
								margin: 0 '. absint($gap[1]) .'px 0 0;
							}
						}
						@media only screen and (max-width: 960px) {
							body .ashade-grid-2cols .ashade-grid-item,
							body .ashade-grid-3cols .ashade-grid-item,
							body .ashade-grid-4cols .ashade-grid-item,
							body .ashade-grid-5cols .ashade-grid-item {
								width: calc(50% - '. absint($gap[1]) .'px);
							}
						}
						@media only screen and (max-width: 767px) {
							body .ashade-grid {
								margin: -'. (0.5 * absint($gap[2])) .'px 0;
							}
							body .ashade-grid .ashade-grid-item {
								margin: '. (0.5 * absint($gap[2])) .'px 0;
							}
							body .ashade-grid-2cols .ashade-grid-item,
							body .ashade-grid-3cols .ashade-grid-item,
							body .ashade-grid-4cols .ashade-grid-item,
							body .ashade-grid-5cols .ashade-grid-item {
								width: 100%;
							}
							body .ashade-albums-carousel-wrap .ashade-album-item__inner {
								margin: 0 '. absint($gap[2]) .'px 0 0;
							}
						}
						';
					}
				}
			}

			# Home Template Gaps and Border Radius
			if ( is_page() && is_page_template( 'page-home.php' ) ) {
				if ( 'yes' == Ashade_Core::get_rwmb( 'ashade-home-works-state' ) ) { 
					$gapType = Ashade_Core::get_rwmb( 'ashade-home-works-gap', 'theme' );
					$br = explode('x', Ashade_Core::get_rwmb( 'ashade-home-works-br', '0x0x0' ) );
					if ( is_array( $br ) ) {
						$ashade_styles .= '
							#ashade-home-works .ashade-album-item__image {
								border-radius: '. absint($br[0] ) .'px;
							}
							@media only screen and (max-width: 1200px) {
								#ashade-home-works .ashade-album-item__image {
									border-radius: '. absint($br[1] ) .'px;
								}	
							}
							@media only screen and (max-width: 767px) {
								#ashade-home-works .ashade-album-item__image {
									border-radius: '. absint($br[2] ) .'px;
								}
							}
						';
					}
					if ( $gapType == 'custom' ) {
						$custom_gap = true;
						$gap = explode('x', Ashade_Core::get_rwmb( 'ashade-home-works-custom-gap' ) );
						if ( $custom_gap && is_array( $gap ) ) {
							$ashade_styles .= '
							.ashade-grid {
								margin: -'. (0.5 * absint($gap[0])) .'px;
							}
							.ashade-grid .ashade-grid-item {
								margin: '. (0.5 * absint($gap[0])) .'px;
							}
							.ashade-grid-2cols .ashade-grid-item {
								width: calc(50% - '. absint($gap[0]) .'px);
							}
							.ashade-grid-3cols .ashade-grid-item {
								width: calc(33.33% - '. absint($gap[0]) .'px);
							}
							.ashade-grid-4cols .ashade-grid-item {
								width: calc(25% - '. absint($gap[0]) .'px);
							}

							@media only screen and (max-width: 1200px) {
								body .ashade-grid {
									margin: -'. (0.5 * absint($gap[1])) .'px;
								}
								body .ashade-grid .ashade-grid-item {
									margin: '. (0.5 * absint($gap[1])) .'px;
								}
								body .ashade-grid-2cols .ashade-grid-item {
									width: calc(50% - '. absint($gap[1]) .'px);
								}
								body .ashade-grid-3cols .ashade-grid-item {
									width: calc(33.33% - '. absint($gap[1]) .'px);
								}
								body .ashade-grid-4cols .ashade-grid-item {
									width: calc(25% - '. absint($gap[1]) .'px);
								}
								body .ashade-grid-5cols .ashade-grid-item {
									width: calc(20% - '. absint($gap[1]) .'px);
								}
							}
							@media only screen and (max-width: 960px) {
								body .ashade-grid-2cols .ashade-grid-item,
								body .ashade-grid-3cols .ashade-grid-item,
								body .ashade-grid-4cols .ashade-grid-item,
								body .ashade-grid-5cols .ashade-grid-item {
									width: calc(50% - '. absint($gap[1]) .'px);
								}
							}
							@media only screen and (max-width: 767px) {
								body .ashade-grid {
									margin: -'. (0.5 * absint($gap[2])) .'px 0;
								}
								body .ashade-grid .ashade-grid-item {
									margin: '. (0.5 * absint($gap[2])) .'px 0;
								}
								body .ashade-grid-2cols .ashade-grid-item,
								body .ashade-grid-3cols .ashade-grid-item,
								body .ashade-grid-4cols .ashade-grid-item,
								body .ashade-grid-5cols .ashade-grid-item {
									width: 100%;
								}
							}
							';
						}
					}
				}
			}

			# Responsive
			$mobile_heading_modifier = 0.7;
			$ashade_styles .= '
			@media only screen and (max-width: 760px) {
				body,
				body .elementor-widget-toggle .elementor-toggle .elementor-tab-content,
				body .elementor-widget-tabs .elementor-tab-content,
				body .elementor-widget-accordion .elementor-accordion .elementor-tab-content,
				body .elementor-widget-text-editor,
				body .elementor-widget-icon-list .elementor-icon-list-item,
				body .elementor-widget-image-box .elementor-image-box-content .elementor-image-box-description,
				body .elementor-widget-testimonial .elementor-testimonial-content,
				body .elementor-widget-icon-box .elementor-icon-box-content .elementor-icon-box-description {
					font-size: '. ( absint( self::get_value( 'ashade-content-fs' ) ) - 1 ) .'px;
				}
				body .elementor-widget-text-editor.elementor-drop-cap-view-framed .elementor-drop-cap,
				body .elementor-widget-text-editor.elementor-drop-cap-view-default .elementor-drop-cap,
				body .elementor-widget-heading h1.elementor-heading-title,
				.elementor-widget-icon-box .elementor-icon-box-content h1.elementor-icon-box-title span,
				.is-dropcap::first-letter,
				body h1 {
					'. self::get_heading( 'h1', $mobile_heading_modifier ) .'
				}
				body .elementor-widget-heading h2.elementor-heading-title,
				.elementor-widget-icon-box .elementor-icon-box-content h2.elementor-icon-box-title span,
				.ashade-albums-slider .ashade-album-item__explore,
				.ashade-home-link span:last-child,
				.ashade-back span:last-child,
				body h2 {
					'. self::get_heading( 'h2', $mobile_heading_modifier ) .'
				}
				body .elementor-widget-heading h3.elementor-heading-title,
				.elementor-widget-icon-box .elementor-icon-box-content h3.elementor-icon-box-title span,
				body h3 {
					'. self::get_heading( 'h3', $mobile_heading_modifier ) .'
				}
				body .elementor-widget-heading h4.elementor-heading-title,
				.shadowcore-progress-counter,
				.shadowcore-service-card__label,
				.elementor-widget-icon-box .elementor-icon-box-content h4.elementor-icon-box-title span,
				.ashade-slider-prev,
				.ashade-slider-next,
				.shadowcore-slider-nav a,
				.ashade-progress-counter,
				body h4 {
					'. self::get_heading( 'h4', $mobile_heading_modifier ) .'
				}
				.shadowcore-pgi__title,
				body .elementor-widget-heading h5.elementor-heading-title,
				.elementor-widget-icon-box .elementor-icon-box-content h5.elementor-icon-box-title span,
				nav.ashade-mobile-menu ul.main-menu > li > a,
				body h5 {
					'. self::get_heading( 'h5', $mobile_heading_modifier ) .'
				}
				body .elementor-widget-heading h6.elementor-heading-title,
				.shadowcore-testimonials-item__author--name,
				body .elementor-widget-testimonial .elementor-testimonial-name,
				body .elementor-widget-progress .elementor-title,
				.elementor-widget-icon-box .elementor-icon-box-content h6.elementor-icon-box-title span,
				.calendar_wrap #prev,
				.calendar_wrap #next,
				body h6 {
					'. self::get_heading( 'h6', $mobile_heading_modifier ) .'
				}
			}
			';

			$ashade_styles .= '
			/* Adapting Font Sizes */
			@media only screen and (max-width: 1800px) {
				body:not(.ashade-albums-template--slider) .ashade-page-title-wrap h1 {
					font-size: '. self::get_compare( 'h1', 'headings' ,'fs', 50 ) .'px;
					line-height: '. self::get_compare( 'h1', 'headings', 'lh', 55 ) .'px;
				}
				body:not(.ashade-albums-template--slider) .ashade-page-title-wrap h1 span {
					font-size: '. self::get_compare( 'h1', 'overheads' ,'fs', 14 ) .'px;
					line-height: '. self::get_compare( 'h1', 'overheads', 'lh', 18 ) .'px;
				}
			}
			@media only screen and (max-width: 1200px) {
				/* --- Typography --- */
				.is-dropcap::first-letter,
				h1 {
					font-size: '. self::get_compare( 'h1', 'headings' ,'fs', 50 ) .'px;
					line-height: '. self::get_compare( 'h1', 'headings', 'lh', 55 ) .'px;
					margin: 0 0 35px 0;
				}
				h1 span {
					font-size: '. self::get_compare( 'h1', 'overheads' ,'fs', 14 ) .'px;
					line-height: '. self::get_compare( 'h1', 'overheads', 'lh', 18 ) .'px;
					margin: 0 0 0 0;
				}
				.ashade-albums-slider .ashade-album-item__explore,
				.ashade-home-link span:last-child,
				.ashade-back span:last-child,
				h2 {
					font-size: '. self::get_compare( 'h2', 'headings' ,'fs', 35 ) .'px;
					line-height: '. self::get_compare( 'h2', 'headings', 'lh', 40 ) .'px;
					margin: 0 0 30px 0;
				}
				h2 span {
					font-size: '. self::get_compare( 'h2', 'overheads' ,'fs', 12 ) .'px;
					line-height: '. self::get_compare( 'h2', 'overheads', 'lh', 15 ) .'px;
					margin: 0 0 1px 0;
				}
				.shadowcore-slider-nav a {
					font-size: '. self::get_compare( 'h3', 'headings' ,'fs', 30 ) .'px;
					line-height: '. self::get_compare( 'h3', 'headings', 'lh', 35 ) .'px;
					margin: 0;
				}
				.ashade-slider-prev,
				.ashade-slider-next,
				h3 {
					font-size: '. self::get_compare( 'h3', 'headings' ,'fs', 30 ) .'px;
					line-height: '. self::get_compare( 'h3', 'headings', 'lh', 35 ) .'px;
					margin: 0 0 35px 0;
				}
				h3 span {
					font-size: '. self::get_compare( 'h3', 'overheads' ,'fs', 12 ) .'px;
					line-height: '. self::get_compare( 'h3', 'overheads', 'lh', 15 ) .'px;
					margin: 0 0 1px 0;
				}
				h4 {
					font-size: '. self::get_compare( 'h4', 'headings' ,'fs', 24 ) .'px;
					line-height: '. self::get_compare( 'h4', 'headings', 'lh', 29 ) .'px;
					margin: 0 0 29px 0;
				}
				h4 span {
					font-size: '. self::get_compare( 'h4', 'overheads' ,'fs', 12 ) .'px;
					line-height: '. self::get_compare( 'h4', 'overheads', 'lh', 15 ) .'px;
					margin: 0 0 0 0;
				}
				h5 {
					font-size: '. self::get_compare( 'h5', 'headings' ,'fs', 20 ) .'px;
					line-height: '. self::get_compare( 'h5', 'headings', 'lh', 25 ) .'px;
					margin: 0 0 25px 0;
				}
				.shadowcore-price-item-mp-label,
				h5 span {
					font-size: '. self::get_compare( 'h5', 'overheads' ,'fs', 10 ) .'px;
					line-height: '. self::get_compare( 'h5', 'overheads', 'lh', 13 ) .'px;
					margin: 0 0 0 0;
				}
				h6 {
					font-size: '. self::get_compare( 'h6', 'headings' ,'fs', 18 ) .'px;
					line-height: '. self::get_compare( 'h6', 'headings', 'lh', 23 ) .'px;
					margin: 0 0 23px 0;
				}
				h6 span {
					font-size: '. self::get_compare( 'h6', 'overheads' ,'fs', 10 ) .'px;
					line-height: '. self::get_compare( 'h6', 'overheads', 'lh', 13 ) .'px;
					margin: 0 0 0 0;
				}
				.is-dropcap::first-letter {
					margin: 4px 15px 0 0;
				}
				#ashade-coming-soon h2 {
					font-size: '. self::get_compare( 'h2', 'headings' ,'fs', 60 ) .'px;
					line-height: '. self::get_compare( 'h2', 'headings', 'lh', 65 ) .'px;
				}
				/* Counter */
				.ashade-counter-label {
					font-size: '. self::get_compare( 'h3', 'overheads' ,'fs', 12 ) .'px;
					line-height: '. self::get_compare( 'h3', 'overheads', 'lh', 18 ) .'px;
				}
				.ashade-counter-value {
					font-size: '. self::get_compare( 'h1', 'headings' ,'fs', 60 ) .'px;
					line-height: '. self::get_compare( 'h1', 'headings', 'lh', 70 ) .'px;
				}
				.ashade-albums-slider-wrap .ashade-album-item__explore span {
					font-size: '. self::get_compare( 'h2', 'overheads' ,'fs', 12 ) .'px;
					line-height: '. self::get_compare( 'h2', 'overheads', 'lh', 15 ) .'px;
				}
				.ashade-progress-counter {
					font-size: '. self::get_compare( 'h4', 'headings' ,'fs', 24 ) .'px;
					line-height: '. self::get_compare( 'h4', 'headings', 'lh', 29 ) .'px;
				}
			}

			@media only screen and (max-width: 960px) {
				.ashade-mobile-menu-button {
					font-size: 32px;
					line-height: 30px;
				}
				.ashade-albums-carousel .ashade-album-item__title h2 {
					font-size: '. self::get_compare( 'h2', 'headings' ,'fs', 30 ) .'px;
					line-height: '. self::get_compare( 'h2', 'headings', 'lh', 35 ) .'px;
				}
				.ashade-albums-carousel .ashade-album-item__title h2 span {
					font-size: '. self::get_compare( 'h2', 'overheads' ,'fs', 12 ) .'px;
					line-height: '. self::get_compare( 'h2', 'overheads', 'lh', 14 ) .'px;
				}
				.ashade-progress-counter {
					font-size: '. self::get_compare( 'h4', 'headings' ,'fs', 20 ) .'px;
					line-height: '. self::get_compare( 'h4', 'headings', 'lh', 25 ) .'px;
				}
			}
			@media only screen and (max-width: 767px) {
				/* --- Typography --- */
				.is-dropcap::first-letter,
				h1 {
					font-size: '. self::get_compare( 'h1', 'headings' ,'fs', 40 ) .'px;
					line-height: '. self::get_compare( 'h1', 'headings', 'lh', 45 ) .'px;
					margin: 0 0 45px 0;
				}
				h1 span {
					font-size: '. self::get_compare( 'h1', 'overheads' ,'fs', 12 ) .'px;
					line-height: '. self::get_compare( 'h1', 'overheads', 'lh', 16 ) .'px;
					margin: 0 0 0 0;
				}
				.ashade-mobile-title-wrap h1 > span {
					margin: 0 0 6px 0;
				}
				h2 {
					font-size: '. self::get_compare( 'h2', 'headings' ,'fs', 35 ) .'px;
					line-height: '. self::get_compare( 'h2', 'headings', 'lh', 40 ) .'px;
					margin: 0 0 40px 0;
				}
				h3 {
					font-size: '. self::get_compare( 'h3', 'headings' ,'fs', 30 ) .'px;
					line-height: '. self::get_compare( 'h3', 'headings', 'lh', 35 ) .'px;
					margin: 0 0 35px 0;
				}
				h3 span {
					font-size: '. self::get_compare( 'h3', 'overheads' ,'fs', 12 ) .'px;
					line-height: '. self::get_compare( 'h3', 'overheads', 'lh', 15 ) .'px;
					margin: 0 0 1px 0;
				}
				.shadowcore-slider-nav a {
					font-size: '. self::get_compare( 'h4', 'headings' ,'fs', 24 ) .'px;
					line-height: '. self::get_compare( 'h4', 'headings', 'lh', 29 ) .'px;
					margin: 0;
				}
				.ashade-slider-prev,
				.ashade-slider-next,
				h4 {
					font-size: '. self::get_compare( 'h4', 'headings' ,'fs', 24 ) .'px;
					line-height: '. self::get_compare( 'h4', 'headings', 'lh', 29 ) .'px;
					margin: 0 0 29px 0;
				}
				h4 span {
					font-size: '. self::get_compare( 'h4', 'overheads' ,'fs', 12 ) .'px;
					line-height: '. self::get_compare( 'h4', 'overheads', 'lh', 15 ) .'px;
					margin: 0 0 0 0;
				}
				h5 {
					font-size: '. self::get_compare( 'h5', 'headings' ,'fs', 20 ) .'px;
					line-height: '. self::get_compare( 'h5', 'headings', 'lh', 25 ) .'px;
					margin: 0 0 25px 0;
				}
				.shadowcore-price-item-mp-label,
				h5 span {
					font-size: '. self::get_compare( 'h5', 'overheads' ,'fs', 10 ) .'px;
					line-height: '. self::get_compare( 'h5', 'overheads', 'lh', 13 ) .'px;
					margin: 0 0 0 0;
				}
				h6 {
					font-size: '. self::get_compare( 'h6', 'headings' ,'fs', 18 ) .'px;
					line-height: '. self::get_compare( 'h6', 'headings', 'lh', 23 ) .'px;
					margin: 0 0 23px 0;
				}
				h6 span {
					font-size: '. self::get_compare( 'h6', 'overheads' ,'fs', 10 ) .'px;
					line-height: '. self::get_compare( 'h6', 'overheads', 'lh', 13 ) .'px;
					margin: 0 0 0 0;
				}
				.is-dropcap::first-letter {
					margin: 4px 15px 0 0;
					font-size: '. self::get_compare( 'h1', 'headings' ,'fs', 50 ) .'px;
					line-height: '. self::get_compare( 'h1', 'headings', 'lh', 55 ) .'px;
				}
				#ashade-coming-soon h2 {
					font-size: '. self::get_compare( 'h2', 'headings' ,'fs', 35 ) .'px;
					line-height: '. self::get_compare( 'h2', 'headings', 'lh', 40 ) .'px;
				}
				#ashade-coming-soon span {
					font-size: '. self::get_compare( 'h2', 'overheads' ,'fs', 12 ) .'px;
					line-height: '. self::get_compare( 'h2', 'overheads', 'lh', 24 ) .'px;
				}
				.ashade-service-item__content-inner h3 {
					font-size: '. self::get_compare( 'h3', 'headings' ,'fs', 24 ) .'px;
					line-height: '. self::get_compare( 'h3', 'headings', 'lh', 29 ) .'px;
				}
				.ashade-mobile-title-wrap h1 {
					font-size: '. self::get_compare( 'h1', 'headings' ,'fs', 30 ) .'px;
					line-height: '. self::get_compare( 'h1', 'headings', 'lh', 35 ) .'px;
				}
				.ashade-albums-carousel-wrap .ashade-albums-carousel.is-medium .ashade-album-item a.ashade-button {
					font-size: '. self::get_compare( 'h2', 'overheads' ,'fs', 12 ) .'px;
					line-height: '. self::get_compare( 'h2', 'overheads', 'lh', 15 ) .'px;
				}
				.ashade-albums-slider .ashade-album-item__explore span,
				.ashade-home-link span:first-child,
				.ashade-back span:first-child {
					font-size: '. self::get_compare( 'h2', 'overheads' ,'fs', 10 ) .'px;
					line-height: '. self::get_compare( 'h2', 'overheads', 'lh', 13 ) .'px;
				}
				.ashade-albums-slider-wrap .ashade-album-item__title.is-loaded h2 span {
					font-size: '. self::get_compare( 'h2', 'overheads' ,'fs', 12 ) .'px;
					line-height: '. self::get_compare( 'h2', 'overheads', 'lh', 15 ) .'px;
				}
				.ashade-albums-slider-wrap .ashade-album-item__title.is-loaded h2,
				.ashade-albums-slider .ashade-album-item__explore,
				.ashade-home-link span:last-child,
				.ashade-back span:last-child {
					font-size: '. self::get_compare( 'h2', 'headings' ,'fs', 24 ) .'px;
					line-height: '. self::get_compare( 'h2', 'headings', 'lh', 29 ) .'px;
				}
				.ashade-page-title-wrap h1 {
					font-size: '. self::get_compare( 'h1', 'headings' ,'fs', 40 ) .'px;
					line-height: '. self::get_compare( 'h1', 'headings', 'lh', 45 ) .'px;
				}
				.ashade-page-title-wrap h1 span {
					font-size: '. self::get_compare( 'h1', 'overheads' ,'fs', 12 ) .'px;
					line-height: '. self::get_compare( 'h1', 'overheads', 'lh', 18 ) .'px;
				}
				.ashade-albums-template--slider .ashade-page-title-wrap h1 {
					font-size: '. self::get_compare( 'h1', 'headings' ,'fs', 30 ) .'px;
					line-height: '. self::get_compare( 'h1', 'headings', 'lh', 35 ) .'px;
				}
				.ashade-albums-carousel.is-medium .ashade-album-item__title h2,
				.ashade-albums-carousel .ashade-album-item__title h2 {
					font-size: '. self::get_compare( 'h2', 'headings' ,'fs', 20 ) .'px;
					line-height: '. self::get_compare( 'h2', 'headings', 'lh', 24 ) .'px;
				}
				.ashade-albums-carousel.is-medium .ashade-album-item__title h2 span {
					font-size: '. self::get_compare( 'h2', 'overheads' ,'fs', 10 ) .'px;
					line-height: '. self::get_compare( 'h2', 'overheads', 'lh', 15 ) .'px;
				}
				.ashade-service-card .ashade-service-card__label h4 {
					font-size: '. self::get_compare( 'h4', 'headings' ,'fs', 18 ) .'px;
					line-height: '. self::get_compare( 'h4', 'headings', 'lh', 23 ) .'px;
				}
				.ashade-service-card .ashade-service-card__label h4 span {
					font-size: '. self::get_compare( 'h4', 'overheads' ,'fs', 12 ) .'px;
					line-height: '. self::get_compare( 'h4', 'overheads', 'lh', 15 ) .'px;
				}
				.ashade-post-navigation-wrap h6 {
					font-size: '. self::get_compare( 'h6', 'headings' ,'fs', 16 ) .'px;
				}
			}
			@media only screen and (max-width: 359px) {
				.ashade-service-card .ashade-service-card__label h4 {
					font-size: '. self::get_compare( 'h4', 'headings' ,'fs', 16 ) .'px;
					line-height: '. self::get_compare( 'h4', 'headings', 'lh', 21 ) .'px;
				}
				.ashade-service-card .ashade-service-card__label h4 span {
					font-size: '. self::get_compare( 'h4', 'overheads' ,'fs', 10 ) .'px;
					line-height: '. self::get_compare( 'h4', 'overheads', 'lh', 13 ) .'px;
				}
			}
			';

			# WooCommerce Part
			if ( class_exists( 'WooCommerce' ) ) {
				$ashade_styles .= '
				/* GENERAL */
				.ashade-wc-loop-item__view h6 span {
					color: '. esc_attr( self::get_rgba( $color_scheme04, 0.5 ) ) .';
				}
				.ashade-wc-loop-item__view {
					background: '. esc_attr( self::get_rgba( $color_scheme01, 0.75 ) ) .';
				}

				fieldset {
					border: 2px solid '. $color_scheme06 .';
				}
				.ashade-wc-header-cart span {
					background-color: '. $color_scheme02 .';
				}
				a.ashade-wc-header-cart svg path {
					fill: '. esc_attr( self::get_rgba( $color_scheme04, 0.5 ) ) .';
				}
				a.ashade-wc-header-cart:hover svg path {
					fill: '. esc_attr( self::get_rgba( $color_scheme04, 1 ) ) .';
				}
				.ashade-wc-header-cart span,
				#add_payment_method #payment,
				.woocommerce-cart #payment,
				.woocommerce-checkout #payment,
				html .woocommerce form.checkout_coupon,
				html .woocommerce form.login,
				html .woocommerce form.register,
				.woocommerce-NoticeGroup,
				.woocommerce-form-coupon-toggle,
				.woocommerce-notices-wrapper > .woocommerce-notice,
				.woocommerce-notices-wrapper > .woocommerce-error,
				.woocommerce-notices-wrapper > .woocommerce-message,
				ul.ashade-cart-listing li {
					box-shadow: 0 0 10px '. esc_attr( self::get_rgba( $color_scheme01, 0.45 ) ) .';
				}
				html .woocommerce form .form-row .required {
					color: '. $color_scheme04 .';
				}
				html .woocommerce-error,
				html .woocommerce-info, .woocommerce-message {
					background-color: '. $color_scheme02 .';
					color: '. $color_scheme03 .';
				}
				.woocommerce #respond input#submit:disabled,
				.woocommerce #respond input#submit:disabled[disabled],
				.woocommerce a.button.disabled,
				.woocommerce a.button:disabled,
				.woocommerce a.button:disabled[disabled],
				.woocommerce button.button.disabled,
				.woocommerce button.button:disabled,
				.woocommerce button.button:disabled[disabled],
				.woocommerce button.button.alt.disabled,
				.woocommerce button.button.alt:disabled,
				.woocommerce button.button.alt:disabled[disabled],
				.woocommerce input.button.disabled,
				.woocommerce input.button:disabled,
				.woocommerce input.button:disabled[disabled],
				.ashade-single-product--tags > a,
				html .woocommerce #respond input#submit.alt,
				html .woocommerce a.button.alt,
				html .woocommerce button.button.alt,
				html .woocommerce input.button.alt,
				html .woocommerce #respond input#submit,
				html .woocommerce a.button,
				html .woocommerce button.button,
				html .woocommerce input.button {
					color: '. esc_attr( $color_scheme04 ) .';
					border-color: '. esc_attr( $color_scheme06 ) .';
					background: transparent;
				}
				.woocommerce #respond input#submit.disabled:hover,
				.woocommerce #respond input#submit:disabled:hover,
				.woocommerce #respond input#submit:disabled[disabled]:hover,
				.woocommerce a.button.disabled:hover,
				.woocommerce a.button:disabled:hover,
				.woocommerce a.button:disabled[disabled]:hover,
				.woocommerce button.button.disabled:hover,
				.woocommerce button.button:disabled:hover,
				.woocommerce button.button:disabled[disabled]:hover,
				.woocommerce input.button.disabled:hover,
				.woocommerce input.button:disabled:hover,
				.woocommerce input.button:disabled[disabled]:hover,
				.ashade-single-product--tags > a:hover,
				html .woocommerce #respond input#submit.alt:hover,
				html .woocommerce a.button.alt:hover,
				html .woocommerce button.button.alt:hover,
				html .woocommerce input.button.alt:hover,
				html .woocommerce #respond input#submit:hover,
				html .woocommerce a.button:hover,
				html .woocommerce button.button:hover,
				html .woocommerce input.button:hover {
					color: '. esc_attr( $color_scheme04 ) .';
					border-color: '. esc_attr( $color_scheme04 ) .';
					background: transparent;
				}
				.ashade-single-product--tags > a,
				html .woocommerce #respond input#submit.alt,
				html .woocommerce a.button.alt,
				html .woocommerce button.button.alt,
				html .woocommerce input.button.alt,
				html .woocommerce #respond input#submit,
				html .woocommerce a.button,
				html .woocommerce button.button,
				html .woocommerce button.button:disabled[disabled],
				html .woocommerce input.button {
					height: '. absint( self::get_value( 'ashade-button-height' ) ) .'px;
					margin: 0 0 '. absint( self::get_value( 'ashade-button-spacing' ) ) .'px 0;
					background: transparent;
					border-style: '. esc_attr( self::get_value( 'ashade-button-bs' ) ) .';
					'. ( self::get_value( 'ashade-button-bs' ) !== 'none' ? 'border-width: ' . esc_attr( self::get_value( 'ashade-button-bw' ) ) . 'px;' : '' ) .'
					border-radius: '. esc_attr( $buttons_br[0] ) .'px '. esc_attr( $buttons_br[1] ) .'px '. esc_attr( $buttons_br[2] ) .'px '. esc_attr( $buttons_br[3] ) .'px;
					padding: '. esc_attr( $buttons_padding[0] ) .'px '. esc_attr( $buttons_padding[1] ) .'px '. esc_attr( $buttons_padding[2] ) .'px '. esc_attr( $buttons_padding[3] ) .'px;
					'. self::get_font_usage( 'ashade-button' ) .'
				}
				.ashade-single-add2cart--qty > a {
					width: '. absint( self::get_value( 'ashade-button-height' ) ) .'px;
					height: '. absint( self::get_value( 'ashade-button-height' ) ) .'px;
					border-color: '. esc_attr( $color_scheme06 ) .';
					border-style: '. esc_attr( self::get_value( 'ashade-button-bs' ) ) .';
					'. ( self::get_value( 'ashade-button-bs' ) !== 'none' ? 'border-width: ' . esc_attr( self::get_value( 'ashade-button-bw' ) ) . 'px;' : '' ) .'
					background: transparent;
				}
				.ashade-single-add2cart--qty > a.ashade-single-add2cart--minus {
					'. ( self::get_value( 'ashade-button-bs' ) !== 'none' ? 'margin-right: -' . esc_attr( self::get_value( 'ashade-button-bw' ) ) . 'px;' : '' ) .'
				}
				.ashade-single-add2cart--qty > a.ashade-single-add2cart--plus {
					'. ( self::get_value( 'ashade-button-bs' ) !== 'none' ? 'margin-left: -' . esc_attr( self::get_value( 'ashade-button-bw' ) ) . 'px;' : '' ) .'
				}
				.ashade-single-add2cart--qty > a::before,
				.ashade-single-add2cart--qty > a::after {
					background-color: '. esc_attr( $color_scheme04 ) .';
				}
				.ashade-single-add2cart--qty > a:hover {
					color: '. esc_attr( $color_scheme04 ) .';
					border-color: '. esc_attr( $color_scheme04 ) .';
					background: transparent;
				}
				.ashade-single-add2cart--qty > a:hover::before,
				.ashade-single-add2cart--qty > a:hover::after {
					background-color: '. esc_attr( $color_scheme04 ) .';
				}
				.ashade-single-product--qty p.stock.in-stock {
					color: '. esc_attr( $color_scheme05 ) .';
				}
				';
				if ( self::get_value( 'ashade-button-custom-colors' ) ) {
					$ashade_styles .= '
					.woocommerce #respond input#submit.disabled,
					.woocommerce #respond input#submit:disabled,
					.woocommerce #respond input#submit:disabled[disabled],
					.woocommerce a.button.disabled,
					.woocommerce a.button:disabled,
					.woocommerce a.button:disabled[disabled],
					.woocommerce button.button.disabled,
					.woocommerce button.button:disabled,
					.woocommerce button.button:disabled[disabled],
					.woocommerce input.button.disabled,
					.woocommerce input.button:disabled,
					.woocommerce input.button:disabled[disabled],
					.ashade-single-product--tags > a,
					.ashade-single-add2cart--qty > a,
					html .woocommerce #respond input#submit.alt,
					html .woocommerce a.button.alt,
					html .woocommerce button.button.alt,
					html .woocommerce input.button.alt,
					html .woocommerce #respond input#submit,
					html .woocommerce a.button,
					html .woocommerce button.button,
					html .woocommerce input.button {
						color: '. esc_attr( self::get_value( 'ashade-button-color-text' ) ) .';
						background-color: '. esc_attr( self::get_value( 'ashade-button-color-bg' ) ) .';
						border-color: '. esc_attr( self::get_value( 'ashade-button-color-border' ) ) .';
					}
					.ashade-single-add2cart--qty > a::before,
					.ashade-single-add2cart--qty > a::after {
						background-color: '. esc_attr( self::get_value( 'ashade-button-color-text' ) ) .';
					}
					.woocommerce #respond input#submit.disabled:hover,
					.woocommerce #respond input#submit:disabled:hover,
					.woocommerce #respond input#submit:disabled[disabled]:hover,
					.woocommerce a.button.disabled:hover,
					.woocommerce a.button:disabled:hover,
					.woocommerce a.button:disabled[disabled]:hover,
					.woocommerce button.button.disabled:hover,
					.woocommerce button.button:disabled:hover,
					.woocommerce button.button:disabled[disabled]:hover,
					.woocommerce input.button.disabled:hover,
					.woocommerce input.button:disabled:hover,
					.woocommerce input.button:disabled[disabled]:hover,
					.ashade-single-product--tags > a:hover,
					.ashade-single-add2cart--qty > a:hover,
					html .woocommerce #respond input#submit.alt:hover,
					html .woocommerce a.button.alt:hover,
					html .woocommerce button.button.alt:hover,
					html .woocommerce input.button.alt:hover,
					html .woocommerce #respond input#submit:hover,
					html .woocommerce a.button:hover,
					html .woocommerce button.button:hover,
					html .woocommerce input.button:hover {
						color: '. esc_attr( self::get_value( 'ashade-button-color-htext' ) ) .';
						background-color: '. esc_attr( self::get_value( 'ashade-button-color-hbg' ) ) .';
						border-color: '. esc_attr( self::get_value( 'ashade-button-color-hborder' ) ) .';
					}
					.ashade-single-add2cart--qty > a:hover::before,
					.ashade-single-add2cart--qty > a:hover::after {
						background-color: '. esc_attr( self::get_value( 'ashade-button-color-htext' ) ) .';
					}
					';
				}

				$ashade_styles .= '
				/* --- SHOPPING CART --- */
				.ashade-cart-total--list li span:last-child {
					color: '. $color_scheme04 .';
					font-weight: '. absint( self::get_value( 'ashade-content-fw' ) ) .';
				}
				ul.woocommerce-checkout-review-order-table li.woocommerce-checkout-review-order-table--footer > ul,
				.ashade-wc-checkout-order > ul li,
				li.woocommerce-shipping-destination,
				li.ashade-shipping-methods,
				.ashade-cart-total--list li.order-total {
					border-top: 1px dashed '. $color_scheme06 .';
				}
				ul.ashade-cart-listing .woocommerce-cart-form__cart-item {
					background-color: '. esc_attr( $color_scheme02 ) .';
				}
				.ashade-cart-footer--lp > a {
					color: '. esc_attr( $color_scheme03 ) .';
				}
				.ashade-cart-footer--lp > a svg path {
					fill: '. esc_attr( $color_scheme03 ) .';
				}
				.ashade-cart-footer--lp > a:hover {
					color: '. esc_attr( $color_scheme04 ) .';
				}
				.ashade-cart-footer--lp > a:hover svg path {
					fill: '. esc_attr( $color_scheme04 ) .';
				}
				h5.ashade-cart-item--qty-label > span.woocommerce-Price-amount,
				h5.ashade-cart-item--qty-label > span.woocommerce-Price-amount .woocommerce-Price-currencySymbol {
					color: '. $color_scheme04 .';
					font-family: '. esc_attr( self::get_value( 'ashade-headings-ff' ) ) .';
					font-weight: '. esc_attr( self::get_value( 'ashade-headings-fw' ) ) .';
					text-transform: '. ( self::get_value( 'ashade-headings-u' ) ? 'uppercase' : 'none' ) .';
					font-style: '. ( self::get_value( 'ashade-headings-i' ) ? 'italic' : 'normal' ) .';
					'. self::get_heading( 'h5' );
					if ( self::get_value( 'ashade-headings-custom-colors' ) ) {
						$ashade_styles .= 'color: ' . esc_attr( self::get_value( 'ashade-headings-color' ) );
					}
				$ashade_styles .= '
					margin: 0;
				}

				.ashade-cart-item--qty-wrap > a {
					border: 2px solid '. $color_scheme06 .';
				}
				a.woocommerce-remove-coupon:before,
				a.woocommerce-remove-coupon:after,
				.ashade-cart-item--qty-wrap > a:before,
				.ashade-cart-item--qty-wrap > a:after,
				.woocommerce .ashade-cart-listing li a.ashade-cart-item--remove:before,
				.woocommerce .ashade-cart-listing li a.ashade-cart-item--remove:after {
					background: '. $color_scheme03 .';
				}
				a.woocommerce-remove-coupon:hover:before,
				a.woocommerce-remove-coupon:hover:after,
				.ashade-cart-item--qty-wrap > a:hover:before,
				.ashade-cart-item--qty-wrap > a:hover:after,
				.woocommerce .ashade-cart-listing li a.ashade-cart-item--remove:hover:before,
				.woocommerce .ashade-cart-listing li a.ashade-cart-item--remove:hover:after {
					background: '. $color_scheme04 .';
				}

				/* --- ORDER DETAILS --- */
				.woocommerce ul.order_details li strong span {
					color: '. esc_attr( $color_scheme04 ) .';
				}
				.woocommerce ul.order_details li {
					border-color: '. esc_attr( $color_scheme06 ) .';
				}
				.woocommerce ul.order_details li strong,
				.woocommerce ul.order_details li strong span {
					font-family: '. esc_attr( self::get_value( 'ashade-headings-ff' ) ) .';
					font-weight: '. esc_attr( self::get_value( 'ashade-headings-fw' ) ) .';
					text-transform: '. ( self::get_value( 'ashade-headings-u' ) ? 'uppercase' : 'none' ) .';
					font-style: '. ( self::get_value( 'ashade-headings-i' ) ? 'italic' : 'normal' ) .';
					';
					if ( self::get_value( 'ashade-headings-custom-colors' ) ) {
						$ashade_styles .= 'color: ' . esc_attr( self::get_value( 'ashade-headings-color' ) );
					}
				$ashade_styles .= '
					'. self::get_heading( 'h6' ) .'
				}
				.ashade-cart-total--list li.ashade-wc-total-address--edit > a.shipping-calculator-button {
					color: '. esc_attr( $color_scheme05 ) .';
				}
				.ashade-cart-total--list li.ashade-wc-total-address--edit > a.shipping-calculator-button:hover {
					color: '. esc_attr( $color_scheme04 ) .';
				}

				/* --- MY ACCOUNT --- */
				.woocommerce-MyAccount-navigation ul li a {
					color: '. esc_attr( $color_scheme03 ) .';
				}
				.woocommerce-MyAccount-navigation ul li.is-active a,
				.woocommerce-MyAccount-navigation ul li a:hover {
					color: '. esc_attr( $color_scheme04 ) .';
				}
				.woocommerce-account .addresses .title span a {
					color: '. esc_attr( $color_scheme05 ) .';
				}
				.woocommerce-account .addresses .title span a:hover {
					color: '. esc_attr( $color_scheme04 ) .';
				}
				.woocommerce-account .addresses .title {
					margin: 0 0 '. absint( self::get_value( 'ashade-headings-h4-bs' ) ) .'px 0;
				}
				.woocommerce-orders-table__cell span.woocommerce-Price-amount {
					color: '. esc_attr( $color_scheme04 ) .';
				}
				.woocommerce form p.form-row.ashade-wc-register-form--button {
					margin: '. absint( self::get_value( 'ashade-content-spacing' ) ) .'px 0 0 0;
				}
				.woocommerce form.ashade-wc-login-form p.form-row.ashade-wc-register-form--button {
					padding: '. absint( self::get_value( 'ashade-content-spacing' ) ) .'px 0 0 0;
				}
				.ashade-wc-login-form--footer .lost_password a,
				.ashade-wc-login-form--footer .woocommerce-LostPassword a {
					font-family: '. esc_attr( self::get_value( 'ashade-overheads-ff' ) ) .';
					font-weight: '. esc_attr( self::get_value( 'ashade-overheads-fw' ) ) .';
					text-transform: '. ( self::get_value( 'ashade-overheads-u' ) ? 'uppercase' : 'none' ) .';
					font-style: '. ( self::get_value( 'ashade-overheads-i' ) ? 'italic' : 'normal' ) .';
				';
					if ( self::get_value( 'ashade-overheads-custom-colors' ) ) {
						$ashade_styles .= 'color: ' . esc_attr( self::get_value( 'ashade-overheads-color' ) );
					}
				$ashade_styles .= '
				}

				/* --- PRODUCT SINGLE --- */
				table.ashade-wc-product-attributes th {
					'. self::get_font( 'ashade-content' ) .'
					color: '. $color_scheme04 .';
				}
				.ashade-woo-categories a {
					color: '. esc_attr( $color_scheme05 ) .';
				}
				.woocommerce div.product .ashade-wc-variations-form-wrap p.price,
				.woocommerce div.product .ashade-wc-variations-form-wrap span.price,
				.woocommerce div.product .ashade-single-product--price p.price,
				.woocommerce div.product .ashade-single-product--price p.price ins,
				.ashade-woo-categories a:hover {
					color: '. esc_attr( $color_scheme04 ) .';
				}
				.ashade-single-product--title .ashade-widget-rating > svg path {
					stroke: '. esc_attr( $color_scheme05 ) .';
				}
				.ashade-single-product--title .ashade-widget-rating span svg path {
					fill: '. esc_attr( $color_scheme05 ) .';
				}
				.woocommerce div.product .ashade-wc-variations-form-wrap p.price del,
				.woocommerce div.product .ashade-wc-variations-form-wrap span.price del,
				.woocommerce div.product .ashade-single-product--price p.price del,
				.ashade-single-product--title h3 > span a {
					color: '. esc_attr( $color_scheme05 ) .';
				}
				.ashade-single-product--title h3 > span a:hover {
					color: '. esc_attr( $color_scheme04 ) .';
				}
				.ashade-comment-tools a.comment-edit-link:before,
				.ashade-single-product--title h3 > span a:before {
					background: '. esc_attr( $color_scheme05 ) .';
				}
				';
				if ( self::get_value( 'ashade-input-custom-colors' ) ) {
					# Custom
					$ashade_styles .= '
					html .ashade-single-add2cart--qty input[type="number"],
					html .ashade-single-add2cart--qty input[type="number"]:hover {
						border-color: '. esc_attr( self::get_value( 'ashade-input-color-border' ) ) .';
					}
					';
				} else {
					# Default
					$ashade_styles .= '
					html .ashade-single-add2cart--qty input[type="number"],
					html .ashade-single-add2cart--qty input[type="number"]:hover {
						border-color: '. esc_attr( $color_scheme06 ) .';
					}
					';
				}
				$ashade_styles .= '
				.ashade-wc-tabs-wrap ul {
					border-bottom: 1px solid '. esc_attr( self::get_rgba( $color_scheme04, 0.15 ) ) .';
				}
				.ashade-wc-tabs-wrap ul li a,
				.ashade-wc-tabs-wrap ul li span {
					color: '. $color_scheme03 .';
				}
				.ashade-wc-tabs-wrap ul li a:hover,
				.ashade-wc-tabs-wrap ul li.active a,
				.ashade-wc-tabs-wrap ul li span:hover,
				.ashade-wc-tabs-wrap ul li.is-active span {
					color: '. $color_scheme04 .';
				}
				.ashade-up-sells,
				.ashade-cross-sells,
				.ashade-single-product section.related.products {
					border-top: 1px solid '. esc_attr( self::get_rgba( $color_scheme04, 0.15 ) ) .';
				}
				.ashade-wc-tabs-wrap  ul li a::before,
				.ashade-wc-tabs-wrap  ul li span::before {
					background-color: '. $color_scheme04 .';
				}
				.ashade-review-form-wrap .comment-notes span.required,
				.ashade-review-form-wrap label span {
					color: '. $color_scheme04 .';
				}
				.ashade-wc-single-nav {
					border-top: 1px solid '. esc_attr( self::get_rgba( $color_scheme04, 0.15 ) ) .';
				}

				/* PRODUCT LISTING: Item Tools */
				.ashade-woo-loop-item__tools {
					background: '. esc_attr( $color_scheme01 ) .';
				}
				.ashade-woo-loop-item__tools > span {
					background: '. esc_attr( self::get_rgba( $color_scheme04, 0.15 ) ) .';
				}
				.ashade-woo-loop-item__tools > a svg path {
					fill: '. esc_attr( $color_scheme03 ) .';
				}
				.ashade-woo-loop-item__tools > a:hover svg path {
					fill: '. esc_attr( $color_scheme04 ) .';
				}
				.woocommerce ul.products li.product .button.ashade-woo-loop-item__add2cart span.ashade-woo-icon--a2c-progress:before {
					border-color: '. esc_attr( self::get_rgba( $color_scheme04, 0.5 ) ) .';
					border-top-color: '. esc_attr( $color_scheme04 ) .';
				}
				.woocommerce ul.products li.product .button.ashade-woo-loop-item__add2cart svg.ashade-woo-icon--a2c-done path {
					stroke: '. esc_attr( $color_scheme03 ) .';
				}
				.woocommerce nav.woocommerce-pagination ul li a svg path {
					fill: '. esc_attr( $color_scheme03 ) .';
				}
				.woocommerce nav.woocommerce-pagination ul li a:hover svg path {
					fill: '. esc_attr( $color_scheme04 ) .';
				}
				.woocommerce nav.woocommerce-pagination ul li a:focus,
				.woocommerce nav.woocommerce-pagination ul li a:hover,
				.woocommerce nav.woocommerce-pagination ul li span.current {
					color: '. esc_attr( $color_scheme04 ) .';
					border-color: '. esc_attr( $color_scheme04 ) .';
				}
				.woocommerce nav.woocommerce-pagination ul li a:before,
				.woocommerce nav.woocommerce-pagination ul li span:before {
					background: '. esc_attr( $color_scheme06 ) .';
				}
				.woocommerce nav.woocommerce-pagination ul li a,
				.woocommerce nav.woocommerce-pagination ul li span {
					border-color: '. esc_attr( $color_scheme06 ) .';
					color: '. esc_attr( $color_scheme03 ) .';
				}

				/* PRODUCT LISTING: Item Footer */
				.ashade-cart-item--name h5 span a:hover,
				.ashade-soldout-label,
				.woocommerce .onsale,
				.woocommerce ul.products li.product .ashade-woo-loop-item__image-wrap .onsale,
				.ashade-woo-loop-item__footer h2 span a:hover,
				.ashade-woo-loop-item__footer h3 span a:hover,
				.ashade-woo-loop-item__footer h4 span a:hover,
				.ashade-woo-loop-item__footer h5 span a:hover,
				.ashade-woo-loop-item__footer h6 span a:hover,
				.shadowcore-pli-meta a:hover,
				.woocommerce ul.products li.product .ashade-woo-loop-item__price .price,
				.woocommerce ul.products li.product .ashade-woo-loop-item__price .price ins {
					color: '. esc_attr( $color_scheme04 ) .';
				}
				.ashade-cart-item--name h5 span a,
				.shadowcore-pli-meta a,
				.woocommerce ul.products li.product .ashade-woo-loop-item__price .price del,
				.ashade-woo-loop-item__footer h2 span a,
				.ashade-woo-loop-item__footer h3 span a,
				.ashade-woo-loop-item__footer h4 span a,
				.ashade-woo-loop-item__footer h5 span a,
				.ashade-woo-loop-item__footer h6 span a {
					color: '. esc_attr( $color_scheme05 ) .';
				}
				.woocommerce div.product .ashade-wc-variations-form-wrap p.price del,
				.woocommerce div.product .ashade-wc-variations-form-wrap span.price del,
				.woocommerce div.product .ashade-single-product--price p.price del,
				.woocommerce ul.products li.product .ashade-woo-loop-item__price .price del {
					font-family: '. esc_attr( self::get_value( 'ashade-overheads-ff' ) ) .';
					font-weight: '. esc_attr( self::get_value( 'ashade-overheads-fw' ) ) .';
					text-transform: '. ( self::get_value( 'ashade-overheads-u' ) ? 'uppercase' : 'none' ) .';
					font-style: '. ( self::get_value( 'ashade-overheads-i' ) ? 'italic' : 'normal' ) .';
				';
				if ( self::get_value( 'ashade-overheads-custom-colors' ) ) {
					$ashade_styles .= 'color: ' . esc_attr( self::get_value( 'ashade-overheads-color' ) );
				}
				$price_use_h = self::get_value( 'ashade-wc-titles-size' );
				$ashade_styles .= '
				}
				.woocommerce div.product .ashade-wc-variations-form-wrap p.price del,
				.woocommerce div.product .ashade-wc-variations-form-wrap span.price del {
					'. self::get_overhead( 'h5' ) .'
				}
				.woocommerce ul.products li.product .ashade-woo-loop-item__price .price del {
					'. self::get_overhead( $price_use_h ) .'
				}
				.woocommerce div.product .ashade-single-product--price p.price del {
					'. self::get_overhead( 'h3' ) .'
				}
				.woocommerce div.product .ashade-wc-variations-form-wrap p.price,
				.woocommerce div.product .ashade-wc-variations-form-wrap span.price,
				.woocommerce div.product .ashade-single-product--price p.price,
				.woocommerce div.product .ashade-single-product--price p.price ins,
				.ashade-soldout-label,
				.woocommerce .onsale,
				.woocommerce ul.products li.product .ashade-woo-loop-item__image-wrap .onsale,
				.woocommerce ul.products li.product .ashade-woo-loop-item__price .price,
				.woocommerce ul.products li.product .ashade-woo-loop-item__price .price ins {
					font-family: '. esc_attr( self::get_value( 'ashade-headings-ff' ) ) .';
					font-weight: '. esc_attr( self::get_value( 'ashade-headings-fw' ) ) .';
					text-transform: '. ( self::get_value( 'ashade-headings-u' ) ? 'uppercase' : 'none' ) .';
					font-style: '. ( self::get_value( 'ashade-headings-i' ) ? 'italic' : 'normal' ) .';
					';
					if ( self::get_value( 'ashade-headings-custom-colors' ) ) {
						$ashade_styles .= 'color: ' . esc_attr( self::get_value( 'ashade-headings-color' ) );
					}
				$ashade_styles .= '
				}
				.woocommerce div.product .ashade-single-product--price p.price,
				.woocommerce div.product .ashade-single-product--price p.price ins {
					'. self::get_heading( 'h3' ) .'
				}
				.woocommerce div.product .ashade-wc-variations-form-wrap p.price ins,
				.woocommerce div.product .ashade-wc-variations-form-wrap span.price ins,
				.woocommerce div.product .ashade-wc-variations-form-wrap span.price {
					'. self::get_heading( 'h5' ) .'
				}
				.woocommerce ul.products li.product .ashade-woo-loop-item__price .price,
				.woocommerce ul.products li.product .ashade-woo-loop-item__price .price ins {
					'. self::get_heading( $price_use_h ) .'
				}
				.ashade-soldout-label,
				html .woocommerce .onsale,
				.woocommerce ul.products li.product .ashade-woo-loop-item__image-wrap .onsale {
					'. self::get_heading( 'h6' ) .'
				}

				/* WIDGETS: Price Filter */
				.price_label {
					color: '. $color_scheme03 .';
				}
				.price_label span {
					color: '. $color_scheme04 .';
				}
				.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content {
					background-color: '. $color_scheme06 .';
				}
				.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
				.woocommerce .widget_price_filter .ui-slider .ui-slider-range {
					background-color: '. $color_scheme03 .';
				}
				.price_slider.ui-slider,
				.price_slider.ui-slider span {
					background: '. $color_scheme04 .';
				}

				/* WIDGETS: Mini Cart */
				.woocommerce .widget_shopping_cart .cart_list li a.remove.ashade-mini-cart-item--remove,
				.woocommerce.widget_shopping_cart .cart_list li a.remove.ashade-mini-cart-item--remove {
					color: '. esc_attr( $color_scheme03 ) .'!important;
				}
				.woocommerce .widget_shopping_cart .cart_list li a.remove.ashade-mini-cart-item--remove:hover,
				.woocommerce.widget_shopping_cart .cart_list li a.remove.ashade-mini-cart-item--remove:hover {
					color: '. esc_attr( $color_scheme04 ) .'!important;
				}
				.woocommerce .widget_shopping_cart .total,
				.woocommerce.widget_shopping_cart .total {
					color: '. $color_scheme04 .';
					'. self::get_font( 'ashade-content' ) .'
				}
				.woocommerce .widget_shopping_cart .total strong,
				.woocommerce.widget_shopping_cart .total strong {
					color: '. $color_scheme03 .';
					font-weight: '. absint( self::get_value( 'ashade-content-fw' ) ) .';
				}

				/* WIDGETS: Nav Filters */
				.woocommerce .widget_layered_nav_filters ul li a {
					border-color: '. esc_attr( $color_scheme06 ) .';
					color: '. esc_attr( $color_scheme03 ) .';
					height: '. absint( self::get_value( 'ashade-button-height' ) ) .'px;
					margin: 0 0 '. absint( self::get_value( 'ashade-button-spacing' ) ) .'px 0;
					background: transparent;
					border-style: '. esc_attr( self::get_value( 'ashade-button-bs' ) ) .';
					'. ( self::get_value( 'ashade-button-bs' ) !== 'none' ? 'border-width: ' . esc_attr( self::get_value( 'ashade-button-bw' ) ) . 'px;' : '' ) .'
					border-radius: '. esc_attr( $buttons_br[0] ) .'px '. esc_attr( $buttons_br[1] ) .'px '. esc_attr( $buttons_br[2] ) .'px '. esc_attr( $buttons_br[3] ) .'px;
					padding: '. esc_attr( $buttons_padding[0] ) .'px '. esc_attr( $buttons_padding[1] ) .'px '. esc_attr( $buttons_padding[2] ) .'px '. esc_attr( $buttons_padding[3] ) .'px;
					'. self::get_font_usage( 'ashade-button' ) .'
				}
				.woocommerce .widget_layered_nav_filters ul li a:hover {
					border-color: '. esc_attr( $color_scheme04 ) .';
					color: '. esc_attr( $color_scheme04 ) .';
				}
				html .woocommerce .widget_layered_nav_filters ul li a:before,
				html .woocommerce .widget_layered_nav_filters ul li a:after {
					background-color: '. esc_attr( $color_scheme03 ) .';
				}
				html .woocommerce .widget_layered_nav_filters ul li a:hover:before,
				html .woocommerce .widget_layered_nav_filters ul li a:hover:after {
					background-color: '. esc_attr( $color_scheme04 ) .';
				}

				/* WIDGETS: Categories */
				ul.woocommerce-widget-layered-nav-list a,
				ul.product-categories a {
					color: '. esc_attr( $color_scheme03 ) .';
				}
				ul.woocommerce-widget-layered-nav-list a:hover,
				ul.product-categories a:hover {
					color: '. esc_attr( $color_scheme04 ) .';
				}
				ul.woocommerce-widget-layered-nav-list li,
				ul.product-categories li {
					color: '. esc_attr( $color_scheme05 ) .';
				}
				ul.woocommerce-widget-layered-nav-list li ul:before,
				ul.product-categories li ul:before {
					background: '. esc_attr( $color_scheme06 ) .';
				}

				/* CHECKOUT */
				.ashade-wc-checkout-payment,
				html .woocommerce form.checkout_coupon,
				html .woocommerce form.login,
				html .woocommerce form.register {
					background: '. esc_attr( $color_scheme02 ) .';
				}

				.select2-container--default .select2-selection--single .select2-selection__arrow:before,
				.select2-container--default .select2-selection--single .select2-selection__arrow:after {
					background: '. esc_attr( $color_scheme03 ) .';
				}

				.select2-container--default .select2-search--dropdown .select2-search__field,
				.select2-dropdown,
				.select2-container--default .select2-selection--single {
					background: '. esc_attr( self::get_rgba( $color_scheme01, 0 ) ) .';
					color: '. esc_attr( $color_scheme03 ) .';
					border-color: '. esc_attr( $color_scheme06 ) .';
				}
				.select2-container--default .select2-search--dropdown .select2-search__field:hover,
				.select2-container--default .select2-search--dropdown .select2-search__field:focus,
				.select2-container--default .select2-selection--single:hover {
					background: '. esc_attr( self::get_rgba( $color_scheme01, 0.5 ) ) .';
					border-color: '. esc_attr( $color_scheme05 ) .';
				}
				.select2-container--default .select2-selection--single .select2-selection__rendered {
					color: '. esc_attr( $color_scheme03 ) .';
				}
				li.select2-results__option {
					background: '. esc_attr( $color_scheme01 ) .';
					border-color: '. esc_attr( $color_scheme06 ) .';
				}
				.select2-container--default .select2-results__option--highlighted[aria-selected],
				.select2-container--default .select2-results__option--highlighted[data-selected] {
					color: '. esc_attr( $color_scheme04 ) .';
				}
				.select2-container--default .select2-results__option[aria-selected=true],
				.select2-container--default .select2-results__option[data-selected=true] {
					background: '. esc_attr( $color_scheme02 ) .';
					color: '. esc_attr( $color_scheme04 ) .';
				}
				label.woocommerce-form__label.woocommerce-form__label-for-checkbox:before,
				.ashade-wc-total-shipping-method-wrap label:before,
				#payment .ashade-wc-checkout-payment .wc_payment_methods li label:before {
					border: 2px solid '. esc_attr( $color_scheme06 ) .';
				}
				label.woocommerce-form__label.woocommerce-form__label-for-checkbox:hover:before {
					border: 2px solid '. esc_attr( $color_scheme05 ) .';
				}
				label.woocommerce-form__label.woocommerce-form__label-for-checkbox:after,
				.ashade-wc-total-shipping-method-wrap label:after,
				#payment .ashade-wc-checkout-payment .wc_payment_methods li label:after {
					background: '. esc_attr( $color_scheme06 ) .';
				}
				.ashade-soldout-label {
					background: '. esc_attr( $color_scheme06 ) .';
				}
				label.woocommerce-form__label.woocommerce-form__label-for-checkbox:hover:after {
					background: '. esc_attr( $color_scheme05 ) .';
				}
				';

				$input_br = explode( "/", self::get_value( 'ashade-input-br' ) );
				$input_padding = explode( "/", self::get_value( 'ashade-input-padding' ) );
				$ashade_styles .= '
				/* --- Forms and Fields --- */
				.select2-container--default .select2-search--dropdown .select2-search__field,
				.select2-dropdown,
				.select2-container--default .select2-selection--single {
					height: '. absint( self::get_value( 'ashade-input-height' ) ) .'px;
					border-style: '. esc_attr( self::get_value( 'ashade-input-bs' ) ) .';
					'. ( self::get_value( 'ashade-input-bs' ) !== 'none' ? 'border-width: ' . esc_attr( self::get_value( 'ashade-input-bw' ) ) . 'px;' : '' ) .'
					border-radius: '. esc_attr( $input_br[0] ) .'px '. esc_attr( $input_br[1] ) .'px '. esc_attr( $input_br[2] ) .'px '. esc_attr( $input_br[3] ) .'px;
					padding: '. esc_attr( $input_padding[0] ) .'px '. esc_attr( $input_padding[1] ) .'px '. esc_attr( $input_padding[2] ) .'px '. esc_attr( $input_padding[3] ) .'px;
					margin: 0 0 '. absint( self::get_value( 'ashade-input-spacing' ) ) .'px 0;
					'. self::get_font_usage( 'ashade-input' ) .'
				}
				';
				if ( self::get_value( 'ashade-input-custom-colors' ) ) {
					$ashade_styles .= '
					.select2-container--default .select2-search--dropdown .select2-search__field,
					.select2-dropdown,
					.select2-container--default .select2-selection--single {
						color: '. esc_attr( self::get_value( 'ashade-input-color-text' ) ) .';
						background-color: '. esc_attr( self::get_value( 'ashade-input-color-bg' ) ) .';
						border-color: '. esc_attr( self::get_value( 'ashade-input-color-border' ) ) .';
					}
					.select2-container--default .select2-search--dropdown .select2-search__field:hover,
					.select2-container--default .select2-selection--single:hover {
						color: '. esc_attr( self::get_value( 'ashade-input-color-htext' ) ) .';
						background-color: '. esc_attr( self::get_value( 'ashade-input-color-hbg' ) ) .';
						border-color: '. esc_attr( self::get_value( 'ashade-input-color-hborder' ) ) .';
					}
					.select2-container--default .select2-search--dropdown .select2-search__field:focus {
						color: '. esc_attr( self::get_value( 'ashade-input-color-ftext' ) ) .';
						background-color: '. esc_attr( self::get_value( 'ashade-input-color-fbg' ) ) .';
						border-color: '. esc_attr( self::get_value( 'ashade-input-color-fborder' ) ) .';
					}
					.select2-container--default .select2-selection--single .select2-selection__rendered {
						color: '. esc_attr( self::get_value( 'ashade-input-color-htext' ) ) .';
					}
					';
				}
				$ashade_styles .= '
				.select2-dropdown {
					background: '. esc_attr( $color_scheme01 ) .';
				}
				.ashade-wc-checkout-order > ul li span:last-child {
					color: '. esc_attr( $color_scheme04 ) .';
				}
				.ashade-wc-checkout-order > ul li span strong {
					color: '. esc_attr( $color_scheme05 ) .';
				}
				#add_payment_method #payment div.payment_box,
				.woocommerce-cart #payment div.payment_box,
				.woocommerce-checkout #payment div.payment_box {
					background: '. esc_attr( $color_scheme01 ) .';
					color: '. esc_attr( $color_scheme03 ) .';
					box-shadow: 0 0 10px '. esc_attr( self::get_rgba( $color_scheme01, 0.45 ) ) .';
					'. self::get_font( 'ashade-content' ) .'
				}
				#add_payment_method #payment div.payment_box::before,
				.woocommerce-cart #payment div.payment_box::before,
				.woocommerce-checkout #payment div.payment_box::before {
					border-bottom-color: '. esc_attr( $color_scheme01 ) .';
				}
				#add_payment_method #payment ul.payment_methods,
				.woocommerce-cart #payment ul.payment_methods,
				.woocommerce-checkout #payment ul.payment_methods {
					border-bottom: 1px solid '. esc_attr( $color_scheme06 ) .';
				}
				';

				if ( self::get_value( 'ashade-content-custom-colors' ) ) {
					$ashade_styles .= '
					ul.product-categories a {
						color: '. esc_attr( self::get_value( 'ashade-content-color-text' ) ) .';
					}
					';
				}

				$ashade_styles .= '
				/* --- WooCommerce Responsive --- */
				@media only screen and (max-width: 960px) {
					.ashade-mobile-header a.ashade-wc-header-cart svg path {
						fill: '. esc_attr( $color_scheme04 ) .'
					}
				}
				@media only screen and (max-width: 760px) {
					html .woocommerce ul.products li.product .ashade-woo-loop-item__price .price,
					html .woocommerce ul.products li.product .ashade-woo-loop-item__price .price ins  {
						'. self::get_heading( 'h5', $mobile_heading_modifier ) .'
					}
					.ashade-soldout-label,
					html .woocommerce ul.products li.product .ashade-woo-loop-item__image-wrap .onsale {
						'. self::get_heading( 'h6', $mobile_heading_modifier ) .'
					}
					.ashade-wc-header-cart-wrap {
						border-top: 1px solid '. esc_attr( $color_scheme06 ) .';
					}
					.ashade-single-product--title h3 span,
					.woocommerce div.product .ashade-single-product--price p.price del {
						'. self::get_overhead( 'h5' ) .';
					}
					.ashade-single-product--title h3,
					.woocommerce div.product .ashade-single-product--price p.price,
					.woocommerce div.product .ashade-single-product--price p.price ins,
					html .woocommerce div.product .ashade-single-product--title .ashade-single-product--price p.price,
					html .woocommerce div.product .ashade-single-product--title .ashade-single-product--price p.price ins {
						'. self::get_heading( 'h4', $mobile_heading_modifier ) .'
					}
					.woocommerce div.product .ashade-wc-variations-form-wrap p.price ins,
					.woocommerce div.product .ashade-wc-variations-form-wrap span.price ins,
					.woocommerce div.product .ashade-wc-variations-form-wrap span.price {
						'. self::get_heading( 'h5', $mobile_heading_modifier ) .'
					}
					.woocommerce ul.products li.product .ashade-woo-loop-item__price .price,
					.woocommerce ul.products li.product .ashade-woo-loop-item__price .price ins {
						'. self::get_heading( $price_use_h, $mobile_heading_modifier ) .'
					}
					.ashade-soldout-label,
					html .woocommerce .onsale,
					.woocommerce ul.products li.product .ashade-woo-loop-item__image-wrap .onsale {
						'. self::get_heading( 'h6', $mobile_heading_modifier ) .'
					}

					.ashade-wc-account-wrap .woocommerce nav ul {
						border-bottom: 1px solid '. esc_attr( $color_scheme06 ) .';
					}

					/* Shopping Cart */
					h5.ashade-cart-item--qty-label span {
						'. self::get_overhead( 'h5' ) .'
					}
					h5.ashade-cart-item--qty-label > span.woocommerce-Price-amount,
					h5.ashade-cart-item--qty-label > span.woocommerce-Price-amount .woocommerce-Price-currencySymbol {
						'. self::get_heading( 'h5', $mobile_heading_modifier ) .'
					}
				}
				';
			} // End Woo IF

			return $ashade_styles;
		}
	}
endif;
