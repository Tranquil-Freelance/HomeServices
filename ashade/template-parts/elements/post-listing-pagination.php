<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

echo get_the_posts_pagination( array(
	'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="9.844" height="17.625" viewBox="0 0 9.844 17.625"><path id="angle-left" d="M2.25-17.812l1.125,1.125L-4.359-9,3.375-1.312,2.25-.187-6-8.437-6.469-9-6-9.562Z" transform="translate(6.469 17.813)" fill="#ffffff"/></svg>',
	'next_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="9.844" height="17.625" viewBox="0 0 9.844 17.625"><path id="angle-right" d="M-2.25-17.812,6-9.562,6.469-9,6-8.437-2.25-.187-3.375-1.312,4.359-9l-7.734-7.687Z" transform="translate(3.375 17.813)" fill="#ffffff"/></svg>',
) );
?>