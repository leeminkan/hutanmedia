<?php
class malina_widget_instagram extends WP_Widget { 
	
	// Widget Settings
	public function __construct() {
		$widget_ops = array('description' => __('Display your latest Instagram Photos by Username. This method deprecated. Use widget malina-Instagram New API instead.', 'malina-elements') );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'instagram' );
		parent::__construct( 'instagram', __('malina-Instagram by Username:deprecated', 'malina-elements'), $widget_ops, $control_ops );
	}
	/** @see WP_Widget::widget */
	function widget($args, $instance) {		
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		$user_name = isset($instance['user_name']) ? $instance['user_name']:'';
		$user_profile_name = $user_name;
		$pics = apply_filters('pics', $instance['pics']);
		$pics_per_row = apply_filters('pics_per_row', $instance['pics_per_row']);
		$hide_items = $instance['hide_items'];
		$hide_link = $instance['hide_link'];
		$item_link = isset($instance['item_link']) ? $instance['item_link'] : 1;
		$insta_title = isset($instance['insta_title']) ? $instance['insta_title'] : '';
		$suf = $this->id;
		$row_class='';	
		// processing further
		$main_data = array();
		echo ''.$before_widget; 
		if ( $title !='' )	echo ''.$before_title . $title . $after_title;
		
		$transient_name = 'malina_instagram_items'.$user_name.$suf;
		$malina_instagram_items = get_transient( $transient_name );

		$malina_instagram_items_count = get_transient( 'malina_instagram_items_count'.$user_name.$suf );

		switch ($pics_per_row) {
        	case '1':
        		$row_class='span12';
        		break;
        	case '2':
        		$row_class='span6';
        		break;
        	case '4':
        		$row_class='span3';
        		break;
        	case '6':
        		$row_class='span2';
        		break;
        	default:
        		$row_class='span4';
        		break;
        }

		if( !$malina_instagram_items || empty($malina_instagram_items) ){
		    // get remote data
		    $result = wp_remote_get( "https://www.instagram.com/".$user_profile_name."/?__a=1", array('timeout' => 30) );

		    if(is_array($result) && !empty($result['body'])){
		    	$result = json_decode( $result['body'] );
			    if ( is_wp_error( $result ) ) {
			        // error handling
			        $error_message = $result->get_error_message();
			        echo "Something went wrong: ".$error_message;

			    } elseif( empty($result) || empty($result->graphql->user->edge_owner_to_timeline_media->edges) ){
			    	esc_html_e('Something went wrong: it seems that profile is private or removed. Go to settings and set instagram username.', 'malina-elements');

			    } elseif( isset($result->meta->error_message) ) {
			    	echo "Something went wrong: ".$result->meta->error_message;

			    } else {
			        
			        $username = '';
			        $n         = 0;
			        //print_r($result->graphql->user->edge_owner_to_timeline_media->edges);
			        // get username and actual thumbnail
			        if( is_array($result->graphql->user->edge_owner_to_timeline_media->edges) || is_object($result->graphql->user->edge_owner_to_timeline_media->edges) ){
			        	foreach ( $result->graphql->user->edge_owner_to_timeline_media->edges as $d ) {
				        	$username = $d->node->owner->username;

				        	$main_data[ $n ]['type'] = $d->node->__typename;
				            $main_data[ $n ]['user']      = $username;
				            $main_data[ $n ]['user_url']   = '//instagram.com/'.$username;
				            $main_data[ $n ]['instagram_item_url'] = '//instagram.com/p/'.$d->node->shortcode;
				            $main_data[ $n ]['thumbnail'] = $d->node->thumbnail_resources[2]->src;
				            $main_data[ $n ]['caption'] = !empty($d->node->edge_media_to_caption->edges[0]->node->text) ? $d->node->edge_media_to_caption->edges[0]->node->text : '';
				            $main_data[ $n ]['full'] = $d->node->display_url;
				            
				            $n++;
				        }
			        }
			        delete_transient( $transient_name );
			        set_transient( $transient_name, $main_data, 1 * HOUR_IN_SECONDS );
			        set_transient( 'malina_instagram_items_count'.$user_name.$suf, $pics, 1 * HOUR_IN_SECONDS );
			    }
		    }
		}
		
		$malina_instagram_items = get_transient( $transient_name );
		if( !$malina_instagram_items ){
			$malina_instagram_items = $main_data;
		}
		if(!empty($malina_instagram_items) && is_array($malina_instagram_items)){
			// create main string, pictures embedded in links
		        $items = '<div class="instagram-items">';
		        $i = 1;
		        foreach ( $malina_instagram_items as $data ) {
		        	if( $i > $pics ){
		        		break;
		        	}
		        	$username = $data['user'];
		        	$user_url = $data['user_url'];
		        	$instagram_item_url = isset($data['instagram_item_url']) ? $data['instagram_item_url'] : $user_url;
		        	if( $data['type']=='GraphVideo' ){
		        		$items .= '<div class="'.$row_class.' instagram-item">';
		        		$items .= '<a class="open-insta-video-lightbox" href="'.esc_url($instagram_item_url).'" target="_blank"><i class="fas fa-video"></i><img src="'.esc_url($data['thumbnail']).'" alt="'.esc_attr($data['caption']).'"></a></div>';
		        	} else {
		        		if( $item_link == 2 ){
							$item_link_t = $instagram_item_url;
							$data_l = 'target="_blank"';
		        		} else {
		        			$item_link_t = esc_url($data['full']);
		        			$data_l = 'data-lightbox="lightbox-insta"';
		        		}
		            	$items .= '<div class="'.$row_class.' instagram-item"><a href="'.$item_link_t.'" '.$data_l.'><img src="'.esc_url($data['thumbnail']).'" alt="'.esc_attr($data['caption']).'"></a></div>';
		            }
		            $i++;
		        }
		        $items .= '</div>';
		    if(!$hide_items){
		    	echo $items;
		    }
		    if(!$hide_link){
		    	if( !isset( $insta_title ) || $insta_title == '' ){
		    		$insta_title = '@ '.$username;
		    	}
	        	echo '<a class="insta-follow-link" href="'.$user_url.'" target="_blank">'.$insta_title.'</a>';
		    }
		}
		echo ''.$after_widget; 
	}
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance; 
		
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['user_name'] = strip_tags( $new_instance['user_name'] );
		$instance['pics'] = strip_tags( $new_instance['pics'] );
		$instance['pics_per_row'] = strip_tags( $new_instance['pics_per_row'] );
		$instance['hide_items'] = $new_instance['hide_items'];
		$instance['hide_link'] = $new_instance['hide_link'];
		$instance['item_link'] = $new_instance['item_link'];
		$instance['insta_title'] = $new_instance['insta_title'];
		if($old_instance['user_name'] != $new_instance['user_name'] || $old_instance['pics'] != $new_instance['pics'] ){
			delete_transient( $transient_name );
		}
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		
		$defaults = array( 'title' => 'Instagram Widget', 'insta_title' => '', 'item_link' => '1', 'pics' => '6', 'user_name' => get_theme_mod('malina_footer_instagram_user_name', ''), 'pics_per_row' => '3', 'hide_link' => '', 'hide_items' => '' ); // Default Values
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
        
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">Widget Title:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'user_name' )); ?>">Your instagram username:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'user_name' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'user_name' )); ?>" value="<?php echo esc_attr($instance['user_name']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'pics' )); ?>">Number of Items:</label>
			<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id( 'pics' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'pics' )); ?>" value="<?php echo esc_attr($instance['pics']); ?>" />
			<span class="description"><?php esc_html_e('Input number of items, max number is 20.','malina-elements'); ?></span>
		</p>
		<p>
		<?php 
			$selected2 = '';
			$selected3 = '';
			$selected4 = '';
			$selected5 = '';
			$selected6 = '';
			if(isset($instance['pics_per_row'])){
				switch ($instance['pics_per_row']) {
					case '1':
						$selected6 = 'selected="selected"';
						break;
					case '2':
						$selected2 = 'selected="selected"';
						break;
					case '3':
						$selected3 = 'selected="selected"';
						break;
					case '4':
						$selected4 = 'selected="selected"';
						break;
					case '6':
						$selected5 = 'selected="selected"';
						break;
				}
			} ?>
			<label for="<?php echo esc_attr($this->get_field_id( 'pics_per_row' )); ?>">Items per row:</label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'pics_per_row' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'pics_per_row' )); ?>">
				<option value="1" <?php echo esc_attr($selected6); ?>>One item per row</option>
				<option value="2" <?php echo esc_attr($selected2); ?>>Two items per row</option>
				<option value="3" <?php echo esc_attr($selected3); ?>>Three items per row</option>
				<option value="4" <?php echo esc_attr($selected4); ?>>Four items per row</option>
				<option value="6" <?php echo esc_attr($selected5); ?>>Six items per row</option>
			</select>
		</p>
		<p>
		<?php 
			$selected1 = '';
			$selected2 = '';
			if(isset($instance['item_link'])){
				switch ($instance['item_link']) {
					case '1':
						$selected1 = 'selected="selected"';
						break;
					case '2':
						$selected2 = 'selected="selected"';
						break;
				}
			} ?>
			<label for="<?php echo esc_attr($this->get_field_id( 'item_link' )); ?>">Link image to:</label>
			<select class="widefat" id="<?php echo esc_attr($this->get_field_id( 'item_link' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'item_link' )); ?>">
				<option value="1" <?php echo esc_attr($selected1); ?>>Lightbox</option>
				<option value="2" <?php echo esc_attr($selected2); ?>>Link to instagram</option>
			</select>
		</p>
    <?php }
}
// Add Widget
function malina_widget_instagram_init() {
	register_widget('malina_widget_instagram');
}
add_action('widgets_init', 'malina_widget_instagram_init');
?>