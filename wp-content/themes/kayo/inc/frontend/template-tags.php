<?php
/**
 * Kayo template tags
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Edit post link
 *
 * @param  boolean $echo or not.
 * @return void
 */
function kayo_edit_post_link( $echo = true ) {

	if ( ! is_user_logged_in() ) {
		return;
	}

	$output = '';

	ob_start();
	edit_post_link( esc_html__( 'Edit', 'kayo' ), '<span class="meta-icon edit-pencil"></span>' );

	if ( is_user_logged_in() ) {
		$output = '<span class="custom-edit-link">' . ob_get_clean() . '</span>';
	}

	if ( 'elementor' === kayo_get_plugin_in_use() && 'post' === get_post_type() ) {
		/* translators: %s: Elementor */
		$output .= '<span class="custom-edit-link"><span class="meta-icon edit-pencil"></span><a class="post-edit-link" href="' . get_edit_post_link() . '&action=elementor">' . sprintf( esc_html__( 'Edit with %s', 'kayo' ), 'Elementor' ) . '</a></span>';
	}

	if ( $echo && $output ) {
		echo kayo_kses( $output );
	}

	return $output;
}

/**
 * Get extra post meta
 *
 * Display comment count, likes, views and reading time
 *
 * @param  boolean $echo Output the result or not.
 * @param  string  $post_type The post type.
 * @return void
 */
function kayo_get_extra_meta( $echo = true, $post_type = null ) {
	$output = '';

	$post_type = ( $post_type ) ? $post_type : get_post_type();

	$comments = kayo_get_comments_count( false );

	if ( ! class_exists( 'Wolf_Custom_Post_Meta' ) && 0 === absint( $comments ) ) {
		return;
	}

	if ( class_exists( 'Wolf_Custom_Post_Meta' ) ) {
		$output      .= '<div class="post-extra-meta">';
		$likes        = wolf_custom_post_meta_get_likes();
		$views        = wolf_custom_post_meta_get_views();
		$reading_time = wolf_custom_post_meta_get_post_reading_time();

		$display_meta = kayo_list_to_array( kayo_get_theme_mod( 'enable_custom_post_meta' ) );

		if ( 'post' !== $post_type ) {
			$display_meta = kayo_list_to_array( kayo_get_theme_mod( $post_type . '_enable_custom_post_meta' ) );
		}

		$post_enable_views        = ( in_array( $post_type . '_enable_views', $display_meta, true ) );
		$post_enable_likes        = ( in_array( $post_type . '_enable_likes', $display_meta, true ) );
		$post_enable_reading_time = ( in_array( $post_type . '_enable_reading_time', $display_meta, true ) );

		if ( $post_enable_likes ) {

			$output .= '<span class="post-meta post-likes wolf-like-this" data-post-id="' . esc_attr( get_the_ID() ) . '"><i class="fa fa-heart-o likes-icon meta-icon"></i>' . sprintf(
				wp_kses(
					/* translators: %s: Likes count */
					__( '<span class="wolf-likes-count">%s</span> likes', 'kayo' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				$likes
			) . '</span>';
		}

		if ( $post_enable_views ) {

			$output .= '<span class="post-meta post-views"><i class="meta-icon views-icon"></i>' . sprintf(
				/* translators: %s: Views count */
				esc_html__( '%s views', 'kayo' ), $views ) . '</span>';
		}

		if ( $post_enable_reading_time ) {

			$output .= '<span class="post-meta post-reading-time"><i class="meta-icon reading-time-icon"></i>' . sprintf(
				/* translators: %s: Minutes count */
				esc_html__( '%s min', 'kayo' ), $reading_time ) . '</span>';
		}
	}

	if ( 0 < get_comments_number() && comments_open() ) {
		$output .= '<span class="post-meta post-comments">
			<a class="scroll" href="' . esc_url( get_permalink() . '#comments' ) . '">
			<span class="meta-icon comments-icon"></span>' . sprintf(
				/* translators: %s: comments count */
				_n( '%s <span class="comment-text">comment</span>', '%s <span class="comment-text">comments</span>', $comments, 'kayo' ),
				$comments
			) . '</a>
		</span>';
	}

	if ( class_exists( 'Wolf_Custom_Post_Meta' ) ) {
		$output .= '</div><!-- .post-extra-meta -->';
	}

	if ( $echo ) {
		echo kayo_kses( $output ); // WCS XSS ok.
	}

	return $output;
}

/**
 * Get date
 *
 * @param bool $echo Output the result or not.
 * @return string
 */
function kayo_entry_date( $echo = true, $link = false, $post_id = null ) {

	$post_id               = ( $post_id ) ? $post_id : get_the_ID();
	$display_time          = get_the_date( '', $post_id );
	$modified_display_time = get_the_modified_date( '', $post_id );

	if ( 'human_diff' === kayo_get_theme_mod( 'date_format' ) ) {
		$display_time = sprintf(
			/* translators: %s: time ago */
			esc_html__( '%s ago', 'kayo' ),
			human_time_diff( get_the_time( 'U', $post_id ), current_time( 'timestamp' ) )
		);
		$modified_display_time = sprintf(
			/* translators: %s: time ago */
			esc_html__( '%s ago', 'kayo' ),
			human_time_diff( get_the_modified_time( 'U', $post_id ), current_time( 'timestamp' ) )
		);
	}

	$date = $display_time;

	if ( get_the_time( 'U', $post_id ) !== get_the_modified_time( 'U', $post_id ) ) {
		$time_string = '<time itemprop="datePublished" class="published" datetime="%1$s">%2$s</time><time itemprop="dateModified" class="updated" datetime="%3$s">%4$s</time>';
	} else {
		$time_string = '<time itemprop="datePublished" class="published updated" datetime="%1$s">%2$s</time>';
	}

	$_time = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c', $post_id ) ),
		esc_html( $display_time ),
		esc_attr( get_the_modified_date( 'c', $post_id ) ),
		esc_html( $modified_display_time )
	);

	if ( $link ) {
		$date = sprintf(
			'<span class="posted-on date"><a href="%1$s" rel="bookmark">%2$s</a></span>',
			esc_url( get_permalink() ),
			$_time
		);
	} else {
		$date = sprintf(
			'<span class="posted-on date">%2$s</span>',
			esc_url( get_permalink( $post_id ) ),
			$_time
		);
	}

	if ( $echo ) {
		/**
		 * Entry date filtered
		 *
		 * @since 1.0.0
		 */
		echo apply_filters( 'kayo_entry_date', kayo_kses( $date ) ); // WCS XSS ok.
	}

	/**
	 * Entry date filtered
	 *
	 * @since 1.0.0
	 */
	return apply_filters( 'kayo_entry_date', kayo_kses( $date ) );
}

/**
 * Get comments count
 *
 * @param boolean $echo Output or not.
 * @return string
 */
function kayo_get_comments_count( $echo = true ) {

	if ( $echo ) {
		echo absint( get_comments_number() );
	}

	return get_comments_number();
}

/**
 *  Get Author Avatar
 *
 * @param integer $size The avatar size.
 * @return void
 */
function kayo_get_author_avatar( $size = 20 ) {

	$output      = '<span class="author-meta">';
		$output .= '<a class="author-link" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">';
		$output .= get_avatar( get_the_author_meta( 'user_email' ), $size );
		$output .= '</a>';

	$output .= sprintf(
		'<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr(
			sprintf(
			/* translators: %s: author name */
				__( 'View all posts by %s', 'kayo' ),
				get_the_author()
			)
		),
		/**
		 * Filters the author name meta
		 *
		 * @since 1.0.0
		 */
		apply_filters( 'kayo_author_name_meta', kayo_the_author( false ) )
	);

	$output .= '</span><!--.author-meta-->';

	/**
	 * Filters the author avatar HTML output
	 *
	 * @since 1.0.0
	 */
	echo apply_filters( 'kayo_author_avatar_html', kayo_kses( $output ) ); // WCS XSS ok.
}

/**
 * Get Author
 */
function kayo_get_author() {

	$output = sprintf(
		'<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s %4$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr(
			sprintf(
			/* translators: %s: author name */
				__( 'View all posts by %s', 'kayo' ),
				get_the_author()
			)
		),
		esc_html__( 'by', 'kayo' ),
		kayo_the_author( false )
	);

	echo kayo_kses( $output );
}

