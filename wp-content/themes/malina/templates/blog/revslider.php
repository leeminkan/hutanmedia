<?php
	$pt = get_theme_mod('malina_home_hero_section_padtop', '25');
	$pr = get_theme_mod('malina_home_hero_section_padright', '25');
	$pb = get_theme_mod('malina_home_hero_section_padbottom', '25');
	$pl = get_theme_mod('malina_home_hero_section_padleft', '25');
	$style = 'padding:'.$pt.'px '.$pr.'px '.$pb.'px '.$pl.'px;';

	$revslider = get_theme_mod('malina_home_revslider','none');
?>
<div id="revslider-section" style="<?php echo esc_attr($style); ?>">
	<?php add_revslider( $revslider ); ?>
</div>