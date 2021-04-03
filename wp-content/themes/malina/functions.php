<?php 
/* ------------------------------------------------------------------------ */
/* Translation
/* Translations can be filed in the framework/languages/ directory */

load_theme_textdomain( 'malina', get_template_directory() . '/languages' );

$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if ( is_readable($locale_file) ){
	require_once($locale_file);
}

include_once(trailingslashit( get_template_directory() ).'framework/customizer/customizer.php');
include_once(trailingslashit( get_template_directory() ).'framework/inc/customcss.php');
if( is_admin() ){
	include_once(trailingslashit( get_template_directory() ).'framework/inc/editor-customcss.php');
}
include_once(trailingslashit( get_template_directory() ).'framework/inc/sidebars.php'); // register widgets area
include_once(trailingslashit( get_template_directory() ).'framework/inc/sidebar-generator.php'); // add custom sidebars

if(!function_exists('malina_scripts_basic')){
	function malina_scripts_basic() { 
		if ( is_singular() ) { 
			wp_enqueue_script( 'comment-reply' ); 
		} 
		wp_enqueue_script('html5', get_template_directory_uri().'/js/html5shiv.js', array(), '3.7.3' );
		wp_script_add_data('html5', 'conditional', 'lt IE 9' );
		wp_register_script('owl-carousel', get_template_directory_uri() . '/js/owl.carousel.min.js', array('jquery'), '2.0.0', TRUE);
		if( get_theme_mod('malina_lightbox', true) ){
			wp_enqueue_script('image-lightbox', get_template_directory_uri() . '/js/image-lightbox.min.js', array('jquery'), '1.0', TRUE);
		}
		wp_register_script('isotope', get_template_directory_uri() . '/js/isotope.min.js', array('jquery'), '3.0.0', true);
		wp_register_script('infinite-scroll', get_template_directory_uri() . '/js/infinite-scroll.pkgd.min.js', array('jquery'), '2.1.0', true);
		if( (!is_archive() && get_theme_mod('malina_sticky_sidebar', 'sticky') == 'sticky') || (is_archive() && get_theme_mod('malina_sticky_sidebar_archive', 'sticky') == 'sticky') ){
			wp_enqueue_script('theia-sticky-sidebar', get_template_directory_uri() . '/js/theia-sticky-sidebar.js', array('jquery'), '1.7.0', true);
		}
		if( get_theme_mod('malina_responsiveness', true) ) {
			wp_enqueue_script('jquery-dlmenu', get_template_directory_uri() . '/js/jquery.dlmenu.js', array('jquery'), '1.0.1', true);
		}
		if( get_theme_mod('malina_subscribe_enable', false) && get_theme_mod('malina_subscribe_popup_time','') != '' ) {
			wp_enqueue_script('jquery.cookie', get_template_directory_uri() . '/js/jquery.cookie.min.js', array('jquery'), '1.4.1', true);
		}
		if( get_theme_mod('malina_smooth_scroll', false) ){
			wp_enqueue_script('malina-smoothscroll', get_template_directory_uri() . '/js/malina-smoothscroll.js', array('jquery'), '1.0', TRUE);
		}
		if(get_theme_mod('malina_live_search', false) == true){
			wp_enqueue_script('malina-ajaxsearch', get_template_directory_uri() . '/js/malina-ajaxsearch.js', array('jquery'), '1.0', TRUE);
			wp_localize_script( 'malina-ajaxsearch', 'malinaAjaxSearch', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
		}
		wp_enqueue_script('malina-functions', get_template_directory_uri() . '/js/malina-functions.js', array('jquery'), '1.0', TRUE);
	}
	add_action( 'wp_enqueue_scripts', 'malina_scripts_basic', 11 );
}

if(!function_exists('malina_styles_basic')){
	function malina_styles_basic() {  
		/* ------------------------------------------------------------------------ */
		/* Register Stylesheets */
		/* ------------------------------------------------------------------------ */
		wp_register_style( 'malina-basic', get_template_directory_uri() . '/css/basic.css', array(), '1.0', 'all' );
		wp_register_style( 'malina-stylesheet', get_template_directory_uri() .'/style.css', array(), '1.0', 'all' );
		wp_register_style( 'malina-skeleton', get_template_directory_uri() . '/css/grid.css', array(), '1', 'all' );
		wp_register_style( 'image-lightbox', get_template_directory_uri() . '/css/imageLightbox.min.css', array(), '1.0', 'all' );
		wp_enqueue_style( 'malina-font-awesome', get_template_directory_uri() . '/framework/fonts/font-awesome/css/all.min.css', array(), '5.8.1', 'all' );
		wp_enqueue_style( 'line-awesome', get_template_directory_uri() . '/framework/fonts/line-awesome/css/line-awesome.min.css', array(), '1.0', 'all' );
		wp_register_style( 'owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css', array(), '2.0.0', 'all' );
		if( get_theme_mod('malina_responsiveness', true) ) {
			wp_enqueue_style( 'dlmenu', get_template_directory_uri() . '/css/dlmenu.css', array(), '1.0', 'all' );
		}
		if( get_theme_mod( 'malina_single_post_subscribe_block', false ) ){
			wp_register_style( 'TheSecret', get_template_directory_uri() . '/framework/fonts/TheSecret/style.css', array(), '1.0', 'all' );
		}
		wp_register_style( 'malina-responsive', get_template_directory_uri() . '/css/responsive.css', array(), '1.0', 'all' );
		wp_enqueue_style( 'malina-basic' );
		wp_enqueue_style( 'malina-skeleton' );
		if( get_theme_mod('malina_lightbox', true) ){
			wp_enqueue_style( 'image-lightbox' );
		}
		if( class_exists('WooCommerce') ){
			wp_enqueue_style('malina-woocommerce', get_template_directory_uri().'/css/custom-woocommerce.css', array(), '1.0.0', 'all');
		}
		wp_enqueue_style( 'malina-stylesheet' );
		if ( function_exists( 'is_rtl' ) && is_rtl() ) {
			wp_enqueue_style( 'malina-stylesheet-rtl', get_template_directory_uri() . '/rtl.css', array('malina-stylesheet'), '1.0', 'all' );
		}
		if( get_theme_mod('malina_responsiveness', true) ) {
			wp_enqueue_style( 'malina-responsive' );
		}
	}  
	add_action( 'wp_enqueue_scripts', 'malina_styles_basic', 1 );
}
function malina_gutenberg_editor() {
	wp_enqueue_style( 'malina-blocks-grid', get_template_directory_uri() . '/css/grid.css');
    wp_enqueue_style( 'malina-blocks-style', get_template_directory_uri() . '/framework/inc/editor-style.css');
    wp_enqueue_style( 'malina-blocks-lineawesome', get_template_directory_uri() . '/framework/fonts/line-awesome/css/line-awesome.min.css');
    wp_enqueue_style( 'malina-blocks-fontawesome', get_template_directory_uri() . '/framework/fonts/font-awesome/css/all.min.css');
}
add_action( 'enqueue_block_editor_assets', 'malina_gutenberg_editor' );

if(!function_exists('malina_enqueue_comments_reply')){
	function malina_enqueue_comments_reply(){
		wp_enqueue_script( 'comment-reply' );
	}
	add_action( 'comment_form_before', 'malina_enqueue_comments_reply' );
}
if( !function_exists('add_revslider') ){
	function add_revslider( $revslider ){
		esc_html_e('Install and activate revolution slider plugin to use it.', 'malina');
	}
}
/* Add Custom Pmalinary Navigation */
if(!function_exists('malina_register_custom_menu')){
	add_action('init', 'malina_register_custom_menu');
	function malina_register_custom_menu() {
		register_nav_menu('main_navigation', esc_html__('Mega Menu Navigation','malina'));
		register_nav_menu('side_navigation', esc_html__('Side Header Navigation','malina'));
		register_nav_menu('mobile_navigation', esc_html__('Mobile menu navigation','malina'));
	}
}

if(!function_exists('malina_string_limit_words')){
	function malina_string_limit_words($string, $word_limit)
	{
	  $string = strip_tags($string, '<p>');
	  $words = explode(' ', $string, ($word_limit + 1));
	  if(count($words) > $word_limit)
	    array_pop($words);
	  return implode(' ', $words);
	}
}

if( !function_exists('malina_allow_svg_upload')){
	function malina_allow_svg_upload($mimes){
		$mimes['svg'] = 'image/svg+xml';
		$mimes['txt'] = 'text/plain';
		$mimes['csv'] = 'text/csv';
  		return $mimes;
	}
	add_filter('upload_mimes', 'malina_allow_svg_upload');
}

if(!function_exists('malina_theme_setup')){
	function malina_theme_setup() {
		add_theme_support( 'woocommerce', array(
	        'thumbnail_image_width' => 400,
	        'single_image_width'    => 600,

	        'product_grid'          => array(
	            'default_rows'    => 3,
	            'min_rows'        => 2,
	            'max_rows'        => 8,
	            'default_columns' => 3,
	            'min_columns'     => 2,
	            'max_columns'     => 4,
	        ),
	    ) );
	    add_theme_support( 'wc-product-gallery-zoom' );
		remove_theme_support( 'wc-product-gallery-lightbox' );
		remove_theme_support( 'wc-product-gallery-slider' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array('gallery', 'image', 'video', 'audio', 'quote', 'link') );
		add_theme_support( "title-tag" );

		$crop = get_theme_mod('malina_crop_post_thumbnail', true) ? true : false;
		set_post_thumbnail_size( '845', '550', $crop );

		add_image_size(esc_html__('malina-masonry', 'malina'), 585, 9999, false);

		$crop = get_theme_mod('malina_extra_medium_crop', true) ? true : false;
		add_image_size(esc_html__('malina-extra-medium', 'malina'), 520, 410, $crop);

		$crop = get_theme_mod('malina_slider_crop', true) ? true : false;
		add_image_size(esc_html__('malina-slider', 'malina'), 1170, 605, $crop);

		$crop = get_theme_mod('malina_fullwidth_slider_crop', true) ? true : false;
		add_image_size(esc_html__('malina-fullwidth-slider', 'malina'), 1900, 650, $crop);

		$crop = get_theme_mod('malina_crop_thumbnail', true) ? 1 : 0;
		update_option( 'thumbnail_crop', $crop );
		$crop = get_theme_mod('malina_crop_medium', true) ? 1 : 0;
		update_option( 'medium_crop', $crop );
		$crop = get_theme_mod('malina_crop_large', true) ? 1 : 0;
		update_option( 'large_crop', $crop );
		
		$list = array(
		    'page',
		    'malina-footer',
		    'malina-header'
		);
		if( class_exists('WPBakeryVisualComposerAbstract') ){
			vc_set_default_editor_post_types( $list );
		}
		if( class_exists( 'Elementor\Plugin' ) ){
			update_option( 'elementor_disable_color_schemes', 'yes' );
			update_option( 'elementor_disable_typography_schemes', 'yes' );
		}

		//add_filter( 'wp_audio_shortcode_library', 'false' ); // 'mediaelement' to activate js for audio

	}
	add_action( 'after_setup_theme', 'malina_theme_setup' );	
}

if(!function_exists('malina_update_media_sizes')){
	function malina_update_media_sizes(){
		update_option( 'thumbnail_size_w', 160 );
		update_option( 'thumbnail_size_h', 160 );
		
		update_option( 'medium_size_w', 570 );
		update_option( 'medium_size_h', 410 );
		
		update_option( 'large_size_w', 1170 );
		update_option( 'large_size_h', 730 );

		if( class_exists( 'Elementor\Plugin' ) ){
			update_option( 'elementor_cpt_support', [ 'post', 'page', 'malina-header', 'malina-footer' ] );
			update_option('elementor_container_width', '1200');
			update_option('elementor_space_between_widgets', '34');
			update_option('elementor_global_image_lightbox', false);
		}
	}
	add_action('after_switch_theme', 'malina_update_media_sizes');
}
if(!function_exists('is_shop')){
	function is_shop(){
		return false;
	}
}
if( !function_exists('malina_custom_posts_count') ){
	function malina_custom_posts_count( $query ){
	    if( !is_admin() && $query->is_archive() && $query->is_main_query() && !is_shop() ){
	    		$posts_count = get_theme_mod( 'malina_archive_post_count', '6');
	            $query->set( 'posts_per_page', $posts_count );
	    } elseif( !is_admin() && $query->is_search() && $query->is_main_query() ){
	    		$posts_count = get_theme_mod( 'malina_search_post_count', '6');
	            $query->set( 'posts_per_page', $posts_count );
	    }
	}
	add_action( 'pre_get_posts', 'malina_custom_posts_count' );
}
if(!function_exists('malina_custom_image_sizes')){
	add_filter( 'image_size_names_choose', 'malina_custom_image_sizes' );
	function malina_custom_image_sizes( $sizes ) {
	    return array_merge( $sizes, array(
	    	'post-thumbnail' => esc_html__('post-thumbnail', 'malina'),
	        'malina-masonry' => esc_html__('malina-masonry', 'malina'),
	        'malina-extra-medium' => esc_html__('malina-extra-medium', 'malina'),
	        'malina-slider' => esc_html__('malina-slider', 'malina'),
	        'malina-fullwidth-slider' => esc_html__('malina-fullwidth-slider', 'malina')
	    ) );
	}
}

if(!function_exists('malina_custom_excerpt_length')){
	function malina_custom_excerpt_length( $length ) {
		global $wp_query;
		$count = 55;
		if( !is_admin() && is_archive() ){
			$count = get_theme_mod('malina_archive_excerpt_count', '15');
		} elseif( !is_admin() && is_search() ){
			$count = get_theme_mod('malina_search_excerpt_count', '15');
		} elseif( !is_admin() && is_home() ) {
			$count = get_theme_mod('malina_blog_excerpt_count', '15');
		}
		return $count;
	}
	add_filter( 'excerpt_length', 'malina_custom_excerpt_length', 99 );
}
if(!function_exists('malina_modify_read_more_link')){
	add_filter('excerpt_more', 'malina_modify_read_more_link');
	add_filter( 'the_content_more_link', 'malina_modify_read_more_link' );
	function malina_modify_read_more_link() {
		return '';
	}
}

if(!function_exists('malina_excerpt')){
	function malina_excerpt($limit=17, $postID=false) {
		if(!$postID){
			$postID = get_the_ID();
		}
		$text = get_the_content($postID);
		$text = apply_filters('the_content', $text);
		$text = strip_shortcodes($text);
		$text = str_replace('\]\]\>', ']]>', $text);
		$text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);
		$text = strip_tags($text);
		$excerpt_length = $limit;
		$words = explode(' ', $text, $excerpt_length + 1);
		array_pop($words);
		$text = implode(' ', $words);
		return $text;
	}
}

