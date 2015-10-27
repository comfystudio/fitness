<?php echo $this->element('login-left'); ?>
    
    <div class = 'right-shadow'>
        <div class = 'right-nav-content'>
        	<?php echo $this->Session->flash(); ?>
        		<div class = 'login'>
                    <h2 id = 'h2-reset-password'>Reset Password</h2>    
                    <?php 
                          echo $form->create('User', array('action' => 'forgot'));
							  echo $form->input('username', array('class' => 'textbox', 'label' => false, 'value' => 'Username...'));
							  echo $form->input('email', array('class' => 'textbox', 'label' => false, 'value' => 'Email...'));
							  echo '<div class = "link-submit">';
							 	 echo $form->submit('reset.png');
							  echo '</div>';
							  echo $form->end();
                    ?>
       			 </div>
           </div>
    </div>
</div> 
