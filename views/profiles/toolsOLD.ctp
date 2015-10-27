<?php echo $this->Html->script('tools');?>
<div class = 'panel'>
	<div class  = 'gender' id = '<?php echo $height['User']['sex'];?>'></div>
	<h2>BMR</h2>
    <?php 
			$today = getdate(); $year = (60*60*24*364.25);
			$difference = ($today[0] - strtotime($height['User']['age'] ) );
			$age = $difference / $year ;
			$age = floor($age);
			
			echo $form->input('age', array('id' => 'ageBMR', 'label' => 'age', 'value' => $age));
			echo $form->input('weight', array('id' => 'weightBMR', 'label' => 'Weight('.$weight['Body']['units'].')', 'value' => $weight['Body']['weight']));
			if($metricLength == 1){
				echo $form->input('height', array('id' => 'heightBMR', 'label' => 'Height(cm)', 'value' => $height['User']['height']));	
			}else{
				echo '<br/>';
				$feet = array('3' =>'3', '4' => '4','5'=>'5','6'=>'6','7'=>'7');
				$inches  = array('0', '1', '2', '3', '4' ,'5', '6', '7', '8', '9', '10', '11');
				echo '<div class = "height">';
				echo '<label id = "height">Height</label>';
				echo $form->input('heightFoot', array('type'=>'select', 'label'=> false, 'options' => $feet, 'id' => 'feetBMR', 'div' => false, 'value' => $height['User']['heightFoot']));
				echo ' ft. ';
				
				echo $form->input('heightInch', array('type'=>'select', 'label' =>false, 'options' => $inches, 'id' => 'inchesBMR', 'div' => false, 'value' => $height['User']['heightInch']));
				echo ' in. ';
				echo '</div>';
				echo '<br/>';
			}
			if($metricMass == 1){
				if($height['User']['sex'] == 'Male'){
					$BMR = ($weight['Body']['weight'] * 10 ) + ($height['User']['height'] * 6.25) - ($age * 5.0) + 5;
					$idealBMR = (($weight['Body']['weight']-10) * 10 ) + ($height['User']['height'] * 6.25) - ($age * 5.0) + 5;
				}else{
					$BMR = ($weight['Body']['weight'] * 10 ) + ($height['User']['height'] * 6.25) - ($age * 5.0) -161;
					$idealBMR = (($weight['Body']['weight']-10) * 10 ) + ($height['User']['height'] * 6.25) - ($age * 5.0) -161;
				}
			}else{
				if($height['User']['sex'] == 'Male'){
					$BMR = (($weight['Body']['weight']/2.2) * 10 ) + ($height['User']['height'] * 6.25) - ($age * 5.0) + 5;
					$idealBMR = ((($weight['Body']['weight']-22)/2.2) * 10 ) + ($height['User']['height'] * 6.25) - ($age * 5.0) + 5;
				}else{
					$BMR = (($weight['Body']['weight']/2.2) * 10 ) + ($height['User']['height'] * 6.25) - ($age * 5.0) -161;
					$idealBMR = ((($weight['Body']['weight']-22)/2.2) * 10 ) + ($height['User']['height'] * 6.25) - ($age * 5.0) -161;
				}
			}
			echo $form->input('weightIdeal', array('id' => 'weightIdealBMR', 'label' => 'Ideal Weight('.$weight['Body']['units'].')', 'value' => $weight['Body']['weight']-10));?>
            <div id = 'BMR'>Your Basal Metabolic Rate is:  <?php echo $BMR;?></div>
            <div id = 'IdealBMR'>Your Ideal Basal Metabolic Rate is: <?php echo $idealBMR;?></div>
</div>

