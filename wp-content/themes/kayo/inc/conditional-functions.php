<?php
/**
 * Kayo conditional functions
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Check if we can display the sidepanel
 */
function kayo_can_display_sidepanel() {
	$menu_panel_mod  = kayo_get_theme_mod( 'side_panel_position' );
	$menu_panel_meta = get_post_meta( kayo_get_inherit_post_id(), '_post_side_panel_position', true );

	/**
	 * Exclude side panel when certain menu layout are selected
	 *
	 * @since Kayo 1.0.0
	 */
	$excluded_menu_layout = apply_filters( 'kayo_excluded_side_panel_menu_layout', array( 'offcanvas', 'lateral', 'overlay' ) );

	$bool = true;

	if ( ! is_active_sidebar( 'sidebar-side-panel' ) ) {
		$bool = false;
	}

	if ( kayo_get_inherit_mod( 'sidepanel_content_block_id' ) && 'none' !== kayo_get_inherit_mod( 'sidepanel_content_block_id' ) ) {
		$bool = true;
	}

	if ( ( 'none' === $menu_panel_mod || ! $menu_panel_mod ) && ! $menu_panel_meta ) {
		$bool = false;
	}

	/* Be sure to not display the side panel if metabox option is set to none */
	if ( 'none' === $menu_panel_meta ) {
		$bool = false;
	}

	if ( in_array( kayo_get_inherit_mod( 'menu_layout' ), $excluded_menu_layout, true ) ) {
		$bool = false;
	}

	/**
	 * Filters side panel display condition
	 *
	 * @since Kayo 1.0.0
	 */
	return apply_filters( 'kayo_display_sidepanel', $bool );
}

/**
 * Check if we should display the search menu item
 */
function kayo_display_shop_search_menu_item() {
	return kayo_get_theme_mod( 'shop_search_menu_item' );
}

/**
 * Check if we should display the cart menu item
 */
function kayo_display_cart_menu_item() {
	return kayo_is_woocommerce() && kayo_get_theme_mod( 'cart_menu_item' );
}

/**
 * Check if we should display the account menu item
 */
function kayo_display_account_menu_item() {
	return kayo_is_woocommerce() && kayo_get_theme_mod( 'account_menu_item' );
}

/**
 * Check if we should display the wishlist menu item
 */
function kayo_display_wishlist_menu_item() {
	return kayo_is_wishlist() && kayo_get_theme_mod( 'wishlist_menu_item' );
}

/**
 * Check if there is a main menu to display
 *
 * @return bool
 */
function kayo_is_main_menu() {
	$has_menu = has_nav_menu( 'primary' );
	$has_logo = kayo_get_theme_mod( 'logo_svg' ) || kayo_get_theme_mod( 'logo_light' ) || kayo_get_theme_mod( 'logo_dark' );
	return $has_menu || $has_logo;
}

/**
 * Is Woocommerce activated?
 *
 * @return bool
 */
function kayo_is_woocommerce() {
	return ( class_exists( 'WooCommerce' ) );
}

/**
 * Is Wolf Woocommerce Wishlist activated?
 *
 * @return bool
 */
function kayo_is_wishlist() {
	return ( class_exists( 'Wolf_WooCommerce_Wishlist' ) && class_exists( 'WooCommerce' ) );
}

/**
 * Check if we are on a woocommerce page
 *
 * @return bool
 */
function kayo_is_woocommerce_page() {

	if ( class_exists( 'WooCommerce' ) ) {

		if ( is_woocommerce() ) {
			return true;
		}

		if ( is_shop() ) {
			return true;
		}

		if ( is_checkout() || is_order_received_page() ) {
			return true;
		}

		if ( is_cart() ) {
			return true;
		}

		if ( is_account_page() ) {
			return true;
		}

		if ( function_exists( 'wolf_wishlist_get_page_id' ) && is_page( wolf_wishlist_get_page_id() ) ) {
			return true;
		}
	}
}

