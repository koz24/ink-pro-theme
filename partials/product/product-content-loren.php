<?php
/**
 * The product content displayed in the loop for the "grid" display 
 *
 * @package WordPress
 * @subpackage InkPro
 */
?>
<?php woocommerce_template_loop_product_link_open(); ?>

<div class="product-thumbnail-container">
	<?php woocommerce_show_product_loop_sale_flash(); ?>
	<?php woocommerce_template_loop_product_thumbnail(); ?>
	<?php inkpro_woocommerce_second_product_thumbnail(); ?>
	<div class="product-title-container">
		<?php woocommerce_template_loop_product_title(); ?>
		<?php woocommerce_template_loop_rating(); ?>
	</div>
</div>

<?php woocommerce_template_loop_product_link_close(); ?>

<?php woocommerce_template_loop_price(); ?>

<?php woocommerce_template_loop_add_to_cart(); ?>

<?php inkpro_add_to_wishlist(); ?>