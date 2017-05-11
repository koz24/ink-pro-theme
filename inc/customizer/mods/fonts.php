<?php
/**
 * InkPro fonts
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_fonts_mods( $inkpro_mods ) {

	$inkpro_google_fonts = apply_filters( 'inkpro_customizer_font_choices', inkpro_get_google_fonts_options() );
	$inkpro_font_choices = array( 'default' => esc_html__( 'Default', 'inkpro' ) );

	foreach ( $inkpro_google_fonts as $key => $value ) {
		$inkpro_font_choices[ $key ] = $key;
	}

	$inkpro_mods['fonts'] = array(
		'id' => 'fonts',
		'title' => esc_html__( 'Fonts', 'inkpro' ),
		'icon' => 'editor-textcolor',
		'options' => array(),
	);

	$inkpro_mods['fonts']['options']['body_font_name'] = array(
		'label' => esc_html__( 'Body Font Name', 'inkpro' ),
		'id' => 'body_font_name',
		'type' => 'text',
		'description' => sprintf( wp_kses(
				__( 'A loaded google font or any <a href="%s" title="more infos" target="_blank">native browser fonts</a>.', 'inkpro' ),
				array( 'a' => array( 'href' => array(), 'target' => array(), 'title' => array(), ), )
			),
			'http://www.w3schools.com/cssref/css_websafe_fonts.asp'
		),
	);

	/*************************Menu****************************/

	$inkpro_mods['fonts']['options']['menu_font_size'] = array(
		'id' => 'menu_font_size',
		'label' => esc_html__( 'Menu Font Size for Desktop', 'inkpro' ),
		'type' => 'text',
		//'transport' => 'postMessage',
	);

	$inkpro_mods['fonts']['options']['menu_font_size_mobile'] = array(
		'id' => 'menu_font_size_mobile',
		'label' => esc_html__( 'Menu Font Size for Mobile', 'inkpro' ),
		'type' => 'text',
		//'transport' => 'postMessage',
	);

	$inkpro_mods['fonts']['options']['menu_font_name'] = array(
		'id' => 'menu_font_name',
		'label' => esc_html__( 'Menu Font', 'inkpro' ),
		'type' => 'select',
		'choices' => $inkpro_font_choices,
		//'transport' => 'postMessage',
	);

	$inkpro_mods['fonts']['options']['menu_font_weight'] = array(
		'label' => esc_html__( 'Menu Font Weight', 'inkpro' ),
		'id' => 'menu_font_weight',
		'type' => 'text',
	);

	$inkpro_mods['fonts']['options']['menu_font_transform'] = array(
		'id' => 'menu_font_transform',
		'label' => esc_html__( 'Menu Font Transform', 'inkpro' ),
		'type' => 'select',
		'choices' => array(
			'none' => esc_html__( 'None', 'inkpro' ),
			'uppercase' => esc_html__( 'Uppercase', 'inkpro' ),
		),
		//'transport' => 'postMessage',
	);

	$inkpro_mods['fonts']['options']['menu_font_style'] = array(
		'id' => 'menu_font_style',
		'label' => esc_html__( 'Menu Font Style', 'inkpro' ),
		'type' => 'select',
		'choices' => array(
			'normal' => esc_html__( 'Normal', 'inkpro' ),
			'italic' => esc_html__( 'Italic', 'inkpro' )
		),
		//'transport' => 'postMessage',
	);

	$inkpro_mods['fonts']['options']['menu_font_letter_spacing'] = array(
		'label' => esc_html__( 'Menu Letter Spacing (omit px)', 'inkpro' ),
		'id' => 'menu_font_letter_spacing',
		'type' => 'int',
	);

	/*************************Heading****************************/

	$inkpro_mods['fonts']['options']['heading_font_name'] = array(
		'id' => 'heading_font_name',
		'label' => esc_html__( 'Heading Font', 'inkpro' ),
		'type' => 'select',
		'choices' => $inkpro_font_choices,
		//'transport' => 'postMessage',
	);

	$inkpro_mods['fonts']['options']['heading_font_weight'] = array(
		'label' => esc_html__( 'Heading Font weight', 'inkpro' ),
		'id' => 'heading_font_weight',
		'type' => 'text',
		'description' => esc_html__( 'For example: 400 is normal, 700 is bold.The available font weights depend on the font. Leave empty to use the theme default style', 'inkpro' ),
	);

	$inkpro_mods['fonts']['options']['heading_font_transform'] = array(
		'id' => 'heading_font_transform',
		'label' => esc_html__( 'Heading Font Transform', 'inkpro' ),
		'type' => 'select',
		'choices' => array(
			'none' => esc_html__( 'None', 'inkpro' ),
			'uppercase' => esc_html__( 'Uppercase', 'inkpro' ),
		),
		//'transport' => 'postMessage',
	);

	$inkpro_mods['fonts']['options']['heading_font_style'] = array(
		'id' => 'heading_font_style',
		'label' => esc_html__( 'Heading Font Style', 'inkpro' ),
		'type' => 'select',
		'choices' => array(
			'normal' => esc_html__( 'Normal', 'inkpro' ),
			'italic' => esc_html__( 'Italic', 'inkpro' )
		),
		//'transport' => 'postMessage',
	);

	$inkpro_mods['fonts']['options']['heading_font_letter_spacing'] = array(
		'label' => esc_html__( 'Heading Letter Spacing (omit px)', 'inkpro' ),
		'id' => 'heading_font_letter_spacing',
		'type' => 'int',
	);

	return $inkpro_mods;
}
add_filter( 'inkpro_customizer_options', 'inkpro_set_fonts_mods' );