<div class="card">
	<h5 class="card-header"><p class="sidebar-left">Tin tài trợ</p></h5>
	<div class="card-body">
		<?php
			// Get the JSON
			// Enter the name of your blog here followed by /wp-json/wp/v2/posts and add filters like this one that limits the result to 2 posts.
		$responseMB = wp_remote_get( 'https://khogiaodien.matbao.net/wp-json/wp/v2/pages/885' );


		$body =  wp_remote_retrieve_body($responseMB);

		
		$postsMB = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $body), false );
		$infoMB = $postsMB->content->rendered;

		if ($infoMB) {
			echo $infoMB;
		} else
		{
			echo("Không có nội dung.");
		}
		?>
	</div>
</div>
<br>
<div class="card">
	<div class="card-body-rating">
		<h4><center>Ủng hộ chúng tôi bằng cách đánh giá chất lượng</center></h4>
		<a href="https://wordpress.org/plugins/wp-helper-lite/#reviews" target="_blank" style="text-decoration: none;">
			<div class="mwph-rating">
				<span class="dashicons dashicons-star-filled"></span>
				<span class="dashicons dashicons-star-filled"></span>
				<span class="dashicons dashicons-star-filled"></span>
				<span class="dashicons dashicons-star-filled"></span>
				<span class="dashicons dashicons-star-filled"></span>
			</div>
		</a>
	</div>
	<div class="card-info">
		<div class="sidebar-left">
			<img src="/wp-content/plugins/wp-helper-lite/assets/images/wp-helper-plugin-rating.svg" alt="Logo WP Helper" class="mbwph-logo-sidebar">
		</div>
		<div class="sidebar-right">
			<h3 style="font-weight: 600; margin: 0 0 .5rem 0;margin: 0px 0px .1rem 0px !important;">WP Helper</h3>
			<h5 style="margin: 0px 0px .1rem 0px !important;">Mat Bao Corp</h5>
			<h5 style="margin: 0px 0px .1rem 0px !important;">Made in <b>Vietnam</b> <img src="/wp-content/plugins/wp-helper-lite/assets/images/vietnam-flag.svg" alt="Việt Nam" class="mbwph-Header-flag"></h5>
		</div>
	</div>
</div>