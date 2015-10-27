<div class = 'tools-food-add'>
	<p id = 'food-header'>Create your own food, to be used in your journal.</p>
    <?php
		echo $form->create('Profile', array('action' => 'addFood'));
			echo $this->Form->hidden('user_id', array('value' => $this->Session->read('User.id')));
			echo $form->input('name', array('label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Name / Label...'));
			$options = array(0 => 'Solid', 1 => 'Liquid');
			//echo $form->input('type', array('type' => 'radio', $options));
			echo $this->Form->radio('type', $options, array('legend' => false));
			echo $form->input('default_value', array('label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Default Value...'));
			
			echo $form->input('food_type', array('type'=>'select', 'label' => 'Food Type' ,'options'=> array()));
			
			echo $form->input('default_label', array('label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Default label...'));
			echo '<p class = "food-notes">For example: Chicken breast (50 grams)</p>';
			echo $form->input('protein', array('div' => 'input text left', 'label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Protein...'));
			echo $form->input('carbs', array('div' => 'input text right','label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Carbohydrates...'));
			echo $form->input('fat', array('div' => 'input text left','label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Fats...'));
			echo $form->input('fibre', array('div' => 'input text right','label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Fibre...'));
			echo $form->input('calories', array('label' => false, 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Calories...'));
			echo '<p class = "food-notes">Add the above values based on the default value and type.</p>';
			echo '<div class = "error-message"></div>';
		echo $form->end('save.png');
	?>
</div>