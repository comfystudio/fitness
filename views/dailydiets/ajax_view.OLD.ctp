<?php 
$totalprotein = 0;
$totalcarbs = 0;
$totalfat = 0;
$totalfibre = 0;
$totalcalories = 0;
$count = 0;?>
<?php foreach ($dailydiets as $key => $dailydiet){?>

	<div class = 'diet'>
     <?php echo $html->link('X', array('controller' => 'dailydiets', 'action' => 'delete', $dailydiet['Dailydiet']['id']), array('title' => 'delete daily diet'), "are you sure?")?>
     <br/>
     <br/>
         <div class = 'meals'>
                <p class = 'add' id = '<?php echo $dailydiet['Dailydiet']['id']?>'>+ add Meal</p>
         </div>
     <br/>
     <br/>
    <?php foreach($dailydiet['Foodentry'] as $foodentry){?>
    <?php $count++;?>
    	  <?php if($foodentry['food_id']-1 == -1){
							$offset = 0;
					}else{
							$offset = 1;
					}?>
    	<div class="foodentry">
       
		
		
			<p class = 'mealLabel'>Meal <?php echo $count;?></p>
				<input type="hidden" name="data[<?php echo $foodentry['id']; ?>][Foodentry][id]" value="<?php echo $foodentry['id']; ?>" />
				<input type="hidden" name="data[<?php echo $foodentry['id']; ?>][Foodentry][dailydiet_id]" value="<?php echo $foodentry['dailydiet_id']; ?>" />
			<div class = 'foodCategory'>
            	<?php $foodcategories = array('Meat', 'Poultry', 'Dairy and Egg', 'Fish', 'Bean, Pea & Nuts', 'Fat, Oil & Dressing', 'Bread & Baked Goods', 
			   								'Pasta & Grain', 'Fruit & Juice', 'Vegetable', 'Beverage', 'Cake & Cookie', 'Snacks & Sweets');
                   	echo $this->Form->input('food_category', array('options' => $foodcategories, 'label' => false, 'div' => false, 'class' => 'food_category', 'id' => 'foodCategory_'.$foodentry['id']));?>
            </div>
            
            <div class = 'foodSubcategory' id = 'foodSubcategory_<?php echo $foodentry['id']?>'></div>
            <div class = 'foodSelect' id = 'foodSelect_<?php echo $foodentry['id']?>'></div>
            <?php //pr($foods);die;?>
               
               <?php //echo $this->Form->input('food_id', array('options' => $foods, 'label' => false, 'div' => false, 'value' => $foodentry['food_id'], 'class' => 'food_id', 'id' => 'foodid_'.$foodentry['id'], 'name' =>'data['.$foodentry['id'].'][Foodentry][food_id]' ));?> 
            <div id = 'foods'></div>
			<div class = 'quantity' id = 'quantity_<?php echo $foodentry['id']?>' >
				<input type="text" class='FoodentryQuantity' id='FoodentryQuantity_<?php echo $foodentry['id'];?>' name="data[<?php echo $foodentry['id']; ?>][Foodentry][quantity]" 
                value="<?php //if($this->Session->read('Metric') == 0){
							if($foodentry['quantity'] == 0){
								echo $food[$foodentry['food_id'] -$offset]['Food']['default_value'];
							}else{
								
								if($food[$foodentry['food_id'] -$offset]['Food']['type'] == 0 &&  $this->Session->read('User.metricMass') == 0){
									echo round(($foodentry['quantity'] * 0.0353),3);
								}elseif($food[$foodentry['food_id'] -$offset]['Food']['type'] == 1 && $this->Session->read('User.metricVolume') == 0){ 
									echo round(($foodentry['quantity'] * 0.00175975326),3);
								}else{ 
									echo round(($foodentry['quantity']),3);
								}
							}?>" />
			</div>
            <?php if($food[$foodentry['food_id']-$offset]['Food']['type'] == 0){
					if($this->Session->read('User.metricMass') == 1){?>
						 <div class = 'type' id = "type_<?php echo $foodentry['id']?>">grams(g)</div>
				<?php }else{ ?>
						<div class = 'type' id = "type_<?php echo $foodentry['id']?>">ounce(oz)</div>
				<?php }
			}else{
				if($this->Session->read('User.metricVolume') == 1){?>
						<div class = 'type' id = "type_<?php echo $foodentry['id']?>">millilitres(mL)</div>
				<?php }else{ ?>
						<div class = 'type' id = "type_<?php echo $foodentry['id']?>">pint(pt)</div>
				<?php }
				
			}?>
			<div class = 'delete'>
				<a class = 'delete' id = '<?php echo $foodentry['id']?>'>X</a>
			</div>
            
            <div class = 'food-label'>
            	<p><?php echo $food[$foodentry['food_id'] -$offset]['Food']['default_label']?></p>
            </div>
           
           	<div id = 'foodId'><?php echo $foodentry['id'];?></div>
            <div class = 'mealstats' id = 'mealstats_<?php echo $foodentry['id'];?>'>
            	<ul>
                    <li class = 'singleList' id = 'protein<?php echo $foodentry['id']?>'>Protein: <?php echo $protein = round($foodentry['quantity'] * $food[$foodentry['food_id'] -$offset]['Food']['protein'],1 )?></li>
                    <li class = 'singleList' id = 'carbs<?php echo $foodentry['id']?>'>Carbs: <?php echo $carbs = round($foodentry['quantity'] * $food[$foodentry['food_id']-$offset]['Food']['carbs'],1 )?></li>
                    <li class = 'singleList' id = 'fat<?php echo $foodentry['id']?>'>Fat: <?php echo $fat = round($foodentry['quantity'] * $food[$foodentry['food_id']-$offset]['Food']['fat'],1 )?></li>
                    <li class = 'singleList' id = 'fibre<?php echo $foodentry['id']?>'>Fibre: <?php echo $fibre =round($foodentry['quantity'] * $food[$foodentry['food_id']-$offset]['Food']['fibre'],1 )?></li>
                    <li class = 'singleList' id = 'calories<?php echo $foodentry['id']?>'>Calories: <?php echo $calories =round($foodentry['quantity'] * $food[$foodentry['food_id']-$offset]['Food']['calories'],1 )?></li>
                </ul>
            </div>
		</div>
        <?php 
			$totalprotein = $totalprotein + $protein;
			$totalcarbs = $totalcarbs + $carbs;
			$totalfat = $totalfat + $fat;
			$totalfibre = $totalfibre + $fibre;
			$totalcalories = $totalcalories + $calories; ?>
        <?php }?>
        <div id = 'addFoodentry<?php echo $dailydiet['Dailydiet']['id']?>'>
        	<div class = 'singleFoodentry' id = 'singleFoodentry0'>
            </div>
        </div>
     	<div class = 'totals' id = 'totals'>
        	<ul>
            	<li id = 'totalprotein'>Total Protein: <?php echo $totalprotein;?></li>
                <li id = 'totalcarbs'>Total Carbs: <?php echo $totalcarbs;?></li>
                <li id = 'totalfat'>Total Fat: <?php echo $totalfat;?></li>
                <li id = 'totalfibre'>Total Fibre: <?php echo $totalfibre;?></li>
                <li id = 'totalcalories'>Total Calories: <?php echo $totalcalories;?></li>
            </ul>
        </div>
    </div>	
	
	
<?php }?>