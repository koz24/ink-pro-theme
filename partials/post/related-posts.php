<?php
/**
 * The template for related posts.
 *
 * @package WordPress
 * @subpackage InkPro
 */
global $post;

$post_id = $post->ID;
$post_type = get_post_type();
$do_not_duplicate[] = $post->ID;

if ( 'post' == $terms = get_the_category( $post_id ) ) {
	
	$terms = get_the_category( $post_id );

} elseif ( 'gallery' == $post_type ) {

	$terms = get_the_terms( $post_id, 'gallery_type' );

}

if ( ! empty( $terms ) ) {
	
	$term = array_shift( $terms );

	$args = array(
		'post_type' => $post_type,
		'posts_per_page' => 3,
		'meta_key'    => '_thumbnail_id',
		'post__not_in' => $do_not_duplicate,
		'ignore_sticky_posts' => 1,
	);

	if ( 'post' == $post_type ) {
		
		$args['cat'] = $term->term_id;
	
	} elseif ( 'gallery' == $post_type ) {

		$args['tax_query'] = array(
			array(
				'taxonomy' => 'gallery_type',
				'field' => 'id',
				'terms' => $term->term_id,
			),
		);
	}

	$related_posts_query = null;
	$related_posts_query = new WP_Query( $args );
	if( $related_posts_query->have_posts() ) {
		?>
		<section class="related-posts clearfix">
			<?php while ( $related_posts_query->have_posts() ) : $related_posts_query->the_post(); ?>
				<div class="related-post-container">
					<div class="related-post-inner">
						<?php the_post_thumbnail( 'inkpro-thumb' ); ?>
						<a class="related-post-overlay" href="<?php the_permalink(); ?>">
							<span class="related-post-caption entry-meta">
								<h6 class="entry-title"><?php the_title(); ?></h6>
								<span class="entry-subheading">
									<?php inkpro_the_subheading(); ?>
								</span>
							</span>
						</a>
					</div>
				</div>
			<?php endwhile; ?>
		</section>
	<?php
	}
}
wp_reset_postdata();