$(document).ready(function() {
	deepLinking();
	
	//EVERYONE
	$('#social-everyone').click(function(){
		$('#social-friends').removeClass('li-active');
		$('#social-search').removeClass('li-active');
		$('#social-messages').removeClass('li-active');
		$('#social-everyone').addClass('li-active');
		$("#LoadingImage").show();
		
		
			$.ajax({
			url : '/posts/ajax_everyone/',
			success : function( response ) {
				$('.social-wrapper').html(response);
				$("#LoadingImage").hide();
				everyone();
				commentAdd();
				like();
				commentLike();
			},
			error : function ( ) {
				alert ( "Error" );
				$("#LoadingImage").hide();
			}
		});	
	})
	
	//FRIENDS
	$('#social-friends').click(function(){
		$('#social-everyone').removeClass('li-active');
		$('#social-search').removeClass('li-active');
		$('#social-messages').removeClass('li-active');
		$('#social-friends').addClass('li-active');
		$("#LoadingImage").show();
		
			$.ajax({
			url : '/posts/ajax_friends/',
			success : function( response ) {
				$('.social-wrapper').html(response);
				everyone();
				commentAdd();
				like();
				commentLike();
				$("#LoadingImage").hide();
			},
			error : function ( ) {
				alert ( "Error" );
				$("#LoadingImage").hide();
			}
		});	
	})
	
	//SEARCH
	$('#social-search').click(function(){
		$('#social-everyone').removeClass('li-active');
		$('#social-friends').removeClass('li-active');
		$('#social-messages').removeClass('li-active');
		$('#social-search').addClass('li-active');
		$("#LoadingImage").show();
		
			$.ajax({
			url : '/posts/ajax_search/',
			success : function( response ) {
				$('.social-wrapper').html(response);
				searchjs();
				//deepLinking();
				$("#LoadingImage").hide();
			},
			error : function ( ) {
				alert ( "Error" );
				$("#LoadingImage").hide();
			}
		});	
	})
	
	//MESSAGES
	$('#social-messages').click(function(){
		$('#social-everyone').removeClass('li-active');
		$('#social-friends').removeClass('li-active');
		$('#social-search').removeClass('li-active');
		$('#social-messages').addClass('li-active');
		$("#LoadingImage").show();
		
		$.ajax({
		url : '/messages/ajax_messages/',
		success : function( response ) {
			$('.social-wrapper').html(response);
			messages();
			$("#LoadingImage").hide();
		},
		error : function ( ) {
			alert ( "Error" );
			$("#LoadingImage").hide();
		}
		});	
	})
})

function everyone(){
	$('.social-post .textarea').attr('value', 'Write a Post...');
	$('.social-post .textarea').focus(function(){
		if($(this).attr('value') == 'Write a Post...'){
			$(this).attr('value', '');
		}
	})
	$('.social-post .textarea').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Write a Post...');
		}
	})
	
	$('.new-comment .textarea').attr('value', 'Add comment...');
	$('.new-comment .textarea').focus(function(){
		if($(this).attr('value') == 'Add comment...'){
			$(this).attr('value', '');
		}
	})
	$('.new-comment .textarea').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Add comment...');
		}
	})
	
	$('.social-post .textarea').focus(function(){
			$(this).css('height', '200px');
			$(this).parent('.input').css('height', '200px');
	})

	$('.new-comment .textarea').focus(function(){
		var test = $(this).parent().parent().parent().attr('id');
		$('#'+test+' .textarea').css('height', '100px');
		$('#'+test+' .submit').css('display', 'block');
		$('#'+test+' .textarea').css('box-shadow', '0 0 5px 2px #FF0000 inset');
		
	})
	
	$('.new-comment .textarea').focusout(function(){
		var test = $(this).parent().parent().parent().attr('id');
		$('#'+test+' .textarea').css('box-shadow', '0 0 5px 2px #FFFFFF inset');
		
	})
	
	$('.comment-select').click(function(){
		var temp = $(this).attr('id');
		var temp2 = temp.split('-')
		var id = temp2[1];
		$('#comment-'+id+' .textarea').focus();
	})
	
	/*$('.like').click(function(){
		var temp = $(this).attr('id');
		var temp2 = temp.split('_')
		var id = temp2[1];
		$(this).css('display', 'none');
		$.ajax({
			url: '/likes/add/'+id,
			success : function( response ){
				var data = document.getElementById('likes-'+id);
				data.innerHTML = response;
			},
			error : function ( ) {
				alert ( 'Error' );
			}
		});	
	})
	
	$('.comment-like').click(function(){
		$(this).css('display', 'none');
		var temp = $(this).attr('id');
		var temp2 = temp.split('-')
		var id = temp2[1];
			$.ajax({
			url: '/comments/add_like/'+id,
			success : function( response ){
				var data = document.getElementById('new-likes_'+id);
				data.innerHTML = response;
			},
			error : function ( ) {
				alert ( 'Error' );
			}
		});	
		
	})*/
	
}

