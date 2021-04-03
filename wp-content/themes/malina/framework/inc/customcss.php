<?php
if(!function_exists('malina_compress')){
    function malina_compress( $minify ){
    /* remove comments */
        $minify = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $minify );

        /* remove tabs, spaces, newlines, etc. */
        $minify = str_replace( array("\r\n", "\r", "\n", "\t", '; ', '  ', '    ', '    ',': ', ', ','{ ','}.'), array('','','','',';','','','',':',',','{','} .'), $minify );
            
        return $minify;
    }
}
/**
 * Add color styling from theme
 */
if(!function_exists('HexToRGB')){
   function HexToRGB($hex, $grad=0) {
        $hex = preg_replace("/#/", "", $hex);
        $color = array();

        if(strlen($hex) == 3) {
            $color['r'] = hexdec(substr($hex, 0, 1) . $r)+$grad;
            $color['g'] = hexdec(substr($hex, 1, 1) . $g)+$grad;
            $color['b'] = hexdec(substr($hex, 2, 1) . $b)+$grad;
        }
        else if(strlen($hex) == 6) {
            $color['r'] = hexdec(substr($hex, 0, 2))+$grad;
            $color['g'] = hexdec(substr($hex, 2, 2))+$grad;
            $color['b'] = hexdec(substr($hex, 4, 2))+$grad;
        }

        return implode(",", $color);
    } 
}

function malina_styles_custom() {
?>
<?php ob_start(); ?>
body {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_body_font_family', 'Open Sans' )); ?>';
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_body_font_size', '17px' )); ?>;
    line-height: <?php echo esc_attr(get_theme_mod( 'malina_body_line_height', '30px' )); ?>;
    color: <?php echo esc_attr(get_theme_mod('malina_body_color', '#333333')); ?>;
    <?php if(get_theme_mod('malina_body_background_color', false)){ echo 'background-color:'.get_theme_mod('malina_body_background_color', '#ffffff').';';} ?>
}
body {
    padding-top: <?php echo esc_attr(get_theme_mod('malina_body_top_padding', '0')); ?>px;
    padding-right: <?php echo esc_attr(get_theme_mod('malina_body_right_padding', '0')); ?>px;
    padding-bottom: <?php echo esc_attr(get_theme_mod('malina_body_bottom_padding', '0')); ?>px;
    padding-left: <?php echo esc_attr(get_theme_mod('malina_body_left_padding', '0')); ?>px;
}
.blog-posts .post .post-content {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_grid_posts_font_family', 'Open Sans' )); ?>';
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_grid_posts_font_size', '14px' )); ?>;
    line-height: <?php echo esc_attr(get_theme_mod( 'malina_grid_posts_line_height', '26px' )); ?>;
    color: <?php echo esc_attr(get_theme_mod('malina_grid_posts_color', '#1b1c1d')); ?>;
}
.blog-posts .post.sticky .post-content {
    font-size: <?php echo str_replace('px','', esc_attr(get_theme_mod( 'malina_grid_posts_font_size', '14px' )) ) + 1; ?>px;
}
#content .has-regular-font-size {
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_body_font_size', '13px' )); ?>;
}
<?php 
    $body_background = rwmb_get_value( 'malina_body_background' );
    if($body_background){
        echo 'body.page-id-'.get_the_ID().' {';
        echo 'background-color: '.$body_background.';';
        echo '}'; 
    } 
?>

a {
   color: <?php echo esc_attr(get_theme_mod('malina_links_color', '#d87b4d')); ?>; 
}
a:hover, .meta-categories a:hover {
   color: <?php echo esc_attr(get_theme_mod('malina_links_color_hover', '#1c1d1f')); ?>; 
}
#header {
	<?php 
    echo "background-color: rgba(".HexToRGB(get_theme_mod('malina_header_bg_color', '#ffffff')).", ".get_theme_mod('malina_header_bg_color_opacity', '1').");";
    if(get_theme_mod('malina_header_image', '') != ''){
        echo "background-image: url(".get_theme_mod('malina_header_image', '').");";
        echo "background-size: ".get_theme_mod('malina_header_bg_size', 'auto').";";
        echo "background-position: 50% 50%;";
    }
    if( get_theme_mod('malina_header_bottom_border_width', '1') != '' ){
        echo "border-bottom:".get_theme_mod('malina_header_bottom_border_width', '1')."px solid ".get_theme_mod('malina_header_border_color', '#e5e6e8').";";
    }
    echo "border-color: ".get_theme_mod('malina_header_border_color', '#e5e6e8').";";

    ?>
}

