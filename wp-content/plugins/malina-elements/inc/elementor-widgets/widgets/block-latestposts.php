<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Widget_ASW_latest_posts extends Widget_Base {
	public function get_name() {
		return 'malina-latest-posts';
	}
	public function get_title() {
		return __( 'Malina Widget Latest Posts', 'malina-elements' );
	}
	public function get_icon() {
		// Icon name from the Elementor font file, as per http://dtbaker.net/web-development/creating-your-own-custom-elementor-widgets/
		return 'eicon-post';
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
			'section_latest_posts',
			[
				'label' => esc_html__( 'Malina Widget Latest Posts', 'malina-elements' ),
			]
		);
		$this->add_control(
			'title',
			[
				'label' => esc_html__( 'Title', 'malina-elements' ),
				'description' => esc_html__('Enter title. Leave blank to hide.', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
			]
		);
		$this->add_control(
			'layout',
			[
				'label' => esc_html__( 'Layout', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'list' => esc_html__('Simple list', 'malina-elements'),
					'thumb' => esc_html__('Thumbnail & title', 'malina-elements')
				],
				'default' => 'list',
			]
		);
		$this->add_control(
			'number',
			[
				'label' => esc_html__( 'Posts count', 'malina-elements' ),
				'description' => esc_html__('Enter number of post to display (Note: Enter -1 to display all posts).', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => '9',
			]
		);
		$this->add_control(
			'excerpt_count',
			[
				'label' => esc_html__( 'How many words show?', 'malina-elements' ),
				'type' => Controls_Manager::TEXT,
				'default' => '6',
			]
		);
		$this->add_control(
			'order_by',
			[
				'label' => esc_html__( 'Order by', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'description' => esc_html__('Select how to sort retrieved posts.', 'malina-elements'),
				'options' => [
					'date' => esc_html__('Date', 'malina-elements'),
					'modified' => esc_html__('Last modified date', 'malina-elements'),
					'comment_count' => esc_html__('Popularity', 'malina-elements'),
					'title' => esc_html__('Title', 'malina-elements'),
					'rand' => esc_html__('Random', 'malina-elements'),
				],
				'default' => 'date',
			]
		);

		$this->add_control(
			'order',
			[
				'label' => esc_html__( 'Posts Order', 'malina-elements' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'DESC' => [
						'title' => esc_html__( 'descending', 'malina-elements' ),
						'icon' => 'fa fa-sort-amount-desc',
					],
					'ASC' => [
						'title' => esc_html__( 'ascending', 'malina-elements' ),
						'icon' => 'fa fa-sort-amount-asc',
					],
				],
				'default' => 'DESC',
			]
		);
		$this->add_control(
			'category_show',
			[
				'label' => esc_html__( 'Show category?', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'show' => esc_html__('Show', 'malina-elements'),
					'hide' => esc_html__('Hide', 'malina-elements')
				],
				'default' => 'hide',
			]
		);
		$this->add_control(
			'meta_info',
			[
				'label' => esc_html__( 'Show meta info?', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'show' => esc_html__('Show', 'malina-elements'),
					'hide' => esc_html__('Hide', 'malina-elements')
				],
				'default' => 'show',
			]
		);
		$this->add_control(
			'img_style',
			[
				'label' => esc_html__( 'Image style', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'default' => esc_html__( 'Default', 'malina-elements' ),
					'rounded' => esc_html__( 'Rounded', 'malina-elements' ),
					'circle' => esc_html__( 'Circle', 'malina-elements' ),
				],
				'default' => 'default',
			]
		);
		$this->end_controls_section();
	}
	protected function render( $instance = [] ) {
		$settings = $this->get_settings();
		extract(shortcode_atts(array(
	    	'title' => '',
	    	'number' => 3,
	    	'excerpt_count'=> 6,
	    	'order_by' => 'date',
	    	'order'=>'DESC',
	    	'layout'=>'list',
	    	'meta_info' => 'show',
	    	'category_show' => 'hide',
	    	'img_style' => 'default'
	    ), $settings));
		$out = '[malinarecentposts title="'.$title.'" number="'.$number.'" excerpt_count="'.$excerpt_count.'" order_by="'.$order_by.'" order="'.$order.'" layout="'.$layout.'" meta_info="'.$meta_info.'" category_show="'.$category_show.'" img_style="'.$img_style.'"]';
		echo shortcode_unautop(do_shortcode($out));
	}
}
?>