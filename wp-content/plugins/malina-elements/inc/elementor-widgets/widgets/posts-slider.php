<?php
namespace Elementor;
use WP_Query as WP_Query;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Widget_ASW_posts_slider extends Widget_Base {
	public function get_name() {
		return 'malina-slider-posts';
	}
	public function get_title() {
		return __( 'Malina posts slider', 'malina-elements' );
	}
	public function get_icon() {
		// Icon name from the Elementor font file, as per http://dtbaker.net/web-development/creating-your-own-custom-elementor-widgets/
		return 'eicon-slider-album';
	}
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		wp_enqueue_script('owl-carousel');
		wp_enqueue_style( 'owl-carousel' );
	}

	public function get_script_depends() {
	 return [ 'owl-carousel' ];
	}
	public function get_style_depends() {
	 return [ 'owl-carousel' ];
	}
	/**
	 * Whether the reload preview is required or not.
	 *
	 * Used to determine whether the reload preview is required.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return bool Whether the reload preview is required.
	 */
	public function is_reload_preview_required() {
		return true;
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
		$imageSizes = get_intermediate_image_sizes();
		$imageSizes[]= 'full';
		$imageSizes = array_combine($imageSizes, $imageSizes);
		$this->start_controls_section(
			'section_posts_slider',
			[
				'label' => esc_html__( 'Malina Posts Slider', 'malina-elements' ),
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
			'number_posts',
			[
				'label' => __( 'Slider count', 'malina-elements' ),
				'description' => __('Enter number of slides to display (Note: Enter -1 to display all slides).', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => '3',
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
			'cat_slug',
			[
				'label' => __( 'Select categories to show', 'malina-elements' ),
				'type' => Controls_Manager::SELECT2,
				'options' => malina_get_categories_select_option(),
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
			'thumbsize',
			[
				'label' => __( 'Image size', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'description' => __('Select your image size to use in slider.', 'malina-elements'),
				'options' => $imageSizes,
				'default' => 'malina-slider',
			]
		);
		$this->add_control(
			'style',
			[
				'label' => __( 'Slider Style', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'simple' => __('Simple', 'malina-elements'),
					'center' => __('Centered', 'malina-elements'),
					'center2' => __('Two Centered3', 'malina-elements'),
					'two_per_row' => __('Two in row', 'malina-elements'),
					'three_per_row' => __('Three in row', 'malina-elements')
				],
				'default' => 'simple',
			]
		);
		$this->add_control(
			'description_style',
			[
				'label' => __( 'Description Style', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'style_1' => __('Style 1', 'malina-elements'),
					'style_2' => __('Style 2', 'malina-elements'),
					'style_3' => __('Style 3', 'malina-elements'),
					'style_4' => __('Style 4', 'malina-elements'),
					'style_5' => __('Style 5', 'malina-elements'),
					'style_6' => __('Style 6', 'malina-elements'),
					'style_7' => __('Style 7', 'malina-elements'),
				],
				'default' => 'style_1',
			]
		);
		$this->add_control(
			'overlay',
			[
				'label' => __( 'Overlay', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => __( 'Show', 'malina-elements' ),
					'false' => __( 'Hide', 'malina-elements' ),
				],
				'default' => 'true',
			]
		);
		$this->add_control(
			'slideshow',
			[
				'label' => __( 'Autoplay', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => __( 'Enable', 'malina-elements' ),
					'false' => __( 'Disable', 'malina-elements' ),
				],
				'default' => 'true',
			]
		);
		$this->add_control(
			'mousewheel',
			[
				'label' => __( 'Scroll on mousewheel', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => __( 'Enable', 'malina-elements' ),
					'false' => __( 'Disable', 'malina-elements' ),
				],
				'default' => 'false',
			]
		);
		$this->add_control(
			'loop',
			[
				'label' => __( 'Loop', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => __( 'Enable', 'malina-elements' ),
					'false' => __( 'Disable', 'malina-elements' ),
				],
				'default' => 'false',
			]
		);
		$this->add_control(
			'nav',
			[
				'label' => __( 'Slider arrows', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => __( 'Enable', 'malina-elements' ),
					'false' => __( 'Disable', 'malina-elements' ),
				],
				'default' => 'false',
			]
		);
		$this->add_control(
			'show_dots',
			[
				'label' => __( 'Slider bullets', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => __( 'Enable', 'malina-elements' ),
					'false' => __( 'Disable', 'malina-elements' ),
				],
				'default' => 'true',
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
		$this->add_control(
			'show_date',
			[
				'label' => __( 'Show date', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => __( 'Show', 'malina-elements' ),
					'false' => __( 'Hide', 'malina-elements' ),
				],
				'default' => 'false',
			]
		);
		$this->end_controls_section();
	}
	protected function render() {
		$settings = $this->get_settings();
		wp_enqueue_script('owl-carousel');
		wp_enqueue_style( 'owl-carousel' );
		extract(shortcode_atts(array(
	    	'block_title' => '',
			'block_title_size' => 'h4',
	    	'slideshow' => 'true',
	    	'loop' => 'false',
	      	'number_posts' => '3',
	      	'orderby' => 'date',
	      	'order' => 'DESC',
	      	'thumbsize' => 'large',
	      	'description_style' => 'style_1',
	      	'cat_slug' => '',
	      	'post_ids' => '',
	      	'style' => '',
	      	'shadow' => 'true',
	      	'nav' => 'false',
	      	'mousewheel' => 'false',
	      	'overlay' => 'true',
	      	'overlay_color' => '',
	      	'show_categories' => 'true',
	      	'show_date' => 'true',
	      	'show_dots' => 'true',
	      	'slider_width' => 'standard'
	    ), $settings));
	    if(!$slideshow){
	    	$slideshow = 'false';
	    }
	    global $post;
		if ( is_front_page() ) {
			$paged = (get_query_var('page')) ? get_query_var('page') : 1;
		} else {
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		}
		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $number_posts,
			//'paged' => $paged,
			'order'          => $order,
			'orderby'        => $orderby,
			'post_status'    => 'publish',
			'ignore_sticky_posts' => true,
			'meta_query' => array(
		        array(
		         'key' => '_thumbnail_id',
		         'compare' => 'EXISTS'
		        ),
		    )
		);
		if( !is_array($post_ids) ){
			$post_ids = str_replace(' ', '', $post_ids);
			$post_ids = explode(',', $post_ids);
		} elseif($post_ids == ''){
			$post_ids = array();
		} else {
			$args['post__in'] = $post_ids;
		}
		if(!empty($cat_slug))
			$cat_slug = implode(',', $cat_slug);
		if($cat_slug != '' && $cat_slug != 'all'){
			$str = $cat_slug;
			$arr = explode(',', $str);	  
			$args['tax_query'][] = array(
			  'taxonomy'  => 'category',
			  'field'   => 'slug',
			  'terms'   => $arr
			);
		}
		if($shadow == 'true'){
			$shadow = '';
		} else {
			$shadow = ' disable-shadow';
		}
		if( $description_style == 'style_6'){
			$style = 'two_per_row';
		}
		
		if( $style == 'center' ){
			$center = $loop = 'true';
			$items = '2';
			$margin = '35';
			$centerClass = 'post-slider-center';

		} elseif( $style == 'center2' ){
			$center = 'true';
			$items = '2';
			$margin = '0';
			$loop = 'true';
			$overlay = $show_date = 'false';
			$thumbsize = 'malina-masonry';
			$centerClass = 'post-slider-center';
			$description_style = 'style_4';

		} elseif ($style == 'three_per_row') {
			$center = 'false';
			$items = '3';
			$margin = '10';
			if($slider_width == 'fullwidth'){
				$margin = '25';
			}
			$centerClass = 'slider-three-per-row';
		} elseif ($style == 'two_per_row') {
			$center = 'false';
			$items = '2';
			$centerClass = '';
			$margin = '25';
			if($slider_width == 'fullwidth'){
				$centerClass = 'post-slider-fullwidth';
			}
		} else {
			$center = 'false';
			$items = '1';
			$centerClass = '';
			$margin = '0';
			if($slider_width == 'fullwidth'){
				$centerClass = 'post-slider-fullwidth';
			}
		}
		if( $overlay == 'true' && $overlay_color !== '' ){
			$overlay_css = 'style="background-color:'.$overlay_color.';"';
		} else {
			$overlay_css = '';
		}
		$navText = '[\'<i class="la la-arrow-left"></i>\',\'<i class="la la-arrow-right"></i>\']';
		if( $description_style == 'style_6'){
			$margin = '50';
			$navText = '[\'<i class="la la-angle-left"></i>\',\'<i class="la la-angle-right"></i>\']';
		}
		if( $description_style == 'style_7' ){
			$margin = '100';
			$navText = '[\'<i class="la la-arrow-left"></i>\',\'<i class="la la-arrow-right"></i>\']';
			$overlay = 'false';
		}
		static $slider_id = 0;
		$out = '';
		$the_query = new WP_Query( $args );
		if( $the_query->have_posts() ) {
			$owl_custom = 'jQuery(document).ready(function($){
				"use strict";
				setTimeout(function(){
					var owl = $("#post-slider-'.++$slider_id.'").owlCarousel(
				    {
				        items: '.$items.',
				        center: '.$center.',
				        margin: '.$margin.',
				        dots: '.$show_dots.',
				        nav: '.$nav.',
				        navText: '.$navText.',
				        autoplay: '.$slideshow.',
				        responsiveClass:true,
				        loop: '.$loop.',
				        smartSpeed: 450,
				        autoHeight: false,
				        autoWidth:'.$center.',
				        themeClass: "owl-post-slider",';
				    if($style == 'three_per_row'){
				    	$owl_custom .= 'responsive:{
				            0:{
				                items:1,
				            },
				            782:{
				                items:2,
				            },
				            960:{
				                items:3
				            }
				        }';
				    }
				    if($style == 'two_per_row'){
				    	$owl_custom .= 'responsive:{
				            0:{
				                items:1,
				            },
				            480:{
				                items:1,
				            },
				            782:{
				                items:2,
				            },
				            960:{
				                items:2
				            }
				        }';
				    }
				    $owl_custom .= '});';
				    if($mousewheel == 'true'){
				    	$owl_custom .= 'document.querySelector(".owl-stage").addEventListener(\'wheel\', function(event){
							event.preventDefault();
							if (event.deltaY > 0){ owl.trigger(\'next.owl\'); }
							else if (event.deltaY < 0){ owl.trigger(\'prev.owl\'); }
						});';
					}
				$owl_custom .= '}, 100);
				
			});';
			wp_add_inline_script('owl-carousel', $owl_custom);
			if( $block_title != ''){
				$out .= '<'.$block_title_size.' class="block_title">'.esc_html($block_title).'</'.$block_title_size.'>';
			}
			$out .= '<div id="post-slider-'.$slider_id.'" class="owl-carousel post-slider '.$style.' '.$centerClass.' '.$slider_width.' post_more_'.$description_style.'">';
			static $post_count = 0;
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				$post_count++;
				if( $the_query->current_post +1 == $the_query->post_count && $the_query->post_count % 2 != 0 ){
					$last = ' last-one';
				} else {
					$last = '';
				}
				if( $style == 'center2' && $post_count == 1 ){

					$out .= '<div class="post-slider-double-item'.$last.'">';
				}
				$out .= '<div class="post-slider-item">';
					if( has_post_thumbnail() ) {
						$out .= '<figure class="post-img"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark">';
						if( $overlay == 'true' ){
							$out .= '<div class="overlay" '.$overlay_css.'></div>';
						}
						$out .= get_the_post_thumbnail($post->ID, $thumbsize).'</a></figure>';
					}
					$out .= '<div class="post-more '.$description_style.$shadow.'">';
					$out .= '<div class="post-more-inner">';
						if( $description_style == 'style_7' ){
							if( $show_date == 'true' ){
								$out .= '<div class="meta-date"><time datetime="'.esc_attr(date(DATE_W3C)).'">'.get_the_time(get_option('date_format')).'</time></div>';
							}
							$out .= '<h3><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina-elements').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark"><span>'.esc_attr(get_the_title()).'</span></a></h3>';
							if( $show_categories == 'true' ){
								$out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
							}
						} else {
							if( $show_categories == 'true' ){
								$out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
							}
							$out .= '<h3><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina-elements').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark"><span>'.esc_attr(get_the_title()).'</span></a></h3>';
							if( $show_date == 'true' ){
								$out .= '<div class="meta-date"><time datetime="'.esc_attr(date(DATE_W3C)).'">'.get_the_time(get_option('date_format')).'</time></div>';
							}
						}
					$out .= '</div>';
					$out .= '</div>';
				$out .= '</div>';
				if( $style == 'center2' && ( $post_count == 2 || $last == ' last-one' ) ){
					$out .= '</div>';
					$post_count = 0;
				}
			}
			$out .= '</div>';
		}
		wp_reset_postdata();
		echo $out;
		if ( Plugin::$instance->editor->is_edit_mode() ) {
			echo '<script>'.$owl_custom.'</script>';
		}
	}
}
?>