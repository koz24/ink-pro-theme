<?php
/**
 * InkPro gallery settings
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'inkpro_add_media_manager_options' ) ) {
	/**
	 * Add settings to gallery media manager
	 *
	 * @see http://wordpress.stackexchange.com/questions/90114/enhance-media-manager-for-gallery
	 * @since InkPro 1.0.0
	 */
	function inkpro_add_media_manager_options() {
		// define your backbone template;
		// the "tmpl-" prefix is required,
		// and your input field should have a data-setting attribute
		// matching the shortcode name
		?>
		<script type="text/html" id="tmpl-custom-gallery-setting">

			<label class="setting">
				<span><?php esc_html_e( 'Layout', 'inkpro' ); ?></span>
				<select data-setting="layout">
					<option value="simple"><?php esc_html_e( 'Simple', 'inkpro' ); ?></option>
					<option value="mosaic"><?php esc_html_e( 'Mosaic', 'inkpro' ); ?></option>
					<option value="slider"><?php esc_html_e( 'Slider (settings below won\'t be applied)', 'inkpro' ); ?></option>
				</select>
			</label>
			<label class="setting">
				<span><?php esc_html_e( 'Custom size', 'inkpro' ); ?></span>
				<select data-setting="size">
					<option value="inkpro-thumb"><?php esc_html_e( 'Standard', 'inkpro' ); ?></option>
					<option value="inkpro-2x2"><?php esc_html_e( 'Square', 'inkpro' ); ?></option>
					<option value="inkpro-portrait"><?php esc_html_e( 'Portrait', 'inkpro' ); ?></option>
					<option value="thumbnail"><?php esc_html_e( 'Thumbnail', 'inkpro' ); ?></option>
					<option value="medium"><?php esc_html_e( 'Medium', 'inkpro' ); ?></option>
					<option value="large"><?php esc_html_e( 'Large', 'inkpro' ); ?></option>
					<option value="full"><?php esc_html_e( 'Full', 'inkpro' ); ?></option>
				</select>
			</label>
			<label class="setting">
				<span><?php esc_html_e( 'Padding', 'inkpro' ); ?></span>
				<select data-setting="padding">
					<option value="yes"><?php esc_html_e( 'Yes', 'inkpro' ); ?></option>
					<option value="no"><?php esc_html_e( 'No', 'inkpro' ); ?></option>
				</select>
			</label>
			<label class="setting">
				<span><?php esc_html_e( 'Hover effect', 'inkpro' ); ?></span>
				<select data-setting="hover_effect">
					<option value="default"><?php esc_html_e( 'Default', 'inkpro' ); ?></option>
					<option value="scale-to-greyscale"><?php esc_html_e( 'Scale + Colored to Black and white', 'inkpro' ); ?></option>
					<option value="greyscale"><?php esc_html_e( 'Black and white to colored', 'inkpro' ); ?></option>
					<option value="to-greyscale"><?php esc_html_e( 'Colored to Black and white', 'inkpro' ); ?></option>
					<option value="scale-greyscale"><?php esc_html_e( 'Scale + Black and white to colored', 'inkpro' ); ?></option>
					<option value="none"><?php esc_html_e( 'None', 'inkpro' ); ?></option>
				</select>
				<small><?php esc_html_e( 'Note that not all browser support the black and white effect', 'inkpro' ); ?></small>
			</label>
		</script>

		<script>

		jQuery( document ).ready( function() {
			// add your shortcode attribute and its default value to the
			// gallery settings list; $.extend should work as well...
			_.extend(wp.media.gallery.defaults, {
				size : 'standard',
				padding : 'no',
				hover_effet : 'default'
			} );

			// merge default gallery settings template with yours
			wp.media.view.Settings.Gallery = wp.media.view.Settings.Gallery.extend( {
				template: function( view ) {
					return wp.media.template( 'gallery-settings' )( view )
					+ wp.media.template( 'custom-gallery-setting' )( view );
				}
			} );
		} );
		</script>
		<?php

	}
	add_action( 'print_media_templates', 'inkpro_add_media_manager_options' );
}