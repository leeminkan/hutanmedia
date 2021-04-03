var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	ServerSideRender = wp.components.ServerSideRender,
	TextControl = wp.components.TextControl,
	__ = wp.i18n.__,
	InspectorControls = wp.editor.InspectorControls,
	SelectControl = wp.components.SelectControl,
    ToggleControl = wp.components.ToggleControl,
    components = wp.components,
	Order = [{ label: __('Descending', 'malina-elements'), value: 'DESC' }, { label: __('Ascending', 'malina-elements'), value: 'ASC' }],
	Orderby = [
		{ label: __('Date', 'malina-elements'), value: 'date' }, 
		{ label: __('Last modified date', 'malina-elements'), value: 'modified' },
		{ label: __('Popularity', 'malina-elements'), value: 'comment_count' },
		{ label: __('Title', 'malina-elements'), value: 'title' },
		{ label: __('Random', 'malina-elements'), value: 'rand' },
		{ label: __('Preserve post ID order', 'malina-elements'), value: 'post__in' },
	],
	PostStyles = [
		{ label: __('Simple', 'malina-elements'), value: 'style_1' }, 
		{ label: __('Featured', 'malina-elements'), value: 'style_2' },
		{ label: __('Featured even/odd', 'malina-elements'), value: 'style_3' },
		{ label: __('Masonry', 'malina-elements'), value: 'style_4' },
		{ label: __('List', 'malina-elements'), value: 'style_5' },
		{ label: __('List 2', 'malina-elements'), value: 'style_5_2' },
		{ label: __('Sono', 'malina-elements'), value: 'style_6' },
		{ label: __('EditorPicks', 'malina-elements'), value: 'style_7' },
		{ label: __('Walnuss', 'malina-elements'), value: 'style_8' },
		{ label: __('Sticky style', 'malina-elements'), value: 'style_9' },
		{ label: __('Boxed', 'malina-elements'), value: 'style_10' },
	],
	Columns = [
		{ label: __('One', 'malina-elements'), value: 'span12' },
		{ label: __('Two', 'malina-elements'), value: 'span6' },
		{ label: __('Three', 'malina-elements'), value: 'span4' },
		{ label: __('Four', 'malina-elements'), value: 'span3' },
		{ label: __('Five', 'malina-elements'), value: 'one_fifth' },
		{ label: __('Six', 'malina-elements'), value: 'span2' }
	],
	ImageSizes = [
		{ label: __('Medium', 'malina-elements'), value: 'medium' },
		{ label: __('Large', 'malina-elements'), value: 'large' },
		{ label: __('Post thumbnail', 'malina-elements'), value: 'post-thumbnail' },
		{ label: __('Malina masonry', 'malina-elements'), value: 'malina-masonry' },
		{ label: __('Malina extra medium', 'malina-elements'), value: 'malina-extra-medium' },
		{ label: __('Malina Slider', 'malina-elements'), value: 'malina-slider' },
		{ label: __('Full', 'malina-elements'), value: 'full' }
	],
	BlockTitleSize = [
		{ label: 'H1', value: 'h1' }, 
		{ label: 'H2', value: 'h2' },
		{ label: 'H3', value: 'h3' },
		{ label: 'H4', value: 'h4' },
		{ label: 'H5', value: 'h5' },
		{ label: 'H6', value: 'h6' },
	],
	TextAlign = [
		{ label: __('Left', 'malina-elements'), value: 'textleft' },
		{ label: __('Center', 'malina-elements'), value: 'textcenter' },
		{ label: __('Right', 'malina-elements'), value: 'textright' }
	],
	DateLabel = [
		{ label: __('Show', 'malina-elements'), value: 'true' },
		{ label: __('Show on hover', 'malina-elements'), value: 'hover' },
		{ label: __('Hide', 'malina-elements'), value: 'false' }
	],
	Pagination = [
		{ label: __('Load more', 'malina-elements'), value: 'true' },
		{ label: __('Standard', 'malina-elements'), value: 'standard' },
		{ label: __('Prev/Next', 'malina-elements'), value: 'next_prev' },
		{ label: __('Infinite scroll', 'malina-elements'), value: 'infinitescroll' },
		{ label: __('Disable', 'malina-elements'), value: 'false' }
	];
	const categorySelections = [];
	const allCats = apiFetch({path: "/wp/v2/categories/?per_page=100"}).then(categories => {
	    jQuery.each( categories, function( key, val ) {
	        categorySelections.push({label: val.name, value: val.slug});
	    });
	    return categorySelections;
	});
