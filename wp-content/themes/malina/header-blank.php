<?php global $post; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<?php do_action('malina_header_meta'); ?>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php if ( ! ( function_exists( 'has_site_icon' ) && has_site_icon() ) ) { ?>
	  	<link rel="shortcut icon" href="<?php echo esc_url(get_theme_mod('malina_media_favicon',get_template_directory_uri().'/favicon.ico')); ?>">
		<link rel="apple-touch-icon" href="<?php echo esc_url(get_theme_mod('malina_media_favicon',get_template_directory_uri().'/favicon.ico')); ?>">
	<?php } ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="main">

			