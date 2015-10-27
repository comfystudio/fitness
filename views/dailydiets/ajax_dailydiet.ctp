<div class = 'dailydiet-wrapper'>
	<a name = "dailydiet"> </a>
	<div class = 'dailydiet-add'><img src="../../webroot/img/add-food.png"></div>
    <div class = 'dailydiet-frequent'>
        <p>Frequent Foods</p>
        <?php 
			$frequentFood = $this->requestAction('dailydiets/getFrequent/');
			foreach ($frequentFood as $frequent){
				 echo '<a id = "food-select_'.$frequent['Food']['id'].'" class = "food-select">'
						.$frequent['Food']['name'].
					'</a>' ;
			}
        ?>
    </div>
    
     <div class = 'dailydiet-search'>
    	<?php
            echo $form->input('search', array('id' => 'SearchFoods', 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Search Foods by name...', 'label' => false));
        ?>
    
    	<div class = 'dailydiet-search-ajax'></div>
    </div>
    
      <div class = 'dailydiet-manual'>
        <div class = 'dailydiet-category'>
            <p>Select Category</p>
            <a class = 'category-select' id = 'category-select_0'>Meats</a>
            <a class = 'category-select' id = 'category-select_1'>Poultry</a>
            <a class = 'category-select' id = 'category-select_2'>Dairy & Egg</a>
            <a class = 'category-select' id = 'category-select_3'>Fish</a>
            <a class = 'category-select' id = 'category-select_4'>Beans, Peas, Nuts</a>
            <a class = 'category-select' id = 'category-select_5'>Fats, Oils, Dressings</a>
            <a class = 'category-select' id = 'category-select_6'>Breads & Baked Goods</a>
            <a class = 'category-select' id = 'category-select_7'>Pasta & Grains</a>
            <a class = 'category-select' id = 'category-select_8'>Fruits & Juices</a>
            <a class = 'category-select' id = 'category-select_9'>Vegetables</a>
            <a class = 'category-select' id = 'category-select_10'>Beverages</a>
            <a class = 'category-select' id = 'category-select_11'>Cake, Cookies, Pastries</a>
            <a class = 'category-select' id = 'category-select_12'>Snacks & Sweets</a>
            <a class = 'category-select' id = 'category-select_13'>Your Foods</a>
            <?php echo $this->Form->input('select', array('type' => 'hidden', 'id' => 'food-selected') ); ?>
        </div>
        
        <div class = 'dailydiet-subcategory'>
        	<p>Select Subcategory</p>
            
            <?php
				echo $this->Form->input('select', array('type' => 'hidden', 'value' => 99, 'id' => 'subcategory-selected') );
				$options = array('Meat with Starch', 'Frozen Meals', 'Gravies from Meat', 'Organ Meats', 'Other Meat', 'Sausages', 'Meat with Vegetables', 'Lunchmeats, Frankfurters', 'Beef ', 'Meat Sandwiches', 'Pork', '99' => 'All'); 
				echo $this->Form->input('subcategory', array('type' => 'radio', 'options' => $options, 'value' => 99, 'id' => 'subcategory-select') ); 
			?>
        
        </div>
        
        <div class = 'dailydiet-results-ajax'></div>
     </div>
     
      <form id = "food-form" action="/dailydiets/save/<?php echo $date?>" method="post">
            <div class = 'dailydiet-dailydiet'>
            	<?php
				if(isset($dailydiet['Foodentry'])){
					foreach($dailydiet['Foodentry'] as $foodentry){
						//pr($foodentry);die;
						$food = $this->requestAction('dailydiets/getFood/'.$foodentry['food_id']);
						echo '<div class = "meal-set" id = "meal-set_'.$foodentry['id'].'">';
						echo $form->input('food_id', array('type' => 'hidden', 'label' => false, 		'value' => $food['Food']['id'] ,			'name' => 'data['.$foodentry['id'].'][Foodentry][food_id]'));
						echo $form->input('id', array('type' => 'hidden', 'label' => false, 			'value' => $foodentry['id'],				'name' => 'data['.$foodentry['id'].'][Foodentry][id]'));
						echo $form->input('dailydiet_id', array('type' => 'hidden', 'label' => false, 	'value' => $foodentry['dailydiet_id'],		'name' => 'data['.$foodentry['id'].'][Foodentry][dailydiet_id]'));
						echo $form->input('food_type', array('type' => 'hidden', 'label' => false, 		'value' => $food['Food']['type'],			'name' => false, 	'id' => 'food-type_'.$foodentry['id']));
						echo $form->input('food_protein', array('type' => 'hidden', 'label' => false, 	'value' => $food['Food']['protein'],		'name' => false,	 'id' => 'food-protein_'.$foodentry['id']));
						echo $form->input('food_carbs', array('type' => 'hidden', 'label' => false, 	'value' => $food['Food']['carbs'],			'name' => false, 	'id' => 'food-carbs_'.$foodentry['id']));
						echo $form->input('food_fat', array('type' => 'hidden', 'label' => false, 		'value' => $food['Food']['fat'], 			'name' => false, 	'id' => 'food-fat_'.$foodentry['id']));
						echo $form->input('food_fibre', array('type' => 'hidden', 'label' => false, 	'value' => $food['Food']['fibre'], 			'name' => false,	'id' => 'food-fibre_'.$foodentry['id']));
						echo $form->input('food_calories', array('type' => 'hidden', 'label' => false, 	'value' => $food['Food']['calories'],		'name' => false, 	'id' => 'food-calories_'.$foodentry['id']));
						echo $form->input('food_value', array('type' => 'hidden', 'label' => false, 	'value' => $food['Food']['default_value'], 	'name' => false,	'id' => 'food-value_'.$foodentry['id']));
						
						
						echo '<p>'.$food['Food']['name'].'</p><a onclick="return confirm(\'are you sure?\')" class = "delete-food-old" id = "delete-food-old_'.$foodentry['id'].'">Delete Exercise</a>';
						echo '<p class = "meal-default">Default - '.$food['Food']['default_label'].'</p>';
						if($food['Food']['type'] == 0){
							if($this->Session->read('User.metricMass') == 1){
								$placeholder = 'grams ';
								$value = round($foodentry['quantity'],1);
							}else{
								$placeholder = 'ounze ';
								$value = round(($foodentry['quantity'] * 0.0353),1);
							}
						}else{
							if($this->Session->read('User.metricVolume') == 1){
								$placeholder = 'litre ';
								$value = round($foodentry['quantity'],1);
							}else{
								$placeholder = 'pint ';
								$value = round(($foodentry['quantity'] * 1.76),1);
							}
						}
						echo $form->input('quantity', array('id' => 'quantity_'.$foodentry['id'], 'class' => 'textbox', 'value' => $value,'label' => $placeholder, 'placeholder' => 'quantity...', 'name' => 'data['.$foodentry['id'].'][Foodentry][quantity]'));
						echo '
								<p class = "nutrition-info">Protein: <a id = "protein-value_'.$foodentry['id'].'"></a></p>
								<p class = "nutrition-info">Carbohydrates: <a id = "carbohydrates-value_'.$foodentry['id'].'"></a></p>
								<p class = "nutrition-info">Fat: <a id = "fat-value_'.$foodentry['id'].'"></a></p>
								<p class = "nutrition-info">Fibre: <a id = "fibre-value_'.$foodentry['id'].'"></a></p>
								<p class = "nutrition-info">Calories: <a id = "calories-value_'.$foodentry['id'].'"></a></p>
							';
					echo '</div>';	
					}
				}
				?>
            	<div class = 'dailydiet-dailydiet-ajax'></div>
            </div>
            
            <div class = 'nutrition-total'>
            <?php
				echo '
					<p class = "total-nutrition-info">Total Protein: 			<a id = "total-protein-value"></a></p>
					<p class = "total-nutrition-info">Total Carbohydrates: 		<a id = "total-carbohydrates-value"></a></p>
					<p class = "total-nutrition-info">Total Fat: 				<a id = "total-fat-value"></a></p>
					<p class = "total-nutrition-info">Total Fibre: 				<a id = "total-fibre-value"></a></p>
					<p class = "total-nutrition-info">Total Calories: 			<a id = "total-calories-value"></a></p>
				';
				
				echo $form->input('note', array('rows' => '1', 'type' => 'text', 'class' => 'textarea', 'value' => $dailydiet['Dailydiet']['note'], 'label' => false, 'placeholder' => 'Add notes...', 'name' => 'data[0][Foodentry][note]'));
            ?>
            </div>
           <div class = "error-message"></div> 
           <div class = 'submit'>
          	<input type="image" src="/img/save.png" />
          </div>
       </form>
</div>