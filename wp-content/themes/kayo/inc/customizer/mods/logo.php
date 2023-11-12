<?php
/**
 * Kayo customizer logo mods
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Logo mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_logo_mods( $mods ) {

	$mods['logo'] = array(
		'id'          => 'logo',
		'title'       => esc_html__( 'Logo', 'kayo' ),
		'icon'        => 'visibility',
		'description' => sprintf(
			wp_kses(
				/* translators: 1: logo width in pixels, 2: logo heigh in pixels, 3: logo max width in pixels */
				__( 'Your theme recommends a logo size of <strong>%1$d &times; %2$d</strong> pixels and set the maximum width to <strong>%3$d</strong> below.', 'kayo' ),
				array(
					'strong' => array(),
				)
			),
			360,
			160,
			180
		),
		'options'     => array(

			'logo_dark'       => array(
				'id'    => 'logo_dark',
				'label' => esc_html__( 'Logo - Dark Version', 'kayo' ),
				'type'  => 'image',
			),

			'logo_light'      => array(
				'id'    => 'logo_light',
				'label' => esc_html__( 'Logo - Light Version', 'kayo' ),
				'type'  => 'image',
			),

			'logo_svg'      => array(
				'id'    => 'logo_svg',
				'label' => esc_html__( 'Logo SVG', 'kayo' ),
				'type'  => 'image',
			),

			'logo_max_width'  => array(
				'id'    => 'logo_max_width',
				'label' => esc_html__( 'Logo Max Width (don\'t ommit px )', 'kayo' ),
				'type'  => 'text',
			),

			'logo_visibility' => array(
				'id'        => 'logo_visibility',
				'label'     => esc_html__( 'Visibility', 'kayo' ),
				'type'      => 'select',
				'choices'   => array(
					'always'      => esc_html__( 'Always', 'kayo' ),
					'sticky_menu' => esc_html__( 'When menu is sticky only', 'kayo' ),
				),
				'transport' => 'postMessage',
			),
		),
	);
	
	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_set_logo_mods' );
