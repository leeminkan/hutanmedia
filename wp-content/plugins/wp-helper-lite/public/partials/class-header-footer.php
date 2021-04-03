<?php
if ( defined( 'ABSPATH' ) && ! class_exists( 'mbwph_Header_Footer_Load_Settings' ) ) {		
	class mbwph_Header_Footer_Load_Settings{
		private $WP_HELPER;
		private $headerScript, $footerScript;
		/**
		* Class constructor.
		*/
		public function __construct() {
			$this->WP_HELPER = 'wp-helper';
			$this->setup_vars();
			$this->hooks();
		}
		function setup_vars(){
			$this->headerScript = get_option('header_script') ;
			$this->footerScript = get_option('footer_script');
		}
		private function hooks(){
			if ( ! empty($this->headerScript)){
				add_action( 'wp_head',array( $this, 'mwp_render_header_script'),1);
			}
			if ( ! empty($this->footerScript)){
				add_action( 'wp_footer',array( $this, 'mwp_render_footer_script'),1);
			}
		}		
		function mwp_render_header_script(){
			echo wp_unslash( $this->headerScript );
		}
		function mwp_render_footer_script(){
			echo wp_unslash( $this->footerScript );
		}
	
	}
}