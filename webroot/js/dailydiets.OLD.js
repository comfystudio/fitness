function dailydiets(){
	//alert('test');
	$('a.tdata').click(function(){
	 	var megaDate = document.getElementById('dateOutput').value;
	  	$.ajax({
			url : '/dailydiets/ajax_view/'+megaDate,
			success : function( response ) {
				var data = document.getElementById('statsadd');
				data.innerHTML = response;
				if(document.getElementById('foodId') == null){
					$('#addDailyDiet').show();	
				}else{
					$('#addDailyDiet').hide();	
				}
				dynamicDiet();
				addMeal();
			},
			error : function ( ) {
				alert ( "Error" );
			}
		});	
	  
	  });	
	
}
/*$(document).ready(function(){
	$('#food_category').change(function(){
		//alert('test');
		var yo = $(this).attr('id');
		var test = yo.split('_');
		var id = test[1];
		var category = document.getElementById('foodCategory_'+id).value;
		$.ajax({
			url: '/dailydiets/ajax_category/'+category,
			success : function(response){
			var data = document.getElementById('foodSelect_'+id);
			data.innerHTML = response;
			},
			error: function () {
				alert('Error');	
			}
		})
	})
})*/
/*$(document).ready(function(){
	$('#foodcategories').change(function(){
		var category = document.getElementById('foodcategories').value;
		$.ajax({
			url: '/dailydiet/ajax_category/'+category,
			success : function(response){
			var data = document.getElementById('foods');
			data.innerHTML = response;
			},
			error: function () {
				alert('Error');	
			}
		})
	})	
})*/

$(document).ready(function(){
	$('#addDailyDiet').click( function( ev ) {
		//  var exercise_id = document.getElementById('exercise_id').value;
		$('#addDailyDiet').hide();
			  var megaDate = document.getElementById('dateOutput').value;
			  	var user_id = document.getElementById('user_id').value;
		  
		 var data = { data : { created : megaDate, user_id : user_id } };
		  $.ajax( {
			data : data,
			url : '/dailydiets/ajax_adddailydiet/'+megaDate,
			type : 'post',
			success : function( response ) {
				var data = document.getElementById('statsadd');
				data.innerHTML = response + data.innerHTML;
				
				dynamicDiet();
				addMeal();
			}
		  });
		  ev.preventDefault();
	 });
});