if(!function_exists('malina_comments_number')){
	function malina_comments_number($postID, $echo = false){
		if( is_single() && get_theme_mod('malina_single_disable_comments', true) ){
			return;
		}
		$num_comments = get_comments_number($postID);
		if ( comments_open() ) {
			if ( $num_comments == 0 ) {
				$comments = esc_html__('No Comments', 'malina');
			} elseif ( $num_comments > 1 ) {
				$comments = $num_comments .' '. esc_html__('Comments', 'malina');
			} else {
				$comments = esc_html__('1 Comment', 'malina');
			}
			$write_comments = '<a href="' . esc_url(get_comments_link($postID)) .'"><span>'.esc_html($comments).'</span></a>';
		} else {
			$write_comments =  '<span><span>'.esc_html__('Comments disabled.', 'malina').'</span></span>';
		}

		if($echo){
			echo wp_kses_post($write_comments);
		} else {
			return $write_comments;
		}
	}
	add_filter( 'malina_comments_number', 'malina_comments_number' );
}

/* Pagination */
if(!function_exists('malina_next_posts_link_attributes')){
	add_filter('next_posts_link_attributes', 'malina_next_posts_link_attributes');
	function malina_next_posts_link_attributes() {
	    return 'class="next"';
	}
}
if(!function_exists('malina_prev_posts_link_attributes')){
	function malina_prev_posts_link_attributes() {
    	return 'class="previous"';
	}
	add_filter('previous_posts_link_attributes', 'malina_prev_posts_link_attributes');
}


if(!function_exists('malina_post_has_more_link')){
	function malina_post_has_more_link( $post_id ) {
		$post = get_post( $post_id );
		$content = $post->post_content;
		$data_array = get_extended( $content );
		return '' !== $data_array['extended'];
	}
}
if(!function_exists('malina_custom_pagination')){
  function malina_custom_pagination($pages = '', $range = 4) {
    $showitems = ($range * 2)+1;
    $out ='';

    global $paged;
	if(empty($paged)) $paged = 1;

    if($pages == '') {
      global $wp_query;
      $pages = $wp_query->max_num_pages;
      if(!$pages) {
        $pages = 1;
      }
    }
    
    if(1 != $pages) {
		if($paged > 1) {
			$out .= get_previous_posts_link('<i class="la la-angle-left"></i>');
		}
		for ($i=1; $i <= $pages; $i++) {
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
				$out .= ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
			}
		}
		if ($paged < $pages) {
			$out .= get_next_posts_link('<i class="la la-angle-right"></i>');
		}
    }
    return $out;
  }
}

/* ------------------------------------------------------------------------ */
/* Comments
/* ------------------------------------------------------------------------ */
if(!function_exists('malina_move_comment_field_to_bottom')){
	function malina_move_comment_field_to_bottom( $fields ) {
		$comment_field = $fields['comment'];
		unset( $fields['comment'] );
		$fields['comment'] = $comment_field;
		return $fields;
	}
	add_filter( 'comment_form_fields', 'malina_move_comment_field_to_bottom' );
}
if( !function_exists('malina_default_comments_field') ){
	add_filter('comment_form_default_fields', 'malina_default_comments_field');
	function malina_default_comments_field( $fields ){
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );

		//Custom Fields
		$commenter = wp_get_current_commenter();

		$fields =  array(
			'author'=> '<input id="author" name="author" type="text" value="'.esc_attr( $commenter['comment_author'] ).'" placeholder="' . esc_attr__('Name', 'malina') . ' *" size="30"' . $aria_req . ' />',
			'email' => '<input id="email" name="email" type="text" value="'. esc_attr( $commenter['comment_author_email'] ) .'" placeholder="' . esc_attr__('E-Mail', 'malina') . ' *" size="30"' . $aria_req . ' />',
		);
		if( get_option('show_comments_cookies_opt_in') ){
			$fields['cookies'] = '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" /><label for="wp-comment-cookies-consent">' . get_theme_mod('malina_gdpr_checkbox_consent', 'Save my name, email, and website in this browser for the next time I comment.') . '</label></p>';
		}
		return $fields;
	}
}	
if(!function_exists('malina_comment')){
	function malina_comment( $comment, $args, $depth ) {
	   $GLOBALS['comment'] = $comment; ?>
	   <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	   <div id="comment-<?php comment_ID(); ?>" class="comment-body clearfix"> 
	   			<?php
				if ( function_exists( 'malina_get_additional_user_meta_thumb' ) && get_comment()->user_id ){
					// retrieve our additional author meta info
					$user_meta_image = esc_attr( get_the_author_meta( 'user_meta_image', get_comment()->user_id ) );
				    // make sure the field is set
				    if ( isset( $user_meta_image ) && $user_meta_image ) {
				        // only display if function exists
				        ?>
							<div class="author-avatar alignleft"><img alt="<?php esc_attr_e('author photo', 'malina'); ?>" src="<?php echo malina_get_additional_user_meta_thumb(get_comment()->user_id); ?>" /></div>
				        <?php } ?>
				<?php } else {
					if( get_avatar( $comment, '65', '' ) ) { echo '<div class="author-avatar alignleft">'.get_avatar( $comment, '65', '' ).'</div>'; }
				} ?>
	        <div class="comment-text">
				<div class="author">
				 	<h2 class="author-title"><?php printf( esc_html__( '%s', 'malina'), get_comment_author_link() ) ?></h2>
				 	<div class="flex-end">
				 		<div class="meta-date"><?php printf(esc_html__('%1$s', 'malina'), get_comment_date(get_option('date_format'))) ?><?php edit_comment_link( esc_html__( '(Edit)', 'malina'),' ','' ) ?></div>  
				 		<div class="comment-reply"><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>
				 	</div>
				</div>
				<div class="text clearfix">
				<?php comment_text() ?>
				<?php if ( $comment->comment_approved == '0' ) : ?>
			        <em><?php esc_html_e( 'Your comment is awaiting moderation.', 'malina') ?></em>
			        <br />
		      	<?php endif; ?>
		      </div>
	      	</div>
	   </div>
	<?php
	}
}
if( !function_exists('rwmb_meta') ){
	function rwmb_meta($key) {
		return false;
	}
}
if( ! function_exists( 'rwmb_get_value' ) ) {
    function rwmb_get_value( $key, $args = '', $post_id = null ) {
        return '';
    }
}
if ( ! function_exists( 'rwmb_the_value' ) ) {
    function rwmb_the_value( $key, $args = '', $post_id = null, $echo = true ) {
        return false;
    }
}
if( !function_exists('wp_body_open') ){
	function wp_body_open() {
		return false;
	}
}
// Define Content Width 
if(! isset( $content_width)){
	$content_width = 845;
	function malina_adjust_content_width() {
		if( is_page_template( 'page-nosidebar.php' ) || is_page_template( 'page-fullwidth.php' ) ){
			global $content_width;
			$content_width = 1170;
		}
	}   
	add_action( 'template_redirect', 'malina_adjust_content_width' );
}
/* ------------------------------------------------------------------------ */
/* Automatic Plugin Activation */
require_once(trailingslashit( get_template_directory() ). 'framework/inc/class-tgm-plugin-activation.php');
/* ------------------------------------------------------------------------ */
// Recommended plugins activation
if(!function_exists('malina_register_required_plugins')){
	add_action('tgmpa_register', 'malina_register_required_plugins');
	function malina_register_required_plugins() {
		$plugins = array(
			array(
	        	'name'      => esc_html__('WPForms', 'malina'),
	        	'slug'      => 'wpforms-lite',
				'required' 	=> false, 
	        ),
			array(
	        	'name'      => esc_html__('Meta Box', 'malina'),
	        	'slug'      => 'meta-box',
				'required' 	=> false, 
	        ),
	        array(
	        	'name'      => esc_html__('WP Mega Menu', 'malina'),
	        	'slug'      => 'wp-megamenu',
				'required' 	=> false, 
	        ),
	        array(
	        	'name'      => esc_html__('One Click Demo Import','malina'),
	        	'slug'      => 'one-click-demo-import',
				'required' 	=> false,
	        ),
	        array(
	        	'name'      		=> esc_html__('Malina elements','malina'),
	        	'slug'      		=> 'malina-elements',
	        	'source'   			=> 'https://www.artstudioworks.net/updates-api/update/malina-elements.zip',
				'required' 			=> true,
	        ),
	        array(
	        	'name'      => esc_html__('Elementor', 'malina'),
	        	'slug'      => 'elementor',
				'required' 	=> false, 
	        ),
		);
		global $wp_version;
		if ( version_compare( $wp_version, '5.0', '<' ) ) {
			$plugins[] = array(
	        	'name'      => esc_html__('Gutenberg', 'malina'),
	        	'slug'      => 'gutenberg',
				'required' 	=> false, 
	        );
		}
		/**
		 * Array of configuration settings. Amend each line as needed.
		 * If you want the default strings to be available under your own theme domain,
		 * leave the strings uncommented.
		 * Some of the strings are added into a sprintf, so see the comments at the
		 * end of each line for what each argument will be.
		 */
		$config = array(
			'domain'       		=> 'malina',         	// Text domain - likely want to be the same as your theme.
			'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
			'menu'         		=> 'install-required-plugins', 	// Menu slug
			'has_notices'      	=> true,                       	// Show admin notices or not
			'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
			'message' 			=> '',							// Message to output right before the plugins table
			'strings'      		=> array(
				'page_title'                       			=> esc_html__( 'Install Required and Recommended Plugins', 'malina' ),
				'menu_title'                       			=> esc_html__( 'Install Plugins', 'malina' ),
				'installing'                       			=> esc_html__( 'Installing Plugin: %s', 'malina' ), // %1$s = plugin name
				'oops'                             			=> esc_html__( 'Something went wrong with the plugin API.', 'malina' ),
				'return'                           			=> esc_html__( 'Return to Required Plugins Installer', 'malina' ),
				'plugin_activated'                 			=> esc_html__( 'Plugin activated successfully.', 'malina' ),
				'complete' 									=> esc_html__( 'All plugins installed and activated successfully. %s', 'malina' ), // %1$s = dashboard link
				'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
			)
		);
		tgmpa($plugins, $config);
	}	
}

