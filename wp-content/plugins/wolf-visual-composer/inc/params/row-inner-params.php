<?php
/**
 * Row inner params
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Core
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

/**
 * Row inner general params
 */
function wvc_row_inner_general_params() {
	return array(
		// array(
		// 	'type' => 'dropdown',
		// 	'heading' => esc_html__( 'Column Type', 'wolf-visual-composer' ),
		// 	'param_name' => 'column_type',
		// 	'value' => array(
		// 		esc_html__( 'Columns', 'wolf-visual-composer' ) => 'column',
		// 		esc_html__( 'Block', 'wolf-visual-composer' ) => 'block',
		// 	),
		// 	'std' => 'column',
		// 	'description' => esc_html__( 'This will set a default style for your columns.', 'wolf-visual-composer' ),
		// 	'weight' => 1,
		// ),
		array(
			'type' => 'dropdown',
			'heading' => esc_html__( 'Row Width', 'wolf-visual-composer' ),
			'param_name' => 'container_width',
			'value' => array(
				sprintf( esc_html__( 'Inherit', 'wolf-visual-composer' ), apply_filters( 'wvc_row_standard_width', '1140px' ) ) => 'inherit',
				sprintf( esc_html__( 'Standard width (%s centered)', 'wolf-visual-composer' ), apply_filters( 'wvc_row_standard_width', '1140px' ) ) => 'standard',
				sprintf( esc_html__( 'Small width (%s centered)', 'wolf-visual-composer' ), apply_filters( 'wvc_row_small_width', '750px' ) ) => 'small',
			),
			'weight' => 1,
		),

		array(
			'type' => 'wvc_textfield',
			'heading' => esc_html__( 'Min Height', 'wolf-visual-composer' ),
			'param_name' => 'min_height',
			'placeholder' => 'auto',
			'description' => esc_html__( 'Insert the row minimum height in pixel.', 'wolf-visual-composer' ),
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

		// array(
		// 	'type' => 'dropdown',
		// 	'heading' => esc_html__( 'Columns position', 'wolf-visual-composer' ),
		// 	'param_name' => 'columns_placement',
		// 	'value' => array(
		// 		esc_html__( 'Default', 'wolf-visual-composer' ) => 'default',
		// 		esc_html__( 'Middle', 'wolf-visual-composer' ) => 'middle',
		// 		esc_html__( 'Top', 'wolf-visual-composer' ) => 'top',
		// 		esc_html__( 'Bottom', 'wolf-visual-composer' ) => 'bottom',
		// 		esc_html__( 'Stretch', 'wolf-visual-composer' ) => 'stretch',
		// 	),
		// 	'description' => esc_html__( 'Select columns position within row.', 'wolf-visual-composer' ),
		// 	'dependency' => array(
		// 		'element' => 'full_height',
		// 		'not_empty' => true,
		// 	),
		// 	'weight' => 1,
		// ),

		// array(
		// 	'type' => 'checkbox',
		// 	'heading' => esc_html__( 'Equal height', 'wolf-visual-composer' ),
		// 	'param_name' => 'equal_height',
		// 	'description' => esc_html__( 'If checked columns will be set to equal height.', 'wolf-visual-composer' ),
		// 	'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes' ),
		// 	'dependency' => array( 'element' => 'content_layout', 'value' => array( 'column' ) ),
		// ),

		// array(
		// 	'type' => 'dropdown',
		// 	'heading' => esc_html__( 'Columns gap', 'wolf-visual-composer' ),
		// 	'param_name' => 'gap',
		// 	'value' => array(
		// 		'0px' => '0',
		// 		'1px' => '1',
		// 		'2px' => '2',
		// 		'3px' => '3',
		// 		'4px' => '4',
		// 		'5px' => '5',
		// 		'10px' => '10',
		// 		'15px' => '15',
		// 		'20px' => '20',
		// 		'25px' => '25',
		// 		'30px' => '30',
		// 		'35px' => '35',
		// 	),
		// 	'std' => '0',
		// 	'description' => esc_html__( 'Select gap between columns in row.', 'wolf-visual-composer' ),
		// ),

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

		array(
			'type' => 'checkbox',
			'heading' => esc_html__( 'Disable row', 'wolf-visual-composer' ),
			'param_name' => 'disable_element',
			// Inner param name.
			'description' => esc_html__( 'If checked the row won\'t be visible on the public side of your website. You can switch it back any time.', 'wolf-visual-composer' ),
			'value' => array( esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes' ),
		),
	);
}
