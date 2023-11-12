<?php
/**
 * Product index WPBakery Page Builder Template
 *
 * The arguments are passed to the kayo_posts hook so we can do whatever we want with it
 *

 * @package Kayo/WPBakeryPageBuilder
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/* retrieve shortcode attributes */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

$atts['post_type'] = 'product';

/* hook passing VC arguments */
do_action( 'kayo_posts', $atts );
