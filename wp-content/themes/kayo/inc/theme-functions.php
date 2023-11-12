<?php
/**
 * Kayo frontend theme specific functions
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add custom font
 */
function kayo_add_google_font( $google_fonts ) {

	$default_fonts = array(
		'Special Elite'    => 'Special+Elite',
		'Oswald'           => 'Oswald:400,500,600,700,800',
		'Playfair Display' => 'Playfair+Display:400,700',
	);

	foreach ( $default_fonts as $key => $value ) {
		if ( ! isset( $google_fonts[ $key ] ) ) {
			$google_fonts[ $key ] = $value;
		}
	}

	return $google_fonts;
}
add_filter( 'kayo_google_fonts', 'kayo_add_google_font' );

/**
 * Overwrite standard post entry slider image size
 */
function kayo_overwrite_entry_slider_img_size( $size ) {

	 add_filter(
		'kayo_entry_slider_image_size',
		function() {
			return '847x508';
		}
	);

}
add_action( 'after_setup_theme', 'kayo_overwrite_entry_slider_img_size', 50 );

add_filter(
	'kayo_release_img_size',
	function( $size ) {
		return '600x600';
	}
);

add_filter(
	'kayo_live_search',
	function() {
		return false;
	}
);

add_filter(
	'kayo_backtop_text',
	function() {
		return esc_html__( 'top', 'kayo' );
	}
);

add_filter(
	'wvc_last_posts_big_slide_button_text',
	function( $text ) {
		return '<span>' . $text . '</span>';
	}
);

/**
 * Interactive links
 */
add_filter(
	'wvc_interactive_links_align',
	function( $value ) {
		return 'center';
	},
	44
);

add_filter(
	'wvc_interactive_links_display',
	function( $value ) {
		return 'inline';
	},
	44
);

/**
 * Post excerpt read more
 */
function kayo_add_menu_lateral_toggle() {
	?>
	<div id="lateral-toggle-bar">
		<div id="lateral-toggle-bar-inner">
			<div class="ltb-logo">
				<?php kayo_logo(); ?>
			</div>
			<div class="ltb-hamburger-container">
				<a class="toggle-lateral-menu ltb-burger" href="#">
					<span class="ltb-b-line" id="ltb-line-1"></span>
					<span class="ltb-b-line" id="ltb-line-2"></span>
					<span class="ltb-b-line" id="ltb-line-3"></span>
				</a>
			</div>
			<div class="ltb-socials">
				<?php
				if ( kayo_is_wolf_extension_activated() && function_exists( 'wvc_socials' ) ) {
					echo wvc_socials(
						array(
							'services' => kayo_get_inherit_mod( 'menu_socials', 'facebook,twitter,instagram' ),
							'size'     => '3',
						)
					);
				}
				?>
			</div>
		</div>
	</div>
	<?php
}
add_action( 'kayo_lateral_menu_panel_start', 'kayo_add_menu_lateral_toggle' );

/**
 * Max logo width filter for lateral menu toggle
 */
function kayo_filter_lateral_menu_logo_width( $layout_css, $values ) {

	if ( isset( $values['logo_max_width'] ) ) {
		$layout_css .= '
			.ltb-logo .logo{
				width:' . absint( $values['logo_max_width'] ) . 'px;
			}
		';
	}

	return $layout_css;

}
add_filter( 'kayo_layout_css_output', 'kayo_filter_lateral_menu_logo_width', 10, 2 );

/**
 * Add lateral menu closer overlay
 */
function kayo_set_panel_closer_overlay_class( $class ) {
	if ( 'lateral' === kayo_get_inherit_mod( 'menu_layout' ) ) {
		$class = 'toggle-lateral-menu';
	}

	return $class;
}
add_filter( 'kayo_panel_closer_overlay_class', 'kayo_set_panel_closer_overlay_class' );

if ( ! function_exists( 'kayo_account_menu_item' ) ) {
	/**
	 * Account menu item
	 */
	function kayo_account_menu_item( $echo = true ) {

		if ( ! function_exists( 'wc_get_page_id' ) ) {
			return;
		}

		$label = esc_html__( 'Login', 'kayo' );
		$class = 'account-item-icon';

		if ( is_user_logged_in() ) {
			$label  = esc_html__( 'My Account', 'kayo' );
			$class .= ' account-item-icon-user-logged-in';
		} else {
			$label  = esc_html__( 'Login', 'kayo' );
			$class .= ' account-item-icon-user-not-logged-in';
		}

		if ( WP_DEBUG ) {
			$class .= ' account-item-icon-user-not-logged-in';
		}

		$account_url = get_permalink( wc_get_page_id( 'myaccount' ) );

		ob_start();
		?>
			<a class="<?php echo kayo_sanitize_html_classes( $class ); ?>" href="<?php echo esc_url( $account_url ); ?>">
				<?php echo sanitize_text_field( $label ); ?>
			</a>
		<?php
		$account_item = ob_get_clean();

		if ( $echo ) {
			echo kayo_kses( $account_item );
		}

		return $account_item;
	}
}

if ( ! function_exists( 'kayo_cart_menu_item' ) ) {
	/**
	 * Cart menu item
	 */
	function kayo_cart_menu_item( $echo = true ) {

		if ( ! function_exists( 'wc_get_cart_url' ) ) {
			return;
		}

		$product_count = WC()->cart->get_cart_contents_count();

		ob_start();
		?>
			<a href="<?php echo wc_get_cart_url(); ?>" class="cart-item-icon toggle-cart">
				<span class="cart-menu-item-title"><?php esc_attr_e( 'Cart', 'kayo' ); ?></span>
				<span class="cart-product-count"><?php echo absint( $product_count ); ?></span>
			</a>
		<?php
		$cart_item = ob_get_clean();

		if ( $echo ) {
			echo kayo_kses( $cart_item );
		}

		return $cart_item;
	}
}

if ( ! function_exists( 'kayo_wishlist_menu_item' ) ) {
	/**
	 * Wishlist menu item
	 */
	function kayo_wishlist_menu_item( $echo = true ) {

		if ( ! function_exists( 'wolf_get_wishlist_url' ) ) {
			return;
		}

		$wishlist_url = wolf_get_wishlist_url();
		ob_start();
		?>
			<a href="<?php echo esc_url( $wishlist_url ); ?>" class="wishlist-item-icon"><?php esc_attr_e( 'Wishlist', 'kayo' ); ?></a>
		<?php
		$cart_item = ob_get_clean();

		if ( $echo ) {
			echo kayo_kses( $cart_item );
		}

		return $cart_item;
	}
}

/**
 * Post excerpt read more
 */
function kayo_output_post_grid_classic_excerpt_read_more() {
	?>
	<p class="post-grid-read-more-container"><a href="<?php the_permalink(); ?>" class="<?php echo esc_attr( apply_filters( 'kayo_more_link_button_class', 'more-link' ) ); ?>"><span><?php esc_html_e( 'Read more', 'kayo' ); ?></span></a></p>
	<?php
}
add_action( 'kayo_post_grid_classic_excerpt', 'kayo_output_post_grid_classic_excerpt_read_more', 44 );
add_action( 'kayo_post_masonry_excerpt', 'kayo_output_post_grid_classic_excerpt_read_more', 44 );
add_action( 'kayo_post_search_excerpt', 'kayo_output_post_grid_classic_excerpt_read_more', 44 );

/**
 * Add custom elements to theme
 *
 * @param array $elements
 * @return  array $elements
 */
function kayo_add_available_wvc_elements( $elements ) {

	$elements[] = 'audio-button';
	$elements[] = 'album-disc';
	$elements[] = 'album-tracklist';
	$elements[] = 'album-tracklist-item';
	$elements[] = 'artist-lineup';
	$elements[] = 'bandsintown-tracking-button';

	$elements[] = 'showcase-vertical-carousel';
	$elements[] = 'showcase-vertical-carousel-item';

	if ( class_exists( 'Wolf_Videos' ) ) {
		$elements[] = 'video-switcher';
	}

	if ( class_exists( 'WooCommerce' ) ) {
		$elements[] = 'login-form';
		$elements[] = 'product-presentation';
	}

	return $elements;
}
add_filter( 'wvc_element_list', 'kayo_add_available_wvc_elements', 44 );

/**
 * Disable default loading and transition animation
 *
 * @param  bool $bool enable/disable default loading animation.
 * @return bool
 */
function kayo_reset_loading_anim( $bool ) {
	return false;
}
add_filter( 'kayo_display_loading_logo', 'kayo_reset_loading_anim' );
add_filter( 'kayo_display_loading_overlay', 'kayo_reset_loading_anim' );
add_filter( 'kayo_default_page_loading_animation', 'kayo_reset_loading_anim' );
add_filter( 'kayo_default_page_transition_animation', 'kayo_reset_loading_anim' );

/**
 * Loading title markup
 */
function kayo_loading_animation_markup() {

	if ( 'none' !== kayo_get_inherit_mod( 'loading_animation_type', 'overlay' ) ) :
		?>
	<div id="kayo-loader-overlay-panel"></div>
	<div class="kayo-loader-overlay">
			<div class="kayo-loader">
				<?php if ( 'kayo' === kayo_get_inherit_mod( 'loading_animation_type', 'overlay' ) ) : ?>
					<!-- <div id="kayo-loader-overlay-panel"></div> -->
					<div id="kayo-loading-before" class="kayo-loading-block"></div>
					<div class="kayo-loading-line" id="kayo-loading-line-1">
						<div class="kayo-loading-line-aux" id="kayo-loading-line-1-aux"></div>
					</div>
					<div class="kayo-loading-line" id="kayo-loading-line-2">
						<div class="kayo-loading-line-aux" id="kayo-loading-line-2-aux"></div>
					</div>
					<div id="kayo-loading-after" class="kayo-loading-block"></div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	endif;
}
add_action( 'kayo_body_start', 'kayo_loading_animation_markup', 0 );

/**
 * Add lateral menu for the vertical bar
 */
function kayo_add_lateral_menu( $menus ) {

	$menus['vertical'] = esc_html__( 'Vertical Menu (optional)', 'kayo' );

	return $menus;

}
add_filter( 'kayo_menus', 'kayo_add_lateral_menu' );

/**
 * Login popup markup
 */
function kayo_login_form_markup() {
	if ( function_exists( 'wvc_login_form' ) && class_exists( 'WooCommerce' ) ) {
		?>
		<div id="loginform-overlay">
			<div id="loginform-overlay-inner">
				<div id="loginform-overlay-content" class="wvc-font-dark">
					<a href="#" id="close-vertical-bar-menu-icon" class="close-panel-button close-loginform-button">X</a>
					<?php echo wvc_login_form(); ?>
				</div>
			</div>
		</div>
		<?php
	}
}
add_action( 'kayo_body_start', 'kayo_login_form_markup', 5 );

/**
 * Overwrite post types menu order
 *
 * @param array  $args
 * @param string $post_type
 * @return array $args
 */
function kayo_overwrite_post_type_menu_order( $args, $post_type ) {

	if ( 'release' === $post_type ) {

		$args['menu_position'] = 5.1;
	}

	if ( 'event' === $post_type ) {

		$args['menu_position'] = 5.2;
	}

	if ( 'video' === $post_type ) {

		$args['menu_position'] = 5.3;
	}

	if ( 'work' === $post_type ) {

		$args['menu_position'] = 5.4;
	}

	if ( 'wpm_playlist' === $post_type ) {

		$args['menu_position'] = 35;
	}

	if ( 'wvc_content_block' === $post_type ) {

		$args['menu_position'] = 40;
	}

	return $args;
}
add_filter( 'register_post_type_args', 'kayo_overwrite_post_type_menu_order', 99, 2 );

/**
 * Reorder admin menu
 */
function custom_menu_order( $menu_ord ) {
	if ( ! $menu_ord ) {
		return true;
	}

	return $menu_ord;
}

add_filter( 'custom_menu_order', 'custom_menu_order' );
add_filter( 'menu_order', 'custom_menu_order' );

/**
 * Output video single post meta
 */
function kayo_ouput_video_meta() {
	$post_id  = get_the_ID();
	$category = get_the_terms( $post_id, 'video_type', '', esc_html__( ', ', 'kayo' ), '' );
	$tags     = get_the_terms( $post_id, 'video_tag', '', esc_html__( ', ', 'kayo' ), '' );

	$post_display_elements = kayo_get_theme_mod( 'video_display_elements' );
	$post_display_elements = kayo_list_to_array( $post_display_elements );
	$show_thumbnail        = ( in_array( 'show_thumbnail', $post_display_elements ) );
	$show_date             = ( in_array( 'show_date', $post_display_elements ) );
	$show_author           = ( in_array( 'show_author', $post_display_elements ) );
	$show_category         = ( in_array( 'show_category', $post_display_elements ) );
	$show_tags             = ( in_array( 'show_tags', $post_display_elements ) );
	?>
	<div class="video-entry-meta entry-meta">
		<?php if ( $show_date ) : ?>
			<span class="entry-date">
				<?php kayo_entry_date( true, true ); ?>
			</span>
		<?php endif; ?>
		<?php if ( $show_author ) : ?>
			<?php kayo_get_author_avatar(); ?>
		<?php endif; ?>
		<?php if ( $show_category && $category ) : ?>
			<span class="entry-category-list">
				<?php echo apply_filters( 'kayo_entry_category_list_icon', '<span class="meta-icon category-icon"></span>' ); ?>
				<?php echo get_the_term_list( get_the_ID(), 'video_type', '', esc_html__( ', ', 'kayo' ), '' ); ?>
			</span>
		<?php endif; ?>
		<?php if ( $show_tags && $tags ) : ?>
			<span class="entry-category-list">
				<?php echo apply_filters( 'kayo_entry_tag_list_icon', '<span class="meta-icon tag-icon"></span>' ); ?>
				<?php echo get_the_term_list( get_the_ID(), 'video_tag', '', esc_html__( ', ', 'kayo' ), '' ); ?>
			</span>
		<?php endif; ?>
		<?php kayo_get_extra_meta(); ?>
	</div><!-- .video-meta -->
	<?php

}
add_action( 'kayo_video_meta', 'kayo_ouput_video_meta' );

/**
 * Set mobile menu template
 *
 * @param string $string Mobile menu template slug.
 * @return string
 */
function kayo_set_mobile_menu_template( $string ) {

	return 'content-mobile-alt';
}
add_filter( 'kayo_mobile_menu_template', 'kayo_set_mobile_menu_template' );

/**
 * Add mobile closer overlay
 */
function kayo_add_mobile_panel_closer_overlay() {
	?>
	<div id="mobile-panel-closer-overlay" class="panel-closer-overlay toggle-mobile-menu"></div>
	<?php
}
add_action( 'kayo_main_content_start', 'kayo_add_mobile_panel_closer_overlay' );

/**
 * Mobile menu
 */
function kayo_mobile_alt_menu() {
	?>
	<div id="mobile-menu-panel">
		<a href="#" id="close-mobile-menu-icon" class="close-panel-button toggle-mobile-menu">X</a>
		<div id="mobile-menu-panel-inner">
		<?php
			/**
			 * Menu
			 */
			kayo_primary_mobile_navigation();
		?>
		</div><!-- .mobile-menu-panel-inner -->
	</div><!-- #mobile-menu-panel -->
	<?php
}
add_action( 'kayo_body_start', 'kayo_mobile_alt_menu' );

/**
 * Get available display options for works
 *
 * @return array
 */
function kayo_set_work_display_options() {

	return array(
		'grid'    => esc_html__( 'Grid', 'kayo' ),
		'metro'   => esc_html__( 'Metro', 'kayo' ),
		'masonry' => esc_html__( 'Masonry', 'kayo' ),
	);
}
add_filter( 'kayo_work_display_options', 'kayo_set_work_display_options' );

/**
 * Set portfolio template folder
 */
function kayo_set_portfolio_template_url( $template_url ) {

	return kayo_get_template_url() . '/portfolio/';
}
add_filter( 'wolf_portfolio_template_url', 'kayo_set_portfolio_template_url' );

/**
 * Set videos template folder
 */
function kayo_set_videos_template_url( $template_url ) {

	return kayo_get_template_url() . '/videos/';
}
add_filter( 'wolf_videos_template_url', 'kayo_set_videos_template_url' );

/**
 * Set discography template folder
 */
function kayo_set_discography_template_url( $template_url ) {

	return kayo_get_template_url() . '/discography/';
}
add_filter( 'wolf_discography_template_url', 'kayo_set_discography_template_url' );
add_filter( 'wolf_discography_url', 'kayo_set_discography_template_url' );

