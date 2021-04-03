<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Widget_ASW_recent_posts extends Widget_Base {
	public function get_name() {
		return 'malina-recent-posts';
	}
	public function get_title() {
		return __( 'Malina Recent Posts', 'malina-elements' );
	}
	public function get_icon() {
		// Icon name from the Elementor font file, as per http://dtbaker.net/web-development/creating-your-own-custom-elementor-widgets/
		return 'eicon-post';
	}
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		wp_enqueue_script('owl-carousel');
		wp_enqueue_style( 'owl-carousel' );
		wp_enqueue_script('isotope');
		wp_enqueue_script('infinite-scroll');
		wp_enqueue_script('imagesloaded');
	}

	public function get_script_depends() {
		return [ 'owl-carousel', 'isotope', 'infinite-scroll', 'imagesloaded' ];
	}
	public function get_style_depends() {
		return [ 'owl-carousel' ];
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
				'label' => esc_html__( 'Malina Recent Posts', 'malina-elements' ),
			]
		);
		$this->add_control(
			'block_title',
			[
				'label' => esc_html__( 'Block title', 'malina-elements' ),
				'description' => esc_html__('Enter block title. Leave blank to hide.', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
			]
		);
		$this->add_control(
			'block_title_size',
			[
				'label' => esc_html__( 'Block title size', 'malina-elements' ),
				'options' => [
					'h1' => esc_html__('H1', 'malina-elements'),
					'h2' => esc_html__('H2', 'malina-elements'),
					'h3' => esc_html__('H3', 'malina-elements'),
					'h4' => esc_html__('H4', 'malina-elements'),
					'h5' => esc_html__('H5', 'malina-elements'),
					'h6' => esc_html__('H6', 'malina-elements'),
				],
				'type' => Controls_Manager::SELECT,
				'default' => 'h4',
			]
		);
		$this->add_control(
			'num',
			[
				'label' => esc_html__( 'Posts count', 'malina-elements' ),
				'description' => esc_html__('Enter number of post to display (Note: Enter -1 to display all posts).', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => '9',
			]
		);
		$this->add_control(
			'load_count',
			[
				'label' => esc_html__( 'Load more posts count', 'malina-elements' ),
				'description' => esc_html__('Enter number of posts to load (leave balnk to use the same value as per page).', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
			]
		);
		$this->add_control(
			'offset',
			[
				'label' => esc_html__( 'Posts offset', 'malina-elements' ),
				'description' => esc_html__('Enter the number of posts to offset before retrieval.', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
			]
		);
		$this->add_control(
			'columns',
			[
				'label' => esc_html__( 'Posts per row', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'description' => esc_html__('Select posts count per row. It works for simple and masonry style.', 'malina-elements'),
				'options' => [
					'span12' => esc_html__('One', 'malina-elements'),
					'span6' => esc_html__('Two', 'malina-elements'),
					'span4' => esc_html__('Three', 'malina-elements'),
					'span3' => esc_html__('Four', 'malina-elements'),
					'one_fifth' => esc_html__('Five', 'malina-elements'),
					'span2' => esc_html__('Six', 'malina-elements'),
				],
				'default' => 'span6',
			]
		);
		$this->add_control(
			'cat_slug',
			[
				'label' => __( 'Categories', 'malina-elements' ),
				'description' => esc_html__('This help you to retrieve items from specific category.', 'malina-elements'),
				'type' => Controls_Manager::SELECT2,
				'options' => malina_get_categories_select_option(),
				'default' => '',
				'multiple' => true
			]
		);
		$this->add_control(
			'post_ids',
			[
				'label' => __( 'Select posts to show', 'malina-elements' ),
				'description' => __('Leave empty to show recent posts.', 'malina-elements'),
				'type' => Controls_Manager::SELECT2,
				'options' => malina_get_all_posts(),
				'default' => '',
				'multiple' => true
			]
		);

		$this->add_control(
			'post__not_in',
			[
				'label' => __( 'Select posts to exclude', 'malina-elements' ),
				'description' => __('Select posts to exclude those records', 'malina-elements'),
				'type' => Controls_Manager::SELECT2,
				'options' => malina_get_all_posts(),
				'default' => '',
				'multiple' => true
			]
		);
		$this->add_control(
			'orderby',
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
					'post__in' => esc_html__('Preserve post ID order', 'malina-elements'),
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
			'post_style',
			[
				'label' => esc_html__( 'Posts view style', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'description' => esc_html__('Select posts style on preview.', 'malina-elements'),
				'options' => [
					'style_1' => esc_html__('Simple', 'malina-elements'),
					'style_2' => esc_html__('Featured', 'malina-elements'),
					'style_3' => esc_html__('Featured even/odd', 'malina-elements'),
					'style_4' => esc_html__('Masonry', 'malina-elements'),
					'style_5' => esc_html__('List', 'malina-elements'),
					'style_5_2' => esc_html__('List 2', 'malina-elements'),
					'style_6' => esc_html__('Sono', 'malina-elements'),
					'style_7' => esc_html__('EditorPick', 'malina-elements'),
					'style_8' => esc_html__('Walnuss', 'malina-elements'),
					'style_9' => esc_html__('Sticky style', 'malina-elements'),
					'style_10' => esc_html__('Boxed', 'malina-elements'),
				],
				'default' => 'style_1',
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
				'default' => 'medium',
			]
		);
		
		$this->add_control(
			'text_align',
			[
				'label' => esc_html__( 'Align elements', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'description' => esc_html__('Select position for text, meta info, categories, etc.', 'malina-elements'),
				'options' => [
					'textleft' => esc_html__( 'Left', 'malina-elements' ),
					'textcenter' => esc_html__( 'Center', 'malina-elements' ),
					'textright' => esc_html__( 'Right', 'malina-elements' ),
				],
				'default' => 'textcenter',
			]
		);
		$this->add_control(
			'excerpt_count',
			[
				'label' => esc_html__( 'Post excerpt count', 'malina-elements' ),
				'description' => esc_html__('Enter number of words in post excerpt. 0 to hide it.', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => '30',
			]
		);
		$this->add_control(
			'display_categories',
			[
				'label' => __( 'Display categories?', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => __( 'Show', 'malina-elements' ),
					'false' => __( 'Hide', 'malina-elements' ),
				],
				'default' => 'true',
			]
		);
		$this->add_control(
			'display_read_time',
			[
				'label' => __( 'Display reading time?', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => __( 'Show', 'malina-elements' ),
					'false' => __( 'Hide', 'malina-elements' ),
				],
				'default' => 'true',
			]
		);
		$this->add_control(
			'display_comments',
			[
				'label' => __( 'Display comments count?', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => __( 'Show', 'malina-elements' ),
					'false' => __( 'Hide', 'malina-elements' ),
				],
				'default' => 'false',
			]
		);
		$this->add_control(
			'display_date',
			[
				'label' => __( 'Display date label?', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => __( 'Show', 'malina-elements' ),
					'hover' => __( 'Show on hover', 'malina-elements' ),
					'false' => __( 'Hide', 'malina-elements' ),
				],
				'default' => 'true',
			]
		);
		$this->add_control(
			'display_views',
			[
				'label' => __( 'Display views?', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => __( 'Show', 'malina-elements' ),
					'false' => __( 'Hide', 'malina-elements' ),
				],
				'default' => 'true',
			]
		);
		$this->add_control(
			'display_likes',
			[
				'label' => __( 'Display likes?', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => __( 'Show', 'malina-elements' ),
					'false' => __( 'Hide', 'malina-elements' ),
				],
				'default' => 'true',
			]
		);
		$this->add_control(
			'show_readmore',
			[
				'label' => __( 'Show readmore', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => __( 'Show', 'malina-elements' ),
					'false' => __( 'Hide', 'malina-elements' ),
				],
				'default' => 'false',
			]
		);
		$this->add_control(
			'pagination',
			[
				'label' => esc_html__( 'Pagination', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => esc_html__( 'Load more', 'malina-elements' ),
					'standard' => esc_html__( 'Standard', 'malina-elements' ),
					'next_prev' => esc_html__( 'Prev/Next', 'malina-elements' ),
					'infinitescroll' => esc_html__( 'Infinite scroll', 'malina-elements' ),
					'false' => esc_html__( 'Disable', 'malina-elements' ),
				],
				'default' => 'standard',
			]
		);
		$this->add_control(
			'ignore_featured',
			[
				'label' => esc_html__( 'Disable featured posts style', 'malina-elements' ),
				'description' => esc_html__('Disable style for featured posts. Do not highlight them.', 'malina-elements'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => esc_html__( 'Enable', 'malina-elements' ),
					'false' => esc_html__( 'Disable', 'malina-elements' ),
				],
				'default' => 'false',
			]
		);
		$this->add_control(
			'ignore_sticky_posts',
			[
				'label' => esc_html__( 'Ignore sticky posts', 'malina-elements' ),
				'description' => esc_html__('Show sticky posts?', 'malina-elements'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => esc_html__( 'Enable', 'malina-elements' ),
					'false' => esc_html__( 'Disable', 'malina-elements' ),
				],
				'default' => 'true',
			]
		);
		$this->end_controls_section();
	}
	protected function render( $instance = [] ) {
		$settings = $this->get_settings();
		extract(shortcode_atts(array(
	    	'block_title' => '',
			'block_title_size' => 'h4',
	      	'num' => '6',
	      	'load_count' => '',
	      	'offset' => '',
	      	'columns' => 'span4',
	      	'post_style' => 'style_1',
	      	'orderby' => 'date',
	      	'order' => 'DESC',
	      	'cat_slug' => '',
	      	'post_ids' => '',
	      	'post__not_in' => '',
	      	'pagination' => 'false',
	      	'thumbsize'		=> 'post-thumbnail',
	      	'text_align' => 'textcenter',
	      	'excerpt_count'	=> '15',
	      	'display_categories' => 'true',
	      	'display_date' => 'true',
	      	'display_comments' => 'true',
	      	'display_views' => 'true',
	      	'display_likes' => 'true',
	      	'display_read_time' => 'true',
	      	'show_readmore' => 'false',
	      	'ignore_featured' => 'true',
	      	'ignore_sticky_posts' => 'false'
	    ), $settings));
	    $post_ids = $post_ids != '' ? $post_ids : array();
		$post_ids = implode(',', $post_ids);

		if( is_array($cat_slug) && !empty($cat_slug) ){
			$cat_slug = implode(',', $cat_slug);
		}

		$post__not_in = $post__not_in != '' ? $post__not_in : array();
		$post__not_in = implode(',', $post__not_in);
		$out = '[gridposts
		block_title="'.$block_title.'" 
		block_title_size="'.$block_title_size.'" 
		num="'.$num.'" 
		load_count="'.$load_count.'" 
		columns="'.$columns.'" 
		post_style="'.$post_style.'" 
		post_ids="'.$post_ids.'" 
		offset="'.$offset.'" 
		orderby="'.$orderby.'" 
		order="'.$order.'" 
		cat_slug="'.$cat_slug.'" 
		post__not_in="'.$post__not_in.'" 
		pagination="'.$pagination.'" 
		thumbsize="'.$thumbsize.'" 
		text_align="'.$text_align.'" 
		excerpt_count="'.$excerpt_count.'" 
		display_categories="'.$display_categories.'" 
		display_date="'.$display_date.'" 
		display_comments="'.$display_comments.'" 
		display_views="'.$display_views.'" 
		display_likes="'.$display_likes.'" 
		display_read_time="'.$display_read_time.'" 
		show_readmore="'.$show_readmore.'" 
		ignore_featured="'.$ignore_featured.'" 
		ignore_sticky_posts="'.$ignore_sticky_posts.'"]';
		echo shortcode_unautop(do_shortcode($out));
	}
}
?>