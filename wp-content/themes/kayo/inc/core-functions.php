<?php
/**
 * Core functions
 *
 * General core functions available on admin and frontend
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Gets the ID of the post, even if it's not inside the loop.
 *
 * @uses WP_Query
 * @uses get_queried_object()
 * @extends get_the_ID()
 * @see get_the_ID()
 *
 * @return int
 */
function kayo_get_the_id() {

	global $wp_query;

	$post_id = null;
	if ( is_object( $wp_query ) && isset( $wp_query->queried_object ) && isset( $wp_query->queried_object->ID ) ) {
		$post_id = $wp_query->queried_object->ID;
	} else {
		$post_id = get_the_ID();
	}

	return $post_id;
}

/**
 * Check if and which page builder plugin is used
 *
 * @return string plugin slug
 */
function kayo_get_plugin_in_use() {

	if ( did_action( 'elementor/loaded' ) ) {

		return 'elementor';

	} elseif ( defined( 'WPB_VC_VERSION' ) ) {

		return 'vc';
	}
}

/**
 * Get the content of a file using wp_remote_get
 *
 * @param string $file path from theme folder.
 */
function kayo_file_get_contents( $file ) {

	if ( is_file( $file ) ) {

		$file_uri = kayo_get_theme_uri( $file );

		$response = wp_remote_get( $file_uri );

		if ( is_array( $response ) ) {
			return wp_remote_retrieve_body( $response );
		}
	}
}

/**
 * Check if Wolf WPBakery Page Builder Extension is activated
 *
 * @return bool
 */
function kayo_is_wolf_extension_activated() {
	if ( class_exists( 'Wolf_Visual_Composer' ) && defined( 'WPB_VC_VERSION' ) && defined( 'WVC_OK' ) && WVC_OK ) {
		return true;
	} elseif ( class_exists( 'Wolf_Core' ) && defined( 'WOLF_CORE_VERSION' ) && defined( 'WOLF_CORE_OK' ) && WOLF_CORE_OK ) {
		return true;
	}
}

/**
 * Check if WooCommerce is activated
 *
 * @return bool
 */
function kayo_is_wc_activated() {
	if ( class_exists( 'WooCommerce' ) ) {
		return true;
	}
}

/**
 * Get default post types to use with VC
 */
function kayo_get_available_post_types() {
	return array(
		'post',
		'page',
		'work',
		'product',
		'release',
		'gallery',
		'event',
		'video',
		'wvc_content_block',
		'wolf_content_block',
	);
}

/**
 * Get all available animations
 *
 * @return array
 */
function kayo_get_animations() {

	/**
	 * Filters theme post item animations
	 *
	 * @since Kayo 1.0.0
	 */
	return apply_filters(
		'kayo_item_animations',
		array(
			'none'            => esc_html__( 'None', 'kayo' ),
			'fade'            => esc_html__( 'Fade', 'kayo' ),
			'fade-up'         => esc_html__( 'Fade Up', 'kayo' ),
			'fade-down'       => esc_html__( 'Fade Down', 'kayo' ),
			'fade-left'       => esc_html__( 'Fade Left', 'kayo' ),
			'fade-right'      => esc_html__( 'Fade Right', 'kayo' ),
			'fade-up-right'   => esc_html__( 'Fade Up Right', 'kayo' ),
			'fade-up-left'    => esc_html__( 'Fade Up Left', 'kayo' ),
			'fade-down-right' => esc_html__( 'Fade Down Right', 'kayo' ),
			'fade-down-left'  => esc_html__( 'Fade Down Left', 'kayo' ),

			'flip-up'         => esc_html__( 'Flip Up', 'kayo' ),
			'flip-down'       => esc_html__( 'Flip Down', 'kayo' ),
			'flip-left'       => esc_html__( 'Flip Left', 'kayo' ),
			'flip-right'      => esc_html__( 'Flip Right', 'kayo' ),

			'slide-up'        => esc_html__( 'Slide Up', 'kayo' ),
			'slide-down'      => esc_html__( 'Slide Down', 'kayo' ),
			'slide-left'      => esc_html__( 'Slide Left', 'kayo' ),
			'slide-right'     => esc_html__( 'Slide Right', 'kayo' ),

			'zoom-in'         => esc_html__( 'Zoom In', 'kayo' ),
			'zoom-in-up'      => esc_html__( 'Zoom In Up', 'kayo' ),
			'zoom-in-down'    => esc_html__( 'Zoom In Down', 'kayo' ),
			'zoom-in-left'    => esc_html__( 'Zoom In Left', 'kayo' ),
			'zoom-in-right'   => esc_html__( 'Zoom In Right', 'kayo' ),
			'zoom-out'        => esc_html__( 'Zoom Out', 'kayo' ),
			'zoom-out-up'     => esc_html__( 'Zoom Out Up', 'kayo' ),
			'zoom-out-down'   => esc_html__( 'Zoom Out Down', 'kayo' ),
			'zoom-out-left'   => esc_html__( 'Zoom Out Left', 'kayo' ),
			'zoom-out-right'  => esc_html__( 'Zoom Out Right', 'kayo' ),
		)
	);
}

