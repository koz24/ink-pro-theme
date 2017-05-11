<?php
/**
 * InkPro footer_bg
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_footer_bg_mods( $inkpro_mods ) {

	$inkpro_mods['footer_bg'] = array(
		'id' =>'footer_bg',
		'label' => esc_html__( 'Footer Background', 'inkpro' ),
		'background' => true,
		'icon' => 'format-image',
	);

	return $inkpro_mods;
}
add_filter( 'inkpro_customizer_options', 'inkpro_set_footer_bg_mods' );