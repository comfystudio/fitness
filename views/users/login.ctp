<?php echo $this->element('login-left'); ?>
    
    <div class = 'right-shadow'>
        <div class = 'right-nav-content'>
        	<?php echo $this->Session->flash(); ?>
        		<div class = 'login'>
                    <h2 id = 'h2-login'>Login</h2>    
                    <?php 
                          //Login form
                          echo $form->create('User', array('action' => 'login', 'autocomplete' => 'off'));
							  echo $form->input('username', array('class' => 'textbox', 'label' => false, 'value' => 'Username...'));
							  echo $form->input('fakepassword', array('class' => 'textbox', 'label' => false, 'value' => 'Password...'));
							  echo $form->input('password', array('class' => 'textbox', 'label' => false));
							  echo '<div class = "link-submit">';
								  echo '<a class = "light-14" href = "users/forgot">Forgotten Your Password?</a>';
								  echo $form->submit('login.png');
							  echo '</div>';
                          echo $form->end();
                    ?> 
                </div>
           </div>
    </div>
</div>
