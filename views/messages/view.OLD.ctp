<div class = 'panel'>
<?php
	echo $form->create('Message', array('url' => array('controller' => 'messages', 'action' => 'compose',$this->Session->read('User.id'))));
	//echo $this->Form->hidden('user_id', array('value' => $this->Session->read('User.id')));
	echo $form->input('From', array('label' => array('id' => 'from'), 'value' => $message['User']['username']));
	echo $form->input('To', array('label' => array('id' => 'to'), 'value' => $to['User']['username']));
	echo $form->input('title', array('label' => array('id' => 'title'),'value' => $message['Message']['title']));
	echo $form->input('content', array('label' => array('id' => 'content'), 'value' => $message['Message']['content']));
	//echo $form->end('Send Message');
?>

</div>