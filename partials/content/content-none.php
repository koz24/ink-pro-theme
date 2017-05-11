<?php
/**
 * The template for displaying a "No posts found" message.
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */
?>
<article class="page">

	<header class="entry-header">
		<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'inkpro' ); ?></h1>
	</header><!-- .page-header -->
	
	<div class="entry-content nothing-found">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
	
			<p>
				<?php printf(
				wp_kses(
					__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'inkpro' ), 
					array( 'a' => array( 'href' => array() ) )
				),
				admin_url( 'post-new.php' ) ); ?>
			</p>
	
		<?php elseif ( is_search() ) : ?>
	
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with different keywords.', 'inkpro' ); ?></p>
			<?php get_search_form(); ?>
			<div class="clear"></div>
			<?php inkpro_top_tags( esc_html__( 'Most used tags : ', 'inkpro' ) ); ?>
	
		<?php else : ?>
	
			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'inkpro' ); ?></p>
			<?php get_search_form(); ?>
			<div class="clear"></div>
			<?php inkpro_top_tags( esc_html__( 'Most used tags : ', 'inkpro' ) ); ?>
	
		<?php endif; ?>
	</div><!-- .page-content -->
</article>