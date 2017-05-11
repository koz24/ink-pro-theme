<?php
/**
 * The Content of the widget areas
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( inkpro_is_woocommerce() ) : ?>

	<?php dynamic_sidebar( 'woocommerce' ); ?>

<?php else : ?>

	<?php if ( function_exists( 'wolf_sidebar' ) ) : ?>

		<?php wolf_sidebar(); ?>

	<?php else : ?>

		<?php dynamic_sidebar( 'sidebar-page' ); ?>

	<?php endif; ?>

<?php endif; ?>