<?php
/**
 * Kayo admin theme update functions
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Update theme version
 *
 * Compare and update theme version and fire update hook to do stuff if needed
 */
function kayo_update() {

	$theme_version = kayo_get_theme_version();
	$theme_slug    = kayo_get_theme_slug();

	if ( ! defined( 'IFRAME_REQUEST' ) && ! defined( 'DOING_AJAX' ) && ( get_option( $theme_slug . '_version' ) !== $theme_version ) ) {

		/**
		 * Update hook
		 * 
		 * @since Kayo 1.0.0 
		 */
		do_action( 'kayo_do_update' );

		/**
		 * Update version
		 */
		delete_option( $theme_slug . '_version' );
		add_option( $theme_slug . '_version', $theme_version );

		/**
		 * After update hook
		 * 
		 * @since Kayo 1.0.0
		 */
		do_action( 'kayo_updated' );
	}
}
add_action( 'admin_init', 'kayo_update', 0 );

/**
 * Fetch XML changelog file from remote server
 *
 * Get the theme changelog and cache it in a transient key
 *
 * @return string
 */
function kayo_get_theme_changelog() {

	$xml           = null;
	$update_url    = 'http://updates.wolfthemes.com';
	$changelog_url = $update_url . '/' . kayo_get_theme_slug() . '/changelog.xml';
	$trans_key     = '_latest_theme_version_' . kayo_get_theme_slug();

	$cached_xml = get_transient( $trans_key );

	if ( false === $cached_xml ) {

		$response = wp_remote_get( $changelog_url, array( 'timeout' => 10 ) );

		if ( ! is_wp_error( $response ) && is_array( $response ) ) {
			$xml = wp_remote_retrieve_body( $response );
			set_transient( $trans_key, $xml, 6 * HOUR_IN_SECONDS );
		}
	} else {
		$xml = $cached_xml;
	}

	if ( $xml ) {
		return @simplexml_load_string( $xml );
	}
}

/**
 * Display the theme update notification notice fro important update
 */
function kayo_update_notification_message() {

	$changelog             = kayo_get_theme_changelog();
	$cookie_name           = kayo_get_theme_slug() . '_update_notice';
	$message               = '';
	$is_envato_plugin_page = ( isset( $_GET['page'] ) && 'envato-market' === sanitize_title( wp_unslash( $_GET['page'] ) ) );

	/* Stop if update is not critical and the update notification is disabled */
	if ( $changelog && isset( $changelog->updatenotification ) && 'no' === (string) $changelog->updatenotification ) {
		return;
	}

	if ( $changelog && isset( $changelog->latest ) && -1 == version_compare( kayo_get_parent_theme_version(), $changelog->latest ) && ! $is_envato_plugin_page ) {

		$class = 'kayo-admin-notice notice notice-info is-dismissible';

		$message .= '<p>';
		
		$message .= sprintf(
			kayo_kses(
				/* translators: 1: parent theme name 2: parent theme version */
				__( 'There is a new version of <strong>%1$s</strong> available. You have version %2$s installed. It is recommended to update.', 'kayo' )
			),
			kayo_get_parent_theme_name(),
			kayo_get_parent_theme_version()
		);
		$message .= '</p>';
		$href   = ( class_exists( 'Envato_Market' ) ) ? admin_url( 'update-core.php' ) : 'https://wolfthemes.ticksy.com/article/11658/';
		$target = ( class_exists( 'Envato_Market' ) ) ? '_parent' : '_blank';

		$message .= '<p>';
		$message .= '<a class="button button-primary kayo-admin-notice-button" href="' . esc_url( $href ) . '" target="' . esc_attr( $target ) . '">';
		/* translators: %s: the latest theme version available */
		$message .= sprintf( esc_html__( 'Update to version %s', 'kayo' ), $changelog->latest );
		$message .= '</a>';

		$message .= ' <a id="' . esc_attr( $cookie_name ) . '" class="button kayo-dismiss-admin-notice" href="#">';
		$message .= esc_html__( 'Hide update notices permanently', 'kayo' );
		$message .= '</a>';
		$message .= '</p>';

		if ( ! isset( $_COOKIE[ $cookie_name ] ) ) {
			printf( '<div class="%1$s">%2$s</div>', esc_attr( $class ), kayo_kses( $message ) );
		}
	}
}
add_action( 'admin_notices', 'kayo_update_notification_message' );


/**
 * Display the info notice for important message
 */
function kayo_info_notification_message() {

	$changelog = kayo_get_theme_changelog();
	$info      = ( $changelog && isset( $changelog->info ) ) ? (string) $changelog->info : null;
	$cookie_id = kayo_get_theme_slug() . '_info_notice';
	$message   = '';

	if ( $info ) {
		kayo_admin_notice( $info, 'info', $cookie_id, esc_html__( 'Dismiss this notice', 'kayo' ) );
	}

}
add_action( 'admin_notices', 'kayo_info_notification_message' );