/**
 * Minimium requirements variables
 *
 * @return array
 */
function kayo_get_minimum_required_server_vars() {

	$variables = array(
		'REQUIRED_PHP_VERSION'         => '7.4.0',
		'REQUIRED_WP_VERSION'          => '5.7',
		'REQUIRED_WP_MEMORY_LIMIT'     => '256M',
		'REQUIRED_SERVER_MEMORY_LIMIT' => '256M',
		'REQUIRED_MAX_INPUT_VARS'      => 3000,
		'REQUIRED_MAX_EXECUTION_TIME'  => 300,
		'REQUIRED_UPLOAD_MAX_FILESIZE' => '256M',
		'REQUIRED_POST_MAX_SIZE'       => '256M',
	);

	return $variables;
}

/**
 * Get theme root
 */
function kayo_get_theme_dirname() {
	return basename( dirname( dirname( __FILE__ ) ) );
}

/**
 * Get theme name
 *
 * @return string
 */
function kayo_get_theme_name() {
	$theme = wp_get_theme();
	return $theme->get( 'Name' );
}

/**
 * Get parent theme name
 *
 * @return string
 */
function kayo_get_parent_theme_name() {
	$theme = wp_get_theme( kayo_get_theme_dirname() );
	return $theme->get( 'Name' );
}

/**
 * Get theme version
 *
 * @return string
 */
function kayo_get_theme_version() {
	$theme = wp_get_theme();
	return $theme->get( 'Version' );
}

/**
 * Get parent theme version
 *
 * @return string
 */
function kayo_get_parent_theme_version() {
	$theme = wp_get_theme( kayo_get_theme_dirname() );
	return $theme->get( 'Version' );
}

/**
 * Get the theme slug
 *
 * @return string
 */
function kayo_get_theme_slug() {

	/**
	 * Filters theme slug
	 *
	 * @since Kayo 1.0.0
	 */
	return apply_filters( 'kayo_theme_slug', esc_attr( sanitize_title_with_dashes( get_template() ) ) );
}

/**
 * Get styling option
 *
 * First check if the option is set in post options (metabox) else return theme mod
 * Option key must have the same slug ( e.g '_post_my_option' for metabox and 'my_option' for theme mod )
 *
 * @param  string $key the mod key.
 * @param  string $default the default value.
 * @param  int    $post_id the post ID.
 * @return string
 */
function kayo_get_inherit_mod( $key, $default = '', $post_id = null ) {
	$option = kayo_get_theme_mod( $key, $default );

	$post_id = ( $post_id ) ? $post_id : kayo_get_inherit_post_id();
	if ( get_post_meta( $post_id, '_post_' . $key, true ) ) {
		$option = get_post_meta( $post_id, '_post_' . $key, true );
	}

	/**
	 * Filters theme mod value
	 *
	 * @since Kayo 1.0.0
	 */
	return apply_filters( 'kayo_' . $key, $option );
}

if ( ! function_exists( 'kayo_get_theme_mod' ) ) {
	/**
	 * Get theme mod
	 *
	 * @param  string $key the mod key.
	 * @param  string $default the default value.
	 * @return string
	 */
	function kayo_get_theme_mod( $key, $default = '' ) {

		if ( isset( $_GET[ $key ] ) && preg_match( '#^[a-zA-Z0-9-_\/]+$#', sanitize_title( $_GET[ $key ] ) ) ) {

			return sanitize_title( $_GET[ $key ] );
		} elseif ( $default && '' === get_theme_mod( $key, $default ) ) {

			return $default;

		} else {

			/**
			 * Filters theme mod value
			 *
			 * @since Kayo 1.0.0
			 */
			return apply_filters( 'kayo_mod_' . $key, get_theme_mod( $key, $default ) );
		}
	}
}

/**
 * Get theme option
 *
 * @param  string $index the option index.
 * @param  string $key the option key.
 * @param  string $default the option default value.
 * @return string
 */
function kayo_get_option( $index, $key, $default = null ) {
	$theme_slug  = kayo_get_theme_slug();
	$option_name = $theme_slug . '_' . $index . '_settings';
	$settings    = get_option( $option_name );

	if ( isset( $settings[ $key ] ) ) {

		return $settings[ $key ];

	} elseif ( $default ) {

		return $default;
	}
}

/**
 * Inject/update an option in the theme options array
 *
 * @param  string $index the option index.
 * @param  string $key the option key.
 * @param  string $value The option default value.
 */
