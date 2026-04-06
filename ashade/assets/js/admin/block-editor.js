/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */

"use strict";

jQuery(window).on('load', function() {
    const has_gb = wp.hasOwnProperty('data');
    if ( has_gb ) {
        const ashade_wpbe_subtitle = {
            init: function() {
                const _self = this;
                this.tryCount = 0;
                this.tryMax = 10;
                this.$originalField = jQuery('input[name="ashade-page-subtitle"]');
                this.$originalField.parents('.ashade-subtitle-field-wrap').addClass('hide-field');
                
                if ( this.check() === 1 ) {
                    this.activate();
                } else {
                    setTimeout( function() {
                        _self.reCheck();
                    }, 100, _self);
                }
            },
            check: function() {
                return jQuery('iframe[name="editor-canvas"]').length;
            },
            activate() {
                const _self = this;
                this.$iframe = jQuery('iframe[name="editor-canvas"]');
                this.$iframe.on('load', function() {
                    _self.inject();
                });
            },
            reCheck: function() {
                const _self = this;
                this.tryCount++;
                if ( this.check() === 1 ) {
                    this.activate();
                } else {
                    if ( this.tryCount <= this.tryMax ) {
                        setTimeout( function() {
                            _self.reCheck();
                        }, 100, _self);
                    } else {
                        this.$originalField.parents('.ashade-subtitle-field-wrap').addClass('is-shown').removeClass('hide-field');
                    }
                }
            },
            inject: function() {
                const _self = this;
                const $title_container = this.$iframe.contents().find('h1.wp-block-post-title').parent();
                this.$subtitleField = this.$originalField.clone();
                this.$subtitleField
                    .addClass('ashade-block-editor-overhead')
                    .prependTo($title_container)
                    .css({
                        'border': 'none',
                        'border-bottom': '1px solid #e6e6e6',
                        'max-width': '840px',
                        'width': '100%',
                        'padding': '0 0 12px 0',
                        'margin': '0 0 -18px 0',
                        'font-size': '16px',
                        'line-height': '1.6',
                        'color': '#000000'
                    })
                    .wrap('<div class="ashade-block-editor-subtitle-wrap" style="display:flex; justify-content: center;"/>')
                    .on('change', function() {
                        _self.$originalField.val(this.value);
                    }).on('keyup', function() {
                        _self.$originalField.val(this.value);
                    });
            }
        }
        ashade_wpbe_subtitle.init();
    }
});