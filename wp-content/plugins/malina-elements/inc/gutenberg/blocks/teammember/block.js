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
	//ImageHeight = [{ label: 'Landscape', value: 'size-landscape' }, { label: 'Portrait', value: 'size-portrait' }];

registerBlockType( 'malina/teammember', {
    title: __('Malina TeamMember', 'malina-elements'),

    icon: 'admin-users',

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
				block: 'malina/teammember',
				attributes: props.attributes,
			} ),

			el( InspectorControls, {},
				el( TextControl, {
					label: __('Name', 'malina-elements'),
					help: __('Please enter member name', 'malina-elements'),
					value: props.attributes.name,
					onChange: ( value ) => { props.setAttributes( { name: value } ); },
				} ),
				el( MediaUpload, {
					onSelect: onSelectImage,
					type: 'image',
					value: props.attributes.mediaID,
					render: function( obj ) {
						return el( components.Button, {
							className: props.attributes.mediaID ? 'image-button' : 'button button-large',
							onClick: obj.open
							},
							! props.attributes.mediaID ? __( 'Upload Image', 'malina-elements') : el( 'img', { src: props.attributes.mediaURL } )
						);
					}
				} ),
				el( TextControl, {
					label: __('URL', 'malina-elements'),
					help: __('Please enter url or leave blank if you need not', 'malina-elements'),
					value: props.attributes.url,
					onChange: ( value ) => { props.setAttributes( { url: value } ); },
				} ),
				el( TextControl, {
					label: __('Position', 'malina-elements'),
					help: __('Please enter member position', 'malina-elements'),
					value: props.attributes.position,
					onChange: ( value ) => { props.setAttributes( { position: value } ); },
				} ),
			),
		];
	},

	// We're going to be rendering in PHP, so save() can just return null.
	save: function() {
		return null;
	},
} );
