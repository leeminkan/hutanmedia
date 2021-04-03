var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	ServerSideRender = wp.components.ServerSideRender,
	TextControl = wp.components.TextControl,
	__ = wp.i18n.__,
	InspectorControls = wp.editor.InspectorControls,
	SelectControl = wp.components.SelectControl,
    ToggleControl = wp.components.ToggleControl,
    carousel = null,
    apiFetch = wp.apiFetch;
	TrueFalse = [{ label: 'No', value: 'false' }, { label: 'Yes', value: 'true' }],
	ImageSizes = [
		{ label: __('Medium', 'malina-elements'), value: 'medium' },
		{ label: __('Large', 'malina-elements'), value: 'large' },
		{ label: __('Post thumbnail', 'malina-elements'), value: 'post-thumbnail' },
		{ label: __('Malina masonry', 'malina-elements'), value: 'malina-masonry' },
		{ label: __('Malina extra medium', 'malina-elements'), value: 'malina-extra-medium' },
		{ label: __('Malina Slider', 'malina-elements'), value: 'malina-slider' },
		{ label: __('Full', 'malina-elements'), value: 'full' }
	],
	Order = [{ label: __('Descending', 'malina-elements'), value: 'DESC' }, { label: __('Ascending', 'malina-elements'), value: 'ASC' }],
	Orderby = [
		{ label: __('Date', 'malina-elements'), value: 'date' }, 
		{ label: __('Last modified date', 'malina-elements'), value: 'modified' },
		{ label: __('Popularity', 'malina-elements'), value: 'comment_count' },
		{ label: __('Title', 'malina-elements'), value: 'title' },
		{ label: __('Random', 'malina-elements'), value: 'rand' },
		{ label: __('Preserve post ID order', 'malina-elements'), value: 'post__in' },
	],
	BlockTitleSize = [
		{ label: 'H1', value: 'h1' }, 
		{ label: 'H2', value: 'h2' },
		{ label: 'H3', value: 'h3' },
		{ label: 'H4', value: 'h4' },
		{ label: 'H5', value: 'h5' },
		{ label: 'H6', value: 'h6' },
	],
	DescStyles = [
		{ label: __('Style 1', 'malina-elements'), value: 'style_1' }, 
		{ label: __('Style 2', 'malina-elements'), value: 'style_2' },
		{ label: __('Style 3', 'malina-elements'), value: 'style_3' },
		{ label: __('Style 4', 'malina-elements'), value: 'style_4' },
		{ label: __('Style 5', 'malina-elements'), value: 'style_5' },
		{ label: __('Style 6', 'malina-elements'), value: 'style_6' },
		{ label: __('Style 7', 'malina-elements'), value: 'style_7' },
	],
	SliderStyle = [
		{ label: __('Simple', 'malina-elements'), value: 'simple' }, 
		{ label: __('Centered', 'malina-elements'), value: 'center' },
		{ label: __('Two Centered', 'malina-elements'), value: 'center2' },
		{ label: __('Two in row', 'malina-elements'), value: 'two_per_row' },
		{ label: __('Three in row', 'malina-elements'), value: 'three_per_row' }
	];

	const postSelections = [];
	const allPosts = apiFetch({path: "/wp/v2/posts/?per_page=100"}).then(posts => {
	    jQuery.each( posts, function( key, val ) {
	        postSelections.push({label: val.title.rendered, value: val.id});
	    });
	    return postSelections;
	});