#header-main {
    <?php
        if( get_theme_mod('malina_header_top_border_width', '') != '' && get_theme_mod('malina_header_top_border_width', '') != 'px' ){
            echo "border-top:".get_theme_mod('malina_header_top_border_width', '5')."px solid ".get_theme_mod('malina_header_top_border_color', '#e5e6e8').";";
        }
    ?>
}
#header.header8 .container:not(.header-fullwidth) #navigation-block {
    <?php 
        if( get_theme_mod('malina_header_bottom_border_width', '1') != '' ){
            echo "border-bottom:".get_theme_mod('malina_header_bottom_border_width', '1')."px solid ".get_theme_mod('malina_header_border_color', '#e5e6e8').";";
        }
    ?>
}
#header.header8 .container.header-fullwidth {
    <?php 
        if( get_theme_mod('malina_header_bottom_border_width', '1') != '' ){
            echo "border-bottom:".get_theme_mod('malina_header_bottom_border_width', '1')."px solid ".get_theme_mod('malina_header_border_color', '#e5e6e8').";";
        }
    ?>
}
#header.header4 > .container > .span12 #navigation-block {
    <?php echo "border-color: ".get_theme_mod('malina_header_border_color', '#e5e6e8')." !important;"; ?>
}
#header.header-scrolled, .header-top.fixed-nav {
    <?php 
        echo "border-bottom-color: ".get_theme_mod('malina_header_border_color', '#e5e6e8')." !important;";
        echo "background-color: rgba(".HexToRGB(get_theme_mod('malina_header_bg_color', '#ffffff')).", 1);"; 
    ?>
}
#header.header6.header-scrolled {
    <?php 
        echo "border-bottom: 1px solid ".get_theme_mod('malina_header_border_color', '#e5e6e8')." !important;";
        echo "background-color: rgba(".HexToRGB(get_theme_mod('malina_header_bg_color', '#ffffff')).", 1); !important"; 
    ?>
}
#mobile-header {
    <?php 
        echo "background-color: ".get_theme_mod('malina_header_bg_color', '#ffffff').";";
        echo "border-color: ".get_theme_mod('malina_header_border_color', '#e5e6e8').";";
    ?>    
}
#side-header, #side-header-vertical {
    <?php
    echo "background-color: rgba(".HexToRGB(get_theme_mod('malina_header_bg_color', '#ffffff')).", ".get_theme_mod('malina_header_bg_color_opacity', '1').");";
    if(get_theme_mod('malina_header_image', '') != ''){
        echo "background-image: url(".get_theme_mod('malina_header_image', '').");";
        echo "background-size: ".get_theme_mod('malina_header_bg_size', 'auto').";";
        echo "background-position: 50% 50%;";
    }
    echo "border-color: ".get_theme_mod('malina_header_border_color', '#e5e6e8').";";
    ?>
}
#side-header {
   <?php 
        echo "background-color: ".get_theme_mod('malina_header_bg_color', '#ffffff').";";
        if(get_theme_mod('malina_header_image', '') != ''){
            echo "background-image: url(".get_theme_mod('malina_header_image', '').");";
            echo "background-size: ".get_theme_mod('malina_header_bg_size', 'auto').";";
            echo "background-position: 50% 50%;";
        }
    ?> 
}
#header #navigation-block {
    <?php echo "background-color: ".get_theme_mod('malina_header_bg_color', '#ffffff').";"; ?>
}
<?php
$header_background = rwmb_get_value( 'malina_header_background' );
if(!empty($header_background)){
    echo '.page-id-'.get_the_ID().' #header, .page-id-'.get_the_ID().' #side-header, .page-id-'.get_the_ID().' #side-header-vertical {';
    rwmb_the_value('malina_header_background');
    echo '}';
    if( isset($header_background['color']) ){
        echo '.page-id-'.get_the_ID().' #side-header .overlay-bg {background-color:rgba('.HexToRGB($header_background['color']).', 0.75);}';
        echo '.page-id-'.get_the_ID().' #header #navigation-block {background-color:rgba('.HexToRGB($header_background['color']).', 1);}';
    }
    
}
if( get_theme_mod('malina_header_socials_color', '') !== '' ){
    echo '#header .social-icons li a {color:'.get_theme_mod('malina_header_socials_color', '').';}';
}
if( get_theme_mod('malina_navigation_disable_dots', true ) ){
    echo '.menu > li > a:after, .menu > li > a:before, #navigation-block ul.wp-megamenu > li > a:after, #navigation-block ul.wp-megamenu > li > a:before {display: none !important;}';
}
?>

.header-top {
    <?php
        if( get_theme_mod('malina_header_top_border_width', '1') != '' ){
            echo "border-bottom:".get_theme_mod('malina_header_top_border_width', '1')."px solid ".get_theme_mod('malina_header_border_color', '#e5e6e8').";";
        }
    ?>
}
<?php
if(get_theme_mod('malina_menu_dropdown_bg', '#fff') === '#fff'){
    $dropdown_menu_bg = get_theme_mod('malina_header_bg_color', '#ffffff');
} else {
    $dropdown_menu_bg = get_theme_mod('malina_menu_dropdown_bg', '#ffffff');
}
?>
#navigation li ul {
    background-color: rgba(<?php echo HexToRGB($dropdown_menu_bg); ?>, <?php echo get_theme_mod('malina_menu_dropdown_bg_opacity', '1'); ?>);
}
#mobile-header .dl-menuwrapper ul {
    background-color: <?php echo esc_attr($dropdown_menu_bg); ?>;    
}
#mobile-header .dl-menuwrapper li a {
    background-image: linear-gradient(to right, <?php echo esc_attr(get_theme_mod('malina_menu_dropdown_items_border', '#a5b2cd')); ?> 33%, rgba(255,255,255,0) 0%);
}
#header.header-scrolled #navigation li ul {
    background-color: rgba(<?php echo HexToRGB(get_theme_mod('malina_menu_dropdown_bg', '#ffffff')); ?>, 1);
}
#header:not(.header-custom) .logo img {
    width: <?php echo esc_attr(get_theme_mod( 'malina_media_logo_width', '185' )); ?>px;
}
#header.header4.header-scrolled .logo img, #header.header5.header-scrolled .logo img {
    max-width: <?php echo (int)esc_attr(get_theme_mod( 'malina_media_logo_width', '185' ))/2; ?>px;
}
#header.header5.header-scrolled .menu-item-logo .logo img {
    max-width: <?php echo (int)esc_attr(get_theme_mod( 'malina_media_logo_width', '185' ))/2 + 60; ?>px;
}
#header .logo .logo_text {
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_media_logo_width', '22' )); ?>px;
    letter-spacing:<?php echo esc_attr( get_theme_mod( 'malina_logo_title_letter_spacing', '1.5') ); ?>px;
    color: <?php echo esc_attr(get_theme_mod( 'malina_logo_color', '#1b1c1d' )); ?>;
}
<?php
    if( (int)get_theme_mod( 'malina_media_logo_width', '18' ) < 30){
        echo '#header.header4.header-scrolled .logo .logo_text, #header.header5.header-scrolled .logo .logo_text, #header.header-custom.header-scrolled .logo .logo_text{font-size: '.esc_attr(get_theme_mod( 'malina_media_logo_width', '18' )).'px;}';
    }
