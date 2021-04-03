<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_HELPER
 * @subpackage WP_HELPER/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing.
 *
 * @package    WP_HELPER
 * @subpackage WP_HELPER/public
 * @author     MWP Team
 */
if ( defined( 'ABSPATH' ) && ! class_exists( 'WP_HELPER_Public' ) ) {
	class WP_HELPER_Public {

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
		 * Initialize the class and set its properties.
		 *
		 * @since    	1.0.0
		 * @param      	string    $WP_HELPER       The name of the plugin.
		 * @param      	string    $version    The version of this plugin.
		 */
		public function __construct( $WP_HELPER, $version ) {

			$this->WP_HELPER = $WP_HELPER;
			$this->version = $version;
		}
		public function mbwph_utilities_actions(){
			if(!is_admin() && $GLOBALS['pagenow'] != 'wp-login.php'){
				wp_enqueue_style( 'mbwph-style', WP_HELPER_URL .'public/partials/assets/css/mbwph-style.css');
			}
			require_once( WP_HELPER_PUBLIC_URL . 'partials/class-general.php' );
			new mbwph_General_Load_Settings();
			require_once( WP_HELPER_PUBLIC_URL . 'partials/class-login.php' );
			new mbwph_Login_Load_Settings();
			require_once( WP_HELPER_PUBLIC_URL . 'partials/class-social.php' );
			new mbwph_Social_Load_Settings();
			require_once( WP_HELPER_PUBLIC_URL . 'partials/class-smtp.php' );
			new mbwph_Smtp_Load_Settings();
			require_once( WP_HELPER_PUBLIC_URL . 'partials/class-security.php' );
			new mbwph_Security_Load_Settings();
			require_once( WP_HELPER_PUBLIC_URL . 'partials/class-header-footer.php'	);
			new mbwph_Header_Footer_Load_Settings();
			require( WP_HELPER_PUBLIC_URL . 'partials/class-woocommerce.php');
			new mbwph_WooCommerce_Load_Settings();
		}
	}
}
