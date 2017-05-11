<?php
/**
 * Filter default options
 *
 * Filter default options in WP options on theme activation
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Filter default options
 *
 * @see inc/admin/admin-funtions.php wolf_theme_default_options_init function
 */
function inkpro_set_default_font_option( $options ) {
	
	$options['google_fonts'] = 'Oswald:400,700|Raleway:300,400,700|Roboto:400,700|Noto+Serif:400,700|Anton';

	return $options;
}
add_filter( 'inkpro_default_options', 'inkpro_set_default_font_option' );