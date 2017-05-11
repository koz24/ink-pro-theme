<?php
/**
 * The post content displayed in the loop for the "standard" display 
 *
 * @package WordPress
 * @subpackage InkPro
 */
$format = get_post_format() ? get_post_format() : 'standard';
$content = get_the_content();
$short_post = ( 'quote' == $format ) || ( 'link' == $format ) || ( 'aside' == $format ) || ( 'status' == $format );
$long_post = ( 'standard' == $format ) || ( 'image' == $format ) || ( 'gallery' == $format ) || ( 'audio' == $format ) || ( 'video' == $format );
$media = inkpro_post_media( true, 'inkpro-thumb' );
$has_tweet = preg_match( inkpro_get_regex( 'twitter' ), $content );
$is_tweet = $has_tweet && ( 'status' == $format );
$is_instagram = ( 'image' == $format ) && preg_match( inkpro_get_regex( 'instagram' ), $content );
?>
<article <?php inkpro_post_attr(); ?> <?php post_class( array( 'entry-display-standard' ) ); ?> <?php inkpro_article_schema(); ?>>
	<?php wolf_post_start(); ?>
	<div class="entry-inner clearfix">
		<?php if ( $short_post && ! $is_tweet ) : ?>
			<div class="entry-content clearfix">
				<div class="entry-summary">
					<div class="entry-summary-inner">
						<?php if ( 'status' ==  $format ) : ?>
							<div class="entry-avatar text-center">
								<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
									<?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
								</a>
							</div><!-- .entry-avatar -->
						<?php endif; ?>
						<div class="entry-text">
							<?php if( 'status' == $format || 'aside' == $format ) : ?>
								<p><?php echo wolf_sample( get_the_excerpt(), 14 ); ?></p>
							<?php else : ?>
								<?php echo inkpro_post_media( true, 'inkpro-thumb' ); ?>
							<?php endif; ?>
						</div><!-- .entry-text -->
					</div><!-- .entry-summary -->
				</div><!-- .entry-summary -->
				<div class="entry-meta">
					<?php inkpro_entry_date(); ?>
					<?php edit_post_link( esc_html__( 'Edit', 'inkpro' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .entry-meta -->
			</div><!-- .entry-content -->
		<?php else : ?>

			<header class="entry-header">
				<?php echo inkpro_post_media(); ?>
			</header><!-- header.entry-header -->
			
			<?php if ( ! post_password_required() && ! $is_tweet & ! $is_instagram ) : ?>
				<div class="entry-content clearfix">
					
					<div class="entry-meta col-4 first">

						<?php inkpro_entry_meta( false ); ?>

						<?php if ( comments_open() ) : ?>
							<span class="comments-link">
								<?php comments_popup_link( '<span class="leave-reply">' . esc_html__( 'Leave a comment', 'inkpro' ) . '</span>', esc_html__( 'One comment so far', 'inkpro' ), esc_html__( 'View all % comments', 'inkpro' ) ); ?>
							</span><!-- .comments-link -->
						<?php endif; // comments_open() ?>
						<?php edit_post_link( esc_html__( 'Edit', 'inkpro' ), '<span class="edit-link">', '</span>' ); ?>

					</div><!-- .entry-meta -->
					
					<div class="entry-summary col-8 last">

						<?php 
							if ( 'post' == get_post_type() ) {
								inkpro_entry_date();
							}
						?>
						<?php inkpro_entry_title(); ?>

						<?php if ( '' != inkpro_no_media_content() ) : ?>
							<div class="post-title-divider"></div>
						<?php endif; ?>
						
						<div class="entry-summary-inner">
							<?php if ( ! is_search() ) : ?>
								<?php echo inkpro_no_media_content(); ?>
							<?php else : ?>
								<?php the_excerpt(); ?>
							<?php endif; ?>
						</div><!-- .entry-summary-inner -->
						<footer class="entry-meta">
							<?php inkpro_entry_icon_meta( true, true, false ); ?>
						</footer><!-- .entry-meta -->
					</div><!-- .entry-summary -->
				</div><!-- .entry-content -->
			<?php endif; ?>
		<?php endif; ?>
	</div><!-- entry-inner -->
</article><!-- article.post -->
