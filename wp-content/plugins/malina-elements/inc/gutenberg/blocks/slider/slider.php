<?php
function malina_postslider_block() {
	// Scripts.
	wp_register_script(
		'malina_postslider-block-script', // Handle.
		MALINA_PLUGIN_URL.'inc/gutenberg/blocks/slider/block.js', // Block.js: We register the block here.
		array( 'wp-blocks', 'wp-editor', 'wp-element', 'wp-i18n', 'wp-api-fetch' ) // Dependencies, defined above.
	);

	// Here we actually register the block with WP, again using our namespacing
	// We also specify the editor script to be used in the Gutenberg interface
	register_block_type( 'malina/postslider', array(
		'editor_script' => 'malina_postslider-block-script',
		'attributes'      => array(
			'slideshow' => array(
				'type' => 'boolean',
				'default' => true
			),
			'number_posts' => array(
				'type' => 'string',
				'default' => '3'
			),
			'block_title' => array(
				'type' => 'string',
				'default' => ''
			),
			'block_title_size' => array(
				'type' => 'string',
				'default' => 'h4'
			),
			'loop' => array(
				'type' => 'boolean',
				'default' => false
			),
			'orderby' => array(
				'type' => 'string',
				'default' => 'date'
			),
			'order' => array(
				'type' => 'string',
				'default' => 'DESC'
			),
			'thumbsize' => array(
				'type' => 'string',
				'default' => 'large'
			),
			'mousewheel' => array(
				'type' => 'string',
				'default' => 'false'
			),
			'description_style' => array(
				'type' => 'string',
				'default' => 'style_1'
			),
			'cat_slug' => array(
				'type' => 'array',
				'default' => [],
				'items'   => [
					'type' => 'string',
				],
			),
			'post_ids' => array(
				'type' => 'array',
				'default' => [],
				'items'   => [
					'type' => 'integer',
				],
			),
			'orderby' => array(
				'type' => 'string',
				'default' => 'date'
			),
			'order' => array(
				'type' => 'string',
				'default' => 'DESC'
			),
			'slider_style' => array(
				'type' => 'string',
				'default' => 'simple'
			),
			'show_categories' => array(
				'type' => 'boolean',
				'default' => true
			),
			'show_date' => array(
				'type' => 'boolean',
				'default' => false
			),
			'nav' => array(
				'type' => 'boolean',
				'default' => false
			),
			'show_dots' => array(
				'type' => 'boolean',
				'default' => true
			),
			'overlay' => array(
				'type' => 'boolean',
				'default' => true
			),
			'slider_width' => array(
				'type' => 'string',
				'default' => 'standard'
			),
		),
		'render_callback' => 'MalinaPostSliderConvert',
	) );

}
add_action( 'init', 'malina_postslider_block' );
function MalinaPostSliderConvert($attributes){
	extract(shortcode_atts(array(
		'block_title' => '',
		'block_title_size' => 'h4',
    	'slideshow' => true,
    	'loop' => 'false',
      	'number_posts' => '3',
      	'orderby' => 'date',
      	'order' => 'DESC',
      	'thumbsize' => 'large',
      	'description_style' => 'style_1',
      	'cat_slug' => '',
      	'post_ids' => '',
      	'slider_style' => 'simple',
      	'shadow' => 'true',
      	'nav' => 'true',
      	'overlay' => 'false',
      	'overlay_color' => '',
      	'show_categories' => 'true',
      	'show_date' => 'true',
      	'show_dots' => 'true',
      	'slider_width' => 'standard',
      	'mousewheel' => 'false'
    ), $attributes));
    $loop = $loop ? 'true' : 'false';
    $show_date = $show_date ? 'true' : 'false';
    $show_categories = $show_categories ? 'true' : 'false';
    $nav = $nav ? 'true' : 'false';
    $show_dots = $show_dots ? 'true' : 'false';
    $overlay = $overlay ? 'true' : 'false';
    $post_ids = implode(',', $post_ids);
	$out = '[post_slider block_title="'.$block_title.'" block_title_size="'.$block_title_size.'" orderby="'.$orderby.'" order="'.$order.'" number_posts="'.$number_posts.'" slideshow="'.$slideshow.'" loop="'.$loop.'" cat_slug="'.implode(',',$cat_slug).'" post_ids="'.$post_ids.'" orderby="'.$orderby.'" order="'.$order.'" thumbsize="'.$thumbsize.'" style="'.$slider_style.'" description_style="'.$description_style.'" nav="'.$nav.'" overlay="'.$overlay.'" show_categories="'.$show_categories.'" show_date="'.$show_date.'" show_dots="'.$show_dots.'" slider_width="'.$slider_width.'" mousewheel="'.$mousewheel.'"]';
	return do_shortcode($out);
}