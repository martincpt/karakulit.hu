<?php
/**
 * Framework
 *
 * A simple class to handle theme functionalities and include files
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main Framework Class
 */
final class Kayo_Framework { // phpcs:ignore

	/**
	 * The single instance of the class
	 */
	protected static $instance = null;

	/**
	 * Default theme settings
	 *
	 * @var array
	 */
	public $options = array(
		'menus'       => array( 'primary' => 'Primary Menu' ),
		'image_sizes' => array(),
	);

	/**
	 * Main Theme Instance
	 *
	 * Ensures only one instance of the theme is loaded or can be loaded.
	 *
	 * @static
	 * @see KAYO()
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
	}

	/**
	 * Kayo_Framework Constructor.
	 *
	 * @param array $options The main theme settings.
	 */
	public function __construct( $options = array() ) {

		$this->options = $options + $this->options;

		$this->includes();

		$this->init_hooks();

		/**
		 * Hook when the framework is loaded completely
		 *
		 * @since 1.0.0
		 */
		do_action( 'kayo_framework_loaded' );
	}

	/**
	 * Hook into actions and filters
	 */
	private function init_hooks() {

		add_action( 'after_setup_theme', array( $this, 'setup' ) );

		if ( kayo_get_plugin_in_use() ) {

			add_action( 'init', array( $this, 'include_post_modules_params' ) );

			if ( 'elementor' === kayo_get_plugin_in_use() && class_exists( 'Wolf_Core' ) ) {

				add_action( 'elementor/widgets/widgets_registered', array( $this, 'init_elementor_widgets' ) );

			} elseif ( 'vc' === kayo_get_plugin_in_use() ) {

				add_action( 'init', array( $this, 'include_vc_modules' ) );
			}
		}
	}

	/**
	 * Include post modules
	 */
	public function include_post_modules_params() {

		if ( ! kayo_include_config( 'module-params.php' ) ) {
			kayo_include( 'inc/module-params.php' );
		}
	}

	/**
	 * Include VC post modules
	 */
	public function include_vc_modules() {

		if ( ! kayo_include_config( 'vc-post-modules.php' ) ) {
			kayo_include( 'inc/vc-post-modules.php' );
		}

		if ( ! kayo_include_config( 'wpbpb-post-modules.php' ) ) {
			kayo_include( 'inc/wpbpb-post-modules.php' );
		}
	}

	/**
	 * Include Elementor post modules
	 */
	public function init_elementor_widgets() {

		$post_types_modules = kayo_get_available_post_types();
		$post_types_modules = array(
			'post',
			'work',
			'product',
			'release',
			'gallery',
			'event',
			'video',
			'artist',
		);

		foreach ( $post_types_modules as $cpt ) {

			if ( post_type_exists( $cpt ) && is_file( get_template_directory() . '/elementor/' . sanitize_title_with_dashes( $cpt ) . '-index.php' ) ) {
				require_once get_template_directory() . '/elementor/' . sanitize_title_with_dashes( $cpt ) . '-index.php';
			}
		}
	}

