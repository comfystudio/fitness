<?php
	echo $form->create('User', array('action' => 'setting'));
		echo '<div class = "setting-input">';
			echo $this->Form->hidden('id', array('value' => $this->Session->read('User.id')));
			echo '<div class = "notifications-sub">';
				echo $form->input('notification_type1', array('type'=>'checkbox', 'label' => 'Recieve notifications for messages', 'checked' => $users['User']['notification_type1']));
				echo $form->input('notification_type2', array('type'=>'checkbox', 'label' => 'Recieve notifications for comments', 'checked' => $users['User']['notification_type2']));
				echo $form->input('notification_type3', array('type'=>'checkbox', 'label' => 'Recieve notifications for followers', 'checked' => $users['User']['notification_type3']));
				echo $form->input('notification_type4', array('type'=>'checkbox', 'label' => 'Recieve notification for likes', 'checked' => $users['User']['notification_type4']));
			echo '</div>';
		echo '</div>';
	echo $form->end('save.png');
?>