$(document).ready(function(e) {
	var cal= new Calendar();
	var now = new Date();
	var startDay = now.getDate();
	var startMonth = (now.getMonth()+1);
	var startYear = now.getFullYear();
	if (startDay < 10){
		startDay = '0'+startDay;	
	}
	if (startMonth < 10){
		startMonth = '0'+startMonth;
	}
	var dbDate = startYear+'-'+startMonth+'-'+startDay;
	document.getElementById('dateOutput').innerHTML = dateFormat(now, "<p>dddd</p> <a>- dS mmmm, yyyy -</a>");
	$('#dateOutput2').val(dbDate);
	
	//Workout
	$('#journal-workout').click(function(){
		$(this).siblings().removeClass('li-active');
		$(this).addClass('li-active');
		$('.journal-wrapper').attr('id', 'journal-wrapper_workout');
		$("#LoadingImage").show();
		
		var megaDate = $('#dateOutput2').attr('value');	
			$.ajax({
			url : '/workouts/ajax_workout/'+megaDate,
			success : function( response ) {
				$('.journal-wrapper').html(response);
				window.location.hash = '';
				searchjs();
				results();
				addWorkout();
				deleteOldExercise(megaDate);
				deleteOldSet();
				addSetOld();
				workout(megaDate);
				$("#LoadingImage").hide();
				//window.location.hash = '#workouts';
				//deepLinking();
			},
			error : function ( ) {
				alert ( "Error" );
				$("#LoadingImage").hide();
			}
		});	
	})
	
	//Food
	$('#journal-food').click(function(){
		$(this).siblings().removeClass('li-active');
		$(this).addClass('li-active');
		$('.journal-wrapper').attr('id', 'journal-wrapper_food');
		$("#LoadingImage").show();
			var megaDate = $('#dateOutput2').attr('value');	
				$.ajax({
				url : '/dailydiets/ajax_dailydiet/'+megaDate,
				success : function( response ) {
					$('.journal-wrapper').html(response);
					food();
					searchFoods();
					foodResults();
					addMeal();
					deleteFoodOld();
					nutritionLoad();
					newUpdateNutrition();
					totalNutritionLoad();
					$("#LoadingImage").hide();
					//window.location.hash = '#dailydiet';
				},
				error : function ( ) {
					alert ( "Error" );
					$("#LoadingImage").hide();
				}
			});	
	})
	
	//Measure
	$('#journal-measure').click(function(){
		$(this).siblings().removeClass('li-active');
		$(this).addClass('li-active');
		$('.journal-wrapper').attr('id', 'journal-wrapper_measure');
		$("#LoadingImage").show();
		
		var megaDate = $('#dateOutput2').attr('value');
		var meals = $.getValues('/bodies/json/'+megaDate);
			if(meals[0] == 0){
				$.ajax({
					url: '/bodies/add/'+megaDate,
					success : function( response ){
						$('.journal-wrapper').html(response);
						measure();
						$("#LoadingImage").hide();
						//window.location.hash = '#addMeasure';
					},
					error : function ( ) {
						alert ( 'Error' );
						$("#LoadingImage").hide();
					}
				});
			}else{
				$.ajax({
					url: '/bodies/edit/'+meals[1]+'/'+megaDate,
					success : function( response ){
						$('.journal-wrapper').html(response);
						measure();
						$("#LoadingImage").hide();
						//window.location.hash = '#editMeasure';
					},
					error : function () {
						alert( 'Error' );
						$("#LoadingImage").hide();	
					}
				});
			}
		
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
				alert ( 'Error' );
			}
		});	
	   return result;
	}
});

	function Calendar(month, year){
		//var test = dataStore.getWorkouts();
		var workouts = $.getValues('/workouts/json_getEntry/');
		var bodies = $.getValues('/bodies/json_getEntry/');
		var meals = $.getValues('/dailydiets/json_getEntry/');
		
		//alert(results);
		
		$('a.tdata').removeClass('tdata');
		
		cal_current_date = new Date();
		
		cal_days_in_month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
		
		cal_days_labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
		
		cal_months_labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'Novemeber' , 'Decemeber'];
		
		prevMonth = cal_current_date.getMonth();
		nextMonth = cal_current_date.getMonth();
		
		prevYear = cal_current_date.getFullYear();
		nextYear = cal_current_date.getFullYear();
		
		this.month = (isNaN(month) || month == null) ? cal_current_date.getMonth() : month;
		this.year  = (isNaN(year) || year == null) ? cal_current_date.getFullYear() : year;
  		this.html = '';

	  // get first day of month
	  var firstDay = new Date(this.year, this.month, 1);
	  var startingDay = firstDay.getDay() -1;
	  if(startingDay == -1)
	  {
		startingDay = 6;  
	  }
	  var todaysDate = cal_current_date.getDate();
	  var todaysMonth = cal_current_date.getMonth();
	  var todaysYear = cal_current_date.getFullYear();
	  
	  
	  var prevYear = this.year;
	  var nextYear = this.year;
	  
	  var prevMonth = this.month -1;
	  var nextMonth = this.month +1;
	  
	  if (nextMonth == 12){
	  		nextYear = this.year +1;
			nextMonth = 0;
	  }
	  
	  if (prevMonth == -1){
			prevYear = this.year -1;
			prevMonth = 11;
 
	  }
	  
	  // find number of days in month
	  var monthLength = cal_days_in_month[this.month];
	  
	  // compensate for leap year
	  if (this.month == 1) { // February only!
		if((this.year % 4 == 0 && this.year % 100 != 0) || this.year % 400 == 0){
		  monthLength = 29;
		}
	  }
	  
	  // do the header
	  var selectedDate = new Date(this.year, this.month, 20);
	  var niceDate = todaysDate+'-'+(this.month +1)+'-'+this.year;
	  //document.getElementById('dateOutput').value = niceDate; 
	  var monthName = cal_months_labels[this.month]
	  var html = '<table class="calendar-table" border = "1">';
	  html += '<tr class = "calendar-select"><th colspan="7">';
	  html += '<a onclick="new Calendar('+prevMonth+', '+prevYear+');return false;"><p class = "left"><</p></a>  ';
	  html += monthName + "&nbsp;" + this.year;
	  html += '  <a onclick="new Calendar('+nextMonth+', '+nextYear+'); return false;"><p class = "right">></p></a>';
	  html += '</th></tr>';
	  html += '<tr class="calendar-header">';
	  for(var i = 0; i <= 6; i++ ){
		html += '<td class="calendar-header-day">';
		html += cal_days_labels[i];
		html += '</td>';
	  }
	  html += '</tr><tr>';
	
	  // fill in the days
	  var day = 1;
	  // this loop is for weeks (rows)
	  for (var i = 0; i < 6; i++) {
		// this loop is for weekdays (cells)
		for (var j = 0; j <= 6; j++) { 
			if (todaysMonth == this.month && todaysYear == this.year && day == todaysDate && i >0){
				var tdClass = 'class=current-day ';
			
		}else if(todaysMonth == this.month && todaysYear == this.year && day == todaysDate && i == 0 && j >=startingDay){
				var tdClass = 'class=current-day ';	
				
			}else if (j > 4 && day <= monthLength && (i > 0 || j >= startingDay) ){
				var tdClass = 'class=weekend-day ';
				} else if (day <= monthLength && (i > 0 || j >= startingDay) ){
						var tdClass = 'class=calendar-day';
					}else{
						var tdClass = '';	
					}	
		html += '<td '+ tdClass+' id='+day+'>';
		  if (day <= monthLength && (i > 0 || j >= startingDay)) {
			//adding leading zero to day and month if they are needed.
			var selectedDate = new Date(this.year, this.month, day);
			if (day < 10){
				day = '0'+day;	
			}
			var currentMonth = this.month +1;
			if (currentMonth < 10){
				currentMonth = '0'+currentMonth;
			}
			
			niceDate = this.year+'-'+currentMonth+'-'+day;
			//if(niceDate )
			//html += '<a class = \'tdata\' onclick="document.getElementById(\'dateOutput\').value=\''+niceDate+'\';"><p class = "tdata-p">'+day+'</p></a>';
			//html += '<a class = \'tdata\' onclick="document.getElementById(\'dateOutput\').value=\''+niceDate+'\';">';
			var now  = selectedDate;
			html += '<a class = \'tdata\' onclick="document.getElementById(\'dateOutput\').innerHTML=\''+dateFormat(now, "<p>dddd</p> <a>- dS mmmm, yyyy -</a>")+'\';">';
			//html += '<a class = \'tdata\'>';
				html += '<p id = "'+niceDate+'" class = "tdata-p">'+day+'</p>';
				
				for(ij in meals){
					if(niceDate == meals[ij]['Dailydiet']['created']){
						html += '<img src = "../img/plate.png" width = "12px" height = "12px">';
						break;	
					}
				}
				
				for(ij in bodies){
					if(niceDate == bodies[ij]['Body']['created']){
						html += '<img src = "../img/scale.png" width = "12px" height = "12px">';
						break;
					}
				}
				
				for(ij in workouts){
					if(niceDate == workouts[ij]['Workout']['created']){
						html += '<img src = "../img/weight.png" width = "12px" height = "12px">';
						break;
					}
				}
				
			html += '</a>';
			day++;
		  }
		  html += '</td>';
		}
		// stop making rows if we've run out of days
		if (day > monthLength) {
		  break;
		} else {
		  html += '</tr><tr>';
		}
	  }
	  html += '</tr></table>';

	  this.html = html;
	  document.getElementById('journal-calendar').innerHTML = this.html;
	 
	   $('a.tdata').click(function(){
		  $('a.tdata').removeClass('tdataSelected');
		  $(this).addClass('tdataSelected');
		  var megaDate2 = $(this).children('p').attr('id');
		  $('#dateOutput2').val(megaDate2);
	  });
	  
	  checkTdata(); 

}