function kayo_update_option( $index, $key, $value ) {

	$theme_slug            = kayo_get_theme_slug();
	$option_name           = $theme_slug . '_' . $index . '_settings';
	$theme_options         = ( get_option( $option_name ) ) ? get_option( $option_name ) : array();
	$theme_options[ $key ] = $value;
	update_option( $option_name, $theme_options );
}

/**
 * Check if a file exists before including it
 *
 * Check if the file exists in the child theme with kayo_locate_file or else check if the file exists in the parent theme
 *
 * @param string $file the file to include.
 */
function kayo_include( $file ) {
	if ( kayo_locate_file( $file ) ) {
		return include kayo_locate_file( $file );
	}
}

/**
 * Get config dir
 */
function kayo_get_config_dir() {

	$config_dir = 'config/';
	$theme_slug = kayo_get_theme_slug();

	if ( is_dir( get_parent_theme_file_path( 'THEMES/' . $theme_slug . '/config' ) ) ) {
		$config_dir = 'THEMES/' . $theme_slug . '/config/';
	}

	return $config_dir;
}

/**
 * Check if a file exists before including it
 *
 * Check if the file exists in the child theme with kayo_locate_file or else check if the file exists in the parent theme
 *
 * @param string $file the file to include from the config folder.
 */
function kayo_include_config( $file ) {

	return kayo_include( kayo_get_config_dir() . $file );
}

/**
 * Locate a file and return the path for inclusion.
 *
 * Used to check if the file exists, is in a parent or child theme folder
 *
 * @param  string $filename the file to locate.
 * @return string
 */
function kayo_locate_file( $filename ) {

	$file = null;

	if ( is_file( get_stylesheet_directory() . '/' . untrailingslashit( $filename ) ) ) {

		$file = get_stylesheet_directory() . '/' . untrailingslashit( $filename );

	} elseif ( is_file( get_template_directory() . '/' . untrailingslashit( $filename ) ) ) {

		$file = get_template_directory() . '/' . untrailingslashit( $filename );
	}

	/**
	 * Filters file path
	 *
	 * @since Kayo 1.0.0
	 */
	return apply_filters( 'kayo_locate_file', $file );
}

/**
 * Check if a file exists in a child theme
 * else returns the URL of the parent theme file
 * Mainly uses for images
 *
 * @param  string $file the file to add to the theme URI.
 * @return string
 */
function kayo_get_theme_uri( $file = null ) {

	$file     = untrailingslashit( $file );
	$file_url = null;

	$file = str_replace( get_template_directory(), '', $file );

	if ( is_child_theme() && is_file( get_stylesheet_directory() . $file ) ) {

		$file_url = esc_url( get_stylesheet_directory_uri() . $file );

	} elseif ( is_file( get_template_directory() . $file ) ) {

		$file_url = esc_url( get_template_directory_uri() . $file );
	}

	return $file_url;
}

/**
 * Check if a string is an external URL to prevent hot linking when importing default mods on theme activation
 *
 * @param  string $string the URL to check.
 * @return bool
 */
function kayo_is_external_url( $string ) {

	if ( filter_var( $string, FILTER_VALIDATE_URL ) && wp_parse_url( site_url(), PHP_URL_HOST ) != wp_parse_url( $string, PHP_URL_HOST ) ) {
		return wp_parse_url( $string, PHP_URL_HOST );
	}
}

/**
 * Get the URL of an attachment from its id
 *
 * @param  int    $id the attachemnt ID.
 * @param  string $size the thumbnail size.
 * @return string $url
 */
function kayo_get_url_from_attachment_id( $id, $size = 'thumbnail' ) {

	$src = wp_get_attachment_image_src( $id, $size );
	if ( isset( $src[0] ) ) {
		return esc_url( $src[0] );
	}
}

/**
 * Remove spaces in inline CSS
 *
 * @param  string $css the CSS to format.
 * @param  bool   $hard whether to compact the string or not. Remo either double spaces or all spaces.
 * @return string
 */
function kayo_compact_css( $css, $hard = true ) {
	return preg_replace( '/\s+/', ' ', $css );
}

/**
 * Clean a list
 *
 * Remove first and last comma of a list and remove spaces before and after separator
 *
 * @param  string $list The list to clean up.
 * @param  string $separator The item delimiter.
 * @return string $list
 */
function kayo_clean_list( $list, $separator = ',' ) {
	$list = str_replace( array( $separator . ' ', ' ' . $separator ), $separator, $list );
	$list = ltrim( $list, $separator );
	$list = rtrim( $list, $separator );
	return $list;
}

/**
 * Helper method to determine if an attribute is true or false.
 *
 * @param string|int|bool $var Attribute value.
 * @return bool
 */
function kayo_attr_bool( $var ) {
	$falsey = array( 'false', '0', 'no', 'n', '', ' ' );
	return ( ! $var || in_array( strtolower( $var ), $falsey, true ) ) ? false : true;
}

