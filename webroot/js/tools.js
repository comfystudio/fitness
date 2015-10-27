$(document).ready(function(){
	
	//MANAGE FOODS
	$('#tools-manageFood').click(function(){
		$(this).siblings().removeClass('li-active');
		$('#tools-manageFood').addClass('li-active');
		$("#LoadingImage").show();
		
			$.ajax({
			url : '/profiles/ajax_manage/',
			success : function( response ) {
				$('.tools-wrapper').html(response);
				manageFood();
				$("#LoadingImage").hide();
			},
			error : function ( ) {
				$("#LoadingImage").hide();
				alert ( "Error" );
			}
		});	
	})
	
	//BMR
	$('#tools-bmr').click(function(){
		$(this).siblings().removeClass('li-active');
		$('#tools-bmr').addClass('li-active');
		$("#LoadingImage").show();
		
			$.ajax({
			url : '/profiles/ajax_bmr/',
			success : function( response ) {
				$('.tools-wrapper').html(response);
				bmr();
				$("#LoadingImage").hide();
			},
			error : function ( ) {
				$("#LoadingImage").hide();
				alert ( "Error" );
			}
		});	
	})
	
	//Bodyfat
	$('#tools-bodyfat').click(function(){
		$(this).siblings().removeClass('li-active');
		$('#tools-bodyfat').addClass('li-active');
		$("#LoadingImage").show();
		
			$.ajax({
			url : '/profiles/ajax_bodyfat/',
			success : function( response ) {
				$('.tools-wrapper').html(response);
				bodyfat();
				$("#LoadingImage").hide();
			},
			error : function ( ) {
				$("#LoadingImage").hide();
				alert ( "Error" );
			}
		});	
	})
	
	//BMI
	$('#tools-bmi').click(function(){
		$(this).siblings().removeClass('li-active');
		$('#tools-bmi').addClass('li-active');
		$("#LoadingImage").show();
		
			$.ajax({
			url : '/profiles/ajax_bmi/',
			success : function( response ) {
				$('.tools-wrapper').html(response);
				bmi();
				$("#LoadingImage").hide();
			},
			error : function ( ) {
				$("#LoadingImage").hide();
				alert ( "Error" );
			}
		});	
	})
})


function manageFood(){
	$('#add-food').click(function(e) {
		$.ajax({
			url : '/profiles/ajax_addFood/',
			success : function( response ) {
				$('.tools-content').html(response);
				addFood();
				validateFood();
			},
			error : function ( ) {
				alert ( "Error" );
			}
		});
    });
	
	$('.tools-food select').change(function(e) {
		var id = $(this).attr('value');
		$.ajax({
			url : '/profiles/ajax_editFood/'+id,
			success : function( response ) {
				$('.tools-content').html(response);
				addFood();
				validateFood();
			},
			error : function ( ) {
				alert ( "Error" );
			}
		});
    }).trigger('change');
}

