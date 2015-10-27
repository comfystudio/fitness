<?php
	echo '<div class = "meal-set" id = "meal-set_'.$foodentryID.'">';
		echo $form->input('food_id', array('type' => 'hidden', 'label' => false, 'value' => $food['Food']['id'] ,'name' => 'data['.$foodentryID.'][Foodentry][food_id]'));
		echo $form->input('food_type', array('type' => 'hidden', 'label' => false, 'value' => $food['Food']['type'], 'id' => 'food-type_'.$foodentryID));
		echo $form->input('food_protein', array('type' => 'hidden', 'label' => false, 'value' => $food['Food']['protein'], 'id' => 'food-protein_'.$foodentryID));
		echo $form->input('food_carbs', array('type' => 'hidden', 'label' => false, 'value' => $food['Food']['carbs'], 'id' => 'food-carbs_'.$foodentryID));
		echo $form->input('food_fat', array('type' => 'hidden', 'label' => false, 'value' => $food['Food']['fat'], 'id' => 'food-fat_'.$foodentryID));
		echo $form->input('food_fibre', array('type' => 'hidden', 'label' => false, 'value' => $food['Food']['fibre'], 'id' => 'food-fibre_'.$foodentryID));
		echo $form->input('food_calories', array('type' => 'hidden', 'label' => false, 'value' => $food['Food']['calories'], 'id' => 'food-calories_'.$foodentryID));
		echo $form->input('food_value', array('type' => 'hidden', 'label' => false, 'value' => $food['Food']['default_value'], 'id' => 'food-value_'.$foodentryID));
		
		
		echo '<p>'.$food['Food']['name'].'</p><a onclick="return confirm(\'are you sure?\')" class = "delete-food" id = "delete-food_'.$foodentryID.'">Delete Exercise</a>';
		echo '<p class = "meal-default">Default - '.$food['Food']['default_label'].'</p>';
		if($food['Food']['type'] == 0){
			if($this->Session->read('User.metricMass') == 1){
				$placeholder = 'grams ';
				$value = round($food['Food']['default_value'],1);
			}else{
				$placeholder = 'ounze ';
				$value = round(($food['Food']['default_value'] * 0.0353),1);
			}
		}else{
			if($this->Session->read('User.metricVolume') == 1){
				$placeholder = 'litre ';
				$value = round($food['Food']['default_value'],1);
			}else{
				$placeholder = 'pint ';
				$value = round(($food['Food']['default_value'] * 1.76),1);
			}
		}
		echo $form->input('quantity', array('id' => 'quantity_'.$foodentryID, 'class' => 'textbox', 'value' => $value,'label' => $placeholder, 'placeholder' => 'quantity...', 'name' => 'data['.$foodentryID.'][Foodentry][quantity]'));
		echo '
				<p class = "nutrition-info">Protein: <a id = "protein-value_'.$foodentryID.'"></a></p>
				<p class = "nutrition-info">Carbohydrates: <a id = "carbohydrates-value_'.$foodentryID.'"></a></p>
				<p class = "nutrition-info">Fat: <a id = "fat-value_'.$foodentryID.'"></a></p>
				<p class = "nutrition-info">Fibre: <a id = "fibre-value_'.$foodentryID.'"></a></p>
				<p class = "nutrition-info">Calories: <a id = "calories-value_'.$foodentryID.'"></a></p>
			';
	echo '</div>';
?>