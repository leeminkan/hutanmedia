var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	ServerSideRender = wp.components.ServerSideRender,
	TextControl = wp.components.TextControl,
	__ = wp.i18n.__,
	InspectorControls = wp.editor.InspectorControls,
	SelectControl = wp.components.SelectControl,
    ToggleControl = wp.components.ToggleControl,
    carousel = null,
	TitleAlign = [
		{ label: __('Left', 'malina-elements'), value: 'textleft' },
		{ label: __('Center', 'malina-elements'), value: 'textcenter' },
		{ label: __('Right', 'malina-elements'), value: 'textright' }
	],
	BlockTitleSize = [
		{ label: 'H1', value: 'h1' }, 
		{ label: 'H2', value: 'h2' },
		{ label: 'H3', value: 'h3' },
		{ label: 'H4', value: 'h4' },
		{ label: 'H5', value: 'h5' },
		{ label: 'H6', value: 'h6' },
	];

registerBlockType( 'malina/septitle', {
    title: __('Malina Separator Title', 'malina-elements'),

    icon: 'editor-strikethrough',

    category: 'malinaelements',

    edit: function( props ) {

		return [

			el( ServerSideRender, {
				block: 'malina/septitle',
				attributes: props.attributes,
			} ),

			el( InspectorControls, {},
				el( TextControl, {
					label: __('Title', 'malina-elements'),
					help: __('Eneter your title text', 'malina-elements'),
					value: props.attributes.title_text,
					onChange: ( value ) => { props.setAttributes( { title_text: value } ); },
				} ),
				el( SelectControl,
	                {
	                    label: __('Select title  size', 'malina-elements'),
	                    value: props.attributes.title_size,
	                    onChange: ( value ) => { props.setAttributes( { title_size: value } ); },
	                    options: BlockTitleSize,
	                }
	            ),
				el( SelectControl,
	                {
	                    label: __('Title posistion', 'malina-elements'),
	                    help : __('Select position for title', 'malina-elements'),
	                    value: props.attributes.title_position,
	                    onChange: ( value ) => { props.setAttributes( { title_position: value } ); },
	                    options: TextAlign,
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
