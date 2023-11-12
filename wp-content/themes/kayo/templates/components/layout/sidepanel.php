<?php
/**
 * Displays side panel
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

/**
 * Filters the side panel container class
 *
 * @since 1.0.0
 */
$sp_classes = apply_filters( 'kayo_side_panel_class', '' );
?>
<div id="side-panel" class="side-panel <?php echo esc_attr( $sp_classes ); ?>">
	<div class="side-panel-inner">
		<?php
			/**
			 * Side panel start hook
			 *
			 * @since 1.0.0
			 */
			do_action( 'kayo_sidepanel_start' );

		if ( kayo_get_theme_mod( 'sidepanel_content_block_id' ) ) {

			echo '<div id="side-panel-block" class="sidebar-container sidebar-side-panel">';
			echo '<div class="sidebar-inner">';
			echo ( function_exists( 'kayo_get_block' ) ) ? kayo_get_block( kayo_get_theme_mod( 'sidepanel_content_block_id' ) ) : ''; // phpcs:ignore
			echo '</div>';
			echo '</div>';

		} else {
			get_sidebar( 'side-panel' );
		}
		?>
	</div><!-- .side-panel-inner -->
</div><!-- .side-panel -->
