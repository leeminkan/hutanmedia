<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon List Widget
 */
class Widget_ASW_google_map extends Widget_Base {

	/**
	 * Retrieve icon list widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'malina-google-map';
	}

	/**
	 * Retrieve icon list widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Malina Google Map', 'malina-elements' );
	}

	/**
	 * Retrieve icon list widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-google-maps';
	}

	/**
	 * Retrieve the list of categories the icon list widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'malina-elements' ];
	}

	/**
	 * Register icon list widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'asw_section_google_map',
			[
				'label' => __( 'Malina Google map', 'malina-elements' ),
			]
		);

		$this->add_control(
			'address',
			[
				'label' => esc_html__('Location', 'malina-elements'),
				'description' => esc_html__('Enter your location.', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Ontario, CA, USA'
			]
		);
		$this->add_control(
			'style',
			[
				'label' => esc_html__('Map style', 'malina-elements'),
				'description' => esc_html__('Select google map style.', 'malina-elements'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style1' => esc_html__('Blue water','malina-elements'),
					'style2' => esc_html__('Simple grayscale','malina-elements'),
					'style3' => esc_html__('Light monochrome','malina-elements'),
					'style4' => esc_html__('Dark theme','malina-elements'),
				],
				'default' => 'style1'
			]
		);
		$this->add_control(
			'marker_icon',
			[
				'label' => esc_html__('Map marker', 'malina-elements'),
				'description' => esc_html__('Select image for your map location icon. Leave blank to use default marker.', 'malina-elements'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'map_height',
			[
				'label' => esc_html__('Map height', 'malina-elements'),
				'description' => esc_html__('Enter your map height', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => ''
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Render icon list widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings();
		extract(shortcode_atts( array(
			'address' => 'Ontario, CA, USA',
	        'style' => 'style1',
	        'marker_icon' => '',
	        'map_height' => ''
		), $settings));
		echo do_shortcode('[malinagooglemap address="'.$address.'" style="'.$style.'" marker_icon="'.$marker_icon['id'].'" map_height="'.$map_height.'"]');
	}
}
