var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	ServerSideRender = wp.components.ServerSideRender,
	TextControl = wp.components.TextControl,
	__ = wp.i18n.__,
	InspectorControls = wp.editor.InspectorControls,
	SelectControl = wp.components.SelectControl,
    ToggleControl = wp.components.ToggleControl,
    MediaUpload = wp.editor.MediaUpload,
    components = wp.components,
    carousel = null,
	TrueFalse = [{ label: 'Yes', value: 'true' }, { label: 'No', value: 'false' }];
	ImageHeight = [{ label: 'Landscape', value: 'size-landscape' }, { label: 'Portrait', value: 'size-portrait' }];

registerBlockType( 'malina/catinfo', {
    title: __('Malina Categories Info', 'malina-elements'),

    icon: 'category',

    category: 'malinaelements',

    edit: function( props ) {
    	var onSelectImage = function( media ) {
			return props.setAttributes( {
				mediaURL: media.url,
				mediaID: media.id,
			} );
		};

		return [

			el( ServerSideRender, {
				block: 'malina/catinfo',
				attributes: props.attributes,
			} ),

			el( InspectorControls, {},
				el( SelectControl,
	                {
	                	multiple: true,
	                    label: __('Select categories to show', 'malina-elements'),
	                    value: props.attributes.categories,
	                    onChange: ( value ) => { props.setAttributes( { categories: value } ); },
	                    options: categorySelections,
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
