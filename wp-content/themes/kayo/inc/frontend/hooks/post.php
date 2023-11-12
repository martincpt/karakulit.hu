<?php
/**
 * Kayo post hook functions
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'kayo_single_header_post_meta' ) ) {
	/**
	 * Header post meta
	 */
	function kayo_single_header_post_meta() {

		global $post, $wp_query;
		$post_id    = get_the_ID();
		$output     = '';
		$desc       = '';
		$subheading = kayo_get_the_subheading();
		if ( kayo_is_home_as_blog() ) {
			$desc = '';
		}

		/* Search result count */
		if ( is_search() ) {

			global $wp_query;

			if ( $wp_query && is_object( $wp_query ) && isset( $wp_query->found_posts ) ) {
				$subheading = sprintf(
				/* translators: 1: number of comments, 2: post title */
					_n(
						'%d result',
						'%d results',
						'kayo'
					),
					$wp_query->found_posts
				);
			}
		}
		if ( is_tax() ) {

			$queried_object = get_queried_object();

			if ( is_object( $queried_object ) && isset( $queried_object->name ) ) {
				$desc = get_queried_object()->description;
			}
		}

		if ( is_category() ) {
			$cat_id = get_the_category();
			$desc   = category_description( $cat_id[0] );
		}

		if ( $desc ) {
			$output .= '<div class="description">' . sanitize_text_field(
				/**
				 * The category description
				 *
				 * @since 1.0.0
				 */
				apply_filters( 'kayo_post_description', $desc )
			) . '</div><!--.description-->';
		}

		if ( $subheading ) {
			$output .= '<div class="subheading">' . apply_filters(
				/**
				 * The subheading
				 *
				 * @since 1.0.0
				 */
				'kayo_post_subheading',
				$subheading
			) . '</div>';
		}

		if ( is_singular( 'post' ) ) {

			if ( 'human_diff' === kayo_get_theme_mod( 'date_format' ) ) {
				/* translators: %s: the date */
				$output .= sprintf( esc_html__( 'Posted %s', 'kayo' ), kayo_entry_date( false ) );
			} else {
				/* translators: %s: the date */
				$output .= sprintf( esc_html__( 'Posted On %s', 'kayo' ), kayo_entry_date( false ) );
			}

			if ( kayo_get_first_category() ) {
				$output .= '<span class="post-meta-separator"></span>';

				$output .= sprintf(
					/* translators: 1: first category URL, 2: the first category name as title attribute, 3: the first category name */
					kayo_kses( __( 'In <a href="%1$s" title="View all posts in the %2$s category">%3$s</a>', 'kayo' ) ),
					esc_url( kayo_get_first_category_url() ),
					esc_attr( kayo_get_first_category() ),
					esc_attr( kayo_get_first_category() )
				);
			}

			if (
			is_multi_author() &&
			get_the_author() ) {
				$output .= '<span class="post-meta-separator"></span>';

				$output .= '<span class="author-meta">';

				$output .= sprintf(
					'<span id="post-title-author">by <span class="author vcard">
				<a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span></span>',
					esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
					esc_attr(
						sprintf(
						/* translators: %s: the author's name */
							__( 'View all posts by %s', 'kayo' ),
							get_the_author()
						)
					),
					get_the_author()
				);
				$output .= '</span>';
			}
		} // end if post.

		elseif ( is_singular( 'work' ) ) {

			$output .= get_the_term_list( $post_id, 'work_type', esc_html__( 'In', 'kayo' ) . ' ', esc_html__( ', ', 'kayo' ), '' );

		} elseif ( is_singular( 'gallery' ) ) {

			$term_list = get_the_term_list( $post_id, 'gallery_type', esc_html__( 'In', 'kayo' ) . ' ', esc_html__( ', ', 'kayo' ), '' );

			$output .= $term_list;

			if ( $term_list ) {
				$output .= '<span class="post-meta-separator"></span>';
			}

			$output .= sprintf(
				/* translators: %s: the photo count */
				__( '<a class="scroll link" href="#content">%d Photos</a>', 'kayo' ),
				kayo_get_first_gallery_image_count()
			);

		} elseif ( is_singular( 'product' ) ) {

			$output .= get_the_term_list(
				$post_id,
				'product_cat',
				esc_html__( 'In', 'kayo' ) . ' ',
				esc_html__( ', ', 'kayo' )
			);

		}

		echo kayo_kses( $output );
	}
	add_action( 'kayo_hero_meta', 'kayo_single_header_post_meta' );
} // end function check

