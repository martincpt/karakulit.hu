<?php
/**
 * Kayo admin activation
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Hook WWPBPBE plugin activation to save theme fonts in plugins settings
 *
 * Import the default fonts from the theme in the page builder settings
 *
 * @param array $settings The WVC settings array.
 */
function kayo_set_page_builder_default_google_fonts( $settings ) {

	/* Get theme fonts */
	$theme_google_font_option = kayo_get_option( 'fonts', 'google_fonts' );

	if ( $theme_google_font_option ) {

		$settings['fonts']['google_fonts'] = $theme_google_font_option;
	}

	return $settings;
}
add_filter( 'wvc_default_settings', 'kayo_set_page_builder_default_google_fonts' );
add_filter( 'wolf_core_default_settings', 'kayo_set_page_builder_default_google_fonts' );

/**
 * Get all social networks URL from plugin if plugin is installed before the theme
 *
 * @param array $mods The theme mods.
 * @return array $mods
 */
function kayo_set_default_social_networks( $mods ) {

	if ( function_exists( 'wvc_get_socials' ) ) {
		$wvc_socials = wvc_get_socials();

		foreach ( $wvc_socials as $service ) {
			$link = wolf_vc_get_option( 'socials', $service );

			if ( $link ) {
				set_theme_mod( $service, $link );
			}
		}
	}

	if ( function_exists( 'wolf_core_get_socials' ) ) {
		$wolf_core_socials = wolf_core_get_socials();

		foreach ( $wolf_core_socials as $service ) {
			$link = wolf_core_get_option( 'socials', $service );

			if ( $link ) {
				set_theme_mod( $service, $link );
			}
		}
	}

	return $mods;
}
add_filter( 'kayo_default_mods', 'kayo_set_default_social_networks' );

/**
 * Define WooCommerce image sizes on theme activation
 *
 * Can be overwritten with the kayo_woocommerce_thumbnail_sizes filter
 */
function kayo_woocommerce_image_sizes() {

	global $pagenow;

	if ( ! isset( $_GET['activated'] ) || 'themes.php' !== $pagenow ) { // phpcs:ignore WordPress.Security.NonceVerification
		return;
	}

	/* Enable ajax cart by default */
	update_option( 'woocommerce_enable_ajax_add_to_cart', 'yes' );

	/* Disable WooCommerce lightbox so we can handle it */
	update_option( 'woocommerce_enable_lightbox', 'no' );
}
add_action( 'after_switch_theme', 'kayo_woocommerce_image_sizes', 1 );

/**
 * Set default WP options on theme activation
 */
function kayo_default_wp_options_init() {

	if ( ! get_option( kayo_get_theme_slug() . '_wp_options_init' ) ) {

		/**
		 * A custom hook to set default options on theme activation
		 * 
		 * @since Kayo 1.0.0
		 */
		do_action( 'kayo_wp_default_options_init' );

		/**
		 * Another custom hook to set default 3rd party plugin options on theme activation
		 * 
		 * @since Kayo 1.0.0
		 */
		do_action( 'kayo_plugins_default_options_init' );

		/* Default WP options */
		update_option( 'image_default_link_type', 'file' );

		/* Add option to flag that the default mods have been set */
		add_option( kayo_get_theme_slug() . '_wp_options_init', true );

		update_option( 'wpb_js_gutenberg_disable', true );
	}
}
add_action( 'init', 'kayo_default_wp_options_init' );

/**
 * Set default Tribe Event plugin option
 */
function kayo_tribe_event_activation_hook() {

	$tribe_event_option = ( get_option( 'tribe_events_calendar_options' ) ) ? get_option( 'tribe_events_calendar_options' ) : array();

	$tribe_event_option['stylesheet_mode'] = 'skeleton';

	update_option( 'tribe_events_calendar_options', $tribe_event_option );
}
register_activation_hook( __FILE__, 'kayo_tribe_event_activation_hook' );
