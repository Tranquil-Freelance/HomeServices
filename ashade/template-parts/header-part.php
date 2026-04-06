<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( Ashade_Core::get_mod( 'ashade-header-sticky' ) ) {
	$header_bg = Ashade_Core::get_mod( 'ashade-header-scroll-state' );
} else {
	$header_bg = false;
}
?>
<header id="ashade-header" data-fade-point="0" <?php echo ( esc_attr( $header_bg ) ? 'class="ashade-header--' . $header_bg .'"' : '' ); ?>>
	<div class="ashade-header-inner">
		<div class="ashade-logo-block">
			<?php 
			if ( Ashade_Core::get_mod( 'ashade-logo-type' ) == 'image' ) {
			# Image Logo
			$logo_image_id = attachment_url_to_postid( Ashade_Core::get_mod( 'ashade-logo-url' ) );
			if ( $logo_image_id ) {
				$logo_image_meta = wp_get_attachment_metadata( $logo_image_id );
				$logo_width = $logo_image_meta[ 'width' ];
				$logo_height = $logo_image_meta[ 'height' ];
			} else {
				$logo_width = 128;
				$logo_height = 110;
			}
			?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ashade-logo <?php echo ( Ashade_Core::get_mod( 'ashade-retina-logo' ) ? 'is-retina' : '' ); ?>">
				<img 
					src="<?php echo esc_url( Ashade_Core::get_mod( 'ashade-logo-url' ) ); ?>" 
					alt="<?php echo get_bloginfo( 'name' ); ?>" 
					width="<?php echo esc_attr( $logo_width ); ?>" 
					height="<?php echo esc_attr( $logo_height ); ?>">
			</a>
			<?php
			}
			if ( Ashade_Core::get_mod( 'ashade-logo-type' ) == 'text' ) {
			# Text Logo
			?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="ashade-logo is-text">
				<span class="ashade-text-logo"><?php echo esc_html( Ashade_Core::get_mod( 'ashade-logo-text' ) ); ?></span>
			</a>
			<?php
			}
			?>
		</div>
		<div class="ashade-nav-block">
			<nav class="ashade-nav">
				<?php
				$menu_location = get_nav_menu_locations();
				if ( isset( $menu_location[ 'main' ] ) && 0 !== $menu_location[ 'main' ] ) {
					wp_nav_menu( array(
						'theme_location' => 'main', 
						'menu_class' => 'main-menu',
						'items_wrap' => Ashade_Core::get_menu_wrap(),
						'depth' => '3'
					) );
				} else {
					if ( current_user_can( 'manage_options' ) ) {
						echo '<div class="ashade-no-menu">' . esc_html__( 'Menu not found. Please create and select menu in ', 'ashade' ) . '<a target="_blank" href="' . esc_url( get_admin_url( null, 'nav-menus.php' ) ) . '">' . esc_html__( 'Appearance -> Menus', 'ashade' ) . '</a>' . '</div>';
					}
				}
				?>                    
			</nav>
			<?php if ( Ashade_Core::get_mod( 'ashade-mobile-menu-alt' ) ) { ?>
			<nav class="ashade-mob-nav">
				<?php
				$menu_location = get_nav_menu_locations();
				if ( isset( $menu_location[ 'mobile' ] ) && 0 !== $menu_location[ 'mobile' ] ) {
					wp_nav_menu( array(
						'theme_location' => 'mobile', 
						'menu_class' => 'mobile-menu main-menu',
						'depth' => '3'
					) );
				} else {
					if ( current_user_can( 'manage_options' ) ) {
						echo '<div class="ashade-no-menu">' . esc_html__( 'Alternative Mobile Menu not found. Please create and select menu in ', 'ashade' ) . '<a target="_blank" href="' . esc_url( get_admin_url( null, 'nav-menus.php' ) ) . '">' . esc_html__( 'Appearance -> Menus', 'ashade' ) . '</a>' . '</div>';
					}
				}
				?>                    
			</nav>
			<?php } ?>
		</div>
	</div>
</header>