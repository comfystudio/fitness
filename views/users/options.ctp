<h1 class = 'manager-h1 gold light'>In the red need to restart? Delete you're manager!</h1>

<div class = 'belts-filter'>
<?php
		echo $this->Form->create('User', array('users/options/'.$this->Session->read('User.manager_id'), 'autocomplete' => 'off'));
		 		echo $this->Form->hidden('id', array('value' => $this->Session->read('User.manager_id')));
		 		echo $this->Form->input('username', array('placeholder' => 'Username...', 'value' => '', 'default' => ''));
				echo $this->Form->input('password', array('type' => 'password', 'placeholder' => 'Password...', 'value' => '', 'default' => ''));
				echo $this->Form->submit('delete.png', array('class' => 'left'));
		echo $this->Form->end();

?>
</div>