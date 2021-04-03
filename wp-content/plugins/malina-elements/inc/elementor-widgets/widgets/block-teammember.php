<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon List Widget
 */
class Widget_ASW_block_teammember extends Widget_Base {

	/**
	 * Retrieve icon list widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'malina-teammember';
	}

	/**
	 * Retrieve icon list widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Malina Team Member', 'malina-elements' );
	}

	/**
	 * Retrieve icon list widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-user-circle-o';
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
			'asw_section_teammember',
			[
				'label' => __( 'Malina Team Member', 'malina-elements' ),
			]
		);
		$this->add_control(
			'name',
			[
				'label' => esc_html__('Name', 'malina-elements'),
				'description' => esc_html__('Please enter member name.', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => ''
			]
		);
		$this->add_control(
			'image_id',
			[
				'label' => esc_html__('Member image', 'malina-elements'),
				'description' => esc_html__('Select image', 'malina-elements'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'position',
			[
				'label' => esc_html__('Position', 'malina-elements'),
				'description' => esc_html__('Please enter member position.', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => ''
			]
		);
		$this->add_control(
			'url',
			[
				'label' => esc_html__('Url', 'malina-elements'),
				'description' => esc_html__('Please enter url if you need.', 'malina-elements'),
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
			'name' => '',
			'position' => '',
			'image_id' => '',
			'url' => '',
			'image_height' => 'size-portrait'
		), $settings));
		echo do_shortcode('[malinateam name="'.$name.'" position="'.$position.'" image_id="'.$image_id['id'].'" url="'.$url.'"]');
	}
}
