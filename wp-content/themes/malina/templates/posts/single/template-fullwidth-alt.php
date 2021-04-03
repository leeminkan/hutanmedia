<?php 
$sidebar_pos = malina_get_sidebar_position();
?>
<div class="wrap-single-post  post-layout-fullwidth-alt">
	<div class="fullwidth-image fullwidth-image-alt">
		<div class="overlay-bg"></div>
		<?php if(get_post_format() == '' || get_post_format() == 'standard') { ?>
		<div class="overlay-title">
			<?php get_template_part('templates/posts/title', 'block'); ?>
		</div>
		<?php } ?>
		<?php
			malina_single_post_format_content();
		?>
	</div>
	<div class="wrap-content-sidebar">
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

	<?php 
		if( $sidebar_pos != 'span12' && !strrpos($sidebar_pos, 'no_widgets_sidebar') ){
			get_sidebar();
		}
	?>
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
