/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

"use strict";
var $ashade_admin_body = jQuery('body'),
	ashade_templates = Array('template--page-albums', 'template--page-home'),
	ashade_album_types = Array('is-grid', 'is-masonry', 'is-adjusted', 'is-bricks', 'is-ribbon', 'is-slider', 'is-justified');

// Search In Array Function
function search_in_array(str, arr) {
	for (var i = 0; i < arr.length; i++) {
		if (arr[i].match(str)) return i;
	}
	return -1;
}

/* Customizer Dependency Functions */
function check_metabox_depend( this_id_array, this_value_array ) {
	var result = '';
	for (var i = 0; i < this_id_array.length; i++) {
		var $this_item = jQuery('#'+this_id_array[i]);
		
		var state = check_metabox_depend_state( $this_item, i, this_id_array, this_value_array );
		if (result == '') {
			result = state;
		} else if ( result == 'show' && state == 'hide' ) {
			result = 'hide';
		} else if ( result == 'hide' && state == 'show' ) {
			result = 'hide';
		}		
	}
	return result;
}

function check_metabox_depend_state( $this_item, i, this_id_array, this_value_array) {
	var result = '';

	if ( $this_item.is('select') ) {
		// Select
		result = check_metabox_depend_value( $this_item.val(), this_value_array[i] );
	}

	return result;
}

function check_metabox_depend_value( val, this_value ) {
	var result = '';
	
	if ( this_value.indexOf(',') > 0 ) {
		this_value = this_value.split(',');
		if ( search_in_array( val, this_value ) > -1 ) {
			result = 'show';
		} else {
			result = 'hide';
		}
	} else {
		if ( val == this_value ) {
			result = 'show';
		} else {
			result = 'hide';
		}			
	}
	return result;
}

