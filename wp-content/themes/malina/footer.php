	<?php 
	$pics = get_theme_mod('malina_footer_instagram_pics', '4');
	$pics_per_row = get_theme_mod('malina_footer_instagram_pics_per_row', '4');

	if( rwmb_get_value('malina_display_page_footer') && is_singular() ) {
	} elseif( get_theme_mod('malina_footer_layout', 'layout-2') === 'custom' ){
		echo '<footer id="footer-custom">';
		if( get_theme_mod('malina_custom_footer', 'none') === 'none' || !get_post_status(get_theme_mod('malina_custom_footer', 'none')) ){
			echo '<div class="container">';
			esc_html_e('Go to dashboard and create your own footer layout. Then select it under Customizer -> theme options -> footer -> custom footer layout', 'malina');
			echo '</div>';
		} else {
			malina_get_custom_footer( get_theme_mod('malina_custom_footer', 'none'), true );
		}
		echo '</footer>';
	} elseif( get_theme_mod('malina_footer_layout', 'layout-2') === 'disable' && get_theme_mod('malina_footer_socials', true ) && function_exists('malina_get_footer_social_links') ){
		echo '<div class="footer-socials-block">'.do_blocks('<!-- wp:malina/socials {"socials_style":"show_on_hover","social_before":"SOCIAL NETWORKS"} /-->').'</div>';
	} elseif( get_theme_mod('malina_footer_instagram_user_name', '') == '' && get_theme_mod('malina_footer_instagram_access_token', '') == '' && get_theme_mod('malina_footer_copyright', '') == '' && get_theme_mod('malina_footer_socials', false) != true ){

	} elseif( get_theme_mod('malina_footer_layout', 'layout-2') === 'layout-2'){ ?>	
			<footer id="footer" class="footer-layout-2">
				<div class="special-bg"></div>
			<?php if( ( get_theme_mod('malina_footer_instagram_user_name', '') != '' || get_theme_mod('malina_footer_instagram_access_token', '') != '' ) && rwmb_get_value('malina_display_instagram') != 'disbale') { 
				$hide_items = $hide_link = '';
				if(rwmb_get_value('malina_display_instagram') == 'disable-items') {
					$hide_items = true;
				}
				if(rwmb_get_value('malina_display_instagram') == 'disable-link'){
					$hide_link = true;
				}
				$item_link = get_theme_mod('malina_footer_instagram_link_to', '2'); 
				?>
				<div id="before-footer">
					<div class="container">
						<div class="span12">
							<?php if( get_theme_mod('malina_footer_instagram_access_token', '') != '' ){
								the_widget( 'malina_widget_instagram_new', array('title'=>'', 'insta_title'=> get_theme_mod('malina_footer_instagram_title', ''), 'hide_items' => $hide_items, 'hide_link' => $hide_link, 'access_token'=>get_theme_mod('malina_footer_instagram_access_token', ''), 'item_link'=>$item_link, 'pics'=>$pics, 'pics_per_row'=>$pics_per_row ));
							} else {
								the_widget( 'malina_widget_instagram', array('title'=>'', 'insta_title'=> get_theme_mod('malina_footer_instagram_title', ''), 'hide_items' => $hide_items, 'hide_link' => $hide_link, 'user_name'=>get_theme_mod('malina_footer_instagram_user_name', ''), 'item_link'=>$item_link, 'pics'=>$pics, 'pics_per_row'=>$pics_per_row ));
							}
							?>
						</div>
					</div>
				</div>
			<?php } ?>
			<?php if( get_theme_mod('malina_footer_copyright', '') != '' || get_theme_mod('malina_footer_socials', true) ) { ?>
				<div class="container">
					<?php if( get_theme_mod('malina_footer_logo', false) ){ ?>
						<div class="span12">
							<h2 class="footer-logo">
								<?php if(get_theme_mod('malina_footer_logo_img','') != "") { ?>
									<a href="<?php echo esc_url(home_url()); ?>/" class="logo_main"><img src="<?php echo esc_url(get_theme_mod('malina_footer_logo_img')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" /></a>
								<?php } else { ?>
									<a href="<?php echo esc_url(home_url()); ?>/" class="logo_text"><?php echo esc_attr(get_bloginfo('name')); ?></a>
								<?php } ?>
							</h2>
						</div>
					<?php } ?>
					<div class="span12">
						<?php if( get_theme_mod('malina_footer_socials', true ) && function_exists('malina_get_footer_social_links') ) { echo malina_get_footer_social_links(); } ?>
					</div>
					<div class="span12">
						<?php if( get_theme_mod('malina_footer_copyright', '') != '' ) { ?>
							<div id="footer-copy-block">
								<div class="copyright-text"><?php echo get_theme_mod('malina_footer_copyright', ''); ?></div>
							</div>
						<?php } ?>	
					</div>	
				</div>
				
			<?php } ?>
			</footer>	
			<div class="clear"></div>
		<?php
	} elseif (get_theme_mod('malina_footer_layout', 'layout-2') === 'layout-3') { ?>	
		<footer id="footer" class="footer-simple">
			<?php if( get_theme_mod('malina_footer_copyright', '') != '' || get_theme_mod('malina_footer_socials', true) ) { ?>
				<div id="footer-bottom">
					<div class="container">
						<div class="span5">
							<?php if( get_theme_mod('malina_footer_copyright', '') != '' ) { ?>
								<div id="footer-copy-block">
									<div class="copyright-text"><?php echo get_theme_mod('malina_footer_copyright', ''); ?></div>
								</div>
							<?php } ?>	
						</div>	
						<div class="span7 footer-menu">
							<?php if( get_theme_mod('malina_footer_menu', 'none') != 'none' ) { 
								wp_nav_menu(['menu' => get_theme_mod('malina_footer_menu'), 'depth' => 1, 'fallback_cb' => '']);
							} 
							?>
						</div>
					</div>
				</div>
			<?php } ?>
			</footer>	
			<div class="clear"></div>
		<?php
	} elseif( get_theme_mod('malina_footer_layout', 'layout-2') === 'layout-4'){ ?>	
			<?php if( ( get_theme_mod('malina_footer_instagram_user_name', '') != '' || get_theme_mod('malina_footer_instagram_access_token', '') != '' ) && rwmb_get_value('malina_display_instagram') != 'disbale') { 
				$hide_items = $hide_link = '';
				if(rwmb_get_value('malina_display_instagram') == 'disable-items') {
					$hide_items = true;
				}
				if(rwmb_get_value('malina_display_instagram') == 'disable-link'){
					$hide_link = true;
				}
				$item_link = get_theme_mod('malina_footer_instagram_link_to', '2'); 
				?>
				
			<div id="before-footer">
				<div class="container">
					<div class="span12">
						<?php 
							if( get_theme_mod('malina_footer_instagram_access_token', '') != '' ){
								the_widget( 'malina_widget_instagram_new', array('title'=>'', 'insta_title'=> get_theme_mod('malina_footer_instagram_title', ''), 'hide_items' => $hide_items, 'hide_link' => $hide_link, 'access_token'=>get_theme_mod('malina_footer_instagram_access_token', ''), 'item_link'=>$item_link, 'pics'=>$pics, 'pics_per_row'=>$pics_per_row ));
							} else {
								the_widget( 'malina_widget_instagram', array('title'=>'', 'insta_title'=> get_theme_mod('malina_footer_instagram_title', ''), 'hide_items' => $hide_items, 'hide_link' => $hide_link, 'user_name'=>get_theme_mod('malina_footer_instagram_user_name', ''), 'item_link'=>$item_link, 'pics'=>$pics, 'pics_per_row'=>$pics_per_row ));
							}
						?>
					</div>
				</div>
			</div>
			<?php } ?>
			<footer id="footer" class="footer-layout-4">
			<?php if( get_theme_mod('malina_footer_copyright', '') != '' || get_theme_mod('malina_footer_socials', true) ) { ?>
				<div class="container">
					<?php if( get_theme_mod('malina_footer_logo', false) ){ ?>
						<div class="span12">
							<h2 class="footer-logo">
								<?php if(get_theme_mod('malina_footer_logo_img','') != "") { ?>
									<a href="<?php echo esc_url(home_url()); ?>/" class="logo_main"><img src="<?php echo esc_url(get_theme_mod('malina_footer_logo_img')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" /></a>
								<?php } else { ?>
									<a href="<?php echo esc_url(home_url()); ?>/" class="logo_text"><?php echo esc_attr(get_bloginfo('name')); ?></a>
								<?php } ?>
							</h2>
						</div>
					<?php } ?>
					<div class="span12">
						<?php if( get_theme_mod('malina_footer_socials', true ) && function_exists('malina_get_footer_social_links') ) { echo malina_get_footer_social_links(); } ?>
					</div>	
				</div>	
			<?php } ?>
			</footer>
			<?php if( get_theme_mod('malina_footer_copyright', '') != '' ) { ?>
					<div id="footer-copy-block" class="footer-layout-4">
						<div class="container">
							<div class="span12">
								<div class="copyright-text"><?php echo get_theme_mod('malina_footer_copyright', ''); ?></div>
							</div>
						</div>
					</div>
				<?php } ?>	
			<div class="clear"></div>
		<?php
	} else { ?>	
		<footer id="footer">
			<div class="special-bg"></div>
			<?php if( ( get_theme_mod('malina_footer_instagram_user_name', '') != '' || get_theme_mod('malina_footer_instagram_access_token', '') != '' ) && rwmb_get_value('malina_display_instagram') != 'disbale') { 
				$hide_items = $hide_link = '';
				if(rwmb_get_value('malina_display_instagram') == 'disable-items') {
					$hide_items = true;
				}
				if(rwmb_get_value('malina_display_instagram') == 'disable-link'){
					$hide_link = true;
				}
				$item_link = get_theme_mod('malina_footer_instagram_link_to', '2');
				?>
				<div id="before-footer" class="fullwidth">
					<?php 
						if( get_theme_mod('malina_footer_instagram_access_token', '') != '' ){
							the_widget( 'malina_widget_instagram_new', array('title'=>'', 'insta_title'=> get_theme_mod('malina_footer_instagram_title', ''), 'hide_items' => $hide_items, 'hide_link' => $hide_link, 'access_token'=>get_theme_mod('malina_footer_instagram_access_token', ''), 'item_link'=>$item_link, 'pics'=>$pics, 'pics_per_row'=>$pics_per_row ));
						} else {
							the_widget( 'malina_widget_instagram', array('title'=>'', 'insta_title'=> get_theme_mod('malina_footer_instagram_title', ''), 'hide_items' => $hide_items, 'hide_link' => $hide_link, 'user_name'=>get_theme_mod('malina_footer_instagram_user_name', ''), 'item_link'=>$item_link, 'pics'=>$pics, 'pics_per_row'=>$pics_per_row ));
						}
					?>
				</div>
			<?php } ?>

			<?php if( is_active_sidebar('footer-widgets') ){ ?>
				<div id="footer-widgets">
					<div class="container">
						<div class="span12">
							<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar('footer-widgets') ); ?>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php if( get_theme_mod('malina_footer_copyright', '') != '' || get_theme_mod('malina_footer_socials', true) ) { ?>
				<div id="footer-bottom">
					<?php if( get_theme_mod('malina_footer_copyright_border', false) ){ ?>
						<hr class="separator-border">
					<?php } ?>
					<div class="container">
						<div class="span4">
							<?php if( get_theme_mod('malina_footer_copyright', '') != '' ) { ?>
								<div id="footer-copy-block">
									<div class="copyright-text"><?php echo get_theme_mod('malina_footer_copyright', ''); ?></div>
								</div>
							<?php } ?>	
						</div>
						<div class="span4">
							<?php if( get_theme_mod('malina_footer_logo', false) ){ ?>
								<h2 class="footer-logo">
									<?php if(get_theme_mod('malina_footer_logo_img','') != "") { ?>
										<a href="<?php echo esc_url(home_url()); ?>/" class="logo_main"><img src="<?php echo esc_url(get_theme_mod('malina_footer_logo_img')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" /></a>
									<?php } else { ?>
										<a href="<?php echo esc_url(home_url()); ?>/" class="logo_text"><?php echo esc_attr(get_bloginfo('name')); ?></a>
									<?php } ?>
								</h2>
							<?php } ?>
						</div>	
						<div class="span4">
							<?php if( get_theme_mod('malina_footer_socials', true) && function_exists('malina_get_social_links') && malina_get_social_links(false) != '' ) { 
								malina_get_social_links(true);
							} ?>
						</div>
					</div>
				</div>
			<?php } ?>
			</footer>	
			<div class="clear"></div>
		<?php
	} ?>
		</div> <!-- end boxed -->

	<?php wp_footer(); ?>
	</body>
</html>