/**
 * Add custom post meta above and below the post content
 */
function kayo_add_custom_post_meta() {
	if ( is_singular( 'post' ) ) {
		if ( ! kayo_is_vc() || 'wvc-single-post-sidebar' === kayo_get_single_post_wvc_layout() ) {
			kayo_get_extra_meta();
		}
	}
}
add_action( 'kayo_post_content_start', 'kayo_add_custom_post_meta' );

/**
 * Add share buttons above and below the post content
 */
function kayo_add_share_buttons() {

	if ( function_exists( 'wolf_share' ) && function_exists( 'wolf_share_get_option' ) ) {

		$enabled_post_types = ( wolf_share_get_option( 'post_types' ) ) ? wolf_share_get_option( 'post_types' ) : array();
		$current_post_type  = get_post_type();

		if ( isset( $enabled_post_types[ $current_post_type ] ) ) {

			if ( is_singular( 'product' ) ) {
				echo '<hr>';
			}

			wp_enqueue_style( 'socicon' );

			wolf_share();
		}
	}
}
add_action( 'kayo_share', 'kayo_add_share_buttons' );
add_action( 'kayo_post_content_end', 'kayo_add_share_buttons', 15 );
add_action( 'kayo_work_meta', 'kayo_add_share_buttons', 15 ); // display in single work.
add_action( 'woocommerce_share', 'kayo_add_share_buttons' ); // display in single product.
add_action( 'wpm_playlist_post_end', 'kayo_add_share_buttons' ); // display in single playlist.

/**
 * Add work taxonomy above title
 *
 * @return void
 */
function kayo_add_work_taxonomy( $template_args ) {
	extract(
		wp_parse_args(
			$template_args,
			array(
				'layout'                    => '',
				'overlay_color'             => 'auto',
				'overlay_custom_color'      => '',
				'overlay_opacity'           => 88,
				'overlay_text_color'        => '',
				'overlay_text_custom_color' => '',
				'work_is_gallery'           => '',
				'custom_thumbnail_size'     => '',
			)
		)
	);

	$text_style = '';

	if ( $overlay_text_color && 'overlay' === $layout ) {
		$text_color = kayo_convert_color_class_to_hex_value( $overlay_text_color, $overlay_text_custom_color );
		if ( $text_color ) {
			$text_style .= 'color:' . kayo_sanitize_color( $text_color ) . ';';
		}
	}
	?>
	<div style="<?php echo kayo_esc_style_attr( $text_style ); ?>" class="entry-taxonomy">
		<?php echo get_the_term_list( get_the_ID(), 'work_type', '', ' <span class="work-taxonomy-separator">/</span> ', '' ); ?>
	</div><!-- .entry-taxonomy -->
	<?php
}
add_action( 'kayo_work_grid_summary_end', 'kayo_add_work_taxonomy', 10, 1 );
add_action( 'kayo_work_masonry_summary_end', 'kayo_add_work_taxonomy', 10, 1 );
add_action( 'kayo_work_metro_summary_end', 'kayo_add_work_taxonomy', 10, 1 );

/**
 * Set work entry background image
 *
 * @param array $template_args The display options.
 */