/**
 * Remove all double spaces
 *
 * This function is mainly used to clean up inline CSS
 *
 * @param string $string The string to clean up.
 * @param bool   $hard Clean up all spaces or just double spaces. Not used ATM.
 * @return string
 */
function kayo_clean_spaces( $string, $hard = true ) {
	return preg_replace( '/\s+/', ' ', $string );
}

/**
 * Convert list of IDs to array
 *
 * @param string $list The list to convert to an array.
 * @param  string $separator The item delimiter.
 * @return array
 */
function kayo_list_to_array( $list, $separator = ',' ) {
	return ( $list ) ? explode( ',', trim( kayo_clean_spaces( kayo_clean_list( $list ) ) ) ) : array();
}

/**
 * Convert array of ids to list
 *
 * @param string $array The array to convert to a list.
 * @return array
 */
function kayo_array_to_list( $array, $separator = ',' ) {
	$list = '';

	if ( is_array( $array ) ) {
		$list = rtrim( implode( $separator, $array ), $separator );
	}

	return kayo_clean_list( $list );
}

/**
 * Check if a file exists in a child theme
 * else returns the path of the parent theme file
 * Mainly uses for config files
 *
 * @param string $file The file to check.
 * @return string
 */
function wolf_get_theme_dir( $file = null ) {

	$file = untrailingslashit( $file );

	if ( is_file( get_stylesheet_directory() . '/' . $file ) ) {

		return get_stylesheet_directory() . '/' . $file;

	} elseif ( is_file( get_template_directory() . '/' . $file ) ) {

		return get_template_directory() . '/' . $file;
	}
}

/**
 * Get post attributes
 *
 * @param int $post_id The post ID.
 * @return array $post_attrs
 */
function kayo_get_post_attr( $post_id ) {

	$post_attrs = array();

	$post_attrs['id']           = 'post-' . $post_id;
	$post_attrs['class']        = kayo_array_to_list( get_post_class(), ' ' );
	$post_attrs['data-post-id'] = $post_id;

	if ( 'work' === get_post_type() ) {
		$post_attrs['itemscope'] = '';
		$post_attrs['itemtype']  = 'https://schema.org/CreativeWork';
	}

	if ( 'release' === get_post_type() ) {
		$post_attrs['itemscope'] = '';
		$post_attrs['itemtype']  = 'https://schema.org/MusicAlbum';
	}

	if ( 'event' === get_post_type() ) {
		$post_attrs['itemscope'] = '';

		/**
		 * Filters microdata attribute
		 *
		 * @since Kayo 1.0.0
		 */
		$post_attrs['itemtype'] = 'https://schema.org/' . apply_filters( 'kayo_microdata_event_itemtype', 'MusicEvent' );
	}

	/**
	 * Filters post tag attributes
	 *
	 * @since Kayo 1.0.0
	 */
	return apply_filters( 'kayo_post_attrs', $post_attrs, $post_id );
}

/**
 * Output post attributes
 *
 * @param int $post_id The post ID.
 */
function kayo_post_attr( $class = '', $post_id = null ) {

	$post_id = ( $post_id ) ? $post_id : get_the_ID();
	$attrs   = kayo_get_post_attr( $post_id );
	$output  = '';

	$classes = array();

	if ( $class ) {
		if ( ! is_array( $class ) ) {
			$class = preg_split( '#\s+#', $class );
		}
			$classes = array_map( 'esc_attr', $class );
	} else {
		$class = array();
	}

	foreach ( $attrs as $attr => $value ) {
		if ( $value ) {

			if ( array() !== $classes && 'class' === $attr ) {
				$classes = array_unique( $classes );

				foreach ( $classes as $class ) {
					$value .= ' ' . $class;
				}
			}

			$output .= esc_attr( $attr ) . '="' . esc_attr( $value ) . '" ';

		} else {
			$output .= esc_attr( $attr ) . ' ';
		}
	}

	echo wp_kses_data( $output );
}

/**
 * Sanitize string with wp_kses
 *
 * @param string $output The string to sanitize.
 * @return sring $output
 */
