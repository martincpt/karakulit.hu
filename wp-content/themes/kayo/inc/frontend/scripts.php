<?php
/**
 * Kayo Frontend Scripts
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Remove plugin scripts
 * Allow an easier customization
 */
function kayo_dequeue_plugin_scripts() {
	wp_dequeue_script( 'wolf-portfolio' );
	wp_dequeue_script( 'wolf-videos' );
	wp_dequeue_script( 'wolf-albums' );
	wp_dequeue_script( 'wolf-discography' );
}
add_action( 'wp_enqueue_scripts', 'kayo_dequeue_plugin_scripts' );

/**
 * Register scripts
 *
 * @param array $scripts The scripts to register.
 */
function kayo_register_scripts( $scripts = array() ) {

	$theme_version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : kayo_get_theme_version();

	foreach ( $scripts as $handle => $properties ) {
		$src          = esc_url( $properties['src'] );
		$dependencies = ( isset( $properties['dependencies'] ) ) ? $properties['dependencies'] : array( 'jquery' );
		$version      = ( isset( $properties['version'] ) ) ? $properties['version'] : $theme_version;
		$in_footer    = ( isset( $properties['in_footer'] ) ) ? $properties['in_footer'] : true;

		wp_register_script( $handle, $src, $dependencies, $version, $in_footer );
	}
}

/**
 * JS params
 */
