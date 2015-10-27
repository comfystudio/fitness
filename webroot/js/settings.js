$(document).ready(function() {
	/***********GENERAL*****************/
	//About
	if($('#UserAbout').attr('value') == ''){
		$(this).attr('value', 'About...');	
	}
	
	$('#UserAbout').focus(function(){
		if($(this).attr('value') == 'About...'){
			$(this).attr('value', '');
		}
	})
	
	$('#UserAbout').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'About...');
		}
	})
	
	//ALL textboxes
	$('.textbox').each(function(index, element) {
        if($(this).attr('value') == ''){
			var test = $(this).attr('id');
			var yo = test.split('User');
			if(yo[1] == 'Height'){
				var string = yo[1]+'(cm)...';	
			}else{
				var string =  yo[1]+'...';
			}
			$(this).attr('value', ''+string);
		}
    });
	
	$('.textbox').focus(function(){
		var test = $(this).attr('id');
		var yo = test.split('User');
		if(yo[1] == 'Height'){
			var string = yo[1]+'(cm)...';	
		}else{
			var string =  yo[1]+'...';
		}
		if($(this).attr('value') == ''+string){
			$(this).attr('value', '');
		}
	})
	
	$('.textbox').blur(function(){
		var test = $(this).attr('id');
		var yo = test.split('User');
		if(yo[1] == 'Height'){
			var string = yo[1]+'(cm)...';	
		}else{
			var string =  yo[1]+'...';
		}
		if($(this).attr('value') == ''){
			$(this).attr('value', ''+string);
		}
	})
	
	
	
	/***************AJAX**************************/
	
	//password selected
	$('#settings-password').click(function(){
		$('#settings-general').removeClass('li-active');
		$('#settings-privacy').removeClass('li-active');
		$('#settings-notifications').removeClass('li-active');
		
		$('#settings-password').addClass('li-active');
		
			$.ajax({
			url : '/users/ajax_setting_password',
			success : function( response ) {
				$('.setting-content').html(response);
				updateSettings();
			},
			error : function ( ) {
				alert ( "Error" );
			}
		});	
	})
	
	//general selected
	$('#settings-general').click(function(){
		$('#settings-password').removeClass('li-active');
		$('#settings-privacy').removeClass('li-active');
		$('#settings-notifications').removeClass('li-active');
		
		$('#settings-general').addClass('li-active');
		
			$.ajax({
			url : '/users/ajax_setting_general',
			success : function( response ) {
				$('.setting-content').html(response);
				updateSettings();
			},
			error : function ( ) {
				alert ( "Error" );
			}
		});	
	})
	
	//notifications selected
	$('#settings-notifications').click(function(){
		$('#settings-password').removeClass('li-active');
		$('#settings-privacy').removeClass('li-active');
		$('#settings-general').removeClass('li-active');
		
		$('#settings-notifications').addClass('li-active');
		
			$.ajax({
			url : '/users/ajax_setting_notifications',
			success : function( response ) {
				$('.setting-content').html(response);
				updateSettings();
			},
			error : function ( ) {
				alert ( "Error" );
			}
		});	
	})
	
	//privacy selected
	$('#settings-privacy').click(function(){
		$('#settings-password').removeClass('li-active');
		$('#settings-notifications').removeClass('li-active');
		$('#settings-general').removeClass('li-active');
		
		$('#settings-privacy').addClass('li-active');
		
			$.ajax({
			url : '/users/ajax_setting_privacy',
			success : function( response ) {
				$('.setting-content').html(response);
				updateSettings();
			},
			error : function ( ) {
				alert ( "Error" );
			}
		});	
	})
	
});

