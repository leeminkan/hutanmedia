<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Widget_ASW_slider extends Widget_Base {
	public function get_name() {
		return 'malina-slider';
	}

	public function get_title() {
		return __( 'Revolution Slider', 'malina-elements' );
	}

	public function get_icon() {
		return 'eicon-slideshow';
	}

	public function get_categories() {
		return [ 'malina-elements' ];
	}

	protected function _register_controls() {
		global $revolutionslider;
		$this->start_controls_section(
			'section_revslider',
			[
				'label' => esc_html__( 'Revolution Slider', 'malina-elements' ),
			]
		); 

		if(!empty($revolutionslider)){
			$this->add_control(
				'select_revslider',
				[
					'label' => __( 'Select slider', 'malina-elements' ),
					'type' => Controls_Manager::SELECT,
					'default' => 'none',
					'options' => $revolutionslider,
					'description' => esc_html__('Create your slider in Revolution Slider plugin, before select it.', 'malina-elements'),
				]
			);
		} else {
			$this->add_control(
				'none_revslider',
				[
					'label' => esc_html__('Revolution Slider plugin is required!', 'malina-elements'),
					'type' => Controls_Manager::HEADING,
				]
			);
		}
		$this->end_controls_section();

	}
	protected function render() {
		$settings = $this->get_settings();
		// get our input from the widget settings.
		$rs_alias = ! empty( $settings['select_revslider'] ) ? $settings['select_revslider'] : '';
		if($rs_alias != ''){
			echo do_shortcode('[rev_slider alias="'.$rs_alias.'"][/rev_slider]');
		} else {
			echo esc_html__('Revolution Slider plugin is required!');
		}
	}
}
?>