function like(){
	$('.like').click(function(){
		var temp = $(this).attr('id');
		var temp2 = temp.split('_')
		var id = temp2[1];
		$(this).css('display', 'none');
		$.ajax({
			url: '/likes/add/'+id,
			success : function( response ){
				var data = document.getElementById('likes-'+id);
				data.innerHTML = response;
			},
			error : function ( ) {
				alert ( 'Error' );
			}
		});	
	})	
}

function likeNew(id){
	$('#social-content_'+id+' .like').click(function(){
		var temp = $(this).attr('id');
		var temp2 = temp.split('_')
		var id = temp2[1];
		$(this).css('display', 'none');
		$.ajax({
			url: '/likes/add/'+id,
			success : function( response ){
				var data = document.getElementById('likes-'+id);
				data.innerHTML = response;
			},
			error : function ( ) {
				alert ( 'Error' );
			}
		});	
	})
}

function commentLike(){
	$('.comment-like').click(function(){
		$(this).css('display', 'none');
		var temp = $(this).attr('id');
		var temp2 = temp.split('-')
		var id = temp2[1];
			$.ajax({
			url: '/comments/add_like/'+id,
			success : function( response ){
				var data = document.getElementById('new-likes_'+id);
				data.innerHTML = response;
			},
			error : function ( ) {
				alert ( 'Error' );
			}
		});	
	})	
}

function commentLikeNew(id){
	$('#comment-'+id+' .comment-like').click(function(){
		$(this).css('display', 'none');
		var temp = $(this).attr('id');
		var temp2 = temp.split('-')
		var id = temp2[1];
			$.ajax({
			url: '/comments/add_like/'+id,
			success : function( response ){
				var data = document.getElementById('new-likes_'+id);
				data.innerHTML = response;
			},
			error : function ( ) {
				alert ( 'Error' );
			}
		});	
	})
}

function commentAddNew(id){
	$('.new-comment #submit_'+id).click(function(e) {
       var temp = $(this).attr('id');
		var temp2 = temp.split('_')
		var id = temp2[1];
		var check = checkValidation(id);
		if(check){
			var data  = $(this).siblings('.textarea').find('#text').val();
			var post_id =  $(this).siblings('.#post_id').attr('value');
			$.ajax({
				url: '/comments/ajax_add/'+data+'/'+post_id,
				success : function( response ){
					$('#social-content_'+post_id).html(response);
					everyone();
					likeNew(id);
					commentLikeNew(id);
					commentAddNew(id);
					
				},
				error : function ( ) {
					alert ( 'Error' );
				}
			});
		}
    });	
}

function commentAdd(){
	$('.new-comment .submit').click(function(e) {
		var temp = $(this).attr('id');
		var temp2 = temp.split('_')
		var id = temp2[1];
		var check = checkValidation(id);
		if(check){
			var data  = $(this).siblings('.textarea').find('#text').val();
			var post_id =  $(this).siblings('.#post_id').attr('value');
			$.ajax({
				url: '/comments/ajax_add/'+data+'/'+post_id,
				success : function( response ){
					$('#social-content_'+post_id).html(response);
					everyone();
					likeNew(id);
					commentLikeNew(id);
					commentAddNew(id);
				},
				error : function ( ) {
					alert ( 'Error' );
				}
			});
		}
    });	
}

