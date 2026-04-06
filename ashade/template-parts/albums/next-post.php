<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if( get_adjacent_post( false, '', false ) ) {
	$post = get_next_post();
	echo '
	<section class="ashade-next-album-wrap ashade-section">
		<a href="'. esc_url( get_permalink($post->ID) ) .'" class="ashade-next-album">
			<h2>
				<span>'. esc_html( get_the_title( $post->ID ) ) . '</span>
				'. esc_html__( 'Next Album', 'ashade' ) .'
			</h2>
			<div class="ashade-next-album-preview" data-src="'. get_the_post_thumbnail_url( $post->ID, 'medium' ) .'"></div>
		</a>
	</section>';
} else { 
	$post = new WP_Query('post_type=ashade-albums&posts_per_page=1&order=ASC'); 
	$post->the_post();
	echo '
	<section class="ashade-next-album-wrap ashade-section">
		<a href="'. esc_url( get_permalink() ) .'" class="ashade-next-album">
			<h2>
				<span>'. esc_html( get_the_title() ) . '</span>
				'. esc_html__( 'Next Album', 'ashade' ) .'
			</h2>
			<div class="ashade-next-album-preview" data-src="'. get_the_post_thumbnail_url(false, 'thumbnail') .'"></div>
		</a>
	</section>';
	wp_reset_query();
}; 