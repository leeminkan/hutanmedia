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
if ( defined( 'ABSPATH' ) && ! class_exists( 'mbwph_Social_Load_Settings' ) ) {
	class mbwph_Social_Load_Settings{
		private $WP_HELPER;
		private $social_active, $fbcomment_active, $backtotop_active, $btn_color, $btn_message, $social_contacts, $social_position, $mail_to, $fb_page_link, $zalo_phone, $tawkto_id, $fb_app_id, $fb_page_id, $call_header_title, $social_header_title;
		/**
		* Class constructor.
		*/
		public function __construct() {
			$this->WP_HELPER = 'wp-helper';
			$this->setup_vars();
			$this->hooks();
		}
		function setup_vars(){
			// $this->socialOptions = get_option($this->WP_HELPER . '_social_options') ;
			$this->social_active 		= get_option('social_active') ;
			$this->fbcomment_active 	= get_option('fbcomment_active') ;
			$this->backtotop_active 	= get_option('backtotop_active') ;
			$this->btn_color 			= get_option('btn_color') ;
			$this->btn_message 			= get_option('btn_message') ;
			$this->social_contacts 		= get_option('social_contacts') ;
			$this->social_position 		= get_option('social_position') ;
			$this->mail_to 				= get_option('mail_to') ;
			$this->fb_page_link 		= get_option('fb_page_link') ;
			$this->zalo_phone 			= get_option('zalo_phone') ;
			$this->tawkto_id 			= get_option('tawkto_id') ;
			$this->fb_app_id 			= get_option('fb_app_id') ;
			$this->fb_page_id 			= get_option('fb_page_id') ;
			$this->call_header_title 	= get_option('call_header_title') ;
			$this->social_header_title 	= get_option('social_header_title') ;
		}
		private function hooks(){
			//Load Styles, Script
			add_action('wp_enqueue_scripts', array( $this,'mbwph_load_style_script'), 1001);
			if($this->social_active == 1){
				add_action('wp_footer', array($this, 'render_html_social'));
				add_action('wp_footer', array($this, 'render_html_hotline'));
			}
			if(empty($this->fb_app_id)){
				add_action('wp_footer', array( $this, 'hook_facebook_messenger_scripts'));
				// add_action('wp_footer',array( $this, 'hook_messenger_button'));
			}
			//Tawk.to
			if(!empty($this->tawkto_id)){
				add_action('wp_footer',array( $this, 'hook_tawkto_button'));
			}
			//Back To Top
			if($this->backtotop_active == 1){
				add_action('wp_footer', array($this, 'render_html_backtotop'));
			}
			//Hotline
			if(!empty($this->call_header_title) && !empty($this->social_contacts)){
				add_action('wp_footer', array($this, 'render_html_hotline'));
			}
		}
		function mbwph_load_style_script(){
			wp_enqueue_style( 'dashicons' );
			wp_enqueue_style( 'mbwph-style', plugin_dir_url( __FILE__ ) .'assets/css/mbwph-style.css');
			wp_enqueue_script( 'mfb-script', plugin_dir_url( __FILE__ ) . 'assets/js/mbwph-scripts.js', array('jquery'), '1.0.0', false );
		}
		function render_html_backtotop(){
			$html 				= '';
			$btn_color 			= $this->btn_color;
			$btn_backtotop 		= $this->backtotop_active;
			$social_position 	= $this->social_position;
			$positon 			= $this->social_position;
			if (!empty($btn_backtotop)) {
				$html .='<div class="mbwph-btt mbwph-btt-high '.$positon.'" role="button" data-title="Lên đầu trang" style="background-color:'.$btn_color.';">
							<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
								viewBox="0 0 240.835 240.835" style="enable-background:new 0 0 240.835 240.835;" xml:space="preserve"><g>
								<path fill="#FFFFFF" id="Expand_Less" d="M129.007,57.819c-4.68-4.68-12.499-4.68-17.191,0L3.555,165.803c-4.74,4.74-4.74,12.427,0,17.155
									c4.74,4.74,12.439,4.74,17.179,0l99.683-99.406l99.671,99.418c4.752,4.74,12.439,4.74,17.191,0c4.74-4.74,4.74-12.427,0-17.155
									L129.007,57.819z"/>
							</svg>
						</div>';
			}
			echo $html;
		}
		function render_html_hotline(){
			$social_active = $this->social_active;
			$btn_color = $this->btn_color;
			$options = $this->social_contacts;
			$social_position = $this->social_position;
			$positon = $this->social_position;
			$call_header_title = $this->call_header_title;
			$header_title = $call_header_title ? $call_header_title : 'Gọi ngay cho chúng tôi!';
			$url = plugin_dir_url(__FILE__);
			if ($social_active == 1 && !empty($options)) {
				echo '<div class="mbwph-call '.$positon.'">
				<div class="mbwph-call-container '.$positon.'">
					<div class="mbwph-call-header" style="background-color:'.$btn_color.';">
						<div class="mbwph-header-title">'.$header_title.'</div>
						<div class="mbwph-header-close" style="background-color:'.$btn_color.';"><span><svg width="12" height="13" viewBox="0 0 14 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g transform="translate(-4087 108)"><g><path transform="translate(4087 -108)" fill="currentColor" d="M 14 1.41L 12.59 0L 7 5.59L 1.41 0L 0 1.41L 5.59 7L 0 12.59L 1.41 14L 7 8.41L 12.59 14L 14 12.59L 8.41 7L 14 1.41Z"></path></g></g></svg></span></div>
					</div>
					<ul>';
				foreach ( (array) $options as $index => $option ) {	
					if (!empty($option['phone-avatar']) && !empty($option['phone-name']) && !empty($option['phone-number'])) {
						echo '<li>
						<a class="mbwph-call-item" href="tel:'.$option['phone-number'].'">
							<span><img src="'.$url.'assets/images/mbwph-icon-'.$option['phone-avatar'].'.png" alt=""></span>
							<div class="mbwph-contact-child">
								<div class="mbwph-contact-child-title">'.$option['phone-name'].'</div>
								<div class="mbwph-contact-child-desc">'.$option['phone-number'].'</div>
							</div>
						</a>';
					}
				}				
				echo '</ul>
						</div>
						<div class="mbwph-call-main '.$positon.'" style="background-color:'.$btn_color.';" >
							<div class="mbwph-button-border" style="background-color:'.$btn_color.';"></div>
							<div class="mbwph-button-border" style="background-color:'.$btn_color.';"></div>
							<svg class="mbwph-call-button-icon-child" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 30">
								<path class="mbwph-button-call-icon" fill="#FFFFFF" fill-rule="evenodd" d="M940.872414,978.904882 C939.924716,977.937215 938.741602,977.937215 937.79994,978.904882 C937.08162,979.641558 936.54439,979.878792 935.838143,980.627954 C935.644982,980.833973 935.482002,980.877674 935.246586,980.740328 C934.781791,980.478121 934.286815,980.265859 933.840129,979.97868 C931.757607,978.623946 930.013117,976.882145 928.467826,974.921839 C927.701216,973.947929 927.019115,972.905345 926.542247,971.731659 C926.445666,971.494424 926.463775,971.338349 926.6509,971.144815 C927.36922,970.426869 927.610672,970.164662 928.316918,969.427987 C929.300835,968.404132 929.300835,967.205474 928.310882,966.175376 C927.749506,965.588533 927.206723,964.77769 926.749111,964.14109 C926.29156,963.50449 925.932581,962.747962 925.347061,962.154875 C924.399362,961.199694 923.216248,961.199694 922.274586,962.161118 C921.55023,962.897794 920.856056,963.653199 920.119628,964.377388 C919.437527,965.045391 919.093458,965.863226 919.021022,966.818407 C918.906333,968.372917 919.274547,969.840026 919.793668,971.269676 C920.856056,974.228864 922.473784,976.857173 924.43558,979.266977 C927.085514,982.52583 930.248533,985.104195 933.948783,986.964613 C935.6148,987.801177 937.341181,988.444207 939.218469,988.550339 C940.510236,988.625255 941.632988,988.288132 942.532396,987.245549 C943.148098,986.533845 943.842272,985.884572 944.494192,985.204083 C945.459999,984.192715 945.466036,982.969084 944.506265,981.970202 C943.359368,980.777786 942.025347,980.091055 940.872414,978.904882 Z M940.382358,973.54478 L940.649524,973.497583 C941.23257,973.394635 941.603198,972.790811 941.439977,972.202844 C940.97488,970.527406 940.107887,969.010104 938.90256,967.758442 C937.61538,966.427182 936.045641,965.504215 934.314009,965.050223 C933.739293,964.899516 933.16512,965.298008 933.082785,965.905204 L933.044877,966.18514 C932.974072,966.707431 933.297859,967.194823 933.791507,967.32705 C935.117621,967.682278 936.321439,968.391422 937.308977,969.412841 C938.23579,970.371393 938.90093,971.53815 939.261598,972.824711 C939.401641,973.324464 939.886476,973.632369 940.382358,973.54478 Z M942.940854,963.694228 C940.618932,961.29279 937.740886,959.69052 934.559939,959.020645 C934.000194,958.902777 933.461152,959.302642 933.381836,959.8878 L933.343988,960.167112 C933.271069,960.705385 933.615682,961.208072 934.130397,961.317762 C936.868581,961.901546 939.347628,963.286122 941.347272,965.348626 C943.231864,967.297758 944.53673,969.7065 945.149595,972.360343 C945.27189,972.889813 945.766987,973.232554 946.285807,973.140969 L946.55074,973.094209 C947.119782,972.993697 947.484193,972.415781 947.350127,971.835056 C946.638568,968.753629 945.126778,965.960567 942.940854,963.694228 Z" transform="translate(-919 -959)"></path>
							</svg>
							<div class="mbwph-call-button-close-icon">
								<svg width="12" height="13" viewBox="0 0 14 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g transform="translate(-4087 108)"><g><path transform="translate(4087 -108)" fill="currentColor" d="M 14 1.41L 12.59 0L 7 5.59L 1.41 0L 0 1.41L 5.59 7L 0 12.59L 1.41 14L 7 8.41L 12.59 14L 14 12.59L 8.41 7L 14 1.41Z"></path></g></g></svg>
							</div>
						</div>
					</div>';
			}
		}
		function render_html_social(){
			$html = '';
			$btn_color = $this->btn_color;
			$social_active = $this->social_active;
			$btn_message =  $this->btn_message;
			$fb_appID = $this->fb_app_id;
			$fb_pageID = $this->fb_page_id;
			$fb_page_link = $this->fb_page_link;
			$tawkID = $this->tawkto_id;
			$email = $this->mail_to;
			$tawkto =  $this->tawkto_id;
			$zalo_phone = $this->zalo_phone;
			$social_position = $this->social_position;
			$positon = $this->social_position;
			$social_header_title = $this->social_header_title;
			$url = plugin_dir_url(__FILE__);
			$pos_social = 1;
			$header_title = $social_header_title ? $social_header_title : 'Liên hệ ngay với chúng tôi!';
			$gretting_title = $btn_message ? $btn_message : 'Xin chào! chúng tôi có thể giúp gì cho bạn';
			if( !empty($fb_page_link) || !empty($email) || !empty($zalo_phone) || !empty($tawkto) || !empty($fb_pageID) || !empty($btn_message)){
				$html = '<div id="mbwph-contact" class="mbwph-main-contact '.$positon.'">
						<div class="mbwph-contact-container '.$positon.'">
							<div class="mbwph-contact-header" style="background-color:'.$btn_color.';">
								<div class="mbwph-header-title">'.$header_title.'</div>
								<div class="mbwph-contact-header-close" style="background-color:'.$btn_color.';"><span><svg width="12" height="13" viewBox="0 0 14 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g transform="translate(-4087 108)"><g><path transform="translate(4087 -108)" fill="currentColor" d="M 14 1.41L 12.59 0L 7 5.59L 1.41 0L 0 1.41L 5.59 7L 0 12.59L 1.41 14L 7 8.41L 12.59 14L 14 12.59L 8.41 7L 14 1.41Z"></path></g></g></svg></span></div>
							</div>
							<ul class="">';
				if(!empty($fb_page_link)){
					$html .='<li>
							<a class="mbwph-contact-item mbwph-contact-facebook" href="'.$fb_page_link.'" target="blank">
								<span><img src="'.$url.'assets/images/mbwph-icon-facebook.png" alt=""></span>
								<div class="mbwph-contact-child">
									<div class="mbwph-contact-child-title">Facebook</div>
								</div>
							</a>
						</li>';
				}
				if(!empty($email)){
					$html .='<li>
								<a class="mbwph-contact-item mbwph-contact-mail" href="mailto:'.$email.'" target="blank">
									<span><img src="'.$url.'assets//images/mbwph-icon-email.png" alt=""></span>
									<div class="mbwph-contact-child">
										<div class="mbwph-contact-child-title">'.$email.'</div>
									</div>
								</a>
							</li>';
				}
				if(!empty($zalo_phone)){
					$html .='<li>
								<a class="mbwph-contact-item mbwph-contact-zalo" href="http://zalo.me/'.$zalo_phone.'" target="blank">
									<span><img src="'.$url.'assets/images/mbwph-icon-zalo.png" alt=""></span>
									<div class="mbwph-contact-child">
										<div class="mbwph-contact-child-title">'.$zalo_phone.'</div>
									</div>
								</a>
							</li>';
				}
				if(!empty($tawkto)){
					$html .='<li>
								<a class="mbwph-contact-item mbwph-contact-tawkto" href="javascript:void(Tawk_API.toggle())">
									<span><img src="'.$url.'assets/images/mbwph-icon-chat.png" alt=""></span>
									<div class="mbwph-contact-child">
										<div class="mbwph-contact-child-title">Hỗ trợ online</div>
									</div>
								</a>
							</li>';
				}
				if(!empty($fb_pageID)){
					$html .='<li>
								<a class="mbwph-contact-item mbwph-contact-messenger" href="/">
									<span><img src="'.$url.'assets/images/mbwph-icon-messenger.png" alt=""></span>
									<div class="mbwph-contact-child">
										<div class="mbwph-contact-child-title">Messenger</div>
									</div>
								</a>
							</li>';
				}
				$html .='
						</ul>
					</div>
					<div class="mbwph-contact-button '.$positon.'" style="background-color:'.$btn_color.';">
						<div class="mbwph-button-border" style="background-color:'.$btn_color.';"></div>
						<div class="mbwph-button-border" style="background-color:'.$btn_color.';"></div>
						<div class="mbwph-button-group-icon">
							<div class="mbwph-button-icon">
							<svg class="mbwph-button-icon-child" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 29">
								<path class="mbwph-button-chat-icon" fill="#FFFFFF" fill-rule="evenodd" d="M878.289968,975.251189 L878.289968,964.83954 C878.289968,963.46238 876.904379,962 875.495172,962 L857.794796,962 C856.385491,962 855,963.46238 855,964.83954 L855,975.251189 C855,976.924031 856.385491,978.386204 857.794796,978.090729 L860.589592,978.090729 L860.589592,981.876783 L860.589592,983.76981 L861.521191,983.76981 C861.560963,983.76981 861.809636,982.719151 862.45279,982.823297 L866.179185,978.090729 L875.495172,978.090729 C876.904379,978.386204 878.289968,976.924031 878.289968,975.251189 Z M881.084764,971.465135 L881.084764,976.197702 C881.43316,978.604561 879.329051,980.755508 876.426771,980.93027 L868.042382,980.93027 L866.179185,982.823297 C866.400357,983.946455 867.522357,984.94992 868.973981,984.716324 L876.426771,984.716324 L879.221567,988.502377 C879.844559,988.400361 880.153166,989.448891 880.153166,989.448891 L881.084764,989.448891 L881.084764,987.555864 L881.084764,984.716324 L882.947962,984.716324 C884.517696,984.949819 885.742758,983.697082 885.742758,981.876783 L885.742758,974.304675 C885.742659,972.717669 884.517597,971.465135 882.947962,971.465135 L881.084764,971.465135 Z" transform="translate(-855 -962)"></path>
							</svg>
							</div>
						</div>
						<div class="mbwph-close-button-icon">
							<svg width="12" height="13" viewBox="0 0 14 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g transform="translate(-4087 108)"><g><path transform="translate(4087 -108)" fill="currentColor" d="M 14 1.41L 12.59 0L 7 5.59L 1.41 0L 0 1.41L 5.59 7L 0 12.59L 1.41 14L 7 8.41L 12.59 14L 14 12.59L 8.41 7L 14 1.41Z"></path></g></g></svg>
						</div>
					</div>';
				if (!empty($btn_message)) {
					$html .='<div class="mbwph-contact-greeting '.$positon.'">
								<div class="mbwph-contact-greeting-content">'.$gretting_title.'</div>
								<div class="mbwph-contact-close-greeting" style="background-color:'.$btn_color.';"><span><svg width="12" height="13" viewBox="0 0 14 14" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g transform="translate(-4087 108)"><g><path transform="translate(4087 -108)" fill="currentColor" d="M 14 1.41L 12.59 0L 7 5.59L 1.41 0L 0 1.41L 5.59 7L 0 12.59L 1.41 14L 7 8.41L 12.59 14L 14 12.59L 8.41 7L 14 1.41Z"></path></g></g></svg></span></div>
							</div>';
				}
				$html .='</div>';
			}
			echo $html;
		}
		function hook_facebook_messenger_scripts(){
			$html = '';
			$btn_color = $this->btn_color;
			$social_position = $this->social_position;
			$fb_pageID = $this->fb_page_id;
			$html = '<div class="mbwph-fbc '.$social_position.'"><div id="fb-root"></div> </div>
						<script>
						window.fbAsyncInit = function() {
						FB.init({
							xfbml            : true,
							version          : "v8.0"
						});
						};
						(function(d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0];
						if (d.getElementById(id)) return;
						js = d.createElement(s); js.id = id;
						js.src = "https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js";
						fjs.parentNode.insertBefore(js, fjs);
					}(document, "script", "facebook-jssdk"));</script>';
			$html .= '<div class="fb-customerchat"
						attribution=setup_tool
						page_id="'.$fb_pageID.'"
						theme_color="'.$btn_color.'"
						logged_in_greeting=""
						logged_out_greeting=""
						alignment="left">
					</div>';
			echo $html;
		}
		function hook_tawkto_button(){
			$tawkto_id = $this->tawkto_id;
			//<!--Start of Tawk.to Script-->
			$html =	'<script type="text/javascript">
						var Tawk_API=Tawk_API || {}, Tawk_LoadStart=new Date();
						(function(){
						var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
						s1.async=true;
						s1.src="https://embed.tawk.to/'. $tawkto_id .'/default";
						s1.charset="UTF-8";
						s1.setAttribute("crossorigin","*");
						s0.parentNode.insertBefore(s1,s0);
						})();
					</script>';
			//<!--End of Tawk.to Script-->
			echo $html;
		}
	}
}
