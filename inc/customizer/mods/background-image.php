<?php
/**
 * InkPro background_image
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_background_image_mods( $inkpro_mods ) {
	
	//* Move background image setting here and rename the seciton title */
	$inkpro_mods['background_image'] = array(
		'id' => 'background_image',
		'title' => esc_html__( 'Background Image', 'inkpro' ),
		'options' => array()
	);
	return $inkpro_mods;
}
add_filter( 'inkpro_customizer_options', 'inkpro_set_background_image_mods' );