/**
 * Get author instagram URL and username
 *
 * @return array
 */
function kayo_get_author_instagram_username( $author_id = null ) {

	if ( ! $author_id ) {
		global $post;

		if ( ! is_object( $post ) ) {
			return;
		}

		$author_id = $post->post_author;
	}

	$author_instagram = get_the_author_meta( 'instagram', $author_id );

	if ( $author_instagram ) {
		if ( preg_match( '/instagram.com\/[a-zA-Z0-9_]+/', $author_instagram, $match ) ) {
			$insta_username = str_replace( 'instagram.com/', '', $match[0] );
			return $insta_username;
		}
	}
}

/**
 * Display work meta for Portfolio "work" post type
 */
function kayo_work_meta() {
	$post_id = get_the_ID();
	$date    = get_the_date();
	$client  = get_post_meta( $post_id, '_work_client', true );
	$link    = get_post_meta( $post_id, '_work_link', true );
	$skills  = get_the_term_list( $post_id, 'work_type', '', esc_html__( ', ', 'kayo' ), '' );

	/**
	 * Filters the work meta separator
	 *
	 * @since 1.0.0
	 */
	$separator = apply_filters( 'kayo_work_meta_separator', '&mdash;' );
	?>
	<ul>
	<?php if ( $skills ) : ?>
		<li class="work-meta work-categories">
			<i class="fa fa-tag"></i> <span class="work-meta-label"><?php esc_html_e( 'Category', 'kayo' ); ?></span> <span class="work-meta-separator"><?php echo esc_attr( $separator ); ?></span> <span class="work-meta-value"><?php echo kayo_kses( $skills ); ?></span>
		</li>
	<?php endif; ?>

	<?php if ( $client ) : ?>
		<li class="work-meta work-client">
			<i class="fa fa-user-o"></i> <span class="work-meta-label"><?php esc_html_e( 'Client', 'kayo' ); ?></span> <span class="work-meta-separator"><?php echo esc_attr( $separator ); ?></span> <span class="work-meta-value"><a target="_blank" href="<?php echo esc_url( $link ); ?>"><?php echo esc_attr( $client ); ?></a></span>
		</li>
	<?php endif; ?>

	<?php do_action( 'kayo_work_meta_end' ); ?>

	</ul>
	<?php
}

if ( ! function_exists( 'kayo_the_work_meta' ) ) {
	/**
	 * Work Custom Fields
	 */
	function kayo_the_work_meta() {
		/**
		 * Filters the work meta separator
		 *
		 * @since 1.0.0
		 */
		$separator     = apply_filters( 'kayo_work_meta_separator', '&mdash;' );
		$excluded_meta = array(
			'slide_template',
			'wv_video_id',
			'total_sales',
			'rs_page_bg_color',
			'nav_overlay_left_block_id',
			'nav_overlay_right_block_id',
		);

		$keys = get_post_custom_keys();

		if ( $keys ) {
			echo '<ul>';
			foreach ( (array) $keys as $key ) {
				$keyt = trim( $key );
				if ( is_protected_meta( $keyt, 'post' ) || in_array( $keyt, $excluded_meta, true ) ) {
						continue;
				}
					$values = array_map( 'trim', get_post_custom_values( $key ) );
					$value  = implode( ', ', $values );
				?>
				<li class="work-meta work-<?php echo esc_attr( sanitize_title_with_dashes( $key ) ); ?>">
					<span class="work-meta-label"><?php echo esc_attr( sanitize_text_field( $key ) ); ?></span>
					<span class="work-meta-separator"><?php echo esc_attr( sanitize_text_field( $separator ) ); ?></span>
					<span class="work-meta-value"><?php echo esc_attr( sanitize_text_field( $value ) ); ?></span>
				</li>
				<?php
			}
			echo '</ul>';
		}
	}
}

if ( ! function_exists( 'kayo_the_author' ) ) {
	/**
	 * Get the author
	 *
	 * @param bool $echo Output the result of not.
	 * @return string $author
	 */
	function kayo_the_author( $echo = true ) {

		global $post;

		if ( ! is_object( $post ) ) {
			return;
		}

		$author_id = $post->post_author;
		$author    = get_the_author_meta( 'user_nicename', $author_id );

		if ( get_the_author_meta( 'nickname', $author_id ) ) {
			$author = get_the_author_meta( 'nickname', $author_id );
		}

		if ( get_the_author_meta( 'first_name', $author_id ) ) {
			$author = get_the_author_meta( 'first_name', $author_id );

			if ( get_the_author_meta( 'last_name', $author_id ) ) {
				$author .= ' ' . get_the_author_meta( 'last_name', $author_id );
			}
		}

		if ( $echo ) {
			$author = sprintf( '<span class="vcard author"><span class="fn">%s</span></span>', $author );
			echo kayo_kses( $author );
		}

		return $author;

	}
}

/**
 * Navigation search form
 *
 * @param string $context Mobile or desktop.
 */
function kayo_nav_search_form( $context = 'desktop' ) {

	/**
	 * Filters whether to display the navigation search form or not
	 *
	 * @since 1.0.0
	 */
	if ( apply_filters( 'kayo_display_nav_search_from', true ) ) {

		$cta_content = kayo_get_inherit_mod( 'menu_cta_content_type', 'search_icon' );
		$class       = '';

		$type = ( 'shop_icons' === $cta_content ) ? 'shop' : 'blog';

		/**
		 * Force shop icons on woocommerce pages
		 */
		$is_wc_page_child = is_page() && wp_get_post_parent_id( get_the_ID() ) == kayo_get_woocommerce_shop_page_id() && kayo_is_woocommerce();
		$is_wc            = kayo_is_woocommerce_page() || is_singular( 'product' ) || $is_wc_page_child;

		/**
		 * Filters whether to display the shop icons in the navigation or not
		 *
		 * @since 1.0.0
		 */
		if ( apply_filters( 'kayo_force_display_nav_shop_icons', $is_wc ) ) {
			$type  = 'shop';
			$class = 'live-search-form';
		}

		/**
		 * Filters whether to display the product search form or not
		 *
		 * @since 1.0.0
		 */
		if ( apply_filters( 'kayo_force_nav_search_product', $is_wc ) ) {
			$type  = 'shop';
			$class = 'live-search-form';
		}

		if ( 'shop_icons' === kayo_get_inherit_mod( 'menu_cta_content_type', 'search_product_icon' ) ) {
			$type  = 'shop';
			$class = 'live-search-form';
		}

		if ( ! class_exists( 'WooCommerce' ) ) {
			$type = 'blog';
		}

		/**
		 * Filters navigation search form type (post or product)
		 *
		 * @since 1.0.0
		 */
		$type = apply_filters( 'kayo_nav_search_form_type', $type );

		?>
		<div class="nav-search-form search-type-<?php echo kayo_sanitize_html_classes( $type ); ?>">
			<div class="nav-search-form-container <?php echo kayo_sanitize_html_classes( $class ); ?>">
				<?php
					/**
					 * Output product or post search form
					 */
				if ( 'shop' === $type ) {
					if ( function_exists( 'get_product_search_form' ) ) {
						get_product_search_form();
					}
				} else {
					get_search_form();
				}
				?>
				<span id="nav-search-loader-<?php echo esc_attr( $context ); ?>" class="<?php echo esc_attr( apply_filters( 'kayo_nav_search_loader_class', 'fa search-form-loader fa-circle-o-notch fa-spin' ) ); ?>"></span>
				<span id="nav-search-close-<?php echo esc_attr( $context ); ?>" class="<?php echo esc_attr( apply_filters( 'kayo_nav_search_close_class', 'toggle-search fa lnr-cross' ) ); ?>"></span>
			</div><!-- .nav-search-form-container -->
		</div><!-- .nav-search-form -->
		<?php
	}
}

/**
 * Output logo
 *
 * @param boolean $echo Output the logo ot not.
 * @return void
 */
