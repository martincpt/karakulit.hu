<?php
/**
 * Displays mobile navigation
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */
?>
<div id="mobile-bar" class="nav-bar">
	<div class="flex-mobile-wrap">
		<div class="logo-container">
			<?php
				/**
				 * Logo
				 */
				kayo_logo();
			?>
		</div><!-- .logo-container -->
		<div class="cta-container">
		<?php
				/**
				 * Secondary menu hook
				 *
				 * @since 1.0.0
				 */
				do_action( 'kayo_secondary_menu', 'mobile' );
		?>
		</div><!-- .cta-container -->
		<div class="hamburger-container">
			<?php
				/**
				 * Menu hamburger icon
				 */
				kayo_hamburger_icon( 'toggle-mobile-menu' );
			?>
		</div><!-- .hamburger-container -->
	</div><!-- .flex-wrap -->
</div><!-- #navbar-container -->