function kayo_set_work_entry_background( $template_args, $display = 'grid' ) {
	$thumbnail_size        = ( isset( $template_args['thumbnail_size'] ) ) ? $template_args['thumbnail_size'] : 'standard';
	$custom_thumbnail_size = ( isset( $template_args['custom_thumbnail_size'] ) ) ? $template_args['custom_thumbnail_size'] : null;

	if ( 'custom' === $thumbnail_size && $custom_thumbnail_size ) {
		$thumbnail_size = $custom_thumbnail_size;
	} else {
		$thumbnail_size = kayo_convert_img_size_name( $thumbnail_size );
	}

	$padding_bottom = kayo_convert_img_dimension_percent_ratio( $thumbnail_size );
	if ( 'masonry' === $display ) {
		?>
		<div class="entry-image">
			<?php
				/**
				 * Thumbnail
				 */

				the_post_thumbnail( $thumbnail_size );
			?>
		</div>
		<?php
	} elseif ( 'metro' === $display ) {
		?>
			<div class="entry-image">
				<div class="entry-cover">
					<?php
						/**
						 * Filters the metro thumbnail size
						 *
						 * Allow to modulate the image size depending on the image in the metro pattern
						 *
						 * @since 1.0.0
						 */
						$metro_size = apply_filters( 'kayo_metro_thumbnail_size', '680x680' );

					if ( $featured || kayo_is_latest_post( 'work' ) ) {
						$metro_size = 'large';
					}

						$size = ( kayo_is_gif( get_post_thumbnail_id() ) ) ? 'full' : $metro_size;

						echo kayo_background_img( array( 'background_img_size' => $size ) );
						remove_filter( 'kayo_metro_thumbnail_size', 10, 1 );
					?>
				</div><!-- entry-cover -->
			</div>
		<?php
	} else {
		echo '<div class="entry-image"><div class="entry-cover" style="padding-bottom:' . esc_attr( $padding_bottom ) . '">';
		if ( kayo_is_gif( get_post_thumbnail_id() ) ) {
			echo kayo_background_img( array( 'background_img_size' => 'full' ) );
		} else {
			kayo_resized_thumbnail( $thumbnail_size, 'img-bg' );
		}
		echo '</div></div>';
	}
}
add_action( 'kayo_work_bg', 'kayo_set_work_entry_background', 10, 2 );

/**
 * Output author box
 */
function kayo_output_author_box() {

	if ( 'yes' === kayo_get_theme_mod( 'post_author_box', 'yes' ) ) {
		if ( 'post' === get_post_type() ) {
			get_template_part( kayo_get_template_dirname() . '/components/post/author' );
		}
	}
}
add_action( 'kayo_post_content_after', 'kayo_output_author_box' );

/**
 * Output related posts
 */
function kayo_output_related_posts() {

	if ( 'yes' === kayo_get_theme_mod( 'post_related_posts', 'yes' ) ) {
		if ( 'post' === get_post_type() ) {
			get_template_part( kayo_get_template_dirname() . '/components/post/related', 'posts' );
		}
	}
}
add_action( 'kayo_post_content_after', 'kayo_output_related_posts', 20 );

/**
 * Output related posts
 */
function kayo_output_related_post_content() {
	?>
	<div class="entry-box">
		<div class="entry-container">
			<a href="<?php the_permalink(); ?>" class="entry-link">
				<?php
				the_post_thumbnail(
					/**
					 * The related posts thumbnail size filtered
					 *
					 * @since 1.0.0
					 */
					apply_filters( 'kayo_related_post_thumbnail_size', 'medium_large' ),
					array( 'class' => 'entry-bg cover' )
				);
				?>
				<div class="entry-overlay"></div>
				<div class="entry-inner">
					<div class="entry-summary">
						<?php the_title( '<h4 class="entry-title">', '</h4>' ); ?>
						<span class="entry-date">
							<?php kayo_entry_date(); ?>
						</span>
					</div><!-- .entry-summary -->
				</div><!-- .entry-inner -->
			</a>
		</div><!-- .entry-container -->
	</div><!-- .entry-box -->
	<?php
}
add_action( 'kayo_related_post_content', 'kayo_output_related_post_content' );

/**
 * Remove share buttons filter
 *
 * This is will allow more control for where we want to output the share buttons
 */
function kayo_remove_share_buttons_filter() {
	remove_filter( 'the_content', 'wolf_share_output_social_buttons' );
}
add_action( 'init', 'kayo_remove_share_buttons_filter' );

/**
 * Remove custom post meta filter
 *
 * This is will allow more control for where we want to output the share buttons
 */
function kayo_remove_custom_post_meta_filter() {
	remove_filter( 'the_content', 'wolf_output_custom_post_meta' );
}
add_action( 'init', 'kayo_remove_custom_post_meta_filter' );

