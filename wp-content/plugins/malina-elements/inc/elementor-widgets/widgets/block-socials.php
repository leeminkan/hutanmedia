<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon List Widget
 */
class Widget_ASW_block_socials extends Widget_Base {

	/**
	 * Retrieve icon list widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'malina-socials';
	}

	/**
	 * Retrieve icon list widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Malina Socials', 'malina-elements' );
	}

	/**
	 * Retrieve icon list widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-social-icons';
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
			'asw_section_socials',
			[
				'label' => __( 'Socials block', 'malina-elements' ),
			]
		);
		$id = rand(0, 9999);
		$this->add_control(
			'default_links',
			[
				'label' => esc_html__( 'Icons links', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => esc_html__( 'From Theme Options', 'malina-elements' ),
					'false' => esc_html__( 'Custom links', 'malina-elements' )
				],
				'default' => 'true',
			]
		);
		$socials_array = array('twitter', 'facebook', 'instagram', 'pinterest', 'skype', 'digg', 'google_plus', 'linkedin', 'vimeo', 'flickr', 'yahoo', 'tumblr', 'youtube', 'picasa', 'deviantart', 'behance', 'dribbble', 'paypal', 'delicious', 'forrst');
		foreach ($socials_array as $item) {
			$this->add_control(
				$item,
				[
					'label' => $item,
					'description' => esc_html__('Enter link to your social account. Leave empty to hide this link.', 'malina-elements'),
					'type' => Controls_Manager::TEXT,
					'default' => '',
					'condition' => [
						'default_links' => 'false'
					]
				]
			);
		}
		$this->add_control(
			'style',
			[
				'label' => esc_html__( 'Icons style', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'simple' => esc_html__( 'Simple', 'malina-elements' ),
					'simple_text' => esc_html__( 'Simple + Text', 'malina-elements' ),
					'circle' => esc_html__( 'Circle', 'malina-elements' ),
					'square' => esc_html__( 'Square', 'malina-elements' )
				],
				'default' => 'simple',
			]
		);
		$this->add_control(
			'icons_size',
			[
				'label' => esc_html__('Icons size in px', 'malina-elements'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 13,
				],
				'selectors' => [
					'{{WRAPPER}} .social-icons li a i' => 'font-size: {{SIZE}}px;',
				],
			]
		);
		$this->add_control(
			'icon_color',
			[
				'label' => esc_html__( 'Icon color initial', 'malina-elements' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .social-icons li a' => 'color: {{VALUE}};',
				],
			]
		);
		$this->add_control(
			'icon_color_hover',
			[
				'label' => esc_html__( 'Icon color hover', 'malina-elements' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .social-icons li a:hover' => 'color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'bg_color',
			[
				'label' => esc_html__( 'Icon background color', 'malina-elements' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'default' => '',
				'condition' => [
					'style' => array('circle', 'square')
				],
				'selectors' => [
					'{{WRAPPER}} .social-icons.square li a, {{WRAPPER}} .social-icons.circle li a' => 'background-color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'bg_color_hover',
			[
				'label' => esc_html__( 'Icon background color hover', 'malina-elements' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'default' => '',
				'condition' => [
					'style' => array('circle', 'square')
				],
				'selectors' => [
					'{{WRAPPER}} .social-icons.square li a:hover, {{WRAPPER}} .social-icons.circle li a:hover' => 'background-color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text color', 'malina-elements' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .social-icons li span' => 'background-color: {{VALUE}};',
				]
			]
		);
		$this->add_control(
			'icons_space',
			[
				'label' => esc_html__('Space between icons', 'malina-elements'),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 100,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 18,
				],
				'selectors' => [
					'{{WRAPPER}} .social-icons ul li:not(:last-child)' => 'margin-right: {{SIZE}}px;',
				],
			]
		);
		$this->add_control(
			'icons_align',
			[
				'label' => esc_html__( 'Align icons', 'malina-elements' ),
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
		echo do_shortcode('[malinasocials icon_color="'.$icon_color.'" style="'.$style.'" icon_color_hover="'.$icon_color_hover.'" bg_color="'.$bg_color.'" bg_color_hover="'.$bg_color_hover.'" text_color="'.$text_color.'" icons_align="'.$icons_align.'" twitter="'.$twitter.'" forrst="'.$forrst.'" dribbble="'.$dribbble.'" flickr="'.$flickr.'" facebook="'.$facebook.'" skype="'.$skype.'" digg="'.$digg.'" google_plus="'.$google_plus.'" linkedin="'.$linkedin.'" vimeo="'.$vimeo.'" instagram="'.$instagram.'" yahoo="'.$yahoo.'" tumblr="'.$tumblr.'" youtube="'.$youtube.'" picasa="'.$picasa.'" deviantart="'.$deviantart.'" behance="'.$behance.'" pinterest="'.$pinterest.'" paypal="'.$paypal.'" delicious="'.$delicious.'"]');
	}
}
