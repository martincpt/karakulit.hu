<?php // phpcs:ignore
/**
 * Artist Index
 *
 * @package Kayo/Elementor
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

class Elementor_Artist_Index_Widget extends \Elementor\Widget_Base { // phpcs:ignore

	/**
	 * Element parameters
	 *
	 * @var string
	 */
	public $params = array();

	/**
	 *  Element scripts
	 *
	 * @var string
	 */
	public $scripts = array();

	public function __construct( $data = array(), $args = null ) { // phpcs:ignore

		parent::__construct( $data, $args );

		$this->params = kayo_artist_index_params();

		if ( isset( $this->params['properties']['register_scripts'] ) ) {

			kayo_register_scripts( $this->params['properties']['register_scripts'] );
		}

		if ( isset( $this->params['properties']['scripts'] ) ) {
			$this->scripts = $this->params['properties']['scripts'];
		}
	}

	/**
	 * Retrieve the list of scripts the counter widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @version 1.0.0
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return $this->scripts;
	}

	/**
	 * Get widget name
	 *
	 * @return string Widget name.
	 */
	public function get_name() {

		if ( isset( $this->params['properties']['el_base'] ) ) {
			return $this->params['properties']['el_base'];
		}
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return $this->params['properties']['name'];
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return $this->params['properties']['icon'];
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return $this->params['properties']['el_categories'];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @version 1.0.0
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		if ( isset( $this->params['properties']['keywords'] ) ) {
			return $this->params['properties']['keywords'];
		}
	}

	/**
	 * Register Artist Index widget controls.
	 */
	protected function register_controls() { // phpcs:ignore

		wolf_core_register_elementor_controls( $this );
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {

		$atts              = $this->get_settings_for_display();
		$atts['post_type'] = 'artist';

		/**
		 * Uses the main post hook to display the artists.
		 */
		do_action( 'kayo_posts', $atts );
	}
}
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_Artist_Index_Widget() );

