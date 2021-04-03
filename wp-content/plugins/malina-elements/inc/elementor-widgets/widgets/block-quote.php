<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon List Widget
 */
class Widget_ASW_block_quote extends Widget_Base {

	/**
	 * Retrieve icon list widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'malina-quote';
	}

	/**
	 * Retrieve icon list widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Malina Quote', 'malina-elements' );
	}

	/**
	 * Retrieve icon list widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-blockquote';
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
			'asw_section_quote',
			[
				'label' => __( 'Malina Quote', 'malina-elements' ),
			]
		);
		$this->add_control(
			'text',
			[
				'label' => esc_html__('Quote text', 'malina-elements'),
				'type' => Controls_Manager::TEXTAREA,
				'default' => 'Enter your quote text'
			]
		);
		$this->add_control(
			'cite',
			[
				'label' => esc_html__('Quote Author', 'malina-elements'),
				'description' => esc_html__('Leave empty if you need not.', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => ''
			]
		);
		$this->add_control(
			'style',
			[
				'label' => esc_html__('Quote style', 'malina-elements'),
				'description' => esc_html__('Please select form from "Contact form 7" plugin.', 'malina-elements'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style1' => esc_html__('Style 1', 'malina-elements'),
					'style2' => esc_html__('Style 2', 'malina-elements'),
					'style3' => esc_html__('Style 3', 'malina-elements'),
					'style4' => esc_html__('Style 4', 'malina-elements'),
					'style5' => esc_html__('Style 5', 'malina-elements'),
				],
				'default' => 'style1',
			]
		);
		$this->add_control(
			'text_position',
			[
				'label' => esc_html__('Select title size', 'malina-elements'),
				'description' => esc_html__('Please select title size.', 'malina-elements'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'textleft' => esc_html__('Left', 'malina-elements'),
					'textcenter' => esc_html__('Center', 'malina-elements'),
					'textright' => esc_html__('Right', 'malina-elements'),
				],
				'default' => 'textcenter',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'label' => __( 'Typography', 'malina-elements' ),
				'selector' => '{{WRAPPER}} blockquote',
			]
		);
		$this->add_control(
			'color',
			[
				'label' => esc_html__( 'Text color', 'malina-elements' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} blockquote' => 'color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'border_color',
			[
				'label' => esc_html__( 'Border color', 'malina-elements' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'default' => '',
				'condition' => [
					'style' => ['style4', 'style2', 'style5']
				],
				'selectors' => [
					'{{WRAPPER}} blockquote' => 'border-color: {{VALUE}} !important;',
					'{{WRAPPER}} blockquote.style4:before' => 'color: {{VALUE}} !important;',
				]
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
			'text' => '',
	      	'cite' => '',
	      	'style'=> 'style1',
	      	'text_position' => 'textcenter'
	    ), $settings));
		$out = '';
		echo shortcode_unautop(do_shortcode('[malinaquote text="'.$text.'" cite="'.$cite.'" style="'.$style.'" text_position="'.$text_position.'"]'));
	}
}
