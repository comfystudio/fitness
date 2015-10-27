<?php
	echo $form->create('User', array('action' => 'setting'));
		echo '<div class = "setting-input">';
			echo $this->Form->hidden('id', array('value' => $this->Session->read('User.id')));
			echo '<div class = "notifications-sub">';
				echo $form->input('hideProfile', array('type'=>'checkbox', 'label' => 'Hide profile', 'checked' => $users['User']['hideProfile']));
				echo $form->input('hidePublic', array('type'=>'checkbox', 'label' => 'Only followers can see your posts', 'checked' => $users['User']['hidePublic']));
			echo '</div>';
		echo '</div>';
	echo $form->end('save.png');
?>
<div class = 'select-delete'>
	<a class = 'select-delete-click'><img src="../../webroot/img/delete-profile.png"></a>
</div>
<div class = 'settings-delete-profile' style="display:none">
	<?php
		
		
		echo $form->create('User', array('action' => 'deleteProfile', 'autocomplete' => 'off'));
			echo '<div class = "setting-input">';
				echo '<div id = "flashMessage">Warning deleting your profile is completely irreversible! Dont leave us!</div>';
				echo $this->Form->hidden('id', array('value' => $this->Session->read('User.id')));
				echo $form->input('username', array('class' => 'textbox', 'label' => false ));
				echo $form->input('passworddelete', array('type' => 'password','label' => false, 'class' => 'textbox'));
				echo $form->input('fakepassworddelete', array('class' => 'textbox', 'label' => false));
			echo '</div>';
		echo $form->end('delete.png');
		
	?>
</div>