?>
#mobile-header .logo img {
    width: <?php echo esc_attr(get_theme_mod( 'malina_media_logo_mobile_width', '90' )); ?>px;
}
#mobile-header .logo .logo_text {
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_media_logo_mobile_width', '18' )); ?>px;
}
#navigation .menu li a,
#hidden-area-widgets .menu li a,
#mobile-header .dl-menuwrapper li a,
#wp-megamenu-main_navigation>.wpmm-nav-wrap ul.wp-megamenu>li>a,
#navigation.vertical .menu > li > a { 
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_menu_font_size', '12px' )); ?>;
    font-weight: <?php echo esc_attr(get_theme_mod( 'malina_menu_font_weight', '500' )); ?>;
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_menu_font_family', 'Montserrat' )); ?>';
    text-transform: <?php echo esc_attr(get_theme_mod( 'malina_menu_transform', 'uppercase' )); ?>;
    color: <?php echo esc_attr(get_theme_mod('malina_menu_item_color', '#2c2e30')); ?>;
    letter-spacing: <?php echo esc_attr(get_theme_mod('malina_menu_letter_spacing', '1.5')); ?>px;
}
#mobile-header .dl-menuwrapper li,
#mobile-header .dl-menuwrapper button.dl-trigger {
    color: <?php echo esc_attr(get_theme_mod('malina_menu_item_color', '#2c2e30')); ?>;
}
.menu > li > a {
    padding-right: <?php echo (int)(get_theme_mod( 'malina_menu_item_padding', '40' ))/2 + 2; ?>px;
    padding-left: <?php echo (int)(get_theme_mod( 'malina_menu_item_padding', '40' ))/2; ?>px;
}
#navigation .menu li ul li a {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_menu_font_family', 'Montserrat' )); ?>';
    font-weight: <?php echo esc_attr(get_theme_mod( 'malina_menu_font_weight', '300' )); ?>;
    color: <?php echo esc_attr(get_theme_mod('malina_menu_item_color', '#1c1d1f')); ?>;
}
input[type="submit"], .button, button[type="submit"], #content .tnp-subscription input.tnp-submit, 
#content .woocommerce #respond input#submit,
#content div.wpforms-container-full .wpforms-form button[type=submit] {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_button_font_family', 'Montserrat' )); ?>';
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_button_font_size', '12px' )); ?>;
    background-color: <?php echo esc_attr(get_theme_mod( 'malina_button_default_bg_color', '#1c1d1f' )); ?>;
    border-color: <?php echo esc_attr(get_theme_mod( 'malina_button_default_border_color', 'transparent' )); ?>;
    color: <?php echo esc_attr(get_theme_mod( 'malina_button_default_text_color', '#ffffff' )); ?>;
    font-weight: <?php echo esc_attr(get_theme_mod( 'malina_button_font_weight', '600' )); ?>;
    text-transform: <?php echo esc_attr(get_theme_mod( 'malina_button_transform', 'uppercase' )); ?>;
    border-radius: <?php echo esc_attr(get_theme_mod( 'malina_button_border_radius', '0' )); ?>px;
    letter-spacing: <?php echo esc_attr(get_theme_mod( 'malina_button_letter_spacing', '1' )); ?>px;
    padding:<?php echo esc_attr(get_theme_mod( 'malina_button_vertical_padding', '13' )); ?>px <?php echo esc_attr(get_theme_mod( 'malina_button_horizontal_padding', '32' )); ?>px
}
#latest-posts #infscr-loading div,
.no_next_post_load {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_button_font_family', 'Montserrat' )); ?>';
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_button_font_size', '12px' )); ?>;
    font-weight: <?php echo esc_attr(get_theme_mod( 'malina_button_font_weight', '600' )); ?>;
    letter-spacing: <?php echo esc_attr(get_theme_mod( 'malina_button_letter_spacing', '1' )); ?>px;
}
#footer-widgets .widget_malinasubscribe .newsletter-submit button {
    background-color: <?php echo esc_attr(get_theme_mod( 'malina_button_default_bg_color', '#1c1d1f' )); ?>;
    color: <?php echo esc_attr(get_theme_mod( 'malina_button_default_text_color', '#ffffff' )); ?>;
}
#content .wp-block-button .wp-block-button__link {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_button_font_family', 'Montserrat' )); ?>';
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_button_font_size', '12px' )); ?>; 
    font-weight: <?php echo esc_attr(get_theme_mod( 'malina_button_font_weight', '600' )); ?>;
    letter-spacing: <?php echo esc_attr(get_theme_mod( 'malina_button_letter_spacing', '1' )); ?>px;
    padding:<?php echo esc_attr(get_theme_mod( 'malina_button_vertical_padding', '13' )); ?>px <?php echo esc_attr(get_theme_mod( 'malina_button_horizontal_padding', '32' )); ?>px
}
#content .woocommerce a.added_to_cart,
#content .woocommerce div.product .woocommerce-tabs ul.tabs li a,
#content .woocommerce .quantity .qty,
#content .woocommerce .quantity .qty-button {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_button_font_family', 'Montserrat' )); ?>';
}
.post-slider-item .post-more .post-more-link,
.sharebox.sharebox-sticky .share-text {
    font-family:'<?php echo esc_attr(get_theme_mod( 'malina_button_font_family', 'Montserrat' )); ?>';
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_button_font_size', '12px' )); ?>;
}
.loadmore.button {
    background-color: <?php echo esc_attr(get_theme_mod( 'malina_button_loadmore_bg_color', '#fff' )); ?>;
    border-color: <?php echo esc_attr(get_theme_mod( 'malina_button_loadmore_border_color', '#dadcdf' )); ?>;
    color: <?php echo esc_attr(get_theme_mod( 'malina_button_loadmore_text_color', '#444b4d' )); ?>;
}
.menu-button-open, .search-link .search-button {
    color: <?php echo esc_attr(get_theme_mod('malina_menu_item_color', '#2c2e30')); ?>;
}
ul#nav-mobile li > a:hover, ul#nav-mobile li.current-menu-item > a, ul#nav-mobile li.current_page_item > a, ul#nav-mobile li.current-menu-ancestor > a,
#navigation .menu li > a:hover, #navigation .menu li.current-menu-item > a, #navigation .menu li.current-menu-ancestor > a,
#hidden-area-widgets .menu li > a:hover, #hidden-area-widgets .menu li.current-menu-item > a, #hidden-area-widgets .menu li.current-menu-ancestor > a
.menu-button-open:hover, .search-link .search-button:hover,
#navigation .menu li ul li a:hover,
#navigation .menu li ul .current-menu-item > a,
#navigation .menu li ul .current-menu-ancestor > a,
#hidden-area-widgets .menu li ul li a:hover,
#hidden-area-widgets .menu li ul .current-menu-item > a,
#hidden-area-widgets .menu li ul .current-menu-ancestor > a,
ul#nav-mobile li > a:hover,
ul#nav-mobile li.current-menu-item > a,
ul#nav-mobile li.current_page_item > a,
ul#nav-mobile li.current-menu-ancestor > a,
.hidden-area-button a.open-hidden-area:hover {
    color: <?php echo esc_attr(get_theme_mod('malina_menu_item_color_active', '#8c8f93')); ?>;
}
#footer-copy-block,
.footer-menu .menu > li > a {
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_footer_copyright_font_size', '11px' )); ?>;
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_footer_copyright_font_family', 'Montserrat' )); ?>';
    color: <?php echo esc_attr(get_theme_mod('malina_footer_copyright_color', '#aaadad')); ?>;
}
#footer .social-icons li a {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_footer_copyright_font_family', 'Montserrat' )); ?>';
}
#footer.footer-layout-4 .social-icons li a {
    color:<?php echo esc_attr(get_theme_mod('malina_footer_socials_color', '#282b2f'));?>;
}
#footer #footer-bottom .social-icons li a {
    color: <?php echo esc_attr(get_theme_mod('malina_footer_copyright_color', '#aaadad')); ?>;
}
#footer .special-bg {
    background-color: <?php echo esc_attr(get_theme_mod('malina_footer_bg_color', '#1d1f20')); ?>;
    <?php if(get_theme_mod('malina_footer_bg_image') == ''){ echo 'display:none;'; }?>
    <?php if(get_theme_mod('malina_footer_bg_image') != ''){
        echo 'background-image: url('.esc_attr(get_theme_mod('malina_footer_bg_image')).');';
        echo 'background-position: '.esc_attr(get_theme_mod('malina_footer_bg_position', 'center bottom')).';'; 
        echo 'background-size: '.esc_attr(get_theme_mod('malina_footer_bg_size', 'auto')).';';
    } ?>
}
#footer,
#footer.footer-simple {
    padding-top:<?php echo get_theme_mod('malina_footer_top_padding', '45'); ?>px;
    padding-bottom:<?php echo get_theme_mod('malina_footer_bottom_padding', '90'); ?>px;
}
<?php if(get_theme_mod('malina_footer_bg_image') == ''){
    echo '#footer {background-color: '.esc_attr(get_theme_mod('malina_footer_bg_color', '#1d1f20')).';}';
}?>
#footer.footer-simple {
    background-color: <?php echo esc_attr(get_theme_mod('malina_footer_bg_color', '#1d1f20')); ?>;
    <?php if(get_theme_mod('malina_footer_bg_image') != ''){
        echo 'background-image: url('.esc_attr(get_theme_mod('malina_footer_bg_image')).');';
        echo 'background-position: '.esc_attr(get_theme_mod('malina_footer_bg_position', 'center bottom')).';'; 
        echo 'background-size: '.esc_attr(get_theme_mod('malina_footer_bg_size', 'auto')).';';
    } ?>
}
<?php
$footer_socials_color = get_theme_mod('malina_footer_socials_color', '');
if( $footer_socials_color != '' ){
    echo '#footer .social-icons li a, #footer .social-icons li a i, #footer .social-icons li a span {color:'.$footer_socials_color.';}';
}
$footer_background = rwmb_meta( 'malina_footer_background' );
if(!empty($footer_background)){
    echo '.page-id-'.get_the_ID().' #footer .special-bg {';
    rwmb_the_value('malina_footer_background');
    echo '}';    
}
$footer_socials_color = rwmb_get_value( 'malina_footer_socials_color' );
if( $footer_socials_color != '' ){
    echo '.page-id-'.get_the_ID().' #footer .social-icons li a, .page-id-'.get_the_ID().' #footer .social-icons li a span {color:'.$footer_socials_color.';}';
}

