<?php
// Create multi dropdown param type
vc_add_shortcode_param( 'dropdown_multi', 'dropdown_multi_settings_field' );
function dropdown_multi_settings_field( $param, $value ) {

    $param_line = '';
    $param_line .= '<select multiple name="'. esc_attr( $param['param_name'] ).'" class="wpb_vc_param_value wpb-input wpb-select '. esc_attr( $param['param_name'] ).' '. esc_attr($param['type']).'">';
    foreach ( $param['value'] as $text_val => $val ) {
        if ( is_numeric($text_val) && (is_string($val) || is_numeric($val)) ) {
            $text_val = $val;
        }
        $text_val = __($text_val, "js_composer");
        $selected = '';

        if(!is_array($value)) {
            $param_value_arr = explode(',',$value);
        } else {
            $param_value_arr = $value;
        }

        if ($value!=='' && in_array($val, $param_value_arr)) {
            $selected = ' selected="selected"';
        }
        $param_line .= '<option class="'.$val.'" value="'.$val.'"'.$selected.'>'.$text_val.'</option>';
    }
    $param_line .= '</select>';

    return  $param_line;
}
function postIdAutocompleteSuggester( $query ) {
	$args = array(
		'post_type' => 'post',
		's' => stripslashes( $query ),
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'order'          => 'ASC',
		'orderby'        => 'title'
	);
	$results = array();
	$items = get_posts( $args );
	if( !empty($items) ){
		foreach( $items as $post ){ 
			setup_postdata($post);
			$id = $post->ID;
			$title = $post->post_title;
			$data = array();
			$data['value'] = $id;
			$data['label'] = $title;
			$results[] = $data;
		}
	} 
	wp_reset_postdata();
	return $results;
}
add_filter( 'vc_autocomplete_singlepost_post_ids_callback', 'postIdAutocompleteSuggester', 10, 1 );
add_filter( 'vc_autocomplete_post_slider_post_ids_callback', 'postIdAutocompleteSuggester', 10, 1 );
add_filter( 'vc_autocomplete_gridposts_post_ids_callback', 'postIdAutocompleteSuggester', 10, 1 );
add_filter( 'vc_autocomplete_gridposts_post__not_in_callback', 'postIdAutocompleteSuggester', 10, 1 );
add_filter( 'vc_autocomplete_carouselposts_post__not_in_callback', 'postIdAutocompleteSuggester', 10, 1 );

function postIdAutocompleteRender( $query ) {
	$query = trim( $query['value'] ); // get value from requested
	if ( ! empty( $query ) ) {
		$post_object = get_post( (int) $query );
		if ( is_object( $post_object ) ) {
			$post_title = $post_object->post_title;
			$post_id = $post_object->ID;
			$data = array();
			$data['value'] = $post_id;
			$data['label'] = $post_title;
			return ! empty( $data ) ? $data : false;
		}
		return false;
	}
	return false;
}
add_filter( 'vc_autocomplete_singlepost_post_ids_render', 'postIdAutocompleteRender', 10, 1 );
add_filter( 'vc_autocomplete_post_slider_post_ids_render', 'postIdAutocompleteRender', 10, 1 );
add_filter( 'vc_autocomplete_gridposts_post_ids_render', 'postIdAutocompleteRender', 10, 1 );
add_filter( 'vc_autocomplete_gridposts_post__not_in_render', 'postIdAutocompleteRender', 10, 1 );
add_filter( 'vc_autocomplete_carouselposts_post__not_in_render', 'postIdAutocompleteRender', 10, 1 );