function validateFood(){
	$('.tools-content form').submit(function(e) {
		$('.error-message').text('');
		$('.error-message').css('float', 'left');
		$('.error-message').css('position', 'static');

		
		/************NAME**************/
		var value = $('form #ProfileName').attr('value');
		var length = value.length;
		if(/^[a-zA-Z0-9_\s!\.]+(\.\.\.)?$/.test(value)){
			
		}else{
			$('.error-message').text('Name must contain only alphaNumeric characters');
			return false;
		}
		if(length > 50){
			$('.error-message').text('Name must not be greater than 50 characters');
			return false;
		}
		
		
		/**************DEFAULT VALUE**************/
		var value = $('form #ProfileDefaultValue').attr('value');
		var length = value.length;
		if(/^\d{1,10}(\.\d{1,4})?$/.test(value)){
			
		}else{
			$('.error-message').text('Default_value must contain only numeric characters');
			return false;
		}
		if(length > 14){
			$('.error-message').text('Default_value must not be greater than 14 characters');
			return false;
		}
		
		/*******************FOOD TYPE************************/
		var value = $('form #ProfileFoodType').attr('value');
		if(/^\d{1}$/.test(value)){
			
		}else{
			$('.error-message').text('Food type is required');
			return false;
		}
		
		
		/**************DEFAULT LABEL**************/
		var value = $('form #ProfileDefaultLabel').attr('value');
		var length = value.length;
		if(/^[a-zA-Z0-9_\s!\.]+(\.\.\.)?$/.test(value)){
			
		}else{
			$('.error-message').text('Default label must contain only alphaNumeric characters');
			return false;
		}
		if(length > 50){
			$('.error-message').text('Default label must not be greater than 50 characters');
			return false;
		}
		
		
		/**************DEFAULT PROTEIN**************/
		var value = $('form #ProfileProtein').attr('value');
		var length = value.length;
		if(/^\d+(\.\d{1,4})?$/.test(value)){
			
		}else{
			$('.error-message').text('Protein must contain only numeric characters with 4 decimals');
			return false;
		}
		if(length > 14){
			$('.error-message').text('Protein must not be greater than 14 characters');
			return false;
		}
		
		
		/**************DEFAULT CARBS**************/
		var value = $('form #ProfileCarbs').attr('value');
		var length = value.length;
		if(/^\d+(\.\d{1,4})?$/.test(value)){
			
		}else{
			$('.error-message').text('Carbs must contain only numeric characters with 4 decimals');
			return false;
		}
		if(length > 14){
			$('.error-message').text('Carbs must not be greater than 14 characters');
			return false;
		}
		
		
		/**************DEFAULT FAT**************/
		var value = $('form #ProfileFat').attr('value');
		var length = value.length;
		if(/^\d+(\.\d{1,4})?$/.test(value)){
			
		}else{
			$('.error-message').text('Fat must contain only numeric characters with 4 decimals');
			return false;
		}
		if(length > 14){
			$('.error-message').text('Fat must not be greater than 14 characters');
			return false;
		}
		
		
		/**************DEFAULT FIBRE**************/
		var value = $('form #ProfileFibre').attr('value');
		var length = value.length;
		if(/^\d+(\.\d{1,4})?$/.test(value)){
			
		}else{
			$('.error-message').text('Fibre must contain only numeric characters with 4 decimals');
			return false;
		}
		if(length > 14){
			$('.error-message').text('Fibre must not be greater than 14 characters');
			return false;
		}
		
		
		/**************DEFAULT CALORIES**************/
		var value = $('form #ProfileCalories').attr('value');
		var length = value.length;
		if(/^\d+(\.\d{1,4})?$/.test(value)){
			
		}else{
			$('.error-message').text('Calories must contain only numeric characters with 4 decimals');
			return false;
		}
		if(length > 14){
			$('.error-message').text('Calories must not be greater than 14 characters');
			return false;
		}
		
		
		if($('.error-message').text() == ''){
			return true;	
		}else{
			return false;	
		}
    });
	
}

function addFood(){
	
	$('#ProfileType0').click(function(e) {
	   var option = {'grams(g)' : 0, 'ounce(oz)' : 1}
	   $('#ProfileFoodType').empty()
	   $.each(option, function(key, value) {
		  $('#ProfileFoodType').append($("<option></option>")
			 .attr("value", value).text(key));
		});
    });	
	
	$('#ProfileType1').click(function(e) {
	   var option = {'litre(l)' : 2, 'pint(pt)' : 3}
	   $('#ProfileFoodType').empty()
	   $.each(option, function(key, value) {
		  $('#ProfileFoodType').append($("<option></option>")
			 .attr("value", value).text(key));
		});
    });	
	placeholderTools();
	
}