function kayo_kses( $output ) {

	return force_balance_tags(
		wp_kses(
			$output,
			array(
				'div'        => array(
					'style'     => array(),
					'class'     => array(),
					'id'        => array(),
					'itemscope' => array(),
					'itemtype'  => array(),
				),
				'p'          => array(
					'class' => array(),
					'id'    => array(),
				),
				'ul'         => array(
					'class' => array(),
					'id'    => array(),
					'style' => array(),
				),
				'ol'         => array(
					'class' => array(),
					'id'    => array(),
					'style' => array(),
				),
				'li'         => array(
					'class' => array(),
					'id'    => array(),
				),
				'span'       => array(
					'class'        => array(),
					'id'           => array(),
					'data-post-id' => array(),
					'itemprop'     => array(),
					'title'        => array(),
				),
				'i'          => array(
					'class'       => array(),
					'id'          => array(),
					'aria-hidden' => array(),
				),
				'time'       => array(
					'class'    => array(),
					'datetime' => array(),
					'itemprop' => array(),
				),
				'blockquote' => array(
					'class' => array(),
					'id'    => array(),
				),
				'hr'         => array(
					'class' => array(),
					'id'    => array(),
				),
				'strong'     => array(
					'class' => array(),
					'id'    => array(),
				),
				'em'         => array(
					'class' => array(),
					'id'    => array(),
				),
				'sup'        => array(
					'class' => array(),
					'id'    => array(),
					'style' => array(),
				),
				'br'         => array(),
				'img'        => array(
					'src'      => array(),
					'srcset'   => array(),
					'class'    => array(),
					'id'       => array(),
					'width'    => array(),
					'height'   => array(),
					'sizes'    => array(),
					'alt'      => array(),
					'title'    => array(),
					'data-src' => array(),
				),
				'audio'      => array(
					'src'      => array(),
					'class'    => array(),
					'id'       => array(),
					'style'    => array(),
					'loop'     => array(),
					'autoplay' => array(),
					'preload'  => array(),
					'controls' => array(),
				),
				'source'     => array(
					'type' => array(),
					'src'  => array(),
				),
				'a'          => array(
					'class'                  => array(),
					'id'                     => array(),
					'href'                   => array(),
					'data-fancybox'          => array(),
					'rel'                    => array(),
					'title'                  => array(),
					'target'                 => array(),
					'data-mega-menu-tagline' => array(),
					'itemprop'               => array(),
				),
				'h1'         => array(
					'class'    => array(),
					'id'       => array(),
					'itemprop' => array(),
					'style'    => array(),
				),
				'h2'         => array(
					'class'    => array(),
					'id'       => array(),
					'itemprop' => array(),
					'style'    => array(),
				),
				'h3'         => array(
					'class'    => array(),
					'id'       => array(),
					'itemprop' => array(),
					'style'    => array(),
				),
				'h4'         => array(
					'class'    => array(),
					'id'       => array(),
					'itemprop' => array(),
					'style'    => array(),
				),
				'h5'         => array(
					'class'    => array(),
					'id'       => array(),
					'itemprop' => array(),
					'style'    => array(),
				),
				'h6'         => array(
					'class'    => array(),
					'id'       => array(),
					'itemprop' => array(),
					'style'    => array(),
				),
				'ins'        => array(
					'class'    => array(),
					'id'       => array(),
					'itemprop' => array(),
					'style'    => array(),
				),
				'del'        => array(
					'class'    => array(),
					'id'       => array(),
					'itemprop' => array(),
					'style'    => array(),
				),
				'code'       => array(
					'class' => array(),
					'id'    => array(),
				),
				'iframe'     => array(
					'align'        => array(),
					'width'        => array(),
					'height'       => array(),
					'frameborder'  => array(),
					'name'         => array(),
					'src'          => array(),
					'id'           => array(),
					'class'        => array(),
					'style'        => array(),
					'scrolling'    => array(),
					'marginwidth'  => array(),
					'marginheight' => array(),
				),
				'svg'        => array(
					'class'           => true,
					'aria-hidden'     => true,
					'aria-labelledby' => true,
					'role'            => true,
					'xmlns'           => true,
					'width'           => true,
					'height'          => true,
					'viewbox'         => true,
				),
				'g'          => array( 'fill' => true ),
				'title'      => array( 'title' => true ),
				'path'       => array(
					'class' => array(),
					'id'    => array(),
					'd'     => true,
					'fill'  => true,
				),
			)
		)
	);
}

/**
 * Check if the home page is set to posts
 *
 * @return bool
 */
function kayo_is_home_as_blog() {
	return ( 'posts' === get_option( 'show_on_front' ) && is_home() );
}

/**
 * Check if the home page
 *
 * @return bool
 */
function kayo_is_home() {
	return apply_filters( 'kayo_is_home', kayo_is_home_as_blog() || is_front_page() );
}


/**
 * Check if we're on the blog index page
 *
 * @return bool
 */
function kayo_is_blog_index() {

	return kayo_is_home_as_blog() || ( absint( kayo_get_the_id() ) === absint( get_option( 'page_for_posts' ) ) );
}

/**
 * Check if we're on a blog page
 *
 * @return bool
 */
function kayo_is_blog() {

	$is_blog = ( kayo_is_home_as_blog() || kayo_is_blog_index() || is_search() || is_archive() ) && ! kayo_is_woocommerce_page() && 'post' === get_post_type();
	return ( true === $is_blog );
}

/**
 * Get the post ID to use to display a header
 *
 * For example, if a header is set for the blog, we will use it for the archive and search page
 *
 * @return int $id
 */
