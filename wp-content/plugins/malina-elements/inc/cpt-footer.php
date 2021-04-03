<?php

add_action('init', 'malina_post_type_footer');
function malina_post_type_footer() {
	$labels = array(
		'name' => __( 'Malina Footers', 'malina-elements' ),
		'singular_name' => __( 'Malina Footer', 'malina-elements' ),
		'add_new' => __( 'Add New Footer', 'malina-elements' ),
		'add_new_item' => __( 'Add New Footer Item', 'malina-elements' ),
		'edit_item' => __( 'Edit Footer Item', 'malina-elements' ),
		'new_item' => __( 'Add New Footer Item', 'malina-elements' ),
		'view_item' => __( 'View Footer', 'malina-elements' ),
		'search_items' => __( 'Search Footer', 'malina-elements' ),
		'not_found' => __( 'No footers found', 'malina-elements' ),
		'not_found_in_trash' => __( 'No footers found in trash', 'malina-elements' )
	);
	register_post_type( 'malina-footer',
        array( 
        'menu_icon'=>'dashicons-align-center',	
		'label' => __('Malina Footer', 'malina-elements'), 
		'labels' => $labels,
		'public' => true, 
		'show_ui' => true,
		'show_in_nav_menus' => false,
		'has_archive' => false,
		'exclude_from_search' => true,
		'menu_position' => 20,
		'rewrite' => array(
			'slug' => 'footer-view',
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