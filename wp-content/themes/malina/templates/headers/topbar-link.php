<div id="topbar" class="topbar-link">
	<div class="container">
		<div class="span12">
			<?php
				$post_url = get_the_permalink();
				query_posts( 'posts_per_page=1&order=DESC' );
				while (have_posts()) : the_post();
					$post_url = get_the_permalink();
				endwhile;
				$text = esc_html__('Click','malina').' <a href="'.esc_url($post_url).'">'.esc_html__('here','malina').'</a> '.esc_html__('to see my new post','malina');
				echo apply_filters('malina_topbar_text', $text);
			?>
		</div>
	</div>
</div>