<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_HELPER
 * @subpackage WP_HELPER/admin
 * @author     MWP Team <wpteam@matbao.com>
 */




if ( defined( 'ABSPATH' ) && ! class_exists( 'WP_HELPER_Admin' ) ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	class WP_HELPER_Admin {

		/**
		 * The ID of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $WP_HELPER    The ID of this plugin.
		 */
		private $WP_HELPER;

		/**
		 * The version of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $version    The current version of this plugin.
		 */
		private $version;

		/**
		* The tabs of settings page
		* @since 1.0.0
		* @access public
		* @var array 	$plugin_settings_tabs	The tabs of this plugin.
		*/
		public $plugin_settings_tabs = array();

		/**
		 * Initialize the class and set its properties.
		 *
		 * @since    1.0.0
		 * @param      string    $WP_HELPER       The name of this plugin.
		 * @param      string    $version    The version of this plugin.
		 */
		public function __construct( $WP_HELPER, $version )
		{
			$this->WP_HELPER = $WP_HELPER;
			$this->version = $version;

			$this->plugin_settings_tabs['social'] =  __( '<span class="dashicons dashicons-format-chat"></span> <span class="d-none d-md-inline">Kênh liên hệ</span>', 'mbwph' );
			$this->plugin_settings_tabs['login'] =  __( '<span class="dashicons dashicons-admin-appearance"></span> <span class="d-none d-md-inline">Giao diện đăng nhập</span>', 'mbwph' );
			$this->plugin_settings_tabs['smtp'] =  __( '<span class="dashicons dashicons-email-alt"></span> <span class="d-none d-md-inline">SMTP Mail</span>', 'mbwph' );
			$this->plugin_settings_tabs['security'] =  __( '<span class="dashicons dashicons-privacy"></span> <span class="d-none d-md-inline">Bảo mật</span>', 'mbwph' );
			$this->plugin_settings_tabs['woocommerce'] = __( '<span class="dashicons dashicons-cart"></span> <span class="d-none d-md-inline">Tối ưu giỏ hàng</span>', 'mbwph' );
			$this->plugin_settings_tabs['insert-header-footer'] =  __( '<span class="dashicons dashicons-editor-code"></span> <span class="d-none d-md-inline">Header & Footer</span>', 'mbwph' );
			$this->plugin_settings_tabs['general'] =  __( '<span class="dashicons dashicons-admin-plugins"></span> <span class="d-none d-md-inline">Tiện ích mở rộng</span>', 'mbwph' );
			$plugin = 'wp-helper-premium/wp-helper-premium.php';
			// if ( is_plugin_active($plugin) ) {
				// $this->plugin_settings_tabs['premium-license'] = __( '<span class="dashicons-awards dashicons"></span> <span class="d-none d-md-inline">Bản quyền</span>', 'mbwph' );
			// }
		}

		/**
		 * Register the Settings page.
		 *
		 * @since    1.0.0
		 */
		public function mbwph_utilities_admin_menu() {
			//Load css & js
			if (isset($_GET['page']) && ($_GET['page'] == 'wp-helper'))
			{							
				wp_enqueue_style( 'bootstrap-style',  WP_HELPER_ASSETS_URL . 'css/bootstrap.min.css');
				wp_enqueue_style( 'bootstrap-switch',  WP_HELPER_ASSETS_URL . 'css/bootstrap-switch.min.css');
				wp_enqueue_style( 'mwph-style',  WP_HELPER_ASSETS_URL . 'css/mbwph-style.css');
				wp_enqueue_style( 'wp-color-picker' );
				wp_enqueue_script('media-upload');
				wp_enqueue_media();

				wp_enqueue_script( 'popper-script', WP_HELPER_ASSETS_URL . 'js/popper.min.js', array('jquery'), false, true );
				wp_enqueue_script( 'mwp-scripts', WP_HELPER_ASSETS_URL . 'js/admin-script.js',array( 'jquery', 'wp-color-picker' ),false,true);

				wp_enqueue_script( 'bootstrap-scripts', WP_HELPER_ASSETS_URL . 'js/bootstrap.min.js', array('jquery'), '4.4.1' ,true);
				wp_enqueue_script('jquery');
				wp_enqueue_script( 'jquery-form' );
			}

			//create new top-level menu
			$plugin = 'wp-helper-premium/wp-helper-premium.php';
			if ( !is_plugin_active($plugin) ) {
				add_menu_page(
					__( 'WP Helper', 'mbwph'),
					__( 'WP Helper', 'mbwph'),
					'administrator',
					'wp-helper',
					array($this, 'display_plugin_admin_page'),
					plugins_url('../assets/images/wp-helper-plugin.icon', __FILE__),
					10 );
			} else {
				add_menu_page(
					__( 'WP Helper', 'mbwph'),
					__( 'WP Helper', 'mbwph'),
					'administrator',
					'wp-helper',
					array($this, 'display_plugin_admin_page'),
					plugins_url('../assets/images/wp-helper-plugin.icon', __FILE__),
					10 );
			}
				add_submenu_page(
					'wp-helper',
					__( 'Kênh liên hệ', 'mbwph'),
					__( 'Kênh liên hệ', 'mbwph'),
					'administrator',
					'wp-helper&amp;tab=social',
					array($this, 'display_plugin_admin_page'));
				add_submenu_page( 'admin.php?page=wp-helper', 'Page title Kênh liên hệ', 'Kênh liên hệ', 'wp-helper', 'social', null);
				add_submenu_page(
					'wp-helper',
					__( 'Giao diện đăng nhập', 'mbwph'),
					__( 'Giao diện đăng nhập', 'mbwph'),
					'administrator',
					'wp-helper&amp;tab=login',
					array($this, 'display_plugin_admin_page'));
				add_submenu_page(
					'wp-helper',
					__( 'SMTP Mail', 'mbwph'),
					__( 'SMTP Mail', 'mbwph'),
					'administrator',
					'wp-helper&amp;tab=smtp',
					array($this, 'display_plugin_admin_page'));
				add_submenu_page(
					'wp-helper',
					__( 'Bảo mật', 'mbwph'),
					__( 'Bảo mật', 'mbwph'),
					'administrator',
					'wp-helper&amp;tab=security',
					array($this, 'display_plugin_admin_page'));
				add_submenu_page(
					'wp-helper',
					__( 'Tối ưu giỏ hàng', 'mbwph'),
					__( 'Tối ưu giỏ hàng', 'mbwph'),
					'administrator',
					'wp-helper&amp;tab=woocommerce',
					array($this, 'display_plugin_admin_page'));
				add_submenu_page(
					'wp-helper',
					__( 'Header & Footer', 'mbwph'),
					__( 'Header & Footer', 'mbwph'),
					'administrator',
					'wp-helper&amp;tab=insert-header-footer',
					array($this, 'display_plugin_admin_page'));
				add_submenu_page(
					'wp-helper',
					__( 'Tiện ích mở rộng', 'mbwph'),
					__( 'Tiện ích mở rộng', 'mbwph'),
					'administrator',
					'wp-helper&amp;tab=general',
					array($this, 'display_plugin_admin_page'));
				remove_submenu_page('wp-helper','wp-helper');
		}
		/**
		 * Settings - Validates saved options
		 *
		 * @since 		1.0.0
		 * @param 		array 		$input 			array of submitted plugin options
		 * @return 		array 						array of validated plugin options
		 */
		public function mbwph_settings_sanitize( $input ) {

			// Initialize the new array that will hold the sanitize values
			$new_input = array();

			if(isset($input)) {
				// Loop through the input and sanitize each of the values
				foreach ( $input as $key => $val ) {
					$new_input[ $key ] = sanitize_text_field( $val );
				}
			}
			return $new_input;

		} // sanitize()

		/**
		 * Renders Settings Tabs
		 *
		 * @since 		1.0.0
		 * @return 		mixed 			The settings field
		 */

		function mbwph_utilities_render_tabs() {
			$current_tab = sanitize_text_field( isset($_GET['tab']) ) ? sanitize_text_field( $_GET['tab'] ) : 'general';
			//screen_icon();
			echo '<div class="nav flex-column nav-pills" id="mwpTab" role="tablist">';
			foreach ( $this->plugin_settings_tabs as $tab_key => $tab_caption ) {
				$active = $current_tab == $tab_key ? 'active' : '';
				echo '<a class="nav-link ' . $active . '" href="?page=' . $this->WP_HELPER . '&tab=' . $tab_key . '">' . $tab_caption . '</a>';
			}
			echo '</div>';
		}

		/**
		 * Plugin Settings Link on plugin page
		 *
		 * @since 		1.0.0
		 * @return 		mixed 			The settings field
		 */
		function add_settings_link( $links ) {
			$mylinks = array(
				'<a href="' . admin_url( 'admin.php?page=wp-helper' ) . '">' . __( 'Settings' ) . '</a>',
				'<a href="#">' . __( 'FAQ' ) . '</a>',
			);
			return array_merge( $links, $mylinks );
		}

		/**
		 * Callback function for the admin settings page.
		 *
		 * @since    1.0.0
		 */
		public function display_plugin_admin_page(){
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/admin-display.php';
		}
		/**
		 * Returns plugin for settings page
		 *
		 * @since    	1.0.0
		 * @return 		string    $WP_HELPER       The name of this plugin
		 */
		public function get_plugin() {
			return $this->WP_HELPER;
		}
	}
}
