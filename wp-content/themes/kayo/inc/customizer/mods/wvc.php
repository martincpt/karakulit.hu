<?php
/**
 * Kayo Page Builder
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * WPBAkery Page Builder Extension plugin mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_wvc_mods( $mods ) {

	if ( class_exists( 'Wolf_Visual_Composer' ) ) {
		$mods['blog']['options']['newsletter'] = array(
			'id'          => 'newsletter_form_single_blog_post',
			'label'       => esc_html__( 'Add newsletter form below single post', 'kayo' ),
			'type'        => 'checkbox',
			'description' => esc_html__( 'Display a newsletter sign up form at the bottom of each blog post.', 'kayo' ),
		);

	}

	if ( class_exists( 'Wolf_Core' ) ) {
		$mods['blog']['options']['newsletter'] = array(
			'id'          => 'newsletter_form_single_blog_post',
			'label'       => esc_html__( 'Add newsletter form below single post', 'kayo' ),
			'type'        => 'checkbox',
			'description' => esc_html__( 'Display a newsletter sign up form at the bottom of each blog post.', 'kayo' ),
		);

	}

	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_set_wvc_mods' );