function placeholderTools(){
	if($('.tools-food-add #ProfileName').attr('value') == ''){
		$('.tools-food-add #ProfileName').attr('value', 'Name / Label...');
	}
	$('.tools-food-add #ProfileName').focus(function(){
		if($(this).attr('value') == 'Name / Label...'){
			$(this).attr('value', '');
		}
	})
	$('.tools-food-add #ProfileName').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Name / Label...');
		}
	})
	
	if($('.tools-food-add #ProfileDefaultValue').attr('value') == ''){
		$('.tools-food-add #ProfileDefaultValue').attr('value', 'Default Value...');
	}
	$('.tools-food-add #ProfileDefaultValue').focus(function(){
		if($(this).attr('value') == 'Default Value...'){
			$(this).attr('value', '');
		}
	})
	$('.tools-food-add #ProfileDefaultValue').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Default Value...');
		}
	})
	
	if($('.tools-food-add #ProfileDefaultLabel').attr('value') == ''){
		$('.tools-food-add #ProfileDefaultLabel').attr('value', 'Default label...');
	}
	$('.tools-food-add #ProfileDefaultLabel').focus(function(){
		if($(this).attr('value') == 'Default label...'){
			$(this).attr('value', '');
		}
	})
	$('.tools-food-add #ProfileDefaultLabel').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Default label...');
		}
	})
	
	if($('.tools-food-add #ProfileProtein').attr('value') == ''){
		$('.tools-food-add #ProfileProtein').attr('value', 'Protein...');
	}
	$('.tools-food-add #ProfileProtein').focus(function(){
		if($(this).attr('value') == 'Protein...'){
			$(this).attr('value', '');
		}
	})
	$('.tools-food-add #ProfileProtein').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Protein...');
		}
	})
	
	if($('.tools-food-add #ProfileCarbs').attr('value') == ''){
		$('.tools-food-add #ProfileCarbs').attr('value', 'Carbohydrates...');
	}
	$('.tools-food-add #ProfileCarbs').focus(function(){
		if($(this).attr('value') == 'Carbohydrates...'){
			$(this).attr('value', '');
		}
	})
	$('.tools-food-add #ProfileCarbs').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Carbohydrates...');
		}
	})
	
	if($('.tools-food-add #ProfileFat').attr('value') == ''){
		$('.tools-food-add #ProfileFat').attr('value', 'Fats...');
	}
	$('.tools-food-add #ProfileFat').focus(function(){
		if($(this).attr('value') == 'Fats...'){
			$(this).attr('value', '');
		}
	})
	$('.tools-food-add #ProfileFat').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Fats...');
		}
	})
	
	if($('.tools-food-add #ProfileFibre').attr('value') == ''){
		$('.tools-food-add #ProfileFibre').attr('value', 'Fibre...');
	}
	$('.tools-food-add #ProfileFibre').focus(function(){
		if($(this).attr('value') == 'Fibre...'){
			$(this).attr('value', '');
		}
	})
	$('.tools-food-add #ProfileFibre').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Fibre...');
		}
	})
	
	
	
	if($('.tools-food-add #ProfileCalories').attr('value') == ''){
		$('.tools-food-add #ProfileCalories').attr('value', 'Calories...');
	}
	$('.tools-food-add #ProfileCalories').focus(function(){
		if($(this).attr('value') == 'Calories...'){
			$(this).attr('value', '');
		}
	})
	$('.tools-food-add #ProfileCalories').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Calories...');
		}
	})
	
}