?>
<?php
    if( rwmb_get_value('malina_header_bottom_border') ){
        echo '#header, #header.header-scrolled, #header.header5 .header-top {border-bottom:0 !important;}';
    }
    if( !get_theme_mod('malina_post_headings_separator', false) ){
        echo '.title:after {display:none !important;} .post .title.hr-sep {margin-bottom:0!important;}';
    }
    if( !get_theme_mod('malina_widgets_headings_separator', false ) ){
        echo '#related-posts h2:after, #related-posts h2:before, .post-meta .meta-date:after, .post-meta .sharebox:before {display:none !important;}';
    }
?>
.title h1, .title h2, .title h3 { 
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_family', 'Montserrat' )); ?>';
    color: <?php echo esc_attr(get_theme_mod('malina_posts_headings_item_color', '#1c1d1f')); ?>;
    font-weight: <?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_weight', '500' )); ?>;
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_size', '50' )); ?>px;
    text-transform: <?php echo esc_attr(get_theme_mod( 'malina_post_headings_transform', 'uppercase' )); ?>;
    letter-spacing:<?php echo esc_attr( get_theme_mod( 'malina_posts_headings_letter_spacing', '2') ); ?>px;
}
#latest-posts .blog-posts .post.style_9 .title h2 {
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_size', '34' )); ?>px;
}
.author-title h2 {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_family', 'Montserrat' )); ?>';
    text-transform: <?php echo esc_attr(get_theme_mod( 'malina_post_headings_transform', 'uppercase' )); ?>;
    letter-spacing:<?php echo esc_attr( get_theme_mod( 'malina_posts_headings_letter_spacing', '0') ); ?>px;
}
<?php
    if( get_theme_mod('malina_post_headings_separator_style', 'vertical') === 'horizontal' && get_theme_mod('malina_post_headings_separator', false) ){
        echo '.title { padding-bottom: 2px !important; margin-bottom: 23px !important; }';
        echo '.page-template-default .before-content .title h2 { margin-bottom:12px !important;}';
        echo 'body.single-post .post .title, .before-content header.title, body.search header.title {margin-bottom:35px !important;}';
        echo '.title:after { top: auto !important; bottom: 0px !important; height: 1px !important; width: 66px !important; border: 0 !important; left: 50% !important; margin: 0 0 0px -33px !important; border-bottom: 2px solid !important; }';
        echo '.title:after {color:'.get_theme_mod('malina_accent_color', '#d87b4d').'}';
    }