/**
 * Check if we're on a post archive page
 *
 * Used for pagination to know if you can use the standard pagination links
 *
 * @param string $post_type The post type to check.
 * @return bool
 */
function kayo_is_post_type_archive( $post_type = null ) {

	$is_blog      = kayo_is_blog();
	$is_portfolio = kayo_is_portfolio();
	$is_shop      = ( function_exists( 'is_shop' ) ) ? is_shop() : false;

	return $is_blog || $is_portfolio || $is_shop;
}

/**
 * Check if WPBakery Page Builder Extension is used on this page
 *
 * @return bool
 */
function kayo_is_vc() {

	if ( function_exists( 'wvc_is_vc' ) ) {
		return wvc_is_vc();
	}
}

/**
 * Check if any page builder is used on this page
 *
 * @return bool
 */
function kayo_is_page_builder_page() {

	$wolf_core_is_page_builder_page = function_exists( 'wolf_core_is_page_builder_page' ) && wolf_core_is_page_builder_page();

	return $wolf_core_is_page_builder_page || kayo_is_vc();
}

/**
 * Check if we are in the customizer previes
 *
 * @return bool
 */
function kayo_is_customizer() {

	global $wp_customize;
	if ( isset( $wp_customize ) ) {
		return true;
	}
}

/**
 * Check if a hero background is set
 *
 * @return bool
 */
function kayo_has_hero() {

	$bool = false;

	if ( function_exists( 'is_product_category' ) && is_product_category() && get_term_meta( get_queried_object()->term_id, 'thumbnail_id', true ) ) {
		$bool = true;
	}

	$post_type    = get_post_type();
	$hero_bg_type = kayo_get_inherit_mod( 'hero_background_type', 'featured-image' );

	/**
	 * Filters post types when the hero header should not be displayed
	 *
	 * @since Kayo 1.0.0
	 */
	$no_hero_post_types = apply_filters( 'kayo_no_header_post_types', array( 'product', 'release', 'event', 'proof_gallery', 'attachment' ) );

	if ( is_single() && in_array( $post_type, $no_hero_post_types, true ) ) {
		$bool = false;

	} elseif ( kayo_is_home_as_blog() && get_header_image() ) {

		$bool = true;

	} elseif ( kayo_get_hero_background() ) {

		$bool = true;
	}

	if ( 'transparent' === kayo_get_inherit_mod( 'menu_style' ) && 'none' === kayo_get_inherit_mod( 'hero_layout' ) ) {
		$bool = true;
	}

	/**
	 * Filters has_hero condition
	 *
	 * @since Kayo 1.0.0
	 */
	return apply_filters( 'kayo_has_hero', $bool );
}

/**
 * Check if we're on a portfolio page
 *
 * @return bool
 */
function kayo_is_portfolio() {

	return function_exists( 'wolf_portfolio_get_page_id' ) && is_page( wolf_portfolio_get_page_id() ) || is_tax( 'work_type' );
}

/**
 * Check if we're on a albums page
 *
 * @return bool
 */
function kayo_is_albums() {

	return function_exists( 'wolf_albums_get_page_id' ) && is_page( wolf_albums_get_page_id() ) || is_tax( 'gallery_type' );
}

/**
 * Check if we're on a photos page
 *
 * @return bool
 */
function kayo_is_photos() {

	if ( function_exists( 'kayo_is_photos_page' ) ) {
		return kayo_is_photos_page();
	}
}

/**
 * Check if we're on a videos page
 *
 * @return bool
 */
function kayo_is_videos() {

	return function_exists( 'wolf_videos_get_page_id' ) && is_page( wolf_videos_get_page_id() ) || is_tax( 'video_type' ) || is_tax( 'video_tag' );
}

/**
 * Check if we're on a events page
 *
 * @return bool
 */
function kayo_is_events() {

	return function_exists( 'wolf_events_get_page_id' ) && is_page( wolf_events_get_page_id() ) || is_tax( 'we_artist' );
}

/**
 * Check if we're on a artists page
 *
 * @return bool
 */
