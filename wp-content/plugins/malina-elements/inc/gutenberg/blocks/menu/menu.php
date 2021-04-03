<?php
function malina_menu_block() {
	// Scripts.
	wp_register_script(
		'malina-menu-block-script', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/menu/block.js', // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-editor', 'wp-element', 'wp-i18n' ) // Dependencies, defined above.
	);

	// Here we actually register the block with WP, again using our namespacing
	// We also specify the editor script to be used in the Gutenberg interface
	register_block_type( 'malina/menu', array(
		'editor_script' => 'malina-menu-block-script',
		'attributes'      => array(
			'menu_place' => array(
				'type' => 'array',
				'default' => 'header'
			),
			'menu_position' => array(
				'type' => 'string',
				'default' => 'flexcenter',
			),
			'enable_search' => array(
				'type' => 'string',
				'default' => 'true'
			)
		),
		'render_callback' => 'MalinaMenuCallback',
	));
}
add_action( 'init', 'malina_menu_block' );
function MalinaMenuCallback($attributes){
	extract(shortcode_atts(array(
    	'menu_place' => 'header',
    	'menu_position' => 'flexcenter',
    	'enable_search' => 'true',
    ), $attributes));
	$out = '[malinamenu menu_place="'.$menu_place.'" menu_position="'.$menu_position.'" enable_search="'.$enable_search.'"]';
	return shortcode_unautop(do_shortcode($out));	
}