/**
 * Rewrite band taxonomy slug
 *
 * @param array  $args Array of taxonomy arguments.
 * @param string $taxonomy The taxonomy slug.
 * @return array
 */
function kayo_change_band_taxonomies_slug( $args, $taxonomy ) {
	if ( 'band' === $taxonomy ) {
		$args['rewrite']['slug'] = 'artist-releases';
	}
	return $args;
}
add_filter( 'register_taxonomy_args', 'kayo_change_band_taxonomies_slug', 10, 2 );

/**
 * Rewrite band taxonomy slug
 *
 * @param array  $args Array of taxonomy arguments.
 * @param string $taxonomy The taxonomy slug.
 * @return array
 */
function kayo_band_url_rewrite() {
	add_rewrite_rule( '^artist-releases/([^/]*)$', 'index.php?band=$matches[1]', 'top' );
	flush_rewrite_rules();
}
add_action( 'admin_init', 'kayo_band_url_rewrite' );

/**
 * Set video display
 *
 * @param string $string
 * @return string
 */
function kayo_set_video_display( $string ) {

	return 'grid';
}
add_filter( 'kayo_mod_video_display', 'kayo_set_video_display', 44 );

/**
 * Set events template folder
 */
function kayo_set_events_template_url( $template_url ) {

	return kayo_get_template_url() . '/events/';
}
add_filter( 'wolf_events_template_url', 'kayo_set_events_template_url' );

/**
 * Set events template folder
 */
function kayo_set_events_date_format( $date_format ) {

	return 'default';
}
add_filter( 'we_date_format', 'kayo_set_events_date_format' );


/**
 * Returns large
 */
function kayo_set_large_metro_thumbnail_size() {
	return 'large';
}

/**
 * Filter metro thumnail size depending on row context
 */
function kayo_optimize_metro_thumbnail_size( $atts ) {

	$column_type   = isset( $atts['column_type'] ) ? $atts['column_type'] : null;
	$content_width = isset( $atts['content_width'] ) ? $atts['content_width'] : null;

	if ( 'column' === $column_type ) {
		if ( 'full' === $content_width || 'large' === $content_width ) {
			add_filter( 'kayo_metro_thumbnail_size_name', 'kayo_set_large_metro_thumbnail_size' );
		}
	}
}
add_action( 'wvc_add_row_filters', 'kayo_optimize_metro_thumbnail_size', 10, 1 );

/* Remove metro thumbnail size filter */
add_action(
	'wvc_remove_row_filters',
	function() {
		remove_filter( 'kayo_metro_thumbnail_size_name', 'kayo_set_large_metro_thumbnail_size' );
	}
);

/**
 * Get available display options for posts
 *
 * @return array
 */
function kayo_set_post_display_options() {

	return array(
		// 'masonry_modern' => esc_html__( 'Masonry', 'kayo' ),
		'standard'     => esc_html__( 'Standard', 'kayo' ),
		'grid_classic' => esc_html__( 'Grid', 'kayo' ),
	);
}
add_filter( 'kayo_post_display_options', 'kayo_set_post_display_options' );

/**
 * Get available display options for releases
 *
 * @return array
 */
function kayo_set_release_display_options() {

	return array(
		'grid'    => esc_html__( 'Grid', 'kayo' ),
		'metro'   => esc_html__( 'Metro', 'kayo' ),
		'lateral' => esc_html__( 'Lateral', 'kayo' ),
	);
}
add_filter( 'kayo_release_display_options', 'kayo_set_release_display_options' );

/**
 * Get available display options for events
 *
 * @return array
 */
function kayo_set_event_display_options() {

	return array(
		'list' => esc_html__( 'List', 'kayo' ),
		// 'grid' => esc_html__( 'Grid', 'kayo' ),
	);
}
add_filter( 'kayo_event_display_options', 'kayo_set_event_display_options' );

/**
 * Filter post modules
 *
 * @param array $atts
 * @return array $atts
 */
function kayo_filter_post_module_atts( $atts ) {

	$post_type           = $atts['post_type'];
	$affected_post_types = array( 'release', 'work' );

	if ( in_array( $post_type, $affected_post_types ) ) {
		if ( isset( $atts[ $post_type . '_display' ] ) && 'offgrid' === $atts[ $post_type . '_display' ] ) {
			$atts['item_animation']         = '';
			$atts[ $post_type . '_layout' ] = 'standard';
		}
	}

	if ( isset( $atts[ $post_type . '_hover_effect' ] ) ) {

		if ( 'simple' === $atts[ $post_type . '_hover_effect' ] ) {
			// $atts[ $post_type . '_layout' ] = 'overlay';
		}

		if ( 'cursor' === $atts[ $post_type . '_hover_effect' ] ) {

			$atts[ $post_type . '_layout' ] = 'standard';

			if ( 'list' === $post_type . '_display' ) {
				$atts[ $post_type . '_display' ] = 'grid';
			}
		}

		if ( 'border' === $atts[ $post_type . '_hover_effect' ] ) {
			$atts[ $post_type . '_layout' ] = 'overlay';
			$atts['overlay_color']          = '';
			// $atts[ $post_type . '_display' ] = 'grid';
		}

		if ( 'zoom' === $atts[ $post_type . '_hover_effect' ] ) {
			$atts[ $post_type . '_layout' ] = 'overlay';
			$atts['overlay_color']          = '';
			// $atts[ $post_type . '_display' ] = 'grid';
		}

		if ( 'slide-up' === $atts[ $post_type . '_hover_effect' ] ) {
			$atts[ $post_type . '_layout' ] = 'overlay';
		}
	}

	return $atts;
}
add_filter( 'kayo_post_module_atts', 'kayo_filter_post_module_atts' );

/**
 *  Set default row skin
 *
 * @param string $font_color
 * @return string $font_color
 */
function kayo_set_default_wvc_row_font_color( $font_color ) {

	// check main skin?
	return 'dark';
}
add_filter( 'wvc_default_row_font_color', 'kayo_set_default_wvc_row_font_color', 40 );

/**
 * No header post types
 *
 * @param  array $post_types Post types where the default hero block is disabled.
 * @return array
 */
function kayo_filter_no_hero_post_types( $post_types ) {

	$post_types = array( 'product', 'attachment' );

	return $post_types;
}
add_filter( 'kayo_no_header_post_types', 'kayo_filter_no_hero_post_types', 40 );

function kayo_show_shop_header_content_block_single_product( $bool ) {

	if ( is_singular( 'product' ) ) {
		$bool = true;
	}

	return $bool;
}
add_filter( 'kayo_force_display_shop_after_header_block', 'kayo_show_shop_header_content_block_single_product' );

/**
 * Read more text
 */
function kayo_view_post_text( $string ) {
	return esc_html__( 'Read more', 'kayo' );
}
add_filter( 'kayo_view_post_text', 'kayo_view_post_text' );

/**
 * Filter empty p tags in excerpt
 */
function kayo_filter_excerpt_empty_p_tags( $excerpt ) {

	return str_replace( '<p></p>', '', $excerpt );

}
add_filter( 'get_the_excerpt', 'kayo_filter_excerpt_empty_p_tags', 100 );

/**
 *  Set entry slider animation
 *
 * @param string $animation
 * @return string $animation
 */
function kayo_set_entry_slider_animation( $animation ) {
	return 'slide';
}
add_filter( 'kayo_entry_slider_animation', 'kayo_set_entry_slider_animation', 40 );

/**
 * Discography "band" text
 */
function wolf_set_discography_band_string( $string ) {
	return esc_html__( 'Artist', 'kayo' );
}
add_filter( 'wolf_discography_band_string', 'wolf_set_discography_band_string', 40 );

/**
 * Search form placeholder
 */
function kayo_set_searchform_placeholder( $string ) {
	return esc_attr_x( 'Search&hellip;', 'placeholder', 'kayo' );
}
add_filter( 'kayo_searchform_placeholder', 'kayo_set_searchform_placeholder', 40 );

/**
 * View more events text
 */
function kayo_view_more_events_text( $string ) {
	return esc_html__( 'View more dates', 'kayo' );
}
add_filter( 'kayo_view_more_events_text', 'kayo_view_more_events_text' );

/**
 * Search form placeholder text
 */
function kayo_searchform_placeholder_text( $string ) {
	return esc_html__( 'Type your search and hit enter&hellip;', 'kayo' );
}
add_filter( 'kayo_searchform_placeholder', 'kayo_searchform_placeholder_text' );

/**
 * Add form in no result page
 */
function kayo_add_no_result_form() {
	get_search_form();
}
add_action( 'kayo_no_result_end', 'kayo_add_no_result_form' );

/**
 * Post Slider color tone
 */
function kayo_add_post_slider_color_block() {
	?>
	<div class="wvc-big-slide-color-block" style="background-color:<?php echo wvc_color_brightness( wvc_get_image_dominant_color( get_post_thumbnail_id() ), 10 ); ?>"></div>
	<?php
}
// add_action( 'wvc_post_big_slide_start', 'kayo_add_post_slider_color_block' );

/**
 * Remove unused mods
 *
 * @param array $mods The default mods.
 * @return void
 */
function kayo_remove_mods( $mods ) {

	// Unset
	unset( $mods['layout']['options']['button_style'] );
	unset( $mods['layout']['options']['site_layout'] );

	unset( $mods['fonts']['options']['body_font_size'] );

	unset( $mods['wolf_videos']['options']['video_display'] );

	unset( $mods['shop']['options']['product_display'] );

	unset( $mods['navigation']['options']['menu_hover_style'] );
	unset( $mods['navigation']['options']['menu_layout']['choices']['overlay'] );
	// unset( $mods['navigation']['options']['menu_layout']['choices']['lateral'] );
	unset( $mods['navigation']['options']['menu_layout']['choices']['offcanvas'] );
	unset( $mods['navigation']['options']['menu_skin'] );

	unset( $mods['header_settings']['options']['hero_scrolldown_arrow'] );

	// unset( $mods['blog']['options']['post_display'] );

	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_remove_mods', 20 );

/**
 * Add release hover effects
 */
function kayo_add_hover_effects() {
	if ( function_exists( 'vc_add_params' ) ) {
		vc_add_params(
			'wvc_release_index',
			array(
				array(
					'heading'     => esc_html__( 'Hover Effect', 'kayo' ),
					'param_name'  => 'release_hover_effect',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Simple', 'kayo' ) => 'simple',
						// esc_html__( 'Zoom', 'kayo' ) => 'default',
						esc_html__( 'Slide Up', 'kayo' ) => 'slide-up',
						// esc_html__( 'Trim', 'kayo' ) => 'border',
						esc_html__( 'Title Following Cursor', 'kayo' ) => 'cursor',
					),
					'dependency'  => array(
						'element'            => 'release_display',
						'value_not_equal_to' => array( 'lateral' ),
					),
					'admin_label' => true,
				),
			)
		);

		vc_add_params(
			'wvc_work_index',
			array(
				array(
					'heading'     => esc_html__( 'Hover Effect', 'kayo' ),
					'param_name'  => 'work_hover_effect',
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Simple', 'kayo' ) => 'simple',
						// esc_html__( 'Zoom', 'kayo' ) => 'default',
						esc_html__( 'Slide Up', 'kayo' ) => 'slide-up',
						// esc_html__( 'Trim', 'kayo' ) => 'border',
						esc_html__( 'Title Following Cursor', 'kayo' ) => 'cursor',
					),
					'dependency'  => array(
						'element' => 'work_display',
						'value'   => array( 'grid', 'metro', 'masonry' ),
					),
					'admin_label' => true,
				),
			)
		);
	}
}
add_action( 'init', 'kayo_add_hover_effects' );

/**
 * Set release taxonomy before string
 *
 * @param  string $string String to append before release taxonomy.
 * @return string
 */
function kayo_set_release_tax_before( $string ) {

	return esc_html__( 'by', 'kayo' ) . ' ';

}
add_filter( 'kayo_release_tax_before', 'kayo_set_release_tax_before' );

/**
 * Secondary navigation hook
 *
 * Display cart icons, social icons or secondary menu depending on cuzstimizer option
 */
function kayo_output_mobile_complementary_menu( $context = 'desktop' ) {
	if ( 'mobile' === $context ) {
		$cta_content = kayo_get_inherit_mod( 'menu_cta_content_type', 'none' );

		/**
		 * Force shop icons on woocommerce pages
		 */
		$is_wc_page_child = is_page() && wp_get_post_parent_id( get_the_ID() ) == kayo_get_woocommerce_shop_page_id() && kayo_get_woocommerce_shop_page_id(); // phpcs:ignore
		$is_wc            = kayo_is_woocommerce_page() || is_singular( 'product' ) || $is_wc_page_child;

		if ( apply_filters( 'kayo_force_display_nav_shop_icons', $is_wc ) ) { // can be disable just in case.
			$cta_content = 'shop_icons';
		}

		if ( 'shop_icons' === $cta_content ) {
			if ( kayo_display_account_menu_item() ) :
				?>
				<div class="account-container cta-item">
					<?php
						/**
						 * account icon
						 */
						kayo_account_menu_item();
					?>
				</div><!-- .cart-container -->
				<?php
			endif;

			if ( kayo_display_cart_menu_item() ) {
				?>
				<div class="cart-container cta-item">
					<?php
						/**
						 * Cart icon
						 */
						kayo_cart_menu_item();
					?>
				</div><!-- .cart-container -->
				<?php
			}
		}
	}
}
add_action( 'kayo_secondary_menu', 'kayo_output_mobile_complementary_menu', 10, 1 );

if ( ! function_exists( 'kayo_release_meta' ) ) {
	/**
	 * Display release meta
	 */
	function kayo_release_meta() {

		if ( ! class_exists( 'Wolf_Discography' ) ) {
			return;
		}

		$meta            = wd_get_meta();
		$release_title   = $meta['title'];
		$release_date    = $meta['date'];
		$release_catalog = $meta['catalog'];
		$release_format  = $meta['format'];
		$artists         = get_the_terms( get_the_ID(), 'band' );
		$artist_tax      = get_taxonomy( 'band' );
		$genre           = get_the_terms( get_the_ID(), 'release_genre' );
		$genre_tax       = get_taxonomy( 'release_genre' );
		$rewrite         = '';
		$artist_tax_slug = '';
		$genre_tax_slug  = '';

		if ( taxonomy_exists( 'band' ) && isset( $artist_tax->rewrite['slug'] ) ) {

			$artist_tax_slug = $artist_tax->rewrite['slug'];
		}

		if ( taxonomy_exists( 'release_genre' ) && isset( $genre_tax->rewrite['slug'] ) ) {

			$genre_tax_slug = $genre_tax->rewrite['slug'];
		}

		// Date
		if ( $release_date ) :
			?>
		<strong><?php esc_html_e( 'Release Date', 'kayo' ); ?></strong> : <?php echo sanitize_text_field( $release_date ); ?><br>
		<?php endif; ?>

		<?php
		if ( $artists ) {
			$artist_label = ( 1 < count( $artists ) ) ? esc_html__( 'Artists', 'kayo' ) : esc_html__( 'Artist', 'kayo' );
			?>
				<strong><?php echo sanitize_text_field( $artist_label ); ?></strong> :
				<?php
				$artists_html = '';
				foreach ( $artists as $artist ) {
					$artist_slug   = $artist->slug;
					$artist_name   = $artist->name;
					$artists_html .= '<a href="' . esc_url( home_url( '/' . $artist_tax_slug . '/' . $artist_slug ) ) . '">' . sanitize_text_field( $artist_name ) . '</a>, ';
				}

				echo rtrim( $artists_html, ', ' );
				echo '<br>';
		}
		?>
		<?php

		if ( $genre ) {
			$genre_label = ( 1 < count( $genre ) ) ? esc_html__( 'Genres', 'kayo' ) : esc_html__( 'Genre', 'kayo' );
			?>
				<strong><?php echo sanitize_text_field( $genre_label ); ?></strong> :
				<?php
				$genre_html = '';
				foreach ( $genre as $g ) {
					// debug( $g );
					$genre_slug  = $g->slug;
					$genre_name  = $g->name;
					$genre_html .= '<a href="' . esc_url( home_url( '/' . $genre_tax_slug . '/' . $genre_slug ) ) . '">' . sanitize_text_field( $genre_name ) . '</a>, ';
				}

				echo rtrim( $genre_html, ', ' );
				echo '<br>';
		}
		?>
		<?php
		// Catalog number
		if ( $release_catalog ) :
			?>
		<strong><?php esc_html_e( 'Catalog ref.', 'kayo' ); ?></strong> : <?php echo sanitize_text_field( $release_catalog ); ?><br>
		<?php endif; ?>

		<?php
		// Type
		if ( $release_format && wolf_get_release_option( 'display_format' ) ) :
			?>
		<strong><?php esc_html_e( 'Format', 'kayo' ); ?></strong> : <?php echo sanitize_text_field( $release_format ); ?><br>
		<?php endif; ?>
		<?php
		edit_post_link( esc_html__( 'Edit', 'kayo' ), '<span class="edit-link">', '</span>' );
	}
}

