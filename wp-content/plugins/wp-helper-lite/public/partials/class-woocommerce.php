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

if ( defined( 'ABSPATH' ) && ! class_exists( 'mbwph_WooCommerce_Load_Settings' ) ) {
	class mbwph_WooCommerce_Load_Settings{
		private $WP_HELPER;
		private $disableDashboard, $enablequickBuy, $callforPrice,$callforPricePhone, $autoUpdateCart, $optimizeCheckout,$billingCompany,$billingFirstName,$billingPostcode,$billingCountry,$billingCity,$billingState,$billingAddress2,$shippingCompany,$shippingPostcode,$shippingCountry,$shippingCity,$shippingState,$shippingAddress2,$scriptData;
		/**
		* Class constructor.
		*/
		public function __construct() {
			$this->WP_HELPER = 'wp-helper';
			$this->mwph_woo_setup_vars();
			$this->mwph_woo_hooks();
		}
		function mwph_woo_setup_vars(){
			$this->disableDashboard = get_option('disable_dashboard');
			$this->enablequickBuy = get_option('quick_buy');
			$this->callforPrice = get_option('call_for_price');
			$this->callforPricePhone = get_option('call_for_price_phone');
			$this->autoUpdateCart = get_option('auto_update_cart');
			$this->optimizeCheckout = get_option('optimize_checkout');
			$this->billingCompany = get_option('billing_company');
			$this->billingFirstName = get_option('billing_first_name');
			$this->billingPostcode = get_option('billing_postcode');
			$this->billingCountry = get_option('billing_country');
			$this->billingCity = get_option('billing_city');
			$this->billingState = get_option('billing_state');
			$this->billingAddress2 = get_option('billing_address_2');

			// $this->shippingCompany = get_option('shipping_company');
			// $this->shippingPostcode = get_option('shipping_postcode');
			// $this->shippingPostcode = get_option('shipping_postcode');
			// $this->shippingCountry = get_option('shipping_country');
			// $this->$shippingCity = get_option('shipping_city');
			// $this->$shippingState = get_option('shipping_state');
			// $this->shippingAddress2 = get_option('shipping_address_2');
		}
		private function mwph_woo_hooks(){
			add_filter( 'woocommerce_product_single_add_to_cart_text', array( $this,'woocommerce_custom_single_add_to_cart_text') );

			if(!empty($this->callforPrice) && $this->callforPrice == 1 && !empty($this->call_for_price_phone)){
				//add_filter('woocommerce_empty_price_html', array( $this,'mwph_call_for_price_button'));
				//add_filter('woocommerce_product_single_add_to_cart_text', array( $this,'mwph_call_for_price_button'));
			}
			//if(!empty($this->callforPrice) && $this->callforPrice == 1){
				//add_filter('woocommerce_empty_price_html', array( $this,'mwph_call_for_price_button'));
			//}
			//if(!empty($this->optimizeCheckout) && $this->optimizeCheckout == 1){
				add_filter( 'woocommerce_checkout_fields' , array( $this,'mwph_custom_override_checkout_fields'),99 );
				add_action( 'wp_enqueue_scripts', array( $this,'mwph_manage_woocommerce_styles'), 99 );
			//}
			if(!empty($this->autoUpdateCart) && $this->autoUpdateCart == 1){				
				add_action('wp_head', array( $this,'mwph_frontpage_woocommerce_styles'));
				add_action('wp_footer',array( $this,'mwph_auto_update_cart_script'));
			}
		}
		function mwph_frontpage_woocommerce_styles() {
			//wp_enqueue_style( 'nova-style', get_stylesheet_directory_uri() . '/assets/css/nova-style.css' );
			//wp_enqueue_style( 'mwph-woo-style',  WP_HELPER_URL . 'public/partials/assets/css/woocommerce.css');
			?>
				<style>
					.continue-shopping .button.primary.mt-0.pull-left.small,
					.woocommerce button[name="update_cart"],
					.woocommerce input[name="update_cart"] {
						display: none !important;
					}
				</style>
			<?php
		}
		function mwph_auto_update_cart_script(){
			?>
			
			<script>
				var timeout;
				jQuery( function( $ ) {
					$('.woocommerce').on('change', 'input.qty', function(){
						if ( timeout !== undefined ) {
							clearTimeout( timeout );
						}
						timeout = setTimeout(function() {
							$("[name='update_cart']").trigger("click");
						}, 1000 ); // 1 second delay, half a second (500) seems comfortable too
				 
					});
				} );


			</script>
			<?php
		}
		function woocommerce_custom_single_add_to_cart_text() {
			return __( 'Thêm vào giỏ hàng', 'mwph' );
		}
		function mwph_call_for_price_button() {
			$html = '<ul class="custom_button">';
			if(is_product()){
				$html .= '<li><a href="tel:'.$this->callforPricePhone.'" class="button primary"><i class="fa fa-phone"></i> Liên hệ</a></li>';
			}
			$html .= '</ul>';
			return $html;
		}
		function mwph_manage_woocommerce_styles(){
			//remove generator meta tag
			
				
		if (isset($GLOBALS['woocommerce'])) {
    		remove_action( 'wp_head', array( $GLOBALS['woocommerce'], 'generator' ) );
		}
	    
	    //first check that woo exists to prevent fatal errors
	    if ( function_exists( 'is_woocommerce' ) )
	    {
	        //dequeue scripts and styles
	        if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() )
	        {
		        wp_dequeue_style( 'woocommerce_frontend_styles' );
		        wp_dequeue_style( 'woocommerce_fancybox_styles' );
		        wp_dequeue_style( 'woocommerce_chosen_styles' );
		        wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
		        wp_dequeue_script( 'wc_price_slider' );
		        wp_dequeue_script( 'wc-single-product' );
		        wp_dequeue_script( 'wc-add-to-cart' );
		        wp_dequeue_script( 'wc-cart-fragments' );
		        wp_dequeue_script( 'wc-checkout' );
		        wp_dequeue_script( 'wc-add-to-cart-variation' );
		        wp_dequeue_script( 'wc-single-product' );
		        wp_dequeue_script( 'wc-cart' );
		        wp_dequeue_script( 'wc-chosen' );
		        wp_dequeue_script( 'woocommerce' );
		        wp_dequeue_script( 'prettyPhoto' );
		        wp_dequeue_script( 'prettyPhoto-init' );
		        wp_dequeue_script( 'jquery-blockui' );
		        wp_dequeue_script( 'jquery-placeholder' );
		        wp_dequeue_script( 'fancybox' );
		        wp_dequeue_script( 'jqueryui' );
	        }
	    }
		}
		function mwph_custom_override_checkout_fields( $fields ) {
			if(!empty($this->billingCompany) && $this->billingCompany == 1){
			  unset($fields['billing']['billing_company']);
				unset($fields['shipping']['shipping_company']);
			}
			if(!empty($this->billingFirstName) && $this->billingFirstName == 1){
			  unset($fields['billing']['billing_first_name']);
				$fields['billing']['billing_last_name'] = array(
				  'label' => __('Họ và tên', 'mbwph'),
				  'placeholder' => _x('Nhập đầy đủ họ và tên của bạn', 'placeholder', 'mbwph'),
				  'required' => true,
				  'class' => array('form-row-wide'),
				  'clear' => true
				);
				unset($fields['shipping']['shipping_first_name']);
				$fields['shipping']['shipping_last_name'] = array(
				  'label' => __('Họ và tên', 'mbwph'),
				  'placeholder' => _x('Nhập đầy đủ họ và tên của người nhận', 'placeholder', 'mbwph'),
				  'required' => true,
				  'class' => array('form-row-wide'),
				  'clear' => true
				);
			}
			if(!empty($this->billingPostcode) && $this->billingPostcode == 1){
			  unset($fields['billing']['billing_postcode']);
				unset($fields['shipping']['shipping_postcode']);
			}
			if(!empty($this->billingCountry) && $this->billingCountry == 1){
			  unset($fields['billing']['billing_country']);
				unset($fields['shipping']['shipping_country']);
			}
			if(!empty($this->billingCity) && $this->billingCity == 1){
			  unset($fields['billing']['billing_city']);
				unset($fields['shipping']['shipping_city']);
			}
			if(!empty($this->billingState) && $this->billingState == 1){
			  unset($fields['billing']['billing_state']);
				unset($fields['shipping']['shipping_state']);
			}
			if(!empty($this->billingAddress2) && $this->billingAddress2 == 1){
			  unset($fields['billing']['billing_address_2']);
			  $fields['billing']['billing_address_1']['placeholder'] = 'Thông tin địa chỉ người nhận';
				unset($fields['shipping']['shipping_address_2']);

			}

		  $fields['shipping']['shipping_phone'] = array(
		    'label' => __('Điện thoại', 'mbwph'),
		    'placeholder' => _x('Số điện thoại người nhận hàng', 'placeholder', 'mbwph'),
		    'required' => true,
		    'class' => array('form-row-wide'),
		    'clear' => true
		  );

		  $fields['shipping']['shipping_address_1']['placeholder'] = 'Ví dụ: Số xx Núi Thành, P. 13, Q. Tân Bình, Tp. HCM';

		  return $fields;
		}

	}
}new mbwph_WooCommerce_Load_Settings();
