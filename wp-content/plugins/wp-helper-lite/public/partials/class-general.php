<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 * 
 * @since      1.0.0
 *
 * @package    MB_WP_Manage
 * @subpackage MB_WP_Manage/public/partials
 */
if ( defined( 'ABSPATH' ) && ! class_exists( 'mbwph_General_Load_Settings' ) ) {
	class mbwph_General_Load_Settings{
		private $WP_HELPER;
		private $editor_type,$duplicate_post_page,$relative_image_url,$duplicate_widget,$allow_widget_class,$duplicate_menu ;
		/**
		* Class constructor.
		*/
		public function __construct() {
			$this->WP_HELPER = 'wp-helper';			
			$this->setup_vars();
			$this->hooks();			
		}
		function setup_vars(){
			$this->editor_type = get_option('editor_type');
			$this->duplicate_post_page = get_option('duplicate_post_page');
			$this->relative_image_url = get_option('relative_image_url');
			$this->duplicate_widget = get_option('duplicate_widget');
			$this->allow_widget_class = get_option('allow_widget_class');
			$this->duplicate_menu = get_option('duplicate_menu');			
		}		
		private function hooks(){			
			if(!empty($this->editor_type)){
				switch ($this->editor_type) {
					case 1:
						add_filter( 'use_block_editor_for_post', '__return_false' );
						break;
					case 2:
						break;
				}
			}
			if(!empty($this->duplicate_post_page) && $this->duplicate_post_page == 1){
				add_filter( 'post_row_actions', array($this, 'mbwph_duplicate_post_link'), 10, 2 );
				add_filter('page_row_actions', array($this, 'mbwph_duplicate_post_link'), 10, 2);
				add_action( 'admin_action_mbwph_duplicate_post_as_draft', array($this, 'mbwph_duplicate_post_as_draft') );
			}
			if(!empty($this->relative_image_url) && $this->relative_image_url == 1){
				$filters = array(
					'bloginfo_url',
					'theme_root_uri',
					'stylesheet_directory_uri',
					'template_directory_uri',
					'the_permalink',
					'wp_list_pages',
					'wp_list_categories',
					'wp_nav_menu',
					'wp_get_attachment_url',
					'wp_get_attachment_link',
					'the_content_more_link',
					'the_tags',
					'get_pagenum_link',
					'get_comment_link',
					'month_link',
					'day_link',
					'year_link',
					'tag_link',
					'the_author_posts_link'
				);
				foreach ( $filters as $filter ) {
					add_filter( $filter, array($this, 'mbwph_roots_root_relative_url') );
				}
				if (!is_admin()) {
				  add_filter('plugins_url', array($this, 'mbwph_roots_root_relative_url'));
				}
				add_action('pre_get_posts', array($this, 'mbwph_roots_relative_feed_urls') );
			}
			if(!empty($this->duplicate_widget) && $this->duplicate_widget == 1){
				add_filter('admin_head', array($this, 'mbwph_enqueue_duplicate_widget_script'));
			}
			if(!empty($this->allow_widget_class) && $this->allow_widget_class == 1){
				add_filter('widget_form_callback', array($this, 'mbwph_widget_form_extend'), 10, 2);
				add_filter( 'widget_update_callback', array($this, 'mbwph_widget_update'), 10, 2 );
				add_filter( 'dynamic_sidebar_params', array($this, 'mbwph_dynamic_sidebar_params') );
			}
			if(!empty($this->duplicate_menu) && $this->duplicate_menu == 1){
				add_action('wp_ajax_mbwph_duplicate_menu_maker', array( $this, 'mbwph_duplicate_menu_maker' ));
				add_action( 'admin_enqueue_scripts', array( $this, 'mbwph_duplicate_admin_scripts' ) );
			}
		}
		public function mbwph_duplicate_post_as_draft(){
			global $wpdb;
			if (! ( isset( $_GET['post']) || isset( $_POST['post'])  || ( isset($_REQUEST['action']) && 'mbwph_duplicate_post_as_draft' == $_REQUEST['action'] ) ) ) {
				wp_die('No post to duplicate has been supplied!');
			}
			if ( !isset( $_GET['duplicate_nonce'] ) || !wp_verify_nonce( $_GET['duplicate_nonce'], basename( __FILE__ ) ) )
				return;
				
			$post_id = (isset($_GET['post']) ? absint( $_GET['post'] ) : absint( $_POST['post'] ) );				
			$post = get_post( $post_id );
			$current_user = wp_get_current_user();
			$new_post_author = $current_user->ID;
			if (isset( $post ) && $post != null) {
				$args = array(
					'comment_status' => $post->comment_status,
					'ping_status'    => $post->ping_status,
					'post_author'    => $new_post_author,
					'post_content'   => $post->post_content,
					'post_excerpt'   => $post->post_excerpt,
					'post_name'      => $post->post_name,
					'post_parent'    => $post->post_parent,
					'post_password'  => $post->post_password,
					'post_status'    => 'draft',
					'post_title'     => $post->post_title,
					'post_type'      => $post->post_type,
					'to_ping'        => $post->to_ping,
					'menu_order'     => $post->menu_order
				);				
				$new_post_id = wp_insert_post( $args );
				$taxonomies = get_object_taxonomies($post->post_type);
				foreach ($taxonomies as $taxonomy) {
					$post_terms = wp_get_object_terms($post_id, $taxonomy, array('fields' => 'slugs'));
					wp_set_object_terms($new_post_id, $post_terms, $taxonomy, false);
				}
				$post_meta_infos = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=$post_id");
				if (count($post_meta_infos)!=0) {
					$sql_query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
					foreach ($post_meta_infos as $meta_info) {
					$meta_key = $meta_info->meta_key;
					if( $meta_key == '_wp_old_slug' ) continue;
					$meta_value = addslashes($meta_info->meta_value);
					$sql_query_sel[]= "SELECT $new_post_id, '$meta_key', '$meta_value'";
					}
					$sql_query.= implode(" UNION ALL ", $sql_query_sel);
					$wpdb->query($sql_query);
				}
				wp_redirect( admin_url( 'post.php?action=edit&post=' . $new_post_id ) );
				exit;
			} else {
				wp_die('Post creation failed, could not find original post: ' . $post_id);
			}
		}			
		public function mbwph_duplicate_post_link( $actions, $post ) {
			if (current_user_can('edit_posts')) {
				$actions['duplicate'] = '<a href="' . wp_nonce_url('admin.php?action=mbwph_duplicate_post_as_draft&post=' . $post->ID, basename(__FILE__), 'duplicate_nonce' ) . '" title="Sao chép bài viết" rel="permalink"><span class="dashicons dashicons-admin-page"></span> Nhân bản</a>';
			}
			return $actions;
		}
		public function mbwph_enqueue_duplicate_widget_script()
		{
			global $pagenow;
			if ($pagenow != 'widgets.php')
				return;			
			wp_enqueue_script('mbwph_duplicate_widgets_script', plugin_dir_url( __FILE__ ) . 'assets/js/mbwph-widgets.js', array('jquery'), false, true);
			wp_localize_script('mbwph_duplicate_widgets_script', 'mbwph_duplicate_widgets', array(
				'text' => __('<span class="dashicons dashicons-admin-page"></span> Nhân bản', 'mbwph-duplicate-widgets'),
				'title' => __('Nhân bản Widget', 'mbwph-duplicate-widgets')
			));
		}
		public function mbwph_roots_relative_feed_urls() {
			global $wp_query;
			if (is_feed()) {
				remove_filter('wp_get_attachment_url', array($this, 'mbwph_roots_root_relative_url'));
				remove_filter('wp_get_attachment_link', array($this, 'mbwph_roots_root_relative_url'));
			}
		}
		function mbwph_roots_root_relative_url($input) {
			preg_match('/(https?:\/\/[^\/|"]+)/', $input, $matches);			
			if (isset($matches[0]) && strpos($matches[0], site_url()) === false) {
				return $input;
			} else {
				return str_replace(end($matches), '', $input);
			}
		}
		function mbwph_widget_form_extend( $instance, $widget ) {	
		  if ( !isset($instance['classes']) )
				$instance['classes'] = null;
				$row = "<p><label for='widget-{$widget->id_base}-{$widget->number}-classes' style='color:#f00'><strong>CSS Class:</strong>";
				$row .= "<input type='text' name='widget-{$widget->id_base}[{$widget->number}][classes]' id='widget-{$widget->id_base}-{$widget->number}-classes' class='widefat' value='{$instance['classes']}'/>\n";
				$row .= "</label></p>";
				echo $row;
			return $instance;
		}
		function mbwph_widget_update( $instance, $new_instance ) {
			$instance['classes'] = $new_instance['classes'];
			return $instance;
		}
		function mbwph_dynamic_sidebar_params( $params ) {
			global $wp_registered_widgets;
			$widget_id    = $params[0]['widget_id'];
			$widget_obj    = $wp_registered_widgets[$widget_id];
			$widget_opt    = get_option($widget_obj['callback'][0]->option_name);
			$widget_num    = $widget_obj['params'][0]['number'];

			if ( isset($widget_opt[$widget_num]['classes']) && !empty($widget_opt[$widget_num]['classes']) )
				$params[0]['before_widget'] = preg_replace( '/class="/', "class=\"{$widget_opt[$widget_num]['classes']} ", $params[0]['before_widget'], 1 );
			return $params;
		}
		function mbwph_duplicate_admin_scripts() {
			wp_enqueue_style( 'mbwph-style',  WP_HELPER_URL . 'public/partials/assets/css/mbwph-style.css');
			wp_enqueue_script( 'mbwph_duplicate_admin_js', WP_HELPER_URL . 'public/partials/assets/js/mbwph-menu.js' ,
			array( 'jquery' ), true, true );			
			wp_localize_script( 'mbwph_duplicate_admin_js', 'mbwph_button_duplicate',
								array(
								'enable_in_menu'=>$this->duplicate_menu,
								'mbwph_bt_name'=>__('<span class="dashicons dashicons-admin-page"></span> Sao chép menu', 'mbwph'),
								'ajax_url'=>admin_url('admin-ajax.php')
								)
							);
		}
		function mbwph_duplicate_menu_maker() {
			$response = array();
			/* Check for vaild input */
			if ( ! isset( $_REQUEST['name'] ) ) {
				echo '<strong> Something went wrong </strong>';
				die();
			}
			/* Make sure values are vaild to process */
			$name = sanitize_text_field( $_REQUEST['name'].'-copy' );
			if ( true === is_nav_menu($name) ) {
				$response["error"] = 'Menu '. $name .' đã tồn tại. Vui lòng truy cập danh sách menu để kiểm tra' ;
				echo json_encode( $response );
				die();
			}
			$source = wp_get_nav_menu_object( $_REQUEST['name'] );
			$source_items = wp_get_nav_menu_items( $_REQUEST['name'] );
			$new_id = wp_create_nav_menu( $name );
			/* Ready to process the menu for duplication */
			$rel = array();
			$i = 1;
			foreach ( $source_items as $menu_item ) {
				$args = array(
					'menu-item-db-id'       	=> $menu_item->db_id,
					'menu-item-object-id'   	=> $menu_item->object_id,
					'menu-item-object'      	=> $menu_item->object,
					'menu-item-position'    	=> $i,
					'menu-item-type'        	=> $menu_item->type,
					'menu-item-title'       	=> $menu_item->title,
					'menu-item-url'         	=> $menu_item->url,
					'menu-item-description' 	=> $menu_item->description,
					'menu-item-attr-title'  	=> $menu_item->attr_title,
					'menu-item-target'      	=> $menu_item->target,
					'menu-item-classes'     	=> implode( ' ', $menu_item->classes ),
					'menu-item-xfn'         	=> $menu_item->xfn,
					'menu-item-status'      	=> $menu_item->post_status
				); // End of for-each()
				$parent_id = wp_update_nav_menu_item( $new_id, 0, $args );
				$rel[$menu_item->db_id] = $parent_id;
				/* Just reassuring, child shouldn't be left home-alone */
				if ( $menu_item->menu_item_parent ) {
					$args['menu-item-parent-id'] = $rel[$menu_item->menu_item_parent];
					$parent_id = wp_update_nav_menu_item( $new_id, $parent_id, $args );
				}
				$i++;
			} /* End of foreach() */
			/* Refresh(redirect to) the current page */
				$response["menu_id"] = $new_id  ;
				echo json_encode( $response );
				die();
		}
	}
}