<?php
/**
 * Kayo AJAX Functions
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get login form
 */
function kayo_ajax_get_wc_login_form() {

	if ( function_exists( 'wolf_core_login_form' ) ) {
		echo wolf_core_login_form();
	} elseif ( function_exists( 'wvc_login_form' ) ) {
		echo wvc_login_form();
	} else {
		echo kayo_login_form();
	}
	exit;
}
add_action( 'wp_ajax_kayo_ajax_get_wc_login_form', 'kayo_ajax_get_wc_login_form' );
add_action( 'wp_ajax_nopriv_kayo_ajax_get_wc_login_form', 'kayo_ajax_get_wc_login_form' );

/**
 * Get next page link for load more pagination
 *
 * Use a good ol' regex to get the next page link from current URL
 */
function kayo_ajax_get_next_page_link() {

	extract( $_POST );

	if ( isset( $_POST['href'] ) ) {

		$response = array();
		$href     = esc_url( $_POST['href'] );
		$regex    = ( get_option( 'permalink_structure' ) ) ? '/page\/([0-9+])/' : '/paged=([0-9+])/';

		if ( preg_match( $regex, $href, $match ) ) {

			if ( isset( $match[1] ) ) {

				$response['href']        = str_replace( $match[1], ( absint( $match[1] ) + 1 ), $href );
				$response['currentPage'] = absint( $match[1] ) + 1;
				$response['nextPage']    = absint( $match[1] ) + 2;

				echo wp_json_encode( $response );
			}
		}
	}
	exit;

}
add_action( 'wp_ajax_kayo_ajax_get_next_page_link', 'kayo_ajax_get_next_page_link' );
add_action( 'wp_ajax_nopriv_kayo_ajax_get_next_page_link', 'kayo_ajax_get_next_page_link' );

/**
 * Get loop content for AJAX category filter
 */
function kayo_ajax_get_post_index_content() {

	extract( $_POST );

	if ( isset( $_POST['params'] ) ) {
		$nonce           = wp_create_nonce( 'post_index_content' );
		$paged           = ( isset( $_POST['params'] ) ) ? absint( $_POST['paged'] ) : 1;
		$params          = array_map( 'esc_attr', $_POST['params'] ); // JSON params
		$params['paged'] = absint( $paged );
		$params['nonce'] = $nonce;
		kayo_output_posts( $params );
	}
	exit;

}
add_action( 'wp_ajax_kayo_ajax_get_post_index_content', 'kayo_ajax_get_post_index_content' );
add_action( 'wp_ajax_nopriv_kayo_ajax_get_post_index_content', 'kayo_ajax_get_post_index_content' );

/**
 * Get page markup by URL for AJAX navigation
 */
function kayo_ajax_get_page_markup() {

	extract( $_POST );

	if ( isset( $_POST['url'] ) ) {
		$url     = esc_url( $_POST['url'] );
		$url     = str_replace( '&#038;', '&', $url ); // decode URL parameters.
		$cookies = array();

		/*
		Cookie comes empty in wp_remote_get response if we do nothing
		Pass cookies in case we need them
		*/
		foreach ( $_COOKIE as $name => $value ) {
			$cookies[] = new WP_Http_Cookie(
				array(
					'name'  => $name,
					'value' => $value,
				)
			);
		}
		$response = wp_remote_get(
			$url,
			array(
				'timeout' => 10,
				'cookies' => $cookies,
			)
		);
		if ( ! is_wp_error( $response ) && is_array( $response ) ) {
			$html = wp_remote_retrieve_body( $response ); // use the content.
			ob_start();
			print( $html ); // output page HTML content.
			header( 'Content-Length: ' . ob_get_length() ); // set lenght for progress bar.
			header( 'Accept-Ranges: bytes' );
		} else {
			echo 'error';
		}
	}
	exit;
}
add_action( 'wp_ajax_kayo_ajax_get_page_markup', 'kayo_ajax_get_page_markup' );
add_action( 'wp_ajax_nopriv_kayo_ajax_get_page_markup', 'kayo_ajax_get_page_markup' );

/**
 * Get Video URL for AJAX request
 */
function kayo_ajax_get_video_url_from_post_id() {

	extract( $_POST );

	if ( isset( $_POST['id'] ) ) {
		$post_id = absint( $_POST['id'] );
		echo esc_url( kayo_get_first_video_url( $post_id ) );
	}

	exit;

}
add_action( 'wp_ajax_kayo_ajax_get_video_url_from_post_id', 'kayo_ajax_get_video_url_from_post_id' );
add_action( 'wp_ajax_nopriv_kayo_ajax_get_video_url_from_post_id', 'kayo_ajax_get_video_url_from_post_id' );

/**
 * AJAX search
 */
