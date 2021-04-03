<?php
/**
 * Controls settings of plugin
 *
 * @package    WP_HELPER
 * @subpackage WP_HELPER/admin/settings
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
class WP_HELPER_General extends WP_HELPER_Admin {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $WP_HELPER    The ID of this plugin.
	 */
	private $WP_HELPER, $plugin;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $WP_HELPER       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $WP_HELPER ) {
		$this->id    = 'general';
		$this->label = __( 'General', 'mbwph' );
		$this->WP_HELPER = $WP_HELPER;
		$this->plugin = 'wp-helper-premium/wp-helper-premium.php';
	}

	/**
	 * Creates our settings sections with fields etc.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function mbwph_settings_general_init() {
		$this->general_post_init();
	}

	/**
	 * Creates post settings sections with fields etc.
	 *
	 * @since    1.1.0
	 * @access   public
	 */
	public function general_post_init() {
		add_settings_section(
			$this->WP_HELPER . '-addon-options', // section
			apply_filters( $this->WP_HELPER . '-display-section-title', __( '', 'mbwph' ) ),
			array( $this, 'main_utilities_section' ),
			$this->WP_HELPER . '_general_tab'
		);
		add_settings_section(
			$this->WP_HELPER . '-content-options', // section
			apply_filters( $this->WP_HELPER . '-display-section-title', __( '', 'mbwph' ) ),
			array( $this, 'manage_content_section' ),
			$this->WP_HELPER . '_general_tab'
		);
			add_settings_field(
				'editor_type',
				apply_filters( $this->WP_HELPER . '-editor_type-label', __( 'Trình soạn thảo', 'mbwph' ) ),
				array( $this, 'mbwph_opt_editor_type_field' ),
				$this->WP_HELPER . '_general_tab',		// Page
				$this->WP_HELPER . '-content-options', 	// section to add to
				array( // The $args
					'editor_type' // Should match Option ID
				)
			);
		add_settings_section(
			$this->WP_HELPER . '-widgets-options', // section
			apply_filters( $this->WP_HELPER . '-display-section-title', __( '', $this->WP_HELPER ) ),
			array( $this, 'manage_duplicate_section' ),
			$this->WP_HELPER . '_general_tab'
		);
			add_settings_field(
				'duplicate_post_page',
				apply_filters( $this->WP_HELPER . '-duplicate_post_page-label', __( 'Trang / Bài viết', 'mbwph' ) ),
				array( $this, 'mbwph_cb_duplicate_post_page_field' ),
				$this->WP_HELPER . '_general_tab',		// Page
				$this->WP_HELPER . '-widgets-options', 	// section to add to
				array( // The $args
					'duplicate_post_page' // Should match Option ID
				)
			);
			add_settings_field(
				'duplicate_widget',
				apply_filters( $this->WP_HELPER . '-duplicate_widget-label', __( 'Widget', 'mbwph' ) ),
				array( $this, 'mbwph_cb_duplicate_widget_field' ),
				$this->WP_HELPER . '_general_tab',		// Page
				$this->WP_HELPER . '-widgets-options', 	// section to add to
				array( // The $args
					'duplicate_widget' // Should match Option ID
				)
			);
			add_settings_field(
				'duplicate_menu',
				apply_filters( $this->WP_HELPER . '-duplicate_menu-label', __( 'Menu', 'mbwph' ) ),
				array( $this, 'mbwph_cb_duplicate_menu_field' ),
				$this->WP_HELPER . '_general_tab',		// Page
				$this->WP_HELPER . '-widgets-options', 	// section to add to
				array( // The $args
					'duplicate_menu' // Should match Option ID
				)
			);
		add_settings_section(
			$this->WP_HELPER . '-advanced-options', // section
			apply_filters( $this->WP_HELPER . '-display-section-title', __( '', $this->WP_HELPER ) ),
			array( $this, 'display_advanced_section' ),
			$this->WP_HELPER . '_general_tab'
		);
			add_settings_field(
				'hide_sidebar',
				apply_filters( $this->WP_HELPER . '-hide_sidebar-label', __( 'Ẩn tin tài trợ', 'mbwph' ) ),
				array( $this, 'mbwph_cb_hide_sidebar_field' ),
				$this->WP_HELPER . '_general_tab',		// Page
				$this->WP_HELPER . '-advanced-options', 	// section to add to
				array( // The $args
					'hide_sidebar' // Should match Option ID
				)
			);					
			add_settings_field(
				'wprocket_install',
				apply_filters( $this->WP_HELPER . '-wprocket_install-label', __( 'WP Rocket', 'mbwph' ) ),
				array( $this, 'mbwph_btn_wprocket_install_field' ),
				$this->WP_HELPER . '_general_tab',		// Page
				$this->WP_HELPER . '-advanced-options', 	// section to add to
				array( // The $args
					'wprocket_install' // Should match Option ID
				)
			);
			add_settings_field(
				'aiomigration_install',
				apply_filters( $this->WP_HELPER . '-aiomigration_install-label', __( 'Loại bỏ giới hạn dung lượng', 'mbwph' ) ),
				array( $this, 'mbwph_btn_aiomigration_install_field' ),
				$this->WP_HELPER . '_general_tab',		// Page
				$this->WP_HELPER . '-advanced-options', 	// section to add to
				array( // The $args
					'aiomigration_install' // Should match Option ID
				)
			);
		register_setting($this->WP_HELPER . '_general_tab','editor_type');
		register_setting($this->WP_HELPER . '_general_tab','duplicate_post_page');
		/*register_setting($this->WP_HELPER . '_general_tab','relative_image_url');*/
		register_setting($this->WP_HELPER . '_general_tab','duplicate_widget');
		register_setting($this->WP_HELPER . '_general_tab','allow_widget_class');
		register_setting($this->WP_HELPER . '_general_tab','duplicate_menu');
		register_setting($this->WP_HELPER . '_general_tab','hide_sidebar');
	}

	/**
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	 public function main_utilities_section( $params ) {
		 _e('<h3><span class="dashicons dashicons-admin-plugins"></span> Tiện ích mở rộng</h3>','mbwph');
		 _e('<span class="description">Thêm nhiều tính nâng hơn giúp cải thiện trang quản lý WordPress.</span><hr>','mbwph');
	 }
	 public function manage_content_section( $params ) {
	 	_e('<h4>Quản lý nội dung</h4>','mbwph');
	 }
	public function manage_duplicate_section( $params ) {
		_e('<h4>Nhân bản</h4>','mbwph');
	}
	public function display_advanced_section( $params ) {
		_e('<h4>Nâng cao</h4>','mbwph');
		_e('<span class="description">Các chức năng nâng cao dành riêng cho phiên bản <a href="https://www.matbao.net/hosting/wp-helper-plugin.html" target="_bland" class="premium-text">Premium</a></span>','mbwph');
	}
	/**
	 * Enable/Disable Checkbox Field
	 *
	 * @since 		1.0.0
	 * @return 		mixed 			The settings field
	 */
	public function mbwph_opt_editor_type_field() {
		$option 	= get_option('editor_type');
		if ( empty( $option ) ) {$option = '';}
		?>
		<div class="input-group">
			<select name="editor_type">
				<option value=''><?php _e('Gutenberg', 'mbwph'); ?></option>
				<option value="1" <?php selected( $option, 1 , true ); ?>><?php _e('Classic Editor', 'mbwph'); ?></option>
				<!--option value="2" disabled><?php //_e('TinyMCE Editor', 'mbwph'); ?></option-->
			</select>
			<span class="el-switch-style"></span>
		</div>
		<span class="description"><?php _e('', 'mbwph'); ?></span>
<?php
	}
	public function mbwph_cb_duplicate_post_page_field() {
		$option 	= get_option('duplicate_post_page');
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input id="duplicate_post_page" class="custom-switch-input" type="checkbox" name="duplicate_post_page" value="1" <?php checked( $option, 1 , true ); ?> />
			<label class="custom-switch-btn" for="duplicate_post_page"></label>
			<span class="description"><?php _e('Cho phép nhân bản trang / bài viết.', 'mbwph'); ?></span>
			<span class="description"  data-toggle="tooltip" data-placement="right" title="<img src='/wp-content/plugins/wp-helper-lite/assets/images/clone-post-page.png'>"><span class="dashicons dashicons-editor-help"></span>
		</div>
<?php
	}
	public function mbwph_cb_duplicate_widget_field() {
		$option 	= get_option('duplicate_widget');
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" id="duplicate_widget" name="duplicate_widget" value="1" <?php checked( $option, 1 , true ); ?> />
			<label class="custom-switch-btn" for="duplicate_widget"></label>
			<span class="description"><?php _e('Cho phép nhân bản Widget.', 'mbwph'); ?></span>
			<span class="description"  data-toggle="tooltip" data-placement="right" title="<img src='/wp-content/plugins/wp-helper-lite/assets/images/clone-widget.png'>"><span class="dashicons dashicons-editor-help"></span>
		</div>
<?php
	}
	public function mbwph_cb_duplicate_menu_field() {
		$option 	= get_option('duplicate_menu');
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox"  id="duplicate_menu" name="duplicate_menu" value="1" <?php checked( $option, 1 , true ); ?> />
			<label class="custom-switch-btn" for="duplicate_menu"></label>
			<span class="description"><?php _e('Cho phép nhân bản menu.', 'mbwph'); ?></span>
			<span class="description"  data-toggle="tooltip" data-placement="right" title="<img src='/wp-content/plugins/wp-helper-lite/assets/images/clone-menu.png'>"><span class="dashicons dashicons-editor-help"></span></span>
		</div>
<?php
	}
	public function mbwph_cb_hide_sidebar_field() {
		$status = '';
		if (!is_plugin_active($this->plugin)) {
			$status = 'disabled';
			$option = 0;
		}else{
			$option 	= get_option( 'hide_sidebar' );
		}
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" id="hide_sidebar" name="hide_sidebar" value="1" <?php checked( $option, 1 , true ); ?> <?php echo $status; ?>/>
			<label class="custom-switch-btn" for="hide_sidebar"></label>
			<span class="description"><?php _e('Ẩn các nội dung tại thanh bên phải.', 'mbwph'); ?></span>
		</div>
<?php
	}
	public function mbwph_btn_wprocket_install_field() {
		if (is_plugin_active($this->plugin)) {
		?>
			<a class="btn btn-success btn-sm install" target="_blank" href="../wp-admin/themes.php?page=mwp-install-plugins&amp;plugin_status=install"> <?php _e('Cài đặt','mbwph');?></a>
			<span class="description"><?php _e('Tăng tốc website WordPress, 100% bản quyền từ <a href="https://wp-rocket.me/" target="_bland">WP Rocket</a>.', 'mbwph'); ?></span>
		<?php
		}else{ ?>
			<a class="btn btn-secondary btn-sm install disabled"> <?php _e('Cài đặt','mbwph');?></span></a>
			<span class="description"><?php _e('Tăng tốc website WordPress, 100% bản quyền từ <a href="https://wp-rocket.me/" target="_bland">WP Rocket</a>.', 'mbwph'); ?></span>
		<?php
		}
	}
	public function mbwph_btn_aiomigration_install_field() {
		if (is_plugin_active($this->plugin)) {
		?>
			<a class="btn btn-success btn-sm install" target="_blank" href="../wp-admin/themes.php?page=mwp-install-plugins&amp;plugin_status=install"> <?php _e('Cài đặt','mbwph');?></a>
			<span class="description"><?php _e('Loại bỏ giới hạn dung lượng của plugin <a href="https://vi.wordpress.org/plugins/all-in-one-wp-migration/" target="_bland">All in One WP Migraion</a>.', 'mbwph'); ?></span>
		<?php
		}else{ ?>
			<a class="btn btn-secondary btn-sm install disabled"> <?php _e('Cài đặt','mbwph');?></span></a>
			<span class="description"><?php _e('Loại bỏ giới hạn dung lượng của plugin <a href="https://vi.wordpress.org/plugins/all-in-one-wp-migration/" target="_bland">All in One WP Migration</a>.', 'mbwph'); ?></span>
		<?php
		}
	}
}
