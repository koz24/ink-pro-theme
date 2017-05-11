<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage InkPro
 * @since 1.0.0
 * @version 2.0.3
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<!-- Meta Tags -->
	<?php wolf_meta_head(); ?>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wolf_head(); ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wolf_body_start(); ?>
<div class="site-container">
<?php wolf_site_content_start(); ?>
	<div id="page" class="hfeed site">
		<div id="page-content">

		<?php wolf_header_before(); ?>
		<header id="masthead" class="site-header clearfix" itemscope itemtype="http://schema.org/WPHeader">
			<?php wolf_header_start(); ?>

			<p class="site-name" itemprop="headline"><?php echo get_bloginfo( 'name' ); ?></p><!-- .site-name -->
			<p class="site-description" itemprop="description"><?php echo get_bloginfo( 'description' ); ?></p><!-- .site-description -->

			<?php wolf_header_end(); ?>
		</header><!-- #masthead -->

		<?php wolf_header_after(); ?>

			<?php wolf_content_before(); ?>
			<div id="main" class="site-main clearfix">
				<div class="site-content">
					<?php wolf_content_start(); ?>
					<div class="content-inner">
						<div class="content-wrapper">