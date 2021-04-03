<?php
/**
 * Controls settings of plugin
 *
 * @package    WP_HELPER
 * @subpackage WP_HELPER/admin/settings
 */
class WP_HELPER_Security extends WP_HELPER_Admin {

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
		$this->id    = 'security';
		$this->label = __( 'Bảo mật', 'mbwph' );
		$this->WP_HELPER = $WP_HELPER;
		$this->plugin = 'wp-helper-premium/wp-helper-premium.php';
	}

	/**
	 * Creates our settings sections with fields etc.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function mbwph_settings_security_init() {
		$this->security_post_init();
	}

	/**
	 * Creates post settings sections with fields etc.
	 *
	 * @since    1.1.0
	 * @access   public
	 */
	public function security_post_init() {

		// register_setting( $option_group, $option_name, $settings_sanitize_callback );
		register_setting(
			$this->WP_HELPER . '_security_options_group',
			$this->WP_HELPER . '_security_options', //Options containt value field
			array( $this, 'mbwph_settings_sanitize' )
		);
		add_settings_section(
			$this->WP_HELPER . '-security-options', // section
			apply_filters( $this->WP_HELPER . '-display-section-security', __( '', $this->WP_HELPER ) ),
			array( $this, 'print_options_section' ),
			$this->WP_HELPER . '_security_tab'
		);
		// Section Captcha
		add_settings_section(
			$this->WP_HELPER . '-captcha-options', // section
			apply_filters( $this->WP_HELPER . '-display-section-title', __( '', $this->WP_HELPER ) ),
			array( $this, 'print_captcha_section' ),
			$this->WP_HELPER . '_security_tab'
		);
			/*add_settings_field(
				'captcha-version',
				apply_filters( $this->WP_HELPER . '-captcha-version-label', __( 'Version', 'mbwph' ) ),
				array( $this, 'mbwph_op_captcha_version_field' ),
				$this->WP_HELPER . '_security_tab',		// Page
				$this->WP_HELPER . '-captcha-options' 	// section to add to
			);*/
			add_settings_field(
				'site-key',
				apply_filters( $this->WP_HELPER . '-site-key-label', __( 'Site key', 'mbwph' ) ),
				array( $this, 'mbwph_txtsite_key_field' ),
				$this->WP_HELPER . '_security_tab',		// Page
				$this->WP_HELPER . '-captcha-options' 	// section to add to
			);
			add_settings_field(
				'secret-key',
				apply_filters( $this->WP_HELPER . '-secret-key-label', __( 'Secret Key', 'mbwph' ) ),
				array( $this, 'mbwph_txtsecret_key_field' ),
				$this->WP_HELPER . '_security_tab',		// Page
				$this->WP_HELPER . '-captcha-options' 	// section to add to
			);
		/*add_settings_field(
			'recaptcha-for',
			apply_filters( $this->WP_HELPER . '-recaptcha-for-label', __( 'reCAPTCHA for', 'mbwph' ) ),
			array( $this, 'mbwph_chk_recaptcha_for_field' ),
			$this->WP_HELPER . '_security_tab',		// Page
			$this->WP_HELPER . '-captcha-options', 	// section to add to
		);
		add_settings_field(
			'mbwph-login-form',
			apply_filters( $this->WP_HELPER . '-mbwph-login-form-label', __( '', 'mbwph' ) ),
			array( $this, '' ),
			$this->WP_HELPER . '_security_tab',		// Page
			$this->WP_HELPER . '-captcha-options', 	// section to add to
		);*/
		// Section SSL
		/*add_settings_section(
			$this->WP_HELPER . '-ssl-options', // section
			apply_filters( $this->WP_HELPER . '-ssl-section-title', __( 'Chuyển hướng HTTP sang HTTPS', $this->WP_HELPER ) ),
			array( $this, 'print_ssl_section' ),
			$this->WP_HELPER . '_security_tab'
		);
		add_settings_field(
			'enable-ssl',
			apply_filters( $this->WP_HELPER . '-enable-captcha-label', __( 'Kích hoạt', 'mbwph' ) ),
			array( $this, 'mbwph_chk_enable_ssl_field' ),
			$this->WP_HELPER . '_security_tab',		// Page
			$this->WP_HELPER . '-ssl-options' 	// section to add to
		);*/
		// Section Hide Login
		add_settings_section(
			$this->WP_HELPER . '-hide-login-options', // section
			apply_filters( $this->WP_HELPER . '-hide-login-section-title', __( '', $this->WP_HELPER ) ),
			array( $this, 'print_hide_login_section' ),
			$this->WP_HELPER . '_security_tab'
		);
			add_settings_field(
				'backend-name',
				apply_filters( $this->WP_HELPER . '-backend-name-label', __( 'Đường dẫn đăng nhập mới', 'mbwph' ) ),
				array( $this, 'mbwph_txt_login_name_field' ),
				$this->WP_HELPER . '_security_tab',		// Page
				$this->WP_HELPER . '-hide-login-options' 	// section to add to
			);
		//Section Others
		add_settings_section(
			$this->WP_HELPER . '-other-secure-options', // section
			apply_filters( $this->WP_HELPER . '-other-secure-section-title', __( '', $this->WP_HELPER ) ),
			array( $this, 'print_other_secure_section' ),
			$this->WP_HELPER . '_security_tab'
		);
			add_settings_field(
				'disable_xmlrpc',
				apply_filters( $this->WP_HELPER . '-disable_xmlrpc-label', __( 'Kích hoạt', 'mbwph' ) ),
				array( $this, 'mbwph_opt_disable_xmlrpc_field' ),
				$this->WP_HELPER . '_security_tab',		// Page
				$this->WP_HELPER . '-other-secure-options', 	// section to add to
				array( // The $args
					'disable_xmlrpc' // Should match Option ID
				)
			);
		//Section Others
		add_settings_section(
			$this->WP_HELPER . '-protect-wp-options', // section
			apply_filters( $this->WP_HELPER . '-protect-wp-section-title', __( '', $this->WP_HELPER ) ),
			array( $this, 'print_protect_wp_section' ),
			$this->WP_HELPER . '_security_tab'
		);	
			add_settings_field(
				'protect_blacklist',
				apply_filters( $this->WP_HELPER . '-protect_blacklist-label', __( 'Kích hoạt', 'mbwph' ) ),
				array( $this, 'mbwph_cb_protect_blacklist_plugin' ),
				$this->WP_HELPER . '_security_tab',		// Page
				$this->WP_HELPER . '-protect-wp-options', 	// section to add to
				array( // The $args
					'protect_blacklist' // Should match Option ID
				)
			);
			//Register settings
			register_setting($this->WP_HELPER . '_security_tab','disable_xmlrpc');
			register_setting($this->WP_HELPER . '_security_tab','protect_blacklist');
	}

	/**
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	public function print_options_section( $params ) {
		_e('<h3><span class="dashicons dashicons-privacy"></span>Bảo mật</h3>','mbwph');
		_e('<span class="description">Cài đặt bảo mật nâng cao dành cho website của bạn.</span><hr>','mbwph');
	}
	public function print_captcha_section( $params ) {
		_e('<h4>Cài đặt reCAPTCHA v2</h4>','mbwph');
		_e('<span class="description">Nếu bạn chưa có khóa reCAPTCHA từ Google, hãy làm theo các bước hướng dẫn <a href="https://wiki.matbao.net/kb/huong-dan-cai-dat-su-dung-recaptcha-tren-website-wordpress/" target="_blank">tại đây</a>.</span>','mbwph');
	}
	public function print_hide_login_section( $params ) {
		_e('<h4>Giấu trang đăng nhập Admin</h4>','mbwph');
		_e('<span class="description">Tránh việc bị tấn công dò mật khẩu, đồng thời giúp người dùng thay đổi đường dẫn quản trị dễ nhớ hơn.</span>','mbwph');
	}
	public function print_other_secure_section( $params ) {
		_e('<h4>Vô hiệu hóa XML-RPC</h4>','mbwph');
		_e('<span class="description">Hạn chế tấn công Brute Force và tấn công HTTP Flood vào website WordPress của bạn.</span>','mbwph');
	}
	public function print_protect_wp_section( $params ) {
		_e('<h4>Bảo vệ WordPress</h4>','mbwph');
		_e('<span class="description">Quét và loại bỏ các plugin nguy hại tới website của bạn, tìm hiểu thêm <a href="https://wiki.matbao.net/kb/danh-sach-plugin-blacklist-va-nhung-luu-y-ve-an-toan-bao-mat" target="_bland">tại đây</a>.</span>','mbwph');
	}
	/**
	 * Enable/Disable Checkbox Field
	 *
	 * @since 		1.0.0
	 * @return 		mixed 			The settings field
	 */
	/*===========Captcha Settings=============*/
	public function mbwph_op_captcha_version_field() {

		$options 	= get_option( $this->WP_HELPER . '_security_options' );
		$captcha_version 	= "";

		if ( ! empty( $options['captcha-version'] ) ) {
			$captcha_version = $options['captcha-version'];
		}
		?>
		<div class="form-group recaptcha-group">
			<label class="mbwph_option">
				<input name="<?php echo $this->WP_HELPER; ?>_security_options[captcha-version]" type="radio"
                               value="v2"<?php if ($captcha_version == 'v2') { ?> checked="checked"<?php } ?> />
                        reCAPTCHA v2
			</label>
			<label class="mbwph_option">
				<input name="<?php echo $this->WP_HELPER; ?>_security_options[captcha-version]" type="radio"
                               value="v3"<?php if ($captcha_version == 'v3') { ?> checked="checked"<?php } ?> />
                        reCAPTCHA v3
			</label>
		</div>
<?php
	}
	public function mbwph_txtsite_key_field() {

		$options 	= get_option( $this->WP_HELPER . '_security_options' );
		$site_key 	= "";

		if ( ! empty( $options['site-key'] ) ) {
			$site_key = $options['site-key'];
		}
		?>
		<div class="form-group recaptcha-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_security_options[site-key]" name="<?php echo $this->WP_HELPER; ?>_security_options[site-key]" value="<?php echo( $site_key); ?>" class="form-control" placeholder="Site key"/>
		</div>
<?php
	}
	public function mbwph_txtsecret_key_field() {

		$options 	= get_option( $this->WP_HELPER . '_security_options');
		$secret_key 	= "";

		if ( ! empty( $options['secret-key'] ) ) {
			$secret_key = $options['secret-key'];
		}
		?>
		<div class="form-group recaptcha-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_security_options[secret-key]" name="<?php echo $this->WP_HELPER; ?>_security_options[secret-key]" value="<?php echo( $secret_key); ?>" class="form-control" placeholder="Secret key"/>
		</div>
<?php
	}
	public function mbwph_chk_recaptcha_for_field() {
		$options 	= get_option( $this->WP_HELPER . '_security_options' );
		$recaptcha_for 	= "";
		//var_dump($options);
		if ( ! empty( $options['mbwph-login-form'] ) ) {
			$option = $options['mbwph-login-form'];
		}
		?>
		<div class="form-group recaptcha-group">
			<button class="mbwph-accordion"><?php _e('WordPress Forms', 'mbwph');?></button>
			<div class="mbwph-panel">
				<p>
					<label class="mbwph_option">
						<input name="<?php echo $this->WP_HELPER; ?>_security_options[mbwph-login-form]" type="checkbox"
									   value="1" <?php echo in_array(1, $option) ? 'checked' : ''; ?> />
								<?php _e('Đăng nhập', 'mbwph');?>
					</label>
					<label class="mbwph_option">
						<input name="<?php echo $this->WP_HELPER; ?>_security_options[recaptcha-for]" type="checkbox"
									   value="2" <?php in_array(2, $recaptcha_for) ? 'checked' : '' ?> />
								<?php _e('Đăng ký', 'mbwph');?>
					</label>
					<label class="mbwph_option">
						<input name="<?php echo $this->WP_HELPER; ?>_security_options[recaptcha-for]" type="checkbox"
									   value="3" <?php in_array(3, $recaptcha_for) ? 'checked' : '' ?> />
								<?php _e('Khôi phục mật khẩu', 'mbwph');?>
					</label>
					<label class="mbwph_option">
						<input name="<?php echo $this->WP_HELPER; ?>_security_options[recaptcha-for]" type="checkbox"
									   value="4" <?php in_array(4, $recaptcha_for) ? 'checked' : '' ?> />
								<?php _e('Bình luận', 'mbwph');?>
					</label>
				</p>
			</div>
			<button class="mbwph-accordion">Other Forms</button>
			<div class="mbwph-panel">
				<p><a href="https://www.matbao.net/hosting/wp-helper-plugin.html" target="_blank"><span style="color:#f00"><?php _e('Get Premium', 'mbwph');?></span></a></p>
			</div>
		</div>
<?php
	}
	/*===========SSL Settings=============*/
	public function mbwph_chk_enable_ssl_field() {

		$options 	= get_option( $this->WP_HELPER . '_security_options' );
		$option 	= 0;

		if ( ! empty( $options['enable-ssl'] ) ) {
			$option = $options['enable-ssl'];
		}
		?>
		<div class="pretty p-switch p-fill">
			<input type="checkbox" id="<?php echo $this->WP_HELPER; ?>_security_options[enable-ssl]" name="<?php echo $this->WP_HELPER; ?>_security_options[enable-ssl]" value="1" <?php checked( $option, 1 , true ); ?> disabled />
			<span class="el-switch-style"></span>
		</label>
		<span class="description"><?php _e('Để sử dụng chức năng này, bạn lưu ý cần phải cài đặt SSL trước đó để kích hoạt ổ khóa xanh trên trình duyệt.', 'mbwph'); ?></span>
<?php
	}
	/*===========SSL Settings=============*/
	public function mbwph_txt_login_name_field() {

		$options 	= get_option( $this->WP_HELPER . '_security_options' );
		$login_name 	= "";
		$url = get_option( 'siteurl' );

		if ( ! empty( $options['backend-name'] ) ) {
			$login_name = $options['backend-name'];
		}else{$slug = 'your-slug';}
		?>
			<div class="input-group mb-3">
				<div class="input-group-prepend">
				    <span class="input-group-text" id="basic-addon3"><?php _e(''.$url.'/', 'mbwph'); ?></span>
				</div>
				<input type="text" id="<?php echo $this->WP_HELPER; ?>_security_options[backend-name]" name="<?php echo $this->WP_HELPER; ?>_security_options[backend-name]" value="<?php echo( $login_name); ?>" class="form-control" id="basic-url" aria-describedby="basic-addon3"  placeholder="vd: quanly">
			</div>
		</div>
<?php
	}
	public function mbwph_opt_disable_xmlrpc_field() {
		$status = '';
		if (!is_plugin_active($this->plugin)) {
			$status = 'disabled';
			$option = 0;
			$description = '<span class="description">Chức năng nâng cao dành riêng cho phiên bản <a href="https://www.matbao.net/hosting/wp-helper-plugin.html" target="_bland" class="premium-text">Premium</a></span>';
		}else{
			$options 	= get_option( $this->WP_HELPER . '_security_options' );
			if ( ! empty( $options['disable_xmlrpc'] ) ) {
				$option = $options['disable_xmlrpc'];
			}
		}		
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" id="<?php echo $this->WP_HELPER; ?>_security_options[disable_xmlrpc]" name="<?php echo $this->WP_HELPER; ?>_security_options[disable_xmlrpc]" value="1" <?php checked( $option, 1 , true ); ?> <?php echo $status; ?> />
			<label class="custom-switch-btn" for="<?php echo $this->WP_HELPER; ?>_security_options[disable_xmlrpc]"></label>
			<?php echo $description; ?>
		</div>
<?php
	}
	public function mbwph_cb_protect_blacklist_plugin() {
		$status = '';
		if (!is_plugin_active($this->plugin)) {
			$status = 'disabled';
			$option = 0;
			$description = '<span class="description">Chức năng nâng cao dành riêng cho phiên bản <a href="https://www.matbao.net/hosting/wp-helper-plugin.html" target="_bland" class="premium-text">Premium</a></span>';
		}else{
			$options 	= get_option( $this->WP_HELPER . '_security_options' );
			if ( ! empty( $options['protect_blacklist'] ) ) {
				$option = $options['protect_blacklist'];
			}
		}
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" id="<?php echo $this->WP_HELPER; ?>_security_options[protect_blacklist]" name="<?php echo $this->WP_HELPER; ?>_security_options[protect_blacklist]" value="1" <?php checked( $option, 1 , true ); ?> <?php echo $status; ?>/>
			<label class="custom-switch-btn" for="<?php echo $this->WP_HELPER; ?>_security_options[protect_blacklist]"></label>
			<?php echo $description; ?>
		</div>
<?php
	}
}
