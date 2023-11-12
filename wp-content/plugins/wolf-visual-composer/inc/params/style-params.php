<?php
/**
 * Style params for containers
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Core
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

/**
 * Style params
 */
function wvc_style_params() {
	return array(
		array(
			'type'       => 'css_editor',
			'heading'    => esc_html__( 'CSS box', 'wolf-visual-composer' ),
			'param_name' => 'css',
			'group'      => esc_html__( 'Custom', 'wolf-visual-composer' ),
			'weight'     => -1,
		),
	);
}
