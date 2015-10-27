<?php echo $this->Html->script('edit', FALSE);?>
<h2>Edit Stats</h2>
<div id='success'></div>
<?php
	$test = array();
	$count = 0;
	foreach ($user_profiles as $item) {
		$profile_id = $user_profiles[$count]['Profile']['id'];
		$test[ $profile_id ] = $user_profiles[$count]['Profile']['created'];
		$count++; 
	}
	//pr($test);die;
	echo $form->input('edit', array('type'=>'select', 'options'=>$test));
    echo $form->create('Profile', array('action' => 'edit'));
   	echo $this->Form->hidden('user_id', array('value' => $this->Session->read('User.id')));
	echo $form->input('height', array('id' => 'height'));
	echo $form->input('age', array('id' => 'age'));
	echo $form->input('weight', array('id' => 'weight'));
	echo $form->input('bodyfat', array('id' => 'bodyfat'));
	echo $form->input('location', array('id' => 'location'));
	echo $form->input('about', array('id' =>'about', 'rows' => '3'));
	echo $form->input('chest', array('id' => 'chest'));
	echo $form->input('arms', array('id' => 'arms'));
	echo $form->input('hips', array('id' => 'hips'));
	echo $form->input('waist', array('id' => 'waist'));
	echo $form->input('thighs', array('id' => 'thighs'));
	echo $form->input('forearms', array('id' => 'forearms'));
	echo $form->input('calves', array('id' => 'calves'));
	echo $form->input('shoulders', array('id' => 'shoulders'));
	echo $form->input('neck', array('id' => 'neck'));
	//echo $form->input('bench', array('id' => 'bench'));
	//echo $form->input('squat', array('id' => 'squat'));
	//echo $form->input('deadlift', array('id' => 'deadlift'));
	//echo $form->input('curl', array('id' => 'curl'));
	//echo $form->input('rows', array('id' => 'rows'));
	//echo $form->input('press', array('id' => 'press'));
	//echo $form->input('mile', array('id' => 'mile'));
	echo $this->Js->submit('Save Changes', array(
		'before'=>$this->Js->get('#sending')->effect('fadeIn'),
		'success'=>$this->Js->get('#sending')->effect('fadeOut'),
		'update'=>'#success'
	 ));
    echo $form->end();
?>
<div id = 'sending'>Sending.....</div>



