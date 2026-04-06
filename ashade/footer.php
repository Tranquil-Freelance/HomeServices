<?php 
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
	$rcp_message_state = Ashade_Core::get_mod( 'ashade-protection-rclick-message-state' );
	$rcp_message = Ashade_Core::get_mod( 'ashade-protection-rclick-message' );
	
	if ( $rcp_message_state && ! empty ( $rcp_message ) ) {
		?>
		<div class="ashade-rcp-message-wrap"><?php echo esc_html( $rcp_message ); ?></div>
		<?php
	}
    wp_footer();
?>
</body>
</html>
