<?php
/**
 * InkPro albums
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_albums_mods( $inkpro_mods ) {

	if ( class_exists( 'Wolf_Albums' ) ) {
		$inkpro_mods['wolf_albums'] = array(
			'priority' => 45,
			'id' => 'wolf_albums',
			'title' => esc_html__( 'Albums', 'inkpro' ),
			'icon' => 'camera',
			'options' => array(

				'albums_layout' => array(
					'id' => 'albums_layout',
					'label' => esc_html__( 'Layout', 'inkpro' ),
					'type' => 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'inkpro' ),
						'fullwidth' => esc_html__( 'Full width', 'inkpro' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'inkpro' ),
						'sidebar-left' => esc_html__( 'Sidebar at left', 'inkpro' ),
					),
					'transport' => 'postMessage',
				),

				'albums_padding' => array(
					'id' => 'albums_padding',
					'label' => esc_html__( 'Padding', 'inkpro' ),
					'type' => 'select',
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'inkpro' ),
						'no' => esc_html__( 'No', 'inkpro' ),
					),
					'transport' => 'postMessage',
				),

				'albums_columns' => array(
					'id' => 'albums_columns',
					'label' => esc_html__( 'Columns', 'inkpro' ),
					'type' => 'select',
					'choices' => array(
						3 => 3, 
						2 => 2, 
						4 => 4, 
						5 => 5, 
						6 => 6,
					),
					'transport' => 'postMessage',
				),

				'album_cover_thumbnail_size' => array(
					'id' => 'album_cover_thumbnail_size',
					'label' => esc_html__( 'Album Cover Size', 'inkpro' ),
					'type' => 'select',
					'choices' => array(
						'inkpro-thumb' => esc_html__( 'Standard', 'inkpro' ),
						'inkpro-2x1' => esc_html__( 'Landscape', 'inkpro' ),
						'inkpro-2x2' => esc_html__( 'Square', 'inkpro' ),
						'inkpro-portrait' => esc_html__( 'Portrait', 'inkpro' ),
					),
				),
			),
		);
	}

	return $inkpro_mods;
}
add_filter( 'inkpro_customizer_options', 'inkpro_set_albums_mods' );