<?php
/**
 * The product content displayed in the loop for the "list" display
 *
 * @package WordPress
 * @subpackage InkPro
 */
?>
<div class="clearfix">
	<div class="product-image col-5 first">
		<?php woocommerce_template_loop_product_link_open(); ?>
			<div class="product-thumbnail-container">
				<?php woocommerce_show_product_loop_sale_flash(); ?>
				<?php woocommerce_template_loop_product_thumbnail(); ?>
				<?php inkpro_woocommerce_second_product_thumbnail(); ?>
			</div>
		<?php woocommerce_template_loop_product_link_close(); ?>
	</div>

	<div class="product-content col-7 last">
		<h3 class="entry-title">
			<a href="<?php the_permalink(); ?>" class="entry-link">
				<?php the_title(); ?>
			</a>
		</h3>


		<?php woocommerce_template_loop_rating(); ?>
		<?php woocommerce_template_loop_price(); ?>

		<div class="product-description" itemprop="description">
			<?php echo apply_filters( 'woocommerce_short_description', get_the_excerpt() ); ?>
		</div>

		<?php woocommerce_template_loop_add_to_cart(); ?>

		<?php inkpro_add_to_wishlist(); ?>
	</div>
</div>

