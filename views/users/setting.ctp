<?php echo $this->element('home-left'); ?>
<?php echo $this->Html->script('settings.js');?>

<div class = 'home-right-shadow'>
            <div class = 'right-nav-content'>
            <?php echo $this->Session->flash(); ?>
           		<div class = 'setting-header'>
                	<ul>
                    	<li class = 'li-active' id = "settings-general">General</li>
                        <li id = "settings-password">Password</li>
                        <li id = "settings-notifications">Notifications</li>
                        <li id = "settings-privacy">Privacy</li>
                    </ul>
                </div>
                <div class = 'setting-content'>
                <?php
                    echo $form->create('User', array('action' => 'setting'));
					echo '<div class = "setting-input">';
						echo $this->Form->hidden('id', array('value' => $this->Session->read('User.id')));
						echo $form->input('forname', array('label' => false, 'class' => 'textbox'));
						echo $form->input('surname', array('label' => false, 'class' => 'textbox'));
						echo $form->input('hideName', array('type'=>'checkbox', 'label' => 'Hide my name'));
						echo '<div class = "setting-sub">';
							//echo $form->input('newusername', array('label' => false, 'class' => 'textbox', 'value' => $users['User']['username']));
							echo $form->input('email', array('label' => false, 'class' => 'textbox'));
							echo $form->input('sex', array('type'=>'select', 'label' => false ,'options'=> array('Male' =>'Male', 'Female'=>'Female')));
							echo $form->input('hideHeight', array('type'=>'checkbox', 'label' => 'Hide my Height'));
							if($users['User']['metricLength'] == 1){
								echo $form->input('height', array('label' => false, 'class' => 'textbox', 'value' => $users['User']['height']));
							}else{
								$feet = array('3' =>'3', '4' => '4','5'=>'5','6'=>'6','7'=>'7');
								$inches  = array('0', '1', '2', '3', '4' ,'5', '6', '7', '8', '9', '10', '11');
								//echo '<div class = "height">';
								echo $form->input('heightFoot', array('type'=>'select', 'label'=> false, 'options' => $feet, 'id' => 'feet', 'div' => false));
								echo ' ft. ';
								
								echo $form->input('heightInch', array('type'=>'select', 'label' =>false, 'options' => $inches, 'id' => 'inches', 'div' => false));
								echo ' in. ';
								//echo '</div>';
								//echo '<br/>';
							}
							echo $form->input('hideAge', array('type'=>'checkbox', 'label' => 'Hide my Age'));
							
							
							//echo '<br/>';
							/*echo '<label>Metric Settings</label>';
							echo $form->input('metricLength', array('type'=>'checkbox', 'label' => 'use metric system for length (cm)'));
							echo $form->input('metricVolume', array('type'=>'checkbox', 'label' => 'use metric system for volume (ml)'));
							echo $form->input('metricMass', array('type'=>'checkbox', 'label' => 'use metric system for mass (kg)'));
							echo '<br/>';
							echo '<label>Notification Settings</label>';
							echo $form->input('notification_type1', array('type'=>'checkbox', 'label' => 'Recieve notifications for messages'));
							echo $form->input('notification_type2', array('type'=>'checkbox', 'label' => 'Recieve notifications for comments'));
							echo $form->input('notification_type3', array('type'=>'checkbox', 'label' => 'Recieve notifications for followers'));
							echo $form->input('notification_type4', array('type'=>'checkbox', 'label' => 'Recieve notification for likes'));
							echo '<br/>';*/
							
							//echo $form->input('age', array('id' => 'age'));
							echo $this->Form->input('age', array( 'label' => false
																, 'dateFormat' => 'DMY'
																, 'minYear' => date('Y') - 80
																, 'maxYear' => date('Y') - 10 ));
							echo  '<br/>';
							echo $form->input('hideLocation', array('type'=>'checkbox', 'label' => 'Hide my Location'));
							echo $form->input('location', array('label' => false, 'class' => 'textbox'));
							
							echo '<div class = "metric">';
							echo $form->input('metricLength', array('type'=>'checkbox', 'label' => 'use metric system for length (cm)'));
							echo $form->input('metricVolume', array('type'=>'checkbox', 'label' => 'use metric system for volume (l)'));
							echo $form->input('metricMass', array('type'=>'checkbox', 'label' => 'use metric system for mass (kg)'));
							echo '</div>';
							
							echo $form->input('about' , array('label' => false, 'class' => 'textarea'));
							
							/*echo '<h2>If you wish to change your password</h2>';
							echo $form->input('Current password', array('type' => 'password'));
							echo $form->input('New password', array('type' => 'password'));*/
							echo '</div>';
						echo '</div>';
						echo $form->end('save.png');
                ?>
                </div>
                
                
  			</div>
        </div>
	</div>
</div> 
