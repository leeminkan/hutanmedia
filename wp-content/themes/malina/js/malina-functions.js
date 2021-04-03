(function($) {
    "use strict";
    $.fn.visible = function(partial) {
        var $t        = $(this),
        $w            = $(window),
        viewTop       = $w.scrollTop(),
        viewBottom    = viewTop + $w.height(),
        _top          = $t.offset().top + $t.height()/5,
        _bottom       = _top + $t.height(),
        compareTop    = partial === true ? _bottom : _top,
        compareBottom = partial === true ? _top : _bottom;

        return ((compareBottom <= viewBottom) && (compareTop >= viewTop));
    };
    $.fn.clickToggle = function(a,b) {
        function cb(){
            [b,a][this._tog^=1].call(this);
        }
        return this.on("click", cb);
    };
})(jQuery);
function malina_is_mobile(){
    var windowWidth = window.screen.width < window.outerWidth ? window.screen.width : window.outerWidth;
    if(('ontouchstart' in document.documentElement) || windowWidth < 783){
        return true;
    } else {
        return false;
    }
}
function malina_header_fix()
{
    var win             = jQuery(window),
        element         = jQuery('.header7 .header-top, .header1 > #navigation-block, .header8 #navigation-block'),
        main            = jQuery('.header-version1 #main, .header-version7 #main, .header-version8 #main' ),
        header_height   = jQuery('#header.header1').outerHeight() + jQuery('#wpadminbar').outerHeight(),
        set_height      = function()
        {
            if (win.scrollTop() > header_height ) {
                element.addClass( 'fixed-nav header-scrolled');
                newP = element.height();
            } else {
                element.removeClass( 'fixed-nav header-scrolled');
                newP = 0;
            }
            main.css({
                paddingTop: newP + 'px'
            });
        }

        if(malina_is_mobile() || !jQuery('#header-main.fixed_header').length || ((win.height()+header_height) > jQuery('body').height()) ) return false;
        win.scroll(set_height);
        set_height();
}
function malina_header4_fix()
{
    var win             = jQuery(window),
        element         = jQuery('#header.header4, #header.header5, #header.header-custom'),
        menu_link       = jQuery('#header.header-custom #navigation-block ul.wp-megamenu > li, #header.header-custom #navigation-block ul.menu > li, #header.header4 #navigation-block ul.wp-megamenu > li, #header.header4 #navigation-block ul.menu > li, #header.header5 #navigation-block ul.wp-megamenu > li:not(.menu-item-logo), #header.header5 #navigation-block ul.menu > li:not(.menu-item-logo)'),
        main            = jQuery('.header-version4 #main, .header-version5 #main, .header-custom #main'),
        logo            = jQuery('#header.header4 .logo, #header.header5 .logo'),
        header_height   = element.height(),
        logo_h          = logo.height(),
        set_height      = function()
        {
            jQuery('#header.header4 #navigation-block, #header.header5 #navigation-block, #header.header-custom #navigation-block').removeClass('fixed-nav');
            header_height  = element.outerHeight();
            if( win.scrollTop() > header_height ){
                element.addClass( 'fixed-nav header-scrolled');
                logo_h = logo.outerHeight();
                main.css({
                    paddingTop: (header_height) + 'px'
                });
            } else {
                element.removeClass( 'fixed-nav header-scrolled');
                main.css({
                    paddingTop:'0px'
                });
            }
        }

        if(malina_is_mobile() || !jQuery('#header-main.fixed_header').length || ((win.height()+header_height) > jQuery('body').height()) ) return false;
        
        win.scroll(set_height);
        set_height();
        
}
function malina_home_parallax(element) {
    jQuery(window).scroll(function () {
        if(!jQuery(element).length){
            return false;
        }
        var scrolled = jQuery(window).scrollTop();
        var initY = jQuery(element).offset().top;
        var height = jQuery(element).height();
        var endY  = initY + jQuery(element).height();
        if(jQuery(element).visible(true)){
            var diff = scrolled - initY
            var ratio = Math.round((diff / height) * 100)
            jQuery(element).css('transform', 'translateY('+parseInt((ratio * 1.5))+'px)');
        } 

    });
}
function malina_elementor_parallax(element) {
    jQuery(window).scroll(function () {
        if(!jQuery(element).length){
            return false;
        }
        var scrolled = jQuery(window).scrollTop();
        initY = 0;
        var height = jQuery(element).outerHeight();
        if(jQuery(element).visible(true)){
            var diff = scrolled - initY
            var ratio = -Math.round((diff / height)*40)
            jQuery(element).css('background-position-y', parseInt((ratio * 1.5))+'px');
        } 
    });
}
function malina_update_sinlge_post_image_height(){
    var h = jQuery(window).height(),
    hl = jQuery('#header').height() + jQuery('#wpadminbar').height();
    var hf = h-hl;
    if( !malina_is_mobile() ){
        jQuery('.single .fullwidth-image-alt:not(.fullwidth-image-alt2) .post-img').css('height', hf);
        jQuery('.post-slider.fullwidth.two_per_row .post-slider-item').css('height', hf - 130)
    } else {
        return false;
    }
}
jQuery( document ).ready( function($) {
	"use strict";
    malina_header_fix();
    malina_header4_fix();
    malina_home_parallax('.fullwidth-image-alt:not(.fullwidth-image-alt2) .post-img img');
    malina_elementor_parallax('.parallax-section');
    $('body').on('click', 'a[href^="#"]', function(event){
        if( $(this).parent().parent('.tabs').length || $(this).parents('.vc_tta').length || $(this).hasClass('popup-video-html5')){
            return;
        }
        var $href = $(this).attr('href');
        var hash = $href.substring($href.indexOf('#'));
        var elemTo = $(hash);
        if(elemTo.length){
            var $anchor = $(hash).offset();
            var headerH = jQuery('#header').height() + jQuery('#wpadminbar').height() + 60;
            $('html, body').animate({ scrollTop: $anchor.top-headerH }, 900);
            return false;
        }
    });
    $('.woocommerce-product-images p').each(function(index, target){
        var image_url = $(target).data('zoomimg');
        $(target).zoom({url:image_url});
    });
    $('body').on('click', '.video-container .video-placeholder', function(ev){
        $(this).delay(400).fadeOut('normal');
        if( $(this).next('iframe').length ){
            $(this).next('iframe')[0].src += "&autoplay=1";
        }
        ev.preventDefault();
    });
    $('#header .search-link .search-button, #mobile-header .search-link .search-button').click(
        function(){
            $('#header .search-area, #mobile-header-block .search-area').addClass('opened');
            return false;
        }
    );
    $('.search-area .close-search').click(function(){
        $(this).parent('.search-area').removeClass('opened');
        return false;
    });
    $('.hidden-area-button a').click(function(){
        return false;
    });
    $('.hidden-area-button a').clickToggle(
        function(){
            $(this).addClass('opened');
            $('#hidden-area-widgets').addClass('opened');
            return false;
        },function(){
            $(this).removeClass('opened');
            $('#hidden-area-widgets').removeClass('opened');
            return false;
        }
    );
    $('#hidden-area-widgets a.close-button').click(function(){
        $(this).parent('#hidden-area-widgets').removeClass('opened');
        $('.hidden-area-button a').click();
        return false;
    });
    $('#subscribe-popup .close-button').click(function(){
        $('#subscribe-popup').removeClass('opened');
        return false;
    });
    malina_update_sinlge_post_image_height();
    $(window).resize(function(){
        malina_update_sinlge_post_image_height();
    });
    if( !malina_is_mobile() ){
        $(window).scroll(function(){
            //malina_update_sinlge_post_image_height();
            if($(window).scrollTop() > 200){
                $("#back-to-top").fadeIn(200);
            } else{
                $("#back-to-top").fadeOut(200);
            }
            if($(window).scrollTop() > ($(document).height() - $('#footer').outerHeight() - 250)){
                $("#header.header8 .socials-block").fadeOut(200);
            } else {
                $("#header.header8 .socials-block").fadeIn(200);
            }
        });
    }
    $('#back-to-top').click(function() {
          $('html, body').animate({ scrollTop:0 }, '800');
          return false;
    });
    malina_home_parallax();
    $('.widget_nav_menu .menu .menu-item').on("click", function(e){
        var submenu = $(this).children('.sub-menu');
        var parent_submenu = $(this).parent();
        if(e.target.tagName.toLowerCase() === 'a') return;
        submenu.toggleClass('sub-menu-show'); //then show the current submenu
        if(submenu.hasClass('sub-menu-show')){
            $('.widget_nav_menu .menu').css('height', submenu.height()+'px');
        } else {
            $('.widget_nav_menu .menu').css('height', parent_submenu.height()+'px');
        }
        if(!$('.sub-menu').hasClass('sub-menu-show')){
            $('.widget_nav_menu .menu').css('height', 'auto');
        } else {
        }
        e.stopPropagation();
        e.preventDefault();
    });

    $('.wpmm-vertical-tabs-nav li a').click(function(){
        var url = $(this).attr('href');
        window.location = url;
    });
    $(window).load(function(){
        $('.page-loading').fadeOut('fast').remove();
        
        if( $('.herosection_text').length ){
            if( $('.herosection_text').visible(true) ){
                $('.herosection_text').addClass('animate-hello');
            }
        }
        $(window).scroll(function(){
            if( $('.herosection_text').length ){
                if( $('.herosection_text').visible(true) ){
                    $('.herosection_text').addClass('animate-hello');
                }
            }
        });
    });

    $("body").on("click", '.qty-button', function() {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();

        if ($button.text() == "+") {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 0;
            }
        }
        $button.parent().find("input").val(newVal).change();
        $('button[name="update_cart"]').click();
    });
});
