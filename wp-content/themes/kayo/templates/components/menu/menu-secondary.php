<?php
/**
 * The secondary main navigation
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

wp_nav_menu(
		array(
			'theme_location' => 'secondary',
			'menu_id'        => 'site-navigation-secondary-desktop',
			'menu_class'     => 'nav-menu nav-menu-desktop',
		)
	);