	/**
	 * What type of request is this?
	 * string $type ajax, frontend or admin
	 *
	 * @param  string $type the type of request.
	 * @return bool
	 */
	private function is_request( $type ) {

		switch ( $type ) {
			case 'admin':
				return is_admin();
			case 'ajax':
				return defined( 'DOING_AJAX' );
			case 'cron':
				return defined( 'DOING_CRON' );
			case 'customizer':
				return is_customize_preview();
			case 'frontend':
				return ( ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' ) ) || is_customize_preview() || kayo_is_elementor_editor();
		}
	}

	/**
	 * Include required  depending on context
	 */
	public function includes() {

		/* Optionaly require a config file that will be fired before anything else */
		if ( is_file( get_parent_theme_file_path( 'config/super-config.php' ) ) ) {
			require get_parent_theme_file_path( '/config/super-config.php' );
		}

		$core_files = array(
			'core-functions',
			'conditional-functions',
		);

		/* Includes files from theme inc dir in both frontend and backend */
		foreach ( $core_files as $file ) {

			if ( ! locate_template( '/inc/' . sanitize_file_name( $file ) . '.php', true, true ) ) {
				wp_die(
					sprintf(
						wp_kses(
							/* translators: %s: the file */
							__( 'Error locating <code>%s</code> for inclusion.', 'kayo' ),
							array(
								'code' => array(),
							)
						),
						esc_attr( $file )
					)
				);
			}
		}

		$core_optional_files = array(
			'elementor-extend',
			'vc-extend',
			'wolf-core-extend',
			'fonts',
			'sidebars',
		);

		/* Includes files from theme inc dir in both frontend and backend */
		foreach ( $core_optional_files as $file ) {
			locate_template( '/inc/' . sanitize_file_name( $file ) . '.php', true, true );
		}

		/* Includes main config file (colors, add support, WooCommerce thumbnail size etc...) */
		kayo_include_config( 'config.php' );

		/* Theme custom functions */
		kayo_include( 'inc/theme-functions.php' );

		if ( $this->is_request( 'admin' ) ) {
			$this->admin_includes();
		}
			$this->frontend_includes();

		if ( $this->is_request( 'ajax' ) ) {
			$this->ajax_includes();
		}

		/*
		 Customizer related functions */
			$this->customizer_includes();
	}

	/**
	 * Includes framework filters, functions, specific front end options & template-tags
	 */
	public function frontend_includes() {

		$frontend_files = array(
			'helpers',
			'image-functions',
			'frontend-functions',
			'background-functions',
			'plugin-extend-functions',
			'template-tags',
			'featured-media',
			'menu-functions',
			'query-functions',
			'body-classes',
			'post-attributes',
			'hooks',
			'post',
			'class-walker-comment',
			'styles',
			'woocommerce',
			'scripts',
		);

		foreach ( $frontend_files as $file ) {

			if ( ! locate_template( '/inc/frontend/' . sanitize_file_name( $file ) . '.php', true, true ) ) {
				wp_die(
					/* translators: %s: the file */
					sprintf( kayo_kses( __( 'Error locating <code>%s</code> for inclusion.', 'kayo' ) ), esc_attr( $file ) )
				);
			}
		}
	}

	/**
	 * Includes ajax functions
	 */
	public function ajax_includes() {

		$file = 'ajax-functions';

		if ( ! locate_template( '/inc/ajax/' . sanitize_file_name( $file ) . '.php', true, true ) ) {
			wp_die(
				/* translators: %s: the file */
				sprintf( kayo_kses( __( 'Error locating <code>%s</code> for inclusion.', 'kayo' ) ), esc_attr( $file ) )
			);
		}
	}

	/**
	 * Includes framework filters, functions, specific front end options & template-tags
	 */
	public function admin_includes() {

		$admin_files = array(
			'theme-activation',
			'admin-functions',
			'admin-update-functions',
			'admin-scripts',
			'class-font-options',
			'class-menu-item-custom-fields',
			'class-about-page',
			'import-functions',
		);

		/* Includes admin files */
		foreach ( $admin_files as $file ) {

			locate_template( '/inc/admin/' . sanitize_file_name( $file ) . '.php', true, true );
		}

		$admin_config_files = array(
			'plugins',
			'importer',
			'update',
			'metaboxes',
		);

		/* Includes admin config files */
		foreach ( $admin_config_files as $file ) {
			kayo_include_config( sanitize_file_name( $file ) . '.php', true, true );
		}
	}

	/**
	 * Includes customizer files.
	 *
	 * They must be enqueued in front end and backend
	 */
	public function customizer_includes() {

		$mod_files = array(
			'class-customizer-library',
			'extensions/functions',
			'extensions/preview-colors',
			'extensions/preview-fonts',
			'extensions/preview-layout',
			'extensions/preview-layout',
			'extensions/frontend',
			'mods',
		);

		/* Require admin config files */
		foreach ( $mod_files as $file ) {

			if ( ! locate_template( '/inc/customizer/' . $file . '.php', true, true ) ) {
				wp_die(
					/* translators: %s: the file */
					sprintf( kayo_kses( __( 'Error locating <code>%s</code> for inclusion.', 'kayo' ) ), esc_attr( $file ) )
				);
			}
		}
	}

	/**
	 * Set up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	public function setup() {

		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on the theme, use a find and replace
		 * to change 'kayo' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'kayo', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'status',
				'audio',
				'chat',
			)
		);

		/**
		 * Add custom background support
		 */
		add_theme_support(
			'custom-background',
			array(
				'default-color'      => '',
				'default-repeat'     => 'no-repeat',
				'default-attachment' => 'fixed',
			)
		);

		/**
		 * Add custom header support
		 *
		 * Diable the header text because we will handle it automatically to display the page title
		 */
		add_theme_support(
			'custom-header',
			/**
			 * Header arguments
			 *
			 * @since 1.0.0
			 */
			apply_filters(
				'kayo_custom_header_args',
				array(
					'header-text' => false,
					'width'       => 1920, // recommended header image width.
					'height'      => 1280, // recommended header image height.
					'flex-height' => true,
					'flex-width'  => true,
				)
			)
		);

		/**
		 * Indicate widget sidebars can use selective refresh in the Customizer.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically typography
		 */
		add_editor_style( 'assets/css/admin/editor-style.css' );

		$this->set_post_thumbnail_sizes();
		$this->register_nav_menus();
	}

	/**
	 * Set the different thumbnail sizes needed in the design
	 * (can be set in functions.php)
	 */
	public function set_post_thumbnail_sizes() {
		global $content_width;

		set_post_thumbnail_size( $content_width, $content_width / 2 ); // default Post Thumbnail dimensions.

		/**
		 * Filters theme image sizes
		 *
		 * @since 1.0.0
		 */
		$image_sizes = apply_filters( 'kayo_image_sizes', $this->options['image_sizes'] );

		if ( array() !== $image_sizes ) {
			if ( function_exists( 'add_image_size' ) ) {
				foreach ( $image_sizes as $k => $v ) {
					add_image_size( $k, $v[0], $v[1], $v[2] );
				}
			}
		}
	}

	/**
	 * Register menus
	 */
	public function register_nav_menus() {
		if ( function_exists( 'register_nav_menus' ) ) {
			register_nav_menus(
				/**
				 * Filters the theme menus
				 *
				 * @since 1.0.0
				 */
				apply_filters( 'kayo_menus', $this->options['menus'] )
			);
		}
	}
} // end class

/**
 * Returns the main instance of KAYO to prevent the need to use globals.
 *
 * @return Kayo_Framework
 */
function KAYO( $options = array() ) { // phpcs:ignore
	return new Kayo_Framework( $options );
}
