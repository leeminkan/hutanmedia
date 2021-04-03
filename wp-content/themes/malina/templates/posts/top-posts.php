<?php  
	$args=array(
		'showposts'=>get_theme_mod('malina_top_stories_post_count', '2'),
	    'orderby' => 'comment_count',
	    'post__not_in' => array($post->ID),
	    'order' => 'DESC',
	    'ignore_sticky_posts' => 'true'
	);

	if( get_theme_mod( 'malina_single_post_top_stories_orderby', 'post_views_count' ) == 'post_views_count' ){
		$args['meta_key'] = 'post_views_count';
		$args['orderby'] = 'meta_value_num';
	} elseif( get_theme_mod( 'malina_single_post_top_stories_orderby', 'post_views_count' ) == 'votes_count' ){
		$args['meta_key'] = 'votes_count';
		$args['orderby'] = 'meta_value_num';
	}
	$columns = get_theme_mod('malina_top_stories_columns', 'span6');
	switch ($columns) {
		case 'span6':
			$thumbsize = 'post-thumbnail';
			break;
		default:
			$thumbsize = 'medium';
			break;
	}
	$my_query = new WP_Query($args);
	$out = '';
	if( $my_query->have_posts() ) {
		$out .='<div id="top-posts" class="aligncenter">';
		$out .= '<h2><span>'. esc_html__('Top stories', 'malina').'</span></h2>';
		$out .= '<div class="row-fluid">';
		while ($my_query->have_posts()) : $my_query->the_post(); 
        $out .= '<div class="top-posts-item '.$columns.'">';
        if( has_post_thumbnail() ) {
			$out .= '<figure class="post-img">';
			$out .= '<a href="'.esc_url(get_permalink()).'">';
			$out .= '<div class="overlay-bg"></div>';
			$out .= get_the_post_thumbnail($post->ID, $thumbsize).'</figure>';
			$out .= '</a>';
		}
		$out .= '<div class="overlay-data">';
		$out .= '<h3 class="top-item-title"><a href="'.esc_url(get_permalink()).'" title="' . esc_attr(the_title_attribute('echo=0')) . '">'.get_the_title().'</a></h3>';
        $out .= '<div class="meta-date">'.get_the_time(get_option('date_format')).'</div>';
        $out .= '</div>';
        $out .= '</div>';
		endwhile;
		$out .= '<div class="clearfix"></div>';
  		$out .= '</div>';
  		$out .= '</div>';
		echo ''.$out;
		wp_reset_postdata();
	}	
?>