<?php

add_action('init', 'malina_post_type_header');
function malina_post_type_header() {
	$labels = array(
		'name' => __( 'Malina Headers', 'malina-elements' ),
		'singular_name' => __( 'Malina Header', 'malina-elements' ),
		'add_new' => __( 'Add New Header', 'malina-elements' ),
		'add_new_item' => __( 'Add New Header Item', 'malina-elements' ),
		'edit_item' => __( 'Edit Header Item', 'malina-elements' ),
		'new_item' => __( 'Add New Header Item', 'malina-elements' ),
		'view_item' => __( 'View Header', 'malina-elements' ),
		'search_items' => __( 'Search Header', 'malina-elements' ),
		'not_found' => __( 'No headers found', 'malina-elements' ),
		'not_found_in_trash' => __( 'No headers found in trash', 'malina-elements' )
	);
	register_post_type( 'malina-header',
        array( 
        'menu_icon'=>'dashicons-welcome-widgets-menus',	
		'label' => __('Malina Header', 'malina-elements'),
		'labels' => $labels, 
		'public' => true, 
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'has_archive' => false,
		'exclude_from_search' => true,
		'menu_position' => 20,
		'rewrite' => array(
			'slug' => 'header-view',
			'with_front' => true,
		),
		'show_in_rest' => true,
		'supports' => array(
				'title',
				'editor')
			) 
		);
}

?>