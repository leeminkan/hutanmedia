<section id="subscribe" class="subscribe-section">
	<?php 
		wp_enqueue_style( 'TheSecret' );
		$out = '';
		if( get_theme_mod('malina_single_post_subscribe_title', 'more from me' ) ){
			echo '<h2>'.get_theme_mod('malina_single_post_subscribe_title', 'More from me' ).'</h2>';
		}
		if( get_theme_mod('malina_single_post_subscribe_text', 'My biggest life changes, latest minds, and my family life.' ) ){
			echo '<p class="desc">'.get_theme_mod('malina_single_post_subscribe_text', 'My biggest life changes, latest minds, and my family life.' ).'</p>';
		}
		if( get_theme_mod('malina_single_post_subscribe_form', '') == '' ){
			$id = 'post-subscribe';
			do_action('malina_email_subscription', $id);
		} else {
			$form_code = get_theme_mod('malina_single_post_subscribe_form', '');
			echo do_shortcode($form_code);
		}

	?>
</section>