<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon List Widget
 */
class Widget_ASW_block_logo extends Widget_Base {

	/**
	 * Retrieve icon list widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'malina-logo';
	}

	/**
	 * Retrieve icon list widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Malina Logo', 'malina-elements' );
	}

	/**
	 * Retrieve icon list widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-logo';
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
			'asw_section_logo',
			[
				'label' => __( 'Logo', 'malina-elements' ),
			]
		);
		$this->add_control(
			'text_logo',
			[
				'label' => esc_html__('Text logo'),
				"description" => esc_html__("Leave blank to use your default logo.", 'malina-elements'), 
				'type' => Controls_Manager::TEXT,
				'default' => ''
			]
		);
		$this->add_control(
			'default_font',
			[
				'label' => esc_html__( 'Use default theme settings', 'malina-elements' ),
				"description" => esc_html__("Leave blank to use your default logo font.", 'malina-elements'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => esc_html__( 'Yes', 'malina-elements' ),
					'false' => esc_html__( 'No', 'malina-elements' )
				],
				'default' => 'true',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'malina-elements' ),
				'selector' => '{{WRAPPER}} .logo .logo_text',
				'condition' => [
					'default_font' => 'false'
				]
			]
		);
		$this->add_control(
			'logo_color',
			[
				'label' => esc_html__( 'Logo text color', 'malina-elements' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .logo .logo_text' => 'color: {{VALUE}};',
				],
				'condition' => [
					'default_font' => 'false'
				]
			]
		);
		$this->add_control(
			'custom_logo',
			[
				'label' => esc_html__('Logo image', 'malina-elements'),
				'description' => esc_html__('Leave blank to use your default logo.', 'malina-elements'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => '',
					'id' => ''
				],
			]
		);
		$this->add_control(
			'logo_width',
			[
				'label' => esc_html__('Logo image width'),
				"description" => esc_html__("Enter value, you can use px, %, em, etc.", 'malina-elements'), 
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .logo img' => 'width: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'logo_align',
			[
				'label' => esc_html__( 'Align logo', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'textleft' => esc_html__( 'Left', 'malina-elements' ),
					'textcenter' => esc_html__( 'Center', 'malina-elements' ),
					'textright' => esc_html__( 'Right', 'malina-elements' ),
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
		extract($settings);
		$out = '';
		$out .= '<div class="logo '.$logo_align.'">';
	        if( $custom_logo['id'] != '' ){
	        	$logo_image = wp_get_attachment_image_url( $custom_logo['id'], 'full' );
				$out .= '<a href="'.esc_url(home_url()).'/" class="logo_main"><img src="'.esc_url($logo_image).'" alt="'.esc_attr(get_bloginfo('name')).'" /></a>';
	        } elseif( $text_logo != '' ){
				$out .= '<a href="'.esc_url(home_url()).'/" class="logo_text">'.esc_attr($text_logo).'</a>';
	        } elseif( get_theme_mod('malina_media_logo','') != "" ) {
				$out .= '<a href="'.esc_url(home_url()).'/" class="logo_main"><img src="'.esc_url(get_theme_mod('malina_media_logo')).'" alt="'.esc_attr(get_bloginfo('name')).'" /></a>';
			} else {
				$out .= '<a href="'.esc_url(home_url()).'/" class="logo_text">'.esc_attr(get_bloginfo('name')).'</a>';
			}
		$out .= '</div>';
		echo $out;
	}
}