function searchjs(){
	$('.social-wrapper .textbox').attr('value', 'Search for users...');
	$('.social-wrapper .textbox').focus(function(){
		if($(this).attr('value') == 'Search for users...'){
			$(this).attr('value', '');
		}
	})
	$('.social-wrapper .textbox').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Search for users...');
		}
	})
	
	$('.social-wrapper .textbox').focus(function(){
		$(this).css('box-shadow', '0 0 5px 2px #FF0000 inset');
		
	})
	
	$('.social-wrapper .textbox').focusout(function(){
		$(this).css('box-shadow', '0 0 5px 2px #FFFFFF inset');
		
	})
	
	$('#PostBody').keypress(function(){
		setTimeout(function(){
			var check = checkSearch();
			if(check){
				var value = $('#PostBody').attr('value');
				$.ajax({
				url: '/posts/ajax_search_update/'+value,
				success : function( response ){
					var data = document.getElementById('social-content-search-id');
					data.innerHTML = response;
					follow();
					},
					error : function ( ) {
						alert ( 'Error' );
					}
				});
			}
		}, 1);
	})
}

function follow(){
	$('.follow').click(function(){
		var temp = $(this).attr('id');
		var temp2 = temp.split('_')
		var id = temp2[1];
		
		var temp = $('.view-user').attr('id');
		var temp2 = temp.split('_')
		var user_id = temp2[1];
		
		$(this).css('display', 'none');
		$('#unfollow_'+id).css('display', 'block');
		$.ajax({
			url: '/followers/add/'+id+'/'+user_id,
			success : function( response ){
				$('.home-following').remove();
				$('.home-followers').remove();
				html = $('.home-left-shadow').html();
				html = html + response;
				$('.home-left-shadow').html(html);
				follow();
				hideFollow();
			},
			error : function ( ) {
				alert ( 'Error' );
			}
		});	
	});
	
	$('.unfollow').click(function(){
		var temp = $(this).attr('id');
		var temp2 = temp.split('_')
		var id = temp2[1];
		
		var temp = $('.view-user').attr('id');
		var temp2 = temp.split('_')
		var user_id = temp2[1];
		
		$(this).css('display', 'none');
		$('#follow_'+id).css('display', 'block');
		$.ajax({
			url: '/followers/delete/'+id+'/'+user_id,
			success : function( response ){
				$('.home-following').remove();
				$('.home-followers').remove();
				html = $('.home-left-shadow').html();
				html = html + response;
				$('.home-left-shadow').html(html);
				follow();
				hideFollow();
			},
			error : function ( ) {
				alert ( 'Error' );
			}
		});		
	});
}

function hideFollow(){
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
}

