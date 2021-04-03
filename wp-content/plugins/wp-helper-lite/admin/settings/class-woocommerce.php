<?php
/**
 * Controls settings of plugin
 *
 * @package    WP_HELPER
 * @subpackage WP_HELPER/admin/settings
 */
//include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
class WP_HELPER_WooCommerce extends WP_HELPER_Admin {
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
		$this->id    = 'woocommerce';
		$this->label = __( 'WooCommerce', 'mbwph' );
		$this->WP_HELPER = $WP_HELPER;
		$this->woo_plugin = 'woocommerce/woocommerce.php';
		$this->plugin = 'wp-helper-premium/wp-helper-premium.php';
	}

	/**
	 * Creates our settings sections with fields etc.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function mbwph_settings_woocommerce_init() {
		$this->general_post_init();
	}

	/**
	 * Creates post settings sections with fields etc.
	 *
	 * @since    1.1.0
	 * @access   public
	 */
	public function general_post_init() {
		// add_settings_section( $id, $title, $callback, $menu_slug );
		add_settings_section(
			$this->WP_HELPER . '-woo-optimize-options', // section
			apply_filters( $this->WP_HELPER . '-display-section-title', __( '', 'mbwph' ) ),
			array( $this, 'display_woo_optimize_section' ),
			$this->WP_HELPER . '_woocommerce_tab'
		);
		// Tien ich gio hang
		add_settings_section(
			$this->WP_HELPER . '-woo-addon-options', // section
			apply_filters( $this->WP_HELPER . '-display-section-title', __( '', 'mbwph' ) ),
			array( $this, 'display_woo_addon_section' ),
			$this->WP_HELPER . '_woocommerce_tab'
		);
			add_settings_field(
				'quick_buy',
				apply_filters( $this->WP_HELPER . '-quick_buy-label', __( 'Nút mua ngay', 'mbwph' ) ),
				array( $this, 'mbwph_opt_quick_buy_field' ),
				$this->WP_HELPER . '_woocommerce_tab',		// Page
				$this->WP_HELPER . '-woo-addon-options', 	// section to add to
				array( // The $args
					'quick_buy' // Should match Option ID
				)
			);
			add_settings_field(
				'call_for_price',
				apply_filters( $this->WP_HELPER . '-call_for_price-label', __( 'Nút liên hệ', 'mbwph' ) ),
				array( $this, 'mbwph_opt_call_for_price_field' ),
				$this->WP_HELPER . '_woocommerce_tab',		// Page
				$this->WP_HELPER . '-woo-addon-options', 	// section to add to
				array( // The $args
					'call_for_price' // Should match Option ID
				)
			);
			add_settings_field(
				'call_for_price_phone',
				apply_filters( $this->WP_HELPER . '-call_for_price_phone-label', __( '', 'mbwph' ) ),
				array( $this, 'mbwph_txt_call_for_price_phone_field' ),
				$this->WP_HELPER . '_woocommerce_tab',		// Page
				$this->WP_HELPER . '-woo-addon-options', 	// section to add to
				array( // The $args
					'call_for_price_phone' // Should match Option ID
				)
			);
			add_settings_field(
				'auto_update_cart',
				apply_filters( $this->WP_HELPER . '-auto_update_cart-label', __( 'Cập nhật giá tự động', 'mbwph' ) ),
				array( $this, 'mbwph_opt_auto_update_cart_field' ),
				$this->WP_HELPER . '_woocommerce_tab',		// Page
				$this->WP_HELPER . '-woo-addon-options', 	// section to add to
				array( // The $args
					'auto_update_cart' // Should match Option ID
				)
			);
			//Tối ưu
		add_settings_section(
			$this->WP_HELPER . '-woo-page-options', // section
			apply_filters( $this->WP_HELPER . '-display-section-title', __( '', 'mbwph' ) ),
			array( $this, 'display_woo_page_section' ),
			$this->WP_HELPER . '_woocommerce_tab'
		);
		// add_settings_section(
		// 	$this->WP_HELPER . '-woo-optimize-billing-options', // section
		// 	apply_filters( $this->WP_HELPER . '-display-section-title', __( '', 'mbwph' ) ),
		// 	array( $this, 'print_woo_optimize_bill_section' ),
		// 	$this->WP_HELPER . '_woocommerce_tab'
		// );

		//add_settings_field( string $id, string $title, callable $callback, string $page, string $section = 'default', array $args = array() )
		add_settings_field(
			'disable_dashboard',
			apply_filters( $this->WP_HELPER . '-disable_dashboard-label', __( 'Tăng tốc trang Admin', 'mbwph' ) ),
			array( $this, 'mbwph_opt_disable_dashboard_field' ),
			$this->WP_HELPER . '_woocommerce_tab',		// Page
			$this->WP_HELPER . '-woo-page-options', 	// section to add to
			array( // The $args
				'disable_dashboard' // Should match Option ID
			)
		);
		add_settings_field(
			'billing_first_name',
			apply_filters( $this->WP_HELPER . '-billing_first_name-label', __( 'Thông tin thanh toán', 'mbwph' ) ),
			array( $this, 'mbwph_billing_first_name_field' ),
			$this->WP_HELPER . '_woocommerce_tab',		// Page
			$this->WP_HELPER . '-woo-page-options', 	// section to add to
			array( // The $args
				'billing_first_name' // Should match Option ID
			)
		);
		add_settings_field(
			'billing_company',
			apply_filters( $this->WP_HELPER . '-billing_company-label', __( '', 'mbwph' ) ),
			array( $this, 'mbwph_billing_company_field' ),
			$this->WP_HELPER . '_woocommerce_tab',		// Page
			$this->WP_HELPER . '-woo-page-options', 	// section to add to
			array( // The $args
				'billing_company' // Should match Option ID
			)
		);
		add_settings_field(
			'billing_address_2',
			apply_filters( $this->WP_HELPER . '-billing_address_2-label', __( '', 'mbwph' ) ),
			array( $this, 'mbwph_billing_address_2_field' ),
			$this->WP_HELPER . '_woocommerce_tab',		// Page
			$this->WP_HELPER . '-woo-page-options', 	// section to add to
			array( // The $args
				'billing_address_2' // Should match Option ID
			)
		);
		add_settings_field(
			'billing_state',
			apply_filters( $this->WP_HELPER . '-billing_state-label', __( '', 'mbwph' ) ),
			array( $this, 'mbwph_billing_state_field' ),
			$this->WP_HELPER . '_woocommerce_tab',		// Page
			$this->WP_HELPER . '-woo-page-options', 	// section to add to
			array( // The $args
				'billing_state' // Should match Option ID
			)
		);
		add_settings_field(
			'billing_city',
			apply_filters( $this->WP_HELPER . '-billing_city-label', __( '', 'mbwph' ) ),
			array( $this, 'mbwph_billing_city_field' ),
			$this->WP_HELPER . '_woocommerce_tab',		// Page
			$this->WP_HELPER . '-woo-page-options', 	// section to add to
			array( // The $args
				'billing_city' // Should match Option ID
			)
		);
		add_settings_field(
			'billing_country',
			apply_filters( $this->WP_HELPER . '-billing_country-label', __( '', 'mbwph' ) ),
			array( $this, 'mbwph_billing_country_field' ),
			$this->WP_HELPER . '_woocommerce_tab',		// Page
			$this->WP_HELPER . '-woo-page-options', 	// section to add to
			array( // The $args
				'billing_country' // Should match Option ID
			)
		);
		add_settings_field(
			'billing_postcode',
			apply_filters( $this->WP_HELPER . '-billing_postcode-label', __( '', 'mbwph' ) ),
			array( $this, 'mbwph_billing_postcode_field' ),
			$this->WP_HELPER . '_woocommerce_tab',		// Page
			$this->WP_HELPER . '-woo-page-options', 	// section to add to
			array( // The $args
				'billing_postcode' // Should match Option ID
			)
		);




		// add_settings_field(
		// 	'shipping_company',
		// 	apply_filters( $this->WP_HELPER . '-shipping_company-label', __( 'Tên công ty (giao hàng)', 'mbwph' ) ),
		// 	array( $this, 'mbwph_shipping_company_field' ),
		// 	$this->WP_HELPER . '_woocommerce_tab',		// Page
		// 	$this->WP_HELPER . '-woo-optimize-billing-options', 	// section to add to
		// 	array( // The $args
		// 		'shipping_company' // Should match Option ID
		// 	)
		// );
		// add_settings_field(
		// 	'shipping_postcode',
		// 	apply_filters( $this->WP_HELPER . '-shipping_postcode-label', __( 'Mã bưu điện', 'mbwph' ) ),
		// 	array( $this, 'mbwph_shipping_postcode_field' ),
		// 	$this->WP_HELPER . '_woocommerce_tab',		// Page
		// 	$this->WP_HELPER . '-woo-optimize-billing-options', 	// section to add to
		// 	array( // The $args
		// 		'shipping_postcode' // Should match Option ID
		// 	)
		// );
		// add_settings_field(
		// 	'shipping_country',
		// 	apply_filters( $this->WP_HELPER . '-shipping_country-label', __( 'Quốc gia', 'mbwph' ) ),
		// 	array( $this, 'mbwph_shipping_country_field' ),
		// 	$this->WP_HELPER . '_woocommerce_tab',		// Page
		// 	$this->WP_HELPER . '-woo-optimize-billing-options', 	// section to add to
		// 	array( // The $args
		// 		'shipping_country' // Should match Option ID
		// 	)
		// );
		// add_settings_field(
		// 	'shipping_city',
		// 	apply_filters( $this->WP_HELPER . '-shipping_city-label', __( 'Tỉnh / Thành phố', 'mbwph' ) ),
		// 	array( $this, 'mbwph_shipping_city_field' ),
		// 	$this->WP_HELPER . '_woocommerce_tab',		// Page
		// 	$this->WP_HELPER . '-woo-optimize-billing-options', 	// section to add to
		// 	array( // The $args
		// 		'shipping_city' // Should match Option ID
		// 	)
		// );
		// add_settings_field(
		// 	'shipping_state',
		// 	apply_filters( $this->WP_HELPER . '-shipping_state-label', __( 'Quận / Huyện', 'mbwph' ) ),
		// 	array( $this, 'mbwph_shipping_state_field' ),
		// 	$this->WP_HELPER . '_woocommerce_tab',		// Page
		// 	$this->WP_HELPER . '-woo-optimize-billing-options', 	// section to add to
		// 	array( // The $args
		// 		'shipping_state' // Should match Option ID
		// 	)
		// );
		// add_settings_field(
		// 	'shipping_address_2',
		// 	apply_filters( $this->WP_HELPER . '-shipping_address_2-label', __( 'Địa chỉ giao hàng 2', 'mbwph' ) ),
		// 	array( $this, 'mbwph_shipping_address_2_field' ),
		// 	$this->WP_HELPER . '_woocommerce_tab',		// Page
		// 	$this->WP_HELPER . '-woo-optimize-billing-options', 	// section to add to
		// 	array( // The $args
		// 		'shipping_address_2' // Should match Option ID
		// 	)
		// );
		register_setting($this->WP_HELPER . '_woocommerce_tab','disable_dashboard');
		register_setting($this->WP_HELPER . '_woocommerce_tab','quick_buy');
		register_setting($this->WP_HELPER . '_woocommerce_tab','call_for_price');
		register_setting($this->WP_HELPER . '_woocommerce_tab','call_for_price_phone');
		register_setting($this->WP_HELPER . '_woocommerce_tab','auto_update_cart');
		register_setting($this->WP_HELPER . '_woocommerce_tab','optimize_checkout');
		/*Billing*/
		register_setting($this->WP_HELPER . '_woocommerce_tab','billing_company');
		register_setting($this->WP_HELPER . '_woocommerce_tab','billing_first_name');
		register_setting($this->WP_HELPER . '_woocommerce_tab','billing_postcode');
		register_setting($this->WP_HELPER . '_woocommerce_tab','billing_country');
		register_setting($this->WP_HELPER . '_woocommerce_tab','billing_city');
		register_setting($this->WP_HELPER . '_woocommerce_tab','billing_state');
		register_setting($this->WP_HELPER . '_woocommerce_tab','billing_address_2');
		/*Shipping*/
		// register_setting($this->WP_HELPER . '_woocommerce_tab','shipping_company');
		// register_setting($this->WP_HELPER . '_woocommerce_tab','shipping_postcode');
		// register_setting($this->WP_HELPER . '_woocommerce_tab','shipping_country');
		// register_setting($this->WP_HELPER . '_woocommerce_tab','shipping_city');
		// register_setting($this->WP_HELPER . '_woocommerce_tab','shipping_state');
		// register_setting($this->WP_HELPER . '_woocommerce_tab','shipping_address_2');
	}

	/**
	 * Creates a settings section
	 *
	 * @since 		1.0.0
	 * @param 		array 		$params 		Array of parameters for the section
	 * @return 		mixed 						The settings section
	 */
	public function display_woo_optimize_section( $params ) {
		_e ('<h3><span class="dashicons dashicons-cart"></span>Tối ưu giỏ hàng</h3>', 'mbwph');
		_e( '<span class="description">Chức năng này chỉ áp dụng cho website đang sử dụng <b>WooCommerce</b> làm giỏ hàng.</span><hr>','mbwph');
	}
	public function display_woo_addon_section( $params ) {
		_e ('<h4>Tiện ích mở rộng</h4>', 'mbwph');
	}
	public function display_woo_page_section( $params ) {
		_e ('<h4>Nâng cao</h4>', 'mbwph');
	}
	// public function print_woo_optimize_bill_section( $params ) {
	// 	_e ('<div id="woo-optimize-section">');
	// }
	/**
	 * Enable/Disable Checkbox Field
	 *
	 * @since 		1.0.0
	 * @return 		mixed 			The settings field
	 */
	public function mbwph_opt_disable_dashboard_field() {
		$status = '';
		$option = 0;
		if (!is_plugin_active($this->plugin)) {
			$status = 'disabled';
			$option = 0;
			$description = __('Chức năng nâng cao dành riêng cho phiên bản <a href="https://www.matbao.net/hosting/wp-helper-plugin.html" target="_bland" class="premium-text">Premium</a>','mbwph');
		}else{
			$option 	= get_option('disable_dashboard');
			$description = __('Loại bỏ các Widget của giỏ hàng không cần thiết.', 'mbwph');
		}
		
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" id="disable_dashboard" name="disable_dashboard" value="1" <?php checked( $option, 1 , true );  echo $status?> />
			<label class="custom-switch-btn" for="disable_dashboard"></label>
			<span class="description"><?php echo $description; ?></span>
		</div>
<?php
	}
	public function mbwph_opt_quick_buy_field() {
		$option 	= get_option('quick_buy');
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" id="quick_buy" name="quick_buy" value="1" <?php checked( $option, 1 , true ); ?> />
			<label class="custom-switch-btn" for="quick_buy"></label>
			<span class="description"><?php _e('Tính năng giúp mua hàng nhanh không thông qua giỏ hàng.', 'mbwph'); ?></span>
		</div>
<?php
	}
	public function mbwph_opt_call_for_price_field() {
		$status = '';
		if (!is_plugin_active($this->plugin)) {
			$status = 'disabled';
			$option = 0;
			$description = __('Chức năng nâng cao dành riêng cho phiên bản <a href="https://www.matbao.net/hosting/wp-helper-plugin.html" target="_bland" class="premium-text">Premium</a>','mbwph');
		}else{
			$option 	= get_option( 'call_for_price' );
			$description = __('Thêm nút liên hệ để đặt hàng nhanh.', 'mbwph');
		}		
		?>
		<span class="description"></span>
		<div id="call-for-price-active" class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" id="call_for_price" name="call_for_price" value="1" <?php checked( $option, 1 , true ); echo $status; ?>  data-toggle='collapse' data-target='#Phonecollapse'/>
			<label class="custom-switch-btn" for="call_for_price"></label>
			<span class="description"><?php echo $description; ?></span>
		</div>
<?php
	}
	public function mbwph_txt_call_for_price_phone_field() {
		$options 	= get_option( 'call_for_price_phone' );
		$phone_text 		= $options['phone-text'];
		$phone_number 		= $options['phone-number'];
		?>
		<div id="Phonecollapse" class="form-row collapse">
				<div class="form-group col-md-6">
		      <input type="text" id="call_for_price_phone[phone-text]" name="call_for_price_phone[phone-text]" value="<?php echo($phone_text); ?>" class="form-control" placeholder="<?php _e('Liên hệ','mwph'); ?>">
		    </div>
				<div class="form-group col-md-6">
					<input type="text" id="call_for_price_phone[phone-number]" name="call_for_price_phone[phone-number]" value="<?php echo($phone_number); ?>" class="form-control" placeholder="<?php _e('Vd: 0909 XXX XXX','mwph'); ?>"/>
				</div>
		</div>
<?php
	}
	public function mbwph_opt_auto_update_cart_field() {
		$status = '';
		if (!is_plugin_active($this->plugin)) {
			$status = 'disabled';
			$option = 0;
			$description = __('Chức năng nâng cao dành riêng cho phiên bản <a href="https://www.matbao.net/hosting/wp-helper-plugin.html" target="_bland" class="premium-text">Premium</a>','mbwph');
		}else{
			$option 	= get_option( 'auto_update_cart' );
			$description = __('Tự động cập nhật giá bán khi thay đổi số lượng trong giỏ hàng.', 'mbwph');;
		}		
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" id="auto_update_cart" name="auto_update_cart" value="<?php echo $option; ?>" <?php checked( $option, 1 , true );  echo $status;?> />
			<label class="custom-switch-btn" for="auto_update_cart"></label>
			<span class="description"><?php echo $description; ?></span>
		</div>
<?php
	}
	public function mbwph_billing_first_name_field() {
		$option 	= get_option('billing_first_name');
		?>
		<div class="custom-control custom-checkbox">
			<input class="custom-control-input" type="checkbox" id="billing_first_name" name="billing_first_name" value="1" <?php checked( $option, 1 , true ); ?> />
			<label class="custom-control-label" for="billing_first_name">Chỉ hiển thị Họ tên</label>
		</div>
<?php
	}
	public function mbwph_billing_company_field() {
		$option 	= get_option('billing_company');
		?>
		<div class="custom-control custom-checkbox">
			<input class="custom-control-input" type="checkbox" id="billing_company" name="billing_company" value="1" <?php checked( $option, 1 , true ); ?> />
			<label class="custom-control-label" for="billing_company">Ẩn tên công ty</label>
		</div>
<?php
	}
	public function mbwph_billing_address_2_field() {
		$option 	= get_option('billing_address_2');
		?>
		<div class="custom-control custom-checkbox">
			<input class="custom-control-input" type="checkbox" id="billing_address_2" name="billing_address_2" value="1" <?php checked( $option, 1 , true ); ?> />
			<label class="custom-control-label" for="billing_address_2">Chỉ hiển thị 1 dòng địa chỉ</label>
		</div>
<?php
	}
	public function mbwph_billing_city_field() {
		$option 	= get_option('billing_city');
		?>
		<div class="custom-control custom-checkbox">
			<input class="custom-control-input" type="checkbox" id="billing_city" name="billing_city" value="1" <?php checked( $option, 1 , true ); ?> />
			<label class="custom-control-label" for="billing_city">Ẩn Tỉnh / Thành phố</label>
		</div>
<?php
	}
	public function mbwph_billing_state_field() {
		$option 	= get_option('billing_state');
		?>
		<div class="custom-control custom-checkbox">
			<input class="custom-control-input" type="checkbox" id="billing_state" name="billing_state" value="1" <?php checked( $option, 1 , true ); ?> />
			<label class="custom-control-label" for="billing_state">Ẩn Quận / Huyện</label>
		</div>
<?php
	}
	public function mbwph_shipping_company_field() {
		$option 	= get_option('shipping_company');
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" name="shipping_company" value="1" <?php checked( $option, 1 , true ); ?> />
			<div class="state p-success">
				<label></label>
			</div>
		</div>
<?php
	}
	public function mbwph_billing_country_field() {
		$option 	= get_option('billing_country');
		?>
		<div class="custom-control custom-checkbox">
			<input class="custom-control-input" type="checkbox" id="billing_country" name="billing_country" value="1" <?php checked( $option, 1 , true ); ?> />
			<label class="custom-control-label" for="billing_country">Ẩn Quốc gia</label>
		</div>
<?php
	}
	public function mbwph_billing_postcode_field() {
		$option 	= get_option('billing_postcode');
		?>
		<div class="custom-control custom-checkbox">
			<input class="custom-control-input" type="checkbox" id="billing_postcode" name="billing_postcode" value="1" <?php checked( $option, 1 , true ); ?> />
			<label class="custom-control-label" for="billing_postcode">Ẩn mã bưu điện</label>
		</div>
<?php
	}
	public function mbwph_shipping_postcode_field() {
		$option 	= get_option('shipping_postcode');
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" name="shipping_postcode" value="1" <?php checked( $option, 1 , true ); ?> />
			<div class="state p-success">
				<label></label>
			</div>
		</div>
<?php
	}
	public function mbwph_shipping_country_field() {
		$option 	= get_option('shipping_country');
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" name="shipping_country" value="1" <?php checked( $option, 1 , true ); ?> />
			<div class="state p-success">
				<label></label>
			</div>
		</div>
<?php
	}
	public function mbwph_shipping_city_field() {
		$option 	= get_option('shipping_city');
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" name="shipping_city" value="1" <?php checked( $option, 1 , true ); ?> />
			<div class="state p-success">
				<label></label>
			</div>
		</div>
<?php
	}
	public function mbwph_shipping_state_field() {
		$option 	= get_option('shipping_state');
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" name="shipping_state" value="1" <?php checked( $option, 1 , true ); ?> />
			<div class="state p-success">
				<label></label>
			</div>
		</div>
<?php
	}
	public function mbwph_shipping_address_2_field() {
		$option 	= get_option('shipping_address_2');
		?>
		<div class="custom-switch custom-switch-label-onoff">
			<input class="custom-switch-input" type="checkbox" name="shipping_address_2" value="1" <?php checked( $option, 1 , true ); ?> />
			<div class="state p-success">
				<label></label>
			</div>
		</div>
<?php
	}
}
