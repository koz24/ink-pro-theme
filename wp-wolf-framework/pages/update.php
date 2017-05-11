<?php
/**
 * Check for update
 * Display update Instruction if the theme is not up to date
 *
 * @since 1.3.5
 * @package WolfFramework
 * @author WolfThemes
 */
?>
<div class="wrap">
	<h2><?php esc_html_e( 'Theme Updates', 'inkpro' ); ?></h2>

	<?php
	$parent_theme = wolf_get_theme_slug();

if ( $xml = wolf_get_theme_changelog() ) {

	if ( -1 == version_compare( WOLF_THEME_VERSION, $xml->latest ) ) {
	// if ( 1 == 1 ) {

		$content_folder = str_replace( network_site_url(), '', get_template_directory_uri() );

		?>
		<div id="message" class="updated">
			<p><strong><?php printf( esc_html__( 'There is a new version of %s available.', 'inkpro' ),  ucfirst( $parent_theme ) ); ?></strong>
				<?php printf( esc_html__( 'You have version %s installed.', 'inkpro' ),  WOLF_THEME_VERSION ); ?>
				<?php printf( esc_html__( 'Update to version %s', 'inkpro' ),  $xml->latest ); ?>
			</p>
		</div>
 		<img style="width:200px;float:left;margin:0 20px 10px 0;border:1px solid #ddd;" src="<?php echo esc_url( WOLF_THEME_URI . '/screenshot.png' ); ?>" alt="screenshot" />
 		<h3><?php esc_html_e( 'Update Download and Instructions', 'inkpro' ); ?></h3>

		<p><?php printf( wp_kses( __(  '<strong>Important :</strong> make a backup of the %1$s theme inside your WordPress installation folder %2$s before attempting to update.', 'inkpro' ), array( 'strong' => array() ) ),  $parent_theme, '<code>' . $content_folder . '</code>' ); ?></p>
		<p><?php printf( esc_html__( 'To update the %s theme, login to your ThemeForest account, go to your downloads section and re-download the theme as you did when you purchased it.', 'inkpro' ),  $parent_theme ); ?></p>

		<?php // Child ?>
		<p><?php esc_html_e( 'If you didn\'t make any changes to the theme files, you are free to overwrite them with the new files without risk of losing your theme settings.', 'inkpro' ); ?></p>
		<p><?php printf( wp_kses( __( 'If you want to edit the theme files it is recommended to create a <a href="%s" target="_blank">child theme</a>.', 'inkpro' ), array( 'a' => array( 'href' => array() ) ) ), 'http://codex.wordpress.org/Child_Themes' ); ?></p>
		<br>

 		<?php // FTP instruction ?>
		<h4><?php esc_html_e( 'Update through FTP', 'inkpro' ); ?></h4>
		<p><?php printf( wp_kses( __( 'Extract the zip\'s contents, find the <strong>%1$s</strong> theme folder, and upload the new files using your FTP client to the %2$s folder. This will overwrite the old files.', 'inkpro' ), array( 'strong' => array() ) ), $parent_theme,  '<code>' . $content_folder . '</code>' ); ?></p>
		<p><?php esc_html_e( 'If you encounter any issue after update, remove all old files before uploading the new ones.', 'inkpro' ); ?></p>
		<?php


	} else {
		?>
		<p><?php printf(
			esc_html__( 'The %1$s theme is currently up to date at version %2$s', 'inkpro' ), $parent_theme, WOLF_THEME_VERSION
		); ?></p>
		<?php
	}
	?>
	<hr>
	<div id="wolf-notifications">
		<?php if ( '' !== ( string )$xml->warning ) {
			$warning = ( string )$xml->warning;
		?>
			<div class="wolf-changelog-notification" id="wolf-changelog-warning"><?php echo wp_kses_post( $warning ); ?></div>
		<?php } ?>
		<?php if ( '' !== ( string )$xml->info ) {
			$info = ( string )$xml->info;
		?>
			<div class="wolf-changelog-notification" id="wolf-changelog-info"><?php echo wp_kses_post( $info ); ?></div>
		<?php } ?>
		<?php if ( '' !== ( string )$xml->new ) {
			$new = ( string )$xml->new;
		?>
			<div class="wolf-changelog-notification" id="wolf-changelog-news"><?php echo wp_kses_post( $new ); ?></div>
		<?php } ?>
	</div><!-- #wolf-notifications -->
	
	<div id="wolf-changelog">
		<h3><?php esc_html_e( 'Changelog', 'inkpro' ); ?></h3>
		<?php echo wp_kses( $xml->changelog, array(
			'h4' => array(),
			'ul' => array(),
			'ol' => array(),
			'li' => array(),
			'strong' => array(),
		) ); ?>
	</div><!-- #wolf-changelog -->
	<hr>
	
	<div id="wolf-theme-details">
		<h3><?php esc_html_e( 'Details', 'inkpro' ); ?></h3>
		<p><?php esc_html_e( 'Requires', 'inkpro' ); ?> : Wordpress <?php echo sanitize_text_field( $xml->requires ); ?></p>
		<p><?php esc_html_e( 'Tested', 'inkpro' ); ?> : Wordpress <?php echo sanitize_text_field( $xml->tested ); ?></p>
		<p><?php esc_html_e( 'Last update', 'inkpro' ); ?> : <?php echo sanitize_text_field( mysql2date( get_option( 'date_format' ), $xml->date .' 00:00:00' ) ); ?></p>
	</div>
	<?php
} else {
	echo '<p>';
	esc_html_e( 'Unable to load the changelog', 'inkpro' );
	echo '</p>';
}
?></div>