<?php
/**
 * BigText shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Templates
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'font_family' => '',
	'letter_spacing' => 0,
	'font_weight' => 700,
	'text_transform' => 'none',
	'font_style' => '',
	'color' => '',
	'custom_color' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'text' => '',
	'link' => '',
	'title_tag' => 'h4',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

// Generate bigtext using wvc_generate_bigtext function (inc/wvc-bigtext.php)
$output = wvc_generate_bigtext( $atts );

echo $output;