/**
 * Newsletter form
 */
function kayo_add_newsletter_form() {

	if (
		function_exists( 'wvc_mailchimp' )
		&& kayo_get_theme_mod( 'newsletter_form_single_blog_post' )
		&& is_singular( 'post' )
	) {
		$list_id = wolf_vc_get_option( 'mailchimp', 'default_mailchimp_list_id' );
		?>
		<section class="newsletter-container entry-section clearfix">
			<div class="newsletter-signup">
				<?php
				echo wvc_mailchimp( // WCS XSS ok.
					array(
						'size'                => 'large',
						/**
						 * The MailChimp newsletter submit button class filtered
						 *
						 * @since 1.0.0
						 */
						'submit_button_class' => apply_filters(
							'kayo_mc_submit_button_class',
							'theme-button-outline'
						),
					)
				);
				?>
			</div><!-- .newsletter-signup -->
		</section><!-- .newsletter-container -->
		<?php
	}

	if (
		function_exists( 'wolf_core_mailchimp' )
		&& kayo_get_theme_mod( 'newsletter_form_single_blog_post' )
		&& is_singular( 'post' )
	) {
		$list_id = wolf_core_get_option( 'mailchimp', 'default_mailchimp_list_id' );
		?>
		<section class="newsletter-container entry-section clearfix">
			<div class="newsletter-signup">
				<?php
				echo wolf_core_mailchimp( // WCS XSS ok.
					array(
						'size'                => 'large',
						/**
						 * The MailChimp newsletter submit button class filtered
						 *
						 * @since 1.0.0
						 */
						'submit_button_class' => apply_filters( 'kayo_mc_submit_button_class', 'theme-button-outline' ),
					)
				);
				?>
			</div><!-- .newsletter-signup -->
		</section><!-- .newsletter-container -->
		<?php
	}
}
add_action( 'kayo_post_content_after', 'kayo_add_newsletter_form', 12 );

/**
 * Output single post pagination
 */
