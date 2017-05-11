<?php
/**
 * InkPro custom CSS
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_css_options( $inkpro_options ) {

	if ( is_child_theme() ) {
		$help = esc_html__( 'Want to add any custom CSS code? Put in here, and the rest is taken care of.', 'inkpro' );
	} else {
		$help = sprintf(
			__( 'Want to add any custom CSS code? Put in here, and the rest is taken care of. If you need more advanced style customization, it is strongly recommended to use a <a href="%s" target="_blank">child theme</a>.', 'inkpro' ),
			'http://codex.wordpress.org/Child_Themes'
		);
	}

	$inkpro_options[] =  array(
		'type' => 'open',
		'label' =>esc_html__( 'CSS', 'inkpro' ),
	);

		$inkpro_options[] =  array(
			'label' => esc_html__( 'Custom CSS', 'inkpro' ),
			'type' => 'section_open',
			'desc' => $help,
		);

		$inkpro_options[] =  array(
			// 'label' => esc_html__( 'Custom CSS', 'inkpro' ),
			'id' => 'custom_css',
			'type' => 'css',
		);

		$inkpro_options[] =  array( 'type' => 'section_close' );

	$inkpro_options[] =  array( 'type' => 'close' );

	return $inkpro_options;
}
add_filter( 'wolf_theme_options', 'inkpro_set_css_options' );