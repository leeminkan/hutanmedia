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
	MenuPlace = [{ label: 'Menu for header', value: 'header' }, { label: 'Menu for footer', value: 'footer' }];
	MenuPosition = [{ label: 'Left', value: 'flexleft' }, { label: 'Center', value: 'flexcenter' }, { label: 'Right', value: 'flexright' }];
	EnableSearch = [{ label: 'Show', value: 'true' }, { label: 'Hide', value: 'false' }];

registerBlockType( 'malina/menu', {
    title: __('Malina Menu', 'malina-elements'),

    icon: 'menu',

    category: 'malinaelements',

    edit: function( props ) {

		return [

			el( 'div', { 
				className: 'malina-element-block'
				},
				el('h3',{className:'malina-block-title'},
					el('span',{},__('Malina Menu', 'malina-elements'))
				)
			),

			el( InspectorControls, {},
				el( SelectControl,
	                {
	                	multiple: false,
	                    label: __('Menu place', 'malina-elements'),
	                    value: props.attributes.menu_place,
	                    onChange: ( value ) => { props.setAttributes( { menu_place: value } ); },
	                    options: MenuPlace,
	                }
	            ),
	            el( SelectControl,
	                {
	                	multiple: false,
	                    label: __('Menu Position', 'malina-elements'),
	                    value: props.attributes.menu_position,
	                    onChange: ( value ) => { props.setAttributes( { menu_position: value } ); },
	                    options: MenuPosition,
	                }
	            ),
	            el( SelectControl,
	                {
	                	multiple: false,
	                    label: __('Show search icon (for header menu)', 'malina-elements'),
	                    value: props.attributes.enable_search,
	                    onChange: ( value ) => { props.setAttributes( { enable_search: value } ); },
	                    options: EnableSearch,
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