function kayo_is_artists() {

	return function_exists( 'wolf_artists_get_page_id' ) && is_page( wolf_artists_get_page_id() ) || is_tax( 'artist_genre' );
}


/**
 * Check if we're on a plugins page
 *
 * @return bool
 */
function kayo_is_plugins() {

	return function_exists( 'wolf_plugins_get_page_id' ) && is_page( wolf_plugins_get_page_id() ) || is_tax( 'plugin_cat' ) || is_tax( 'plugin_tag' );
}

/**
 * Check if we're on a themes page
 *
 * @return bool
 */
function kayo_is_themes() {

	return function_exists( 'wolf_themes_get_page_id' ) && is_page( wolf_themes_get_page_id() ) || is_tax( 'themes_cat' ) || is_tax( 'themes_tag' );
}

/**
 * Check if we're on a discography page
 *
 * @return bool
 */
function kayo_is_discography() {

	return function_exists( 'wolf_discography_get_page_id' ) && is_page( wolf_discography_get_page_id() ) || is_tax( 'label' ) || is_tax( 'band' ) || is_tax( 'release_genre' );
}

/**
 * Do masonry
 *
 * @return bool
 */
function kayo_do_masonry() {

	$blog_masonry_display      = array( 'masonry', 'metro', 'metro_modern' );
	$portfolio_masonry_display = array( 'masonry', 'metro' );

	$return = false;

	if ( kayo_is_blog() ) {

		$return = in_array( kayo_get_theme_mod( 'post_display' ), $blog_masonry_display, true );

	} elseif ( kayo_is_portfolio() ) {

		$return = in_array( kayo_get_theme_mod( 'work_display' ), $portfolio_masonry_display, true );
	}

	return $return;
}

/**
 * Do packery (metro layout)
 *
 * @return bool
 */
function kayo_do_packery() {

	if ( kayo_is_blog() ) {

		return 'metro' === kayo_get_theme_mod( 'post_display' ) || 'metro_modern' === kayo_get_theme_mod( 'post_display' );

	} elseif ( kayo_is_portfolio() ) {

		return 'metro' === kayo_get_theme_mod( 'work_display' );

	} elseif ( kayo_is_albums() ) {

		return 'metro' === kayo_get_theme_mod( 'gallery_display' );
	}
}

/**
 * Is AJAX navigation enabled?
 *
 * @return bool
 */
function kayo_do_ajax_nav() {

	$ajax_mod = kayo_get_theme_mod( 'ajax_nav' );

	/**
	 * Filters AJAX navigation condition
	 *
	 * @since Kayo 1.0.0
	 */
	return apply_filters( 'kayo_do_ajax_nav', $ajax_mod );
}

/**
 * Check if post format is status, aside, quote or link
 *
 * @return bool
 */
function kayo_is_short_post_format() {

	$short_format = array( 'aside', 'status', 'quote', 'link' );

	return in_array( get_post_format(), $short_format, true );
}

/**
 * Check if we need to display the sidebar depending on context
 *
 * @return bool
 */
