var el = wp.element.createElement,
	registerBlockType = wp.blocks.registerBlockType,
	ServerSideRender = wp.ServerSideRender,
	TextControl = wp.components.TextControl,
	PanelBody = wp.components.PanelBody,
	__ = wp.i18n.__,
	InspectorControls = wp.blockEditor.InspectorControls,
	SelectControl = wp.components.SelectControl,
    ToggleControl = wp.components.ToggleControl,
    ColorPalette = wp.blockEditor.ColorPalette,
    ColorPicker = wp.blockEditor.ColorPicker,
	PanelColor = wp.components.PanelColor,
	TextAlign = [
		{ label: __('Left', 'malina-elements'), value: 'textleft' },
		{ label: __('Center', 'malina-elements'), value: 'textcenter' },
		{ label: __('Right', 'malina-elements'), value: 'textright' }
	],
	SocialsStyle = [
		{ label: __('Simple', 'malina-elements'), value: 'simple' },
		{ label: __('Show on hover', 'malina-elements'), value: 'show_on_hover' }
	];


registerBlockType( 'malina/socials', {
    title: __('Malina Social links', 'malina-elements'),

    icon: 'networking',

    category: 'malinaelements',

    edit: function( props ) {

		return [

			el( ServerSideRender, {
				block: 'malina/socials',
				attributes: props.attributes,
			} ),

			el( InspectorControls, {},
				el( 'p', {}, __('If you need to change links. Go to Theme options -> socials in customizer', 'malina-elements') ),
				el( 'p', {}, '' ),
				el( 'h3', {}, __( 'Select icon color', 'malina-elements' ) ),
                el(ColorPalette, {
                    value: props.attributes.links_color,
                    onChange: ( value ) => { props.setAttributes( { links_color: value } ); }
                }),
                el( 'p', {}, '' ),
                el( 'h3', {}, __( 'Select icon background color', 'malina-elements' ) ),
                el(ColorPalette, {
                    value: props.attributes.bg_color,
                    onChange: ( value ) => { props.setAttributes( { bg_color: value } ); }
                }),
                el( SelectControl,
	                {
	                    label: __('Align icons', 'malina-elements'),
	                    help : __('Select position for icons etc.', 'malina-elements'),
	                    value: props.attributes.icons_align,
	                    onChange: ( value ) => { props.setAttributes( { icons_align: value } ); },
	                    options: TextAlign,
	                }
	            ),
	            el( SelectControl,
	                {
	                    label: __('Socials icons style', 'malina-elements'),
	                    help : __('Select icons style', 'malina-elements'),
	                    value: props.attributes.socials_style,
	                    onChange: ( value ) => { props.setAttributes( { socials_style: value } ); },
	                    options: SocialsStyle,
	                }
	            ),
	            el( TextControl, {
					label: __('Before icons text', 'malina-elements'),
					help : __('Use this field if you need add some text before icons.', 'malina-elements'),
					value: props.attributes.social_before,
					onChange: ( value ) => { props.setAttributes( { social_before: value } ); },
				} ),
	            el( TextControl, {
					label: __('Socials block id', 'malina-elements'),
					help : __('Use this field if you need to style it.', 'malina-elements'),
					value: props.attributes.block_id,
					onChange: ( value ) => { props.setAttributes( { block_id: value } ); },
				} ),
			),
			el('style', {
	            	type:"text/css"
	            },
	            '.social-icons.simple'+props.attributes.block_id+' li a {background-color:'+props.attributes.bg_color+' !important; color:'+props.attributes.links_color+' !important;}'
	        )
			
		];
	},

	// We're going to be rendering in PHP, so save() can just return null.
	save: function() {
		return null;
	},
} );