?>
#navigation-block #wp-megamenu-main_navigation>.wpmm-nav-wrap ul.wp-megamenu h4.grid-post-title a,
#navigation-block #wp-megamenu-main_navigation>.wpmm-nav-wrap ul.wp-megamenu h4.grid-post-title {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_family', 'Montserrat' )); ?>' !important;
    letter-spacing:<?php echo esc_attr( get_theme_mod( 'malina_posts_headings_letter_spacing', '0') ); ?>px;
    text-transform: <?php echo esc_attr(get_theme_mod( 'malina_post_headings_transform', 'uppercase' )); ?>;
    font-weight: <?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_weight', '300' )); ?>;
}
.logo { 
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_logo_font_family', 'Montserrat' )); ?>';
    font-weight: <?php echo esc_attr(get_theme_mod( 'malina_logo_font_weight', '700' )); ?>;
    text-transform: <?php echo esc_attr(get_theme_mod( 'malina_logo_transform', 'uppercase' )); ?>;
}
<?php if( get_theme_mod('malina_footer_logo_img', '') == '' ){ ?>
.footer-logo {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_footer_logo_font_family', 'Montserrat' )); ?>';
    font-size:<?php echo esc_attr(get_theme_mod('malina_footer_logo_size', '18')); ?>px;
    font-weight: <?php echo esc_attr(get_theme_mod( 'malina_footer_logo_font_weight', '400' )); ?>;
    text-transform: <?php echo esc_attr(get_theme_mod( 'malina_footer_logo_transform', 'uppercase' )); ?>;
    color:<?php echo esc_attr(get_theme_mod('malina_footer_logo_color', '#151516'));?>;
}
<?php } else { ?>
    #footer .footer-logo img { max-width:<?php echo get_theme_mod('malina_footer_logo_size', '150') ?>px; }
<?php } ?>
blockquote,
.woocommerce #reviews #comments ol.commentlist li .comment-text p.meta {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_family', 'Montserrat' )); ?>';
}
h1,h2,h3,h4,h5,.has-drop-cap:first-letter {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_family', 'Montserrat' )); ?>';
    color: <?php echo esc_attr(get_theme_mod('malina_posts_headings_item_color', '#1c1d1f')); ?>;
    font-weight: <?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_weight', '500' )); ?>;
    letter-spacing:<?php echo esc_attr( get_theme_mod( 'malina_posts_headings_letter_spacing', '1.5') ); ?>px;
}
.block_title {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_widgets_headings_font_family', 'Montserrat' )); ?>';
    color: <?php echo esc_attr(get_theme_mod('malina_widgets_headings_item_color', '#1c1d1f')); ?>;
    font-weight: <?php echo esc_attr(get_theme_mod( 'malina_widgets_headings_font_weight', '500' )); ?>;
    letter-spacing:<?php echo esc_attr( get_theme_mod( 'malina_widgets_headings_letter_spacing', '1.5') ); ?>px;
    text-transform: <?php echo esc_attr( get_theme_mod( 'malina_widgets_headings_transform', 'uppercase' ) ); ?>
}
.page-title h2 {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_page_title_font_family', 'Montserrat' )); ?>';
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_page_title_font_size', '36' )); ?>px;
    color: <?php echo esc_attr(get_theme_mod('malina_page_title_item_color', '#1c1d1f')); ?>;
    font-weight: <?php echo esc_attr(get_theme_mod( 'malina_page_title_font_weight', '700' )); ?>;
    letter-spacing:<?php echo esc_attr( get_theme_mod( 'malina_page_title_letter_spacing', '0') ); ?>px;
    text-transform: <?php echo esc_attr( get_theme_mod( 'malina_page_title_transform', 'none' ) ); ?>
}
.team-member-pos {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_widgets_headings_font_family', 'Montserrat' )); ?>';   
}
.categories-info li {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_widgets_headings_font_family', 'Montserrat' )); ?>';
}
#pagination.pagination_next_prev a {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_family', 'Montserrat' )); ?>';
    font-weight: <?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_weight', '500' )); ?>;
    letter-spacing:<?php echo esc_attr( get_theme_mod( 'malina_posts_headings_letter_spacing', '1.5') ); ?>px;
}
.post-slider-item .post-more.style_5 h3, .post-slider-item .post-more h3 {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_family', 'Montserrat' )); ?>';
    font-weight: <?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_weight', '500' )); ?>;
    text-transform: <?php echo esc_attr(get_theme_mod( 'malina_post_headings_transform', 'uppercase' )); ?>;
    letter-spacing:<?php echo esc_attr( get_theme_mod( 'malina_posts_headings_letter_spacing', '1.5') ); ?>px;
}
p.title-font {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_family', 'Montserrat' )); ?>';
}
#content .woocommerce ul.products li.product .price,
#content .woocommerce table.shop_table .product-subtotal span,
#content .woocommerce table.shop_table .product-name a,
.woocommerce table.shop_table tbody th {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_family', 'Montserrat' )); ?>';
    color: <?php echo esc_attr(get_theme_mod('malina_posts_headings_item_color', '#1c1d1f')); ?>;
}
.social-icons.big_icon_text li span {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_family', 'Montserrat' )); ?>';
}
.woocommerce .products div.product p.price, .woocommerce .products div.product span.price {
    color:<?php echo esc_attr(get_theme_mod('malina_accent_color', '#d87b4d')); ?> !important;
}
.woocommerce div.product p.price, .woocommerce div.product span.price {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_family', 'Montserrat' )); ?>' !important;
}
.title h2 a:hover, .title h3 a:hover, .related-item-title a:hover, .latest-blog-item-description a.title:hover,
.post-slider-item .post-more.style_5 h3 a:hover, .post_more_style_7 .post-slider-item .post-more h3 a:hover {
    color: <?php echo esc_attr(get_theme_mod('malina_posts_headings_item_color_active', '#d87b4d')); ?>;
}
.meta-categories {
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_meta_categories_font_size', '18px' )); ?>;
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_meta_categories_font_family', 'Dancing Script' )); ?>';
    font-weight: <?php echo esc_attr(get_theme_mod( 'malina_meta_categories_font_weight', '400' )); ?>;
    text-transform: <?php echo esc_attr(get_theme_mod( 'malina_meta_categories_transform', 'none' )); ?>;
    color:<?php echo esc_attr(get_theme_mod('malina_meta_categories_color', '#d87b4d')); ?>;
    letter-spacing: <?php echo esc_attr(get_theme_mod( 'malina_meta_categories_letter_spacing', '0' )); ?>px;
}
.post.style_9 .post-block-title:after {
    background-color:<?php echo esc_attr(get_theme_mod('malina_meta_categories_color', '#d87b4d')); ?>;
}
.meta-categories a:hover {
    color:<?php echo esc_attr(get_theme_mod('malina_meta_categories_color_hover', '#cccccc')); ?>;
}
.post-meta.footer-meta > div,
.single-post .post .post-meta .meta > div,
.post.sticky .post-meta .meta > div,
.post.style_9 .post-meta .meta > div,
.revslider_post_date {
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_meta_info_font_size', '11px' )); ?>;
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_meta_info_font_family', 'Montserrat' )); ?>';
    text-transform: <?php echo esc_attr(get_theme_mod( 'malina_meta_info_transform', 'uppercase' )); ?>;
    color:<?php echo esc_attr(get_theme_mod('malina_meta_info_color', '#888c8e')); ?>;
    letter-spacing: <?php echo esc_attr(get_theme_mod( 'malina_meta_info_letter_spacing', '1' )); ?>px;
}

