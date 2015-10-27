<?php 
	echo $this->Form->input('food_id', array('options' => $foods, 'label' => false, 'div' => false, 'value' => $foodentry['Foodentry']['food_id'], 'class' => 'food_id', 'id' => 'foodid_'.$foodentry['Foodentry']['id'], 'name' =>'data['.$foodentry['Foodentry']['id'].'][Foodentry][food_id]' ));
?>