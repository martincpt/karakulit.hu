<?php
/**
 * Kayo site hook functions
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function kayo_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'kayo_pingback_header' );

/**
 * Output anchor at the very top of the page
 */
function kayo_output_top_anchor() {
	?>
	<div id="top"></div>
	<?php
}
add_action( 'kayo_body_start', 'kayo_output_top_anchor' );

/**
 * Output loader overlay
 */
function kayo_page_loading_overlay() {

	/**
	 * Loading overlay filter
	 *
	 * @since 1.0.0
	 */
	$show_overlay = apply_filters( 'kayo_display_loading_overlay', 'none' !== kayo_get_inherit_mod( 'loading_animation_type', 'none' ) );

	if ( ! $show_overlay ) {
		return;
	}
	?>
	<div id="loading-overlay" class="loading-overlay">
		<?php kayo_spinner(); ?>
	</div><!-- #loading-overlay.loading-overlay -->
	<?php
}
add_action( 'kayo_body_start', 'kayo_page_loading_overlay' );

/**
 * Output ajax loader overlay
 */
function kayo_ajax_loading_overlay() {

	if ( 'none' === kayo_get_theme_mod( 'ajax_animation_type', 'none' ) ) {
		return;
	}
	?>
	<div id="ajax-loading-overlay" class="loading-overlay">
		<?php kayo_spinner(); ?>
	</div><!-- #loading-overlay.loading-overlay -->
	<?php
}
add_action( 'wolf_site_content_start', 'kayo_ajax_loading_overlay' );

/**
 * Add panel closer overlay
 */
function kayo_add_panel_closer_overlay() {
	$toggle_class = 'toggle-side-panel';

	if ( 'offcanvas' === kayo_get_inherit_mod( 'menu_layout' ) ) {
		$toggle_class = 'toggle-offcanvas-menu';
	}

	/**
	 * Overlay menu toggle button class filter
	 *
	 * @since 1.0.0
	 */
	$toggle_class = apply_filters( 'kayo_panel_closer_overlay_class', $toggle_class );
	?>
	<div id="panel-closer-overlay" class="panel-closer-overlay <?php echo kayo_sanitize_html_classes( $toggle_class ); ?>"></div>
	<?php
}
add_action( 'kayo_main_content_start', 'kayo_add_panel_closer_overlay' );

/**
 * Scroll to top arrow
 */
function kayo_scroll_top_link() {
	?>
	<a href="#top" id="back-to-top" class="back-to-top">
	<?php
	/**
	 * Back to top button text
	 *
	 * @since 1.0.0
	 */
	echo esc_attr( apply_filters( 'kayo_backtop_text', esc_html__( 'Back to the top', 'kayo' ) ) );
	?>
	</a>
	<?php
}
add_action( 'kayo_body_start', 'kayo_scroll_top_link' );

/**
 * Output frame
 */
function kayo_frame_border() {

	if ( 'frame' === kayo_get_inherit_mod( 'site_layout' ) || kayo_is_customizer() ) {
		?>
		<span class="frame-border frame-border-top"></span>
		<span class="frame-border frame-border-bottom"></span>
		<span class="frame-border frame-border-left"></span>
		<span class="frame-border frame-border-right"></span>
		<?php
	}
}
add_action( 'kayo_body_start', 'kayo_frame_border' );

/**
 * Hero
 */
function kayo_output_hero_content() {

	$show_hero = true;

	/**
	 * No header post types array
	 *
	 * @since 1.0.0
	 */
	$no_hero_post_types = apply_filters( 'kayo_no_header_post_types', array( 'product', 'release', 'event', 'proof_gallery', 'attachment' ) );

	if ( is_single() && in_array( get_post_type(), $no_hero_post_types, true ) ) {
		$show_hero = false;
	}

	if ( is_single() && 'none' === get_post_meta( get_the_ID(), '_post_hero_layout', true ) ) {
		$show_hero = false;
	}

	/**
	 * Show hero header or not filter
	 *
	 * @since 1.0.0
	 */
	if ( apply_filters( 'kayo_show_hero', $show_hero ) ) {
		get_template_part( kayo_get_template_dirname() . '/components/layout/hero', 'content' );
	}
}
add_action( 'kayo_hero', 'kayo_output_hero_content' );

/**
 * Output Hero background
 *
 * Diplsay the hero background through the hero_background hook
 */
