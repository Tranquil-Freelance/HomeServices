<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$contact_data = get_query_var( 'shadow_contacts' );
?>
<div class="ashade-widget--contacts">
	<?php echo ( ! empty( $contact_data[ 'descr' ] ) ? wp_specialchars_decode( $contact_data[ 'descr' ] ) : '' ); ?>
	<ul class="ashade-contact-details__list <?php echo ( $contact_data[ 'labels' ] ? 'has-labels' : '' ); ?>">
	<?php 
		if ( ! empty( $contact_data[ 'location' ] ) ) {
		echo '<li>
			' . ( $contact_data[ 'labels' ] ? '<i class="ashade-contact-icon asiade-icon--location"></i>' : '' ) . '
			' . esc_html( $contact_data[ 'location' ] ) . '
		</li>';
		}
		if ( ! empty( $contact_data[ 'email' ] ) ) {
			echo '<li>
				' . ( $contact_data[ 'labels' ] ? '<i class="ashade-contact-icon asiade-icon--email"></i>' : '' ) . '
				<a href="mailto:' . sanitize_email( $contact_data[ 'email' ] ) . '">' . sanitize_email( $contact_data[ 'email' ] ) . '</a>
			</li>';
		}
		if ( ! empty( $contact_data[ 'phone' ] ) ) {
			echo '<li>
				' . ( $contact_data[ 'labels' ] ? '<i class="ashade-contact-icon asiade-icon--phone"></i>' : '' ) . '
				<a href="tel:' . esc_attr( strtr( $contact_data[ 'phone' ], [' ' => '', '(' => '', ')' => '', '-' => ''] ) ) . '">' . esc_attr( $contact_data[ 'phone' ] ) . '</a>
			</li>';
		}
		if ( ! empty( $contact_data[ 'fax' ] ) ) {
			echo '<li>
				' . ( $contact_data[ 'labels' ] ? '<i class="ashade-contact-icon asiade-icon--fax"></i>' : '' ) . '
				' . esc_attr( $contact_data[ 'fax' ] ) . '
			</li>';
		}
		if ( $contact_data[ 'socials' ] ) {
			echo '<li class="ashade-contact-socials">
				' . ( $contact_data[ 'labels' ] ? '<i class="ashade-contact-icon asiade-icon--socials"></i>' : '' );
			Ashade_Core::the_social_links();
			echo '</li>';
		}
		?>
	</ul>
</div>