if(!function_exists('malina_import_files')){
	function malina_import_files() {
	    return array(
	        array(
	            'import_file_name'           => 'Main Demo',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/elementor/maindemo/demo.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ).'framework/demos/elementor/maindemo/widgets.wie',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/elementor/maindemo/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/elementor/maindemo/demo.jpg',
	            'preview_url'                => 'https://www.malina.artstudioworks.net/',
	            'categories' => ['Elementor']
	        ),
	        array(
	            'import_file_name'           => 'Madrid Demo',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/elementor/madrid/demo.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ).'framework/demos/elementor/madrid/widgets.wie',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/elementor/madrid/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/elementor/madrid/demo.jpg',
	            'preview_url'                => 'https://www.malina.artstudioworks.net/madrid',
	            'categories' => ['Elementor']
	        ),
	        array(
	            'import_file_name'           => 'Lily Hill',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/elementor/lilyhill/demo.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ).'framework/demos/elementor/lilyhill/widgets.wie',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/elementor/lilyhill/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/elementor/lilyhill/demo.jpg',
	            'preview_url'                => 'https://www.malina.artstudioworks.net/lillyhill',
	            'categories' => ['Elementor']
	        ),
	        array(
	            'import_file_name'           => 'Handmade Demo',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/elementor/handmade/demo.xml',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/elementor/handmade/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/elementor/handmade/demo.jpg',
	            'preview_url'                => 'https://www.malina.artstudioworks.net/dinogua',
	            'categories' => ['Elementor']
	        ),
	        array(
	            'import_file_name'           => 'Split Screen',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/elementor/splitscreen/demo.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ).'framework/demos/elementor/splitscreen/widgets.wie',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/elementor/splitscreen/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/elementor/splitscreen/demo.jpg',
	            'preview_url'                => 'https://malina.artstudioworks.net/splitscreen/',
	            'categories' => ['Elementor']
	        ),
	        array(
	            'import_file_name'           => 'Cosmo Demo',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/elementor/cosmo/demo.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ).'framework/demos/elementor/cosmo/widgets.wie',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/elementor/cosmo/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/elementor/cosmo/demo.jpg',
	            'preview_url'                => 'https://www.malina.artstudioworks.net/cosmo',
	            'categories' => ['Elementor']
	        ),
	        array(
	            'import_file_name'           => 'FreshiCo Demo',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/elementor/freshico/demo.xml',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/elementor/freshico/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/elementor/freshico/demo.jpg',
	            'preview_url'                => 'https://www.malina.artstudioworks.net/freshico',
	            'categories' => ['Elementor']
	        ),
	        array(
	            'import_file_name'           => 'Kylie Demo',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/elementor/kylie/demo.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ).'framework/demos/elementor/kylie/widgets.wie',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/elementor/kylie/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/elementor/kylie/demo.jpg',
	            'preview_url'                => 'https://www.malina.artstudioworks.net/kylie',
	            'categories' => ['Elementor']
	        ),
	        array(
	            'import_file_name'           => 'Minimal (Sono)',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/elementor/sono/demo.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ).'framework/demos/elementor/sono/widgets.wie',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/elementor/sono/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/elementor/sono/demo.jpg',
	            'preview_url'                => 'https://www.malina.artstudioworks.net/sono',
	            'categories' => ['Elementor']
	        ),
	        array(
	            'import_file_name'           => 'Esse Demo',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/elementor/esse/demo.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ).'framework/demos/elementor/esse/widgets.wie',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/elementor/esse/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/elementor/esse/demo.jpg',
	            'preview_url'                => 'https://www.malina.artstudioworks.net/esse',
	            'categories' => ['Elementor']
	        ),
	        array(
	            'import_file_name'           => 'Recipes Demo',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/elementor/recipes/demo.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ).'framework/demos/elementor/recipes/widgets.wie',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/elementor/recipes/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/elementor/recipes/demo.png',
	            'preview_url'                => 'https://www.malina.artstudioworks.net/yummy',
	            'categories' => ['Elementor']
	        ),
	        array(
	            'import_file_name'           => 'Cosmo Demo',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/cosmo/demo.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/cosmo/widgets.wie',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/cosmo/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/gutenberg/cosmo/demo.jpg',
	            'preview_url'                => 'https://www.malina.artstudioworks.net/cosmo',
	            'categories' => ['Gutenberg']
	        ),
	        array(
	            'import_file_name'           => 'Main Demo',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/maindemo/demo.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/maindemo/widgets.wie',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/maindemo/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/gutenberg/maindemo/demo.jpg',
	            'preview_url'                => 'https://www.malina.artstudioworks.net/',
	            'categories' => ['Gutenberg']
	        ),
	        array(
	            'import_file_name'           => 'Madrid Demo',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/madrid/demo.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/madrid/widgets.wie',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/madrid/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/gutenberg/madrid/demo.jpg',
	            'preview_url'                => 'https://www.malina.artstudioworks.net/madrid',
	            'categories' => ['Gutenberg']
	        ),
	        array(
	            'import_file_name'           => 'Minimal (Sono)',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/sono/demo.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/sono/widgets.wie',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/sono/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/gutenberg/sono/demo.jpg',
	            'preview_url'                => 'https://www.malina.artstudioworks.net/sono',
	            'categories' => ['Gutenberg']
	        ),
	        array(
	            'import_file_name'           => 'Esse Demo',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/esse/demo.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/esse/widgets.wie',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/esse/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/gutenberg/esse/demo.jpg',
	            'preview_url'                => 'https://www.malina.artstudioworks.net/esse',
	            'categories' => ['Gutenberg']
	        ),
	        array(
	            'import_file_name'           => 'Recipes Demo',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/recipes/demo.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/recipes/widgets.wie',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/recipes/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/gutenberg/recipes/demo.png',
	            'preview_url'                => 'https://www.malina.artstudioworks.net/yummy',
	            'categories' => ['Gutenberg']
	        ),
	        array(
	            'import_file_name'           => 'Walnuss Demo',
	            'local_import_file'            => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/walnuss/demo.xml',
	            'local_import_widget_file'     => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/walnuss/widgets.wie',
	            'local_import_customizer_file' => trailingslashit( get_template_directory() ).'framework/demos/gutenberg/walnuss/customizer.dat',
	            'import_preview_image_url'   => trailingslashit( get_template_directory_uri() ).'framework/demos/gutenberg/walnuss/demo.jpg',
	            'preview_url'                => 'https://www.malina.artstudioworks.net/walnuss',
	            'categories' => ['Gutenberg']
	        )
	    );
	}
	add_filter( 'pt-ocdi/import_files', 'malina_import_files' );
}
if(!function_exists('malina_is_plugin_exists')){
	function malina_is_plugin_exists($plugin)
	{
	    if( file_exists(WP_PLUGIN_DIR .'/'. $plugin ) ) {
			return true;
		}
		return false;
	}
}

