$(document).ready(function(){
var checkMetricMass = $('.metricMass').attr('id');
var checkMetricLength = $('.metricLength').attr('id');
var checkGender = $('.gender').attr('id');	
	/*****************************************BodyFat***************************************************/
	$('#heightBF').focusout(function(){
		getBodyfat();
	});
	
	$('#waistBF').focusout(function(){
		getBodyfat();	
	});
	
	$('#neckBF').focusout(function(){
		getBodyfat();	
	});
	
	$('#hipsBF').focusout(function() {
        getBodyfat();
    });
	
	$('#feetBF').change(function() {
		getBodyfat();
	});
	
	$('#inchesBF').change(function() {
		getBodyfat();
	});

	/************************************BMR*************************************************************/
	$('#weightBMR').focusout(function() {
		if(checkMetricMass == 1){
			var age = $('#ageBMR').attr('value');
			var weight = $('#weightBMR').attr('value');
			if(checkMetricLength == 1){
				var height = $('#heightBMR').attr('value');
			}else{
				var feet = $('#feetBMR').attr('value');
				var inch = $('#inchesBMR').attr('value');
				var totalInches = parseInt(feet*12)+parseInt(inch);
				var height = totalInches * 2.54;
			}
			age = parseInt(age); weight = parseInt(weight); height = parseInt(height);
			if(checkGender == 'Male'){
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) +5);	
				document.getElementById('BMR').innerHTML = 'Your Basal Metabolic Rate is: '+BMR;
			}else{
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) -161); 
				document.getElementById('BMR').innerHTML = 'Your Basal Metabolic Rate is: '+BMR;
			}
			
		}else{
			var age = $('#ageBMR').attr('value');
			var weight = $('#weightBMR').attr('value');
			weight = parseInt(weight /2.2);
			if(checkMetricLength == 1){
				var height = $('#heightBMR').attr('value');
			}else{
				var feet = $('#feetBMR').attr('value');
				var inch = $('#inchesBMR').attr('value');
				var totalInches = parseInt(feet*12)+parseInt(inch);
				var height = totalInches * 2.54;
			}
			if(checkGender == 'Male'){
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) +5);	
				document.getElementById('BMR').innerHTML = 'Your Basal Metabolic Rate is: '+BMR;
			}else{
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) -161); 
				document.getElementById('BMR').innerHTML = 'Your Basal Metabolic Rate is: '+BMR;
			}
			
		}
        
    });
	
	$('#weightIdealBMR').focusout(function() {
		if(checkMetricMass == 1){
			var age = $('#ageBMR').attr('value');
			var weight = $('#weightIdealBMR').attr('value');
			if(checkMetricLength == 1){
				var height = $('#heightBMR').attr('value');
			}else{
				var feet = $('#feetBMR').attr('value');
				var inch = $('#inchesBMR').attr('value');
				var totalInches = parseInt(feet*12)+parseInt(inch);
				var height = totalInches * 2.54;
			}
			age = parseInt(age); weight = parseInt(weight); height = parseInt(height);
			if(checkGender == 'Male'){
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) +5);	
				document.getElementById('IdealBMR').innerHTML = 'Your Ideal Basal Metabolic Rate is: '+BMR;
			}else{
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) -161); 
				document.getElementById('IdealBMR').innerHTML = 'Your Ideal Basal Metabolic Rate is: '+BMR;
			}
			
		}else{
			var age = $('#ageBMR').attr('value');
			var weight = $('#weightIdealBMR').attr('value');
			weight = parseInt(weight /2.2);
			if(checkMetricLength == 1){
				var height = $('#heightBMR').attr('value');
			}else{
				var feet = $('#feetBMR').attr('value');
				var inch = $('#inchesBMR').attr('value');
				var totalInches = parseInt(feet*12)+parseInt(inch);
				var height = totalInches * 2.54;
			}
			if(checkGender == 'Male'){
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) +5);	
				document.getElementById('IdealBMR').innerHTML = 'Your Ideal Basal Metabolic Rate is: '+BMR;
			}else{
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) -161); 
				document.getElementById('IdealBMR').innerHTML = 'Your Ideal Basal Metabolic Rate is: '+BMR;
			}
			
		}
        
    });
	
	$('#ageBMR').focusout(function() {
		//if(checkMetricMass == 1){
			var age = $('#age').attr('value');
			var weight = $('#weight').attr('value');
			if(checkMetricLength == 1){
				var height = $('#height').attr('value');
			}else{
				var feet = $('#feet').attr('value');
				var inch = $('#inches').attr('value');
				var totalInches = parseInt(feet*12)+parseInt(inch);
				var height = totalInches * 2.54;
			}
			var idealWeight = $('#idealWeight').attr('value');
			age = parseInt(age); weight = parseInt(weight); height = parseInt(height); idealWeight = parseInt(idealWeight);
			if(checkGender == 'Male'){
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) +5);	
				document.getElementById('BMR').innerHTML = 'Your Basal Metabolic Rate is: '+BMR;
				var idealBMR = ((idealWeight*10) + (height * 6.25) - (age *5.0) +5);
				document.getElementById('IdealBMR').innerHTML = 'Your Ideal Basal Metabolic Rate is: '+idealBMR;
			}else{
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) -161); 
				document.getElementById('BMR').innerHTML = 'Your Basal Metabolic Rate is: '+BMR;
				var idealBMR = ((idealWeight*10) + (height * 6.25) - (age *5.0) -161);
				document.getElementById('IdealBMR').innerHTML = 'Your Ideal Basal Metabolic Rate is: '+idealBMR;
			}
			
		/*}else{
			var age = $('#ageBMR').attr('value');
			age = parseInt(age);
			var weight = $('#weightBMR').attr('value');
			var idealWeight = $('#weightIdealBMR').attr('value');
			idealWeight = parseInt(idealWeight / 2.2);
			weight = parseInt(weight /2.2);
			if(checkMetricLength == 1){
				var height = $('#heightBMR').attr('value');
			}else{
				var feet = $('#feetBMR').attr('value');
				var inch = $('#inchesBMR').attr('value');
				var totalInches = parseInt(feet*12)+parseInt(inch);
				var height = totalInches * 2.54;
			}
			if(checkGender == 'Male'){
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) +5);	
				document.getElementById('BMR').innerHTML = 'Your Basal Metabolic Rate is: '+BMR;
				var idealBMR = ((idealWeight*10) + (height * 6.25) - (age *5.0) +5);
				document.getElementById('IdealBMR').innerHTML = 'Your Ideal Basal Metabolic Rate is: '+idealBMR;
			}else{
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) -161); 
				document.getElementById('BMR').innerHTML = 'Your Basal Metabolic Rate is: '+BMR;
				var idealBMR = ((idealWeight*10) + (height * 6.25) - (age *5.0) -161);
				document.getElementById('IdealBMR').innerHTML = 'Your Ideal Basal Metabolic Rate is: '+idealBMR;
			}
		}  */ 
    });
	
	$('#heightBMR').focusout(function() {
			var age = $('#ageBMR').attr('value');
			var weight = $('#weightBMR').attr('value');
			var height = $('#heightBMR').attr('value');
			var idealWeight = $('#weightIdealBMR').attr('value');
			if(checkMetricMass == 0){
				weight = parseInt(weight /2.2);	
				idealWeight = parseInt(idealWeight / 2.2);
			}
			age = parseInt(age); weight = parseInt(weight); height = parseInt(height); idealWeight = parseInt(idealWeight);
			if(checkGender == 'Male'){
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) +5);	
				document.getElementById('BMR').innerHTML = 'Your Basal Metabolic Rate is: '+BMR;
				var idealBMR = ((idealWeight*10) + (height * 6.25) - (age *5.0) +5);
				document.getElementById('IdealBMR').innerHTML = 'Your Ideal Basal Metabolic Rate is: '+idealBMR;
			}else{
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) -161); 
				document.getElementById('BMR').innerHTML = 'Your Basal Metabolic Rate is: '+BMR;
				var idealBMR = ((idealWeight*10) + (height * 6.25) - (age *5.0) -161);
				document.getElementById('IdealBMR').innerHTML = 'Your Ideal Basal Metabolic Rate is: '+idealBMR;
			}
    });
	
	$('#feetBMR').change(function() {
			var age = $('#ageBMR').attr('value');
			age = parseInt(age);
			var weight = $('#weightBMR').attr('value');
			var idealWeight = $('#weightIdealBMR').attr('value');
			if(checkMetricMass == 0){
				weight = parseInt(weight /2.2);	
				idealWeight = parseInt(idealWeight / 2.2);
			}
			var feet = $('#feetBMR').attr('value');
			var inch = $('#inchesBMR').attr('value');
			var totalInches = parseInt(feet*12)+parseInt(inch);
			var height = totalInches * 2.54;
			if(checkGender == 'Male'){
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) +5);	
				document.getElementById('BMR').innerHTML = 'Your Basal Metabolic Rate is: '+BMR;
				var idealBMR = ((idealWeight*10) + (height * 6.25) - (age *5.0) +5);
				document.getElementById('IdealBMR').innerHTML = 'Your Ideal Basal Metabolic Rate is: '+idealBMR;
			}else{
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) -161); 
				document.getElementById('BMR').innerHTML = 'Your Basal Metabolic Rate is: '+BMR;
				var idealBMR = ((idealWeight*10) + (height * 6.25) - (age *5.0) -161);
				document.getElementById('IdealBMR').innerHTML = 'Your Ideal Basal Metabolic Rate is: '+idealBMR;
			}
    });
	
	$('#inchesBMR').change(function() {
			var age = $('#ageBMR').attr('value');
			age = parseInt(age);
			var weight = $('#weightBMR').attr('value');
			var idealWeight = $('#weightIdealBMR').attr('value');
			if(checkMetricMass == 0){
				weight = parseInt(weight /2.2);	
				idealWeight = parseInt(idealWeight / 2.2);
			}
			var feet = $('#feetBMR').attr('value');
			var inch = $('#inchesBMR').attr('value');
			var totalInches = parseInt(feet*12)+parseInt(inch);
			var height = totalInches * 2.54;
			if(checkGender == 'Male'){
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) +5);	
				document.getElementById('BMR').innerHTML = 'Your Basal Metabolic Rate is: '+BMR;
				var idealBMR = ((idealWeight*10) + (height * 6.25) - (age *5.0) +5);
				document.getElementById('IdealBMR').innerHTML = 'Your Ideal Basal Metabolic Rate is: '+idealBMR;
			}else{
				var BMR = ((weight*10) + (height * 6.25) - (age *5.0) -161); 
				document.getElementById('BMR').innerHTML = 'Your Basal Metabolic Rate is: '+BMR;
				var idealBMR = ((idealWeight*10) + (height * 6.25) - (age *5.0) -161);
				document.getElementById('IdealBMR').innerHTML = 'Your Ideal Basal Metabolic Rate is: '+idealBMR;
			}
    });
	
	
	
	
	/**************BMI*******************************/
	$('#weight').focusout(function() {
		if (checkMetricLength == 1){
			if(checkMetricMass == 1){
			   var weight = $('#weight').attr('value');
			}else{
			   var weight = $('#weight').attr('value') / 2.2;
			}
		   var height = $('#height').attr('value');
		   var bmi = weight/ Math.pow((height/100),2);
		   document.getElementById('BMI').innerHTML = 'Your BMI is: '+Math.round((bmi*100))/100;
		   getcategory(bmi);
		   document.getElementById('result').innerHTML = 'This is considered: '+category;
		} else{
			if(checkMetricMass == 1){
			   var weight = $('#weight').attr('value');
			}else{
			   var weight = $('#weight').attr('value') / 2.2;
			}
			var foot = $('#feet').attr('value');
			var inch = $('#inches').attr('value');
			var totalInches = (foot*12);
			totalInches = parseInt(totalInches) + parseInt(inch);
			var bmi = (weight *703) / Math.pow((totalInches),2);
			document.getElementById('BMI').innerHTML = 'Your BMI is '+Math.round((bmi*100))/100;
			getcategory(bmi);
			document.getElementById('result').innerHTML = 'This is considered: '+category;
		}
    });
	
	$('#height').focusout(function() {
       if(checkMetricMass == 1){
		   var weight = $('#weight').attr('value');
		}else{
		   var weight = $('#weight').attr('value') / 2.2;
		}
	   var height = $('#height').attr('value');
	   var bmi = weight/ Math.pow((height/100),2);
	   document.getElementById('BMI').innerHTML = 'Your BMI is: '+Math.round((bmi*100))/100;
	   getcategory(bmi);
	   document.getElementById('result').innerHTML = 'This is considered: '+category;
    });
	
	$('#feet').change(function() {
        if(checkMetricMass == 1){
		   var weight = $('#weight').attr('value');
		}else{
		   var weight = $('#weight').attr('value') / 2.2;
		}
		var foot = $('#feet').attr('value');
		var inch = $('#inches').attr('value');
		var totalInches = (foot*12);
		totalInches = parseInt(totalInches) + parseInt(inch);
		var bmi = (weight *703) / Math.pow((totalInches),2);
		document.getElementById('BMI').innerHTML = 'Your BMI is '+Math.round((bmi*100))/100;
		getcategory(bmi);
		document.getElementById('result').innerHTML = 'This is considered: '+category;
    });
	
	$('#inches').change(function(){
		if(checkMetricMass == 1){
		   var weight = $('#weight').attr('value');
		}else{
		   var weight = $('#weight').attr('value') / 2.2;
		}
		var foot = $('#feet').attr('value');
		var inch = $('#inches').attr('value');
		var totalInches = (foot*12);
		totalInches = parseInt(totalInches) + parseInt(inch);
		var bmi = (weight *703) / Math.pow((totalInches),2);
		document.getElementById('BMI').innerHTML = 'Your BMI is '+Math.round((bmi*100))/100;
		getcategory(bmi);
		document.getElementById('result').innerHTML = 'This is considered: '+category;
	});

});

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

