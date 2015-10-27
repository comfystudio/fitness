 <?php
	echo $form->create('User', array('action' => 'setting'));
	echo '<div class = "setting-input">';
		echo $this->Form->hidden('id', array('value' => $this->Session->read('User.id')));
		echo $form->input('forname', array('label' => false, 'class' => 'textbox', 'value' => $users['User']['forname']));
		echo $form->input('surname', array('label' => false, 'class' => 'textbox', 'value' => $users['User']['surname']));
		echo $form->input('hideName', array('type'=>'checkbox', 'label' => 'Hide my name', 'checked' => $users['User']['hideName']));
		echo '<div class = "setting-sub">';
			//echo $form->input('newusername', array('label' => false, 'class' => 'textbox', 'value' => $users['User']['username']));
			echo $form->input('email', array('label' => false, 'class' => 'textbox', 'value' => $users['User']['email']));
			echo $form->input('sex', array('type'=>'select', 'label' => false ,'options'=> array('Male' =>'Male', 'Female'=>'Female'), 'default' => $users['User']['sex']));
			echo $form->input('hideHeight', array('type'=>'checkbox', 'label' => 'Hide my Height', 'checked' => $users['User']['hideHeight']));
			if($users['User']['metricLength'] == 1){
				echo $form->input('height', array('label' => false, 'class' => 'textbox', 'value' => $users['User']['height']));
			}else{
				$feet = array('3' =>'3', '4' => '4','5'=>'5','6'=>'6','7'=>'7');
				$inches  = array('0', '1', '2', '3', '4' ,'5', '6', '7', '8', '9', '10', '11');
				echo $form->input('heightFoot', array('type'=>'select', 'label'=> false, 'options' => $feet, 'id' => 'feet', 'div' => false, 'value' => $users['User']['heightFoot']));
				echo ' ft. ';
				
				echo $form->input('heightInch', array('type'=>'select', 'label' =>false, 'options' => $inches, 'id' => 'inches', 'div' => false, 'value' => $users['User']['heightInch']));
				echo ' in. ';
			}
			echo $form->input('hideAge', array('type'=>'checkbox', 'label' => 'Hide my Age', 'checked' => $users['User']['hideAge']));
			echo $this->Form->input('age', array( 'value' => $users['User']['age'], 'label' => false
												, 'dateFormat' => 'DMY'
												, 'minYear' => date('Y') - 80
												, 'maxYear' => date('Y') - 10 ));
			echo  '<br/>';
			echo $form->input('hideLocation', array('type'=>'checkbox', 'label' => 'Hide my Location', 'checked' => $users['User']['hideLocation']));
			echo $form->input('location', array('label' => false, 'class' => 'textbox', 'value' => $users['User']['location']));
			echo '<div class = "metric">';
			echo $form->input('metricLength', array('type'=>'checkbox', 'label' => 'use metric system for length (cm)', 'checked' => $users['User']['metricLength']));
			echo $form->input('metricVolume', array('type'=>'checkbox', 'label' => 'use metric system for volume (l)', 'checked' => $users['User']['metricVolume']));
			echo $form->input('metricMass', array('type'=>'checkbox', 'label' => 'use metric system for mass (kg)', 'checked' => $users['User']['metricMass']));
			echo '</div>';
			echo $form->input('about' , array('label' => false, 'class' => 'textarea', 'value' => $users['User']['about']));
			echo '</div>';
		echo '</div>';
	echo $form->end('save.png');
?>