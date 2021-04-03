<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon List Widget
 */
class Widget_ASW_block_septitle extends Widget_Base {

	/**
	 * Retrieve icon list widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'malina-septitle';
	}

	/**
	 * Retrieve icon list widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Malina Title Separator', 'malina-elements' );
	}

	/**
	 * Retrieve icon list widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-animated-headline';
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
			'asw_section_separatortitle',
			[
				'label' => __( 'Malina Title Separator', 'malina-elements' ),
			]
		);
		$this->add_control(
			'title_text',
			[
				'label' => esc_html__('Title', 'malina-elements'),
				'description' => esc_html__('Enter your title', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Title text'
			]
		);
		$this->add_control(
			'title_size',
			[
				'label' => esc_html__('Select title size', 'malina-elements'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => esc_html__('H1', 'malina-elements'),
					'h2' => esc_html__('H2', 'malina-elements'),
					'h3' => esc_html__('H3', 'malina-elements'),
					'h4' => esc_html__('H4', 'malina-elements'),
					'h5' => esc_html__('H5', 'malina-elements'),
					'h6' => esc_html__('H6', 'malina-elements'),
				],
				'default' => 'h3',
			]
		);
		$this->add_control(
			'title_position',
			[
				'label' => esc_html__('Select title alignment', 'malina-elements'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'textleft' => esc_html__('Left', 'malina-elements'),
					'textcenter' => esc_html__('Center', 'malina-elements'),
					'textright' => esc_html__('Right', 'malina-elements'),
				],
				'default' => 'textcenter',
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
		extract(shortcode_atts(array(
			'title_text' => '',
	      	'title_size' => 'h3',
	      	'title_position' => 'textcenter'
	    ), $settings));
		$out = '';
		echo shortcode_unautop(do_shortcode('[malinaseparatortitle text="'.$title_text.'" size="'.$title_size.'" position="'.$title_position.'"]'));
	}
}