add_action( 'init', 'malina_elements_vc_shortcodes' );
function malina_elements_vc_shortcodes() {
	$imageSizes = get_intermediate_image_sizes();
	$imageSizes[]= 'full';
	$suf = rand(0, 9999);
    vc_add_shortcode_param( 'hidden_id', 'malina_hidden_id_settings_field' );
	function malina_hidden_id_settings_field( $settings, $value ) {
	   return '<div class="hidden_id_param_block" style="display:none;">'
	             .'<input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value wpb-textinput ' .
	             esc_attr( $settings['param_name'] ) . ' ' .
	             esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" />' .
	             '</div>'; // This is html markup that will be outputted in content elements edit form
	}
	$text_transform = array(
		esc_html__('Default', 'malina-elements' ) => 'default',
		esc_html__('Uppercase', 'malina-elements' ) => 'uppercase',
		esc_html__('Lowercase', 'malina-elements' ) => 'lowercase',
		esc_html__('Capitalize', 'malina-elements' ) => 'capitalize'
	);
	vc_map( 
		array(
			"name" => __("Malina Posts Slider", 'malina-elements'),
			"base" => "post_slider",
			"icon" => 'malina-element-icon dashicons dashicons-slides',
			"category" => __('Malina Elements', 'malina-elements'),
			'front_enqueue_js' => array(MALINA_PLUGIN_URL.'js/owl.carousel.min.js'),
			'description' => __('Slider with your posts', 'malina-elements'),
			"params" => array(
				array(
					"type" => "textfield",            
					"heading" => __("Block title", 'malina-elements'),
					"param_name" => "block_title",
					"value" => '',
					'admin_label' => true,
					"description" => __("Enter block title. Leave blank to hide.", 'malina-elements')            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Block title size", 'malina-elements'),
					"param_name" => "block_title_size",
					"value" => array(
					   __('H1', 'malina-elements')=>'h1', 
					   __('H2', 'malina-elements')=>'h2',
					   __('H3', 'malina-elements')=>'h3',
					   __('H4', 'malina-elements')=>'h4',
					   __('H5', 'malina-elements')=>'h5',
					   __('H6', 'malina-elements')=>'h6',
					),
					"description" => __('Select title size', 'malina-elements'),
					"std" => array('h4')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Autoplay", 'malina-elements'),
					"param_name" => "slideshow",
					"value" => array(
					   __('Enable', 'malina-elements')=>'true',
					   __('Disable', 'malina-elements')=>'false',
					),
					"description" => __("Disable or Enable Autoplay.", 'malina-elements'),
					"std" => array('true')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Scroll on mousewheel", 'malina-elements'),
					"param_name" => "mousewheel",
					"value" => array(
					   __('Yes', 'malina-elements')=>'true',
					   __('No', 'malina-elements')=>'false',
					),
					"description" => __("Move items on mousewheel", 'malina-elements'),
					"std" => array('false')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Loop", 'malina-elements'),
					"param_name" => "loop",
					"value" => array(
					   __('Enable', 'malina-elements')=>'true',
					   __('Disable', 'malina-elements')=>'false',
					),
					"description" => __("If you want to have continuous slider, please select enable", 'malina-elements'),
					"std" => array('false')
				),		
				array(
					"type" => "textfield",            
					"heading" => __("Slider count", 'malina-elements'),
					"param_name" => "number_posts",
					"value" => '3',
					'admin_label' => true,
					"description" => __("Enter number of slides to display (Note: Enter '-1' to display all slides).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Category slug", 'malina-elements'),
					"param_name" => "cat_slug",
					"value" => '',
					"description" => __("This help you to retrieve items from specific category. More than one separate by commas.", 'malina-elements')
				),
				array(
					"type" => "autocomplete",            
					"heading" => __("Select posts", 'malina-elements'),
					"param_name" => "post_ids",
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
						'unique_values' => true,
					),
					'save_always' => true
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Order by", 'malina-elements'),
					"param_name" => "orderby",
					"value" => array(
					   __('Date', 'malina-elements')=>'date', 
					   __('Last modified date', 'malina-elements') => 'modified',
					   __('Popularity', 'malina-elements')=>'comment_count',
					   __('Title', 'malina-elements')=>'title',
					   __('Random', 'malina-elements')=>'rand',
					   __('Preserve post ID order', 'malina-elements') => 'post__in',
					),
					"description" => __('Select how to sort retrieved posts.', 'malina-elements'),
					"std" => array('date')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Sort order", 'malina-elements'),
					"param_name" => "order",
					"value" => array(
					   __('Descending', 'malina-elements')=>'DESC', 
					   __('Ascending', 'malina-elements')=>'ASC'
					),
					"description" => __('Select ascending or descending order.', 'malina-elements'),
					"std" => array('DESC')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Image size", 'malina-elements'),
					"param_name" => "thumbsize",
					"value" => $imageSizes,
					"description" => __('Select your image size to use in slider.', 'malina-elements'),
					"std" => array('large')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Slider Style", 'malina-elements'),
					"param_name" => "style",
					"value" => array(
					   __('Centered', 'malina-elements')=>'center',
					   __('Two Centered', 'malina-elements')=>'center2',
					   __('Simple', 'malina-elements')=>'simple',
					   __('Two in row', 'malina-elements') => 'two_per_row',
					   __('Three in row', 'malina-elements') => 'three_per_row',
					),
					"std" => array('simple')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Description Style", 'malina-elements'),
					"param_name" => "description_style",
					"value" => array(
					   __('Style 1', 'malina-elements')=>'style_1',
					   __('Style 2', 'malina-elements') => 'style_2',
					   __('Style 3', 'malina-elements') => 'style_3',
					   __('Style 4', 'malina-elements') => 'style_4',
					   __('Style 5', 'malina-elements') => 'style_5',
					   __('Style 6', 'malina-elements') => 'style_6',
					   __('Style 7', 'malina-elements') => 'style_6',
					),
					"std" => array('style_1')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Navigation arrows", 'malina-elements'),
					'description' => __('Display navigation arrows.', 'malina-elements'),
					"param_name" => "nav",
					"value" => array(
					   __('Show', 'malina-elements') => 'true',
					   __('Hide', 'malina-elements') => 'false',
					),
					"std" => array('true')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Navigation dots", 'malina-elements'),
					'description' => __('Display navigation dots.', 'malina-elements'),
					"param_name" => "show_dots",
					"value" => array(
					   __('Show', 'malina-elements') => 'true',
					   __('Hide', 'malina-elements') => 'false',
					),
					"std" => array('true')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Overlay", 'malina-elements'),
					'description' => __('Display overlay on image. Your image with displays with some saturation.', 'malina-elements'),
					"param_name" => "overlay",
					"value" => array(
					   __('Show', 'malina-elements') => 'true',
					   __('Hide', 'malina-elements') => 'false',
					),
					"std" => array('true')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Show meta categories?", 'malina-elements'),
					"param_name" => "show_categories",
					"value" => array(
					   __('Show', 'malina-elements') => 'true',
					   __('Hide', 'malina-elements') => 'false',
					),
					"std" => array(true)
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Show date?", 'malina-elements'),
					"param_name" => "show_date",
					"value" => array(
					   __('Show', 'malina-elements') => 'true',
					   __('Hide', 'malina-elements') => 'false',
					),
					"std" => array('true')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Slider width", 'malina-elements'),
					"param_name" => "slider_width",
					"value" => array(
					   __('Fullwidth', 'malina-elements') => 'fullwidth',
					   __('Standard', 'malina-elements') => 'standard',
					),
					"std" => array('standard')
				),
			)
		)
	);
	vc_map( 
		array(
			"name" => __("Malina Recent Posts", 'malina-elements'),
			"base" => "gridposts",
			"icon" => 'malina-element-icon dashicons dashicons-layout',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Show WP posts in grid.', 'malina-elements'),
			"params" => array(
				array(
					"type" => "textfield",            
					"heading" => __("Block title", 'malina-elements'),
					"param_name" => "block_title",
					"value" => '',
					'admin_label' => true,
					"description" => __("Enter block title. Leave blank to hide.", 'malina-elements')            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Block title size", 'malina-elements'),
					"param_name" => "block_title_size",
					"value" => array(
					   __('H1', 'malina-elements')=>'h1', 
					   __('H2', 'malina-elements')=>'h2',
					   __('H3', 'malina-elements')=>'h3',
					   __('H4', 'malina-elements')=>'h4',
					   __('H5', 'malina-elements')=>'h5',
					   __('H6', 'malina-elements')=>'h6',
					),
					"description" => __('Select title size', 'malina-elements'),
					"std" => array('h4')
				),	
				array(
					"type" => "textfield",            
					"heading" => __("Post count", 'malina-elements'),
					"param_name" => "num",
					"value" => '6',
					'admin_label' => true,
					"description" => __("Enter number of posts to display (Note: Enter '-1' to display all posts).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Load more posts count", 'malina-elements'),
					"param_name" => "load_count",
					"value" => '',
					"description" => __("Enter number of posts to load (leave balnk to use the same value as per page).", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Posts offset", 'malina-elements'),
					"param_name" => "offset",
					"value" => '0',
					"description" => __("Enter the number of posts to offset before retrieval.", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Category slug", 'malina-elements'),
					"param_name" => "cat_slug",
					"value" => '',
					"description" => __("This help you to retrieve items from specific category. More than one separate by commas.", 'malina-elements')
				),
				array(
					"type" => "autocomplete",            
					"heading" => __("Select posts to show", 'malina-elements'),
					"param_name" => "post_ids",
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
						'unique_values' => true,
					),
					'save_always' => true
				),
				array(
					"type" => "autocomplete",            
					"heading" => __("Select posts to exclude", 'malina-elements'),
					"param_name" => "post__not_in",
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
						'unique_values' => true,
					),
					'save_always' => true,
					"description" => __("Select posts to exclude those records.", 'malina-elements')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Order by", 'malina-elements'),
					"param_name" => "orderby",
					"value" => array(
					   __('Date', 'malina-elements')=>'date', 
					   __('Last modified date', 'malina-elements') => 'modified',
					   __('Popularity', 'malina-elements')=>'comment_count',
					   __('Title', 'malina-elements')=>'title',
					   __('Random', 'malina-elements')=>'rand',
					   __('Preserve post ID order', 'malina-elements') => 'post__in',
					),
					"description" => __('Select how to sort retrieved posts.', 'malina-elements'),
					"std" => array('date')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Sort order", 'malina-elements'),
					"param_name" => "order",
					"value" => array(
					   __('Descending', 'malina-elements')=>'DESC', 
					   __('Ascending', 'malina-elements')=>'ASC'
					),
					"description" => __('Select ascending or descending order.', 'malina-elements'),
					"std" => array('DESC')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Post view style", 'malina-elements'),
					"param_name" => "post_style",
					"value" => array(
					   __('Simple', 'malina-elements')=>'style_1',
					   __('Featured','malina-elements') => 'style_2', 
					   __('Featured even/odd', 'malina-elements')=>'style_3',
					   __('Masonry', 'malina-elements')=>'style_4',
					   __('List', 'malina-elements') => 'style_5',
					   __('List 2', 'malina-elements') => 'style_5_2',
					   __('Sono', 'malina-elements') => 'style_6',
					   __('EditorPicks', 'malina-elements') => 'style_7',
					   __('Walnuss', 'malina-elements') => 'style_8',
					   __('Sticky style', 'malina-elements') => 'style_9',
					   __('Boxed', 'malina-elements') => 'style_10'
					),
					"description" => __('Select posts style on preview.', 'malina-elements'),
					"std" => array('style_1')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Posts per row", 'malina-elements'),
					"param_name" => "columns",
					"value" => array(
					   __('Two', 'malina-elements')=>'span6',
					   __('Three', 'malina-elements')=>'span4',
					   __('Four', 'malina-elements')=>'span3',
					   __('Five', 'malina-elements')=>'one_fifth',
					   __('Six', 'malina-elements')=>'span2',
					),
					"description" => __("Select posts count per row.", 'malina-elements'),
					"std" => array('span4'),
					"dependency" => array(
				        "element" => "post_style",
				        "value" => array('style_1', 'style_4')
				    )
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Thumbnail size", 'malina-elements'),
					"param_name" => "thumbsize",
					"value" => $imageSizes,
					"description" => __('Select your image size to use.', 'malina-elements'),
					"std" => array('medium')
				),
				array(
					"type" => "textfield",            
					"heading" => __("Post excerpt count", 'malina-elements'),
					"param_name" => "excerpt_count",
					"value" => '15',
					"description" => __("Enter number of words in post excerpt. 0 to hide it.", 'malina-elements')            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Align elements", 'malina-elements'),
					"param_name" => "text_align",
					"value" => array(
					   __('Left', 'malina-elements')=>'textleft',
					   __('Center', 'malina-elements')=>'textcenter',
					   __('Right', 'malina-elements')=>'textright'
					),
					"description" => __("Select position for text, meta info, categories, etc.", 'malina-elements'),
					"std" => array('textcenter')
				),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Display categories?", 'malina-elements'),
		            "param_name" => "display_categories",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "description" => __('Show categories above the title?', 'malina-elements'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Display time reading?", 'malina-elements'),
		            "param_name" => "display_read_time",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "description" => __('Show estimate time to read the post?', 'malina-elements'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Display comments count?", 'malina-elements'),
		            "param_name" => "display_comments",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "description" => __('Show comments count in meta?', 'malina-elements'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Display date label?", 'malina-elements'),
		            "param_name" => "display_date",
		            "value" => array(__('Show','malina-elements')=>'true', __('Show on hover','malina-elements')=>'hover', __('Hide', 'malina-elements')=>'false'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Display views?", 'malina-elements'),
		            "param_name" => "display_views",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Display likes?", 'malina-elements'),
		            "param_name" => "display_likes",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "std" => array('true')
		        ),
				array(
		            "type" => "dropdown",            
		            "heading" => __("Pagination", 'malina-elements'),
		            "param_name" => "pagination",
		            "value" => array(
		            	__('Load more','malina-elements')=>'true',
		            	__('Standard','malina-elements')=>'standard',
		            	__('Next/prev', 'malina-elements')=>'next_prev',
		            	__('Infinite scroll','malina-elements')=>'infinitescroll',
		            	__('Disable', 'malina-elements')=>'false'
		            ),
		            "description" => __('Select pagination for posts.', 'malina-elements'),
		            "std" => array('false')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Disable featured posts style", 'malina-elements'),
		            "param_name" => "ignore_featured",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "description" => __('Disable style for featured posts. Do not highlight them.', 'malina-elements'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Ignore sticky posts", 'malina-elements'),
		            "param_name" => "ignore_sticky_posts",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "description" => __('Show sticky posts?', 'malina-elements'),
		            "std" => array('false')
		        ),
			)
		)
	);
	vc_map( 
		array(
			"name" => __("Malina Carousel Posts", 'malina-elements'),
			"base" => "carouselposts",
			"icon" => 'malina-element-icon dashicons dashicons-leftright',
			'front_enqueue_js' => array(MALINA_PLUGIN_URL.'js/owl.carousel.min.js'),
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Show WP posts in grid.', 'malina-elements'),
			"params" => array(
				array(
					"type" => "textfield",            
					"heading" => __("Posts block title", 'malina-elements'),
					"param_name" => "block_title",
					"value" => '',
					'admin_label' => true,
					"description" => __("Enter posts block title e.g. 'Latest posts'. Leave blank if you need not to display it.", 'malina-elements')            
				),		
				array(
					"type" => "textfield",            
					"heading" => __("Post count", 'malina-elements'),
					"param_name" => 'posts_count',
					"value" => '3',
					"description" => __("Enter number of posts to display (Note: Enter '-1' to display all posts).", 'malina-elements')            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Posts per view", 'malina-elements'),
					"param_name" => "columns",
					"value" => array(
					   __('Two per view', 'malina-elements')=>'span6',
					   __('Three per view', 'malina-elements')=>'span4',
					   __('Four per view', 'malina-elements')=>'span3',
					   __('Five per view', 'malina-elements')=>'one_fifth',
					   __('Six per view', 'malina-elements')=>'span2',
					),
					"description" => __("Select posts count per view.", 'malina-elements'),
					"std" => array('one_fifth')
				),
				array(
					"type" => "textfield",            
					"heading" => __("Category slug", 'malina-elements'),
					"param_name" => "cat_slug",
					"value" => '',
					"description" => __("This help you to retrieve items from specific category. More than one separate by commas.", 'malina-elements')
				),
				array(
					"type" => "textfield",            
					"heading" => __("Select posts to show", 'malina-elements'),
					"param_name" => "post_ids",
					'settings' => array(
						'multiple' => true,
						'sortable' => true,
						'unique_values' => true,
					),
					'save_always' => true,
					"description" => __("Search posts by title.", 'malina-elements')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Order by", 'malina-elements'),
					"param_name" => "orderby",
					"value" => array(
					   __('Date', 'malina-elements')=>'date', 
					   __('Last modified date', 'malina-elements') => 'modified',
					   __('Popularity', 'malina-elements')=>'comment_count',
					   __('Title', 'malina-elements')=>'title',
					   __('Random', 'malina-elements')=>'rand',
					   __('Preserve post ID order', 'malina-elements') => 'post__in',
					),
					"description" => __('Select how to sort retrieved posts.', 'malina-elements'),
					"std" => array('date')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Sort order", 'malina-elements'),
					"param_name" => "order",
					"value" => array(
					   __('Descending', 'malina-elements')=>'DESC', 
					   __('Ascending', 'malina-elements')=>'ASC'
					),
					"description" => __('Select ascending or descending order.', 'malina-elements'),
					"std" => array('DESC')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Thumbnail size", 'malina-elements'),
					"param_name" => "thumbsize",
					"value" => $imageSizes,
					"description" => __('Select your image size to use.', 'malina-elements'),
					"std" => array('medium')
				),
			)
		)
	);
	vc_map( 
		array(
			"name" => __("Malina Single Posts", 'malina-elements'),
			"base" => "singlepost",
			"icon" => 'malina-element-icon dashicons dashicons-megaphone',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Show WP post. Just input post ID. You can find post ID in browser address bar while editing post.', 'malina-elements'),
			"params" => array(		
				array(
					"type" => "autocomplete",            
					"heading" => __("Select post to show", 'malina-elements'),
					"param_name" => "post_ids",
					"value" => '',
					"description" => __("Enter posts ID to display only those record.", 'malina-elements')
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Thumbnail size", 'malina-elements'),
					"param_name" => "thumbsize",
					"value" => $imageSizes,
					"description" => __('Select your image size to use.', 'malina-elements'),
					"std" => array('post-thumbnail')
				),
				array(
		            "type" => "dropdown",            
		            "heading" => __("Show categories?", 'malina-elements'),
		            "param_name" => "show_categories",
		            "value" => array(__('Yes','malina-elements')=>'true', __('No', 'malina-elements')=>'false'),
		            "description" => __('Show categories above the title?', 'malina-elements'),
		            "std" => array('true')
		        ),
			)
		)
	);
	/*vc_map( 
		array(
			"name" => __("Malina Footer", 'malina-elements'),
			"base" => "malinafooter",
			"icon" => 'malina-element-icon dashicons dashicons-align-center',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Show page footer.', 'malina-elements'),
			"params" => array(		
				array(
					"type" => "colorpicker",            
					"heading" => __("Custom footer background", 'malina-elements'),
					"param_name" => "bg_color",
					"value" => ''
				)
			)
		)
	);*/
	vc_map( 
		array(
			"name" => __("Malina Socials", 'malina-elements'),
			"base" => "malinasocials",
			"icon" => 'malina-element-icon dashicons dashicons-networking',
			"category" => array(__('Malina Elements', 'malina-elements') ),
			'description' => __('Show social icons: facebook, twitter, pinterest, etc.', 'malina-elements'),
			"params" => array(	
				array(
					"type" => "dropdown",            
					"heading" => __("Icons Links", 'malina-elements'),
					"param_name" => "default_links",
					"value" => array(__('From theme options','malina-elements')=>'true', __('Custom links', 'malina-elements')=>'false'),
					"std" => array('true')           
				),	
				array(
					"type" => "textfield",            
					"heading" => __("Facebook", 'malina-elements'),
					"param_name" => "facebook",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Twitter", 'malina-elements'),
					"param_name" => "twitter",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Pinterest", 'malina-elements'),
					"param_name" => "pinterest",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Instagram", 'malina-elements'),
					"param_name" => "instagram",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements') ,
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )           
				),
				array(
					"type" => "textfield",            
					"heading" => __("Tumblr", 'malina-elements'),
					"param_name" => "tumblr",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Forrst", 'malina-elements'),
					"param_name" => "forrst",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Flickr", 'malina-elements'),
					"param_name" => "flickr",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Dribbble", 'malina-elements'),
					"param_name" => "dribbble",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Skype", 'malina-elements'),
					"param_name" => "skype",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Digg", 'malina-elements'),
					"param_name" => "digg",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Google plus", 'malina-elements'),
					"param_name" => "google_plus",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Linkedin", 'malina-elements'),
					"param_name" => "linkedin",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Vimeo", 'malina-elements'),
					"param_name" => "vimeo",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Yahoo", 'malina-elements'),
					"param_name" => "yahoo",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Youtube", 'malina-elements'),
					"param_name" => "youtube",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Picasa", 'malina-elements'),
					"param_name" => "picasa",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Deviantart", 'malina-elements'),
					"param_name" => "deviantart",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Behance", 'malina-elements'),
					"param_name" => "behance",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("PayPal", 'malina-elements'),
					"param_name" => "Paypal",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Delicious", 'malina-elements'),
					"param_name" => "delicious",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to your account (profile).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Rss", 'malina-elements'),
					"param_name" => "rss",
					'admin_label' => true,
					"value" => '',
					"description" => __("Enter link to rss.", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_links",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Icons style", 'malina-elements'),
					"param_name" => "style",
					"value" => array(
					   __('Simple', 'malina-elements')=>'simple',
					   __('Simple + Text', 'malina-elements')=>'simple_text',
					   __('Circle', 'malina-elements')=>'circle',
					   __('Square', 'malina-elements')=>'square'
					),
					"std" => array('simple')
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Icon background color", 'malina-elements'),
					"param_name" => "bg_color",
					"value" => '',
					"description" => __("Leave empty to use default color.", 'malina-elements'),
					"dependency" => array(
				        "element" => "style",
				        "value" => array('circle', 'square')
				    )        
				),	
				array(
					"type" => "colorpicker",            
					"heading" => __("Icon color initial", 'malina-elements'),
					"param_name" => "icon_color",
					"value" => '',
					"description" => __("Leave empty to use default color.", 'malina-elements'),       
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Icon color hover", 'malina-elements'),
					"param_name" => "icon_color_hover",
					"value" => '',
					"description" => __("Leave empty to use default color.", 'malina-elements'),       
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Icon background color hover", 'malina-elements'),
					"param_name" => "bg_color_hover",
					"value" => '',
					"description" => __("Leave empty to use default color.", 'malina-elements'),
					"dependency" => array(
				        "element" => "style",
				        "value" => array('circle', 'square')
				    )        
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Text color", 'malina-elements'),
					"param_name" => "text_color",
					"value" => '',
					"description" => __("Leave empty to use default color.", 'malina-elements'),       
				),
				array(
					"type" => "hidden_id",            
					"heading" => '',
					"param_name" => "id",
					"value" => $suf,
					"description" => ''            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Icons align", 'malina-elements'),
					"param_name" => "icons_align",
					"value" => array(
					   __('Center', 'malina-elements') => 'textcenter',
					   __('Right', 'malina-elements') => 'textright',
					   __('Left', 'malina-elements') => 'textleft',
					),
					"std" => array('textcenter')
				),
			)
		)
	);
	vc_map( 
		array(
			"name" => __("Malina User Info", 'malina-elements'),
			"base" => "malinauser",
			"icon" => 'malina-element-icon dashicons dashicons-admin-users',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Show user information.', 'malina-elements'),
			"params" => array(		
				array(
					"type" => "textfield",            
					"heading" => __("Username", 'malina-elements'),
					"param_name" => "username",
					"value" => '',
					'admin_label' => true,
					"description" => __("Enter username parameter to display information.", 'malina-elements')            
				),
			)
		)
	);
	$menus_list = array();
	$menus_list['none'] = __('Default', 'malina-elements');
	$menus = get_terms('nav_menu');
	if( !empty($menus) ){
		foreach($menus as $menu){
		  $menus_list[$menu->term_id] = $menu->name;
		}
	}
	vc_map( 
		array(
			"name" => __("Malina Menu", 'malina-elements'),
			"base" => "malinamenu",
			"icon" => 'malina-element-icon dashicons dashicons-menu',
			"category" => array( __('Malina Header', 'malina-elements'), __('Malina Footer', 'malina-elements') ), 
			'description' => __('Show your header menu.', 'malina-elements'),
			"params" => array(
				array(
					"type" => "dropdown",            
					"heading" => __("Menu place", 'malina-elements'),
					"param_name" => "menu_place",
					"value" => array(
					   __('Header', 'malina-elements') => 'header',
					   __('Footer', 'malina-elements') => 'footer',
					),
					"std" => array('header'),
					"description" => __("Select place where do you want to insert menu.", 'malina-elements')            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Use default theme font", 'malina-elements'),
					"param_name" => "default_font",
					"value" => array(
					   __('Yes', 'malina-elements') => 'true',
					   __('No', 'malina-elements') => 'false',
					),
					"std" => array('true'),
					"description" => __("Leave blank to use your default menu font.", 'malina-elements')            
				),
				array(
					'type' => 'google_fonts',
					'param_name' => 'menu_font',
					'value' => '',
					'settings' => array(
						'fields' => array(
							'font_family' => 'Montserrat:regular,italic',
							'font_family_description' => __( 'Select font family.', 'malina-elements' ),
							'font_style_description' => __( 'Select font styling.', 'malina-elements' ),
						),
					),
					"dependency" => array(
				        "element" => "default_font",
				        "value" => "false"
				    )
				),
				array(
					"type" => "textfield",            
					"heading" => __("Menu font size", 'malina-elements'),
					"param_name" => "menu_font_size",
					"value" => '12',
					"description" => __("Enter value in px. Do not set (px).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_font",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Menu text transform", 'malina-elements'),
					"param_name" => "menu_text_transform",
					"value" => $text_transform,
					"description" => __("Select text transform.", 'malina-elements'),
					"std" => array('uppercase'),
					"dependency" => array(
				        "element" => "default_font",
				        "value" => 'false'
				    )           
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Menu item color (initial)", 'malina-elements'),
					"param_name" => "menu_items_color_initial",
					"value" => '',
					"dependency" => array(
				        "element" => "default_font",
				        "value" => 'false'
				    )            
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Menu item color (hover)", 'malina-elements'),
					"param_name" => "menu_items_color_hover",
					"value" => '',
					"dependency" => array(
				        "element" => "default_font",
				        "value" => 'false'
				    )           
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Menu position", 'malina-elements'),
					"param_name" => "menu_position",
					"value" => array(
					   __('Right', 'malina-elements') => 'flexright',
					   __('Center', 'malina-elements') => 'flexcenter',
					   __('Left', 'malina-elements') => 'flexleft',
					),
					"std" => array('flex-end'),           
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Enable search icon?", 'malina-elements'),
					"param_name" => "enable_search",
					"value" => array(
					   __('Yes', 'malina-elements') => 'true',
					   __('No', 'malina-elements') => 'false',
					),
					"std" => array('true'),
					"description" => __("Enable search icon to show at the end of the menu.", 'malina-elements') ,
					"dependency" => array(
				        "element" => "menu_place",
				        "value" => "header"
				    )           
				),
				array(
					"type" => "hidden_id",            
					"heading" => '',
					"param_name" => "id",
					"value" => $suf,
					"description" => ''            
				),
			)
		)
	);
	vc_map( 
		array(
			"name" => __("Malina Logo", 'malina-elements'),
			"base" => "malinalogo",
			"icon" => 'malina-element-icon dashicons dashicons-admin-home',
			"category" => array(__('Malina Footer', 'malina-elements'), __('Malina Header', 'malina-elements')),
			'description' => __('Show your site logo.', 'malina-elements'),
			"params" => array(
				array(
					"type" => "textfield",            
					"heading" => __("Text logo", 'malina-elements'),
					"param_name" => "text_logo",
					"value" => '',
					"description" => __("Leave blank to use your default logo.", 'malina-elements')            
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Use default theme settings", 'malina-elements'),
					"param_name" => "default_font",
					"value" => array(
					   __('Yes', 'malina-elements') => 'true',
					   __('No', 'malina-elements') => 'false',
					),
					"std" => array('true'),
					"description" => __("Leave blank to use your default logo font.", 'malina-elements')            
				),
				array(
					'type' => 'google_fonts',
					'param_name' => 'logo_font',
					'value' => '',
					'settings' => array(
						'fields' => array(
							'font_family' => 'Montserrat:regular',
							'font_family_description' => __( 'Select font family.', 'malina-elements' ),
							'font_style_description' => __( 'Select font styling.', 'malina-elements' ),
						),
					),
					"dependency" => array(
				        "element" => "default_font",
				        "value" => "false"
				    )
				),
				array(
					"type" => "textfield",            
					"heading" => __("Logo font size", 'malina-elements'),
					"param_name" => "logo_font_size",
					"value" => '',
					"description" => __("Enter value in px. Do not set (px).", 'malina-elements'),
					"dependency" => array(
				        "element" => "default_font",
				        "value" => 'false'
				    )            
				),		
				array(
					"type" => "attach_image",            
					"heading" => __("Image logo", 'malina-elements'),
					"param_name" => "custom_logo",
					"value" => '',
					"description" => __("Leave blank to use your default logo.", 'malina-elements')          
				),
				array(
					"type" => "textfield",            
					"heading" => __("Logo image width", 'malina-elements'),
					"param_name" => "logo_width",
					"value" => '',
					"description" => __("Enter value, you can use px, %, em, etc.", 'malina-elements'),           
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Logo align", 'malina-elements'),
					"param_name" => "logo_align",
					"value" => array(
					   __('Right', 'malina-elements') => 'textright',
					   __('Center', 'malina-elements') => 'textcenter',
					   __('Left', 'malina-elements') => 'textleft',
					),
					"std" => array('textcenter'),           
				),
				array(
					"type" => "hidden_id",            
					"heading" => '',
					"param_name" => "id",
					"value" => $suf,
					"description" => ''            
				),
			)
		)
	);
	vc_map( 
		array(
			"name" => __("Malina Instagram", 'malina-elements'),
			"base" => "malinainstagram",
			"icon" => 'malina-element-icon dashicons dashicons-format-image',
			"category" => array( __('Malina Elements', 'malina-elements') ),
			'description' => __('Show your instagram feeds.', 'malina-elements'),
			"params" => array(		
				array(
					"type" => "textfield",            
					"heading" => __("Title", 'malina-elements'),
					"param_name" => "title",
					"value" => '',
					'admin_label' => true,
					"description" => __("Enter instagram block title.", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Access token", 'malina-elements'),
					"param_name" => "access_token",
					"value" => get_theme_mod('malina_footer_instagram_access_token', ''),
					'admin_label' => true,
					"description" => '<a target="_blank" href="https://www.instagram.com/oauth/authorize?app_id=423965861585747&redirect_uri=https://api.smashballoon.com/instagram-basic-display-redirect.php&response_type=code&scope=user_profile,user_media&state=https://malina.artstudioworks.net/auth/?">'.esc_html__('Get your Access Token','malina-elements').'</a>',            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Items count", 'malina-elements'),
					"description" => __('Max items count is 20.', 'malina-elements'),
					"param_name" => "pics",
					"value" => '4',
				),
				array(
					"type" => "dropdown",            
					"heading" => __("Items per row", 'malina-elements'),
					"param_name" => "pics_per_row",
					"value" => array(
					   __('One per row', 'malina-elements')=>'1',
					   __('Two row', 'malina-elements')=>'2',
					   __('Three per row', 'malina-elements')=>'3',
					   __('Four per row', 'malina-elements') => '4',
					   __('Six per row', 'malina-elements')=>'6',
					),
					"description" => __('Select items count per row', 'malina-elements'),
					"std" => array('4')
				),
				array(
		            "type" => "dropdown",            
		            "heading" => __("Follow link", 'malina-elements'),
		            "param_name" => "hide_link",
		            "value" => array(__('Hide','malina-elements')=>'true', __('Show', 'malina-elements')=>'false'),
		            "description" => __('Show or hide follow link', 'malina-elements'),
		            "std" => array('true')
		        ),
		        array(
		            "type" => "dropdown",            
		            "heading" => __("Link image to:", 'malina-elements'),
		            "param_name" => "item_link",
		            "value" => array(__('Lightbox','malina-elements')=>'1', __('Link to instagram', 'malina-elements')=>'2'),
		            "std" => array('1')
		        ),

			)
		)
	);
	$options = array();
	$options['Uncategorised'] = 'uncategorised';
    $query1 = get_terms( 'category', array('hide_empty' => false));
    if( $query1 ){
        foreach ( $query1 as $post ) {
            $options[ $post->name ] = $post->slug;
        }
    }
	vc_map( 
		array(
			"name" => __("Malina Category", 'malina-elements'),
			"base" => "malinacategory",
			"icon" => 'malina-element-icon dashicons dashicons-category',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Show special block with link to category.', 'malina-elements'),
			"params" => array(
				array(
		            "type" => "dropdown",            
		            "heading" => __("Category", 'malina-elements'),
		            "param_name" => "category",
		            "value" => $options,
		            "description" => __('Select category to show.', 'malina-elements'),
		            'admin_label' => true,
		        ),	
		        array(
					"type" => "hidden_id",            
					"heading" => '',
					"param_name" => "id",
					"value" => $suf,
					"description" => ''            
				),	
				array(
					"type" => "textfield",            
					"heading" => __("Button label", 'malina-elements'),
					"param_name" => "button_label",
					"value" => '',
					"description" => __("Enter button label, if empty label is equal to category name.", 'malina-elements')            
				),
				array(
					"type" => "textfield",            
					"heading" => __("Button url", 'malina-elements'),
					"param_name" => "button_url",
					"value" => '',
					"description" => __("Enter button url, if empty url is equal to category url.", 'malina-elements')            
				),
				array(
					"type" => "attach_image",            
					"heading" => __("Category image", 'malina-elements'),
					"param_name" => "bg_image_id",
					"value" => '',
					"description" => __("Select image for category block", 'malina-elements')          
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Button Border color", 'malina-elements'),
					"param_name" => "category_button_border_color",
					"value" => '',
					"description" => __("Leave empty to use default style.", 'malina-elements')          
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Button background color", 'malina-elements'),
					"param_name" => "category_button_bg_color",
					"value" => '',
					"description" => __("Leave empty to use default style.", 'malina-elements')          
				),
				array(
					"type" => "colorpicker",            
					"heading" => __("Button text color", 'malina-elements'),
					"param_name" => "category_button_text_color",
					"value" => '',
					"description" => __("Leave empty to use default style.", 'malina-elements')          
				)
			)
		)
	);
	$options2 = array();
	$options2['Uncategorised'] = 'uncategorised';
    $query1 = get_terms( 'category', array('hide_empty' => false));
    if( $query1 ){
        foreach ( $query1 as $post ) {
            $options2[ $post->name ] = $post->term_id;
        }
    }
	vc_map( 
		array(
			"name" => __("Malina Categories info", 'malina-elements'),
			"base" => "malinacatinfo",
			"icon" => 'malina-element-icon dashicons dashicons-category',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Display categories with posts count.', 'malina-elements'),
			"params" => array(
				array(
					"type" => "dropdown_multi",            
					"heading" => __("Categories", 'malina-elements'),
					"param_name" => "categories",
					"value" => $options,
					"description" => __("Select categories to show.", 'malina-elements'),
					'admin_label' => true,            
				),
			)
		)
	);
	vc_map( 
		array(
			"name" => __("Malina Team Member", 'malina-elements'),
			"base" => "malinateam",
			"icon" => 'malina-element-icon dashicons dashicons-admin-users',
			"category" => __('Malina Elements', 'malina-elements'),
			'description' => __('Show special block with link to category.', 'malina-elements'),
			"params" => array(	
				array(
					"type" => "textfield",            
					"heading" => __("Member Name", 'malina-elements'),
					"param_name" => "name",
					"value" => '',            
				),
				array(
					"type" => "attach_image",            
					"heading" => __("Member image", 'malina-elements'),
					"param_name" => "image_id",
					"value" => '',         
				),
				array(
					"type" => "textfield",            
					"heading" => __("Member position", 'malina-elements'),
					"param_name" => "position",
					"value" => '',          
				),
				array(
					"type" => "textfield",            
					"heading" => __("Member url", 'malina-elements'),
					"param_name" => "url",
					"value" => '',          
				),
			)
		)
	);
}
?>