<?php
/**
 * InkPro header_image
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_header_image_mods( $inkpro_mods ) {
	
	/* Move header image setting here and rename the seciton title */
	$inkpro_mods['header_image'] = array(
		'id' => 'header_image',
		'title' => esc_html__( 'Default Header Image', 'inkpro' ),
		'icon' => 'format-image',
		'options' => array()
	);

	return $inkpro_mods;
}
add_filter( 'inkpro_customizer_options', 'inkpro_set_header_image_mods' );