function checkTdata(){
	$('a.tdata').click(function(){
		megaDate = $(this).children('p').attr('id');
		var temp = $('.journal-wrapper').attr('id');
		var temp2 = temp.split('_');
		var type = temp2[1];
		if(type == 'measure'){
			var meals = $.getValues('/bodies/json/'+megaDate);
			if(meals[0] == 0){
				$.ajax({
					url: '/bodies/add/'+megaDate,
					success : function( response ){
						$('.journal-wrapper').html(response);
						measure();
					},
					error : function ( ) {
						alert ( 'Error' );
					}
				});
			}else{
				$.ajax({
					url: '/bodies/edit/'+meals[1]+'/'+megaDate,
					success : function( response ){
						$('.journal-wrapper').html(response);
						measure();
					},
					error : function () {
						alert( 'Error' );	
					}
				});
			}
		}else if(type == 'workout'){
			var megaDate = $('#dateOutput2').attr('value');	
				$.ajax({
				url : '/workouts/ajax_workout/'+megaDate,
				success : function( response ) {
					$('.journal-wrapper').html(response);
					searchjs();
					results();
					addWorkout();
					deleteOldExercise(megaDate);
					deleteOldSet();
					addSetOld();
					workout();
				},
				error : function ( ) {
					alert ( "Error" );
				}
			});	
			
		}else if(type == 'food'){
			var megaDate = $('#dateOutput2').attr('value');	
				$.ajax({
				url : '/dailydiets/ajax_dailydiet/'+megaDate,
				success : function( response ) {
					$('.journal-wrapper').html(response);
					food();
					searchFoods();
					foodResults();
					addMeal();
					deleteFoodOld();
					nutritionLoad();
					newUpdateNutrition();
					totalNutritionLoad()
				},
				error : function ( ) {
					alert ( "Error" );
				}
			});	
		}
	  });
}

function measure(){
	$('.textbox').focus(function(e) {
        $(this).css('box-shadow', '0 0 5px 2px #FF0000 inset');
    });	
	
	$('.textbox').focusout(function(e) {
        $(this).css('box-shadow', '0 0 5px 2px #FFFFFF inset');
    });	
}

function searchjs(){
	$('#SearchActivites').keypress(function(){
		setTimeout(function(){
			//alert(check);
			var check = checkWorkoutSearch();
			//alert(check);
			if(check){
				var value = $('#SearchActivites').attr('value');
				$.ajax({
				url: '/workouts/ajax_search/'+value,
				success : function( response ){
					$('.workout-search-ajax').html(response);
					addWorkoutSearch();
					},
					error : function ( ) {
						alert ( 'Error' );
					}
				});	
			}
		}, 1);
	})	
}

function results(){
	$('.category-select').click(function(e) {
		$(this).siblings('a').css('color', '#747472');
        $(this).css('color', 'red');
		var temp = $(this).attr('id');
		var temp2 = temp.split('_');
		var id = temp2[1];
		$('#workout-selected').attr('value', id);
		var category = id;
		var equipment = $('#equipment-selected').attr('value');
		
		$.ajax({
			url: '/workouts/ajax_results/'+category+'/'+equipment,
			success : function( response ){
				$('.workout-results-ajax').html(response);
					addWorkoutResults();
				},
				error : function ( ) {
					alert ( 'Error' );
				}
		});	
		
    });
	
	$('.workout-equipment input').click(function(e) {
        var equipment  = $(this).attr('value');
		var category = $('#workout-selected').attr('value');
		$('#equipment-selected').attr('value', equipment);
		$.ajax({
			url: '/workouts/ajax_results/'+category+'/'+equipment,
			success : function( response ){
				$('.workout-results-ajax').html(response);
					addWorkoutResults();
				},
				error : function ( ) {
					alert ( 'Error' );
				}
		});	
    });
	
}

function addWorkout(){
	//checkWorkoutValidation()
	$('.workout-workout #time').focus(function(){
		if($(this).attr('value') == 'Time'){
			$(this).attr('value', '');
		}
	})
	$('.workout-workout #time').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Time');
		}
	})
	
	
	
	
	$('.exercise-select').click(function(e) {
		$('.exercise-select').css('color', '#747472');
        $(this).css('color', 'red');
		
		var temp = $(this).attr('id');
		var temp2 = temp.split('_');
		var id = temp2[1];
		var count = 0;;
		$('.workout-set').each(function(index) {
           	var temp10 = $(this).attr('id');
			var temp11 = temp10.split('_');
			var exid = temp11[1];
			
			if(exid == id){
				 window.location = '/workouts/index#exercise_id'+exid;
				 count = 1;
				return;	
			}
			
        });
		if(count != 1){
			var megaDate = $('#dateOutput2').attr('value');	
			$.ajax({
				url: '/workouts/ajax_addworkout/'+id+'/'+megaDate,
				success : function( response ){
					if(response.substr(0,1) =='#')
						{
						  window.location = '/workouts/index'+response;
						}else{
							var html = $('.workout-workout-ajax').html();
							html += response;
							$('.workout-workout-ajax').html(html);
								addSet();
								removeNewExercise();
								addPlaceholder();
							}
						},
					error : function ( ) {
						alert ( 'Error' );
					}
			})
		}
    })
}

function addWorkoutSearch(){
	$('.exercise-select-search').click(function(e) {
		$('.exercise-select-search').css('color', '#747472');
        $(this).css('color', 'red');
		
		var temp = $(this).attr('id');
		var temp2 = temp.split('_');
		var id = temp2[1];
		var count = 0;;
		$('.workout-set').each(function(index) {
           	var temp10 = $(this).attr('id');
			var temp11 = temp10.split('_');
			var exid = temp11[1];
			
			if(exid == id){
				 window.location = '/workouts/index#exercise_id'+exid;
				 count = 1;
				return;	
			}
			
        });
		if(count != 1){
			var megaDate = $('#dateOutput2').attr('value');	
			$.ajax({
				url: '/workouts/ajax_addworkout/'+id+'/'+megaDate,
				success : function( response ){
					if(response.substr(0,1) =='#')
						{
						  window.location = '/workouts/index'+response;
						}else{
							var html = $('.workout-workout-ajax').html();
							html += response;
							$('.workout-workout-ajax').html(html);
								addSet();
								removeNewExercise();
								addPlaceholder();
							}
						},
					error : function ( ) {
						alert ( 'Error' );
					}
			})
		}
    })
}

function addWorkoutResults(){
	$('.exercise-select-results').click(function(e) {
		$('.exercise-select-results').css('color', '#747472');
        $(this).css('color', 'red');
		
		var temp = $(this).attr('id');
		var temp2 = temp.split('_');
		var id = temp2[1];
		var count = 0;;
		$('.workout-set').each(function(index) {
           	var temp10 = $(this).attr('id');
			var temp11 = temp10.split('_');
			var exid = temp11[1];
			
			if(exid == id){
				 window.location = '/workouts/index#exercise_id'+exid;
				 count = 1;
				return;	
			}
			
        });
		if(count != 1){
			var megaDate = $('#dateOutput2').attr('value');	
			$.ajax({
				url: '/workouts/ajax_addworkout/'+id+'/'+megaDate,
				success : function( response ){
					if(response.substr(0,1) =='#')
						{
						  window.location = '/workouts/index'+response;
						}else{
							var html = $('.workout-workout-ajax').html();
							html += response;
							$('.workout-workout-ajax').html(html);
								addSet();
								removeNewExercise();
								addPlaceholder();
							}
						},
					error : function ( ) {
						alert ( 'Error' );
					}
			})
		}
    })
}

function addPlaceholder(){
	var temp = $('.user-length').attr('id');
	var temp2 = temp.split('_');
	var length = temp2[1];
	
	var temp = $('.user-mass').attr('id');
	var temp2 = temp.split('_');
	var mass = temp2[1];
	
	//$('.workout-workout .textarea').attr('value', 'Add notes...');
	$('.workout-workout .textarea').focus(function(){
		if($(this).attr('value') == 'Add notes...'){
			$(this).attr('value', '');
		}
	})
	$('.workout-workout .textarea').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Add notes...');
		}
	})
	
	
	//$('.workout-workout #time').attr('value', 'Time');
	$('.workout-workout #time').focus(function(){
		if($(this).attr('value') == 'Time'){
			$(this).attr('value', '');
		}
	})
	$('.workout-workout #time').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Time');
		}
	})
	
	if(length == 1){
		//$('.workout-workout #distance').attr('value', 'Kilometre (km)');
		$('.workout-workout #distance').focus(function(){
			if($(this).attr('value') == 'Kilometre (km)'){
				$(this).attr('value', '');
			}
		})
		$('.workout-workout #distance').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Kilometre (km)');
			}
		})	
	}else{
		//$('.workout-workout #distance').attr('value', 'Mile');
		$('.workout-workout #distance').focus(function(){
			if($(this).attr('value') == 'Mile'){
				$(this).attr('value', '');
			}
		})
		$('.workout-workout #distance').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Mile');
			}
		})	
	}
	
	if(mass == 1){
		//$('.workout-workout #value').attr('value', 'Weight (kg)');
		$('.workout-workout #value').focus(function(){
			if($(this).attr('value') == 'Weight (kg)'){
				$(this).attr('value', '');
			}
		})
		$('.workout-workout #value').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Weight (kg)');
			}
		})	
	}else{
		//$('.workout-workout #value').attr('value', 'Weight (lb)');
		$('.workout-workout #value').focus(function(){
			if($(this).attr('value') == 'Weight (lb)'){
				$(this).attr('value', '');
			}
		})
		$('.workout-workout #value').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Weight (lb)');
			}
		})	
	}
	
	//$('.workout-workout #reps').attr('value', 'Reps');
		$('.workout-workout #reps').focus(function(){
			if($(this).attr('value') == 'Reps'){
				$(this).attr('value', '');
			}
		})
		$('.workout-workout #reps').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Reps');
			}
		})	
	
	
}

