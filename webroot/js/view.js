$(document).ready(function(e) {
	//Feed Home
	$('#home-feed').click(function(){
		$(this).siblings().removeClass('li-active');
		$(this).addClass('li-active');
		var temp = $('.view-user').attr('id');
		var temp2 = temp.split('_')
		var id = temp2[1];
		
			$.ajax({
			url : '/users/ajax_feed/'+id,
			success : function( response ) {
				$('.home-wrapper').html(response);
				feed();
			},
			error : function ( ) {
				alert ( "Error" );
			}
		});	
	})
	
	//Progress Home
	$('#home-progress').click(function(){
		$(this).siblings().removeClass('li-active');
		$(this).addClass('li-active');
		
			$.ajax({
			url : '/users/ajax_progress/',
			success : function( response ) {
				$('.home-wrapper').html(response);
				progress();
			},
			error : function ( ) {
				alert ( "Error" );
			}
		});	
	})
	
	//Pictures Home
	$('#home-pictures').click(function(){
		$(this).siblings().removeClass('li-active');
		$(this).addClass('li-active');
		var temp = $('.view-user').attr('id');
		var temp2 = temp.split('_')
		var id = temp2[1];
		
			$.ajax({
			url : '/users/ajax_pictures/'+id,
			success : function( response ) {
				$('.home-wrapper').html(response);
				pictures();
			},
			error : function ( ) {
				alert ( "Error" );
			}
		});	
	})
});

jQuery.extend({
	getValues: function(url) {
		var result = null;
		$.ajax({
		url: url,
		type: 'get',
		dataType: 'json',
		async: false,
		success : function( response ){
			result = response;
		},
			error : function ( ) {
				alert ( 'Error JQUERY EXTEND' );
			}
		});	
	   return result;
	}
});

function feed(){
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
	commentAdd();
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
				},
				error : function ( ) {
					alert ( 'Error' );
					//$('#error-message_'+post_id).css('position', 'relative');
					//$('#error-message_'+post_id).html('Comment must contain only alphaNumeric and at most 200 characters');
				}
			});
		}
    });	
}

function pictures(){
	$('#PictureAbout').focus(function(e) {
        $(this).css('box-shadow', '0 0 5px 2px #FF0000 inset');
		$(this).css('height', '100px');
    });
	
	$('#PictureAbout').focusout(function(e) {
        $(this).css('box-shadow', '0 0 5px 2px #FFFFFF inset');
    });
	
	$('.picture-gallery .right').click(function(){
		var temp = $(this).attr('id');
		var temp2 = temp.split('_')
		var id = temp2[1];
		$('.picture-gallery .right').css('display', 'block');
		$(this).css('display', 'none');
		$('.picture-gallery img').css('border', '2px solid black');
		$(this).parent().parent().find('img').css('border', '2px solid red');
		//$('img').css('border', '2px solid red');
		$.ajax({
			url: '/pictures/avatar/'+id,
			success : function( response ){
			},
			error : function ( ) {
				alert ( 'Error' );
			}
		});		
	})
	
	var currentImage = 1;
	$('.picture-click').click(function(e) {
		$('.picture-overlay').delay(500).fadeIn(500);
		$('.wrapper').css('background', 'rgba(0, 0, 0, 0.7)');
		$('.topheader_bg').css('background', 'rgba(0,0,0,0.7)');
		$('.right-nav-content').css('background', 'rgba(0,0,0,0.7)');
		
		var temp3 = $(this).attr('id');
		var temp4 = temp3.split('_')
		var id = temp4[1];
		start(id);
    });
	
	$('.destroy-overlay').click(function(e){
		$('.picture-overlay').fadeOut(500);
		
		setTimeout( function(){
			$('.topheader_bg').css('background', '#F2F2F2');
			$('.wrapper').css('background-image', 'url("../img/bg2.png")');
			$('.right-nav-content').css('background', '#FFFFFF');
   		},500);
	});
	
	/************Carousel****************/
	var imageWidth = 600;
	var temp = $('#mycarousel').attr('class');
	var temp2 = temp.split('_')
	var numberPictures = temp2[1];
	
	$('#index-button-left').click(function(e){	
		goto(1);
		e.preventDefault();
		return false;	
	});	
	
	$('#index-button-right').click(function(e){
		goto(2);
		e.preventDefault();
		return false;
	});
	
	function start(index){
		var left = ((-index * imageWidth)+600)
		currentImage = index;
		$('#mycarousel').animate({left:left},1);
	}
	
	function goto(index){
		var left = ((-currentImage * imageWidth)+600)
		if(currentImage >= 2 && index == 1){
			currentImage = Math.floor(currentImage) -1;
			left += imageWidth;
			$('#mycarousel').animate({left:left},300);
			//return false;
		}
		
		if(currentImage < numberPictures && index == 2){
			currentImage = Math.floor(currentImage) +1;
			left -= imageWidth;
			$('#mycarousel').animate({left:left},300);
			//return false;
		}else{
			
			//return false;	
		}
		
		
	}
	
}