function kayo_get_inherit_post_id() {

	if ( is_404() ) {
		return;
	}

	$post_id      = null;
	$shop_page_id = ( function_exists( 'kayo_get_woocommerce_shop_page_id' ) ) ? kayo_get_woocommerce_shop_page_id() : false;

	$is_shop_page = function_exists( 'is_shop' ) ? is_shop() || is_cart() || is_checkout() || is_account_page() || is_product_category() || is_product_tag() || ( function_exists( 'wolf_wishlist_get_page_id' ) && is_page( wolf_wishlist_get_page_id() ) ) : false;

	$is_product_taxonomy = function_exists( 'is_product_taxonomy' ) ? is_product_taxonomy() : false;
	$is_single_product   = function_exists( 'is_product' ) ? is_product() : false;
	if ( ( kayo_is_blog() || is_search() ) && false === $is_shop_page && false === $is_product_taxonomy ) {

		$post_id = get_option( 'page_for_posts' );
	} elseif ( $is_shop_page ) {

		$post_id = $shop_page_id;
	} elseif ( ( is_tax( 'band' ) || is_tax( 'label' ) ) && function_exists( 'wolf_discography_get_page_id' ) ) {

		$post_id = wolf_discography_get_page_id();
	} elseif ( is_tax( 'video_type' ) || is_tax( 'video_tag' ) && function_exists( 'wolf_videos_get_page_id' ) ) {

		$post_id = wolf_videos_get_page_id();
	} elseif ( is_tax( 'we_artist' ) && function_exists( 'wolf_events_get_page_id' ) ) {

		$post_id = wolf_events_get_page_id();
	} elseif ( is_tax( 'work_type' ) && function_exists( 'wolf_portfolio_get_page_id' ) ) {

		$post_id = wolf_portfolio_get_page_id();
	} elseif ( is_tax( 'gallery_type' ) && function_exists( 'wolf_albums_get_page_id' ) ) {

		$post_id = wolf_albums_get_page_id();

	} else {
		$post_id = kayo_get_the_id();
	}

	return $post_id;
}

/**
 * Get attachment ID from title
 *
 * @param string $title the attachment title
 * @return int | null the attachment ID
 */
function kayo_get_attachement_id_from_title( $title ) {

	global $wpdb;

	$_attachment = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE post_title = %s AND post_type = %s ", array( $title, 'attachment' ) ) );

	$attachment = $_attachment ? array_pop( $_attachment ) : null;

	return ( $attachment && is_object( $attachment ) ) ? $attachment->ID : '';
}

/**
 * Add to cart tag
 *
 * @param int    $product_id
 * @param string $text link text content
 * @param string $class button class
 * @return string
 */
function kayo_add_to_cart( $product_id, $classes = '', $text = '' ) {

	$wc_url = untrailingslashit( kayo_get_current_url() ) . '/?add-to-cart=' . absint( $product_id );

	$classes .= ' product_type_simple add_to_cart_button ajax_add_to_cart';

	return '<a
		href="' . esc_url( $wc_url ) . '"
		rel="nofollow"
		data-quantity="1" data-product_id="' . absint( $product_id ) . '"
		class="' . kayo_sanitize_html_classes( $classes ) . '">' . $text . '</a>';
}

/**
 * Get lists of categories.
 *
 * @see js_composer/include/classes/vendors/class-vc-vendor-woocommerce.php
 *
 * @param $parent_id
 * @param array     $array
 * @param $level
 * @param array     $dropdown - passed by  reference
 */
function kayo_get_category_childs_full( $parent_id, $array, $level, &$dropdown ) {
	$keys = array_keys( $array );
	$i    = 0;
	while ( $i < count( $array ) ) {
		$key  = $keys[ $i ];
		$item = $array[ $key ];
		$i ++;
		if ( $item->category_parent == $parent_id ) {
			$name       = str_repeat( '- ', $level ) . $item->name;
			$value      = $item->term_id;
			$dropdown[] = array(
				'label' => $name . ' (' . $item->term_id . ')',
				'value' => $value,
			);
			unset( $array[ $key ] );
			$array = kayo_get_category_childs_full( $item->term_id, $array, $level + 1, $dropdown );
			$keys  = array_keys( $array );
			$i     = 0;
		}
	}

	return $array;
}

/**
 * Get product category dropdown options
 */
