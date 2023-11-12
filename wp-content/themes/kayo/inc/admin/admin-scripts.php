<?php
/**
 * Kayo admin scripts
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Admin scripts
 */
function kayo_admin_scripts() {

	$suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : kayo_get_theme_version();

	/* Admin styles */
	wp_enqueue_style( 'chosen', get_template_directory_uri() . '/assets/js/admin/chosen/chosen.min.css', array(), '1.1.0' );
	wp_enqueue_style( 'kayo-admin', get_template_directory_uri() . '/assets/css/admin/admin' . $suffix . '.css', array(), $version );

	/* Admins scripts */
	wp_enqueue_media();
	wp_enqueue_script( 'chosen', get_template_directory_uri() . '/assets/js/admin/chosen/chosen.jquery.min.js', array( 'jquery' ), '1.1.0', true );
	wp_enqueue_script( 'js-cookie', get_template_directory_uri() . '/assets/js/lib/js.cookie.min.js', array( 'jquery' ), '1.4.1', true );

	if ( isset( $_GET['page'] ) && ( sanitize_title( wp_unslash( $_GET['page'] ) ) === kayo_get_theme_slug() . '-about' ) ) {
		wp_enqueue_script( 'kayo-tabs', get_template_directory_uri() . '/assets/js/admin/tabs.js', array( 'jquery' ), $version, true );
	}

	wp_enqueue_script( 'kayo-admin', get_template_directory_uri() . '/assets/js/admin/admin.js', array( 'jquery', 'jquery-ui-sortable', 'wp-color-picker' ), $version, true );

	/*
	* Check the uer capabilities to avoid enabling the customizer reset button in guest mod with Customizer Preview for Theme Demo plugin
	*/
	if ( current_user_can( 'manage_options' ) && apply_filters( 'kayo_customizer_rest_button', true ) ) { // phpcs:ignore
		wp_enqueue_script( 'kayo-reset-customizer-button', get_template_directory_uri() . '/assets/js/admin/reset-customizer-button' . $suffix . '.js', array( 'jquery' ), $version, true );
	}

	wp_localize_script(
		'kayo-admin',
		'KayoAdminParams',
		array(
			'ajaxUrl'               => esc_url( admin_url( 'admin-ajax.php' ) ),
			'noResult'              => esc_html__( 'No result', 'kayo' ),
			'resetModsText'         => esc_html__( 'Reset', 'kayo' ),
			'subHeadingPlaceholder' => esc_html__( 'Subheading', 'kayo' ),
			/**
			 * Filters customizer reset button condition
			 *
			 * @since 1.0.0
			 */
			'customizerResetButton' => apply_filters( 'kayo_customizer_rest_button', true ),
			'confirm'               => esc_html__( 'Are you sure to want to reset all mods to default? There is no way back.', 'kayo' ),
			'nonce'                 => array(
				'reset' => wp_create_nonce( 'kayo-customizer-reset' ),
			),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'kayo_admin_scripts' );

/**
 * Additional custom CSS
 *
 * @see kayo_get_theme_uri
 */
function kayo_admin_custom_css() {

	$css = '';

	$accent = get_theme_mod( 'accent_color' );

	if ( $accent ) {
		$css .= "
			.accent{
				color:$accent;
			}

			.wvc_colored-dropdown .accent{
				background-color:$accent;
				color:#fff;
			}

			.wolf_core_colored-dropdown .accent{
				background-color:$accent;
				color:#fff;
			}
		";
	}

	if ( is_file( get_template_directory() . '/config/badge.png' ) ) {

		$badge_url = get_template_directory_uri() . '/config/badge.png';

		$css .= "
			.kayo-about-page-logo{
				background-image: url($badge_url)!important;
			}
		";
	}

	if ( ! SCRIPT_DEBUG ) {
		/**
		 * Filter CSS output to allow adding more
		 *
		 * @since Kayo 1.0.0
		 */
		$css = kayo_compact_css( apply_filters( 'kayo_admin_custom_css', $css ) );
	}

	wp_add_inline_style( 'kayo-admin', $css );
}
add_action( 'admin_enqueue_scripts', 'kayo_admin_custom_css' );
