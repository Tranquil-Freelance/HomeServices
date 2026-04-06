/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

"use strict";
jQuery(document).ready(function() {
	// Init Tabs DOM
	if (jQuery('.rwmb-meta-box').length) {
		jQuery('.rwmb-meta-box').each(function() {
			var $this_box = jQuery(this),
				this_box_id = $this_box.attr('id');
			
			if ($this_box.find('span.ashade-rwmb-tab').length > 1) {
				// Add TabBox
				$this_box.addClass('has-tabs');
				$this_box.parent().addClass('ashade-tabs-wrapper');
				let $this_tabs_wrap = jQuery('<div class="ashade-rwmb-tabs-box"/>').insertBefore($this_box),
					$this_tabs_list = jQuery('<ul class="ashade-rwmb-tab-list"/>').appendTo($this_tabs_wrap);
				
				//Create Tabs in this Box
				$this_box.find('span.ashade-rwmb-tab').each(function() {
					let $this_parent = jQuery(this).parents('.rwmb-field').addClass('ashade-rwmb-tab-field'),
						current_tab_id = jQuery(this).text(),
						$this_tab_content = jQuery(),
						next_field = $this_parent[0].nextSibling;
					
					// Add Tab to TabBox
					$this_tabs_list.append('<li data-tab="'+ current_tab_id +'">'+ $this_parent.find('h4').text() +'</li>');
					
					while(next_field) {
						if (!jQuery(next_field).find('span.ashade-rwmb-tab').length) {
							$this_tab_content.push(next_field);
							next_field = next_field.nextSibling;
						} else {
							break;
						}
					}
				
					$this_tab_content.wrapAll('<div class="ashade-rwmb-tab-content" data-id="'+ current_tab_id +'" />');
					$this_parent.remove();
				});
				
				$this_box.find('.ashade-rwmb-tab-content').eq(0).addClass('is-active');
				$this_tabs_list.find('li:first-child').addClass('is-active');
				$this_tabs_list.on('click', 'li', function() {
					let $this_li = jQuery(this);
					
					$this_tabs_list.find('.is-active').removeClass('is-active');
					$this_box.find('.is-active').removeClass('is-active');
					$this_li.addClass('is-active');
					$this_box.find('[data-id="'+ $this_li.data('tab') +'"]').addClass('is-active');
				});
			}
		});
	}

	/* --- Metabox: Responsive Controls --- */
	if ( jQuery('input[data-ashade-responsive]').length ) {
		jQuery('input[data-ashade-responsive]').each(function() {
			let $this = jQuery(this),
				this_id = $this.attr('id'),
				$wrap = $this.parent(),
				$c_wrap = jQuery('<div class="ashade-rmwb-responsive-fields show-desktop"/>').appendTo($wrap),
				type = $this.attr('data-ashade-responsive'),
				def = $this.attr('data-default'),
				this_val = $this.val().length ? $this.val() : def,
				val_arr = false;
			$wrap.addClass('is-responsive').parent().removeClass('hidden').wrapInner('<div class="rwmb-responsive-wrapper"/>');
			$wrap.prepend('\
				<div class="ashade-rmwb-responsive-tools">\
					<a href="#" data-size="desktop" class="is-selected"><i class="dashicons dashicons-desktop"></i></a>\
					<a href="#" data-size="tablet"><i class="dashicons dashicons-tablet"></i></a>\
					<a href="#" data-size="mobile"><i class="dashicons dashicons-smartphone"></i></a>\
				</div>');
			
			$wrap.on('click', '.ashade-rmwb-responsive-tools a', function(e) {
				e.preventDefault();
				jQuery(this).parent().children().removeClass('is-selected');
				jQuery(this).addClass('is-selected');
				$c_wrap.removeClass('show-desktop show-tablet show-mobile').addClass('show-' + jQuery(this).attr('data-size'));
			})
			
			if ( 'number' == type ) {
				/* --- Responsive Control: Number --- */
				let min = $this.attr('data-min'),
					max = $this.attr('data-max'),
					$this_d = jQuery('<input type="number" min="'+ min +'" max="'+ max +'" id="'+ this_id +'-d">').addClass('is-desktop').appendTo($c_wrap),
					$this_t = jQuery('<input type="number" min="'+ min +'" max="'+ max +'" id="'+ this_id +'-t">').addClass('is-tablet').appendTo($c_wrap),
					$this_m = jQuery('<input type="number" min="'+ min +'" max="'+ max +'" id="'+ this_id +'-m">').addClass('is-mobile').appendTo($c_wrap),
					this_update = function() {
						if ( $this_d.val() == '' ) {
							$this_d.val(0);
						}
						if ( $this_t.val() == '' ) {
							$this_t.val(0);
						}
						if ( $this_m.val() == '' ) {
							$this_m.val(0);
						}
						let new_val = $this_d.val() + 'x' + $this_t.val() + 'x' + $this_m.val();
						$this.val(new_val);
					}
				
				// Parse Value
				if ( this_val.indexOf('x') ) {
					val_arr = this_val.split('x');
					if ( val_arr < 3 ) {
						val_arr[1] = val_arr[0];
						val_arr[2] = val_arr[0];
					}
					$this_d.val(val_arr[0]);
					$this_t.val(val_arr[1]);
					$this_m.val(val_arr[2]);
				}
				
				$c_wrap.on('change', 'input', function() {
					this_update();
				}).on('keyup', 'input', function(){
					this_update();
				});
				this_update();
				// Debug
				// $this.attr('type', 'text');
			}
			
			/* --- Responsive Control: Dimension --- */
			if ( 'dimension' == type ) {
				let min = $this.attr('data-min'),
					max = $this.attr('data-max'),
					$d_wrap = jQuery('').appendTo($c_wrap),
					$t_wrap = jQuery('').appendTo($c_wrap),
					$m_wrap = jQuery('').appendTo($c_wrap),
					locker = 'a.ashade-dimension-locker',
					values = Array(),
					this_update = function() {
						let result = '';
						for (let i = 0; i < 3; i++) {
							if ( i > 0) {
								result = result + '/';
							}
							for(let v = 0; v < 5; v++ ) {
								if ( v > 0) {
									result = result + 'x';
								}
								result = result + values[i][v];
							}
						}
						$this.val(result);
					},
					this_change = function($field) {
						if ( $field.val() == '' ) {
							$field.val(0);
						}
						let i = $field.parent().index(),
							v = $field.index();
						
						if ( $field.parent().children(locker).hasClass('is-locked') ) {
							$field.parent().children('input').val($field.val());
							values[i][0] = values[i][1] = values[i][2] = values[i][3] = $field.val();
						} else {
							values[i][v] = $field.val();
						}
						
						this_update();
					},
					locker_change = function( i ) {
						let $c_parent = $c_wrap.children().eq(i),
							$locker = $c_parent.children(locker);
						
						if ( $locker.hasClass('is-locked') ) {
							let c_val = $c_parent.children('input').eq(0).val();
							if (c_val == '') {
								c_val = 0
							};
							$c_parent.children('input').val(c_val);
							values[i][0] = values[i][1] = values[i][2] = values[i][3] = c_val;
							values[i][4] = 1;
						} else {
							values[i][4] = 0;
						}
						this_update();
					}
				
				// Get Values 
				if ( this_val.indexOf('/') ) {
					val_arr = this_val.split('/');
					if ( val_arr < 3 ) {
						val_arr[1] = val_arr[0];
						val_arr[2] = val_arr[0];
					}
					values[0] = val_arr[0];
					values[1] = val_arr[1];
					values[2] = val_arr[2];
				}
				
				// Create Fields
				$c_wrap.prepend('\
					<div class="is-desktop ashade-rmwb-dimension-field"></div>\
					<div class="is-tablet ashade-rmwb-dimension-field"></div>\
					<div class="is-mobile ashade-rmwb-dimension-field"></div>\
				');
				$c_wrap.children('div').each(function() {
					let $c_parent = jQuery(this),
						ind = $c_parent.index();
					$c_parent.append('\
						<input type="number" min="'+ min +'" max="'+ max +'">\
						<input type="number" min="'+ min +'" max="'+ max +'">\
						<input type="number" min="'+ min +'" max="'+ max +'">\
						<input type="number" min="'+ min +'" max="'+ max +'">\
						<a href="#" class="ashade-dimension-locker"><i class="dashicons dashicons-lock"></i><i class="dashicons dashicons-unlock"></i></a>\
					');
					if ( values[ind].indexOf('x') ) {
						values[ind] = values[ind].split('x');
					} else {
						values[ind] = array(0,0,0,0,1);
					}
					$c_parent.children('input').each(function() {
						jQuery(this).val(values[ind][jQuery(this).index()]);
					});
					if ( parseInt(values[ind][4],10) ) {
						$c_parent.children('a').addClass('is-locked');
					}
					$c_parent.on('click', 'a', function(e) {
						e.preventDefault();
						jQuery(this).toggleClass('is-locked');
						locker_change( jQuery(this).parent().index());
					});
					$c_parent.on('change', 'input', function() {
						this_change( jQuery(this) );
					}).on('keyup', 'input', function(){
						this_change( jQuery(this) );
					});
				});
				this_update();
				// Debug
				// $this.attr('type', 'text');
			}
		});
	}

	/* --- Metabox: Custom Parent Class --- */
	if ( jQuery('[data-ashade-parent-class]').length ) {
		jQuery('[data-ashade-parent-class]').each( function() {
			jQuery(this).parents('.rwmb-field').addClass( jQuery(this).attr('data-ashade-parent-class') );
		});
	}

	/* --- Metabox: Tabs --- */
	if (jQuery('.rwmb-meta-box').length) {
		jQuery('.rwmb-meta-box').each(function() {
			var $this_box = jQuery(this),
				this_box_id = $this_box.attr('id');
			
			if ($this_box.find('span.ashade-rwmb-tab').length > 1) {
				// Add TabBox
				$this_box.addClass('has-tabs');
				$this_box.parent().addClass('ashade-tabs-wrapper');
				let $this_tabs_wrap = jQuery('<div class="ashade-rwmb-tabs-box"/>').insertBefore($this_box),
					$this_tabs_list = jQuery('<ul class="ashade-rwmb-tab-list"/>').appendTo($this_tabs_wrap);
				
				//Create Tabs in this Box
				$this_box.find('span.ashade-rwmb-tab').each(function() {
					let $this_parent = jQuery(this).parents('.rwmb-field').addClass('ashade-rwmb-tab-field'),
						current_tab_id = jQuery(this).text(),
						$this_tab_content = jQuery(),
						next_field = $this_parent[0].nextSibling;
					
					// Add Tab to TabBox
					$this_tabs_list.append('<li data-tab="'+ current_tab_id +'">'+ $this_parent.find('h4').text() +'</li>');
					
					while(next_field) {
						if (!jQuery(next_field).find('span.ashade-rwmb-tab').length) {
							$this_tab_content.push(next_field);
							next_field = next_field.nextSibling;
						} else {
							break;
						}
					}
				
					$this_tab_content.wrapAll('<div class="ashade-rwmb-tab-content" data-id="'+ current_tab_id +'" />');
					$this_parent.remove();
				});
				
				$this_box.find('.ashade-rwmb-tab-content').eq(0).addClass('is-active');
				$this_tabs_list.find('li:first-child').addClass('is-active');
				$this_tabs_list.on('click', 'li', function() {
					let $this_li = jQuery(this);
					
					$this_tabs_list.children('li.is-active').removeClass('is-active');
					$this_box.find('.ashade-rwmb-tab-content.is-active').removeClass('is-active');
					$this_li.addClass('is-active');
					$this_box.find('[data-id="'+ $this_li.data('tab') +'"]').addClass('is-active');
				});
			}
		});
	}
});