function kayo_display_sidebar() {

	global $wp_customize;

	$post_id = kayo_get_the_id();

	$is_customizer = ( isset( $wp_customize ) ) ? true : false;

	$is_right_post_type = ! is_singular( 'show' );

	$blog_layout = kayo_is_blog() && ( 'sidebar-left' === kayo_get_theme_mod( 'post_layout' ) || 'sidebar-right' === kayo_get_theme_mod( 'post_layout' ) );

	$shop_layout = ! is_singular( 'product' ) && kayo_is_woocommerce_page() && ( 'sidebar-left' === kayo_get_theme_mod( 'product_layout' ) || 'sidebar-right' === kayo_get_theme_mod( 'product_layout' ) );

	$product_layout = is_singular( 'product' ) && ( 'sidebar-left' === kayo_get_inherit_mod( 'single_product_layout' ) || 'sidebar-right' === kayo_get_inherit_mod( 'single_product_layout' ) );

	$disco_layout = kayo_is_discography() && ( 'sidebar-left' === kayo_get_theme_mod( 'release_layout' ) || 'sidebar-right' === kayo_get_theme_mod( 'release_layout' ) );

	$videos_layout = kayo_is_videos() && ( 'sidebar-left' === kayo_get_theme_mod( 'video_layout' ) || 'sidebar-right' === kayo_get_theme_mod( 'video_layout' ) );

	$portfolio_layout = kayo_is_portfolio() && ( 'sidebar-left' === kayo_get_theme_mod( 'work_layout' ) || 'sidebar-right' === kayo_get_theme_mod( 'work_layout' ) );

	$albums_layout = kayo_is_albums() && ( 'sidebar-left' === kayo_get_theme_mod( 'gallery_layout' ) || 'sidebar-right' === kayo_get_theme_mod( 'gallery_layout' ) );

	$events_layout = kayo_is_events() && ( 'sidebar-left' === kayo_get_theme_mod( 'event_layout' ) || 'sidebar-right' === kayo_get_theme_mod( 'event_layout' ) );

	$artists_layout = kayo_is_artists() && ( 'sidebar-left' === kayo_get_theme_mod( 'artist_layout' ) || 'sidebar-right' === kayo_get_theme_mod( 'artist_layout' ) );

	$single_post_layout = kayo_get_single_post_layout( $post_id );
	$is_single_sidebar  = is_singular( 'post' ) && ( ( 'sidebar-left' === $single_post_layout ) || ( 'sidebar-right' === $single_post_layout ) );

	$single_video_layout     = kayo_get_single_video_layout( $post_id );
	$is_single_video_sidebar = is_singular( 'video' ) && ( ( 'sidebar-left' === $single_video_layout ) || ( 'sidebar-right' === $single_video_layout ) && ! kayo_is_page_builder_page() );

	$single_artist_layout     = kayo_get_single_artist_layout( $post_id );
	$is_single_artist_sidebar = is_singular( 'artist' ) && ( ( 'sidebar-left' === $single_artist_layout ) || ( 'sidebar-right' === $single_artist_layout ) && ! kayo_is_page_builder_page() );

	$single_mp_event_layout     = kayo_get_single_mp_event_layout( $post_id );
	$is_single_mp_event_sidebar = is_singular( 'mp-event' ) && ( ( 'sidebar-left' === $single_mp_event_layout ) || ( 'sidebar-right' === $single_mp_event_layout ) );

	$single_mp_column_layout     = kayo_get_single_mp_column_layout( $post_id );
	$is_single_mp_column_sidebar = is_singular( 'mp-column' ) && ( ( 'sidebar-left' === $single_mp_column_layout ) || ( 'sidebar-right' === $single_mp_column_layout ) );

	if ( $is_right_post_type ) {
		/**
		 * Filters the "display sidebar" condition
		 *
		 * @since 1.0.0
		 */
		return apply_filters( 'kayo_display_sidebar', $blog_layout || $portfolio_layout || $product_layout || $events_layout || $artists_layout || $shop_layout || $is_customizer || $is_single_sidebar || $is_single_video_sidebar || $is_single_artist_sidebar || $disco_layout || $videos_layout || $albums_layout || $is_single_mp_event_sidebar || $is_single_mp_column_sidebar );
	}
}

/**
 * Check if the default template is used on the current page
 *
 * @return bool
 */
function kayo_is_default_template() {
	return ( ! kayo_is_page_builder_page() && 'page.php' === basename( get_page_template() ) );
}

/**
 * Filter is WVC condition
 */
