<?php
/**
 * Kayo Navigation hook functions
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Output the main menu in the header
 */
function kayo_output_main_navigation() {

	if ( 'none' === kayo_get_inherit_mod( 'menu_layout', 'top-right' ) ) {
		return;
	}

	$desktop_menu_layout = kayo_get_inherit_mod( 'menu_layout', 'top-right' );

	/**
	 * Mobile menu template filter
	 *
	 * @since 1.0.0
	 */
	$mobile_menu_layout = apply_filters( 'kayo_mobile_menu_template', 'content-mobile' );
	?>
	<div id="desktop-navigation" class="clearfix">
		<?php
			/**
			 * Desktop Navigation
			 */
			get_template_part( kayo_get_template_dirname() . '/components/navigation/content', $desktop_menu_layout );

			/**
			 * Search form
			 */
			kayo_nav_search_form();
		?>
	</div><!-- #desktop-navigation -->

	<div id="mobile-navigation">
		<?php
			/**
			 * Mobile Navigation
			 */
			get_template_part( kayo_get_template_dirname() . '/components/navigation/' . $mobile_menu_layout );

			/**
			 * Search form
			 */
			kayo_nav_search_form( 'mobile' );
		?>
	</div><!-- #mobile-navigation -->
	<?php
}
add_action( 'kayo_main_navigation', 'kayo_output_main_navigation' );

/**
 * Output hamburger
 */
function kayo_output_sidepanel_hamburger() {
	?>
	<div class="hamburger-container hamburger-container-side-panel">
		<?php
			/**
			 * Menu hamburger icon
			 */
			kayo_hamburger_icon( 'toggle-side-panel' );
		?>
	</div><!-- .hamburger-container -->
	<?php
}
add_action( 'kayo_sidepanel_hamburger', 'kayo_output_sidepanel_hamburger' );

/**
 * Secondary navigation hook
 *
 * Display cart icons, social icons or secondary menu depending on customizer option
 *
 * @param string $context desktop or mobile.
 * @return void
 */