function malina_check_plugins_before_import($selected_import){
	if( !class_exists( 'Elementor\Plugin' ) && strpos($selected_import['local_import_file'], 'elementor') !== false  ){
		if( malina_is_plugin_exists('elementor/elementor.php') ){
			$plugin = 'elementor/elementor.php';
			$activateUrl = sprintf(admin_url('plugins.php?action=activate&plugin=%s&plugin_status=all&paged=1&s'), $plugin);
		    $_REQUEST['plugin'] = $plugin;
		    $url = wp_nonce_url($activateUrl, 'activate-plugin_' . $plugin);
		} else {
			$action = 'install-plugin';
			$slug = 'elementor';
			$url = wp_nonce_url(
			    add_query_arg(
			        array(
			            'action' => $action,
			            'plugin' => $slug
			        ),
			        admin_url( 'update.php' )
			    ),
			    $action.'_'.$slug
			);
		}
		$response['message'] = sprintf(
			__( '%1$sPlease install Elementor Plugin, before this demo importing.%2$s Go to %3$sInstall or Activate Plugin%4$s and try again %5$s', 'malina' ),
			'<div class="notice  notice-warning"><p>',
			'<br>',
			'<a href="'.$url.'">',
			'</a>',
			'</p></div>'
		);
		delete_transient( 'ocdi_importer_data' );
		wp_send_json( $response );
	}
	if(!class_exists('Kadence_Blocks_Frontend') && strpos($selected_import['local_import_file'], 'gutenberg') !== false ){
		if( malina_is_plugin_exists('kadence-blocks/kadence-blocks.php') ){
			$plugin = 'kadence-blocks/kadence-blocks.php';
			$activateUrl = sprintf(admin_url('plugins.php?action=activate&plugin=%s&plugin_status=all&paged=1&s'), $plugin);
		    $_REQUEST['plugin'] = $plugin;
		    $url = wp_nonce_url($activateUrl, 'activate-plugin_' . $plugin);
		} else {
			$action = 'install-plugin';
			$slug = 'kadence-blocks';
			$url = wp_nonce_url(
			    add_query_arg(
			        array(
			            'action' => $action,
			            'plugin' => $slug
			        ),
			        admin_url( 'update.php' )
			    ),
			    $action.'_'.$slug
			);
		}
		$response['message'] = sprintf(
			__( '%1$sPlease install Kadence Blocks - Gutenberg Page Builder Toolkit plugin, before this demo importing.%2$s Go to %3$sInstall or Activate Plugin%4$s and try again %5$s', 'malina' ),
			'<div class="notice  notice-warning"><p>',
			'<br>',
			'<a href="'.$url.'">',
			'</a>',
			'</p></div>'
		);
		delete_transient( 'ocdi_importer_data' );
		wp_send_json( $response );
	}
}
add_action('pt-ocdi/before_content_import', 'malina_check_plugins_before_import');

if( !function_exists('malina_before_widgets_import') ){
	function malina_before_widgets_import( $selected_import ){
		if( 'Main Demo' === $selected_import['import_file_name'] ){
			$new_sidebars = array('AboutMe', 'ContactMe', 'SinglePost', 'SinglePost2');
			foreach ($new_sidebars as $sidebar) {
				$sidebars = sidebar_generator::get_sidebars();
				$name = str_replace(array("\n","\r","\t"),'', $sidebar);
				$id = sidebar_generator::name_to_class($name);
				if(!isset($sidebars[$id])){
					$sidebars[$id] = $name;
					sidebar_generator::update_sidebars($sidebars);
				}
			}
		}
		if( 'Split Screen' === $selected_import['import_file_name'] ){
			$new_sidebars = array('AboutMe', 'ContactMe');
			foreach ($new_sidebars as $sidebar) {
				$sidebars = sidebar_generator::get_sidebars();
				$name = str_replace(array("\n","\r","\t"),'', $sidebar);
				$id = sidebar_generator::name_to_class($name);
				if(!isset($sidebars[$id])){
					$sidebars[$id] = $name;
					sidebar_generator::update_sidebars($sidebars);
				}
			}
		}
		if( 'Recipes Demo' === $selected_import['import_file_name'] ){
			set_post_thumbnail_size( '845', '9999', false );
			update_option( 'medium_size_w', 570 );
			update_option( 'medium_size_h', 605 );
		}
		if( 'Handmade Demo' === $selected_import['import_file_name'] ){
			set_post_thumbnail_size( '750', '9999', false );
			update_option( 'large_size_w', 750 );
			update_option( 'large_size_h', 9999 );
			update_option( 'large_crop', 0 );
		}
		if( 'Walnuss Demo' === $selected_import['import_file_name'] ){
			update_option( 'large_crop', 0 );
			update_option( 'medium_size_w', 450 );
			update_option( 'medium_size_h', 500 );
		}
		if( 'Cosmo Demo' === $selected_import['import_file_name'] ){
			set_post_thumbnail_size( '845', '9999', false );
		}
		if( 'Lily Hill' === $selected_import['import_file_name'] ){
			set_post_thumbnail_size( '845', '9999', false );
			update_option( 'medium_size_w', 380 );
			update_option( 'medium_size_h', 380 );
		}
	}
	add_action( 'pt-ocdi/before_widgets_import', 'malina_before_widgets_import' );
}
if(!function_exists('malina_after_import_setup')){
	function malina_after_import_setup( $selected_import ) {
	    // Assign menus to their locations.
	    $uploaded_file = trailingslashit( get_template_directory_uri() ).'framework/demos/elementor/maindemo/malina-theme.txt';
	    if('Minimal (Sono)' === $selected_import['import_file_name']){
	    	$uploaded_file = trailingslashit( get_template_directory_uri() ).'framework/demos/sono/sono-theme.txt';
			$main_menu = get_term_by( 'name', 'Main menu', 'nav_menu' );
	    	$mobile_menu = get_term_by( 'name', 'Mobile Menu', 'nav_menu' );
	    	$footer_menu = get_term_by( 'name', 'footer menu', 'nav_menu');
	    	set_theme_mod( 'nav_menu_locations', array(
	            'main_navigation' => $main_menu->term_id,
	            'mobile_navigation' => $mobile_menu->term_id
	        ));
	        set_theme_mod( 'malina_footer_menu', $footer_menu->term_id );
		}
    	if( 'Main Demo' === $selected_import['import_file_name'] || 'Madrid Demo' === $selected_import['import_file_name'] || 'Esse Demo' === $selected_import['import_file_name'] ){
    		$main_menu = get_term_by( 'name', 'Main menu', 'nav_menu' );
	    	$mobile_menu = get_term_by( 'name', 'Mobile menu', 'nav_menu' );

	    	set_theme_mod( 'nav_menu_locations', array(
	            'main_navigation' => $main_menu->term_id,
	            'mobile_navigation' => $mobile_menu->term_id
	        ));
		}
		if( 'Main Demo' === $selected_import['import_file_name'] ){
	    	$side_menu = get_term_by( 'name', 'Side Menu', 'nav_menu' );
	    	set_theme_mod( 'nav_menu_locations', array(
	            'side_navigation' => $side_menu->term_id
	        ));
	        if ( class_exists( 'RevSlider' ) ) {
				$slider_array = array();
				$slider_array[] = get_template_directory()."/framework/demos/home_posts_slider.zip";
				if(class_exists('WooCommerce'))
					$slider_array[] = get_template_directory()."/framework/demos/shop-home-page.zip";
				$slider = new RevSlider();
				foreach($slider_array as $filepath){
					$slider->importSliderFromPost(true,true,$filepath);  
				}
				esc_html_e(' Slider processed', 'malina');
			}
		}
		if( 'Recipes Demo' === $selected_import['import_file_name'] 
			|| 'FreshiCo Demo' === $selected_import['import_file_name'] 
			|| 'Walnuss Demo' === $selected_import['import_file_name']
			|| 'Kylie Demo' === $selected_import['import_file_name']
			|| 'Handmade Demo' === $selected_import['import_file_name']
			|| 'Lily Hill' === $selected_import['import_file_name'] ){
			
    		$main_menu = get_term_by( 'name', 'Main menu', 'nav_menu' );

	    	set_theme_mod( 'nav_menu_locations', array(
	            'main_navigation' => $main_menu->term_id,
	            'mobile_navigation' => $main_menu->term_id
	        ));
		}
		if( 'Lily Hill' === $selected_import['import_file_name'] ){
	        if ( class_exists( 'RevSlider' ) ) {
				$slider_array = array();
				$slider_array[] = get_template_directory()."/framework/demos/elementor/lilyhill/home-slider.zip";
				$slider = new RevSlider();
				foreach($slider_array as $filepath){
					$slider->importSliderFromPost(true,true,$filepath);  
				}
				esc_html_e(' Slider processed', 'malina');
			}
		}
		if( 'Split Screen' === $selected_import['import_file_name'] ){
    		$main_menu = get_term_by( 'name', 'Main menu', 'nav_menu' );
	    	set_theme_mod( 'nav_menu_locations', array(
	    		'main_navigation' => $main_menu->term_id,
	            'side_navigation' => $main_menu->term_id,
	            'mobile_navigation' => $main_menu->term_id
	        ));
		}

		if( 'Cosmo Demo' === $selected_import['import_file_name'] ){
    		$main_menu = get_term_by( 'name', 'Side menu', 'nav_menu' );
	    	set_theme_mod( 'nav_menu_locations', array(
	            'mobile_navigation' => $main_menu->term_id
	        ));
		}
		// Assign front page and posts page (blog page).
	    $front_page_id = get_page_by_title( 'Home' );
	    update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $front_page_id->ID );
	    
	    if( 'Cosmo Demo' === $selected_import['import_file_name'] || 'Kylie Demo' === $selected_import['import_file_name'] ){
	    	update_option( 'show_on_front', 'posts' );
	    }
	    if( 'FreshiCo Demo' === $selected_import['import_file_name'] ){
	    	update_option( 'show_on_front', 'page' );
	    	$front_page_id = get_page_by_title( 'Blog' );
    		update_option( 'page_on_front', $front_page_id->ID );
		}
		if( class_exists('wp_megamenu_themes') ){
            $wp_check_filetype = wp_check_filetype( $uploaded_file);
            $serilized_data = wp_remote_get($uploaded_file);
            $serilized_data = wp_remote_retrieve_body( $serilized_data );
            if (wpmm_is_serialized($serilized_data)) {
                $post_data = unserialize($serilized_data);
                $required_keys = array('post_title', 'post_content', 'post_type', 'post_status');
                if (array_keys_exist($required_keys, $post_data)){
	                $imported_post_id = wp_insert_post($post_data);
	                echo 'Mega menu theme imported';
                } else {
	                echo 'Array keys not exists properly, <br />'. implode(', ', $required_keys);
                }
            } else {
                echo 'not serialized data properly';
            }
		}
	}
	add_action( 'pt-ocdi/after_import', 'malina_after_import_setup' );
	add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
}

if(!class_exists('Malina_Mobile_Walker_Nav_Menu')){
	class Malina_Mobile_Walker_Nav_Menu extends Walker_Nav_Menu {
	  function start_lvl(&$output, $depth = 0, $args = array()) {
	    $indent = str_repeat("\t", $depth);
	    $output .= "\n$indent<ul class=\"dl-submenu\">\n";
	  }
	}
}

