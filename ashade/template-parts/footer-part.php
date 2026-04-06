<?php
/** 
 * Author: Shadow Themes
 * Author URL: http://shadow-themes.com
 */
if ( ! defined( 'ABSPATH' ) ) exit;

$copyright_position = Ashade_Core::get_mod( 'ashade-copyright-pos' );
$copyright_state = strlen( Ashade_Core::get_mod( 'ashade-copyright-text' ) ) ? true : false;
$socials_state = Ashade_Core::get_mod( 'ashade-socials-state' );
$socials_position = $socials_state ? Ashade_Core::get_mod( 'ashade-socials-pos' ) : 'none';
$menu_global_pos = Ashade_Core::get_mod( 'ashade-footer-menu-position' );
$menu_position = 'none';
$menu_state = false;
if ( $menu_global_pos == 'left' || $menu_global_pos == 'center' || $menu_global_pos == 'right' ) {
    $menu_position = $menu_global_pos;
    $menu_state = true;
} else if ( $menu_global_pos !== 'none' ) {
    $copyright_state = true;
}
if ( $menu_global_pos == 'none' && strlen( Ashade_Core::get_mod( 'ashade-copyright-text' ) ) < 1 ) {
    $copyright_position = 'none';
    $copyright_state = false;
}
$maintenance = false;
if ( Ashade_Core::get_maintenance_status() && ! current_user_can( 'edit_posts' ) ) {
    $maintenance = true;
    if ( $menu_state && ! Ashade_Core::get_mod( 'ashade-footer-menu-maintenance' ) ) {
        $menu_state = false;
        $menu_position = 'none';
    }
}
$cols_arr = [];
if ( $copyright_state ) {
    $cols_arr[$copyright_position] = ['copyright'];
}
if ( $socials_state ) {
    if ( array_key_exists($socials_position, $cols_arr) ) {
        array_push($cols_arr[$socials_position], 'socials');
    } else {
        $cols_arr[$socials_position] = ['socials'];
    }
}
if ( $menu_state ) {
    if ( array_key_exists($menu_position, $cols_arr) ) {
        array_push($cols_arr[$menu_position], 'menu');
    } else {
        $cols_arr[$menu_position] = ['menu'];
    }
}
$cols = count($cols_arr);

if ( $cols == 2 && array_key_exists('center', $cols_arr) ) {
    $cols = 3;
}

?>
<footer id="ashade-footer" class="ashade-main-footer<?php echo esc_attr( $menu_global_pos !== 'none' ? ' has-footer-menu' : '') . ($maintenance ? ' ashade-maintenance-footer' : ''); ?>">
    <div class="ashade-footer-inner ashade-footer-<?php echo esc_attr($cols); ?>col">
        <?php
            if ( $cols == 3 || array_key_exists('left', $cols_arr ) ) {
                # Left Column
                ?>
                <div class="ashade-footer-col ashade-footer-col-lt">
                    <?php
                    if ( array_key_exists('left', $cols_arr ) ) {
                        Ashade_Core::get_footer_column( $cols_arr['left'] );
                    }
                    ?>
                </div>
                <?php
            }
            if ( $cols == 3 || array_key_exists('center', $cols_arr ) ) {
                # Center Column
                ?>
                <div class="ashade-footer-col ashade-footer-col-cr">
                    <?php
                    if ( array_key_exists('center', $cols_arr ) ) {
                        Ashade_Core::get_footer_column( $cols_arr['center'] );
                    }
                    ?>
                </div>
                <?php
            }
            if ( $cols == 3 || array_key_exists('right', $cols_arr ) ) {
                # Right Column
                ?>
                <div class="ashade-footer-col ashade-footer-col-rt">
                    <?php 
                    if ( array_key_exists('right', $cols_arr ) ) {
                        Ashade_Core::get_footer_column( $cols_arr['right'] );
                    }
                    ?>
                </div>
                <?php
            }
        ?>
    </div>
</footer>
<?php if ( $menu_global_pos !== 'none' && Ashade_Core::get_mod( 'ashade-footer-menu-overlay' ) ) {
    echo '<div class="ashade-footer-menu-overlay"></div>';
}
?>
