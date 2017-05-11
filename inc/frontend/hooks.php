<?php
/**
 * InkPro hook functions
 *
 * Inject content through template hooks
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Site page hooks
 */
include_once( 'hooks/site-page-hooks.php' );

/**
 * Navigation hooks
 */
include_once( 'hooks/navigation-hooks.php' );

/**
 * Posts hooks
 */
include_once( 'hooks/post-hooks.php' );

/**
 * Plugin hooks
 */
include_once( 'hooks/plugin-hooks.php' );