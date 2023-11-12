<?php
/**
 * WPBakery Page Builder Extension Theme functions
 *
 * Theme specific functions to use on frontend
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Templates
 * @version 3.2.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Remove scripts
 */
function wvc_remove_vc_scripts() {

	$theme_slug = sanitize_title_with_dashes( get_template() );

	// Remove script and styles that we don't need in the theme
	if ( wvc_is_right_theme() ) {

		// Scripts
		wp_dequeue_script( 'swipebox' );
		wp_deregister_script( 'swipebox' );

		// Styles
		wp_dequeue_style( 'swipebox' );
		wp_deregister_style( 'swipebox' );
	}

}
add_action( 'wp_enqueue_scripts', 'wvc_remove_vc_scripts', 100 );