/**
 * Remove unused mods
 *
 * @param array $mods The default mods.
 * @return void
 */
function kayo_unset_mods( $mods ) {

	// Unset
	unset( $mods['shop']['options']['product_display'] );
	unset( $mods['navigation']['options']['menu_hover_style'] );
	unset( $mods['blog']['options']['post_display']['choices']['mosaic'] );
	unset( $mods['blog']['options']['post_display']['choices']['grid'] );

	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_unset_mods', 20 );

/**
 *  Set default button shape
 *
 * @param string $shape
 * @return string $shape
 */
function kayo_set_default_wvc_button_shape( $shape ) {
	return 'boxed';
}
add_filter( 'wvc_default_button_shape', 'kayo_set_default_wvc_button_shape', 40 );

/**
 *  Set default button shape
 *
 * @param string $shape
 * @return string $shape
 */
function kayo_set_default_theme_button_shape( $shape ) {
	return 'square';
}
add_filter( 'kayo_mod_button_style', 'kayo_set_default_theme_button_shape', 40 );

/**
 *  Set default button font weight
 *
 * @param string $shape
 * @return string $shape
 */
function kayo_set_default_wvc_button_font_weight( $value ) {
	return 700;
}
add_filter( 'wvc_button_default_font_weight', 'kayo_set_default_wvc_button_font_weight', 40 );

/**
 *  Set default team member layout
 *
 * @param string $layout
 * @return string $layout
 */
function wvc_set_default_team_member_layout( $value ) {
	return 'overlay';
}
add_filter( 'wvc_default_team_member_layout', 'wvc_set_default_team_member_layout', 40 );

/**
 *  Set default team member socials_args
 *
 * @param string $args
 * @return string $args
 */
function wvc_set_default_team_member_socials_args( $args ) {

	$args['background_style'] = 'rounded';
	$args['background_color'] = 'white';
	$args['custom_color']     = '#000000';
	$args['size']             = 'fa-1x';

	return $args;
}
add_filter( 'wvc_team_member_socials_args', 'wvc_set_default_team_member_socials_args', 40 );

/**
 *  Set default team member title font size
 *
 * @param string $font_size
 * @return string $font_size
 */
function wvc_set_default_team_member_font_size( $font_size ) {
	return 24;
}
add_filter( 'wvc_default_team_member_title_font_size', 'wvc_set_default_team_member_font_size', 40 );
add_filter( 'wvc_default_single_image_title_font_size', 'wvc_set_default_team_member_font_size', 40 );

/**
 *  Set default icon font
 *
 * @param string $shape
 * @return string $shape
 */
function kayo_set_default_icon_font( $shape ) {
	return 'dripicons-v2';
}
// add_filter( 'wvc_default_icon_font', 'kayo_set_default_icon_font', 40 );

/**
 * Added selector to menu_selectors
 *
 * @param  array $selectors navigation items CSS selectors.
 * @return array $selectors
 */
function kayo_add_menu_selectors( $selectors ) {

	$selectors[] = '.category-filter ul li a';
	$selectors[] = '.cart-panel-buttons a';

	return $selectors;
}
add_filter( 'kayo_menu_selectors', 'kayo_add_menu_selectors' );
/**
 * Added selector to heading_family_selectors
 *
 * @param  array $selectors headings related CSS selectors.
 * @return array $selectors
 */
function kayo_add_heading_family_selectors( $selectors ) {

	$selectors[] = '.wvc-tabs-menu li a';
	$selectors[] = '.woocommerce-tabs ul.tabs li a';
	$selectors[] = '.wvc-process-number';
	$selectors[] = '.wvc-button';
	$selectors[] = '.wvc-svc-item-title';
	$selectors[] = '.button';
	$selectors[] = '.onsale, .category-label';
	// $selectors[] = '.entry-post-grid_classic .sticky-post';
	$selectors[] = 'input[type=submit], .wvc-mailchimp-submit';
	$selectors[] = '.nav-next,.nav-previous';
	$selectors[] = '.wvc-embed-video-play-button';
	// $selectors[] = '.category-filter ul li';
	$selectors[] = '.wvc-ati-title';
	$selectors[] = '.wvc-team-member-role';
	$selectors[] = '.wvc-svc-item-tagline';
	$selectors[] = '.entry-metro insta-username';
	$selectors[] = '.wvc-testimonial-cite';
	$selectors[] = '.kayo-button-';
	$selectors[] = '.kayo-button-simple';
	$selectors[] = '.wvc-wc-cat-title';
	$selectors[] = '.wvc-pricing-table-button a';
	// $selectors[] = '.load-more-button-line';
	$selectors[] = '.view-post';
	$selectors[] = '.wolf-gram-follow-button';
	$selectors[] = '#kayo-percent';
	$selectors[] = '.wvc-workout-program-title';
	$selectors[] = '.wvc-meal-title';
	$selectors[] = '.wvc-recipe-title';
	$selectors[] = '.wvc-pie-counter';
	$selectors[] = '.we-date-format-custom';
	$selectors[] = '.comment-reply-link';
	$selectors[] = '.logo-text';

	return $selectors;
}
add_filter( 'kayo_heading_family_selectors', 'kayo_add_heading_family_selectors' );

/**
 * Added selector to heading_family_selectors
 *
 * @param  array $selectors headings related CSS selectors.
 * @return array $selectors
 */
function kayo_add_kayo_heading_selectors( $selectors ) {

	$selectors[] = '.wvc-tabs-menu li a';
	$selectors[] = '.woocommerce-tabs ul.tabs li a';
	$selectors[] = '.wvc-process-number';
	$selectors[] = '.wvc-svc-item-title';
	$selectors[] = '.wvc-wc-cat-title';
	$selectors[] = '.logo-text';

	return $selectors;
}
add_filter( 'kayo_heading_selectors', 'kayo_add_kayo_heading_selectors' );

/**
 * Filter heading attribute
 *
 * @param array $atts
 * @return array $atts
 */
function woltheme_filter_heading_atts( $atts ) {

	// heading
	if ( isset( $atts['style'] ) ) {
		$atts['el_class'] = $atts['el_class'] . ' ' . $atts['style'];
	}

	return $atts;
}
add_filter( 'wvc_heading_atts', 'woltheme_filter_heading_atts' );

/**
 *  Set embed video title
 *
 * @param string $title
 * @return string $title
 */
function wvc_set_embed_video_title( $title ) {

	return esc_html__( '&mdash; %s', 'kayo' );
}
add_filter( 'wvc_embed_video_title', 'wvc_set_embed_video_title', 40 );

/**
 *  Set default pie chart line width
 *
 * @param string $width
 * @return string $width
 */
function wvc_set_default_pie_chart_line_width( $width ) {

	return 15;
}
add_filter( 'wvc_default_pie_chart_line_width', 'wvc_set_default_pie_chart_line_width', 40 );

/**
 *  Set embed video title
 *
 * @param string $title
 * @return string $title
 */
function kayo_set_default_video_opener_button( $title ) {

	return '<span class="video-opener" data-aos="fade" data-aos-once="true"></span>';
}
// add_filter( 'wvc_default_video_opener_button', 'kayo_set_default_video_opener_button', 40 );

/**
 * Standard row width
 */
add_filter(
	'wvc_row_standard_width',
	function( $string ) {
		return '1300px';
	},
	40
);

/**
 * Load more pagination hash change
 */
add_filter(
	'kayo_loadmore_pagination_hashchange',
	function( $size ) {
		return false;
	},
	40
);

/**
 *  Set cat list icon
 *
 * @param string $icon
 * @return string $icon
 */
function kayo_set_entry_cat_list_icon( $icon ) {

	return '<span class="post-meta-prefix">' . esc_html__( 'In', 'kayo' ) . '</span>';
}
add_filter( 'kayo_entry_category_list_icon', 'kayo_set_entry_cat_list_icon', 40 );

/**
 *  Set tag list icon
 *
 * @param string $icon
 * @return string $icon
 */
function kayo_set_entry_tag_list_icon( $icon ) {

	return '<span class="post-meta-prefix">' . esc_html__( 'Tagged as', 'kayo' ) . '</span>';
}
add_filter( 'kayo_entry_tag_list_icon', 'kayo_set_entry_tag_list_icon', 40 );

/**
 *  Set entry author prefix
 *
 * @param string $icon
 * @return string $icon
 */
function kayo_set_author_name_meta( $author_name ) {

	return sprintf( esc_html__( 'By %s', 'kayo' ), '<span class="author-name">' . $author_name . '</span>' );
}
add_filter( 'kayo_author_name_meta', 'kayo_set_author_name_meta', 40 );

/**
 *  Set default heading font size
 *
 * @param int $font_size
 * @return int $font_size
 */
function wvc_set_default_custom_heading_font_size( $font_size ) {
	return 22;
}
add_filter( 'wvc_default_custom_heading_font_size', 'wvc_set_default_custom_heading_font_size', 40 );
add_filter( 'wvc_default_advanced_slide_title_font_size', 'wvc_set_default_custom_heading_font_size', 40 );

/**
 *  Set default heading font size
 *
 * @param string $font_size
 * @return string $font_size
 */
function wvc_set_default_cta_font_size( $font_size ) {
	return 22;
}
add_filter( 'wvc_default_cta_font_size', 'wvc_set_default_cta_font_size', 40 );

/**
 * Primary Special buttons class
 *
 * @param string $string
 * @return string
 */
function kayo_set_primary_special_button_class( $class ) {

	$kayo_button_class = 'kayo-button-primary';

	$class = $kayo_button_class . ' wvc-button wvc-button-size-sm';

	return $class;
}
add_filter( 'wvc_last_posts_big_slide_button_class', 'kayo_set_primary_special_button_class' );

/**
 * Primary Special buttons class
 *
 * @param string $string
 * @return string
 */
function kayo_set_primary_special_button_outline( $class ) {

	$kayo_button_class = 'kayo-button-primary';

	$class = $kayo_button_class . ' wvc-button wvc-button-size-sm';

	return $class;
}
add_filter( 'kayo_loadmore_button_class', 'kayo_set_primary_special_button_outline' );

/**
 * Primary Outline buttons class
 *
 * @param string $string
 * @return string
 */
function kayo_set_primary_button_class( $class ) {

	$kayo_button_class = 'kayo-button-primary';

	$class = $kayo_button_class . ' wvc-button wvc-button-size-sm';

	return $class;
}
add_filter( 'kayo_404_button_class', 'kayo_set_primary_button_class' );
add_filter( 'kayo_single_event_buy_ticket_button_class', 'kayo_set_primary_button_class' );

/**
 * Event ticket button class
 *
 * @param string $string
 * @return string
 */
function kayo_set_event_ticket_button_class( $class ) {

	$kayo_button_class = 'kayo-button-primary';

	$class = $kayo_button_class . ' wvc-button wvc-button-size-xs ticket-button';

	return $class;
}
add_filter( 'we_ticket_link_class', 'kayo_set_event_ticket_button_class', 40 );

/**
 * Main buttons class
 *
 * @param string $string
 * @return string
 */
function kayo_set_alt_button_class( $class ) {

	$kayo_button_class = 'kayo-button-primary';

	$class = $kayo_button_class . ' wvc-button wvc-button-size-xs';

	return $class;
}
add_filter( 'kayo_release_button_class', 'kayo_set_alt_button_class' );

/**
 * Text buttons class
 *
 * @param string $string
 * @return string
 */
function kayo_set_more_link_button_class( $class ) {

	$kayo_button_class = 'kayo-button-simple';

	$class = $kayo_button_class . ' wvc-button wvc-button-size-xs';

	return $class;
}
add_filter( 'kayo_more_link_button_class', 'kayo_set_more_link_button_class' );
add_filter( 'wvc_showcase_vertical_carousel_button_class', 'kayo_set_more_link_button_class' );

/**
 * Author box buttons class
 *
 * @param string $string
 * @return string
 */
function kayo_set_author_box_button_class( $class ) {

	$class = ' wvc-button wvc-button-size-xs kayo-button-primary';

	return $class;
}
add_filter( 'kayo_author_page_link_button_class', 'kayo_set_author_box_button_class' );


/**
 * Excerpt more
 *
 * Add span to allow more CSS tricks
 *
 * @return string
 */
function kayo_custom_more_text( $string ) {

	$text = '<span>' . esc_html__( 'Continue reading', 'kayo' ) . '</span>';

	return $text;
}
add_filter( 'kayo_more_text', 'kayo_custom_more_text', 40 );

/**
 * Set related posts text
 *
 * @param string $string
 * @return string
 */
function kayo_set_related_posts_text( $text ) {

	return esc_html__( 'More Posts', 'kayo' );
}
add_filter( 'kayo_related_posts_text', 'kayo_set_related_posts_text' );

/**
 *  Set default item overlay color
 *
 * @param string $color
 * @return string $color
 */
function kayo_set_default_item_overlay_color( $color ) {

	return 'accent';
}
add_filter( 'wvc_default_item_overlay_color', 'kayo_set_default_item_overlay_color', 40 );

/**
 *  Set default item overlay text color
 *
 * @param string $color
 * @return string $color
 */
function kayo_set_item_overlay_text_color( $color ) {
	return 'white';
}
add_filter( 'wvc_default_item_overlay_text_color', 'kayo_set_item_overlay_text_color', 40 );

/**
 *  Set default item overlay opacity
 *
 * @param int $color
 * @return int $color
 */
function kayo_set_item_overlay_opacity( $opacity ) {
	return 100;
}
add_filter( 'wvc_default_item_overlay_opacity', 'kayo_set_item_overlay_opacity', 40 );

/**
 * Excerpt length hook
 * Set the number of character to display in the excerpt
 *
 * @param int $length
 * @return int
 */
function kayo_overwrite_excerpt_length( $length ) {

	return 23;
}
add_filter( 'kayo_excerpt_length', 'kayo_overwrite_excerpt_length' );

/**
 *  Set menu skin
 *
 * @param string $skin
 * @return string $skin
 */
function kayo_set_menu_skin( $skin ) {
	return 'light';
}
add_filter( 'kayo_mod_menu_skin', 'kayo_set_menu_skin', 40 );

/**
 *  Set playlist skin
 *
 * @param string $skin
 * @return string $skin
 */
function kayo_set_defaul_playlist_skin( $skin ) {
	return 'light';
}
add_filter( 'wvc_default_playlist_skin', 'kayo_set_defaul_playlist_skin' );

/**
 * Excerpt length hook
 * Set the number of character to display in the excerpt
 *
 * @param int $length
 * @return int
 */
function kayo_overwrite_sticky_menu_height( $length ) {

	return 66;
}
add_filter( 'kayo_sticky_menu_height', 'kayo_overwrite_sticky_menu_height' );

/**
 * Set menu hover effect
 *
 * @param string $string
 * @return string
 */
function kayo_set_menu_hover_style( $string ) {
	return 'opacity';
}
add_filter( 'kayo_mod_menu_hover_style', 'kayo_set_menu_hover_style' );


/**
 * Get available display options for products
 *
 * @return array
 */
function kayo_set_product_display_options() {

	return array(
		'grid_overlay' => esc_html__( 'Grid', 'kayo' ),
		// 'metro' => esc_html__( 'Metro', 'kayo' ),
	);
}
add_filter( 'kayo_product_display_options', 'kayo_set_product_display_options' );

/**
 * Set shop display
 *
 * @param string $string
 * @return string
 */
function kayo_set_product_display( $string ) {

	return 'grid_overlay';
}
add_filter( 'kayo_mod_product_display', 'kayo_set_product_display', 40 );

/**
 * Filter sidebar footer class
 */
function kayo_set_sidebar_footer_class( $class ) {

	if ( 'light' === kayo_get_color_tone( kayo_get_theme_mod( 'footer_bg_color' ) ) ) {

		$class .= 'wvc-font-dark';

	} else {
		$class .= 'wvc-font-light';
	}

	return $class;
}
add_filter( 'kayo_sidebar_footer_class', 'kayo_set_sidebar_footer_class' );

/**
 * Set team member social
 */
function kayo_set_team_member_socials( $socials ) {

	return array( 'facebook', 'twitter', 'instagram', 'youtube', 'spotify', 'soundcloud', 'bandsintown', 'vimeo', 'email' );
}
add_filter( 'wvc_team_member_socials', 'kayo_set_team_member_socials' );

/**
 * Add font option
 */
function kayo_add_fonts_options( $fonts ) {

	$fonts['Gotham'] = 'Gotham';

	return $fonts;
}
// add_filter( 'kayo_mods_fonts', 'kayo_add_fonts_options', 100 ); // add the fonts to the customizer
// add_filter( 'wvc_fonts', 'kayo_add_fonts_options', 100 ); // add the fonts to the Page Builder settings

/**
 * Overwrite hamburger icon
 */
function kayo_set_hamburger_icon( $html, $class, $title_attr ) {

	$title_attr = esc_html__( 'Menu', 'kayo' );

	ob_start();
	?>
	<a class="hamburger-icon <?php echo esc_attr( $class ); ?>" href="#" title="<?php echo esc_attr( $title_attr ); ?>">
		<span class="line line-first"></span>
		<span class="line line-second"></span>
		<span class="line line-third"></span>
	</a>
	<?php
	$html = ob_get_clean();

	return $html;

}
// add_filter( 'kayo_hamburger_icon', 'kayo_set_hamburger_icon', 10, 3 );

/**
 * Filter fullPage Transition
 *
 * @return array
 */
function kayo_set_fullpage_transition( $transition ) {

	if ( is_page() || is_single() ) {
		if ( get_post_meta( wvc_get_the_ID(), '_post_fullpage', true ) ) {
			$transition = get_post_meta( wvc_get_the_ID(), '_post_fullpage_transition', true );
		}
	}

	return $transition;
}
add_filter( 'wvc_fp_transition_effect', 'kayo_set_fullpage_transition' );

/**
 * Add mods
 */
function kayo_add_mods( $mods ) {

	$color_scheme = kayo_get_color_scheme();

	// $mods['layout']['options']['custom_cursor'] = array(
	// 'id' => 'custom_cursor',
	// 'label' => esc_html__( 'Custom Cursor', 'kayo' ),
	// 'type' => 'checkbox',
	// );

	$mods['loading'] = array(

		'id'      => 'loading',
		'title'   => esc_html__( 'Loading', 'kayo' ),
		'icon'    => 'update',
		'options' => array(

			array(
				'label'   => esc_html__( 'Loading Animation Type', 'kayo' ),
				'id'      => 'loading_animation_type',
				'type'    => 'select',
				'choices' => array(
					'none'    => esc_html__( 'None', 'kayo' ),
					'overlay' => esc_html__( 'Overlay', 'kayo' ),
					'kayo'    => esc_html__( 'Overlay with animation', 'kayo' ),
				),
			),

			// 'loading_logo' => array(
			// 'type' => 'image',
			// 'label' => esc_html__( 'Loading Logo', 'kayo' ),
			// 'id' => 'loading_logo',
			// 'description' => esc_html__( 'For the overlay with logo loading animation.', 'kayo' ),
			// 'label' => esc_html__( 'Loading Text', 'kayo' ),
			// ),

			// array(
			// 'label' => esc_html__( 'Loading Logo Animation', 'kayo' ),
			// 'id' => 'loading_logo_animation',
			// 'type' => 'select',
			// 'choices' => array(
			// 'none'   => esc_html__( 'None', 'kayo' ),
		 // 'pulse' => esc_html__( 'Pulse', 'kayo' ),
			// ),
			// ),
		),
	);

	$mods['blog']['options']['post_hero_layout'] = array(
		'label'   => esc_html__( 'Single Post Header Layout', 'kayo' ),
		'id'      => 'post_hero_layout',
		'type'    => 'select',
		'choices' => array(
			''           => esc_html__( 'Default', 'kayo' ),
			'standard'   => esc_html__( 'Standard', 'kayo' ),
			'big'        => esc_html__( 'Big', 'kayo' ),
			'small'      => esc_html__( 'Small', 'kayo' ),
			'fullheight' => esc_html__( 'Full Height', 'kayo' ),
			'none'       => esc_html__( 'No header', 'kayo' ),
		),
	);

	// $mods['navigation']['options']['ajax_nav'] = array(
	// 'label' => esc_html__( 'AJAX Navigation', 'kayo' ),
	// 'id'    => 'ajax_nav',
	// 'type'  => 'checkbox',
	// );

	// $mods['navigation']['options']['nav_bar_bg_img'] = array(
	// 'label' => esc_html__( 'Sticky Navigation Bar Background', 'kayo' ),
	// 'id'    => 'nav_bar_bg_img',
	// 'type'  => 'image',
	// );

	// $mods['navigation']['options']['mega_menu_bg_img'] = array(
	// 'label' => esc_html__( 'Mega Menu Background', 'kayo' ),
	// 'id'    => 'mega_menu_bg_img',
	// 'type'  => 'image',
	// );

	// $mods['navigation']['options']['side_panel_bg_img'] = array(
	// 'label' => esc_html__( 'Side Panel Background', 'kayo' ),
	// 'id'    => 'side_panel_bg_img',
	// 'type'  => 'image',
	// );

	// $mods['navigation']['options']['overlay_menu_bg_img'] = array(
	// 'label' => esc_html__( 'Overlay Menu Background', 'kayo' ),
	// 'id'    => 'overlay_menu_bg_img',
	// 'type'  => 'image',
	// );

	// $mods['navigation']['options']['lateral_menu_bg_img'] = array(
	// 'label' => esc_html__( 'Lateral Menu Background', 'kayo' ),
	// 'id'    => 'lateral_menu_bg_img',
	// 'type'  => 'image',
	// );

	// $mods['navigation']['options']['mobile_menu_bg_img'] = array(
	// 'label' => esc_html__( 'Mobile Menu Background', 'kayo' ),
	// 'id'    => 'mobile_menu_bg_img',
	// 'type'  => 'image',
	// );

	if ( isset( $mods['wolf_videos'] ) ) {
		$mods['wolf_videos']['options']['video_hero_layout'] = array(
			'label'   => esc_html__( 'Single Video Header Layout', 'kayo' ),
			'id'      => 'video_hero_layout',
			'type'    => 'select',
			'choices' => array(
				''           => esc_html__( 'Default', 'kayo' ),
				'standard'   => esc_html__( 'Standard', 'kayo' ),
				'big'        => esc_html__( 'Big', 'kayo' ),
				'small'      => esc_html__( 'Small', 'kayo' ),
				'fullheight' => esc_html__( 'Full Height', 'kayo' ),
				'none'       => esc_html__( 'No header', 'kayo' ),
			),
		);

		$mods['wolf_videos']['options']['video_category_filter'] = array(
			'id'    => 'video_category_filter',
			'label' => esc_html__( 'Category filter (not recommended with a lot of videos)', 'kayo' ),
			'type'  => 'checkbox',
		);

		$mods['wolf_videos']['options']['products_per_page'] = array(
			'label' => esc_html__( 'Videos per Page', 'kayo' ),
			'id'    => 'videos_per_page',
			'type'  => 'text',
		);

		$mods['wolf_videos']['options']['video_pagination'] = array(
			'id'      => 'video_pagination',
			'label'   => esc_html__( 'Video Archive Pagination', 'kayo' ),
			'type'    => 'select',
			'choices' => array(
				'standard_pagination' => esc_html__( 'Numeric Pagination', 'kayo' ),
				// 'ajax_pagination' => esc_html__( 'AJAX Pagination', 'kayo' ),
				'load_more'           => esc_html__( 'Load More Button', 'kayo' ),
				// 'infinitescroll' => esc_html__( 'Infinite Scroll', 'kayo' ),
			),
		);

		$mods['wolf_videos']['options']['video_display_elements'] = array(
			'id'          => 'video_display_elements',
			'label'       => esc_html__( 'Post meta to show in single video page', 'kayo' ),
			'type'        => 'group_checkbox',
			'choices'     => array(
				'show_date'       => esc_html__( 'Date', 'kayo' ),
				'show_author'     => esc_html__( 'Author', 'kayo' ),
				'show_category'   => esc_html__( 'Category', 'kayo' ),
				'show_tags'       => esc_html__( 'Tags', 'kayo' ),
				'show_extra_meta' => esc_html__( 'Extra Meta', 'kayo' ),
			),
			'description' => esc_html__( 'Note that some options may be ignored depending on the post display.', 'kayo' ),
		);

		if ( class_exists( 'Wolf_Custom_Post_Meta' ) ) {

			$mods['wolf_videos']['options'][] = array(
				'label'   => esc_html__( 'Enable Custom Post Meta', 'kayo' ),
				'id'      => 'video_enable_custom_post_meta',
				'type'    => 'group_checkbox',
				'choices' => array(
					'video_enable_views' => esc_html__( 'Views', 'kayo' ),
					'video_enable_likes' => esc_html__( 'Likes', 'kayo' ),
				),
			);
		}
	}

	if ( isset( $mods['wolf_discography'] ) ) {

		$mods['wolf_discography']['options']['release_hero_layout'] = array(
			'label'   => esc_html__( 'Single Release Header Layout', 'kayo' ),
			'id'      => 'release_hero_layout',
			'type'    => 'select',
			'choices' => array(
				''           => esc_html__( 'Default', 'kayo' ),
				'standard'   => esc_html__( 'Standard', 'kayo' ),
				'big'        => esc_html__( 'Big', 'kayo' ),
				'small'      => esc_html__( 'Small', 'kayo' ),
				'fullheight' => esc_html__( 'Full Height', 'kayo' ),
				'none'       => esc_html__( 'No header', 'kayo' ),
			),
			// 'transport' => 'postMessage',
		);
	}

	if ( isset( $mods['portfolio'] ) ) {
		$mods['portfolio']['options']['work_hero_layout'] = array(
			'label'   => esc_html__( 'Single Work Header Layout', 'kayo' ),
			'id'      => 'work_hero_layout',
			'type'    => 'select',
			'choices' => array(
				''           => esc_html__( 'Default', 'kayo' ),
				'standard'   => esc_html__( 'Standard', 'kayo' ),
				'big'        => esc_html__( 'Big', 'kayo' ),
				'small'      => esc_html__( 'Small', 'kayo' ),
				'fullheight' => esc_html__( 'Full Height', 'kayo' ),
				'none'       => esc_html__( 'No header', 'kayo' ),
			),
		);
	}

	if ( isset( $mods['wolf_events'] ) ) {

		$mods['wolf_events']['options']['event_hero_layout'] = array(
			'label'   => esc_html__( 'Single Event Header Layout', 'kayo' ),
			'id'      => 'event_hero_layout',
			'type'    => 'select',
			'choices' => array(
				''           => esc_html__( 'Default', 'kayo' ),
				'standard'   => esc_html__( 'Standard', 'kayo' ),
				'big'        => esc_html__( 'Big', 'kayo' ),
				'small'      => esc_html__( 'Small', 'kayo' ),
				'fullheight' => esc_html__( 'Full Height', 'kayo' ),
				'none'       => esc_html__( 'No header', 'kayo' ),
			),
			// 'transport' => 'postMessage',
		);
	}

	if ( isset( $mods['portfolio'] ) ) {

		$mods['portfolio']['options']['work_hero_layout'] = array(
			'label'   => esc_html__( 'Single Work Header Layout', 'kayo' ),
			'id'      => 'work_hero_layout',
			'type'    => 'select',
			'choices' => array(
				''           => esc_html__( 'Default', 'kayo' ),
				'standard'   => esc_html__( 'Standard', 'kayo' ),
				'big'        => esc_html__( 'Big', 'kayo' ),
				'small'      => esc_html__( 'Small', 'kayo' ),
				'fullheight' => esc_html__( 'Full Height', 'kayo' ),
				'none'       => esc_html__( 'No header', 'kayo' ),
			),
			// 'transport' => 'postMessage',
		);
	}

	if ( isset( $mods['shop'] ) && class_exists( 'WooCommerce' ) ) {
		$mods['shop']['options']['product_sticky'] = array(
			'label'       => esc_html__( 'Stacked Images with Sticky Product Details', 'kayo' ),
			'id'          => 'product_sticky',
			'type'        => 'checkbox',
			'description' => esc_html__( 'Not compatible with sidebar layouts.', 'kayo' ),
		);
	}

	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_add_mods', 40 );

/**
 * Disable single post pagination
 *
 * @param bool $bool
 * @return bool
 */
add_filter( 'kayo_disable_single_post_pagination', '__return_true' );

/**
 * Disable single post pagination
 *
 * @param bool $bool
 * @return bool
 */
function kayo_disable_single_post_pagination_background( $bool ) {
	return false;

}
// add_filter( 'kayo_enable_single_post_pagination_backgrounds', 'kayo_disable_single_post_pagination_background' );

/**
 * Force show loading overlay
 *
 * @param bool $bool
 * @return bool
 */
function kayo_force_display_loading_overlay( $bool ) {
	return false;
}
add_filter( 'kayo_display_loading_overlay', 'kayo_force_display_loading_overlay' );

/**
 * Force show loading logo
 *
 * @param bool $bool
 * @return bool
 */
function kayo_force_display_loading_logo( $bool ) {
	return true;
}
add_filter( 'kayo_display_loading_logo', 'kayo_force_display_loading_logo' );

/**
 * Set page loaded delay
 *
 * @param int $int
 * @return int
 */
function kayo_set_page_loaded_delay( $int ) {

	if ( 'kayo' === kayo_get_inherit_mod( 'loading_animation_type' ) ) {
		$int = 2000;
	}

	return $int;
}
add_filter( 'kayo_page_loaded_delay', 'kayo_set_page_loaded_delay' );

/**
 * Set sticky menu scrollpoint
 *
 * @param int $int
 * @return int
 */
function kayo_set_sticky_menu_scrollpoint( $int ) {

	return 200;
}
add_filter( 'kayo_sticky_menu_scrollpoint', 'kayo_set_sticky_menu_scrollpoint' );

/**
 * Custom button types
 */
function kayo_custom_button_types() {
	return array(
		esc_html__( 'Default', 'kayo' )     => 'default',
		// esc_html__( 'Special', 'kayo' ) => 'kayo-button-special-primary',
		// esc_html__( 'Special Outline', 'kayo' ) => 'kayo-button-special-outline',
		esc_html__( 'Primary', 'kayo' )     => 'kayo-button-primary',
		// esc_html__( 'Primary Alt', 'kayo' ) => 'kayo-button-primary-alt',
		esc_html__( 'Simple Text', 'kayo' ) => 'kayo-button-simple',
		// esc_html__( 'Simple Text Alt', 'kayo' ) => 'kayo-button-simple-alt',
	);
}

/**
 * Custom backgorund effect output
 */
function kayo_output_row_bg_effect( $html ) {

	ob_start();
	?>
	<div class="kayo-bg-overlay"></div>
	<?php
	$html = ob_get_clean();

	return $html;
}
add_filter( 'wvc_background_effect', 'kayo_output_row_bg_effect' );

/**
 *  Add kayo background effect
 *
 * @param string $effects
 * @return string $effects
 */
function kayo_add_wvc_custom_background_effect( $effects ) {

	if ( function_exists( 'vc_add_param' ) ) {
		vc_add_param(
			'vc_row',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Film Grain Effect', 'kayo' ),
				'param_name' => 'add_effect',
				'group'      => esc_html__( 'Style', 'kayo' ),
			)
		);

		vc_add_param(
			'vc_column',
			array(
				'type'       => 'checkbox',
				'heading'    => esc_html__( 'Add Film Grain Effect', 'kayo' ),
				'param_name' => 'add_effect',
				'group'      => esc_html__( 'Style', 'kayo' ),
			)
		);
	}
}
// add_action( 'init', 'kayo_add_wvc_custom_background_effect' );

/**
 * Remove some params
 */
function kayo_remove_vc_params() {

	if ( function_exists( 'vc_remove_param' ) ) {

		vc_remove_param( 'wvc_product_index', 'product_display' );
		vc_remove_param( 'wvc_product_index', 'product_text_align' );

		vc_remove_param( 'wvc_event_index', 'event_display' );
		vc_remove_param( 'wvc_event_index', 'event_module' );
		vc_remove_param( 'wvc_event_index', 'grid_padding' );
		vc_remove_param( 'wvc_event_index', 'overlay_color' );
		vc_remove_param( 'wvc_event_index', 'overlay_custom_color' );
		vc_remove_param( 'wvc_event_index', 'overlay_text_color' );
		vc_remove_param( 'wvc_event_index', 'overlay_custom_text_color' );
		vc_remove_param( 'wvc_event_index', 'overlay_opacity' );
		vc_remove_param( 'wvc_event_index', 'event_thumbnail_size' );

		vc_remove_param( 'wvc_work_index', 'caption_text_alignment' );
		vc_remove_param( 'wvc_release_index', 'caption_text_alignment' );

		vc_remove_param( 'wvc_work_index', 'work_category_filter_text_alignment' );
		vc_remove_param( 'wvc_release_index', 'release_category_filter_text_alignment' );
		vc_remove_param( 'wvc_video_index', 'video_category_filter_text_alignment' );

		vc_remove_param( 'wvc_interactive_links', 'align' );
		vc_remove_param( 'wvc_interactive_links', 'v_align' );
		vc_remove_param( 'wvc_interactive_links', 'display' );
		vc_remove_param( 'wvc_interactive_overlays', 'align' );
		vc_remove_param( 'wvc_interactive_overlays', 'display' );

		vc_remove_param( 'wvc_audio_button', 'color' );
		vc_remove_param( 'wvc_audio_button', 'custom_color' );
		vc_remove_param( 'wvc_audio_button', 'shape' );
		vc_remove_param( 'wvc_audio_button', 'style' );
		vc_remove_param( 'wvc_audio_button', 'size' );
		// vc_remove_param( 'wvc_audio_button', 'align' );
		vc_remove_param( 'wvc_audio_button', 'button_block' );
		vc_remove_param( 'wvc_audio_button', 'hover_effect' );
		vc_remove_param( 'wvc_audio_button', 'font_weight' );
		vc_remove_param( 'wvc_audio_button', 'scroll_to_anchor' );

		vc_remove_param( 'wvc_testimonial_slide', 'avatar' );
	}
}
add_action( 'init', 'kayo_remove_vc_params' );

/**
 * Audio button simple markup
 */
function kayo_filter_audio_button_markup( $markup, $atts ) {

	$class = ( isset( $atts['el_class'] ) ) ? $atts['el_class'] : '';

	$align  = isset( $atts['align'] ) ? $atts['align'] : 'center';
	$class .= ' align-' . $align;

	$output = '';

	if ( 'inline' !== $align ) {
		$output .= '<div>';
	}

	$output .= '<a href="#" class="wvc-audio-button audio-simple-button ' . $class . '"><span>Play</span></a>';

	if ( 'inline' !== $align ) {
		$output .= '</div>';
	}

	return $output;

}
add_filter( 'wvc_audio_button_html', 'kayo_filter_audio_button_markup', 10, 2 );

/**
 * Add button dependencies
 */
function kayo_add_button_dependency_params() {

	if ( ! class_exists( 'WPBMap' ) || ! class_exists( 'Wolf_Visual_Composer' ) || ! defined( 'WVC_OK' ) || ! WVC_OK ) {
		return;
	}

	$param               = WPBMap::getParam( 'vc_button', 'color' );
	$param['dependency'] = array(
		'element' => 'button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'vc_button', $param );

	$param               = WPBMap::getParam( 'vc_button', 'shape' );
	$param['dependency'] = array(
		'element' => 'button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'vc_button', $param );

	$param               = WPBMap::getParam( 'vc_button', 'hover_effect' );
	$param['dependency'] = array(
		'element' => 'button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'vc_button', $param );

	$param               = WPBMap::getParam( 'vc_cta', 'btn_color' );
	$param['dependency'] = array(
		'element' => 'btn_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'vc_cta', $param );

	$param               = WPBMap::getParam( 'vc_cta', 'btn_shape' );
	$param['dependency'] = array(
		'element' => 'btn_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'vc_cta', $param );

	$param               = WPBMap::getParam( 'vc_cta', 'btn_hover_effect' );
	$param['dependency'] = array(
		'element' => 'btn_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'vc_cta', $param );

	$param               = WPBMap::getParam( 'wvc_advanced_slide', 'b1_color' );
	$param['dependency'] = array(
		'element' => 'b1_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'wvc_advanced_slide', $param );

	$param               = WPBMap::getParam( 'wvc_advanced_slide', 'b1_shape' );
	$param['dependency'] = array(
		'element' => 'b1_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'wvc_advanced_slide', $param );

	$param               = WPBMap::getParam( 'wvc_advanced_slide', 'b1_hover_effect' );
	$param['dependency'] = array(
		'element' => 'b1_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'wvc_advanced_slide', $param );

	$param               = WPBMap::getParam( 'wvc_advanced_slide', 'b2_color' );
	$param['dependency'] = array(
		'element' => 'b2_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'wvc_advanced_slide', $param );

	$param               = WPBMap::getParam( 'wvc_advanced_slide', 'b2_shape' );
	$param['dependency'] = array(
		'element' => 'b2_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'wvc_advanced_slide', $param );

	$param               = WPBMap::getParam( 'wvc_advanced_slide', 'b2_hover_effect' );
	$param['dependency'] = array(
		'element' => 'b2_button_type',
		'value'   => 'default',
	);
	vc_update_shortcode_param( 'wvc_advanced_slide', $param );
}
add_action( 'init', 'kayo_add_button_dependency_params', 15 );

/**
 * Filter button attribute
 *
 * @param array $atts
 * @return array $atts
 */
function woltheme_filter_button_atts( $atts ) {

	// button
	if ( isset( $atts['button_type'] ) && 'default' !== $atts['button_type'] ) {
		$atts['shape']        = '';
		$atts['color']        = '';
		$atts['hover_effect'] = '';
		$atts['el_class']    .= ' ' . $atts['button_type'];
	}

	return $atts;
}
add_filter( 'wvc_button_atts', 'woltheme_filter_button_atts' );

/**
 * Filter CTA button attribute
 *
 * @param array $atts the shortcode atts we get
 * @param array $btn_params the button attribute to filter
 * @return array $btn_params
 */
function woltheme_filter_cta_button_atts( $btn_params, $atts ) {

	// button
	if ( isset( $atts['btn_button_type'] ) && 'default' !== $atts['btn_button_type'] ) {
		$btn_params['shape']        = '';
		$btn_params['color']        = '';
		$btn_params['hover_effect'] = '';
		$btn_params['el_class']    .= ' ' . $atts['btn_button_type'];
	}

	return $btn_params;
}
add_filter( 'wvc_cta_button_atts', 'woltheme_filter_cta_button_atts', 10, 2 );

/**
 * Filter advanced slider button 1 attribute
 *
 * @param array $atts the shortcode atts we get
 * @param array $b1_params the button attribute to filter
 * @return array $b1_params
 */
function woltheme_filter_b1_button_atts( $b1_params, $atts ) {

	// button
	if ( isset( $atts['b1_button_type'] ) && 'default' !== $atts['b1_button_type'] ) {
		$b1_params['shape']        = '';
		$b1_params['color']        = '';
		$b1_params['hover_effect'] = '';
		$b1_params['el_class']    .= ' ' . $atts['b1_button_type'];
	}

	return $b1_params;
}
add_filter( 'wvc_advanced_slider_b1_button_atts', 'woltheme_filter_b1_button_atts', 10, 2 );

/**
 * Filter advanced slider button 1 attribute
 *
 * @param array $atts the shortcode atts we get
 * @param array $b2_params the button attribute to filter
 * @return array $b2_params
 */
function woltheme_filter_b2_button_atts( $b2_params, $atts ) {

	// button
	if ( isset( $atts['b2_button_type'] ) && 'default' !== $atts['b2_button_type'] ) {
		$b2_params['shape']        = '';
		$b2_params['color']        = '';
		$b2_params['hover_effect'] = '';
		$b2_params['el_class']    .= ' ' . $atts['b2_button_type'];
	}

	return $b2_params;
}
add_filter( 'wvc_advanced_slider_b2_button_atts', 'woltheme_filter_b2_button_atts', 10, 2 );

/**
 * Add theme button option to Button element
 */
function kayo_add_theme_buttons() {

	if ( function_exists( 'vc_add_params' ) ) {
		vc_add_params(
			'vc_button',
			array(
				array(
					'heading'    => esc_html__( 'Button Type', 'kayo' ),
					'param_name' => 'button_type',
					'type'       => 'dropdown',
					'value'      => kayo_custom_button_types(),
					'weight'     => 1000,
				),
			)
		);

		vc_add_params(
			'vc_cta',
			array(
				array(
					'heading'    => esc_html__( 'Button Type', 'kayo' ),
					'param_name' => 'btn_button_type',
					'type'       => 'dropdown',
					'value'      => kayo_custom_button_types(),
					'weight'     => 10,
					'group'      => esc_html__( 'Button', 'kayo' ),
				),
			)
		);

		vc_add_params(
			'wvc_advanced_slide',
			array(
				array(
					'heading'    => esc_html__( 'Button Type', 'kayo' ),
					'param_name' => 'b1_button_type',
					'type'       => 'dropdown',
					'value'      => kayo_custom_button_types(),
					'weight'     => 10,
					'group'      => esc_html__( 'Button 1', 'kayo' ),
					'dependency' => array(
						'element' => 'add_button_1',
						'value'   => array( 'true' ),
					),
				),
			)
		);

		vc_add_params(
			'wvc_advanced_slide',
			array(
				array(
					'heading'    => esc_html__( 'Button Type', 'kayo' ),
					'param_name' => 'b2_button_type',
					'type'       => 'dropdown',
					'value'      => kayo_custom_button_types(),
					'weight'     => 10,
					'group'      => esc_html__( 'Button 2', 'kayo' ),
					'dependency' => array(
						'element' => 'add_button_2',
						'value'   => array( 'true' ),
					),
				),
			)
		);

		vc_add_params(
			'vc_custom_heading',
			array(
				array(
					'heading'    => esc_html__( 'Style', 'kayo' ),
					'param_name' => 'style',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Default', 'kayo' ) => '',
						esc_html__( 'Theme Style', 'kayo' ) => 'kayo-heading',
					),
					'weight'     => 10,
				),
			)
		);
	}
}
add_action( 'init', 'kayo_add_theme_buttons' );

/**
 * Page grid thumbnail size
 */
function kayo_set_page_grid_overlay_thumbnail_size( $size ) {

	return array( 565, 220 );

}
add_filter( 'kayo_page_grid_overlay_thumbnail_size', 'kayo_set_page_grid_overlay_thumbnail_size' );
add_filter( 'kayo_page_grid_thumbnail_size', 'kayo_set_page_grid_overlay_thumbnail_size' );

/**
 * Add single audio skins
 */
function kayo_add_single_audio_skins() {
	if ( function_exists( 'vc_add_params' ) ) {
		vc_add_params(
			'wvc_audio',
			array(
				array(
					'heading'    => esc_html__( 'Skin', 'kayo' ),
					'param_name' => 'skin',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Dark', 'kayo' ) => 'default',
						esc_html__( 'Transparent', 'kayo' ) => 'transparent',
					),
				),
			)
		);
	}
}
add_action( 'init', 'kayo_add_single_audio_skins' );

/**
 * Add style option to tabs element
 */
function kayo_add_vc_accordion_and_tabs_options() {
	// if ( function_exists( 'vc_add_params' ) ) {
	// vc_add_params(
	// 'vc_tabs',
	// array(
	// array(
	// 'heading' => esc_html__( 'Background', 'kayo' ),
	// 'param_name' => 'background',
	// 'type' => 'dropdown',
	// 'value' => array(
	// esc_html__( 'Border', 'kayo' ) => 'solid',
	// esc_html__( 'No Border', 'kayo' ) => 'transparent',
	// ),
	// 'weight' => 1000,
	// ),
	// )
	// );
	// }

	if ( function_exists( 'vc_add_params' ) ) {
		vc_add_params(
			'vc_accordion',
			array(
				array(
					'heading'    => esc_html__( 'Background', 'kayo' ),
					'param_name' => 'background',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Solid', 'kayo' ) => 'solid',
						esc_html__( 'Transparent', 'kayo' ) => 'transparent',
					),
					'weight'     => 1000,
				),
			)
		);
	}
}
add_action( 'init', 'kayo_add_vc_accordion_and_tabs_options' );

/**
 * Filter tabs shortcode attribute
 */
function kayo_add_vc_tabs_params( $params ) {

	if ( isset( $params['background'] ) ) {
		$params['el_class'] = $params['el_class'] . ' wvc-tabs-background-' . $params['background'];
	}

	return $params;
}
add_filter( 'shortcode_atts_vc_tabs', 'kayo_add_vc_tabs_params' );

/**
 * Filter accordion shortcode attribute
 */
function kayo_add_vc_accordion_params( $params ) {

	if ( isset( $params['background'] ) ) {
		$params['el_class'] = $params['el_class'] . ' wvc-accordion-background-' . $params['background'];
	}

	return $params;
}
add_filter( 'shortcode_atts_vc_accordion', 'kayo_add_vc_accordion_params' );


/**
 * Add additional JS scripts and functions
 */
function kayo_enqueue_additional_scripts() {

	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : kayo_get_theme_version();

	if ( ! kayo_is_wolf_extension_activated() ) {

		wp_register_style( 'dripicons', get_template_directory_uri() . '/assets/css/lib/fonts/dripicons-v2/dripicons.min.css', array(), kayo_get_theme_version() );

		wp_register_style( 'elegant-icons', get_template_directory_uri() . '/assets/css/lib/fonts/elegant-icons/elegant-icons.min.css', array(), kayo_get_theme_version() );

		wp_register_style( 'kayo-icons', get_template_directory_uri() . '/assets/css/lib/fonts/kayo-icons/kayo-icons.min.css', array(), kayo_get_theme_version() );

		wp_register_script( 'countup', get_template_directory_uri() . '/assets/js/lib/countUp.min.js', array(), '1.9.3', true );
	}

	if ( is_singular( 'event' ) && kayo_is_wolf_extension_activated() ) {
		wp_enqueue_style( 'wolficons' );
	}

	wp_enqueue_style( 'dripicons' );
	wp_enqueue_style( 'elegant-icons' );
	wp_enqueue_style( 'font-awesome' );

	wp_enqueue_script( 'countup' );

	wp_enqueue_script( 'jquery-effects-core' );
	wp_enqueue_script( 'kayo-custom', get_template_directory_uri() . '/assets/js/t/kayo.js', array( 'jquery' ), $version, true );
}
add_action( 'wp_enqueue_scripts', 'kayo_enqueue_additional_scripts', 40 );

/**
 *  Filter WVC bg object fit
 *
 * Diable oject fit if "kayo" bg effect is used
 *
 * @param string $do_of
 * @return string $do_of
 */
function kayo_filters_wvc_bg_object_fit( $do_of, $args ) {

	if ( isset( $args['background_effect'] ) && 'kayo' === $args['background_effect'] ) {
		$do_of = false;
	}

	return $do_of;
}
// add_filter( 'wvc_bg_objectfit', 'kayo_filters_wvc_bg_object_fit', 10, 2 );

/**
 *  Set smooth scroll speed
 *
 * @param string $speed
 * @return string $speed
 */
function kayo_set_smooth_scroll_speed( $speed ) {
	return 1500;
}
add_filter( 'kayo_smooth_scroll_speed', 'kayo_set_smooth_scroll_speed' );
add_filter( 'wvc_smooth_scroll_speed', 'kayo_set_smooth_scroll_speed' );

/**
 *  Set smooth scroll easing effect
 *
 * @param string $ease
 * @return string $ease
 */
function kayo_set_smooth_scroll_ease( $ease ) {
	return 'easeOutCubic';
}
add_filter( 'kayo_smooth_scroll_ease', 'kayo_set_smooth_scroll_ease' );
add_filter( 'wvc_smooth_scroll_ease', 'kayo_set_smooth_scroll_ease' );
add_filter( 'wvc_fp_easing', 'kayo_set_smooth_scroll_ease' );

/**
 * Add mobile alt body class
 *
 * @param array
 * @return array
 */
function kayo_additional_body_classes( $classes ) {

	$classes[] = 'mobile-menu-alt';

	$sticky_details_meta   = kayo_get_inherit_mod( 'product_sticky' ) && 'no' !== kayo_get_inherit_mod( 'product_sticky' );
	$single_product_layout = kayo_get_inherit_mod( 'product_single_layout' );

	if ( is_singular( 'product' ) && $sticky_details_meta && 'sidebar-right' !== $single_product_layout && 'sidebar-left' !== $single_product_layout ) {
		$classes[] = 'sticky-product-details';
	}

	if ( kayo_get_theme_mod( 'custom_cursor' ) ) {
		$classes[] = 'custom-cursor-enabled';
	}

	return $classes;

}
add_filter( 'body_class', 'kayo_additional_body_classes' );

/**
 * Save modal window content after import
 */
function kayo_set_modal_window_content_after_import() {
	$post = get_page_by_title( 'Modal Window Content', OBJECT, 'wvc_content_block' );

	if ( $post && function_exists( 'wvc_update_option' ) ) {
		wvc_update_option( 'modal_window', 'content_block_id', $post->ID );
	}
}
add_action( 'pt-ocdi/after_import', 'kayo_set_modal_window_content_after_import' );

/**
 * Filter lightbox settings
 */
function kayo_filter_lightbox_settings( $settings ) {

	$settings['transitionEffect'] = 'fade';
	$settings['buttons']          = array(
		'zoom',
		// 'share',
		'close',
	);

	return $settings;
}
add_filter( 'kayo_fancybox_settings', 'kayo_filter_lightbox_settings' );

/**
 * Add label
 */
function kayo_add_single_product_page_label() {

	$output = '';
	$label  = get_post_meta( get_the_ID(), '_post_product_mp3_label', true );

	if ( $label ) {
		echo '<span class="single-product-song-label">' . $label . '</span>';
	}

	echo kayo_kses( $output );
}
add_action( 'woocommerce_single_product_summary', 'kayo_add_single_product_page_label', 15 );

/**
 * Returns CSS for the color schemes.
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function kayo_edit_color_scheme_css( $output, $colors ) {

	extract( $colors );

	$output = '';

	$overlay_accent_bg_color = sprintf( 'rgba( %s, 0.95)', kayo_hex_to_rgb( $accent_color ) );
	$border_color            = sprintf( 'rgba( %s, 0.03)', kayo_hex_to_rgb( $strong_text_color ) );
	$overlay_panel_bg_color  = sprintf( 'rgba( %s, 0.95)', kayo_hex_to_rgb( $submenu_background_color ) );

	$link_selector       = '.link, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):not(.gallery-quickview)';
	$link_selector_after = '.link:after, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):not(.gallery-quickview):after';

	$output .= "/* Color Scheme */

	/* Body Background Color */
	body,
	.frame-border{
		background-color: $body_background_color;
	}

	/* Page Background Color */
	.site-header,
	.post-header-container,
	.content-inner,
	#logo-bar,
	.nav-bar,
	.loading-overlay,
	.no-hero #hero,
	.wvc-font-default,
	#topbar{
		background-color: $page_background_color;
	}

	.spinner:before,
	.spinner:after{
		background-color: $page_background_color;
	}

	/* Submenu color */
	#site-navigation-primary-desktop .mega-menu-panel,
	#site-navigation-primary-desktop ul.sub-menu,
	#mobile-menu-panel,
	.offcanvas-menu-panel,
	.lateral-menu-panel,
	.cart-panel{
		background:$submenu_background_color;
	}

	.cart-panel{
		background:$submenu_background_color!important;
	}

	.panel-closer-overlay{
		background:$submenu_background_color;
	}

	.overlay-menu-panel{
		background:$overlay_panel_bg_color;
	}

	/* Sub menu Font Color */
	.nav-menu-desktop li ul li:not(.menu-button-primary):not(.menu-button-secondary) .menu-item-text-container,
	.nav-menu-desktop li ul.sub-menu li:not(.menu-button-primary):not(.menu-button-secondary).menu-item-has-children > a:before,
	.nav-menu-desktop li ul li.not-linked > a:first-child .menu-item-text-container{
		color: $submenu_font_color;
	}

	.cart-panel,
	.cart-panel a,
	.cart-panel strong,
	.cart-panel b{
		color: $submenu_font_color!important;
	}

	#close-side-panel-icon{
		color: $submenu_font_color!important;
	}

	.nav-menu-vertical li a,
	.nav-menu-mobile li a,
	.nav-menu-vertical li.menu-item-has-children:before,
	.nav-menu-vertical li.page_item_has_children:before,
	.nav-menu-vertical li.active:before,
	.nav-menu-mobile li.menu-item-has-children:before,
	.nav-menu-mobile li.page_item_has_children:before,
	.nav-menu-mobile li.active:before{
		color: $submenu_font_color!important;
	}

	.lateral-menu-panel .wvc-icon:before{
		color: $submenu_font_color!important;
	}

	.nav-menu-desktop li ul.sub-menu li.menu-item-has-children > a:before{
		color: $submenu_font_color;
	}

	.cart-panel,
	.cart-panel a,
	.cart-panel strong,
	.cart-panel b{
		color: $submenu_font_color!important;
	}

	/* Accent Color */
	.accent{
		color:$accent_color;
	}

	.accent-color-is-black .wvc-font-color-light .accent{
		color:white;
	}

	.logo-text:after{
		color:$accent_color;
	}

	#kayo-loading-point{
		color:$accent_color;
	}

	#kayo-cursor-dot{
		background-color:$accent_color;
	}

	.wvc-single-image-overlay-title span:after,
	.work-meta-value a:hover{
		color:$accent_color;
	}

	.nav-menu li.sale .menu-item-text-container:before,
	.nav-menu-mobile li.sale .menu-item-text-container:before
	{
		background:$accent_color!important;
	}

	.entry-post-standard:hover .entry-title,
	.entry-post-masonry_modern:hover .entry-title,
	.entry-post-grid_classic:hover .entry-title{
		color:$accent_color!important;
	}

	.entry-post-standard .entry-thumbnail-overlay{
		background-color:$overlay_accent_bg_color;
	}

	.widget_price_filter .ui-slider .ui-slider-range,
	mark,
	p.demo_store,
	.woocommerce-store-notice{
		background-color:$accent_color;
	}

	.widget_archive ul li a:before,
	.widget_categories ul li a:before,
	.widget_meta ul li a:before,
	.widget_nav_menu ul li a:before,
	.widget_product_categories ul li a:before{
		color:$accent_color;
	}

	.button-secondary{
		background-color:$accent_color;
		border-color:$accent_color;
	}

	.nav-menu li.menu-button-primary > a:first-child > .menu-item-inner{
		border-color:$accent_color;
		background-color:$accent_color;
	}

	.nav-menu li.menu-button-secondary > a:first-child > .menu-item-inner{
		border-color:$accent_color;
	}

	.nav-menu li.menu-button-secondary > a:first-child > .menu-item-inner:hover{
		background-color:$accent_color;
	}

	.fancybox-thumbs>ul>li:before{
		border-color:$accent_color;
	}

	.added_to_cart, .button, .button-download, .more-link, .wvc-mailchimp-submit, input[type=submit]{
		background-color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-background-color-accent{
		background-color:$accent_color;
	}

	.accent-color-is-black .wvc-font-color-light .wvc_bar_color_filler{
		background-color:white!important;
	}

	.wvc-highlight-accent{
		background-color:$accent_color;
		color:#fff;
	}

	.wvc-icon-background-color-accent{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-icon-background-color-accent .wvc-icon-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	.wvc-button-background-color-accent{
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-button-background-color-accent .wvc-button-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	.wvc-svg-icon-color-accent svg * {
		stroke:$accent_color!important;
	}

	.wvc-one-page-nav-bullet-tip{
		background-color: $accent_color;
	}

	.wvc-one-page-nav-bullet-tip:before{
		border-color: transparent transparent transparent $accent_color;
	}

	.accent,
	.comment-reply-link,
	.bypostauthor .avatar{
		color:$accent_color;
	}

	.wvc-button-color-button-accent,
	.more-link,
	.buton-accent{
		background-color: $accent_color;
		border-color: $accent_color;
	}

	.wvc-ils-active .wvc-ils-item-title:after,
	.wvc-interactive-link-item a:hover .wvc-ils-item-title:after {
	    color:$accent_color;
	}

	.wvc-io-active .wvc-io-item-title:after,
	.wvc-interactive-overlay-item a:hover .wvc-io-item-title:after {
	    color:$accent_color;
	}

	.widget.widget_categories a:hover,
	.widget.widget_pages a:hover,
	.widget .tagcloud a:hover,
	.widget.widget_recent_comments a:hover,
	.widget.widget_recent_entries a:hover,
	.widget.widget_archive a:hover,
	.widget.widget_meta a:hover,
	.widget.widget_product_categories a:hover,
	.widget.widget_nav_menu a:hover,
	a.rsswidget:hover{
		color:$accent_color!important;
	}

	.widget .tagcloud:before{
		 color:$accent_color;
	}

	.group_table td a:hover{
		color:$accent_color;
	}

	/* WVC icons */
	.wvc-icon-color-accent{
		color:$accent_color;
	}

	.wvc-icon-background-color-accent{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-icon-background-color-accent .wvc-icon-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	#ajax-progress-bar,
	.cart-icon-product-count{
		background:$accent_color;
	}

	.background-accent{
		background: $accent_color!important;
	}

	// .mejs-container .mejs-controls .mejs-time-rail .mejs-time-current,
	// .mejs-container .mejs-controls .mejs-time-rail .mejs-time-current, .mejs-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current{
	// 	background: $accent_color!important;
	// }

	.trigger{
		background-color: $accent_color!important;
		border : solid 1px $accent_color;
	}

	.bypostauthor .avatar {
		border: 3px solid $accent_color;
	}

	::selection {
		background: $accent_color;
	}
	::-moz-selection {
		background: $accent_color;
	}

	.spinner{
		color:$accent_color;
	}

	/*********************
		WVC
	***********************/

	.wvc-it-label{
		color:$accent_color;
	}

	.wvc-icon-box.wvc-icon-type-circle .wvc-icon-no-custom-style.wvc-hover-fill-in:hover, .wvc-icon-box.wvc-icon-type-square .wvc-icon-no-custom-style.wvc-hover-fill-in:hover {
		-webkit-box-shadow: inset 0 0 0 1em $accent_color;
		box-shadow: inset 0 0 0 1em $accent_color;
		border-color: $accent_color;
	}

	.wvc-pricing-table-featured-text,
	.wvc-pricing-table-featured .wvc-pricing-table-button a{
		background: $accent_color;
	}

	.wvc-pricing-table-featured .wvc-pricing-table-price,
	.wvc-pricing-table-featured .wvc-pricing-table-currency {
		color: $accent_color;
	}

	.wvc-pricing-table-featured .wvc-pricing-table-price-strike:before {
		background-color: $accent_color;
	}

	.wvc-team-member-social-container a:hover{
		color: $accent_color;
	}

	/* Main Text Color */
	body,
	.nav-label{
		color:$main_text_color;
	}

	.spinner-color, .sk-child:before, .sk-circle:before, .sk-cube:before{
		background-color: $main_text_color!important;
	}

	/* Strong Text Color */
	a,strong,
	.products li .price,
	.products li .star-rating,
	.wr-print-button,
	table.cart thead, #content table.cart thead{
		color: $strong_text_color;
	}

	.bit-widget-container,
	.entry-link{
		color: $strong_text_color;
	}

	.wr-stars>span.wr-star-voted:before, .wr-stars>span.wr-star-voted~span:before{
		color: $strong_text_color!important;
	}

	/* Border Color */
	.author-box,
	input[type=text],
	input[type=search],
	input[type=tel],
	input[type=time],
	input[type=url],
	input[type=week],
	input[type=password],
	input[type=checkbox],
	input[type=color],
	input[type=date],
	input[type=datetime],
	input[type=datetime-local],
	input[type=email],
	input[type=month],
	input[type=number],
	select,
	textarea{
		/*border-color:$border_color;*/
	}

	.widget-title,
	.woocommerce-tabs ul.tabs{
		border-bottom-color:$border_color;
	}

	.widget_layered_nav_filters ul li a{
		border-color:$border_color;
	}

	hr{
		background:$border_color;
	}
	";

	$link_selector_after  = '.link:after, .underline:after, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):after';
	$link_selector_before = '.link:before, .underline:before, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):before';

	$output .= "

		$link_selector_after,
		$link_selector_before{
			//background: $accent_color!important;
		}

		.category-filter ul li a:before{
			//background:$accent_color!important;
		}

		.category-label{
			//background:$accent_color!important;
		}

		.video-opener:after,
		.video-play-button:after{
			background-color: $accent_color;
		}

		.wvc-breadcrumb a:hover{
			color:$accent_color!important;
		}

		.nav-menu-desktop > li:not(.menu-button-primary):not(.menu-button-secondary) > a:first-child .menu-item-text-container:before{
			color:$accent_color;
		}

		.kayo-heading:after{
			color:$accent_color;
		}

		.wvc-mi-linked .wvc-mi-name{
			color:$accent_color;
		}

		.entry-mp-event .entry-container,
		.wvc-recipe-instructions o li:before,
		.wvc-recipe .wvc-recipe-counter-circle {
			background:$accent_color;
		}

		.accent-color-light .category-label{
			color:#333!important;
		}

		.accent-color-dark .category-label{
			color:#fff!important;
		}

		.accent-color-light #back-to-top:hover:before{
			color:#333!important;
		}

		.accent-color-dark #back-to-top:hover:before{
			color:#fff!important;
		}

		#back-to-top:after{
			background:$accent_color;
		}

		.coupon .button:hover{
			background:$accent_color!important;
			border-color:$accent_color!important;
		}

		.menu-item-fill{
			background:$accent_color!important;
		}

		.kayo-button-special-primary{
			border-color:$accent_color;
		}

		.kayo-button-special-primary:before{
			background-color:$accent_color;
		}

		.woocommerce-info .button,
		.woocommerce-message .button{
			background:$accent_color!important;
			border-color:$accent_color!important;
		}

		.kayo-button-primary{
			background-color:$accent_color;
			border-color:$accent_color;
		}

		.accent-color-is-black .wvc-font-light .kayo-button-primary{
			background-color:white;
			border-color:white;
			color:black;
		}

		.kayo-button-primary-alt:hover{
			background-color:$accent_color!important;
			border-color:$accent_color!important;

		}

		.kayo-button-simple{
			color:$accent_color;
		}

		.accent-color-is-black .wvc-font-light .kayo-button-simple{
			color:white;
		}

		.kayo-button-simple:after,
		.kayo-button-simple-alt:hover:after{
			background-color:$accent_color;
		}

		button.wvc-mailchimp-submit,
		.login-submit #wp-submit,
		.single_add_to_cart_button,
		.wc-proceed-to-checkout .button,
		.woocommerce-form-login .button,
		.woocommerce-alert .button,
		.woocommerce-message .button{
			background:$accent_color;
			border-color:$accent_color;
		}

		.audio-shortcode-container .mejs-container .mejs-controls > .mejs-playpause-button{
			//background:$accent_color;
		}

		.menu-hover-style-h-underline .nav-menu-desktop li a span.menu-item-text-container:after{
			background-color:$accent_color!important;
		}

		ul.wc-tabs li:hover:after,
		ul.wc-tabs li.ui-tabs-active:after,
		ul.wc-tabs li.active:after,
		ul.wvc-tabs-menu li:hover:after,
		ul.wvc-tabs-menu li.ui-tabs-active:after,
		ul.wvc-tabs-menu li.active:after
		{
			background-color:$accent_color!important;
		}

		.wvc-accordion-tab.ui-state-active{
			background-color:$accent_color!important;
		}

		.entry-product ins .woocommerce-Price-amount,
		.entry-single-product ins .woocommerce-Price-amount{
			color:$accent_color;
		}
	";

	$heading_selectors = apply_filters( 'kayo_heading_selectors', kayo_list_to_array( 'h1:not(.wvc-bigtext), h2:not(.wvc-bigtext), h3:not(.wvc-bigtext), h4:not(.wvc-bigtext), h5:not(.wvc-bigtext), .post-title, .entry-title, h2.entry-title > .entry-link, h2.entry-title, .widget-title, .wvc-counter-text, .wvc-countdown-period, .location-title, .logo-text, .wvc-interactive-links, .wvc-interactive-overlays, .heading-font' ) );

	$heading_selectors = kayo_array_to_list( $heading_selectors );
	$output           .= "$heading_selectors{text-rendering: auto;}";

	// If dark
	if ( preg_match( '/dark/', kayo_get_theme_mod( 'color_scheme' ) ) ) {
		$output .= ".wvc-background-color-default.wvc-font-light{
			background-color:$page_background_color;
		}";
	}

	// if light
	if ( preg_match( '/light/', kayo_get_theme_mod( 'color_scheme' ) ) ) {
		$output .= ".wvc-background-color-default.wvc-font-dark{
			background-color:$page_background_color;
		}";
	}

	return $output;
}
add_filter( 'kayo_color_scheme_output', 'kayo_edit_color_scheme_css', 10, 2 );

/**
 * Entry tag list separator
 *
 * @param string $string
 * @return string $string
 */
function kayo_set_entry_tag_list_separator( $string ) {

	$string = ', ';

	return $string;
}
add_action( 'kayo_entry_tag_list_separator', 'kayo_set_entry_tag_list_separator' );

/**
 * Filter single work title
 *
 * @param string $string
 * @return string
 */
function kayo_set_single_work_title( $string ) {

	return esc_html__( 'Details & Info', 'kayo' );
}
// add_filter( 'kayo_single_work_title', 'kayo_set_single_work_title', 40 );

/**
 * Add cusotm fields in work meta
 */
add_action(
	'kayo_work_meta',
	function() {
		kayo_the_work_meta();
	},
	15
);

add_filter(
	'kayo_work_meta_separator',
	function() {
		return ' : ';
	}
);

/**
 * Quickview product excerpt lenght
 */
add_filter(
	'wwcqv_excerpt_length',
	function() {
		return 28;
	}
);

/**
 * After quickview summary hook
 */
add_action(
	'wwcqv_product_summary',
	function() {
		?>
	<div class="single-add-to-wishlist">
		<span class="single-add-to-wishlist-label"><?php esc_html_e( 'Wishlist', 'kayo' ); ?></span>
		<?php kayo_add_to_wishlist(); ?>
	</div><!-- .single-add-to-wishlist -->
		<?php
	},
	20
);

/**
 * After summary hook
 */
add_action(
	'woocommerce_single_product_summary',
	function() {
		?>
	<div class="single-add-to-wishlist">
		<span class="single-add-to-wishlist-label"><?php esc_html_e( 'Wishlist', 'kayo' ); ?></span>
		<?php kayo_add_to_wishlist(); ?>
	</div><!-- .single-add-to-wishlist -->
		<?php
	},
	25
);

/**
 * Add MP3 player on single product page
 *
 * @return string
 */
function kayo_add_audio_player_on_single_product_page() {

	$output     = '';
	$audio_meta = get_post_meta( get_the_ID(), '_post_product_mp3', true );

	if ( $audio_meta ) {
		$audio_attrs = array(
			'src'      => esc_url( $audio_meta ),
			'loop'     => false,
			'autoplay' => false,
			'preload'  => 'auto',
		);

		$output = wp_audio_shortcode( $audio_attrs );
	}

	echo kayo_kses( $output );
}
add_action( 'woocommerce_single_product_summary', 'kayo_add_audio_player_on_single_product_page', 14 );

/**
 * Minimal player
 *
 * Displays a play/pause audio player on product grid
 */
function kayo_minimal_player( $post_id = null ) {
	$post_id    = ( $post_id ) ? $post_id : get_the_ID();
	$audio_meta = get_post_meta( get_the_ID(), '_post_product_mp3', true );
	$rand       = rand( 0, 99999 );

	if ( ! $audio_meta ) {
		return;
	}
	?>
	<a href="#" class="minimal-player-play-button">
	<i class="minimal-player-icon minimal-player-play"></i><i class="minimal-player-icon minimal-player-pause"></i>
	</a>
	<audio class="minimal-player-audio" id="minimal-player-audio-<?php echo absint( $rand ); ?>" src="<?php echo esc_url( $audio_meta ); ?> "></audio>
	<?php
}
/* Output player in loop */
add_action( 'kayo_product_minimal_player', 'kayo_minimal_player' );

/**
 * Overwrite release button
 */
function kayo_release_buttons( $html ) {

	$meta                = wd_get_meta();
	$release_itunes      = $meta['itunes'];
	$release_google_play = $meta['google_play'];
	$release_amazon      = $meta['amazon'];
	$release_spotify     = $meta['spotify'];
	$release_buy         = $meta['buy'];
	$release_free        = $meta['free'];

	$product_id = get_post_meta( get_the_ID(), '_post_wc_product_id', true );

	ob_start();
	?>
	<span class="wolf-release-buttons">
		<?php if ( $release_free ) : ?>
		<span class="wolf-release-button">
			<a class="wolf-release-free <?php echo apply_filters( 'kayo_release_button_class', 'button' ); ?>" title="<?php esc_html_e( 'Download Now', 'kayo' ); ?>" href="<?php echo esc_url( $release_free ); ?>"><?php esc_html_e( 'Free Download', 'kayo' ); ?></a>
		</span>
		<?php endif; ?>
		<?php if ( $release_spotify ) : ?>
		<span class="wolf-release-button">
			<a target="_blank" title="<?php printf( esc_html__( 'Listen on %s', 'kayo' ), 'Spotify' ); ?>" class="wolf-release-spotify <?php echo apply_filters( 'kayo_release_button_class', 'button' ); ?>" href="<?php echo esc_url( $release_spotify ); ?>"><?php esc_html_e( 'Spotify', 'kayo' ); ?></a>
		</span>
		<?php endif; ?>
		<?php if ( $release_itunes ) : ?>
		<span class="wolf-release-button">
			<a target="_blank" title="<?php printf( esc_html__( 'Buy on %s', 'kayo' ), 'iTunes' ); ?>" class="wolf-release-itunes <?php echo apply_filters( 'kayo_release_button_class', 'button' ); ?>" href="<?php echo esc_url( $release_itunes ); ?>"><?php esc_html_e( 'iTunes', 'kayo' ); ?></a>
		</span>
		<?php endif; ?>
		<?php if ( $release_amazon ) : ?>
		<span class="wolf-release-button">
			<a target="_blank" title="<?php printf( esc_html__( 'Buy on %s', 'kayo' ), 'amazon' ); ?>" class="wolf-release-amazon <?php echo apply_filters( 'kayo_release_button_class', 'button' ); ?>" href="<?php echo esc_url( $release_amazon ); ?>"><?php esc_html_e( 'Amazon', 'kayo' ); ?></a>
		</span>
		<?php endif; ?>
		<?php if ( $release_google_play ) : ?>
		<span class="wolf-release-button">
			<a target="_blank" title="<?php printf( esc_html__( 'Buy on %s', 'kayo' ), 'YouTube' ); ?>" class="wolf-release-google_play <?php echo apply_filters( 'kayo_release_button_class', 'button' ); ?>" href="<?php echo esc_url( $release_google_play ); ?>"><?php esc_html_e( 'YouTube', 'kayo' ); ?></a>
		</span>
		<?php endif; ?>
		<?php if ( $release_buy ) : ?>
		<span class="wolf-release-button">
			<a target="_blank" title="<?php esc_html_e( 'Buy Now', 'kayo' ); ?>" class="wolf-release-buy <?php echo apply_filters( 'kayo_release_button_class', 'button' ); ?>" href="<?php echo esc_url( $release_buy ); ?>"><?php esc_html_e( 'Buy', 'kayo' ); ?></a>
		</span>
		<?php endif; ?>
		<?php if ( $product_id && 0 != $product_id ) : ?>
			<span class="wolf-release-button">
				<?php echo kayo_add_to_cart( $product_id, 'wolf-release-add-to-cart ' . apply_filters( 'kayo_release_button_class', 'button' ), '<span class="wolf-release-add-to-cart-button-title" title="' . esc_html__( 'Add to cart', 'kayo' ) . '"></span>' ); ?>
			</span>
		<?php endif; ?>
	</span><!-- .wolf-release-buttons -->
	<?php
	$html = ob_get_clean();

	return $html;
}
add_filter( 'wolf_discography_release_buttons', 'kayo_release_buttons' );

if ( ! function_exists( 'kayo_gallery_meta' ) ) {
	/**
	 * Gallery meta
	 */
	function kayo_gallery_meta() {

		?>
		<a href="#" data-gallery-params="<?php echo esc_js( wp_json_encode( kayo_get_gallery_params() ) ); ?>" class="gallery-quickview" title="<?php esc_html_e( 'Quickview', 'kayo' ); ?>">
		<?php
			/**
			 * Photo count
			 */
			printf( esc_html__( '%d photos', 'kayo' ), kayo_get_first_gallery_image_count() );
		?>
		</a>
		<?php
		if ( get_the_term_list( get_the_ID(), 'gallery_type', '', ' / ', '' ) ) {
			?>
			<span class="gallery-meta-separator">&mdash;</span>
			<?php
				/**
				 * Gallery taxonomy
				 */
				echo get_the_term_list( get_the_ID(), 'gallery_type', '', ' / ', '' );

		}
	}
}

/*
----------------------------------------------------------------------------------

	Playlist function

--------------------------------------------------------------------------------------
*/

// add_theme_support( 'wpm_bar' );

/**
 * Can we display a player?
 *
 * @return bool
 */
function kayo_sticky_playlist_id() {
	if ( is_page() && get_post_meta( get_the_ID(), '_post_sticky_playlist_id', true ) ) {
		$playlist_id = get_post_meta( get_the_ID(), '_post_sticky_playlist_id', true );

		if ( $playlist_id && 'none' !== $playlist_id ) {
			return $playlist_id;
		}
	}
}

/**
 * Add body classes
 *
 * @param  array $classes
 * @return array
 */
function kayo_sticky_player_body_class( $classes ) {

	if ( kayo_sticky_playlist_id() ) {
		$classes[] = 'is-wpm-bar-player';
	}

	return $classes;
}
add_filter( 'body_class', 'kayo_sticky_player_body_class' );


/**
 * Output bottom bar holder
 *
 * @param  array $classes
 * @return array
 */
function kayo_output_sticky_playlist_holder() {

	if ( kayo_sticky_playlist_id() ) {
		echo '<div class="wpm-bar-holder"></div>';
	}
}
add_action( 'wp_footer', 'kayo_output_sticky_playlist_holder' );

/**
 * Output bottom bar player
 */
function kayo_output_sticky_playlist() {

	if ( kayo_sticky_playlist_id() ) {

		$playlist_id = kayo_sticky_playlist_id();
		$skin        = get_post_meta( get_the_ID(), '_post_sticky_playlist_skin', true );

		$attrs = array(
			'show_tracklist'   => false,
			'is_sticky_player' => true,
		);

		if ( $skin ) {
			$attrs['theme'] = $skin;
		}

		if ( function_exists( 'wpm_playlist' ) ) {
			wpm_playlist( $playlist_id, $attrs );
		}
	}
}
add_action( 'kayo_body_start', 'kayo_output_sticky_playlist' );

/*
=========================================
	Loop posts
==========================================*/
/**
 * Redefine post standard hook
 */
function kayo_remove_loop_post_default_hooks() {

	remove_action( 'kayo_before_post_content_standard_title', 'kayo_output_post_content_standard_date' );
	remove_action( 'kayo_after_post_content_standard', 'kayo_output_post_content_standard_meta' );

	add_action( 'kayo_before_post_content_standard_title', 'kayo_output_post_content_standard_top_meta', 10, 1 );

}
add_action( 'init', 'kayo_remove_loop_post_default_hooks' );

/**
 * Redefinesingle post hook
 */
function kayo_remove_single_post_default_hooks() {

	/**
	 * Remove default Hooks
	 */
	remove_action( 'kayo_post_content_start', 'kayo_add_custom_post_meta' );
	remove_action( 'kayo_post_content_end', 'kayo_ouput_single_post_taxonomy' );

	/**
	 * Add new hooks
	 */
	add_action( 'kayo_post_content_end', 'kayo_output_single_post_bottom_meta', 10, 1 );

}
add_action( 'init', 'kayo_remove_single_post_default_hooks' );

/**
 * Output single post meta
 */
function kayo_output_single_post_bottom_meta() {
	echo '<div class="single-post-meta-container wrap clearfix">';

		echo '<span class="single-post-date single-post-meta entry-date">';
	if ( 'human_diff' === kayo_get_theme_mod( 'date_format' ) ) {
		printf( esc_html__( 'Posted %s', 'kayo' ), kayo_entry_date( false ) );
	} else {
		printf( esc_html__( 'Posted On %s', 'kayo' ), kayo_entry_date( false ) );
	}
		echo '</span>';

		echo '<span class="single-post-taxonomy single-post-meta categories single-post-categories">';
			echo apply_filters( 'kayo_entry_category_list_icon', '<span class="meta-icon category-icon"></span>' );
			the_category( ', ' );
		echo '</span>';

		the_tags( '<span class="single-post-taxonomy single-post-meta tagcloud single-post-tagcloud">', '', '</span>' );

	echo '</div><!-- .single-post-meta -->';
}

/**
 * Add post meta before title
 */
function kayo_output_post_content_standard_top_meta( $post_display_elements ) {

	echo '<header class="entry-meta">';

	if ( in_array( 'show_date', $post_display_elements ) && '' == get_post_format() || 'video' === get_post_format() || 'gallery' === get_post_format() || 'image' === get_post_format() || 'audio' === get_post_format() ) {
		?>
		<span class="entry-date">
			<?php kayo_entry_date( true, true ); ?>
		</span>
		<?php
	}

	$show_author     = ( in_array( 'show_author', $post_display_elements ) );
	$show_category   = ( in_array( 'show_category', $post_display_elements ) );
	$show_tags       = ( in_array( 'show_tags', $post_display_elements ) );
	$show_extra_meta = ( in_array( 'show_extra_meta', $post_display_elements ) );
	?>
	<?php if ( ( $show_author || $show_extra_meta || $show_category || kayo_edit_post_link( false ) ) && ! kayo_is_short_post_format() ) : ?>

				<?php if ( $show_author ) : ?>
					<?php kayo_get_author_avatar(); ?>
				<?php endif; ?>
				<?php if ( $show_category ) : ?>
					<span class="entry-category-list">
						<?php echo apply_filters( 'kayo_entry_category_list_icon', '<span class="meta-icon category-icon"></span>' ); ?>
						<?php echo get_the_term_list( get_the_ID(), 'category', '', esc_html__( ', ', 'kayo' ), '' ); ?>
					</span>
				<?php endif; ?>
				<?php if ( $show_tags ) : ?>
					<?php kayo_entry_tags(); ?>
				<?php endif; ?>
				<?php if ( $show_extra_meta ) : ?>
					<?php kayo_get_extra_meta(); ?>
				<?php endif; ?>
				<?php kayo_edit_post_link(); ?>
		<?php endif; ?>
	<?php
	echo '</header>';
}

/**
 * Display sale label condition
 *
 * @param bool $bool
 * @return bool
 */
function kayo_do_show_sale_label( $bool ) {

	if ( get_post_meta( get_the_ID(), '_post_product_label', true ) ) {
		$bool = true;
	}

	return $bool;
}
add_filter( 'kayo_show_sale_label', 'kayo_do_show_sale_label' );

/**
 * Sale label text
 *
 * @param string $string
 * @return string
 */
function kayo_sale_label( $string ) {

	if ( get_post_meta( get_the_ID(), '_post_product_label', true ) ) {
		$string = '<span class="onsale">' . esc_attr( get_post_meta( get_the_ID(), '_post_product_label', true ) ) . '</span>';
	}

	return $string;
}
add_filter( 'woocommerce_sale_flash', 'kayo_sale_label' );

/**
 * Product quickview button
 *
 * @param string $string
 * @return string
 */
function kayo_output_product_quickview_button() {

	if ( function_exists( 'wolf_quickview_button' ) ) {
		$text = esc_html__( 'Quickview', 'kayo' );
		?>
		<a
		class="product-quickview-button wwcq-product-quickview-button"
		href="<?php the_permalink(); ?>"
		title="<?php echo esc_attr( $text ); ?>"
		rel="nofollow"
		data-product-title="<?php echo esc_attr( get_the_title() ); ?>"
		data-product-id="<?php the_ID(); ?>"><span><?php esc_html_e( 'Quickview', 'kayo' ); ?></span></a>
		<?php
	}
}
add_filter( 'kayo_product_quickview_button', 'kayo_output_product_quickview_button' );

/**
 * Product wishlist button
 *
 * @param string $string
 * @return string
 */
function kayo_output_product_wishlist_button() {

	if ( function_exists( 'wolf_add_to_wishlist' ) ) {
		wolf_add_to_wishlist();
	}
}
add_filter( 'kayo_add_to_wishlist_button', 'kayo_output_product_wishlist_button' );

/**
 * Product Add to cart button
 *
 * @param string $string
 * @return string
 */
function kayo_output_product_add_to_cart_button() {

	global $product;

	if ( $product->is_type( 'variable' ) ) {

		echo '<a class="product-add-to-cart" href="' . esc_url( get_permalink() ) . '"><span class="hastip fa product-add-to-cart-icon" title="' . esc_attr( __( 'Select option', 'kayo' ) ) . '"></span></a>';

	} elseif ( $product->is_type( 'external' ) || $product->is_type( 'grouped' ) ) {

		echo '<a class="product-add-to-cart" href="' . esc_url( get_permalink() ) . '"><span class="hastip fa product-add-to-cart-icon" title="' . esc_attr( __( 'View product', 'kayo' ) ) . '"></span></a>';

	} else {

		echo kayo_add_to_cart(
			get_the_ID(),
			'product-add-to-cart',
			'<span class="hastip fa product-add-to-cart-icon" title="' . esc_attr( __( 'Add to cart', 'kayo' ) ) . '"></span>'
		);
	}

}
add_filter( 'kayo_product_add_to_cart_button', 'kayo_output_product_add_to_cart_button' );

/**
 * Product more button
 *
 * @param string $string
 * @return string
 */
function kayo_output_product_more_button() {

	?>
	<a class="product-quickview-button product-more-button" href="<?php the_permalink(); ?>" title="<?php esc_attr_e( 'More details', 'kayo' ); ?>"><span class="fa ion-android-more-vertical"></span></a>
	<?php
}
add_filter( 'kayo_product_more_button', 'kayo_output_product_more_button' );


/*
=========================================
	Loop products
==========================================*/
/**
 * Redefine product hook
 */
function kayo_remove_loop_item_default_wc_hooks() {

	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );
	remove_action( 'woocommerce_after_shop_loop_item', 'www_output_add_to_wishlist_button', 15 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

	add_action( 'woocommerce_before_shop_loop_item', 'kayo_wc_loop_thumbnail', 10, 1 );
	add_action( 'woocommerce_after_shop_loop_item', 'kayo_wc_loop_summary' );
}
add_action( 'woocommerce_init', 'kayo_remove_loop_item_default_wc_hooks' );

/**
 * WC loop thumbnail
 */
function kayo_wc_loop_thumbnail( $template_args ) {

	extract(
		wp_parse_args(
			$template_args,
			array(
				'display' => '',
			)
		)
	);

	$product_thumbnail_size = ( 'metro' === $display ) ? 'kayo-metro' : 'woocommerce_thumbnail';
	$product_thumbnail_size = apply_filters( 'kayo_' . $display . '_thumbnail_size_name', $product_thumbnail_size );
	$product_thumbnail_size = ( kayo_is_gif( get_post_thumbnail_id() ) ) ? 'full' : $product_thumbnail_size;
	?>
	<div class="product-thumbnail-container clearfix">
		<div class="product-thumbnail-inner">
			<a class="entry-link-mask" href="<?php the_permalink(); ?>"></a>
			<?php woocommerce_show_product_loop_sale_flash(); ?>
			<?php echo woocommerce_get_product_thumbnail( $product_thumbnail_size ); ?>
			<?php kayo_woocommerce_second_product_thumbnail( $product_thumbnail_size ); ?>
			<div class="product-actions">
				<?php
					/**
					 * Quickview button
					 */
					do_action( 'kayo_product_quickview_button' );
				?>
				<?php
					/**
					 * Wishlist button
					 */
					do_action( 'kayo_add_to_wishlist_button' );
				?>
			</div><!-- .product-actions -->
		</div><!-- .product-thumbnail-inner -->
	</div><!-- .product-thumbnail-container -->
	<?php
}

function kayo_wc_loop_summary() {
	?>
	<div class="product-summary clearfix">
		<div class="product-summary-cell-left">
			<?php woocommerce_template_loop_product_link_open(); ?>
				<?php woocommerce_template_loop_product_title(); ?>
				<?php woocommerce_template_loop_price(); ?>
				<?php
					/**
					 * After title
					 */
					do_action( 'kayo_after_shop_loop_item_title' );
				?>
			<?php woocommerce_template_loop_product_link_close(); ?>
		</div>
		<div class="product-summary-cell-right">
			<?php
				/**
				 * Add to cart button
				 */
				do_action( 'kayo_product_add_to_cart_button' );
			?>
		</div>
	</div><!-- .product-summary -->
	<?php
}

/**
 * Single product wishlist button
 */
add_filter(
	'kayo_show_single_product_wishlist_button',
	function() {
		return false;
	}
);

/**
 * Product stacked images + sticky details
 */
function kayo_single_product_sticky_layout() {

	if ( ! kayo_get_inherit_mod( 'product_sticky' ) || 'no' === kayo_get_inherit_mod( 'product_sticky' ) ) {
		return;
	}

	/* Remove default images */
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

	global $product;

	$product_id = $product->get_id();

	echo '<div class="images">';

	woocommerce_show_product_sale_flash();
	/**
	 * If gallery
	 */
	$attachment_ids = $product->get_gallery_image_ids();

	if ( is_array( $attachment_ids ) && ! empty( $attachment_ids ) ) {

		echo '<ul>';

		if ( has_post_thumbnail( $product_id ) ) {

			$caption = get_post_field( 'post_excerpt', get_post_thumbnail_id( $post_thumbnail_id ) );
			?>
			<li class="stacked-image">
				<a class="lightbox" data-fancybox="wc-stacked-images-<?php echo absint( $product_id ); ?>" href="<?php echo get_the_post_thumbnail_url( $product_id, 'full' ); ?>" data-caption="<?php echo esc_attr( $caption ); ?>">
					<?php echo kayo_kses( $product->get_image( 'large' ) ); ?>
				</a>
			</li>
			<?php
		}

		foreach ( $attachment_ids as $attachment_id ) {
			if ( wp_attachment_is_image( $attachment_id ) ) {

				$caption = get_post_field( 'post_excerpt', $attachment_id );
				?>
				<li class="stacked-image">
					<a class="lightbox" data-fancybox="wc-stacked-images-<?php echo absint( $product_id ); ?>" href="<?php echo wp_get_attachment_url( $attachment_id, 'full' ); ?>" data-caption="<?php echo esc_attr( $caption ); ?>">
						<?php echo wp_get_attachment_image( $attachment_id, 'large' ); ?>
					</a>
				</li>
				<?php
			}
		}

		echo '</ul>';

		/**
		 * If featured image only
		 */
	} elseif ( has_post_thumbnail( $product_id ) ) {
		?>
		<span class="stacked-image">
			<a class="lightbox" data-fancybox="wc-stacked-images-<?php echo absint( $product_id ); ?>" href="<?php echo get_the_post_thumbnail_url( $product_id, 'full' ); ?>">
				<?php echo kayo_kses( $product->get_image( 'large' ) ); ?>
			</a>
		</span>
		<?php
		/**
		 * Placeholder
		 */
	} else {

		$html  = '<span class="woocommerce-product-gallery__image--placeholder">';
		$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'kayo' ) );
		$html .= '</span>';

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
	}

	echo '</div>';
}
add_action( 'woocommerce_before_single_product_summary', 'kayo_single_product_sticky_layout' );