function addSet(){
	$('.add-set').click(function(e) {
		var temp = $('.user-mass').attr('id');
		var temp2 = temp.split('_');
		var mass = temp2[1];
		
		var temp3 = $('.user-length').attr('id');
		var temp4 = temp3.split('_');
		var length = temp4[1];
		
		var temp7 = $(this).attr('id');
		var temp8 = temp7.split('_');
		var id = temp8[1];
		
		var temp5 = $('#workout-set_'+id+' .exercise-type').attr('id');
		var temp6 = temp5.split('_');
		var type = temp6[1];
		
		var count = ($('#add-set-js_'+id).children().length)+2;
		if (count == 2){
			
		}
		if(mass == 1){
			var placeholder = 'Weight (kg)';
		}else{
			var placeholder = 'Weight (lb)';
		}
		
		if(length == 1){
			var placeholder2 = 'Kilometre (km)';
		}else{
			var placeholder2 = 'Mile ';
		}
		
		var number = Math.floor((Math.random()*1000000)+5);
		var index = number+count+id;
		
		var html = $('#add-set-js_'+id).html();
			html += '<div class = "new-set" id = "new-set_'+index+'">';
				html += '<a id = "set-label_'+count+'" class = "left">Set '+count+'</a>';
				html += '<input type="hidden" name="data['+id+']['+index+'][Activity][id]">';
				html += '<input type="hidden" name="data['+id+']['+index+'][Activity][workout_id]">';
				if(type == 0){
					html += '<input id="reps" class="textbox" type="text" placeholder="Reps" name="data['+id+']['+index+'][Activity][reps]">';
					html += '<input id="value" class="textbox" type="text" placeholder="'+placeholder+'" name="data['+id+']['+index+'][Activity][value]">';
				}else{
					html += '<input id="time" class="textbox" type="text" placeholder="Time" name="data['+id+']['+index+'][Activity][time]">';
					html += '<input id="distance" class="textbox" type="text" placeholder="'+placeholder2+'" name="data['+id+']['+index+'][Activity][distance]">';
				}
				html += '<a class = "delete-set" id = "delete-set_'+index+'">X</a>';
			html += '</div>'
			
		$('#add-set-js_'+id).html(html); 
		number = number+1;
		
		removeNewSet(id);
		addPlaceholder();
		checkWorkoutValidation()
    });
}

function removeNewSet(oldID){
	$('.delete-set').click(function(e) {
        var temp = $(this).attr('id');
		var temp2 = temp.split('_');
		var id = temp2[1];
		$('#new-set_'+id).remove();
		$('#add-set-js_'+oldID).children().children('.left').each(function(index) {
			$(this).html('Set '+(index+2));
        });
    });
}

function removeNewExercise(){
	$('.delete-exercise').click(function(e) {
        var temp = $(this).attr('id');
		var temp2 = temp.split('_');
		var id = temp2[1];
		$('#workout-set_'+id).remove();
    });
}

function deleteOldExercise(date){
	$('.delete-exercise-old').click(function(e) {
        var temp = $(this).attr('id');
		var temp2 = temp.split('_');
		var id = temp2[1];
		$('#workout-set_'+id).remove();
		$.ajax({
			url: '/workouts/ajax_deleteOldExercise/'+date+'/'+id,
			success : function( response ){
			},
			error : function ( ) {
				alert ( 'Error' );
			}
		})
    });
}

function deleteOldSet(){
	$('.delete-set-old').click(function(e) {
        var temp = $(this).attr('id');
		var temp2 = temp.split('_');
		var id = temp2[1];
		
		var temp3 = $('#old-set_'+id).parent('.workout-set').attr('id');
		var temp4 = temp3.split('_');
		var exercise_id = temp4[1];
		
		$('#old-set_'+id).remove();
		var count = 0;
		$('#workout-set_'+exercise_id+' .old-set').children('.left').each(function(index) {
			$(this).html('Set '+(index+1));
			count = count + 1;
        });
		
		$('#add-set-js-old_'+exercise_id+' .new-set').children('.left').each(function(index) {
			$(this).html('Set '+(index+count+1));
        });
		
		$.ajax({
			url: '/workouts/ajax_deleteOldSet/'+id,
			success : function( response ){
			},
			error : function ( ) {
				alert ( 'Error' );
			}
		})
    });
	
}

function addSetOld(){
	$('.add-set-old').click(function(e) {
		var temp = $('.user-mass').attr('id');
		var temp2 = temp.split('_');
		var mass = temp2[1];
		
		var temp3 = $('.user-length').attr('id');
		var temp4 = temp3.split('_');
		var length = temp4[1];
		
		var temp7 = $(this).attr('id');
		var temp8 = temp7.split('_');
		var id = temp8[1];
		
		var temp5 = $('#workout-set_'+id+' .exercise-type').attr('id');
		var temp6 = temp5.split('_');
		var type = temp6[1];
		
		var temp7 = $('#workout-set_'+id+' .exercise-type').attr('id');
		var temp8 = temp7.split('_');
		var type = temp8[1];
		
		var count =  $('#workout-set_'+id+' .old-set').length;
			count = count + ($('#add-set-js-old_'+id).children().length)+1;
			
		if(mass == 1){
			var placeholder = 'Weight (kg)';
		}else{
			var placeholder = 'Weight (lb)';
		}
		
		if(length == 1){
			var placeholder2 = 'Kilometre (km)';
		}else{
			var placeholder2 = 'Mile ';
		}
		
		var number = Math.floor((Math.random()*1000000)+5);
		var index = number+count+id;
		
		var html = $('#add-set-js-old_'+id).html();
			html += '<div class = "new-set" id = "new-set_'+index+'">';
				html += '<a id = "set-label_'+count+'" class = "left">Set '+count+'</a>';
				html += '<input type="hidden" name="data['+id+']['+index+'][Activity][id]">';
				html += '<input type="hidden" name="data['+id+']['+index+'][Activity][workout_id]">';
				if(type == 0){
					html += '<input id="reps" class="textbox" type="text" placeholder="Reps" name="data['+id+']['+index+'][Activity][reps]">';
					html += '<input id="value" class="textbox" type="text" placeholder="'+placeholder+'" name="data['+id+']['+index+'][Activity][value]">';
				}else{
					html += '<input id="time" class="textbox" type="text" placeholder="Time" name="data['+id+']['+index+'][Activity][time]">';
					html += '<input id="distance" class="textbox" type="text" placeholder="'+placeholder2+'" name="data['+id+']['+index+'][Activity][distance]">';
				}
				html += '<a class = "delete-set" id = "delete-set_'+index+'">X</a>';
			html += '</div>'
			
		$('#add-set-js-old_'+id).html(html); 
		number = number+1;
		
		removeNewSetUpdate(id);
		checkWorkoutValidation()
    });
}

function removeNewSetUpdate(oldID){
	$('.delete-set').click(function(e) {
        var temp = $(this).attr('id');
		var temp2 = temp.split('_');
		var id = temp2[1];
		$('#new-set_'+id).remove();
		var count = $('#workout-set_'+oldID+' .old-set').length+1;
		$('#add-set-js-old_'+oldID).children().children('.left').each(function(index) {
			$(this).html('Set '+(index+count));
        });
    });
}

function workout(megaDate){
	//alert(megaDate);
	$('.workout-search .textbox').attr('value', 'Search for activities by name...');
	$('.workout-search .textbox').focus(function(){
		if($(this).attr('value') == 'Search for activities by name...'){
			$(this).attr('value', '');
		}
	})
	$('.workout-search .textbox').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Search for activities by name...');
		}
	})
	
	$('.workout-add img').click(function(e) {
		if($('.workout-frequent').css('display') == 'block'){
			$(this).attr("src","../../webroot/img/addworkout.png");

			$('.workout-frequent').css('display', 'none');
			$('.workout-search').css('display', 'none');
			$('.workout-manual').css('display', 'none');
		}else{
			$(this).attr("src","../../webroot/img/cancel.png");
			$('.workout-frequent').css('display', 'block');
			$('.workout-search').css('display', 'block');
			$('.workout-manual').css('display', 'block');
		}
    });	
	
	deepLinking();
	checkWorkoutValidation()
}

