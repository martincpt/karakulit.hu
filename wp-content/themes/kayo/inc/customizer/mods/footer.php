<?php
/**
 * Kayo footer
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Footer mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_footer_mods( $mods ) {

	$mods['footer'] = array(

		'id'      => 'footer',
		'title'   => esc_html__( 'Footer', 'kayo' ),
		'icon'    => 'welcome-widgets-menus',
		'options' => array(

			'footer_type'    => array(
				'label'     => esc_html__( 'Footer Type', 'kayo' ),
				'id'        => 'footer_type',
				'type'      => 'select',
				'choices'   => array(
					'standard' => esc_html__( 'Standard', 'kayo' ),
					'uncover'  => esc_html__( 'Uncover', 'kayo' ),
					'hidden'   => esc_html__( 'No Footer', 'kayo' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label'     => esc_html__( 'Footer Width', 'kayo' ),
				'id'        => 'footer_layout',
				'type'      => 'select',
				'choices'   => array(
					'boxed' => esc_html__( 'Boxed', 'kayo' ),
					'wide'  => esc_html__( 'Wide', 'kayo' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label'     => esc_html__( 'Foot Widgets Layout', 'kayo' ),
				'id'        => 'footer_widgets_layout',
				'type'      => 'select',
				'choices'   => array(
					'none'                 => esc_html__( 'Unset', 'kayo' ),
					'3-cols'               => esc_html__( '3 Columns', 'kayo' ),
					'4-cols'               => esc_html__( '4 Columns', 'kayo' ),
					'one-half-two-quarter' => esc_html__( '1 Half/2 Quarters', 'kayo' ),
					'two-quarter-one-half' => esc_html__( '2 Quarters/1 Half', 'kayo' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label'     => esc_html__( 'Bottom Bar Layout', 'kayo' ),
				'id'        => 'bottom_bar_layout',
				'type'      => 'select',
				'choices'   => array(
					'centered' => esc_html__( 'Centered', 'kayo' ),
					'inline'   => esc_html__( 'Inline', 'kayo' ),
				),
				'transport' => 'postMessage',
			),

			'footer_socials' => array(
				'id'          => 'footer_socials',
				'label'       => esc_html__( 'Socials', 'kayo' ),
				'type'        => 'text',
				'description' => esc_html__( 'The list of social services to display in the bottom bar. (eg: facebook,twitter,instagram)', 'kayo' ),
			),

			'copyright'      => array(
				'id'    => 'copyright',
				'label' => esc_html__( 'Copyright Text', 'kayo' ),
				'type'  => 'text',
			),
		),
	);

	if ( class_exists( 'Wolf_Vc_Content_Block' ) ) {
		$mods['footer']['options']['footer_type']['description'] = sprintf(
			kayo_kses(
				/* translators: %s: Content block feature help page link URL */
				__( 'This is the default footer settings. You can leave the fields below empty and use a <a href="%s" target="_blank">content block</a> instead for more flexibility. See the customizer "Layout" tab or the page options below your text editor.', 'kayo' )
			),
			'http://wlfthm.es/content-blocks'
		);
	}

	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_set_footer_mods' );