function messages(){
	$('.social-messages .textbox').attr('value', 'To...');
	$('.social-messages .textbox').focus(function(){
		if($(this).attr('value') == 'To...'){
			$(this).attr('value', '');
		}
	})
	$('.social-messages .textbox').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'To...');
		}
	})
	
	$('.social-messages .textarea').attr('value', 'Messages...');
	$('.social-messages .textarea').focus(function(){
		if($(this).attr('value') == 'Messages...'){
			$(this).attr('value', '');
		}
	})
	$('.social-messages .textarea').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Messages...');
		}
	})
	
	$('.messages-reply .textarea').attr('value', 'Write a reply...');
	$('.messages-reply .textarea').focus(function(){
		if($(this).attr('value') == 'Write a reply...'){
			$(this).attr('value', '');
		}
	})
	$('.messages-reply .textarea').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Write a reply...');
		}
	})
	
	$('.new-message').click(function(){
		$(this).css('display', 'none');
		$('.new-message-form').css('display', 'block');
	})
	
	$('.cancel-message').click(function(){
		$('.new-message-form').css('display', 'none');
		$('.new-message').css('display', 'block');
		$('#MessageTo').attr('value', '');
		$('#MessageContent').attr('value', '')
	})
	
	$('.view-message').click(function(){
		var temp = $(this).attr('id');
		var temp2 = temp.split('_')
		var id = temp2[1];
		$('#message-reply_'+id).css('display', 'block');
		$(this).css('display','none');
		$('#hide-message_'+id).css('display', 'block');
		
	})
	
	$('.hide-message').click(function(){
		var temp = $(this).attr('id');
		var temp2 = temp.split('_')
		var id = temp2[1];
		$('#message-reply_'+id).css('display', 'none');	
		$(this).css('display','none');
		$('#view-message_'+id).css('display', 'block');
	})
	
	$('.social-content-messages .textarea').focus(function(){
		//alert('etst');
		$(this).css('box-shadow', '0 0 5px 2px #FF0000 inset');
		$(this).css('height', '200px');
		$(this).parent().css('height', '200px');
	})
	
	$('.social-content-messages .textarea').focusout(function(){
		$(this).css('box-shadow', '0 0 5px 2px #FFFFFF inset');
	})
	
	$('.delete-message').click(function(e) {
        var temp = $(this).attr('id');
		var temp2 = temp.split('_')
		var id = temp2[1];
		
		$.ajax({
			url : '/messages/ajax_delete/'+id,
			success : function( response ) {
				$('#social-wrapper_'+id).remove();
				//$('.social-wrapper').html(response);
				//$("#LoadingImage").hide();
				//everyone();
				//window.location.hash = hash;
				//deepLinkingChange();
			},
			error : function ( ) {
				alert ( "Error" );
				//$("#LoadingImage").hide();
			}
		});	
    });
	
	$('.MessageAjaxMessagesForm .submit').click(function(e) {
        var temp = $(this).parent().attr('id');
		var temp2 = temp.split('_')
		var id = temp2[1];
		var data = new Array();
		
		var message_set_id =  id;
		var text = $(this).siblings().find('#content').val();
		
		var check = checkMessage(id);
		if(check){
			$.ajax({
				url : '/messages/ajax_reply/'+message_set_id+'/'+text,
				success : function( response ) {
					html = $('#message-reply_'+id+' .newMessages').html();
					html += response;
					$('#message-reply_'+id+' .newMessages').html(html);
		
				},
				error : function ( ) {
					alert ( "Error" );
				}
			});
		}
    });
	
	
}

function deepLinking(){
	hash = window.location.hash;
	var temp = hash;
	var temp2 = temp.split('_');
	var shortHash = temp2[0];
	//alert(shortHash);
	
	var selected = '';
	$('.social-header li').each(function(index, element) {
        if($(this).hasClass('li-active')){
			selected = $(this).attr('id');
		}
    });
	
	//alert(shortHash+' '+selected);
	if(shortHash == '#message' && selected != 'social-messages'){
		$('#social-everyone').removeClass('li-active');
		$('#social-friends').removeClass('li-active');
		$('#social-search').removeClass('li-active');
		$('#social-messages').addClass('li-active');
		$("#LoadingImage").show();
		
		$.ajax({
		url : '/messages/ajax_messages/',
		success : function( response ) {
			$('.social-wrapper').html(response);
			messages();
			//window.location.hash = hash;
			deepLinkingChange()
			$("#LoadingImage").hide();
			
		},
		error : function ( ) {
			alert ( "Error" );
			$("#LoadingImage").hide();
		}
	});
	}else if(shortHash == '#friends'){
		$('#social-everyone').removeClass('li-active');
		$('#social-search').removeClass('li-active');
		$('#social-messages').removeClass('li-active');
		$('#social-friends').addClass('li-active');
		$("#LoadingImage").show();
		
			$.ajax({
			url : '/posts/ajax_friends/',
			success : function( response ) {
				$('.social-wrapper').html(response);
				everyone();
				//deepLinking();
				$("#LoadingImage").hide();
			},
			error : function ( ) {
				alert ( "Error" );
				$("#LoadingImage").hide();
			}
		});	
	
	}else if(shortHash == '#post' && selected != 'social-everyone'|| shortHash == '#comment' && selected != 'social-everyone'){
		$('#social-friends').removeClass('li-active');
		$('#social-search').removeClass('li-active');
		$('#social-messages').removeClass('li-active');
		$('#social-everyone').addClass('li-active');
		$("#LoadingImage").show();
		
		
			$.ajax({
			url : '/posts/ajax_everyone/',
			success : function( response ) {
				$('.social-wrapper').html(response);
				$("#LoadingImage").hide();
				everyone();
				//window.location.hash = hash;
				deepLinkingChange();
			},
			error : function ( ) {
				alert ( "Error" );
				$("#LoadingImage").hide();
			}
		});	
	}
}

