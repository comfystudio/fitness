<!-- File: /app/views/posts/add.ctp -->    
    
<h2>Add Post</h2>
<?php
	
	echo $form->create('Post', array('action' => 'add'));
	echo $form->input('title');
	echo $form->input('body', array('rows' => '3'));
	//echo $this->element('attachment', array('field' => 'image'));
	echo $form->file('attachment');
	echo $form->end('Save Post');
	
	//echo $form->labelTag('File/image', 'Image');  
    //echo $html->file('File/image');  
	
	/*echo $form->create('Post', array('type' => 'file', 'url' => '/'.$this->params['url']['url']));
	echo $form->create('Post', array('type' => 'file'));
	echo $form->input('title');
	echo $form->input('body', array('rows' => '3'));
	echo $form->file('image');
	echo $form->end('Save Post');*/
	
?>