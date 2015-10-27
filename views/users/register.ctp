<?php echo $this->element('login-left'); ?>
    
    <div class = 'right-shadow'>
        <div class = 'right-nav-content'>
        	<?php echo $this->Session->flash(); ?>
        		<div class = 'login'>
                    <h2 id = 'h2-register'>Register</h2>     
                    <?php echo $form->create('User', array('action' => 'register', 'autocomplete' => 'off'));
							  //echo $form->input('forname', array('class' => 'textbox', 'label' => false));
							  //echo $form->input('surname', array('class' => 'textbox', 'label' => false));
							  echo $form->input('username', array('class' => 'textbox', 'label' => false, 'value' => 'Username...'));
							  echo $form->input('fakepassword', array('class' => 'textbox', 'label' => false, 'value' => 'Password...'));
							  echo $form->input('password', array('class' => 'textbox', 'label' => false));
							  echo $form->input('email', array('class' => 'textbox', 'label' => false, 'value' => 'Email...'));
							  echo '<div class = "link-submit">';
								echo $form->submit('register.png');
							  echo '</div>';
                          echo $form->end();
                    ?>
                 </div>
           </div>
    </div>
</div>
