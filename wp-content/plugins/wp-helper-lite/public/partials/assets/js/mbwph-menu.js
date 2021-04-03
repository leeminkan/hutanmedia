//Duplicate menu button
jQuery('.publishing-action').ready(function($){
	// Multiple variables are used to make single line short and readable.
	var mbwphBtName = mbwph_button_duplicate.mbwph_bt_name,
		menuName	  = $("[name='menu-name']").val(),
		menuLink	  = 'admin.php?action=duplicate_ppmc_menu_maker',
		menu_clone 	  = menuLink+'&name='+menuName,
		btClass	  = 'button button-danger button-large';

	// Add 'Duplicate' button next to menu 'Save' button.
	if ( '1' === ( mbwph_button_duplicate.enable_in_menu ) ) {
		$( '.publishing-action' ).
		append('<a id="btn_duplicate_menu" name="btn_duplicate_menu" mbwph_menu_id="'+menuName+'" class="'+
		btClass+'" >'+mbwphBtName+'</a>');
		
	}
	jQuery('a#btn_duplicate_menu').on( 'click', function(e){
		e.preventDefault();
		mbwph_menu_cloning( jQuery( this ) )
	});
});
function mbwph_menu_cloning( context ){
	
	var menu_name	=	jQuery( context ).attr('mbwph_menu_id');

	jQuery.ajax({
		url:mbwph_button_duplicate.ajax_url,
		type:'post',
		dataType:'json',
		data:{
			action:'mbwph_duplicate_menu_maker',
			name: menu_name
		},
		beforeSend:function(){
			//var HTML_MESSAGE	=	'<div id="mbwphPopup" class="modal">Duplicating <strong>"'+menu_name+'"</strong> menu.<br/>Be patience while processing complete.';
			
			//HTML_MESSAGE	+=	'It may take a while depends on data and server size.</div>';		
			//alert('');			
		}
	}).success(function( response ){
				
		var message = "";
		
		if( response.error ){
			message	= response.error;
		}else{
			message = 'Menu đã được khởi tạo thành công. Chọn danh sách menu để xem kết quả.';
		}
		alert(message);
		location.reload();
	});

}