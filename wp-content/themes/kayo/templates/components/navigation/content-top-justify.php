<?php
/**
 * Displays top justify navigation type
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */
?>
<div id="nav-bar" class="nav-bar" data-menu-layout="top-justify">
	<div class="flex-wrap">
		<?php
		if ( 'left' === kayo_get_inherit_mod( 'side_panel_position' ) && kayo_can_display_sidepanel() ) {
			/**
			 * Output sidepanel hamburger
			 *
			 * @since 1.0.0
			 */
			do_action( 'kayo_sidepanel_hamburger' );
		}
		?>
		<div class="logo-container">
			<?php
				/**
				 * Logo
				 */
				kayo_logo();
			?>
		</div><!-- .logo-container -->
		<nav class="menu-container" itemscope="itemscope"  itemtype="https://schema.org/SiteNavigationElement">
			<?php
				/**
				 * Menu
				 */
				kayo_primary_desktop_navigation();
			?>
		</nav><!-- .menu-container -->
		<div class="cta-container">
		<?php
				/**
				 * Secondary menu hook
				 *
				 * @since 1.0.0
				 */
				do_action( 'kayo_secondary_menu', 'desktop' );
		?>
		</div><!-- .cta-container -->
		<?php
		if ( 'right' === kayo_get_inherit_mod( 'side_panel_position' ) && kayo_can_display_sidepanel() ) {
			/**
			 * Output sidepanel hamburger
			 *
			 * @since 1.0.0
			 */
			do_action( 'kayo_sidepanel_hamburger' );
		}
		?>
	</div><!-- .flex-wrap -->
</div><!-- #navbar-container -->
