<?php
/**
 * Kayo Frontend Styles
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Remove plugin styles
 * Allow an easier customization
 */
function kayo_dequeue_plugin_styles() {
	wp_dequeue_style( 'wolf-portfolio' );
	wp_deregister_style( 'wolf-portfolio' );
	wp_dequeue_style( 'wolf-videos' );
	wp_deregister_style( 'wolf-videos' );
	wp_dequeue_style( 'wolf-albums' );
	wp_deregister_style( 'wolf-albums' );
	wp_dequeue_style( 'wolf-discography' );
	wp_deregister_style( 'wolf-discography' );
	wp_dequeue_style( 'wolf-events' );
	wp_deregister_style( 'wolf-events' );
	wp_dequeue_style( 'wolf-share' );
	wp_deregister_style( 'wolf-share' );
	wp_dequeue_style( 'fancybox' );
	wp_deregister_style( 'fancybox' );
}
add_action( 'wp_enqueue_scripts', 'kayo_dequeue_plugin_styles' );

if ( ! function_exists( 'kayo_enqueue_styles' ) ) {
	/**
	 * Enqueue CSS stylsheets
	 * JS scripts are separated and can be found in inc/scripts.php
	 */
	function kayo_enqueue_styles() {

		$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : kayo_get_theme_version();

		/**
		 * Filters the lightbox option
		 *
		 * @since 1.0.0
		 */
		$lightbox = apply_filters( 'kayo_lightbox', kayo_get_theme_mod( 'lightbox', 'fancybox' ) );

		/*
		* Register Icon files
		*/
		wp_register_style( 'font-awesome', get_template_directory_uri() . '/assets/css/lib/fonts/fontawesome/font-awesome.min.css', array(), kayo_get_theme_version() );
		wp_register_style( 'socicon', get_template_directory_uri() . '/assets/css/lib/fonts/socicon/socicon.min.css', array(), kayo_get_theme_version() );
		wp_register_style( 'linea-icons', get_template_directory_uri() . '/assets/css/lib/fonts/linea-icons/linea-icons.min.css', array(), kayo_get_theme_version() );
		wp_register_style( 'linearicons', get_template_directory_uri() . '/assets/css/lib/fonts/linearicons/linearicons.min.css', array(), kayo_get_theme_version() );

		/* Flickity */
		wp_register_style( 'flickity', get_template_directory_uri() . '/assets/css/lib/flickity.min.css', array(), '2.3.0' );

		wp_enqueue_style( 'font-awesome' );
		wp_enqueue_style( 'socicon' );
		wp_enqueue_style( 'linea-icons' );
		wp_enqueue_style( 'linearicons' );

		if ( is_singular( 'product' ) ) {
			wp_enqueue_style( 'flickity' );
		}

		if ( is_singular( 'artist' ) ) {
			wp_enqueue_style( 'wolficons' );
		}

		/* Media elements (for AJAX processed content) */
		wp_enqueue_style( 'wp-mediaelement' );

		/* WordPress icon library */
		wp_enqueue_style( 'dashicons' );

		/*
		 * normalize.css
		 * @link https://necolas.github.io/normalize.css/
		 */
		wp_enqueue_style( 'normalize', get_template_directory_uri() . '/assets/css/lib/normalize.min.css', array(), '3.0.0' );

		/*
		 * animate.css
		 * @link https://daneden.github.io/animate.css/
		 */
		wp_register_style( 'aos', get_template_directory_uri() . '/assets/css/lib/aos.css', array(), '2.3.0' );

		/*
		 * FlexSlider
		 * @link https://github.com/woocommerce/FlexSlider
		 */
		wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/assets/css/lib/flexslider/flexslider.min.css', array(), '2.6.3' );

		/* Enqueue custom flexslider style if Wolf Plugin not activated, else use the plugin flexslider style in the design */
		if ( ! kayo_is_wolf_extension_activated() ) {

			wp_enqueue_style( 'flexslider-custom', get_template_directory_uri() . '/assets/css/flexslider-custom.css', array(), $version );
		}

		if ( 'fancybox' === $lightbox ) {
			/*
			* jQuery fancybox
			* http://fancyapps.com/fancybox/3/
			*/
			wp_enqueue_style( 'fancybox', get_template_directory_uri() . '/assets/css/lib/jquery.fancybox.min.css', array(), '3.5.2' );

		} elseif ( 'swipebox' === $lightbox ) {
			/*
			* jQuery swipebox
			* http://brutaldesign.github.io/swipebox/
			*/
			wp_enqueue_style( 'swipebox', get_template_directory_uri() . '/assets/css/lib/swipebox.min.css', array(), '1.3.0' );
		}

		$suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : kayo_get_theme_version();
		if ( defined( 'AUTOPTIMIZE_PLUGIN_DIR' ) ) {
			$suffix = '';
		}
		wp_enqueue_style( 'kayo-style', get_template_directory_uri() . '/assets/css/main' . $suffix . '.css', array(), $version );
		wp_enqueue_style( 'kayo-single-post-style', get_template_directory_uri() . '/assets/css/single-post.css', array(), $version );
		wp_enqueue_style( 'kayo-default', get_stylesheet_uri(), array(), kayo_get_theme_version() );
	}
	add_action( 'wp_enqueue_scripts', 'kayo_enqueue_styles' );
}

/**
 * Enqueue CSS stylsheets
 * JS scripts are separated and can be found in inc/scripts.php
 */
function kayo_enqueue_vc_fontawesome() {

	if ( function_exists( 'vc_icon_element_fonts_enqueue' ) ) {
		vc_icon_element_fonts_enqueue( 'fontawesome' );
	}
}
add_action( 'init', 'kayo_enqueue_vc_fontawesome' );