function malina_menu_logo_center( $items, $args ) {
    // Checks to see if the menu passed in is the pmalinary one, and creates the logo item for it
    $logo_item = '';
    if ( $args->theme_location == 'main_navigation' ) {
        $logo_item = '<li class="menu-item-logo"><div class="logo">' . malina_get_logo() . '</div></li>';
    }

    //Gets the location of the menu element I want to insert the logo before
    $index = round( malina_count_top_lvl_items() / 2 ) + 1;
    //Gets the menu item I want to insert the logo before
    $menu_item = malina_get_menu_item( $index );
    $insert_before = '<li id="menu-item-' . $menu_item->ID;
    if(function_exists('wp_megamenu')){
    	$wpmm_nav_location_settings = get_wpmm_option('main_navigation');
	 	if(!empty($wpmm_nav_location_settings['is_enabled'])){
	 		$insert_before = '<li id="wp-megamenu-item-' . $menu_item->ID;
	 	} 
    }
    $menu_update = substr_replace( $items, $logo_item, strpos( $items, $insert_before ), 0 );
    if( get_theme_mod('malina_header_search_button', false) && $args->theme_location == 'main_navigation' ) {
		$search_button = '<li class="search-link"><a href="javascript:void(0);" class="search-button"><i class="fa fa-search"></i></a><li>';
		$menu_update .= $search_button;
	}
	if( get_theme_mod('malina_header_shopping_cart', false) && class_exists('WooCommerce') ) { 
		$cart_url = wc_get_cart_url();
		$count = WC()->cart->cart_contents_count;
		$menu_update .= '<li class="cart-main menu-item cart-contents">';
			$menu_update .= '<a class="my-cart-link" href="'.esc_url($cart_url).'"><i class="la la-shopping-cart"></i>';
			if ( $count > 0 ) {
		        $menu_update .='<span class="cart-contents-count">'.esc_html( $count ).'</span>';
		    }
			$menu_update .='</a>';
		$menu_update .= '</li>';
	}
    $items = $menu_update;
    return $items;
}

function malina_menu_item_search( $items, $args ){
	$logo_item = '';
	if ( $args->theme_location == 'main_navigation' ) {
        $logo_item = '<li class="menu-item-search"><div class="search-link"><a href="javascript:void(0);" class="search-button"><i class="fa fa-search"></i></a></div></li>';
    }
    $items .= $logo_item;
    return $items;
}
//Counts the number of top level items in the menu
function malina_count_top_lvl_items() {
    $items = malina_get_menu_items();
    $counter = 0;
    foreach ( $items as $val ) {
        if ( $val->menu_item_parent === '0' ) {
            $counter++;
        }
    }
    return $counter;
}
//Returns the menu item to insert the logo before
function malina_get_menu_item( $index ) {
    $items = malina_get_menu_items();
    $counter = 0;
    foreach ( $items as $val ) {
        if ( $val->menu_item_parent === '0' ) {
            $counter++;
        }
        if ( $counter == $index ) {
            return $val;
        }
    }
}

function malina_get_logo() {
    if(get_theme_mod('malina_media_logo','') != "") {
		$logo_item = '<a href="'.esc_url(home_url()).'/" class="logo_main"><img src="'.esc_url(get_theme_mod('malina_media_logo')).'" alt="'.esc_attr(get_bloginfo('name')).'" /></a>';
	} else {
		$logo_item = '<a href="'.esc_url(home_url()).'/" class="logo_text">'.esc_attr( get_bloginfo('name') ).'</a>';
		if( get_theme_mod('malina_logo_tagline_show', false) ){ $logo_item .= '<p class="tagline">'.esc_html(get_bloginfo('description')).'</p>'; }
	}
    return $logo_item;
}
function malina_get_menu_items() {
    $locations = get_nav_menu_locations();
    $menu = wp_get_nav_menu_object( $locations['main_navigation'] );
    $items = wp_get_nav_menu_items( $menu );
    return $items;
}

if(!class_exists('Malina_Custom_Menu_Walker')){
	class Malina_Custom_Menu_Walker extends Walker_Nav_Menu {
		function start_lvl( &$output, $depth = 0, $args = array() ) {
			$ex_li = '';
				$ex_li = "<li class=\"back-to-menu\">".esc_html__('back', 'malina')."</li>";
			$indent = str_repeat( "\t", $depth );
			$output .= "\n{$indent}<ul class=\"sub-menu\">\n".$ex_li;
		}   
	}
}

if(!function_exists('malina_widget_custom_walker')){
	function malina_widget_custom_walker( $args ) {
	    return array_merge( $args, array(
	        'walker' => new Malina_Custom_Menu_Walker(),
	        // another setting go here ... 
	    ) );
	}
	add_filter( 'widget_nav_menu_args', 'malina_widget_custom_walker' );
}
if(!function_exists('malina_embed_wrap')){
	add_filter('embed_oembed_html', 'malina_embed_wrap', 10, 4);
	function malina_embed_wrap($html, $url, $attr, $post_ID) {
	    if (strpos($url, 'youtube') !== false || strpos($url, 'vimeo') !== false ) {
	        $html = '<div class="video-container">'.$html.'</div>';
	    }
	    return $html;
	}
}

