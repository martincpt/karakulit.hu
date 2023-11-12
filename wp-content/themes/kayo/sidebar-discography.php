<?php
/**
 * The sidebar containing the discography widget areas
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

if ( ! kayo_display_sidebar() ) { // see inc/frontend/conditional-functions.php.
	return;
}
?>
<div id="secondary" class="sidebar-container sidebar-discography" role="complementary" itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
	<div class="sidebar-inner">
		<div class="widget-area">
			<?php dynamic_sidebar( 'sidebar-discography' ); ?>
		</div><!-- .widget-area -->
	</div><!-- .sidebar-inner -->
</div><!-- #secondary .sidebar-container -->
