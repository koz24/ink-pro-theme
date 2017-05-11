<?php
/**
 * The template for the WooCommerce search form in the desktop navigation
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div id="menu-product-search-form-container">
	<?php get_product_search_form(); ?>
	<span id="product-search-form-loader" class="fa fa-circle-o-notch fa-spin"></span>
	<span id="close-product-search-form" class="close-product-search-form">&times;</span>
</div><!-- #menu-product-search-form-container -->
