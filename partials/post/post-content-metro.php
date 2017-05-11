<?php
/**
 * The post content displayed in the loop for the "metro" display
 *
 * @package WordPress
 * @subpackage InkPro
 */
$post_id = get_the_ID();
$rand = rand( 1, 99999 );
$format = get_post_format() ? get_post_format() : 'standard';
$class = array( 'metro-item', 'entry-display-metro' );
$link = inkpro_get_first_url();
$permalink = ( 'link' == $format && $link ) ? $link : get_permalink();
$metro_thumbnail_size = get_post_meta( $post_id, '_single_post_metro_thumbnail_size', true );

$bg = wolf_get_post_thumbnail_url( 'large' );

if ( $metro_thumbnail_size ) {
	if ( 'big-square' == $metro_thumbnail_size ) {

		$class[] = 'metro-item-width2';
		$class[] = 'metro-item-height2';

	} elseif( 'portrait' == $metro_thumbnail_size ) {

		$class[] = 'metro-item-height2';
		$class[] = 'metro-item-standard-width';

	} elseif( 'landscape' == $metro_thumbnail_size ) {

		$class[] = 'metro-item-width2';

	} else {

		$class[] = 'metro-item-basic';
		$class[] = 'metro-item-standard-width';
	}

} else {

	if ( $post_id == inkpro_get_last_post_id() ) {

		$class[] = 'metro-item-width2';
		$class[] = 'metro-item-height2';

	} elseif( 'image' == $format ) {

		$class[] = 'metro-item-height2';
		$class[] = 'metro-item-standard-width';

	} elseif( 'gallery' == $format ) {

		$class[] = 'metro-item-width2';
	} else {

		$class[] = 'metro-item-basic';
		$class[] = 'metro-item-standard-width';
	}
}
?>
<?php if ( $bg ) : ?>
	<article <?php inkpro_post_attr(); ?> <?php inkpro_article_schema(); ?> <?php post_class( $class ); ?>>
		<?php wolf_post_start(); ?>
		<div class="post-metro-container">
			<?php
				if ( is_sticky() && ! is_paged() ) {
					echo '<span class="sticky-post">' . esc_html__( 'Featured', 'inkpro' ) . '</span>';
				}
			?>
			<a href="<?php echo esc_url( $permalink ); ?>" class="entry-thumbnail entry-link post-metro-container-entry-link">
				<span style="background-image:url(<?php echo esc_url( $bg ); ?>);" id="post-metro-cover-<?php echo absint( $rand ); ?>" class="post-metro-cover"></span>
				<div class="post-metro-title-container">
					<div class="post-metro-title-inner">
						<div class="post-metro-content">
							<h2 class="entry-title">
								<?php echo get_the_title( $post_id ); ?>
							</h2>
							<span class="post-metro-entry-meta">
								<?php
									/**
									 * Display categories
									 */
									if ( 'post' == get_post_type( $post_id ) ) {

										echo strip_tags( get_the_category_list( esc_html__( ', ', 'inkpro' ) ) );

									} elseif( 'work' == get_post_type( $post_id ) ) {

										echo strip_tags( get_the_term_list( $post_id, 'work_type', '', esc_html__( ', ', 'inkpro' ), '' ) );
									}
								?>
							</span><!-- .post-metro-entry-meta -->
						</div><!-- .post-metro-content -->
					</div><!-- .post-metro-title-inner -->
				</div><!-- .post-metro-title-container -->
			</a><!-- .post-metro-container-entry-link -->
		</div><!-- .post-metro-container -->
	</article><!-- article.post -->
<?php endif; ?>