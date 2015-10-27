$(document).ready(function() {
	deleteNotifications();
	
	/***DEFAULT HEADER**/
	$('#menu li').mouseover(function(){
		var id = $(this).find('a').attr('id');
		$('#'+id).css('background-position', 'bottom');
		$(this).mouseout(function(){
			$('#'+id).css('background-position', 'top');
		})
	})
	
	$('#header-picture').click(function(){
		$('#header-picture').css('background-color', '#272824');
		if($('.header-options').css('display') == 'none'){
			$('.header-options').css('display', 'block');
		}else{
			$('.header-options').css('display', 'none');
			$('#header-picture').css('background-color', 'transparent');
		}
	})
	
	$('#header-picture').mouseover(function(){
		if($('.header-options').css('display') == 'none'){
			$('#header-picture').css('background-color', '#272824');
		}
	})
	
	$('#header-picture').mouseout(function(){
		if($('.header-options').css('display') == 'none'){
			$('#header-picture').css('background-color', 'transparent');
		}
	})
	
	$('#mail').click(function(){
		$('#mail').css('background-color', '#272824');	
		if($('#header-notifications').css('display') == 'none'){
			$('#header-notifications').css('display', 'block');
		}else{
			$('#header-notifications').css('display', 'none');
			$('#mail').css('background-color', 'transparent');
		}
		
	})
	
	$('#mail').mouseover(function(){
		if($('#header-notifications').css('display') == 'none'){
			$('#mail').css('background-color', '#272824');
		}
	})
	
	$('#mail').mouseout(function(){
		if($('#header-notifications').css('display') == 'none'){
			$('#mail').css('background-color', 'transparent');
		}
	})
	
	/***LOGIN***/
	$('#UserPassword').hide();
	$('#UserFakepassword').focus(function(){
		$('#UserFakepassword').hide();
		$('#UserPassword').show();
		$('#UserPassword').focus();	
	})
	
	$('#UserPassword').blur(function(){
		if($('#UserPassword').attr('value') == ''){
			$('#UserPassword').hide();
			$('#UserFakepassword').show();	
		}	
	})
	
	$('#UserUsername').focus(function(){
		if($('#UserUsername').attr('value') == 'Username...'){
			$('#UserUsername').attr('value', '');
		}
	})
	
	$('#UserUsername').blur(function(){
		if($('#UserUsername').attr('value') == ''){
			$('#UserUsername').attr('value', 'Username...');
		}
	})
	
	$('#UserEmail').focus(function(){
		if($('#UserEmail').attr('value') == 'Email...'){
			$('#UserEmail').attr('value', '');
		}
	})
	
	$('#UserEmail').blur(function(){
		if($('#UserEmail').attr('value') == ''){
			$('#UserEmail').attr('value', 'Email...');
		}
	})
	
	
	
	/**************HOME****************/
	
	$('#following-hide').click(function(){
		if($('.following').css('display') == 'block'){
			$('.following').css('display', 'none');
			$('#following-hide').html('show');
		}else{
			$('.following').css('display', 'block');
			$('#following-hide').html('hide');
		}
	})
	
	
	$('#followers-hide').click(function(){
		if($('.followers').css('display') == 'block'){
			$('.followers').css('display', 'none');
			$('#followers-hide').html('show');
		}else{
			$('.followers').css('display', 'block');
			$('#followers-hide').html('hide');
		}
	})
	
	
	/**************SOCIAL****************/
	
	$('#meet-others-hide').click(function(){
		if($('.meet-others').css('display') == 'block'){
			$('.meet-others').css('display', 'none');
			$('#meet-others-hide').html('show');
		}else{
			$('.meet-others').css('display', 'block');
			$('#meet-others-hide').html('hide');
		}
	})
	
	/**************OLD***************/
	
	
});

function deleteNotifications(){
	$('.notifications-delete').click(function(e) {
		var temp =  $(this).attr('id');
	   	var temp2 = temp.split('_')
	   	var id = temp2[1];
		
		$.ajax({
			url: '/notifications/ajax_delete/'+id,
			success : function( response ){
				$('#header-notifications').html(response);
				deleteNotifications();
				var count = 0;
				$('.notifications-pictures').each(function(index, element) {
                    count = count + 1;
                });
				var html = '<p>'+count+'</p>';
				$('#notifications-alert').html(html);
			},
			error : function ( ) {
				alert ( 'Error' );
			}
		});
        
    });
}