function kayo_get_product_cat_dropdown_options() {

	$product_categories_dropdown_param = array();
	$product_categories_dropdown       = array();
	$product_cat_args                  = array(
		'type'         => 'post',
		'child_of'     => 0,
		'parent'       => '',
		'orderby'      => 'name',
		'order'        => 'ASC',
		'hide_empty'   => false,
		'hierarchical' => 1,
		'exclude'      => '',
		'include'      => '',
		'number'       => '',
		'taxonomy'     => 'product_cat',
		'pad_counts'   => false,

	);

	$categories = get_categories( $product_cat_args );

	$product_categories_dropdown = array();
	kayo_get_category_childs_full( 0, $categories, 0, $product_categories_dropdown );

	foreach ( $product_categories_dropdown as $cat ) {
		if ( isset( $cat['value'] ) ) {
			$product_categories_dropdown_param[ $cat['value'] ] = $cat['label'];
		}
	}

	return $product_categories_dropdown_param;
}

/**
 * Get product category dropdown options
 */
function kayo_get_video_cat_dropdown_options() {

	$video_categories_dropdown_param = array();
	$video_categories_dropdown       = array();
	$video_cat_args                  = array(
		'type'         => 'post',
		'child_of'     => 0,
		'parent'       => '',
		'orderby'      => 'name',
		'order'        => 'ASC',
		'hide_empty'   => false,
		'hierarchical' => 1,
		'exclude'      => '',
		'include'      => '',
		'number'       => '',
		'taxonomy'     => 'video_type',
		'pad_counts'   => false,

	);

	$categories = get_categories( $video_cat_args );

	$video_categories_dropdown = array();
	kayo_get_category_childs_full( 0, $categories, 0, $video_categories_dropdown );

	foreach ( $video_categories_dropdown as $cat ) {
		if ( isset( $cat['value'] ) ) {
			$video_categories_dropdown_param[ $cat['value'] ] = $cat['label'];
		}
	}

	return $video_categories_dropdown_param;
}

/**
 * Get metro pattern options
 */
function kayo_get_metro_patterns() {

	/**
	 * Filters available metro pattern options
	 *
	 * @since Kayo 1.0.0
	 */
	return apply_filters(
		'kayo_metro_pattern_options',
		array(
			'auto'      => esc_html__( 'Auto', 'kayo' ),
			/* translators: %1$d: pattern number %2$d: number of item in the loop */
			'pattern-1' => sprintf( esc_html__( 'Pattern %1$d (loop of %2$d)', 'kayo' ), 1, 6 ),
			/* translators: %1$d: pattern number %2$d: number of item in the loop */
			'pattern-2' => sprintf( esc_html__( 'Pattern %1$d (loop of %2$d)', 'kayo' ), 2, 8 ),
			/* translators: %1$d: pattern number %2$d: number of item in the loop */
			'pattern-3' => sprintf( esc_html__( 'Pattern %1$d (loop of %2$d)', 'kayo' ), 3, 10 ),
			/* translators: %1$d: pattern number %2$d: number of item in the loop */
			'pattern-4' => sprintf( esc_html__( 'Pattern %1$d (loop of %2$d)', 'kayo' ), 4, 8 ),
			/* translators: %1$d: pattern number %2$d: number of item in the loop */
			'pattern-5' => sprintf( esc_html__( 'Pattern %1$d (loop of %2$d)', 'kayo' ), 5, 5 ),
			/* translators: %1$d: pattern number %2$d: number of item in the loop */
			'pattern-6' => sprintf( esc_html__( 'Pattern %1$d (loop of %2$d)', 'kayo' ), 6, 5 ),
			/* translators: %1$d: pattern number %2$d: number of item in the loop */
			'pattern-7' => sprintf( esc_html__( 'Pattern %1$d (loop of %2$d)', 'kayo' ), 7, 6 ),
		)
	);
}

/**
 * Get default color skin
 *
 * Get old option name if empty
 *
 * @return string
 */
function kayo_get_color_scheme_option() {
	/**
	 * Filters color scheme
	 *
	 * @since Kayo 1.0.0
	 */
	return apply_filters( 'kayo_color_scheme_option', get_theme_mod( 'color_scheme', get_theme_mod( 'skin', 'default' ) ) );
}

/**
 * Returns "order by values" options
 *
 * @return array
 */
function kayo_order_by_values() {
	return array(
		''              => '',
		'date'          => esc_html__( 'Date', 'kayo' ),
		'ID'            => esc_html__( 'ID', 'kayo' ),
		'author'        => esc_html__( 'Author', 'kayo' ),
		'title'         => esc_html__( 'Title', 'kayo' ),
		'modified'      => esc_html__( 'Modified', 'kayo' ),
		'rand'          => esc_html__( 'Random', 'kayo' ),
		'comment_count' => esc_html__( 'Comment count', 'kayo' ),
		'menu_order'    => esc_html__( 'Menu order', 'kayo' ),
	);
}

/**
 * Returns "order way values" options
 *
 * @return array
 */
function kayo_order_way_values() {
	return array(
		''     => '',
		'DESC' => esc_html__( 'Descending', 'kayo' ),
		'ASC'  => esc_html__( 'Ascending', 'kayo' ),
	);
}

/**
 * Returns "shared_gradient_colors" options
 *
 * @return array
 */
