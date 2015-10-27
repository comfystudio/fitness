<div class = 'panel'>
<?php
	echo $form->create('Message', array('url' => array('controller' => 'messages', 'action' => 'compose',$this->Session->read('User.id'))));
	echo $this->Form->hidden('user_id', array('value' => $this->Session->read('User.id')));
	echo $form->input('To', array('label' => array('id' => 'to')));
	echo $form->input('title', array('label' => array('id' => 'title'),'value' => $title));
	echo $form->input('content', array('label' => array('id' => 'content'), 'value' => $content));
	echo $form->end('Send Message');
?>

</div>