 <div class = 'bmr-content' id = 'tools-content_<?php echo $user['User']['sex']?>'>
 <div class = 'check-metric-length' id = 'length-metric_<?php echo $user['User']['metricLength']?>'></div>
 <div class = 'check-metric-mass' id = 'mass-metric_<?php echo $user['User']['metricMass']?>'></div>
 	<?php
		echo $form->input('age', array('id' => 'age', 'label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Age...'));
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
		
		if($user['User']['metricMass'] == 1){
			echo $form->input('weight', array('id' => 'weight', 'label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Weight(kg)...'));
			echo $form->input('idealWeight', array('id' => 'idealWeight', 'label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Ideal Weight(kg)...'));
		}else{
			echo $form->input('weight', array('id' => 'weight', 'label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Weight(lb)...'));
			echo $form->input('idealWeight', array('id' => 'idealWeight', 'label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Ideal Weight(lb)...'));
		}
		
    ?>
 </div>
 
 <div class = 'tools-results'>
 	<div>Your Basal Metabolic Rate is: <p id = 'bmr'></p></div>
    <div>Your Ideal Basal Metabolic Rate is:<p id = 'idealbmr'></p></div>
 </div>