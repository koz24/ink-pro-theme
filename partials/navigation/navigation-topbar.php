<?php
/**
 * The top bar navigation
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */
?>
<div id="topbar">
	<div class="wrap">
		<div id="topbar-left">
			<?php
				if ( wolf_get_theme_mod( 'topbar_content' ) ) {
					echo '<span id="topbar-text">';
					echo wp_kses_post( wolf_get_theme_mod( 'topbar_content' ) );
					echo '</span>';
				}
			?>
		</div>
		<div id="topbar-right" class="topbar-menu-container">
			<?php
				if ( has_nav_menu( 'secondary' ) ) {
					/**
					 * Top Navigation
					 */
					wp_nav_menu(
						array(
							'theme_location' => 'secondary',
							'menu_id' => 'top-nav',
							'menu_class' => 'nav-menu-secondary inline-list',
							//'depth'           => 3,
							'walker'         => new Inkpro_Custom_Fields_Nav_Walker(),
							'fallback_cb' => '',
						)
					);
				} else {
					echo '&nbsp;';
				}
			?>
		</div>
	</div>
</div>
