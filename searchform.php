<?php
/**
 * The template for displaying search forms
 *
 * @package WordPress
 * @subpackage InkPro
 * @since 1.0.0
 * @version 2.0.3
 */
?>
<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<input type="search" class="field" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo wolf_get_theme_option( 'search_placeholder_text', esc_html__( 'Enter your search', 'inkpro' ) ); ?>" />
	<input type="submit" class="searchsubmit" value="<?php esc_html_e( 'Search', 'inkpro' ); ?>" />
</form>