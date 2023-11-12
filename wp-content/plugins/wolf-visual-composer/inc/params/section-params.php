<?php
/**
 * Section params
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Core
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

/**
 * Section general params
 */
function wvc_section_general_params() {
	return array(

		// array(
		// 	'type' => 'dropdown',
		// 	'heading' => esc_html__( 'Content Width', 'wolf-visual-composer' ),
		// 	'param_name' => 'content_type',
		// 	'value' => array(
		// 		sprintf( esc_html__( 'Standard width (%s centered)', 'wolf-visual-composer' ), '1140px' ) => 'standard',
		// 		sprintf( esc_html__( 'Small width (%s centered)', 'wolf-visual-composer' ), '750px' ) => 'small',
		// 		sprintf( esc_html__( 'Large width (%s centered)', 'wolf-visual-composer' ), '98%' ) => 'large',
		// 		sprintf( esc_html__( 'Full width (%s)', 'wolf-visual-composer' ), '100%' ) => 'full',
		// 	),
		// 	'dependency' => array( 'element' => 'content_layout', 'value' => array( 'column' ) ),
		// 	'weight' => 1,
		// ),

		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Min Height', 'wolf-visual-composer' ),
			'param_name' => 'min_height',
			'placeholder' => 'auto',
			'description' => esc_html__( 'Insert the row minimum height in pixel.', 'wolf-visual-composer' ),
			'weight' => 1,
		),

		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Full height section?', 'wolf-visual-composer' ),
			'param_name' => 'full_height',
			'description' => esc_html__( 'If checked section will be set to full height.', 'wolf-visual-composer' ),
			'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes' ),
			'weight' => 1,
		),

		// array(
		// 	'type' => 'dropdown',
		// 	'heading' => esc_html__( 'Content position', 'wolf-visual-composer' ),
		// 	'param_name' => 'content_placement',
		// 	'value' => array(
		// 		esc_html__( 'Default', 'wolf-visual-composer' ) => 'default',
		// 		esc_html__( 'Top', 'wolf-visual-composer' ) => 'top',
		// 		esc_html__( 'Middle', 'wolf-visual-composer' ) => 'middle',
		// 		esc_html__( 'Bottom', 'wolf-visual-composer' ) => 'bottom',
		// 	),
		// 	'description' => esc_html__( 'Select content position within columns.', 'wolf-visual-composer' ),
		// 	'dependency' => array( 'element' => 'content_layout', 'value' => array( 'column' ) ),
		// ),

		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Add pointing down arrow', 'wolf-visual-composer' ),
			'description' => esc_html__( 'Allow user to scroll to the next section when clicking on the arrow', 'wolf-visual-composer' ),
			'param_name' => 'arrow_down',
			//'dependency' => array( 'element' => 'full_height', 'value' => array( 'yes' ) ),
			'weight' => 1,
		),

		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Arrow Caption', 'wolf-visual-composer' ),
			'param_name' => 'arrow_down_text',
			'placeholder' => esc_html__( 'Continue', 'wolf-visual-composer' ),
			'weight' => 1,
		),

		// Row name
		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Section name', 'wolf-visual-composer' ),
			'param_name' => 'row_name',
			'description' => esc_html__( 'Required for the onepage scroll, this gives the name to the section.', 'wolf-visual-composer' ),
		),

		// Visibility
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Visibility', 'wolf-visual-composer' ),
			'param_name' => 'hide_class',
			'value' => array(
				esc_html__( 'Always visible', 'wolf-visual-composer' ) => '',
				esc_html__( 'Hide on tablet and mobile', 'wolf-visual-composer' ) => 'wvc-hide-tablet',
				esc_html__( 'Hide on mobile', 'wolf-visual-composer' ) => 'wvc-hide-mobile',
				esc_html__( 'Show on tablet and mobile only', 'wolf-visual-composer' ) => 'wvc-show-tablet',
				esc_html__( 'Show on mobile only', 'wolf-visual-composer' ) => 'wvc-show-mobile',
				esc_html__( 'Always hidden', 'wolf-visual-composer' ) => 'wvc-hide',
			),
		),

		// Extra class
		array(
			'type' => 'textfield',
			'heading' => esc_html__( 'Extra class name', 'wolf-visual-composer' ),
			'param_name' => 'el_class',
			'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'wolf-visual-composer' ),
		),
	);
}

/**
 * Section custom params
 */
function wvc_section_custom_params() {
	return array(
		array(
			'type' => 'css_editor',
			'heading' => esc_html__( 'CSS box', 'wolf-visual-composer' ),
			'param_name' => 'css',
			'group' => esc_html__( 'Custom', 'wolf-visual-composer' ),
			'weight' => -1,
		),

		// array(
		// 	'type' => 'textfield',
		// 	'heading' => esc_html__( 'Border Color', 'wolf-visual-composer' ),
		// 	'param_name' => 'border_color',
		// 	'group' => esc_html__( 'Custom', 'wolf-visual-composer' ),
		// 	'weight' => -1,
		// ),

		// array(
		// 	'type' => 'textfield',
		// 	'heading' => esc_html__( 'Border Style', 'wolf-visual-composer' ),
		// 	'param_name' => 'border_style',
		// 	'group' => esc_html__( 'Custom', 'wolf-visual-composer' ),
		// 	'weight' => -1,
		// ),
	);
}