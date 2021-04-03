<?php get_header(); ?>

<?php 
$text_align = get_theme_mod( 'malina_archive_elements_align', 'textcenter');
// Get Blog Layout from Theme Options
$sidebar = get_theme_mod('malina_sidebar_pos_archive', 'sidebar-right');
if($sidebar != 'none'){
	$sidebar_pos = $sidebar.' span9';
} else {
	$sidebar_pos ='span12';
}
if( !is_active_sidebar('blog-widgets') && $sidebar != 'none') {
	$sidebar_pos .=' no_widgets_sidebar';
}
?>
<div id="page-wrap-blog" class="container">
	<div id="content" class="<?php echo esc_attr($sidebar_pos); ?>">
		<header class="page-title">
			<h2 class="<?php echo ''.$text_align; ?>">
				<?php if ( is_category() ) : ?>
					<?php single_cat_title(); ?>
			    <?php else : ?>
			        <?php the_archive_title(); ?>
			    <?php endif; ?>
			</h2>
		</header>
		<?php
			if( is_category() && category_description() != '' ){
				echo '<div class="category_description '.$text_align.'">'.category_description().'</div>';
			}
		?>
		<div class="row">
			<?php

			$columns = get_theme_mod( 'malina_archive_columns', 'span6');
	      	$display_categories = false;
	      	$display_date = get_theme_mod( 'malina_display_post_date_archive', 'true');
	      	$date_on_hover = $display_date == 'hover' ? ' date_on_hover' : '';
			$display_date = ($display_date == 'true' || $display_date=='1' || $display_date=='hover');
	      	$display_comments = get_theme_mod( 'malina_display_post_comments_archive', false);
	      	$show_readmore = get_theme_mod( 'malina_display_read_more_archive', false);
	      	if( function_exists('MalinaGetPostViews')){
	      		$display_views = get_theme_mod( 'malina_display_post_views_archive', true);
	      	} else {
	      		$display_views = false;
	      	}
	      	if( function_exists('getPostLikeLink') ){
	      		$display_likes = get_theme_mod( 'malina_display_post_likes_archive', true);
	      	} else {
	      		$display_likes = false;
	      	}
	      	if( function_exists('malina_calculate_reading_time') ){
	      		$display_read_time = get_theme_mod( 'malina_display_post_read_time_archive', true);
	      	} else {
	      		$display_read_time = false;
	      	}
	      	$pagination = get_theme_mod( 'malina_display_post_pagination_archive', 'standard');
	      	$display_readmore = 'true';
	      	$ignore_featured = $ignore_sticky_posts = true;
	      	$text_align = get_theme_mod( 'malina_archive_elements_align', 'textcenter');
			$out = '';
			$post_style = get_theme_mod('malina_archive_style', 'style_1');
			$thumbsize = get_theme_mod('malina_archive_thumbnail_size','malina-extra-medium');
			$excerpt_count = get_theme_mod('malina_archive_excerpt_count','17');
			if($post_style == 'style_4'){
				$thumbsize = 'malina-masonry';
			}
			if($post_style == 'style_2' || $post_style == 'style_3' ){
				$thumbsize = 'post-thumbnail';
			}
			if(($post_style == 'style_1' || $post_style == 'style_4' || $post_style == 'style_8' || $post_style == 'style_10' ) || $pagination == 'true' || $pagination == 'infinitescroll' ){
				if( $post_style == 'style_4' || ($post_style == 'style_8' && $thumbsize == 'malina-masonry') || ($post_style == 'style_10' && $thumbsize == 'malina-masonry') ){
					$masonry = 'masonry';
				} else {
					$masonry = 'fitRows';
				}
				$owl_reinit = '';
				$show_post_format = rwmb_get_value('malina_display_featured_img_instead', $post->ID);
				if( $show_post_format === 'true' ){
					$show_post_format = get_theme_mod('malina_display_featured_img_preview', true);
				}
				if($show_post_format !== '1' || $show_post_format !== true || $show_post_format !== 'true'){
					$autoplay = rwmb_get_value('malina_gallery_autoplay', $post->ID);
					$loop = rwmb_get_value('malina_gallery_loop', $post->ID);
					$autoplay = $autoplay ? 'true' : 'false';
					$loop = $loop ? 'true' : 'false';
					$owl_reinit = 'var owl = newElems.find(\'div[class*="preview-post-gallery"]\').owlCarousel({
			            items:1,
			            autoplay:'.$autoplay.',
			            singleItem:true,
			            loop:'.$loop.',
			            nav:true,
			            navRewind:false,
			            navText: [ \'<i class="la la-angle-left"></i>\',\'<i class="la la-angle-right"></i>\' ],
			            dots:true,
			            autoHeight: true,
			            themeClass: "owl-gallery"
	    			});';
				}
				wp_enqueue_script('isotope');
				if( $pagination == 'infinitescroll' || $pagination == 'true'){
					wp_enqueue_script('infinite-scroll');
					wp_enqueue_script('imagesloaded');
				}
				if(is_rtl()){
					$isOriginLeft = 'false';
				} else {
					$isOriginLeft = 'true';
				}
				$script = "var win = jQuery(window);
					var doc = jQuery(document);
				    doc.ready(function($){
				        var isoOptionsBlog = {
		                    itemSelector: '.post',
		                    layoutMode: '".$masonry."',
		                    masonry: {
		                        columnWidth: '.post-size'
		                    },
		                    percentPosition:true,
		                    isOriginLeft: ".$isOriginLeft.",
		                };
				        var gridBlog2 = $('#latest-posts .blog-posts');
				        gridBlog2.isotope(isoOptionsBlog);       
				        win.resize(function(){
				            gridBlog2.isotope('layout');
				        });
						jQuery('.blog-posts .post .post-img img').on('load', function(){ gridBlog2.isotope('layout'); });
						win.load(function(){
				            gridBlog2.isotope('layout');
				        });";
				        if($pagination == 'infinitescroll' || $pagination == 'true'){
				        	$script .= "gridBlog2.infinitescroll({
					            navSelector  : '#pagination',    // selector for the paged navigation 
					            nextSelector : '#pagination a.next',  // selector for the NEXT link (to page 2)
					            itemSelector : '.post',     // selector for all items you'll retrieve
					            loading: {
					                finishedMsg: '".esc_html__('No more items to load.', 'malina')."',
					                msgText: '<i class=\"fa fa-spinner fa-spin fa-2x\"></i>'
					              },
					            animate      : false,
					            errorCallback: function(){
					                $('a.loadmore').removeClass('active').hide();
					                $('a.loadmore').addClass('hide');
					            },
					            appendCallback: true
					            },  // call Isotope as a callback
					            function( newElements ) {
					                var newElems = $( newElements ); 
					                newElems.imagesLoaded(function(){
					                	".$owl_reinit."
					                    gridBlog2.isotope( 'appended', newElems );
					                    gridBlog2.isotope('layout');
					                    $('a.loadmore').removeClass('active');
					                });
					            }
					        );
					        $('a.loadmore').click(function () {
					            $(this).addClass('active');
					            gridBlog2.infinitescroll('retrieve');
					            return false;
					        });";
						}
				        $script .= "setTimeout(function(){ $('.page-loading').fadeOut('fast', function (){});}, 100);
				    });";
				if( $pagination != 'infinitescroll' ){
			    	$script .= "jQuery(window).load(function(){ jQuery(window).unbind('.infscr'); });";
			    }
				wp_add_inline_script('isotope', $script);
			}
			if( have_posts() ) {
				$out .= '<div id="latest-posts">';
				$out .= '<div id="blog-posts-page" class="row-fluid blog-posts">';
				while ( have_posts() ) {
					the_post();
					$classes = join(' ', get_post_class($post->ID));
					$classes .= ' post';
					if(!$ignore_sticky_posts && is_sticky() && strrpos($classes, 'sticky')){
						$out .= '<article class="'.$text_align.' span12 '.$classes.'">';
							$out .= '<div class="post-block-title">';
								if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
								$out .= '<header class="title">';
								$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
								$out .= '</header>';
							$out .= '</div>';
							$out .= '<div class="post-img-block">';
							$out .= malina_get_post_format_content(false, 'large');
							if( $display_date ) $out .= '<div class="label-date'.$date_on_hover.'"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
							$out .= '</div>';	
							$out .= '<div class="post-content">';
								if( malina_post_has_more_link( get_the_ID() ) ){
									$out .= malina_get_the_content();
								} else {
									$out .= get_the_excerpt();
								}
								$out .= '</div>';
								$out .= '<div class="post-meta'.$bottom_lines.'">';
									$out .= '<div class="meta">';
										if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
										if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
										if( comments_open() && $display_comments ){
											$out .= '<div class="meta-comment">'.malina_comments_number( get_the_ID() ).'</div>';
										}
									$out .= '</div>';
									$out .= '<div class="post-more"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark"><span>'.esc_html__('Read more', 'malina').'</span><i class="la la-long-arrow-right"></i></a></div>';
									if(function_exists('MalinaSharebox')){
										$out .= MalinaSharebox( get_the_ID() );
									}
								$out .= '</div>';
						$out .= '</article>';
					} elseif(!$ignore_featured && rwmb_get_value('malina_post_featured') && $post_style == 'style_1' ){
						$classes = str_replace('sticky ', '', $classes);
						$out .= '<article class="post-featured post-size span12 '.$classes.'">';
							$out .= '<div class="post-content-container">';
								$out .= '<div class="post-img-side">';
								if( $display_date ) $out .= '<div class="label-date'.$date_on_hover.'"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
								$out .= malina_get_post_format_content(false, 'post-thumbnail');
								$out .= '</div>';
								$out .= '<div class="post-content-side">';
									if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
									$out .= '<header class="title">';
									$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
									$out .= '</header>';
								$out .= '<div class="post-content">';
								if( malina_post_has_more_link( get_the_ID() ) ){
									$out .= '<div class="post-excerpt">'.malina_get_the_content().'</div>';
								} else {
									$out .= '<div class="post-excerpt">'.get_the_excerpt().'</div>';
								}
								$out .= '</div>';
								if( $display_likes || $display_read_time || $display_views || (comments_open() && $display_comments) ) {
									$out .= '<div class="post-meta footer-meta">';
									if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
									if( $display_read_time ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
									if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
									if( comments_open() && $display_comments ){
										$out .= '<div class="meta-comment">'.malina_comments_number( get_the_ID() ).'</div>';
									}
									$out .= '</div>';
								}
								$out .= '</div>';
							$out .= '</div>';
						$out .= '</article>';
					} elseif(!$ignore_featured && rwmb_get_value('malina_post_featured') && ($post_style == 'style_2' || $post_style == 'style_3' || $post_style == 'style_5' ) ){
						$classes = str_replace('sticky ', '', $classes);
						$out .= '<article class="post-featured post-featured-style2 span12 '.$classes.'">';
							$out .= '<div class="post-content-container '.$text_align.'">';						
							$out .= '<div class="post-content">';
								$out .= '<div class="post-img-block">';
								if( $display_date ) $out .= '<div class="label-date'.$date_on_hover.'"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
								$out .= malina_get_post_format_content(false, 'large');
								$out .= '</div>';
								$out .= '<div class="post-title-block">';
									if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
									$out .= '<header class="title">';
									$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
									$out .= '</header>';
								$out .= '</div>';
							$out .= '</div>';
							$out .= '</div>';
						$out .= '</article>';
					} elseif(!$ignore_featured && rwmb_get_value('malina_post_featured') && $post_style == 'style_4'){
						$classes = str_replace('sticky ', '', $classes);
						$out .= '<article class="post-featured-style4 post-size '.$columns.' '.$classes.'">';
							$out .= '<div class="post-content-container '.$text_align.'">';						
								$out .= '<div class="post-content">';
									$out .= '<div class="post-img-block">';
										$out .= '<div class="meta-over-img">';
										$out .= '<header class="title">';
										if( $display_categories == 'true' ){
											$out .= '<div class="meta-categories">'.get_the_category_list(' ').'</div>';
										}
										$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
										$out .= '<div class="meta-date"><time datetime="'.get_the_date(DATE_W3C).'">'.get_the_time(get_option('date_format')).'</time></div>';
										$out .= '</header>';
										$out .= '</div>';
										if( has_post_thumbnail() ) {
											$out .= '<figure class="post-img"><a href="'.get_the_permalink().'" rel="bookmark">'.get_the_post_thumbnail($post->ID, 'malina-masonry').'</a></figure>';
										}
									$out .= '</div>';

								$out .= '</div>';
							$out .= '</div>';
						$out .= '</article>';
					} elseif( $post_style == 'style_2' || $post_style == 'style_3' ){
						$classes = str_replace('sticky ', '', $classes);
						if($post_style == 'style_3' ){
							static $i = 0;
							$i++;
							if($i % 2 == 0){
								$post_pos = 'even';
							} else {
								$post_pos = 'odd';
							}
						} else {
							$post_pos = '';
						}
						$out .= '<article class="post-size style_2 '.$post_pos.' span12 '.$classes.'">';
							$out .= '<div class="post-content-container '.$text_align.'">';
								$out .= '<div class="post-img-side">';
									if( $display_date ) $out .= '<div class="label-date'.$date_on_hover.'"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
									$out .= malina_get_post_format_content(false, $thumbsize);
								$out .= '</div>';
								$out .= '<div class="post-content-side">';
									if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
									$out .= '<header class="title">';
									$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
									$out .= '</header>';
								$out .= '<div class="post-content">';
								if( malina_post_has_more_link( get_the_ID() ) ){
									$out .= '<div class="post-excerpt">'.malina_get_the_content().'</div>';
								} else {
									$out .= '<div class="post-excerpt">'.get_the_excerpt().'</div>';
								}
								$out .= '</div>';
								if( $display_likes || $display_read_time || $display_views || (comments_open() && $display_comments) ) {
									$out .= '<div class="post-meta footer-meta">';
									if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
									if( $display_read_time ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
									if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
									if( comments_open() && $display_comments ){
										$out .= '<div class="meta-comment">'.malina_comments_number( get_the_ID() ).'</div>';
									}
									$out .= '</div>';
								}
								$out .= '</div>';
							$out .= '</div>';
						$out .= '</article>';
					} elseif( $post_style == 'style_5' ) {
					$classes = str_replace('sticky ', '', $classes);
					$out .= '<article class="span12 post-size style_5 '.$classes.'">';
						$out .= '<div class="post-content-container">';
							$out .= '<div class="post-img-side">';
								if( $display_date ) $out .= '<div class="label-date'.$date_on_hover.'"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
								$out .= malina_get_post_format_content(false, $thumbsize);
							$out .= '</div>';
							$out .= '<div class="post-content-side">';
								if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
								$out .= '<header class="title">';
								$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
								$out .= '</header>';
							$out .= '<div class="post-content">';
							if( malina_post_has_more_link( get_the_ID() ) ){
								$out .= '<div class="post-excerpt">'.malina_get_the_content().'</div>';
							} else {
								$out .= '<div class="post-excerpt">'.get_the_excerpt().'</div>';
							}
							$out .= '</div>';
							if( $display_likes || $display_read_time || $display_views || (comments_open() && $display_comments) ) {
								$out .= '<div class="post-meta footer-meta">';
								if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
								if( $display_read_time ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
								if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
								if( comments_open() && $display_comments ){
									$out .= '<div class="meta-comment">'.malina_comments_number( get_the_ID() ).'</div>';
								}
								$out .= '<div class="post-more"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark"><i class="la la-long-arrow-right"></i></a></div>';
								$out .= '</div>';
							}
							$out .= '</div>';
						$out .= '</div>';
					$out .= '</article>';
					} elseif( $post_style == 'style_5_2' ) {
						$classes = str_replace('sticky ', '', $classes);
						$out .= '<article class="span12 post-size style_5 style_5_2 '.$classes.'">';
							$out .= '<div class="post-content-container '.$text_align.'">';
								$out .= '<div class="post-img-side">';
								$out .= malina_get_post_format_content(false, $thumbsize);
								$out .= '</div>';
								$out .= '<div class="post-content-side">';
									if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
									$out .= '<header class="title">';
									$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
									$out .= '</header>';
								$out .= '<div class="post-content">';
								if( malina_post_has_more_link( get_the_ID() ) ){
									$out .= '<div class="post-excerpt">'.malina_get_the_content().'</div>';
								} else {
									$out .= '<div class="post-excerpt">'.get_the_excerpt().'</div>';
								}
								$out .= '</div>';
								if( $display_likes || $display_read_time || $display_views || (comments_open() && $display_comments) || $display_date ) {
									$out .= '<div class="post-meta footer-meta">';
									if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
									if( $display_date ) $out .= '<div class="post-date">'.esc_html__('Posted', 'malina').' '.get_the_time(get_option('date_format')).'</div>';
									if( $display_read_time ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
									if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
									if( comments_open() && $display_comments ){
										$out .= '<div class="meta-comment">'.malina_comments_number( get_the_ID() ).'</div>';
									}
									$out .= '</div>';
								}
								$out .= '</div>';
							$out .= '</div>';
						$out .= '</article>';
					} elseif($post_style == 'style_6') {
						$classes = str_replace('sticky ', '', $classes);
						$out .= '<article class="post-size '.$columns.' '.$post_style.' '.$classes.'">';
							$out .= '<div class="post-content-container '.$text_align.'">';
								$out .= '<div class="post-img-block">';
								if( $display_date ) $out .= '<div class="label-date'.$date_on_hover.'"><span class="day">'.get_the_time('d', get_the_ID() ).'</span><span class="month">'.get_the_time('M', get_the_ID() ).'</span></div>';
								$out .= malina_get_post_format_content(false, $thumbsize);
								$out .= '</div>';
								$out .= '<div class="post-content-block">';
									$out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
									$out .= '<header class="title">';
									$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
									$out .= '</header>';
								if( $excerpt_count != '0' ){	
									$out .= '<div class="post-content">';
									$out .= '<div class="post-excerpt">'.get_the_excerpt().'</div>';
									$out .= '</div>';
								}
								if( function_exists('MalinaSharebox') ){
									$out .= '<div class="meta-sharebox"><i class="la la-share-alt"></i>';
										$out .= MalinaSharebox(get_the_ID(), false);
									$out .= '</div>';
								}
								if( $display_likes || $display_read_time || $display_views || (comments_open() && $display_comments) ) {
									$out .= '<div class="post-meta footer-meta">';
									if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
									if( $display_read_time ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
									if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
									if( comments_open() && $display_comments ){
										$out .= '<div class="meta-comment">'.MalinaCommentsNumber( get_the_ID() ).'</div>';
									}
									$out .= '</div>';
								}

								$out .= '</div>';
							$out .= '</div>';
						$out .= '</article>';
					} elseif($post_style == 'style_7') {
						static $i = 0;
						$i++;
						$classes = str_replace('sticky ', '', $classes);
						if( $i == 1){
							$columns = 'span8';
							$thumbsize = 'post-thumbnail';
						} else {
							$columns = 'span4';
							$thumbsize = 'thumbnail';
						}
						$out .= '<article class="post-size '.$columns.' '.$post_style.' '.$classes.'">';
							$out .= '<div class="post-content-container textleft">';
								$out .= '<div class="post-img-block">';
								$out .= malina_get_post_format_content(false, $thumbsize);
								$out .= '</div>';
								$out .= '<div class="post-content-block">';
									if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
									$out .= '<header class="title">';
									$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
									$out .= '</header>';
								if( $i == 1 && $excerpt_count != '0' ){	
									$out .= '<div class="post-content">';
									$out .= '<div class="post-excerpt">'.get_the_excerpt().'</div>';
									$out .= '</div>';
								}
								if( function_exists('MalinaSharebox') && $i==1 ){
									$out .= '<div class="meta-sharebox"><i class="la la-share-alt"></i>'.MalinaSharebox(get_the_ID(), false).'</div>';
								}

								$out .= '</div>';
							$out .= '</div>';
						$out .= '</article>';
					} elseif( $post_style == 'style_8' ) {
						$classes = str_replace('sticky ', '', $classes);
						$out .= '<article class="post-size '.$columns.' '.$post_style.' '.$classes.'">';
							$out .= '<div class="post-content-container '.$text_align.'">';
								$out .= '<div class="post-img-block">';
								$out .= malina_get_post_format_content(false, $thumbsize);
								$out .= '</div>';
								$out .= '<div class="post-content-block">';
									if( $display_date ) $out .= '<div class="meta-date">'.get_the_time(get_option('date_format'), get_the_ID() ).'</div>';
									$out .= '<header class="title">';
									$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_html__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
									$out .= '</header>';
								$out .= '<div class="post-content">';
								if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
								$out .= '<div class="post-excerpt">'.get_the_excerpt().'</div>';
								if( $show_readmore ){
									$out .= '<a class="readmore" href="'.get_the_permalink().'">'.apply_filters( 'malina_recent_post_readmore_text', esc_html__("Read more", "malina") ).'</a>';
								}
								$out .= '</div>';
								if( $display_likes || $display_read_time || $display_views || (comments_open() && $display_comments) ) {
									$out .= '<div class="post-meta footer-meta">';
									if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
									if( $display_read_time ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
									if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
									if( comments_open() && $display_comments ){
										$out .= '<div class="meta-comment">'.MalinaCommentsNumber( get_the_ID() ).'</div>';
									}
									$out .= '</div>';
								}
								$out .= '</div>';
							$out .= '</div>';
						$out .= '</article>';
					} elseif($post_style == 'style_9'){
						$classes = str_replace('sticky ', '', $classes);
						$out .= '<article class="post-size span12 '.$post_style.' '.$classes.' '.$text_align.'">';
							$out .= '<div class="post-block-title">';
								if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
								$out .= '<header class="title">';
								$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
								$out .= '</header>';
							$out .= '</div>';
							$out .= '<div class="post-img-block">';
								if( $display_date ) $out .= '<div class="label-date'.$date_on_hover.'"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
								$out .= malina_get_post_format_content(false, 'large');
							$out .= '</div>';	
							$out .= '<div class="post-content">';
								if( malina_post_has_more_link( get_the_ID() ) ){
									$out .= malina_get_the_content();
								} else {
									$out .= get_the_excerpt();
								}
								$out .= '</div>';
								$out .= '<div class="post-meta'.$bottom_lines.'">';
									$out .= '<div class="meta">';
										if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
										if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
										if( $display_read_time ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
										if( comments_open() && $display_comments ){
											$out .= '<div class="meta-comment">'.malina_comments_number( get_the_ID() ).'</div>';
										}
									$out .= '</div>';
									if( $show_readmore )
										$out .= '<div class="post-more"><a href="'.esc_url(get_the_permalink()).'" rel="bookmark"><span>'.esc_html__('Read more', 'malina').'</span><i class="la la-long-arrow-right"></i></a></div>';
									if(function_exists('MalinaSharebox')){
										$out .= MalinaSharebox( get_the_ID() );
									} else {
										$out .= '<div style="width:25%;"></div>';
									}
								$out .= '</div>';
						$out .= '</article>';
					} elseif( $post_style == 'style_10' ) {
						$classes = str_replace('sticky ', '', $classes);
						$out .= '<article class="post-size '.$columns.' '.$post_style.' '.$classes.'">';
							$out .= '<div class="post-content-container '.$text_align.'">';
								$out .= '<div class="post-img-block">';
									$out .= malina_get_post_format_content(false, $thumbsize);
								$out .= '</div>';
								$out .= '<div class="post-content-block">';
									if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
									$out .= '<header class="title">';
									$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
									$out .= '</header>';
								$out .= '<div class="post-content">';
								if( malina_post_has_more_link( get_the_ID() ) ){
									$out .= '<div class="post-excerpt">'.malina_get_the_content().'</div>';
								} elseif( (int)$excerpt_count > 0 ) {
									$out .= '<div class="post-excerpt">'.get_the_excerpt().'</div>';
								}
								$out .= '</div>';
								if( $display_likes || $display_read_time || $display_views || (comments_open() && $display_comments) ) {
									$out .= '<div class="post-meta footer-meta">';
									if( $display_date ) $out .= '<div class="meta-date">'.get_the_time(get_option('date_format')).'</div>';
									if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
									if( $display_read_time ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
									if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
									if( comments_open() && $display_comments ){
										$out .= '<div class="meta-comment">'.malina_comments_number( get_the_ID() ).'</div>';
									}
									$out .= '</div>';
								}
								$out .= '</div>';
							$out .= '</div>';
						$out .= '</article>';
					} else {
						$classes = str_replace('sticky ', '', $classes);
						$out .= '<article class="post-size '.$columns.' '.$post_style.' '.$classes.'">';
							$out .= '<div class="post-content-container '.$text_align.'">';
								$out .= '<div class="post-img-block">';
									if( $display_date ) $out .= '<div class="label-date'.$date_on_hover.'"><span class="day">'.get_the_time('d').'</span><span class="month">'.get_the_time('M').'</span></div>';
									$out .= malina_get_post_format_content(false, $thumbsize);
								$out .= '</div>';
								$out .= '<div class="post-content-block">';
								if( $display_categories ) $out .= '<div class="meta-categories">'.get_the_category_list(', ').'</div>';
									$out .= '<header class="title">';
									$out .= '<h2 itemprop="headline"><a href="'.get_the_permalink().'" title="'.esc_attr__('Permalink to', 'malina').' '.esc_attr(the_title_attribute('echo=0')).'" rel="bookmark">'.get_the_title().'</a></h2>';
									$out .= '</header>';
									
								$out .= '<div class="post-content">';
								
								$out .= '<div class="post-excerpt">'.get_the_excerpt().'</div>';
								
								$out .= '</div>';
								if( $display_likes || $display_read_time || $display_views || (comments_open() && $display_comments) ) {
									$out .= '<div class="post-meta footer-meta">';
									if( $display_likes ) $out .= '<div class="post-like">'.getPostLikeLink(get_the_ID()).'</div>';
									if( $display_read_time ) $out .= '<div class="post-read">'.malina_calculate_reading_time().'</div>';
									if( $display_views ) $out .= '<div class="post-view">'.MalinaGetPostViews(get_the_ID()).'</div>';
									if( comments_open() && $display_comments ){
										$out .= '<div class="meta-comment">'.malina_comments_number( get_the_ID() ).'</div>';
									}
									$out .= '</div>';
								}
								$out .= '</div>';
							$out .= '</div>';
						$out .= '</article>';
					}

				}
			$out .= '</div>';
			if( $pagination == 'true' && get_next_posts_link() ) {
				$out .= '<div id="pagination" class="hide">'.get_next_posts_link().'</div>';
				$out .= '<div class="loadmore-container"><a href="#" class="loadmore button"><span>'.esc_html(get_theme_mod('malina_button_loadmore_text', esc_html__('Load More', 'malina'))).'</span></a></div>';
			} elseif( $pagination == 'infinitescroll' && get_next_posts_link() ) {
				$out .= '<div id="pagination" class="hide pagination-'.$post_section_id.'">'.get_next_posts_link().'</div>';
			} elseif ( $pagination == 'next_prev' && (get_next_posts_link() || get_previous_posts_link() ) ){
				$out .= '<div id="pagination" class="pagination pagination_next_prev">';
				$out .= get_previous_posts_link(esc_html__('prev', 'malina'));
				$out .= get_next_posts_link(esc_html__('next', 'malina'));
				$out .= '</div>';
			} else {
				if(malina_custom_pagination() != '') {
					$out .= '<div id="pagination">'.malina_custom_pagination().'</div>';
				}
			}
			$out .= '</div>';
			echo ''.$out;
		} else { ?>
				
				<h2><?php esc_html_e('Not Found', 'malina') ?></h2>
				
			<?php } ?>
		</div>
	</div>

<?php if($sidebar != 'none' && is_active_sidebar('blog-widgets') ){
		get_sidebar();
	} 
?>
</div>

<?php get_footer(); ?>
