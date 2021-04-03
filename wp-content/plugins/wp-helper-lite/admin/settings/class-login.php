<?php

/**
 * Controls settings of plugin
 *
 * @package    WP_HELPER
 * @subpackage WP_HELPER/admin/settings
 */
class WP_HELPER_Login extends WP_HELPER_Admin {

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
		$this->id    = 'mbwph_login';
		$this->label = __( 'Login', 'mbwph' );
		$this->WP_HELPER = $WP_HELPER;
	}

	/**
	 * Creates our settings sections with fields etc.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function mbwph_settings_login_init() {
		$this->mbwph_login_post_init();
	}

	/**
	 * Creates post settings sections with fields etc.
	 *
	 * @since    1.1.0
	 * @access   public
	 */
	public function mbwph_login_post_init() {
		// add_settings_section( $id, $title, $callback, $menu_slug );
		add_settings_section(
			$this->WP_HELPER . '-login-options',
			__( '', 'mbwph'),
			array( $this, 'display_options_section' ),
			$this->WP_HELPER . '_mbwph_login_tab'
		);
		add_settings_section(
			$this->WP_HELPER . '-login-logo-options',
			__( '', 'mbwph'),
			array( $this, 'display_logo_options_section' ),
			$this->WP_HELPER . '_mbwph_login_tab'
		);
		add_settings_section(
			$this->WP_HELPER . '-login-background-options',
			__( '', 'mbwph'),
			array( $this, 'display_background_options_section' ),
			$this->WP_HELPER . '_mbwph_login_tab'
		);
		/*add_settings_section(
			$this->WP_HELPER . '-login-form-options',
			__( '', 'mbwph'),
			array( $this, 'display_form_options_section' ),
			$this->WP_HELPER . '_mbwph_login_tab'
		);*/

		// Active
		add_settings_field(
			'enable_login_style', // Option ID
			apply_filters( $this->WP_HELPER . '-chk-enable_login_style-header-label', __( 'Kích hoạt', 'mbwph' ) ), // Label
			array( $this, 'mbwph_cb_enable_login_style_field' ), // !important - This is where the args go!
			$this->WP_HELPER . '_mbwph_login_tab',		// Page it will be displayed
			$this->WP_HELPER . '-login-options', 	// Name of our section
			array( // The $args
				'enable_login_style' // Should match Option ID
			)
		);

		// Logo Setting
		add_settings_field(
			'login_logo_id',
			apply_filters( $this->WP_HELPER . '-login_logo-label', __( 'Logo', 'mbwph' ) ),
			array( $this, 'mbwph_btn_login_logo_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-logo-options',
			array(
				'login_logo_id'
			)
		);
		add_settings_field(
			'resize_logo',
			apply_filters( $this->WP_HELPER . '-resize_logo-label', __( 'Thay đổi kích thước', 'mbwph' ) ),
			array( $this, 'mbwph_opt_resize_logo_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-logo-options',
			array(
				'resize_logo'
			)
		);
		add_settings_field(
			'set_logo_size',
			apply_filters( $this->WP_HELPER . '-set_logo_size-label', __( 'Kích thước (%)', 'mbwph' ) ),
			array( $this, 'mbwph_txt_set_logo_size_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-logo-options',
			array(
				'set_logo_size'
			)
		);
		add_settings_field(
			'set_logo_height',
			apply_filters( $this->WP_HELPER . '-set_logo_height-label', __( 'Chiều cao (%)', 'mbwph' ) ),
			array( $this, 'mbwph_txt_set_logo_height_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-logo-options',
			array(
				'set_logo_height'
			)
		);
		add_settings_field(
			'logo_url',
			apply_filters( $this->WP_HELPER . '-logo_url-label', __( 'Đường dẫn liên kết', 'mbwph' ) ),
			array( $this, 'mbwph_txt_logo_url_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-logo-options',
			array(
				'logo_url'
			)
		);
		// Background setting
		add_settings_field(
			'bg_color',
			apply_filters( $this->WP_HELPER . '-txt_bg_color-label', __( 'Màu nền', 'mbwph' ) ),
			array( $this, 'mbwph_txt_bg_color_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-background-options',
			array(
				'bg_color'
			)
		);
		add_settings_field(
			'bg_image_id',
			apply_filters( $this->WP_HELPER . '-bg_image_id-label', __( 'Ảnh nền', 'mbwph' ) ),
			array( $this, 'mbwph_btn_bg_image_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-background-options',
			array(
				'bg_image_id'
			)
		);
		add_settings_field(
			'bg_repeat',
			apply_filters( $this->WP_HELPER . '-bg_repeat-label', __( 'Lặp lại ảnh nền', 'mbwph' ) ),
			array( $this, 'mbwph_cb_bg_repeat_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-background-options',
			array(
				'bg_repeat'
			)
		);
		add_settings_field(
			'bg_scale',
			apply_filters( $this->WP_HELPER . '-bg_scale-label', __( 'Cân chỉnh vừa màn hình', 'mbwph' ) ),
			array( $this, 'mbwph_cb_bg_scale_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-background-options',
			array(
				'bg_scale'
			)
		);
		// Form Setting
/*		add_settings_field(
			'frm_login_top_margin',
			apply_filters( $this->WP_HELPER . '-frm_login_top_margin-label', __( 'Canh lề trên', 'mbwph' ) ),
			array( $this, 'mbwph_txt_frm_login_top_margin_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-form-options',
			array(
				'frm_login_top_margin'
			)
		);
		add_settings_field(
			'frm_login_width',
			apply_filters( $this->WP_HELPER . '-frm_login_width-label', __( 'Chiều rộng khung đăng nhập', 'mbwph' ) ),
			array( $this, 'mbwph_txt_frm_login_width_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-form-options',
			array(
				'frm_login_width'
			)
		);*/
		add_settings_field(
			'set_transparent_form',
			apply_filters( $this->WP_HELPER . '-set_transparent_form-label', __( 'Khung đăng nhập trong suốt', 'mbwph' ) ),
			array( $this, 'mbwph_cb_set_transparent_form_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-background-options',
			array(
				'set_transparent_form'
			)
		);

		add_settings_field(
			'set_transparent_input',
			apply_filters( $this->WP_HELPER . '-set_transparent_input-label', __( 'Ô nhập liệu trong suốt', 'mbwph' ) ),
			array( $this, 'mbwph_cb_set_transparent_input_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-background-options',
			array(
				'set_transparent_input'
			)
		);
/*		
		add_settings_field(
			'input_text_color',
			apply_filters( $this->WP_HELPER . '-input_text_color-label', __( 'Màu chữ ô nhập liệu', 'mbwph' ) ),
			array( $this, 'mbwph_txt_input_text_color_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-form-options',
			array(
				'input_text_color'
			)
		);
		add_settings_field(
			'input_border_color',
			apply_filters( $this->WP_HELPER . '-input_border_color-label', __( 'Màu viền ô nhập liệu', 'mbwph' ) ),
			array( $this, 'mbwph_txt_input_border_color_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-form-options',
			array(
				'input_border_color'
			)
		);
		add_settings_field(
			'input_hover_color',
			apply_filters( $this->WP_HELPER . '-input_hover_color-label', __( 'Hiệu ứng viền ô nhập liệu', 'mbwph' ) ),
			array( $this, 'mbwph_txt_input_hover_color_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-form-options',
			array(
				'input_hover_color'
			)
		);
		add_settings_field(
			'form_bg_color',
			apply_filters( $this->WP_HELPER . '-form_bg_color-label', __( 'Màu nền khung đăng nhập', 'mbwph' ) ),
			array( $this, 'mbwph_txt_form_bg_color_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-form-options',
			array(
				'form_bg_color'
			)
		);
		add_settings_field(
			'form_border_color',
			apply_filters( $this->WP_HELPER . '-form_border_color-label', __( 'Màu viền khung đăng nhập', 'mbwph' ) ),
			array( $this, 'mbwph_txt_form_border_color_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-form-options',
			array(
				'form_border_color'
			)
		);*/
		add_settings_field(
			'form_text_color',
			apply_filters( $this->WP_HELPER . '-form_text_color-label', __( 'Màu chữ', 'mbwph' ) ),
			array( $this, 'mbwph_txt_form_text_color_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-background-options',
			array(
				'form_text_color'
			)
		);/*
		add_settings_field(
			'form_link_color',
			apply_filters( $this->WP_HELPER . '-form_link_color-label', __( 'Màu đường dẫn', 'mbwph' ) ),
			array( $this, 'mbwph_txt_form_link_color_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-form-options',
			array(
				'form_link_color'
			)
		);
		add_settings_field(
			'form_link_hover_color',
			apply_filters( $this->WP_HELPER . '-form_link_hover_color-label', __( 'Hiệu ứng đường dẫn', 'mbwph' ) ),
			array( $this, 'mbwph_txt_form_link_hover_color_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-form-options',
			array(
				'form_link_hover_color'
			)
		);
		add_settings_field(
			'form_button_color',
			apply_filters( $this->WP_HELPER . '-form_button_color-label', __( 'Màu nút đăng nhập', 'mbwph' ) ),
			array( $this, 'mbwph_txt_form_button_color_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-form-options',
			array(
				'form_button_color'
			)
		);
		add_settings_field(
			'form_button_hover_color',
			apply_filters( $this->WP_HELPER . '-form_button_hover_color-label', __( 'Hiệu ứng nút đăng nhập', 'mbwph' ) ),
			array( $this, 'mbwph_txt_form_button_hover_color_field' ),
			$this->WP_HELPER . '_mbwph_login_tab',
			$this->WP_HELPER . '-login-form-options',
			array(
				'form_button_hover_color'
			)
		);
*/
		register_setting($this->WP_HELPER . '_mbwph_login_tab','enable_login_style');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','bg_color');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','bg_image_id');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','bg_repeat');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','bg_scale');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','frm_login_top_margin');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','frm_login_width');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','login_logo_id');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','resize_logo');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','set_logo_size');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','set_logo_height');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','logo_url');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','set_transparent_form');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','set_transparent_input');
/*		register_setting($this->WP_HELPER . '_mbwph_login_tab','input_text_color');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','input_border_color');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','input_hover_color');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','form_bg_color');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','form_border_color');*/
		register_setting($this->WP_HELPER . '_mbwph_login_tab','form_text_color');
		/*register_setting($this->WP_HELPER . '_mbwph_login_tab','form_link_color');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','form_link_hover_color');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','form_button_color');
		register_setting($this->WP_HELPER . '_mbwph_login_tab','form_button_hover_color');
*/
	}

	/**
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	public function display_options_section( $params ) {
		_e('<h3><span class="dashicons dashicons-admin-appearance"></span>Giao diện đăng nhập</h3>','mbwph');
		_e('<span class="description">Thay đổi giao diện đăng nhập theo cách riêng của bạn.</span>','mbwph');
	}
	public function display_logo_options_section( $params ) {
		_e('<h4>Cài đặt Logo</h4>','mbwph');
	}
	public function display_background_options_section( $params ) {
		_e('<h4>Cài đặt nền</h4>','mbwph');
	}
	public function display_form_options_section( $params ) {
		_e('<h4>Tùy chỉnh khung đăng nhập</h4>','mbwph');
	}
	public function mbwph_cb_enable_login_style_field() {
		$option 	= get_option('enable_login_style');
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" id="enable_login_style" name="enable_login_style" value="1" <?php checked( $option, 1 , true ); ?> />
			<label class="custom-switch-btn" for="enable_login_style"></label>
			<span class="description"><?php _e('Cho phép thay đổi giao diện đăng nhập.', 'mbwph'); ?></span>
		</div>
<?php
	}
	public function mbwph_txt_bg_color_field() {
		$option 	= get_option('bg_color');
		if ( isset( $option) ) {
			$bg_color = esc_attr($option);
		}
		else
		{
			$bg_color = "#263237";
		}
		?>
		<div class="placeholder">
			<input type="text" name="bg_color" value="<?php echo( $bg_color); ?>" data-default-color="#263237" class="color-field"></input>
		</div>
<?php
	}
	public function mbwph_btn_bg_image_field() {

		$option 	= get_option('bg_image_id');
		$bg_id = '';
		$bg_url = '';
		if ( ! empty( $option ) ) {
			$bg_id = $option;
			$bg_url = wp_get_attachment_url($option);
		}
		else
		{
			$logo_id = "";
			$logo_url = "";
		}
		?>
		<div class="input-group">
			<div id="login_bg_img" class="thumbnail mbwph-image-preview">
				<input class="image_id" name="bg_image_id" type="hidden" value="<?php echo($bg_id); ?>">
				<input class="mbwph_image_url" name="bg_image" type="hidden" value="<?php echo($bg_url); ?>">
				<?php if(!empty($bg_url)){ ?>
					<i class="dashicons dashicons-no-alt img-remove"></i>
					<img class="imgpreview_login_bg_img" src="<?php echo($bg_url); ?>">
				<?php } ?>
			</div>
		</div>

<?php	}
	public function mbwph_cb_bg_repeat_field() {
		$option 	= get_option('bg_repeat');
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" id="bg_repeat" name="bg_repeat" value="1" <?php checked( $option, 1 , true ); ?> />
			<label class="custom-switch-btn" for="bg_repeat"></label>
			<span class="description"><?php _e('Cho phép lặp ảnh nền.', 'mbwph'); ?></span>
		</div>
<?php
	}
	public function mbwph_cb_bg_scale_field() {
		$option 	= get_option('bg_scale');
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" id="bg_scale" name="bg_scale" value="1" <?php checked( $option, 1 , true ); ?> />
			<label class="custom-switch-btn" for="bg_scale"></label>
			<span class="description"><?php _e('Tỷ lệ hình ảnh phù hợp với kích thước màn hình.','mbwph'); ?></span>
		</div>

<?php
	}
	public function mbwph_txt_frm_login_top_margin_field() {
		$top_margin	= get_option('frm_login_top_margin');
		if(empty($top_margin)){$top_margin = 20;}
		?>
		<div class="form-group">
			<input id="frm_login_top_margin" name="frm_login_top_margin" type="text" data-provide="slider" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="<?php echo( $top_margin); ?>"/>
			<span><input id = "marginVal" class="mbwphNumber" type="text" value = "<?php echo( $top_margin); ?>" readonly /> %</span>
		</div>
<?php
	}
	public function mbwph_txt_frm_login_width_field() {
		$frm_width	= get_option('frm_login_width');
		if(empty($frm_width)){$frm_width = 25;}
		?>
		<div class="form-group">
			<input id="frm_login_width" name="frm_login_width" type="text" data-provide="slider" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="<?php echo( $frm_width); ?>"/>
			<span><input id = "widthVal" class="mbwphNumber" type="text" value = "<?php echo( $frm_width); ?>" readonly /> %</span>
		</div>
<?php
	}
	public function mbwph_btn_login_logo_field() {

		$option 	= get_option('login_logo_id');

		if ( ! empty( $option ) ) {
			$logo_id = $option;
			$logo_url = wp_get_attachment_url($option);
		}
		else
		{
			$logo_id = "";
			$logo_url = "";
		}
		?>
		<div class="input-group">
			<div id="login_logo_img" class="thumbnail mbwph-image-preview">
				<input class="image_id" name="login_logo_id" type="hidden" value="<?php echo($logo_id); ?>">
				<input class="mbwph_image_url" name="login_logo" type="hidden" value="<?php echo($logo_url); ?>">
				<?php if(!empty($logo_url)){ ?>
					<i class="dashicons dashicons-no-alt img-remove"></i>
					<img class="imgpreview_login_logo_img" src="<?php echo($logo_url); ?>">
				<?php } ?>
			</div>
		</div>

<?php
	}
	public function mbwph_opt_resize_logo_field() {
		$option 	= get_option('resize_logo');
		?>
		<div id="mwph-logo-resize-active" class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" id="resize_logo" name="resize_logo" value="1" <?php checked( $option, 1 , true ); ?> />
			<label class="custom-switch-btn" for="resize_logo"></label>
			<span class="description"><?php _e('Cho phép thay đổi kích thước logo.', 'mbwph'); ?></span>
		</div>
<?php
	}
	public function mbwph_txt_set_logo_size_field() {
		$option	= get_option('set_logo_size');
		if(empty($option)){$option = 10;}
		?>
		<div class="mwph-range mwph-form-inline">
			<input id="set_logo_size" name="set_logo_size" class="custom-range" type="range" name="range" min="0" max="100" value="<?php echo( $option); ?>" onchange="rangeLogoSize.value=value">
			<output id="rangeLogoSize"><?php echo( $option); ?></output>
		</div>
<?php
	}
	public function mbwph_txt_set_logo_height_field() {
		$option	= get_option('set_logo_height');
		if(empty($option)){$option = 100;}
		?>
		<div class="mwph-range mwph-form-inline">
			<input id="set_logo_height" name="set_logo_height" class="custom-range" type="range" name="range" min="0" max="100" value="<?php echo( $option); ?>" onchange="rangeLogoHeight.value=value">
			<output id="rangeLogoHeight"><?php echo( $option); ?></output>
		</div>
<?php
	}
	public function mbwph_txt_logo_url_field() {
		$logo_url 	= get_option('logo_url');
		if(empty($logo_url)){$logo_url = site_url();}
		?>
		<div class="form-group">
			<input type="text" name="logo_url" value="<?php echo( $logo_url); ?>" class="form-control" placeholder="Tên miền website"/>
		</div>
<?php
	}
	public function mbwph_cb_set_transparent_form_field() {
		$option 	= get_option('set_transparent_form');
		?>
		<div id="" class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" id="set_transparent_form" name="set_transparent_form" value="1" <?php checked( $option, 1 , true ); ?> />
			<label class="custom-switch-btn" for="set_transparent_form"></label>
			<span class="description"><?php _e('', 'mbwph'); ?></span>
		</div>
<?php
	}
	public function mbwph_cb_set_transparent_input_field() {
		$option 	= get_option('set_transparent_input');
		?>
		<div id="" class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" id="set_transparent_input" name="set_transparent_input" value="1" <?php checked( $option, 1 , true ); ?> />
			<label class="custom-switch-btn" for="set_transparent_input"></label>			
			<span class="description"><?php _e('Chọn để hiển thị ô nhập liệu trong suốt.', 'mbwph'); ?></span>
		</div>
<?php
	}
	public function mbwph_txt_input_text_color_field() {
		$option 	= get_option('input_text_color');
		if ( isset( $option) ) {
			$input_text_color = esc_attr($option);
		}
		else
		{
			$input_text_color = "#5b5b5b";
		}
		?>
		<div class="placeholder">
			<input type="text" name="input_text_color" value="<?php echo( $input_text_color); ?>" data-default-color="#5b5b5b" class="color-field"></input>
		</div>
<?php
	}
	public function mbwph_txt_input_border_color_field() {
		$option 	= get_option('input_border_color');
		if ( isset( $option) ) {
			$input_border_color = esc_attr($option);
		}
		else
		{
			$input_border_color = "#e2e2e2";
		}
		?>
		<div class="placeholder">
			<input type="text" name="input_border_color" value="<?php echo( $input_border_color); ?>" data-default-color="#e2e2e2" class="color-field"></input>
		</div>
<?php
	}
	public function mbwph_txt_input_hover_color_field() {
		$option 	= get_option('input_hover_color');
		if ( isset( $option) ) {
			$input_hover_color = esc_attr($option);
		}
		else
		{
			$input_hover_color = "#756c6c";
		}
		?>
		<div class="placeholder">
			<input type="text" name="input_hover_color" value="<?php echo( $input_hover_color); ?>" data-default-color="#756c6c" class="color-field"></input>
		</div>
<?php
	}
	public function mbwph_txt_form_bg_color_field() {
		$option 	= get_option('form_bg_color');
		if ( isset( $option) ) {
			$form_bg_color = esc_attr($option);
		}
		else
		{
			$form_bg_color = "#423143";
		}
		?>
		<div class="placeholder">
			<input type="text" name="form_bg_color" value="<?php echo( $form_bg_color); ?>" data-default-color="#423143" class="color-field"></input>
		</div>
<?php
	}
	public function mbwph_txt_form_border_color_field() {
		$option 	= get_option('form_border_color');
		if ( isset( $option) ) {
			$form_border_color = esc_attr($option);
		}
		else
		{
			$form_bg_color = "#C9C8BF";
		}
		?>
		<div class="placeholder">
			<input type="text" name="form_border_color" value="<?php echo( $form_border_color); ?>" data-default-color="#C9C8BF" class="color-field"></input>
		</div>
<?php
	}
	public function mbwph_txt_form_text_color_field() {
		$option 	= get_option('form_text_color');
		if ( isset( $option) ) {
			$form_text_color = esc_attr($option);
		}
		else
		{
			$form_bg_color = "#cccccc";
		}
		?>
		<div class="placeholder">
			<input type="text" name="form_text_color" value="<?php echo( $form_text_color); ?>" data-default-color="#cccccc" class="color-field"></input>
		</div>
<?php
	}
	public function mbwph_txt_form_link_color_field() {
		$option 	= get_option('form_link_color');
		if ( isset( $option) ) {
			$form_link_color = esc_attr($option);
		}
		else
		{
			$form_bg_color = "#777777";
		}
		?>
		<div class="placeholder">
			<input type="text" name="form_link_color" value="<?php echo( $form_link_color); ?>" data-default-color="#777777" class="color-field"></input>
		</div>
<?php
	}
	public function mbwph_txt_form_link_hover_color_field() {
		$option 	= get_option('form_link_hover_color');
		if ( isset( $option) ) {
			$form_link_hover_color = esc_attr($option);
		}
		else
		{
			$form_link_hover_color = "#555555";
		}
		?>
		<div class="placeholder">
			<input type="text" name="form_link_hover_color" value="<?php echo( $form_link_hover_color); ?>" data-default-color="#555555" class="color-field"></input>
		</div>
<?php
	}
	public function mbwph_txt_form_button_color_field() {
		$option 	= get_option('form_button_color');
		if ( isset( $option) ) {
			$form_button_color = esc_attr($option);
		}
		else
		{
			$form_button_color = "#555555";
		}
		?>
		<div class="placeholder">
			<input type="text" name="form_button_color" value="<?php echo( $form_button_color); ?>" data-default-color="#555555" class="color-field"></input>
		</div>
<?php
	}
	public function mbwph_txt_form_button_hover_color_field() {
		$option 	= get_option('form_button_hover_color');
		if ( isset( $option) ) {
			$form_button_hover_color = esc_attr($option);
		}
		else
		{
			$form_button_hover_color = "#555555";
		}
		?>
		<div class="placeholder">
			<input type="text" name="form_button_hover_color" value="<?php echo( $form_button_hover_color); ?>" data-default-color="#555555" class="color-field"></input>
		</div>
<?php
	}
}