function kayo_output_hero_background() {

	echo kayo_get_hero_background(); // phpcs:ignore

	if ( kayo_get_inherit_mod( 'hero_scrolldown_arrow' ) ) {
		echo '<a class="scroll-down" id="hero-scroll-down-arrow" href="#"><i class="fa scroll-down-icon"></i></a>';
	}
}
add_action( 'kayo_hero_background', 'kayo_output_hero_background' );

/**
 * Output bottom bar with menu copyright text and social icons
 */
function kayo_bottom_bar() {

	$class           = 'site-infos wrap';
	$hide_bottom_bar = get_post_meta( get_the_ID(), '_post_bottom_bar_hidden', true );
	$services        = sanitize_text_field( kayo_get_theme_mod( 'footer_socials' ) );
	$display_menu    = has_nav_menu( 'tertiary' );
	$display_menu    = false;
	$credits         = kayo_get_theme_mod( 'copyright' );

	if ( 'yes' === $hide_bottom_bar ) {
		return;
	}

	if ( $services || $display_menu || $credits ) :
		?>
	<div class="site-infos clearfix">
		<div class="wrap">
			<div class="bottom-social-links">
				<?php
					/**
					 * Social icons
					 */
				if ( function_exists( 'wvc_socials' ) && $services ) {
					echo wvc_socials( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound
						array(
							'services' => $services,
							'size'     => 'fa-1x',
						)
					);
				}

				if ( function_exists( 'wolf_core_socials' ) && $services ) {
					echo wolf_core_socials( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound
						array(
							'services' => $services,
							'size'     => 'fa-1x',
						)
					);
				}
				?>
			</div><!-- .bottom-social-links -->
			<?php
				/**
				 * Fires in the Kayo bottom menu
				 *
				 * @since 1.0.0
				 */
				do_action( 'kayo_bottom_menu' );
			?>
			<?php if ( has_nav_menu( 'tertiary' ) ) : ?>
			<div class="clear"></div>
			<?php endif; ?>
			<div class="credits">
				<?php
					/**
					 * Fires in the Kayo footer text for customization.
					 *
					 * @since Kayo 1.0
					 */
					do_action( 'kayo_credits' );
				?>
			</div><!-- .credits -->
		</div>
	</div><!-- .site-infos -->
		<?php
	endif;
}
add_action( 'kayo_bottom_bar', 'kayo_bottom_bar' );

/**
 * Copyright/site info text
 *
 * @since Kayo 1.0.0
 */
function kayo_site_infos() {

	$footer_text = kayo_get_theme_mod( 'copyright' );

	if ( $footer_text ) {
		$footer_text = '<span class="copyright-text">' . $footer_text . '</span>';
		/**
		 * Copyright text filters
		 *
		 * @since 1.0.0
		 */
		echo kayo_kses( apply_filters( 'kayo_copyright_text', $footer_text ) );
	}
}
add_action( 'kayo_credits', 'kayo_site_infos' );

/**
 * Output top block beafore header using WVC Content Block plugin function
 */
