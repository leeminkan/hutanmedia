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

		function mbwph_hide_login_hidden_field(){
			$mbwph_slug =  $this->secureOptions["backend-name"];
			?>
				<input type="hidden" name="redirect_slug" value="<?php echo $mbwph_slug ?>" />
			<?php
		}
		function mbwph_hide_login_head(){
			$mbwph_slug =  $this->secureOptions['backend-name'];
			//echo ($mbwph_slug);
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
			if(parse_url($_SERVER['REQUEST_URI'],PHP_URL_QUERY) == $mbwph_slug ){
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
