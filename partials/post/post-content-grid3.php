<?php
/**
 * The post content displayed in the loop for the "grid3" display 
 *
 * @package WordPress
 * @subpackage InkPro
 */
$format = get_post_format() ? get_post_format() : 'standard';
$thumb_size = 'inkpro-portrait';
$cat_list = '';
$classes = array( 'post-grid3-entry', 'entry-display-grid3' );
$post_id = get_the_ID();
if ( get_the_category( $post_id ) ) {
	foreach ( get_the_category( $post_id ) as $cat ) {
		$classes[] = $cat->slug .' ';
	}
}
?>
<?php if ( has_post_thumbnail() ) : ?>
	<article <?php inkpro_post_attr(); ?> <?php post_class( $classes ); ?> <?php inkpro_article_schema(); ?>>
		<?php wolf_post_start(); ?>
		<div class="post-grid3-entry-inner">
			<?php
				if ( is_sticky() && ! is_paged() ) {
					echo '<span class="sticky-post">' . esc_html__( 'Featured', 'inkpro' ) . '</span>';
				}
			?>
			<a href="<?php the_permalink(); ?>" class="entry-thumbnail entry-link">
				<?php the_post_thumbnail( $thumb_size, array( 'itemprop' => 'image' ) ); ?>
			
				<?php if ( ! post_password_required() ) : ?>
					<div class="post-grid3-entry-content">
						<div class="post-grid3-entry-caption">
							<?php if ( inkpro_get_first_category() ) : ?>
								<span class="post-grid3-category"><?php echo sanitize_text_field( inkpro_get_first_category() ); ?></span>
							<?php endif; ?>
							<h2 class="entry-title">
								<?php the_title(); ?>
							</h2>
						</div>
					</div><!-- .post-grid3-entry-content -->
				<?php endif; ?>
			</a>
		</div><!-- .post-grid3-entry-inner -->
	</article><!-- article.post -->
<?php endif; ?>