add_action(
	'woocommerce_before_quantity_input_field',
	function() {
		echo '<span class="wt-quantity-plus"></span>';
	}
);

add_action(
	'woocommerce_after_quantity_input_field',
	function() {
		echo '<span class="wt-quantity-minus"></span>';
	}
);

/**
 * Additional styles
 */
function kayo_output_additional_styles() {

	$output = '';

	// $output .= '.sticky-post:before{content: "' . esc_html__( 'Featured', 'kayo' ) . '";}';

	if ( ! SCRIPT_DEBUG ) {
		$output = kayo_compact_css( $output );
	}

	wp_add_inline_style( 'kayo-style', $output );
}
add_action( 'wp_enqueue_scripts', 'kayo_output_additional_styles', 999 );

/**
 * Category thumbnail fields.
 */
function kayo_add_category_fields() {
	?>
	<div class="form-field term-thumbnail-wrap">
		<label><?php esc_html_e( 'Size Chart', 'kayo' ); ?></label>
		<div id="sizechart_img" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
		<div style="line-height: 60px;">
			<input type="hidden" id="product_cat_sizechart_img_id" name="product_cat_sizechart_img_id" />
			<button type="button" id="upload_sizechart_image_button" class="upload_sizechart_image_button button"><?php esc_html_e( 'Upload/Add image', 'kayo' ); ?></button>
				<button type="button" id="remove_sizechart_image_button" class="remove_sizechart_image_button button" style="display:none;"><?php esc_html_e( 'Remove image', 'kayo' ); ?></button>
		</div>
		<script type="text/javascript">

			// Only show the "remove image" button when needed
			if ( ! jQuery( '#product_cat_sizechart_img_id' ).val() ) {
				jQuery( '#remove_sizechart_image_button' ).hide();
			}

			// Uploading files
			var sizechart_frame;

			jQuery( document ).on( 'click', '#upload_sizechart_image_button', function( event ) {

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( sizechart_frame ) {
					sizechart_frame.open();
					return;
				}

				// Create the media frame.
				sizechart_frame = wp.media.frames.downloadable_file = wp.media({
					title: '<?php esc_html_e( 'Choose an image', 'kayo' ); ?>',
					button: {
						text: '<?php esc_html_e( 'Use image', 'kayo' ); ?>'
					},
					multiple: false
				} );

				// When an image is selected, run a callback.
				sizechart_frame.on( 'select', function() {
					var attachment           = sizechart_frame.state().get( 'selection' ).first().toJSON();
					var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

					jQuery( '#product_cat_sizechart_img_id' ).val( attachment.id );
					jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
					jQuery( '#remove_sizechart_image_button' ).show();
				} );

				// Finally, open the modal.
				sizechart_frame.open();
			} );

			jQuery( document ).on( 'click', '#remove_sizechart_image_button', function() {
				jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
				jQuery( '#product_cat_sizechart_img_id' ).val( '' );
				jQuery( '#remove_sizechart_image_button' ).hide();
				return false;
			} );

			jQuery( document ).ajaxComplete( function( event, request, options ) {
				if ( request && 4 === request.readyState && 200 === request.status
					&& options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

					var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
					if ( ! res || res.errors ) {
						return;
					}
					// Clear Thumbnail fields on submit
					jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
					jQuery( '#product_cat_sizechart_img_id' ).val( '' );
					jQuery( '#remove_sizechart_image_button' ).hide();
					// Clear Display type field on submit
					jQuery( '#display_type' ).val( '' );
					return;
				}
			} );

		</script>
		<div class="clear"></div>
	</div>
	<?php
}
add_action( 'product_cat_add_form_fields', 'kayo_add_category_fields', 100 );

