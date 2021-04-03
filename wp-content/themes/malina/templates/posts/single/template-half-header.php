<?php 
$sidebar_pos = 'span12';
?>
<div class="wrap-single-post post-layout-half-header">
	<div class="double-header">
		<div class="post-info-col">
			<div class="col-inner">
				<?php 
					global $post;
					get_template_part('templates/posts/title', 'block'); 
					if($post->post_excerpt != ''){
						echo '<div class="excerpt-text">'.esc_html($post->post_excerpt).'</div>';
					}
				?>
			</div>
		</div>
		<?php 
			if( malina_single_post_format_content(false) ){
				echo '<div class="post-featured-img-col">'.malina_single_post_format_content(false).'</div>';
			}
		?>
	</div>
	<div class="row">
		<div id="content" class="<?php echo esc_attr($sidebar_pos); ?> single">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<article <?php post_class(); ?>>
						<div class="post-content-container">			
							<div class="post-content">
								<div class="post-excerpt">
									<?php the_content(); ?>
								</div>
								<?php wp_link_pages(array('before' =>'<div class="pagination_post aligncenter">', 'after'  =>'</div>', 'pagelink' => '<span>%</span>')); ?>
							</div>

							<?php get_template_part( 'templates/posts/meta', 'single' ); ?>
						</div>
						<?php
							if( get_theme_mod( 'malina_single_post_subscribe_block', false ) ){
								get_template_part( 'templates/posts/subscribe-block' );
							} 
							if ( '' !== get_the_author_meta( 'description' ) && get_theme_mod( 'malina_single_post_author_info', true ) ) {
								get_template_part( 'templates/posts/biography' );
							}
							if( get_theme_mod( 'malina_single_post_navigation', true ) ){
								get_template_part( 'templates/posts/post-navigation' );
							}

							if( get_theme_mod( 'malina_single_post_related', 'false' ) == 'true' ){
								get_template_part( 'templates/posts/related-posts' );
							}

							if(comments_open()) {
								comments_template();
							} 
						?>
					</article>
					<?php 
						if( rwmb_meta('malina_post_sticky_sharebox') && function_exists('MalinaStickySharebox') ){
							MalinaStickySharebox(get_the_ID(), true);
						} elseif ( get_theme_mod( 'malina_single_post_sicky_sharebox', false ) && function_exists('MalinaStickySharebox') ){
							MalinaStickySharebox(get_the_ID(), true);
						}
					?>
					
			<?php endwhile; endif; ?>
		</div>
	</div>
	<?php 
		if( !rwmb_meta('malina_post_top_stories_hide') && get_theme_mod( 'malina_single_post_top_stories', 'false' ) == 'true' ){
			get_template_part( 'templates/posts/top-posts' );
		}
		if( get_theme_mod( 'malina_single_post_infinitescroll', 'false' ) == 'true' ){
			get_template_part( 'templates/posts/infinitescroll-post' );
		}
	?>
</div>
