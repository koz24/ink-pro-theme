<?php
/**
 * InkPro header_settings
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_header_settings_mods( $inkpro_mods ) {

	$inkpro_mods['header_settings'] = array(

		'id' => 'header_settings',
		'title' => esc_html__( 'Header Settings', 'inkpro' ),
		'icon' => 'editor-table',
		'options' => array(

			'auto_header' => array(
				'id' =>'auto_header',
				'label' => esc_html__( 'Use the post featured image as header image.', 'inkpro' ),
				'type' => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'inkpro' ),
					'' => esc_html__( 'No', 'inkpro' ),
				),
			),

			'auto_header_type' => array(
				'label'	=> esc_html__( 'Page Header Type', 'inkpro' ),
				'id'	=> 'auto_header_type',
				'type'	=> 'select',
				'choices' => array(
					'standard' => esc_html__( 'Standard', 'inkpro' ),
					'big' => esc_html__( 'Big', 'inkpro' ),
					'small' => esc_html__( 'Small', 'inkpro' ),
					'breadcrumb' => esc_html__( 'Breadcrumb', 'inkpro' ),
					'none' => esc_html__( 'No header', 'inkpro' ),
				),
			),

			'auto_header_effect' => array(
				'id' =>'auto_header_effect',
				'label' => esc_html__( 'Header Image Effect', 'inkpro' ),
				'type' => 'select',
				'choices' => array(
					'parallax' => esc_html__( 'Parallax', 'inkpro' ),
					'zoomin' => esc_html__( 'Zoom', 'inkpro' ),
					'none' => esc_html__( 'None', 'inkpro' ),
				),
			),
		),
	);

	return $inkpro_mods;
}
add_filter( 'inkpro_customizer_options', 'inkpro_set_header_settings_mods' );