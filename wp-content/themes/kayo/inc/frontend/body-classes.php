<?php
/**
 * Kayo body classes
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kayo_body_classes' ) ) {
	/**
	 * Add specific class to the body depending on theme mods and page template
	 *
	 * @version 1.5.1
	 * @param array $classes The body classes.
	 * @return array $classes
	 */
	function kayo_body_classes( $classes ) {

		$classes[] = 'wolf';

		$classes[] = kayo_get_theme_slug();
		if ( isset( $_COOKIE[ kayo_get_theme_slug() . '_session_loaded' ] ) ) {
			$classes[] = 'session-loaded';
		}

		if ( kayo_is_edge() ) {
			$classes[] = 'is-edge';
		} else {
			$classes[] = 'not-edge';
		}

		/* Page title */
		if ( is_page() ) {
			$classes[] = 'page-title-' . sanitize_title_with_dashes( get_the_title() );
		}

		/* Loading animation type */
		$classes[] = 'loading-animation-type-' . kayo_get_inherit_mod( 'loading_animation_type' );

		/* Site Layout */
		$classes[] = 'site-layout-' . kayo_get_inherit_mod( 'site_layout', 'wide' );

		/* Body BG */
		$background_img_meta = get_post_meta( kayo_get_inherit_post_id(), '_post_body_background_img', true );

		if ( $background_img_meta ) {
			$classes[] = 'custom-background';
		}

		/* Button Style */
		$classes[] = 'button-style-' . kayo_get_theme_mod( 'button_style', 'standard' );

		if ( is_single() && post_password_required() ) {
			$classes[] = 'password-protected';
		}

		/* Global skin */
		$classes[] = 'global-skin-' . kayo_get_color_scheme_option(); // global skin.

		if ( ! kayo_is_vc() ) {
			/*
			* Output skin class on non page builder pages only
			*/
			$classes[] = 'skin-' . kayo_get_color_scheme_option();
		}

		if ( class_exists( 'Wolf_Visual_Composer' ) ) {
			$classes[] = 'wvc';
		}

		if ( class_exists( 'Wolf_Core' ) ) {
			$classes[] = 'wolf-core-yes';
		} else {
			$classes[] = 'wolf-core-no';
		}

		/* Menu Layout */
		$classes[] = 'menu-layout-' . kayo_get_menu_layout();

		if ( 'none' !== kayo_get_menu_layout() ) {
			/* Menu Style class */
			$classes[] = 'menu-style-' . apply_filters( 'kayo_menu_style_body_class_slug', kayo_get_menu_style() ); // phpcs: ignore
		}

		/* Menu Skin */
		$menu_skin = kayo_get_inherit_mod( 'menu_skin', 'light' );

		if ( kayo_get_theme_mod( 'nav_bar_bg_img' ) ) {
			$menu_skin = 'light';
			$classes[] = 'nav-bar-has-bg';
		}

		if ( kayo_get_inherit_mod( 'top_bar_block_id' ) && ! isset( $_COOKIE['top_bar_closed'] ) ) {
			$classes[] = 'has-top-bar';
		}

		$classes[] = 'menu-skin-' . kayo_get_inherit_mod( 'menu_skin', 'light' );

		/* Menu Width */
		$classes[] = 'menu-width-' . kayo_get_inherit_mod( 'menu_width', 'boxed' );

		/* Mega Menu Width */
		$classes[] = 'mega-menu-width-' . kayo_get_inherit_mod( 'mega_menu_width', 'boxed' );

		/* Menu Hover Style */
		$classes[] = 'menu-hover-style-' . kayo_get_inherit_mod( 'menu_hover_style', 'none' );

		/* Menu Sticky */
		$classes[] = 'menu-sticky-' . kayo_get_inherit_mod( 'menu_sticky_type', 'soft' );

		/* Sub menu color adjustment */
		if ( 'light' === kayo_get_color_tone( kayo_get_theme_mod( 'submenu_background_color' ) ) ) {
			$classes[] = 'submenu-bg-light';
		} else {
			$classes[] = 'submenu-bg-dark';
		}

		/* Accent color tune */
		if ( 'light' === kayo_get_accent_color_tone() ) {
			$classes[] = 'accent-color-light';
		} else {
			$classes[] = 'accent-color-dark';

			if ( kayo_color_is_black( kayo_get_inherit_mod( 'accent_color' ) ) ) {
				$classes[] = 'accent-color-is-black';
			}
		}

		if ( 'none' === kayo_get_menu_cta_content_type() ) {
			$classes[] = 'no-menu-cta';
		}

		/* Mobile Menu BG */
		if ( kayo_get_theme_mod( 'mobile_menu_bg_img' ) ) {
			$classes[] = 'mobile-menu-has-bg';
		}

		/* Menu items visiblity */
		$classes[] = 'menu-items-visibility-' . kayo_get_inherit_mod( 'menu_items_visibility' );

		/* Side Panel */
		if ( kayo_can_display_sidepanel() ) {
			$classes[] = 'side-panel-position-' . kayo_get_inherit_mod( 'side_panel_position', 'right' );

			if ( kayo_get_theme_mod( 'side_panel_bg_img' ) ) {
				$classes[] = 'side-panel-has-bg';
			} else {
				if ( 'light' === kayo_get_color_tone( kayo_get_inherit_mod( 'submenu_background_color' ) ) ) {
					$classes[] = 'side-panel-bg-light';
				} else {
					$classes[] = 'side-panel-bg-dark';
				}
			}
		}

		if ( kayo_get_theme_mod( 'lateral_menu_bg_img' ) ) {
			$classes[] = 'lateral-menu-has-bg';
		}

		if ( kayo_get_theme_mod( 'mega_menu_bg_img' ) ) {
			$classes[] = 'mega-menu-has-bg';
		}

		if ( kayo_get_theme_mod( 'overlay_menu_bg_img' ) ) {
			$classes[] = 'overlay-menu-has-bg';
		}

		/* Hero */
		$classes[] = ( kayo_has_hero() ) ? 'has-hero' : 'no-hero';

		/* Header font tone */
		$classes[] = 'hero-font-' . kayo_get_header_font_tone();

		/*
		Font class. Allow font size customization depending on font if needed
		*/
		$classes[] = 'body-font-' . sanitize_title( kayo_get_theme_mod( 'body_font_name' ) );
		$classes[] = 'heading-font-' . sanitize_title( kayo_get_theme_mod( 'heading_font_name' ) );
		$classes[] = 'menu-font-' . sanitize_title( kayo_get_theme_mod( 'menu_font_name' ) );
		$classes[] = 'submenu-font-' . sanitize_title( kayo_get_theme_mod( 'submenu_font_name' ) );

		/* Default Header Image */
		if ( get_header_image() ) {
			$classes[] = 'has-default-header';
		}

		/* Transition animation type */
		$classes[] = 'transition-animation-type-' . kayo_get_inherit_mod( 'transition_animation_type' );

		/* No logo */
		$logo_svg = apply_filters( 'kayo_logo_svg', kayo_get_theme_mod( 'logo_svg' ) ); // phpcs:disable
		$logo_light = apply_filters( 'kayo_logo_light', kayo_get_theme_mod( 'logo_light' ) ); // phpcs:disable
		$logo_dark = apply_filters( 'kayo_logo_dark', kayo_get_theme_mod( 'logo_dark' ) ); // phpcs:disable

		if ( ! $logo_svg && ! $logo_light && ! $logo_dark ) {
			$classes[] = 'has-text-logo';
		}

		if ( $logo_light && $logo_dark && ! $logo_svg ) {
			$classes[] = 'has-both-logo-tone';
		}

		/* Logo visibility */
		$classes[] = 'logo-visibility-' . kayo_get_inherit_mod( 'logo_visibility' );

		/**
		 * Ajax navigation
		 */
		if ( kayo_do_ajax_nav() ) {
			$classes[] = 'is-ajax-nav';
		}

		/* Home Blog */
		if ( kayo_is_home_as_blog() ) {
			$classes[] = 'is-blog-home';
		}

		/* Blog index page */
		if ( kayo_is_blog_index() ) {
			$classes[] = 'is-blog-index'; // archive blog index (page for posts).
		}

		if ( kayo_is_gutenberg_page() ) {
			$classes[] = 'is-gutenberg-page';
		}

		/* Is WVC activated? */
		if ( kayo_is_wolf_extension_activated() ) {
			$classes[] = 'has-wvc';
		} else {
			$classes[] = 'no-wvc';
		}

		/* Blog pages */
		if ( kayo_is_blog() || is_singular( 'post' ) ) {
			if ( ! kayo_display_sidebar() || ! is_active_sidebar( 'sidebar-main' ) ) {
				$classes[] = 'sidebar-disabled';
			}
		}

		/* Single post */
		if ( is_singular( 'post' ) ) {

			$classes[] = 'single-post-layout-' . kayo_get_single_post_layout();

			$classes[] = kayo_get_single_post_wvc_layout();

			if ( kayo_get_theme_mod( 'newsletter_form_single_blog_post' ) ) {
				$classes[] = 'show-newsletter-form';
			} else {
				$classes[] = 'no-newsletter-form';
			}

			if ( kayo_get_theme_mod( 'post_author_box' ) ) {
				$classes[] = 'show-author-box';
			} else {
				$classes[] = 'no-author-box';
			}

			if ( kayo_get_theme_mod( 'post_related_posts' ) ) {
				$classes[] = 'show-related-post';
			} else {
				$classes[] = 'no-related-post';
			}
		}

		/* Blog pages */
		if ( kayo_is_blog() || is_search() && ! kayo_is_woocommerce_page() ) {
			$classes[] = 'is-blog';
			$classes[] = 'layout-' . kayo_get_theme_mod( 'post_layout', 'standard' );
			$classes[] = 'display-' . kayo_get_theme_mod( 'post_display', 'standard' );
		}

		if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) && function_exists( 'is_account_page' ) && is_account_page() ) {

			$classes[] = 'wc-registration-allowed';
		}

		/* Portfolio */
		if ( kayo_is_portfolio() ) {
			$classes[] = 'is-portfolio';
			/**
			 * Filters default portfolio layout class
			 *
			 * @since 1.0.0
			 */
			$classes[] = 'layout-' . apply_filters( 'kayo_portfolio_layout', kayo_get_theme_mod( 'work_layout', 'standard' ) );
		}

		/* Albums */
		if ( kayo_is_albums() ) {
			$classes[] = 'is-albums';
			/**
			 * Filters default gallery layout class
			 *
			 * @since 1.0.0
			 */
			$classes[] = 'layout-' . apply_filters( 'kayo_albums_layout', kayo_get_theme_mod( 'gallery_layout', 'standard' ) );
		}

		/* Photos */
		if ( kayo_is_photos() ) {
			$classes[] = 'is-photos';
			/**
			 * Filters default attacchment layout class
			 *
			 * @since 1.0.0
			 */
			$classes[] = 'layout-' . apply_filters( 'kayo_photos_layout', kayo_get_theme_mod( 'attachment_layout', 'standard' ) );
		}

		/* Videos */
		if ( kayo_is_videos() ) {
			$classes[] = 'is-videos';
			/**
			 * Filters default videos layout class
			 *
			 * @since 1.0.0
			 */
			$classes[] = 'layout-' . apply_filters( 'kayo_videos_layout', kayo_get_theme_mod( 'video_layout', 'standard' ) );
		}

		/* Artists */
		if ( kayo_is_artists() ) {
			$classes[] = 'is-artists';
			/**
			 * Filters default artists layout class
			 *
			 * @since 1.0.0
			 */
			$classes[] = 'layout-' . apply_filters( 'kayo_artists_layout', kayo_get_theme_mod( 'artist_layout', 'standard' ) );
		}

		/* Single video */
		if ( is_singular( 'video' ) ) {
			$classes[] = 'single-post-layout-' . kayo_get_single_video_layout();
		}

		/* Single MP Event */
		if ( is_singular( 'mp-event' ) ) {
			$classes[] = 'single-post-layout-' . kayo_get_single_mp_event_layout();
		}

		/* Single MP Column */
		if ( is_singular( 'mp-column' ) ) {
			$classes[] = 'single-post-layout-' . kayo_get_single_mp_column_layout();
		}

		/* Discography */
		if ( kayo_is_discography() ) {
			$classes[] = 'is-discography';
			/**
			 * Filters default discography layout class
			 *
			 * @since 1.0.0
			 */
			$classes[] = 'layout-' . apply_filters( 'kayo_discography_layout', kayo_get_theme_mod( 'release_layout', 'standard' ) );
		}

		/* Event */
		if ( kayo_is_events() ) {
			$classes[] = 'is-events';
			/**
			 * Filters default events layout class
			 *
			 * @since 1.0.0
			 */
			$classes[] = 'layout-' . apply_filters( 'kayo_events_layout', kayo_get_theme_mod( 'event_layout', 'standard' ) );
		}

		/* WooCommerce */
		if ( kayo_is_woocommerce_page() ) {

			if ( is_singular( 'product' ) ) {
				$classes[] = 'single-product-layout-' . kayo_get_inherit_mod( 'product_single_layout', 'standard' );
			} else {
				$classes[] = 'is-shop';
				$classes[] = 'layout-' . kayo_get_theme_mod( 'product_layout', 'standard' );
			}
		}

		/* Single work */
		if ( is_singular( 'work' ) ) {
			$classes[] = 'single-work-layout-' . kayo_get_single_post_layout();
			$classes[] = 'single-work-width-' . get_post_meta( get_the_ID(), '_post_width', true );
		}

		/* Single Release */
		if ( is_singular( 'release' ) ) {
			$classes[] = 'single-release-layout-' . kayo_get_single_post_layout( get_the_ID(), 'sidebar-left' );
			$classes[] = 'single-release-width-' . get_post_meta( get_the_ID(), '_post_width', true );
		}

		/* Single Video */
		if ( is_singular( 'video' ) ) {
			$classes[] = 'single-video-layout-' . kayo_get_single_post_layout( get_the_ID(), 'fullwidth' );
			$classes[] = 'single-video-width-' . get_post_meta( get_the_ID(), '_post_width', true );
		}

		/* Single Artist */
		if ( is_singular( 'artist' ) ) {
			$classes[] = 'single-artist-layout-' . kayo_get_single_post_layout( get_the_ID(), 'fullwidth' );
			$classes[] = 'single-artist-width-' . get_post_meta( get_the_ID(), '_post_width', true );

			if ( get_post_meta( get_the_ID(), '_artist_hide_pagination', true ) ) {
				$classes[] = 'single-artist-hide-pagination';
			}
		}

		/* Page template clean classes */
		if ( is_page_template( 'page-templates/full-width.php' ) ) {
			$classes[] = 'page-default';
		}

		if ( is_page_template( 'page-templates/full-width.php' ) ) {
			$classes[] = 'page-full-width';
		}

		if ( is_page_template( 'page-templates/page-sidebar-right.php' ) ) {
			$classes[] = 'page-sidebar-right';
		}

		if ( is_page_template( 'page-templates/page-sidebar-left.php' ) ) {
			$classes[] = 'page-sidebar-left';
		}

		if ( is_page_template( 'page-templates/post-archives.php' ) ) {
			$classes[] = 'page-post-archives';
		}

		/* Hero */

		$hero_layout = kayo_get_inherit_mod( 'hero_layout' );

		$post_hero_layout_meta = get_post_meta( get_the_ID(), '_post_hero_layout', true );
		$show_hero             = ( 'none' !== $post_hero_layout_meta );

		if ( is_single() && $show_hero ) {

			if ( $post_hero_layout_meta ) {
				$hero_layout = $post_hero_layout_meta;

			} else {

				$hero_post_types = array( 'post', 'gallery', 'work', 'release', 'event', 'video', 'artist' );

				foreach ( $hero_post_types as $post_type ) {

					$post_type_hero_layout_mod = kayo_get_theme_mod( $post_type . '_hero_layout' );

					if ( is_singular( $post_type ) && $post_type_hero_layout_mod && $show_hero ) {

						$hero_layout = $post_type_hero_layout_mod;

					} else {
						$hero_layout = $hero_layout;
					}
				}
			}
		}

		$classes[] = 'hero-layout-' . apply_filters( 'kayo_hero_layout_body_class_slug', $hero_layout );

		if ( get_post_meta( kayo_get_inherit_post_id(), '_post_hide_title_text', true ) ) {

			$classes[] = 'post-hide-title-text';
		} else {

			$classes[] = 'post-is-title-text';
		}

		/* Post hero type */
		if ( 'none' === kayo_get_inherit_mod( 'hero_type' ) ) {

			$classes[] = 'post-hide-hero';

		} else {

			$classes[] = 'post-is-hero';
		}

		/* Footer widget area layout */
		$classes[] = 'footer-type-' . kayo_get_inherit_mod( 'footer_type' );
		$classes[] = 'footer-skin-' . kayo_get_inherit_mod( 'footer_skin', 'dark' );
		$classes[] = 'footer-widgets-layout-' . kayo_get_theme_mod( 'footer_widgets_layout', '4-cols' );
		$classes[] = 'footer-layout-' . kayo_get_theme_mod( 'footer_layout', 'boxed' );

		/* Bottom bar layout */
		$classes[] = 'bottom-bar-layout-' . kayo_get_theme_mod( 'bottom_bar_layout', 'centered' );

		if ( get_post_meta( get_the_ID(), '_post_bottom_bar_hidden', true ) ) {
			$classes[] = 'bottom-bar-hidden';
		} else {
			$classes[] = 'bottom-bar-visible';
		}

		if ( class_exists( 'Wolf_404_Error_Page' ) || class_exists( 'PP_404Page' ) ) {
			$classes[] = 'has-404-plugin';
		} else {
			$classes[] = 'no-404-plugin';
		}

		if ( ! wp_is_mobile() ) {
			$classes[] = 'desktop desktop-screen';
		}

		return $classes;
	}
	add_filter( 'body_class', 'kayo_body_classes' );
}

/**
 * Add data attribute to body
 *
 * @version 1.5.1
 * @param array $atts The body data_attr array.
 * @return array
 */
function kayo_body_data_atts( $atts ) {

	$atts['hero-font-tone'] = kayo_get_header_font_tone();

	if ( kayo_get_the_id() ) {
		$atts['post-id'] = kayo_get_the_id();
	}

	return $atts;
}
add_filter( 'kayo_body_data_atts', 'kayo_body_data_atts', 9999 );

/**
 * Output body attributes
 *
 * @return void
 */
function kayo_output_body_attr() {

	/**
	 * Filters body data attributes
	 *
	 * @since 1.0.0
	 */
	$atts        = apply_filters( 'kayo_body_data_atts', array() );
	$atts_string = '';

	foreach ( $atts as $k => $v ) {
		echo wp_kses_data( 'data-' . $k . '="' . $v . '" ' );
	}
}
add_action( 'kayo_body_atts', 'kayo_output_body_attr' );