function kayo_get_theme_js_params() {
	/**
	 * Filters the JS params
	 *
	 * @since 1.0.0
	 */
	return apply_filters(
		'kayo_js_params',
		array(
			/**
			 * Filters the default page loading animation
			 *
			 * @since 1.0.0
			 */
			'defaultPageLoadingAnimation'    => apply_filters( 'kayo_default_page_loading_animation', true ),

			/**
			 * Filters the default page transition animation
			 *
			 * @since 1.0.0
			 */
			'defaultPageTransitionAnimation' => apply_filters( 'kayo_default_page_transition_animation', true ),

			'siteUrl'                        => esc_url( site_url( '/' ) ),
			'homeUrl'                        => esc_url( home_url( '/' ) ),
			'ajaxUrl'                        => esc_url( admin_url( 'admin-ajax.php' ) ),
			'ajaxNonce'                      => wp_create_nonce( 'kayo_ajax_nonce' ),
			'themeUrl'                       => esc_url( get_template_directory_uri() ),
			'isUserLoggedIn'                 => is_user_logged_in(),
			'isMobile'                       => wp_is_mobile(),
			'isPostTypeArchive'              => kayo_is_post_type_archive(),
			'isPage'                         => is_page(),
			'themeSlug'                      => kayo_get_theme_slug(),
			'accentColor'                    => kayo_get_inherit_mod( 'accent_color', '#007acc' ),

			/**
			 * Filters the mobile menu breakpoint
			 *
			 * @since 1.0.0
			 */
			'breakPoint'                     => apply_filters( 'kayo_menu_breakpoint', kayo_get_inherit_mod( 'menu_breakpoint', 1100 ) ),

			'menuLayout'                     => kayo_get_inherit_mod( 'menu_layout' ),
			'menuSkin'                       => kayo_get_inherit_mod( 'menu_skin' ),

			/**
			 * Filters the menu offset
			 *
			 * @since 1.0.0
			 */
			'menuOffset'                     => apply_filters( 'kayo_menu_offset', kayo_get_inherit_mod( 'menu_offset', 0 ) ),

			'menuHoverStyle'                 => kayo_get_inherit_mod( 'menu_hover_style', 'opacity' ),

			/**
			 * Filters the submenu width
			 *
			 * @since 1.0.0
			 */
			'subMenuWidth'                   => apply_filters( 'kayo_submenu_width', 230 ),

			'stickyMenuType'                 => kayo_get_inherit_mod( 'menu_sticky_type', 'soft' ),

			/**
			 * Filters the sticky menu scoll point
			 *
			 * @since 1.0.0
			 */
			'stickyMenuScrollPoint'          => apply_filters( 'kayo_sticky_menu_scrollpoint', 0 ), // ??

			/**
			 * Filters the sticky menu height
			 *
			 * @since 1.0.0
			 */
			'stickyMenuHeight'               => apply_filters( 'kayo_sticky_menu_height', 60 ),

			/**
			 * Filters the desktop menu height
			 *
			 * @since 1.0.0
			 */
			'desktopMenuHeight'              => apply_filters( 'kayo_desktop_menu_height', 80 ),

			/**
			 * Filters the mobile screen breakpoint
			 *
			 * @since 1.0.0
			 */
			'mobileScreenBreakpoint'         => apply_filters( 'kayo_mobile_screen_breakpoint', 499 ),

			/**
			 * Filters the tablet screen breakpoint
			 *
			 * @since 1.0.0
			 */
			'tabletScreenBreakpoint'         => apply_filters( 'kayo_tablet_screen_breakpoint', 768 ),

			/**
			 * Filters the notebook screen breakpoint
			 *
			 * @since 1.0.0
			 */
			'notebookScreenBreakpoint'       => apply_filters( 'kayo_notebook_screen_breakpoint', 1024 ),

			/**
			 * Filters the desktop screen breakpoint
			 *
			 * @since 1.0.0
			 */
			'desktopScreenBreakpoint'        => apply_filters( 'kayo_desktop_screen_breakpoint', 1224 ),

			/**
			 * Filters the desktop big screen breakpoint
			 *
			 * @since 1.0.0
			 */
			'desktopBigScreenBreakpoint'     => apply_filters( 'kayo_desktop_big_screen_breakpoint', 1350 ),

			'isWolfCore'                     => class_exists( 'Wolf_Core' ),
			'pageBuilder'                    => kayo_get_plugin_in_use(),

			/**
			 * Filters the lightbox option
			 *
			 * @since 1.0.0
			 */
			'lightbox'                       => apply_filters( 'kayo_lightbox', kayo_get_inherit_mod( 'lightbox', 'fancybox' ) ),

			/**
			 * Filters the WOW box class
			 *
			 * Used for scroll animation
			 *
			 * @since 1.0.0
			 */
			'WOWBoxClass'                    => apply_filters( 'kayo_wow_box_class', 'wow' ),

			/**
			 * Filters the WOW animation offset
			 *
			 * @since 1.0.0
			 */
			'WOWAnimationOffset'             => apply_filters( 'kayo_wow_animation_offset', 0 ),

			'fullPageAnimation'              => kayo_do_fullpage(),

			/**
			 * Filters the animation on mobile condition
			 *
			 * @since 1.0.0
			 */
			'forceAnimationMobile'           => apply_filters( 'kayo_force_animation_mobile', false ),

			/**
			 * Filters the noIos param for the parallax script
			 *
			 * @since 1.0.0
			 */
			'parallaxNoIos'                  => apply_filters( 'kayo_parallax_no_ios', true ),

			/**
			 * Filters the noAndroid param for the parallax script
			 *
			 * @since 1.0.0
			 */
			'parallaxNoAndroid'              => apply_filters( 'kayo_parallax_no_android', true ),

			/**
			 * Filters the noSmallScreen param for the parallax script
			 *
			 * @since 1.0.0
			 */
			'parallaxNoSmallScreen'          => apply_filters( 'kayo_parallax_no_small_screen', true ),

			/**
			 * Filters the sticky menu height
			 *
			 * @since 1.0.0
			 */
			'portfolioSidebarOffsetTop'      => ( 'soft' === kayo_get_inherit_mod( 'menu_sticky_type', 'soft' ) || 'hard' === kayo_get_inherit_mod( 'menu_sticky_type', 'soft' ) ) ? apply_filters( 'kayo_sticky_menu_height', 60 ) : 0,
			'isWooCommerce'                  => function_exists( 'WC' ),
			'WooCommerceCartUrl'             => ( function_exists( 'wc_get_cart_url' ) ) ? wc_get_cart_url() : '',
			'WooCommerceCheckoutUrl'         => ( function_exists( 'wc_get_checkout_url' ) ) ? wc_get_checkout_url() : '',
			'WooCommerceAccountUrl'          => ( function_exists( 'WC' ) ) ? get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) : '',
			'isWooCommerceVariationSwatches' => defined( 'TAWC_VS_PLUGIN_FILE' ),

			/**
			 * Filters the single product related products count
			 *
			 * @since 1.0.0
			 */
			'relatedProductCount'            => apply_filters( 'kayo_related_products_count', 4 ),

			'doWoocommerceLightbox'          => ( 'no' === get_option( 'woocommerce_enable_lightbox' ) ),
			'doVideoLightbox'                => ( 'yes' === kayo_get_inherit_mod( 'videos_lightbox' ) ),

			/**
			 * Filters the live search condition
			 *
			 * @since 1.0.0
			 */
			'doLiveSearch'                   => apply_filters( 'kayo_live_search', true ),

			/**
			 * Filters the load more pagination hash change condition
			 *
			 * @since 1.0.0
			 */
			'doLoadMorePaginationHashChange' => apply_filters( 'kayo_loadmore_pagination_hashchange', true ),

			/**
			 * Filters smooth scroll speed
			 *
			 * @since 1.0.0
			 */
			'smoothScrollSpeed'              => apply_filters( 'kayo_smooth_scroll_speed', 1000 ),

			/**
			 * Filters smooth scroll ease
			 *
			 * @since 1.0.0
			 */
			'smoothScrollEase'               => apply_filters( 'kayo_smooth_scroll_ease', 'swing' ),

			'infiniteScrollEmptyLoad'        => get_template_directory_uri() . '/assets/img/blank.gif',

			/**
			 * Filters the infinite scroll pagination gif URL
			 *
			 * @since 1.0.0
			 */
			'infiniteScrollGif'              => apply_filters( 'kayo_infinite_scroll_loading_gif_url', get_template_directory_uri() . '/assets/img/loading.gif' ),

			'isCustomizer'                   => kayo_is_customizer(),
			'isAjaxNav'                      => kayo_do_ajax_nav(),

			/**
			 * Filters the panel toggle mody class for the AJAX pagination
			 *
			 * @since 1.0.0
			 */
			'ajaxNavigateToggleClass'        => apply_filters(
				'kayo_ajax_navigate_toggle_class',
				array(
					'mobile-menu-toggle',
					'side-panel-toggle',
					'search-form-toggle',
					'overlay-menu-toggle',
					'offcanvas-menu-toggle',
					'lateral-menu-toggle',
				)
			),

			'pageLoadingAnimationType'       => kayo_get_inherit_mod( 'loading_animation_type', 'none' ),

			/**
			 * Filters the loading overlay display condition
			 *
			 * @since 1.0.0
			 */
			'hasLoadingOverlay'              => apply_filters( 'kayo_display_overlay', 'none' !== kayo_get_inherit_mod( 'loading_animation_type', 'none' ) ),

			/**
			 * Filters the page loading delay
			 *
			 * @since 1.0.0
			 */
			'pageLoadedDelay'                => apply_filters( 'kayo_page_loaded_delay', 1000 ),

			/**
			 * Filters the delay before page transition
			 *
			 * @since 1.0.0
			 */
			'pageTransitionDelayBefore'      => apply_filters( 'kayo_page_transition_delay_before', 0 ),

			/**
			 * Filters the delay after page transition
			 *
			 * @since 1.0.0
			 */
			'pageTransitionDelayAfter'       => apply_filters( 'kayo_page_transition_delay_after', 0 ),

			'mediaelementLegacyCssUri'       => includes_url( 'js/mediaelement/mediaelementplayer-legacy.min.css' ),
			'fancyboxMediaelementCssUri'     => get_template_directory_uri() . '/assets/css/fancybox-mediaelement.min.css',

			/**
			 * Filters the Fancybox settings array
			 *
			 * @since 1.0.0
			 */
			'fancyboxSettings'               => apply_filters(
				'kayo_fancybox_settings',
				array(
					'loop'             => true,
					'transitionEffect' => 'slide',
					'wheel'            => false,
					'hideScrollbar'    => false,
					'buttons'          => array(
						'slideShow',
						'fullScreen',
						'thumbs',
						'close',
					),
				)
			),

			/**
			 * Filters the gallery post slider transition animation
			 *
			 * @since 1.0.0
			 */
			'entrySliderAnimation'           => apply_filters( 'kayo_entry_slider_animation', 'fade' ),

			'is404'                          => is_404(),
			'isUserLoggedIn'                 => is_user_logged_in(),
			'allowedMimeTypes'               => array_keys( get_allowed_mime_types() ),
			'logoMarkup'                     => kayo_logo( false ),
			'language'                       => get_locale(),
			'l10n'                           => array(
				'chooseImage'               => esc_html__( 'Choose an image', 'kayo' ),
				'useImage'                  => esc_html__( 'Use image', 'kayo' ),
				'replyTitle'                => esc_html__( 'Post a comment', 'kayo' ),
				'editPost'                  => esc_html__( 'Edit Post', 'kayo' ),
				'infiniteScrollMsg'         => esc_html__( 'Loading', 'kayo' ) . '<span class="load-more-hellip">.</span><span class="load-more-hellip">.</span><span class="load-more-hellip">.</span>',
				'infiniteScrollEndMsg'      => esc_html__( 'No more post to load', 'kayo' ),

				/**
				 * Filters the "load more" message text for the pagination
				 *
				 * @since 1.0.0
				 */
				'loadMoreMsg'               => apply_filters( 'kayo_load_more_posts_text', esc_html__( 'Load More', 'kayo' ) ),

				'infiniteScrollDisabledMsg' => esc_html__( 'The infinitescroll is disabled in live preview mode', 'kayo' ),
				'addToCart'                 => esc_html__( 'Add to cart', 'kayo' ),
				'viewCart'                  => esc_html__( 'View cart', 'kayo' ),
				'addedToCart'               => esc_html__( 'Added to cart', 'kayo' ),
				'playText'                  => esc_html__( 'Play', 'kayo' ),
				'pauseText'                 => esc_html__( 'Pause', 'kayo' ),
			),
		)
	);
}

