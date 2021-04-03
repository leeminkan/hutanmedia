<?php
if ( defined( 'ABSPATH' ) && ! class_exists( 'mbwph_Login_Load_Settings' ) ) {
	class mbwph_Login_Load_Settings{
		private $WP_HELPER;
		private $enable_login_style, $bg_color, $bg_image_id, $bg_repeat, $bg_scale, $frm_login_top_margin, $frm_login_width, $login_logo_id, $resize_logo, $set_logo_size, $set_logo_height, $logo_url, $set_transparent_form, $set_transparent_input, $input_text_color, $input_border_color, $input_hover_color, $form_bg_color, $form_border_color, $form_text_color, $form_link_color, $form_link_hover_color,$form_button_color,$form_button_hover_color;
		public function __construct() {
			$this->WP_HELPER = 'wp-helper';			
			$this->setup_vars();
			$this->hooks();			
		}
		function setup_vars(){
			$this->enable_login_style = get_option('enable_login_style');
		}
		private function hooks(){
			if($this->enable_login_style == 1){
				add_action('login_head', array($this, 'mbwph_Load_Login_Style'));
				add_filter('login_headerurl', array($this, 'mbwph_Login_url'));
			}			
		}
		public function mbwph_Load_Login_Style(){
			include_once( WP_HELPER_PUBLIC_ASSETS_URL . '/css/mbwph.login.css.php' );
		}
		public function mbwph_Login_url(){
			$logo_url = $this->logo_url;
			if(empty($logo_url))
					return site_url();
			else return $logo_url;
		}
	}
}