jQuery(document).ready(function(){

	// Page Subtitle
	if (jQuery('input[name="ashade-page-subtitle"]').length) {
		jQuery('input[name="ashade-page-subtitle"]').parents('.rwmb-field').addClass('ashade-subtitle-field-wrap');
	}

	// Metabox Dependency
	if ( jQuery('[data-ashade-condition]').length ) {
		jQuery('[data-ashade-condition]').each( function() {
			var $this = jQuery(this),
				$this_parent = $this.parents('div.rwmb-field'),
				this_conditions = JSON.parse($this.attr('data-ashade-condition')),
				this_id_array = [],
				this_value_array = [];
			
			for(var i in this_conditions) {
				this_id_array.push(i);
				this_value_array.push(this_conditions[i]);
			}
			
			var final_result = check_metabox_depend( this_id_array, this_value_array );

			if (final_result == 'hide') {
				$this_parent.hide();
			} else {
				$this_parent.show();
			}
			
			// Bind Actions
			this_id_array.forEach( function( item,i ) {
				var $this_el = jQuery('#'+item);
				if ($this_el.is('select')) {
					// Select
					$this_el.on('change', function() {
						var action = check_metabox_depend( this_id_array, this_value_array );
						if (action == 'hide') {
							$this_parent.slideUp(300);
						} else {
							$this_parent.slideDown(300);
						}
					});
				}
			});

		});
	}
	
	// Highlight Default Metabox Fields
	jQuery('.rwmb-select').each(function(){
		if (jQuery(this).val() == 'default') {
			jQuery(this).parents('.rwmb-select-wrapper').addClass('rwmb-default-select');
		}
	});
	
	// Mixed Media RWMB
	if ( jQuery('.ashade-mixed-media').length ) {
		// Image Media Selector
		let ashade_mmc_image = {
			parent_el: false,
			input_el: false,
			l18n: {
				title: '',
				update_button: '',
			},
			
			// Initializes a new media manager or returns an existing frame.
			frame: function() {
				if ( this._frame )
					return this._frame;

				var $parent = this.parent_el;

				this._frame = wp.media({
					title: this.l18n.title,
					library: {
						type: 'image'
					},
					button: {
						text: this.l18n.update_button
					},
					multiple: false
				});

				this._frame.on( 'open', this.updateFrame ).state('library').on( 'select', this.select );

				return this._frame;
			},

			select: function() {
				let attachment = this.get('selection').first().toJSON(),
					$item = ashade_mmc_image.parent_el,
					img_src = '';
				
				// Update Image
				if (attachment.sizes.thumbnail) {
					img_src = attachment.sizes.thumbnail.url;
				} else {
					img_src = attachment.sizes.full.url;
				}


				if ($item.find('img').length) {
					$item.find('img').attr('src', img_src);
				} else {
					$item.prepend('<img src="'+ img_src +'" alt="Media Image">');
					$item.parents('.ashade-mm-section--image').removeClass('not-selected');
				}

				ashade_mmc_image.input_el.val( attachment.id );
			},
		};
		// Video Media Selector
		let ashade_mmc_video = {
			parent_el: false,
			input_el:  false,
			type_el:   false,
			l18n: {
				title: '',
				update_button: '',
			},
			
			// Initializes a new media manager or returns an existing frame.
			frame: function() {
				if ( this._frame )
					return this._frame;

				var $parent = this.parent_el;

				this._frame = wp.media({
					title: this.l18n.title,
					library: {
						type: 'video'
					},
					button: {
						text: this.l18n.update_button
					},
					multiple: false
				});

				this._frame.on( 'open', this.updateFrame ).state('library').on( 'select', this.select );

				return this._frame;
			},

			select: function() {
				let attachment = this.get('selection').first().toJSON(),
					$item = ashade_mmc_video.parent_el;
				
				// Update Video
				if ($item.find('video').length) {
					$item.find('video').attr('src', attachment.url);
				} else {
					$item.prepend('<video src="'+ attachment.url +'" controls></video>');
					$item.parents('.ashade-mm-section--video').removeClass('not-selected');
				}
				
				ashade_mmc_video.input_el.val( attachment.id );
				ashade_mmc_video.type_el.val( 'video' );
			},
		};
		// Embed Link Selector
		let ashade_mmc_link = {
			parent_el: false,
			input_el:  false,
			type_el:   false,
			result:    false,
			l18n: {
				title: '',
				update_button: '',
			},
			open: function() {
				jQuery('.ashade-mixed-media').addClass('is-inactive');
				let popup_el = jQuery('<div class="ashade-mmc-link-wrap"></div>'),
					popup_overlay = jQuery('<div class="ashade-mmc-link-overlay"></div>');
				
				if ( jQuery('body').find('.ashade-mmc-link-wrap').length ) {
					jQuery('body').find('.ashade-mmc-link-wrap').remove();
					jQuery('body').find('.ashade-mmc-link-overlay').remove();
				}
				
				popup_el.append('\
					<div class="media-frame-title" id="media-frame-title">\
						<h1>'+ this.l18n.title +'</h1>\
						<p>' + this.l18n.intro + '</p>\
					</div>\
					<a href="#" class="ashade-mmc-link--close"></a>\
					<div class="ashade-mmc-link-input">\
						<input type="text" placeholder="'+ this.l18n.title +'"></input>\
					</div>\
					<div class="ashade-mmc-link-footer">\
						<div>\
							<span><strong>' + this.l18n.example + '</strong></span>\
							<span>' + this.l18n.youtube + '</span>\
							<span>' + this.l18n.vimeo + '</span>\
						</div>\
						<div>\
							<button type="button" class="ashade-mmc-link--submit button button-primary button-large">'+ this.l18n.update_button +'</button>\
						</div>\
					</div>\
				').appendTo( jQuery('body') );
				
				popup_el.find('input').focus();
				popup_overlay.appendTo( jQuery('body') );
				popup_overlay.on('click', function(e) {
					e.preventDefault();
					popup_el.remove();
					popup_overlay.remove();
				});
				
				popup_el.on('click', '.ashade-mmc-link--close', function(e) {
					e.preventDefault();
					popup_el.remove();
					popup_overlay.remove();
				}).on('click', '.ashade-mmc-link--submit', function(e) {
					e.preventDefault();
					let $item = ashade_mmc_link.parent_el,
						this_val = popup_el.find('input').val(),
						iframe_url = '',
						this_id = false,
						this_type = '';
					
					// Detect Video Type
					if ( this_val.indexOf('outube') > 1 ) {
						// Youtube Video
						this_id = this_val.split('=')[1];
						// Check and Remove additional params
						if ( this_id.indexOf( '&' ) > 1 ) {
							this_id = this_id.split('&')[0];
						}
						// Get iFrame URL
						iframe_url = 'https://www.youtube.com/embed/' + this_id + '?controls=1&amp;loop=0';
						this_type = 'youtube';
					} else if ( this_val.indexOf('imeo') > 1 ) {
						// Vimeo Video
						this_id = this_val.split('.com/')[1];
						iframe_url = 'https://player.vimeo.com/video/' + this_id + '?controls=1&amp;loop=0';
						this_type = 'vimeo';
					}
							   
					// Return Result
					if ( this_id ) {
						
						// Update Frame
						if ( $item.find('iframe').length ) {
							$item.find('iframe').attr('src', iframe_url);
						} else {
							$item.prepend('<iframe src="'+ iframe_url +'"></iframe>');
							$item.parents('.ashade-mm-section--video').removeClass('not-selected');
						}
						
						// Return Input Val
						ashade_mmc_link.input_el.val( this_id );
						ashade_mmc_link.type_el.val( this_type );
					}
					
					popup_el.remove();
					popup_overlay.remove();
				});
			}
		}
		
		jQuery('.ashade-mixed-media').each(function() {
			let $parent = jQuery(this),
				$wrap   = $parent.children( '.rwmb-input' ),
				$l18n   = $parent.prev( '.ashade-mixed-media-l18n' ),
				$add    = jQuery( '<a href="#" class="ashade-mixed-media--add button-primary">' + $l18n.data( 'button-add' ) + '</a>' );
			
			// L18n
			ashade_mmc_image.l18n.update_button = ashade_mmc_video.l18n.update_button = $l18n.data( 'button-select' );
			ashade_mmc_link.l18n.update_button  = $l18n.data( 'embed-insert' );
			ashade_mmc_image.l18n.title  = $l18n.data( 'select-image' );
			ashade_mmc_video.l18n.title  = $l18n.data( 'select-video' );
			ashade_mmc_link.l18n.title   = $l18n.data( 'select-embed' );
			ashade_mmc_link.l18n.intro   = $l18n.data( 'embed-intro' );
			ashade_mmc_link.l18n.youtube = $l18n.data( 'embed-youtube' );
			ashade_mmc_link.l18n.vimeo   = $l18n.data( 'embed-vimeo' );
			ashade_mmc_link.l18n.example = $l18n.data( 'embed-example' );
			
			// Create DOM function
			function create_dom( $item ) {
				let $item_inner  = jQuery('<div class="mixed-media-item--inner"/>'),
					$input_image = $item.children('fieldset').children('p').eq(0).children('input'),
					$input_video = $item.children('fieldset').children('p').eq(1).children('input'),
					$input_type  = $item.children('fieldset').children('p').eq(2).children('input');
				
				// Open Frame Function
				function ashade_mmc_open_frame( frame_type ) {
					if ( 'image' == frame_type ) {
						ashade_mmc_image.parent_el = $item.find('.ashade-mm--image-wrap');
						ashade_mmc_image.input_el = $input_image;
						ashade_mmc_image.frame().open();
					}
					if ( 'video' == frame_type ) {
						ashade_mmc_video.parent_el = $item.find('.ashade-mm--video-wrap');
						ashade_mmc_video.input_el = $input_video;
						ashade_mmc_video.type_el = $input_type;
						ashade_mmc_video.frame().open();
					}
					if ( 'embed' == frame_type ) {
						ashade_mmc_link.parent_el  = $item.find('.ashade-mm--video-wrap');
						ashade_mmc_link.input_el   = $input_video;
						ashade_mmc_link.type_el    = $input_type;
						ashade_mmc_link.open();
					}
				}
				
				// Activate Class
				$item.addClass('ashade-mixed-media-item');
				
				// Create DOM
				$item_inner.append('\
					<div class="ashade-mm-section--image not-selected">\
						<span class="ashade-mml-select">' + $l18n.data( 'select-image' ) + '</span>\
						<span class="ashade-mml-selected">' + $l18n.data( 'selected-image' ) + '</span>\
						<a href="#" class="ashade-mm--image-select" title="' + $l18n.data( 'select-image' ) + '"></a>\
						<div class="ashade-mm--image-wrap"></div>\
						<div class="ashade-mm--tools">\
							<a href="#" class="ashade-mm--image-remove" title="' + $l18n.data( 'button-remove' ) + '"></a>\
							<a href="#" class="ashade-mm--image-update" title="' + $l18n.data( 'button-update' ) + '"></a>\
						</div>\
					</div><!-- .ashade-mm-section--image -->\
					<span class="ashade-mm-section--divider"></span>\
					<div class="ashade-mm-section--video not-selected">\
						<span class="ashade-mml-selected">' + $l18n.data( 'selected-video' ) + '</span>\
						<div class="ashade-mm-video-selector">\
							<div>\
								<span class="ashade-mml-select">' + $l18n.data( 'select-video' ) + '</span>\
								<a href="#" class="ashade-mm--video-select" title="' + $l18n.data( 'select-video' ) + '"></a>\
							</div>\
							<div class="ashade-mm--or">' + $l18n.data( 'or' ) + '</div>\
							<div>\
								<span class="ashade-mml-select">' + $l18n.data( 'select-embed' ) + '</span>\
								<a href="#" class="ashade-mm--video-embed" title="' + $l18n.data( 'select-embed' ) + '"></a>\
							</div>\
						</div>\
						<div class="ashade-mm--video-wrap"></div>\
						<div class="ashade-mm--tools">\
							<a href="#" class="ashade-mm--video-remove" title="' + $l18n.data( 'button-remove' ) + '"></a>\
							<a href="#" class="ashade-mm--video-update" title="' + $l18n.data( 'button-update' ) + '"></a>\
						</div>\
					</div><!-- .ashade-mm-section--video -->\
				');
				
				// Append Data
				if ( $input_image.val().length ) {
					// Load Image Preview
					let $section = $item_inner.find('.ashade-mm-section--image'),
						img_url = '',
						this_ID = $input_image.val();
					
					$section.removeClass( 'not-selected' ).addClass( 'is-loading' );

					wp.media.attachment(this_ID).fetch().then(function (data) {
						if ( data.sizes.thumbnail ) {
							img_url = data.sizes.thumbnail.url;
						} else {
							img_url = data.sizes.full.url;
						}
						$item_inner.find('.ashade-mm--image-wrap').append('<img src="'+ img_url +'" alt="Media Image">');
						$section.removeClass( 'is-loading' );
					});
				}
				if ( $input_video.val().length ) {
					// Load Video Preview
					let $section = $item_inner.find('.ashade-mm-section--video'),
						this_ID = $input_video.val();
					
					$section.removeClass( 'not-selected' ).addClass( 'is-loading' );
					
					if ( 'video' == $input_type.val() ) {
						wp.media.attachment(this_ID).fetch().then(function (data) {
							$section.find('.ashade-mm--video-wrap').append('<video src="'+ data.url +'" controls></video>');
							$section.removeClass('is-loading');
						});
					}
					if ( 'vimeo' == $input_type.val() ) {
						// Load Vimeo Preview
						$section.removeClass('is-loading');
						$section.find('.ashade-mm--video-wrap').append('<iframe src="https://player.vimeo.com/video/' + this_ID + '?controls=1&amp;loop=0"></iframe>');
					}
					if ( 'youtube' == $input_type.val() ) {
						// Load YouTube Preview
						$section.removeClass('is-loading');
						$section.find('.ashade-mm--video-wrap').append('<iframe src="https://www.youtube.com/embed/' + this_ID + '?controls=1&amp;loop=0"></iframe>');
					}
				}
				
				// Append DOM
				$item.append( $item_inner );
				
				// UI Select Events
				$item.on('mousedown', 'a', function(e) {
					e.preventDefault();
				});
				$item.on('click', '.ashade-mm--image-select', function(e) {
					// Select Image
					e.preventDefault();
					ashade_mmc_open_frame( 'image' );
				});
				
				$item.on('click', '.ashade-mm--video-select', function(e) {
					// Select Video
					e.preventDefault();
					ashade_mmc_open_frame( 'video' );
				});
				$item.on('click', '.ashade-mm--video-embed', function(e) {
					// Embed Video
					e.preventDefault();
					ashade_mmc_open_frame( 'embed' );
				});
				
				// UI Update Events
				$item.on('click', '.ashade-mm--image-update', function(e) {
					// Update Image
					e.preventDefault();
					ashade_mmc_open_frame( 'image' );
				});
				$item.on('click', '.ashade-mm--image-wrap', function(e) {
					// Update Image
					e.preventDefault();
					ashade_mmc_open_frame( 'image' );
				});
				
				$item.on('click', '.ashade-mm--video-update', function(e) {
					// Update Video
					e.preventDefault();
					if ( 'video' == $input_type.val() ) {
						ashade_mmc_open_frame( 'video' );
					} else {
						ashade_mmc_open_frame( 'embed' );
					}
				});
				
				// UI Remove Events
				$item.on('click', '.ashade-mm--image-remove', function(e) {
					// Remove Image
					e.preventDefault();
					$item.find('.ashade-mm--image-wrap img').remove();
					$item.find('.ashade-mm-section--image').addClass('not-selected');
					$input_image.val('');
				});
				$item.on('click', '.ashade-mm--video-remove', function(e) {
					// Remove Video
					e.preventDefault();
					$item.find('.ashade-mm--video-wrap video').remove();
					$item.find('.ashade-mm--video-wrap iframe').remove();
					$item.find('.ashade-mm-section--video').addClass('not-selected');
					$input_video.val('');
					$input_type.val('');
				});
			}
			
			// Init Current Items
			if ( $wrap.children('.rwmb-clone').length ) {
				$wrap.children('.rwmb-clone').each(function() {
					let $item = jQuery(this);
					create_dom( $item );
				});
			}
			
			// "Add New Item" Button 
			$wrap.children( 'a.add-clone' ).before( $add );
			
			$add.on('click', function(e) {
				e.preventDefault();
				let $last = $wrap.children('.ashade-mixed-media-item').last(),
					$clone = $last.clone(),
					cloneIndex = $last.index() + 1;
				
				// Remove UI
				$clone.children('.mixed-media-item--inner').remove();
				
				// Update Inputs
				$clone.find('input').each(function() {
					let $input = jQuery(this),
						orig_name = $input.attr('name'),
						split_name = orig_name.split('[');
					
					// Update Name Index
					$input.attr('name', split_name[0] + '['+ cloneIndex +'][' + split_name[split_name.length - 1]).val('');
				});
				
				// Create UI
				create_dom( $clone );
				
				// Append new Item
				$add.before( $clone );
			});
		});
	}
});