.herosection_text {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_meta_categories_font_family', 'Dancing Script' )); ?>';
}
.wpb_widgetised_column .widget h3.title, .widget-title, #footer .widget-title {
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_widgets_headings_font_size', '11px' )); ?>; 
    font-weight: <?php echo esc_attr(get_theme_mod( 'malina_widgets_headings_font_weight', '600' )); ?>;
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_widgets_headings_font_family', 'Montserrat' )); ?>';
    color: <?php echo esc_attr(get_theme_mod('malina_widgets_headings_item_color', '#1c1d1f')); ?>;
    text-transform: <?php echo esc_attr(get_theme_mod( 'malina_widgets_headings_transform', 'uppercase' )); ?>;    
    letter-spacing:<?php echo esc_attr( get_theme_mod( 'malina_widgets_headings_letter_spacing', '1') ); ?>px;
    text-align:<?php echo esc_attr( get_theme_mod('malina_widgets_headings_textalign', 'center') ); ?>
}
<?php
    if( get_theme_mod('malina_subscribe_popup_bg') != '' ){
        echo ".subscribe-popup { background-image: url(".get_theme_mod('malina_subscribe_popup_bg')."); }";
    }
    if( get_theme_mod('malina_subscribe_popup_bg_color') != '' ){
        echo ".subscribe-popup:after { background-color:".get_theme_mod('malina_subscribe_popup_bg_color', '#fdefe2')."; }";
    }
