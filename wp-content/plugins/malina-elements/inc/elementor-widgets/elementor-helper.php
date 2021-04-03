<?php
if ( ! defined( 'ABSPATH' ) ) exit;
// This file is pretty much a boilerplate WordPress plugin.
// It does very little except including wp-widget.php
global $revolutionslider;
$revolutionslider = array();
$revAliases = '';
if(class_exists('RevSlider')){
    $slider = new RevSlider();
	$arrSliders = $slider->getArrSliders();
	foreach($arrSliders as $revSlider) { 
		$revAliases .= $revSlider->getAlias().', ';
		$revolutionslider[$revSlider->getAlias()] = $revSlider->getTitle();
	}
}
class ElementorCustomElement {
	private static $instance = null;
	public static function get_instance() {
		if ( ! self::$instance )
			self::$instance = new self;
		return self::$instance;
	}
	public function init(){
		// Add New Elementor Categories
        add_action( 'elementor/elements/categories_registered', array( $this, 'add_elementor_category' ), 1 );
		add_action( 'elementor/widgets/widgets_registered', array( $this, 'widgets_registered' ) );
	}
	public function add_elementor_category()
    {
        \Elementor\Plugin::instance()->elements_manager->add_category( 'malina-elements', array(
            'title' => __( 'Malina Elements', 'malina-elements' ),
        ), 1 );
    }
	public function widgets_registered() {
		// We check if the Elementor plugin has been installed / activated.
		if ( defined( 'ELEMENTOR_PATH' ) && class_exists( 'Elementor\Widget_Base' ) ) {
			// get our own widgets up and running:
			// copied from widgets-manager.php

			if ( class_exists( 'Elementor\Plugin' ) ) {

				if ( is_callable( 'Elementor\Plugin', 'instance' ) ) {

					$elementor = \Elementor\Plugin::instance();
					if ( isset( $elementor->widgets_manager ) ) {
						if ( method_exists( $elementor->widgets_manager, 'register_widget_type' ) ) {
							$asw_widgets = array(
							'posts-slider',
							'recent-posts',
							'single-post',
							'block-category',
							'contactform',
							'block-sidebar',
							'subscribe',
							'block-socials',
							'block-instagram',
							'google-map',
							'block-teammember',
							'block-catinfo',
							'block-logo',
							'block-menu',
							'block-septitle',
							'block-quote',
							'block-posttitle',
							'block-videopopup',
							);
							foreach ( $asw_widgets as $widget_filename ) {
								$template_file = plugin_dir_path(__FILE__)."widgets/".$widget_filename.".php";
								if ( $template_file && is_readable( $template_file ) ) {
									$class_name = str_replace( '-', '_', $widget_filename );
									$class_name = 'Elementor\Widget_ASW_' . $class_name;
									include $template_file;
									\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new $class_name() );
								}
							}
							
						}
					}
				}
			}
		}
	}
}
ElementorCustomElement::get_instance()->init();
?>