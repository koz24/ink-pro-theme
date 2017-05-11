<?php
/**
 * WolfFramework theme options class
 *
 * @package WordPress
 * @subpackage WolfFramework
 * @author WolfThemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Wolf_Theme_Admin_Options' ) ) {
	/**
	 * Theme options class
	 *
	 * Create theme options easily from an array (includes/options.php)
	 *
	 * @since 1.4.2
	 * @package WolfFramework
	 * @author WolfThemes
	 */
	class Wolf_Theme_Admin_Options {

		/**
		 * @var array
		 */
		public $options = array();

		/**
		 * Wolf_Theme_Admin_Options Constructor
		 *
		 * @todo set a main key option
		 */
		public function __construct( $options = array() ) {
			$this->options = $options + $this->options;
			$this->save();
			$this->render();
		}

		/**
		 * Get theme option from "wolf_theme_options_template" array
		 *
		 * @param string $o
		 * @param string $default
		 * @return string
		 */
		public function get_option( $o, $default = null ) {

			global $options;

			$wolf_framework_options = get_option( 'wolf_theme_options_' . wolf_get_theme_slug() );

			if ( isset( $wolf_framework_options[ $o ] ) ) {

				$option = $wolf_framework_options[ $o ];

				/* WPML */
				if ( function_exists( 'icl_t' ) ) {

					$option = icl_t( wolf_get_theme_slug(), $o, $option ); // WPML
				}

				return $option;

			} elseif ( $default ) {

				return $default;
			}
		}

		/**
		 * Save the theme options in array
		 */
		public function save() {

			global $options;

			/**
			 * Back from Wolf_Framework_Admin construct function redirection
			 */
			// if ( isset( $_GET['message'] ) && 'save' == $_GET['message'] && isset( $_GET['page'] ) && $_GET['page'] == 'wolf-theme-options' ) {
			// 	wolf_admin_notice( esc_html__( 'Your options have been saved.', 'inkpro' ), 'success' );
			// }

			// if ( isset( $_GET['message'] ) && 'export' == $_GET['message'] && isset( $_GET['page'] ) && $_GET['page'] == 'wolf-theme-options' ) {
			// 	wolf_admin_notice( esc_html__( 'Your download should start in a few seconds.', 'inkpro' ), 'success' );
			// }

			if ( isset( $_GET['page'] ) && $_GET['page'] == 'wolf-theme-options' ) {

				$errors = array();

				if ( isset( $_POST['action'] ) && $_POST['action'] == 'save'
				        && ( ! isset( $_FILES['wolf-options-import-file']['name'] ) || '' == $_FILES['wolf-options-import-file']['name'] )
					&& wp_verify_nonce( $_POST['wolf_save_theme_options_nonce'],'wolf_save_theme_options' ) ) {

					// 5 minutes time out
					set_time_limit( 900 );

					$new_options = array();
					$data = $_POST['wolf_theme_options'];

					foreach ( $this->options as $value ) {

						$type = isset( $value['type'] ) ? $value['type'] : null;
						$value_key = isset( $value['id'] ) ? $value['id'] : null;

						if ( 'int' == $type ) {

							$new_options[ $value_key ] = intval( $data[ $value_key ] );
						}

						elseif ( 'image' == $type ) {

							if ( is_numeric( $data[ $value_key ] ) ) {

								$new_options[ $value_key ] = absint( $data[ $value_key ] );
							} else {

								$new_options[ $value_key ] = esc_url( $data[ $value_key ] );
							}
						}

						elseif ( 'url' == $type || 'file' == $type ) {

							if ( ! empty( $data[ $value_key ] ) )
								$new_options[ $value_key ] = esc_url( $data[ $value_key ] );
						}

						elseif ( 'email' == $type ) {

							if ( ! empty( $data[ $value_key ] ) && ! is_email( $data[ $value_key ] ) ) {

								$errors[] = '<strong>' . $data[ $value_key ] . '</strong> '.esc_html__( 'is not a valid email', 'inkpro' ).'.';

							} elseif ( ! empty( $data[ $value_key ] ) ) {

								$new_options[ $value_key ] = sanitize_email( $data[ $value_key ] );
							}
						}

						elseif ( 'editor' == $type ) {

							if ( ! empty( $_POST[ 'wolf_theme_options_editor_' . $value['id'] ] ) ) {

								$new_options[ $value_key ] = $_POST[ 'wolf_theme_options_editor_' . $value_key ];

								if ( function_exists( 'icl_register_string' ) ) {
									icl_register_string( wolf_get_theme_slug(), $value_key, $new_options[ $value_key ] );
								}
							}
						}

						elseif ( 'text' == $type || 'textarea' == $type ) {

							if ( ! empty( $data[ $value_key ] ) ) {

								$new_options[ $value_key ] = sanitize_text_field( $data[ $value_key ] );

								if ( 'text' == $type || 'textarea' == $type ) {
									if ( function_exists( 'icl_register_string' ) ) {
										icl_register_string( wolf_get_theme_slug(), $value_key, $new_options[ $value_key ] );
									}
								}
							}
						}

						elseif ( 'textarea_html' == $type ) {

							if ( ! empty( $data[ $value_key ] ) ) {

								$new_options[ $value_key ] = $data[ $value_key ];

								if ( 'text' == $type || 'textarea' == $type ) {
									if ( function_exists( 'icl_register_string' ) ) {
										icl_register_string( wolf_get_theme_slug(), $value_key, $new_options[ $value_key ] );
									}
								}
							}
						}

						elseif ( 'background' == $type ) {

							$bg_options = array( 'color', 'img', 'position', 'repeat', 'attachment', 'size', 'parallax', 'font_color' );

							foreach ( $bg_options as $s ) {

								$o = $value_key . '_' . $s;

								if ( isset( $o ) && ! empty( $data[ $o ] ) ) {

									$setting = $data[ $o ];

									if ( 'img' == $s ) {
										if ( is_numeric( $setting ) ) {
											$new_options[ $o ] = absint( $setting );
										} else {
											$new_options[ $o ] = esc_url( $setting );
										}
									} else {
										$new_options[ $o ] = sanitize_text_field( $setting );
										// $new_options[ $o ] = $setting;
									}
								}
							}

						} // end background

						elseif ( 'font' == $type ) {

							$font_options = array( 'font_color', 'font_name', 'font_weight', 'font_transform', 'font_style', 'font_letter_spacing' );

							foreach ( $font_options as $s ) {

								$o = $value_key . '_' . $s;

								if ( isset( $o ) && ! empty( $data[ $o ] ) ) {

									$new_options[ $o ] = sanitize_text_field( $data[ $o ] );
								}
							}
						} // end font

						elseif ( 'video' == $type ) {

							$video_options = array( 'mp4', 'webm', 'ogv', 'opacity', 'img', 'type', 'youtube_url' );

							foreach ( $video_options as $s ) {

								$o = $value_key . '_' . $s;

								if ( isset( $o ) && ! empty( $data[ $o ] ) ) {

									$new_options[ $o ] = sanitize_text_field( $data[ $o ] );
								}
							}

						} // end video

						elseif ( 'css' == $type ) {
							
							if ( isset( $value_key ) && ! empty( $data[ $value_key ] ) ) {
								$new_options[ $value_key ] = $data[ $value_key ];
							}

						} else {
							if ( isset( $value_key ) && ! empty( $data[ $value_key ] ) ) {
								$new_options[ $value_key ] = sanitize_text_field( strip_tags( $data[ $value_key ] ) ) ;
							}
						}
					}

					update_option( 'wolf_theme_options_' . wolf_get_theme_slug(), $new_options );

					do_action( 'wolf_after_options_save', $new_options );

					//wp_redirect( admin_url( 'admin.php?page=wolf-theme-options' ) );

				} else if ( ( isset( $_POST['action'] ) ) && ( $_POST['action'] == 'wolf-reset-all-options' ) ) {

					$old_options = get_option( 'wolf_theme_options' );

					delete_option( 'wolf_theme_options_' . wolf_get_theme_slug() );

					/**
					 * wolf_theme_default_options_init hook
					 */
					do_action( 'wolf_theme_default_options_init' );
				}

				if ( isset( $_POST['action'] ) && 'save' == $_POST['action'] ) {
					wolf_admin_notice( esc_html__( 'Your options have been saved.', 'inkpro' ), 'success' );
				}

				if ( ( isset( $_POST['action'] ) ) && 'wolf-reset-all-options' == $_POST['action'] ) {
					wolf_admin_notice( esc_html__( 'Your options have been reset.', 'inkpro' ), 'success' );
				}

				/* Display raw error message */
				if ( $errors != array() ) {
					$error_message = '<br><div class="error">';
					foreach ( $errors as $error) {
						$error_message .= '<p>'.$error.'</p>';
					}
					$error_message .= '</div>';
					echo wp_kses( $error_message, array(
						'p' => array(),
						'br' => array(),
						'strong' => array(),
						'div' => array(
							'class' => array(),
						),
					) );
				}
			}

		} // end save function

		/**
		 * Render Theme options inputs
		 */
		public function render() {

			$theme_version = 'v.' . WOLF_THEME_VERSION;

			/* If a child theme is used and update notces are enabled, we show the parent theme version */
			if ( is_child_theme() && WOLF_UPDATE_NOTICE )
				$theme_version = sprintf( esc_html__( 'v.%1$s (Parent Theme v.%2$s)', 'inkpro' ), wp_get_theme()->Version, WOLF_THEME_VERSION ) ;

		?>
		<div id="wolf-framework-messages">
			<?php
				// Check for theme update and set an admin notification if needed
				wolf_theme_update_notification_message();
			?>
		</div>

	<div class="wrap">
		<form id="wolf-theme-options-form" method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=wolf-theme-options' ) ); ?>" enctype="multipart/form-data">
		<?php wp_nonce_field( 'wolf_save_theme_options', 'wolf_save_theme_options_nonce' ); ?>

			<h2 class="nav-tab-wrapper">

				<div class="tabs" id="tabs1">
					<?php foreach ( $this->options as $value ) : ?>
						<?php if ( 'open' == $value['type'] ) : ?>
							<a href="#<?php echo sanitize_title( $value['label'] ); ?>" class="nav-tab"><?php echo sanitize_text_field( $value['label'] ); ?></a>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</h2>

		<div class="content">
	<?php foreach ( $this->options as $value ) {

		$def = ( isset( $value['def'] ) ) ? $value['def'] : '';
		$desc = ( isset( $value['desc'] ) ) ? $value['desc'] : '';
		$type = ( isset( $value['type'] ) ) ? $value['type'] : 'text';
		$label = ( isset( $value['label'] ) ) ? $value['label'] : '';
		$section_id = isset( $value['id'] ) ? $value['id'] : 'section';
		$class 	= "option-section-$section_id";

		if ( 'open' == $type ) {
		?>
		<div id="<?php echo sanitize_title( $label ); ?>" class="wolf-options-panel">

			<?php if ( $desc ) : ?>
				<p><?php echo sanitize_text_field( $desc ); ?></p>
			<?php endif; ?>

		<?php
		} elseif ( 'close' == $type ) {
			// vertical-align:middle; margin-left:10px; display:none;
		?>
			<div class="wolf-options-actions">
				<span class="submit">
					<input name="wolf-theme-options-save" type="submit" class="wolf-theme-options-save button-primary menu-save" value="<?php esc_html_e( 'Save changes', 'inkpro' ); ?>">
					<img class="options-loader" style="vertical-align:middle; margin-left:10px; display:none;" src="<?php echo esc_url( admin_url( 'images/loading.gif' ) ); ?>" alt="loader">
					<div style="float:none; clear:both"></div>
				</span>
				<div class="clear"></div>
			</div>

		</div><!-- panel -->

		<?php

		} elseif ( 'subtitle' == $type ) {
		?>

			<div class="wolf_title wolf_subtitle">
				<h3>
				<?php echo sanitize_text_field( $label ); ?>
				<br><small><?php echo sanitize_text_field( $desc ); ?></small>
				</h3>
				<div class="clear"></div>
			</div>

		<?php

		} elseif ( 'section_open' == $type ) {
		?>
		<div class="<?php echo esc_attr( $class ); ?>">
			<div class="section-title">
				<?php if ( $label ) : ?>
					<h3><?php echo sanitize_text_field( $label ); ?></h3>
				<?php endif ?>

				<p class="description">
					<?php echo wp_kses( $desc,
						array(
							'a' => array(
								'href' => array(),
							),
						)
					); ?>
				</p>
			</div>

			<table class="form-table">
				<tbody>
		<?php

		} elseif ( 'section_close' == $type ) {
		?>
				</tbody>
			</table>
		</div>
		<?php
		} else {

			$this->do_input( $value);

		}
	} // end foreach
	?>
		<input type="hidden" name="action" value="save">
		</form>

		</div> <!-- .content -->

		<?php
		$reset_options_confirm = esc_html__( 'Are you sure to want to reset all options ?', 'inkpro' );
		?>
		<div id="wolf-options-footer">
			<form method="post" action="<?php echo esc_url( admin_url( 'admin.php?page=wolf-theme-options' ) ); ?>">
				<p id="reset">
					<input name="wolf-reset-all-options" type="submit" value="<?php esc_html_e( 'Reset all options', 'inkpro' ); ?>" onclick="if (window.confirm( '<?php echo esc_js( $reset_options_confirm ); ?>' ) )
					{location.href='default.htm';return true;} else {return false;}">
					<input type="hidden" name="action" value="wolf-reset-all-options">
				</p>
			</form>

			<p id="theme-version"><?php echo sanitize_text_field( wp_get_theme()->Name ); ?> <small><?php echo sanitize_text_field( $theme_version ); ?></small></p>
		</div>
	</div><!-- .wrap -->

		<?php
			if ( WOLF_DEBUG ) {
				echo "<br><br>options";
				debug( get_option( 'wolf_theme_options_' . wolf_get_theme_slug() ) );

				echo "<br><br>posted";
				debug( $_POST );

			}
			//end wolf_options_admin
		}

		/**
		 * Generate theme option inputs
		 * @return string
		 */
		public function do_input( $item ) {
			wp_enqueue_media();

			$prefix = 'wolf_theme_options';

			$field_id = $item['id'];
			$label = ( isset( $item['label'] ) ) ? $item['label'] : '';
			$type = ( isset( $item['type'] ) ) ? $item['type'] : 'text';
			$size = ( isset( $item['size'] ) ) ? $item['size'] : '';
			$def = ( isset( $item['def'] ) ) ? $item['def'] : '';
			$desc = ( isset( $item['desc'] ) ) ? $item['desc'] : '';
			$pre = ( isset( $item['pre'] ) ) ? $item['pre'] : '';
			$app = ( isset( $item['app'] ) ) ? $item['app'] : '';
			$help = ( isset( $item['help'] ) ) ? $item['help'] : '';
			$placeholder = ( isset( $item['placeholder'] ) ) ? $item['placeholder'] : '';
			$parallax = ( isset( $item['parallax'] ) && $item['parallax'] == true && $type == 'background' ) ? true : false;
			$font_color = ( isset( $item['font_color'] ) && $item['font_color'] == false && $type == 'background' ) ? false : true;
			$do_attachment = ( isset( $item['bg_attachment'] ) && $item['bg_attachment'] == false && $type == 'background' ) ? true : false;

			if ( $help ) {

				$help = '<span class="hastip" title="' . esc_attr( esc_html__( 'Click to view the screenshot helper', 'inkpro' ) ) . '"><a class="wolf-help-img" href="' . esc_url( WOLF_THEME_URI . '/assets/img/admin/help/' . $item['help'] )  . '"><img src="' . esc_url( WOLF_FRAMEWORK_URI . '/assets/img/help.png' ) . '" alt="help"></a></span>';

				if ( $type != 'checkbox' ) {
					$desc .= $help;
				}
			}

			$dependency	= ( isset( $item['dependency'] ) ) ? $item['dependency'] : array();
			$class 		= "option-section-$field_id";
			$data 		= '';

			if ( array() != $dependency ) {
				$class .= ' has-dependency';

				$data .= ' data-dependency-element="' . $dependency['element'] . '"';

				$value_list = '';
				foreach ( $dependency['value'] as $value ) {
					$value_list .= '"' . $value . '",';
				}
				$value_list = rtrim( $value_list, ',' );

				$dependency_value = "[$value_list]";

				$data .= " data-dependency-values='$dependency_value'";
			}


		if ( $type == 'text' || $type == 'int' || $type == 'email' || $type == 'url' ) : ?>

			<tr valign="top" class="<?php echo esc_attr( $class ); ?>"<?php echo sanitize_text_field( $data ); ?>>
		    		<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]"><?php echo sanitize_text_field( $label ); ?>
						<br>
						<small class="description">
							<?php echo wp_kses( $desc,
								array(
									'a' => array(
										'class' => array(),
										'href' => array(),
										'target' => array(),
									),
									'span' => array(
										'class' => array(),
										'title' => array(),
									),
									'img' => array(
										'class' => array(),
										'src' => array(),
										'alt' => array(),
										'style' => array(),
									),
								)
							); ?>
						</small>
					</label>
				</th>

				<td class="forminp">
					<div class="<?php if ( $pre != '' ) : echo "input-prepend"; elseif ( $app !='' ) : echo "input-append"; endif; ?>">
					<?php if ( $pre != '' ) : ?>
						<span class="add-on"><?php echo sanitize_text_field( $pre ); ?></span>
					<?php endif; ?>
						<input<?php echo ( 'long' == $size ) ? ' style="max-width:900px;"' : ''; ?> placeholder="<?php echo esc_attr( $placeholder ); ?>" class="option-input" name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]" id="<?php echo esc_attr( $field_id ); ?>" type="text" value="<?php echo ( $this->get_option( $field_id ) ) ? htmlentities( stripslashes($this->get_option( $field_id ) ) ) : $def; ?>">
					<?php if ( $app != '' ) : ?>
						<span class="add-on"><?php echo sanitize_text_field( $app ); ?></span>
					<?php endif; ?>
					</div>
				</td>
			</tr>


		<?php
		/**
		 * CSS textarea
		 */
		elseif ( $type == 'css' ) : ?>
		<tr valign="top">
	    		<th scope="row" class="titledesc">
				<label for="<?php echo sanitize_text_field( $label ); ?>"><?php echo sanitize_text_field( $label ); ?>
					<br>
					<small class="description">
						<?php echo wp_kses( $desc,
							array(
								'a' => array(
									'class' => array(),
									'href' => array(),
									'target' => array(),
								),
								'span' => array(
									'class' => array(),
									'title' => array(),
								),
								'img' => array(
									'class' => array(),
									'src' => array(),
									'alt' => array(),
									'style' => array(),
								),
							)
						); ?>
					</small>
				</label>
			</th>

			<td class="forminp">

			</td>
		</tr>
		<div id="css-editor-container">
			<div id="css-editor"><?php echo wp_kses_post( stripslashes( $this->get_option( $field_id ) ) ); ?></div>
		</div>
		<textarea name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]" id="css-textarea" style="visibility:hidden;"><?php echo wp_kses_post( stripslashes( $this->get_option( $field_id ) ) ); ?></textarea>
		
		<?php elseif ( $type == 'editor' ) : ?>
		<?php
			$content =  ( $this->get_option( $field_id ) ) ? stripslashes( $this->get_option( $field_id ) ) : $def;
			$editor_id = $prefix . '_editor_' . $field_id;
		?>

			<tr valign="top" class="<?php echo esc_attr( $class ); ?>"<?php echo sanitize_text_field( $data ); ?>>
		    		<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $editor_id ); ?>"><?php echo sanitize_text_field( $label ); ?>
						<br>
						<small class="description">
							<?php echo wp_kses( $desc,
								array(
									'a' => array(
										'class' => array(),
										'href' => array(),
										'target' => array(),
									),
									'span' => array(
										'class' => array(),
										'title' => array(),
									),
									'img' => array(
										'class' => array(),
										'src' => array(),
										'alt' => array(),
										'style' => array(),
									),
								)
							); ?>
						</small>
					</label>
				</th>

				<td class="forminp">
					<div class="wolf-editor-container">
						<?php wp_editor( $content, $editor_id, $options = array() ); ?>
					</div>
				</td>
			</tr>

	    	<?php elseif ( $type == 'textarea' ) : ?>

		    	<tr valign="top" class="<?php echo esc_attr( $class ); ?>"<?php echo sanitize_text_field( $data ); ?>>
		    		<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]"><?php echo sanitize_text_field( $label ); ?><br>
					<small class="description">
							<?php echo wp_kses( $desc,
								array(
									'a' => array(
										'class' => array(),
										'href' => array(),
										'target' => array(),
									),
									'span' => array(
										'class' => array(),
										'title' => array(),
									),
									'img' => array(
										'class' => array(),
										'src' => array(),
										'alt' => array(),
										'style' => array(),
									),
								)
							); ?>
						</small>
					</label>
				</th>

				<td class="forminp">
					<div class="option-textarea">
						<textarea name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]"><?php echo ( $this->get_option( $field_id ) ) ? sanitize_text_field( $this->get_option( $field_id ) ) : $def; ?></textarea>
					</div>
				</td>
			</tr>

		<?php elseif ( $type == 'textarea_html' ) : ?>

		    	<tr valign="top" class="<?php echo esc_attr( $class ); ?>"<?php echo sanitize_text_field( $data ); ?>>
		    		<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]"><?php echo sanitize_text_field( $label ); ?><br>
					<small class="description">
							<?php echo wp_kses( $desc,
								array(
									'a' => array(
										'class' => array(),
										'href' => array(),
										'target' => array(),
									),
									'span' => array(
										'class' => array(),
										'title' => array(),
									),
									'img' => array(
										'class' => array(),
										'src' => array(),
										'alt' => array(),
										'style' => array(),
									),
								)
							); ?>
						</small>
					</label>
				</th>

				<td class="forminp">
					<div class="option-textarea">
						<textarea name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]"><?php echo ( $this->get_option( $field_id ) ) ? stripslashes( $this->get_option( $field_id ) ) : $def; ?></textarea>
					</div>
				</td>
			</tr>

	    	<?php elseif ( $type == 'select' ) : ?>

			<tr valign="top" class="<?php echo esc_attr( $class ); ?>"<?php echo sanitize_text_field( $data ); ?>>
		    		<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]"><?php echo sanitize_text_field( $label ); ?><br>
						<small class="description">
							<?php echo wp_kses( $desc,
								array(
									'a' => array(
										'class' => array(),
										'href' => array(),
										'target' => array(),
									),
									'span' => array(
										'class' => array(),
										'title' => array(),
									),
									'img' => array(
										'class' => array(),
										'src' => array(),
										'alt' => array(),
										'style' => array(),
									),
								)
							); ?>
						</small>
					</label>
				</th>

				<td class="forminp">

					<select name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]" id="<?php echo esc_attr( $field_id ); ?>">

					<?php if ( is_int( key( $item['choices'] ) ) ) : // is not associative ?>
						<?php foreach ( $item['choices'] as $v) : ?>
							<option value="<?php echo esc_attr( $v ); ?>" <?php selected( stripslashes($this->get_option( $field_id ) ), $v  ); ?>><?php echo sanitize_text_field( $v ); ?></option>
						<?php endforeach; ?>

					<?php else : ?>
						<?php foreach ( $item['choices'] as $v => $o) : ?>
							<option value="<?php echo esc_attr( $v ); ?>" <?php selected( stripslashes( $this->get_option( $field_id ) ), $v  ); ?>><?php echo sanitize_text_field( $o ); ?></option>
						<?php endforeach; ?>
					<?php endif; ?>
					</select>

				</td>
			</tr>

		<?php elseif ( $type == 'checkbox' ) : ?>

			<tr valign="top" class="<?php echo esc_attr( $class ); ?>"<?php echo sanitize_text_field( $data ); ?>>
		    		<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]"><?php echo sanitize_text_field( $label ); ?></label>
					<?php echo sanitize_text_field( $help ); ?>
				</th>

				<td class="forminp">
					<input type="checkbox" name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]" id="<?php echo esc_attr( $field_id ); ?>" value="true" <?php checked( $this->get_option( $field_id ), 'true' ); ?>>
					<small class="description">
						<?php echo wp_kses( $desc,
							array(
								'a' => array(
									'class' => array(),
									'href' => array(),
									'target' => array(),
								),
								'span' => array(
									'class' => array(),
									'title' => array(),
								),
								'img' => array(
									'class' => array(),
									'src' => array(),
									'alt' => array(),
									'style' => array(),
								),
							)
						); ?>
					</small>
				</td>
			</tr>

		<?php elseif ( $type == 'radio' ) : ?>

			<div class="wolf_input wolf_checkbox" class="<?php echo esc_attr( $class ); ?>"<?php echo sanitize_text_field( $data ); ?>>
				<label for="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]"><?php echo sanitize_text_field( $label ); ?></label>
				<input type="radio" name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]" id="<?php echo esc_attr( $field_id ); ?>" value="true" <?php checked( $def, true ); ?>>
				<small class="description">
					<?php echo wp_kses( $desc,
						array(
							'a' => array(
								'class' => array(),
								'href' => array(),
								'target' => array(),
							),
							'span' => array(
								'class' => array(),
								'title' => array(),
							),
							'img' => array(
								'class' => array(),
								'src' => array(),
								'alt' => array(),
								'style' => array(),
							),
						)
					); ?>
				</small>
			 </div>

		<?php elseif ( $type == 'image' ) :
			$img = $this->get_option( $field_id );

			if ( is_numeric( $img ) ) {
				$img_url = wolf_get_url_from_attachment_id( $img, 'logo' );
			} else {
				$img_url = esc_url( $img );
			}
		?>

			<tr valign="top" class="<?php echo esc_attr( $class ); ?>"<?php echo sanitize_text_field( $data ); ?>>
		    		<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]"><?php echo sanitize_text_field( $label ); ?>
						<br>
						<small class="description">
							<?php echo wp_kses( $desc,
								array(
									'a' => array(
										'class' => array(),
										'href' => array(),
										'target' => array(),
									),
									'span' => array(
										'class' => array(),
										'title' => array(),
									),
									'img' => array(
										'class' => array(),
										'src' => array(),
										'alt' => array(),
										'style' => array(),
									),
								)
							); ?>
						</small>
					</label>
				</th>

				<td class="forminp">

					<input type="hidden" name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]" id="<?php echo esc_attr( $field_id ); ?>" value="<?php echo esc_attr( $img ); ?>">
					<img <?php if ( ! $this->get_option( $field_id ) ) echo 'style="display:none;"'; ?> class="wolf-options-img-preview" src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $field_id ); ?>">
					<br>
					<a href="#" class="button wolf-options-reset-img"><?php esc_html_e( 'Clear', 'inkpro' ); ?></a>
					<a href="#" class="button wolf-options-set-img"><?php esc_html_e( 'Choose an image', 'inkpro' ); ?></a>

				</td>
			</tr>

		<?php elseif ( $type == 'file' ) : ?>

			<tr valign="top" class="<?php echo esc_attr( $class ); ?>"<?php echo sanitize_text_field( $data ); ?>>
		    		<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]"><?php echo sanitize_text_field( $label ); ?><br>
					<small class="description">
						<?php echo wp_kses( $desc,
							array(
								'a' => array(
									'class' => array(),
									'href' => array(),
									'target' => array(),
								),
								'span' => array(
									'class' => array(),
									'title' => array(),
								),
								'img' => array(
									'class' => array(),
									'src' => array(),
									'alt' => array(),
									'style' => array(),
								),
							)
						); ?>
					</small>
				</th>

				<td class="forminp">
					<input type="text" class="option-input" name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]" id="<?php echo esc_attr( $field_id ); ?>" value="<?php echo esc_url( $this->get_option( $field_id ) ); ?>">
					<br><br>
					<a href="#" class="button wolf-options-reset-file"><?php esc_html_e( 'Clear', 'inkpro' ); ?></a>
					<a href="#" class="button wolf-options-set-file"><?php esc_html_e( 'Choose a file', 'inkpro' ); ?></a>
				</td>
			</tr>

		<?php elseif ( $type == 'background' ) : ?>

		<div class="<?php echo esc_attr( $class ); ?>"<?php echo sanitize_text_field( $data ); ?>>
			<div class="section-title">
				<h3><?php echo sanitize_text_field( $label ); ?></h3>
				<p class="description">
					<?php echo wp_kses( $desc,
						array(
							'a' => array(
								'class' => array(),
								'href' => array(),
								'target' => array(),
							),
							'span' => array(
								'class' => array(),
								'title' => array(),
							),
							'img' => array(
								'class' => array(),
								'src' => array(),
								'alt' => array(),
								'style' => array(),
							),
						)
					); ?>
				</p>
			</div>

			<table class="form-table">
				<tbody>

		<?php
		/* Font Color
		---------------*/
		?>
		<?php
		if ( $font_color ) :
			$options = array(
				'dark' => esc_html__( 'Dark', 'inkpro' ),
				'light' => esc_html__( 'Light', 'inkpro' )
			);
			 ?>
			 	<tr valign="top">
			    		<th scope="row" class="titledesc">
						<label for="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>_font_color]"><?php esc_html_e( 'Font Color', 'inkpro' ); ?></label>
					</th>

					<td class="forminp">
						<select name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>_font_color]" id="<?php echo esc_attr( $field_id ); ?>_font_color">
						<?php foreach ( $options as $o => $v) : ?>
							<option value="<?php echo esc_attr( $o ); ?>" <?php if ( stripslashes($this->get_option( $field_id.'_font_color' ) ) == $o  ) echo 'selected="selected"'; ?>><?php echo sanitize_text_field( $v ); ?></option>
						<?php endforeach; ?>
						</select>
					</td>
				</tr>

			<?php
		endif;
			/* Color
			---------------*/
			?>
			<tr valign="top">
		    		<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>_color]"><?php esc_html_e( 'Background Color', 'inkpro' ); ?><br></label>
				</th>

				<td class="forminp">
					<input class="wolf-options-colorpicker" name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>_color]" id="<?php echo esc_attr( $field_id ); ?>_color" style="width:75px" type="text" value="<?php if ( $this->get_option( $field_id.'_color' ) ) echo htmlentities( stripslashes($this->get_option( $field_id.'_color' ) ) ); ?>">
				</td>
			</tr>

		<?php
		/* Image
		---------------*/
		$img = $this->get_option( $field_id . '_img' );
		if ( is_numeric( $img ) ) {
			$img_url = wolf_get_url_from_attachment_id( $img, 'thumbnail' );
		} else {
			$img_url = esc_url( $img );
		}
		?>
			<tr valign="top">
		    		<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>_img]"><?php esc_html_e( 'Background Image', 'inkpro' ); ?>
				</label>
				</th>

				<td class="forminp">
					<input type="hidden" name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>_img]" id="<?php echo esc_attr( $field_id ); ?>_img" value="<?php echo esc_attr( $img ); ?>">
					<img <?php if ( ! $this->get_option( $field_id .'_img' ) ) echo 'style="display:none;"'; ?> class="wolf-options-img-preview" src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $field_id ); ?>">
					<br><a href="#" class="button wolf-options-reset-bg"><?php esc_html_e( 'Clear', 'inkpro' ); ?></a>
					<a href="#" class="button wolf-options-set-bg"><?php esc_html_e( 'Choose an image', 'inkpro' ); ?></a>
				</td>
			</tr>

		<?php
		/* Repeat
		---------------*/
		?>
		<?php
		$options = array( 'no-repeat', 'repeat', 'repeat-x', 'repeat-y' );
		 ?>
		 	<tr valign="top">
		    		<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>_repeat]"><?php esc_html_e( 'Repeat', 'inkpro' ); ?></label>
				</th>

				<td class="forminp">
					<select name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>_repeat]" id="<?php echo esc_attr( $field_id ); ?>_repeat">
					<?php foreach ( $options as $o) : ?>
						<option value="<?php echo esc_attr( $o ); ?>" <?php if ( stripslashes($this->get_option( $field_id.'_repeat' ) ) == $o  ) echo 'selected="selected"'; ?>><?php echo sanitize_text_field( $o ); ?></option>
					<?php endforeach; ?>
					</select>
				</td>
			</tr>

		<?php
		/* Position
		---------------*/

		$options = array(
			'center center',
			'center top',
			'left top' ,
			'right top' ,
			'center bottom',
			'left bottom' ,
			'right bottom' ,
			'left center' ,
			'right center',
		);
		 ?>
	 		<tr valign="top">
		    		<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>_position]"><?php esc_html_e( 'Position', 'inkpro' ); ?></label>
				</th>

				<td class="forminp">
					<select name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>_position]" id="<?php echo esc_attr( $field_id ); ?>_position">
					<?php foreach ( $options as $o) : ?>
						<option value="<?php echo esc_attr( $o ); ?>" <?php selected( $this->get_option( $field_id.'_position' ), $o  ); ?>><?php echo sanitize_text_field( $o ); ?></option>
					<?php endforeach; ?>
					</select>
				</td>
			</tr>
		<?php
		if ( $do_attachment ) :

			/* Attachment
			---------------*/
			$options = array(
				'scroll',
				'fixed',
			);
			 ?>
		 		<tr valign="top">
			    		<th scope="row" class="titledesc">
						<label for="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>_attachment]"><?php esc_html_e( 'Attachment', 'inkpro' ); ?></label>
					</th>

					<td class="forminp">
						<select name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>_attachment]" id="<?php echo esc_attr( $field_id ); ?>_attachment">
						<?php foreach ( $options as $o) : ?>
							<option value="<?php echo esc_attr( $o ); ?>" <?php selected( $this->get_option( $field_id.'_attachment' ), $o  ); ?>><?php echo sanitize_text_field( $o ); ?></option>
						<?php endforeach; ?>
						</select>
					</td>
				</tr>
			<?php
		endif; // endif attachment

		/* Size
		---------------*/
		$options = array(
			'cover' => esc_html__( 'cover (resize)', 'inkpro' ),
			'normal' => esc_html__( 'normal', 'inkpro' ),
			'resize' => esc_html__( 'responsive (hard resize)', 'inkpro' ),
		);

		?>
			<tr valign="top">
		    		<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>_size]"><?php esc_html_e( 'Size', 'inkpro' ); ?></label>
				</th>

				<td class="forminp">
					<select name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>_size]" id="<?php echo esc_attr( $field_id ); ?>_size">
					<?php foreach ( $options as $o => $v) : ?>
						<option value="<?php echo esc_attr( $o ); ?>" <?php selected( $this->get_option( $field_id.'_size' ), $o ); ?>><?php echo sanitize_text_field( $v ); ?></option>
					<?php endforeach; ?>
					</select>
				</td>
			</tr>

				<?php if ( $parallax ): ?>
					<tr valign="top">
				    		<th scope="row" class="titledesc">
							<label for="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>_parallax]"><?php esc_html_e( 'Parallax', 'inkpro' ); ?></label>
							</label>
						</th>

						<td class="forminp">
							<input type="checkbox" name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>_parallax]" id="<?php echo esc_attr( $field_id ); ?>_parallax" value="true" <?php checked( $this->get_option( $field_id . '_parallax' ), 'true' ); ?>>
						</td>
					</tr>

				<?php endif ?>
			</tbody>
		</table>

		</div><!-- end option section -->
		<?php
		/* Font
		---------------*/
		elseif ( $type == 'font' ) :
			$field_id = $field_id;
			$color = $this->get_option( $field_id . '_font_color' );
			$name = $this->get_option( $field_id . '_font_name' );
			$weight = $this->get_option( $field_id . '_font_weight' );
			$transform = $this->get_option( $field_id . '_font_transform' );
			$letter_spacing = $this->get_option( $field_id . '_font_letter_spacing' );
			$style = $this->get_option( $field_id . '_font_style' );
			$exclude_params = isset( $item['exclude_params'] ) ? $item['exclude_params'] : array();
		?>
		<div class="<?php echo esc_attr( $class ); ?>"<?php echo sanitize_text_field( $data ); ?>>
			<div class="section-title">
				<h3><?php echo sanitize_text_field( $label ); ?></h3>
				<p class="description"><?php echo sanitize_text_field( $item['desc'] ); ?></p>
			</div>

			<table class="form-table">
				<tbody>

			<?php

			if ( ! in_array( 'name', $exclude_params ) ) :

				global $wolf_google_fonts;
				$wolf_fonts = $wolf_google_fonts;
			?>
			<tr valign="top">
		    		<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_font_name]'; ?>"><?php esc_html_e( 'Font family', 'inkpro' ); ?><br>
					</label>
				</th>

				<td class="forminp">
					<select name="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_font_name]'; ?>" id="<?php echo esc_attr( $field_id ); ?>">
						<?php foreach ( $wolf_fonts as $k => $v ) : ?>
							<option value="<?php echo esc_attr( $k ); ?>" <?php selected( $k, $name ); ?>><?php echo sanitize_text_field( $k ); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<?php endif;

			if ( ! in_array( 'color', $exclude_params ) ) :
			?>
			<tr valign="top">
		    		<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_font_color]'; ?>"><?php esc_html_e( 'Font color', 'inkpro' ); ?><br>
					</label>
				</th>

				<td class="forminp">
					<input class="wolf-options-colorpicker" value="<?php echo esc_attr( $color ); ?>" name="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_font_color]'; ?>" id="<?php echo esc_attr( $field_id ); ?>">
				</td>
			</tr>
			<?php endif;

			if ( ! in_array( 'weight', $exclude_params ) ) :
			?>
			<tr valign="top">
		    		<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_font_weight]'; ?>"><?php esc_html_e( 'Font weight', 'inkpro' ); ?><br>
					<small class="description"><?php esc_html_e( 'For example: 400 is normal, 700 is bold.The available font weights depend on the font. Leave empty to use the theme default style', 'inkpro' ); ?></small>
					</label>
				</th>

				<td class="forminp">
					<input value="<?php echo esc_attr( $weight ); ?>" name="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_font_weight]'; ?>" id="<?php echo esc_attr( $field_id ); ?>">
				</td>
			</tr>
			<?php endif;

			if ( ! in_array( 'transform', $exclude_params ) ) :

				$options = array( 'none', 'uppercase' );
			?>
			<tr valign="top">
		    		<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_font_transform]'; ?>"><?php esc_html_e( 'Font transform', 'inkpro' ); ?><br>
					</label>
				</th>

				<td class="forminp">
					<select name="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_font_transform]'; ?>" id="<?php echo esc_attr( $field_id ); ?>">
						<?php foreach ( $options as $o ) : ?>
							<option value="<?php echo esc_attr( $o ); ?>" <?php if ( $o == $transform ) echo 'selected="selected"'; ?>><?php echo sanitize_text_field( $o ); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<?php endif;

			if ( ! in_array( 'style', $exclude_params ) ) :

				$options = array( 'normal', 'italic' );
			?>
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_font_style]'; ?>"><?php esc_html_e( 'Font style', 'inkpro' ); ?><br>
					</label>
				</th>

				<td class="forminp">
					<select name="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_font_style]'; ?>" id="<?php echo esc_attr( $field_id ); ?>">
						<?php foreach ( $options as $o ) : ?>
							<option value="<?php echo esc_attr( $o ); ?>" <?php selected( $o, $style ); ?>><?php echo sanitize_text_field( $o ); ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<?php endif;

			if ( ! in_array( 'letter_spacing', $exclude_params ) ) : ?>
			<tr valign="top">
				<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_font_letter_spacing]'; ?>"><?php esc_html_e( 'Letter Spacing (omit px)', 'inkpro' ); ?><br>
					</label>
				</th>

				<td class="forminp">
					<input value="<?php echo esc_attr( $letter_spacing ); ?>" name="<?php echo esc_attr( $prefix . '[' .  $field_id .'_font_letter_spacing]' ); ?>" id="<?php echo esc_attr( $field_id ); ?>">
				</td>
			</tr>
			<?php endif; ?>
			</tbody>
		</table>
		</div><!-- end option section -->
		<?php
		/* video
		---------------*/
		elseif ( $type == 'video' ) :

			$type = $this->get_option( $field_id . '_type' );
			$youtube_url = $this->get_option( $field_id . '_youtube_url' );
			$mp4 = $this->get_option( $field_id . '_mp4' );
			$webm = $this->get_option( $field_id . '_webm' );
			$ogv = $this->get_option( $field_id . '_ogg' );
			$opacity = $this->get_option( $field_id . '_opacity' ) ? intval( $this->get_option( $field_id . '_opacity' ) ) : 100;
			$img = $this->get_option( $field_id . '_img' );
			$exclude_params = isset( $item['exclude_params'] ) ? $item['exclude_params'] : array();
		?>
		<div class="<?php echo esc_attr( $class ); ?>"<?php echo sanitize_text_field( $data ); ?>>
			<div class="section-title">
				<h3><?php echo sanitize_text_field( $label ); ?></h3>
				<p class="description"><?php echo sanitize_text_field( $item['desc'] ); ?></p>
			</div>

			<table class="form-table">
				<tbody>

				<?php if ( ! in_array( 'type', $exclude_params ) ) : ?>
					<tr valign="top" class="option-section-<?php echo esc_attr( $field_id .'_type' ); ?>">
						<th scope="row" class="titledesc">
							<label for="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_type]'; ?>"><?php esc_html_e( 'Video Background type', 'inkpro' ); ?><br>
						</th>

						<td class="forminp">
							<select name="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_type]'; ?>">
								<option value="youtube" <?php selected( $type, 'youtube' ); ?>>Youtube</option>
								<option value="selfhosted" <?php selected( $type, 'selfhosted' ); ?>><?php esc_html_e( 'Self hosted', 'inkpro' ); ?></option>
							</select>
						</td>
					</tr>
				<?php endif; ?>

				<?php if ( ! in_array( 'youtube_url', $exclude_params ) ) : ?>
					<tr valign="top" class="has-dependency" data-dependency-element="<?php echo esc_attr( $field_id . '_type' ); ?>" data-dependency-values='["youtube"]'>
						<th scope="row" class="titledesc">
							<label for="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_youtube_url]'; ?>"><?php esc_html_e( 'Video Background Youtube URL', 'inkpro' ); ?><br>
						</th>

						<td class="forminp">
							<input class="option-input" name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>_youtube_url]" type="text" value="<?php echo esc_url( $youtube_url ); ?>">
						</td>
					</tr>
				<?php endif; ?>

				<?php if ( ! in_array( 'mp4', $exclude_params ) ) : ?>
					<tr valign="top" class="has-dependency" data-dependency-element="<?php echo esc_attr( $field_id . '_type' ); ?>" data-dependency-values='["selfhosted"]'>
						<th scope="row" class="titledesc">
							<label for="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_mp4]'; ?>"><?php esc_html_e( 'mp4 URL', 'inkpro' ); ?><br>
						</th>

						<td class="forminp">
							<input type="text" class="option-input" name="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_mp4]'; ?>" id="<?php echo esc_attr( $field_id ); ?>" value="<?php echo esc_url( $mp4 ); ?>">
							<br><br>
							<a href="#" class="button wolf-options-reset-file"><?php esc_html_e( 'Clear', 'inkpro' ); ?></a>
							<a href="#" class="button wolf-options-set-file"><?php esc_html_e( 'Choose a file', 'inkpro' ); ?></a>
						</td>
					</tr>
				<?php endif; ?>

				<?php if ( ! in_array( 'webm', $exclude_params ) ) : ?>
					<tr valign="top" class="has-dependency" data-dependency-element="<?php echo esc_attr( $field_id . '_type' ); ?>" data-dependency-values='["selfhosted"]'>
						<th scope="row" class="titledesc">
							<label for="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_webm]'; ?>"><?php esc_html_e( 'webm URL', 'inkpro' ); ?><br>
						</th>

						<td class="forminp">
							<input type="text" class="option-input" name="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_webm]'; ?>" id="<?php echo esc_attr( $field_id ); ?>" value="<?php echo esc_url( $webm ); ?>">
							<br><br>
							<a href="#" class="button wolf-options-reset-file"><?php esc_html_e( 'Clear', 'inkpro' ); ?></a>
							<a href="#" class="button wolf-options-set-file"><?php esc_html_e( 'Choose a file', 'inkpro' ); ?></a>
						</td>
					</tr>
				<?php endif; ?>

				<?php if ( ! in_array( 'ogv', $exclude_params ) ) : ?>
					<tr valign="top" class="has-dependency" data-dependency-element="<?php echo esc_attr( $field_id . '_type' ); ?>" data-dependency-values='["selfhosted"]'>
						<th scope="row" class="titledesc">
							<label for="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_ogv]'; ?>"><?php esc_html_e( 'ogv URL', 'inkpro' ); ?><br>
						</th>

						<td class="forminp">
							<input type="text" class="option-input" name="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_ogv]'; ?>" id="<?php echo esc_attr( $field_id ); ?>" value="<?php echo esc_url( $ogv ); ?>">
							<br><br>
							<a href="#" class="button wolf-options-reset-file"><?php esc_html_e( 'Clear', 'inkpro' ); ?></a>
							<a href="#" class="button wolf-options-set-file"><?php esc_html_e( 'Choose a file', 'inkpro' ); ?></a>
						</td>
					</tr>
				<?php endif; ?>

				<?php if ( ! in_array( 'image', $exclude_params ) ) : ?>
					<tr valign="top">
						<th scope="row" class="titledesc">
							<label for="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_img]'; ?>"><?php esc_html_e( 'Image URL', 'inkpro' ); ?><br>
							<small class="description"><?php esc_html_e( 'Image fallback', 'inkpro' ); ?></small></label>
						</th>

						<td class="forminp">
							<input type="text" class="option-input" name="<?php echo esc_attr( $prefix ) . '[' .  $field_id .'_img]'; ?>" id="<?php echo esc_attr( $field_id ); ?>" value="<?php echo esc_url( $img ); ?>">
							<br><br>
							<a href="#" class="button wolf-options-reset-file"><?php esc_html_e( 'Clear', 'inkpro' ); ?></a>
							<a href="#" class="button wolf-options-set-file"><?php esc_html_e( 'Choose a file', 'inkpro' ); ?></a>
						</td>
					</tr>
				<?php endif; ?>

			</tbody>
		</table>

		</div><!-- end option section -->
		<?php elseif ( $type == 'colorpicker' ) : ?>

			<tr valign="top" class="<?php echo esc_attr( $class ); ?>"<?php echo sanitize_text_field( $data ); ?>>
				<th scope="row" class="titledesc">
					<label for="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]"><?php echo sanitize_text_field( $label ); ?><br>
						<small class="description">
							<?php echo wp_kses( $desc,
								array(
									'a' => array(
										'class' => array(),
										'href' => array(),
										'target' => array(),
									),
									'span' => array(
										'class' => array(),
										'title' => array(),
									),
									'img' => array(
										'class' => array(),
										'src' => array(),
										'alt' => array(),
										'style' => array(),
									),
								)
							); ?>
						</small>
					</label>
				</th>

				<td class="forminp">
					<input class="wolf-options-colorpicker" name="<?php echo esc_attr( $prefix ); ?>[<?php echo esc_attr( $field_id ); ?>]" id="<?php echo esc_attr( $field_id ); ?>" type="text" value="<?php echo ( $this->get_option( $field_id ) ) ? htmlentities( stripslashes( $this->get_option( $field_id ) ) ) : $def; ?>">
				</td>
			</tr>


		<?php
		endif;

		} // end wolf_do_input function

	} // end class

} // end class exists check