// RWMB Default Highlighting
jQuery(document).on( 'change', '.rwmb-select', function() {
	if (jQuery(this).val() == 'default') {
		jQuery(this).parents('.rwmb-select-wrapper').addClass('rwmb-default-select');
	} else {
		jQuery(this).parents('.rwmb-select-wrapper').removeClass('rwmb-default-select');
	}
});

// Template Change
jQuery(document).on( 'change', '.editor-page-attributes__template select', function() {
	ashade_templates.forEach(function(item) {
		$ashade_admin_body.removeClass(item);
	});
	
	let this_val = jQuery(this).val();
	if (this_val.indexOf('.') > 0) {
		let set_class = this_val.split('.');
		$ashade_admin_body.addClass('template--' + set_class[0]);
	}
});

// Album Type Change
jQuery(document).on( 'change', 'select#ashade-albums-type', function() {
	let $this = jQuery(this);
	ashade_album_types.forEach(function(item) {
		$ashade_admin_body.removeClass(item);
	});
	
	let this_val = jQuery(this).val(),
		newClass = this_val;
	if ('default' == this_val) {
		newClass = $this.data('default');
	}
	$ashade_admin_body.addClass('is-' + this_val);
});

// Reset Theme Settings
jQuery(document).on( 'click', '.ashade-settings--reset', function () {
    if ( confirm( jQuery(this).attr('data-confirm') ) ) {
        jQuery.post( ajaxurl, {
            action: 'ashade_reset_mods'
        }, function ( response ) {
            alert( response );
        });
    }
});

