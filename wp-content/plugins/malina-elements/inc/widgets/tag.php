<?php


class malina_widget_tag extends WP_Widget { 
	
	// Widget Settings
	public function __construct() {
		$widget_ops = array('description' => __('Display tag', 'malina-elements'), 'classname' => 'widget_category widget_tag' );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'tag' );
		parent::__construct( 'tag', __('malina-Tag', 'malina-elements'), $widget_ops, $control_ops );
		add_action('admin_enqueue_scripts', array($this, 'admin_setup'));
	}
	/**
	 * Enqueue all the javascript.
	 */
	public function admin_setup() {
		global $pagenow;

		wp_enqueue_media();
        wp_enqueue_script(
			'about-me-widget',
			MALINA_PLUGIN_URL.'js/about-me-widget.js',
			array(),
			1.0
		);

	}
	// Widget Output
	function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$category = $instance['category'];
		// ------
		echo ''.$before_widget;
		if ( $title !='' ) echo ''.$before_title . $title . $after_title;

		$catObj = get_term_by('slug', $category, 'post_tag' );
		if(!empty($catObj)){
		?>
			<div class="category">
				<?php if($instance['image']): ?>
				<div class="category-img">
					<?php if( $instance['image_id'] ){
						$image_tmp = wp_get_attachment_image_src($instance['image_id'], 'medium');
						$image_url = $image_tmp[0];
						$image_alt = get_post_meta($instance['image_id'], '_wp_attachment_image_alt', TRUE) ? get_post_meta($instance['image_id'], '_wp_attachment_image_alt', TRUE) : 'category-image';
						if($image_url){
							echo '<img src="'.esc_url($image_url).'" alt="'.esc_attr($image_alt).'">';
						}
					}?>
				</div>
				<?php endif; 

				echo '<a href="'.esc_url(get_category_link($catObj->term_id)).'" class="button category-button">'.$catObj->name.'</a>' 
				?>
			</div>

		<?php
		}
		echo ''.$after_widget;
		// ------
	}
	
	// Update
	function update( $new_instance, $old_instance ) {  
		$instance = $old_instance; 
		
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['category'] = sanitize_text_field($new_instance['category']);
		$instance['image'] = $new_instance['image'];
		$instance['image_id'] = $new_instance['image_id'];
		return $instance;
	}
	
	// Backend Form
	function form($instance) {
		
		$defaults = array('title' => '', 'image' => '', 'image_id' => '', 'category' => '');
		$instance = wp_parse_args((array) $instance, $defaults); 
		$catoptions = array();
	    $query1 = get_terms( 'post_tag', array('hide_empty' => false));
	    if( $query1 ){
	        foreach ( $query1 as $post ) {
	            $catoptions[ $post->slug ] = $post->name;
	        }
	    }
		?>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php _e('Tag Image:','malina-elements'); ?></label>
			<input type="text" class="widefat widget-image-input" id="<?php echo esc_attr($this->get_field_id('image')); ?>_media_url" name="<?php echo esc_attr($this->get_field_name('image')); ?>" value="<?php echo esc_attr($instance['image']); ?>" />
			<input type="hidden" class="widefat widget-image-id" id="<?php echo esc_attr($this->get_field_id('image')); ?>_media_id" name="<?php echo esc_attr($this->get_field_name('image_id')); ?>" value="<?php echo esc_attr($instance['image_id']); ?>" />
			<br><br>
			<a href="#" class="upload_image_button button button-pmalinary" id="<?php echo esc_attr($this->get_field_id('image')); ?>"><?php _e('Upload image', 'malina-elements'); ?></a>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('category')); ?>"><?php _e('Select tag:','malina-elements'); ?></label>
			<?php
            if(isset($instance['category'])) $category = $instance['category'];
            ?>
            <select class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">
                <?php
                $op = '<option value="%s"%s>%s</option>';
                foreach ($catoptions as $key=>$value ) {
                    if ($category === $key) {
                        printf($op, $key, ' selected="selected"', $value);
                    } else {
                        printf($op, $key, '', $value);
                    }
                }
                ?>
            </select>
		</p>
		
    <?php }
}

// Add Widget
function malina_widget_tag_init() {
	register_widget('malina_widget_tag');
}
add_action('widgets_init', 'malina_widget_tag_init');

?>