function food(){
	if($('.nutrition-total .textarea').attr('value') == ''){
		$('.nutrition-total .textarea').attr('value', 'Add notes...');
	}
	$('.nutrition-total .textarea').focus(function(){
		if($(this).attr('value') == 'Add notes...'){
			$(this).attr('value', '');
		}
	})
	$('.nutrition-total .textarea').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Add notes...');
		}
	})
	
	
	$('.dailydiet-search .textbox').attr('value', 'Search Foods by name...');
	$('.dailydiet-search .textbox').focus(function(){
		if($(this).attr('value') == 'Search Foods by name...'){
			$(this).attr('value', '');
		}
	})
	$('.dailydiet-search .textbox').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Search Foods by name...');
		}
	})
	
	$('.dailydiet-add img').click(function(e) {
		if($('.dailydiet-frequent').css('display') == 'block'){
			$(this).attr("src","../../webroot/img/add-food.png");

			$('.dailydiet-frequent').css('display', 'none');
			$('.dailydiet-search').css('display', 'none');
			$('.dailydiet-manual').css('display', 'none');
		}else{
			$(this).attr("src","../../webroot/img/cancel.png");
			$('.dailydiet-frequent').css('display', 'block');
			$('.dailydiet-search').css('display', 'block');
			$('.dailydiet-manual').css('display', 'block');
		}
    });
	checkFoodValidation()
}

function searchFoods(){
	$('#SearchFoods').keypress(function(){
		setTimeout(function(){
			var check = checkFoodSearch();
			if(check){
				var value = $('#SearchFoods').attr('value');
				$.ajax({
				url: '/dailydiets/ajax_search/'+value,
				success : function( response ){
					$('.dailydiet-search-ajax').html(response);
						addMealSearch();
					},
					error : function ( ) {
						alert ( 'Error' );
					}
				});
			}
		}, 1);
	})	
}

function foodResults(){
	$('.category-select').click(function(e) {
		$(this).siblings('a').css('color', '#747472');
        $(this).css('color', 'red');
		var temp = $(this).attr('id');
		var temp2 = temp.split('_');
		var id = temp2[1];
		$('#food-selected').attr('value', id);
		var category = id;
		var subcategory = 99;
		
		$('.radio input').remove();
		$('.radio label').remove();
		
		var html = '';
		if(category == 0){
			html += '<input id="Subcategory-select0" type="radio" value="0" name="data[subcategory]">';
			html += '<label for="Subcategory-select0">Meat with Starch</label>';
			html += '<input id="Subcategory-select1" type="radio" value="1" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select1">Frozen Meals</label>';
			html +=	'<input id="Subcategory-select2" type="radio" value="2" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Gravies from Meat</label>';
			html +=	'<input id="Subcategory-select3" type="radio" value="3" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select3">Organ Meats</label>';
			html +=	'<input id="Subcategory-select4" type="radio" value="4" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select4">Other Meat</label>';
			html +=	'<input id="Subcategory-select5" type="radio" value="5" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select5">Sausages</label>';
			html +=	'<input id="Subcategory-select6" type="radio" value="6" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select6">Meat with Vegetables</label>';
			html +=	'<input id="Subcategory-select7" type="radio" value="7" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select7">Lunchmeats, Frankfurters</label>';
			html +=	'<input id="Subcategory-select8" type="radio" value="8" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select8">Beef </label>';
			html +=	'<input id="Subcategory-select9" type="radio" value="9" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select9">Meat Sandwiches</label>';
			html +=	'<input id="Subcategory-select10" type="radio" value="10" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select10">Pork</label>';
			html +=	'<input id="Subcategory-select99" type="radio" checked="checked" value="99" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select99">All</label>';
			
		}else if (category == 1){
			
			html += '<input id="Subcategory-select0" type="radio" value="11" name="data[subcategory]">';
			html += '<label for="Subcategory-select0">Other poultry</label>';
			
			html += '<input id="Subcategory-select1" type="radio" value="12" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select1">Frozen meals</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="13" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Poultry in Gravy or Sauce</label>';
			
			html +=	'<input id="Subcategory-select3" type="radio" value="14" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select3">Organ Meats and mixutres</label>';
			
			html +=	'<input id="Subcategory-select4" type="radio" value="15" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select4">Duck</label>';
			
			html +=	'<input id="Subcategory-select5" type="radio" value="16" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select5">Chicken</label>';
			
			html +=	'<input id="Subcategory-select6" type="radio" value="17" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select6">Turkey</label>';
			
			html +=	'<input id="Subcategory-select99" type="radio" checked="checked" value="99" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select99">All</label>';
			
		}else if (category == 2){
			
			html += '<input id="Subcategory-select0" type="radio" value="18" name="data[subcategory]">';
			html += '<label for="Subcategory-select0">Flavoured milk and milk drinks</label>';
			
			html += '<input id="Subcategory-select1" type="radio" value="19" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select1">Milk meal replacements</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="20" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Ice cream and milk desserts</label>';
			
			html +=	'<input id="Subcategory-select3" type="radio" value="21" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select3">Creams</label>';
			
			html +=	'<input id="Subcategory-select4" type="radio" value="22" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select4">Milk</label>';
			
			html +=	'<input id="Subcategory-select5" type="radio" value="23" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select5">Cheeses</label>';
			
			html +=	'<input id="Subcategory-select6" type="radio" value="24" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select6">Eggs</label>';
			
			html +=	'<input id="Subcategory-select6" type="radio" value="25" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select6">Yogurt</label>';
			
			html +=	'<input id="Subcategory-select99" type="radio" checked="checked" value="99" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select99">All</label>';
			
		}else if (category == 3){
			
			html += '<input id="Subcategory-select0" type="radio" value="26" name="data[subcategory]">';
			html += '<label for="Subcategory-select0">Fish with Starch</label>';
			
			html += '<input id="Subcategory-select1" type="radio" value="27" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select1">Frozen Meals</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="28" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Finfish</label>';
			
			html +=	'<input id="Subcategory-select3" type="radio" value="29" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select3">Shellfish</label>';
			
			html +=	'<input id="Subcategory-select99" type="radio" checked="checked" value="99" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select99">All</label>';
			
		}else if (category == 4){
			
			html += '<input id="Subcategory-select0" type="radio" value="30" name="data[subcategory]">';
			html += '<label for="Subcategory-select0">Dried Beans, Mixtures</label>';
			
			html += '<input id="Subcategory-select1" type="radio" value="31" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select1">Carob Products</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="32" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Seeds</label>';
			
			html +=	'<input id="Subcategory-select3" type="radio" value="33" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select3">Soybean Products</label>';
			
			html +=	'<input id="Subcategory-select4" type="radio" value="34" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select4">Meat Substitutes</label>';
			
			html +=	'<input id="Subcategory-select5" type="radio" value="35" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select5">Nuts, butters, mixtures</label>';
			
			html +=	'<input id="Subcategory-select6" type="radio" value="36" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select6">Peas, Lentil mixture</label>';
			
			html +=	'<input id="Subcategory-select99" type="radio" checked="checked" value="99" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select99">All</label>';
			
		}else if (category == 5){
			
			html += '<input id="Subcategory-select0" type="radio" value="37" name="data[subcategory]">';
			html += '<label for="Subcategory-select0">Salad Dressings</label>';
			
			html += '<input id="Subcategory-select1" type="radio" value="38" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select1">Fats</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="39" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Oils</label>';
			
			html +=	'<input id="Subcategory-select99" type="radio" checked="checked" value="99" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select99">All</label>';
			
		}else if (category == 6){
			
			html += '<input id="Subcategory-select0" type="radio" value="40" name="data[subcategory]">';
			html += '<label for="Subcategory-select0">Cakes</label>';
			
			html += '<input id="Subcategory-select1" type="radio" value="41" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select1">Wheat Breads, Rolls</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="42" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Cookies</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="43" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Quick Breads</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="44" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Crackers, salty snacks</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="45" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Pancakes and waffles</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="46" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">White breads, rolls</label>';
			
			html +=	'<input id="Subcategory-select99" type="radio" checked="checked" value="99" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select99">All</label>';
			
		}else if (category == 7){
			
			html += '<input id="Subcategory-select0" type="radio" value="47" name="data[subcategory]">';
			html += '<label for="Subcategory-select0">Flower</label>';
			
			html += '<input id="Subcategory-select1" type="radio" value="48" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select1">Frozen Meals</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="49" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Soups</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="50" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Crackers</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="51" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Breakfast Cereals</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="52" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Pasta</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="53" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Rice</label>';
			
			html +=	'<input id="Subcategory-select99" type="radio" checked="checked" value="99" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select99">All</label>';
			
		}else if (category == 8){
			
			html += '<input id="Subcategory-select0" type="radio" value="54" name="data[subcategory]">';
			html += '<label for="Subcategory-select0">Fruit Mixtures</label>';
			
			html += '<input id="Subcategory-select1" type="radio" value="55" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select1">Non-Citrus fruit juices</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="56" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Dried fruits</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="57" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Berries</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="58" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Fruits</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="59" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Citrus fruits and juices</label>';
			
			html +=	'<input id="Subcategory-select99" type="radio" checked="checked" value="99" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select99">All</label>';
			
		}else if (category == 9){
			
			html += '<input id="Subcategory-select0" type="radio" value="60" name="data[subcategory]">';
			html += '<label for="Subcategory-select0">Dark Leafy Vegetables</label>';
			
			html += '<input id="Subcategory-select1" type="radio" value="61" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select1">Other Vegetables</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="62" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Vegetable soups</label>';
			
			html +=	'<input id="Subcategory-select99" type="radio" checked="checked" value="99" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select99">All</label>';
			
		}else if (category == 10){
			
			html += '<input id="Subcategory-select0" type="radio" value="63" name="data[subcategory]">';
			html += '<label for="Subcategory-select0">Fruitades and drinks</label>';
			
			html += '<input id="Subcategory-select1" type="radio" value="64" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select1">Alcoholic beverages</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="65" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Tea</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="66" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Coffee</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="67" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Soft drinks</label>';
			
			html +=	'<input id="Subcategory-select99" type="radio" checked="checked" value="99" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select99">All</label>';
			
		}else if (category == 11){
			
			html += '<input id="Subcategory-select0" type="radio" value="68" name="data[subcategory]">';
			html += '<label for="Subcategory-select0">Cobblers, Eclairs, etc</label>';
			
			html += '<input id="Subcategory-select1" type="radio" value="69" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select1">Doughnuts, Danishes, etc</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="70" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Cakes</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="71" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Cookies</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="72" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Pies</label>';
			
			html +=	'<input id="Subcategory-select99" type="radio" checked="checked" value="99" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select99">All</label>';
			
		}else if (category == 12){
			
			html += '<input id="Subcategory-select0" type="radio" value="73" name="data[subcategory]">';
			html += '<label for="Subcategory-select0">Gelatin Deserts or salads</label>';
			
			html += '<input id="Subcategory-select1" type="radio" value="74" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select1">Sugar an sugar substitutes</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="75" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Popsicles</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="76" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Candies and gum</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="77" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Jellies, Jams</label>';
			
			html +=	'<input id="Subcategory-select2" type="radio" value="78" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select2">Syrups, Honey, ect</label>';
			
			html +=	'<input id="Subcategory-select99" type="radio" checked="checked" value="99" name="data[subcategory]">';
			html +=	'<label for="Subcategory-select99">All</label>';
			
		}
		
		
		$('.radio').html(html);
		
		
		
		$.ajax({
			url: '/dailydiets/ajax_results/'+category+'/'+subcategory,
			success : function( response ){
				$('.dailydiet-results-ajax').html(response);
					newFoodResults();
					addMealResults();
					
				},
				error : function ( ) {
					alert ( 'Error' );
				}
		});	
		
    });
	
	$('.dailydiet-subcategory input').click(function(e) {
        var subcategory  = $(this).attr('value');
		var category = $('#food-selected').attr('value');
		$('#subcategory-selected').attr('value', subcategory);
		$.ajax({
			url: '/dailydiets/ajax_results/'+category+'/'+subcategory,
			success : function( response ){
				$('.dailydiet-results-ajax').html(response);
					newFoodResults();
				},
				error : function ( ) {
					alert ( 'Error' );
				}
		});	
    });
}

