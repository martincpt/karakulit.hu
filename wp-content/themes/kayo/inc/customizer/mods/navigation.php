<?php
/**
 * Kayo navigation
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Navigation mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_navigation_mods( $mods ) {

	$mods['navigation'] = array(
		'id'      => 'navigation',
		'icon'    => 'menu',
		'title'   => esc_html__( 'Navigation', 'kayo' ),
		'options' => array(

			'menu_layout'           => array(
				'id'      => 'menu_layout',
				'label'   => esc_html__( 'Main Menu Layout', 'kayo' ),
				'type'    => 'select',
				'default' => 'top-justify',
				'choices' => array(
					'top-right'        => esc_html__( 'Top Right', 'kayo' ),
					'top-justify'      => esc_html__( 'Top Justify', 'kayo' ),
					'top-justify-left' => esc_html__( 'Top Justify Left', 'kayo' ),
					'centered-logo'    => esc_html__( 'Centered', 'kayo' ),
					'top-left'         => esc_html__( 'Top Left', 'kayo' ),
					'offcanvas'        => esc_html__( 'Off Canvas', 'kayo' ),
					'overlay'          => esc_html__( 'Overlay', 'kayo' ),
					'lateral'          => esc_html__( 'Lateral', 'kayo' ),
				),
			),

			'menu_width'            => array(
				'id'        => 'menu_width',
				'label'     => esc_html__( 'Main Menu Width', 'kayo' ),
				'type'      => 'select',
				'choices'   => array(
					'wide'  => esc_html__( 'Wide', 'kayo' ),
					'boxed' => esc_html__( 'Boxed', 'kayo' ),
				),
				'transport' => 'postMessage',
			),

			'menu_style'            => array(
				'id'        => 'menu_style',
				'label'     => esc_html__( 'Main Menu Style', 'kayo' ),
				'type'      => 'select',
				'choices'   => array(
					'semi-transparent-white' => esc_html__( 'Semi-transparent White', 'kayo' ),
					'semi-transparent-black' => esc_html__( 'Semi-transparent Black', 'kayo' ),
					'solid'                  => esc_html__( 'Solid', 'kayo' ),
					'transparent'            => esc_html__( 'Transparent', 'kayo' ),
				),
				'transport' => 'postMessage',
			),

			'menu_hover_style'      => array(
				'id'        => 'menu_hover_style',
				'label'     => esc_html__( 'Main Menu Hover Style', 'kayo' ),
				'type'      => 'select',
				/**
				 * Menu hover style option filter
				 *
				 * @since 1.0.0
				 */
				'choices'   => apply_filters(
					'kayo_main_menu_hover_style_options',
					array(
						'none'               => esc_html__( 'None', 'kayo' ),
						'opacity'            => esc_html__( 'Opacity', 'kayo' ),
						'underline'          => esc_html__( 'Underline', 'kayo' ),
						'underline-centered' => esc_html__( 'Underline Centered', 'kayo' ),
						'border-top'         => esc_html__( 'Border Top', 'kayo' ),
						'plain'              => esc_html__( 'Plain', 'kayo' ),
					)
				),
				'transport' => 'postMessage',
			),

			'mega_menu_width'       => array(
				'id'        => 'mega_menu_width',
				'label'     => esc_html__( 'Mega Menu Width', 'kayo' ),
				'type'      => 'select',
				'choices'   => array(
					'boxed'     => esc_html__( 'Boxed', 'kayo' ),
					'wide'      => esc_html__( 'Wide', 'kayo' ),
					'fullwidth' => esc_html__( 'Full Width', 'kayo' ),
				),
				'transport' => 'postMessage',
			),

			'menu_breakpoint'       => array(
				'id'          => 'menu_breakpoint',
				'label'       => esc_html__( 'Main Menu Breakpoint', 'kayo' ),
				'type'        => 'text',
				'description' => esc_html__( 'Below each width would you like to display the mobile menu? 0 will always show the desktop menu and 99999 will always show the mobile menu.', 'kayo' ),
			),

			'menu_sticky_type'      => array(
				'id'        => 'menu_sticky_type',
				'label'     => esc_html__( 'Sticky Menu', 'kayo' ),
				'type'      => 'select',
				'choices'   => array(
					'none' => esc_html__( 'Disabled', 'kayo' ),
					'soft' => esc_html__( 'Sticky on scroll up', 'kayo' ),
					'hard' => esc_html__( 'Always sticky', 'kayo' ),
				),
				'transport' => 'postMessage',
			),

			'menu_skin'             => array(
				'id'          => 'menu_skin',
				'label'       => esc_html__( 'Menu Skin', 'kayo' ),
				'type'        => 'select',
				'choices'     => array(
					'light' => esc_html__( 'Light', 'kayo' ),
					'dark'  => esc_html__( 'Dark', 'kayo' ),
				),
				'transport'   => 'postMessage',
				'description' => esc_html__( 'Can be overwite on single page.', 'kayo' ),
			),

			'menu_cta_content_type' => array(
				'id'      => 'menu_cta_content_type',
				'label'   => esc_html__( 'Additional Content', 'kayo' ),
				'type'    => 'select',
				'default' => 'icons',
				/**
				 * Filters menu Call to Action content type
				 *
				 * @since 1.0.0
				 */
				'choices' => apply_filters(
					'kayo_menu_cta_content_type_options',
					array(
						'search_icon'    => esc_html__( 'Search Icon', 'kayo' ),
						'secondary-menu' => esc_html__( 'Secondary Menu', 'kayo' ),
						'none'           => esc_html__( 'None', 'kayo' ),
					)
				),
			),
		),
	);

	$mods['navigation']['options']['menu_socials'] = array(
		'id'          => 'menu_socials',
		'label'       => esc_html__( 'Menu Socials', 'kayo' ),
		'type'        => 'text',
		'description' => esc_html__( 'The list of social services to display in the menu. (eg: facebook,twitter,instagram)', 'kayo' ),
	);

	$mods['navigation']['options']['side_panel_position'] = array(
		'id'          => 'side_panel_position',
		'label'       => esc_html__( 'Side Panel', 'kayo' ),
		'type'        => 'select',
		'choices'     => array(
			'none'  => esc_html__( 'None', 'kayo' ),
			'right' => esc_html__( 'At Right', 'kayo' ),
			'left'  => esc_html__( 'At Left', 'kayo' ),
		),
		'description' => esc_html__( 'Note that it will be disable with a vertical menu layout (offcanvas and lateral layout).', 'kayo' ),
	);

	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_set_navigation_mods' );
