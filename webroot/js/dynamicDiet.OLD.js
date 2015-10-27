function dynamicDiet(){
	$('.food_id').change(function(){
		var yo = $(this).attr('id');
		var test = yo.split('_');
		var id = test[1];
		var quantity = document.getElementById('FoodentryQuantity_'+id).value;
		var selected = document.getElementById('foodid_'+id).value;
		document.getElementById('quantity_'+id).style.display = 'block';
	  	$.ajax({
			url : '/dailydiets/ajax_mealstats/'+id+'/'+quantity+'/'+selected,
			success : function( response ) {
				var data = document.getElementById('mealstats_'+id);
				data.innerHTML = response;
				var foodtype = document.getElementById('foodtype_'+id).innerHTML;
				if (foodtype == 0){
					var metric = document.getElementById('metricMass_'+id).innerHTML;
				}else{
					var metric = document.getElementById('metricVolume_'+id).innerHTML;
				}
				checkType(metric, foodtype, id);
				updateTotals();
			},
			error : function ( ) {
				alert ( "Error" );
			}
		});	
	  
	  });
	  
	$('.FoodentryQuantity').focusout(function(){
		var tempid = $(this).attr('id');
		var splitString = tempid.split('_');
		var id = splitString[1];
		var quantity = document.getElementById('FoodentryQuantity_'+id).value;
		var selected = document.getElementById('foodid_'+id).value;
		$.ajax({
			url : '/dailydiets/ajax_mealstats/'+id+'/'+quantity+'/'+selected,
			success : function( response ) {
				var data = document.getElementById('mealstats_'+id);
				data.innerHTML = response;
				updateTotals();		
			},
			error : function ( ) {
				alert ( "Error" );
			}
		});	
	  
	  });
  
	  $('a.delete').click(function(){
		$(this).parent().parent().remove();
		var id = $(this).attr('id');
			$.ajax({
			  url : '/dailydiets/ajax_foodentry_remove/'+id,
			  success : function( reponse ) {
				 updateTotals();
			  },
			  error :  function() {
					alert ('Error');  
			  }
			});
	  });
	  
	$('.food_category').change(function(){
		var yo = $(this).attr('id');
		var test = yo.split('_');
		var id = test[1];
		var category = document.getElementById('foodCategory_'+id).value;
		document.getElementById('foodSelect_'+id).style.display = 'none'; 
		$.ajax({
			url: '/dailydiets/ajax_category/'+category+'/'+id,
			success : function(response){
			var data = document.getElementById('foodSubcategory_'+id);
			data.innerHTML = response;
			//dynamicDiet();
			subcategory(id);
			},
			error: function () {
				alert('Error');	
			}
		})
	})
}

function subcategory(id){
	$('#foodSubcategorySelect_'+id).change(function(){
		var subcategory = document.getElementById('foodSubcategorySelect_'+id).value;
		document.getElementById('foodSelect_'+id).style.display = 'block'; 
		$.ajax({
			url: '/dailydiets/ajax_subcategory/'+subcategory+'/'+id,
			success : function(response){
			var data = document.getElementById('foodSelect_'+id);
			data.innerHTML = response;
			//addQuantity(id);
			 dynamicDiet();
			},
			error: function () {
				alert('Error');	
			}
		})
	})
}

function updateTotals(){
				var totalProtein = 0;
				var totalCarbs = 0;
				var totalFat = 0;
				var totalFibre = 0;
				var totalCalories = 0;
					
				$('.mealstats').each(function(indexmeals, element) {
					var tempid = $(this).attr('id');
					var splitString = tempid.split('_');
					var totalid = splitString[1];
			
					var proteinString = $('#protein'+totalid).html();
					var splitProtein =  proteinString.split(' ');
					var protein = splitProtein[1];
					protein = parseFloat(protein);
					
					var carbsString = $('#carbs'+totalid).html();
					var splitCarbs =  carbsString.split(' ');
					var carbs = splitCarbs[1];
					carbs = parseFloat(carbs);
					
					var fatString = $('#fat'+totalid).html();
					var splitFat =  fatString.split(' ');
					var fat = splitFat[1];
					fat = parseFloat(fat);
					
					var fibreString = $('#fibre'+totalid).html();
					var splitFibre =  fibreString.split(' ');
					var fibre = splitFibre[1];
					fibre = parseFloat(fibre);
					
					var caloriesString = $('#calories'+totalid).html();
					var splitCalories =  caloriesString.split(' ');
					var calories = splitCalories[1];
					calories = parseFloat(calories);
					
					totalProtein = Math.round((totalProtein + protein)*100)/100;
					totalCarbs = Math.round((totalCarbs + carbs)*100)/100;
					totalFat = Math.round((totalFat + fat)*100)/100;
					totalFibre = Math.round((totalFibre + fibre)*100)/100;
					totalCalories = Math.round((totalCalories + calories)*100)/100;
					
				document.getElementById('totalprotein').innerHTML = 'Total Protein: '+totalProtein;
				document.getElementById('totalcarbs').innerHTML = 'Total Carbs: '+totalCarbs;
				document.getElementById('totalfat').innerHTML = 'Total Fat: '+totalFat;
				document.getElementById('totalfibre').innerHTML = 'Total Fibre: '+totalFibre;
				document.getElementById('totalcalories').innerHTML = 'Total Calories: '+totalCalories;
	
	})
}

function checkType(metric, foodtype, id){
	if(metric == 1){
		if(foodtype == 0){
			document.getElementById('type_'+id).innerHTML = 'grams(g)';
		}else{
			document.getElementById('type_'+id).innerHTML = 'millilitres(mL)';
		}
		
	}else{
		if(foodtype == 0){
			document.getElementById('type_'+id).innerHTML = 'ounce(oz)';
		}else{
			document.getElementById('type_'+id).innerHTML = 'pint(pt)';
		}
	}
}

function addMeal(){
		  $('p.add').click(function(){
			var id = $(this).attr('id');
			var data = '';
			var count = 0;
				$.ajax({
					url : '/dailydiets/ajax_foodentry_add/'+id,
					success : function( response ) {
						$('.singleFoodentry').each(function(index){
							data = document.getElementById('singleFoodentry'+index);
							count  = index +1;	
						}) 
						data.innerHTML = response;
						var html = "<div class ='singleFoodentry' id ='singleFoodentry"+count+"'></div>"
						var test = document.getElementById('singleFoodentry'+(count-1));
						test.innerHTML = test.innerHTML + html;
						dynamicDiet();
					},
					error : function ( ) {
						alert ( "Error" );
					}
				})
	  });
}