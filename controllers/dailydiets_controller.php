<?php  
App::import('Sanitize');
class DailydietsController extends AppController 
{ 
    var $name = "Dailydiets";
	
	
	function ajax_dailydiet($date){
		$date = Sanitize::clean($date);
		if (!$this->Session->read('User.id')){
			$this->Session->setFlash('You must be logged in to view this page');
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}else{
			$this->layout = 'ajax';
			$this->loadModel('Food');
			$frequents = $this->Dailydiet->find('first', array('conditions' => array('user_id' => $this->Session->read('User.id') ) ) );
			$dailydiet = $this->Dailydiet->find('first', array('conditions' => array('user_id' => $this->Session->read('User.id'), 'Dailydiet.created' =>$date) ) );
			$this->set(compact('frequents', 'date', 'dailydiet'));
		}
	}
	
	function ajax_addmeal($id = null, $date = null){
		$date = Sanitize::clean($date);
		$id = Sanitize::clean($id);
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}else{
			$this->autoRender = false;
			$this->loadModel('Food');
			$this->loadModel('Foodentry');
			$food = $this->Food->find('first', array('conditions' => array('Food.id' => $id) ) );
			$this->Foodentry->create();
			$this->Foodentry->save();
			$foodentryID = $this->Foodentry->getlastinsertid();
			$array['food'] = $food;
			$array['date'] = $date;
			$array['foodentryID'] = $foodentryID;
			return json_encode($array);
		}
		
	}
	
	/*function json_getFoodID(){
		//$this->loadModel('Foodentry');	
		$temp = $this->Dailydiet->find('first', array('order' => 'created DESC', 'conditions' => array('user_id' => $this->Session->read('User.id') ) ) );
		//$temp = $this->Foodentry->find('first', array('order' => 'Foodentry.created DESC', 'conditions' => array('user_id' => $this->Session->read('User.id') ) ) );
		pr($temp);die;
		return json_encode($foodentryID['Foodentry']['id']);
	}*/
	
	
	function ajax_results($category = 0, $subcategory = 99){
		$category = Sanitize::clean($category);
		$subcategory = Sanitize::clean($subcategory);
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}else{
			$this->layout = 'ajax';
			$this->loadModel('Food');
			if($category == 13){
				$results = $this->Food->find('all', array('fields' => array('DISTINCT Food.id', 'name'), 'recursive' => -1, 'conditions' => array('user_id' => $this->Session->read('User.id')) ) );
			}elseif($subcategory == 99){
				$results = $this->Food->find('all', array('fields' => array('DISTINCT Food.id', 'name'), 'recursive' => -1, 'conditions' => array('category' => $category, 'user_id' => '0') ) );
			}else{
				$results = $this->Food->find('all', array('fields' => array('DISTINCT Food.id', 'name'), 'recursive' => -1, 'conditions' => array('category' => $category, 'subcat' => $subcategory) ) );
			}
			$this->set(compact('results'));	
		}
	}
	
	function ajax_search($search = null){
		$search = Sanitize::clean($search);
		$this->loadModel('Food');
		$this->layout = 'ajax';
		$foods = $this->Food->find('all', array('fields' => array('Food.id', 'Food.name'), 'conditions' => array('name LIKE' => '%'.$search.'%', 'user_id' => 0) ) );
		$this->set(compact('foods'));
	}
	
	function getFrequent(){
		$this->loadModel('Food');
		$foods = array();
		$count = 0;
		$dailydiet = $this->Dailydiet->find('all', array('conditions' => array('user_id' => $this->Session->read('User.id')) ) );
		foreach ($dailydiet as $diet){
			foreach($diet['Foodentry'] as $foodentry){
				if($count <= 8){
					$food = $this->Food->find('first', array('conditions' => array('id' => $foodentry['food_id']) ) );
					
					if(isset($foods)){
						$counter = 0;
						foreach($foods as $fod){
							if($food['Food']['id'] == $fod['Food']['id']){
								$counter++;
							}
						}
						if($counter == 0){
							$foods[$count] = $food;
						}
					}
					
					$count = count($foods);
				}else{
					break(2);	
				}
			}
		}
		$this->set(compact('foods'));
		if (isset($this->params['requested'])) {
			return $foods;
		}
		return $foods;
	}
	
	function json_getEntry(){
		$this->autoRender = false;
		$dailyDiets = $this->Dailydiet->find('all', array('fields' => 'Dailydiet.created', 'recursive' => -1,  'conditions' => array('user_id' => $this->Session->read('User.id'))));
		echo json_encode($dailyDiets);	
	}
	
	function getFood($id = null){
		$id = Sanitize::clean($id);
		$this->loadModel('Food');
		$food = $this->Food->find('first', array('conditions' => array('Food.id' => $id) ) );
		if (isset($this->params['requested'])) {
			return $food;
		}
		return $food;
		
	}
	
	function ajax_deleteOldFood($id = null){
		$id = Sanitize::clean($id);
		$this->loadModel('Foodentry');
		$foodentry = $this->Foodentry->find('first', array('conditions' => array('Foodentry.id' => $id) ) );
		if($this->Session->read('User.id') == $foodentry['Dailydiet']['user_id']){
			$this->Foodentry->delete($id);
			$dailydiet = $this->Dailydiet->find('first', array('conditions' => array('Dailydiet.id' => $foodentry['Dailydiet']['id']) ) );
			$count  = count($dailydiet['Foodentry']);
			if($count == 0){
				$this->Dailydiet->delete($dailydiet['Dailydiet']['id']);	
			}
		}else{
			$this->Session->setFlash('You must be the correct user to delete this entry');
			$this->redirect($this->referer());	
		}
	}
	
	/*function index(){
		$user_id = $this->Session->read('User.id');
		if(empty($user_id)){
			$this->Session->setFlash('Your must be logged in to view Daily Diets index');
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}else{
			$dailydiets = $this->Dailydiet->find('all', array('conditions' => array('user_id' => $user_id ) ) );
		}
	}
	
	function ajax_mealstats($id = null, $quantity = null, $selected = null){
		$this->layout = 'ajax';
		$this->loadModel('Foodentry');
		$this->loadModel('Food');
		$this->set('id', $id);
		$foodT = $this->Food->find('first', array('conditions' => array('Food.id' => $selected)));
		$foodtype = $foodT['Food']['type'];
		if($foodtype == 1 && $this->Session->read('User.metricVolume') == 0){
			$convertQuantity = $quantity * 568.261485;
		}elseif($foodtype == 0 && $this->Session->read('User.metricMass') == 0){
			$convertQuantity = $quantity * 28.35;
		}else{
			$convertQuantity = $quantity;	
		}
		$this->set('quantity', $convertQuantity);
		$this->set('food', $this->Food->find('first', array('conditions' => array('Food.id' => $selected))));
		$this->set('metricVolume', $this->Session->read('User.metricVolume'));
		$this->set('metricMass', $this->Session->read('User.metricMass'));
		$this->set('foodtype', $foodtype);
	}
	
	function ajax_category($category = null, $id = null){
		$this->layout = 'ajax';
		//$this->loadModel('Food');
		$this->loadModel('Foodentry');
		//$this->set('foods', $this->Food->find('list', array('conditions' => array('category' => $category) ) ) );
		$temparray = array();	
		if($category == 0){
			$temparray = array(0 => 'Meat with Starch', 1 => 'Frozen Meals', 2 => 'Gravies from Meat', 3 => 'Organ Meats', 4 => 'Other Meat', 5 => 'Sausages', 6 => 'Meat with Starch Item and Vegetables', 7 => 'Lunchmeats, Frankfurters', 8 => 'Beef', 9 => 'Meat Sandwiches', 10 => 'Pork');	
		}elseif($category == 1){
			$temparray= array(11 => 'Other poultry', 12 => 'Frozen meals', 13 => 'Poultry in Gravy, Sauce or cream', 14 => 'Organ Meats and mixutres', 15 => 'Duck', 16 => 'Chicken', 17 => 'Turkey');	
		}elseif($category == 2){
			$temparray= array(18 => 'Flavoured milk and milk drinks', 19 => 'Milk based meal replacements', 20 => 'Ice cream, Pudding and milk desserts', 21 => 'Creams', 22 => 'Milk', 23 => 'Cheeses', 24 => 'Eggs', 25 => 'Yogurt');	
		}elseif($category == 3){
			$temparray= array(26 => 'Fish with Starch', 27 => 'Frozen Meals', 28 => 'Finfish', 29 => 'Shellfish');	
		}elseif($category == 4){
			$temparray= array(30 => 'Dried Beans, Mixtures', 31 => 'Carob Products', 32 => 'Seeds', 33 => 'Soybean Derived Products', 34 => 'Meat Substitutes', 35 => 'Nuts, nut butters, mixtures', 36 => 'Peas, Lentil mixture');	
		}elseif($category == 5){
			$temparray= array(37 => 'Salad Dressings', 38 => 'Fats', 39 => 'Oils');	
		}elseif($category == 6){
			$temparray= array(40 => 'Cakes', 41 => 'Wheat Breads, Rolls', 42 => 'Cookies', 43 => 'Quick Breads', 44 => 'Crackers, salty snacks', 45 => 'Pancakes, waffles, french toast', 46 => 'White breads, rolls');	
		}elseif($category == 7){
			$temparray= array(47 => 'Flower', 48 => 'Frozen Meals', 49 => 'Soups', 50 => 'Crackers', 51 => 'Breakfast Cereals', 52 => 'Pasta', 53 => 'Rice');	
		}elseif($category == 8){
			$temparray= array(54 => 'Fruit Mixtures', 55 => 'Non-Citrus fruit juices and mixtures', 56 => 'Dried fruits', 57 => 'Berries', 58 => 'Fruits', 59 => 'Citrus fruits and juices');	
		}elseif($category == 9){
			$temparray= array(60 => 'Dark Green Leafy Vegetables', 61 => 'Other Vegetables', 62 => 'Vegetable soups');	
		}elseif($category == 10){
			$temparray= array(63 => 'fruitades and drinks', 64 => 'Alcoholic beverages', 65 => 'Tea', 66 => 'Coffee', 67 => 'soft drinks');	
		}elseif($category == 11){
			$temparray= array(68 => 'Cobblers, Eclairs, Turnovers, Other Pastries', 69 => 'Doughnuts, Danishes, Granola Bars, Breakfast pastries', 70 => 'Cakes', 71 => 'Cookies', 72 => 'Pies');	
		}elseif($category == 12){
			$temparray= array(73 => 'Gelatin Deserts or salads', 74 => 'sugar and sugar substitutes', 75 => 'popsicles', 76 => 'candies and gum', 77 => 'jellies, jams and preserves', 78 => 'syrups, honey, molasses, sweet toppings');	
		}
		$this->set('subcategory', $temparray);
		$this->set('foodentry', $this->Foodentry->find('first', array('conditions' => array('Foodentry.id' => $id) ) ) );
	}
	
	function ajax_subcategory($subcategory = null, $id = null){
		$this->layout = 'ajax';
		$this->loadModel('Food');
		$this->loadModel('Foodentry');
		$this->set('foods', $this->Food->find('list', array('conditions' => array('subcat' => $subcategory) ) ) );	
		$this->set('foodentry', $this->Foodentry->find('first', array('conditions' => array('Foodentry.id' => $id) ) ) );
	}
	
	function ajax_activity_remove($id = null){
		$this->autoRender = false;
		$this->loadModel('Activity');
		$deleteActivity = $this->Activity->find('first', array('conditions' => array('Activity.id' => $id)));
		if (!empty($deleteActivity ) ){
			$activity_id = $deleteActivity['Activity']['id'];
			$this->Activity->delete($activity_id);	
		}
		
	}
	
	function ajax_foodentry_remove($id = null){
		$this->autoRender = false;
		$this->loadModel('Foodentry');
		$deleteFoodentry = $this->Foodentry->find('first', array('conditions' => array('Foodentry.id' => $id) ) );
		if (!empty($deleteFoodentry) ){
			$foodentry_id = $deleteFoodentry['Foodentry']['id'];
			$this->Foodentry->delete($foodentry_id);	
		}
	}
	
	function ajax_foodentry_add($id = null){
		$this->layout = 'ajax';
		$this->loadModel('Foodentry');
		$this->loadModel('Food');
		$test = $this->Foodentry->find('all', array('conditions' => array('dailydiet_id' => $id)));
		$count = count($test) +1;
		$newFoodentry = array('Foodentry' => array('dailydiet_id' => $id));
		$this->Foodentry->save($newFoodentry);
		$foodentryId = $this->Foodentry->getInsertID();
		$this->set('foodentry', $this->Foodentry->find('first', array('conditions' => array('Foodentry.id' => $foodentryId) ) ) );
		$this->set('foods', $this->Food->find('list'));
		$this->set('foodentryId', $foodentryId);
		$this->set('id', $id);
		$this->set('count', $count);
	}
	
	function ajax_view($date = null){
		$this->layout = 'ajax';
		$this->loadModel('Food');	
		$this->set('foods', $this->Food->find('list'));
		$this->set('food', $this->Food->find('all'));
		
		$start = strtotime ( $date );
		$end = $start + ( 24 * 60 * 60 ) -1;
		$range = array ( 
			"Dailydiet.created >= " => date( "Y-m-d H:i:s", $start ),
            "Dailydiet.created <= " => date( "Y-m-d H:i:s", $end ),
			'user_id' => $this->Session->read('User.id')
		);
		$dailydiets = $this->Dailydiet->find( 'all', array( 'conditions' => $range ) );
		$this->set ( compact ( "dailydiets" ) );
		
	}
	
	function ajax_adddailydiet ($date = null){
		$this->layout =  'ajax';
		$this->loadModel('Foodentry');
		$this->loadModel('Food');
		$this->set('foods', $this->Food->find('list'));
		$this->set('food', $this->Food->find('all'));
		$dailydiets = array();
		
		
		if ( !empty ( $this->data ) ) {
				$newDailydiet = array ( 'Dailydiet' => $this->data );
				
				if ( $this->Dailydiet->save( $newDailydiet ) ) {
					$id = $this->Dailydiet->getInsertID();
					$newFoodentry = array('Foodentry' => array('dailydiet_id' => $id));
					$this->Foodentry->save($newFoodentry);
					$dailydiets = $this->Dailydiet->find('all', array( 'conditions' => array ( 'Dailydiet.id' => $id ) ) );
				}
		}
		$this->set ( compact ( "dailydiets" ) );
		$this->render("ajax_view");
	}*/
	
	function volumeConvert($convert = null, $variable = null){
		if ($convert == 0){
			$imperial =  $variable * 1.76;
			return $imperial;	
		} else {
			$metric =  $variable * 	0.5683;
			return $metric;	
		}
	}
	
	function massConvert($convert = null, $variable = null){
		if ($convert == 0){
			$imperial =  $variable * 0.0353;
			return $imperial;	
		} else {
			$metric =  $variable * 	28.35;
			return $metric;
		}
	}
	
	function save ($date = null) {
		//saves multiple foodentries
		$date = Sanitize::clean($date);
		$this->loadModel( "Foodentry" );
		$this->loadModel('Food');
		$count = 0;
		$note = '';
		if ( !empty ( $this->data ) ) {
			ksort($this->data);
			$this->data = Sanitize::clean($this->data);
			foreach ( $this->data as $foodentry ) {
				if(isset($foodentry['Foodentry']['note'])){
					$note = $foodentry['Foodentry']['note'];
					continue;
				}
				
				if($count == 0){
					if(isset($foodentry['Foodentry']['dailydiet_id'])){
						$dailydiet_ID = $foodentry['Foodentry']['dailydiet_id'];
						$this->Dailydiet->id = $dailydiet_ID;
						$this->Dailydiet->saveField('note', $note);
					}else{
						$this->Dailydiet->create();
						$DailydietData = array('Dailydiet' => array('user_id' => $this->Session->read('User.id'), 'created' => $date, 'note' => $note));
						$this->Dailydiet->save($DailydietData);
						$dailydiet_ID = $this->Dailydiet->getInsertID();
						$foodentry['Foodentry']['dailydiet_id'] = $dailydiet_ID;
					}
					$count++;
				}
				if(isset($foodentry['Foodentry']['id'])){
					$this->Foodentry->id = $foodentry['Foodentry']['id'];
				}
				
				$food = $this->Food->find('first', array('conditions' => array('Food.id' => $foodentry['Foodentry']['food_id']) ) );
				if ($this->Session->read('User.metricMass') == 0){
					if ($food['Food']['type'] == 0){
						$foodentry['Foodentry']['quantity'] = $this->massConvert(1,$foodentry['Foodentry']['quantity']);
					}
				}
				if($this->Session->read('User.metricVolume') == 0){
					if($food['Food']['type'] == 1){
						$foodentry['Foodentry']['quantity'] = $this->volumeConvert(1,$foodentry['Foodentry']['quantity']);
					}
				}
				if($foodentry['Foodentry']['quantity'] != 0){
					$foodentry['Foodentry']['dailydiet_id'] = $dailydiet_ID;
					$this->Foodentry->save ( $foodentry );
				}else{
					$this->Foodentry->delete($foodentry['Foodentry']['id']);
				}
			}
			//Delete all empty foodentries
			$this->deleteFoodEntries();
		}
		$dailydiet = $this->Dailydiet->find('first', array('conditions' => array('Dailydiet.id' => $dailydiet_ID)));
		if($dailydiet['Dailydiet']['new'] == 0){
			$this->createPost($date);
		}
		$this->Session->setFlash('Your daily diet has been saved');
		$this->redirect($this->referer());
	}
	
	function deleteFoodEntries(){
		$this->loadModel('Foodentry');
		$foodentries = $this->Foodentry->find('all', array('recursive' => -1));
		foreach ($foodentries as $foodentry){
			
			if(!isset($foodentry['Foodentry']['quantity']) || empty($foodentry['Foodentry']['quantity']) || $foodentry['Foodentry']['quantity'] == 0){
				$this->Foodentry->delete($foodentry['Foodentry']['id']);
			}
		}
	}
	
	function createPost($date = null){
		$this->loadModel('Post');
		$dailydiets = $this->Dailydiet->find('first', array('conditions' => array('Dailydiet.created' => $date, 'user_id' => $this->Session->read('User.id')) ) );
		$this->Dailydiet->id = $dailydiets['Dailydiet']['id'];
		$this->Dailydiet->saveField('new', 1);
		$this->Post->create();
		$newData['Post']['user_id'] = $this->Session->read('User.id');
		$string = '<p style = "color:#272824"><strong>Added Diet!</strong></p><br/>';
		foreach ($dailydiets['Foodentry'] as $dailydiet){
			$food = $this->getFood($dailydiet['food_id']);
			$string = $string.'<p style = "color:#272824"><strong>'.$food['Food']['name'].'</strong></p>';
			$string = $string.'<p class = "createPost">';
				if($food['Food']['type'] == 0){
					$string = $string.round($dailydiet['quantity'],1).' grams <br/>';
				}else{
					$string = $string.round($dailydiet['quantity'],1).' litre <br/>';
				}
				$string = $string.'<strong>Protein:</strong> '.round($dailydiet['quantity'] * $food['Food']['protein'],1)		.'<a style = "float:right;margin-right:150px;"><strong>Carbs:</strong> '.round($dailydiet['quantity'] * $food['Food']['carbs'],1).'</a> <br/>';
				$string = $string.'<strong>Fat:</strong> '.round($dailydiet['quantity'] * $food['Food']['fat'],1)				.'<a style = "float:right;margin-right:150px;"><strong>Fibre:</strong> '.round($dailydiet['quantity'] * $food['Food']['fibre'],1).'</a> <br/>';
				$string = $string.'<strong>Calories:</strong> '.round($dailydiet['quantity'] * $food['Food']['calories'],1)	.' <br/><br/>';
				
			$string = $string.'</p>';
			
		}
		if(isset($dailydiets['Dailydiet']['note'])){
			$string = $string.'<br/><strong>Note: </strong>'.$dailydiets['Dailydiet']['note'].' <br/><br/>';
		}
		$newData['Post']['body'] = $string;
		$this->Post->save($newData);	
	}
	
	/*function delete($id = null) {
		$this->loadModel('Foodentry');
		$foodentries = $this->Foodentry->find('all', array('conditions' => array('dailydiet_id' => $id ) ) );
		$user_id = $this->Session->read('User.id');
		$dailydiet_userid = $this->Dailydiet->read('user_id');
		if (!$this->Session->read('User.id') || $user_id != $dailydiet_userid['Dailydiet']['user_id']) {
			$this->Session->setFlash('You must be logged in as the correct user to delete this daily diet');
			$this->redirect(array('controller' => 'posts', 'action'=>'index'));
		} else {
			foreach($foodentries as $item) {
				$foodentries_id = $item['Foodentry']['id'];
				$this->Foodentry->delete($foodentries_id);
			}
			$this->Dailydiet->delete($id);
			$this->Session->setFlash('The Daily diet has been deleted');
			$this->redirect(array('controller'=>'dailydiets', 'action'=>'index'));
		}
	}*/
}
?>