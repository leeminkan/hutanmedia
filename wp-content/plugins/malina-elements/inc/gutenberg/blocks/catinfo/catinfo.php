<?php
function malina_catinfo_block() {
	// Scripts.
	wp_register_script(
		'malina-catinfo-block-script', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/catinfo/block.js', // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-editor', 'wp-element', 'wp-i18n' ) // Dependencies, defined above.
	);

	// Here we actually register the block with WP, again using our namespacing
	// We also specify the editor script to be used in the Gutenberg interface
	register_block_type( 'malina/catinfo', array(
		'editor_script' => 'malina-catinfo-block-script',
		'attributes'      => array(
			'categories' => array(
				'type' => 'array',
				'default' => [],
				'items'   => [
					'type' => 'string',
				],
			),
		),
		'render_callback' => 'MalinaCatinfoCallback',
	) );

}
add_action( 'init', 'malina_catinfo_block' );
function MalinaCatinfoCallback($attributes){
	extract(shortcode_atts(array(
    	'categories' => '',
    ), $attributes));
    $categories = implode(',', $categories);
	$out = '[malinacatinfo categories="'.$categories.'"]';
	return shortcode_unautop(do_shortcode($out));	
}