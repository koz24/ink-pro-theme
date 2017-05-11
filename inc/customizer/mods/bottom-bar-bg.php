<?php
/**
 * InkPro bottom_bar
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_bottom_bar_mods( $inkpro_mods ) {

	$inkpro_mods['bottom_bar_bg'] = array(
		'id' =>'bottom_bar_bg',
		'label' => esc_html__( 'Bottom Bar Background', 'inkpro' ),
		'background' => true,
	);

	return $inkpro_mods;
}
add_filter( 'inkpro_customizer_options', 'inkpro_set_bottom_bar_mods' );