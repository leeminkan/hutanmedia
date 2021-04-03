<?php
function malina_teammember_block() {
	// Scripts.
	wp_register_script(
		'malina-teammember-block-script', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/teammember/block.js', // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-editor', 'wp-element', 'wp-i18n' ) // Dependencies, defined above.
	);
	// Here we actually register the block with WP, again using our namespacing
	// We also specify the editor script to be used in the Gutenberg interface
	register_block_type( 'malina/teammember', array(
		'editor_script' => 'malina-teammember-block-script',
		'attributes'      => array(
			'name' => array(
				'type' => 'string',
				'default' => ''
			),
			'mediaID' => array(
				'type' => 'number',
				'default' => ''
			),
			'mediaURL' => array(
				'type' => 'string',
				'default' => ''
			),
			'url' => array(
				'type' => 'string',
				'default' => ''
			),
			'position' => array(
				'type' => 'string',
				'default' => ''
			),
			'image_height' => array(
				'type' => 'string',
				'default' => 'size-portrait'
			),
		),
		'render_callback' => 'MalinaTeammemberCallback',
	) );
}
add_action( 'init', 'malina_teammember_block' );
function MalinaTeammemberCallback($attributes){
	extract(shortcode_atts(array(
    	'name' => '',
		'position' => '',
		'mediaID' => '',
		'url' => '',
		'image_height' => 'size-portrait'
    ), $attributes));
	$out = '';
	$out = '[malinateam name="'.$name.'" position="'.$position.'" image_id="'.$mediaID.'" url="'.$url.'"]';
	return do_shortcode($out);	
}