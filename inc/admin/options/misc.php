<?php
/**
 * InkPro misc options
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_misc_options( $inkpro_options ) {

	$inkpro_options[] = array(
		'type' => 'open',
		'label' => esc_html__( 'Misc', 'inkpro' ),
	);

		$inkpro_options[] = array(
			'label' => esc_html__( 'Misc', 'inkpro' ),
			'type' => 'section_open',
			'desc' => '',
		);

		$inkpro_options[] = array(
			'label' => esc_html__( 'Search Form Placeholder', 'inkpro' ),
			'id' => 'search_placeholder_text',
			'type' => 'text',
		);

		$inkpro_options[] = array(
			'label' => esc_html__( '404 Background', 'inkpro' ),
			'id' => '404_bg',
			'type' => 'image',
		);

		$inkpro_options[] = array( 'type' => 'section_close' );

	$inkpro_options[] = array( 'type' => 'close' );

	return $inkpro_options;
}
add_filter( 'wolf_theme_options', 'inkpro_set_misc_options' );