<?php
/**
 * InkPro Page Builder
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_wpb_mods( $inkpro_mods ) {

	if ( class_exists( 'Wolf_Page_Builder' ) ) {
		$inkpro_mods['blog']['options']['newsletter'] = array(
			'id' =>'newsletter_form_single_blog_post',
			'label' => esc_html__( 'Newsletter Form', 'inkpro' ),
			'type' => 'checkbox',
			'description' => esc_html__( 'Display a newsletter sign up form at the bottom of each blog post.', 'inkpro' ),
		);

		$inkpro_mods['footer']['options']['footer_socials_services'] = array(
			'id' =>'footer_socials_services',
			'label' => esc_html__( 'Footer Socials', 'inkpro' ),
			'description' => sprintf( wp_kses(
				__( 'Enter the social networks names separated by a comma. e.g "twitter, facebook, instagram". ( see Wolf Page Builder options <a href="%s">social profiles tab</a>).', 'inkpro' ),
					array( 'a' => array( 'href' => array(), ) )
				),
				esc_url( admin_url( 'admin.php?page=wpb-socials' ) )
			),
			'type' => 'text',
		);

		$inkpro_mods['light_background'] = array(
			'id' =>'light_background',
			'description' => esc_html__( 'Here you can set a custom background that will be used for the "light" page builder sections.', 'inkpro' ),
			'label' => esc_html__( 'Page Builder Light Background', 'inkpro' ),
			'background' => true,
		);

		$inkpro_mods['dark_background'] = array(
			'id' =>'dark_background',
			'description' => esc_html__( 'Here you can set a custom background that will be used for the "dark" page builder sections.', 'inkpro' ),
			'label' => esc_html__( 'Page Builder Dark Background', 'inkpro' ),
			'background' => true,
		);
	}

	return $inkpro_mods;
}
add_filter( 'inkpro_customizer_options', 'inkpro_set_wpb_mods' );