function progress(){
	var temp = $('.view-user').attr('id');
	var temp2 = temp.split('_')
	var id = temp2[1];
	$('#type').change(function(e) {
	   var selected = $(this).attr('value');
	   $.ajax({
			url: '/users/ajax_progress_type/'+selected+'/'+id,
			success : function( response ){
				$('.home-progress-ajax').html(response);
				progress_type();
			},
			error : function ( ) {
				alert ( 'Error' );
			}
		});		
    }).trigger('change');	
	
	
}

function progress_type(){
	$('#option').change(function(e) {
       var temp =  $('.home-progress-option').attr('id');
	   var temp2 = temp.split('_')
	   var id = temp2[1];
	   var temp3 = $('.view-user').attr('id');
	   var temp4 = temp3.split('_')
	   var user_id = temp4[1];
	   var selected = $(this).attr('value');
	   var selected2 = $('#option option:selected').text()
	   if(id == 2){
			$.ajax({
				url: '/users/ajax_graph/'+selected+'/'+id+'/'+user_id,
				dataType:"json",
				async: false,
				success : function( response ){
					var res = response;
					graph(selected, res);
				},
				error : function ( ) {
					alert ( 'Error' );
				}
			});
	   }else if(id == 1){
		   $.ajax({
				url: '/users/ajax_graph/'+selected+'/'+id+'/'+user_id,
				dataType:"json",
				async: false,
				success : function( response ){
					var res = response;
					graphDailydiet(selected, res);
				},
				error : function ( ) {
					alert ( 'Error' );
				}
			});
		   
	   }else if(id == 0){
		   $.ajax({
				url: '/users/ajax_graph/'+selected+'/'+id+'/'+user_id,
				dataType:"json",
				async: false,
				success : function( response ){
					var res = response;
					graphWorkout(selected, res, selected2);
				},
				error : function ( ) {
					alert ( 'Error' );
				}
			});
	   }
	}).trigger('change');
}

function graph(selected, res){
	$.ajax({
		url: '/users/getUser/',
		success : function( response ){
			  var user = JSON.parse ( response );
			  var label = getLabelMeasure(selected, user);
			  var wrapper = new google.visualization.ChartWrapper({
			  chartType: 'LineChart',
			  dataTable: res,
			  
			  options: {'title': selected.toUpperCase(),
			  			'backgroundColor.fill':'red',
						'chartArea':{width:"80%", height:"70%"},
						'colors':['red', 'red'],
						'fontName':'Arial',
						//'titleTextStyle': {fontStyle:'normal'},
						'width':700,
						'height':400,
						'hAxis':{title: 'Date', titleTextStyle: {color: 'red'}},
						'vAxis':{title: label, titleTextStyle: {color:'red', fontStyle:'normal'}},
						'legend':'none',
						'pointSize':5},
			containerId: 'chart_div',
			});
			wrapper.draw();
			google.setOnLoadCallback(graph);
			
		},
		error : function ( ) {
			alert ( 'Error' );
		}
	});		
}

