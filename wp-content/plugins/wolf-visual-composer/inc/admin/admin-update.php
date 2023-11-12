<?php
/**
 * Perform data process on update if needed
 *
 * @package WordPress
 * @subpackage WPBakery Page Builder Extension
 * @version 3.2.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Update gradient slugs
 */
function wvc_update_gradient_slugs() {
	//esc_html__( 'Gradient Red', 'wolf-visual-composer' ) => 'gradient-red',
	//esc_html__( 'Gradient Green', 'wolf-visual-composer' ) => 'gradient-green',
	//esc_html__( 'Gradient Green Circle', 'wolf-visual-composer' ) => 'gradient-green-circle',

	$pages = get_pages();

	foreach ( $pages as $page ) {

		$page_id = $page->ID;
		$old_content = $page->post_content;

		$new_content = str_replace(
			array(
				'gradient-red',
				'gradient-green',
				'gradient-green-circle',
			),
			array(
				'gradient-color-3452ff',
				'gradient-color-105898',
				'gradient-color-111420',
			),
			$old_content
		);

		$updated_post = array(
			'ID' => $page_id,
			'post_content' => $new_content,
		);

		//var_dump( $new_content );

		wp_update_post( $updated_post );
	}
}

/**
 * Update interactive link attribute
 */
function wvc_update_interactive_links() {
	$pages = get_pages();

	$_attrs_regex = '[a-zA-ZŽžšŠÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçČčÌÍÎÏìíîïÙÚÛÜùúûüÿÑñйА-я= {}0-9#@|\%_\.:;,+\/\/\?!\'%&€^¨°¤£$§~()`*"-]+';
	$_all_regex = '(.*?)';

	foreach ( $pages as $page ) {

		$page_id = $page->ID;

		$page_id = $page->ID;
		$content = $page->post_content;

		$content = preg_replace_callback( '/\[wvc_interactive_link_item ' . $_attrs_regex . '\]/', function( $matches ) {

			$output = '';

			foreach ( $matches as $shortcode ) {
				$parsed_shortcode = shortcode_parse_atts( $shortcode );
				$args = str_replace( array( '[wvc_interactive_link_item', ']' ), '', $shortcode );
				$attrs = shortcode_parse_atts( $args );
				$string_to_replace = '';

				if ( isset( $attrs['image'] ) && $attrs['image'] ) {
					$string_to_replace = 'image="' . $attrs['image'] . '"';
					$output .= str_replace( $string_to_replace, 'add_overlay="yes" background_type="image" background_img="' . $attrs['image'] . '"', $shortcode );
				}
			}

			return $output;

		}, $content );

		// update post
		$updated_post = array(
			'ID' => $page_id,
			'post_content' => $content,
		);

		wp_update_post( $updated_post );
	}
}

//wvc_update_interactive_links();

/**
 * Do update
 */
function wvc_update_stuffs() {
	$current_version = get_option( 'wolf_vc_version' );
	
	if ( version_compare( $current_version, '1.3.8', '<' ) ) {
		wvc_update_gradient_slugs();
	}

	if ( version_compare( $current_version, '2.3.0', '<' ) ) {
		//wvc_update_interactive_links();
	}

	if ( version_compare( $current_version, '2.5.3', '<' ) && wolf_vc_get_option( 'modal_window', 'delay' ) ) {
		$pop_up_delay =  wolf_vc_get_option( 'modal_window', 'delay' );
		wvc_update_option( 'modal_window', 'delay', $pop_up_delay / 1000 );
	}

	if ( version_compare( $current_version, '2.8.8', '<' ) ) {
		if ( ! get_transient( 'wvc_activation_notice' ) && ! get_option( 'wvc_activation_notice_set' ) ) {
			set_transient( 'wvc_activation_notice', true, 30 * DAY_IN_SECONDS );
			add_option( 'wvc_activation_notice_set' );
		}
	}
}
add_action( 'wolf_vc_do_update', 'wvc_update_stuffs' );