/**
 * Edit category thumbnail field.
 *
 * @param mixed $term Term (category) being edited
 */
function kayo_edit_category_fields( $term ) {

	$sizechart_id = absint( get_term_meta( $term->term_id, 'sizechart_id', true ) );

	if ( $sizechart_id ) {
		$image = wp_get_attachment_thumb_url( $sizechart_id );
	} else {
		$image = wc_placeholder_img_src();
	}
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php esc_html_e( 'Size Chart', 'kayo' ); ?></label></th>
		<td>
			<div id="sizechart_img" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
			<div style="line-height: 60px;">
				<input type="hidden" id="product_cat_sizechart_img_id" name="product_cat_sizechart_img_id" value="<?php echo absint( $sizechart_id ); ?>" />
				<button type="button" id="upload_sizechart_image_button" class="upload_sizechart_image_button button"><?php esc_html_e( 'Upload/Add image', 'kayo' ); ?></button>
				<button type="button" id="remove_sizechart_image_button" class="remove_sizechart_image_button button" style="display:none;"><?php esc_html_e( 'Remove image', 'kayo' ); ?></button>
			</div>
			<script type="text/javascript">

				// Only show the "remove image" button when needed
				if ( jQuery( '#product_cat_sizechart_img_id' ).val() ) {
					jQuery( '#remove_sizechart_image_button' ).show();
				}

				// Uploading files
				var sizechart_frame;

				jQuery( document ).on( 'click', '#upload_sizechart_image_button', function( event ) {

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if ( sizechart_frame ) {
						sizechart_frame.open();
						return;
					}

					// Create the media frame.
					sizechart_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php esc_html_e( 'Choose an image', 'kayo' ); ?>',
						button: {
							text: '<?php esc_html_e( 'Use image', 'kayo' ); ?>'
						},
						multiple: false
					} );

					// When an image is selected, run a callback.
					sizechart_frame.on( 'select', function() {
						var attachment           = sizechart_frame.state().get( 'selection' ).first().toJSON();
						var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

						jQuery( '#product_cat_sizechart_img_id' ).val( attachment.id );
						jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
						jQuery( '#remove_sizechart_image_button' ).show();
					} );

					// Finally, open the modal.
					sizechart_frame.open();
				} );

				jQuery( document ).on( 'click', '#remove_sizechart_image_button', function() {
					jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
					jQuery( '#product_cat_sizechart_img_id' ).val( '' );
					jQuery( '#remove_sizechart_image_button' ).hide();
					return false;
				} );

			</script>
			<div class="clear"></div>
		</td>
	</tr>
	<?php
}
add_action( 'product_cat_edit_form_fields', 'kayo_edit_category_fields', 100 );