function kayo_wvc_is_vc_page( $bool ) {

	if ( kayo_is_blog() || is_search() && ! is_single() ) {
		$bool = false;
	}

	$is_videos_page      = function_exists( 'wolf_videos_get_page_id' ) && is_page( wolf_videos_get_page_id() );
	$is_discography_page = function_exists( 'wolf_discography_get_page_id' ) && is_page( wolf_discography_get_page_id() );
	$is_albums_page      = function_exists( 'wolf_albums_get_page_id' ) && is_page( wolf_albums_get_page_id() );
	$is_events_page      = function_exists( 'wolf_events_get_page_id' ) && is_page( wolf_events_get_page_id() );
	$is_portfolio_page   = function_exists( 'wolf_portfolio_get_page_id' ) && is_page( wolf_portfolio_get_page_id() );

	if ( $is_videos_page || $is_discography_page || $is_albums_page || $is_events_page ) {
		$bool = false;
	}

	return $bool;
}
add_filter( 'wvc_is_vc', 'kayo_wvc_is_vc_page' );

/**
 * Check if the browser is edge
 *
 * @return bool
 */
function kayo_is_edge() {
	global $is_edge;

	return $is_edge;
}

/**
 * Check if the browser is iOS
 *
 * @return bool
 */
function kayo_is_iphone() {
	global $is_iphone;

	return $is_iphone;
}

/**
 * Check if elementor
 */
function kayo_is_elementor_page( $post_id = null ) {

	if ( defined( 'ELEMENTOR_VERSION' ) ) {
		global $post;

		$post_id = ( $post_id ) ? $post_id : null;

		if ( ! $post_id && is_object( $post ) ) {
			$post_id = $post->ID;
		}

		if ( $post_id ) {
			return \Elementor\Plugin::$instance->documents->get( $post_id )->is_built_with_elementor();
		}
	}
}

/**
 * Check if elementor
 */
function kayo_is_elementor_editor() {

	if ( defined( 'ELEMENTOR_VERSION' ) ) {
		return ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) || ( isset( $_GET['action'] ) && 'elementor' === $_GET['action'] );
	}
}

/**
 * Check if Elementor fonts are enabled.
 *
 * Disable all font related option if it is.
 */
function kayo_is_elementor_fonts_enabled() {
	return class_exists( 'Wolf_Core' ) && ! get_option( 'elementor_disable_typography_schemes' );
}

/**
 * Check if Elementor colors are enabled.
 *
 * Disable all colors related option if it is.
 */
function kayo_is_elementor_colors_enabled() {
	return class_exists( 'Wolf_Core' ) && ! get_option( 'elementor_disable_color_schemes' );
}

/**
 * Check if we must display a "one-^page" menu
 *
 * @return bool
 */
function kayo_do_onepage_menu() {

	if ( ! is_page() ) {
		return;
	}

	$post_id = get_the_ID();

	$is_page_builder = ( class_exists( 'Wolf_Visual_Composer' ) || class_exists( 'Wolf_Core' ) );
	$meta            = get_post_meta( $post_id, '_post_one_page_menu', true );

	return $is_page_builder && $meta;
}

/**
 * Check if easy zoom is enabled on product single page
 *
 * @return boo
 */
function kayo_do_single_product_easyzoom() {

	$bool = kayo_get_theme_mod( 'product_zoom' );

	if ( get_post_meta( kayo_get_the_id(), '_post_product_disable_easyzoom', true ) ) {
		$bool = false;
	}

	/* Disable zoom on mobile */
	if ( wp_is_mobile() ) {
		$bool = true;
	}

	/**
	 * Filters single product zoom option condition
	 *
	 * @since Kayo 1.0.0
	 */
	return apply_filters( 'kayo_single_product_zoom', $bool );
}

/**
 * Check if post has Instagram embed
 *
 * @return bool
 */
function kayo_is_instagram_post( $post_id = null ) {

	return preg_match( '/instagr/', kayo_get_first_url( $post_id ) ) && 'image' === get_post_format( $post_id );
}

/**
 * Check if post has video embed
 *
 * @return bool
 */
function kayo_is_video_post( $post_id = null ) {
	return kayo_get_first_video_url( $post_id ) && 'video' === get_post_format( $post_id );
}


/**
 * Post thumbnail
 *
 * @return bool
 */
