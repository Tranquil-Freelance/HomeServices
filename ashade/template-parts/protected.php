<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$protected_background = '';
if ( Ashade_Core::get_fimage_url() ) {
	$protected_background = Ashade_Core::get_fimage_url();
}
if ( Ashade_Core::get_rwmb( 'ashade-protected-image' ) ) {
	$protected_background = Ashade_Core::get_rwmb( 'ashade-protected-image' );
}
if ($protected_background !== '') {
?>
<div 
	class="ashade-protected-background ashade-page-background" 
	data-src="<?php echo esc_url( $protected_background ); ?>"
	data-opacity="0.1">
</div>
<?php 
} 
?>
<div class="ashade-protected-wrap">
	<div class="ashade-protected-inner">
		<div class="ashade-page-title-wrap">
			<h1 class="ashade-page-title">
				<span><?php echo esc_html__( 'This content is password protected', 'ashade' ); ?></span>
				<?php the_title(); ?>
			</h1>
		</div><!-- .ashade-page-title-wrap -->
		<div class="ashade-protected-text">
			<div class="ashade-protected-form-wrap" data-submit="<?php echo esc_attr__( 'Continue', 'ashade' ); ?>" data-placeholder="<?php echo esc_attr__( 'Enter Password', 'ashade' ); ?>">
				<p class="ashade-intro">
				<?php 
				echo esc_html__( 'Content of this page is protected by password. To get access for this page please enter your password in the field below. Or you may return to a previous page if you are here by mistake.', 'ashade' );
				?>
				</p>
				<?php
				the_content(); 
				?>
			</div><!-- .ashade-protected-form-wrap -->
		</div><!-- .ashade-404-text -->
		<div class="ashade-protected-back-wrap ashade-back-wrap">
			<div class="ashade-back is-404-return" data-home="<?php echo esc_url( home_url( '/' ) ); ?>">
				<span><?php echo esc_html__( 'Previous Page', 'ashade' ); ?></span>
				<span><?php echo esc_html__( 'Go Back', 'ashade' ); ?></span>
			</div>
		</div><!-- .ashade-protected-back-wrap -->
	</div><!-- .ashade-protected-inner -->
</div><!-- .ashade-protected-wrap -->