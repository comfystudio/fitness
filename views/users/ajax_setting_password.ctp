<?php
	echo $form->create('User', array('action' => 'setting'));
	echo '<div class = "setting-input">';
		echo $this->Form->hidden('id', array('value' => $this->Session->read('User.id')));
		echo $form->input('fakepassword', array('class' => 'textbox', 'label' => false, 'value' => 'Current Password...'));
		echo $form->input('Current password', array('type' => 'password','label' => false, 'class' => 'textbox'));
		echo $form->input('fakenewpassword', array('class' => 'textbox', 'label' => false, 'value' => 'New Password...'));
		echo $form->input('New password', array('type' => 'password','label' => false, 'class' => 'textbox'));
	echo '</div>';
	//echo '<div class = "password-sub">';	
		echo $form->end('save.png');
	//echo '</div>';
?>