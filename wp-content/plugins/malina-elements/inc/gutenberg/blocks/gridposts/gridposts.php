<?php
function malinagridposts_block() {
	// Scripts.
	wp_register_script(
		'malinagridposts-block-script', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/gridposts/block.js', // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-editor', 'wp-element', 'wp-i18n' ) // Dependencies, defined above.
	);

	// Styles.
	wp_register_style(
		'malinagridposts-block-editor-style', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/gridposts/editor.css', // Block editor CSS.
		array( 'wp-edit-blocks' ) // Dependency to include the CSS after it.
	);

	// Here we actually register the block with WP, again using our namespacing
	// We also specify the editor script to be used in the Gutenberg interface
	register_block_type( 'malina/gridposts', array(
		'editor_script' => 'malinagridposts-block-script',
		'editor_style' => 'malinagridposts-block-editor-style',
		'attributes'      => array(
			'block_title' => array(
				'type' => 'string',
				'default' => ''
			),
			'block_title_size' => array(
				'type' => 'string',
				'default' => 'h4'
			),
			'num' => array(
				'type' => 'string',
				'default' => '6'
			),
			'load_count' => array(
				'type' => 'string',
			),
			'offset' => array(
				'type' => 'string',
				'default' => ''
			),
			'columns' => array(
				'type' => 'string',
				'default' => 'span6'
			),
			'post_style' => array(
				'type' => 'string',
				'default' => 'style_1'
			),
			'orderby' => array(
				'type' => 'string',
				'default' => 'date'
			),
			'order' => array(
				'type' => 'string',
				'default' => 'DESC'
			),
			'post_ids' => array(
				'type' => 'array',
				'default' => [],
				'items'   => [
					'type' => 'integer',
				],
			),
			'cat_slug' => array(
				'type' => 'array',
				'default' => [],
				'items'   => [
					'type' => 'string',
				],
			),
			'post__not_in' => array(
				'type' => 'array',
				'default' => [],
				'items'   => [
					'type' => 'integer',
				],
			),
			'pagination' => array(
				'type' => 'string',
				'default' => 'standard'
			),
			'thumbsize' => array(
				'type' => 'string',
				'default' => 'medium'
			),
			'text_align' => array(
				'type' => 'string',
				'default' => 'textcenter'
			),
			'excerpt_count' => array(
				'type' => 'string',
				'default' => '15'
			),
			'display_categories' => array(
				'type' => 'boolean',
				'default' => 1
			),
			'display_date' => array(
				'type' => 'string',
				'default' => 'true'
			),
			'display_comments' => array(
				'type' => 'boolean',
				'default' => 0
			),
			'display_views' => array(
				'type' => 'boolean',
				'default' => 1
			),
			'display_likes' => array(
				'type' => 'boolean',
				'default' => 1
			),
			'display_read_time' => array(
				'type' => 'boolean',
				'default' => 1
			),
			'ignore_featured' => array(
				'type' => 'boolean',
				'default' => 1
			),
			'ignore_sticky_posts' => array(
				'type' => 'boolean',
				'default' => 0
			),
		),
		'render_callback' => 'MalinaGridPostsConvert',
	) );

}
add_action( 'init', 'malinagridposts_block' );
function MalinaGridPostsConvert($attributes){
	extract(shortcode_atts(array(
		'block_title' => '',
		'block_title_size' => 'h4',
    	'num' => '6',
    	'offset' => '',
      	'load_count' => '',
      	'columns' => 'span4',
      	'post_style' => 'style_1',
      	'orderby' => 'date',
      	'order' => 'DESC',
      	'cat_slug' => '',
      	'post_ids' => '',
      	'post__not_in' => '',
      	'pagination' => 'standard',
      	'thumbsize'		=> 'post-thumbnail',
      	'text_align' => 'textcenter',
      	'excerpt_count'	=> '32',
      	'display_categories' => 'true',
      	'display_date' => 'true',
      	'display_comments' => 'false',
      	'display_views' => 'true',
      	'display_likes' => 'true',
      	'display_read_time' => 'true',
      	'ignore_featured' => 'true',
      	'ignore_sticky_posts' => 'false'
    ), $attributes));

	$out = '[gridposts 
	block_title="'.$block_title.'"
	block_title_size="'.$block_title_size.'" 
	num="'.$num.'" 
	load_count="'.$load_count.'" 
	offset="'.$offset.'"
	columns="'.$columns.'" 
	post_style="'.$post_style.'" 
	post_ids="'.implode(',',$post_ids).'" 
	orderby="'.$orderby.'" 
	order="'.$order.'" 
	cat_slug="'.implode(',',$cat_slug).'" 
	post__not_in="'.implode(',',$post__not_in).'" 
	pagination="'.$pagination.'" 
	thumbsize="'.$thumbsize.'" 
	text_align="'.$text_align.'" 
	excerpt_count="'.$excerpt_count.'" 
	display_categories="'.$display_categories.'" 
	display_date="'.$display_date.'" 
	display_comments="'.$display_comments.'" 
	display_views="'.$display_views.'" 
	display_likes="'.$display_likes.'" 
	display_read_time="'.$display_read_time.'"
	ignore_featured="'.$ignore_featured.'" 
	ignore_sticky_posts="'.$ignore_sticky_posts.'"]';
	return shortcode_unautop(do_shortcode($out));
}