function newFoodResults(){
	$('.dailydiet-subcategory input').click(function(e) {
        var subcategory  = $(this).attr('value');
		var category = $('#food-selected').attr('value');
		$('#subcategory-selected').attr('value', subcategory);
		$.ajax({
			url: '/dailydiets/ajax_results/'+category+'/'+subcategory,
			success : function( response ){
				$('.dailydiet-results-ajax').html(response);
					addMealResults();
				},
				error : function ( ) {
					alert ( 'Error' );
				}
		});	
    });	
}

function addMeal(){
	$('.food-select').click(function(e) {
		$('.food-select').css('color', '#747472');
        $(this).css('color', 'red');
		
		var temp = $(this).attr('id');
		var temp2 = temp.split('_');
		var id = temp2[1];
		var megaDate = $('#dateOutput2').attr('value');	
		$.ajax({
			url: '/dailydiets/ajax_addmeal/'+id+'/'+megaDate,
			dataType:'json',
			success : function( response ){
				var html = $('.dailydiet-dailydiet-ajax').html();
				html += '<div class = "meal-set" id = "meal-set_'+response['foodentryID']+'">';
					html += '<input type="hidden" name="data['+response['foodentryID']+'][Foodentry][food_id]" id = "food_id" value = "'+response['food']['Food']['id']+'">';
					html += '<input type="hidden" name="data['+response['foodentryID']+'][Foodentry][id]" id = "id_'+response['foodentryID']+'" value = "'+response['foodentryID']+'">';
					html += '<input type="hidden" id = "food-type_'+response['foodentryID']+'" 		value = "'+response['food']['Food']['type']+'">';
					html += '<input type="hidden" id = "food-protein_'+response['foodentryID']+'" 	value = "'+response['food']['Food']['protein']+'">';
					html += '<input type="hidden" id = "food-carbs_'+response['foodentryID']+'"	 	value = "'+response['food']['Food']['carbs']+'">';
					html += '<input type="hidden" id = "food-fat_'+response['foodentryID']+'" 		value = "'+response['food']['Food']['fat']+'">';
					html += '<input type="hidden" id = "food-fibre_'+response['foodentryID']+'" 	value = "'+response['food']['Food']['fibre']+'">';
					html += '<input type="hidden" id = "food-calories_'+response['foodentryID']+'" 	value = "'+response['food']['Food']['calories']+'">';
					html += '<input type="hidden" id = "food-value_'+response['foodentryID']+'" 	value = "'+response['food']['Food']['default_value']+'">';
					
					html += '<p>'+response['food']['Food']['name']+'</p><a onclick="return confirm(\'are you sure?\')" class = "delete-food" id = "delete-food_'+response['foodentryID']+'">Delete Exercise</a>';
					html += '<p class = "meal-default">Default - '+response['food']['Food']['default_label']+'</p>';
					
					var temp15 = $('.user-mass').attr('id');
					var temp16 = temp15.split('_');
					var mass = temp16[1];
					
					var temp17 = $('.user-volume').attr('id');
					var temp18 = temp17.split('_');
					var volume = temp18[1];
					
					if(response['food']['Food']['type'] == 0){
						if(mass == 1){
							var placeholder = 'grams ';
							var value = Math.round(response['food']['Food']['default_value'] * 10) / 10;
						}else{
							var placeholder = 'ounze ';
							var value = Math.round((response['food']['Food']['default_value'] * 0.0353) * 10) / 10;
						}
					}else{
						if(volume == 1){
							var placeholder = 'litre ';
							var value = Math.round(response['food']['Food']['default_value'] * 10) / 10;
						}else{
							var placeholder = 'pint ';
							var value = Math.round((response['food']['Food']['default_value'] * 1.76) * 10) / 10;
						}
					}
					html += '<div class = "input text">'
						html += '<label>'+placeholder+'</label>'
						html += '<input name="data['+response['foodentryID']+'][Foodentry][quantity]" class = "textbox" id = "quantity_'+response['foodentryID']+'" placeholder = "quantity..." value = "'+value+'">';
					html += '</div>';
					html += '<p class = "nutrition-info">Protein: <a id = "protein-value_'+response['foodentryID']+'"></a></p>';
					html += '<p class = "nutrition-info">Carbohydrates: <a id = "carbohydrates-value_'+response['foodentryID']+'"></a></p>';
					html += '<p class = "nutrition-info">Fat: <a id = "fat-value_'+response['foodentryID']+'"></a></p>';
					html += '<p class = "nutrition-info">Fibre: <a id = "fibre-value_'+response['foodentryID']+'"></a></p>';
					html += '<p class = "nutrition-info">Calories: <a id = "calories-value_'+response['foodentryID']+'"></a></p>';
				html += '</div>';
				
				$('.dailydiet-dailydiet-ajax').html(html);
				placeHolder();
				makeNewNutrition(response['foodentryID']);
				deleteNewMeal(response['foodentryID']);
				newUpdateNutrition(response['foodentryID']);
					
			},
				error : function ( ) {
					alert ( 'Error' );
				}
		})
		checkFoodValidation()
    })
}

function placeHolder(){
	$('.meal-set .textbox').focus(function(){
		if($(this).attr('value') == 'quantity...'){
			$(this).attr('value', '');
		}
	})
	$('.meal-set .textbox').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'quantity...');
		}
	})	
}


function makeNewNutrition(foodentryID){
		var id = foodentryID;
		
		//var type = $('#food-type_'+id).attr('value');
		var default_value = $('#food-value_'+id).attr('value');
		
		var protein = $('#food-protein_'+id).attr('value');
		var carbs = $('#food-carbs_'+id).attr('value');
		var fat = $('#food-fat_'+id).attr('value');
		var fibre = $('#food-fibre_'+id).attr('value');
		var calories = $('#food-calories_'+id).attr('value');
		
		var value = Math.round((protein * default_value)*10) /10;
		$('#protein-value_'+id).html(value);
		$('#protein-value_'+id).attr('value', value);
		value = Math.round((carbs * default_value)*10) /10;
		$('#carbohydrates-value_'+id).html(value);
		$('#carbohydrates-value_'+id).attr('value', value);
		value = Math.round((fat * default_value)*10) /10;
		$('#fat-value_'+id).html(value);
		$('#fat-value_'+id).attr('value', value);
		value =Math.round((fibre * default_value)*10) /10;
		$('#fibre-value_'+id).html(value);
		$('#fibre-value_'+id).attr('value', value);
		value = Math.round((calories * default_value)*10) /10;
		$('#calories-value_'+id).html(value);
		$('#calories-value_'+id).attr('value', value);
		
		totalNutritionLoad()
}

function deleteNewMeal(foodentryID){
	$('.delete-food').click(function(e) {
		var temp = $(this).attr('id');
		var temp2 = temp.split('_');
		var id = temp2[1];
		$('#meal-set_'+id).remove();
		totalNutritionLoad()
    });
}

