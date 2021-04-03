<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon List Widget
 */
class Widget_ASW_contactform extends Widget_Base {

	/**
	 * Retrieve icon list widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'malina-contactform';
	}

	/**
	 * Retrieve icon list widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Malina Contact Form', 'malina-elements' );
	}

	/**
	 * Retrieve icon list widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-form-horizontal';
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
			'asw_section_contactform',
			[
				'label' => __( 'Malina ContactForm', 'malina-elements' ),
			]
		);
		$this->add_control(
			'contactform',
			[
				'label' => esc_html__('Select form to display', 'malina-elements'),
				'description' => esc_html__('Please select form. It works with WPForms and Contact Form 7', 'malina-elements'),
				'type' => Controls_Manager::SELECT,
				'options' => malina_get_contact_form7_forms(),
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
		$out = '';
		if(post_type_exists('wpforms')){
			$out = '[wpforms id="'.$settings['contactform'].'"]';
		} elseif(post_type_exists('wpcf7_contact_form')) {
			$out = '[contact-form-7 id="'.$settings['contactform'].'"]';
		}
		if($out != ''){
			echo do_shortcode($out);
		} else {
			echo esc_html__('You need to install&activate "WPForms" or "Contact Form 7" plugin, then create form.', 'malina-elements');
		}
	}
}