function log10(val){
	return Math.log(val) / Math.log(10);
}

function getBodyfat(){
	var checkMetricLength = $('.metricLength').attr('id');
	var checkGender = $('.gender').attr('id');	
	if(checkMetricLength == 1){
		if(checkGender == 'Male'){
			var height = $('#heightBF').attr('value');
			var waist = $('#waistBF').attr('value');
			var neck = $('#neckBF').attr('value');
			height = parseInt(height); waist = parseInt(waist); neck = parseInt(neck);
			var bodyfat = 86.010*log10(waist-neck)-70.041*log10(height)+30.30;
			bodyfat = Math.round(bodyfat);
			document.getElementById('bodyfat').innerHTML = 'Bodyfat : '+bodyfat+'%';
				
		}else{
			var height = $('#heightBF').attr('value');
			var waist = $('#waistBF').attr('value');
			var neck = $('#neckBF').attr('value');
			var hips = $('#hipsBF').attr('value');
			height = parseInt(height); waist = parseInt(waist); neck = parseInt(neck); hips = parseInt(hips);
			var bodyfat = 163.205*log10(waist+hips-neck)-97.684*log10(height)-104.912;
			bodyfat = Math.round(bodyfat);
			document.getElementById('bodyfat').innerHTML = 'Bodyfat : '+bodyfat+'%';
		}
		
	}else{
		if(checkGender == 'Male'){
			var feet = $('#feetBF').attr('value');
			var inch = $('#inchesBF').attr('value');
			var totalInches = parseInt(feet*12)+parseInt(inch);
			var height = totalInches * 2.54;
			var waist = $('#waistBF').attr('value')*2.54;
			var neck = $('#neckBF').attr('value')*2.54;
			height = parseInt(height); waist = parseInt(waist); neck = parseInt(neck);
			var bodyfat = 86.010*log10(waist-neck)-70.041*log10(height)+30.30;
			bodyfat = Math.round(bodyfat);
			document.getElementById('bodyfat').innerHTML = 'Bodyfat : '+bodyfat+'%';
		}else{
			var feet = $('#feetBF').attr('value');
			var inch = $('#inchesBF').attr('value');
			var totalInches = parseInt(feet*12)+parseInt(inch);
			var height = totalInches * 2.54;
			var waist = $('#waistBF').attr('value')*2.54;
			var neck = $('#neckBF').attr('value')*2.54;
			var hips = $('#hipsBF').attr('value')*2.54;
			height = parseInt(height); waist = parseInt(waist); neck = parseInt(neck); hips = parseInt(hips);
			var bodyfat = 163.205*log10(waist+hips-neck)-97.684*log10(height)-104.912;
			bodyfat = Math.round(bodyfat);
			document.getElementById('bodyfat').innerHTML = 'Bodyfat : '+bodyfat+'%';
			
		}
	}
	
}