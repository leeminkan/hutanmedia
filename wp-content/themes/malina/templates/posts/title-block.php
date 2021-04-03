<?php
$title_pos = rwmb_meta('malina_post_title_position');
if(!$title_pos){
	$title_pos = 'textcenter';
}
?>
<header class="title <?php echo esc_attr($title_pos); ?>">
	<div class="meta-categories"><?php echo get_the_category_list(', '); ?></div>
	<h1><?php the_title(); ?></h1>
	<?php if( get_theme_mod('malina_single_post_meta_date', true ) ) {?><div class="meta-date"><time datetime="<?php echo esc_attr(date(DATE_W3C)); ?>"><?php the_time(get_option('date_format')); ?></time></div><?php } ?>
</header>