/**
 * Returns script sto register
 */
function kayo_get_register_scripts() {

	$suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : kayo_get_theme_version();
	if ( defined( 'AUTOPTIMIZE_PLUGIN_DIR' ) ) {
		$suffix = '';
	}

	/**
	 * Filters the registered scripts array
	 *
	 * @since 1.0.0
	 */
	return apply_filters(
		'kayo_register_scripts',
		array(
			'infinitescroll'                     => array(
				'src'     => get_template_directory_uri() . '/assets/js/lib/jquery.infinitescroll.min.js',
				'version' => '2.0.0',
			),

			'jarallax'                           => array(
				'src'     => get_template_directory_uri() . '/assets/js/lib/jarallax.min.js',
				'version' => '1.8.0',
			),

			'aos'                                => array(
				'src'     => get_template_directory_uri() . '/assets/js/lib/aos.js',
				'version' => '2.0.0',
			),

			'vimeo-player'                       => array(
				'src'     => get_template_directory_uri() . '/assets/js/lib/player.min.js',
				'version' => '2.6.1',
			),

			'imagesloaded'                       => array(
				'src'     => get_template_directory_uri() . '/assets/js/lib/imagesloaded.pkgd.min.js',
				'version' => '4.1.4',
			),

			'isotope'                            => array(
				'src'     => get_template_directory_uri() . '/assets/js/lib/isotope.pkgd.min.js',
				'version' => '3.0.5',
			),

			'packery-mode'                       => array(
				'src'     => get_template_directory_uri() . '/assets/js/lib/packery-mode.pkgd.min.js',
				'version' => '2.0.1',
			),
			'flex-images'                        => array(
				'src'     => get_template_directory_uri() . '/assets/js/lib/jquery.flex-images.min.js',
				'version' => '1.0.4',
			),

			'flickity'                           => array(
				'src'     => get_template_directory_uri() . '/assets/js/lib/flickity.pkgd.min.js',
				'version' => '2.3.0',
			),

			'kayo-youtube-video-background' => array(
				'src' => get_template_directory_uri() . '/assets/js/YT-background' . $suffix . '.js',
			),

			'kayo-vimeo'                    => array(
				'src' => get_template_directory_uri() . '/assets/js/vimeo' . $suffix . '.js',
			),

			'kayo-masonry'                  => array(
				'src' => get_template_directory_uri() . '/assets/js/masonry' . $suffix . '.js',
			),

			'kayo-category-filter'          => array(
				'src' => get_template_directory_uri() . '/assets/js/category-filter' . $suffix . '.js',
			),

			'kayo-masonry'                  => array(
				'src' => get_template_directory_uri() . '/assets/js/masonry' . $suffix . '.js',
			),

			'kayo-carousels'                => array(
				'src' => get_template_directory_uri() . '/assets/js/carousels' . $suffix . '.js',
			),

			'kayo-loadposts'                => array(
				'src' => get_template_directory_uri() . '/assets/js/loadposts' . $suffix . '.js',
			),

			'kayo-one-page'                 => array(
				'src' => get_template_directory_uri() . '/assets/js/one-page' . $suffix . '.js',
			),

			'kayo-loginform'                => array(
				'src' => get_template_directory_uri() . '/assets/js/loginform' . $suffix . '.js',
			),

			'kayo-ajax-nav'                 => array(
				'src' => get_template_directory_uri() . '/assets/js/ajax' . $suffix . '.js',
			),

			'kayo-elementor-editor'         => array(
				'src'        => get_template_directory_uri() . '/assets/js/elementor-editor' . $suffix . '.js',
				'dependency' => array( 'elementor-frontend' ),
			),
		)
	);
}