function kayo_output_top_bar_block() {

	if ( ! function_exists( 'wccb_block' ) && ! function_exists( 'wolf_core_content_block' ) ) {
		return;
	}

	if ( is_404() ) {
		return;
	}

	$post_id = kayo_get_the_id();

	$block_mod  = kayo_get_theme_mod( 'top_bar_block_id' );
	$block_meta = get_post_meta( $post_id, '_post_top_bar_block_id', true );

	if ( ! is_single() && ! is_page() ) {
		$block_meta = null;
	}

	$block = ( $block_meta ) ? $block_meta : $block_mod;

	/* Shop page inheritance */
	$wc_meta = get_post_meta( kayo_get_woocommerce_shop_page_id(), '_post_top_bar_block_id', true );
	$is_wc_page_child = is_page() && wp_get_post_parent_id( $post_id ) == kayo_get_woocommerce_shop_page_id();

	$is_wc = kayo_is_woocommerce_page() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $wc_meta &&
		/**
		 * Force to display the top bar or not
		 *
		 * @since 1.0.0
		 */
		apply_filters( 'kayo_force_display_shop_top_bar_block_id', $is_wc ) ) {
		$block = $wc_meta;
	}

	/* Blog page inheritance */
	$blog_page_id = get_option( 'page_for_posts' );
	$blog_meta    = get_post_meta( $blog_page_id, '_post_top_bar_block_id', true );
	$is_blog_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $blog_page_id;

	$is_blog = kayo_is_blog() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $blog_meta &&
		/**
		 * Force to display the top bar on the blog or not
		 *
		 * @since 1.0.0
		 */
		apply_filters( 'kayo_force_display_blog_top_bar_block_id', $is_blog ) ) {
		$block = $blog_meta;
	}

	/* Video page inheritance */
	$video_page_id = kayo_get_videos_page_id();
	$video_meta    = get_post_meta( $video_page_id, '_post_top_bar_block_id', true );
	$is_video_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $video_page_id;

	$is_video = kayo_is_videos() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $video_meta &&
		/**
		 * Force to display the top bar on the video posts or not
		 *
		 * @since 1.0.0
		 */
		apply_filters( 'kayo_force_display_video_top_bar_block_id', $is_video ) ) {
		$block = $video_meta;
	}

	/* Portfolio page inheritance */
	$portfolio_page_id = kayo_get_portfolio_page_id();
	$portfolio_meta    = get_post_meta( $portfolio_page_id, '_post_top_bar_block_id', true );
	$is_portfolio_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $portfolio_page_id;

	$is_portfolio = kayo_is_portfolio() || is_singular( 'work' );

	if ( ! $block_meta && 'none' !== $block_meta && $portfolio_meta &&
		/**
		 * Force to display the top bar on the portfolio posts or not
		 *
		 * @since 1.0.0
		 */
		apply_filters( 'kayo_force_display_portfolio_top_bar_block_id', $is_portfolio ) ) {
		$block = $portfolio_meta;
	}

	/* Artists page inheritance */
	$artists_page_id = kayo_get_artists_page_id();
	$artists_meta    = get_post_meta( $artists_page_id, '_post_top_bar_block_id', true );
	$is_artists_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $artists_page_id;

	$is_artists = kayo_is_artists() || is_singular( 'artist' );

	if ( ! $block_meta && 'none' !== $block_meta && $artists_meta &&
		/**
		 * Force to display the top bar on the artist posts or not
		 *
		 * @since 1.0.0
		 */
		apply_filters( 'kayo_force_display_artists_top_bar_block_id', $is_artists ) ) {
		$block = $artists_meta;
	}

	/* Releases page inheritance */
	$releases_page_id = kayo_get_discography_page_id();
	$releases_meta    = get_post_meta( $releases_page_id, '_post_top_bar_block_id', true );
	$is_releases_page_child = is_page() && absint( wp_get_post_parent_id( $post_id ) ) === absint( $releases_page_id );

	$is_releases = kayo_is_discography() || is_singular( 'release' );

	if ( ! $block_meta && 'none' !== $block_meta && $releases_meta &&
		/**
		 * Force to display the top bar on the release posts or not
		 *
		 * @since 1.0.0
		 */
		apply_filters( 'kayo_force_display_releases_top_bar_block_id', $is_releases ) ) {
		$block = $releases_meta;
	}

	/* Events page inheritance */
	$events_page_id = kayo_get_events_page_id();
	$events_meta    = get_post_meta( $events_page_id, '_post_top_bar_block_id', true );
	$is_events_page_child = is_page() && absint( wp_get_post_parent_id( $post_id ) ) === absint( $events_page_id );

	$is_events = kayo_is_events() || is_singular( 'event' );

	if ( ! $block_meta && 'none' !== $block_meta && $events_meta &&
		/**
		 * Force to display the top bar on the event posts or not
		 *
		 * @since 1.0.0
		 */
		apply_filters( 'kayo_force_display_events_top_bar_block_id', $is_events ) ) {
		$block = $events_meta;
	}

	if ( is_search() ) {
		$block = get_post_meta( get_option( 'page_for_posts' ), '_post_top_bar_block_id', true );

		if ( isset( $_GET['post_type'] ) && 'product' === $_GET['post_type'] ) { // phphcs:ignore

			$block = get_post_meta( kayo_get_woocommerce_shop_page_id(), '_post_top_bar_block_id', true );

		} else {
			$block = get_post_meta( get_option( 'page_for_posts' ), '_post_top_bar_block_id', true );
		}
	}

	if ( $block && 'none' !== $block ) {

		wp_enqueue_script( 'js-cookie' );

		echo '<div id="top-bar-block">';

		echo kayo_get_block( $block ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound

		if ( 'yes' === kayo_get_inherit_mod( 'top_bar_closable' ) ) {
			echo '<a href="#" id="top-bar-close">' . esc_html__( 'Close', 'kayo' ) . '</a>';
		}

		echo '</div>';
	}
}
add_action( 'kayo_top_bar_block', 'kayo_output_top_bar_block' );

