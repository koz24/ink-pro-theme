<?php
/**
 * The category filter
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */
?>
<?php
	if ( ! inkpro_do_ajax_category_filter() ) {
		return;
	}

	if ( inkpro_is_blog() ) {

		get_template_part( 'partials/filter/filter', 'category-blog' );

	} elseif ( inkpro_is_portfolio() ) {

		wolf_portfolio_get_template( 'filter.php' );
	}
?>