if ( ! function_exists( 'kayo_enqueue_scripts' ) ) {
	/**
	 * Register theme scripts for the theme
	 */
	function kayo_enqueue_scripts() {

		$suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : kayo_get_theme_version();
		if ( defined( 'AUTOPTIMIZE_PLUGIN_DIR' ) ) {
			$suffix = '';
		}

		/**
		 * Filters the lightbox option
		 *
		 * @since 1.0.0
		 */
		$lightbox = apply_filters( 'kayo_lightbox', kayo_get_theme_mod( 'lightbox', 'fancybox' ) );

		/* Register conditional scripts */
		kayo_register_scripts( kayo_get_register_scripts() );
		wp_enqueue_script( 'wp-mediaelement' );
		wp_enqueue_script( 'jquery-migrate' );

		/**
		 * Enqueue main scripts
		 */
		wp_enqueue_script( 'js-cookie', get_template_directory_uri() . '/assets/js/lib/js.cookie.min.js', array( 'jquery' ), '2.1.4', true );
		wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/assets/js/lib/jquery.flexslider.min.js', array( 'jquery' ), '2.6.3', true );

		if ( 'fancybox' === $lightbox ) {
			wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/assets/js/lib/jquery.fancybox.min.js', array( 'jquery' ), '3.5.7', true );

		} elseif ( 'swipebox' === $lightbox ) {
			wp_enqueue_script( 'swipebox', get_template_directory_uri() . '/assets/js/lib/jquery.swipebox.min.js', array( 'jquery' ), '1.4.4', true );
		}
		wp_enqueue_script( 'lazyloadxt', get_template_directory_uri() . '/assets/js/lib/jquery.lazyloadxt.min.js', array( 'jquery' ), '1.1.0', true );
		wp_enqueue_script( 'sticky-kit', get_template_directory_uri() . '/assets/js/lib/sticky-kit.min.js', array( 'jquery' ), '1.1.3', true );
		wp_enqueue_script( 'wolftheme', get_template_directory_uri() . '/assets/js/functions' . $suffix . '.js', array( 'jquery' ), $version, true );
		wp_enqueue_script( 'tooltipsy', get_template_directory_uri() . '/assets/js/lib/tooltipsy.min.js', array( 'jquery' ), '1.0.0', true );

		/**
		 * Enqueue condition scripts
		 */
		if ( kayo_is_edge() ) {
			wp_enqueue_script( 'object-fit-images', get_template_directory_uri() . '/assets/lib/ofi.min.js', array(), '3.2.3', true );
		}

		/**
		 * Enqueuing scripts
		 */
		wp_enqueue_script( 'flexslider' );
		wp_enqueue_script( 'jarallax' );
		if ( kayo_is_wolf_extension_activated() ) {
			wp_enqueue_script( 'bigtext' );
			wp_enqueue_script( 'wvc-bigtext' );
			wp_enqueue_script( 'wolf-core-bigtext' );
		}

		if ( is_search() || is_singular( 'proof_gallery' ) ) {
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'isotope' );
			wp_enqueue_script( 'kayo-masonry' );
		}

		if ( is_singular( 'artist' ) ) {
			wp_enqueue_script( 'jquery-ui-tabs' );
		}

		if ( is_singular( 'product' ) ) {
			wp_enqueue_script( 'flickity' );
			wp_enqueue_script( 'kayo-carousels' );
		}

		if ( kayo_do_onepage_menu() || kayo_is_elementor_editor() ) {
			wp_enqueue_script( 'kayo-one-page' );
		}

		/**
		 * If AJAX navigation is enabled, we enqueued everything we may need from start
		 */
		if ( kayo_do_ajax_nav() ) {
			wp_enqueue_script( 'wp-mediaelement' );
			wp_enqueue_script( 'jarallax' );
			wp_enqueue_script( 'imagesloaded' );
			wp_enqueue_script( 'isotope' );
			wp_enqueue_script( 'packery-mode' );
			wp_enqueue_script( 'infinitescroll' );
			wp_enqueue_script( 'sticky-kit' );
			wp_enqueue_script( 'kayo-masonry' );
			wp_enqueue_script( 'kayo-infinitescroll' );
			wp_enqueue_script( 'kayo-loadposts' );
			wp_enqueue_script( 'kayo-category-filter' );
			wp_enqueue_script( 'kayo-carousels' );
			if ( class_exists( 'WooCommerce' ) ) {

				wp_enqueue_script( 'wc-single-product' );
				wp_enqueue_script( 'wc-add-to-cart-variation' );
				wp_enqueue_script( 'wc-jquery-ui-touchpunch', WC()->plugin_url() . '/assets/js/jquery-ui-touch-punch/jquery-ui-touch-punch' . $suffix . '.js', array( 'jquery-ui-slider' ), WC_VERSION, true );
				wp_enqueue_script( 'wc-price-slider', WC()->plugin_url() . '/assets/js/frontend/price-slider' . $suffix . '.js', array( 'jquery-ui-slider', 'wc-jquery-ui-touchpunch' ), WC_VERSION, true );
			}

			wp_enqueue_script( 'kayo-ajax-nav' );
			wp_enqueue_script( 'kayo-one-page' );
		}
		wp_localize_script(
			'wolftheme',
			'KayoParams',
			kayo_get_theme_js_params()
		);
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
	add_action( 'wp_enqueue_scripts', 'kayo_enqueue_scripts' );
} // end function check

