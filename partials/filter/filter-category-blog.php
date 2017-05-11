<?php
/**
 * The Portfolio category filter
 *
 * @author WpWolf
 * @package WolfPortfolio/Templates
 * @since 1.1.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$cat_args = array(
	'taxonomy' 	=> 'category',
	'orderby'      	=> 'slug',
	'show_count'  	=> 0,
	'pad_counts'   => 0,
	'hierarchical' 	=> 0,
	'title_li'     	=> '',
);

$current_tax_slug = null;
$cat = get_categories( $cat_args );
$active_class = ( inkpro_is_blog_index() ) ? 'active' : '';

if ( is_category() ) {

	// if the category blog display is different, no filter
	if ( wolf_get_theme_mod( 'blog_display', 'standard' ) != inkpro_get_blog_display() ) {
		return;
	}

	$current_cat_query = get_query_var('cat');
	$current_cat = get_category( $current_cat_query );
	$current_tax_slug = $current_cat->slug;
}

if ( $cat != array() ) :
?>
<div id="blog-filter-container">
	<ul id="blog-filter">
		<li><a data-url="<?php echo esc_url( inkpro_get_blog_url() ); ?>" data-filter="masonry-item" class="<?php echo sanitize_html_class( $active_class ); ?>" href="<?php echo esc_url( inkpro_get_blog_url() ); ?>"><?php esc_html_e( 'All', 'inkpro' ); ?></a></li>
	<?php foreach ( $cat as $c ) : ?>
		<?php if ( 0 != $c->count ) : ?>
			<li>
				<a data-url="<?php echo esc_url( get_category_link( $c->term_id ) ); ?>" class="<?php if ( $current_tax_slug == $c->slug ) echo 'active'; ?>" data-filter="<?php echo sanitize_title( $c->slug ); ?>" href="<?php echo esc_url( get_category_link( $c->term_id ) ); ?>"><?php echo sanitize_text_field( $c->name ); ?></a>
			</li>
		<?php endif; ?>
	<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>