function graphWorkout(selected, res, selected2){
	$.ajax({
		url: '/users/getUser/',
		success : function( response ){
			  var user = JSON.parse ( response );
			  var label = getLabelWorkout(selected, user);
			  var wrapper = new google.visualization.ChartWrapper({
			  chartType: 'ColumnChart',
			  dataTable: res,
			  options: {'title': selected2.toUpperCase(),
			  			'backgroundColor.fill':'red',
						'chartArea':{width:"80%", height:"70%"},
						'colors':['red', 'blue', 'green', 'yellow', 'purple'],
						'fontName':'Arial',
						'width':700,
						'height':400,
						'hAxis':{title: 'Date', titleTextStyle: {color: 'red'}},
						'vAxis':{title: label, titleTextStyle: {color:'red', fontStyle:'normal'}},
						'legend':'none'},
			containerId: 'chart_div',
			});
			wrapper.draw();
			google.visualization.events.addListener(wrapper, 'ready', fixGoogleCharts);
			
			 function fixGoogleCharts()
			{
				$( 'iframe[id*=Drawing_Frame_]' ).each( function()
				{
					$( $( this ).get( 0 ).contentDocument ).find( "g" ).each( function()
					{
						if ( !$( this ).attr( 'clip-path' ) ) return;
						if ( $( this ).attr( 'clip-path' ).indexOf( 'url(#') == -1 ) return;
						$( this ).attr( 'clip-path', 'url(' + document.location + $( this ).attr( 'clip-path' ).substring( 4 ) )
					})
				});
			}
		},
		error : function ( ) {
			alert ( 'Error' );
		}
	});	
}

function graphDailydiet(selected, res){
	$.ajax({
		url: '/users/getUser/',
		success : function( response ){
			  var user = JSON.parse ( response );
			 // var label = getLabelMeasure(selected, user);
			  var wrapper = new google.visualization.ChartWrapper({
			  chartType: 'PieChart',
			  dataTable: res,
			  
			  options: {'title': 'Macros Consumed'.toUpperCase(),
			  			'backgroundColor.fill':'red',
						'chartArea':{width:"80%", height:"70%"},
						'colors':['blue', 'green', 'yellow', 'orange', 'purple'],
						'fontName':'Arial',
						//'titleTextStyle': {fontStyle:'normal'},
						'width':700,
						'height':400,
						//'hAxis':{title: 'Date', titleTextStyle: {color: 'red'}},
						//'vAxis':{title: label, titleTextStyle: {color:'red', fontStyle:'normal'}},
						'is3D':'true'},
			containerId: 'chart_div',
			});
			wrapper.draw();
			google.setOnLoadCallback(graphDailydiet);
			//html = $('#chart_div').html();
			html = 'Calories: '+res['total']['calories'];
			$('#total-calories').html(html);
			
		},
		error : function ( ) {
			alert ( 'Error' );
		}
	});		
}

function getLabelWorkout(selected, user){
	var label = '';
	var exercise = $.getValues('/workouts/getExercise/'+selected);
	if(exercise['Exercise']['type'] == 0){
		if(user['metricMass'] == 1){
			return label = 'Kilograms (kg)';
		}else{
			return label = 'Pounds (ib)';
		}
	}else{
		if(user['metricLength'] == 1){
			return label = 'Kilometres (km)';
		}else{
			return label = 'Miles ';
		}
	}
}


function getLabelMeasure(selected, user){
	var label = '';
	if(selected == 'weight'){
		if(user['metricMass'] == 1){
			return label = 'Kilograms (kg)';
		}else{
			return label = 'Pounds (ib)';
		}
	}else if(selected == 'bodyfat'){
		return label = 'BodyFat (%)';
	}else{
		if(user['metricLength'] == 1){
			return label = 'Centimetre (cm)';	
		}else{
			return label = 'Inches (in)';	
		}
	}
	
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


function checkValidation(id){
	var value = $('#submit_'+id).siblings('.textarea').children('.textarea').attr('value');
	var length = value.length;
	 $('#error-message_'+id).css('position', 'static');
	 $('#error-message_'+id).css('font-size', '16px');
	if( /([^a-zA-Z0-9_\s!\.])+/.test( value ) ) {
	   $('#error-message_'+id).text('Comment must contain only alphaNumeric characters');
       return false;
    }else if(length > 200){
		$('#error-message_'+id).text('Comment must not be greater than 200 characters');
		return false;	
	}
    return true;   
}