<?php
/**
 * Displays centered logo navigation type
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */
?>
<div id="nav-bar" class="nav-bar" data-menu-layout="centered-logo">
	<div class="flex-wrap">
		<?php
		if ( 'left' === kayo_get_inherit_mod( 'side_panel_position' ) && kayo_can_display_sidepanel() ) {
			/**
			 * Output sidepanel hamburger
			 */
			do_action( 'kayo_sidepanel_hamburger' );
		}
		?>
		<nav class="menu-container" itemscope="itemscope"  itemtype="https://schema.org/SiteNavigationElement">
			<?php
				/**
				 * Menu
				 */
				kayo_primary_desktop_navigation();
			?>
		</nav><!-- .menu-container -->
		<div class="cta-container"><?php
				/**
				 * Secondary menu hook
				 */
				do_action( 'kayo_secondary_menu', 'desktop' );
		?></div><!-- .cta-container -->
		<?php
		if ( 'right' === kayo_get_inherit_mod( 'side_panel_position' ) && kayo_can_display_sidepanel() ) {
			/**
			 * Output sidepanel hamburger
			 */
			do_action( 'kayo_sidepanel_hamburger' );
		}
		?>
	</div><!-- .flex-wrap -->
</div><!-- #navbar-container -->