<div class = 'panel'>
	<h2>Bodyfat</h2>
	 <?php if($metricLength == 1){
			echo $form->input('height', array('id' => 'heightBF', 'label' => 'Height('.$weight['Body']['units2'].')', 'value' => $height['User']['height']));
	 }else{
			echo '<br/>';
			echo '<div class = "height">';
			echo '<label id = "height">Height</label>';
			echo $form->input('heightFoot', array('type'=>'select', 'label'=> false, 'options' => $feet, 'id' => 'feetBF', 'div' => false, 'value' => $height['User']['heightFoot']));
			echo ' ft. ';
			
			echo $form->input('heightInch', array('type'=>'select', 'label' =>false, 'options' => $inches, 'id' => 'inchesBF', 'div' => false, 'value' => $height['User']['heightInch']));
			echo ' in. ';
			echo '</div>';
			echo '<br/>';
	 }
			echo $form->input('waist', array('id' => 'waistBF', 'label' => 'Waist('.$weight['Body']['units2'].')', 'value' => $weight['Body']['waist']));
			echo $form->input('neck', array('id' => 'neckBF', 'label' => 'Neck('.$weight['Body']['units2'].')', 'value' => $weight['Body']['neck']));
			if($height['User']['sex'] == 'Female'){
					echo $form->input('hips', array('id' => 'hipsBF', 'label' => 'Hips('.$weight['Body']['units2'].')', 'value' => $weight['Body']['hips']));
					$bf = 163.205*log10($weight['Body']['waist']+$weight['Body']['hips']-$weight['Body']['neck'])-97.684*log10($height['User']['height'])-104.912;
				}else{
					$bf = 86.010*log10($weight['Body']['waist']-$weight['Body']['neck'])-70.041*log10($height['User']['height'])+30.30;
				}?>
        <div id = 'bodyfat'>Bodyfat: <?php if($height['User']['height'] != null && $weight['Body']['waist'] != null && $weight['Body']['neck'] != null) {echo round($bf,1);}?>%</div>
        <br/>
</div>

<div class = 'panel'>
	<div class  = 'metricMass' id = '<?php echo $metricMass;?>'></div>
    <div class  = 'metricLength' id = '<?php echo $metricLength;?>'></div>
	<h2>BMI</h2>
    <?php if($weight['Body']['weight'] != null && $height['User']['height'] != null){?>
    		<?php  if ($metricMass == 1){?>
    			<?php $metricBMI = $weight['Body']['weight'] / pow(($height['User']['height']/100),2);?>
        	<?php }else{
					$metricBMI = ($weight['Body']['weight']/2.2) / pow(($height['User']['height']/100),2);	
			}?>
    <?php }else{
			$metricBMI = 1;
		}?>
     <?php if ($metricBMI < 16){
				$category = 'Severely underweight';
			}elseif ($metricBMI >16 && $metricBMI <=18.5) {
				$category = 'Underweight';
			}elseif ($metricBMI > 18.5 && $metricBMI <= 25){
				$category = 'Normal';
			}elseif ($metricBMI > 25 && $metricBMI <=30){
				$category = 'Overweight';	
			}elseif ($metricBMI > 30 && $metricBMI <=35){
				$category = 'Obese Class I';	
			}elseif ($metricBMI >35 && $metricBMI <=40) {
				$category = 'Obese Class II';	
			}elseif ($metricBMI >40){
				$category = 'Obese Class III';	
			}?>
            
    <?php echo $form->input('weight', array('label' => 'Weight('.$weight['Body']['units'].')', 'value' => $weight['Body']['weight']));
  		  if($metricLength == 1){
    			echo $form->input('height', array('label' => 'Height(cm)', 'value' => $height['User']['height']));
		  }else{
				echo '<br/>';
				echo '<div class = "height">';
				echo '<label id = "height">Height</label>';
				echo $form->input('heightFoot', array('type'=>'select', 'label'=> false, 'options' => $feet, 'id' => 'feet', 'div' => false, 'value' => $height['User']['heightFoot']));
				echo ' ft. ';
				
				echo $form->input('heightInch', array('type'=>'select', 'label' =>false, 'options' => $inches, 'id' => 'inches', 'div' => false, 'value' => $height['User']['heightInch']));
				echo ' in. ';
				echo '</div>';
				echo '<br/>';
		  }?>
       
        <div id = 'BMI'>Your BMI is: <?php echo round($metricBMI,2);?></div>
        <br/>
    	<div id = 'result'>This is considered: <?php echo $category;?></div>
</div>