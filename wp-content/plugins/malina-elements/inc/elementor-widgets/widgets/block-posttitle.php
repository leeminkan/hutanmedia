<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon List Widget
 */
class Widget_ASW_block_posttitle extends Widget_Base {

	/**
	 * Retrieve icon list widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'malina-posttitle';
	}

	/**
	 * Retrieve icon list widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Malina Post Title Block', 'malina-elements' );
	}

	/**
	 * Retrieve icon list widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-post-title';
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
			'asw_section_posttitle',
			[
				'label' => __( 'Post title block', 'malina-elements' ),
			]
		);
		$this->add_control(
			'default_font',
			[
				'label' => __( 'Title font', 'plugin-domain' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'Custom', 'malina-elements' ),
				'label_off' => esc_html__( 'Default', 'malina-elements' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'text_typography',
				'label' => __( 'Typography', 'malina-elements' ),
				'condition' => [
					'default_font' => ['yes']
				],
				'selector' => '{{WRAPPER}} .title h1',
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
		$title_pos = rwmb_meta('malina_post_title_position');
		if(!$title_pos){
			$title_pos = 'textcenter';
		}
		$out = '<header class="title '.esc_attr($title_pos).'">';
			$out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
			$out .= '<h1>'.get_the_title().'</h1>';
			if( get_theme_mod('malina_single_post_meta_date', true ) ) {
				$out .= '<div class="meta-date"><time datetime="'.esc_attr(date(DATE_W3C)).'">'.get_the_time(get_option('date_format')).'</time></div>';
			}
		$out .= '</header>';
		echo $out;
	}
}
