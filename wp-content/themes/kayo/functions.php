<?php
/**
 * Kayo functions and definitions
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package    WordPress
 * @subpackage Kayo
 * @version    1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sets up theme defaults and registers support for various WordPress features using the KAYO function
 *
 * @see inc/framework.php
 */
function kayo_setup_config() {
	/**
	 *  Require the wolf themes framework core file
	 */
	include_once get_template_directory() . '/inc/framework.php';

	/**
	 * Set theme main settings
	 *
	 * We this array to configure the main theme settings
	 */
	$kayo_settings = array(

		/* Menus */
		'menus'       => array(
			'primary'   => esc_html__( 'Primary Menu', 'kayo' ),
			'secondary' => esc_html__( 'Secondary Menu', 'kayo' ),
			'mobile'    => esc_html__( 'Mobile Menu (optional)', 'kayo' ),
		),

		/**
		 *  We define wordpress thumbnail sizes that we will use in our design
		 */
		'image_sizes' => array(

			/**
			 * Create custom image sizes if the Wolf WPBakery Page Builder extension plugin is not installed
			 * We will use the same image size names to avoid duplicated image sizes in the case the plugin is active
			 */
			'kayo-photo'         => array( 500, 500, false ),
			'kayo-metro'         => array( 550, 999, false ),
			'kayo-masonry'       => array( 500, 2000, false ),
			'kayo-masonry-small' => array( 400, 400, false ),
			'kayo-XL'            => array( 1920, 3000, false ),
		),
	);

	KAYO( $kayo_settings ); // let's go.
}
kayo_setup_config();