function kayo_logo( $echo = true ) {

	$output = '';

	/**
	 * Filters the logo SVG URL
	 *
	 * @since 1.0.0
	 */
	$logo_svg = apply_filters( 'kayo_logo_svg', kayo_get_theme_mod( 'logo_svg' ) );

	/**
	 * Filters the light logo image URL
	 *
	 * @since 1.0.0
	 */
	$logo_light = apply_filters( 'kayo_logo_light', kayo_get_theme_mod( 'logo_light' ) );

	/**
	 * Filters the dark logo image URL
	 *
	 * @since 1.0.0
	 */
	$logo_dark = apply_filters( 'kayo_logo_dark', kayo_get_theme_mod( 'logo_dark' ) );

	if ( $logo_svg || $logo_light || $logo_dark ) {

		/**
		 * Filters the navigation logo link URL
		 *
		 * @since 1.0.0
		 */
		$home_url = apply_filters( 'kayo_logo_home_url', home_url( '/' ) );

		$output = '<div class="logo"><a href="' . esc_url( $home_url ) . '" rel="home" class="logo-link">';

		if ( $logo_svg ) {

			$output .= '<img src="' . esc_url( $logo_svg ) . '" alt="' . esc_attr( __( 'logo-svg', 'kayo' ) ) . '" class="svg logo-img logo-svg">';

		} else {
			if ( $logo_light ) {
				$output .= '<img src="' . esc_url( $logo_light ) . '" alt="' . esc_attr( __( 'logo-light', 'kayo' ) ) . '" class="logo-img logo-light">';
			}

			if ( $logo_dark ) {
				$output .= '<img src="' . esc_url( $logo_dark ) . '" alt="' . esc_attr( __( 'logo-dark', 'kayo' ) ) . '" class="logo-img logo-dark">';
			}
		}

		$output .= '</a>
			</div><!-- .logo -->';
	} else {
		$output .= '<div class="logo logo-is-text"><a class="logo-text logo-link" href="' . esc_url( home_url( '/' ) ) . '" rel="home">';

		$output .= get_bloginfo( 'name' );

		$output .= '</a></div>';
	}

	/**
	 * Filters the logo markup output
	 *
	 * @since 1.0.0
	 */
	$output = apply_filters( 'kayo_logo_html', $output );

	if ( $echo && $output ) {
		echo kayo_kses( $output );
	}

	return kayo_kses( $output );
}

/**
 * Get the first embed video URL to use as video background
 *
 * Supports self hosted video and youtube
 *
 * @param int $post_id The post ID.
 * @return void
 */
function kayo_entry_video_background( $post_id = null ) {

	$post_id = ( $post_id ) ? $post_id : get_the_ID();

	if ( kayo_get_first_url( $post_id ) ) {

		$video_url = kayo_get_first_url( $post_id );

		$img_src = get_the_post_thumbnail_url( $post_id, 'large' );

		if ( preg_match( '#youtu#', $video_url, $match ) ) {

			echo kayo_youtube_video_bg( $video_url, $img_src ); // phpcs:ignore

		} elseif ( preg_match( '#.vimeo#', $video_url, $match ) ) {

			echo kayo_vimeo_bg( $video_url ); // phpcs:ignore

		} elseif ( preg_match( '#.mp4#', $video_url, $match ) ) {

			echo kayo_video_bg( $video_url ); // phpcs:ignore
		}
	}
}

/**
 * Display social networks in author bio box
 */
function kayo_author_socials( $author_id = null ) {

	if ( ! $author_id ) {
		$author_id = get_the_author_meta( 'ID' );
	}

	$name    = get_the_author_meta( 'user_nicename', $author_id );
	$website = get_the_author_meta( 'user_url', $author_id );

	if ( function_exists( 'wvc_get_team_member_socials' ) || function_exists( 'wolf_core_get_team_member_socials' ) ) {

		$services = wvc_get_team_member_socials();

		if ( function_exists( 'wolf_core_get_team_member_socials' ) ) {
			$services = wolf_core_get_team_member_socials();
		} else {
			$services = wvc_get_team_member_socials();
		}

		foreach ( $services as $service ) {

			$link      = get_the_author_meta( $service );
			$icon_slug = $service;

			$title_attr = sprintf(
				/* translators: %s author's name */
				esc_html__( 'Visit %1$s\'s %2$s profile', 'kayo' ),
				$name,
				ucfirst( $service )
			);

			if ( 'email' === $service ) {
				$icon_slug  = 'envelope';
				$title_attr = sprintf(
					/* translators: %s author's name */
					esc_html__( 'Send an email to %s', 'kayo' ), $name );
			}

			if ( $link ) {
				echo '<a target="_blank" title="' . esc_attr( $title_attr ) . '" href="' . esc_url( $link ) . '" class="author-link hastip"><i class="fa fa-' . $icon_slug . '"></i></a>';
			}
		}
	} else {

		$googleplus = get_the_author_meta( 'googleplus', $author_id );
		$twitter    = get_the_author_meta( 'twitter', $author_id );
		$facebook   = get_the_author_meta( 'facebook', $author_id );

		if ( $facebook ) {
			echo '<a target="_blank" title="' . esc_attr( sprintf( __( 'Visit %s\'s Facebook profile', 'kayo' ), $name ) ) . '" href="' . esc_url( $facebook ) . '" class="author-link"><i class="fa fa-facebook"></i></a>';
		}

		if ( $twitter ) {
			echo '<a target="_blank" title="' . sprintf( __( 'Visit %s\'s Twitter feed', 'kayo' ), $name ) . '" href="'. esc_url( 'https://twitter.com/' . $twitter ) .'" class="author-link"><i class="fa fa-twitter"></i></a>';
		}
	}

	if ( $website ) {
		echo '<a target="_blank" title="' . esc_attr( sprintf( __( 'Visit %s\'s website', 'kayo' ), $name ) ) . '" href="' . esc_url( $website ) . '" class="author-link hastip"><i class="fa fa-link"></i></a>';
	}
}

/**
 * Template tag to display the loader
 */
function kayo_spinner() {

	$loading_logo           = kayo_get_inherit_mod( 'loading_logo' );
	$loading_logo_animation = kayo_get_inherit_mod( 'loading_logo_animation' );
	$loading_animation_type = kayo_get_inherit_mod( 'loading_animation_type' );

	/**
	 * Filters the condition for displaying the loading logo
	 *
	 * @since 1.0.0
	 */
	$show_logo = apply_filters( 'kayo_display_loading_logo', ( $loading_logo && 'logo' === $loading_animation_type ) );

	if ( 'none' === $loading_animation_type ) {
		return;
	}
	?>
	<div class="loader">
	<?php if ( $show_logo ) : ?>
		<?php ob_start(); ?>
		<img class="loading-logo <?php echo sanitize_html_class( $loading_logo_animation ); ?>" src="<?php echo esc_url( $loading_logo ); ?>" alt="<?php esc_attr_e( 'loading logo', 'kayo' ); ?>">
		<?php
			/**
			 * Filters the condition for displaying the loading logo
			 *
			 * @since 1.0.0
			 */
			echo kayo_kses( apply_filters( 'kayo_loading_logo', ob_get_clean() ) ); ?>
	<?php else : ?>
		<?php get_template_part( esc_html(
			/**
			 * Filters the spinner folder name
			 *
			 * @since 1.0.0
			 */
			apply_filters( 'kayo_spinners_folder', kayo_get_template_dirname() . '/components/spinner/' ) ) . $loading_animation_type ); ?>
	<?php endif; ?>
	</div><!-- #loader.loader -->
	<?php
}
if ( ! function_exists( 'kayo_search_menu_item' ) ) {
	/**
	 * Search icon menu item
	 *
	 * @param boolean $echo Output the result or not.
	 * @return string
	 */
	function kayo_search_menu_item( $echo = false ) {

		ob_start();
		?>
			<span title="<?php esc_attr_e( 'Search', 'kayo' ); ?>" class="search-item-icon toggle-search"></span>
		<?php
		$search_item = ob_get_clean();

		if ( $echo ) {
			echo kayo_kses( apply_filters( 'kayo_search_menu_item_html', $search_item ) );
		}

		return apply_filters( 'kayo_search_menu_item_html', $search_item );
	}
}

