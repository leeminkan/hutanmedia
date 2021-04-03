<?php
function malina_septitle_block() {
	// Scripts.
	wp_register_script(
		'malinaseptitle-block-script', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/separator-title/block.js', // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-editor', 'wp-element', 'wp-i18n' ) // Dependencies, defined above.
	);

	// Here we actually register the block with WP, again using our namespacing
	// We also specify the editor script to be used in the Gutenberg interface
	register_block_type( 'malina/septitle', array(
		'editor_script' => 'malinaseptitle-block-script',
		'attributes'      => array(
			'title_text' => array(
				'type' => 'string',
				'default' => ''
			),
			'title_size' => array(
				'type' => 'string',
				'default' => 'h3'
			),
			'title_position' => array(
				'type' => 'string',
				'default' => 'textcenter'
			),
		),
		'render_callback' => 'MalinaSepTitle',
	) );

}
add_action( 'init', 'malina_septitle_block' );
function MalinaSepTitle($attributes){
	extract(shortcode_atts(array(
      	'title_text' => '',
      	'title_size' => 'h3',
      	'title_position' => 'center'
    ), $attributes));
	$out = '';
	
	return do_shortcode('[malinaseparatortitle text="'.$title_text.'" size="'.$title_size.'" position="'.$title_position.'"]');
}