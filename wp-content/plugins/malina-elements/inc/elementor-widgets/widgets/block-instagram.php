<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon List Widget
 */
class Widget_ASW_block_instagram extends Widget_Base {

	/**
	 * Retrieve icon list widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'malina-instagram';
	}

	/**
	 * Retrieve icon list widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Malina instagram', 'malina-elements' );
	}

	/**
	 * Retrieve icon list widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-instagram-gallery';
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
			'asw_section_instagram',
			[
				'label' => __( 'Instagram block', 'malina-elements' ),
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__('Title', 'malina-elements'),
				'description' => esc_html__('Enter title for instagram. Leave blank to hide.', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => ''
			]
		);
		$this->add_control(
			'access_token',
			[
				'label' => esc_html__('Access Token Key', 'malina-elements'),
				'description' => '<a target="_blank" href="https://www.instagram.com/oauth/authorize?app_id=423965861585747&redirect_uri=https://api.smashballoon.com/instagram-basic-display-redirect.php&response_type=code&scope=user_profile,user_media&state=https://malina.artstudioworks.net/auth/?">'.esc_html__('Get your Access Token','malina-elements').'</a>',
				'type' => Controls_Manager::TEXT,
				'default' => get_theme_mod('malina_footer_instagram_access_token', ''),
			]
		);
		$this->add_control(
			'pics',
			[
				'label' => esc_html__('Items count', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => '6'
			]
		);
		$this->add_control(
			'pics_per_row',
			[
				'label' => esc_html__( 'Items per row', 'malina-elements' ),
				'description' => __('Max items count is 20.', 'malina-elements'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( 'One per row', 'malina-elements' ),
					'2' => esc_html__( 'Two per row', 'malina-elements' ),
					'3' => esc_html__( 'Three per row', 'malina-elements' ),
					'4' => esc_html__( 'Four per row', 'malina-elements' ),
					'5' => esc_html__( 'Five per row', 'malina-elements' ),
					'6' => esc_html__( 'Six per row', 'malina-elements' ),
				],
				'default' => '3',
			]
		);
		$this->add_control(
			'hide_link',
			[
				'label' => esc_html__( 'Follow link', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => esc_html__( 'Hide', 'malina-elements' ),
					'false' => esc_html__( 'Show', 'malina-elements' )
				],
				'default' => 'true',
			]
		);
		$this->add_control(
			'item_link',
			[
				'label' => esc_html__( 'Link image to:', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => esc_html__( 'Lightbox', 'malina-elements' ),
					'2' => esc_html__( 'Link to instagram', 'malina-elements' )
				],
				'default' => '1',
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
		echo do_shortcode('[malinainstagram item_link="'.$item_link.'" hide_link="'.$hide_link.'" pics_per_row="'.$pics_per_row.'" pics="'.$pics.'" access_token="'.$access_token.'" title="'.$title.'"]');
	}
}
