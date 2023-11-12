<?php
/**
 * Plugin Name: Share Icons
 * Plugin URI: https://wlfthm.es/wolf-share
 * Description: A WordPress plugin to add share buttons to your post.
 * Version: 1.1.1
 * Author: WolfThemes
 * Author URI: https://wolfthemes.com
 * Requires at least: 5.0
 * Tested up to: 5.5
 *
 * Text Domain: wolf-share
 * Domain Path: /languages/
 *
 * @package WolfShare
 * @category Core
 * @author WolfThemes
 *
 * Verified customers who have purchased a premium theme at https://wlfthm.es/tf/
 * will have access to support for this plugin in the forums
 * https://wlfthm.es/help/
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wolf_Share' ) ) {
	/**
	 * Main Wolf_Share Class
	 *
	 * Contains the main functions for Wolf_Share
	 *
	 * @class Wolf_Share
	 * @version 1.1.1
	 * @since 1.0.0
	 */
	class Wolf_Share {

		/**
		 * @var string
		 */
		public $version = '1.1.1';

		/**
		 * @var Wolf Share The single instance of the class
		 */
		protected static $_instance = null;



		/**
		 * Main Wolf Share Instance
		 *
		 * Ensures only one instance of Wolf Share is loaded or can be loaded.
		 *
		 * @static
		 * @see WSHARE()
		 * @return Wolf Share - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Wolf Share Constructor.
		 */
		public function __construct() {

			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			do_action( 'wolf_share_loaded' );
		}

		/**
		 * Hook into actions and filters
		 */
		private function init_hooks() {
			register_activation_hook( __FILE__, array( $this, 'activate' ) );
			add_action( 'init', array( $this, 'init' ), 0 );

			add_action( 'admin_init', array( $this, 'plugin_update' ) );
		}

		/**
		 * Activation function
		 */
		public function activate() {

			do_action( 'wolf_share_activated' );
		}

		/**
		 * Define WPB Constants
		 */
		private function define_constants() {

			$constants = array(
				'WS_DEV' => false,
				'WS_DIR' => $this->plugin_path(),
				'WS_URI' => $this->plugin_url(),
				'WS_CSS' => $this->plugin_url() . '/assets/css',
				'WS_JS' => $this->plugin_url() . '/assets/js',
				'WS_IMG' => $this->plugin_url() . '/assets/img',
				'WS_SLUG' => plugin_basename( dirname( __FILE__ ) ),
				'WS_PATH' => plugin_basename( __FILE__ ),
				'WS_VERSION' => $this->version,
				'WS_DOC_URI' => 'https://docs.wolfthemes.com/documentation/plugins/' . plugin_basename( dirname( __FILE__ ) ),
				'WS_WOLF_DOMAIN' => 'wolfthemes.com',
			);

			foreach ( $constants as $name => $value ) {
				$this->define( $name, $value );
			}

			// var_dump( WPB_UPLOAD_URI );
		}

		/**
		 * Define constant if not already set
		 * @param  string $name
		 * @param  string|bool $value
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * What type of request is this?
		 * string $type ajax, frontend or admin
		 * @return bool
		 */
		private function is_request( $type ) {
			switch ( $type ) {
				case 'admin' :
					return is_admin();
				case 'ajax' :
					return defined( 'DOING_AJAX' );
				case 'cron' :
					return defined( 'DOING_CRON' );
				case 'frontend' :
					return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
			}
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 */
		public function includes() {

			include_once( 'inc/ws-core-functions.php' );

			if ( $this->is_request( 'admin' ) ) {
				include_once( 'inc/admin/class-ws-admin.php' );
			}

			if ( $this->is_request( 'ajax' ) ) {
				include_once( 'inc/ajax/ws-ajax-functions.php' );
			}

			if ( $this->is_request( 'frontend' ) ) {
				include_once( 'inc/frontend/ws-frontend-functions.php' );
				include_once( 'inc/frontend/class-ws-shortcodes.php' );
			}
		}

		/**
		 * Init Wolf Share when WordPress Initialises.
		 */
		public function init() {
			// Before init action
			do_action( 'before_wolf_share_init' );

			// Set up localisation
			$this->load_plugin_textdomain();

			// Init action
			do_action( 'wolf_share_init' );
		}

		/**
		 * Loads the plugin text domain for translation
		 */
		public function load_plugin_textdomain() {

			$domain = 'wolf-share';
			$locale = apply_filters( 'wolf-share', get_locale(), $domain );
			load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Get the plugin url.
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}

		/**
		 * Get the plugin path.
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		/**
		 * Plugin update
		 */
		public function plugin_update() {

			if ( ! class_exists( 'WP_GitHub_Updater' ) ) {
				include_once 'inc/admin/updater.php';
			}

			$repo = 'wolfthemes/wolf-share';

			$config = array(
				'slug' => plugin_basename( __FILE__ ),
				'proper_folder_name' => 'wolf-share',
				'api_url' => 'https://api.github.com/repos/' . $repo . '',
				'raw_url' => 'https://raw.github.com/' . $repo . '/master/',
				'github_url' => 'https://github.com/' . $repo . '',
				'zip_url' => 'https://github.com/' . $repo . '/archive/master.zip',
				'sslverify' => true,
				'requires' => '5.0',
				'tested' => '5.5',
				'readme' => 'README.md',
				'access_token' => '',
			);

			new WP_GitHub_Updater( $config );
		}
	}
}
/**
 * Returns the main instance of WSHARE to prevent the need to use globals.
 *
 * @return Wolf_Share
 */
function WSHARE() {
	return Wolf_Share::instance();
}

WSHARE(); // Go
