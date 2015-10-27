<h2>Edit Comment</h2>
<?php
	echo $form->create('Comment', array('controller'=>'comments', 'action' => 'edit'));
	echo $form->input('text', array('rows' => '3'));
	echo $form->input('id', array('type'=>'hidden'));
	echo $form->end('Save Comment');

?>