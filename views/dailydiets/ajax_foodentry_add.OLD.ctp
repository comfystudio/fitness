<div class="foodentry">
<?php if($this->Session->read('User.metricVolume') == 1){?>
	<div class = 'type' id = "type_<?php echo $foodentryId?>">millilitres(mL)</div>
<?php }else{?>
	<div class = 'type' id = "type_<?php echo $foodentryId?>">pint(pt)</div>
<?php }?>
	
	<p class = 'mealLabel'>Meal <?php echo $count;?></p>
        <input type="hidden" name="data[<?php echo $foodentryId; ?>][Foodentry][id]" value="<?php echo $foodentryId; ?>" />
        <input type="hidden" name="data[<?php echo $foodentryId; ?>][Foodentry][dailydiet_id]" value="<?php echo $id; ?>" />
    <div class = 'foodSelect'>
       <?php echo $this->Form->input('food_id', array('options' => $foods, 'label' => false, 'div' => false, 'value' => ''.$foodentry['Foodentry']['food_id'],  'class' => 'food_id', 'id' => 'foodid_'.$foodentryId, 'name' =>'data['.$foodentryId.'][Foodentry][food_id]' ));?> 
    </div>
    <div class = 'quantity'>
        <input type="text" class='FoodentryQuantity' id='FoodentryQuantity_<?php echo $foodentryId;?>' name="data[<?php echo $foodentryId; ?>][Foodentry][quantity]" value="<?php echo $foodentry['Foodentry']['quantity']; ?>" />
    </div>
    <div class = 'delete'>
        <a class = 'delete' id = '<?php echo $foodentryId?>'>X</a>
    </div>
   
    <div id = 'foodId'><?php echo $foodentryId;?></div>
    <div class = 'mealstats' id = 'mealstats_<?php echo $foodentryId;?>'>
        <ul>
            <li class = 'singleList' id = 'protein<?php echo $foodentryId?>'>Protein: 0</li>
            <li class = 'singleList' id = 'carbs<?php echo $foodentryId?>'>Carbs: 0</li>
            <li class = 'singleList' id = 'fat<?php echo $foodentryId?>'>Fat: 0</li>
            <li class = 'singleList' id = 'fibre<?php echo $foodentryId?>'>Fibre: 0</li>
            <li class = 'singleList' id = 'calories<?php echo $foodentryId?>'>Calories: 0</li>
        </ul>
    </div>
</div>