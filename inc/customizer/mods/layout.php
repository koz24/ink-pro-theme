<?php
/**
 * InkPro layout
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_layout_mods( $inkpro_mods ) {

	$inkpro_mods['layout'] = array(

		'id' => 'layout',
		'title' => esc_html__( 'Layout', 'inkpro' ),
		'icon' => 'layout',
		// 'description' => esc_html__( 'The accent color used for links and keypoints', 'inkpro' ),
		'options' => array(

			'site_layout' => array(
				'id' => 'site_layout',
				'label' => esc_html__( 'Site Layout', 'inkpro' ),
				'type' => 'select',
				'default' => 'wide',
				'choices' => array(
					'wide' => esc_html__( 'Wide', 'inkpro' ),
					'boxed' => esc_html__( 'Boxed', 'inkpro' ),
					'frame' => esc_html__( 'Frame', 'inkpro' ),
				),
				'transport' => 'postMessage',
			),

			'site_width' => array(
				'id' => 'site_width',
				'label' => esc_html__( 'Site Width for Boxed Layout', 'inkpro' ),
				'type' => 'text',
				'description' => esc_html__( 'Set the width of the site wrapper here if your layout is set to "boxed" above', 'inkpro' )
			),

			'site_margin' => array(
				'id' => 'site_margin',
				'label' => esc_html__( 'Site Margin for Frame Layout', 'inkpro' ),
				'type' => 'text',
				'description' => sprintf( esc_html__( 'Supports CSS format like %s', 'inkpro' ), '0px 0px 0px 0px' ),
			),

			'text_link_style' => array(
				'id' => 'text_link_style',
				'label' => esc_html__( 'Text Link Style', 'inkpro' ),
				'type' => 'select',
				'choices' => array(
					'colored' => esc_html__( 'Colored', 'inkpro' ),
					'colored_hover' => esc_html__( 'Colored on hover', 'inkpro' ),
				),
				//'transport' => 'postMessage',
			),

			'button_style' => array(
				'id' => 'button_style',
				'label' => esc_html__( 'Button Style', 'inkpro' ),
				'type' => 'select',
				'choices' => array(
					'default' => esc_html__( 'Default', 'inkpro' ),
					'square' => esc_html__( 'Square', 'inkpro' ),
					'round' => esc_html__( 'Round', 'inkpro' ),
				),
				'transport' => 'postMessage',
			),

			'lightbox' => array(
				'id' => 'lightbox',
				'label' => esc_html__( 'Lightbox', 'inkpro' ),
				'type' => 'select',
				'default' => 'swipebox',
				'choices' => array(
					'swipebox' => 'swipebox',
					'fancybox' => 'fancybox',
					'' => esc_html__( 'None', 'inkpro' ),
				),
				//'transport' => 'postMessage',
			),

			'do_lazyload' => array(
				'id' => 'do_lazyload',
				'label' => esc_html__( 'Lazyload images if possible', 'inkpro' ),
				'type' => 'checkbox',
			),
		),
	);

	return $inkpro_mods;
}
add_filter( 'inkpro_customizer_options', 'inkpro_set_layout_mods' );