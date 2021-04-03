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
<?php wp_body_open(); ?>
<?php if(get_theme_mod('malina_page_loading', false)){ ?>
	<div class="page-loading">
		<div class="loader">
		    <svg class="circular" viewBox="25 25 50 50">
		      <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
		    </svg>
		</div>
	</div>
<?php } ?>
<?php
	get_template_part('templates/hidden-area/hidden-area');
	$header_type = rwmb_get_value('malina_header_variant');
	if(!is_array($header_type) && $header_type != '' && $header_type != 'default'){
		get_template_part('templates/headers/'.$header_type);
	} else {
		get_template_part('templates/headers/'.get_theme_mod('malina_header_variant', 'header-version4'));
	}
	get_template_part('templates/headers/mobile-header');

	if(get_theme_mod( 'malina_back_to_top', true )){
		echo '<div id="back-to-top"><a href="#"><i class="fa fa-angle-up"></i></a></div>';
	}
	if( get_theme_mod('malina_subscribe_enable', false) ){
		get_template_part('templates/headers/popup-subscribe');
	}
?>
<div id="main">
	
	<?php

		$hero_section = rwmb_get_value('malina_page_hero_section');

		if( !is_archive() || !is_home() || !is_single() ){
			switch ($hero_section) {
				case 'slider':
					get_template_part('templates/page/slider');
					break;
				case 'herosection':
					get_template_part('templates/page/herosection');
					break;
				case 'revslider':
					get_template_part('templates/page/revslider');
					break;
				default:
					# code...
					break;
			}
		}
		
	?>
	<?php if( !is_home() && get_theme_mod('malina_breadcrumbs', 'false') != 'false' ){
		malina_breadcrumbs();
	} ?>

			