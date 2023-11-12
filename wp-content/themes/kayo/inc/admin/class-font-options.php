<?php // phpcs:ignore

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Kayo_Font_Options' ) ) {
	/**
	 * Kayo font loader
	 *
	 * Allow to load Google fonts and Typekit fonts to use in the customizer
	 *
	 * @package WordPress
	 * @subpackage Kayo
	 * @version 1.5.1
	 */
	class Kayo_Font_Options {

		/**
		 * Option index
		 *
		 * @var string
		 */
		private $index = 'font';

		/**
		 * Hook into the appropriate actions when the class is constructed.
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'add_menu' ) );
			add_action( 'admin_init', array( $this, 'admin_init' ) );
			add_action( 'admin_init', array( $this, 'default_options' ) );
		}

		/**
		 * Add contextual menu
		 */
		public function add_menu() {

			add_theme_page( esc_html__( 'Fonts Loader', 'kayo' ), esc_html__( 'Font Loader', 'kayo' ), 'administrator', 'font-loader', array( $this, 'font_loader_settings' ) );
		}

		/**
		 * Get option index name
		 */
		public function options_index_name() {
			return kayo_get_theme_slug() . '_' . $this->index . '_settings';
		}

		/**
		 * Add Settings
		 */
		public function admin_init() {

			register_setting( $this->options_index_name(), $this->options_index_name(), array( $this, 'settings_validate' ) );

			add_settings_section( $this->options_index_name(), '', array( $this, 'section_intro' ), $this->options_index_name() );

			add_settings_field( 'google_fonts', esc_html__( 'Google Fonts', 'kayo' ), array( $this, 'setting_google_font' ), $this->options_index_name(), $this->options_index_name() );

			add_settings_field( 'typekit_fonts', esc_html__( 'Typekit fonts', 'kayo' ), array( $this, 'setting_typekit_font' ), $this->options_index_name(), $this->options_index_name() );
		}

		/**
		 * Intro section used for debug
		 */
		public function section_intro() {
		}

		/**
		 * Intro section used for debug
		 */
		public function settings_validate( $input ) {

			if ( isset( $_POST['kayo_font_settings_nonce'] ) && wp_verify_nonce( $_POST['kayo_font_settings_nonce'], 'kayo_save_font_settings_nonce' ) ) {

				$input['google_fonts']  = str_replace( ';', ',', $input['google_fonts'] );
				$input['typekit_fonts'] = str_replace( ';', ',', $input['typekit_fonts'] );

				$regex                  = '/[^a-zA-Z0-9|:,+-]+/';
				$input['google_fonts']  = preg_replace( $regex, '', $input['google_fonts'] );
				$input['typekit_fonts'] = preg_replace( $regex, '', $input['typekit_fonts'] );

				$input['google_fonts']  = esc_attr( $input['google_fonts'] );
				$input['typekit_fonts'] = esc_attr( $input['typekit_fonts'] );

				do_action( 'kayo_after_' . $this->options_index_name() . '_options_save', $input );
			}

			return $input;

		}

		/**
		 * Google font text field
		 */
		public function setting_google_font() {
			?>
			<input placeholder="Open+Sans:400,700|Karla:400,400" type="text" class="large-text" name="<?php echo esc_attr( $this->options_index_name() ); ?>[google_fonts]" value="<?php echo esc_attr( $this->get_option( 'google_fonts' ) ); ?>">
			<p class="description">
				<?php
					echo sprintf(
						kayo_kses(
							__( 'You can get your fonts on the <a href="%s" target="_blank">Google Fonts</a> website.', 'kayo' )
						),
						esc_url( 'https://www.google.com/fonts' )
					)
				?>
			</p>
			<?php
		}

		/**
		 * Typekit font text field
		 */
		public function setting_typekit_font() {
			?>
			<input placeholder="adobe-caslon-pro|other-font" type="text" class="large-text" name="<?php echo esc_attr( $this->options_index_name() ); ?>[typekit_fonts]" value="<?php echo esc_attr( $this->get_option( 'typekit_fonts' ) ); ?>">
			<p class="description">
				<?php
					echo sprintf(
						kayo_kses(
							__( 'You need <a href="%1$s" target="_blank">Typekit Fonts for WordPress</a> plugin to import your font kit into your website. <a href="%2$s" target="_blank">More infos</a>', 'kayo' )
						),
						esc_url( 'https://wordpress.org/plugins/typekit-fonts-for-wordpress/' ),
						esc_url( 'https://wolfthemes.ticksy.com/article/11666/' )
					);
				?>
			</p>
			<?php
		}

		/**
		 * Get fonts option
		 *
		 * @param string $value
		 * @return string|null
		 */
		public function get_option( $value = null ) {

			$settings = get_option( $this->options_index_name() );

			if ( isset( $settings[ $value ] ) ) {
				return $settings[ $value ];
			}
		}

		/**
		 * Default options
		 */
		public function default_options() {

			if ( false === get_option( $this->options_index_name() ) ) {

				$default = array(
					'google_fonts'  => apply_filters( 'kayo_default_google_fonts', '' ),
					'typekit_fonts' => apply_filters( 'kayo_default_typekit_fonts', '' ),
				);

				add_option( $this->options_index_name(), $default );
			}
		}

		/**
		 * Settings Form
		 */
		public function font_loader_settings() {
			?>
			<div class="wrap">
				<div id="icon-options-general" class="icon32"></div>
				<h2><?php esc_html_e( 'Fonts Loader', 'kayo' ); ?></h2>
				<?php if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) { ?>
					<div id="setting-error-settings_updated" class="updated settings-error">
						<p><strong><?php esc_html_e( 'Settings saved.', 'kayo' ); ?></strong></p>
					</div>
				<?php } ?>
				<form action="options.php" method="post">
					<?php wp_nonce_field( 'kayo_save_font_settings_nonce', 'kayo_font_settings_nonce' ); ?>
					<?php settings_fields( $this->options_index_name() ); ?>
					<?php do_settings_sections( $this->options_index_name() ); ?>
					<p class="submit"><input name="save" type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'kayo' ); ?>" /></p>
				</form>
			</div>
			<?php
		}
	} // end class

	new Kayo_Font_Options();
}
