<?php
/**
 * Login form
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Elements
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

// Audio
vc_map(
	array(
		'name' => esc_html__( 'Login Form', 'wolf-visual-composer' ),
		'base' => 'wvc_login_form',
		'description' => esc_html__( 'A membership frontent login form', 'wolf-visual-composer' ),
		'icon' => 'icon-wpb-wp',
		'category' => esc_html__( 'Music' , 'wolf-visual-composer' ),
		'params' => array(
			// array(
			// 	'type' => 'attach_image',
			// 	'heading' => esc_html__( 'Image', 'wolf-visual-composer' ),
			// 	'param_name' => 'image',
			// 	'admin_label' => true,
			// ),
		),
	)
);

class WPBakeryShortCode_Wvc_Login_Form extends WPBakeryShortCode {}