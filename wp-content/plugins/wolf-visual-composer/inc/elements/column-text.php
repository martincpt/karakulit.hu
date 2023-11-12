<?php
/**
 * Text Block
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Elements
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Text Block', 'wolf-visual-composer' ),
		'base' => 'vc_column_text',
		'icon' => 'fa fa-font',
		'wrapper_class' => 'clearfix',
		'category' => esc_html__( 'Content', 'wolf-visual-composer' ),
		'description' => esc_html__( 'A basic block of text with editor', 'wolf-visual-composer' ),
		'params' => array(
			array(
				'type' => 'textarea_html',
				'holder' => 'div',
				'heading' => esc_html__( 'Text', 'wolf-visual-composer' ),
				'param_name' => 'content',
				'value' => '<p>' . esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.', 'wolf-visual-composer' ) . '</p>',
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Center Align on Mobile', 'wolf-visual-composer' ),
				'param_name' => 'text_align_mobile',
				'value' => array(
					esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
				),
			),
		),
	)
);