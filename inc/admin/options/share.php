<?php
/**
 * InkPro share options
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_share_options( $inkpro_options ) {

	$inkpro_options[] = array(
		'type' => 'open', 
		'label' =>esc_html__( 'Social Sharing', 'inkpro' )
	);

		$inkpro_options[] = array(
			'label' => esc_html__( 'Display', 'inkpro' ),
			'type' => 'section_open',
		);

		$inkpro_options[] = array(
			'label' => esc_html__( 'Share Links', 'inkpro' ),
			'desc' => esc_html__( 'Display "share" links below each single post ?', 'inkpro' ),
			'id' => 'post_share_buttons',
			'type' => 'checkbox',
		);

		$inkpro_options[] = array(
			'label' => esc_html__( 'Generate Facebook & Google plus Meta', 'inkpro' ),
			'desc' => wp_kses(
				sprintf( 
					__( 'Would you like to generate facebook, twitter and google plus metadata? Disable this function if you use a SEO plugin. In case <a href="%s" target="_blank">Yoast SEO</a> plugin is installed, it will be automatically disabled.', 'inkpro' ),
					'https://wordpress.org/plugins/wordpress-seo/'
				),
				array(
					'br' => array(),
					'a' => array(
						'href' => array(),
						'target' => array(),
					),
				)
			),
			'id' => 'social_meta',
			'type' => 'checkbox',
		);

		$inkpro_options[] = array(
			'label' => esc_html__( 'Default Share Image (used for facebook and google plus)', 'inkpro' ),
			'desc' => esc_html__( 'By default, the post featured image will be shown when you share a post/page on facebook. Here you can set the default image that will be displayed if no featured image is set', 'inkpro' ),
			'id' => 'share_img',
			'type' => 'image',
		);

		$inkpro_options[] = array(
			'label' => esc_html__( 'Share Text', 'inkpro' ),
			'id' => 'share_text',
			'type' => 'text',
		);

		$inkpro_options[] = array(
			'label' => 'facebook',
			'id' => 'share_facebook',
			'type' => 'checkbox',
		);

		$inkpro_options[] = array(
			'label' => 'twitter',
			'id' => 'share_twitter',
			'type' => 'checkbox',
		);

		$inkpro_options[] = array(
			'label' => 'pinterest',
			'id' => 'share_pinterest',
			'type' => 'checkbox',
		);

		$inkpro_options[] = array(
			'label' => 'google plus',
			'id' => 'share_google',
			'type' => 'checkbox',
		);

		$inkpro_options[] = array(
			'label' => 'tumblr',
			'id' => 'share_tumblr',
			'type' => 'checkbox',
		);

		$inkpro_options[] = array(
			'label' => 'stumbleupon',
			'id' => 'share_stumbleupon',
			'type' => 'checkbox',
		);

		$inkpro_options[] = array(
			'label' => 'linked in',
			'id' => 'share_linkedin',
			'type' => 'checkbox',
		);

		$inkpro_options[] = array(
			'label' => 'email',
			'id' => 'share_mail',
			'type' => 'checkbox',
		);

		$inkpro_options[] = array( 'type' => 'section_close' );


	$inkpro_options[] = array( 'type' => 'close' );

	return $inkpro_options;
}
add_filter( 'wolf_theme_options', 'inkpro_set_share_options' );