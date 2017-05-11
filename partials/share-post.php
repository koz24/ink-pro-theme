<?php
/**
 * Share links
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */
?>
<div class="share-box clearfix">
	<div class="share-box-inner clearfix">
		<div class="share-box-title">
			<span class="share-title"><?php echo wolf_get_theme_option( 'share_text' ); ?></span>
		</div><!-- .share-box-title -->
		<div class="share-box-icons">
			<?php if ( wolf_get_theme_option( 'share_facebook' ) ) : ?>
				<a data-popup="true" data-width="580" data-height="320" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>&amp;t=<?php echo urlencode( get_the_title() ); ?>" class="fa fa-facebook share-link share-link-with-text share-link-facebook" title="<?php printf( esc_html__( 'Share on %s', 'inkpro' ), ucfirst( 'facebook' ) ); ?>"><span class="share-link-text"><?php esc_html_e( 'Facebook', 'inkpro' ); ?></span></a>
			<?php endif; ?>
			<?php if ( wolf_get_theme_option( 'share_twitter' ) ) : ?>
				<a data-popup="true" href="http://twitter.com/home?status=<?php echo urlencode( get_the_title() ) . ' - ' . urlencode( get_permalink() ); ?>" class="fa fa-twitter share-link share-link-with-text share-link-twitter" title="<?php printf( esc_html__( 'Share on %s', 'inkpro' ), ucfirst( 'twitter' ) ); ?>"><span class="share-link-text"><?php esc_html_e( 'Twitter', 'inkpro' ); ?></span></a>
			<?php endif; ?>
			<?php if ( wolf_get_theme_option( 'share_pinterest' ) ) : ?>
				<a data-popup="true" data-width="580" data-height="300" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode( get_permalink() ); ?>&amp;media=<?php echo wolf_get_post_thumbnail_url( 'XL' ); ?>&amp;description=<?php echo urlencode( get_the_title() ); ?>" class="fa fa-pinterest share-link share-link-pinterest" title="<?php printf( esc_html__( 'Share on %s', 'inkpro' ), ucfirst( 'pinterest' ) ); ?>"><span class="share-link-text"><?php esc_html_e( 'Pinterest', 'inkpro' ); ?></span></a>
			<?php endif; ?>
			<?php if ( wolf_get_theme_option( 'share_google' ) ) : ?>
				<a data-popup="true" data-height="500" href="https://plus.google.com/share?url=<?php echo urlencode( get_permalink() ); ?>" class="fa fa-google-plus share-link share-link-google" title="<?php printf( esc_html__( 'Share on %s', 'inkpro' ), ucfirst( 'google plus' ) ); ?>"><span class="share-link-text"><?php esc_html_e( 'Google Plus', 'inkpro' ); ?></span></a>
			<?php endif; ?>
			<?php if ( wolf_get_theme_option( 'share_tumblr' ) ) : ?>
				<a data-popup="true" href="http://tumblr.com/share/link?url=<?php echo urlencode( get_permalink() ); ?>&amp;name=<?php echo urlencode( get_the_title() ); ?>" class="fa fa-tumblr share-link share-link-tumblr" title="<?php printf( esc_html__( 'Share on %s', 'inkpro' ), ucfirst( 'tumblr' ) ); ?>"><span class="share-link-text"><?php esc_html_e( 'Tumblr', 'inkpro' ); ?></span></a>
			<?php endif; ?>
			<?php if ( wolf_get_theme_option( 'share_stumbleupon' ) ) : ?>
				<a data-popup="true" data-width="800" data-height="600" href="http://www.stumbleupon.com/submit?url=<?php echo urlencode( get_permalink() ); ?>&amp;title=<?php echo urlencode( get_the_title() ); ?>" class="fa fa-stumbleupon share-link share-link-stumbleupon" title="<?php printf( esc_html__( 'Share on %s', 'inkpro' ), ucfirst( 'stumbleupon' ) ); ?>"><span class="share-link-text"><?php esc_html_e( 'StumbleUpon', 'inkpro' ); ?></span></a>
			<?php endif; ?>
			<?php if ( wolf_get_theme_option( 'share_linkedin' ) ) : ?>
				<a data-popup="true" data-height="380" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode( get_permalink() ); ?>&amp;title=<?php echo urlencode( get_the_title() ); ?>" class="fa fa-linkedin share-link share-link-linkedin" title="<?php printf( esc_html__( 'Share on %s', 'inkpro' ), ucfirst( 'linkedin' ) ); ?>"><span class="share-link-text"><?php esc_html_e( 'LinkedIn', 'inkpro' ); ?></span></a>
			<?php endif; ?>
			<?php if ( wolf_get_theme_option( 'share_mail' ) ) : ?>
				<a data-popup="true" href="mailto:?subject=<?php echo urlencode( get_the_title() ); ?>&amp;body=<?php echo urlencode( get_permalink() ); ?>" class="fa fa-envelope share-link share-link-email" title="<?php printf( esc_html__( 'Share by %s', 'inkpro' ), ucfirst( 'email' ) ); ?>"><span class="share-link-text"><?php esc_html_e( 'Email', 'inkpro' ); ?></span></a>
			<?php endif; ?>
		</div><!-- .share-box-icons -->
	</div><!-- .share-box-inner -->
</div><!-- .share-box -->