?>
<?php 
if(get_theme_mod('malina_widgets_headings_textalign', 'center') == 'left'){
    echo '.widget-title.separator:after { left:0; margin-left:0; }';
}
if(get_theme_mod('malina_widgets_headings_textalign', 'center') == 'right'){
    echo '.widget-title.separator:after { left:auto; margin-left:0; right:0; }';
}
?>
#related-posts h2, #comments-title, .write-comment h3 {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_widgets_headings_font_family', 'Montserrat' )); ?>';
    color: <?php echo esc_attr(get_theme_mod('malina_widgets_headings_item_color', '#1c1d1f')); ?>;
    text-transform: <?php echo esc_attr(get_theme_mod( 'malina_widgets_headings_transform', 'uppercase' )); ?>;    
    letter-spacing:<?php echo esc_attr( get_theme_mod( 'malina_widgets_headings_letter_spacing', '1.5') ); ?>px;
}
.comment .author-title {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_posts_headings_font_family', 'Montserrat' )); ?>';
    text-transform: <?php echo esc_attr(get_theme_mod( 'malina_widgets_headings_transform', 'uppercase' )); ?>; 
    color: <?php echo esc_attr(get_theme_mod('malina_widgets_headings_item_color', '#1c1d1f')); ?>;   
}
.meta-date, #latest-list-posts .post .post-meta .categories, #latest-posts .post .post-meta .categories, 
.meta-read, .related-meta-date, .label-date, .post-meta .post-more a span, .post-more a.post-more-button span,
.tp-caption.slider-posts-desc .slider-post-meta, .slider-posts-desc .slider-post-meta,
.author .comment-reply a, .pagination_post a, .pagination_post span,
body.single-post .post .post-meta .meta > div {
    font-size: <?php echo esc_attr(get_theme_mod( 'malina_meta_info_font_size', '11px' )); ?>;
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_meta_info_font_family', 'Montserrat' )); ?>';
    text-transform: <?php echo esc_attr(get_theme_mod( 'malina_meta_info_transform', 'uppercase' )); ?>;
    letter-spacing:<?php echo esc_attr( get_theme_mod( 'malina_widgets_headings_letter_spacing', '1') ); ?>px;
}
.meta-date,
#navigation-block #wp-megamenu-main_navigation>.wpmm-nav-wrap ul.wp-megamenu .meta-date {
   color:<?php echo esc_attr(get_theme_mod('malina_meta_info_color', '#888c8e')); ?>; 
}
.widget .latest-blog-list .post-meta-recent span {
    font-family: '<?php echo esc_attr(get_theme_mod( 'malina_widgets_headings_font_family', 'Montserrat' )); ?>';
}
.widget .latest-blog-list .meta-categories a:hover, .post-meta .meta-tags a:hover,
.author .comment-reply a:hover, .pie-top-button, #header .social-icons li a:hover, #mobile-nav .social-icons li a:hover,
.widget_categories ul li a:hover, #latest-list-posts .post .post-meta .categories a:hover,
.social-icons li a:hover, input[type="checkbox"]:not(:checked) + label:after,
input[type="checkbox"]:checked + label:after,
.category-block:hover .category-block-inner .link-icon,
.author .comment-reply a,
.widget_category .category-button,
#content .woocommerce .product .price ins,
#content .woocommerce table.shop_table .product-remove .remove:hover,
.prev-post-title span, .next-post-title span,
blockquote:before, .menu-item.update-label > a:after {
    color:<?php echo esc_attr(get_theme_mod('malina_accent_color', '#d87b4d')); ?>;
}
#content .woocommerce-message .button,
.block-title,
.list-style2 li:before,
.number-list li:before,
#pagination.pagination_next_prev a:hover,
#subscribe.subscribe-section p.desc {
    color:<?php echo esc_attr(get_theme_mod('malina_accent_color', '#d87b4d')); ?> !important;
}
.social-icons.big_icon_text li a:hover,
.sharebox.sharebox-sticky ul li a:hover,
#content .woocommerce span.onsale,
.widget_malinasubscribe .newsletter-submit button,
.widget_mc4wp_form_widget input[type=submit],
.widget_newsletterwidget .tnp-widget input[type=submit],
 #content .woocommerce a.button, #content .woocommerce button.button, #content .woocommerce input.button,
