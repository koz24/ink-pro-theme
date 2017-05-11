<?php
/**
 * InkPro loading
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_loading_mods( $inkpro_mods ) {

	$inkpro_mods['loading'] = array(

		'id' => 'loading',
		'title' => esc_html__( 'Loading', 'inkpro' ),
		'icon' => 'update',
		'options' => array(

			array(
				'label' => esc_html__( 'Loader', 'inkpro' ),
				'id' => 'loader_type',
				'help' => 'loaders.jpg',
				'type' => 'select',
				'choices' => array(
					'none'	 => esc_html__( 'None', 'inkpro' ),
		 			'loader1' => esc_html__( 'Rotating plane', 'inkpro' ),
					'loader2' => esc_html__( 'Double Pulse', 'inkpro' ),
					'loader3' => esc_html__( 'Wave', 'inkpro' ),
					'loader4' => esc_html__( 'Wandering cubes', 'inkpro' ),
					'loader5' => esc_html__( 'Pulse', 'inkpro' ),
					'loader6' => esc_html__( 'Chasing dots', 'inkpro' ),
					'loader7' => esc_html__( 'Three bounce', 'inkpro' ),
					'loader8' => esc_html__( 'Circle', 'inkpro' ),
					'loader9' => esc_html__( 'Cube grid', 'inkpro' ),
					'loader10' => esc_html__( 'Classic Loader', 'inkpro' ),
					'loader11' => esc_html__( 'Folding cube', 'inkpro' ),
					'loader12' => esc_html__( 'Ball Pulse', 'inkpro' ),
					'loader13' => esc_html__( 'Ball Grid Pulse', 'inkpro' ),
					//'loader14' => esc_html__( 'Ball Clip Rotate', 'inkpro' ),
					'loader15' => esc_html__( 'Ball Clip Rotate Pulse', 'inkpro' ),
					'loader16' => esc_html__( 'Ball Clip Rotate Pulse Multiple', 'inkpro' ),
					'loader17' => esc_html__( 'Ball Pulse Rise', 'inkpro' ),
					//'loader18' => esc_html__( 'Ball Rotate', 'inkpro' ),
					'loader19' => esc_html__( 'Ball Zigzag', 'inkpro' ),
					'loader20' => esc_html__( 'Ball Zigzag Deflect', 'inkpro' ),
					'loader21' => esc_html__( 'Ball Triangle Path', 'inkpro' ),
					'loader22' => esc_html__( 'Ball Scale', 'inkpro' ),
					'loader23' => esc_html__( 'Ball Line Scale', 'inkpro' ),
					'loader24' => esc_html__( 'Ball Line Scale Party', 'inkpro' ),
					'loader25' => esc_html__( 'Ball Scale Multiple', 'inkpro' ),
					'loader26' => esc_html__( 'Ball Pulse Sync', 'inkpro' ),
					'loader27' => esc_html__( 'Ball Beat', 'inkpro' ),
					'loader28' => esc_html__( 'Ball Scale Ripple Multiple', 'inkpro' ),
					'loader29' => esc_html__( 'Ball Spin Fade Loader', 'inkpro' ),
					'loader30' => esc_html__( 'Line Spin Fade Loader', 'inkpro' ),
					'loader31' => esc_html__( 'Pacman', 'inkpro' ),
					'loader32' => esc_html__( 'Ball Grid Beat ', 'inkpro' ),
					//'loader33' => esc_html__( 'Semi Cirlce Spin ', 'inkpro' ),
					//'loader34' => esc_html__( 'Ball ', 'inkpro' ),
					//'loader35' => esc_html__( 'Ball ', 'inkpro' ),
					//'loader36' => esc_html__( 'Ball ', 'inkpro' ),
				),
			),

			'loading_logo' => array(
				'id' => 'loading_logo',
				'label' => esc_html__( 'Optional Loading Logo', 'inkpro' ),
				'type' => 'image',
			),

			array(
				'label' => esc_html__( 'Loading Logo Animation', 'inkpro' ),
				'id' => 'loading_logo_animation',
				'description' => esc_html__( 'It is recommended to disabled the loader icon if you set a logo animation', 'inkpro' ),
				'help' => 'loaders.jpg',
				'type' => 'select',
				'choices' => array(
					'none'	 => esc_html__( 'None', 'inkpro' ),
		 			'pulse' => esc_html__( 'Pulse', 'inkpro' ),
					
				),
			),

			array(
				'label' => esc_html__( 'No Loading Overlay', 'inkpro' ),
				'id' => 'no_loading_overlay',
				'type' => 'checkbox',
			),

			array(
				'label' => esc_html__( 'No Transition Animation', 'inkpro' ),
				'id' => 'no_transition_overlay',
				'type' => 'checkbox',
			),

			array(
				'label' => esc_html__( 'No AJAX Progress Bar', 'inkpro' ),
				'description' => esc_html__( 'If AJAX navigation is set.', 'inkpro' ),
				'id' => 'no_ajax_progress_bar',
				'type' => 'checkbox',
			),
		),
	);
	return $inkpro_mods;
}
add_filter( 'inkpro_customizer_options', 'inkpro_set_loading_mods' );