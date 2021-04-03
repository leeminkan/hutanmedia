<?php
//start your code here
function malina_parent_styles()  
{  
	/* ------------------------------------------------------------------------ */
	/* Register Stylesheets */
	/* ------------------------------------------------------------------------ */
	wp_register_style( 'child-stylesheet', get_stylesheet_uri(), array(), '1.0', 'all' ); // Main Stylesheet
	wp_enqueue_style( 'child-stylesheet' );
}  
add_action( 'wp_enqueue_scripts', 'malina_parent_styles', 12 ); 
?>