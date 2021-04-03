<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    WP_HELPER
 * @subpackage WP_HELPER/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WP_HELPER
 * @subpackage WP_HELPER/includes
 * @author     MWP Team
 */
if ( defined( 'ABSPATH' ) && ! class_exists( 'WP_HELPER' ) ) {
	class WP_HELPER {

		/**
		 * The loader that's responsible for maintaining and registering all hooks that power
		 * the plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      WP_HELPER_Loader    $loader    Maintains and registers all hooks for the plugin.
		 */
		protected $loader;

		/**
		 * The unique identifier of this plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string    $WP_HELPER    The string used to uniquely identify this plugin.
		 */
		protected $WP_HELPER;

		/**
		 * The current version of the plugin.
		 *
		 * @since    1.0.0
		 * @access   protected
		 * @var      string    $version    The current version of the plugin.
		 */
		protected $version;

		/**
		 * Define the core functionality of the plugin.
		 *
		 * Set the plugin name and the plugin version that can be used throughout the plugin.
		 * Load the dependencies, define the locale, and set the hooks for the admin area and
		 * the public-facing side of the site.
		 *
		 * @since    1.0.0
		 */
		public function __construct() {
			$this->version = WP_HELPER_VERSION;
			$this->WP_HELPER = 'wp-helper';

			$this->load_dependencies();
			$this->define_admin_hooks();
			$this->define_public_hooks();
		}

		/**
		 * Load the required dependencies for this plugin.
		 *
		 * Include the following files that make up the plugin:
		 *
		 * - WP_HELPER_Loader. Orchestrates the hooks of the plugin.
		 * - WP_HELPER_i18n. Defines internationalization functionality.
		 * - WP_HELPER_Admin. Defines all hooks for the admin area.
		 * - WP_HELPER_Public. Defines all hooks for the public side of the site.
		 *
		 * Create an instance of the loader which will be used to register the hooks
		 * with WordPress.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function load_dependencies() {

			/**
			 * The class responsible for orchestrating the actions and filters of the
			 * core plugin.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-loader.php';

			/**
			 * The class responsible for defining all actions that occur in the admin area.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-admin.php';

			/**
			 * The class responsible for defining all Settings.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-general.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-login.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-social.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-smtp.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/partials/send_mail.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-security.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-insert-header-footer.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-woocommerce.php';
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-premium.php';
			/**
			 * The class responsible for defining all actions that occur in the public-facing
			 * side of the site.
			 */
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-public.php';

			$this->loader = new WP_HELPER_Loader();

		}

		/**
		 * Register all of the hooks related to the admin area functionality
		 * of the plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function define_admin_hooks() {
			$plugin_admin = new WP_HELPER_Admin( $this->get_WP_HELPER(), $this->get_version() );

			$this->loader->add_action( 'admin_menu', $plugin_admin, 'mbwph_utilities_admin_menu' );

			$settings_init_general = new WP_HELPER_General( $this->get_WP_HELPER() );
			$this->loader->add_action( 'admin_init', $settings_init_general, 'mbwph_settings_general_init' );

			$settings_init_login = new WP_HELPER_Login( $this->get_WP_HELPER() );
			$this->loader->add_action( 'admin_init', $settings_init_login, 'mbwph_settings_login_init' );

			$settings_init_social = new WP_HELPER_Social( $this->get_WP_HELPER() );
			$this->loader->add_action( 'admin_init', $settings_init_social, 'mbwph_settings_social_init' );

			$settings_init_smtp = new WP_HELPER_Smtp( $this->get_WP_HELPER() );
			$this->loader->add_action( 'admin_init', $settings_init_smtp, 'mbwph_settings_smtp_init' );

			$settings_init_security = new WP_HELPER_Security( $this->get_WP_HELPER() );
			$this->loader->add_action( 'admin_init', $settings_init_security, 'mbwph_settings_security_init' );

			$settings_init_header_footer = new WP_HELPER_Insert_Header_Footer( $this->get_WP_HELPER() );
			$this->loader->add_action( 'admin_init', $settings_init_header_footer, 'mbwph_settings_header_footer_init' );
			$settings_init_woocommerce = new WP_HELPER_WooCommerce( $this->get_WP_HELPER() );
			$this->loader->add_action( 'admin_init', $settings_init_woocommerce, 'mbwph_settings_woocommerce_init' );
			$settings_init_premium = new WP_HELPER_Premium( $this->get_WP_HELPER() );
			$this->loader->add_action( 'admin_init', $settings_init_premium, 'mbwph_settings_premium_init' );

			$this->loader->add_filter( 'plugin_action_links_wp-helper/wp-helper.php', $plugin_admin, 'add_settings_link' );
		}

		/**
		 * Register all of the hooks related to the public-facing functionality
		 * of the plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 */
		private function define_public_hooks() {
			$plugin_public = new WP_HELPER_Public( $this->get_WP_HELPER(), $this->get_version() );
			$this->loader->add_action( 'wp_loaded', $plugin_public, 'mbwph_utilities_actions' );
		}

		/**
		 * Run the loader to execute all of the hooks with WordPress.
		 *
		 * @since    1.0.0
		 */
		public function run() {
			$this->loader->run();
		}

		/**
		 * The name of the plugin used to uniquely identify it within the context of
		 * WordPress and to define internationalization functionality.
		 *
		 * @since     1.0.0
		 * @return    string    The name of the plugin.
		 */
		public function get_WP_HELPER() {
			return $this->WP_HELPER;
		}

		/**
		 * The reference to the class that orchestrates the hooks with the plugin.
		 *
		 * @since     1.0.0
		 * @return    WP_HELPER_Loader    Orchestrates the hooks of the plugin.
		 */
		public function get_loader() {
			return $this->loader;
		}

		/**
		 * Retrieve the version number of the plugin.
		 *
		 * @since     1.0.0
		 * @return    string    The version number of the plugin.
		 */
		public function get_version() {
			return $this->version;
		}

		public function mbwph_utilities_load_textdomain() {
			load_plugin_textdomain( $this->WP_HELPER, false, plugin_dir_path( dirname( __FILE__ ) ) . 'languages' );
		}
	}
}
