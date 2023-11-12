<?php
/**
 * The main navigation for vertical menus
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

if ( ! kayo_do_onepage_menu() ) {

	if ( has_nav_menu( 'vertical' ) ) {

		wp_nav_menu(
			array(
				'theme_location' => 'vertical',
				'menu_class'     => 'nav-menu nav-menu-vertical',
				'menu_id'        => 'site-navigation-vertical-vertical',
			)
		);

	} else {
		wp_nav_menu(
			array(
				'theme_location' => 'primary',
				'menu_class'     => 'nav-menu nav-menu-vertical',
				'menu_id'        => 'site-navigation-primary-vertical',
			)
		);
	}
}