if ( ! function_exists( 'kayo_account_menu_item' ) ) {
	/**
	 * Account menu item
	 *
	 * @param boolean $echo Output the result or not.
	 * @return void
	 */
	function kayo_account_menu_item( $echo = true ) {

		if ( ! function_exists( 'wc_get_page_id' ) ) {
			return;
		}

		$label = esc_html__( 'Sign In or Register', 'kayo' );
		$class = 'account-item-icon';

		if ( is_user_logged_in() ) {
			$label  = esc_html__( 'My account', 'kayo' );
			$class .= ' account-item-icon-user-logged-in';
		} else {
			$label  = esc_html__( 'Sign In or Register', 'kayo' );
			$class .= ' account-item-icon-user-not-logged-in';
		}

		if ( WP_DEBUG ) {
			$class .= ' account-item-icon-user-not-logged-in';
		}

		$account_url = get_permalink( wc_get_page_id( 'myaccount' ) );

		ob_start();
		?>
			<a class="<?php echo kayo_sanitize_html_classes( $class ); ?>" href="<?php echo esc_url( $account_url ); ?>" title="<?php echo esc_attr( $label ); ?>">
			</a>
		<?php
		$account_item = ob_get_clean();

		if ( $echo ) {
			echo kayo_kses( apply_filters( 'kayo_account_menu_item_html', $account_item ) );
		}

		return apply_filters( 'kayo_account_menu_item_html', $account_item );
	}
}

if ( ! function_exists( 'kayo_cart_menu_item' ) ) {
	/**
	 * Cart menu item markup
	 *
	 * @param boolean $echo Output the result or not.
	 * @return void
	 */
	function kayo_cart_menu_item( $echo = true ) {

		if ( ! function_exists( 'wc_get_cart_url' ) ) {
			return;
		}

		$product_count = WC()->cart->get_cart_contents_count();
		ob_start();
		?>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'Cart', 'kayo' ); ?>" class="cart-item-icon toggle-cart">
				<span class="cart-icon-product-count"><?php echo absint( $product_count ); ?></span>
			</a>
		<?php
		$cart_item = ob_get_clean();

		if ( $echo ) {
			echo kayo_kses( apply_filters( 'kayo_cart_menu_item_html', $cart_item ) );
		}

		return apply_filters( 'kayo_cart_menu_item_html', $cart_item );
	}
}

/**
 * Account menu item for mobile menu
 */
function kayo_account_menu_item_mobile( $echo = true ) {

	if ( ! function_exists( 'wc_get_page_id' ) ) {
			return;
	}

		$label = esc_html__( 'Login', 'kayo' );
		$class = 'account-item-mobile';

	if ( is_user_logged_in() ) {
		$label  = esc_html__( 'My Account', 'kayo' );
		$class .= ' account-item-mobile-user-logged-in';
	} else {
		$label  = esc_html__( 'Login', 'kayo' );
		$class .= ' account-item-mobile-user-not-logged-in';
	}

	if ( WP_DEBUG ) {
		$class .= ' account-item-mobile-user-not-logged-in';
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

		return apply_filters( 'kayo_account_menu_item_mobile_html', $account_item );
}

/**
 * Cart menu item for mobile menu
 */
function kayo_cart_menu_item_mobile( $echo = true ) {

	if ( ! function_exists( 'wc_get_page_id' ) ) {
		return;
	}

	$cta_content = kayo_get_inherit_mod( 'menu_cta_content_type', 'search_icon' );

	if ( 'shop_icons' !== $cta_content ) {
		return;
	}

	$product_count = WC()->cart->get_cart_contents_count();
	ob_start();
	?>
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'Cart', 'kayo' ); ?>" class="cart-item-mobile toggle-cart-mobile">
			<span class="cart-label-mobile"><?php esc_html_e( 'Cart', 'kayo' ); ?>
			<span class="cart-icon-product-count"><?php echo absint( $product_count ); ?></span>
			</span>
		</a>
	<?php
	$cart_item = ob_get_clean();

	if ( $echo ) {
		echo kayo_kses( apply_filters( 'kayo_cart_menu_item_mobile_html', $cart_item ) );
	}

	return apply_filters( 'kayo_cart_menu_item_mobile_html', $cart_item );
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
			<a href="<?php echo esc_url( $wishlist_url ); ?>" title="<?php esc_attr_e( 'My Wishlist', 'kayo' ); ?>" class="wishlist-item-icon"></a>
		<?php
		$wishlist_item = ob_get_clean();

		if ( $echo ) {
			echo kayo_kses( apply_filters( 'kayo_wishlist_menu_item_html', $wishlist_item ) );
		}

		return apply_filters( 'kayo_wishlist_menu_item_html', $wishlist_item );
	}
}

if ( ! function_exists( 'kayo_cart_panel' ) ) {
	/**
	 * Cart menu item
	 */
	function kayo_cart_panel() {

		if ( ! function_exists( 'WC' ) ) {
			return;
		}

		$cart_url     = wc_get_cart_url();
		$checkout_url = wc_get_checkout_url();
		$items        = WC()->cart->get_cart();

		ob_start();
		?>
		<div class="cart-panel">
			<ul class="cart-item-list">
				<?php if ( $items ) : ?>
					<?php foreach ( $items as $cart_item_key => $cart_item ) : ?>
						<?php
							$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
							$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
						if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :

							$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
							?>
							<li class="cart-item-list-item clearfix">
								<span class="cart-item-image">
									<?php
									$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

									if ( ! $product_permalink ) {
										echo kayo_kses( $thumbnail );
									} else {
										printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
									}
									?>
								</span>
								<span class="cart-item-details">
									<span class="cart-item-title">
										<?php
										if ( ! $product_permalink ) {
											echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
										} else {
											echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_title() ), $cart_item, $cart_item_key );
										}
										?>
									</span>
									<span class="cart-item-price">
										<?php echo esc_attr( $cart_item['quantity'] ); ?> x
										<?php
											echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
										?>
									</span>

								</span>
							</li>
						<?php endif; // endif visible ?>
					<?php endforeach; ?>

					<li class="cart-panel-subtotal">
						<span class="cart-subtotal-label">
							<?php esc_html_e( 'Total', 'kayo' ); ?>:
						</span>
						<span class="cart-subtotal">
							<?php echo kayo_kses( WC()->cart->get_cart_subtotal() ); ?>
						</span>
					</li>
					<li class="cart-panel-buttons">
						<a href="<?php echo esc_url( wc_get_cart_url() ); ?>">
							<i class="fa cart-panel-cart-icon"></i>
							<?php esc_html_e( 'View Cart', 'kayo' ); ?>
						</a>
						<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>">
							<i class="fa cart-panel-checkout-icon"></i>
							<?php esc_html_e( 'Checkout', 'kayo' ); ?>
						</a>
					</li>
				<?php else : ?>
					<li class="cart-panel-no-product"><?php esc_html_e( 'No product in cart yet.', 'kayo' ); ?></li>
				<?php endif; ?>
			</ul><!-- .cart-item-list -->
		</div><!-- .cart-panel -->
		<?php
		$cart_item = ob_get_clean();

		return $cart_item;
	}
} // end function check

/**
 * Get audio embed content
 */
function kayo_get_audio_embed_content( $post_id, $embed = true ) {

	if ( kayo_is_elementor_page( $post_id ) ) {

		$audio = kayo_get_elementor_audio_embed_content( $post_id );

	} else {

		$audio     = null;
		$pattern   = get_shortcode_regex();
		$first_url = kayo_get_first_url( $post_id );

		$shortcodes = array(
			'audio',
			'playlist',
			'wolf_jplayer_playlist',
			'wolf_playlist',
			'wvc_playlist',
			'wvc_audio',
			'wvc_audio_embed',
			'mixcloud',
			'reverbnation',
			'soundcloud',
			'spotify',
		);

		$first_url = str_replace( 'embed/', '', $first_url );

		if ( kayo_is_audio_embed_post( $post_id ) ) {

			if ( $embed ) {
				$audio = wp_oembed_get( $first_url, array( 'width' => 750 ) );
			} else {
				$audio = $first_url;
			}
		} elseif ( has_block( 'audio', $post_id ) ) {

			if ( $embed ) {
				$audio = do_shortcode( '[audio mp3="' . esc_url( $first_url ) . '"]' );
			} else {
				$audio = $first_url;
			}
		} else {
			foreach ( $shortcodes as $shortcode ) {
				if ( kayo_shortcode_preg_match( $shortcode ) ) {
					$match = kayo_shortcode_preg_match( $shortcode );
					if ( $embed ) {
						$audio = do_shortcode( $match[0] );
					} else {
						$audio = $match[0];
					}
					break;
				}
			}
		}
	}

	return $audio;
}

