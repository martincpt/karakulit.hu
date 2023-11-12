<?php
/**
 * Theme configuration file
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

/**
 * Default Google fonts option
 */
function kayo_set_default_google_font() {
	return 'Nunito+Sans:400,500,700,900';
}
add_filter( 'kayo_default_google_fonts', 'kayo_set_default_google_font' );

/**
 * Set color scheme
 *
 * Add csutom color scheme
 *
 * @param array $color_scheme
 * @param array $color_scheme
 */
function kayo_set_color_schemes( $color_scheme ) {

	//unset( $color_scheme['default'] );

	$color_scheme['light'] = array(
		'label'  => esc_html__( 'Light', 'kayo' ),
		'colors' => array(
			'#fff', // body_bg
			'#fff', // page_bg
			'#fff', // submenu_background_color
			'#000', // submenu_font_color
			'#000', // '#c3ac6d', // accent
			'#444444', // main_text_color
			'#4c4c4c', // secondary_text_color
			'#0d0d0d', // strong_text_color
			'#999289', // secondary accent
		)
	);

	$color_scheme['dark'] = array(
		'label'  => esc_html__( 'Dark', 'kayo' ),
		'colors' => array(
			'#1B1B1B', // body_bg
			'#232322', // page_bg
			'#000000', // submenu_background_color
			'#ffffff', // submenu_font_color
			'#3bc4d4', // accent
			'#f4f4f4', // main_text_color
			'#ffffff', // secondary_text_color
			'#ffffff', // strong_text_color
			'#999289', // secondary accent
		)
	);

	return $color_scheme;
}
add_filter( 'kayo_color_schemes', 'kayo_set_color_schemes' );

/**
 * Add additional theme support
 */
function kayo_additional_theme_support() {

	/**
	 * Enable WooCommerce support
	 */
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'kayo_additional_theme_support' );

/**
 * Set default WordPress option
 */
function kayo_set_default_wp_options() {

	update_option( 'medium_size_w', 500 );
	update_option( 'medium_size_h', 286 );

	update_option( 'thread_comments_depth', 2 );
}
add_action( 'kayo_default_wp_options_init', 'kayo_set_default_wp_options' );

/**
 * Set mod files to include
 */
function kayo_customizer_set_mod_files( $mod_files ) {
	$mod_files = array(
		'loading',
		'logo',
		'layout',
		'colors',
		'navigation',
		'socials',
		'fonts',
		'header',
		'header-image',
		'blog',
		'videos',
		'discography',
		'events',
		'shop',
		'portfolio',
		'background-image',
		'footer',
		'footer-bg',
		'wvc',
	);

	return $mod_files;
}
add_filter( 'kayo_customizer_mod_files', 'kayo_customizer_set_mod_files' );
