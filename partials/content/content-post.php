<?php
/**
 * The post content displayed in the loop
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */
$blog_display = ( 'sidebar' == inkpro_get_blog_display() ) ? 'standard' : inkpro_get_blog_display();
get_template_part( 'partials/post/post-content', $blog_display );