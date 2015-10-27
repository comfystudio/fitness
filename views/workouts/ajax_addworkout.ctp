<?php
	echo '<div id = "workout-set_'.$exercise['Exercise']['id'].'" class = "workout-set">';
		echo '<p>'.$exercise['Exercise']['name'].'</p><a name = "'.$exercise['Exercise']['name'].'"></a><a name = "exercise_id'.$exercise['Exercise']['id'].'"></a><a onclick="return confirm(\'are you sure?\')" class = "delete-exercise" id = "delete-exercise_'.$exercise['Exercise']['id'].'">Delete Exercise</a>';
		echo '<a class = "left">Set 1</a>';
		echo $form->input('id', array('type' => 'hidden', 'label' => false, 'name' => 'data['.$exercise['Exercise']['id'].']['.$exercise['Exercise']['id'].'][Activity][id]'));
		echo $form->input('workout_id', array('type' => 'hidden', 'label' => false, 'name' => 'data['.$exercise['Exercise']['id'].']['.$exercise['Exercise']['id'].'][Activity][workout_id]'));
		echo $form->input('created', array('type' => 'hidden', 'label' => false, 'value' => $date, 'name' => 'data['.$exercise['Exercise']['id'].']['.$exercise['Exercise']['id'].'][Activity][created]'));
		if($exercise['Exercise']['type'] == 0){
			echo $form->input('reps', array('class' => 'textbox', 'label' => false, 'placeholder' => 'Reps', 'name' => 'data['.$exercise['Exercise']['id'].']['.$exercise['Exercise']['id'].'][Activity][reps]'));
			if($this->Session->read('User.metricMass') == 1){
				$placeholder = 'Weight (kg)';
			}else{
				$placeholder = 'Weight (lb)';
			}
			echo $form->input('value', array('class' => 'textbox', 'label' => false, 'placeholder' => $placeholder, 'name' => 'data['.$exercise['Exercise']['id'].']['.$exercise['Exercise']['id'].'][Activity][value]'));
		}else{
			echo $form->input('time', array('class' => 'textbox', 'label' => false, 'placeholder' => 'Time', 'name' => 'data['.$exercise['Exercise']['id'].']['.$exercise['Exercise']['id'].'][Activity][time]'));
			if($this->Session->read('User.metricLength') == 1){
				$placeholder = 'Kilometre  (km)';
			}else{
				$placeholder = 'Mile ';
			}
			echo $form->input('distance', array('class' => 'textbox', 'label' => false, 'placeholder' => $placeholder, 'name' => 'data['.$exercise['Exercise']['id'].']['.$exercise['Exercise']['id'].'][Activity][distance]'));
		}
		echo '<a class = "add-set" id = "add-set_'.$exercise['Exercise']['id'].'">Add Set +</a>';
		echo "<div id = 'add-set-js_".$exercise['Exercise']['id']."' class = 'add-set-js'></div>";
		echo $form->input('notes', array('rows' => '1', 'type' => 'text', 'class' => 'textarea', 'label' => false, 'placeholder' => 'Add notes...', 'name' => 'data['.$exercise['Exercise']['id'].']['.$exercise['Exercise']['id'].'][Activity][notes]'));
		echo "<div class = 'exercise-type' id = 'exercise-type_".$exercise['Exercise']['type']."'></div>";
	echo '</div>';
?>
	
	