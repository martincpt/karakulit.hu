<?php
/**
 * Kayo Customizer CSS
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueues front-end CSS for color scheme.
 *
 * @see wp_add_inline_style()
 */
function kayo_color_scheme_css() {

	$default_color_scheme_option = kayo_get_color_scheme_option();
	$default_color_scheme        = kayo_get_color_scheme();

	$secondary_accent = ( isset( $default_color_scheme[8] ) ) ? $default_color_scheme[8] : $default_color_scheme[4];

	$color_scheme = array(
		'body_background_color'    => kayo_get_theme_mod( 'body_background_color', $default_color_scheme[0] ),
		'page_background_color'    => kayo_get_theme_mod( 'page_background_color', $default_color_scheme[1] ),
		'submenu_background_color' => kayo_get_theme_mod( 'submenu_background_color', $default_color_scheme[2] ),
		'submenu_font_color'       => kayo_get_theme_mod( 'submenu_font_color', $default_color_scheme[3] ),
		'accent_color'             => kayo_get_inherit_mod( 'accent_color', $default_color_scheme[4] ),
		'main_text_color'          => kayo_get_theme_mod( 'main_text_color', $default_color_scheme[5] ),
		'secondary_text_color'     => kayo_get_theme_mod( 'secondary_text_color', $default_color_scheme[6] ),
		'strong_text_color'        => kayo_get_theme_mod( 'strong_text_color', $default_color_scheme[7] ),
		'secondary_accent_color'   => kayo_get_theme_mod( 'secondary_accent_color', $secondary_accent ),
		'border_color'             => sprintf( 'rgba( %s, 0.08)', kayo_get_theme_mod( 'strong_text_color', kayo_hex_to_rgb( $default_color_scheme[4] ) ) ),
	);

	$color_scheme_css = kayo_get_color_scheme_css( $color_scheme );

	if ( ! SCRIPT_DEBUG ) {
		$color_scheme_css = kayo_compact_css( $color_scheme_css );
	}

	wp_add_inline_style( 'kayo-style', $color_scheme_css );
}
add_action( 'wp_enqueue_scripts', 'kayo_color_scheme_css' );

/**
 * Enqueues front-end CSS for fonts
 *
 * @see wp_add_inline_style()
 */
function kayo_customizer_fonts_css() {

	$font_values = array(
		'body_font_name'              => kayo_get_theme_mod( 'body_font_name' ),
		'body_font_size'              => kayo_get_theme_mod( 'body_font_size' ),
		'menu_font_name'              => kayo_get_theme_mod( 'menu_font_name' ),
		'menu_font_weight'            => kayo_get_theme_mod( 'menu_font_weight' ),
		'menu_font_transform'         => kayo_get_theme_mod( 'menu_font_transform' ),
		'menu_font_size'              => kayo_get_theme_mod( 'menu_font_size' ),
		'submenu_font_name'           => kayo_get_theme_mod( 'submenu_font_name' ),
		'submenu_font_transform'      => kayo_get_theme_mod( 'submenu_font_transform' ),
		'submenu_font_weight'         => kayo_get_theme_mod( 'submenu_font_weight' ),
		'submenu_font_letter_spacing' => kayo_get_theme_mod( 'submenu_font_letter_spacing' ),
		'menu_font_style'             => kayo_get_theme_mod( 'menu_font_style' ),
		'menu_font_letter_spacing'    => kayo_get_theme_mod( 'menu_font_letter_spacing' ),
		'heading_font_name'           => kayo_get_theme_mod( 'heading_font_name' ),
		'heading_font_weight'         => kayo_get_theme_mod( 'heading_font_weight' ),
		'heading_font_transform'      => kayo_get_theme_mod( 'heading_font_transform' ),
		'heading_font_style'          => kayo_get_theme_mod( 'heading_font_style' ),
		'heading_font_letter_spacing' => kayo_get_theme_mod( 'heading_font_letter_spacing' ),
	);

	$font_css = kayo_get_fonts_css( $font_values );

	if ( ! SCRIPT_DEBUG ) {
		$font_css = kayo_compact_css( $font_css );
	}

	wp_add_inline_style( 'kayo-style', $font_css );
}
add_action( 'wp_enqueue_scripts', 'kayo_customizer_fonts_css' );

/**
 * Enqueues front-end CSS for the layout mods
 *
 * @see wp_add_inline_style()
 */
function kayo_customizer_layout_css() {

	$values = array(
		'site_width'     => kayo_get_theme_mod( 'site_width' ),
		'logo_max_width' => kayo_get_theme_mod( 'logo_max_width' ),
	);

	$layout_css = kayo_get_layout_css( $values );

	if ( ! SCRIPT_DEBUG ) {
		$layout_css = kayo_compact_css( $layout_css );
	}

	wp_add_inline_style( 'kayo-style', $layout_css );
}
add_action( 'wp_enqueue_scripts', 'kayo_customizer_layout_css' );

/**
 * Get bg CSS
 *
 * @param array $selectors Array fo CSS selectors.
 * @return string
 */
