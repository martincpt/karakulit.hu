<?php
/**
 * Tabs
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Elements
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

$tab_id_1 = time() . '-1-' . rand( 0, 100 );
$tab_id_2 = time() . '-2-' . rand( 0, 100 );

vc_map(
	array(
		'name' => esc_html__( 'Tabs', 'wolf-visual-composer' ),
		'base' => 'vc_tabs',
		'show_settings_on_create' => false,
		'is_container' => true,
		'icon' => 'fa fa-folder',
		'category' => esc_html__( 'Content', 'wolf-visual-composer' ),
		'description' => esc_html__( 'Tabbed contents', 'wolf-visual-composer' ),
		'params' => array(
			// array(
			// 	'type' => 'textfield',
			// 	'heading' => esc_html__( 'Widget title', 'wolf-visual-composer' ),
			// 	'param_name' => 'title',
			// 	'description' => esc_html__( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'wolf-visual-composer' ),
			// ),
			// array(
			// 	'type' => 'checkbox',
			// 	'heading' => esc_html__( 'Vertical tabs', 'wolf-visual-composer' ),
			// 	'param_name' => 'vertical',
			// 	'description' => esc_html__( 'Specify checkbox to allow all sections to be collapsible.', 'wolf-visual-composer' ),
			// 	'value' => array(
			// 		esc_html__( 'Yes, please', 'wolf-visual-composer' ) => 'yes',
			// 	)
			// ),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Tabs Alignment', 'wolf-visual-composer' ),
				'param_name' => 'tabs_align',
				'value' => array(
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'Center', 'wolf-visual-composer' ) => 'center',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
				),
			),
		),
		'custom_markup' => '
	<div class="wpb_tabs_holder wpb_holder vc_container_for_children">
	<ul class="tabs_controls">
	</ul>
	%content%
	</div>',
		'default_content' => '
	[vc_tab title="' . esc_html__( 'Tab 1', 'wolf-visual-composer' ) . '" tab_id="' . $tab_id_1 . '"][/vc_tab]
	[vc_tab title="' . esc_html__( 'Tab 2', 'wolf-visual-composer' ) . '" tab_id="' . $tab_id_2 . '"][/vc_tab]
	',
		'js_view' => 'VcTabsView',
	)
);