/**
 * save_category_fields function.
 *
 * @param mixed  $term_id Term ID being saved
 * @param mixed  $tt_id
 * @param string $taxonomy
 */
function kayo_save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {

	if ( isset( $_POST['product_cat_sizechart_img_id'] ) && 'product_cat' === $taxonomy ) {
		update_woocommerce_term_meta( $term_id, 'sizechart_id', absint( $_POST['product_cat_sizechart_img_id'] ) );
	}
}
add_action( 'created_term', 'kayo_save_category_fields', 10, 3 );
add_action( 'edit_term', 'kayo_save_category_fields', 10, 3 );

/**
 * Product Size Chart Image
 */
function kayo_product_size_chart_img() {

	$hide_sizechart = get_post_meta( get_the_ID(), '_post_wc_product_hide_size_chart_img', true );

	if ( $hide_sizechart || ! is_singular( 'product' ) ) {
		return;
	}

	global $post;
	$sc_img = null;
	$terms  = get_the_terms( $post, 'product_cat' );

	foreach ( $terms as $term ) {

		$sizechart_id = absint( get_term_meta( $term->term_id, 'sizechart_id', true ) );

		if ( $sizechart_id ) {
			$sc_img = $sizechart_id;
		}
	}

	if ( get_post_meta( get_the_ID(), '_post_wc_product_size_chart_img', true ) ) {
		$sc_img = get_post_meta( get_the_ID(), '_post_wc_product_size_chart_img', true );
	}

	if ( is_single() && $sc_img ) {
		$href = kayo_get_url_from_attachment_id( $sc_img, 'kayo-XL' );
		?>
		<div class="size-chart-img">
			<a href="<?php echo esc_url( $href ); ?>" class="lightbox"><?php esc_html_e( 'Size Chart', 'kayo' ); ?></a>
		</div>
		<?php
	}
}
add_action( 'woocommerce_single_product_summary', 'kayo_product_size_chart_img', 25 );

/**
 * Product Subheading
 */
function kayo_add_product_subheading() {

	$subheading = get_post_meta( get_the_ID(), '_post_subheading', true );

	if ( is_single() && $subheading ) {
		?>
		<div class="product-subheading">
			<?php echo sanitize_text_field( $subheading ); ?>
		</div>
		<?php
	}

}
add_action( 'woocommerce_single_product_summary', 'kayo_add_product_subheading', 6 );

/**
 * WC gallery image size overwrite
 */
add_filter(
	'woocommerce_gallery_thumbnail_size',
	function( $size ) {
		return array( 100, 100 );
	},
	40
);

/**
 * Single Product Subheading
 */
function kayo_add_single_product_subheading() {

	$subheading = get_post_meta( get_the_ID(), '_post_subheading', true );

	if ( is_single() && $subheading ) {
		?>
		<div class="product-subheading">
			<?php echo sanitize_text_field( $subheading ); ?>
		</div>
		<?php
	}

}
add_action( 'woocommerce_single_product_summary', 'kayo_add_single_product_subheading', 6 );
