<?php
function malina_instagram_block() {
	// Scripts.
	wp_register_script(
		'malina_instagram-block-script', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/instagram/block.js', // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-editor', 'wp-element', 'wp-i18n', 'wp-api-fetch' ) // Dependencies, defined above.
	);

	// Here we actually register the block with WP, again using our namespacing
	// We also specify the editor script to be used in the Gutenberg interface
	register_block_type( 'malina/instagram', array(
		'editor_script' => 'malina_instagram-block-script',
		'attributes'      => array(
			'insta_title' => array(
				'type' => 'string',
				'default' => ''
			),
			'access_token' => array(
				'type' => 'string',
				'default' => ''
			),
			'pics' => array(
				'type' => 'string',
				'default' => '6'
			),
			'pics_per_row' => array(
				'type' => 'string',
				'default' => '3'
			),
			'hide_link' => array(
				'type' => 'string',
				'default' => 'true'
			),
			'item_link' => array(
				'type' => 'string',
				'default' => '1'
			),
		),
		'render_callback' => 'MalinaInstagramConvert',
	) );

}
add_action( 'init', 'malina_instagram_block' );
function MalinaInstagramConvert($attributes){
	extract(shortcode_atts(array(
		'insta_title'=>'',
		'hide_link' => 'true',
		'access_token'=>'',
		'pics'=>'6',
		'pics_per_row'=>'3',
		'item_link' => '1'
    ), $attributes));
	$out = '[malinainstagram title="'.$insta_title.'" hide_link="'.$hide_link.'" access_token="'.$access_token.'" pics="'.$pics.'" pics_per_row="'.$pics_per_row.'" item_link="'.$item_link.'"]';
	return do_shortcode($out);
}