function bmr(){
	var temp = $('.bmr-content').attr('id');
	var temp2 = temp.split('_');
	var checkGender = temp2[1];
	
	var temp3 = $('.check-metric-length').attr('id');
	var temp4 = temp3.split('_');
	var checkLength = temp4[1];
	
	var temp5 = $('.check-metric-mass').attr('id');
	var temp6 = temp5.split('_');
	var checkMass = temp6[1];
	
	if($('.bmr-content #age').attr('value') == ''){
		$('.bmr-content #age').attr('value', 'Age...');
	}
	$('.bmr-content #age').focus(function(){
		if($(this).attr('value') == 'Age...'){
			$(this).attr('value', '');
		}
	})
	$('.bmr-content #age').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Age...');
		}
	})
	
	if($('.bmr-content #height').attr('value') == ''){
		$('.bmr-content #height').attr('value', 'Height(cm)...');
	}
	$('.bmr-content #height').focus(function(){
		if($(this).attr('value') == 'Height(cm)...'){
			$(this).attr('value', '');
		}
	})
	$('.bmr-content #height').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Height(cm)...');
		}
	})
	
	if(checkMass == 1){
		if($('.bmr-content #weight').attr('value') == ''){
			$('.bmr-content #weight').attr('value', 'Weight(kg)...');
		}
		$('.bmr-content #weight').focus(function(){
			if($(this).attr('value') == 'Weight(kg)...'){
				$(this).attr('value', '');
			}
		})
		$('.bmr-content #weight').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Weight(kg)...');
			}
		})
		
		if($('.bmr-content #idealWeight').attr('value') == ''){
			$('.bmr-content #idealWeight').attr('value', 'Ideal Weight(kg)...');
		}
		$('.bmr-content #idealWeight').focus(function(){
			if($(this).attr('value') == 'Ideal Weight(kg)...'){
				$(this).attr('value', '');
			}
		})
		$('.bmr-content #idealWeight').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Ideal Weight(kg)...');
			}
		})
	}else{
		if($('.bmr-content #weight').attr('value') == ''){
			$('.bmr-content #weight').attr('value', 'Weight(lb)...');
		}
		$('.bmr-content #weight').focus(function(){
			if($(this).attr('value') == 'Weight(lb)...'){
				$(this).attr('value', '');
			}
		})
		$('.bmr-content #weight').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Weight(lb)...');
			}
		})
		
		if($('.bmr-content #idealWeight').attr('value') == ''){
			$('.bmr-content #idealWeight').attr('value', 'Ideal Weight(lb)...');
		}
		$('.bmr-content #idealWeight').focus(function(){
			if($(this).attr('value') == 'Ideal Weight(lb)...'){
				$(this).attr('value', '');
			}
		})
		$('.bmr-content #idealWeight').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Ideal Weight(lb)...');
			}
		})
		
	}
	
	$('#age').focusout(function(e) {
        getBMR();
    });
	
	$('#height').focusout(function(e) {
        getBMR();
    });
	
	$('#feet').focusout(function(e) {
        getBMR();
    });
	
	$('#inches').focusout(function(e) {
        getBMR();
    });
	
	$('#weight').focusout(function(e) {
        getBMR();
    });
	
	$('#idealWeight').focusout(function(e) {
        getBMR();
    });
	
	function getBMR(){
			var age = $('#age').attr('value');
			if(checkLength == 1){
				var height = $('#height').attr('value');
			}else{
				var feet = $('#feet').attr('value');
				var inch = $('#inches').attr('value');
				var totalInches = parseInt(feet*12)+parseInt(inch);
				var height = totalInches * 2.54;
			}
			if (checkMass == 1){
				var weight = $('#weight').attr('value');
				var idealWeight = $('#idealWeight').attr('value');
			}else{
				var weight = $('#weight').attr('value');
				var idealWeight = $('#idealWeight').attr('value');
				var weight = parseInt(weight / 2.2);
				var idealWeight =  parseInt(idealWeight / 2.2);
			}
			age = parseInt(age); weight = parseInt(weight); height = parseInt(height); idealWeight = parseInt(idealWeight);
			if(checkGender == 'Male'){
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) +5);
				var idealBMR = ((idealWeight*10) + (height * 6.25) - (age *5.0) +5);
				if(!isNaN(BMR)){
					document.getElementById('bmr').innerHTML = BMR;
					document.getElementById('idealbmr').innerHTML = idealBMR;
				}
				
			}else{
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) -161); 
				var idealBMR = ((idealWeight*10) + (height * 6.25) - (age *5.0) -161);
				if(!isNaN(BMR)){
					document.getElementById('bmr').innerHTML = BMR;
					document.getElementById('idealbmr').innerHTML = idealBMR;
				}
			}
	}
	
}

