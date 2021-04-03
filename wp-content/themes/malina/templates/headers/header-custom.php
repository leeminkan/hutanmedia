<div id="header-main" class="<?php if( get_theme_mod('malina_fixed_header', true) ) echo 'fixed_header'; ?>">
<header id="header" class="header-custom clearfix">
	<?php if( get_theme_mod('malina_header_search_button', false) ) { ?>
		<div class="search-area">
			<div class="container">
				<div class="span12">
					<form action="<?php echo esc_url(home_url('/')); ?>" id="header-searchform" method="get">
				        <input type="text" id="header-s" name="s" value="" placeholder="<?php esc_attr_e('Search...', 'malina'); ?>" autocomplete="off" />
				        <button type="submit"><i class="la la-search"></i></button>
					</form>
				</div>
			</div>
			<a href="#" class="close-search"><i class="la la-times"></i></a>
		</div>
	<?php } ?>
	<div class="header-content">
		
			<?php if( get_theme_mod('malina_custom_header', 'none') === 'none' || !get_post_status(get_theme_mod('malina_custom_header', 'none')) ){
					echo '<div class="container">';
						esc_html_e('Go to dashboard and create your own header layout. Then select it under Customizer -> theme options -> header -> custom header layout', 'malina');
					echo '</div>';
				} else {
					malina_get_custom_header( get_theme_mod('malina_custom_header', 'none') , true );
				}
			?>
		
	</div>
</header>
</div>