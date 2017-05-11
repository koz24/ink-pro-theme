<?php
/**
 * InkPro theme options
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) )  {
	exit; // Exit if accessed directly
}

/**
 * Create an array of options
 */
function inkpro_create_options() {
	return array();
}
add_filter( 'wolf_theme_options', 'inkpro_create_options' );

include_once( WOLF_THEME_DIR . '/inc/admin/options/fonts.php' );
include_once( WOLF_THEME_DIR . '/inc/admin/options/share.php' );
include_once( WOLF_THEME_DIR . '/inc/admin/options/misc.php' );
include_once( WOLF_THEME_DIR . '/inc/admin/options/css.php' );