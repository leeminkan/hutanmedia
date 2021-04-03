<?php
/**
 * Plugin Name: WP Helper Lite
 * Plugin URI:  https://www.matbao.net/hosting/wp-helper-plugin.html
 * Description: The best WordPress All-in-One plugin. ❤ Made in Vietnam by MWP Team. 
 * Version:     3.2
 * Author:      Mat Bao Corp
 * Author URI:  https://www.matbao.net/hosting/wp-helper-plugin.html
 * Text Domain: mbwph
 * Domain Path: /languages
 * License:     GPL2
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
define( 'WP_HELPER_VERSION', '3.2' );
define( 'WP_HELPER_FILE' , __FILE__ );
define( 'WP_HELPER_PLUGIN_BASE', plugin_basename( WP_HELPER_FILE ) );
define( 'WP_HELPER_PATH' , realpath( plugin_dir_path( WP_HELPER_FILE ) ) . '/' );
define( 'WP_HELPER_URL' , plugin_dir_url( WP_HELPER_FILE ) );
define( 'WP_HELPER_ASSETS_URL' , WP_HELPER_URL . 'assets/' );
define( 'WP_HELPER_ASSETS_IMG_URL' , WP_HELPER_ASSETS_URL . 'images/' );
define( 'WP_HELPER_PUBLIC_URL' , WP_HELPER_PATH . 'public/' );
define( 'WP_HELPER_PUBLIC_ASSETS_URL' , WP_HELPER_PATH . 'public/partials/assets/' );
define( 'WP_HELPER_PUBLIC_IMAGES_URL' , WP_HELPER_URL . 'public/partials/assets/images' );




function mbwph_admin_notice_activation_hook() {
	set_transient( 'mwp-admin-notice', true, 5 );
}register_activation_hook( __FILE__, 'mbwph_admin_notice_activation_hook' );

function mbwph_admin_actived_notice(){
	/* Check transient, if available display notice */
	if( get_transient( 'mwp-admin-notice' ) ){
		?>
		<div class="updated notice is-dismissible">
			<p>Cám ơn bạn đã sử dụng plugin <strong>WP Helper</strong>! Hãy bấm <a href="<?php echo admin_url('admin.php?page=wp-helper'); ?>">vào đây</a> để tiến hành cài đặt.</p>
		</div>
		<?php
		/* Delete transient, only display this notice once. */
		delete_transient( 'mwp-admin-notice' );
	}
}add_action( 'admin_notices', 'mbwph_admin_actived_notice' );
require WP_HELPER_PATH . 'includes/class-wp-helper-lite.php';
function run_WP_HELPER() {
	$plugin = new WP_HELPER();
	$plugin->run();
}
run_WP_HELPER();
require WP_HELPER_PATH . 'public/woo-dashboard.php';