function bodyfat(){
	var temp = $('.bmr-content').attr('id');
	var temp2 = temp.split('_');
	var checkGender = temp2[1];
	
	var temp3 = $('.check-metric-length').attr('id');
	var temp4 = temp3.split('_');
	var checkLength = temp4[1];
	
	var temp5 = $('.check-metric-mass').attr('id');
	var temp6 = temp5.split('_');
	var checkMass = temp6[1];
	
	if(checkLength == 1){
		if($('.bmr-content #waist').attr('value') == ''){
			$('.bmr-content #waist').attr('value', 'Waist(cm)...');
		}
		$('.bmr-content #waist').focus(function(){
			if($(this).attr('value') == 'Waist(cm)...'){
				$(this).attr('value', '');
			}
		})
		$('.bmr-content #waist').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Waist(cm)...');
			}
		})
		
		if($('.bmr-content #neck').attr('value') == ''){
			$('.bmr-content #neck').attr('value', 'Neck(cm)...');
		}
		$('.bmr-content #neck').focus(function(){
			if($(this).attr('value') == 'Neck(cm)...'){
				$(this).attr('value', '');
			}
		})
		$('.bmr-content #neck').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Neck(cm)...');
			}
		})
		
		if($('.bmr-content #hips').attr('value') == ''){
			$('.bmr-content #hips').attr('value', 'Hips(cm)...');
		}
		$('.bmr-content #hips').focus(function(){
			if($(this).attr('value') == 'Hips(cm)...'){
				$(this).attr('value', '');
			}
		})
		$('.bmr-content #hips').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Hips(cm)...');
			}
		})
		
	}else{
		if($('.bmr-content #waist').attr('value') == ''){
			$('.bmr-content #waist').attr('value', 'Waist(in)...');
		}
		$('.bmr-content #waist').focus(function(){
			if($(this).attr('value') == 'Waist(in)...'){
				$(this).attr('value', '');
			}
		})
		$('.bmr-content #waist').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Waist(in)...');
			}
		})
		
		if($('.bmr-content #neck').attr('value') == ''){
			$('.bmr-content #neck').attr('value', 'Neck(in)...');
		}
		$('.bmr-content #neck').focus(function(){
			if($(this).attr('value') == 'Neck(in)...'){
				$(this).attr('value', '');
			}
		})
		$('.bmr-content #neck').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Neck(in)...');
			}
		})
		
		if($('.bmr-content #hips').attr('value') == ''){
			$('.bmr-content #hips').attr('value', 'Hips(in)...');
		}
		$('.bmr-content #hips').focus(function(){
			if($(this).attr('value') == 'Hips(in)...'){
				$(this).attr('value', '');
			}
		})
		$('.bmr-content #hips').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Hips(in)...');
			}
		})
	}
	
	if($('.bmr-content #weight').attr('value') == ''){
			$('.bmr-content #weight').attr('value', 'Weight(kg)...');
		}
		$('.bmr-content #weight').focus(function(){
			if($(this).attr('value') == 'Weight(kg)...'){
				$(this).attr('value', '');
			}
		})
		$('.bmr-content #weight').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Weight(kg)...');
			}
		})
		
	if($('.bmr-content #height').attr('value') == ''){
		$('.bmr-content #height').attr('value', 'Height(cm)...');
	}
	$('.bmr-content #height').focus(function(){
		if($(this).attr('value') == 'Height(cm)...'){
			$(this).attr('value', '');
		}
	})
	$('.bmr-content #height').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Height(cm)...');
		}
	})
	
	$('#height').focusout(function(){
		getBodyfat();
	});
	
	$('#waist').focusout(function(){
		getBodyfat();	
	});
	
	$('#neck').focusout(function(){
		getBodyfat();	
	});
	
	$('#hips').focusout(function() {
        getBodyfat();
    });
	
	$('#feet').change(function() {
		getBodyfat();
	}).trigger('change');
	
	$('#inches').change(function() {
		getBodyfat();
	}).trigger('change');
	
	function log10(val){
		return Math.log(val) / Math.log(10);
	}
	
	function getBodyfat(){
		if(checkLength == 1){
			if(checkGender == 'Male'){
				var height = $('#height').attr('value');
				var waist = $('#waist').attr('value');
				var neck = $('#neck').attr('value');
				height = parseInt(height); waist = parseInt(waist); neck = parseInt(neck);
				var bodyfat = 86.010*log10(waist-neck)-70.041*log10(height)+30.30;
				bodyfat = Math.round(bodyfat);
				if(!isNaN(bodyfat)){
					document.getElementById('bodyfat').innerHTML = bodyfat+'%';
				}
					
			}else{
				var height = $('#height').attr('value');
				var waist = $('#waist').attr('value');
				var neck = $('#neck').attr('value');
				var hips = $('#hips').attr('value');
				height = parseInt(height); waist = parseInt(waist); neck = parseInt(neck); hips = parseInt(hips);
				var bodyfat = 163.205*log10(waist+hips-neck)-97.684*log10(height)-104.912;
				bodyfat = Math.round(bodyfat);
				if(!isNaN(bodyfat)){
					document.getElementById('bodyfat').innerHTML = bodyfat+'%';
				}
			}
			
		}else{
			if(checkGender == 'Male'){
				var feet = $('#feet').attr('value');
				var inch = $('#inches').attr('value');
				var totalInches = parseInt(feet*12)+parseInt(inch);
				var height = totalInches * 2.54;
				var waist = $('#waist').attr('value')*2.54;
				var neck = $('#neck').attr('value')*2.54;
				height = parseInt(height); waist = parseInt(waist); neck = parseInt(neck);
				var bodyfat = 86.010*log10(waist-neck)-70.041*log10(height)+30.30;
				bodyfat = Math.round(bodyfat);
				if(!isNaN(bodyfat)){
					document.getElementById('bodyfat').innerHTML = bodyfat+'%';
				}
			}else{
				var feet = $('#feet').attr('value');
				var inch = $('#inches').attr('value');
				var totalInches = parseInt(feet*12)+parseInt(inch);
				var height = totalInches * 2.54;
				var waist = $('#waist').attr('value')*2.54;
				var neck = $('#neck').attr('value')*2.54;
				var hips = $('#hips').attr('value')*2.54;
				height = parseInt(height); waist = parseInt(waist); neck = parseInt(neck); hips = parseInt(hips);
				var bodyfat = 163.205*log10(waist+hips-neck)-97.684*log10(height)-104.912;
				bodyfat = Math.round(bodyfat);
				if(!isNaN(bodyfat)){
					document.getElementById('bodyfat').innerHTML = bodyfat+'%';
				}
			}
		}
	}
}

