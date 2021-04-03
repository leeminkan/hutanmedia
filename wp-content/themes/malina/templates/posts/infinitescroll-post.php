<?php
	wp_enqueue_style('owl-carousel');
	wp_enqueue_script('owl-carousel');
	$autoplay = rwmb_get_value('malina_gallery_autoplay');
	$loop = rwmb_get_value('malina_gallery_loop');
	$autoplay = $autoplay ? 'true' : 'false';
	$loop = $loop ? 'true' : 'false';
	$autoheight = rwmb_get_value('malina_gallery_autoheight');
	$owl_custom = 'function malina_update_single_post_carousel_2(){
			var owl = jQuery(".single-post-gallery-thumbs").owlCarousel({
	            items:1,
	            autoplay:'.$autoplay.',
	            singleItem:true,
	            loop:'.$loop.',
	            nav:false,
	            navRewind:false,
	            navText: [ \'<i class="la la-angle-left"></i>\',\'<i class="la la-angle-right"></i>\' ],
	            dots:false,
	            autoHeight:'.$autoheight.',
	            themeClass: "owl-gallery",
	            thumbs:true,
    			thumbsPrerendered:true
			});
	}';
	$owl_custom .= 'function malina_update_single_post_carousel(){
			var owl = jQuery(".single-post-gallery").owlCarousel({
	            items:1,
	            autoplay:'.$autoplay.',
	            singleItem:true,
	            loop:'.$loop.',
	            nav:true,
	            navRewind:false,
	            navText: [ \'<i class="la la-long-arrow-left"></i>\',\'<i class="la la-long-arrow-right"></i>\' ],
	            dots:false,
	            autoHeight:'.$autoheight.',
	            themeClass: "owl-gallery"
			});
	}';
    $owl_custom .= 'function malina_update_widget_post_carousel(){
            var owl = jQuery(".widget_sliderposts .sliderposts").owlCarousel(
            {
                items: 1,
                margin: 0,
                dots: false,
                nav: true,
                navText: [\'<i class="la la-angle-left"></i>\',\'<i class="la la-angle-right"></i>\'],
                autoplay: false,
                responsiveClass:true,
                loop: '.$loop.',
                smartSpeed: 450,
                autoHeight: true,
                themeClass: "owl-widget-sliderposts",
                responsive:{
                    0:{
                        items:1,
                    },
                    1199:{
                        items:1
                    }
                }
            });
    }';
	wp_add_inline_script('owl-carousel', $owl_custom);
	$custom_js = '(function($) {$(window).load(function(){
        var next_count = 1;
        var canBeLoaded = true;
        $(".nextpost a").attr("id", "next"+next_count);
        $(window).scroll(function(){
            if( $(document).scrollTop() > ( $("#page-wrap-blog").position().top + $("#page-wrap-blog").height() - $(window).height()) && canBeLoaded == true ){
                canBeLoaded = false;
                var next_link = $("#next"+next_count).attr("href");
                $(".load_next_post_anim").addClass("active");
                if(typeof(next_link) != "undefined"){
                    $.ajax({
                        type: "GET",
                        url: next_link,
                        data: {},
                        async: false,
                        success: function(data){
                            if(data){
                                next_count = ++next_count;
                                var result = $(data);
                                result.find(".nextpost a").attr("id","next"+next_count);
                                setTimeout(function(){
                                    $("#page-wrap-blog").find(".wrap-single-post").last().after(result.find(".wrap-single-post"));
                                    canBeLoaded = true;
                                    malina_update_sinlge_post_image_height();
                                    malina_update_single_post_carousel();
                                    malina_update_single_post_carousel_2();
                                    malina_update_widget_post_carousel();
                                }, 600);
                            }
                        },
                        error: function(){
                            canBeLoaded = false;
                            $(".load_next_post_anim").remove();
                            $("#page-wrap-blog").find(".wrap-single-post").last().after("<h3 class=\'no_next_post_load\'>"+$(".nextpost .no_next_post").text()+"</h3>");
                            setTimeout(function(){ $("#page-wrap-blog").find(".no_next_post_load").fadeOut("slow"); }, 1200);
                        }
                    });
                } else {
                    setTimeout(function(){
                        canBeLoaded = false;
                        $(".load_next_post_anim").remove();
                        $("#page-wrap-blog").find(".wrap-single-post").last().after(\'<h3 class="no_next_post_load">\'+$(".nextpost .no_next_post").text()+"</h3>");
                        setTimeout(function(){ $("#page-wrap-blog").find(".no_next_post_load").fadeOut("slow"); }, 1200);
                    }, 800);
                }
            }
        });
    });
})(jQuery);';
wp_add_inline_script('owl-carousel', $custom_js);
	$prevURL = get_previous_post_link();
	if($prevURL == ''){
		$prevURL = '<span class="no_next_post">'.esc_html__('It was the oldest post', 'malina').'</span>';
	}
	echo '<div class="nextpost hide">'.$prevURL.'</div>';
?>