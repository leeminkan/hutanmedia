<div id="mobile-header-block">	
	<?php if( get_theme_mod('malina_header_search_button', false) ) { ?>
		<div class="search-area">
			<div class="container">
				<div class="span12">
					<form action="<?php echo esc_url(home_url('/')); ?>" id="header-searchform-mobile" method="get">
				        <input type="text" id="header-mobile-s" name="s" value="" placeholder="<?php esc_attr_e('Search...', 'malina'); ?>" autocomplete="off" />
				        <button type="submit"><i class="la la-search"></i></button>
					</form>
				</div>
			</div>
			<a href="#" class="close-search"><i class="la la-times"></i></a>
		</div>
	<?php } ?>
	<header id="mobile-header">
		<div>
			<div class="logo">
				<?php if(get_theme_mod('malina_media_logo_mobile','') != "") { ?>
					<a href="<?php echo esc_url(home_url()); ?>/" class="logo_main"><img src="<?php echo esc_url(get_theme_mod('malina_media_logo_mobile')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" /></a>
				<?php } elseif(get_theme_mod('malina_media_logo','') != "") { ?>
					<a href="<?php echo esc_url(home_url()); ?>/" class="logo_main"><img src="<?php echo esc_url(get_theme_mod('malina_media_logo')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>" /></a>
				<?php } else { ?>
					<a href="<?php echo esc_url(home_url()); ?>/" class="logo_text"><?php echo esc_attr(get_bloginfo('name')); ?></a>
					<?php if( get_theme_mod('malina_logo_tagline_show', false) ){ echo '<p class="tagline">'.esc_html(get_bloginfo('description')).'</p>'; }?>
				<?php } ?>
			</div>
			<div id="dl-menu" class="dl-menuwrapper">
				<?php if( get_theme_mod('malina_header_search_button', false) ) { ?>
					<div class="search-link">
						<a href="javascript:void(0);" class="search-button"><i class="la la-search"></i></a>
					</div>
				<?php } ?>
				<?php if( has_nav_menu('mobile_navigation') ){ ?> <button class="dl-trigger"></button> <?php } ?>
				<?php if( get_theme_mod('malina_header_shopping_cart', false) && class_exists('WooCommerce') ) { 
							$count = WC()->cart->cart_contents_count;
						?>
						<div class="cart-main menu-item cart-contents">
							<a class="my-cart-link" href="<?php echo wc_get_cart_url(); ?>"><i class="la la-shopping-cart"></i>
								<?php if ( $count > 0 ) {
							        ?>
							        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
							        <?php
							    } ?>
							</a>
						</div>
				<?php } ?>
				
				<?php
				if( has_nav_menu('mobile_navigation') ){
					echo '<ul id="nav-mobile" class="dl-menu">';
					wp_nav_menu(array('theme_location' => 'mobile_navigation', 'container' => false, 'menu_id' => 'nav-mobile', 'items_wrap'=>'%3$s', 'fallback_cb' => false, 'walker' => new Malina_Mobile_Walker_Nav_Menu()));
					echo '</ul>';
				} ?>
				
			</div>
		</div>
	</header>
</div>