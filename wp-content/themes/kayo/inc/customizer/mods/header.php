<?php
/**
 * Kayo header_settings
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

function kayo_set_header_settings_mods( $mods ) {

	$mods['header_settings'] = array(

		'id'      => 'header_settings',
		'title'   => esc_html__( 'Header Layout', 'kayo' ),
		'icon'    => 'editor-table',
		'options' => array(

			'hero_layout'            => array(
				'label'     => esc_html__( 'Page Header Layout', 'kayo' ),
				'id'        => 'hero_layout',
				'type'      => 'select',
				'choices'   => array(
					'standard'   => esc_html__( 'Standard', 'kayo' ),
					'big'        => esc_html__( 'Big', 'kayo' ),
					'small'      => esc_html__( 'Small', 'kayo' ),
					'fullheight' => esc_html__( 'Full Height', 'kayo' ),
					'none'       => esc_html__( 'No header', 'kayo' ),
				),
				'transport' => 'postMessage',
			),

			'hero_background_effect' => array(
				'id'      => 'hero_background_effect',
				'label'   => esc_html__( 'Header Image Effect', 'kayo' ),
				'type'    => 'select',
				'choices' => array(
					'parallax' => esc_html__( 'Parallax', 'kayo' ),
					'zoomin'   => esc_html__( 'Zoom', 'kayo' ),
					'none'     => esc_html__( 'None', 'kayo' ),
				),
			),

			'hero_scrolldown_arrow'  => array(
				'id'      => 'hero_scrolldown_arrow',
				'label'   => esc_html__( 'Scroll Down arrow', 'kayo' ),
				'type'    => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'kayo' ),
					''    => esc_html__( 'No', 'kayo' ),
				),
			),

			array(
				'label'   => esc_html__( 'Header Overlay', 'kayo' ),
				'id'      => 'hero_overlay',
				'type'    => 'select',
				'choices' => array(
					''       => esc_html__( 'Default', 'kayo' ),
					'custom' => esc_html__( 'Custom', 'kayo' ),
					'none'   => esc_html__( 'None', 'kayo' ),
				),
			),

			array(
				'label' => esc_html__( 'Overlay Color', 'kayo' ),
				'id'    => 'hero_overlay_color',
				'type'  => 'color',
				'value' => '#000000',
			),

			array(
				'label' => esc_html__( 'Overlay Opacity (in percent)', 'kayo' ),
				'id'    => 'hero_overlay_opacity',
				'desc'  => esc_html__( 'Adapt the header overlay opacity if needed', 'kayo' ),
				'type'  => 'text',
				'value' => 40,
			),
		),
	);

	if ( class_exists( 'Wolf_Vc_Content_Block' ) ) {
		$mods['header_settings']['options']['hero_layout']['description'] = sprintf(
			kayo_kses(
				/* translators: %s: Content block feature help page link URL */
				__( 'The header can be overwritten by a <a href="%s" target="_blank">content block</a> on all pages or on specific pages. See the customizer "Layout" tab or the page options below your text editor.', 'kayo' )
			),
			'http://wlfthm.es/content-blocks'
		);
	}

	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_set_header_settings_mods' );
