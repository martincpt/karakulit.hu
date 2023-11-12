<?php
/**
 * The main navigation for desktop
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

if ( ! kayo_do_onepage_menu() ) {
	wp_nav_menu(
		array(
			'theme_location' => 'primary',
			'menu_id'        => 'site-navigation-primary-desktop',
			'menu_class'     => 'nav-menu nav-menu-desktop',
		)
	);
}
