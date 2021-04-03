<?php

/**
 * Controls settings of plugin
 *
 * @package    WP_HELPER
 * @subpackage WP_HELPER/admin/settings
 */
class WP_HELPER_Insert_Header_Footer extends WP_HELPER_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $WP_HELPER    The ID of this plugin.
	 */
	private $WP_HELPER;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $WP_HELPER       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $WP_HELPER ) {
		$this->id    = 'header_footer';
		$this->label = __( 'Header & Footer', 'mbwph' );
		$this->WP_HELPER = $WP_HELPER;
	}

	/**
	 * Creates our settings sections with fields etc. 
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function mbwph_settings_header_footer_init() {		
		$this->header_footer_post_init();		
	}

	/**
	 * Creates post settings sections with fields etc. 
	 *
	 * @since    1.1.0
	 * @access   public
	 */
	public function header_footer_post_init() {
		// add_settings_section( $id, $title, $callback, $menu_slug );
		add_settings_section(
			$this->WP_HELPER . '-header-footer-options', // Section ID 
			apply_filters( $this->WP_HELPER . '-display-section-title', __( '', $this->WP_HELPER ) ),// Section Title
			array( $this, 'display_options_section' ), // Callback			
			$this->WP_HELPER . '_header_footer_tab' // What Page?  This makes the section show up on the Header Footer Settings Page
		);		
		add_settings_field(
			'header_script', // Option ID
			apply_filters( $this->WP_HELPER . '-txtarea-header-label', __( 'Header Scripts', 'mbwph' ) ), // Label
			array( $this, 'mbwph_txtarea_header_field' ), // !important - This is where the args go!
			$this->WP_HELPER . '_header_footer_tab',		// Page it will be displayed
			$this->WP_HELPER . '-header-footer-options', 	// Name of our section
			array( // The $args
				'header_script' // Should match Option ID
			) 
		);
		add_settings_field(
			'footer_script', // Option ID
			apply_filters( $this->WP_HELPER . '-txtarea-footer-label', __( 'Footer Scripts', 'mbwph' ) ), // Label
			array( $this, 'mbwph_txtarea_footer_field' ), // !important - This is where the args go!
			$this->WP_HELPER . '_header_footer_tab',		// Page it will be displayed
			$this->WP_HELPER . '-header-footer-options', 	// Name of our section
			array( // The $args
				'footer_script' // Should match Option ID
			) 
		);
		register_setting(			
			$this->WP_HELPER . '_header_footer_tab',
			'header_script' //Options containt value field			
			//array( $this, 'mbwph_settings_sanitize' )
		);
		register_setting(			
			$this->WP_HELPER . '_header_footer_tab',
			'footer_script' //Options containt value field			
			//array( $this, 'mbwph_settings_sanitize' )
		);		
	}
	
	/**
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	public function display_options_section( $params ) {
		_e('<h3><span class="dashicons dashicons-editor-code"></span>Header & Footer</h3>','mbwph');
		_e('<span class="description">Chèn mã nhúng Google Analytics, Facebook...an toàn, không cần can thiệp vào code</span>','mbwph');
	}
	public function mbwph_txtarea_header_field() {				
		$content 	= get_option('header_script');
		echo '<textarea name="header_script" class="widefat" rows="8" style="font-family:Courier New;">';
		echo esc_html($content) . '</textarea>';
		echo '<span class="description">';
		echo esc_html_e( 'Nội dung sẽ được chèn vào header.', 'mbwph' );
		echo '</span><br><br>';
	}
	public function mbwph_txtarea_footer_field() {
		$content 	= get_option('footer_script');
		echo '<textarea name="footer_script" class="widefat" rows="8" style="font-family:Courier New;">';
		echo esc_html($content) . '</textarea>';
		echo '<span class="description">';
		echo esc_html_e('Nội dung sẽ được chèn vào footer.', 'mbwph' );
		echo '</span>';
		
	}
	
}