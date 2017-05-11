<?php
/**
 * The template for the search form overlay
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
<div id="top-search-form-container">
	<div id="top-search-form" class="table">
		<div class="table-cell">
			<?php get_search_form(); ?>
		</div>
	</div><!--#top-search-form-->
	<span id="close-search"></span>
</div><!--#top-search-form-container-->