if(!function_exists('malina_post_layout_classes')){
	add_filter('body_class', 'malina_post_layout_classes');
	function malina_post_layout_classes($classes) {
		$tmp = rwmb_get_value( 'malina_post_layout' );
        if( is_single() && !is_array($tmp) && $tmp != '' ){
        	$classes[] = 'post-layout-'.$tmp;
        } else {
        	$classes[] = 'post-layout-default';
        }
        $header_type = rwmb_get_value('malina_header_variant');
		if(!is_array($header_type) && $header_type != '' && $header_type != 'default'){
			$header_var = $header_type;
		} else {
			$header_var = get_theme_mod('malina_header_variant', 'header-version4');
		}
		$classes[] = $header_var;
        return $classes;
	}
}
if(!function_exists('malina_add_meta_viewport')){
	function malina_add_meta_viewport(){
		if( get_theme_mod('malina_responsiveness', true) ) {
			echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">';
		}
	}
	add_action('malina_header_meta', 'malina_add_meta_viewport');
}
if( !function_exists('malina_get_sidebar_position')){
	function malina_get_sidebar_position(){
		$sidebar_pos = '';
		$malina_post_sidebar = 'default';
		$sidebar_name = rwmb_get_value('malina_page_sidebar');
		if(!$sidebar_name){
			$sidebar_name = 'blog-widgets';
		}
		if( rwmb_get_value( 'malina_post_sidebar', get_the_ID() ) == '' || rwmb_get_value( 'malina_post_sidebar', get_the_ID() ) == 'default' || !rwmb_get_value( 'malina_post_sidebar', get_the_ID()) ){
			$malina_post_sidebar = 'default';
		} elseif (rwmb_get_value( 'malina_post_sidebar', get_the_ID() ) == 'none') {
			$malina_post_sidebar = 'none';
		} else {
			$malina_post_sidebar = 'span9 '.rwmb_get_value( 'malina_post_sidebar', get_the_ID() );
		}

		if( $malina_post_sidebar == 'none' ){
			$sidebar_pos ='span12';
		} elseif( $malina_post_sidebar == 'default' ){
			if (get_theme_mod('malina_single_post_sidebar', 'sidebar-right') == 'none'){
				$sidebar_pos = 'span12';
			} else {
				$sidebar_pos = get_theme_mod('malina_single_post_sidebar', 'sidebar-right').' span9';
			}
		} else {
			$sidebar_pos = $malina_post_sidebar;
		}
		$sidebars_widgets  = wp_get_sidebars_widgets();
    	$is_active_sidebar = ! empty( $sidebars_widgets[$sidebar_name] );
		
		if( !$is_active_sidebar && ( get_theme_mod('malina_single_post_sidebar', 'sidebar-right') != 'none' || $malina_post_sidebar != 'none' ) ) {
			$sidebar_pos .=' no_widgets_sidebar';
		}

		return $sidebar_pos;
	}
}
if(!function_exists('malina_single_post_gallery')){
	function malina_single_post_gallery($postID = false, $echo = true){
		if(!$postID){
			$postID = get_the_ID();
		}
		wp_enqueue_style('owl-carousel');
		wp_enqueue_script('owl-carousel');
		$out = '';
		$gallery_type = rwmb_get_value('malina_gallery_post_layout');
		$autoheight = rwmb_get_value('malina_gallery_autoheight');
		$img_size = 'large';
		if( rwmb_get_value('malina_post_layout') == 'fullwidth' ) {
			$img_size = 'malina-fullwidth-slider';
		} elseif( rwmb_get_value('malina_post_layout') == 'wide' ) {
			$img_size = 'large';
		} elseif( rwmb_get_value('malina_post_layout') == 'sideimage' ){
			$img_size = 'malina-masonry';
		} else {
			if( rwmb_get_value('malina_post_sidebar') == 'none' || ( rwmb_get_value('malina_post_sidebar') == 'default' && get_theme_mod('malina_sidebar_pos', 'sidebar-right') != 'none' ) ) {
				$img_size = 'large';
			} else {
				$img_size = 'post-thumbnail';
			}
		}
		$images = rwmb_get_value( 'malina_gallery_images', 'type=image&size='.$img_size );
		$autoplay = rwmb_get_value('malina_gallery_autoplay');
		$loop = rwmb_get_value('malina_gallery_loop');
		if($autoheight ){
			$autoheight = 'true';
		} else {
			$autoheight = 'false';
		}
		if($autoplay ){
			$autoplay = 'true';
		} else {
			$autoplay = 'false';
		}
		if($loop) {
			$loop = 'true';
		} else {
			$loop = 'false';
		}
		if ( !empty($images) ){
			switch ($gallery_type) {
				case 'slideshow_2':
					$owl_custom = 'jQuery(window).load(function(){
						var owl = jQuery(".single-post-gallery").owlCarousel({
				            items:1,
				            autoplay:'.$autoplay.',
				            singleItem:true,
				            loop:'.$loop.',
				            nav:true,
				            navRewind:false,
				            navText: [ \'<i class="la la-angle-left"></i>\',\'<i class="la la-angle-right"></i>\' ],
				            dots:false,
				            autoHeight:'.$autoheight.',
				            themeClass: "owl-gallery"
		    			});	
					});';
					wp_add_inline_script('owl-carousel', $owl_custom);
					$out .= '<div class="single-post-gallery slideshow_2">';
					foreach( $images as $image ) :
						$out .= '<div><img src="'.esc_url($image['url']).'" alt="'.esc_attr($image['alt']).'" /></div>';
					endforeach;
					$out .= '</div>';
					break;
				case 'slideshow_thumb':
					$owl_custom = 'jQuery(window).load(function(){
							var owl = jQuery(".single-post-gallery-thumbs").owlCarousel({
					            items:1,
					            autoplay:'.$autoplay.',
					            singleItem:true,
					            loop:'.$loop.',
					            nav:false,
					            navRewind:false,
					            navText: [ \'<i class="la la-angle-left"></i>\',\'<i class="la la-angle-right"></i>\' ],
					            dots:false,
					            autoHeight:'.$autoheight.',
					            themeClass: "owl-gallery",
					            thumbs:true,
		            			thumbsPrerendered:true
			    			});
					});';
					wp_add_inline_script('owl-carousel', $owl_custom);
					$out .= '<div class="single-post-gallery-thumbs owl-carousel" data-slider-id="1">';
					foreach( $images as $image ) :
						$out .= '<div><img src="'.esc_url($image['url']).'" alt="'.esc_attr($image['alt']).'" /></div>';
					endforeach;
					$out .= '</div>';
					$out .= '<div class="owl-thumbs" data-slider-id="1">';
					foreach( $images as $image ) :
						$image_tmp = wp_get_attachment_image_src( $image['ID'], 'medium');
						$image_src = $image_tmp[0];
						$out .= '<div class="owl-thumb-item"><img src="'.esc_url($image_src).'" alt="'.esc_attr($image['alt']).'" /></div>';
					endforeach;
					$out .= '</div>';
					break;
				default:
					$owl_custom = 'jQuery(window).load(function(){
							var owl = jQuery(".single-post-gallery").owlCarousel({
					            items:1,
					            autoplay:'.$autoplay.',
					            singleItem:true,
					            loop:'.$loop.',
					            nav:true,
					            navRewind:false,
					            navText: [ \'<i class="la la-long-arrow-left"></i>\',\'<i class="la la-long-arrow-right"></i>\' ],
					            dots:false,
					            autoHeight:'.$autoheight.',
					            themeClass: "owl-gallery"
			    			});
					});';
					wp_add_inline_script('owl-carousel', $owl_custom);
					if( rwmb_get_value('malina_post_layout') == 'sideimage' ){
						$type = ' slideshow_2';
					} else {
						$type = '';
					}
					$out .= '<div class="single-post-gallery'.$type.'">';
					foreach( $images as $image ) :
						$out .= '<div><a href="'.esc_url($image['full_url']).'" data-lightbox="lightbox-gallery" data-caption="'.esc_attr($image['caption']).'"><img src="'.esc_url($image['url']).'" alt="'.esc_attr($image['alt']).'" /></a></div>';
					endforeach;
					$out .= '</div>';
					break;
			}
		} elseif( has_post_thumbnail() ) {
			$out .= '<figure class="post-img">'.get_the_post_thumbnail($postID, $img_size).'</figure>';
		}
		if($echo){
			echo ''.$out;
		} else {
			return $out;
		}
	}
}
if( !function_exists('malina_single_post_format_content') ){
	function malina_single_post_format_content($echo = true) {
		$post_format = get_post_format();
		global $post;
		global $_wp_additional_image_sizes;
		$img_size = 'large';
		if( rwmb_get_value('malina_post_layout') == 'fullwidth' || rwmb_get_value('malina_post_layout') == 'fullwidth-alt2') {
			$img_size = 'malina-fullwidth-slider';
		} elseif( rwmb_get_value('malina_post_layout') == 'fullwidth-alt' || rwmb_get_value('malina_post_layout') == 'clean' ) {
			$img_size = 'full';
		} elseif( rwmb_get_value('malina_post_layout') == 'wide' || rwmb_get_value('malina_post_layout') == 'wide2' || rwmb_get_value('malina_post_layout') == 'fancy-header' || rwmb_get_value('malina_post_layout') == 'half-header') {
			$img_size = 'large';
		} elseif( rwmb_get_value('malina_post_layout') == 'sideimage'){
			$img_size = 'malina-masonry';
		} elseif( get_theme_mod('malina_single_post_layout', 'standard') == 'fullwidth' || get_theme_mod('malina_single_post_layout', 'standard') == 'fullwidth-alt2' ) {
			$img_size = 'malina-fullwidth-slider';
		} elseif( get_theme_mod('malina_single_post_layout', 'standard') == 'fullwidth-alt' || get_theme_mod('malina_single_post_layout', 'standard') == 'clean' ) {
			$img_size = 'full';
		} elseif( get_theme_mod('malina_single_post_layout', 'standard') == 'wide' || get_theme_mod('malina_single_post_layout', 'standard') == 'wide2' || get_theme_mod('malina_single_post_layout', 'standard') == 'fancy-header' || get_theme_mod('malina_single_post_layout', 'standard') == 'half-header' ) {
			$img_size = 'large';
		} elseif( get_theme_mod('malina_single_post_layout', 'standard') == 'sideimage' ){
			$img_size = 'malina-masonry';
		} else {
			if( rwmb_get_value('malina_post_sidebar') == 'none' || ( rwmb_get_value('malina_post_sidebar') == 'default' && get_theme_mod('malina_single_post_sidebar', 'sidebar-right') == 'none' ) ) {
				$img_size = 'large';
			} else {
				$img_size = 'post-thumbnail';
			}
		}
		$width  = get_option( "{$img_size}_size_w" );
		$height = get_option( "{$img_size}_size_h" );
		if( (!$width || !$height) && isset($_wp_additional_image_sizes["{$img_size}"]) ){
			$width = $_wp_additional_image_sizes["{$img_size}"]['width'];
			$height = $_wp_additional_image_sizes["{$img_size}"]['height'];
		}
		if( !$width || !$height || $img_size == 'malina-masonry' || $img_size == 'full' ){
			$proportions = '56.25';
		} else {
			$proportions = ($height/$width) * 100;
		}
		$out = '';
		switch ($post_format) {
			case 'gallery':
				$out = malina_single_post_gallery(false, false);
				break;
			case 'video':
				$media = rwmb_meta('malina_post_format_video', $post->ID);
				$url = rwmb_get_value( 'malina_post_format_video' );
				if( has_post_thumbnail() && $media && $url != '' ){
					$media_sites = array('youtube', 'vimeo');
					$site_name = 'youtube';
					$check_media = false;
					foreach ($media_sites as $site) {
						if( strpos( $media, $site ) ){
							$site_name = $site;
							$check_media = true;
						}
					}
					$out = '<div class="video-container">';
					$out .= '<div class="video-placeholder video-'.$site_name.'"><div class="video-play-button"><i class="fab fa-youtube"></i></div><figure class="post-img">'.get_the_post_thumbnail($post->ID, $img_size).'</figure></div>';
					$out .= do_shortcode($media);
					$out .= '</div>';
				} elseif( $media && $url != '' ){
					$out = '<div class="video-container">'.do_shortcode($media).'</div>';
				}
				break;
			case 'audio':
				$media = rwmb_get_value('malina_post_format_audio');
				$url = rwmb_get_value( 'malina_post_format_audio' );
				$media_sites = array('soundcloud', 'mixcloud', 'reverbnation', 'spotify');
				$check = false;
				global $wp_embed;
				if( $media && $url != '' ){
					foreach ($media_sites as $site) {
						if( strpos( $media, $site ) ){
							$check = true;
						}
					}
					if($check){
						$proportions='47';
						$out = '<div class="video-container" style="padding-bottom:'.$proportions.'%">'.$wp_embed->run_shortcode("[embed]".$media."[/embed]").'</div>';
					} else {
						if( has_post_thumbnail() ){
							$out = '<div class="audio-block">';
							$out .= '<figure class="post-img">'.get_the_post_thumbnail($post->ID, $img_size).'</figure>';
							$out .= '<div class="audio-overlay">';
							if( rwmb_get_value('malina_post_layout') == 'fullwidth-alt2' || rwmb_get_value('malina_post_layout') == 'fullwidth-alt'){
								ob_start();
							    get_template_part('templates/posts/title', 'block');
							    $out .= ob_get_contents();
							    ob_end_clean();
							} elseif( rwmb_get_value('malina_post_layout') == 'default' && ( get_theme_mod('malina_single_post_layout', 'standard') == 'fullwidth-alt2' || get_theme_mod('malina_single_post_layout', 'standard') == 'fullwidth-alt') ){
								ob_start();
							    get_template_part('templates/posts/title', 'block');
							    $out .= ob_get_contents();
							    ob_end_clean();
							}
							$out .= do_shortcode('[audio src="'.$media.'" loop="off" autoplay="0" preload="none"]').'</div>';
							$out .= '</div>';
						} else {
							$out = do_shortcode('[audio src="'.$media.'" loop="off" autoplay="0" preload="none"]');
						}
					}
					
				}
				break;
			case 'link':
				$out = malina_single_post_link(false, false);
				break;
			case 'quote':
				$text = rwmb_get_value( 'malina_post_format_quote_text' );
				if ( $text != '' ){
					$cite = rwmb_get_value( 'malina_post_format_quote_cite' );
					$text_color = rwmb_get_value( 'malina_post_format_quote_text_color' );
					$bg_color = rwmb_get_value( 'malina_post_format_quote_bg_color' );
					$style = $style_cite = '';
					if($text_color){
						$style .= $style_cite = 'color:'.$text_color.';';
					}
					if($bg_color) {
						$style .= 'background-color:'.$bg_color.';';
					}
					$out = '<blockquote style="'.$style.'">';
					$out .= '<p class="mb0">'.esc_html($text).'</p>';
					if($cite){
						$out .='<cite style="'.$style_cite.'">'.esc_html($cite).'</cite>';
					}
					$out .= '</blockquote>';
					
				}
				break;
			case 'image':
				$out = '';
				break;
			default:
				$check_media = rwmb_get_value('malina_post_format_embed_replace');
				$media = rwmb_get_value( 'malina_post_format_embed' );
				$url = rwmb_get_value( 'malina_post_format_embed' );
				if( $check_media && $media && $url != ''){
					$proportions_supports = array('cloudup','collegehumor', 'funnyordie', 'flickr', 'youtube', 'dailymotion', 'vimeo', 'ted', 'videopress', 'vine', 'wordpress.tv');
					$check = false;
					foreach ($proportions_supports as $site) {
						if( strpos( $media, $site ) ){
							$check = true;
						}
					}
					if($media && $url != '') {
						if($check){
							$out = '<div class="video-container">'.$media.'</div>';
						} else {
							$out = '<div class="iframe-container">'.$media.'</div>';
						}
					}
				} elseif( has_post_thumbnail() ){
					$out = '<figure class="post-img"><img src="'.get_the_post_thumbnail_url($post->ID, $img_size).'" alt="'.get_the_title().'" ></figure>';
				}
				break;
		}
		if( $echo ){
			echo ''.$out;
		} else {
			return $out;
		}
	}
}
if( !function_exists('malina_get_post_format_content') ){
	function malina_get_post_format_content($echo = true, $img_size){
		global $_wp_additional_image_sizes;
		global $post;
		if(!$img_size){
			$img_size = 'post-thumbnail';
		}
		$out = '';
		$width  = get_option( "{$img_size}_size_w" );
		$height = get_option( "{$img_size}_size_h" );
		if( isset($_wp_additional_image_sizes["{$img_size}"]) && (!$width || !$height)){
			$width = $_wp_additional_image_sizes["{$img_size}"]['width'];
			$height = $_wp_additional_image_sizes["{$img_size}"]['height'];
		}
		if( has_post_thumbnail() && get_the_post_thumbnail($post->ID, $img_size) != ''){
			$out = '<figure class="post-img"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark">'.get_the_post_thumbnail($post->ID, $img_size).'</a></figure>';
		}
		if( $echo ){
			echo ''.$out;
		} else {
			return $out;
		}
	}
}
if(!function_exists('malina_get_the_content')){
	function malina_get_the_content() {
		$content = get_the_content();
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		return $content;
	}
}
if( !function_exists('MalinaSetPostViews')){
	function MalinaSetPostViews() {
		return false;
	}
}
if(!function_exists('malina_single_post_link')){
	function malina_single_post_link($postID = false, $echo = true){
		if(!$postID){
			$postID = get_the_ID();
		}
		$out = '';
		$img_size = 'large';
		if( rwmb_get_value('malina_post_layout') == 'fullwidth' ) {
			$img_size = 'malina-fullwidth-slider';
		} elseif( rwmb_get_value('malina_post_layout') == 'wide' ) {
			$img_size = 'large';
		} elseif( rwmb_get_value('malina_post_layout') == 'sideimage' ){
			$img_size = 'malina-masonry';
		} else {
			if( rwmb_get_value('malina_post_sidebar') == 'none' || ( rwmb_get_value('malina_post_sidebar') == 'default' && get_theme_mod('malina_sidebar_pos', 'sidebar-right') != 'none' ) ) {
				$img_size = 'large';
			} else {
				$img_size = 'post-thumbnail';
			}
		}
		$link = rwmb_get_value( 'malina_post_format_link');
		$title = rwmb_get_value( 'malina_post_format_link_title' );
		if($title == '') {
			$title = $link;
		}
		if ( $link != '' && has_post_thumbnail() ){
			$out .= '<figure class="post-img"><a class="overlay-link" href="'.esc_url($link).'" rel="bookmark"><h2>'.$title.'</h2></a>'.get_the_post_thumbnail($postID, $img_size).'</figure>';
		} elseif( has_post_thumbnail() ) {
			$out .= '<figure class="post-img">'.get_the_post_thumbnail($postID, $img_size).'</figure>';
		}
		if($echo){
			echo ''.$out;
		} else {
			return $out;
		}
	}
}
if(!function_exists('malina_ajax_search')) {
	//now hook into wordpress ajax function to catch any ajax requests
	add_action( 'wp_ajax_malina_ajax_search', 'malina_ajax_search' );
	add_action( 'wp_ajax_nopriv_malina_ajax_search', 'malina_ajax_search' );

	function malina_ajax_search()
	{

	    unset($_REQUEST['action']);
	    if(empty($_REQUEST['s'])) die();

	    $defaults = array('numberposts' => 4, 'post_type' => 'post', 'post_status' => 'publish', 'post_password' => '', 'suppress_filters' => false);
	    $_REQUEST['s'] = apply_filters( 'get_search_query', $_REQUEST['s']);

	    $query = array_merge($defaults, $_REQUEST);
	    $query = http_build_query($query);
	    $posts = get_posts( $query );

	    if(empty($posts))
	    {
	        $output  = "<span class='ajax_search_entry ajax_not_found'>";
	        $output .= "<span class='ajax_search_title'>";
            $no_criteria_matched = esc_html__("Sorry, no posts matched your criteria", 'malina');
            $output .= $no_criteria_matched;
	        $output .= "</span>";
	        $output .= "</span>";
	        echo ''.$output;
	        die();
	    }

	    //if we got posts resort them by post type
	    $output = "";
	    $sorted = array();
	    $post_type_obj = array();
	    foreach($posts as $post)
	    {
	        $sorted[$post->post_type][] = $post;
	        if(empty($post_type_obj[$post->post_type]))
	        {
	            $post_type_obj[$post->post_type] = get_post_type_object($post->post_type);
	        }
	    }

	    //now we got everything we need to preapre the output
	        $output .= "<ul class='unstyled'>";
	        foreach($posts as $post)
	        {
	            $image = get_the_post_thumbnail( $post->ID, 'medium' );
	            $excerpt = "";
	            $link = get_permalink($post->ID);
	            $output .= "<li class='post'>";
	            $output .= '<figure>';
	            //$output .= '<div class="label-date"><span class="day">'.get_the_time('d', $post->ID).'</span><span class="month">'.get_the_time('M', $post->ID).'</span></div>';
	            $output .= '<a href="'.$link.'">'.$image.'</a></figure>';
	            $output .= '<div class="extra-wrap">';
	            $output .= '<div class="meta-categories">'.get_the_category_list(', ', 'single', $post->ID ).'</div>';
	            $output .= '<header class="title">';
				$output .= '<h3 itemprop="headline"><a href="'.$link.'" rel="bookmark">'.get_the_title($post->ID).'</a></h3>';
				$output .= '</header>';
				$output .= "</div>";
	            $output .= "</li>";
	        }

	    $query =  http_build_query($_REQUEST);
        $label = esc_html__('View all results','malina');
        $output .= "</ul>";
	    $output .= "<a class='button' href='".home_url('?' . $query )."'>".$label."</a>";
	    echo ''.$output;
	    die();
	}
}
if(!function_exists('malina_calculate_reading_time')){
	function malina_calculate_reading_time($postID = false, $echo = false) {
		$wpm = 250;
		if(!$postID){
			$postID = get_the_ID();
		}
		$include_shortcodes = true;
		$exclude_images = false;
		$tmpContent = get_post_field('post_content', $postID);
		$number_of_images = substr_count(strtolower($tmpContent), '<img ');
		if ( ! $include_shortcodes ) {
			$tmpContent = strip_shortcodes($tmpContent);
		}
		$tmpContent = strip_tags($tmpContent);
		$wordCount = str_word_count($tmpContent);

		if ( !$exclude_images ) {

			$additional_words_for_images = malina_calculate_images( $number_of_images, $wpm );
			$wordCount += $additional_words_for_images;
		}

		$wordCount = apply_filters( 'malina_filter_wordcount', $wordCount );

		$readingTime = ceil($wordCount / $wpm);

		// If the reading time is 0 then return it as < 1 instead of 0.
		if ( $readingTime < 1 ) {
			$readingTime = esc_html__('< 1 min read', 'malina');
		} elseif($readingTime == 1) {
			$readingTime = esc_html__('1 min read', 'malina');
		} else {
			$readingTime = $readingTime.' '.esc_html__('mins read', 'malina');
		}

		if($echo){ 
			echo ''.$readingTime;
		} else {
			return $readingTime;
		}
	}
}