/**
 * Output top block after header using WVC Content Block plugin function
 */
function kayo_output_after_header_block() {

	if ( is_404() ) {
		return;
	}

	$post_id = kayo_get_the_id();

	$block_mod  = kayo_get_theme_mod( 'after_header_block' );
	$block_meta = get_post_meta( $post_id, '_post_after_header_block', true );

	if ( ! is_single() && ! is_page() ) {
		$block_meta = null;
	}

	$block = ( $block_meta ) ? $block_meta : $block_mod;

	/* Shop page inheritance */
	$wc_meta = get_post_meta( kayo_get_woocommerce_shop_page_id(), '_post_after_header_block', true );
	$is_wc_page_child = is_page() && wp_get_post_parent_id( $post_id ) == kayo_get_woocommerce_shop_page_id();

	$is_wc = kayo_is_woocommerce_page() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $wc_meta &&
		/**
		 * Force to display the top bar on the event posts or not
		 *
		 * @since 1.0.0
		 */
		apply_filters( 'kayo_force_display_shop_after_header_block', $is_wc ) ) {
		$block = $wc_meta;
	}

	/* Blog page inheritance */
	$blog_page_id = get_option( 'page_for_posts' );
	$blog_meta    = get_post_meta( $blog_page_id, '_post_after_header_block', true );
	$is_blog_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $blog_page_id;

	$is_blog = kayo_is_blog() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $blog_meta &&
		/**
		 * Force to display the header block in the blog
		 *
		 * @since 1.0.0
		 */
		apply_filters( 'kayo_force_display_blog_after_header_block', $is_blog ) ) {
		$block = $blog_meta;
	}

	/* Video page inheritance */
	$video_page_id = kayo_get_videos_page_id();
	$video_meta    = get_post_meta( $video_page_id, '_post_after_header_block', true );
	$is_video_page_child = is_page() && absint(wp_get_post_parent_id( $post_id )) === absint($video_page_id);

	$is_video = kayo_is_videos() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $video_meta &&
		/**
		 * Force to display the header block in the videos
		 *
		 * @since 1.0.0
		 */
		apply_filters( 'kayo_force_display_video_after_header_block', $is_video ) ) {
		$block = $video_meta;
	}

	/* Portfolio page inheritance */
	$portfolio_page_id = kayo_get_portfolio_page_id();
	$portfolio_meta    = get_post_meta( $portfolio_page_id, '_post_after_header_block', true );
	$is_portfolio_page_child = is_page() && absint(wp_get_post_parent_id( $post_id )) === absint($portfolio_page_id);

	$is_portfolio = kayo_is_portfolio() || is_singular( 'work' );

	if ( ! $block_meta && 'none' !== $block_meta && $portfolio_meta &&
		/**
		 * Force to display the header block in the portfolio
		 *
		 * @since 1.0.0
		 */
		apply_filters( 'kayo_force_display_portfolio_after_header_block', $is_portfolio ) ) {
		$block = $portfolio_meta;
	}

	/* Artists page inheritance */
	$artists_page_id = kayo_get_artists_page_id();
	$artists_meta    = get_post_meta( $artists_page_id, '_post_after_header_block', true );
	$is_artists_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $artists_page_id;

	$is_artists = kayo_is_artists() || is_singular( 'artist' );

	if ( ! $block_meta && 'none' !== $block_meta && $artists_meta &&
		/**
		 * Force to display the header block in the artists post
		 *
		 * @since 1.0.0
		 */
		apply_filters( 'kayo_force_display_artists_after_header_block', $is_artists ) ) {
		$block = $artists_meta;
	}

	/* Releases page inheritance */
	$releases_page_id = kayo_get_discography_page_id();
	$releases_meta    = get_post_meta( $releases_page_id, '_post_after_header_block', true );
	$is_releases_page_child = is_page() && absint( wp_get_post_parent_id( $post_id ) ) === absint( $releases_page_id );

	$is_releases = kayo_is_discography() || is_singular( 'release' );

	if ( ! $block_meta && 'none' !== $block_meta && $releases_meta &&
		/**
		 * Force to display the header block in the release posts
		 *
		 * @since 1.0.0
		 */
		apply_filters( 'kayo_force_display_releases_after_header_block', $is_releases ) ) {
		$block = $releases_meta;
	}

	/* Events page inheritance */
	$events_page_id = kayo_get_events_page_id();
	$events_meta    = get_post_meta( $events_page_id, '_post_after_header_block', true );
	$is_events_page_child = is_page() && absint( wp_get_post_parent_id( $post_id ) ) === absint( $events_page_id );

	$is_events = kayo_is_events() || is_singular( 'event' );

	if ( ! $block_meta && 'none' !== $block_meta && $events_meta &&
		/**
		 * Force to display the header block in the events post
		 *
		 * @since 1.0.0
		 */
		apply_filters( 'kayo_force_display_events_after_header_block', $is_events ) ) {
		$block = $events_meta;
	}

	if ( is_search() ) {
		$block = get_post_meta( get_option( 'page_for_posts' ), '_post_after_header_block', true );

		if ( isset( $_GET['post_type'] ) && 'product' === $_GET['post_type'] ) { // phpcs:ignore

			$block = get_post_meta( kayo_get_woocommerce_shop_page_id(), '_post_after_header_block', true );
		} else {
			$block = get_post_meta( get_option( 'page_for_posts' ), '_post_after_header_block', true );
		}
	}

	/**
	 * Header content block ID filters
	 *
	 * @since 1.0.0
	 */
	$block = apply_filters( 'kayo_after_header_block_id', $block );

	if ( $block && 'none' !== $block ) {
		echo kayo_get_block( $block ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound
	}
}
add_action( 'kayo_after_header_block', 'kayo_output_after_header_block' );