.my-cart-link .cart-contents-count,
.subscribe-block .newsletter-submit button,
.list-style1 li:before,
#pagination .current, #pagination a:hover,
.post-slider-item:hover .post-more.style_4 .post-more-inner,
.meta-sharebox > i,
.meta-sharebox .sharebox .social-icons li:hover,
.meta-sharebox:hover > i:hover,
.single-post .post .post-meta .sharebox a,
.menu-item.new-label > a:after {
    background-color:<?php echo esc_attr(get_theme_mod('malina_accent_color', '#d87b4d')); ?>;
}
.instagram-item:hover img,
input[type="text"]:focus,
input[type="password"]:focus,
input[type="email"]:focus,
input[type="url"]:focus,
input[type="tel"]:focus,
input[type="number"]:focus,
textarea:focus,
.single-post .post.featured .title .meta-date .meta-categories a,
.wp-block-pullquote blockquote, .style2,
.widget_newsletterwidget, .widget_malinasubscribe, .widget_mc4wp_form_widget,
.widget_newsletterwidget:before, .widget_malinasubscribe:before, .widget_mc4wp_form_widget:before,
#navigation .menu li ul li a:hover:before,
#navigation .menu li ul .current-menu-item > a:before,
#navigation .menu li ul .current-menu-ancestor > a:before,
.wp-megamenu-wrap .wp-megamenu li .wp-megamenu-sub-menu li > a:hover:before,
.wp-megamenu-wrap .wp-megamenu li .wp-megamenu-sub-menu li.current-menu-item > a:before,
.wp-megamenu-wrap .wp-megamenu li .wp-megamenu-sub-menu li.current-menu-ancestor > a:before,
#navigation-block #wp-megamenu-main_navigation>.wpmm-nav-wrap ul.wp-megamenu>li ul.wp-megamenu-sub-menu .wpmm-tab-btns li.active a:before,
.search-area input#header-s, .search-area input#header-mobile-s, a.readmore:after, .wp-block-quote.style5,
#navigation-block .wp-megamenu li.menu-item > .wp-megamenu-sub-menu,
#navigation li ul, .author-info .author-avatar {
    border-color:<?php echo esc_attr(get_theme_mod('malina_accent_color', '#d87b4d')); ?>;
}
.category-block:hover .category-block-inner::before {
    border-top-color: <?php echo esc_attr(get_theme_mod('malina_accent_color', '#d87b4d')); ?>;
    border-right-color: <?php echo esc_attr(get_theme_mod('malina_accent_color', '#d87b4d')); ?>;
}
.category-block:hover .category-block-inner::after {
    border-bottom-color: <?php echo esc_attr(get_theme_mod('malina_accent_color', '#d87b4d')); ?>;
    border-left-color: <?php echo esc_attr(get_theme_mod('malina_accent_color', '#d87b4d')); ?>;
}

#sidebar .widget.widget_socials .social-icons li a:before, .pie,
#footer .social-icons li a:before, .sk-folding-cube .sk-cube:before,
#back-to-top a:hover, input[type="radio"]:checked + label:after,
input[type="radio"]:not(:checked) + label:after,
.category-block:hover .category-block-inner .category-button,
.pagination_post > span,
.pagination_post a:hover span, .widget_category .category-button:hover,
.woocommerce nav.woocommerce-pagination ul li a:focus,
.woocommerce nav.woocommerce-pagination ul li a:hover,
.woocommerce nav.woocommerce-pagination ul li span.current,
.search-area form button, span.search-excerpt {
    background-color:<?php echo esc_attr(get_theme_mod('malina_accent_color', '#d87b4d')); ?> !important;
}
<?php $out=ob_get_contents(); $out = malina_compress($out); ob_end_clean();

    wp_add_inline_style('malina-stylesheet', $out);
}
add_action( 'wp_enqueue_scripts', 'malina_styles_custom' );
?>