if(!function_exists('malina_calculate_images')){
	function malina_calculate_images( $total_images, $wpm ) {
		$additional_time = 0;
		// For the first image add 12 seconds, second image add 11, ..., for image 10+ add 3 seconds
		for ( $i = 1; $i <= $total_images; $i++ ) {
			if ( $i >= 10 ) {
				$additional_time += 3 * (int) $wpm / 60;
			} else {
				$additional_time += (12 - ($i - 1) ) * (int) $wpm / 60;
			}
		}

		return $additional_time;
	}
}
if(!function_exists('malina_content_has_shortcode')){
	function malina_content_has_shortcode( $shortcode = NULL ) {
	    $post_to_check = get_post( get_the_ID() );
	    // false because we have to search through the post content first
	    $found = false;
	    // if no short code was provided, return false
	    if( !$post_to_check ){
	    	return $found;
	    }
	    if ( ! $shortcode ) {
	        return $found;
	    }
	    // check the post content for the short code
	    if(is_array($shortcode)){
	    	foreach ($shortcode as $item) {
			    if (strpos($post_to_check->post_content, '['.$item) !== FALSE) {
			        $found = TRUE;
			    }
			}
	    } else {
	    	if ( stripos( $post_to_check->post_content, '[' . $shortcode) !== FALSE ) {
		        // we have found the short code
		        $found = TRUE;
		    }
	    }
	    
	    // return our final results
	    return $found;
	}
}
if( class_exists('WooCommerce') ){
	add_action( 'wp_enqueue_scripts', 'dequeue_woocommerce_styles_scripts', 99 );
	function dequeue_woocommerce_styles_scripts() {
	    if ( function_exists( 'is_woocommerce' ) ) {
	    	$woo_shortcodes = ['woocommerce_', 'products', 'featured_products', 'sale_products', 'best_selling_products', 'recent_products', 'product_attribute', 'top_rated_products', 'product_', 'add_to_cart', 'shop_messages'];
	        if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && !malina_content_has_shortcode($woo_shortcodes) ) {
	            wp_dequeue_style('malina-woocommerce' );
	            wp_dequeue_style( 'woocommerce-general' );
	            wp_dequeue_style( 'woocommerce-layout' );
	            wp_dequeue_style( 'woocommerce-smallscreen' );
	            wp_dequeue_style( 'woocommerce_frontend_styles' );
	            wp_dequeue_style( 'woocommerce_fancybox_styles' );
	            wp_dequeue_style( 'woocommerce_chosen_styles' );
	            wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
	            wp_dequeue_style( 'wc-block-style' );
	            wp_dequeue_style( 'wc-gateway-ppec-frontend' );
	            # Scripts
	            wp_dequeue_script( 'wc_price_slider' );
	            wp_dequeue_script( 'wc-single-product' );
	            //wp_dequeue_script( 'wc-add-to-cart' );
	            //wp_dequeue_script( 'wc-cart-fragments' );
	            wp_dequeue_script( 'wc-checkout' );
	            wp_dequeue_script( 'wc-add-to-cart-variation' );
	            wp_dequeue_script( 'wc-single-product' );
	            wp_dequeue_script( 'wc-cart' );
	            wp_dequeue_script( 'wc-chosen' );
	            wp_dequeue_script( 'woocommerce' );
	            wp_dequeue_script( 'prettyPhoto' );
	            wp_dequeue_script( 'prettyPhoto-init' );
	            wp_dequeue_script( 'jquery-blockui' );
	            wp_dequeue_script( 'jquery-placeholder' );
	            wp_dequeue_script( 'fancybox' );
	            wp_dequeue_script( 'jqueryui' );
	            wp_dequeue_script( 'vc_woocommerce-add-to-cart-js' );
	        }
	    }
	}

	if(!function_exists('malina_woocommerce_my_single_title')){
		remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
		add_action('woocommerce_single_product_summary', 'malina_woocommerce_my_single_title', 5);
		function malina_woocommerce_my_single_title() {
			echo '<header class="title"><h2>'.get_the_title().'</h2></header>';
		}
	}
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart');
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price');
	function malina_price_add_to_cart_wrapper_1(){
		echo '<div class="add_to_cart_wrapper">';
	}
	function malina_price_add_to_cart_wrapper_2(){
		echo '</div>';
	}
	add_action( 'woocommerce_after_shop_loop_item', 'malina_price_add_to_cart_wrapper_1', 10);
	add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 11);
	add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 12);
	add_action( 'woocommerce_after_shop_loop_item', 'malina_price_add_to_cart_wrapper_2', 15);

	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs');
	remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
	//remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
	add_action('woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 60);
	add_action('woocommerce_after_single_product', 'woocommerce_output_related_products', 20);
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
	add_filter( 'woocommerce_output_related_products_args', 'malina_related_products_args' );
	function malina_related_products_args( $args ) {
		$args['posts_per_page'] = 3; // 4 related products
		$args['columns'] = 3; // arranged in 2 columns
		return $args;
	}
	/**
	 * Rename product data tabs
	 */
	add_filter( 'woocommerce_product_tabs', 'malina_rename_tabs', 98 );
	function malina_rename_tabs( $tabs ) {
		global $product;
		if ( $product && ( $product->has_attributes() || apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() ) ) ) {
			$tabs['additional_information']['title'] = __( 'Material and Care', 'malina' );	// Rename the additional information tab
		} else {
			unset( $tabs['additional_information'] );
		}
		return $tabs;

	}

	add_filter( 'woocommerce_show_page_title', 'malina_disable_shop_title');
	function malina_disable_shop_title($true){
		return false;
	}

	add_action('woocommerce_before_shop_loop', 'malina_woocommerce_shop_title', 5);
	function malina_woocommerce_shop_title() {
		if( !is_archive() ){
			echo '<header class="page-title"><h1>'.woocommerce_page_title(false).'</h1></header>';
		}
	}
	add_action('woocommerce_archive_description', 'malina_woocommerce_shop_title_archive', 5);
	function malina_woocommerce_shop_title_archive() {
		echo '<header class="page-title"><h1>'.woocommerce_page_title(false).'</h1></header>';
	}
	/**
	 * Ensure cart contents update when products are added to the cart via AJAX
	 */
	function malina_header_add_to_cart_fragment( $fragments ) {
	 
	    ob_start();
	    $count = WC()->cart->cart_contents_count;
	    $cart_url = wc_get_cart_url();
	    ?><div class="cart-main menu-item cart-contents">
			<a class="my-cart-link" href="<?php echo wc_get_cart_url(); ?>"><i class="la la-shopping-cart"></i>
				<?php if ( $count > 0 ) {?>
			        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
			        <?php
			    } ?>
			</a>
		</div><?php
	 
	    $fragments['div.cart-contents'] = ob_get_clean();
	     
	    return $fragments;
	}
	add_filter( 'woocommerce_add_to_cart_fragments', 'malina_header_add_to_cart_fragment' );
}

