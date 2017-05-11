<?php
/**
 * InkPro customizer options
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Initialize customizer mods
 */
function inkpro_customizer_get_mods() {
	
	return apply_filters( 'inkpro_customizer_options', array() );
}

/**
 * Initialize customizer mods
 */
function inkpro_customizer_set_mods() {

	// include all mods condtionally using wolf_include function
	wolf_include( 'inc/customizer/mods/colors.php' );
	wolf_include( 'inc/customizer/mods/loading.php' );
	wolf_include( 'inc/customizer/mods/logo.php' );
	wolf_include( 'inc/customizer/mods/layout.php' );
	wolf_include( 'inc/customizer/mods/navigation.php' );
	wolf_include( 'inc/customizer/mods/header-image.php' );
	wolf_include( 'inc/customizer/mods/header-settings.php' );
	wolf_include( 'inc/customizer/mods/fonts.php' );
	wolf_include( 'inc/customizer/mods/blog.php' );
	wolf_include( 'inc/customizer/mods/portfolio.php' );
	wolf_include( 'inc/customizer/mods/discography.php' );
	wolf_include( 'inc/customizer/mods/events.php' );
	wolf_include( 'inc/customizer/mods/albums.php' );
	wolf_include( 'inc/customizer/mods/videos.php' );
	wolf_include( 'inc/customizer/mods/shop.php' );
	wolf_include( 'inc/customizer/mods/footer.php' );
	wolf_include( 'inc/customizer/mods/footer-bg.php' );
	wolf_include( 'inc/customizer/mods/bottom-bar-bg.php' );
	wolf_include( 'inc/customizer/mods/wpb.php' );
	
	if ( class_exists( 'Wolf_Theme_Customizer' ) && is_user_logged_in() ) {
		new Wolf_Theme_Customizer( inkpro_customizer_get_mods() );
	}
}
//add_action( 'after_setup_theme', 'inkpro_customizer_set_mods', 1 );
inkpro_customizer_set_mods();

/**
 * Set customizer tab icons
 */
function inkpro_set_customizer_tabs_icons() {
	$mods = inkpro_customizer_get_mods();

	$css = '';

	foreach ( $mods as $key => $value) {
		
		if ( isset( $value['icon'] ) && isset( $value['id'] ) ) {

			$section_id = $value['id'];
			$icon_slug = $value['icon'];

			$css .= '
				#accordion-section-' . $section_id . ' .accordion-section-title:before{
					position:relative;
					font-family:Dashicons;
					content : "' . inkpro_get_dashicon_css_unicode( $icon_slug ) . '";
					position: relative;
					top: 2px;
					margin-left: 5px;
					left: -6px;
					line-height: inherit;
					font-weight: normal;
				}
			';
		}
	}

	if ( ! SCRIPT_DEBUG ) {
		$css = wolf_compact_css( $css );
	}

	wp_add_inline_style( 'inkpro-customizer-style', $css );
}
add_action( 'customize_controls_enqueue_scripts', 'inkpro_set_customizer_tabs_icons' );

/**
 * Get dashicon CSS unicod from slug
 */
function inkpro_get_dashicon_css_unicode( $icon_slug ) {

	$dashicons_array = array(
		'admin-customizer' => '\f540',
		'welcome-write-blog' => '\f119',
		'welcome-view-site' => '\f115',
		'menu' => '\f333',
		'layout' => '\f538',
		'editor-video' => '\f219',
		'update' => '\f463',
		'portfolio' => '\f322',
		'images-alt' => '\f232',
		'images-alt2' => '\f233',
		'cart' => '\f174',
		'calendar' => '\f145',
		'calendar-alt' => '\f508',
		'editor-textcolor' => '\f215',
		'arrow-down-alt' => '\f346',
		'format-image' => '\f128',
		'camera' => '\f306',
		'media-spreadsheet' => '\f495',
		'format-audio' => '\f127',
		'album' => '\f514',
		'minus' => '\f460',
		'editor-table' => '\f535',
		'visibility' => '\f177',
	);

	if ( isset( $dashicons_array[ $icon_slug ] ) ) {
		return $dashicons_array[ $icon_slug ];
	}
}

/**
 * Add selective refresh functionality to certain settings
 */
function inkpro_register_settings_partials( $wp_customize ) {
	// Abort if selective refresh is not available.
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->get_setting( 'logo_dark' )->transport = 'postMessage';
	$wp_customize->get_setting( 'logo_light' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_image' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'logo_dark', array(
		'selector' => '.logo-img-inner',
		'settings' => array( 'logo_dark', 'logo_light' ),
		'render_callback' => 'inkpro_logo',
	) );

	$wp_customize->selective_refresh->add_partial( 'header_image', array(
		'selector' => '.post-header-container',
		'settings' => array( 'header_image' ),
		'render_callback' => 'inkpro_output_page_header',
	) );
}
add_action( 'customize_register', 'inkpro_register_settings_partials' );