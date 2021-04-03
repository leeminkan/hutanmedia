jQuery( document ).ready(function($) {
	//Login tab
	const $logoSizeVal = $('#rangeLogoSize');
	const $logoSize = $('#set_logo_size');
	$logoSize.on('input change', () => {
		$logoSizeVal.html($logoSize.val());
	});
	var $logoHeightVal = $('#rangeLogoHeight');
	var $logoHeight = $('#set_logo_height');
	$logoHeight.on('input change', () => {
    $logoHeightVal.html($logoHeight.val());
  });
	var $logoResizeActive = $('#mwph-logo-resize-active input');
	if($logoResizeActive.prop('checked')==true){
		// $("#set_logo_size").slider("enable");
	  // $("#set_logo_height").slider("enable");
	}else{
		// $("#set_logo_size").slider("disable");
	  // $("#set_logo_height").slider("disable");
	}
	$logoResizeActive.change( function() {
		if($logoResizeActive.prop('checked')==true) {

		}
		else {

		}
	});
	//Optimize checkout
	var $wooOpActive = $('#mwph-woo-optimize-active input');
	if($wooOpActive.prop("checked")==true){
	  $('#woo-optimize-section').attr('style','display:block;');
	}else{
	  $('#woo-optimize-section').attr('style','display:none;');
	}
	$wooOpActive.change( function() {
	  var $input = $(this);
	  if($input.prop("checked")==true){
	    $('#woo-optimize-section').attr('style','display:block;');
	  }else if($input.prop("checked")==false){
	    $('#woo-optimize-section').attr('style','display:none;');
	  }
	});
	//Secure tabs

	//SMTP tabs
	var $smtpActive = $( '#mwph-smtp-active input' );
	if($smtpActive.prop("checked")==true){
	  $('.smtp-group input').prop('readonly', false);
		$('.encryption-group input').prop('disabled', false);
		$('.authenticate-group input').prop('disabled', false);
	}else{
	  $('.smtp-group input').prop('readonly', true);
		$('.encryption-group input').prop('disabled', true);
		$('.authenticate-group input').prop('disabled', true);
	}
	$smtpActive.change( function() {
	  var $input = $(this);
	  if($input.prop("checked")==true){
	    $('.smtp-group input').prop('readonly', false);
			$('.encryption-group input').prop('disabled', false);
			$('.authenticate-group input').prop('disabled', false);
	  }else if($input.prop("checked")==false){
	    $('.smtp-group input').prop('readonly', true);
			$('.encryption-group input').prop('disabled', true);
			$('.authenticate-group input').prop('disabled', true);
	  }
	});
	$( '#encryption-none, #encryption-ssl, #encryption-tls' ).on('click', function() {
		var $smtpPort = $('#mwph-smtp-port input');
		if ($("#encryption-none").is(":checked") == true) {
			$smtpPort.val( '25' );
		}
		if ($("#encryption-ssl").is(":checked") == true) {
			$smtpPort.val( '465' );
		}
		if ($("#encryption-tls").is(":checked") == true) {
			$smtpPort.val( '587' );
		}
	} );
	//WooCommerce tabs
	var $callForPriceActive = $( '#call-for-price-active input' );
	if($callForPriceActive.prop("checked")==true){
		$('#Phonecollapse').collapse({toggle: true});
	  $('.call_for_price_group input').prop('readonly', false);
	}else{
		$('#Phonecollapse').collapse({toggle: false});
	  $('.call_for_price_group input').prop('readonly', true);
	}
	$callForPriceActive.change( function() {
	  var $input = $(this);
	  if($input.prop("checked")==true){
	    $('#Phonecollapse').collapse({toggle: true});
			$('.call_for_price_group input').prop('readonly', false);
	  }else if($input.prop("checked")==false){
	    $('#Phonecollapse').collapse({toggle: false});
			$('.call_for_price_group input').prop('readonly', true);
	  }
	});
	///////////////////////////////////////////////////////////
	//Begin highlight Sub Menu
	var thisUrl = window.location.search; // = ?page=wp-helper&tab=login
	var murl = $("a[href='admin.php"+thisUrl+"']");
	$("ul.wp-submenu-wrap > li").find(murl).parent().addClass('current');
	$("ul.wp-submenu-wrap > li").find(murl).addClass("current");
	// Add Color Picker to all inputs that have 'color-field' class
	$('.color-field').wpColorPicker();

	//Tooltip
  $('[data-toggle="tooltip"]').tooltip(
	{
		animated: 'fade',
		placement: 'right',
		html: true
	}
  );
	//remove preview image
	$('.mbwph-image-preview').on('click', '.img-remove', function( event ){
		  event.preventDefault();
		  var id = $(this).closest("div").attr("id");
		  $("#" + id).find(" .imgpreview_" + id).remove();
		  $("#" + id).find(" i.img-remove").remove();
		  $("#" + id).find(" .mbwph_image_url").val("");
		  $("#" + id).find(" .image_id").val("");
		  $(this).find().remove();
		  return false;
	  });
	// Uploading files v2
	var file_frame;

	  $('.mbwph-image-preview').on('click', function( event ){
		event.preventDefault();
		var divid = $(this).attr("id");
		//alert(divid);
		// Create the media frame.
		file_frame = wp.media.frames.file_frame = wp.media({
		title: 'Select Image',
		button: {
			text: 'Choose'
		},
		multiple: false  // Set to true to allow multiple files to be selected
		});

		// When an image is selected, run a callback.
		file_frame.on( 'select', function() {
			var selection = file_frame.state().get('selection');

			selection.map( function( attachment ) {
				//alert(divid);
				attachment = attachment.toJSON();
				$("#" + divid + " .imgpreview_" + divid).remove();
				$("#" + divid).find(" i.img-remove").remove();
				$("#" + divid).append('<i class="dashicons dashicons-no-alt img-remove"></i><img class="imgpreview_' + divid + '" src="' + attachment.url + '" />');
				$("#" + divid + " .mbwph_image_url").val(attachment.url);
				$("#" + divid + " .image_id").val(attachment.id);
			});

		});
			// Finally, open the modal
			file_frame.open();
	  });
	//Show/Hide Password
	$("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password span').addClass( "dashicons-hidden" );
            $('#show_hide_password span').removeClass( "dashicons-visibility" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password span').removeClass( "dashicons-hidden" );
            $('#show_hide_password span').addClass( "dashicons-visibility" );
        }
    });

	//Accordion
	var acc = document.getElementsByClassName("mwph-accordion");
	var i;

	for (i = 0; i < acc.length; i++) {
		acc[i].addEventListener("click", function() {
		event.preventDefault();
		this.classList.toggle("active");
		var panel = this.nextElementSibling;
		if (panel.style.maxHeight) {
			panel.style.maxHeight = null;
		} else {
			panel.style.maxHeight = panel.scrollHeight + "px";
		}
		});
	}

	//jQuery Number Slider
	/*$("#frm_login_top_margin").slider();
		$("#frm_login_top_margin").on("slide", function(slideEvt) {
			$("#marginVal").val(slideEvt.value);
	});
	$("#frm_login_width").slider();
		$("#frm_login_width").on("slide", function(slideEvt) {
			$("#widthVal").val(slideEvt.value);
	});*/
	$("#set_logo_size").slider({tooltip: 'hide'});
	$("#set_logo_size").on("slide", function(slideEvt) {
			$("#logoSizeVal").val(slideEvt.value);
	});
	$("#set_logo_size").on("change",function(slideEvt) {
			$("#logoSizeVal").val(slideEvt.value.newValue);
	});
	$("#set_logo_height").slider({tooltip: 'hide'});
	$("#set_logo_height").on("slide", function(slideEvt) {
		$("#logoHeightVal").val(slideEvt.value);
	});
	$("#set_logo_height").on("change", function(slideEvt) {
		$("#logoHeightVal").val(slideEvt.value.newValue);
	});

	//Fixed on scroll
	/*$(window).scroll(function() {
		if($(this).scrollTop()>50) {
			$( ".savebutton" ).addClass("fixed-me");
		} else {
			$( ".savebutton" ).removeClass("fixed-me");
		}
	});*/
	//Save settings
		$(window).bind('keydown', function(event) {
		    if (event.ctrlKey || event.metaKey) {
		        switch (String.fromCharCode(event.which).toLowerCase()) {
		        case 's':
		            event.preventDefault();
								$('#frm_mbwphOptions').submit();
		            break;
		        }
		    }
		});

		$('#frm_mbwphOptions').submit(function() {
			$('#mbwphLoader').append('<div class="loader mbwph-loader"> <img class="loader-outter" src="/wp-content/plugins/wp-helper-lite/assets/images/wp-helper-loading.gif"></div>');
			$('#mbwphLoader').modal('show');
			$(this).ajaxSubmit({
				success: function(){
					$('#mbwphLoader').modal('hide').data( 'modal', null );
					$('#mbwphResult').html("<div id='mbwphPopup' class='modal'><div id='saveMessage' class='successModal'></div></div>");
					$('#saveMessage').append("<span><span class='dashicons dashicons-saved'></span> Đã lưu cài đặt</span>");
					$('#mbwphPopup').modal('show');
				},
				timeout: 5000
			});
			setTimeout(function() { $('#mbwphPopup').modal('hide'); }, 4000);
			return false;
		});
		
	var MaxInputs       = 4;
	var FieldNumber 	= $(".phone-field").length;
	var PremiumActive   = $('#premium-active').length;
	if (!PremiumActive) {
		MaxInputs 		= 1;
	}
	$('#mbwhp-AddMoreFieldBox').click(function (e) {
		if(FieldNumber <= MaxInputs) {
			FieldNumber++;
			$('#mbwhp-inputsWrapper').append('<div name="mbwhp-mytext[]" class="phone-field" id="contact-obj-'+FieldNumber+'">'+
			'<div class="mbmwph-phone-field form-row social-group pb-2">' +
			'<div class="form-group col-md-3">'+'<div class="input-group">'+'<div class="input-group-prepend">'+'</div>'+
					'<select name="social_contacts[contact-obj-'+FieldNumber+'][phone-avatar]" class="custom-select selectpicker call-number-field">'+
					'<option id="avatar">Chọn ảnh</option>'+
					'<option value="1" >Nam</option>'+ '<option value="2">Nữ</option>'+ '<option value="3">Support 24/7</option>'+'</select>'+
				'</div>'+
			'</div>'+
			'<div class="form-group col-md-4">'+
				'<input type="text" id="social_contacts[contact-obj-'+FieldNumber+'][phone-name]" name="social_contacts[contact-obj-'+FieldNumber+'][phone-name]" value="" class="form-control" placeholder="Vị trí"/>'+
			'</div>'+
			'<div class="form-group col-md-4">'+
				'<input type="tel" title="Bạn cần điền đúng số điện thoại" id="social_contacts[contact-obj-'+FieldNumber+'][phone-number]" name="social_contacts[contact-obj-'+FieldNumber+'][phone-number]" value="" class="form-control mbwph-phone-number" placeholder="Vd: 0909 XXX XXX"/>'+
			'</div>'+
			'<a href="#" type="button"  class="mbwhp-removeField"><span class="dashicons dashicons-dismiss" id="mbwhp-remove-phone"></span></a>'+'</div>'+'</div>');

			$("#mbwhp-AddMoreFieldId").show();
			$("#mbwhp-DisableAddMoreFieldBox").show();
			if (FieldNumber == 5) {
				$("#mbwhp-AddMoreFieldId").hide();
				return false;
			}
			if ((!PremiumActive) && (FieldNumber == 2)) {
				$("#mbwhp-AddMoreFieldBox").hide();
				$("#mbwhp-lineBreak").html("<a type='button' href='#' id='mbwhp-DisableAddMoreFieldBox' class='btn btn-secondary btn-sm disabled'>Thêm liên hệ</a> <span class='description'>Nâng cấp <strong class='premium-text'>Premium</strong> để thêm liên hệ.</span>"); 
				$("#mbwhp-lineBreak").removeClass('mbwhp-lineBreak-before');
				$("#mbwhp-lineBreak").addClass('mbwhp-lineBreak-after');
				return false;
			}
		}
		return false;
	});
	
	$("body").on("click",".mbwhp-removeField", function(e){
		$(this).parent('div > div').remove();
		FieldNumber--;
		$("#mbwhp-DisableAddMoreFieldBox").hide();
		$("#mbwhp-AddMoreFieldId").show();
		$("#mbwhp-AddMoreFieldBox").show();
		$("#mbwhp-AddMoreFieldBox").removeClass('disabled');
		$("#mbwhp-AddMoreFieldBox").removeClass('btn-secondary');
		$("#mbwhp-AddMoreFieldBox").addClass('btn-success');
		$("#mbwhp-lineBreak").html("");
		return false;
	});

	//valid phone field
	$(".mbwph-phone-number").keypress(function(event) {
		return /\d/.test(String.fromCharCode(event.keyCode));
	});

});
