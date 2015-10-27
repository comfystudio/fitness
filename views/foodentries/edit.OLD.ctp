<h2>edit daily meals!</h2>
<?php 
	$test = array();
	$count = 0;
	
	foreach ($foods as $item){
		$test[$foods[$count]['Food']['id']] = $foods[$count]['Food']['name'];
		$count++;
	}
	echo $form->create('Foodentry', array('action' =>'edit'));
	echo $this->Form->hidden('user_id', array('value' =>$this->Session->read('User.id')));
	echo $form->input('food_id', array('type'=>'select', 'options'=> $test));
	echo $form->input('quantity');
	echo $form->end('Submit');
	?>