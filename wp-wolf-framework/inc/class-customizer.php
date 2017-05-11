<?php
/**
 * WolfFramework customizer class
 *
 * Create customizer inputs from array
 *
 * @package WordPress
 * @subpackage WolfFramework
 * @author WolfThemes
 */
class Wolf_Theme_Customizer {

	var $sections = array();

	public function __construct( $sections = array() ) {
		$this->sections = $sections + $this->sections;
		add_action( 'customize_register', array( $this, 'register_sections' ) );
	}

	/**
	 *  Set priority depending on array order
	 */
	public function set_priority() {

		$priority = 34;
		
		foreach ( $this->sections as $key => $value ) {

			$priority++;

			$this->sections[ $key ]['priority'] = $priority;

			if ( isset( $value['options'] ) ) {

				$options_priority = 0;

				foreach ( $value['options'] as $k => $v ) {

					$options_priority++;

					if ( 'background' == $this->sections[ $key ]['options'][ $k ]['type'] )
						$options_priority = $options_priority + 9;

						if ( ! isset( $this->sections[ $key ]['options'][ $k ]['priority'] ) )
							$this->sections[ $key ]['options'][ $k ]['priority'] = $options_priority;
				}
			}
		}
	}

	/**
	 * Register sections
	 *
	 * @param object $wp_customize
	 */
	public function register_sections( $wp_customize ) {

		$default_priority = 35;

		foreach ( $this->sections as $section ) {
			$default_priority++;
			$section_id = $section['id'];
			$title = isset( $section['title'] ) ? $section['title'] : esc_html__( 'Section Title', 'inkpro' );
			$description = isset( $section['description'] ) ? $section['description'] : '';
			$priority = isset( $section['priority'] ) ? $section['priority'] : $default_priority;
			$is_background = isset( $section['background'] ) ? $section['background'] : false;
			$font_color  = $is_background && isset( $section['font_color'] ) ? $section['font_color'] : true;
			$parallax = $is_background && isset( $section['parallax'] ) ? $section['parallax'] : false;
			$is_bg_img = $is_background && isset( $section['img'] ) ? $section['img'] : true;
			$is_no_bg = $is_background && isset( $section['no_bg'] ) ? $section['no_bg'] : true;
			$opacity = $is_background && isset( $section['opacity'] ) ? $section['opacity'] : true;
			$transport = isset( $section['transport'] ) ?  $section['transport'] : 'postMessage';

			// debug( $priority );

			if ( $is_background ) {
				// Background Section
				$this->background_setting( $section, $section_id, $wp_customize, true, $priority );

			} else {

				$wp_customize->add_section(
					$section_id,
					array(
						'title' => $title,
						'description' => $description,
						'priority' => $priority,
					)
				);

				$options = $section['options'];

				foreach ( $options as $option ) {

					$label     = $option['label'];
					$option_id = $option['id'];
					$type = isset( $option['type'] ) ? $option['type'] : 'text';
					$default   = isset( $option['default'] ) ? $option['default'] : '';
					$priority  = isset( $option['priority'] ) ? $option['priority'] : 1;
					$transport = isset( $option['transport'] ) ?  $option['transport'] : 'refresh';
					$description = isset( $option['description'] ) ?  $option['description'] : '';

					/* Text
					---------------*/
					if ( 'text' == $type ) {
						$wp_customize->add_setting(
							$option_id,
							array(
								'default' => $default,
								'transport' => $transport,
								'sanitize_callback' => array( $this, 'sanitize_text' ),
							)
						);

						$wp_customize->add_control(
							$option_id,
							array(
								'label' => $label,
								'section' => $section_id,
								'type' => 'text',
								'description' => $description,
							)
						);

						/* Integer
						---------------*/
					} elseif ( 'int' == $type ) {

						$wp_customize->add_setting(
							$option_id,
							array(
								'default' => $default,
								'sanitize_callback' => array( $this, 'sanitize_int' ),
								'transport' => $transport,
							)
						);

						$wp_customize->add_control(
							$option_id,
							array(
								'label' => $label,
								'section' => $section_id,
								'type' => 'text',
							)
						);

						/* Color
						---------------*/
					} elseif ( 'color' == $type ) {
						

						$wp_customize->add_setting(
							$option_id,
							 array(
								'default' => $default,
								'sanitize_callback' => 'sanitize_hex_color',
								'transport' => $transport,
							)
						);

						$wp_customize->add_control(
						$wolf_wp_customize_color_control = new WP_Customize_Color_Control(
							$wp_customize,
							$option_id,
								array(
									'label' => $label,
									'section' => $section_id,
									'settings' => $option_id,
									'description' => $description,
								)
							)
						);

						/* Image
						---------------*/
					} elseif ( 'image' == $type ) {

						$wp_customize->add_setting( $option_id,
							array(
								'sanitize_callback' => array( $this, 'sanitize_url' ),
							)
						);

						$wp_customize->add_control(
						$wolf_wp_customize_image_control = new WP_Customize_Image_Control(
							$wp_customize,
							$option_id,
								array(
									'label' => $label,
									'section' => $section_id,
									'settings' => $option_id,
									'description' => $description,
								)
							)
						);

						/* Select
						---------------*/
					} elseif ( 'select' == $type ) {

						$wp_customize->add_setting(
							$option_id,
							array(
								'default' => $default,
								'transport' => $transport,
								'sanitize_callback' => array( $this, 'sanitize_text' ),
							)
						);

						$wp_customize->add_control(
							$option_id,
							array(
								'type' => 'select',
								'label' => $label,
								'section' => $section_id,
								'choices' => $option['choices'],
								'description' => $description,
							)
						);

						/* Select
						---------------*/
					} elseif ( 'radio' == $type ) {

						$wp_customize->add_setting(
							$option_id,
							array(
								'default' => $default,
								'transport' => $transport,
								'sanitize_callback' => array( $this, 'sanitize_text' ),
							)
						);

						$wp_customize->add_control(
							$option_id,
							array(
								'type' => 'radio',
								'label' => $label,
								'section' => $section_id,
								'choices' => $option['choices'],
							)
						);


						/* Checkbox
						--------------------*/
					} elseif ( 'checkbox' == $type ) {

						$wp_customize->add_setting(
							$option_id,
							array(
								'default' => $default,
								'transport' => $transport,
								'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
							)
						);

						$wp_customize->add_control(
							$option_id,
							array(
								'type' => 'checkbox',
								'label' => $label,
								'section' => $section_id,
							)
						);


						/* Textarea
						--------------------*/
					} elseif ( 'textarea' == $type ) {

						$wp_customize->add_setting( $option_id,
							array(
								'sanitize_callback' => array( $this, 'sanitize_text' ),
							)
						);

						$wp_customize->add_control(
						$wolf_customize_textarea_control = new Wolf_Customize_Textarea_Control(
							$wp_customize,
							$option_id,
								array(
									'label' => $label,
									'section' => $section_id,
									'settings' => $option_id,
								)
							)
						);
					}

					/*----------------------------- Background option --------------------------------*/

					elseif ( 'background' == $type ) {

						$this->background_setting( $option, $section_id, $wp_customize, false  );
					}
				} // end foreach options
			} // end not background
		}
	}

