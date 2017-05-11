<?php
/**
 * WolfFramework admin functions
 *
 * @package WordPress
 * @subpackage WolfFramework
 * @author WolfThemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Check if a string is an external URL to prevent hot linking with theme mods/options default values
 *
 * @param string $string
 * @return bool
 */
function wolf_is_external_url( $string ) {

	if ( filter_var( $string, FILTER_VALIDATE_URL ) && parse_url( site_url(), PHP_URL_HOST) != parse_url( $string, PHP_URL_HOST ) ) {
		return parse_url( $string, PHP_URL_HOST );
	}
}

/**
 * Custom admin notice
 *
 * @param string $message
 * @param string $type error|warning|info|success
 * @param string $cookie_id if set a cookie will be use to hide the notice permanently
 */
function wolf_admin_notice( $message = null, $type = null, $cookie_id = null ) {

	if ( ! $message ) {
		return;
	}

	$is_dismissible = ( 'error' == $message ) ? '' : 'is-dismissible';

	if ( $cookie_id ) {

		$dismiss_text = esc_html__( 'Hide permanently', 'inkpro' );

		if ( $cookie_id ) {
			if ( ! isset( $_COOKIE[ $cookie_id ] ) ) {
				echo "<div class='notice notice-$type $is_dismissible'><p>$message<br><a href='#' id='$cookie_id' class='wolf-dismiss-admin-notice'>$dismiss_text</a></p></div>";
			}
		}
	} else {
		echo "<div class='notice notice-$type $is_dismissible'><p>$message</p></div>";
	}
}
add_action( 'admin_notices', 'wolf_admin_notice' );

/**
 * Fetch XML changelog file from remote server
 *
 * Get the theme changelog and cache it in a transient key
 *
 * @return string
 */
function wolf_get_theme_changelog() {

	$xml = null;
	$changelog_url = WOLF_UPDATE_URI . '/' . WOLF_THEME_SLUG .'/changelog.xml';

	if ( WOLF_DEBUG ) {
		$changelog_url = WOLF_THEME_URI . '/pack/changelog/changelog.xml';
	}

	$trans_key = '_wolf_latest_theme_version_' . WOLF_THEME_SLUG;

	// delete_transient( $trans_key );

	if ( false === ( $cached_xml = get_transient( $trans_key ) ) ) {
		
		$response = wp_remote_get( $changelog_url , array( 'timeout' => 10 ) );

		if ( ! is_wp_error( $response ) && is_array( $response ) ) {
			$xml = wp_remote_retrieve_body( $response ); // use the content
		}

		if ( $xml ) {
			set_transient( $trans_key, $xml, WOLF_CACHE_DURATION );
		}
	} else {
		$xml = $cached_xml;
	}

	if ( $xml ) {
		return @simplexml_load_string( $xml );
	}
}

/**
 * Get last changes
 *
 * @return string $last_log
 */
function wolf_get_last_change_from_changelog() {

	$xml = wolf_get_theme_changelog();

	if ( $xml ) {
		$last_log = (string)$xml->new;
		if ( $last_log ) {

			return $last_log;
		}
	}
}

/**
 * Get last changes
 *
 * @return string
 */
function wolf_get_theme_description_from_changelog() {

	$xml = wolf_get_theme_changelog();

	if ( $xml ) {
		$desc = (string)$xml->description;
		if ( $desc ) {

			return $desc;
		}
	}
}


/**
 * Get theme short link
 *
 * @return string
 */
function wolf_get_theme_short_link() {

	$xml = wolf_get_theme_changelog();

	if ( $xml ) {
		$shortlink = (string)$xml->shortlink;
		if ( $shortlink ) {

			return esc_url( $shortlink );
		}
	}
}

/**
 * Get warning from changelog
 *
 * @return string $desc
 */
function wolf_get_theme_update_warning_message() {

	$xml = wolf_get_theme_changelog();

	if ( $xml ) {
		$desc = (string)$xml->warning;
		if ( $desc ) {

			return $desc;
		}
	}
}

/**
 * Display the theme update notification notice
 *
 * @param bool $link
 * @return string
 */
function wolf_theme_update_notification_message( $link = true ) {

	if ( WOLF_UPDATE_NOTICE ) {

		$changelog = wolf_get_theme_changelog();
		$warning = wolf_get_theme_update_warning_message();

		//if ( 1 == 1 ) {
		if ( $changelog && isset( $changelog->latest ) && -1 == version_compare( WOLF_THEME_VERSION, $changelog->latest ) ) {
			$message  = '';
			$message .= '<strong>' . sprintf( esc_html__( 'There is a new version of %s available.', 'inkpro' ),  ucfirst( wolf_get_theme_slug() ) ) . '</strong>';
			$message .= ' ' . sprintf( esc_html__( 'You have version %s installed.', 'inkpro' ),  WOLF_THEME_VERSION );
			$href = admin_url( 'admin.php?page=wolf-theme-update' );

			if ( class_exists( 'Envato_Market' ) ) {
				$href = admin_url( 'admin.php?page=envato-market' );
			}

			if ( $link ) {
				$message .= ' <a href="' . esc_url( $href ) . '">';
			}
				$message .= sprintf( esc_html__( 'Update to version %s', 'inkpro' ),  $changelog->latest );

			if ( $link ) {
				$message .= '</a>';
			}

			if ( $warning ) {
				$message .= '<br>';
				$message .= $warning;
			}

			wolf_admin_notice( $message, 'success', wolf_get_theme_slug() . '_update_notice' );
		}
	}
}

/**
 * Get the content of a file using wp_remote_get
 *
 * Check if file exists in the child theme folder
 * Else check the theme folder
 *
 * @param string $file path from theme folder
 */
function wolf_file_get_contents( $file ) {

	$file = wolf_get_theme_uri( $file );

	if ( $file ) {
		$response = wp_remote_get( $file );
		if ( is_array( $response ) ) {
			return wp_remote_retrieve_body( $response );
		}
	}
}

/**
 * Put content in a file using WP_filesystem
 *
 * @param string $file
 * @param string $content
 */
function wolf_file_put_contents( $file, $content ) {

	if ( function_exists( 'WP_Filesystem' ) ) { // ensure we're in the admin
		WP_Filesystem();
		global $wp_filesystem;
		return $wp_filesystem->put_contents( $file, $content, FS_CHMOD_FILE );
	}
}

/**
 * Add a clickable question mark to help user understand a setting
 *
 * @param string $id
 */
function wolf_help_mark( $id ) {
	return '<span class="hastip" title="' . esc_attr( esc_html__( 'Click to view the screenshot helper', 'inkpro' ) ) . '"><a class="wolf-help-img" href="' . esc_url( WOLF_THEME_URI . '/assets/img/admin/help/' . $id )  . '"><img src="' . esc_url( WOLF_FRAMEWORK_URI . '/assets/img/help.png' ) . '" alt="help"></a></span>';
}