<?php // phpcs:ignore
/**
 * Post Index
 *
 * @package Kayo/Elementor
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

class Elementor_Animated_SVG_Widget extends \Elementor\Widget_Base { // phpcs:ignore

	public function get_name() {
		return 'animated-SVG';
	}

	public function get_title() {
		return esc_html__( 'Simple Animated SVG', 'kayo' );
	}

	public function get_icon() {
		return 'fa fa-code';
	}

	public function get_categories() {
		return array( 'extension' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			array(
				'label' => esc_html__( 'Content', 'kayo' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'inline_code',
			array(
				'label' => esc_html__( 'SVG Inline Code', 'kayo' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
			)
		);

		$this->add_control(
			'path_color',
			array(
				'label' => esc_html__( 'Path Color', 'kayo' ),
				'type'  => \Elementor\Controls_Manager::COLOR,
			)
		);

		$this->add_control(
			'anim_duration',
			array(
				'label' => esc_html__( 'Animation Duration (in seconds)', 'kayo' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			)
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		$svg                = $settings['inline_code'];
		$path_color         = $settings['path_color'];
		$animation_duration = $settings['animation_duration'];

		echo '<div class="nu-svg" data-path-color="' . esc_attr( $path_color ) . '" data-animation-duration="' . esc_attr( $animation_duration ) . '">';

		echo ( $svg ) ? $svg : $settings['inline_code'];

		echo '</div>';

	}
}
\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_Animated_SVG_Widget() );