function kayo_output_single_post_pagination() {

	if ( is_singular( 'event' ) || is_singular( 'proof_gallery' ) || is_singular( 'attachment' ) ) {
		return; // event are ordered by custom date so it's better to hide the pagination.
	}

	/**
	 * Filters the condition to disable the single post pagination
	 *
	 * @since 1.0.0
	 */
	if ( apply_filters( 'kayo_disable_single_post_pagination', false ) ) {
		return;
	}

	global $post;
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous || ! is_single() || 'wvc_content_block' === get_post_type() ) {
		return;
	}

	$index_url = kayo_get_blog_url();
	$index_id  = kayo_get_blog_index_id();

	if ( 'work' === get_post_type() && function_exists( 'wolf_portfolio_get_page_id' ) && function_exists( 'wolf_get_portfolio_url' ) ) {
		$index_id  = wolf_portfolio_get_page_id();
		$index_url = wolf_get_portfolio_url();
	}

	if ( 'gallery' === get_post_type() && function_exists( 'wolf_albums_get_page_id' ) && function_exists( 'wolf_get_albums_url' ) ) {
		$index_id  = wolf_albums_get_page_id();
		$index_url = wolf_get_albums_url();
	}

	if ( 'video' === get_post_type() && function_exists( 'wolf_videos_get_page_id' ) && function_exists( 'wolf_get_videos_url' ) ) {
		$index_id  = wolf_videos_get_page_id();
		$index_url = wolf_get_videos_url();
	}

	if ( 'event' === get_post_type() && function_exists( 'wolf_events_get_page_id' ) && function_exists( 'wolf_get_events_url' ) ) {
		$index_id  = wolf_events_get_page_id();
		$index_url = wolf_get_events_url();
	}

	if ( 'release' === get_post_type() && function_exists( 'wolf_discography_get_page_id' ) && function_exists( 'wolf_discography_get_page_link' ) ) {
		$index_id  = wolf_discography_get_page_id();
		$index_url = wolf_discography_get_page_link();
	}

	if ( 'product' === get_post_type() && function_exists( 'kayo_get_woocommerce_shop_page_id' ) ) {
		$index_id  = kayo_get_woocommerce_shop_page_id();
		$index_url = get_permalink( kayo_get_woocommerce_shop_page_id() );
	}

	$prev_post = get_previous_post();
	$next_post = get_next_post();

	$prev_post_id = ( is_object( $prev_post ) && isset( $prev_post->ID ) ) ? $prev_post->ID : null;
	$next_post_id = ( is_object( $next_post ) && isset( $next_post->ID ) ) ? $next_post->ID : null;

	$index_post_featured_img_id = ( $index_id && get_post_thumbnail_id( $index_id ) ) ? get_post_thumbnail_id( $index_id ) : kayo_get_hero_image_id();
	$prev_post_featured_img_id  = ( $prev_post_id ) ? get_post_thumbnail_id( $prev_post_id ) : null;
	$next_post_featured_img_id  = ( $next_post_id ) ? get_post_thumbnail_id( $next_post_id ) : null;

	$index_class = 'nav-index';
	$prev_class  = 'nav-previous';
	$next_class  = 'nav-next';

	/**
	 * Filters the condition to enable the single post pagination background
	 *
	 * @since 1.0.0
	 */
	if ( apply_filters( 'kayo_enable_single_post_pagination_backgrounds', true ) ) {
		if ( $index_post_featured_img_id && kayo_background_img( array( 'background_img' => $index_post_featured_img_id ) ) ) {
			$index_class .= ' nav-has-bg';
		}

		if ( $prev_post_featured_img_id && kayo_background_img( array( 'background_img' => $prev_post_featured_img_id ) ) ) {
			$prev_class .= ' nav-has-bg';
		}

		if ( $next_post_featured_img_id && kayo_background_img( array( 'background_img' => $next_post_featured_img_id ) ) ) {
			$next_class .= ' nav-has-bg';
		}
	}
	?>
	<nav class="single-post-pagination clearfix">
		<div class="<?php echo kayo_sanitize_html_classes( $prev_class ); ?>">
			<?php
			/**
			 * Filters the condition to enable the single post pagination background
			 *
			 * @since 1.0.0
			 */
			if ( apply_filters( 'kayo_enable_single_post_pagination_backgrounds', true ) ) {
				/**
				 * BG
				 */
				echo kayo_background_img( array( 'background_img' => $prev_post_featured_img_id ) );
			}
			?>
			<?php previous_post_link( '%link', '<span class="nav-label"><i class="meta-icon single-pagination-prev" aria-hidden="true"></i> ' . esc_html__( 'Previous', 'kayo' ) . '</span><span class="meta-nav"></span> %title' ); ?>
		</div><!-- .nav-previous -->
		<div class="<?php echo kayo_sanitize_html_classes( $index_class ); ?>">
			<?php
			/**
			 * Filters the condition to enable the single post pagination background
			 *
			 * @since 1.0.0
			 */
			if ( apply_filters( 'kayo_enable_single_post_pagination_backgrounds', true ) ) {
				/**
				 * BG
				 */
				echo kayo_background_img( array( 'background_img' => $index_post_featured_img_id ) );
			}
			?>
			<a href="<?php echo esc_url( $index_url ); ?>">
				<!-- <i class="fa fa-th-large" aria-hidden="true"></i> -->
				<span class="nav-index-icon"> <?php esc_html_e( 'Main Page', 'kayo' ); ?></span>
			</a>
		</div>
		<div class="<?php echo kayo_sanitize_html_classes( $next_class ); ?>">
			<?php
			/**
			 * Filters the condition to enable the single post pagination background
			 *
			 * @since 1.0.0
			 */
			if ( apply_filters( 'kayo_enable_single_post_pagination_backgrounds', true ) ) {
				/**
				 * BG
				 */
				echo kayo_background_img( array( 'background_img' => $next_post_featured_img_id ) );
			}
			?>
			<?php next_post_link( '%link', '<span class="nav-label">' . esc_html__( 'Next', 'kayo' ) . ' <i class="meta-icon single-pagination-next" aria-hidden="true"></i></span> %title <span class="meta-nav"></span>' ); ?>
		</div><!-- .nav-next -->
	</nav><!-- .single-post-pagination -->
	<?php
}
add_action( 'kayo_before_footer_block', 'kayo_output_single_post_pagination', 14 );

