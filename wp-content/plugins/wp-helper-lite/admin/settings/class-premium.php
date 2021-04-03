<?php
/**
 * Controls settings of plugin
 *
 * @package    WP_HELPER 
 * @subpackage WP_HELPER/admin/settings
 */
class WP_HELPER_Premium extends WP_HELPER_Admin {

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
		$this->id    = 'premium-license';
		$this->label = __( 'Premium', 'mbwph' );
		$this->WP_HELPER = $WP_HELPER;
	}

	/**
	 * Creates our settings sections with fields etc. 
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function mbwph_settings_premium_init() {
		$this->mbwph_premium_tab_init();		
	}

	/**
	 * Creates post settings sections with fields etc.  
	 *
	 * @since    1.1.0
	 * @access   public
	 */
	public function mbwph_premium_tab_init() {
		
		// register_setting( $option_group, $option_name, $settings_sanitize_callback );
		register_setting(
			$this->WP_HELPER . '_premium_options_group',
			$this->WP_HELPER . '_premium_options', //Options containt value field
			array( $this, 'mbwph_settings_sanitize' )
		);
		
		// add_settings_section( $id, $title, $callback, $menu_slug );
		add_settings_section(
			$this->WP_HELPER . '-premium-options', // section
			apply_filters( $this->WP_HELPER . '-display-section-title', __( 'Tính năng nâng cao Premium', $this->WP_HELPER ) ),
			array( $this, 'print_premium_section' ),  //in ra dòng mô tả bên dưới tiêu đề tab
			$this->WP_HELPER . '_premium_tab'
		);
		
		add_settings_field(
			'license-key',
			apply_filters( $this->WP_HELPER . '-license-key-label', __( 'License key', 'mbwph' ) ),
			array( $this, 'mbwph_txt_license_key_field' ),
			$this->WP_HELPER . '_premium_tab',		// Page
			$this->WP_HELPER . '-premium-options' 	// section to add to
		);

		add_settings_field(
			'license-info',
			apply_filters( $this->WP_HELPER . '-license-info-label', __( 'Thông tin License', 'mbwph' ) ),
			array( $this, 'mbwph_text_license_info' ),
			$this->WP_HELPER . '_premium_tab',		// Page
			$this->WP_HELPER . '-premium-options' 	// section to add to
		);		

		add_settings_field(
		 	'enable-scan-blacklist-plugin',
		 	apply_filters( $this->WP_HELPER . '-enable-scan-blacklist-plugin', __( 'Quét Plugin nguy hại', 'mbwph' ) ),
		 	array( $this, 'mbwph_op_enable_scan_blacklist_plugin_field' ),
		 	$this->WP_HELPER . '_premium_tab',		// Page
		 	$this->WP_HELPER . '-premium-options' 	// section to add to
	 );

		// // add_settings_field( $id, $title, $callback, $menu_slug, $section, $args );
		// add_settings_field(
		// 	'enable-smtp',
		// 	apply_filters( $this->WP_HELPER . '-enable-smtp-label', __( 'Kích hoạt', 'mbwph' ) ),
		// 	array( $this, 'mbwph_op_enable_smtp_field' ),
		// 	$this->WP_HELPER . '_smtp_tab',		// Page
		// 	$this->WP_HELPER . '-smtp-options' 	// section to add to
		// );
		// add_settings_field(
		// 	'from',
		// 	apply_filters( $this->WP_HELPER . '-from-label', __( 'Email gửi từ', 'mbwph' ) ),
		// 	array( $this, 'mbwph_txtfrom_field' ),
		// 	$this->WP_HELPER . '_smtp_tab',		// Page
		// 	$this->WP_HELPER . '-smtp-options' 	// section to add to
		// );
		// add_settings_field(
		// 	'from-name',
		// 	apply_filters( $this->WP_HELPER . '-from-name-label', __( 'Tên gửi từ', 'mbwph' ) ),
		// 	array( $this, 'mbwph_txtfrom_name_field' ),
		// 	$this->WP_HELPER . '_smtp_tab',		// Page
		// 	$this->WP_HELPER . '-smtp-options' 	// section to add to
		// );
		// add_settings_field(
		// 	'smtp-host',
		// 	apply_filters( $this->WP_HELPER . '-smtp-host-label', __( 'SMTP Host', 'mbwph' ) ),
		// 	array( $this, 'mbwph_txtsmtp_host_field' ),
		// 	$this->WP_HELPER . '_smtp_tab',		// Page
		// 	$this->WP_HELPER . '-smtp-options' 	// section to add to
		// );
		// add_settings_field(
		// 	'smtp-secure',
		// 	apply_filters( $this->WP_HELPER . '-smtp-secure-label', __( 'Bảo mật SMTP', 'mbwph' ) ),
		// 	array( $this, 'mbwph_opsmtp_secure_field' ),
		// 	$this->WP_HELPER . '_smtp_tab',		// Page
		// 	$this->WP_HELPER . '-smtp-options' 	// section to add to
		// );
		// add_settings_field(
		// 	'smtp-port',
		// 	apply_filters( $this->WP_HELPER . '-smtp-port-label', __( 'Cổng SMTP', 'mbwph' ) ),
		// 	array( $this, 'mbwph_txtsmtp_port_field' ),
		// 	$this->WP_HELPER . '_smtp_tab',		// Page
		// 	$this->WP_HELPER . '-smtp-options' 	// section to add to
		// );
		// add_settings_field(
		// 	'smtp-auth',
		// 	apply_filters( $this->WP_HELPER . '-smtp-auth-label', __( 'Xác thực SMTP', 'mbwph' ) ),
		// 	array( $this, 'mbwph_opsmtp_auth_field' ),
		// 	$this->WP_HELPER . '_smtp_tab',		// Page
		// 	$this->WP_HELPER . '-smtp-options' 	// section to add to
		// );
		// add_settings_field(
		// 	'smtp-username',
		// 	apply_filters( $this->WP_HELPER . '-smtp-username-label', __( 'Tên đăng nhập SMTP', 'mbwph' ) ),
		// 	array( $this, 'mbwph_txtsmtp_username_field' ),
		// 	$this->WP_HELPER . '_smtp_tab',		// Page
		// 	$this->WP_HELPER . '-smtp-options' 	// section to add to
		// );
		// add_settings_field(
		// 	'smtp-password',
		// 	apply_filters( $this->WP_HELPER . '-smtp-password-label', __( 'Mật khẩu SMTP', 'mbwph' ) ),
		// 	array( $this, 'mbwph_txtsmtp_password_field' ),
		// 	$this->WP_HELPER . '_smtp_tab',		// Page
		// 	$this->WP_HELPER . '-smtp-options' 	// section to add to
		// );		
	}
	
	/**
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	public function print_premium_section( $params ) {

		//echo '<p>' . $params['title'] . '</p>';
		echo '<hr/>';

	} // display_options_section()


	/**
	 * Enable/Disable Checkbox Field
	 *
	 * @since 		1.0.0
	 * @return 		mixed 			The settings field
	 */

	public function mbwph_txt_license_key_field() {

		$options 	= get_option( $this->WP_HELPER . '_premium_options' );
		$license_key 	= "";

		if ( ! empty( $options['license_key'] ) ) {
			$license_key = $options['license_key'];
		}		
		?>
		<div class="form-group">
			<input type="password" id="<?php echo $this->WP_HELPER; ?>_premium_options[license_key]" name="<?php echo $this->WP_HELPER; ?>_premium_options[license_key]" value="<?php echo( $license_key); ?>" class="form-control" placeholder="XXXX-XXXX-XXXX-XXXX"/> 
			<span class="description">Liên hệ chăm sóc khách hàng của Mắt Bão để nhận License này!</span>
		</div>
		<?php
	} 




	public function mbwph_text_license_info() {
		$options 	= get_option( $this->WP_HELPER . '_premium_options' );
		$license_key 	= "";

		if ( ! empty( $options['license_key'] ) ) {
			$license_key = $options['license_key'];
		}

	
		//$string = file_get_contents('https://wphelper-api.mwpteam.com/get-license.php?license_key='.$license_key);



		$response = wp_remote_request('https://wphelper-api.mwpteam.com/get-license.php?license_key='.$license_key);


		//$response = wp_remote_get( 'https://wphelper-api.mwpteam.com/get-license.php?license_key=ICG1-XAA3-E0BU-0G79' );

// 		$response = wp_remote_get( 'https://wphelper-api.mwpteam.com/get-license.php?license_key=ICG1-XAA3-E0BU-0G791' );
		if ( is_array( $response ) ) {
  		$header = $response['headers']; // array of http header lines
 		$body = $response['body']; // use the content
 		//echo $body;
 		$all_data = json_decode($body); 		
		
		
		//var_dump($license);
		if	($all_data->success == "1"){
		$license = $all_data->data[0];
		 	?>
	
	 
	
 	<div class="form-group">
 		Trạng thái:
		<?php
		if 	($license->status == "1")
		{ echo "<b style=\"color:green\"> Hoạt động</b>"; } 
		else
		{ echo "<b style=\"color:red\"> Không hợp lệ</b>"; } 	
		?>
		<br>
 		Ngày hết hạn:<b style="color:green"> <?php echo $newDate = date("d-m-Y", strtotime($license->expiration_date)); ?></b> <br>
 		Loại license:
		<?php
		if 	($license->type == "0")
		{ echo "<b style=\"color:green\"> License được cấp cùng Hosting WordPress V3 Mắt Bão</b>"; } 
		else
		{ echo "<b style=\"color:red\"> License bản quyền</b>"; } 	
		?>		 
		
		<br>
		<i> <?php echo $license->note; ?> </i>
 		
 	</div>
 	<?php
		} 
		else if	($all_data->success == "0")
		{
			echo "<div class=\"form-group\"> <b style=\"color:red\">".$all_data->message."</b></div>";
		}
	} // mbwph_text_license_info()
	}
	public function mbwph_op_enable_scan_blacklist_plugin_field() {

		$options 	= get_option( $this->WP_HELPER . '_premium_options' );
		$option 	= 0;

		if ( ! empty( $options['enable_scan_blacklist_plugin'] ) ) {
			$option = $options['enable_scan_blacklist_plugin'];
		}		
		?>		
		<div class="pretty p-switch p-fill">
			<input type="checkbox" id="<?php echo $this->WP_HELPER; ?>_smtp_options[enable_scan_blacklist_plugin]" name="<?php echo $this->WP_HELPER; ?>_premium_options[enable_scan_blacklist_plugin]" value="1" <?php checked( $option, 1 , true ); ?> />
			<div class="state p-success">
				<label></label>
			</div>
		</div>
		<span class="description">Quét và cách lý plugin nguy hại tới website.</span>			
		<?php
	} // mbwph_op_enable_smtp_field()

	public function mbwph_op_enable_smtp_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$option 	= 0;

		if ( ! empty( $options['enable-smtp'] ) ) {
			$option = $options['enable-smtp'];
		}		
		?>		
		<label class="el-switch el-switch-red">
			<input type="checkbox" id="<?php echo $this->WP_HELPER; ?>_smtp_options[enable-smtp]" name="<?php echo $this->WP_HELPER; ?>_smtp_options[enable-smtp]" value="1" <?php checked( $option, 1 , true ); ?> />
			<span class="el-switch-style"></span>
		</label>		
		<?php
	} // mbwph_op_enable_smtp_field()
	public function mbwph_txtfrom_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$from 	= "";

		if ( ! empty( $options['from'] ) ) {
			$from = $options['from'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_smtp_options[from]" name="<?php echo $this->WP_HELPER; ?>_smtp_options[from]" value="<?php echo( $from); ?>" class="form-control" placeholder="Địa chỉ email. vd: your-email@domain"/> 
			<span class="description">Nếu bạn sử dụng Email từ nhà cung cấp (Gmail, Yahoo, Outlook.com, v.v.) thì đây sẽ là địa chỉ email của bạn cho tài khoản đó.</span>
		</div>
		<?php
	} // mbwph_txtfrom_field()
	public function mbwph_txtfrom_name_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$from_name 	= "";

		if ( ! empty( $options['from-name'] ) ) {
			$from_name = $options['from-name'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_smtp_options[from-name]" name="<?php echo $this->WP_HELPER; ?>_smtp_options[from-name]" value="<?php echo( $from_name); ?>" class="form-control" placeholder="Tên đại diện email"/> 
			<span class="description">Vd: Tên Công ty / Cá Nhân</span>
		</div>
		<?php
	} // mbwph_txtfrom_name_field()
	public function mbwph_txtsmtp_host_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$smtp_host 	= "";

		if ( ! empty( $options['smtp-host'] ) ) {
			$smtp_host = $options['smtp-host'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-host]" name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-host]" value="<?php echo( $smtp_host); ?>" class="form-control" placeholder="Địa chỉ máy chủ SMTP. vd: smtp.gmail.com"/> 
		</div>
		<?php
	} // mbwph_txtsmtp_host_field()
	public function mbwph_opsmtp_secure_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$smtp_secure	= "";

		if ( ! empty( $options['smtp-secure'] ) ) {
			$smtp_secure = $options['smtp-secure'];
		}
		?>
		<div class="form-group">
			<label class="mbwph_option">
				<input name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-secure]" type="radio"
				value=""<?php if ($smtp_secure == '') { ?> checked="checked"<?php } ?> />
				None
			</label>
			<label class="mbwph_option">
				<input name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-secure]" type="radio"
				value="ssl"<?php if ($smtp_secure == 'ssl') { ?> checked="checked"<?php } ?> />
				SSL
			</label>
			<label class="mbwph_option">
				<input name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-secure]" type="radio"
				value="tls"<?php if ($smtp_secure == 'tls') { ?> checked="checked"<?php } ?> />
				TLS
			</label><br>
			<span class="description">Đối với hầu hết các máy chủ, TLS là tùy chọn được đề xuất. Nếu nhà cung cấp SMTP của bạn cung cấp cả hai tùy chọn SSL và TLS, chúng tôi khuyên bạn nên sử dụng TLS.</span>
		</div>
		<?php
	} // mbwph_txtsmtp_secure_field()
	public function mbwph_txtsmtp_port_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$smtp_port 	= "";

		if ( ! empty( $options['smtp-port'] ) ) {
			$smtp_port = $options['smtp-port'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-port]" name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-port]" value="<?php echo( $smtp_port); ?>" class="form-control" placeholder="Cổng kết nối máy chủ mail: 465 hoặc 587."/> 
			<span class="description">Tùy vào máy chủ SMTP sẽ có cấu hình thông số Port khác nhau, tuy nhiên thông thường thông số Port SMTP sẽ như sau:<br>None: 25<br>SSL: 465<br>TLS: 587</span>
		</div>
		<?php
	} // mbwph_txtsmtp_port_field()
	public function mbwph_opsmtp_auth_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$smtp_auth	= "";

		if ( ! empty( $options['smtp-auth'] ) ) {
			$smtp_auth = $options['smtp-auth'];
		}
		?>
		<div class="form-group">
			<label class="mbwph_option">
				<input name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-auth]" type="radio"
				value="no"<?php if ($smtp_auth == 'no') { ?> checked="checked"<?php } ?> />
				No
			</label>
			<label class="mbwph_option">
				<input name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-auth]" type="radio"
				value="yes"<?php if ($smtp_auth == 'yes') { ?> checked="checked"<?php } ?> />
				Yes
			</label>			
		</div>
		<?php
	} // mbwph_opsmtp_auth_field()
	public function mbwph_txtsmtp_username_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$smtp_username 	= "";

		if ( ! empty( $options['smtp-username'] ) ) {
			$smtp_username = $options['smtp-username'];
		}		
		?>
		<div class="form-group">
			<input type="text" id="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-username]" name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-username]" value="<?php echo( $smtp_username); ?>" class="form-control" placeholder="Tên đăng nhập"/> 
		</div>
		<?php
	} // mbwph_txtsmtp_user_field()
	public function mbwph_txtsmtp_password_field() {

		$options 	= get_option( $this->WP_HELPER . '_smtp_options' );
		$smtp_password 	= "";

		if ( ! empty( $options['smtp-password'] ) ) {
			$smtp_password = $options['smtp-password'];
		}		
		?>
		<div class="form-group">
			<div class="input-group" id="show_hide_password">
				<input type="password" id="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-password]" name="<?php echo $this->WP_HELPER; ?>_smtp_options[smtp-password]" value="<?php echo( $smtp_password); ?>" class="form-control" placeholder="Mật khẩu"  data-toggle="password"/>
				<div class="input-group-addon">
					<a href="#"><span class="dashicons dashicons-hidden" aria-hidden="true"></span></a>
				</div>
			</div>
		</div>
		<?php
	} // mbwph_txtsmtp_password_field()	
}