function kayo_ajax_live_search() {

	extract( $_POST );

	if ( isset( $_POST['s'] ) && '' != $_POST['s'] ) {

		$typed = esc_attr( $_POST['s'] );

		if ( 2 < strlen( $typed ) ) {

			$query = kayo_ajax_search_query( $typed, true );

			if ( $query && $query->have_posts() ) {

				while ( $query->have_posts() ) {

					$query->the_post();

					$title = str_ireplace( $typed, '<strong>' . $typed . '</strong>', get_the_title() );
					$title = get_the_title();

					$terms = explode( ' ', $typed );

					$words        = array();
					$strong_words = array();

					foreach ( $terms as $t ) {
						$words[] = ucfirst( $t );
						$words[] = $t;
					}

					foreach ( $words as $w ) {
						$strong_words[] = "<strong>$w</strong>";
					}

					$words = array_diff( $words, array( 'strong', 's', 'st', 'str', 'stron' ) );

					$title = get_the_title();
					$title = str_replace( $words, $strong_words, $title );
					?>
					<li>
						<a href="<?php the_permalink(); ?>" class="ajax-link post-search-link">
							<div class="post-search-title">
								<?php
								echo wp_kses(
									$title,
									array(
										'strong' => array(),
									)
								);
								?>
							</div>
						</a>
					</li>
					<?php
				} // endwhile
			} // endif
		}
	}
	exit;
}
add_action( 'wp_ajax_kayo_ajax_live_search', 'kayo_ajax_live_search' );
add_action( 'wp_ajax_nopriv_kayo_ajax_live_search', 'kayo_ajax_live_search' );

/**
 * WooCommerce AJAX search
 */
function kayo_ajax_woocommerce_live_search() {

	extract( $_POST );

	if ( isset( $_POST['s'] ) && '' != $_POST['s'] ) {

		$typed = esc_attr( $_POST['s'] );

		if ( 2 < strlen( $typed ) ) {

			$query = kayo_woocommerce_ajax_search_query( $typed, true );

			if ( $query && $query->have_posts() ) {

				while ( $query->have_posts() ) {

					$query->the_post();
					$product = wc_get_product( get_the_ID() );
					if ( $product && $product->exists() ) {

						$title = str_ireplace( $typed, '<strong>' . $typed . '</strong>', get_the_title() );
						$title = get_the_title();

						$terms = explode( ' ', $typed );

						$words        = array();
						$strong_words = array();

						foreach ( $terms as $t ) {
							$words[] = ucfirst( $t );
							$words[] = $t;
						}

						foreach ( $words as $w ) {
							$strong_words[] = "<strong>$w</strong>";
						}

						$words = array_diff( $words, array( 'strong', 's', 'st', 'str', 'stron' ) );

						$title = get_the_title();
						$title = str_replace( $words, $strong_words, $title );
						?>
						<li>
							<a href="<?php the_permalink(); ?>" class="ajax-link product-search-link">
								<div class="product-search-image">
									<?php echo wp_kses_post( $product->get_image() ); ?>
								</div>
								<div class="product-search-title">
									<?php
									echo wp_kses(
										$title,
										array(
											'strong' => array(),
										)
									);
									?>
								</div>
								<div class="product-search-price">
									<?php
									if ( is_a( $product, 'WC_Product_Bundle' ) ) {
										if ( $product->min_price != $product->max_price ) {
											printf( '%s - %s', wc_price( $product->min_price ), wc_price( $product->max_price ) );
										} else {
											echo wp_striptags( wc_price( $product->min_price ) ); // WCS XSS ok.
										}
									} elseif ( $product->price != '0' ) {
										echo wp_kses_post( $product->get_price_html() );
									}
									?>
								</div>
							</a>
						</li>
						<?php
					}
				} // endwhile
			} // endif
		}
	}
	exit;
}
add_action( 'wp_ajax_kayo_ajax_woocommerce_live_search', 'kayo_ajax_woocommerce_live_search' );
add_action( 'wp_ajax_nopriv_kayo_ajax_woocommerce_live_search', 'kayo_ajax_woocommerce_live_search' );

/**
 * Delete customizer init function to force customizer to reset to default theme options
 */
function kayo_ajax_customizer_reset() {

	if ( ! is_customize_preview() ) {
		wp_send_json_error( 'not_preview' );
		echo 'preview error';
	}

	if ( ! check_ajax_referer( 'kayo-customizer-reset', 'nonce', false ) ) {
		wp_send_json_error( 'invalid_nonce' );
		echo 'nonce';
	}

	$theme_slug = ( is_child_theme() ) ? kayo_get_theme_slug() . '_child' : kayo_get_theme_slug();

	if ( delete_option( $theme_slug . '_customizer_init' ) ) {
		echo 'OK';
	}
	exit;
}
add_action( 'wp_ajax_kayo_ajax_customizer_reset', 'kayo_ajax_customizer_reset' );

/**
 * Get URL of an attachment post by ID
 */
function kayo_ajax_get_url_from_attachment_id() {

	extract( $_POST );

	if ( isset( $_POST['attachmentId'] ) ) {
		$attachment_id = absint( $_POST['attachmentId'] );
		$size          = ( isset( $_POST['size'] ) ) ? sanitize_text_field( $_POST['size'] ) : 'medium';
		if ( kayo_get_url_from_attachment_id( $attachment_id, $size ) ) {
			echo kayo_get_url_from_attachment_id( $attachment_id, $size );
		}
	}
	exit;
}
add_action( 'wp_ajax_kayo_ajax_get_url_from_attachment_id', 'kayo_ajax_get_url_from_attachment_id' );
