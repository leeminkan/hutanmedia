<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @since      1.0.0
 *
 * @package    MB_WP_Manage
 * @subpackage MB_WP_Manage/public/partials
 */
if ( defined( 'ABSPATH' ) && ! class_exists( 'mbwph_Security_Load_Settings' ) ) {
	class mbwph_Security_Load_Settings{
		private $WP_HELPER;
		private $secureOptions, $site_key, $secret_key;
		/**
		* Class constructor.
		*/
		public function __construct() {
			$this->WP_HELPER = 'wp-helper';
			$this->setup_vars();
			$this->hooks();
		}
		function setup_vars(){
			$this->secureOptions = get_option($this->WP_HELPER . '_security_options') ;
		}
		private function hooks(){
			if(!empty($this->secureOptions["site-key"]) && !empty($this->secureOptions["secret-key"])){
				add_action('login_enqueue_scripts', array( $this, 'mbwph_login_recaptcha_script'));
				add_action('login_form', array( $this, 'mbwph_display_login_captcha_form' ));
				add_filter('wp_authenticate_user', array( $this, 'mbwph_verify_login_captcha'), 10, 2);
			}
			if(!empty($this->secureOptions["backend-name"])){
				// add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ), 9999 ); //Done
				//
				// add_filter( 'site_url', array( $this, 'site_url' ), 10, 4 ); //Done
				// add_filter( 'network_site_url', array( $this, 'network_site_url' ), 10, 3 ); //Done
				// add_filter( 'wp_redirect', array( $this, 'wp_redirect' ), 10, 2 ); //Done
				// add_filter( 'site_option_welcome_email', array( $this, 'welcome_email' ) );
				//
				// remove_action( 'template_redirect', 'wp_redirect_admin_locations', 1000 );
				// //add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
				//
				// //add_action( 'admin_menu', array( $this, 'wps_hide_login_menu_page' ) );
				// //add_action( 'admin_init', array( $this, 'whl_template_redirect' ) );
				//
				// add_action( 'template_redirect', array( $this, 'redirect_export_data' ) );//Done
				// add_filter( 'login_url', array( $this, 'login_url' ), 10, 3 );//Done
				//
				// add_filter( 'user_request_action_email_content', array( $this, 'user_request_action_email_content' ), 999, 2 );

				add_action( 'login_init', array( $this,'mbwph_hide_login_head'),1);
				add_action( 'login_form', array( $this,'mbwph_hide_login_hidden_field'));
				add_action( 'template_redirect', array( $this,'mbwph_hide_login_init'));
				add_action( 'init', array( $this,'mbwph_hide_login_init'));
				add_filter( 'lostpassword_url',  array( $this,'mbwph_hide_login_lostpassword'), 10, 0 );
				add_action( 'lostpassword_form', array( $this,'mbwph_hide_login_hidden_field'));
				add_filter( 'lostpassword_redirect', array( $this,'mbwph_hide_login_lostpassword_redirect'), 100, 1 );
			}
			if(!empty($this->secureOptions["disable_xmlrpc"]) && $this->secureOptions["disable_xmlrpc"] == true){
				add_filter('mod_rewrite_rules', array( $this,'mwph_htaccess_contents'));
			}
		}

		/*Hide Login New Version*/
		public function plugins_loaded() {
			global $pagenow;

			$request = parse_url( rawurldecode( $_SERVER['REQUEST_URI'] ) );

			if ( ( strpos( rawurldecode( $_SERVER['REQUEST_URI'] ), 'wp-login.php' ) !== false
			       || ( isset( $request['path'] ) && untrailingslashit( $request['path'] ) === site_url( 'wp-login', 'relative' ) ) )
			     && ! is_admin() ) {

				$this->wp_login_php = true;

				$_SERVER['REQUEST_URI'] = $this->user_trailingslashit( '/' . str_repeat( '-/', 10 ) );

				$pagenow = 'index.php';

			} elseif ( ( isset( $request['path'] ) && untrailingslashit( $request['path'] ) === home_url( $this->new_login_slug(), 'relative' ) )
			           || ( ! get_option( 'permalink_structure' )
			                && isset( $_GET[ $this->new_login_slug() ] )
			                && empty( $_GET[ $this->new_login_slug() ] ) ) ) {

				$pagenow = 'wp-login.php';

			} elseif ( ( strpos( rawurldecode( $_SERVER['REQUEST_URI'] ), 'wp-register.php' ) !== false
			             || ( isset( $request['path'] ) && untrailingslashit( $request['path'] ) === site_url( 'wp-register', 'relative' ) ) )
			           && ! is_admin() ) {

				$this->wp_login_php = true;

				$_SERVER['REQUEST_URI'] = $this->user_trailingslashit( '/' . str_repeat( '-/', 10 ) );

				$pagenow = 'index.php';
			}

		}
		public function network_site_url( $url, $path, $scheme ) {

			return $this->filter_wp_login_php( $url, $scheme );

		}
		public function wp_redirect( $location, $status ) {
			if ( strpos( $location, 'https://wordpress.com/wp-login.php' ) !== false ) {
				return $location;
			}
			return $this->filter_wp_login_php( $location );
		}
		public function filter_wp_login_php( $url, $scheme = null ) {

				if ( strpos( $url, 'wp-login.php?action=postpass' ) !== false ) {
					return $url;
				}

				if ( strpos( $url, 'wp-login.php' ) !== false && strpos( wp_get_referer(), 'wp-login.php' ) === false ) {

					if ( is_ssl() ) {

						$scheme = 'https';

					}

					$args = explode( '?', $url );

					if ( isset( $args[1] ) ) {

						parse_str( $args[1], $args );

						if ( isset( $args['login'] ) ) {
							$args['login'] = rawurlencode( $args['login'] );
						}

						$url = add_query_arg( $args, $this->new_login_url( $scheme ) );

					} else {

						$url = $this->new_login_url( $scheme );

					}

				}

				return $url;

			}
		public function welcome_email( $value ) {
			return $value = str_replace( 'wp-login.php', trailingslashit( get_option( $this->secureOptions["backend-name"] ) ), $value );
		}
		private function new_login_slug() {
			if ( $slug = get_option($this->secureOptions["backend-name"]) ) {
				return $slug;
			} else if ( ( is_multisite() && ( $slug = get_option( $this->secureOptions["backend-name"] ) ) ) ) {
				return $slug;
			} else if ( $slug = 'login' ) {
				return $slug;
			}
		}
		public function redirect_export_data() {
			if ( ! empty( $_GET ) && isset( $_GET['action'] ) && 'confirmaction' === $_GET['action'] && isset( $_GET['request_id'] ) && isset( $_GET['confirm_key'] ) ) {
				$request_id = (int) $_GET['request_id'];
				$key        = sanitize_text_field( wp_unslash( $_GET['confirm_key'] ) );
				$result     = wp_validate_user_request_key( $request_id, $key );
				if ( ! is_wp_error( $result ) ) {
					wp_redirect( add_query_arg( array(
						'action'      => 'confirmaction',
						'request_id'  => $_GET['request_id'],
						'confirm_key' => $_GET['confirm_key']
					), $this->new_login_url()
					) );
					exit();
				}
			}
		}
		public function login_url( $login_url, $redirect, $force_reauth ) {
			if ( is_404() ) {
				return '#';
			}

			if ( $force_reauth === false ) {
				return $login_url;
			}

			if ( empty( $redirect ) ) {
				return $login_url;
			}

			$redirect = explode( '?', $redirect );

			if ( $redirect[0] === admin_url( 'options.php' ) ) {
				$login_url = admin_url();
			}

			return $login_url;
		}
		public function user_request_action_email_content( $email_text, $email_data ) {
			$email_text = str_replace( '###CONFIRM_URL###', esc_url_raw( str_replace( $this->new_login_slug() . '/', 'wp-login.php', $email_data['confirm_url'] ) ), $email_text );

			return $email_text;
		}
		/*End Hide Login New Version*/

		function mbwph_hide_login_hidden_field(){
			$mbwph_slug =  $this->secureOptions["backend-name"];
			?>
				<input type="hidden" name="redirect_slug" value="<?php echo $mbwph_slug ?>" />
			<?php
		}
		function mbwph_hide_login_head(){
			$mbwph_slug =  $this->secureOptions['backend-name'];
			if( isset($_POST['redirect_slug']) && $_POST['redirect_slug'] == $mbwph_slug){
				return false;
			}
			if( strpos($_SERVER['REQUEST_URI'], 'action=logout') !== false ){
				check_admin_referer( 'log-out' );
				$user = wp_get_current_user();
				wp_logout();
				wp_safe_redirect( home_url(), 302 );
				die;
			}
			if( ( strpos($_SERVER['REQUEST_URI'], $mbwph_slug) === false  ) &&
			( strpos($_SERVER['REQUEST_URI'], 'wp-login.php') !== false  ) ){
				wp_safe_redirect( home_url( '404' ), 302 );
			  exit();
			}
		}
		function mbwph_hide_login_init(){
			$mbwph_slug =  $this->secureOptions['backend-name'];
		    
			if('/'.$mbwph_slug ==  $_SERVER['REQUEST_URI']){
				wp_safe_redirect(home_url('wp-login.php?'.$mbwph_slug.'&redirect=false'));
				exit();
			}
		}
		function mbwph_hide_login_lostpassword() {
			$mbwph_slug =  $this->secureOptions['backend-name'];
			return site_url('wp-login.php?action=lostpassword&'.$mbwph_slug.'&redirect=false');
		}
		function mbwph_hide_login_lostpassword_redirect($lostpassword_redirect) {
			$mbwph_slug =  $this->secureOptions['backend-name'];
			return 'wp-login.php?checkemail=confirm&redirect=false&' . $mbwph_slug;
		}
		/** reCAPTCHA **/
		function mbwph_login_recaptcha_script(){
			//wp_enqueue_style("mbwphcss", plugin_dir_url(__FILE__)."assets/css/mbwph-style.css");
			wp_register_script("recaptcha_api", "https://www.google.com/recaptcha/api.js?hl=" . get_locale());
			wp_enqueue_script("recaptcha_api");

		}
		function mbwph_display_login_captcha_form(){
			$this->site_key = $this->secureOptions["site-key"];
			echo '<div class="g-recaptcha" data-badge="inline" data-sitekey="'.$this->site_key.'"></div>';
		}
		function mbwph_verify_login_captcha($user, $password){
			if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["g-recaptcha-response"])) {
				$recaptcha_secret = $this->secureOptions["secret-key"];
				$response = wp_remote_get("https://www.google.com/recaptcha/api/siteverify?secret=". $recaptcha_secret ."&response=". $_POST['g-recaptcha-response']);
				$response = json_decode($response["body"], true);
				if (true == $response["success"]) {
					return $user;
				} else {
					return new WP_Error("Captcha Invalid", __("<strong>ERROR</strong>: Mã Captcha không đúng"));
				}
			} else {
				return new WP_Error("Captcha Invalid", __("<strong>ERROR</strong>: Mã Captcha không đúng"));
			}
		}
		function mwph_htaccess_contents( $rules )
		{
			global $wp_rewrite;
			$wp_rewrite->flush_rules( false );
				$new_rules  = '# BEGIN Protect XML-RPC'. "\n";
				$new_rules .= '<Files "xmlrpc.php">'. "\n";
				$new_rules .= 'Order Deny,Allow'. "\n";
				$new_rules .= 'Deny from all'. "\n";
				$new_rules .= '</Files>'. "\n";
				$new_rules .= '# END Protect XML-RPC'. "\n";
			return  $rules ."\n". $new_rules . "\n";
		}
	}
}
