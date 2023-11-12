<?php
/**
 * Kayo Socials
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Social services mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_socials_mods( $mods ) {

	if ( function_exists( 'wvc_get_socials' ) || function_exists( 'wolf_core_get_socials' ) ) {

		$socials = array();

		if ( function_exists( 'wvc_get_socials' ) ) {

			$socials = wvc_get_socials();

		} elseif ( function_exists( 'wolf_core_get_socials' ) ) {

			$socials = wolf_core_get_socials();
		}

		$mods['socials'] = array(
			'id'      => 'socials',
			'title'   => esc_html__( 'Social Networks', 'kayo' ),
			'icon'    => 'share',
			'options' => array(),
		);

		foreach ( $socials as $social ) {
			$mods['socials']['options'][ $social ] = array(
				'id'    => $social,
				'label' => ucfirst( $social ),
				'type'  => 'text',
			);
		}
	}

	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_set_socials_mods' );