function newUpdateNutrition(){
	var temp = $('.user-mass').attr('id');
	var temp2 = temp.split('_');
	var mass = temp2[1];
	
	var temp3 = $('.user-volume').attr('id');
	var temp4 = temp3.split('_');
	var volume = temp4[1];
	
	$('.input .textbox').change(function(e) {
		var temp5 = $(this).attr('id');
		var temp6 = temp5.split('_');
		var id = temp6[1];
		var type = $('#food-type_'+id).attr('value');
		default_value = $(this).attr('value');
		
		var protein = $('#food-protein_'+id).attr('value');
		var carbs = $('#food-carbs_'+id).attr('value');
		var fat = $('#food-fat_'+id).attr('value');
		var fibre = $('#food-fibre_'+id).attr('value');
		var calories = $('#food-calories_'+id).attr('value');
		
		if(type == 0){
			if(mass == 1){
				var value = Math.round((protein * default_value)*10) /10;
				$('#protein-value_'+id).html(value);
				$('#protein-value_'+id).attr('value', value);
				value = Math.round((carbs * default_value)*10) /10;
				$('#carbohydrates-value_'+id).html(value);
				$('#carbohydrates-value_'+id).attr('value', value);
				value = Math.round((fat * default_value)*10) /10;
				$('#fat-value_'+id).html(value);
				$('#fat-value_'+id).attr('value', value);
				value =Math.round((fibre * default_value)*10) /10;
				$('#fibre-value_'+id).html(value);
				$('#fibre-value_'+id).attr('value', value);
				value = Math.round((calories * default_value)*10) /10;
				$('#calories-value_'+id).html(value);
				$('#calories-value_'+id).attr('value', value);
			}else{
				var value = Math.round((protein * (default_value * 28.35))*10) /10;
				$('#protein-value_'+id).html(value);
				$('#protein-value_'+id).attr('value', value);
				value = Math.round((carbs * (default_value * 28.35))*10) /10;
				$('#carbohydrates-value_'+id).html(value);
				$('#carbohydrates-value_'+id).attr('value', value);
				value = Math.round((fat * (default_value * 28.35))*10) /10;
				$('#fat-value_'+id).html(value);
				$('#fat-value_'+id).attr('value', value);
				value =Math.round((fibre * (default_value * 28.35))*10) /10;
				$('#fibre-value_'+id).html(value);
				$('#fibre-value_'+id).attr('value', value);
				value = Math.round((calories * (default_value * 28.35))*10) /10;
				$('#calories-value_'+id).html(value);
				$('#calories-value_'+id).attr('value', value);
			}
		}else{
			if(volume ==1){
				var value = Math.round((protein * default_value)*10) /10;
				$('#protein-value_'+id).html(value);
				$('#protein-value_'+id).attr('value', value);
				value = Math.round((carbs * default_value)*10) /10;
				$('#carbohydrates-value_'+id).html(value);
				$('#carbohydrates-value_'+id).attr('value', value);
				value = Math.round((fat * default_value)*10) /10;
				$('#fat-value_'+id).html(value);
				$('#fat-value_'+id).attr('value', value);
				value =Math.round((fibre * default_value)*10) /10;
				$('#fibre-value_'+id).html(value);
				$('#fibre-value_'+id).attr('value', value);
				value = Math.round((calories * default_value)*10) /10;
				$('#calories-value_'+id).html(value);
				$('#calories-value_'+id).attr('value', value);
			}else{
				var value = Math.round((protein * (default_value * 0.5683))*10) /10;
				$('#protein-value_'+id).html(value);
				$('#protein-value_'+id).attr('value', value);
				value = Math.round((carbs * (default_value * 0.5683))*10) /10;
				$('#carbohydrates-value_'+id).html(value);
				$('#carbohydrates-value_'+id).attr('value', value);
				value = Math.round((fat * (default_value * 0.5683))*10) /10;
				$('#fat-value_'+id).html(value);
				$('#fat-value_'+id).attr('value', value);
				value =Math.round((fibre * (default_value * 0.5683))*10) /10;
				$('#fibre-value_'+id).html(value);
				$('#fibre-value_'+id).attr('value', value);
				value = Math.round((calories * (default_value * 0.5683))*10) /10;
				$('#calories-value_'+id).html(value);
				$('#calories-value_'+id).attr('value', value);
			}
		}
		totalNutritionLoad();
    }).trigger('change');
}

function addMealSearch(){
	$('.food-select-search').click(function(e) {
		$('.food-select-search').css('color', '#747472');
        $(this).css('color', 'red');
		
		var temp = $(this).attr('id');
		var temp2 = temp.split('_');
		var id = temp2[1];
		var megaDate = $('#dateOutput2').attr('value');	
		$.ajax({
			url: '/dailydiets/ajax_addmeal/'+id+'/'+megaDate,
			dataType:'json',
			success : function( response ){
				var html = $('.dailydiet-dailydiet-ajax').html();
				html += '<div class = "meal-set" id = "meal-set_'+response['foodentryID']+'">';
					html += '<input type="hidden" name="data['+response['foodentryID']+'][Foodentry][food_id]" id = "food_id" value = "'+response['food']['Food']['id']+'">';
					html += '<input type="hidden" name="data['+response['foodentryID']+'][Foodentry][id]" id = "id_'+response['foodentryID']+'" value = "'+response['foodentryID']+'">';
					html += '<input type="hidden" id = "food-type_'+response['foodentryID']+'" 		value = "'+response['food']['Food']['type']+'">';
					html += '<input type="hidden" id = "food-protein_'+response['foodentryID']+'" 	value = "'+response['food']['Food']['protein']+'">';
					html += '<input type="hidden" id = "food-carbs_'+response['foodentryID']+'"	 	value = "'+response['food']['Food']['carbs']+'">';
					html += '<input type="hidden" id = "food-fat_'+response['foodentryID']+'" 		value = "'+response['food']['Food']['fat']+'">';
					html += '<input type="hidden" id = "food-fibre_'+response['foodentryID']+'" 	value = "'+response['food']['Food']['fibre']+'">';
					html += '<input type="hidden" id = "food-calories_'+response['foodentryID']+'" 	value = "'+response['food']['Food']['calories']+'">';
					html += '<input type="hidden" id = "food-value_'+response['foodentryID']+'" 	value = "'+response['food']['Food']['default_value']+'">';
					
					html += '<p>'+response['food']['Food']['name']+'</p><a onclick="return confirm(\'are you sure?\')" class = "delete-food" id = "delete-food_'+response['foodentryID']+'">Delete Exercise</a>';
					html += '<p class = "meal-default">Default - '+response['food']['Food']['default_label']+'</p>';
					
					var temp15 = $('.user-mass').attr('id');
					var temp16 = temp15.split('_');
					var mass = temp16[1];
					
					var temp17 = $('.user-volume').attr('id');
					var temp18 = temp17.split('_');
					var volume = temp18[1];
					
					if(response['food']['Food']['type'] == 0){
						if(mass == 1){
							var placeholder = 'grams ';
							var value = Math.round(response['food']['Food']['default_value'] * 10) / 10;
						}else{
							var placeholder = 'ounze ';
							var value = Math.round((response['food']['Food']['default_value'] * 0.0353) * 10) / 10;
						}
					}else{
						if(volume == 1){
							var placeholder = 'litre ';
							var value = Math.round(response['food']['Food']['default_value'] * 10) / 10;
						}else{
							var placeholder = 'pint ';
							var value = Math.round((response['food']['Food']['default_value'] * 1.76) * 10) / 10;
						}
					}
					html += '<div class = "input text">'
						html += '<label>'+placeholder+'</label>'
						html += '<input name="data['+response['foodentryID']+'][Foodentry][quantity]" class = "textbox" id = "quantity_'+response['foodentryID']+'" placeholder = "quantity..." value = "'+value+'">';
					html += '</div>';
					html += '<p class = "nutrition-info">Protein: <a id = "protein-value_'+response['foodentryID']+'"></a></p>';
					html += '<p class = "nutrition-info">Carbohydrates: <a id = "carbohydrates-value_'+response['foodentryID']+'"></a></p>';
					html += '<p class = "nutrition-info">Fat: <a id = "fat-value_'+response['foodentryID']+'"></a></p>';
					html += '<p class = "nutrition-info">Fibre: <a id = "fibre-value_'+response['foodentryID']+'"></a></p>';
					html += '<p class = "nutrition-info">Calories: <a id = "calories-value_'+response['foodentryID']+'"></a></p>';
				html += '</div>';
				
				$('.dailydiet-dailydiet-ajax').html(html);
				placeHolder();
				makeNewNutrition(response['foodentryID']);
				deleteNewMeal(response['foodentryID']);
				newUpdateNutrition(response['foodentryID']);
					
			},
				error : function ( ) {
					alert ( 'Error' );
				}
		})
    })
}

