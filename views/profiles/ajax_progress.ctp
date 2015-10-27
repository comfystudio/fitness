
<div class = 'home-progress-select'>
	<?php
		$options = array('Workout', 'Food', 'Measurements');
		echo $form->input('type', array('type'=>'select', 'label'=> 'Select Type', 'options' => $options, 'div' => false));
		echo  '<p>Select a category you\'d like to see your progress in.</p>'
	
	?>
</div>

<div class = 'home-progress-ajax'>

</div>