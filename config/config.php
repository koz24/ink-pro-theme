<?php
/**
 * Theme configuration file
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

/**
 * Set color scheme
 *
 * Add csutom color scheme
 *
 * @param array $color_scheme
 * @param array $color_scheme
 */
function inkpro_set_color_schemes( $color_scheme ) {

	$color_scheme['light'] = array(
		'label'  => esc_html__( 'Light', 'inkpro' ),
		'colors' => array(
			'#ffffff', // bg
			'#ffffff', // page bg
			'#ee3440', // accent
			'#666', // main text
			'#777777', // second text
			'#333333', // strong text
			'#333333', // submenu
			'#ffffff', // content frame
			'#ee3440', // shop tabs background
			'#ffffff', // shop tabs text
		)
	);

	$color_scheme['dark'] = array(
		'label'  => esc_html__( 'Dark', 'inkpro' ),
		'colors' => array(
			'#262626', // bg
			'#1a1a1a', // page bg
			'#ee3440', // accent
			'#e5e5e5', // main text
			'#c1c1c1', // second text
			'#FFFFFF', // strong text
			'#282828', // submenu
			'#0d0d0d', // content frame
			'#ee3440', // shop tabs background
			'#ffffff', // shop tabs text
		)
	);

	return $color_scheme;
}
add_filter( 'inkpro_color_schemes', 'inkpro_set_color_schemes' );

/**
 * Add additional theme support
 */
function inkpro_additional_theme_support() {

	/**
	 * Enable WooCommerce support
	 */
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'inkpro_additional_theme_support' );

/**
 * Add post display options
 *
 * @param array $options
 * @param array $options
 */
function inkpro_add_blog_display_options( $options ) {

	$new_options = array(
		'standard' => esc_html__( 'Standard', 'inkpro' ),
		'grid' => esc_html__( 'Square grid', 'inkpro' ),
		'grid3' => esc_html__( 'Portrait grid', 'inkpro' ),
		'column' => esc_html__( 'Columns', 'inkpro' ),
		'masonry' => esc_html__( 'Masonry', 'inkpro' ),
		'metro' => esc_html__( 'Metro', 'inkpro' ),
		'medium-image' => esc_html__( 'Medium image', 'inkpro' ),
		'photo' => esc_html__( 'Photo', 'inkpro' ),
	);

	$options = array_merge( $new_options, $options );
	
	return $options;
}
add_filter( 'inkpro_blog_display_options', 'inkpro_add_blog_display_options' );

/**
 * Add shop product display options
 *
 * @param array $options
 * @param array $options
 */
function inkpro_add_shop_display_options( $options ) {

	if ( class_exists( 'WooCommerce' ) ) {
		$options['loren'] = esc_html__( 'Loren', 'inkpro' );
		$options['agathe'] = esc_html__( 'Agathe', 'inkpro' );
	}

	return $options;
}
add_filter( 'inkpro_shop_display_options', 'inkpro_add_shop_display_options' );

/**
 * Inject theme button style params
 *
 * @param array $button_types
 * @return array $button_types
 */
function inkpro_add_theme_button_type( $button_types ) {
	
	$additional_button_types = array();
	$additional_button_types['wolf-wpb-button'] = esc_html__( 'Theme Accent Color', 'inkpro' );

	return $additional_button_types + $button_types;
}
add_filter( 'wpb_button_types', 'inkpro_add_theme_button_type' );