function addMealResults(){
	$('.food-select-results').click(function(e) {
		$('.food-select-results').css('color', '#747472');
        $(this).css('color', 'red');
		
		var temp = $(this).attr('id');
		var temp2 = temp.split('_');
		var id = temp2[1];
		var megaDate = $('#dateOutput2').attr('value');	
		$.ajax({
			url: '/dailydiets/ajax_addmeal/'+id+'/'+megaDate,
			dataType:'json',
			success : function( response ){
				var html = $('.dailydiet-dailydiet-ajax').html();
				html += '<div class = "meal-set" id = "meal-set_'+response['foodentryID']+'">';
					html += '<input type="hidden" name="data['+response['foodentryID']+'][Foodentry][food_id]" id = "food_id_'+response['foodentryID']+'" value = "'+response['food']['Food']['id']+'">';
					html += '<input type="hidden" name="data['+response['foodentryID']+'][Foodentry][id]" id = "id_'+response['foodentryID']+'" value = "'+response['foodentryID']+'">';
					html += '<input type="hidden" id = "food-type_'+response['foodentryID']+'" 		value = "'+response['food']['Food']['type']+'">';
					html += '<input type="hidden" id = "food-protein_'+response['foodentryID']+'" 	value = "'+response['food']['Food']['protein']+'">';
					html += '<input type="hidden" id = "food-carbs_'+response['foodentryID']+'"	 	value = "'+response['food']['Food']['carbs']+'">';
					html += '<input type="hidden" id = "food-fat_'+response['foodentryID']+'" 		value = "'+response['food']['Food']['fat']+'">';
					html += '<input type="hidden" id = "food-fibre_'+response['foodentryID']+'" 	value = "'+response['food']['Food']['fibre']+'">';
					html += '<input type="hidden" id = "food-calories_'+response['foodentryID']+'" 	value = "'+response['food']['Food']['calories']+'">';
					html += '<input type="hidden" id = "food-value_'+response['foodentryID']+'" 	value = "'+response['food']['Food']['default_value']+'">';
					
					html += '<p>'+response['food']['Food']['name']+'</p><a onclick="return confirm(\'are you sure?\')" class = "delete-food" id = "delete-food_'+response['foodentryID']+'">Delete Exercise</a>';
					html += '<p class = "meal-default">Default - '+response['food']['Food']['default_label']+'</p>';
					
					var temp15 = $('.user-mass').attr('id');
					var temp16 = temp15.split('_');
					var mass = temp16[1];
					
					var temp17 = $('.user-volume').attr('id');
					var temp18 = temp17.split('_');
					var volume = temp18[1];
					
					if(response['food']['Food']['type'] == 0){
						if(mass == 1){
							var placeholder = 'grams ';
							var value = Math.round(response['food']['Food']['default_value'] * 10) / 10;
						}else{
							var placeholder = 'ounze ';
							var value = Math.round((response['food']['Food']['default_value'] * 0.0353) * 10) / 10;
						}
					}else{
						if(volume == 1){
							var placeholder = 'litre ';
							var value = Math.round(response['food']['Food']['default_value'] * 10) / 10;
						}else{
							var placeholder = 'pint ';
							var value = Math.round((response['food']['Food']['default_value'] * 1.76) * 10) / 10;
						}
					}
					html += '<div class = "input text">'
						html += '<label>'+placeholder+'</label>'
						html += '<input name="data['+response['foodentryID']+'][Foodentry][quantity]" class = "textbox" id = "quantity_'+response['foodentryID']+'" placeholder = "quantity..." value = "'+value+'">';
					html += '</div>';
					html += '<p class = "nutrition-info">Protein: <a id = "protein-value_'+response['foodentryID']+'"></a></p>';
					html += '<p class = "nutrition-info">Carbohydrates: <a id = "carbohydrates-value_'+response['foodentryID']+'"></a></p>';
					html += '<p class = "nutrition-info">Fat: <a id = "fat-value_'+response['foodentryID']+'"></a></p>';
					html += '<p class = "nutrition-info">Fibre: <a id = "fibre-value_'+response['foodentryID']+'"></a></p>';
					html += '<p class = "nutrition-info">Calories: <a id = "calories-value_'+response['foodentryID']+'"></a></p>';
				html += '</div>';
				
				$('.dailydiet-dailydiet-ajax').html(html);
				placeHolder();
				makeNewNutrition(response['foodentryID']);
				deleteNewMeal(response['foodentryID']);
				newUpdateNutrition(response['foodentryID']);
					
			},
				error : function ( ) {
					alert ( 'Error' );
				}
		})

    })
}

function deleteFoodOld(){
	$('.delete-food-old').click(function(e) {
       	var temp = $(this).attr('id');
		var temp2 = temp.split('_');
		var id = temp2[1];
		
		$('#meal-set_'+id).remove();
		
		$.ajax({
			url: '/dailydiets/ajax_deleteOldFood/'+id,
			success : function( response ){
			},
			error : function ( ) {
				alert ( 'Error' );
			}
		})
		totalNutritionLoad()
    });	
}

function nutritionLoad(){
	var temp15 = $('.user-mass').attr('id');
	var temp16 = temp15.split('_');
	var mass = temp16[1];
	
	var temp17 = $('.user-volume').attr('id');
	var temp18 = temp17.split('_');
	var volume = temp18[1];
	
	
	$('.input .textbox').each(function(index) {
		var temp10 = $(this).attr('id');
		var temp11 = temp10.split('_');
		var id = temp11[1];
		var type = $('#food-type_'+id).attr('value');
		
		if(type == 0){
			if(mass == 1){
				var default_value = $(this).attr('value');
			}else{
				var default_value = ($(this).attr('value') * 0.0353);
			}
		}else{
			if(volume == 1){
				var default_value = $(this).attr('value');
			}else{
				var default_value = ($(this).attr('value') * 0.5683);
			}
		}
		
		var protein = $('#food-protein_'+id).attr('value');
		var carbs = $('#food-carbs_'+id).attr('value');
		var fat = $('#food-fat_'+id).attr('value');
		var fibre = $('#food-fibre_'+id).attr('value');
		var calories = $('#food-calories_'+id).attr('value');
		
		var value = Math.round((protein * default_value)*10) /10;
		$('#protein-value_'+id).html(value);
		$('#protein-value_'+id).attr('value', value);
		value = Math.round((carbs * default_value)*10) /10;
		$('#carbohydrates-value_'+id).html(value);
		$('#carbohydrates-value_'+id).attr('value', value);
		value = Math.round((fat * default_value)*10) /10;
		$('#fat-value_'+id).html(value);
		$('#fat-value_'+id).attr('value', value);
		value =Math.round((fibre * default_value)*10) /10;
		$('#fibre-value_'+id).html(value);
		$('#fibre-value_'+id).attr('value', value);
		value = Math.round((calories * default_value)*10) /10;
		$('#calories-value_'+id).html(value);
		$('#calories-value_'+id).attr('value', value);
	});
}

function totalNutritionLoad(){
	var totalProtein = 0.0;
	var totalCarbs = 0.0;
	var totalFat = 0.0;
	var totalFibre = 0.0;
	var totalCalories = 0.0;
	$('.meal-set').each(function(index, element) {
        var temp1 = $(this).attr('id');
		var temp2 = temp1.split('_');
		var id = temp2[1];
		
		var protein = parseFloat($('#protein-value_'+id).attr('value'));
		var carbs = parseFloat($('#carbohydrates-value_'+id).attr('value'));
		var fat = parseFloat($('#fat-value_'+id).attr('value'));
		var fibre = parseFloat($('#fibre-value_'+id).attr('value'));
		var calories = parseFloat($('#calories-value_'+id).attr('value'));
		totalProtein = Math.round((totalProtein + protein)*10) / 10;
		totalCarbs = Math.round((totalCarbs + carbs)*10) / 10;
		totalFat = Math.round((totalFat + fat)*10) / 10;
		totalFibre = Math.round((totalFibre + fibre)*10) / 10;
		totalCalories = Math.round((totalCalories + calories)*10) / 10;
    });
	$('#total-protein-value').html(totalProtein);
	$('#total-carbohydrates-value').html(totalCarbs);
	$('#total-fat-value').html(totalFat);
	$('#total-fibre-value').html(totalFibre);
	$('#total-calories-value').html(totalCalories);
}

function deepLinking(){
	/*var now = new Date();
	var startDay = now.getDate();
	var startMonth = (now.getMonth()+1);
	var startYear = now.getFullYear();
	var dbDate = startYear+'-'+startMonth+'-'+startDay;
	$('#dateOutput2').val(dbDate);*/
		//alert("Hello")
	var hash = window.location.hash;
	if(hash == '#workouts'){
		$('#journal-workout').siblings().removeClass('li-active');
		$('#journal-workout').addClass('li-active');
		$('.journal-wrapper').attr('id', 'journal-wrapper_workout');
		$("#LoadingImage").show();
		
		var megaDate = $('#dateOutput2').attr('value');	
			$.ajax({
			url : '/workouts/ajax_workout/'+megaDate,
			success : function( response ) {
				$('.journal-wrapper').html(response);
				searchjs();
				results();
				addWorkout();
				deleteOldExercise(megaDate);
				deleteOldSet();
				addSetOld();
				workout();
				$("#LoadingImage").hide();
				//window.location.hash = '#workouts';
			},
			error : function ( ) {
				alert ( "Error" );
				$("#LoadingImage").hide();
			}
		});	
	}
	
	//Food
	if(hash == '#dailydiet'){
		$('#journal-workout').siblings().removeClass('li-active');
		$('#journal-workout').addClass('li-active');
		$('.journal-wrapper').attr('id', 'journal-wrapper_food');
		$("#LoadingImage").show();
			var megaDate = $('#dateOutput2').attr('value');	
				$.ajax({
				url : '/dailydiets/ajax_dailydiet/'+megaDate,
				success : function( response ) {
					$('.journal-wrapper').html(response);
					food();
					searchFoods();
					foodResults();
					addMeal();
					deleteFoodOld();
					nutritionLoad();
					newUpdateNutrition();
					totalNutritionLoad();
					$("#LoadingImage").hide();
					//window.location.hash = '#dailydiet';
				},
				error : function ( ) {
					alert ( "Error" );
					$("#LoadingImage").hide();
				}
			});	
	}
	
	if(hash == '#measure'){
		$('#journal-measure').siblings().removeClass('li-active');
		$('#journal-measure').addClass('li-active');
		$('.journal-wrapper').attr('id', 'journal-wrapper_measure');
		$("#LoadingImage").show();
		
		var megaDate = $('#dateOutput2').attr('value');
		var meals = $.getValues('/bodies/json/'+megaDate);
			if(meals[0] == 0){
				$.ajax({
					url: '/bodies/add/'+megaDate,
					success : function( response ){
						$('.journal-wrapper').html(response);
						measure();
						$("#LoadingImage").hide();
					},
					error : function ( ) {
						alert ( 'Error' );
						$("#LoadingImage").hide();
					}
				});
			}else{
				$.ajax({
					url: '/bodies/edit/'+meals[1]+'/'+megaDate,
					success : function( response ){
						$('.journal-wrapper').html(response);
						measure();
						$("#LoadingImage").hide();
					},
					error : function () {
						alert( 'Error' );
						$("#LoadingImage").hide();	
					}
				});
			}
		}
}

