function workout(){
	  $('a.tdata').click(function(){
	 	var megaDate = document.getElementById('dateOutput').value;
	  	$.ajax({
			url : '/workouts/ajax_view/'+megaDate,
			success : function( response ) {
				var data = document.getElementById('statsadd');
				data.innerHTML = response;
				addworkout();
				removeWorkout();
				removeActivity();
			},
			error : function ( ) {
				alert ( "Error" );
			}
		});	
	  
	  });	
}

$(document).ready(function(){
	$('#exerciseCategory').change(function(){
		var category = document.getElementById('exerciseCategory').value;
		var subcategory = $('input:radio:checked').val();
		$.ajax({
			url: '/workouts/ajax_category/'+category+'/'+subcategory,
			success : function(response){
			var data = document.getElementById('exercises');	
			data.innerHTML = response;	
			},
			error: function(){
				alert('Error');	
			}
		})
	})	
})

$(document).ready(function(){
	$('.radio').change(function(){
		var category = document.getElementById('exerciseCategory').value;
		var subcategory = $('input:radio:checked').val();
		$.ajax({
			url: '/workouts/ajax_category/'+category+'/'+subcategory,
			success : function(response){
			var data = document.getElementById('exercises');	
			data.innerHTML = response;	
			},
			error: function(){
				alert('Error');	
			}
		})
	})	
})

$(document).ready(function(){
	$('#addWorkout').click( function( ev ) {
		if(document.getElementById('exercise_id') == null || document.getElementById('exercise_id').value == 0){
			alert('You must select an exercise');
		}else{
			  var exercise_id = document.getElementById('exercise_id').value;
				  var megaDate = document.getElementById('dateOutput').value;
					var user_id = document.getElementById('user_id').value;
			  
			 var data = { data : { created : megaDate, exercise_id : exercise_id, user_id : user_id } };
			  var count = 0;
			  $.ajax( {
				data : data,
				url : '/workouts/ajax_addworkout/'+megaDate,
				type : 'post',
				success : function( response ) {
					if(response.length <= 50){
						window.location = '/workouts#'+response
					}else{
						$('.addWorkout').each(function(index){
							data = document.getElementById('addWorkout'+index);
							count  = index +1;	
						})
						data.innerHTML = response;
						var html = "<div class ='addWorkout' id ='addWorkout"+count+"'></div>"
						var test = document.getElementById('addWorkout'+(count-1));
						test.innerHTML = test.innerHTML + html;
						
						var id = 0;
						$('p.add').each(function(index){
							id = $(this).attr('id');
						})
						newAddWorkout(id);
					}
					newRemoveWorkout(id);
					removeActivity();
				}
			  });
		}
			 ev.preventDefault();
	 });
});
  
//End