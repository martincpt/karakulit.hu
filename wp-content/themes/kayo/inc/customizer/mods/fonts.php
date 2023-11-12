<?php
/**
 * Kayo customizer font mods
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Font mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_font_mods( $mods ) {

	$mods['fonts'] = array(
		'id'      => 'fonts',
		'title'   => esc_html__( 'Fonts', 'kayo' ),
		'icon'    => 'editor-textcolor',
		'options' => array(),
	);

	if ( kayo_is_elementor_fonts_enabled() ) {

		$mods['fonts']['options']['no_font'] = array(
			'label'       => esc_html__( 'Theme Fonts Disabled', 'kayo' ),
			'id'          => 'no_font',
			'type'        => 'text_helper',
			'description' => sprintf(
				kayo_kses(
					/* translators: %s: Elementor settings page link URL */
					__( 'Please disable the default fonts options in the <a href="%s" target="_blank">Elementor settings</a> to use the theme font options.', 'kayo' )
				),
				esc_url( admin_url( 'admin.php?page=elementor' ) )
			),
		);

		return $mods;
	}

	/**
	 * Get Google Fonts from Font loader
	 * 
	 * @since Kayo 1.0.0
	 */
	$_fonts = apply_filters( 'kayo_mods_fonts', kayo_get_google_fonts_options() );

	$font_choices = array( 'default' => esc_html__( 'Default', 'kayo' ) );

	foreach ( $_fonts as $key => $value ) {
		$font_choices[ $key ] = $key;
	}

	$mods['fonts']['options']['body_font_name'] = array(
		'label'     => esc_html__( 'Body Font Name', 'kayo' ),
		'id'        => 'body_font_name',
		'type'      => 'select',
		'choices'   => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['body_font_size'] = array(
		'label'       => esc_html__( 'Body Font Size', 'kayo' ),
		'id'          => 'body_font_size',
		'type'        => 'text',
		'transport'   => 'postMessage',
		'description' => esc_html__( 'Don\'t ommit px. Leave empty to use the default font size.', 'kayo' ),
	);

	/*************************Menu*/

	$mods['fonts']['options']['menu_font_name'] = array(
		'id'        => 'menu_font_name',
		'label'     => esc_html__( 'Menu Font', 'kayo' ),
		'type'      => 'select',
		'choices'   => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_weight'] = array(
		'label'     => esc_html__( 'Menu Font Weight', 'kayo' ),
		'id'        => 'menu_font_weight',
		'type'      => 'text',
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_transform'] = array(
		'id'        => 'menu_font_transform',
		'label'     => esc_html__( 'Menu Font Transform', 'kayo' ),
		'type'      => 'select',
		'choices'   => array(
			'none'      => esc_html__( 'None', 'kayo' ),
			'uppercase' => esc_html__( 'Uppercase', 'kayo' ),
			'lowercase' => esc_html__( 'Lowercase', 'kayo' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_letter_spacing'] = array(
		'label'     => esc_html__( 'Menu Letter Spacing (omit px)', 'kayo' ),
		'id'        => 'menu_font_letter_spacing',
		'type'      => 'int',
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_style'] = array(
		'id'        => 'menu_font_style',
		'label'     => esc_html__( 'Menu Font Style', 'kayo' ),
		'type'      => 'select',
		'choices'   => array(
			'normal'  => esc_html__( 'Normal', 'kayo' ),
			'italic'  => esc_html__( 'Italic', 'kayo' ),
			'oblique' => esc_html__( 'Oblique', 'kayo' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_name'] = array(
		'id'        => 'submenu_font_name',
		'label'     => esc_html__( 'Submenu Font', 'kayo' ),
		'type'      => 'select',
		'choices'   => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_weight'] = array(
		'label'     => esc_html__( 'Submenu Font Weight', 'kayo' ),
		'id'        => 'submenu_font_weight',
		'type'      => 'text',
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_transform'] = array(
		'id'        => 'submenu_font_transform',
		'label'     => esc_html__( 'Submenu Font Transform', 'kayo' ),
		'type'      => 'select',
		'choices'   => array(
			'none'      => esc_html__( 'None', 'kayo' ),
			'uppercase' => esc_html__( 'Uppercase', 'kayo' ),
			'lowercase' => esc_html__( 'Lowercase', 'kayo' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_style'] = array(
		'id'        => 'submenu_font_style',
		'label'     => esc_html__( 'Submenu Font Style', 'kayo' ),
		'type'      => 'select',
		'choices'   => array(
			'normal'  => esc_html__( 'Normal', 'kayo' ),
			'italic'  => esc_html__( 'Italic', 'kayo' ),
			'oblique' => esc_html__( 'Oblique', 'kayo' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_letter_spacing'] = array(
		'label'     => esc_html__( 'Submenu Letter Spacing (omit px)', 'kayo' ),
		'id'        => 'submenu_font_letter_spacing',
		'type'      => 'int',
		'transport' => 'postMessage',
	);

	/*************************Heading*/

	$mods['fonts']['options']['heading_font_name'] = array(
		'id'        => 'heading_font_name',
		'label'     => esc_html__( 'Heading Font', 'kayo' ),
		'type'      => 'select',
		'choices'   => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_weight'] = array(
		'label'       => esc_html__( 'Heading Font weight', 'kayo' ),
		'id'          => 'heading_font_weight',
		'type'        => 'text',
		'description' => esc_html__( 'For example: "400" is normal, "700" is bold.The available font weights depend on the font.', 'kayo' ),
		'transport'   => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_transform'] = array(
		'id'        => 'heading_font_transform',
		'label'     => esc_html__( 'Heading Font Transform', 'kayo' ),
		'type'      => 'select',
		'choices'   => array(
			'none'      => esc_html__( 'None', 'kayo' ),
			'uppercase' => esc_html__( 'Uppercase', 'kayo' ),
			'lowercase' => esc_html__( 'Lowercase', 'kayo' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_style'] = array(
		'id'        => 'heading_font_style',
		'label'     => esc_html__( 'Heading Font Style', 'kayo' ),
		'type'      => 'select',
		'choices'   => array(
			'normal'  => esc_html__( 'Normal', 'kayo' ),
			'italic'  => esc_html__( 'Italic', 'kayo' ),
			'oblique' => esc_html__( 'Oblique', 'kayo' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_letter_spacing'] = array(
		'label'     => esc_html__( 'Heading Letter Spacing (omit px)', 'kayo' ),
		'id'        => 'heading_font_letter_spacing',
		'type'      => 'int',
		'transport' => 'postMessage',
	);

	return $mods;

}
add_filter( 'kayo_customizer_mods', 'kayo_set_font_mods', 10 );
