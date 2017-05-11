<?php
/**
 * The main navigation for mobile
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */
?>
<div id="navbar-mobile-container">
	<div id="navbar-mobile" class="navbar clearfix">
		<div id="toggle-close" class="mobile-menu-toggle-button">&times;</div>
		<nav id="site-navigation-primary-mobile" class="navigation main-navigation clearfix" itemscope itemtype="http://schema.org/SiteNavigationElement">
			<?php

			if ( 'centered' == inkpro_get_menu_layout() ) {
				/**
				 * Main navigation for mobile
				 */
				wp_nav_menu(
					array(
						'theme_location' => 'primary-left',
						'menu_class' => 'nav-menu-mobile dropdown',
						'depth'           => 3,
						'walker'         => new Inkpro_Custom_Fields_Nav_Walker(),
						'fallback_cb' => ''
					)
				);

				wp_nav_menu(
					array(
						'theme_location' => 'primary-right',
						'menu_class' => 'nav-menu-mobile dropdown',
						'depth'           => 3,
						'walker'         => new Inkpro_Custom_Fields_Nav_Walker(),
						'fallback_cb' => ''
					)
				);
			
			} else {
				
				wp_nav_menu(
					array(
						'theme_location' 	=> 'primary',
						'menu_class' 		=> 'nav-menu-mobile dropdown',
						'depth'			=> 3,
						'walker'			=> new Inkpro_Custom_Fields_Nav_Walker(),
						'fallback_cb'		=> ''
					)
				);
			}
			
			if ( has_nav_menu( 'secondary' ) ) {
				/**
				 * Top Navigation
				 */
				wp_nav_menu(
					array(
						'theme_location' => 'secondary',
						'menu_class' => 'nav-menu-mobile dropdown',
						//'depth'           => 3,
						'walker'         => new Inkpro_Custom_Fields_Nav_Walker(),
						'fallback_cb' => '',
					)
				);
			}
			?>
		</nav><!-- #site-navigation-primary -->
	</div><!-- #navbar-mobile -->
</div><!-- #navbar-mobile-container -->