<?php
/**
 * Wolf Core theme related functions
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'Wolf_Core' ) ) {
	return;
}

if ( ! defined( 'WPB_VC_VERSION' ) && ! did_action( 'elementor/loaded' ) ) {
	return;
}

/**
 * Add theme accent color to shared colors
 *
 * @param array $colors The colors array options.
 * @return array
 */
function kayo_add_accent_color_option( $colors ) {

	$colors = array( 'accent' => esc_html__( 'Theme Accent Color', 'kayo' ) ) + $colors;

	return $colors;
}
add_filter( 'wolf_core_elementor_colors', 'kayo_add_accent_color_option', 14 );

/**
 * Filter theme accent color
 *
 * @param string $color The color to filter.
 * @return string
 */
function kayo_set_theme_accent_color( $color ) {
	return kayo_get_inherit_mod( 'accent_color' );
}
add_filter( 'wolf_core_theme_accent_color', 'kayo_set_theme_accent_color' );
