	$('a.tdata').removeClass('tdata');
	
	cal_days_labels = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
	
	cal_months_labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'Novemeber' , 'Decemeber'];
	
	cal_days_in_month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
	
	cal_current_date = new Date();
	
	prevMonth = cal_current_date.getMonth();
	nextMonth = cal_current_date.getMonth();
	
	prevYear = cal_current_date.getFullYear();
	nextYear = cal_current_date.getFullYear();

	function Calendar(month, year){
		
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
	  html += '<tr><th colspan="7">';
	  html += '<a onclick="new Calendar('+prevMonth+', '+prevYear+');return false;">Prev</a> | ';
	  html += monthName + "&nbsp;" + this.year;
	  html += ' | <a onclick="new Calendar('+nextMonth+', '+nextYear+'); return false;">Next</a>';
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
			html += '<a class = \'tdata\' onclick="document.getElementById(\'dateOutput\').value=\''+niceDate+'\';">'+day+'</a>';
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
	  document.getElementById('calendar').innerHTML = this.html; 
	 
	   $('a.tdata').click(function(){
		  $('a.tdata').removeClass('tdataSelected');
		  $(this).addClass('tdataSelected');
	  });
	  
	  if (window.location.pathname == '/workouts'){
		workout();
	  }
	  
	   if (window.location.pathname == '/bodies'){
		bodies();
	  }
	  
	  if (window.location.pathname == '/dailydiets'){
		dailydiets();  
	  }
	  /*$('a.tdata').click(function(){
	 	var megaDate = document.getElementById('dateOutput').value;
	  	$.ajax({
			url : '/bodies/add/'+megaDate,
			success : function( response ) {
				var res = JSON.parse ( response );
				//alert(res);
				//alert("Test");
				document.getElementById('dateOutput').value = res;
				//$('#score_'+res['Comment']['id']).html(res['Comment']['rating']);
			},
			error : function ( ) {
				alert ( "Error" );
			}
		});	
	  
	  });*/
}



	 
	
