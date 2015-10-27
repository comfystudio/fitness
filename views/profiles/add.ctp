<h2>Update Your Stats</h2>
<?php
	echo $form->create('Profile', array('action' => 'add'));
	echo $this->Form->hidden('user_id', array('value' => $this->Session->read('User.id')));
	if (empty($user_profiles)){
		echo $form->input('sex', array('type'=>'select', 'options'=> array('M' =>'Male', 'F'=>'Female')));
	}
	echo $form->input('height');
	echo $form->input('age');
	echo $form->input('weight');
	echo $form->input('bodyfat');
	echo $form->input('location');
	echo $form->input('about', array('rows' => '3'));
	echo $form->input('chest');
	echo $form->input('arms');
	echo $form->input('hips');
	echo $form->input('waist');
	echo $form->input('thighs');
	echo $form->input('forearms');
	echo $form->input('calves');
	echo $form->input('shoulders');
	echo $form->input('neck');
	//echo $form->input('bench');
	//echo $form->input('squat');
	//echo $form->input('deadlift');
	//echo $form->input('curl');
	//echo $form->input('rows');
	//echo $form->input('press');
	//echo $form->input('mile');
	echo $form->end('Save Post');
?>