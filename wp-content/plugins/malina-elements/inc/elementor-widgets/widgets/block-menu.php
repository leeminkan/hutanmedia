<?php
namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Icon List Widget
 */
class Widget_ASW_block_menu extends Widget_Base {

	/**
	 * Retrieve icon list widget name.
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'malina-menu';
	}

	/**
	 * Retrieve icon list widget title.
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Malina Menu', 'malina-elements' );
	}

	/**
	 * Retrieve icon list widget icon.
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-nav-menu';
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

	private function get_available_menus() {
		$menus = wp_get_nav_menus();

		$options = [];

		foreach ( $menus as $menu ) {
			$options[ $menu->term_id ] = $menu->name;
		}

		return $options;
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
			'asw_section_menu',
			[
				'label' => __( 'Malina Menu', 'malina-elements' ),
			]
		);
		$menus = $this->get_available_menus();

		if ( ! empty( $menus ) ) {
			$this->add_control(
				'menu',
				[
					'label' => __( 'Select Menu', 'malina-elements' ),
					'type' => Controls_Manager::SELECT,
					'options' => $menus,
					'default' => array_keys( $menus )[0],
					'save_default' => true,
					'separator' => 'after',
					'description' => sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to manage your menus.', 'malina-elements' ), admin_url( 'nav-menus.php' ) ),
				]
			);
		} else {
			$this->add_control(
				'menu',
				[
					'type' => Controls_Manager::RAW_HTML,
					'raw' => '<strong>' . __( 'There are no menus in your site.', 'malina-elements' ) . '</strong><br>' . sprintf( __( 'Go to the <a href="%s" target="_blank">Menus screen</a> to create one.', 'malina-elements' ), admin_url( 'nav-menus.php?action=edit&menu=0' ) ),
					'separator' => 'after',
					'content_classes' => 'elementor-panel-alert elementor-panel-alert-info',
				]
			);
		}
		$this->add_control(
			'menu_place',
			[
				'label' => esc_html__( 'Menu Place', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'header' => esc_html__('Menu for header', 'malina-elements'),
					'footer' => esc_html__('Menu for footer', 'malina-elements')
				],
				'default' => 'header',
			]
		);
		$this->add_control(
			'menu_vertical',
			[
				'label' => esc_html__( 'Show verticaly/horizontaly', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'vertical' => esc_html__( 'Vertical', 'malina-elements' ),
					'horizontal' => esc_html__( 'Horizontal', 'malina-elements' )
				],
				'default' => 'horizontal',
				'condition' => [
					'menu_place' => 'footer'
				]
			]
		);
		$this->add_control(
			'default_font',
			[
				'label' => esc_html__( 'Menu settings', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => esc_html__( 'Default', 'malina-elements' ),
					'false' => esc_html__( 'Custom', 'malina-elements' )
				],
				'default' => 'true',
			]
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'content_typography',
				'label' => __( 'Typography', 'malina-elements' ),
				'selector' => '{{WRAPPER}} #navigation-block .wp-megamenu-wrap .wpmm-nav-wrap > ul > li > a, {{WRAPPER}} #navigation-block #navigation .menu li a, {{WRAPPER}} #navigation-block .dl-menuwrapper li a',
				'condition' => [
					'default_font' => 'false'
				]
			]
		);
		$this->add_control(
			'menu_items_color',
			[
				'label' => esc_html__( 'Menu item color initial', 'malina-elements' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} #navigation-block .wp-megamenu-wrap .wpmm-nav-wrap > ul > li > a, 
					{{WRAPPER}} #navigation-block #navigation .menu li a, 
					{{WRAPPER}} #navigation-block .dl-menuwrapper li a' => 'color: {{VALUE}};'
				],
				'condition' => [
					'default_font' => 'false'
				]
			]
		);
		$this->add_control(
			'menu_items_color_hover',
			[
				'label' => esc_html__( 'Menu items color hover', 'malina-elements' ),
				'type' => Controls_Manager::COLOR,
				'alpha' => false,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} #navigation-block .wp-megamenu-wrap .wpmm-nav-wrap > ul > li > a:hover, 
					{{WRAPPER}} #navigation-block #navigation .menu li a:hover, 
					{{WRAPPER}} #navigation-block .dl-menuwrapper li a:hover' => 'color: {{VALUE}};'
				],
				'condition' => [
					'default_font' => 'false'
				]
			]
		);
		$this->add_control(
			'menu_position',
			[
				'label' => esc_html__( 'Menu Position', 'malina-elements' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'flexleft' => esc_html__( 'Left', 'malina-elements' ),
					'flexcenter' => esc_html__( 'Center', 'malina-elements' ),
					'flexright' => esc_html__( 'Right', 'malina-elements' ),
				],
				'default' => 'textcenter',
			]
		);
		$this->add_control(
			'enable_search',
			[
				'label' => esc_html__( 'Enable search icon?', 'malina-elements' ),
				"description" => esc_html__("Enable search icon to show at the end of the menu.", 'malina-elements'),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'true' => esc_html__( 'Yes', 'malina-elements' ),
					'false' => esc_html__( 'No', 'malina-elements' )
				],
				'default' => 'false',
				'condition' => [
					'menu_place' => 'header'
				]
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
		if( $enable_search == 'true' ){
			$out .= '<div class="search-area">';
				$out .= '<div class="container">';
					$out .= '<div class="span12">';
						$out .= '<form action="'.esc_url(home_url('/')).'" id="header-searchform" method="get">';
					        $out .= '<input type="text" id="header-s" name="s" value="" placeholder="'.esc_attr__('Search...', 'malina-elements').'" autocomplete="off" />';
					        $out .= '<button type="submit"><i class="la la-search"></i></button>';
						$out .= '</form>';
					$out .= '</div>';
				$out .= '</div>';
				$out .= '<a href="#" class="close-search"><i class="la la-times"></i></a>';
			$out .= '</div>';
		}
		$out .= '<div id="navigation-block" class="'.$menu_position.'">';
        if( $enable_search == 'true' ){
        	add_filter('wp_nav_menu_items','malina_custom_menu_item_search', 10, 2);
        }

        if($menu_place == 'header'){
        	$depth = 0;
        } else {
        	$depth = 1;
        }

        $wp_megamenu_enabled = false;
        $locations = get_nav_menu_locations();

        if(isset($locations['main_navigation']) && $locations['main_navigation'] == $menu ){
        	$wpmm_nav_location_settings = get_option( 'wpmm_options' );
        	if(!empty( $wpmm_nav_location_settings['main_navigation']['is_enabled'] ) || $wpmm_nav_location_settings['main_navigation']['is_enabled'] == '1' ){
				$wp_megamenu_enabled = true;
        	}
        }
		if(function_exists('wp_megamenu') && $wp_megamenu_enabled && $menu_place == 'header'){
			ob_start();			
			wp_megamenu(array('theme_location' => 'main_navigation'));
			$out .= ob_get_contents();
			ob_end_clean();
		} else {
			$out .= '<nav id="navigation">';
				$out .= '<ul id="nav" class="menu menu-'.$menu_vertical.'">';
					if ( isset($menu) && $menu !== '' ) {
						$out .= wp_nav_menu(array('container' => false, 'menu'=>$menu, 'menu_id' => 'nav-custom', 'items_wrap'=>'%3$s', 'fallback_cb' => false, 'echo' => false, 'depth' => $depth ));
					} else {
						$out .= wp_nav_menu(array('container' => false, 'menu_id' => 'nav-custom', 'items_wrap'=>'%3$s', 'fallback_cb' => false, 'echo' => false, 'depth' => $depth ));
					}
				$out .= '</ul>';
			$out .= '</nav>';
		}
		$out .= '</div>';
		echo $out;
	}
}
