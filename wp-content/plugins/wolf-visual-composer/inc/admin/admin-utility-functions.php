<?php
/**
 * WPBakery Page Builder Extension admin utitliy functions
 *
 * Functions available on admin
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Admin
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

function wvc_target_param_list() {
	return array(
		esc_html__( 'Same window', 'wolf-visual-composer' ) => '_self',
		esc_html__( 'New window', 'wolf-visual-composer' ) => '_blank',
	);
}