/**
 * Output categories & tags below single post content
 */
function kayo_ouput_single_post_taxonomy() {

	if ( 'post' !== get_post_type() ) {
		return;
	}

	echo '<div class="single-post-taxonomy-container clearfix">';
		echo '<span class="single-post-taxonomy categories single-post-categories">';
			the_category( ' ' );
		echo '</span>';
		the_tags( '<span class="single-post-taxonomy tagcloud single-post-tagcloud">', '', '</span>' );
	echo '</div><!-- .single-post-taxonomy -->';
}
add_action( 'kayo_post_content_end', 'kayo_ouput_single_post_taxonomy' );

/**
 * Output modern grid slideshow arrows
 */
function kayo_output_post_grid_slideshow_arrows() {
	?>
	<div class="slideshow-gallery-direction-nav">
		<a href="#" class="slideshow-gallery-direction-nav-prev">
			<span class="slideshow-gallery-direction-nav-prev-icon"></span>
		</a>
		<a href="#" class="slideshow-gallery-direction-nav-next">
			<span class="slideshow-gallery-direction-nav-next-icon"></span>
		</a>
	</div>
	<?php
}
add_action( 'kayo_post_grid_slideshow_arrows', 'kayo_output_post_grid_slideshow_arrows' );

/**
 * Add custom post meta above and below the post content
 */
function kayo_add_vc_post_custom_post_meta() {
	if ( is_singular( 'post' ) ) {
		if ( 'wvc-single-post-fullwidth' === kayo_get_single_post_wvc_layout() ) {
			kayo_get_extra_meta();
		}
	}
}
add_action( 'kayo_post_content_end', 'kayo_add_vc_post_custom_post_meta' );

/**
 * Output single post bottom separator
 */
function kayo_ouput_single_post_end_separator() {

	echo '<hr class="single-post-bottom-line">';
}
add_action( 'kayo_post_content_end', 'kayo_ouput_single_post_end_separator', 100 );

/**
 * Output work single post meta
 */
function kayo_ouput_work_meta() {
	/**
	 * Work meta
	 */
	if ( function_exists( 'kayo_work_meta' ) ) {
		kayo_work_meta();
	}
}
add_action( 'kayo_work_meta', 'kayo_ouput_work_meta' );

/**
 * Output release single post meta
 */
function kayo_ouput_release_meta() {
	/**
	 * Release meta
	 */
	if ( function_exists( 'kayo_release_meta' ) ) {
		kayo_release_meta();
	}
}
add_action( 'kayo_release_meta', 'kayo_ouput_release_meta' );

/**
 * Output artist single post meta
 */
function kayo_ouput_artist_meta() {

	if ( function_exists( 'kayo_artist_meta' ) ) {
		kayo_artist_meta();
	}
}
add_action( 'kayo_artist_meta', 'kayo_ouput_artist_meta' );

/**
 * Output artist single post content
 */
function kayo_ouput_artist_content() {

	if ( function_exists( 'kayo_artist_content' ) ) {
		kayo_artist_content();
	}
}
add_action( 'kayo_artist_content', 'kayo_ouput_artist_content' );

/**
 * Output post grid summary
 */
