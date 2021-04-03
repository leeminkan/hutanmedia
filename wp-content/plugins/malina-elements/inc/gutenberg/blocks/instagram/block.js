var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	ServerSideRender = wp.components.ServerSideRender,
	TextControl = wp.components.TextControl,
	__ = wp.i18n.__,
	InspectorControls = wp.editor.InspectorControls,
	SelectControl = wp.components.SelectControl,
    ToggleControl = wp.components.ToggleControl,
	TrueFalse = [{ label: 'No', value: 'false' }, { label: 'Yes', value: 'true' }],
	PicsPerRow = [
		{ label: __('One per row', 'malina-elements'), value: '1' },
		{ label: __('Two per row', 'malina-elements'), value: '2' },
		{ label: __('Three per row', 'malina-elements'), value: '3' },
		{ label: __('Four per row', 'malina-elements'), value: '4' },
		{ label: __('five per row', 'malina-elements'), value: '5' },
		{ label: __('Siz per row', 'malina-elements'), value: '6' }
	],
	FollowLink = [
		{ label: __('Lightbox', 'malina-elements'), value: '1' }, 
		{ label: __('Link to instagram', 'malina-elements'), value: '2' }
	];

registerBlockType( 'malina/instagram', {
    title: __('Malina Instagram', 'malina-elements'),

    icon: 'instagram',

    category: 'malinaelements',

    edit: function( props ) {

		return [
			el( ServerSideRender, {
				block: 'malina/instagram',
				attributes: props.attributes,
			} ),

			el( InspectorControls, {},
				el( TextControl, {
					label: __('Title', 'malina-elements'),
					help : __('Enter title. Leave blank to hide.', 'malina-elements'),
					value: props.attributes.insta_title,
					onChange: ( value ) => { props.setAttributes( { insta_title: value } ); },
				} ),
				el( TextControl, {
					label: __('Access Token', 'malina-elements'),
					help : '<a href="" target="_blank">'+__('Generate access token', 'malina-elements')+'</a>',
					value: props.attributes.access_token,
					onChange: ( value ) => { props.setAttributes( { access_token: value } ); },
				} ),
				el( TextControl, {
					label: __('Items count', 'malina-elements'),
					value: props.attributes.pics,
					onChange: ( value ) => { props.setAttributes( { pics: value } ); },
				} ),
				el( SelectControl,
	                {
	                    label: __('Items per row', 'malina-elements'),
	                    value: props.attributes.pics_per_row,
	                    onChange: ( value ) => { props.setAttributes( { pics_per_row: value } ); },
	                    options: PicsPerRow,
	                }
	            ),
				el( SelectControl,
	                {
	                    label: __('Hide Follow Link?', 'malina-elements'),
	                    value: props.attributes.hide_link,
	                    onChange: ( value ) => { props.setAttributes( { hide_link: value } ); },
	                    options: TrueFalse,
	                }
	            ),
	            el( SelectControl,
	                {
	                    label: __('Link image to:', 'malina-elements'),
	                    value: props.attributes.item_link,
	                    onChange: ( value ) => { props.setAttributes( { item_link: value } ); },
	                    options: FollowLink,
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
