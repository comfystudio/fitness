<div class = 'home-progress-option' id = 'home-progress-option_<?php echo $id?>'>
	<?php
		$options2 = array('All', 'Year', 'Month', 'Week');
		if(isset($message)){
			echo '<div id = "flashMessage">'.$message.'</div>';	
		}else{
			echo $form->input('option', array('type'=>'select', 'label'=> 'Select Option', 'options' => $options, 'div' => false));
			if($id != 1){
				echo $form->input('filter', array('type'=>'select', 'label'=> 'Filter Time Frame', 'options' => $options2, 'div' => false));
			}
		}
	?>
</div>

<div class = 'home-progress-graph'>
	<div id="chart_div"></div>
    <div id="total-calories"></div>

</div>