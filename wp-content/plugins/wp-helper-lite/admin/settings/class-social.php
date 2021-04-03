<?php

/**
 * Controls settings of plugin
 *
 * @package    WP_HELPER
 * @subpackage WP_HELPER/admin/settings
 */
class WP_HELPER_Social extends WP_HELPER_Admin {

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
		$this->id    = 'social';
		$this->label = __( 'Kênh liên hệ', 'mbwph' );
		$this->WP_HELPER = $WP_HELPER;
	}

	/**
	 * Creates our settings sections with fields etc.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function mbwph_settings_social_init() {
		$this->social_post_init();
	}

	/**
	 * Creates post settings sections with fields etc.
	 *
	 * @since    1.1.0
	 * @access   public
	 */
	public function social_post_init() {
		// add_settings_section( $id, $title, $callback, $menu_slug );
		add_settings_section(
			$this->WP_HELPER . '-social-options', // section
			apply_filters( $this->WP_HELPER . '-social-section-title', __( '', 'mbwph' ) ),
			array( $this, 'display_social_section' ),
			$this->WP_HELPER . '_social_tab'
		);
		add_settings_section(
			$this->WP_HELPER . '-style-options', // section
			apply_filters( $this->WP_HELPER . '-style-section-title', __( '', $this->WP_HELPER ) ),
			array( $this, 'display_style_section' ),
			$this->WP_HELPER . '_social_tab'
		);
		add_settings_section(
			$this->WP_HELPER . '-hotline-options', // section
			apply_filters( $this->WP_HELPER . '-hotline-section-title', __( '', $this->WP_HELPER ) ),
			array( $this, 'display_hotline_section' ),
			$this->WP_HELPER . '_social_tab'
		);
		add_settings_section(
			$this->WP_HELPER . '-general-contact-options', // section
			apply_filters( $this->WP_HELPER . '-general-contact-title', __( '', 'mbwph' ) ),
			array( $this, 'display_general_contact_section' ),
			$this->WP_HELPER . '_social_tab'
		);
		add_settings_section(
			$this->WP_HELPER . '-backtotop-options', // section
			apply_filters( $this->WP_HELPER . '-backtotop-section-title', __( '', $this->WP_HELPER ) ),
			array( $this, 'print_backtotop_section' ),
			$this->WP_HELPER . '_social_tab'
		);

		// add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );
		add_settings_field(
			'social_active',
			apply_filters( $this->WP_HELPER . '-social-active-label', __( 'Kích hoạt', 'mbwph' ) ),
			array( $this, 'mbwph_opt_social_active_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-social-options', // section to add to
			array( // The $args
				'social_active' // Should match Option ID
			)
		);
		add_settings_field(
			'backtotop_active',
			apply_filters( $this->WP_HELPER . '-backtotop-active-label', __( 'Kích hoạt', 'mbwph' ) ),
			array( $this, 'mbwph_opt_backtotop_active_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-backtotop-options', // section to add to
			array( // The $args
				'backtotop_active' // Should match Option ID
			)
		);
		add_settings_field(
			'btn_color',
			apply_filters( $this->WP_HELPER . '-btn-color-label', __( 'Màu nút liên hệ', 'mbwph' ) ),
			array( $this, 'mbwph_btn_color_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-style-options', // section to add to
			array(
				'btn_color'
			)
		);
		add_settings_field(
			'btn_message',
			apply_filters( $this->WP_HELPER . '-btn-message-label', __( 'Lời chào mặc định', 'mbwph' ) ),
			array( $this, 'mbwph_txt_btn_message_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-style-options', // section to add to
			array(
				'btn_message'
			)
		);
		add_settings_field(
			'call_header_title',
			apply_filters( $this->WP_HELPER . '-call_header_title-label', __( 'Tiêu đề', 'mbwph' ) ),
			array( $this, 'mbwph_txt_call_header_title_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-hotline-options', // section to add to
			array(
				'call_header_title'
			)
		);
		add_settings_field(
			'social_header_title',
			apply_filters( $this->WP_HELPER . '-social_header_title-label', __( 'Tiêu đề', 'mbwph' ) ),
			array( $this, 'mbwph_txt_social_header_title_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-general-contact-options', // section to add to
			array(
				'social_header_title'
			)
		);
		add_settings_field(
			'social_contacts',
			apply_filters( $this->WP_HELPER . '-social-contacts-label', __( 'Số điện thoại', 'mbwph' ) ),
			array( $this, 'mbwph_txt_social_contacts_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-hotline-options', // section to add to
			array(
      			'social_contacts'
			)
		);
		add_settings_field(
			'social_position',
			apply_filters( $this->WP_HELPER . '-social-position-label', __( 'Vị trí', 'mbwph' ) ),
			array( $this, 'mbwph_opt_social_position_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-style-options', // section to add to
			array(
				'social_position'
			)
		);
		// //Liên hệ chung: Mail, Zalo, tawkto, fanpage, messenger...
		add_settings_field(
			'mail_to',
			apply_filters( $this->WP_HELPER . '-mail-to-label', __( 'Địa chỉ Email', 'mbwph' ) ),
			array( $this, 'mbwph_txt_mail_to_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-general-contact-options' // section to add to
		);
		add_settings_field(
			'fb_page_link',
			apply_filters( $this->WP_HELPER . '-fb-page-link-label', __( 'Facebook', 'mbwph' ) ),
			array( $this, 'mbwph_txt_fb_page_link_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-general-contact-options' // section to add to
		);
		add_settings_field(
			'zalo_phone',
			apply_filters( $this->WP_HELPER . '-zalo-phone-label', __( 'Zalo Chat', 'mbwph' ) ),
			array( $this, 'mbwph_txt_zalo_phone_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-general-contact-options' // section to add to
		);
		add_settings_field(
			'tawkto_id',
			apply_filters( $this->WP_HELPER . '-tawkto-id-label', __( 'Tawk.to Chat', 'mbwph' ) ),
			array( $this, 'mbwph_txt_tawkto_id_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-general-contact-options' // section to add to
		);

		// Messenger Setting
		add_settings_field(
			'fb_page_id',
			apply_filters( $this->WP_HELPER . '-fb-page-id-label', __( 'Facebook Page ID', 'mbwph' ) ),
			array( $this, 'mbwph_txt_fb_page_id_field' ),
			$this->WP_HELPER . '_social_tab',    // Page
			$this->WP_HELPER . '-general-contact-options' // section to add to
		);

		register_setting($this->WP_HELPER . '_social_tab','social_active');
		register_setting($this->WP_HELPER . '_social_tab','btn_color');
		register_setting($this->WP_HELPER . '_social_tab','btn_message');
		register_setting($this->WP_HELPER . '_social_tab','call_header_title');
		register_setting($this->WP_HELPER . '_social_tab','social_header_title');
		register_setting($this->WP_HELPER . '_social_tab','social_contacts');
		register_setting($this->WP_HELPER . '_social_tab','social_position');
		register_setting($this->WP_HELPER . '_social_tab','mail_to');
		register_setting($this->WP_HELPER . '_social_tab','fb_page_link');
		register_setting($this->WP_HELPER . '_social_tab','zalo_phone');
		register_setting($this->WP_HELPER . '_social_tab','tawkto_id');
		register_setting($this->WP_HELPER . '_social_tab','fb_page_id');
		register_setting($this->WP_HELPER . '_social_tab','backtotop_active');
	}

	/**
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	
	 */
	public function display_social_section( $params ) {
		_e( '<h3><span class="dashicons dashicons-format-chat"></span>Kênh liên hệ</h3>','mbwph');
		_e( '<span class="description">Bộ công cụ tiện lợi giúp kết nối với khách hàng dễ dàng hơn.</span>','mbwph');
	} // display_options_section()
	public function display_style_section( $params ) {
		_e( '<h4>Kiểu thiết kế</h4>','mbwph');
	} // display_options_section()
	public function display_hotline_section( $params ) {
		_e( '<h4>Liên hệ điện thoại</h4>','mbwph');
	}
	public function display_general_contact_section( $params ) {
		_e( '<h4>Liên hệ chung</h4>','mbwph');
	} // display_options_section()
	public function print_backtotop_section( $params ) {
		_e( '<h4>Trở lại đầu trang</h4>','mbwph');
		_e( '<span class="description">Thêm nút cuộn lên đầu trang rất tiện ích cho người dùng.</span>','mbwph');
	}
	/**
	 * Enable/Disable Checkbox Field
	 *
	 * @since 		1.0.0
	 * @return 		mixed 			The settings field
	 */
	public function mbwph_opt_social_active_field() {
			$option 	= get_option('social_active');
		?>
			<div id="mwph-social_active" class="custom-switch custom-switch-label-onoff">
				<input class="custom-switch-input" type="checkbox" id="social_active" name="social_active" value="1" <?php checked( $option, 1 , true ); ?> />
				<label class="custom-switch-btn" for="social_active"></label>
			</div>
		<?php
	} // mbwph_opt_social_active_field()
	public function mbwph_opt_backtotop_active_field() {
		$option 	= get_option('backtotop_active');
		?>
			<div id="mwph-backtotop_active" class="custom-switch custom-switch-label-onoff">
				<input class="custom-switch-input" type="checkbox" id="backtotop_active" name="backtotop_active" value="1" <?php checked( $option, 1 , true ); ?> />
				<label class="custom-switch-btn" for="backtotop_active"></label>
			</div>
		<?php
	} // mbwph_opt_backtotop_active_field()
	public function mbwph_btn_color_field() {
		$option 	= get_option( 'btn_color' );
		if ( !empty( $option ) ) {
			$btn_color = esc_attr($option);
		}
		else
		{
			$btn_color = "#17568c";
		}
		?>
			<div class="placeholder">
				<input type="text" id="btn_color" name="btn_color" value="<?php echo( $btn_color); ?>" data-default-color="#17568c" class="color-field"></input>
			</div>
		<?php	
	} // mb_wp_manage_options_field()
	public function mbwph_txt_btn_message_field() {
		$options 	= get_option('btn_message');
		$message 	= $options ? $options : 'Xin chào! Chúng tôi có thể giúp gì cho bạn?';
		?>
			<div class="form-group social-group">
				<input type="text" id="btn_message" name="btn_message" value="<?php echo($options); ?>" class="form-control" placeholder="<?php echo($message); ?>"/>
			</div>
		<?php	
	} //mbwph_txt_btn_message_field
	public function mbwph_txt_call_header_title_field() {

		$options 	= get_option('call_header_title');
		$header_title 	= $options ? $options : 'Gọi ngay cho chúng tôi!';
		?>
			<div class="form-group social-group">
				<input type="text" id="call_header_title" name="call_header_title" value="<?php echo($options); ?>" class="form-control" placeholder="<?php echo($header_title); ?>"/>
			</div>
		<?php	
	} //mbwph_txt_call_header_title_field
	public function mbwph_txt_social_header_title_field() {

		$options 	= get_option('social_header_title');
		$header_title 	= $options ? $options : 'Liên hệ ngay với chúng tôi!';
		?>
			<div class="form-group social-group">
				<input type="text" id="social_header_title" name="social_header_title" value="<?php echo($options); ?>" class="form-control" placeholder="<?php echo($header_title); ?>"/>
			</div>
		<?php	
	} //mbwph_txt_social_header_title_field
	public function mbwph_txt_social_contacts_field($args) {
		$options 			= get_option('social_contacts');
		$isActivePremium    = is_plugin_active('wp-helper-premium/wp-helper-premium.php');
		$count = 0;
		echo '<div id="mbwhp-inputsWrapper">';
		foreach ( (array) $options as $index => $option ) {			
			if (!empty($option['phone-avatar']) && !empty($option['phone-name']) && !empty($option['phone-number'])) {
				echo    '<div name="mytext[]" class="phone-field" id="'.$index.'">
							<div class="mbmwph-phone-field form-row social-group pb-2">
								<div class="form-group col-md-3">
									<div class="input-group">
										<div class="input-group-prepend">
									</div>
									<select name="social_contacts['.$index .'][phone-avatar]" class="custom-select selectpicker call-number-field">
										<option id="avatar">Chọn ảnh</option>
										<option value="1" '. ($option['phone-avatar'] == 1 ? "selected=selected":"").'>Nam</option>
										<option value="2" '. ($option['phone-avatar'] == 2 ? "selected=selected":"").'>Nữ</option>
										<option value="3" '. ($option['phone-avatar'] == 3 ? "selected=selected":"").'>Support 24/7</option>
									</select>
								</div>
							</div>
							<div class="form-group col-md-4">
								<input type="text" id="social_contacts['.$index .'][phone-name]" name="social_contacts['.$index .'][phone-name]" value="'.$option['phone-name'].'" class="form-control" placeholder="Vị trí"/>
							</div>
							<div class="form-group col-md-4">
								<input type="tel" title="Bạn cần điền đúng số điện thoại" id="social_contacts['.$index .'][phone-number]" name="social_contacts['.$index .'][phone-number]" value="'.$option['phone-number'].'" class="form-control mbwph-phone-number" placeholder="Vd: 0909 XXX XXX"/>
							</div>
							<a href="#" type="button" class="mbwhp-removeField"> 
								<span class="dashicons dashicons-dismiss" id="mbwhp-remove-phone"></span>
					   		</a>
							</div>
						</div>';
			$count++;
			}
			if ((!$isActivePremium) && ($count == 2)) break;
		}
		echo '</div>';
		if ($isActivePremium) {echo '<div id="premium-active"></div>';}
		if ((!$isActivePremium) && ($count == 2)) {
			echo '
				<div id="mbwhp-AddMoreFieldId" class="col-sm-12 p-0">
					<a type="button" href="#" id="mbwhp-AddMoreFieldBox" class="btn btn-secondary btn-sm disabled">
						Thêm liên hệ
					</a>
					<div id="mbwhp-lineBreak" class="mbwhp-lineBreak-before">
						<span class="description">Nâng cấp <strong class="premium-text">Premium</strong> để thêm liên hệ.</span>
					</div><br><br>
				</div>';
		} 
		else if (($isActivePremium) && ($count == 5)) {
			echo '<div id="mbwhp-AddMoreFieldId" class="col-sm-12 p-0" style="display:none">
					<a type="button"  href="#" id="mbwhp-AddMoreFieldBox" class="btn btn-success btn-sm">
						Thêm liên hệ
					</a>
					<div id="mbwhp-lineBreak"></div><br><br>
				</div>';
		} else {
			echo '<div id="mbwhp-AddMoreFieldId" class="col-sm-12 p-0">
					<a type="button"  href="#" id="mbwhp-AddMoreFieldBox" class="btn btn-success btn-sm">
						Thêm liên hệ
					</a>
					</a><div id="mbwhp-lineBreak"></div><br><br>
				</div>';
		}
		
		?>
		<span class="error_form" id="mbwph_phone_name_error_message"></span>
	<?php 
	} //mbwph_txt_social_contacts_field
	
	public function mbwph_opt_social_position_field() {
		$position 	= get_option( 'social_position' );
		if ( empty( $position ) ) {
			$position = 'onRight';
		}
		?>
			<div class="mwph-contact-position custom-control custom-radio custom-control-inline">
				<input id="social_position_left" name="social_position" type="radio" value="onLeft" <?php if ($position == 'onLeft') { ?> checked="checked"<?php } ?> class="custom-control-input"/>
				<label class="custom-control-label" for="social_position_left">Trái</label>
			</div>
			<div class="mwph-contact-position custom-control custom-radio custom-control-inline">
				<input id="social_position_right" name="social_position" type="radio" value="onRight" <?php if ($position == 'onRight') { ?> checked="checked"<?php } ?> class="custom-control-input"/>
				<label class="custom-control-label" for="social_position_right">Phải</label>
			</div>
		<?php
	} //mbwph_opt_social_position_field
	public function mbwph_btn_theme_color_field() {
		$options 	= get_option( $this->WP_HELPER . '_social_options' );
		if ( isset( $options['theme-color'] ) ) {
			$theme_color = esc_attr($options['theme-color']);
		}
		else
		{
			$theme_color = "#17568c";
		}
		?>
			<div class="placeholder">
				<input type="text" id="<?php echo $this->WP_HELPER; ?>_social_options[theme-color]" name="<?php echo $this->WP_HELPER; ?>_social_options[theme-color]" value="<?php echo( $theme_color); ?>" data-default-color="#17568c" class="color-field"></input>
			</div>
		<?php	
	} // mbwph_btn_theme_color_field()
	public function mbwph_txt_greeting_message_field() {
		$options 	= get_option( 'btn_message' );
		?>
			<div class="form-group social-group">
				<input type="text" id="btn_message" name="btn_message" value="<?php echo($options); ?>" class="form-control" placeholder="Lời chào"/>
			</div>
		<?php
	} //mbwph_txt_greeting_message_field
	public function mbwph_txt_fb_page_id_field() {
		$options 	= get_option( 'fb_page_id' );
		?>
			<div class="form-group social-group">
				<input type="text" id="fb_page_id" name="fb_page_id" value="<?php echo($options); ?>" class="form-control" placeholder="Page ID ứng dụng"/>
				<span class="description">Xem hướng dẫn nhận Page ID từ Facebook <a href="https://wiki.matbao.net/kb/huong-dan-lay-id-fanpage-facebook/" target="_blank">tại đây</a>.</span>
			</div>
		<?php
	} // mbwph_txt_fb_page_id_field()
	public function mbwph_txt_fb_page_link_field() {
		$options 	= get_option( 'fb_page_link' );
		?>
			<div class="form-group social-group">
				<input type="text" id="fb_page_link" name="fb_page_link" value="<?php echo($options); ?>" class="form-control" placeholder="Vd: https://www.facebook.com/your-page"/>
				<span class="description"></span>
			</div>
		<?php
	} // mbwph_txt_fb_page_id_field()
	public function mbwph_txt_zalo_phone_field() {
		$options 	= get_option( 'zalo_phone' );
		?>
			<div class="form-group social-group">
				<input type="text" id="zalo_phone" name="zalo_phone" value="<?php echo($options); ?>" class="form-control" placeholder="Vd: 0909 XXX XXX"/>
			</div>
		<?php
	} // mbwph_txt_zalo_phone_field()
	public function mbwph_txt_tawkto_id_field() {
		$options 	= get_option( 'tawkto_id' );
		?>
			<div class="form-group social-group">
				<input type="text" id="tawkto_id" name="tawkto_id" value="<?php echo($options); ?>" class="form-control" placeholder="Mã ID Tawk.to"/>
				<span class="description">Xem hướng dẫn nhận Tawk.to ID  <a href="https://wiki.matbao.net/kb/huong-dan-dang-ky-tai-khoan-tawk-to-va-lay-tawk-to-id/" target="_blank">tại đây</a>.</span>
			</div>
		<?php
	} // mbwph_txt_tawkto_id_field()
	public function mbwph_txt_mail_to_field() {
		$options 	= get_option( 'mail_to' );
		?>
			<div class="form-group social-group">
				<input type="text" id="mail_to" name="mail_to" value="<?php echo($options); ?>" class="form-control" placeholder="Vd: support@gmail.com"/>
			</div>
		<?php
	} // mbwph_txt_mail_to_field()
}
