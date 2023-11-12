<?php
/**
 * The sidebar containing the overlay menu panel widget areas.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

if ( is_active_sidebar( 'sidebar-overlay-menu-panel-top' ) ) : ?>
	<div class="sidebar-container sidebar-overlay-menu-panel-top" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
		<div class="sidebar-inner">
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-overlay-menu-panel-top' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-inner -->
	</div><!-- #tertiary .sidebar-container -->
<?php endif; ?>
