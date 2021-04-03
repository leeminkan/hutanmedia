<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Widget_ASW_single_post extends Widget_Base {
	public function get_name() {
		return 'malina-single-post';
	}
	public function get_title() {
		return __( 'Malina Single Post', 'malina-elements' );
	}
	public function get_icon() {
		// Icon name from the Elementor font file, as per http://dtbaker.net/web-development/creating-your-own-custom-elementor-widgets/
		return 'eicon-image-box';
	}
	/**
	 * Retrieve the list of categories the accordion widget belongs to.
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
	protected function _register_controls() {

		$this->start_controls_section(
			'section_recent_posts',
			[
				'label' => esc_html__( 'Malina Single Post', 'malina-elements' ),
			]
		);
		
		$this->add_control(
			'post_id',
			[
				'label' => __( 'Select posts to show', 'malina-elements' ),
				'description' => __('Leave empty to show recent posts.', 'malina-elements'),
				'type' => Controls_Manager::SELECT2,
				'options' => malina_get_all_posts(),
				'default' => '',
				'multiple' => false
			]
		);

		$imageSizes = get_intermediate_image_sizes();
		$imageSizes[]= 'full';
		$imageSizes = array_combine($imageSizes, $imageSizes);
		$this->add_control(
			'thumbsize',
			[
				'label' => __( 'Image size', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'description' => esc_html__('Select your image size to use in post.', 'malina-elements'),
				'options' => $imageSizes,
				'default' => 'full',
			]
		);
		$this->add_control(
			'show_categories',
			[
				'label' => __( 'Show meta categories?', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => __( 'Show', 'malina-elements' ),
					'false' => __( 'Hide', 'malina-elements' ),
				],
				'default' => 'true',
			]
		);
		$this->end_controls_section();
	}
	protected function render( $instance = [] ) {
		$settings = $this->get_settings();
		extract(shortcode_atts(array(
	      	'post_id' => '',
	      	'thumbsize'	=> 'post-thumbnail',
	      	'show_categories' => 'true'
	    ), $settings));
		echo do_shortcode('[singlepost post_ids="'.$post_id.'" thumbsize="'.$thumbsize.'" show_categories="'.$show_categories.'"]');
	}
}
?>