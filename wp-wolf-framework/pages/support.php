<?php
/**
 * Redirect the user to the Support Forum with javascript
 *
 * @since 1.4.1
 * @package WolfFramework
 * @author WolfThemes
 */
?>
<div class="wrap"><?php esc_html_e( 'Redirection...', 'inkpro' ); ?></div>
<script type="text/javascript">
	//<![CDATA[
	window.location.replace("<?php echo esc_url( WOLF_SUPPORT_URL . '/' ); ?>");
	//]]>
</script>