registerBlockType( 'malina/postslider', {
    title: __('Malina Slider Posts', 'malina-elements'),

    icon: 'slides',

    category: 'malinaelements',

    edit: function( props ) {

		return [
			el( 'div', { 
				className: 'malina-element-block'
				},
				el('h3',{className:'malina-block-title'},
					el('span',{},__('Malina Posts slider', 'malina-elements'))
				)
			),

			el( InspectorControls, {},
				el( TextControl, {
					label: __('Block title', 'malina-elements'),
					help : __('Enter block title. Leave blank to hide.', 'malina-elements'),
					value: props.attributes.block_title,
					onChange: ( value ) => { props.setAttributes( { block_title: value } ); },
				} ),
				el( SelectControl,
	                {
	                    label: __('Block title size', 'malina-elements'),
	                    value: props.attributes.block_title_size,
	                    onChange: ( value ) => { props.setAttributes( { block_title_size: value } ); },
	                    options: BlockTitleSize,
	                }
	            ),
				el( TextControl, {
					label: __('Posts count', 'malina-elements'),
					value: props.attributes.number_posts,
					onChange: ( value ) => { props.setAttributes( { number_posts: value } ); },
				} ),
				el( SelectControl,
	                {
	                	multiple: true,
	                    label: __('Select posts to show', 'malina-elements'),
	                    value: props.attributes.post_ids,
	                    onChange: ( value ) => { props.setAttributes( { post_ids: value } ); },
	                    options: postSelections,
	                }
	            ),
	            el( SelectControl,
	                {
	                	multiple: true,
	                    label: __('Select categories to show', 'malina-elements'),
	                    value: props.attributes.cat_slug,
	                    onChange: ( value ) => { props.setAttributes( { cat_slug: value } ); },
	                    options: categorySelections,
	                }
	            ),
	            el( SelectControl,
	                {
	                    label: __('Order by', 'malina-elements'),
	                    help : __('Select how to sort retrieved posts.', 'malina-elements'),
	                    value: props.attributes.orderby,
	                    onChange: ( value ) => { props.setAttributes( { orderby: value } ); },
	                    options: Orderby,
	                }
	            ),
				el( SelectControl,
	                {
	                    label: __('Sort order', 'malina-elements'),
	                    help : __('Select ascending or descending order.', 'malina-elements'),
	                    value: props.attributes.order,
	                    onChange: ( value ) => { props.setAttributes( { order: value } ); },
	                    options: Order,
	                }
	            ),
	            el( SelectControl,
	                {
	                    label: __('Slider description style', 'malina-elements'),
	                    value: props.attributes.description_style,
	                    onChange: ( value ) => { props.setAttributes( { description_style: value } ); },
	                    options: DescStyles,
	                }
	            ),
	            el( SelectControl,
	                {
	                    label: __('Slider Style', 'malina-elements'),
	                    value: props.attributes.slider_style,
	                    onChange: ( value ) => { props.setAttributes( { slider_style: value } ); },
	                    options: SliderStyle,
	                }
	            ),
	            el( SelectControl,
	                {
	                    label: __('Thumbnail size', 'malina-elements'),
	                    help : __('Select your image size to use.', 'malina-elements'),
	                    value: props.attributes.thumbsize,
	                    onChange: ( value ) => { props.setAttributes( { thumbsize: value } ); },
	                    options: ImageSizes,
	                }
	            ),
	            el( ToggleControl,
                    {
                        label: __('Overlay', 'malina-elements'),
                        checked: props.attributes.overlay,
                        onChange: function (event) {
                            props.setAttributes({overlay: !props.attributes.overlay});
                        }
                    }
                ),
				el( ToggleControl,
	                {
	                    label: __('Slideshow', 'malina-elements'),
	                    help: __('You can enable/disable slides autoplay','malina-elements'),
	                    checked: props.attributes.slideshow,
	                    onChange: function (event) {
                            props.setAttributes({slideshow: !props.attributes.slideshow});
                        }
	                }
	            ),
	            el( SelectControl,
	                {
	                    label: __('Scroll on mousewheel', 'malina-elements'),
	                    value: props.attributes.mousewheel,
	                    onChange: ( value ) => { props.setAttributes( { mousewheel: value } ); },
	                    options: TrueFalse,
	                }
	            ),
	            el( ToggleControl,
                    {
                        label: 'Loop',
                        help: __('You can enable/disable slides loop', 'malina-elements'),
                        checked: props.attributes.loop,
                        onChange: function (event) {
                            props.setAttributes({loop: !props.attributes.loop});
                        }
                    }
                ),
                el( ToggleControl,
                    {
                        label: __('Slider Arrows', 'malina-elements'),
                        checked: props.attributes.nav,
                        onChange: function (event) {
                            props.setAttributes({nav: !props.attributes.nav});
                        }
                    }
                ),
                el( ToggleControl,
                    {
                        label: __('Slider bullets', 'malina-elements'),
                        checked: props.attributes.show_dots,
                        onChange: function (event) {
                            props.setAttributes({show_dots: !props.attributes.show_dots});
                        }
                    }
                ),
                el( ToggleControl,
                    {
                        label: __('Show categories', 'malina-elements'),
                        checked: props.attributes.show_categories,
                        onChange: function (event) {
                            props.setAttributes({show_categories: !props.attributes.show_categories});
                        }
                    }
                ),
                el( ToggleControl,
                    {
                        label: __('Show date', 'malina-elements'),
                        checked: props.attributes.show_date,
                        onChange: function (event) {
                            props.setAttributes({show_date: !props.attributes.show_date});
                        }
                    }
                ),
			),
		];
	},

	// We're going to be rendering in PHP, so save() can just return null.
	save: function() {
		return null;
	},
} );
