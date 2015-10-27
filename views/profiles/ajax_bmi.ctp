 <div class = 'bmr-content' id = 'tools-content_<?php echo $user['User']['sex']?>'>
 <div class = 'check-metric-length' id = 'length-metric_<?php echo $user['User']['metricLength']?>'></div>
 <div class = 'check-metric-mass' id = 'mass-metric_<?php echo $user['User']['metricMass']?>'></div>
 	<?php
		if($user['User']['metricMass'] == 1){
			echo $form->input('weight', array('id' => 'weight', 'label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Weight(kg)...'));
		}else{
			echo $form->input('weight', array('id' => 'weight', 'label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Weight(lb)...'));
		}
		
		if($user['User']['metricLength'] == 1){
			echo $form->input('height', array('id' => 'height', 'label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Height(cm)...'));
		}else{
			$feet = array('3' =>'3', '4' => '4','5'=>'5','6'=>'6','7'=>'7');
			$inches  = array('0', '1', '2', '3', '4' ,'5', '6', '7', '8', '9', '10', '11');
			echo '<div class = "heightFeet">';
				echo $form->input('heightFoot', array('type'=>'select', 'label'=> false, 'options' => $feet, 'id' => 'feet', 'div' => false));
				echo ' ft. ';
				
				echo $form->input('heightInch', array('type'=>'select', 'label' =>false, 'options' => $inches, 'id' => 'inches', 'div' => false));
				echo ' in. ';
			echo '</div>';
		}
	
		/*if($user['User']['metricLength'] == 1){
			echo $form->input('height', array('id' => 'height', 'label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Height(cm)...'));
			echo $form->input('waist', array('id' => 'waist', 'label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Waist(cm)...'));
			echo $form->input('neck', array('id' => 'neck', 'label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Neck(cm)...'));
			if($user['User']['sex'] == 'Female'){
				echo $form->input('hips', array('id' => 'hips', 'label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'hips(cm)...'));
			}
			
		}else{
			$feet = array('3' =>'3', '4' => '4','5'=>'5','6'=>'6','7'=>'7');
			$inches  = array('0', '1', '2', '3', '4' ,'5', '6', '7', '8', '9', '10', '11');
			echo '<div class = "heightFeet">';
				echo $form->input('heightFoot', array('type'=>'select', 'label'=> false, 'options' => $feet, 'id' => 'feet', 'div' => false));
				echo ' ft. ';
				
				echo $form->input('heightInch', array('type'=>'select', 'label' =>false, 'options' => $inches, 'id' => 'inches', 'div' => false));
				echo ' in. ';
			echo '</div>';
			echo $form->input('waist', array('id' => 'waist', 'label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Waist(in)...'));
			echo $form->input('neck', array('id' => 'neck', 'label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Neck(in)...'));
			if($user['User']['sex'] == 'Female'){
				echo $form->input('hips', array('id' => 'hips', 'label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'hips(in)...'));
			}
		}	*/
    ?>
 </div>
 
 <div class = 'tools-results-bmi'>
 	<div>Your BMI is: <p id = 'bmi'></p></div>
    <div>This is considered: <p id = 'considered'></p></div>
 </div>