registerBlockType( 'malina/gridposts', {
    title: __('Malina Recent Posts', 'malina-elements'),

    icon: 'layout',

    category: 'malinaelements',

    edit: function( props ) {
		return [
			/*
			 * The ServerSideRender element uses the REST API to automatically call
			 * php_block_render() in your PHP code whenever it needs to get an updated
			 * view of the block.
			 */
			el( ServerSideRender, {
				block: 'malina/gridposts',
				attributes: props.attributes,
			} ),
			/*
			 * InspectorControls lets you add controls to the Block sidebar. In this case,
			 * we're adding a TextControl, which lets us edit the 'foo' attribute (which
			 * we defined in the PHP). The onChange property is a little bit of magic to tell
			 * the block editor to update the value of our 'foo' property, and to re-render
			 * the block.
			 */
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
					label: __('Post count', 'malina-elements'),
					help: __("Enter number of posts to display per page (Note: Enter '-1' to display all posts).", 'malina-elements') ,
					value: props.attributes.num,
					onChange: ( value ) => { props.setAttributes( { num: value } ); },
				} ),
				el( TextControl, {
					label: __('Load more posts count', 'malina-elements'),
					help: __("Enter number of posts to load (leave balnk to use the same value as per page).", 'malina-elements') ,
					value: props.attributes.load_count,
					onChange: ( value ) => { props.setAttributes( { load_count: value } ); },
				} ),
				el( TextControl, {
					label: __('Posts offset', 'malina-elements'),
					help: __("Enter the number of posts to offset before retrieval.", 'malina-elements') ,
					value: props.attributes.offset,
					onChange: ( value ) => { props.setAttributes( { offset: value } ); },
				} ),
				el( SelectControl,
	                {
	                    label: __('Posts per row', 'malina-elements'),
	                    help : __('Select posts count per row. It works for simple and masonry style.', 'malina-elements'),
	                    value: props.attributes.columns,
	                    onChange: ( value ) => { props.setAttributes( { columns: value } ); },
	                    options: Columns,
	                }
	            ),
				el( SelectControl,
	                {
	                	multiple: true,
	                    label: __('Select categories to show', 'brookside-elements'),
	                    value: props.attributes.cat_slug,
	                    onChange: ( value ) => { props.setAttributes( { cat_slug: value } ); },
	                    options: categorySelections,
	                }
	            ),
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
	                    label: __('Select posts to exclude', 'malina-elements'),
	                    value: props.attributes.post__not_in,
	                    onChange: ( value ) => { props.setAttributes( { post__not_in: value } ); },
	                    options: postSelections,
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
	                    label: __('Post view style', 'malina-elements'),
	                    help : __('Select posts style on preview.', 'malina-elements'),
	                    value: props.attributes.post_style,
	                    onChange: ( value ) => { props.setAttributes( { post_style: value } ); },
	                    options: PostStyles,
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
	            el( TextControl, {
					label: __('Post excerpt count', 'malina-elements'),
					help: __("Enter number of words in post excerpt. 0 to hide it.", 'malina-elements') ,
					value: props.attributes.excerpt_count,
					onChange: ( value ) => { props.setAttributes( { excerpt_count: value } ); },
				} ),
				el( SelectControl,
	                {
	                    label: __('Align elements', 'malina-elements'),
	                    help : __('Select position for text, meta info, categories, etc.', 'malina-elements'),
	                    value: props.attributes.text_align,
	                    onChange: ( value ) => { props.setAttributes( { text_align: value } ); },
	                    options: TextAlign,
	                }
	            ),
	            el( ToggleControl,
                    {
                        label: __('Display categories?','malina-elements'),
                        help: __('Show categories above the title?', 'malina-elements'),
                        checked: props.attributes.display_categories,
                        onChange: function (event) {
                            props.setAttributes({display_categories: !props.attributes.display_categories});
                        }
                    }
                ),
                el( ToggleControl,
                    {
                        label: __('Display time reading?','malina-elements'),
                        help: __('Show estimate time to read the post?', 'malina-elements'),
                        checked: props.attributes.display_read_time,
                        onChange: function (event) {
                            props.setAttributes({display_read_time: !props.attributes.display_read_time});
                        }
                    }
                ),
                el( ToggleControl,
                    {
                        label: __('Display comments count?','malina-elements'),
                        checked: props.attributes.display_comments,
                        onChange: function (event) {
                            props.setAttributes({display_comments: !props.attributes.display_comments});
                        }
                    }
                ),
                el( SelectControl,
                    {
                        label: __('Display date label?','malina-elements'),
                        checked: props.attributes.display_date,
                        onChange: ( value ) => { props.setAttributes( { display_date: value } ); },
                        options: DateLabel,
                    }
                ),
                el( ToggleControl,
                    {
                        label: __('Display views?','malina-elements'),
                        checked: props.attributes.display_views,
                        onChange: function (event) {
                            props.setAttributes({display_views: !props.attributes.display_views});
                        }
                    }
                ),
                el( ToggleControl,
                    {
                        label: __('Display likes?','malina-elements'),
                        checked: props.attributes.display_likes,
                        onChange: function (event) {
                            props.setAttributes({display_likes: !props.attributes.display_likes});
                        }
                    }
                ),
                el( SelectControl,
	                {
	                    label: __('Pagination', 'malina-elements'),
	                    help : __('Select pagination for posts.', 'malina-elements'),
	                    value: props.attributes.pagination,
	                    onChange: ( value ) => { props.setAttributes( { pagination: value } ); },
	                    options: Pagination,
	                }
	            ),
                el( ToggleControl,
                    {
                        label: __('Disable featured posts style?','malina-elements'),
                        help: __('Disable style for featured posts. Do not highlight them.', 'malina-elements'),
                        checked: props.attributes.ignore_featured,
                        onChange: function (event) {
                            props.setAttributes({ignore_featured: !props.attributes.ignore_featured});
                        }
                    }
                ),
                el( ToggleControl,
                    {
                        label: __('Ignore sticky posts?','malina-elements'),
                        checked: props.attributes.ignore_sticky_posts,
                        onChange: function (event) {
                            props.setAttributes({ignore_sticky_posts: !props.attributes.ignore_sticky_posts});
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