/**
 * Enqueue Elementor preview needed scripts
 */
function kayo_enqueue_elementor_preview_scripts() {

	$scripts = array(
		'imagesloaded',
		'isotope',
		'packery-mode',
		'flex-images',
		'flickity',
		'kayo-functions',
		'kayo-masonry',
		'kayo-carousel',
		'kayo-category-filter',
		'kayo-elementor-editor',
	);

	foreach ( $scripts as $script ) {
		wp_enqueue_script( $script );
	}
}
add_action( 'elementor/preview/enqueue_scripts', 'kayo_enqueue_elementor_preview_scripts' );

/**
 * Force WWPBPBE to enqueue all scripts for AJAX
 *
 * Wolf WPBakery Page Builder Extension enqueue scripts conditionally. We need all scripts from start for AJAX navigation.
 * We set the wvc_force_enqueue_scripts filter to true right here if AJAX nav is enabled
 */
function kayo_wvc_force_enqueue_scripts() {

	if ( kayo_do_ajax_nav() ) {
		return true;
	}
}
add_filter( 'wvc_force_enqueue_scripts', 'kayo_wvc_force_enqueue_scripts' );

/**
 * Remove CSS and/or JS for Select2 used by WooCommerce.
 *
 * @link https://gist.github.com/Willem-Siebe/c6d798ccba249d5bf080.
 */
function kayo_dequeue_stylesandscripts_select2() {
	if ( class_exists( 'WooCommerce' ) && wp_is_mobile() ) {
		wp_dequeue_style( 'selectWoo' );
		wp_deregister_style( 'selectWoo' );

		wp_dequeue_script( 'selectWoo' );
		wp_deregister_script( 'selectWoo' );
	}
}
add_action( 'wp_enqueue_scripts', 'kayo_dequeue_stylesandscripts_select2', 100 );
