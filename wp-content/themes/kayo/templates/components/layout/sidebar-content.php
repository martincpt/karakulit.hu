<?php
/**
 * Displays sidebar content
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

if ( kayo_is_woocommerce_page() ) {

	dynamic_sidebar( 'sidebar-shop' );

} else {

	if ( function_exists( 'wolf_sidebar' ) ) {

		wolf_sidebar();

	} else {

		dynamic_sidebar( 'sidebar-page' );
	}
}
