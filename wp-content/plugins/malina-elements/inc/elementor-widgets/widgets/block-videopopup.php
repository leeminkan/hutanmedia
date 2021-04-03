<?php
namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class Widget_ASW_block_videopopup extends Widget_Base {
	public function get_name() {
		return 'malina-video-popup';
	}
	public function get_title() {
		return __( 'Malina Video Popup', 'malina-elements' );
	}
	public function get_icon() {
		// Icon name from the Elementor font file, as per http://dtbaker.net/web-development/creating-your-own-custom-elementor-widgets/
		return 'eicon-lightbox';
	}
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		wp_enqueue_script('jquery.magnific-popup');
		wp_enqueue_style( 'magnific-popup' );
	}

	public function get_script_depends() {
	 return [ 'jquery.magnific-popup' ];
	}
	public function get_style_depends() {
	 return [ 'magnific-popup' ];
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
			'video_url',
			[
				'label' => esc_html__( 'Video url', 'malina-elements' ),
				'description' => esc_html__('Enter video url. Self-hosted video, from Youtube or Vimeo.', 'malina-elements'),
				'type' => Controls_Manager::TEXT,
				'default' => '',
			]
		);
		$this->add_control(
			'image_id',
			[
				'label' => esc_html__('Placeholder image', 'malina-elements'),
				'description' => esc_html__('Select image', 'malina-elements'),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
			]
		);
		$this->add_control(
			'thumbsize',
			[
				'label' => __( 'Placeholder image', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'description' => __('Select your image size.', 'malina-elements'),
				'options' => $imageSizes,
				'default' => 'medium',
			]
		);
		$this->end_controls_section();
	}
	protected function render() {
		$settings = $this->get_settings();
		extract(shortcode_atts(array(
	    	'video_url' => '',
	    	'image_id' => '',
	    	'thumbsize' => 'medium'
	    ), $settings));
		if($video_url != ''){
			$custom_js = 'jQuery(document).ready(function($){
				"use strict";
				$(\'.popup-video-link\').magnificPopup({
					disableOn: 100,
					type: \'iframe\',
					mainClass: \'mfp-fade\',
					removalDelay: 160,
					preloader: false,
					fixedContentPos: false
				});
				$(\'.popup-video-html5\').magnificPopup({
				  type:\'inline\',
				  midClick: true,
				  callbacks: {
				    open: function() {
				    },
				    close: function() {
				      $(this.content).find(\'video\')[0].pause();
				    }
				  }
				});
			});';
			wp_add_inline_script('jquery.magnific-popup', $custom_js);
			$out = '';
			$out .= '<div class="video-block">';
			$imageSrc = wp_get_attachment_image_url($image_id['id'], $thumbsize);
			$media_sites = array('youtube', 'vimeo');
			$check = false;
			foreach ($media_sites as $site) {
				if( strpos( $video_url, $site ) ){
					$check = true;
				}
			}
			if($check){
				$out .= '<a class="popup-video-link" href="'.esc_url($video_url).'">';
				$out .= '<div class="play-button"><i class="la la-play-circle-o"></i></div>';
				$out .= '<img class="placeholder-img" src="'.esc_url($imageSrc).'" alt="">';
				$out .= '</a>';
			} else {
				global $wp_embed;
				$out .= '<a class="popup-video-html5" href="#video-html5">';
				$out .= '<div class="play-button"><i class="la la-play-circle-o"></i></div>';
				$out .= '<img class="placeholder-img" src="'.esc_url($imageSrc).'" alt="">';
				$out .= '</a>';
				$out .= '<div id="video-html5" class="mfp-hide"><div class="video-container"><video controls src="'.esc_url($video_url).'"></video></div></div>';
			}
			$out .= '</div>';
			echo $out;
			if ( Plugin::$instance->editor->is_edit_mode() ) {
				echo '<script>'.$custom_js.'</script>';
			}
		}
	}
}
?>