function kayo_output_post_grid_summary() {

	$format = get_post_format();

	if ( kayo_is_short_post_format() || 'audio' === $format ) {
		?>
		<div class="entry-image">
			<div class="entry-cover">
				<?php
					echo kayo_background_img(
						array(
							'background_img_size'  => 'large',
							'placeholder_fallback' => true,
						)
					);
				?>
			</div><!-- entry-cover -->
		</div>
		<?php
	}

	if ( 'image' === $format && kayo_is_instagram_post() ) {

		echo kayo_get_instagram_image(); // phpcs:ignore

		if ( kayo_get_author_instagram_username() ) {
			echo '<span class="insta-username">' . kayo_get_author_instagram_username() . '</span>'; // phpcs:ignore
		}
	} elseif ( 'gallery' === $format && kayo_background_slideshow() ) {

		echo kayo_background_slideshow(
			array(
				'slideshow_image_size' => '1200x1024',
				'slideshow_img_count'  => 3,
			)
		);

		/**
		 * Post grid slideshow arrow navigation hook
		 *
		 * @since 1.0.0
		 */
		do_action( 'kayo_post_grid_slideshow_arrows' );

		kayo_post_grid_entry_title();

	} elseif ( 'video' === $format ) {

		if ( kayo_background_video() ) { // if we can get a video background
			echo kayo_background_video();
		}
		kayo_post_grid_entry_title();

	} elseif ( 'audio' === $format && kayo_featured_media() ) {

		kayo_post_grid_entry_title();

	} elseif ( 'aside' === $format || 'status' === $format ) {

		kayo_post_grid_entry_title( kayo_sample( get_the_content(), 30 ) );

	} elseif ( 'quote' === $format ) {

		kayo_post_grid_entry_title( kayo_get_first_quote() );

	} elseif ( 'link' === $format ) {

		kayo_post_grid_entry_title();

	} else { // most likely standard format.
		?>
	<div class="entry-image">
		<div class="entry-cover">
			<?php
				echo kayo_background_img(
					array(
						'background_img_size'  => 'large',
						'placeholder_fallback' => true,
					)
				);
			?>
		</div><!-- entry-cover -->
	</div>
		<?php kayo_post_grid_entry_title(); ?>
		<?php
	}
}
add_action( 'kayo_post_grid_summary', 'kayo_output_post_grid_summary' );

/**
 * Post Grid classic excerpt
 */
function kayo_output_post_grid_classic_excerpt( $post_excerpt_type ) {

	if ( 'full' === $post_excerpt_type ) :
		?>
		<p><?php echo kayo_sample( get_the_excerpt(), 1000 ); ?></p>
	<?php else : ?>
		<p><?php echo kayo_sample( get_the_excerpt(), kayo_get_excerpt_lenght() ); ?></p>
		<?php
	endif;
}
add_action( 'kayo_post_grid_classic_excerpt', 'kayo_output_post_grid_classic_excerpt', 10, 1 );
add_action( 'kayo_post_grid_excerpt', 'kayo_output_post_grid_classic_excerpt', 10, 1 );

/**
 * Post Grid classic excerpt
 */
function kayo_output_post_masonry_excerpt( $post_excerpt_length ) {

	if ( 'full' === $post_excerpt_length ) :
		?>
		<p><?php echo kayo_sample( get_the_excerpt(), 1000 ); ?></p>
	<?php elseif ( is_numeric( $post_excerpt_length ) ) : ?>
		<p><?php echo kayo_sample( get_the_excerpt(), absint( $post_excerpt_length ) ); ?></p>
	<?php else : ?>
		<p><?php echo kayo_sample( get_the_excerpt(), kayo_get_excerpt_lenght() ); ?></p>
		<?php
	endif;
}
add_action( 'kayo_post_masonry_excerpt', 'kayo_output_post_masonry_excerpt', 10, 1 );
add_action( 'kayo_post_metro_excerpt', 'kayo_output_post_masonry_excerpt', 10, 1 );
add_action( 'kayo_post_search_excerpt', 'kayo_output_post_masonry_excerpt', 10, 1 );

/**
 * Output the excerpt
 *
 * @param string $post_excerpt_type
 */
function kayo_output_the_excerpt( $post_excerpt_type ) {

	/* Case page builder is used */
	if ( preg_match( '#vc_row#', get_the_content() ) || kayo_is_elementor_page() ) {

		$content = ( get_the_excerpt() ) ? get_the_excerpt() : get_the_content();
		echo '<p>' . kayo_sample( $content, 100 ) . '...</p>';

		if ( $content ) {
			echo '<p>' . kayo_more_button() . '</p>'; // phpcs:ignore
		}
	} else {

		if ( 'auto' === $post_excerpt_type ) {

			echo '<p>';
			echo kayo_kses( get_the_excerpt() );
			echo '</p>';

		} else {
			echo kayo_content( kayo_more_text() ); // phpcs:ignore
		}
	}
}
add_action( 'kayo_the_excerpt', 'kayo_output_the_excerpt', 10, 1 );
