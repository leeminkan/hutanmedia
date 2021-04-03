<?php
//echo get_option('disable_dashboard');
if(!empty(get_option('disable_dashboard')) && get_option('disable_dashboard') == 1){
  add_filter( 'woocommerce_admin_disabled', '__return_true');
  add_filter( 'woocommerce_marketing_menu_items', '__return_empty_array',99 );
  add_filter( 'woocommerce_admin_features', 'mwph_disable_admin_features', 99);
  add_action('wp_enqueue_scripts', 'mwph_disable_woocommerce_scripts', 99);
  add_action('wp_enqueue_scripts', 'mwph_disable_woocommerce_cart_fragmentation', 99);
  add_action('wp_dashboard_setup', 'mwph_disable_woocommerce_status');
  add_action('widgets_init', 'mwph_disable_woocommerce_widgets', 99);
}
function mwph_disable_admin_features( $features ) {
  return array_values(
        array_filter( $features, function($feature) {
            return $feature !== 'marketing';
        } )
    );
}
function mwph_disable_woocommerce_scripts() {
  if(function_exists('is_woocommerce')) {
    if(!is_woocommerce() && !is_cart() && !is_checkout() && !is_account_page() && !is_product() && !is_product_category() && !is_shop()) {

      //Dequeue WooCommerce Styles
      wp_dequeue_style('woocommerce-general');
      wp_dequeue_style('woocommerce-layout');
      wp_dequeue_style('woocommerce-smallscreen');
      wp_dequeue_style('woocommerce_frontend_styles');
      wp_dequeue_style('woocommerce_fancybox_styles');
      wp_dequeue_style('woocommerce_chosen_styles');
      wp_dequeue_style('woocommerce_prettyPhoto_css');
      //Dequeue WooCommerce Scripts
      wp_dequeue_script('wc_price_slider');
      wp_dequeue_script('wc-single-product');
      wp_dequeue_script('wc-add-to-cart');
      wp_dequeue_script('wc-checkout');
      wp_dequeue_script('wc-add-to-cart-variation');
      wp_dequeue_script('wc-single-product');
      wp_dequeue_script('wc-cart');
      wp_dequeue_script('wc-chosen');
      wp_dequeue_script('woocommerce');
      wp_dequeue_script('prettyPhoto');
      wp_dequeue_script('prettyPhoto-init');
      wp_dequeue_script('jquery-blockui');
      wp_dequeue_script('jquery-placeholder');
      wp_dequeue_script('fancybox');
      wp_dequeue_script('jqueryui');

      if(!empty(get_option('wcbloat_wc_fragmentation_disable')) && (get_option('wcbloat_wc_fragmentation_disable') == 'yes')) {
        wp_dequeue_script('wc-cart-fragments');
      }
    }
  }
}
function mwph_disable_woocommerce_cart_fragmentation() {
  if(function_exists('is_woocommerce')) {
    wp_dequeue_script('wc-cart-fragments');
  }
}
function mwph_disable_woocommerce_status() {
  remove_meta_box('woocommerce_dashboard_status', 'dashboard', 'normal');
}
function mwph_disable_woocommerce_widgets() {
  unregister_widget('WC_Widget_Products');
  unregister_widget('WC_Widget_Product_Categories');
  unregister_widget('WC_Widget_Product_Tag_Cloud');
  unregister_widget('WC_Widget_Cart');
  unregister_widget('WC_Widget_Layered_Nav');
  unregister_widget('WC_Widget_Layered_Nav_Filters');
  unregister_widget('WC_Widget_Price_Filter');
  unregister_widget('WC_Widget_Product_Search');
  unregister_widget('WC_Widget_Recently_Viewed');
  unregister_widget('WC_Widget_Recent_Reviews');
  unregister_widget('WC_Widget_Top_Rated_Products');
  unregister_widget('WC_Widget_Rating_Filter');
}
if(!empty(get_option('quick_buy')) && get_option('quick_buy') == 1){
  add_action('woocommerce_after_add_to_cart_button', 'mwph_quickbuy_button');
  add_filter('woocommerce_add_to_cart_redirect', 'mwph_redirect_to_checkout');
}
function mwph_quickbuy_button(){
    global $product;
    $options 	= get_option( 'call_for_price_phone' );
?>
    <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="single_add_to_cart_button button alt" id="buy_now_button">
        <?php _e('Mua ngay','mwph'); ?>
    </button>
    <?php if(!empty(get_option('call_for_price')) && (get_option('call_for_price') == 1)&& !empty($options['phone-text'])&& !empty($options['phone-number'])){ ?>
      <span class="call-for-price"><span class="dashicons dashicons-smartphone"></span> <?php echo $options['phone-text'];?>: <a href="tel:<?php echo $options['phone-number'];?>"><strong><?php echo $options['phone-number'];?></strong></a></span>
    <?php
      }
    ?>
    <input type="hidden" name="is_buy_now" id="is_buy_now" value="0" />
    <script>
        jQuery(document).ready(function(){
            jQuery('body').on('click', '#buy_now_button', function(){
                if(jQuery(this).hasClass('disabled')) return;
                var thisParent = jQuery(this).closest('form.cart');
                jQuery('#is_buy_now', thisParent).val('1');
                thisParent.submit();
            });
        });
    </script>
    <?php
}
function mwph_redirect_to_checkout($redirect_url) {
    if (isset($_REQUEST['is_buy_now']) && $_REQUEST['is_buy_now']) {
        $redirect_url = wc_get_checkout_url();
    }
    return $redirect_url;
}