// Append Subtitle Field
function ashade_append_subtitle() {
	let is_init = false,
		$container = false;
    if ( ! $ashade_admin_body.hasClass('block-editor-page') ) {
        if ( jQuery('#titlewrap').length ) {
            $container = jQuery('#titlewrap');
            const $original_input = jQuery('input[name="ashade-page-subtitle"]');
            $original_input.addClass('ashade-subtitle-field is-default-editor').prependTo($container);
        }
    }
}

jQuery(window).on('load', function() {
	// Page Subtitle
	if (jQuery('input[name="ashade-page-subtitle"]').length) {
		ashade_append_subtitle();
	}
	
	// Check ALL Categories
	if (jQuery('.ashade-albums-select-categ').length) {
		jQuery('.ashade-albums-select-categ').each(function() {
			if (jQuery(this).find('input:checked').length < 1) {
				jQuery(this).find('input[value="all"]').prop("checked", true);
			}
		});
	}
});

jQuery(document).on('click', '.ashade-albums-select-categ input', function() {
	let $this = jQuery(this);
	if ( 'all' == $this.attr( 'value' ) ) {
		$this.parents('.ashade-albums-select-categ').find('input').not(this).prop("checked", false);
	} else {
		$this.parents('.ashade-albums-select-categ').find('input[value="all"]').prop("checked", false);
	}
	if ( $this.parents('.ashade-albums-select-categ').find('input:checked').length < 1 ) {
		$this.parents('.ashade-albums-select-categ').find('input[value="all"]').prop("checked", true);
	}
});