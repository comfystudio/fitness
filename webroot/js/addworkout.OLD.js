function addworkout(){

	$('p.add').click(function(){
		var id = $(this).attr('id');
		var data = '';
		var count = 0;
			$.ajax({
			url : '/workouts/ajax_activity_add/'+id,
			success : function( response ) {
				$('.singleActivity'+id).each(function(index){
					data = document.getElementById('singleActivity'+id+','+index);
					count  = index +1;	
				})
				data.innerHTML = response;
				var html = "<div class ='singleActivity"+id+"' id ='singleActivity"+id+","+count+"'></div>"
				var test = document.getElementById('singleActivity'+id+','+(count-1));
				test.innerHTML = test.innerHTML + html;
				removeActivity();
			},
			error : function ( ) {
				alert ( "Error" );
			}
		});	
	  });	
}

function newAddWorkout(id){
		$('p#'+id).click(function(){
		var data = '';
		var count = 0;
			$.ajax({
			url : '/workouts/ajax_activity_add/'+id,
			success : function( response ) {
				$('.singleActivity'+id).each(function(index){
					data = document.getElementById('singleActivity'+id+','+index);
					count  = index +1;	
				})
				data.innerHTML = response;
				var html = "<div class ='singleActivity"+id+"' id ='singleActivity"+id+","+count+"'></div>"
				var test = document.getElementById('singleActivity'+id+','+(count-1));
				test.innerHTML = test.innerHTML + html;
				removeActivity();
			},
			error : function ( ) {
				alert ( "Error" );
			}
		});	
	  });	
	
	
	
}

function removeActivity(){
	  $('a.delete').click(function(){
		$(this).parent().parent().remove();

		var id = $(this).attr('id');
			$.ajax({
			  url : '/workouts/ajax_activity_remove/'+id,
			  success : function( reponse ) {
			  },
			  error :  function() {
					alert ('Error');  
			  }
			});
	  });
}

function removeWorkout(){
	  $('a.removeWorkout').click(function(){
		var selected = confirm('are you sure');
		if (selected == true){ 
			var temp = $(this).attr('id');
			var yo = temp.split('_');
			var id = yo[1];
				$(this).parent().remove();
					$.ajax({
					  url : '/workouts/ajax_delete/'+id,
					  success : function( reponse ) {
					  },
					  error :  function() {
							alert ('Error');  
					  }
					});
		}
	});
}

function newRemoveWorkout(id){
	  $('#removeWorkout_'+id).click(function(){
		var selected = confirm('are you sure');
		if (selected == true){ 
				$(this).parent().remove();
					$.ajax({
					  url : '/workouts/ajax_delete/'+id,
					  success : function( reponse ) {
					  },
					  error :  function() {
							alert ('Error');  
					  }
					});
		}
	});
}