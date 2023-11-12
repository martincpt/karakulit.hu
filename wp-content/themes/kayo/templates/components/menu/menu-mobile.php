<?php
/**
 * The main navigation for mobile
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

if ( ! kayo_do_onepage_menu() ) {

	if ( has_nav_menu( 'mobile' ) ) {

		wp_nav_menu(
			array(
				'theme_location' => 'mobile',
				'menu_class'     => 'nav-menu nav-menu-mobile',
				'menu_id'        => 'site-navigation-mobile-mobile',
			)
		);

	} else {
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'menu_class'     => 'nav-menu nav-menu-mobile',
				'menu_id'        => 'site-navigation-primary-mobile',
			)
		);
	}
}

