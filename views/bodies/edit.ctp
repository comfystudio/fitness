<div class = 'journal-measure'>
<a name = "editMeasure"> </a>
<p class = 'left'>Edit Measurements</p> <?php echo $html->link('Delete Measurement', array('controller' => 'bodies', 'action' => 'delete',$id));?> 
	<?php 
        $user_id = $this->Session->read('User.id');
    
        echo $form->create('Body', array('action' =>'edit', $id));
			echo $this->Form->hidden('user_id', array('value' => $user_id));
			echo $this->Form->hidden('created', array('value' => $selectedDate));
			if ($this->Session->read('User.metricLength') == 1){
				if($this->Session->read('User.metricMass') == 1){
					echo $form->input('weight', array('id' => 'weight', 'placeholder' => 'weight (kg)', 'label' => 'weight (kg)', 'class' => 'textbox'));
				}else{
					echo $form->input('weight', array('id' => 'weight', 'placeholder' => 'weight (ib)', 'label' => 'weight (ib)', 'class' => 'textbox'));
				}
				echo $form->input('bodyfat', array('id' => 'bodyfat', 'placeholder' => 'bodyfat %', 'label' => 'bodyfat %', 'class' => 'textbox'));
				echo $form->input('chest', array('id' => 'chest', 'placeholder' => 'chest (cm)', 'label' => 'chest (cm)', 'class' => 'textbox'));
				echo $form->input('arms', array('id' => 'arms', 'placeholder' => 'arms (cm)', 'label' => 'arms (cm)', 'class' => 'textbox'));
				echo $form->input('hips', array('id' => 'hips', 'placeholder' => 'hips (cm)', 'label' => 'hips (cm)', 'class' => 'textbox'));
				echo $form->input('waist', array('id' => 'waist', 'placeholder' => 'waist (cm)', 'label' => 'waist (cm)', 'class' => 'textbox'));
				echo $form->input('thighs', array('id' => 'thighs', 'placeholder' => 'thighs (cm)', 'label' => 'thighs (cm)', 'class' => 'textbox'));
				echo $form->input('forearms', array('id' => 'forearms', 'placeholder' => 'forearms (cm)', 'label' => 'forearms (cm)', 'class' => 'textbox'));
				echo $form->input('calves', array('id' => 'calves', 'placeholder' => 'calves (cm)', 'label' => 'calves (cm)', 'class' => 'textbox'));
				echo $form->input('shoulders', array('id' => 'shoulders', 'placeholder' => 'shoulders (cm)', 'label' => 'shoulders (cm)', 'class' => 'textbox'));
				echo $form->input('neck', array('id' => 'neck', 'placeholder' => 'neck (cm)', 'label' => 'neck (cm)', 'class' => 'textbox'));
			}else {
				if($this->Session->read('User.metricMass') == 1){
					echo $form->input('weight', array('id' => 'weight', 'placeholder' => 'weight (kg)', 'label' => 'weight (kg)', 'class' => 'textbox'));
				}else{
					echo $form->input('weight', array('id' => 'weight', 'placeholder' => 'weight (ib)', 'label' => 'weight (ib)', 'class' => 'textbox'));
				}
				echo $form->input('bodyfat', array('id' => 'bodyfat', 'placeholder' => 'bodyfat %', 'label' => 'bodyfat %', 'class' => 'textbox'));
				echo $form->input('chest', array('id' => 'chest', 'placeholder' => 'chest (in)', 'label' => 'chest (in)', 'class' => 'textbox'));
				echo $form->input('arms', array('id' => 'arms', 'placeholder' => 'arms (in)', 'label' => 'arms (in)', 'class' => 'textbox'));
				echo $form->input('hips', array('id' => 'hips', 'placeholder' => 'hips (in)', 'label' => 'hips (in)', 'class' => 'textbox'));
				echo $form->input('waist', array('id' => 'waist', 'placeholder' => 'waist (in)', 'label' => 'waist (in)', 'class' => 'textbox'));
				echo $form->input('thighs', array('id' => 'thighs', 'placeholder' => 'thighs (in)', 'label' => 'thighs (in)', 'class' => 'textbox'));
				echo $form->input('forearms', array('id' => 'forearms', 'placeholder' => 'forearms (in)', 'label' => 'forearms (in)', 'class' => 'textbox'));
				echo $form->input('calves', array('id' => 'calves', 'placeholder' => 'calves (in)', 'label' => 'calves (in)', 'class' => 'textbox'));
				echo $form->input('shoulders', array('id' => 'shoulders', 'placeholder' => 'shoulders (in)', 'label' => 'shoulders (in)', 'class' => 'textbox'));
				echo $form->input('neck', array('id' => 'neck', 'placeholder' => 'neck (in)', 'label' => 'neck (in)', 'class' => 'textbox'));
			}
        echo $form->end('save.png');
    ?>
</div>