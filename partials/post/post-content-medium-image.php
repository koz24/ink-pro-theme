<?php
/**
 * The post content displayed in the loop for the "medium image" display 
 *
 * @package WordPress
 * @subpackage InkPro
 */
$format = get_post_format() ? get_post_format() : 'standard';
$content = get_the_content();
$bg = wolf_get_post_thumbnail_url( 'large' );
$short_post = ( 'quote' == $format ) || ( 'link' == $format ) || ( 'aside' == $format ) || ( 'status' == $format );
$long_post = ( 'standard' == $format ) || ( 'image' == $format ) || ( 'gallery' == $format ) || ( 'audio' == $format ) || ( 'video' == $format );
$has_tweet = preg_match( inkpro_get_regex( 'twitter' ), $content );
$is_tweet = $has_tweet && ( 'status' == $format );
$is_instagram = ( 'image' == $format ) && preg_match( inkpro_get_regex( 'instagram' ), $content );
$media = inkpro_post_media( false, 'inkpro-thumb' );
?>
<article <?php inkpro_post_attr(); ?> <?php inkpro_article_schema(); ?> <?php post_class( array( 'clearfix', 'entry-display-medium-image' ) ); ?> data-bg="<?php echo esc_url( $bg ); ?>">
	<?php wolf_post_start(); ?>
	<div class="entry-inner clearfix">
		<?php if ( ( $long_post || $is_tweet ) && $media ) : ?>
			<header class="entry-header">
				<div class="post-media-container">
					<?php echo inkpro_post_media( true, 'inkpro-thumb' ); ?>
				</div><!-- .post-media-container -->
			</header><!-- header.entry-header -->
		<?php endif; ?>

		<?php if ( ! post_password_required() && ! $is_tweet && ! $is_instagram ) : ?>
			<div class="entry-content clearfix">
				<?php if ( ! $short_post  ): ?>
					<?php inkpro_entry_title(); ?>
				<?php endif; ?>
				
				<div class="entry-summary">
					<div class="entry-summary-inner">
						
						<?php if ( 'status' ==  $format ) : ?>
							<div class="entry-avatar text-center">
								<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
									<?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
								</a>
							</div><!-- .entry-avatar -->
						<?php endif; ?>

						<div class="entry-meta">
							<?php if ( $short_post ) : ?>
								<?php inkpro_entry_meta( true, false, false, false ); // display date only ?>
							<?php else : ?>
								<?php inkpro_entry_meta( true, false, true ); // display date, cat and tags ?>
							<?php endif;  ?>
						</div><!-- .entry-meta -->
						
						<div class="entry-text" itemprop="text">
	
							<?php if ( 'quote' == $format || 'link' == $format ) : ?>	
								
								<?php echo inkpro_post_media( false, 'inkpro-thumb' ); ?>

							<?php elseif ( 'status' == $format || 'aside' == $format  ) : ?>
							
								<p><?php echo inkpro_get_the_excerpt( 50 ); ?></p>

							<?php else : ?>

								<p>
									<?php echo inkpro_get_the_excerpt(); ?>
									&nbsp;<?php echo inkpro_more_button( 'more-link-medium-image-text' ); ?>
								</p>
							
							<?php endif; ?>
						</div><!-- .entry-text -->
						
					</div><!-- .entry-summary-inner -->
				</div><!-- .entry-summary -->

				<footer class="entry-meta">
					<?php inkpro_entry_meta( false, true, false, false ); // display author only ?>
					<?php inkpro_entry_icon_meta(); ?>
					<?php edit_post_link( esc_html__( 'Edit', 'inkpro' ), '<span class="edit-link">', '</span>' ); ?>
				</footer><!-- .entry-meta -->
			</div><!-- .entry-content -->
		<?php endif; ?>
		<div class="clear"></div>
	</div><!-- entry-inner -->
</article><!-- article.post -->