/**
 * Output bottom block before footer using WVC Content Block plugin function
 */
function kayo_output_before_footer_block() {

	if ( ! function_exists( 'wccb_block' ) && ! function_exists( 'wolf_core_content_block' ) ) {
		return;
	}

	if ( is_404() ) {
		return;
	}

	$post_id = kayo_get_the_id();

	$block_mod  = kayo_get_theme_mod( 'before_footer_block' );
	$block_meta = get_post_meta( $post_id, '_post_before_footer_block', true );
	$block      = ( $block_meta ) ? $block_meta : $block_mod;

	/* Shop page inheritance */
	$wc_meta          = get_post_meta( kayo_get_woocommerce_shop_page_id(), '_post_before_footer_block', true );
	$is_wc_page_child = is_page() && absint( wp_get_post_parent_id( $post_id ) ) === absint( kayo_get_woocommerce_shop_page_id() );
	$is_wc            = ( kayo_is_woocommerce_page() || $is_wc_page_child || is_singular( 'product' ) );

	if ( ! $block_meta && 'none' !== $block_meta && $wc_meta &&
		/**
		 * Force to display the footer block in the shop
		 *
		 * @since 1.0.0
		 */
		apply_filters( 'kayo_force_display_shop_pre_footer_block', $is_wc ) ) {
		$block = $wc_meta;
	}

	/* Blog page inheritance */
	$blog_page_id       = get_option( 'page_for_posts' );
	$blog_meta          = get_post_meta( $blog_page_id, '_post_before_footer_block', true );
	$is_blog_page_child = is_page() && absint( wp_get_post_parent_id( $post_id ) ) === absint( $blog_page_id );
	$is_blog            = ( kayo_is_blog() || $is_blog_page_child ) && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $blog_meta &&
		/**
		 * Force to display the footer block in the blog
		 *
		 * @since 1.0.0
		 */
		apply_filters( 'kayo_force_display_blog_pre_footer_block', $is_blog ) ) {
		$block = $blog_meta;
	}

	/**
	 * Filters the footer block ID
	 *
	 * @since 1.0.0
	 */
	$block = apply_filters( 'kayo_before_footer_block_id', $block );

	if ( $block && 'none' !== $block ) {

		echo kayo_get_block( $block ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound
	}
}
add_action( 'kayo_before_footer_block', 'kayo_output_before_footer_block', 28 );


/**
 * Output music network icons
 *
 * @see Wolf Music Network http://wolfthemes.com/plugin/wolf-music-network/
 */
function kayo_output_music_network() {

	if ( function_exists( 'wolf_music_network' ) ) {
		echo '<div class="music-social-icons-container clearfix">';
			wolf_music_network();
		echo '</div><!--.music-social-icons-container-->';
	}
}
add_action( 'kayo_before_footer_block', 'kayo_output_music_network' );