function checkWorkoutSearch(){
	var value = $('#SearchActivites').attr('value');
	var length = value.length;
	$('#error-message-search').css('position', 'static');
	$('.exercise-select-search').each(function(index, element) {
        $(this).remove();
    });
	if( /([^a-zA-Z0-9_\s])+/.test( value ) ) {
		$('#flashMessage').text(' ');
		$('#error-message-search').text('Search must contain only alphaNumeric characters');
		return false;
    }else if(length > 50){
		$('#flashMessage').text(' ');
		$('#error-message-search').text('Search must not be greater than 50 characters');
		return false;	
	}
	$('#error-message-search').text(' ');
    return true;  	
}

function checkFoodSearch(){
	var value = $('#SearchFoods').attr('value');
	var length = value.length;
	$('#error-message-search').css('position', 'static');
	$('.food-select-search').each(function(index, element) {
        $(this).remove();
    });
	if( /([^a-zA-Z0-9_\s])+/.test( value ) ) {
		$('#flashMessage').text(' ');
		$('#error-message-search').text('Search must contain only alphaNumeric characters');
		return false;
    }else if(length > 50){
		$('#flashMessage').text(' ');
		$('#error-message-search').text('Search must not be greater than 50 characters');
		return false;	
	}
	$('#error-message-search').text(' ');
    return true;  	
}

function checkWorkoutValidation(){
	$('#workouts-form').submit(function(e) {
		$('.error-message').text('');
		$('#workouts-form #reps').each(function(index, element) {
			var value = $(this).attr('value');
			var length = value.length;
			if( /([^0-9])+/.test( value ) ) {
				$('.error-message').text('Reps must contain only numeric characters');
				return false;
			}else if(length > 10){
				$('.error-message').text('Reps must not be greater than 10 characters');
				return false;
			}
			
        });
		
		$('#workouts-form #time').each(function(index, element) {
			var value = $(this).attr('value');
			var length = value.length;
			if( /([^a-zA-Z0-9_\s!])+/.test( value ) ) {
				$('.error-message').text('Time must contain only alphaNumeric characters');
				return false;
			}else if(length > 25){
				$('.error-message').text('Time must not be greater than 25 characters');
				return false;
			}
			
        });
		
		$('#workouts-form #distance').each(function(index, element) {
			var value = $(this).attr('value');
			var length = value.length;
			if( /^-?(\d*)\.?\d*?$/.test( value ) ) {
				
				
			}else{
				$('.error-message').text('Distance must contain only numeric characters');
				return false;
			}
			if(length > 5){
				$('.error-message').text('Distance must not be greater than 5 characters');
				return false;
			}
			
        });
		
		$('#workouts-form #value').each(function(index, element) {
			var value = $(this).attr('value');
			var length = value.length;
			if( /^-?(\d*)\.?\d*?$/.test(value)){
				
			}else{
				$('.error-message').text('Value must contain only numeric characters');
				return false;
			}
			
			if(length > 10){
				$('.error-message').text('Value must not be greater than 10 characters');
				return false;	
			}
        });
		
		$('#workouts-form #notes').each(function(index, element) {
			var value = $(this).attr('value');
			var length = value.length;
			if( /([^a-zA-Z0-9_\s!\.])+/.test( value ) ) {
				$('.error-message').text('Notes must contain only alphNumeric characters');
				return false;
			}else if(length > 200){
				$('.error-message').text('Notes must not be greater than 200 characters');
				return false;
			}
        });
		var text = $('.error-message').text();
		if(text == ''){
			return true;	
		}else{
			return false;	
		}
    });
		
}

function checkFoodValidation(){
	$('#food-form').submit(function(e) {
		$('.error-message').text('');
		$('#food-form .textbox').each(function(index, element) {
			var value = $(this).attr('value');
			var length = value.length;
			if( /^-?(\d*)\.?\d*?$/.test(value)){
				
			}else{
				$('.error-message').text('Quantity must contain only numeric characters');
				return false;
			}
			
			if(length > 10){
				$('.error-message').text('Quantity must not be greater than 10 characters');
				return false;	
			}
        });
		
		$('#food-form #note').each(function(index, element) {
			var value = $(this).attr('value');
			var length = value.length;
			if( /^(([a-zA-Z0-9_\s!\.])+(\.{3})?)$/.test( value ) ) {
				
			}else{
				$('.error-message').text('Notes must contain only alphNumeric characters');
				return false;
			}
			if(length > 200){
				$('.error-message').text('Notes must not be greater than 200 characters');
				return false;
			}
        });
		var text = $('.error-message').text();
		if(text == ''){
			return true;	
		}else{
			return false;	
		}
    });
		
}

/*
 * Date Format 1.2.3
 * (c) 2007-2009 Steven Levithan <stevenlevithan.com>
 * MIT license
 *
 * Includes enhancements by Scott Trenda <scott.trenda.net>
 * and Kris Kowal <cixar.com/~kris.kowal/>
 *
 * Accepts a date, a mask, or a date and a mask.
 * Returns a formatted version of the given date.
 * The date defaults to the current date/time.
 * The mask defaults to dateFormat.masks.default.
 */

var dateFormat = function () {
	var	token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
		timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
		timezoneClip = /[^-+\dA-Z]/g,
		pad = function (val, len) {
			val = String(val);
			len = len || 2;
			while (val.length < len) val = "0" + val;
			return val;
		};

	// Regexes and supporting functions are cached through closure
	return function (date, mask, utc) {
		var dF = dateFormat;

		// You can't provide utc if you skip other args (use the "UTC:" mask prefix)
		if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
			mask = date;
			date = undefined;
		}

		// Passing date through Date applies Date.parse, if necessary
		date = date ? new Date(date) : new Date;
		if (isNaN(date)) throw SyntaxError("invalid date");

		mask = String(dF.masks[mask] || mask || dF.masks["default"]);

		// Allow setting the utc argument via the mask
		if (mask.slice(0, 4) == "UTC:") {
			mask = mask.slice(4);
			utc = true;
		}

		var	_ = utc ? "getUTC" : "get",
			d = date[_ + "Date"](),
			D = date[_ + "Day"](),
			m = date[_ + "Month"](),
			y = date[_ + "FullYear"](),
			H = date[_ + "Hours"](),
			M = date[_ + "Minutes"](),
			s = date[_ + "Seconds"](),
			L = date[_ + "Milliseconds"](),
			o = utc ? 0 : date.getTimezoneOffset(),
			flags = {
				d:    d,
				dd:   pad(d),
				ddd:  dF.i18n.dayNames[D],
				dddd: dF.i18n.dayNames[D + 7],
				m:    m + 1,
				mm:   pad(m + 1),
				mmm:  dF.i18n.monthNames[m],
				mmmm: dF.i18n.monthNames[m + 12],
				yy:   String(y).slice(2),
				yyyy: y,
				h:    H % 12 || 12,
				hh:   pad(H % 12 || 12),
				H:    H,
				HH:   pad(H),
				M:    M,
				MM:   pad(M),
				s:    s,
				ss:   pad(s),
				l:    pad(L, 3),
				L:    pad(L > 99 ? Math.round(L / 10) : L),
				t:    H < 12 ? "a"  : "p",
				tt:   H < 12 ? "am" : "pm",
				T:    H < 12 ? "A"  : "P",
				TT:   H < 12 ? "AM" : "PM",
				Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
				o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
				S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
			};

		return mask.replace(token, function ($0) {
			return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
		});
	};
}();

// Some common format strings
dateFormat.masks = {
	"default":      "ddd mmm dd yyyy HH:MM:ss",
	shortDate:      "m/d/yy",
	mediumDate:     "mmm d, yyyy",
	longDate:       "mmmm d, yyyy",
	fullDate:       "dddd, mmmm d, yyyy",
	shortTime:      "h:MM TT",
	mediumTime:     "h:MM:ss TT",
	longTime:       "h:MM:ss TT Z",
	isoDate:        "yyyy-mm-dd",
	isoTime:        "HH:MM:ss",
	isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
	isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
};

// Internationalization strings
dateFormat.i18n = {
	dayNames: [
		"Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
		"Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
	],
	monthNames: [
		"Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
		"January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
	]
};

// For convenience...
Date.prototype.format = function (mask, utc) {
	return dateFormat(this, mask, utc);
};



	 
	

