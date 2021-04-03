<div id="subscribe-popup" class="subscribe-popup">
	<div class="subscribe-popup-inner">
		<div class="flex-grid flex-grid-2">
			<div class="flex-column">
				<div class="subscribe-bg">
					<?php if(get_theme_mod('malina_subscribe_popup_img', get_template_directory_uri().'/images/subscribe-img.jpg')){
						echo '<img src="'.get_theme_mod('malina_subscribe_popup_img', get_template_directory_uri().'/images/subscribe-img.jpg').'" alt="'.esc_html__('Subscribe popup image', 'malina').'">';
					} ?>
				</div>
			</div>
			<div class="flex-column">
				<a href="#" class="close-button"><i class="la la-close"></i></a>
				<div class="form-wrap">
					<h3><?php echo get_theme_mod('malina_subscribe_popup_title', 'Malina') ?></h3>
					<p class="subtitle"><?php echo get_theme_mod('malina_subscribe_popup_subtitle', 'Get the latest fashion trends, the best in travel and my life.') ?></p>
					<?php if(get_theme_mod('malina_subscribe_popup_form', '') != ''){
						echo do_shortcode( get_theme_mod('malina_subscribe_popup_form') );
					} else {
						do_action('malina_email_subscription', 'subscribe-header');
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
jQuery(window).load(function(){
	<?php if(get_theme_mod('malina_subscribe_popup_time','') != ''){ ?>
		if(jQuery.cookie('showpopup') != 'no'){
			setTimeout(function(){jQuery('#subscribe-popup').addClass('opened')}, <?php echo get_theme_mod('malina_subscribe_popup_time','3000'); ?>);
		}
		jQuery("#subscribe-popup .close-button").click(function(){
			var exp = new Date();
			exp.setTime(exp.getTime() + 7*24*60*(60 * 1000));
		    jQuery.cookie('showpopup','no',{ expires: exp });
		});	
	<?php } ?>
	jQuery("<?php echo get_theme_mod('malina_subscribe_popup_click','.open-subscribe'); ?>").click(function(){
		jQuery('#subscribe-popup').addClass('opened');
		return false;
	});
});
</script>