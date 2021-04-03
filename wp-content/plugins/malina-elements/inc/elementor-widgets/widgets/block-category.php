<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon List Widget
 */
class Widget_ASW_block_category extends Widget_Base {

	/**
	 * Retrieve icon list widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'malina-category';
	}

	/**
	 * Retrieve icon list widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Malina Category', 'malina-elements' );
	}

	/**
	 * Retrieve icon list widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-folder';
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
			'asw_section_category',
			[
				'label' => __( 'Malina Category Block', 'malina-elements' ),
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__('Title', 'malina-elements'),
				'description' => esc_html__('Input button title', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => 'Read More'
			]
		);
		$this->add_control(
			'cat_url',
			[
				'label' => esc_html__('Button URL', 'malina-elements'),
				'description' => esc_html__('Enter button URL.', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => ''
			]
		);
		$this->add_control(
			'bg_image',
			[
				'label' => esc_html__('Select image', 'malina-elements'),
				'description' => esc_html__('Select image for block.', 'malina-elements'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src()
				],
			]
		);
		$this->add_control(
			'image_height',
			[
				'label' => esc_html__('Image height', 'malina-elements'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'size-portrait' => esc_html__('Portrait', 'malina-elements'),
					'size-landscape' => esc_html__('Landscape', 'malina-elements')
				],
				'default' => 'size-portrait',
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
			'title' => 'Read more',
	      	'bg_image' => '',
	      	'cat_url' => '#',
	      	'image_height' => 'size-portrait'
			), $settings));
		$mediaid = $settings['bg_image']['id'];
		$mediaurl = $settings['bg_image']['url'];

		echo do_shortcode('[malinacategory title="'.$title.'" cat_url="'.$cat_url.'" mediaid="'.$mediaid.'" mediaurl="'.$mediaurl.'" image_height="'.$image_height.'"]');
	}
}
