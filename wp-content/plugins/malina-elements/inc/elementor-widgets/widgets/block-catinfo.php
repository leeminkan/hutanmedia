<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon List Widget
 */
class Widget_ASW_block_catinfo extends Widget_Base {

	/**
	 * Retrieve icon list widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'malina-category-info';
	}

	/**
	 * Retrieve icon list widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Malina Categories Info', 'malina-elements' );
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
			'asw_section_catinfo',
			[
				'label' => __( 'Malina Categories Info', 'malina-elements' ),
			]
		);

		$options = array();
	    $query1 = get_terms( 'category' );
	    if( $query1 ){
	        foreach ( $query1 as $post ) {
	            $options[ $post->slug ] = $post->name;
	        }
	    }
		$this->add_control(
			'categories',
			[
				'label' => esc_html__('Categories', 'malina-elements'),
				'description' => esc_html__('Select categories to show.', 'malina-elements'),
				'type' => Controls_Manager::SELECT2,
				'options' => $options,
				'default' => '',
				'multiple' => true
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
			'categories' => ''
		), $settings));
		$categories = implode(',', $categories);
		echo do_shortcode('[malinacatinfo categories="'.$categories.'"]');
	}
}
