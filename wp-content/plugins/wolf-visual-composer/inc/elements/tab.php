<?php
/**
 * Tab
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Elements
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Tab', 'wolf-visual-composer' ),
		'base' => 'vc_tab',
		'allowed_container_element' => 'vc_row',
		'is_container' => true,
		'content_element' => false,
		'params' => array(
			array(
				'type' => 'textfield',
				'heading' => esc_html__( 'Title', 'wolf-visual-composer' ),
				'param_name' => 'title',
				'description' => esc_html__( 'Tab title.', 'wolf-visual-composer' )
			),

			// array(
			// 	'type' => 'tab_id',
			// 	'heading' => esc_html__( 'Tab ID', 'wolf-visual-composer' ),
			// 	'param_name' => 'tab_id',
			// ),
			// array(
			// 	'type' => 'checkbox',
			// 	'heading' => esc_html__( 'Remove top margin', 'wolf-visual-composer' ),
			// 	'param_name' => 'no_margin',
			// 	'description' => esc_html__( 'Activate this to remove the top margin.', 'wolf-visual-composer' ),
			// 	'value' => array(
			// 		esc_html__( 'Yes, please', 'wolf-visual-composer' ) => 'yes',
			// 	)
			// ),
		),
		'js_view' => 'VcTabView',
	)
);