<style type="text/css">
<?php
if(!empty(get_option('auto_update_cart')) && get_option('auto_update_cart') == 1){
  //$this->scriptData = $this->autoUpdateCart;
  //wp_localize_script('mwp-scripts', 'autoUpdateCart', $scriptData);
  ?>
    .woocommerce button[name="update_cart"],
    .woocommerce input[name="update_cart"] {
    display: none;
    }
  <?php
}
$bg_image_id = get_option('bg_image_id');
$login_logo_id = get_option('login_logo_id');

$bg_image_path = (is_numeric($bg_image_id)) ? wp_get_attachment_url($bg_image_id) : $bg_image_id;
$login_logo_path = (is_numeric($login_logo_id)) ? wp_get_attachment_url($login_logo_id) : $login_logo_id;
?>
body, html { height: auto; }
body.login{background-color:<?php echo get_option('bg_color') . ' !important;'; if(!empty($bg_image_path)) echo ' background-image: url(' . $bg_image_path  . ');'; if(get_option('bg_repeat') == 1) echo 'background-repeat: repeat'; else echo 'background-repeat: no-repeat'; ?>; background-position: center center; <?php if(get_option('bg_scale')) echo 'background-size: 100% auto;'; ?> background-attachment: fixed; margin:0; padding:1px; top: 0; right: 0; bottom: 0; left: 0; }
html, body.login:after { display: block; clear: both; }
body.login-action-register { position: relative }
body.login-action-login, body.login-action-lostpassword { position: fixed }
.login h1 a {
<?php if(!empty($login_logo_path)) { ?>
width: 100%;
background: url(<?php echo $login_logo_path; ?>) center center no-repeat;
<?php if(get_option('resize_logo')) { ?>
background-size: <?php echo get_option('set_logo_size'); ?>%;
<?php }
} ?>
height:<?php echo get_option('set_logo_height'); ?>px; margin: 0 auto 20px; }
div#login { background: <?php if(get_option('set_transparent_form') ==1) echo 'transparent'; else echo get_option('login_divbg_color'); ?>;
margin-top: <?php if(!empty(get_option('frm_login_top_margin')) < 20) echo get_option('frm_login_top_margin') . "7%"; else echo "7%"; ?>; padding: 18px 0 }
body.interim-login div#login {width: 95% !important; height: auto }
.login label, .login form, .login form p,.login a:focus, .login a:hover { color: <?php echo get_option('form_text_color'); ?> !important }
.login a { text-decoration: underline; color: <?php echo get_option('form_text_color'); ?> !important }
.login a:focus, .login a:hover { color: <?php echo get_option('form_link_hover_color'); ?> !important; }
.login form { background: <?php if(get_option('set_transparent_form') == 1) echo 'transparent'; else echo get_option('form_bg_color'); ?> !important; -webkit-box-shadow: none; -moz-box-shadow: none; box-shadow: none; border:<?php if(get_option('set_transparent_form') != 1) echo '1px solid ' .get_option('form_border_color') . ';'; else echo '0 none !important;'; if(get_option('set_transparent_form') == 1) echo  'padding: 26px 0px 30px !important'; else echo 'padding: 26px 24px 30px !important'; ?> }
form#loginform .button-primary, form#registerform .button-primary, .button-primary { background:<?php echo get_option('form_button_color'); ?> !important; border:none !important; color: #fff; text-shadow: none;}
form#loginform .button-primary.focus,form#loginform .button-primary.hover,form#loginform .button-primary:focus,form#loginform .button-primary:hover, form#registerform .button-primary.focus, form#registerform .button-primary.hover,form#registerform .button-primary:focus,form#registerform .button-primary:hover {}
<?php if(get_option('set_transparent_form') == 1) { ?>.login #backtoblog, .login #nav { margin : 0; padding: 0 } .login form { padding-top: 2px !important}<?php } ?>

.login form input.input { background: <?php if(!empty(get_option('set_transparent_input')==1)) echo 'transparent'; else echo '#f1f1f1' ?> url(<?php echo WP_HELPER_PUBLIC_IMAGES_URL; ?>/login-sprite.png) no-repeat 12px -5px;padding: 9px 0 9px 38px !important; font-size: 16px !important; line-height: 1; outline: none !important;color: <?php if(!empty(get_option('input_text_color'))) echo get_option('input_text_color'); else echo '#fff' ?>;
border:1px solid <?php if(!empty(get_option('input_border_color'))) echo get_option('input_border_color'); else echo '#fff' ?>; box-shadow: 0 0 2px <?php if(!empty(get_option('input_border_color'))) echo get_option('input_border_color'); else echo '#fff' ?>;
}
input#user_pass, input#user_email, input#pass1, input#pass2 { background-position:12px -56px !important; }
input#user_login, input#pass1, input#pass2 { margin-bottom: 5px }
.login form #wp-submit { width: 100%; height: 35px }
p.forgetmenot { margin-bottom: 16px !important; }
.login #pass-strength-result {margin: 12px 0 16px !important }
p.indicator-hint { clear:both }

/* Message box */
div.updated, .login #login_error, .login .message { border-left: 4px solid <?php echo get_option('msgbox_border_color'); ?>; background-color: <?php echo get_option('msg_box_color'); ?>; color: <?php echo get_option('msgbox_text_color'); ?>; }
div.updated a, .login #login_error a, .login .message a { color: <?php echo get_option('msgbox_link_color'); ?>; }
div.updated a:hover, .login #login_error a:hover, .login .message a:hover { color: <?php echo get_option('msgbox_link_hover_color'); ?>; }

.login_footer_content { padding: 40px 0; text-align:center; }
.footer_content { }
<?php if(get_option('hide_backtoblog') == 1) echo '#backtoblog { display:none !important; }';
if(get_option('hide_remember') == 1) echo 'p.forgetmenot { display:none !important; }';

if(get_option('design_type') == 2) { ?>
.wp-core-ui .button,.wp-core-ui .button-secondary {
  <?php if(!empty(get_option('sec_button_border_color'))) echo "border-color:" . get_option('sec_button_border_color') . ";" ?>
<?php if(!empty(get_option('sec_button_border_color'))) echo "-webkit-box-shadow:inset 0 1px 0 " . get_option('sec_button_shadow_color') . ",0 1px 0 rgba(0,0,0,.08);"; ?>
box-shadow:inset 0 1px 0 <?php echo get_option('sec_button_shadow_color'); ?>,0 1px 0 rgba(0,0,0,.08);
}
.wp-core-ui .button-secondary:focus, .wp-core-ui .button-secondary:hover, .wp-core-ui .button.focus, .wp-core-ui .button.hover, .wp-core-ui .button:focus, .wp-core-ui .button:hover {border-color:<?php echo get_option('sec_button_hover_border_color'); ?>; -webkit-box-shadow:inset 0 1px 0 <?php echo get_option('sec_button_hover_shadow_color'); ?>,0 1px 0 rgba(0,0,0,.08);box-shadow:inset 0 1px 0 <?php echo get_option('sec_button_hover_shadow_color'); ?>,0 1px 0 rgba(0,0,0,.08);}
.wp-core-ui .button-primary, .wp-core-ui .button-primary-disabled, .wp-core-ui .button-primary.disabled, .wp-core-ui .button-primary:disabled, .wp-core-ui .button-primary[disabled] {border-color:<?php echo get_option('pry_button_border_color'); ?> !important;-webkit-box-shadow:inset 0 1px 0 <?php echo get_option('pry_button_shadow_color'); ?>,0 1px 0 rgba(0,0,0,.15) !important; box-shadow: inset 0 1px 0 <?php echo get_option('pry_button_shadow_color'); ?>, 0 1px 0 rgba(0,0,0,.15) !important;}
.wp-core-ui .button-primary.focus, .wp-core-ui .button-primary.hover, .wp-core-ui .button-primary:focus, .wp-core-ui .button-primary:hover, .wp-core-ui .button-primary.active,.wp-core-ui .button-primary.active:focus,.wp-core-ui .button-primary.active:hover,.wp-core-ui .button-primary:active {<?php if(!empty(get_option('pry_button_hover_border_color'))) echo "border-color:" . get_option('pry_button_hover_border_color') . "!important;"; ?>-webkit-box-shadow:inset 0 1px 0 <?php echo get_option('pry_button_hover_shadow_color'); ?>,0 1px 0 rgba(0,0,0,.15) !important; box-shadow: inset 0 1px 0 <?php echo get_option('pry_button_hover_shadow_color'); ?>,0 1px 0 rgba(0,0,0,.15) !important;}
<?php }
if(get_option('design_type') == 1) {
?>
.login .message, .button-primary, .wp-core-ui .button-primary {
    -webkit-box-shadow: none !important;
    -moz-box-shadow: none !important;
    box-shadow: none !important;
    text-shadow: none;
}
.button-primary, .wp-core-ui .button-primary {
    border: none;
}

<?php } //end of design_type

//echo get_option('login_custom_css'); ?>

@media only screen and (min-width: 800px) {
	div#login {
		width: <?php echo get_option('frm_login_width'); ?>% !important;
	}
}
@media screen and (max-width: 800px){
	div#login {
		width: 90% !important;
	}
	body.login {
		background-size: auto;
	}
	body.login-action-login, body.login-action-lostpassword {
		position: relative;
	}
}
</style>
