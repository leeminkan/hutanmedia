<?php
	$paddings = rwmb_meta('malina_page_herosection_padding');
	if(!empty($paddings)){
		$top = !empty($paddings['top']) ? $paddings['top'].'px' : '0';
		$right = !empty($paddings['right']) ? $paddings['right'].'px' : '0';
		$bottom = !empty($paddings['bottom']) ? $paddings['bottom'].'px' : '0';
		$left = !empty($paddings['left']) ? $paddings['left'].'px' : '0';
		$padding_css = 'padding:'.$top.' '.$right.' '.$bottom.' '.$left.';';
	} else {
		$padding_css = '';
	}
?>
<div id="revslider-section" style="<?php echo esc_attr($padding_css); ?>">
	<?php add_revslider( rwmb_meta('malina_page_herosection_revslider') ); ?>
</div>