function deepLinkingChange(){
	$(window).bind('hashchange', function() {
		hash = window.location.hash;
		var temp = hash;
		var temp2 = temp.split('_');
		var shortHash = temp2[0];
		
		var selected = '';
		$('.social-header li').each(function(index, element) {
			if($(this).hasClass('li-active')){
				selected = $(this).attr('id');
			}
		});
		if(shortHash == '#message' && selected != 'social-messages'){
			$('#social-everyone').removeClass('li-active');
			$('#social-friends').removeClass('li-active');
			$('#social-search').removeClass('li-active');
			$('#social-messages').addClass('li-active');
			$("#LoadingImage").show();
			
			$.ajax({
			url : '/messages/ajax_messages/',
			success : function( response ) {
				$('.social-wrapper').html(response);
				messages();
				//window.location.hash = hash;
				//deepLinking()
				$("#LoadingImage").hide();
				
			},
			error : function ( ) {
				alert ( "Error" );
				$("#LoadingImage").hide();
			}
			});
		}else if(shortHash == '#post' && selected != 'social-everyone'|| shortHash == '#comment' && selected != 'social-everyone'){
			$('#social-friends').removeClass('li-active');
			$('#social-search').removeClass('li-active');
			$('#social-messages').removeClass('li-active');
			$('#social-everyone').addClass('li-active');
			$("#LoadingImage").show();
			
			
				$.ajax({
				url : '/posts/ajax_everyone/',
				success : function( response ) {
					$('.social-wrapper').html(response);
					$("#LoadingImage").hide();
					everyone();
					//window.location.hash = hash;
					//deepLinking();
				},
				error : function ( ) {
					alert ( "Error" );
					$("#LoadingImage").hide();
				}
			});	
		}
	});
}

function checkValidation(id){
	var value = $('#submit_'+id).siblings('.textarea').children('.textarea').attr('value');
	var length = value.length;
	 $('#error-message_'+id).css('position', 'static');
	 $('#error-message_'+id).css('font-size', '16px');
	if( /[^a-zA-Z0-9\s!\.](^\.\.\.)?$/.test( value ) ) {
	   $('#error-message_'+id).text('Comment must contain only alphaNumeric characters');
       return false;
    }else if(length > 200){
		$('#error-message_'+id).text('Comment must not be greater than 200 characters');
		return false;	
	}
    return true;   
}

function checkSearch(){
	var value = $('.social-search #PostBody').attr('value');
	var length = value.length;
	$('.error-message').css('position', 'static');
	if( /([^a-zA-Z0-9_\s])+/.test( value ) ) {
	   $('.error-message').text('Search must contain only alphaNumeric characters');
       return false;
    }else if(length > 15){
		$('.error-message').text('Search must not be greater than 15 characters');
		return false;	
	}
	$('.error-message').text(' ');
    return true;  
	
}

function checkMessage(id){
	var value = $('#MessageAjaxMessagesForm_'+id).find('#content').attr('value');
	var length = value.length;
	$('#error-message_'+id).css('position', 'static');
	$('#error-message_'+id).css('float', 'left');
	if( /([^a-zA-Z0-9_\s!\.])+/.test( value ) ) {
	   $('#error-message_'+id).text('Reply must contain only alphaNumeric characters');
       return false;
    }else if(length > 200){
		$('#error-message_'+id).text('Reply must not be greater than 200 characters');
		return false;	
	}
    return true;  
	
}