function kayo_has_post_thumbnail() {

	return ( kayo_post_thumbnail( '', false ) ) ? true : false;
}

/**
 * Check if post has Mixcloud, ReverbNation, SoundCloud or Spotify embed player
 *
 * @return bool
 */
function kayo_is_audio_embed_post( $post_id = null ) {

	return preg_match( '/mixcloud/', kayo_get_first_url( $post_id ) )
		|| preg_match( '/reverbnation/', kayo_get_first_url( $post_id ) )
		|| preg_match( '/soundcloud/', kayo_get_first_url( $post_id ) )
		|| preg_match( '/spotify/', kayo_get_first_url( $post_id ) );
}

/**
 * Check if single audio player
 *
 * @return bool
 */
function kayo_is_single_audio_player() {
	return kayo_shortcode_preg_match( 'wolf-audio' ) || kayo_shortcode_preg_match( 'audio' ) || kayo_shortcode_preg_match( 'wvc_audio' ) || kayo_shortcode_preg_match( 'wolf_core_audio' );
}

/**
 * Check if single audio player
 *
 * @return bool
 */
function kayo_is_playlist_audio_player( $post_id = null ) {
	return kayo_is_audio_embed_post( $post_id ) || kayo_shortcode_preg_match( 'wvc_audio_embed' ) || kayo_shortcode_preg_match( 'wolf_playlist', $post_id ) || kayo_shortcode_preg_match( 'wvc_playlist' ) || kayo_shortcode_preg_match( 'playlist', $post_id ) || kayo_shortcode_preg_match( 'wolf_jplayer_playlist' );
}

/**
 * Is image a gif?
 *
 * @param int $attachment_id The attachment ID.
 * @return bool
 */
function kayo_is_gif( $attachment_id ) {

	$ext = strtolower( pathinfo( kayo_get_url_from_attachment_id( $attachment_id ), PATHINFO_EXTENSION ) );

	if ( 'gif' === $ext ) {
		return true;
	}
}

/**
 * Is latest post?
 *
 * @param string $post_type The post type of the post to check.
 * @param int    $post_id The post ID.
 * @return bool
 */
function kayo_is_latest_post( $post_type = 'post', $post_id = null ) {

	$post_id        = ( $post_id ) ? abdint( $post_id ) : get_the_ID();
	$latest_post_id = null;

	if ( 'post' === $post_type ) {

		$args = array(
			'posts_per_page'      => 1,
			'post_type'           => 'post',
			'post__in'            => get_option( 'sticky_posts' ),
			'ignore_sticky_posts' => 1,
		);

	} else {

		$args = array(
			'numberposts' => 1,
			'post_type'   => $post_type,
		);
	}

	$args['meta_key'] = '_thumbnail_id';

	$recent_posts = wp_get_recent_posts( $args, ARRAY_A );

	if ( is_array( $recent_posts ) && isset( $recent_posts[0] ) ) {
		if ( isset( $recent_posts[0]['ID'] ) ) {
			$latest_post_id = absint( $recent_posts[0]['ID'] );
		}
	}

	return ( $post_id === $latest_post_id );
}

/**
 * Do fullPage?
 */
function kayo_do_fullpage() {
	return ( function_exists( 'wvc_do_fullpage' ) && wvc_do_fullpage() );
}

/**
 * Maintenance
 */
function kayo_is_maintenance_page() {

	$wolf_maintenance_settings = get_option( 'wolf_maintenance_settings' );
	$maintenance_page_id       = ( isset( $wolf_maintenance_settings['page_id'] ) ) ? $wolf_maintenance_settings['page_id'] : null;

	if ( is_page( $maintenance_page_id ) ) {
		return true;
	}
}

/**
 * CHeck if gutenberg is used
 */
function kayo_is_gutenberg_page() {

	if ( ! kayo_is_woocommerce_page() && is_singular() && function_exists( 'has_blocks' ) && has_blocks( kayo_get_the_id() ) ) {
		return true;
	}
}
