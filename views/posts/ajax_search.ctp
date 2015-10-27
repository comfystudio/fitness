<div class = 'social-search-border'> 
<div class = 'view-user' id = 'view-user_<?php echo $this->Session->read('User.id')?>'></div> 
    <div class = 'social-search'>
        <?php
			echo '<div class = "error-message"></div>';
            echo $form->input('body', array('id' => 'PostBody', 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Search for users...', 'label' => false));
        ?>
    </div>
</div>
<div class = 'social-content-search' id = 'social-content-search-id'>

</div>
  