function kayo_output_complementary_menu( $context = 'desktop' ) {

	$cta_content = kayo_get_inherit_mod( 'menu_cta_content_type', 'none' );

	/**
	 * Force shop icons on woocommerce pages
	 */
	$is_wc_page_child = is_page() && wp_get_post_parent_id( get_the_ID() ) == kayo_get_woocommerce_shop_page_id() && kayo_get_woocommerce_shop_page_id(); // phpcs:ignore
	$is_wc            = kayo_is_woocommerce_page() || is_singular( 'product' ) || $is_wc_page_child;

	/**
	 * Filters whether to force the shop icons in the menu
	 *
	 * @since 1.0.0
	 */
	if ( apply_filters( 'kayo_force_display_nav_shop_icons', $is_wc ) ) {
		$cta_content = 'shop_icons';
	}

	/**
	 * If shop icons are set on discography page, apply on all release pages
	 */
	$is_disco_page_child = is_page() && absint( wp_get_post_parent_id( get_the_ID() ) ) === absint( kayo_get_discography_page_id() ) && kayo_get_discography_page_id();
	$is_disco_page       = is_page( kayo_get_discography_page_id() ) || is_singular( 'release' ) || $is_disco_page_child;

	if ( $is_disco_page && get_post_meta( kayo_get_discography_page_id(), '_post_menu_cta_content_type', true ) ) {
		$cta_content = get_post_meta( kayo_get_discography_page_id(), '_post_menu_cta_content_type', true );
	}

	/**
	 * If shop icons are set on events page, apply on all event pages
	 */
	$is_events_page_child = is_page() && absint( wp_get_post_parent_id( get_the_ID() ) ) === absint( kayo_get_events_page_id() ) && kayo_get_events_page_id();
	$is_events_page       = is_page( kayo_get_events_page_id() ) || is_singular( 'event' ) || $is_events_page_child;

	if ( $is_events_page && get_post_meta( kayo_get_events_page_id(), '_post_menu_cta_content_type', true ) ) {
		$cta_content = get_post_meta( kayo_get_events_page_id(), '_post_menu_cta_content_type', true );
	}
	?>
	<?php if ( 'shop_icons' === $cta_content && 'desktop' === $context ) { ?>
		<?php if ( kayo_display_shop_search_menu_item() ) : ?>
				<div class="search-container cta-item">
					<?php
						/**
						 * Search
						 */
						echo kayo_search_menu_item(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound
					?>
				</div><!-- .search-container -->
			<?php endif; ?>
			<?php if ( kayo_display_account_menu_item() ) : ?>
				<div class="account-container cta-item">
					<?php
						/**
						 * Account icon
						 */
						kayo_account_menu_item();
					?>
				</div><!-- .cart-container -->
			<?php endif; ?>
			<?php if ( kayo_display_wishlist_menu_item() ) : ?>
				<div class="wishlist-container cta-item">
					<?php
						/**
						 * Wishlist icon
						 */
						kayo_wishlist_menu_item();
					?>
				</div><!-- .cart-container -->
			<?php endif; ?>
			<?php if ( kayo_display_cart_menu_item() ) : ?>
				<div class="cart-container cta-item">
					<?php
						/**
						 * Cart icon
						 */
						kayo_cart_menu_item();

						/**
						 * Cart panel
						 */
						echo kayo_cart_panel(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound
					?>
				</div><!-- .cart-container -->
			<?php endif; ?>

	<?php } elseif ( 'search_icon' === $cta_content && 'desktop' === $context ) { ?>

		<div class="search-container cta-item">
			<?php
				/**
				 * Search
				 */
				echo kayo_kses( kayo_search_menu_item() );
			?>
		</div><!-- .search-container -->

		<?php
	} elseif ( 'socials' === $cta_content ) {

		if ( kayo_is_wolf_extension_activated() && ( function_exists( 'wvc_socials' ) || function_exists( 'wolf_core_get_socials' ) ) ) {

			if ( function_exists( 'wolf_core_social_icons' ) ) {

				echo wolf_core_social_icons( array( 'services' => kayo_get_inherit_mod( 'menu_socials', 'facebook,twitter,instagram' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound

			} elseif ( function_exists( 'wvc_socials' ) ) {

				echo wvc_socials( array( 'services' => kayo_get_inherit_mod( 'menu_socials', 'facebook,twitter,instagram' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped,Generic.Files.EndFileNewline.NotFound
			}
		}
	} elseif ( 'secondary-menu' === $cta_content && 'desktop' === $context ) {

		kayo_secondary_desktop_navigation();

	} elseif ( 'wpml' === $cta_content && 'desktop' === $context ) {

		/**
		 * WPML language selection hook
		 *
		 * @since 1.0.0
		 */
		do_action( 'wpml_add_language_selector' );

	} elseif ( 'custom' === $cta_content && 'desktop' === $context ) {

		/**
		 * Custom menu CTA content
		 *
		 * @since 1.0.0
		 */
		do_action( 'kayo_custom_menu_cta_content' );

	} // end type
}
add_action( 'kayo_secondary_menu', 'kayo_output_complementary_menu', 10, 1 );

/**
 * Add side panel
 */
function kayo_side_panel() {

	if ( kayo_can_display_sidepanel() ) {
		get_template_part( kayo_get_template_dirname() . '/components/layout/sidepanel' );
	}
}
add_action( 'kayo_body_start', 'kayo_side_panel' );

/**
 * Overwrite sidepanel position for non-top menu
 *
 * @param string $position the side panel position.
 * @return string
 */
function kayo_overwrite_side_panel_position( $position ) {

	$menu_layout = kayo_get_inherit_mod( 'menu_layout', 'top-right' );

	if ( $position && 'overlay' === $menu_layout ) {
		$position = 'left';
	}

	return $position;
}
add_action( 'kayo_side_panel_position', 'kayo_overwrite_side_panel_position' );

/**
 * Off Canvas menus
 */
function kayo_offcanvas_menu() {

	if ( 'offcanvas' !== kayo_get_inherit_mod( 'menu_layout' ) ) {
		return;
	}
	?>
	<div class="offcanvas-menu-panel">
		<?php
			/**
			 * Off-Canvas Menu Panel start hook
			 *
			 * @since 1.0.0
			 */
			do_action( 'kayo_offcanvas_menu_start' );
		?>
		<div class="offcanvas-menu-panel-inner">
			<?php
			/**
			 * Menu
			 */
			kayo_primary_vertical_navigation();
			?>
		</div><!-- .offcanvas-menu-panel-inner -->
	</div><!-- .offcanvas-menu-panel -->
	<?php
}
add_action( 'kayo_body_start', 'kayo_offcanvas_menu' );

/**
 * Infinite scroll pagination
 *
 * @param object $query The WP Query.
 * @param array  $pagination_args The pagination arguments.
 */
function kayo_output_pagination( $query = null, $pagination_args = array() ) {

	if ( ! $query ) {
		global $wp_query;
		$main_query = $wp_query;
		$query      = $wp_query;
	}

	$pagination_args = extract(
		wp_parse_args(
			$pagination_args,
			array(
				'post_type'                => 'post',
				'pagination_type'          => '',
				'view_more_text'           => '',
				'product_category_link_id' => '',
				'video_category_link_id'   => '',
				'paged'                    => 1,
				'container_id'             => '',
			)
		)
	);

	$max = $query->max_num_pages;

	/**
	 * Post_pagination filters
	 *
	 * @since 1.0.0
	 */
	$pagination_type = ( $pagination_type ) ? $pagination_type : apply_filters( 'kayo_post_pagination', kayo_get_theme_mod( 'post_pagination' ) );

	/**
	 * Load more butotn CSS class
	 *
	 * @since 1.0.0
	 */
	$button_class = apply_filters( 'kayo_loadmore_button_class', 'button', $pagination_type );

	/**
	 * Load more button container CSS class filters
	 *
	 * @since 1.0.0
	 */
	$container_class = apply_filters( 'kayo_loadmore_container_class', 'trigger-container wvc-element' );

	if ( 'link_to_blog' === $pagination_type ) {

		?>
		<div class="<?php echo kayo_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url( kayo_get_blog_url() ); ?>"><span>
								 <?php
									/**
									 * View more posts text filter
									 *
									 * @since 1.0.0
									 */
									echo esc_html( apply_filters( 'kayo_view_more_posts_text', esc_html__( 'View more posts', 'kayo' ) ) );
									?>
			</span></a>
		</div>
		<?php

	} elseif ( 'link_to_shop' === $pagination_type ) {

		/**
		 * View more products text filter
		 *
		 * @since 1.0.0
		 */
		$view_more_text = ( ! empty( $view_more_text ) ) ? $view_more_text : apply_filters( 'kayo_view_more_products_text', esc_html__( 'View more products', 'kayo' ) );
		?>
		<div class="<?php echo kayo_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url( kayo_get_shop_url() ); ?>"><span><?php echo esc_html( $view_more_text ); ?></span></a>
		</div>
		<?php

	} elseif ( 'link_to_shop_category' === $pagination_type && $product_category_link_id ) {
		$cat_url = get_category_link( $product_category_link_id );

		/**
		 * View more products text filter
		 *
		 * @since 1.0.0
		 */
		$view_more_text = ( ! empty( $view_more_text ) ) ? $view_more_text : apply_filters( 'kayo_view_more_products_text', esc_html__( 'View more products', 'kayo' ) );
		?>
		<div class="<?php echo kayo_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url( $cat_url ); ?>"><span><?php echo esc_html( $view_more_text ); ?></span></a>
		</div>
		<?php

	} elseif ( 'link_to_portfolio' === $pagination_type ) {
		/**
		 * View more works text filter
		 *
		 * @since 1.0.0
		 */
		$view_more_text = ( ! empty( $view_more_text ) ) ? $view_more_text : apply_filters( 'kayo_view_more_works_text', esc_html__( 'View more works', 'kayo' ) );
		?>
		<div class="<?php echo kayo_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url( kayo_get_portfolio_url() ); ?>"><span><?php echo esc_html( $view_more_text ); ?></span></a>
		</div>
		<?php

	} elseif ( 'link_to_events' === $pagination_type ) {

		?>
		<div class="<?php echo kayo_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url( kayo_get_events_url() ); ?>"><span>
				<?php
				/**
				 * View more events text filter
				 *
				 * @since 1.0.0
				 */
				echo esc_html( apply_filters( 'kayo_view_more_events_text', esc_html__( 'View more events', 'kayo' ) ) );
				?>
			</span></a>
		</div>
		<?php

	} elseif ( 'link_to_videos' === $pagination_type ) {

		?>
		<div class="<?php echo kayo_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url( kayo_get_videos_url() ); ?>"><span>
				<?php
				/**
				 * View more videos text filter
				 *
				 * @since 1.0.0
				 */
				echo esc_html( apply_filters( 'kayo_view_more_videos_text', esc_html__( 'View more videos', 'kayo' ) ) );
				?>
			</span></a>
		</div>
		<?php

	} elseif ( 'link_to_video_category' === $pagination_type && $video_category_link_id ) {
		$cat_url = get_category_link( $video_category_link_id );
		?>
		<div class="<?php echo kayo_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url( $cat_url ); ?>"><span>
			<?php
			/**
			 * View more products text filter
			 *
			 * @since 1.0.0
			 */
			echo esc_html( apply_filters( 'kayo_view_more_products_text', esc_html__( 'View more products', 'kayo' ) ) );
			?>
			</span></a>
		</div>
		<?php

	} elseif ( 'link_to_artists' === $pagination_type ) {

		?>
		<div class="<?php echo kayo_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url( wolf_artists_get_page_link() ); ?>"><span>
			<?php
			/**
			 * View more artists text filter
			 *
			 * @since 1.0.0
			 */
			echo esc_html( apply_filters( 'kayo_view_more_artists_text', esc_html__( 'View more artists', 'kayo' ) ) );
			?>
			</span></a>
		</div>
		<?php

	} elseif ( 'link_to_albums' === $pagination_type ) {
		?>
		<div class="<?php echo kayo_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url( kayo_get_albums_url() ); ?>"><span>
			<?php
			/**
			 * View more albums text filter
			 *
			 * @since 1.0.0
			 */
			echo esc_html( apply_filters( 'kayo_view_more_albums_text', esc_html__( 'View more albums', 'kayo' ) ) );
			?>
			</span></a>
		</div>
		<?php

	} elseif ( 'link_to_discography' === $pagination_type ) {
		?>
		<div class="<?php echo kayo_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url( kayo_get_discography_url() ); ?>"><span>
			<?php
			/**
			 * View more releases text filter
			 *
			 * @since 1.0.0
			 */
			echo esc_html( apply_filters( 'kayo_view_more_releases_text', esc_html__( 'View more releases', 'kayo' ) ) );
			?>
			</span></a>
		</div>
		<?php

	} elseif ( 'link_to_attachments' === $pagination_type && function_exists( 'kayo_get_photos_url' ) && kayo_get_photos_url() ) {
		?>
		<div class="<?php echo kayo_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url( kayo_get_photos_url() ); ?>"><span>
				<?php
				/**
				 * View more photos text filter
				 *
				 * @since 1.0.0
				 */
				echo esc_html( apply_filters( 'kayo_view_more_photos_text', esc_html__( 'View more photos', 'kayo' ) ) );
				?>
			</span></a>
		</div>
		<?php

	} elseif ( 'load_more' === $pagination_type ) {

		wp_enqueue_script( 'kayo-loadposts', get_template_directory_uri() . '/assets/js/loadposts.min.js', array( 'jquery' ), '1.0', true );

		$next_page = $paged + 1;

		$next_page_href = get_pagenum_link( $next_page );
		?>
		<?php if ( 1 < $max && $next_page <= $max ) : ?>
			<div class="<?php echo kayo_sanitize_html_classes( $container_class ); ?>">
				<a data-current-page="1" data-next-page="<?php echo absint( $next_page ); ?>" data-max-pages="<?php echo absint( $max ); ?>" class="<?php echo esc_attr( $button_class ); ?> loadmore-button" data-current-url="<?php echo esc_url( kayo_get_current_url() ); ?>" href="<?php echo esc_url( $next_page_href ); ?>"><span>
					<?php
					/**
					 * Load more text filter
					 *
					 * @since 1.0.0
					 */
					echo esc_html( apply_filters( 'kayo_load_more_posts_text', esc_html__( 'Load More', 'kayo' ) ) );
					?>
				</span></a>
			</div><!-- .trigger-containe -->
		<?php endif; ?>
		<?php

	} elseif ( 'infinitescroll' === $pagination_type ) {

		if ( 'attachment' === $post_type ) {
			kayo_paging_nav( $query );
		}
	} elseif ( 'none' !== $pagination_type && ( 'numbers' === $pagination_type || 'standard_pagination' === $pagination_type ) ) {

		/**
		 * Pagination numbers
		 */
		if ( ! kayo_is_home_as_blog() ) {
			$GLOBALS['wp_query']->max_num_pages       = $max; // overwrite max_num_pages with custom query
			$GLOBALS['wp_query']->query_vars['paged'] = $paged;
		}

		the_posts_pagination(
			/**
			 * Post pagination arguments filter
			 *
			 * @since 1.0.0
			 */
			apply_filters(
				'kayo_the_post_pagination_args',
				array(
					'prev_text' => '<i class="pagination-icon-prev"></i>',
					'next_text' => '<i class="pagination-icon-next"></i>',
				)
			)
		);
	}
}
add_action( 'kayo_pagination', 'kayo_output_pagination', 10, 3 );