function kayo_shared_gradient_colors() {
	return ( function_exists( 'wolf_core_get_shared_gradient_colors' ) ) ? wolf_core_get_shared_gradient_colors() : array();
}

/**
 * Returns "wolfheme_shared_colors" options
 *
 * @return array
 */
function kayo_shared_colors() {
	return ( function_exists( 'wolf_core_get_shared_colors' ) ) ? wolf_core_get_shared_colors() : array();
}

/**
 * Enqueue Elementor admin scripts
 */
function kayo_enqueue_elementor_editor_scripts() {

	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : kayo_get_theme_version();

	wp_enqueue_script( 'elementor-admin', get_template_directory_uri() . '/assets/js/admin/elementor-admin.js', array( 'jquery' ), $version, true );
}
add_action( 'elementor/frontend/after_enqueue_scripts', 'kayo_enqueue_elementor_editor_scripts' );


/**
 * Returns a login form
 *
 * @param array $atts
 */
function kayo_login_form( $atts = array() ) {

	if ( ! function_exists( 'wc_get_page_id' ) ) {
		return;
	}

	$atts = wp_parse_args(
		$atts,
		array(
			'css_animation'       => '',
			'css_animation_delay' => '',
			'css'                 => '',
			'el_class'            => '',
			'inline_style'        => '',
		)
	);

	/**
	 * Filters login form attibutes
	 *
	 * @since Kayo 1.0.0
	 */
	$atts = apply_filters( 'kayo_login_form_atts', $atts );

	extract( $atts ); // phpcs:ignore

	$output = '';

	wp_enqueue_script( 'jquery-ui-tabs' );
	wp_enqueue_script( 'kayo-loginform' );

	$class = $el_class;

	$class .= ' kayo-login-form kayo-login-form-container';

	$output .= '<div class="' . kayo_sanitize_html_classes( $class ) . '">';

	$output .= '<div class="kayo-login-form-inner">';

	/* Title */
	$output .= '<div class="kayo-login-form-title-container">';
	$output .= '<h3 class="kayo-login-form-title">';
	$output .= esc_html__( 'Login', 'kayo' );
	$output .= '</h3>';
	$output .= '</div>';

	ob_start();

	?>
	<form class="kayo-login-form" method="post">
			<?php
				/**
				 * WC login form start hook
				 *
				 * @since Kayo 1.0.0
				 */
				do_action( 'woocommerce_login_form_start' );
			?>

			<p class="login-username">
				<label for="username"><?php esc_html_e( 'Username or email address', 'kayo' ); ?>&nbsp;<span class="required">*</span></label>
				<input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? sanitize_user( wp_unslash( $_POST['username'] ) ) : ''; ?>" />
			</p>
			<p class="login-password">
				<label for="password"><?php esc_html_e( 'Password', 'kayo' ); ?>&nbsp;<span class="required">*</span></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="password" name="password" id="password" autocomplete="current-password" />
			</p>

			<input type="hidden" name="redirect" value="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>">

			<?php
				/**
				 * WC login form hook
				 *
				 * @since Kayo 1.0.0
				 */
				do_action( 'woocommerce_login_form' );
			?>

			<p class="login-remember">
				<label>
					<input name="rememberme" type="checkbox" id="rememberme" value="forever"><span><?php esc_html_e( 'Remember me', 'kayo' ); ?></span>
				</label>
			</p>

			<p class="login-submit">
				<?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
				<input id="wp-submit" type="submit" class="
				<?php
					/**
					 * Filters submit button class
					 *
					 * @since Kayo 1.0.0
					 */
					echo esc_attr( apply_filters( 'kayo_login_form_submit_button_class', 'button button-primary' ) );
				?>
				" name="login" value="<?php esc_attr_e( 'Log in', 'kayo' ); ?>">
			</p>

			<p class="kayo-login-form-links">
				<a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ); ?>"><?php esc_html_e( 'I need to register', 'kayo' ); ?></a>

				<?php
					echo esc_attr(
						/**
						 * Filters link separator
						 *
						 * @since Kayo 1.0.0
						 */
						apply_filters( 'kayo_login_form_bottom_link_separator', '|' )
					);
				?>

				<a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php esc_html_e( 'Lost your password?', 'kayo' ); ?></a>
			</p>

			<?php
				/**
				 * WC login form end hook
				 *
				 * @since Kayo 1.0.0
				 */
				do_action( 'woocommerce_login_form_end' );
			?>
		</form>
	<?php

	$output .= ob_get_clean();

	$output .= '</div><!--.kayo-login-form-inner-->';

	$output .= '</div><!--.kayo-login-form-->';

	return $output;
}

/**
 * Tertiary isset shortand
 */
function kayo_isset( $entry, $default_value = null ) {
	return isset( $entry ) ? $entry : null;
}