/**
 * Output primary desktop navigation
 */
function kayo_primary_desktop_navigation() {
	get_template_part( kayo_get_template_dirname() . '/components/menu/menu', 'desktop' );
}

/**
 * Output primary vertical navigation
 */
function kayo_primary_vertical_navigation() {
	get_template_part( kayo_get_template_dirname() . '/components/menu/menu', 'vertical' );
}

/**
 * Output secondary desktop navigation
 */
function kayo_secondary_desktop_navigation() {
	get_template_part( kayo_get_template_dirname() . '/components/menu/menu', 'secondary' );
}

/**
 * Output primary mobile navigation
 */
function kayo_primary_mobile_navigation() {
	get_template_part( kayo_get_template_dirname() . '/components/menu/menu', 'mobile' );
}

/**
 * Hamburger icon
 */
function kayo_hamburger_icon( $class = 'toggle-mobile-menu' ) {

	if ( 'toggle-side-panel' === $class ) {
		$title_attr = esc_html__( 'Side Panel', 'kayo' );
	} else {
		$title_attr = esc_html__( 'Menu', 'kayo' );
	}

	ob_start();
	?>
	<a class="hamburger-icon <?php echo esc_attr( $class ); ?>" href="#" title="<?php echo esc_attr( $title_attr ); ?>">
		<span class="line line-1"></span>
		<span class="line line-2"></span>
		<span class="line line-3"></span>
	</a>
	<?php
	$html = ob_get_clean();

	echo apply_filters(
		'kayo_hamburger_icon',
		wp_kses(
			$html,
			array(
				'a'    => array(
					'class' => array(),
					'href'  => array(),
					'title' => array(),
				),
				'span' => array(
					'class' => array(),
				),
			)
		),
		$class,
		$title_attr
	);
}

/**
 * Returns page title outside the loop
 *
 * @return string
 */
function kayo_output_post_title() {

	if ( is_author() && class_exists( 'Wolf_Photos' ) ) {

		get_template_part( kayo_get_template_dirname() . '/components/post/author', 'heading' );
		rewind_posts();

	} elseif ( kayo_get_post_title() ) {

		$title              = kayo_get_post_title();
		$title_inline_style = '';
		$title_class        = 'post-title entry-title';

		/* Big text & custom header font */
		if ( is_single() || is_page() ) {

			$bigtext        = get_post_meta( get_the_ID(), '_post_hero_title_bigtext', true );
			$font_family    = get_post_meta( get_the_ID(), '_post_hero_title_font_family', true );
			$font_transform = get_post_meta( get_the_ID(), '_post_hero_title_font_transform', true );

			if ( $bigtext ) {
				$title_class .= ' wvc-bigtext';
			}

			if ( $font_family ) {
				$title_inline_style .= 'font-family:' . esc_attr( $font_family ) . ';';
			}

			if ( $font_transform ) {
				$title_class .= ' text-transform-' . esc_attr( $font_transform );
			}
		}

		$output = '<h1 itemprop="name" style="' . kayo_esc_style_attr( $title_inline_style ) . '" class="' . kayo_sanitize_html_classes( $title_class ) . '"><span>' . apply_filters( 'kayo_hero_post_title', $title ) . '</span></h1>';

		echo kayo_kses( $output ); // WCS XSS ok.
	}
}
add_action( 'kayo_hero_title', 'kayo_output_post_title' );

/**
 * Returns page title outside the loop
 *
 * @return string
 */
function kayo_get_post_title() {

	$title = get_the_title();

	if ( kayo_is_home_as_blog() ) {
		$title = get_bloginfo( 'description' );
	}

	/* Main condition not 404 and not woocommerce page */
	if ( ! is_404() && ! kayo_is_woocommerce_page() ) {

		if ( kayo_is_blog() ) {

			if ( is_category() ) {

				$title = single_cat_title( '', false );

			} elseif ( is_tag() ) {

				$title = single_tag_title( '', false );

			} elseif ( is_author() ) {

				$title = get_the_author();

			} elseif ( is_day() ) {

				$title = get_the_date();

			} elseif ( is_month() ) {

				$title = get_the_date( 'F Y' );

			} elseif ( is_year() ) {

				$title = get_the_date( 'Y' );

				/* is blog index */
			} elseif ( kayo_is_blog_index() && ! kayo_is_home_as_blog() ) {

				$title = get_the_title( get_option( 'page_for_posts' ) );
			}
		} elseif ( is_tax() ) {

			$queried_object = get_queried_object();

			if ( is_object( $queried_object ) && isset( $queried_object->name ) ) {
				$title = $queried_object->name;
			}
		} elseif ( isset( $_GET['s'] ) && isset( $_GET['post_type'] ) && 'attachment' === $_GET['post_type'] ) {

			$s = esc_attr( $_GET['s'] );

			$title = sprintf(
				/* translators: %s de search term */
				esc_html__( 'Search results for %s', 'kayo' ), '<span class="search-query-text">&quot;' . esc_html( $s ) . '&quot;</span>' );

		} elseif ( is_single() ) {

			$title = get_the_title();
		}
	} elseif ( kayo_is_woocommerce_page() ) { // shop title.

		if ( is_shop() || is_product_taxonomy() ) {

			$title = ( function_exists( 'woocommerce_page_title' ) ) ? woocommerce_page_title( false ) : '';

		} else {
			$title = get_the_title();
		}
	}

	if ( is_search() ) {

		$s = ( isset( $_GET['s'] ) ) ? esc_attr( $_GET['s'] ) : '';

		$title = sprintf(
			/* translatros: %s: the search term */
			esc_html__( 'Search results for %s', 'kayo' ), '<span class="search-query-text">&quot;' . $s . '&quot;</span>' );
	}

	return $title;
}

/**
 * Return the subheading of a post
 *
 * @param int $post_id The post ID.
 * @return string
 */
function kayo_get_the_subheading( $post_id = null ) {

	if ( ! $post_id ) {
		$post_id = kayo_get_the_id();
	}

	if ( kayo_is_woocommerce_page() ) {
		if ( is_shop() || is_product_taxonomy() ) {
			$post_id = ( function_exists( 'kayo_get_woocommerce_shop_page_id' ) ) ? kayo_get_woocommerce_shop_page_id() : false;
		}
	}

	return apply_filters( 'kayo_the_subheading', get_post_meta( $post_id, '_post_subheading', true ), $post_id );
}

/**
 * Fire add to wishlist function
 *
 * If Wolf WooCommerce Wishlist is installed, it will output the add to wishlist button
 */
function kayo_add_to_wishlist() {
	if ( function_exists( 'wolf_add_to_wishlist' ) ) {
		wolf_add_to_wishlist();
	}
}

/**
 * Display slideshow background
 *
 * @param array $args The slideshow arguments.
 * @return string
 */
function kayo_entry_slider( $args = array() ) {

	extract(
		wp_parse_args(
			$args,
			array(
				'slideshow_image_size' => apply_filters( 'kayo_entry_slider_image_size', '750x300' ),
				'slideshow_img_ids'    => '',
				'slideshow_speed'      => 4000,
			)
		)
	);

	$output = '';

	if ( '' === $slideshow_img_ids ) {

		$slideshow_img_ids = kayo_get_post_gallery_ids();
	}

	$slideshow_img_ids = kayo_list_to_array( $slideshow_img_ids );

	if ( array() !== $slideshow_img_ids ) {

		$slideshow_img_ids = array_slice( $slideshow_img_ids, 0, 3 ); // first 3 ids only.

		$output .= '<div data-slideshow-speed="' . absint( $slideshow_speed ) . '" class="entry-slider flexslider"><ul class="slides">';

		foreach ( $slideshow_img_ids as $image_id ) {

			$output .= '<li class="slide">';
			$output .= kayo_resized_thumbnail( $slideshow_image_size, '', $image_id, false );

			$output .= '</li>';
		}

		$output .= '</ul></div>';
	}

	return $output;
}

/**
 * Filter password form
 *
 * @param string $output The password form markup to filter.
 * @return void
 */