// trim excerpt whitespace
if ( !function_exists( 'malina_trim_excerpt_whitespace' ) ) {
  function malina_trim_excerpt_whitespace( $excerpt ) {
    return trim( $excerpt );
  }
  add_filter( 'get_the_excerpt', 'malina_trim_excerpt_whitespace', 1 );
}


if( !function_exists('malina_breadcrumbs') ){
	function malina_breadcrumbs() {

		$showOnHome = get_theme_mod('malina_breadcrumbs', 'false') == 'true' ? 0 : 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$delimiter = apply_filters('malina_breadcrumbs_delimiter', ' / '); // delimiter between crumbs
		$home = esc_html__('Home', 'malina'); // text for the 'Home' link
		$blog = esc_html__('Blog', 'malina');
		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$showSingular = 1;
		$before = '<span class="current">'; // tag before the current crumb
		$after = '</span>'; // tag after the current crumb

		global $post;

		$homeLink = home_url();
		if (is_front_page() && $showOnHome == 0){
			return;
		}

		echo '<div id="breadcrumbs"><div class="container"><div class="span12">';
		if (is_home() && is_front_page()) {

			if ($showOnHome == 1){
				echo '<div id="crumbs"><a href="' . $homeLink . '">' . $blog . '</a></div>';
			}

		} elseif (is_home() && !is_front_page()) {

			echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ' . $blog . '</div>';

		} elseif (is_front_page()) {

			if ($showOnHome == 1){
				echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a></div>';
			}

		} else {

			echo '<div id="crumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';

			if ( is_category() ) {
				$thisCat = get_category(get_query_var('cat'), false);
				if ($thisCat->parent != 0) echo get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter . ' ');
				echo ''.$before .esc_html__('Archive by category','malina').' "' . single_cat_title('', false) . '"' . $after;
			} elseif ( is_search() ) {
				echo ''.$before .esc_html__('Search results for','malina').' "' . get_search_query() . '"' . $after;
			} elseif ( is_day() ) {
				echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
				echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
				echo ''.$before . get_the_time('d') . $after;
			} elseif ( is_month() ) {
				echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
				echo ''.$before . get_the_time('F') . $after;
			} elseif ( is_year() ) {
				echo ''.$before . get_the_time('Y') . $after;
			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					if($showSingular) {
						if (class_exists('WooCommerce')) {
							if(is_product()){
								$product=true;
							} else {
								$product=false;
							}
						}
						if($product){
							$categories = get_the_terms($post->ID, 'product_cat');
							if ( ! empty( $categories ) ) {
								$category = '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a> '.$delimiter . ' ';
							} else {
								$category = '';
							}
							echo ''.$category;
						} else {
							echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
						}
					}
					if ($showCurrent == 1) 
						echo  $before . get_the_title() . $after;
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
					if ($showCurrent == 0)
						$cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
					echo ''.$cats;
					if ($showCurrent == 1)
						echo ''.$before . get_the_title() . $after;
				}

			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				$post_type = get_post_type_object(get_post_type());
				echo ''.$before . $post_type->labels->singular_name . $after;
			} elseif ( is_attachment() ) {
				$parent = get_post($post->post_parent);
				$cat = get_the_category($parent->ID); //$cat = $cat[0];
				if(get_category_parents($cat, TRUE, ' ' . $delimiter . ' ')) {
					get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
				}
				echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
				if ($showCurrent == 1)
					echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

			} elseif ( is_page() && !$post->post_parent ) {
				if ($showCurrent == 1) echo ''.$before . get_the_title() . $after;
			} elseif ( is_page() && $post->post_parent ) {
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					echo ''.$breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1)
						echo ' ' . $delimiter . ' ';
				}
				if ($showCurrent == 1)
					echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;

			} elseif ( is_tag() ) {
				echo ''.$before .esc_html__('Posts tagged','malina').' "' . single_tag_title('', false) . '"' . $after;
			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata($author);
				echo ''.$before .esc_html__('Articles posted by','malina').' ' . $userdata->display_name . $after;
			} elseif ( is_404() ) {
				echo ''.$before .esc_html__('Error 404','malina').' '. $after;
			}

			if ( get_query_var('paged') ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) 
					echo ' (';
				echo esc_html__('Page','malina') . ' ' . get_query_var('paged');
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() )
					echo ')';
			}
			echo '</div>';

		}
		echo "</div></div></div>";
	}
}
if( !function_exists('malina_get_custom_header_list') ){
	function malina_get_custom_header_list(){
		$headers['none'] = esc_html__('None', 'malina');
		$args = array(
			'post_type' => 'malina-header',
			'post_status'    => 'publish',
			'order'          => 'ASC',
			'orderby'        => 'title'
		);
		$items = get_posts( $args );
		if( !empty($items) ){
			foreach( $items as $post ){ 
				setup_postdata($post);
				$id = $post->ID;
				$title = $post->post_title; 
				$headers[$id] = $title;
			}
		} 
		wp_reset_postdata();
		return $headers;
	}	
}
if( !function_exists('malina_get_custom_header') ){
	function malina_get_custom_header( $id, $echo = true ){
		if( $id != ''){
			if(class_exists('Elementor\Plugin') && \Elementor\Plugin::$instance->db->is_built_with_elementor($id) ){
				$out = \Elementor\Plugin::$instance->frontend->get_builder_content( $id );
			} else {
				$out = '<div class="container"><div class="span12">';
				$content_post = get_post($id);
				$content = $content_post->post_content;
				$content = apply_filters('the_content', $content);
				$out .= str_replace(']]>', ']]&gt;', $content);
				$out .= '</div></div>';
			}
			if($echo){
				echo ''.$out;
			} else {
				return $out;
			}
		} else {
			return false;
		}
	}
}
if( !function_exists('malina_get_custom_footer_list') ){
	function malina_get_custom_footer_list(){
		$footers['none'] = esc_html__('None', 'malina');
		$args = array(
			'post_type' => 'malina-footer',
			'post_status'    => 'publish',
			'order'          => 'ASC',
			'orderby'        => 'title'
		);
		$items = get_posts( $args );
		if( !empty($items) ){
			foreach( $items as $post ){ 
				setup_postdata($post);
				$id = $post->ID;
				$title = $post->post_title; 
				$footers[$id] = $title;
			}
		} 
		wp_reset_postdata();
		return $footers;
	}	
}

if( !function_exists('malina_get_custom_footer') ){
	function malina_get_custom_footer( $id, $echo = true ){
		if( $id != ''){
			if(class_exists('Elementor\Plugin') && \Elementor\Plugin::$instance->db->is_built_with_elementor($id) ){
				$out = \Elementor\Plugin::$instance->frontend->get_builder_content( $id );
			} else {
				$out = '<div class="container"><div class="span12">';
				$content_post = get_post($id);
				$content = $content_post->post_content;
				$content = apply_filters('the_content', $content);
				$out .= str_replace(']]>', ']]&gt;', $content);
				$out .= '</div></div>';
			}
			if($echo){
				echo ''.$out;
			} else {
				return $out;
			}
		} else {
			return false;
		}
	}
}
if(!get_theme_mod('malina_seo_settings', false) && !function_exists('malina_schemaorg_print_scripts')){
function malina_schemaorg_print_scripts() { 
	if(is_single()){
	?>
<script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Article",
      "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "<?php the_permalink(); ?>"
      },
      "headline": "<?php the_title(); ?>",
      "image": [
        "<?php the_post_thumbnail_url('thumbnail'); ?>",
        "<?php the_post_thumbnail_url('medium'); ?>",
        "<?php the_post_thumbnail_url('large'); ?>"
       ],
      "datePublished": "<?php the_date(); ?>",
      "dateModified": "<?php the_modified_date(); ?>",
      "author": {
        "@type": "Person",
        "name": "<?php the_author(); ?>"
      },
       "publisher": {
        "@type": "Organization",
        "name": "<?php bloginfo('name'); ?>",
        "logo": {
			"@type": "ImageObject",
			"url": "<?php if(get_theme_mod('malina_media_logo', '') != ''){ echo esc_url(get_theme_mod('malina_media_logo')); } else { echo esc_url(get_theme_mod('malina_media_favicon',get_template_directory_uri().'/favicon.ico')); } ?>"
	    }
      },
      "description": "<?php echo strip_tags(get_the_excerpt()); ?>"
    }
</script>
<?php
	}
}
add_action('wp_footer', 'malina_schemaorg_print_scripts');
}
?>