function updateSettings(){
	/**********PASSWORDS*****************/
	$('#UserPassword').hide();
	$('#UserFakepassword').focus(function(){
		$('#UserFakepassword').hide();
		$('#UserCurrentPassword').show();
		$('#UserCurrentPassword').focus();	
	})
	
	$('#UserCurrentPassword').blur(function(){
		if($('#UserCurrentPassword').attr('value') == ''){
			$('#UserCurrentPassword').hide();
			$('#UserFakepassword').show();	
		}	
	})
	
	$('#UserNewPassword').hide();
	$('#UserFakenewpassword').focus(function(){
		$('#UserFakenewpassword').hide();
		$('#UserNewPassword').show();
		$('#UserNewPassword').focus();	
	})
	
	$('#UserNewPassword').blur(function(){
		if($('#UserNewPassword').attr('value') == ''){
			$('#UserNewPassword').hide();
			$('#UserFakenewpassword').show();	
		}	
	})
	
	$('#UserFakepassword').focus(function(){
		$('#UserFakepassword').hide();
		$('#UserCurrentPassword').show();
		$('#UserCurrentPassword').focus();	
	})
	
	$('#UserPassworddelete').hide();
	$('#UserFakepassworddelete').focus(function(){
		$('#UserFakepassworddelete').hide();
		$('#UserPassworddelete').show();
		$('#UserPassworddelete').focus();	
	})
	
	$('#UserPassworddelete').blur(function(){
		if($('#UserPassworddelete').attr('value') == ''){
			$('#UserPassworddelete').hide();
			$('#UserFakepassworddelete').show();	
		}	
	})
	
	$('.settings-delete-profile #UserUsername').attr('value', 'Username...');
	$('.settings-delete-profile #UserUsername').focus(function(){
		if($(this).attr('value') == 'Username...'){
			$(this).attr('value', '');
		}
	})
	$('.settings-delete-profile #UserUsername').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Username...');
		}
	})
	
	$('.settings-delete-profile #UserFakepassworddelete').attr('value', 'Password...');
	
	
	/****************GENERAL******************/
	//About
	if($('#UserAbout').attr('value') == ''){
		$(this).attr('value', 'About...');	
	}
	
	$('#UserAbout').focus(function(){
		if($(this).attr('value') == 'About...'){
			$(this).attr('value', '');
		}
	})
	
	$('#UserAbout').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'About...');
		}
	})
	
	//ALL textboxes
	$('.textbox').each(function(index, element) {
        if($(this).attr('value') == ''){
			var test = $(this).attr('id');
			var yo = test.split('User');
			if(yo[1] == 'Height'){
				var string = yo[1]+'(cm)...';	
			}else{
				var string =  yo[1]+'...';
			}
			$(this).attr('value', ''+string);
		}
    });
	
	$('.textbox').focus(function(){
		var test = $(this).attr('id');
		var yo = test.split('User');
		if(yo[1] == 'Height'){
			var string = yo[1]+'(cm)...';	
		}else{
			var string =  yo[1]+'...';
		}
		if($(this).attr('value') == ''+string){
			$(this).attr('value', '');
		}
		if($('#UserPassworddelete').attr('value') == ''+string){
			$('#UserPassworddelete').attr('value', '');
		}
	})
	
	$('.textbox').blur(function(){
		var test = $(this).attr('id');
		var yo = test.split('User');
		if(yo[1] == 'Height'){
			var string = yo[1]+'(cm)...';	
		}else{
			var string =  yo[1]+'...';
		}
		if($(this).attr('value') == ''){
			$(this).attr('value', ''+string);
		}
		if($('#UserPassworddelete').attr('value') == ''+string){
			$('#UserPassworddelete').attr('value', '');
		}
	})
	
	$('.select-delete-click').click(function(e) {
        if($('.settings-delete-profile').css('display') == 'none'){
			$('.settings-delete-profile').css('display', 'block');
			$('.select-delete-click img').attr('src', '../img/cancel.png');
			
		}else{
			$('.settings-delete-profile').css('display', 'none');
			$('.select-delete-click img').attr('src', '../img/delete-profile.png');	
		}
    });
}