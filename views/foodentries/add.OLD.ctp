<h2>Add daily meals!</h2>
<?php 
	$test = array();
	$count = 0;
	$user_id = $this->Session->read('User.id');
	foreach ($foods as $item){
		$test[$foods[$count]['Food']['id']] = $foods[$count]['Food']['name'];
		$count++;
	}
	echo $form->create('Foodentry', array('action' =>'add'));
	echo $this->Form->hidden('dailydiet_id', array('value' => $dailydiets['Dailydiet']['id']));
	echo $this->Form->hidden('user_id', array('value' => $user_id));
	echo $form->input('food_id', array('type'=>'select', 'options'=> $test));
	echo $form->input('quantity');
	echo $form->end('Submit');
	?>