<?php
/**
 * WolfFramework admin scripts
 *
 * @package WordPress
 * @subpackage WolfFramework
 * @author WolfThemes
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Enqueue framework admin scripts (admin JS)
 */
function wolf_framework_enqueue_admin_scripts() {

	// Register option panel script
	wp_register_script( 'wolf-options-panel', WOLF_FRAMEWORK_URI . '/assets/js/min/options-panel.min.js', array( 'jquery' ), true, WOLF_FRAMEWORK_VERSION );

	// Enqueue script libraries
	wp_enqueue_script( 'chosen', WOLF_FRAMEWORK_URI . '/assets/chosen/chosen.jquery.min.js', array( 'jquery' ), true, '1.1.0' );
	wp_enqueue_script( 'fancybox', WOLF_FRAMEWORK_URI . '/assets/fancybox/jquery.fancybox.pack.js',  array( 'jquery' ), true, '2.1.4' );
	wp_enqueue_script( 'cookie', WOLF_FRAMEWORK_URI . '/assets/js/min/memo.min.js',  array( 'jquery' ), true, WOLF_FRAMEWORK_VERSION );
	wp_enqueue_script( 'tipsy', WOLF_FRAMEWORK_URI . '/assets/js/min/tipsy.min.js', array( 'jquery' ), true, WOLF_FRAMEWORK_VERSION );

	// empty file only used to set global variables
	wp_enqueue_script( 'wolf-admin', WOLF_FRAMEWORK_URI . '/assets/js/admin.js', array( 'jquery' ), true, WOLF_FRAMEWORK_VERSION );

	// Enqueue framework admin scrips
	wp_enqueue_script( 'wolf-admin-colorpicker', WOLF_FRAMEWORK_URI . '/assets/js/min/colorpicker.min.js', array( 'wp-color-picker' ), false, true );

	if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {

		wp_enqueue_script( 'wolf-admin-searchable', WOLF_FRAMEWORK_URI . '/assets/js/src/searchable.js', array( 'jquery' ), WOLF_FRAMEWORK_VERSION, true );
		wp_enqueue_script( 'wolf-admin-notice', WOLF_FRAMEWORK_URI . '/assets/js/src/notice.js', array( 'jquery' ), WOLF_FRAMEWORK_VERSION, true );
		wp_enqueue_script( 'wolf-admin-upload', WOLF_FRAMEWORK_URI . '/assets/js/src/upload.js', array( 'jquery' ), WOLF_FRAMEWORK_VERSION, true );
		wp_enqueue_script( 'wolf-admin-field-dependencies', WOLF_FRAMEWORK_URI . '/assets/js/src/field-dependencies.js', array( 'jquery' ), WOLF_FRAMEWORK_VERSION, true );
		wp_enqueue_script( 'wolf-admin-reset-customizer-button', WOLF_FRAMEWORK_URI . '/assets/js/src/reset-customizer-button.js', array( 'jquery' ), WOLF_FRAMEWORK_VERSION, true );
		wp_enqueue_script( 'wolf-admin-fancybox-help', WOLF_FRAMEWORK_URI . '/assets/js/src/fancybox.help.js', array( 'jquery' ), WOLF_FRAMEWORK_VERSION, true );

	} else {

		wp_enqueue_script( 'wolf-admin-app', WOLF_FRAMEWORK_URI . '/assets/js/app.js', array( 'jquery' ), WOLF_FRAMEWORK_VERSION, true );
	}

	wp_localize_script(
		'wolf-admin', 'WolfAdminParams', array(
			'chooseImage' => esc_html__( 'Choose an image', 'inkpro' ),
			'chooseFile' => esc_html__( 'Choose a file', 'inkpro' ),
			'noResult' => esc_html__( 'Oops, nothing found!', 'inkpro' ),
			'resetModsText'   => esc_html__( 'Reset', 'inkpro' ),
			'confirm' => esc_html__( 'Are you sure to want to reset all mods to default? There is no way back.', 'inkpro' ),
			'nonce' => array(
				'reset' => wp_create_nonce( 'wolf-customizer-reset' ),
			)
		)
	);

	if ( isset( $_GET['page'] ) && ( $_GET['page'] == 'wolf-theme-options' || $_GET['page'] == 'wolf-theme-about' ) ) {
		wp_enqueue_script( 'wolf-options-panel' );
	}

	if ( isset( $_GET['page'] ) && ( $_GET['page'] == 'wolf-theme-options' ) ) {
		wp_enqueue_script( 'ace', WOLF_FRAMEWORK_URI . '/assets/ace/ace.js', array(), WOLF_FRAMEWORK_VERSION, true );
	}
}
add_action( 'admin_enqueue_scripts', 'wolf_framework_enqueue_admin_scripts' );

/**
 * Enqueue framework admin styles (admin CSS)
 */
function wolf_framework_enqueue_admin_styles() {

	// Enqueue styles libraries
	wp_enqueue_style( 'chosen', WOLF_FRAMEWORK_URI . '/assets/chosen/chosen.min.css', false, '1.1.0', 'all' );
	wp_enqueue_style( 'fancybox', WOLF_FRAMEWORK_URI . '/assets/fancybox/fancybox.css', false, '2.1.4', 'all' );
	wp_enqueue_style( 'wolf-admin', WOLF_FRAMEWORK_URI . '/assets/css/admin.css', false, WOLF_FRAMEWORK_VERSION, 'all' );
	wp_enqueue_style( 'wp-color-picker' );
}
add_action( 'admin_enqueue_scripts', 'wolf_framework_enqueue_admin_styles' );

/**
 * Output CSS style conditionally
 */
function wolf_conditional_admin_inline_style() {

	$css = '';

	if ( isset( $_GET['page'] ) ) {
		$page = $_GET['page'];

		if ( 'wolf-theme-options' == $page ) {
			$css .= '
				.wolf-plugin-admin-notice,
				.woocommerce-message{
					display: none;
			}';

		}

		if ( 'wpcf7' == $page ) {
			$css .= '
			#welcome-panel{
				display: none;
			}';
		}
	}

	wp_add_inline_style( 'wolf-admin', wolf_compact_css( $css ) );
}
add_action( 'admin_enqueue_scripts', 'wolf_conditional_admin_inline_style' );

/**
 * Output ACE inline script for theme options CSS editor
 */
function wolf_ace_inline_script() {

	$script = "jQuery( function( $ ) {
		var editor = ace.edit( 'css-editor' ),
			textArea = $( '#css-textarea' );
		editor.setTheme( 'ace/theme/github' );
		editor.session.setMode( 'ace/mode/css' );

		$( '#css-editor' ).css( { 'font-size' : '14px' } );

		editor.getSession().on('change', function( e ) {
			textArea.html( editor.getValue() );
			// console.log( editor.getValue() );
		} );
	} );";

	wp_add_inline_script( 'ace', $script );
}
add_action( 'admin_enqueue_scripts', 'wolf_ace_inline_script' );
