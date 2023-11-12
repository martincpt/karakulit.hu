<?php
/**
 * Kayo menu functions
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add a parent CSS class for nav menu items.
 *
 * @see https://developer.wordpress.org/reference/functions/wp_nav_menu/#How_to_add_a_parent_class_for_menu_item
 * @param array $items The menu items, sorted by each menu item's menu order.
 * @return array (maybe) modified parent CSS class.
 */
function kayo_add_menu_parent_class( $items ) {

	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}
	foreach ( $items as $item ) {
		if ( in_array( (string) $item->ID, $parents, true ) ) {
			$item->classes[] = 'menu-parent-item';
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'kayo_add_menu_parent_class' );

/**
 * Display icons in social links menu.
 *
 * @param  string  $item_output The menu item output.
 * @param  WP_Post $item        Menu item object.
 * @param  int     $depth       Depth of the menu.
 * @param  array   $args        wp_nav_menu() arguments.
 * @return string  $item_output The menu item output with social icon.
 */
function kayo_nav_menu_social_icons( $item_output, $item, $depth, $args ) {

	$social_icons = kayo_social_links_icons();

	if ( 'primary' === $args->theme_location || 'secondary' === $args->theme_location ) {
		foreach ( $social_icons as $attr => $value ) {
			if ( false !== strpos( $item_output, $attr ) ) {
				$label       = wp_strip_all_tags( $item_output );
				$icon        = "<span class='socicon socicon-$value'></span>";
				$item_output = str_replace( $label, $icon, $item_output );
			}
		}
	}

	return $item_output;
}

/**
 * Modify menu item output
 *
 * @param string $item_output The menu item's starting HTML output.
 * @param object $item        Menu item data object.
 * @param int    $depth       Depth of menu item. Used for padding.
 * @param array  $args        An array of wp_nav_menu() arguments.
 */
function kayo_menu_item_markup( $item_output, $item, $depth, $args ) {

	if ( 'primary' === $args->theme_location || 'secondary' === $args->theme_location ) {

		$item_id = $item->ID;

		$before_text = '';
		$after_text  = '';

		$label = wp_strip_all_tags( $item_output );

		$icon          = get_post_meta( $item->ID, '_menu-item-icon', true );
		$icon_position = ( get_post_meta( $item_id, '_menu-item-icon-position', true ) ) ? get_post_meta( $item->ID, '_menu-item-icon-position', true ) : 'before';
		if ( $icon && 'before' === $icon_position ) {
			$before_text = '<i class="fa ' . $icon . '"></i>';
		}

		if ( $icon && 'after' === $icon_position ) {
			$after_text = '<i class="fa ' . $icon . '"></i>';
		}

		$new_label = $before_text . $label . $after_text;

		if ( $icon && $icon_position ) {
			$item_output = str_replace( $label, $new_label, $item_output );
		}
	}

	return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'kayo_menu_item_markup', 10, 4 );

/**
 * Add menu_item attributes
 *
 * @param string $menu_id The ID that is applied to the menu item's <li>.
 * @param object $item The current menu item.
 * @param array  $args An array of wp_nav_menu() arguments.
 * @return array $classes
 */
function kayo_add_menu_item_link_attributes( $atts, $item, $args ) {

	if ( 'primary' === $args->theme_location || 'secondary' === $args->theme_location ) {

		$item_id = $item->ID;

		if ( get_post_meta( $item_id, '_menu-item-scroll', true ) ) {
			$atts['class'] = 'menu-link scroll';
		} else {
			$atts['class'] = 'menu-link';
		}
		if ( get_post_meta( $item_id, '_mega-menu-tagline', true ) ) {
			$atts['data-mega-menu-tagline'] = get_post_meta( $item_id, '_mega-menu-tagline', true );
		}

		if ( get_post_meta( $item_id, '_menu-item-tagline', true ) ) {
			$atts['data-menu-item-tagline'] = get_post_meta( $item_id, '_menu-item-tagline', true );
		}

		$atts['itemprop'] = 'url';
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'kayo_add_menu_item_link_attributes', 10, 3 );

/**
 * Add menu_item attributes
 *
 * @param string $menu_id The ID that is applied to the menu item's <li>.
 * @param object $item The current menu item.
 * @param array  $args An array of wp_nav_menu() arguments.
 * @return array $classes
 */
function kayo_add_overlay_menu_item_tagline( $atts, $item, $args ) {

	if ( 'vertical' === $args->theme_location ) {

		$item_id = $item->ID;

		if ( get_post_meta( $item_id, '_menu-item-tagline', true ) ) {
			$atts['data-menu-item-tagline'] = get_post_meta( $item_id, '_menu-item-tagline', true );
		}
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'kayo_add_overlay_menu_item_tagline', 10, 3 );

/**
 * Add custom classes to menu item
 *
 * @param array  $classes The ID that is applied to the menu item's <li>.
 * @param object $item The current menu item.
 * @param array  $args An array of wp_nav_menu() arguments.
 * @return array $classes
 */
function kayo_add_menu_item_css_classes( $classes, $item, $args ) {

	if ( 'primary' === $args->theme_location || 'secondary' === $args->theme_location ) {

		$item_id = $item->ID;

		$classes[] = 'menu-item-' . $item_id;
		$social_icons = kayo_social_links_icons();

		if ( get_post_meta( $item_id, '_mega-menu', true ) ) {
			$classes[] = 'mega-menu';
		}

		if ( get_post_meta( $item_id, '_mega-menu-tagline', true ) ) {
			$classes[] = 'mega-menu-has-tagline';
		}

		if ( get_post_meta( $item_id, '_menu-item-not-linked', true ) ) {
			$classes[] = 'not-linked';
		}

		if ( get_post_meta( $item_id, '_menu-item-hidden', true ) ) {
			$classes[] = 'menu-item-hidden';
		}

		if ( get_post_meta( $item_id, '_menu-item-button-style', true ) ) {
			$classes[] = 'menu-button-' . esc_attr( get_post_meta( $item_id, '_menu-item-button-style', true ) );
		}

		if ( get_post_meta( $item_id, '_menu-item-button-class', true ) ) {
			$classes[] = 'nav-button ' . esc_attr( get_post_meta( $item_id, '_menu-item-button-class', true ) );
		}

		if ( get_post_meta( $item_id, '_menu-item-new', true ) ) {
			$classes[] = 'new';
		}

		if ( get_post_meta( $item_id, '_menu-item-hot', true ) ) {
			$classes[] = 'hot';
		}

		if ( get_post_meta( $item_id, '_menu-item-sale', true ) ) {
			$classes[] = 'sale';
		}

		if ( get_post_meta( $item_id, '_menu-item-external', true ) ) {
			$classes[] = 'external';
		}
		$icon_position = ( get_post_meta( $item_id, '_menu-item-icon-position', true ) ) ? get_post_meta( $item_id, '_menu-item-icon-position', true ) : 'before';
		$classes[]     = "menu-item-icon-$icon_position";
		$mega_menu_cols = ( get_post_meta( $item_id, '_mega-menu-cols', true ) ) ? get_post_meta( $item_id, '_mega-menu-cols', true ) : 4;
		$classes[]      = "mega-menu-$mega_menu_cols-cols";

	} // endif primary menu

	return $classes;
}
add_filter( 'nav_menu_css_class', 'kayo_add_menu_item_css_classes', 10, 3 );

/**
 * Add a account menu item in mobile menu
 */
function kayo_add_account_menu_item_mobile( $items, $args ) {
	$cta_content = kayo_get_inherit_mod( 'menu_cta_content_type', 'none' );

	/**
	 * Force shop icons on woocommerce pages
	 */
	$is_wc_page_child = is_page() && absint( wp_get_post_parent_id( get_the_ID() ) ) === absint( kayo_get_woocommerce_shop_page_id() ) && kayo_get_woocommerce_shop_page_id();
	$is_wc            = kayo_is_woocommerce_page() || is_singular( 'product' ) || $is_wc_page_child;

	/**
	 * Filters to force to display the navigation shop icons or not
	 *
	 * @since Kayo 1.0.0
	 */
	if ( apply_filters( 'kayo_force_display_nav_shop_icons', $is_wc ) ) { // can be disable just in case.
		$cta_content = 'shop_icons';
	}

	if ( kayo_display_account_menu_item() && 'shop_icons' === $cta_content ) {
		if ( 'primary' === $args->theme_location && preg_match( '/mobile/', $args->menu_class ) ) {
			$items .= '<li class="menu-item mobile-account-menu-item">';
			$items .= kayo_account_menu_item_mobile( false );
			$items .= '</li>';
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_items', 'kayo_add_account_menu_item_mobile', 10, 2 );

/**
 * Add a cart menu item in mobile menu
 */
function kayo_add_cart_menu_item_mobile( $items, $args ) {

	$cta_content = kayo_get_inherit_mod( 'menu_cta_content_type', 'none' );

	/**
	 * Force shop icons on woocommerce pages
	 */
	$is_wc_page_child = is_page() && absint( wp_get_post_parent_id( get_the_ID() ) ) === absint( kayo_get_woocommerce_shop_page_id() ) && kayo_get_woocommerce_shop_page_id();
	$is_wc            = kayo_is_woocommerce_page() || is_singular( 'product' ) || $is_wc_page_child;

	/**
	 * Filters to force the shpo icons in the nav
	 *
	 * @since 1.0.0
	 */
	if ( apply_filters( 'kayo_force_display_nav_shop_icons', $is_wc ) ) { // can be disable just in case.
		$cta_content = 'shop_icons';
	}

	if ( kayo_display_cart_menu_item() && 'shop_icons' === $cta_content ) {
		if ( 'primary' === $args->theme_location && preg_match( '/mobile/', $args->menu_class ) ) {
			$items .= '<li class="menu-item mobile-cart-menu-item">';
			$items .= kayo_cart_menu_item_mobile( false );
			$items .= '</li>';
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_items', 'kayo_add_cart_menu_item_mobile', 10, 2 );

/**
 * Get menu args
 *
 * deprecated
 *
 * @param string $location
 * @param string $location
 * @param string $location
 */
function kayo_get_menu_args( $location = 'primary', $type = 'desktop', $depth = 3 ) {

	$args = array(
		'theme_location' => $location,
		'menu_class'     => "nav-menu nav-menu-$type",
		'menu_id'        => "site-navigation-$location-$type",
		'depth'          => $depth,
		'fallback_cb'    => 'kayo_menu_fallback',
		'link_before'    => '<span class="menu-item-inner"><span class="menu-item-text-container" itemprop="name">',
		'link_after'     => '</span></span>',
	);

	return $args;
}

/**
 * Filters menu args
 *
 * @param array $args
 * @return array
 */
function kayo_filter_menu_args( $args ) {

	$args['depth']       = 3;
	$args['fallback_cb'] = 'kayo_menu_fallback';
	$args['link_before'] = '<span class="menu-item-inner"><span class="menu-item-text-container" itemprop="name">';
	$args['link_after']  = '</span></span>';

	return $args;
}
add_filter( 'wp_nav_menu_args', 'kayo_filter_menu_args' );

/**
 * Dsplay "add menu" link to create menu when no menu is set if user is logged
 *
 * @link http://wordpress.stackexchange.com/questions/64515/fall-back-for-main-menu/
 */
function kayo_menu_fallback( $args ) {

	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	extract( $args );

	$link = '<a class="no-link-style" href="' . admin_url( 'nav-menus.php' ) . '">' . $link_before
	. $before . esc_html__( 'Add Menu', 'kayo' ) . $after . $link_after . '</a>';
	if ( false !== stripos( $items_wrap, '<ul' )
		|| false !== stripos( $items_wrap, '<ol' )
		) {
		$link = "<li>$link</li>";
	}

	$output = sprintf( $items_wrap, $menu_id, $menu_class, $link );

	if ( ! empty( $container ) ) {
		$output = "<$container class='$container_class' id='$container_id'>$output</$container>";
	}

	echo kayo_kses( $output );
}

/**
 * Returns an array of supported social links (URL and icon name).
 *
 * Inspired by Twenty Seventeen theme
 *
 * @return array $social_links_icons
 */
function kayo_social_links_icons() {
	$social_links_icons = array(
		'behance.net'     => 'behance',
		'codepen.io'      => 'codepen',
		'deviantart.com'  => 'deviantart',
		'digg.com'        => 'digg',
		'dribbble.com'    => 'dribbble',
		'dropbox.com'     => 'dropbox',
		'facebook.com'    => 'facebook',
		'flickr.com'      => 'flickr',
		'foursquare.com'  => 'foursquare',
		'plus.google.com' => 'google-plus',
		'github.com'      => 'github',
		'instagram.com'   => 'instagram',
		'linkedin.com'    => 'linkedin',
		'mailto:'         => 'mail',
		'medium.com'      => 'medium',
		'path.com'        => 'path',
		'pinterest.com'   => 'pinterest-p',
		'getpocket.com'   => 'get-pocket',
		'polldaddy.com'   => 'polldaddy',
		'reddit.com'      => 'reddit-alien',
		'skype.com'       => 'skype',
		'skype:'          => 'skype',
		'slideshare.net'  => 'slideshare',
		'snapchat.com'    => 'snapchat-ghost',
		'soundcloud.com'  => 'soundcloud',
		'spotify.com'     => 'spotify',
		'stumbleupon.com' => 'stumbleupon',
		'tumblr.com'      => 'tumblr',
		'twitch.tv'       => 'twitch',
		'twitter.com'     => 'twitter',
		'vimeo.com'       => 'vimeo',
		'vine.co'         => 'vine',
		'vk.com'          => 'vk',
		'wordpress.org'   => 'wordpress',
		'wordpress.com'   => 'wordpress',
		'yelp.com'        => 'yelp',
		'youtube.com'     => 'youtube',
	);
	/**
	 * Social_links_icons array filtered
	 *
	 * @since 1.0.0
	 */
	return apply_filters( 'kayo_social_links_icons', $social_links_icons );
}