function bmi(){
	var temp = $('.bmr-content').attr('id');
	var temp2 = temp.split('_');
	var checkGender = temp2[1];
	
	var temp3 = $('.check-metric-length').attr('id');
	var temp4 = temp3.split('_');
	var checkLength = temp4[1];
	
	var temp5 = $('.check-metric-mass').attr('id');
	var temp6 = temp5.split('_');
	var checkMass = temp6[1];
	
	if($('.bmr-content #height').attr('value') == ''){
		$('.bmr-content #height').attr('value', 'Height(cm)...');
	}
	$('.bmr-content #height').focus(function(){
		if($(this).attr('value') == 'Height(cm)...'){
			$(this).attr('value', '');
		}
	})
	$('.bmr-content #height').blur(function(){
		if($(this).attr('value') == ''){
			$(this).attr('value', 'Height(cm)...');
		}
	})
		
	if(checkMass == 1){
		if($('.bmr-content #weight').attr('value') == ''){
			$('.bmr-content #weight').attr('value', 'Weight(kg)...');
		}
		$('.bmr-content #weight').focus(function(){
			if($(this).attr('value') == 'Weight(kg)...'){
				$(this).attr('value', '');
			}
		})
		$('.bmr-content #weight').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Weight(kg)...');
			}
		})
	}else{
		if($('.bmr-content #weight').attr('value') == ''){
			$('.bmr-content #weight').attr('value', 'Weight(lb)...');
		}
		$('.bmr-content #weight').focus(function(){
			if($(this).attr('value') == 'Weight(lb)...'){
				$(this).attr('value', '');
			}
		})
		$('.bmr-content #weight').blur(function(){
			if($(this).attr('value') == ''){
				$(this).attr('value', 'Weight(lb)...');
			}
		})
	}
	
	$('#weight').focusout(function(){
		getBMI();	
	});
	
	$('#height').focusout(function() {
        getBMI();
    });
	
	$('#feet').change(function() {
		getBMI();
	}).trigger('change');
	
	$('#inches').change(function() {
		getBMI();
	}).trigger('change');
	
	function getcategory(number){
	if (number < 16){
			return category = 'Severely underweight';
		}else if (number >16 && number <18.5) {
			return category = 'Underweight';
		}else if (number > 18.5 && number < 25){
			return category = 'Normal';
		}else if (number > 25 && number < 30){
			return category = 'Overweight';	
		}else if (number > 30 && number < 35){
			return category = 'Obese Class I';	
		}else if (number >35 && number < 40) {
			return category = 'Obese Class II';	
		}else if (number >40){
			return category = 'Obese Class III';	
		}
	}
	
	
	function getBMI(){
		if (checkLength == 1){
			if(checkMass == 1){
			   var weight = $('#weight').attr('value');
			}else{
			   var weight = $('#weight').attr('value') / 2.2;
			}
		   var height = $('#height').attr('value');
		   var bmi = weight/ Math.pow((height/100),2);
		   document.getElementById('bmi').innerHTML = Math.round((bmi*100))/100;
		   var category = getcategory(bmi);
		   document.getElementById('considered').innerHTML = category;
		} else{
			if(checkMass == 1){
			   var weight = $('#weight').attr('value');
			}else{
			   var weight = $('#weight').attr('value') / 2.2;
			}
			var foot = $('#feet').attr('value');
			var inch = $('#inches').attr('value');
			var totalInches = (foot*12);
			var height = totalInches * 2.54;
			var bmi = weight/ Math.pow((height/100),2);
			document.getElementById('bmi').innerHTML = Math.round((bmi*100))/100;
			var category = getcategory(bmi);
			document.getElementById('considered').innerHTML = category;
		}
		
	}
	
}