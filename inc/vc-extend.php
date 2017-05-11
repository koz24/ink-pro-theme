<?php
/**
 * InkPro Visual Composer Extend
 *
 * Add Visual Composer Compatiblity
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Vc_Manager' ) ) {
	return;
}

/* Removing unwanted parameters */
if ( function_exists( 'vc_remove_param' ) ) {
	//vc_remove_param( 'vc_row', 'full_width' );
}

// Content inner width
vc_add_param( 'vc_row', array(
	'type' => 'dropdown',
	'class' => '',
	'show_settings_on_create' => true,
	'heading' => esc_html__( 'Content Type', 'inkpro' ),
	'param_name' => 'content_type',
	'value' => array(
		sprintf( esc_html__( 'Standard width (%s centered)', 'inkpro' ), '1140px' ) => 'standard',
		sprintf( esc_html__( 'Small width (%s centered)', 'inkpro' ), '750px' ) => 'small',
		sprintf( esc_html__( 'Large width (%s centered)', 'inkpro' ), '98%' ) => 'large',
		sprintf( esc_html__( 'Full width (%s)', 'inkpro' ), '100%' ) => 'full',
	)
) );

// Padding top
vc_add_param( 'vc_row', array(
	'type' => 'textfield',
	'class' => '',
	'heading' => esc_html__( 'Padding top', 'inkpro' ),
	'param_name' => 'padding_top',
	'description' => '',
	'value' => '50px',
) );

// Padding bottom
vc_add_param( 'vc_row', array(
	'type' => 'textfield',
	'class' => '',
	'heading' => esc_html__( 'Padding bottom', 'inkpro' ),
	'param_name' => 'padding_bottom',
	'description' => '',
	'value' => '50px',
) );

// Font color
vc_add_param( 'vc_row', array(
	'type' => 'dropdown',
	'class' => '',
	'show_settings_on_create' => true,
	'heading' => esc_html__( 'Font Color', 'inkpro' ),
	'param_name' => 'font_color',
	'value' => array(
		esc_html__( 'Dark', 'inkpro' ) => 'dark',
		esc_html__( 'Light', 'inkpro' ) => 'light',
	),
) );

// Overlay
vc_add_param( 'vc_row', array(
	'type' => 'dropdown',
	'class' => '',
	'show_settings_on_create' => true,
	'heading' => esc_html__( 'Add Overlay', 'inkpro' ),
	'param_name' => 'overlay',
	'value' => array(
		esc_html__( 'No', 'inkpro' ) => '',
		esc_html__( 'Yes', 'inkpro' ) => 'yes',
	),
) );

// Overlay color
vc_add_param( 'vc_row', array(
	'type' => 'colorpicker',
	'class' => '',
	'show_settings_on_create' => true,
	'heading' => esc_html__( 'Overlay Color', 'inkpro' ),
	'param_name' => 'overlay_color',
	'value' => '#000000',
	'dependency' => array( 'element' => 'overlay', 'value' => array( 'yes' ) ),
) );

// Overlay opacity
vc_add_param( 'vc_row', array(
	'type' => 'textfield',
	'class' => '',
	'heading' => esc_html__( 'Overlay Opacity in Oercent', 'inkpro' ),
	'param_name' => 'overlay_opacity',
	'description' => '',
	'value' => 40,
	'dependency' => array( 'element' => 'overlay', 'value' => array( 'yes' ) ),
) );