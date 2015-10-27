<!-- File: /app/views/posts/edit.ctp -->
    
<h2>Edit Post</h2>
<?php
    echo $form->create('Post', array('action' => 'edit'));
    //echo $form->input('title');
    echo $form->input('body', array('rows' => '3'));
    echo $form->input('id', array('type'=>'hidden')); 
    echo $form->end('Save Post');
?>