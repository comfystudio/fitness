<?php 

	echo $this->Form->input('food_subcategory', array('options'  => $subcategory, 'label' => false, 'div' => false, 'class' => 'food_subcategory', 'id' => 'foodSubcategorySelect_'.$foodentry['Foodentry']['id']));
	//echo $this->Form->input('food_id', array('options' => $foods, 'label' => false, 'div' => false, 'value' => $foodentry['Foodentry']['food_id'], 'class' => 'food_id', 'id' => 'foodid_'.$foodentry['Foodentry']['id'], 'name' =>'data['.$foodentry['Foodentry']['id'].'][Foodentry][food_id]' ));
?>