function kayo_get_customizer_bg_css( $selectors = array() ) {

	$css = '';

	foreach ( $selectors as $id => $selector ) {

		$img        = '';
		$color      = kayo_get_theme_mod( $id . '_color' );
		$repeat     = kayo_get_theme_mod( $id . '_repeat' );
		$position   = kayo_get_theme_mod( $id . '_position' );
		$attachment = kayo_get_theme_mod( $id . '_attachment' );
		$size       = kayo_get_theme_mod( $id . '_size' );
		$none       = kayo_get_theme_mod( $id . '_none' );
		$parallax   = kayo_get_theme_mod( $id . '_parallax' );
		$font_color = kayo_get_theme_mod( $id . '_font_color' );
		$opacity    = intval( kayo_get_theme_mod( $id . '_opacity', 100 ) ) / 100;
		$color_rgba = 'rgba(' . kayo_hex_to_rgb( $color ) . ', ' . $opacity . ')';

		if ( $font_color ) {
			$css .= "$selector {color:$font_color;}";

			/* Kind of hook for footer widget area. A bit ugly... */
			if ( 'footer_bg' === $id ) {
				$css .= ".site-footer h1, .site-footer h2, .site-footer h3, .site-footer h4, .site-footer h5, .site-footer h6, .site-footer a, .site-footer .widget a {
    color: $font_color !important;
}";
			}
		}

		/*
		 Backgrounds
		---------------------------------
		*/
		if ( '' === $none ) {

			if ( kayo_get_inherit_mod( $id . '_img' ) ) {
				$img_data = kayo_get_inherit_mod( $id . '_img' );
				$img_url  = ( is_numeric( $img_data ) ) ? kayo_get_url_from_attachment_id( $img_data, '%SLUG-XL%' ) : esc_url( $img_data );
				$img      = 'url("' . $img_url . '")!important';
			}

			if ( $color || $img ) {

				if ( ! $img ) {
					$css .= "$selector {background-color:$color;background-color:$color_rgba;}";
				}

				if ( $img ) {

					if ( $parallax ) {

						$css .= "$selector {background : $color $img no-repeat fixed}";
						$css .= "$selector {background-position : 50% 0}";

					} else {

						if ( $color ) {
							$css .= "$selector {background-color : $color}";
						}

						if ( $repeat ) {
							$css .= "$selector {background-repeat : $repeat}";
						}

						if ( $position ) {
							$css .= "$selector {background-position : $position}";
						}

						$css .= "$selector {background-image : $img}";

					}

					if ( 'cover' == $size ) {

						$css .= "$selector {
							-webkit-background-size: 100%;
							-o-background-size: 100%;
							-moz-background-size: 100%;
							background-size: 100%;
							-webkit-background-size: cover;
							-o-background-size: cover;
							background-size: cover;
						}";
					}

					if ( 'resize' == $size ) {

						$css .= "$selector {
							-webkit-background-size: 100%;
							-o-background-size: 100%;
							-moz-background-size: 100%;
							background-size: 100%;
						}";
					}
				}
			}
		} else {
			$css .= "$selector {background:none;}";
		}
	} // end foreach selectors

	return $css;
}

/**
 * Enqueues front-end CSS for background
 *
 * @see wp_add_inline_style()
 */
function kayo_customizer_backgrounds_css() {

	$backgrounds_css = '';

	$backgrounds = array(
		'footer_bg'       => '.sidebar-footer',
		'side_panel_bg'   => '.side-panel',
		'lateral_menu_bg' => '.lateral-menu-panel',
		'overlay_menu_bg' => '.overlay-menu-panel',
		'mega_menu_bg'    => '.mega-menu-panel',
		'nav_bar_bg'      => '.nav-bar-has-bg.sticking:not(.overlay-menu-toggle):not(.mobile-menu-toggle) #nav-bar',
		'mobile_menu_bg'  => '#mobile-menu-panel',
		'bottom_bar_bg'   => '.site-infos',
	);

	$backgrounds_css .= kayo_get_customizer_bg_css( $backgrounds );

	if ( ! SCRIPT_DEBUG ) {
		$backgrounds_css = kayo_compact_css( $backgrounds_css );
	}

	wp_add_inline_style( 'kayo-style', $backgrounds_css );
} // end function
add_action( 'wp_enqueue_scripts', 'kayo_customizer_backgrounds_css' );

/**
 * Enqueues front-end CSS for 404 background & password protected page
 *
 * @see wp_add_inline_style()
 */
function kayo_404_background_css() {

	$css = '';

	if ( get_header_image() ) {
		$src  = get_header_image();
		$css .= "
			body.error404,
			body.single.password-protected{
				background-image:url($src)!important;
			}
		";
	}

	if ( ! SCRIPT_DEBUG ) {
		$css = kayo_compact_css( $css );
	}

	wp_add_inline_style( 'kayo-style', $css );
}
add_action( 'wp_enqueue_scripts', 'kayo_404_background_css' );