	/**
	 *  Register a background section
	 */
	public function background_setting( $option, $section_id, $wp_customize, $section = true, $priority = 35 ) {

		//var_dump( $priority );

		$label = isset( $option['label'] ) ? $option['label'] : '';
		$background_id = true == $section ? $section_id :  $option['id'];
		$bg_attachment = isset( $option['bg_attachment'] ) ? $option['bg_attachment'] : false;
		$font_color = isset( $option['font_color'] ) ? $option['font_color'] : false;
		$default_font_color = isset( $option['default_font_color'] ) ? $option['default_font_color'] : 'dark';
		$parallax = isset( $option['parallax'] ) ? $option['parallax'] : false;
		$is_bg_img = isset( $option['img'] ) ? $option['img'] : true;
		$is_no_bg = isset( $option['no_bg'] ) ? $option['no_bg'] : false;
		$opacity = isset( $option['opacity'] ) ? $option['opacity'] : false;
		$transport = isset( $option['transport'] ) ?  $option['transport'] : 'postMessage';

		if ( $section ) {

			$desc = isset( $option['desc'] ) ? $option['desc'] : '';
			//$priority = isset( $option['priority'] ) ? $option['priority'] : 35;

			$wp_customize->add_section(
				$section_id,
				array(
					'title' => $label,
					'description' => $desc,
					'priority' => $priority,
				)
			);
		}

		if ( $font_color ) {

			/* Font Color
			--------------------*/
			$wp_customize->add_setting(
				$background_id . '_font_color',
				array(
					'default' => '',
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);

			$wp_customize->add_control(
			$wolf_wp_customize_color_control = new WP_Customize_Color_Control(
				$wp_customize,
				$background_id . '_font_color',
					array(
						'label' => esc_html__( 'Font Color', 'inkpro' ),
						'section' => $section_id,
						'settings' => $background_id . '_font_color',
						//'priority' => 2,
					)
				)
			);
		} // endif font color option

		if ( $is_no_bg ) {

			/* None
			--------------------*/
			$wp_customize->add_setting(
				$background_id . '_none',
				array(
					'transport' => 'refresh',
					'sanitize_callback' => array( $this, 'sanitize_text' ),
				)
			);

			$wp_customize->add_control(
				$background_id . '_none',
				array(
					'type' => 'checkbox',
					'label' => esc_html__( 'No Background', 'inkpro' ),
					'section' => $section_id,
					'priority' => 1,
				)
			);

		} // endif no bg option

		/* Color
		---------------*/
		$wp_customize->add_setting(
			$background_id . '_color',
			array(
				'default' => '',
				'sanitize_callback' => 'sanitize_hex_color',
			)
		);

		$wp_customize->add_control(
		$wolf_wp_customize_color_control = new WP_Customize_Color_Control(
			$wp_customize,
			$background_id . '_color',
				array(
					'label' => esc_html__( 'Background Color', 'inkpro' ),
					'section' => $section_id,
					'settings' => $background_id . '_color',
					'priority' => 2,
				)
			)
		);

		if ( $opacity ) :

			/* Opacity
			---------------*/
			$wp_customize->add_setting(
				$background_id . '_opacity',
				array(
					'default' => 100,
					'sanitize_callback' => array( $this, 'sanitize_text' ),
				)
			);

			$wp_customize->add_control(
				$background_id . '_opacity',
				array(
					'label' => esc_html__( 'Background Color Opacity (in percent)', 'inkpro' ),
					'section' => $section_id,
					'type' => 'text',
					'priority' => 3,
				)
			);
		endif;

		if ( $is_bg_img ) :

			/* Image
			---------------*/
			$wp_customize->add_setting( $background_id . '_img',
				array(
					'sanitize_callback' => array( $this, 'sanitize_url' ),
				)
			);

			$wp_customize->add_control(
			$wolf_wp_customize_image_control = new WP_Customize_Image_Control(
				$wp_customize,
				$background_id . '_img',
					array(
						'label' => esc_html__( 'Background Image', 'inkpro' ),
						'section' => $section_id,
						'settings' => $background_id . '_img',
						'priority' => 4,
						'sanitize_callback' => array( $this, 'sanitize_image' ),
					)
				)
			);

			/* Repeat
			---------------*/
			$wp_customize->add_setting(
				$background_id . '_repeat',
				array(
					'default' => 'repeat',
					'transport' => $transport,
					'sanitize_callback' => array( $this, 'sanitize_text' ),
				)
			);

			$wp_customize->add_control(
				$background_id . '_repeat',
				array(
					'type' => 'select',
					'label' => esc_html__( 'Background Repeat', 'inkpro' ),
					'section' => $section_id,
					'choices' => array(
						'no-repeat' => 'no-repeat',
						'repeat' => 'repeat',
						'repeat-x' => 'repeat-x',
						'repeat-y' => 'repeat-y',
					),
					'priority' => 5,
				)
			);

			/* Position
			---------------*/
			$wp_customize->add_setting(
				$background_id . '_position',
				array(
					'default' => 'center top',
					'transport' => $transport,
					'sanitize_callback' => array( $this, 'sanitize_text' ),
				)
			);

			$wp_customize->add_control(
				$background_id . '_position',
				array(
					'type' => 'select',
					'label' => esc_html__( 'Background Position', 'inkpro' ),
					'section' => $section_id,
					'choices' => array(
						'center center' => 'center center',
						'center top' => 'center top',
						'left top' => 'left top',
						'right top' => 'right top',
						'center bottom' => 'center bottom',
						'left bottom' => 'left bottom',
						'right bottom' => 'right bottom',
						'left center' => 'left center',
						'right center' => 'right center',
					),
					'priority' => 6,
				)
			);

			if ( $bg_attachment ) {
				/* Attachment
				----------------------*/
				$wp_customize->add_setting(
					$background_id . '_attachment',
					array(
						'default' => 'scroll',
						'transport' => $transport,
						'sanitize_callback' => array( $this, 'sanitize_text' ),
					)
				);
			}

			$wp_customize->add_control(
				$background_id . '_attachment',
				array(
					'type' => 'select',
					'label' => esc_html__( 'Background Attachment', 'inkpro' ),
					'section' => $section_id,
					'choices' => array(
						'scroll' => 'scroll',
						'fixed' => 'fixed',
					),
					'priority' => 7,
				)
			);

			/* Size
			---------------*/
			$wp_customize->add_setting(
				$background_id . '_size',
				array(
					'default' => 'cover',
					'transport' => $transport,
					'sanitize_callback' => array( $this, 'sanitize_text' ),
				)
			);

			$wp_customize->add_control(
				$background_id . '_size',
				array(
					'type' => 'select',
					'label' => esc_html__( 'Background Size', 'inkpro' ),
					'section' => $section_id,
					'choices' => array(
						'cover' => esc_html__( 'Cover', 'inkpro' ),
						'contain' => esc_html__( 'Contain', 'inkpro' ),
						'100% auto' => esc_html__( '100% width', 'inkpro' ),
						'auto 100%' => esc_html__( '100% height', 'inkpro' ),
						'inherit' => esc_html__( 'Inherit', 'inkpro' ),
					),
					'priority' => 8,
				)
			);


			if ( $parallax ) {

				/* Parallax
				--------------------*/
				$wp_customize->add_setting(
					$background_id . '_parallax',
					array(
						'sanitize_callback' => array( $this, 'sanitize_text' ),
					)
				);

				$wp_customize->add_control(
					$background_id . '_parallax',
					array(
						'type' => 'checkbox',
						'label' => esc_html__( 'Parallax', 'inkpro' ),
						'section' => $section_id,
						'priority' => 9,
					)
				);

			}

		endif; // end if bg image

	}

	/**
	 *  Sanitize integer
	 *
	 * @param string $input
	 * @return int
	 */
	public function sanitize_int( $input ) {

		return intval( $input );
	}

	/**
	 *  Sanitize checkbox
	 *
	 * @param string $input
	 * @return int
	 */
	public function sanitize_checkbox( $input ) {

		return esc_attr( $input );
	}

	/**
	 *  Sanitize text
	 *
	 * @param string $input
	 * @return int
	 */
	public function sanitize_text( $input ) {

		return sanitize_text_field( $input );
	}

	/**
	 *  Sanitize image
	 *
	 * @param string $input
	 * @return int
	 */
	public function sanitize_url( $input ) {

		return esc_url( $input );
	}
} // end class