function kayo_get_the_password_form( $output ) {

	global $post;
	$current_post = get_post( $post );
	$label        = 'pwbox-' . ( empty( $current_post->ID ) ? wp_rand() : $current_post->ID );

	$output = '<form action="' . esc_url( home_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form clearfix" method="post">
	<p>' . esc_html__( 'This content is password protected. To view it please enter your password below:', 'kayo' ) . '</p>
	<p><label for="' . $label . '">' . esc_html__( 'Password:', 'kayo' ) . '</label> <input name="post_password" id="' . $label . '" type="password"> <input class="password-submit" type="submit" name="Submit" value="' . esc_attr_x( 'Enter', 'post password form', 'kayo' ) . '" /></p></form>
	';

	return $output;
}
add_filter( 'the_password_form', 'kayo_get_the_password_form' );

/**
 * Excerpt more
 * Render "Read more" link text differenttly depending on post format
 *
 * @return string
 */
function kayo_more_text() {

	$text = '<span>' . esc_html__( 'Continue reading', 'kayo' ) . '</span>';

	return apply_filters( 'kayo_more_text', $text );
}

/**
 * Output "more" button
 */
function kayo_more_button() {

	return '<a rel="bookmark" class="' . apply_filters( 'kayo_more_link_button_class', 'more-link' ) . '" href="' . get_permalink() . '">' . kayo_more_text() . '</a>';
}

/**
 * Add custom class to the more link
 *
 * @param string $link The "read more" link.
 * @param string $text The "read more" link test.
 */
function kayo_add_more_link_class( $link, $text ) {

	return str_replace(
		'more-link',
		apply_filters( 'kayo_more_link_button_class', 'more-link' ),
		$link
	);
}
add_action( 'the_content_more_link', 'kayo_add_more_link_class', 10, 2 );

/**
 * Get exceprt lenght
 */
function kayo_get_excerpt_lenght() {
	return absint( apply_filters( 'kayo_excerpt_length', 14 ) );
}

/**
 * Excerpt length hook
 *
 * Set the number of character to display in the excerpt
 *
 * @param int $length The excerpt lenght.
 * @return int
 */
function kayo_excerpt_length( $length ) {

	if ( is_single() ) {
		$lenght = 999999;
	} else {
		$lenght = kayo_get_excerpt_lenght();
	}

	return $length;
}
add_filter( 'excerpt_length', 'kayo_excerpt_length' );

/**
 * Excerpt "more" link
 *
 * @param string $more
 * @return string
 */
function kayo_excerpt_more( $more ) {

	return '...<p>' . kayo_more_button() . '</p>';
}
add_filter( 'excerpt_more', 'kayo_excerpt_more' );

/**
 * Filter previous comments link
 */
function kayo_comments_link_prev_class( $atts ) {

	return 'class="pagination-icon-prev"';
}
add_filter( 'previous_comments_link_attributes', 'kayo_comments_link_prev_class' );

/**
 * Filter next comments link
 */
function kayo_comments_link_next_class( $atts ) {
	return 'class="pagination-icon-next"';
}
add_filter( 'next_comments_link_attributes', 'kayo_comments_link_next_class' );

if ( ! function_exists( 'kayo_entry_tags' ) ) {
	/**
	 * Get the entry tags
	 */
	function kayo_entry_tags( $echo = true ) {

		$output = '';

		if ( get_the_tag_list() ) {
			ob_start();
			?>
			<span class="entry-tags-list">
				<?php echo apply_filters( 'kayo_entry_tag_list_icon', '<span class="meta-icon hashtag"></span>' ); ?>
				<?php echo get_the_tag_list( '', apply_filters( 'kayo_entry_tag_list_separator', ' ' ) ); ?>
			</span>
			<?php
			$output = ob_get_clean();

			if ( $echo ) {
				echo wp_kses(
					$output,
					array(
						'span' => array(
							'class' => array(),
						),
						'a'    => array(
							'class' => array(),
							'href'  => array(),
							'rel'   => array(),
						),
					)
				);
			}

			return $output;
		}
	}
}

if ( ! function_exists( 'kayo_post_thumbnail' ) ) {
	/**
	 * Post thumbnail
	 *
	 * @param string size
	 * @return string image
	 */
	function kayo_post_thumbnail( $size = '', $post_id = null ) {

		$thumbnail = get_the_post_thumbnail( '', $size );

		if ( ! $thumbnail && kayo_is_instagram_post( $post_id ) ) {
			$thumbnail = kayo_get_instagram_image( kayo_get_first_url( $post_id ) );
		}

		return $thumbnail;
	}
}

if ( ! function_exists( 'kayo_justified_post_thumbnail' ) ) {
	/**
	 * Post thumbnail
	 */
	function kayo_justified_post_thumbnail( $size = 'kayo-photo', $post_id = '', $echo = true ) {

		$thumbnail = '';
		$post_id   = ( $post_id ) ? $post_id : get_post_thumbnail_id();
		$src       = wp_get_attachment_image_src( $post_id, $size );
		$src       = $src[0];
		$image_alt = get_post_meta( $post_id, '_wp_attachment_image_alt', true );

		$metadata = wp_get_attachment_metadata( $post_id );
		$width    = '';
		$height   = '';

		if ( isset( $metadata['sizes'][ $size ] ) ) {
			$width  = $metadata['sizes'][ $size ]['width'];
			$height = $metadata['sizes'][ $size ]['height'];
		}

		ob_start();
		?>
		<img
			class="lazy-hidden"
			width="<?php echo absint( $width ); ?>"
			height="<?php echo absint( $height ); ?>"
			src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/blank.gif' ); ?>"
			title="<?php echo esc_attr( get_the_title() ); ?>"
			alt="<?php echo esc_attr( $image_alt ); ?>"
			data-src="<?php echo esc_url( $src ); ?>"
		>
		<?php
		$thumbnail = ob_get_clean();

		if ( $echo ) {
			echo kayo_kses( $thumbnail );
		}

		return $thumbnail;
	}
}

/**
 * Metro entry title
 *
 * Use for the metro_modern_alt only ATM
 */
function kayo_post_grid_entry_title( $title = null ) {

	if ( ! $title ) {
		$title = get_the_title();
	}

	$format        = get_post_format();
	$the_permalink = ( 'link' === $format && kayo_get_first_url() ) ? kayo_get_first_url() : get_the_permalink();

	$product_id = get_post_meta( get_the_ID(), '_post_wc_product_id', true );
	if ( $product_id && 'publish' === get_post_status( $product_id ) ) {
		$format = 'product';
	}

	if ( ! kayo_is_short_post_format() && 'product' !== $format ) :
		?>
		<span class="date-label">
			<?php if ( is_sticky() ) : ?>
				<?php esc_html_e( 'Featured', 'kayo' ); ?>
			<?php else : ?>
				<?php kayo_entry_date(); ?>
			<?php endif; ?>
		</span>
	<?php endif; ?>
	<span class="entry-summary">
		<?php if ( 'video' === $format ) : ?>
			<?php if ( kayo_get_first_video_url() ) : ?>
				<a href="<?php echo esc_url( kayo_get_first_video_url() ); ?>" class="post-play-video-icon lightbox-video">
			<?php endif; ?>
			<span class="format-label"><?php esc_html_e( 'Watch', 'kayo' ); ?></span>
			<?php if ( kayo_get_first_video_url() ) : ?>
				</a>
			<?php endif; ?>
			<br>
		<?php elseif ( 'audio' === $format ) : ?>
			<?php if ( kayo_get_first_mp3_url() ) : ?>
				<a title="<?php esc_attr_e( 'Play audio', 'kayo' ); ?>" href="<?php echo esc_url( kayo_get_first_mp3_url() ); ?>" class="post-play-audio-icon loop-post-play-button">
			<?php endif; ?>
			<span class="format-label"><?php esc_html_e( 'Listen', 'kayo' ); ?></span>
			<?php if ( kayo_get_first_mp3_url() ) : ?>
				</a>
				<audio class="loop-post-player-audio" id="<?php echo esc_attr( uniqid( 'loop-post-player-audio-' ) ); ?>" src="<?php echo esc_url( kayo_get_first_mp3_url() ); ?> "></audio>
			<?php endif; ?>
			<br>

			<?php
		elseif ( 'product' === $format ) :
			$product      = wc_get_product( $product_id );
			$permalink    = get_permalink( $product->get_id() );
			$price        = $product->get_price_html();
			$button_class = apply_filters( 'kayo_post_product_button', 'button post-product-button' );
			?>
			<a href="<?php echo esc_url( $the_permalink ); ?>">
				<h2 class="entry-title"><?php echo kayo_kses( $title ); ?></h2>
			</a>
			<?php if ( $price ) : ?>
				<span class="post-product-price">
					<?php echo kayo_kses( $price ); ?>
				</span>
			<?php endif; ?>
			<a class="<?php echo kayo_sanitize_html_classes( $button_class ); ?>" href="<?php echo esc_url( $permalink ); ?>"><?php esc_html_e( 'Shop Now', 'kayo' ); ?></a>
		<?php endif; ?>
		<?php if ( 'product' !== $format ) : ?>
			<a href="<?php echo esc_url( $the_permalink ); ?>">
				<h2 class="entry-title"><?php echo kayo_kses( $title ); ?></h2>
				<?php if ( ! kayo_is_short_post_format() && 'video' !== $format && 'audio' !== $format ) : ?>
					<span class="view-post"><?php esc_html_e( 'View post', 'kayo' ); ?></span>
				<?php endif; ?>
			</a>
		<?php endif ?>
	</span>
	<?php
}

/**
 * Returns the content for standard post layout without the featured media if any
 */
function kayo_content( $more_text ) {
	global $post;

	$the_content = '';

	if ( ! is_single() && $post->post_excerpt || is_search() ) {

		$the_content = get_the_excerpt();

	} else {

		$media_to_filter = '';
		$content         = get_the_content( $more_text );

		if ( kayo_is_instagram_post() ) {
			$media_to_filter = kayo_get_first_url();
		}

		if ( kayo_is_video_post() ) {
			$media_to_filter = kayo_get_first_video_url();
		}

		if ( $media_to_filter ) {

			$content = str_replace( $media_to_filter, '', $content );
		}

		$the_content = apply_filters( 'the_content', $content );
	}

	return $the_content;
}

/*
=======================
 * Post Content Standard hook
 =======================
 */

/**
 * Post Sticky Label
 */
function kayo_output_post_content_standard_sticky_label() {

	if ( is_sticky() && ! is_paged() ) {
		echo '<span class="sticky-post" title="' . esc_attr( __( 'Featured', 'kayo' ) ) . '"></span>';
	}
}
add_action( 'kayo_before_post_content_standard', 'kayo_output_post_content_standard_sticky_label' );

/**
 * Post Media
 */
function kayo_output_post_content_standard_media( $post_display_elements, $display, $post_id ) {

	if ( in_array( 'show_thumbnail', $post_display_elements, true ) || 'link' === get_post_format( $post_id ) ) {
		if ( kayo_featured_media( $post_id ) ) {
			?>
			<div class="entry-media">
				<?php echo kayo_featured_media( $post_id ); ?>
			</div>
			<?php
		}
	}
}
add_action( 'kayo_before_post_content_standard_title', 'kayo_output_post_content_standard_media', 10, 3 );

/**
 * Post Date
 */
function kayo_output_post_content_standard_date( $post_display_elements ) {
	if ( in_array( 'show_date', $post_display_elements, true ) && ! get_post_format() || 'video' === get_post_format() || 'gallery' === get_post_format() || 'image' === get_post_format() || 'audio' === get_post_format() ) {
		?>
		<span class="entry-date">
			<?php kayo_entry_date( true, true ); ?>
		</span>
		<?php
	}
}
add_action( 'kayo_before_post_content_standard_title', 'kayo_output_post_content_standard_date', 10, 1 );

/**
 * Post title
 */
function kayo_output_post_content_standard_title() {

	if ( ! get_post_format() || 'video' === get_post_format() || 'gallery' === get_post_format() || 'image' === get_post_format() || 'audio' === get_post_format() ) {
		the_title( '<h2 class="entry-title"><a class="entry-link" href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
	}
}
add_action( 'kayo_post_content_standard_title', 'kayo_output_post_content_standard_title' );

/**
 * Post Text
 */
function kayo_output_post_content_standard_excerpt( $post_display_elements, $post_excerpt_type ) {
	if ( in_array( 'show_text', $post_display_elements, true ) ) {
		if ( ! kayo_is_short_post_format() ) {
			?>
			<div class="entry-summary clearfix">
				<?php

					/**
					 * The excerpt
					 */
					do_action( 'kayo_the_excerpt', $post_excerpt_type );

					wp_link_pages(
						array(
							'before'      => '<div class="clear"></div><div class="page-links clearfix">' . esc_html__( 'Pages:', 'kayo' ),
							'after'       => '</div>',
							'link_before' => '<span class="page-number">',
							'link_after'  => '</span>',
						)
					);
				?>
			</div>
			<?php
		}
	}
}
add_action( 'kayo_after_post_content_standard_title', 'kayo_output_post_content_standard_excerpt', 10, 2 );

/**
 * Post meta
 *
 * @param array $post_display_elements The post elements to display.
 * @return void
 */
function kayo_output_post_content_standard_meta( $post_display_elements ) {
	$show_author     = ( in_array( 'show_author', $post_display_elements, true ) );
	$show_category   = ( in_array( 'show_category', $post_display_elements, true ) );
	$show_tags       = ( in_array( 'show_tags', $post_display_elements, true ) );
	$show_extra_meta = ( in_array( 'show_extra_meta', $post_display_elements, true ) );
	?>
	<?php if ( ( $show_author || $show_extra_meta || $show_category || kayo_edit_post_link( false ) ) && ! kayo_is_short_post_format() ) : ?>
			<footer class="entry-meta">
				<?php if ( $show_author ) : ?>
					<?php kayo_get_author_avatar(); ?>
				<?php endif; ?>
				<?php if ( $show_category ) : ?>
					<span class="entry-category-list">
						<?php echo kayo_kses( apply_filters( 'kayo_entry_category_list_icon', '<span class="meta-icon category-icon"></span>' ) ); ?>
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
			</footer><!-- .entry-meta -->
		<?php endif; ?>
	<?php
}
add_action( 'kayo_after_post_content_standard', 'kayo_output_post_content_standard_meta', 10, 1 );

/*
=======================
 * Post Content Masonry hook
=======================
*/

/**
 * Post Media
 *
 * @param array  $post_display_elements Post elements to display.
 * @param string $display The display option (grid, masonry, etc.).
 * @return void
 */
function kayo_output_post_content_grid_media( $post_display_elements = array(), $display = null ) {
	$show_thumbnail = ( in_array( 'show_thumbnail', $post_display_elements, true ) );
	$show_category  = ( in_array( 'show_category', $post_display_elements, true ) );
	?>
	<?php if ( $show_thumbnail ) : ?>
		<?php if ( kayo_has_post_thumbnail() || kayo_is_instagram_post() ) : ?>
			<div class="entry-image">
				<?php if ( $show_category ) : ?>
					<a class="category-label" href="<?php echo esc_url( kayo_get_first_category_url() ); ?>"><?php echo kayo_get_first_category(); ?></a>
				<?php endif; ?>
				<?php
				if ( is_sticky() && ! is_paged() ) {
					echo '<span class="sticky-post" title="' . esc_attr( __( 'Featured', 'kayo' ) ) . '"></span>';
				}

				if ( 'masonry' === $display ) {

					echo kayo_post_thumbnail( 'kayo-masonry' ); // WCS XSS ok.

				} else {

					?>
						<div class="entry-cover">
						<?php
							echo kayo_background_img(
								array(
									'background_img_size' => 'medium',
								)
							);
						?>
						</div><!-- entry-cover -->
						<?php
				}
				?>
			</div><!-- .entry-image -->
		<?php endif; ?>
	<?php endif; ?>
	<?php
}
add_action( 'kayo_before_post_content_grid_title', 'kayo_output_post_content_grid_media', 10, 2 );
add_action( 'kayo_before_post_content_masonry_title', 'kayo_output_post_content_grid_media', 10, 2 );


/**
 * Post Media
 */
function kayo_output_post_content_metro_media( $post_display_elements, $display = 'metro' ) {
	$show_category = ( in_array( 'show_category', $post_display_elements, true ) );
	?>
	<div class="entry-image">
		<div class="entry-cover">
			<?php

				/**
				 * Post thumbnail
				 */

				$metro_size = apply_filters( 'kayo_metro_thumbnail_size', 'kayo-photo' );

			if ( $featured || kayo_is_latest_post() || 'image' === get_post_format() ) {
				$metro_size = 'large';
			}

				$size = ( kayo_is_gif( get_post_thumbnail_id() ) ) ? 'full' : $metro_size;
				echo kayo_background_img( array( 'background_img_size' => $size ) );
			?>
		</div><!-- .entry-cover -->
		<div class="entry-post-metro-overlay"></div>
	</div><!-- .entry-image -->
	<?php if ( $show_category && 'metro' === $display ) : ?>
		<a class="category-label" href="<?php echo esc_url( kayo_get_first_category_url() ); ?>"><?php echo esc_attr( kayo_get_first_category() ); ?></a>
	<?php endif; ?>
	<?php
}
add_action( 'kayo_before_post_content_metro_title', 'kayo_output_post_content_metro_media', 10, 2 );

/**
 * Post Metro inner open tag
 */
function kayo_output_post_content_metro_inner_open_tag( $post_display_elements ) {
	?>
	<div class="entry-inner">
	<?php
}
add_action( 'kayo_before_post_content_metro_title', 'kayo_output_post_content_metro_inner_open_tag', 10, 1 );

/**
 * Post Date
 */
function kayo_output_post_content_grid_date( $post_display_elements, $display = 'grid' ) {
	$show_date     = ( in_array( 'show_date', $post_display_elements, true ) );
	$show_category = ( in_array( 'show_category', $post_display_elements, true ) );
	?>

	<div class="entry-summary">
		<div class="entry-summary-inner">
			<?php if ( ! is_sticky() && $show_date ) : ?>
				<span class="entry-date">
					<?php kayo_entry_date(); ?>
				</span>
				<?php
			endif;
}
add_action( 'kayo_before_post_content_grid_title', 'kayo_output_post_content_grid_date', 10, 1 );
add_action( 'kayo_before_post_content_masonry_title', 'kayo_output_post_content_grid_date', 10, 1 );
add_action( 'kayo_before_post_content_metro_title', 'kayo_output_post_content_grid_date', 10, 2 );

/**
 * Post title
 */
function kayo_output_post_grid_title( $post_display_elements ) {
	$show_thumbnail = ( in_array( 'show_thumbnail', $post_display_elements, true ) );
	?>
	<h2 class="entry-title">
		<?php if ( ! kayo_has_post_thumbnail() || ! $show_thumbnail ) : ?>
			<?php
			if ( is_sticky() && ! is_paged() ) {
				echo '<span class="sticky-post" title="' . esc_attr( __( 'Featured', 'kayo' ) ) . '"></span>';
			}
			?>
		<?php endif; ?>
		<?php the_title(); ?>
	</h2>
	<?php
}
add_action( 'kayo_post_content_grid_title', 'kayo_output_post_grid_title' );
add_action( 'kayo_post_content_masonry_title', 'kayo_output_post_grid_title' );
add_action( 'kayo_post_content_metro_title', 'kayo_output_post_grid_title' );

/**
 * Post Text
 *
 * @param array  $post_display_elements The post elements to display.
 * @param int    $post_excerpt_length The post excertp lenght.
 * @param string $display The display type (grid, masonry etc.).
 * @return void
 */
function kayo_output_post_content_grid_excerpt( $post_display_elements, $post_excerpt_length, $display = 'grid' ) {

	$show_text      = ( in_array( 'show_text', $post_display_elements, true ) );
	$show_thumbnail = ( in_array( 'show_thumbnail', $post_display_elements, true ) );
	$show_category  = ( in_array( 'show_category', $post_display_elements, true ) );

	if ( 'metro' === $display ) {
		$post_excerpt_length = 5;
	}
	?>
	<?php if ( $show_text ) : ?>
		<div class="entry-excerpt">
			<?php
				/**
				 * Dynamic post excerpt hook
				 *
				 * @since 1.0.0
				 */
				do_action( 'kayo_post_' . $display . '_excerpt', $post_excerpt_length );
			?>
		</div><!-- .entry-excerpt -->
	<?php endif; ?>
	<?php if ( $show_category && ( ! kayo_has_post_thumbnail() || ! $show_thumbnail ) ) : ?>
		<div class="entry-category-list">
			<?php echo get_the_term_list( get_the_ID(), 'category', esc_html__( 'In', 'kayo' ) . ' ', esc_html__( ', ', 'kayo' ), '' ); ?>
		</div>
	<?php endif; ?>
	<?php
}
add_action( 'kayo_after_post_content_grid_title', 'kayo_output_post_content_grid_excerpt', 10, 3 );
add_action( 'kayo_after_post_content_masonry_title', 'kayo_output_post_content_grid_excerpt', 10, 3 );
add_action( 'kayo_after_post_content_metro_title', 'kayo_output_post_content_grid_excerpt', 10, 3 );

/**
 * Post meta
 */
function kayo_output_post_content_grid_meta( $post_display_elements ) {
	$show_author     = ( in_array( 'show_author', $post_display_elements, true ) );
	$show_tags       = ( in_array( 'show_tags', $post_display_elements, true ) );
	$show_extra_meta = ( in_array( 'show_extra_meta', $post_display_elements, true ) );
	?>
	</div><!-- .entry-summary-inner -->
		<?php if ( $show_author || $show_tags || $show_extra_meta || kayo_edit_post_link( false ) ) : ?>
			<div class="entry-meta">
				<?php if ( $show_author ) : ?>
					<?php kayo_get_author_avatar(); ?>
				<?php endif; ?>
				<?php if ( $show_tags ) : ?>
					<?php kayo_entry_tags(); ?>
				<?php endif; ?>
				<?php if ( $show_extra_meta ) : ?>
					<?php kayo_get_extra_meta(); ?>
				<?php endif; ?>
				<?php kayo_edit_post_link(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
	</div><!-- .entry-summary -->
	<?php
}
add_action( 'kayo_after_post_content_grid', 'kayo_output_post_content_grid_meta', 10, 1 );
add_action( 'kayo_after_post_content_masonry', 'kayo_output_post_content_grid_meta', 10, 1 );
add_action( 'kayo_after_post_content_metro', 'kayo_output_post_content_grid_meta', 10, 1 );

/**
 * Post Metro inner close tag
 */
function kayo_output_post_content_metro_inner_close_tag( $post_display_elements ) {
	?>
	</div><!-- .entry-inner -->
	<?php
}
add_action( 'kayo_after_post_content_metro', 'kayo_output_post_content_metro_inner_close_tag', 10, 1 );

/**
 * Get block
 *
 * @param int $block The block ID.
 * @return void
 */
function kayo_get_block( $block ) {

	if ( function_exists( 'wolf_core_content_block' ) ) {

		return wolf_core_content_block( $block );

	} elseif ( function_exists( 'wccb_block' ) ) {

		return wccb_block( $block );
	}
}

/**
 * Get first audio type content from Elementor post data
 *
 * @param [type] $post_id
 * @return void
 */
function kayo_get_elementor_audio_embed_content( $post_id ) {

	$audio_widgets = array(
		'audio', // soundcloud.
		'wp-widget-media_audio',
		'playlist',
		'spotify-player',
		'soundcloud',
	);

	foreach ( $audio_widgets as $audio_widget ) {
		if ( kayo_get_elementor_post_widget_data( $audio_widget, $post_id ) ) {
			$widget      = kayo_get_elementor_post_widget_data( $audio_widget, $post_id );
			$widget_name = $widget->widgetType; //phpcs:ignore
			$settings    = $widget->settings;

			if ( 'wp-widget-media_audio' === $widget_name ) {

				if ( ! empty( $settings->wp->mp3 ) ) {

					return do_shortcode( '[audio mp3="' . esc_url( $settings->wp->mp3 ) . '"]' );
				}
			} elseif ( 'playlist' === $widget_name && function_exists( 'wolf_core_playlist' ) ) {

				return wolf_core_playlist(
					array(
						'playlist_id' => $settings->playlist_id,
					)
				);

			} elseif ( 'spotify-player' === $widget_name && function_exists( 'wolf_core_spotify_player' ) ) {

				$type = isset( $settings->type ) ? $settings->type : 'large';

				return wolf_core_spotify_player(
					array(
						'url'   => $settings->url,
						'type'  => $type,
						'width' => 750,
					)
				);

			} elseif ( 'audio' === $widget_name ) { // soundcloud
			}
		}
	}
}
