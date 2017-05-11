<?php
/**
 * WolfFramework about page
 *
 * @package WordPress
 * @subpackage WolfFramework
 * @author WolfThemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Wolf_Admin_About_Page' ) ) {
	/**
	 * Welcome Page Class
	 *
	 * Shows a feature overview for the new version (major).
	 *
	 * @since Wolf 1.0.0
	 */
	class Wolf_Admin_About_Page {

		/**
		 * __construct function.
		 */
		public function __construct() {

			if ( is_child_theme() ) {
				//return;
			}

			add_action( 'admin_menu', array( $this, 'admin_menus') );
			add_action( 'admin_enqueue_scripts', array( $this, 'hide_admin_notice' ) );
			add_action( 'admin_init', array( $this, 'welcome' ) );
		}

		/**
		 * Add admin menus/screens
		 *
		 */
		public function admin_menus() {

			add_theme_page( esc_html__( 'About the Theme', 'inkpro' ), esc_html__( 'About the Theme', 'inkpro' ), 'switch_themes', 'wolf-theme-about', array( $this, 'about_screen' ) );
		}

		/**
		 * Add styles just for this page, and remove dashboard page links.
		 *
		 */
		public function hide_admin_notice() {

			$css = '';

			//remove_submenu_page( 'themes.php', 'wolf-theme-about' );
			if ( isset( $_GET['page'] ) && 'wolf-theme-about' == $_GET['page'] ) {
				$css = '
					/* Hide plugin admin notice */
					.wolf-admin-notice{
						display:none;
					}
				';

			}

			if ( ! SCRIPT_DEBUG ) {
				$css = wolf_compact_css( $css );
			}
			
			wp_add_inline_style( 'wolf-admin', $css );
		}

		/**
		 * Into text/links shown on all about pages.
		 *
		 * @access private
		 * @return void
		 */
		private function intro() {

			// force Welcome admin panel to show
			if ( isset( $_GET['wolf-theme-activated'] ) ) {
				update_user_meta( get_current_user_id(), 'show_welcome_panel', true );
			}

			$theme_name = WOLF_THEME_NAME;
			$theme_version = WOLF_THEME_VERSION;
			?>
			<h1><?php printf( esc_html__( 'Welcome to %s %s', 'inkpro' ), $theme_name, $theme_version ); ?></h1>

			<div class="about-text wolf-about-text">
				<?php
					if ( isset( $_GET['wolf-theme-updated'] ) ) {
						$message = esc_html__( 'Thank you for updating to the latest version!', 'inkpro' );
					} else {
						$message = sprintf( esc_html__( 'Thanks for installing %s theme!', 'inkpro' ), $theme_name );
					}

					if ( isset( $_GET['wolf-theme-activated'] ) ) {
						
						printf( esc_html__( '%s We hope you will enjoy using it.', 'inkpro' ), $message );
					
					} elseif ( isset( $_GET['wolf-theme-updated'] ) ) {
						
						printf( wp_kses( __( '%s <br> %s is now more stable and secure than ever.<br>We hope you enjoy using it.', 'inkpro' ), array( 'br' => array() ) ), $message, $theme_name );
					
					} else {
						printf( esc_html__( '%s We hope you enjoy using it.', 'inkpro' ), $message );
					}
				?>
			</div>
			<div class="wp-badge wolf-about-page-logo">
			<?php printf( esc_html__( 'Version %s', 'inkpro'  ), sanitize_text_field( $theme_version ) ); ?></div>
			<?php
		}

		/**
		 * Output the about screen.
		 *
		 */
		public function about_screen() {
			?>
			<div class="wrap about-wrap wolf-about-page">
				<?php $this->intro(); ?>
				<?php $this->actions(); ?>
				<?php $this->tabs(); ?>
			</div>
			<?php
		}

		/**
		 * Check if TGM plugin activation is completed
		 *
		 * As there isn't any filter or hook to know if TGMPA has been completed
		 * We check if its menu exists as it is disabled when plugin is completed
		 */
		private function is_tgmpa_in_da_place() { // don't ask me, lack of inspiratino for the function name
			global $submenu;

			$tgmpa_menu_slug = 'tgmpa-install-plugins'; // must be the same as in the plugin config/plugins.php file

			if ( ! get_user_meta( get_current_user_id(), 'tgmpa_dismissed_notice_tgmpa' ) ) { // if user didn't dismissed the notice
				if ( isset( $submenu['themes.php'] ) ) {
					$theme_menu_items = $submenu['themes.php'];

					foreach ( $theme_menu_items as $item ) {

						if ( isset( $item[2] ) && $tgmpa_menu_slug == $item[2] ) {
							return true;
							break;
						}
					}
				}
			}
		}

		/**
		 * Output the last new feature if set in the changelog XML
		 *
		 */
		public function actions() {
			?>
			<p class="wolf-about-actions">
				<?php if ( $this->is_tgmpa_in_da_place() ) : ?>
					<a href="<?php echo esc_url( admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>" class="button button-primary">
						<span class="dashicons dashicons-admin-plugins"></span>
						<?php esc_html_e( 'Install Recommended Plugins', 'inkpro' ); ?>
					</a>	
				<?php endif; ?>
				<a target="_blank" href="<?php echo esc_url( 'https://docs.wolfthemes.com/documentation/theme/' . WOLF_THEME_SLUG ); ?>" class="button">
					<span class="dashicons dashicons-sos"></span>
					<?php esc_html_e( 'Documentation', 'inkpro' ); ?>
				</a>
			</p>
			<?php
		}

		/**
		 * Tabs
		 */
		public function tabs() {
			?>
			<div id="wolf-welcome-tabs">
				<h2 class="nav-tab-wrapper">
					<div class="tabs" id="tabs1">
						<a href="#welcome" class="nav-tab nav-tab-active"><?php esc_html_e( 'System Status', 'inkpro' ); ?></a>
						<a href="#changelog" class="nav-tab"><?php esc_html_e( 'Changelog', 'inkpro' ); ?></a>	
					</div>
				</h2>
				<div class="content">
					<div id="welcome" class="wolf-options-panel">
						<?php $this->system_status(); ?>
					</div>
					<div id="changelog" class="wolf-options-panel">
						<?php $this->changelog(); ?>
					</div>
				</div>
			</div><!-- #wolf-welcome-tabs -->
			<?php
		}

		/**
		 * Welcom tab
		 */
		public function system_status() {
			?>
			<div id="wolf-system-status">

				<p>
					<?php esc_html_e( 'Check that all the requirements below are fulfiled and labeled in green.', 'inkpro' ); ?>
				</p>

				<h4><?php esc_html_e( 'WordPress Environment', 'inkpro' ); ?></h4>

				<table>
			<?php
			$xml_latest = '0';
			$xml_requires = WOLF_REQUIRED_WP_VERSION;

			if ( $xml = wolf_get_theme_changelog() ) {
				$xml_latest = (string)$xml->latest;
				$xml_requires = (string)$xml->requires;
			}
			// Theme version
			$theme_version = WOLF_THEME_VERSION;
			//$theme_version = '1.0.0';
			$required_theme_version = $xml_latest;
			$theme_version_condition = ( version_compare( $theme_version, $required_theme_version, '>=' ) );
			$theme_update_url = ( class_exists( 'Envato_Market' ) ) ? admin_url( 'admin.php?page=envato-market' ) : admin_url( 'admin.php?page=wolf-theme-update' );
			$theme_version_error_message = ( ! $theme_version_condition ) ? ' - ' . esc_html__( 'It is recommended to update the theme to the latest version', 'inkpro' ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'Theme Version', 'inkpro' ); ?></td>
						<td class="help"><a class="hastip" title="<?php printf( __( 'The version of %s installed on your site.', 'inkpro' ), WOLF_THEME_NAME ); ?>" href="<?php echo esc_url( $theme_update_url ); ?>"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( $theme_version_condition ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $theme_version . $theme_version_error_message ); ?></td>
						<td class="status <?php echo ( $theme_version_condition ) ? 'green' : 'red'; ?>"><?php echo ( $theme_version_condition ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			// WP version
			$wp_version = get_bloginfo( 'version' );
			//$wp_version = '4.4.0';
			$required_wp_version = $xml_requires;
			$wp_version_condition = ( version_compare( $wp_version, $required_wp_version, '>=' ) );
			$wp_version_error_message = ( ! $wp_version_condition ) ? ' - ' . esc_html__( 'It is recommended to update WordPress to the latest version', 'inkpro' ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'WP Version', 'inkpro' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_html_e( 'The version of WordPress installed on your site.', 'inkpro' ); ?>" href="https://docs.wolfthemes.com/document/keep-wordpress-installation-date/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( $wp_version_condition ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $wp_version . $wp_version_error_message ); ?></td>
						<td class="status <?php echo ( $wp_version_condition ) ? 'green' : 'red'; ?>"><?php echo ( $wp_version_condition ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			// WP memory limit
			$wp_memory_limit = WP_MEMORY_LIMIT;
			//$wp_memory_limit = '12M';
			$required_wp_memory_limit = WOLF_REQUIRED_WP_MEMORY_LIMIT;
			$wp_memory_limit_condition = ( wp_convert_hr_to_bytes( $wp_memory_limit ) >= wp_convert_hr_to_bytes( $required_wp_memory_limit ) );
			$wp_memory_limit_error_message = ( ! $wp_memory_limit_condition ) ? ' - ' . sprintf( __( 'It is recommended to increase your WP memory limit to %s at least', 'inkpro' ), WOLF_REQUIRED_WP_MEMORY_LIMIT ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'WP Memory Limit', 'inkpro' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_html_e( 'The maximum amount of memory (RAM) that your site can use at one time.', 'inkpro' ); ?>" href="https://docs.wolfthemes.com/document/increasing-the-wordpress-memory-limit/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( $wp_memory_limit_condition ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $wp_memory_limit . $wp_memory_limit_error_message ); ?></td>
						<td class="status <?php echo ( $wp_memory_limit_condition ) ? 'green' : 'red'; ?>"><?php echo ( $wp_memory_limit_condition ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
				
				</table>

				<h4><?php esc_html_e( 'Server Environment', 'inkpro' ); ?></h4>

				<table>
			<?php
			// PHP version
			$php_version = phpversion();
			//$php_version = '1.0.0';
			$required_php_version = WOLF_REQUIRED_PHP_VERSION;
			$php_version_condition = ( version_compare( $php_version, $required_php_version, '>=' ) );
			$php_version_error_message = ( ! $php_version_condition ) ? ' - ' . sprintf( __( 'The theme needs at least PHP %s installed on your server', 'inkpro' ), WOLF_REQUIRED_PHP_VERSION ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'PHP Version', 'inkpro' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_html_e( 'The version of PHP installed on your hosting server.', 'inkpro' ); ?>" href="https://docs.wolfthemes.com/document/how-to-update-your-php-version/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( $php_version_condition ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $php_version . $php_version_error_message ); ?></td>
						<td class="status <?php echo ( $php_version_condition ) ? 'green' : 'red'; ?>"><?php echo ( $php_version_condition ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			// PHP max_input_vars
			$max_input_vars = @ini_get( 'max_input_vars' );
			//$max_input_vars = '1000';
			$required_max_input_vars = WOLF_REQUIRED_MAX_INPUT_VARS;
			$max_input_vars_condition = ( wp_convert_hr_to_bytes( $max_input_vars ) >= wp_convert_hr_to_bytes( $required_max_input_vars ) );
			$max_input_vars_condition_error_message = ( ! $max_input_vars_condition ) ? ' - ' . sprintf( __( 'It is recommended to increase your server max_input_var value to %s at least', 'inkpro' ), WOLF_REQUIRED_MAX_INPUT_VARS ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'PHP Max Input Vars', 'inkpro' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_html_e( 'The maximum amount of variable your server can use for a single function.', 'inkpro' ); ?>" href="https://docs.wolfthemes.com/document/increasing-the-php-max-input-vars/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( $max_input_vars_condition ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $max_input_vars . $max_input_vars_condition_error_message ); ?></td>
						<td class="status <?php echo ( $max_input_vars_condition ) ? 'green' : 'red'; ?>"><?php echo ( $max_input_vars_condition ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			// PHP post_max_size
			$php_post_max_size = size_format( wp_convert_hr_to_bytes( @ini_get( 'post_max_size' ) ) );
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'PHP Post Max Size', 'inkpro' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_html_e( 'The largest filesize that can be contained in one post.', 'inkpro' ); ?>" href="https://docs.wolfthemes.com/document/increase-upload-size-limit/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data"><?php echo esc_attr( $php_post_max_size ); ?></td>
						<td class="status">&nbsp;</td>
					</tr>
			<?php
			// Server memory limit
			$php_memory_limit = @ini_get( 'memory_limit' );
			//$php_memory_limit = '12M';
			$required_php_memory_limit = WOLF_REQUIRED_SERVER_MEMORY_LIMIT;
			$php_memory_limit_condition = ( wp_convert_hr_to_bytes( $php_memory_limit ) >= wp_convert_hr_to_bytes( $required_php_memory_limit ) );
			$php_memory_limit_error_message = ( ! $php_memory_limit_condition ) ? ' - ' . sprintf( __( 'It is recommended to increase your server memory limit to %s at least', 'inkpro' ), WOLF_REQUIRED_SERVER_MEMORY_LIMIT ) : '';
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'Server Memory Limit', 'inkpro' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_html_e( 'The maximum amount of memory (RAM) that your server can use at one time.', 'inkpro' ); ?>" href="https://docs.wolfthemes.com/document/increasing-server-memory-limit/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data <?php echo ( $php_memory_limit_condition ) ? 'green' : 'red'; ?>"><?php echo esc_attr( $php_memory_limit . $php_memory_limit_error_message ); ?></td>
						<td class="status <?php echo ( $php_memory_limit_condition ) ? 'green' : 'red'; ?>"><?php echo ( $php_memory_limit_condition ) ? '<span class="dashicons dashicons-yes"></span>' : '<span class="dashicons dashicons-no"></span>'; ?></td>
					</tr>
			<?php
			//  max_upload_size
			$max_upload_size = size_format( wp_max_upload_size() );
			?>
					<tr>
						<td class="label"><?php esc_html_e( 'Max Upload Size', 'inkpro' ); ?></td>
						<td class="help"><a class="hastip" title="<?php esc_html_e( 'The largest filesize that can be uploaded to your WordPress installation.', 'inkpro' ); ?>" href="https://docs.wolfthemes.com/document/increase-upload-size-limit/" target="_blank"><span class="dashicons dashicons-editor-help"></span></a></td>
						<td class="data"><?php echo esc_attr( $max_upload_size ); ?></td>
						<td class="status">&nbsp;</td>
					</tr>
				</table>

				<p><?php
					printf( __( 'Please check the <a target="_blank" href="%s">server requirements</a> recommended by WordPress. You can find more informations <a href="%s" target="_blank">here</a>.', 'inkpro' ),
					'https://wordpress.org/about/requirements/',
					'https://docs.wolfthemes.com/document/server-requirements/'

				) ?></p>
			</div><!-- .wolf-system-status -->

			<?php
			//echo sanitize_text_field( $xml->requires );
			//echo sanitize_text_field( $xml->tested );
			//echo sanitize_text_field( mysql2date( get_option( 'date_format' ), $xml->updated .' 00:00:00' ) );
		}

		/**
		 * Output the last new feature if set in the changelog XML
		 *
		 */
		public function changelog() {
			if ( $xml = wolf_get_theme_changelog() ) {
				?>
				<div id="wolf-notifications">
					<?php if ( '' !== ( string )$xml->warning ) {
						$warning = ( string )$xml->warning;
					?>
						<div class="wolf-changelog-notification" id="wolf-changelog-warning"><?php echo wp_kses_post( $warning ); ?></div>
					<?php } ?>
					<?php if ( '' !== ( string )$xml->info ) {
						$info = ( string )$xml->info;
					?>
						<div class="wolf-changelog-notification" id="wolf-changelog-info"><?php echo wp_kses_post( $info ); ?></div>
					<?php } ?>
					<?php if ( '' !== ( string )$xml->new ) {
						$new = ( string )$xml->new;
					?>
						<div class="wolf-changelog-notification" id="wolf-changelog-news"><?php echo wp_kses_post( $new ); ?></div>
					<?php } ?>
				</div><!-- #wolf-notifications -->
				
				<div id="wolf-changelog">
					<?php echo wp_kses_post( $xml->changelog ); ?>
				</div><!-- #wolf-changelog -->
				<hr>
				<?php
			}
		}

		/**
		 * Sends user to the welcome page on first activation
		 *
		 */
		public function welcome() {
			if ( isset( $_GET['activated'] ) && 'true' == $_GET['activated'] ) {
				flush_rewrite_rules();
				wp_redirect( admin_url( 'admin.php?page=wolf-theme-about&wolf-theme-activated' ) );
				exit;
			}
		}
	}

	if ( WOLF_ENABLE_ABOUT_MESSAGE ) {
		new Wolf_Admin_About_Page();
	}
} // end class exists check