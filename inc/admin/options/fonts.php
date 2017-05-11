<?php
/**
 * InkPro fonts options
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_font_options( $inkpro_options ) {

	$inkpro_options[] = array(
		'type' => 'open',
		'label' => esc_html__( 'Fonts Loader', 'inkpro' ),
	);

		$inkpro_options[] = array(
			'label' => esc_html__( 'Fonts', 'inkpro' ),
			'type' => 'section_open',
			'desc' => sprintf(
				wp_kses(
						__( 'Loads your fonts here then select which font to use in the <a href="%s">customizer</a>.', 'inkpro' ),
						array( 'a' => array( 'href' => array() ) )
					),
					esc_url( admin_url( 'customize.php' ) )
				),
		);

			$inkpro_options[] = array(
				'label' => esc_html__( 'Google Fonts Loader', 'inkpro' ),
				'id' => 'google_fonts',
				'desc' => sprintf( wp_kses(
						__( 'You can get your fonts on the <a href="%s" target="_blank">Google Fonts</a> website.', 'inkpro' ),
						array( 'a' => array( 'href' => array(), 'target' => array() ) )
					),
					esc_url( 'https://www.google.com/fonts' )
				),
				'placeholder' => 'Lora:400,700|Roboto:400,700',
				'type' => 'text',
				'size' => 'long',
				'help' => 'google-fonts.jpg',
			);

			$inkpro_options[] = array(
				'label' => esc_html__( 'Typekit Fonts Loader', 'inkpro' ),
				'id' => 'typekit_fonts',
				'desc' => sprintf(
					wp_kses_post(
						__( 'You need <a href="%s" target="_blank">Typekit Fonts for WordPress</a> plugin to import your font kit into your website. Once your font kit is imported, add your font names separted by a "|"  in this field to be able to select them in the customizer. <a href="%s" target="_blank">More infos</a>', 'inkpro' )
					),
					esc_url( 'https://wordpress.org/plugins/typekit-fonts-for-wordpress/' ),
					esc_url( 'https://docs.wolfthemes.com/document/add-typekit-fonts-theme/' )
				),
				'placeholder' => 'adobe-caslon-pro|other-font',
				'type' => 'text',
				'size' => 'long',
				'help' => 'typekit.png',
			);

		$inkpro_options[] = array( 'type' => 'section_close' );

	$inkpro_options[] = array( 'type' => 'close' );

	return $inkpro_options;
}
add_filter( 'wolf_theme_options', 'inkpro_set_font_options' );
