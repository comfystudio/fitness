<div class = 'home-progress-option' id = 'home-progress-option_<?php echo $id?>'>
	<?php
		if(isset($message)){
			echo '<div id = "flashMessage">'.$message.'</div>';	
		}else{
			echo $form->input('option', array('type'=>'select', 'label'=> 'Select Option', 'options' => $options, 'div' => false));
		}
	?>
</div>

<div class = 'home-progress-graph'>
	<div id="chart_div"></div>
    <div id="total-calories"></div>

</div>