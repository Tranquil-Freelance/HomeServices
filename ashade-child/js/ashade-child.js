/**
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
"use strict";

jQuery(function($) {
	$('.ashade-child-home-trigger').on('click', function(e) {
		e.preventDefault();

		var eventName = $(this).attr('data-event');
		var targetSelector = eventName === 'contacts'
			? '.ashade-home-link--contacts > a.ashade-home-link--a'
			: '.ashade-home-link--works > a.ashade-home-link--a';
		var $target = $(targetSelector).first();

		if ($target.length) {
			$target.trigger('click');
		}
	});
});
