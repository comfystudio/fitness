<?php
App::import('Sanitize');
class ProfilesController extends AppController{
	var $name = 'Profiles';
	var $helpers = array('Js' => array('Jquery'));
	var $components = array('RequestHandler');
	
	
	function ajax_progress(){
		header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}else{
			$this->layout = 'ajax';
		}
	}
	
	function ajax_graph($selected = null, $id = null){
		$id = Sanitize::clean($id);
		$selected = Sanitize::clean($selected);
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}else{
			//WORKOUT SELECTED
			if($id == 0){
				$this->loadModel('Workout');
				$workouts = $this->Workout->find('all', array('order' => 'Workout.created DESC', 'conditions' => array('exercise_id' => $selected, 'user_id' => $this->Session->read('User.id'))), $this->Session->read('User.metricMass'));
				$tempArray = array();
				$tempDate = array();
				$tempStat = array();
				$exerciseName = $this->requestAction('workouts/getExercise/'.$selected);
				$count = 1;
				
				$cols = array(array('id' => '','label' => 'date', 'pattern' => '', 'type' => 'date'));
				foreach($workouts as $workout){
					//$temp = count($workout['Activity']);
					//if($temp > $count){
						//$count = $temp;	
					//}
					if($count <= 20){
						foreach($workout['Activity'] as $activity){
							
							if($activity['value'] != 0){
								array_push($cols, array('id' => '','label' => 'Set '.($count).' '.$exerciseName['Exercise']['name'].' Reps x '.$activity['reps'].' Weight ', 'pattern' => '', 'type' => 'number'));
							}elseif($activity['distance'] !=0){
								array_push($cols, array('id' => '','label' => 'Set '.($count).' '.$exerciseName['Exercise']['name'].' '.$activity['time'].' to do ', 'pattern' => '', 'type' => 'number'));
							}
							$count++;
						}
					}
					//break;
				}
				/*$cols = array(array('id' => '','label' => 'date', 'pattern' => '', 'type' => 'date'), array('id' => '','label' => 'Set 1 '.$exerciseName['Exercise']['name'], 'pattern' => '', 'type' => 'number'));
				for($i = 1; $i <= $count-1; $i++){
					//array_push($cols, array('id' => '', 'role'=> 'tooltip', 'type' => 'string', 'p' => array('role'=>'tooltip')));
					array_push($cols, array('id' => '','label' => 'Set '.($i+1).' '.$exerciseName['Exercise']['name'], 'pattern' => '', 'type' => 'number'));
				}*/
				
				$count = 0;
				foreach ($workouts as $workout){
					$date = explode('-', $workout['Workout']['created']);
					$year = $date[0];
					$month = $date[1];
					$day = $date[2];
					$tempStat[$count] = array('c' => array(array('v' => 'Date('.$year.','.($month-1).','.$day.')') ) );
					foreach ($workout['Activity'] as $activity){
						if(isset($activity['value']) && $activity['value'] != 0.0){
							//array_push($tempStat[$count]['c'], array('v' => 'test'.round($activity['reps'],1)));	
							array_push($tempStat[$count]['c'], array('v' => round($activity['value'],1)));	
						}else{
							if($this->Session->read('metricLength') == 0){
								$activity['distance'] = round(($activity['distance'] * 0.6214),1);
							}
							array_push($tempStat[$count]['c'], array('v' => round($activity['distance'],1)));	
						}
						
					}
					$count++;
				}
				$tempArray['cols'] = $cols;
				$tempArray['rows'] = $tempStat;
				echo json_encode($tempArray);
				$this->autoRender = false;
				
			//DAILYDIET SELECTED
			}elseif($id == 1){
				$this->loadModel('Dailydiet');
				$dailydiet = $this->Dailydiet->find('first', array('conditions' =>  array('Dailydiet.id' => $selected) ) );
				$totals = $this->getDietTotals($dailydiet);
				$cols = array(array('id' => '', 'label' => '', 'pattern' => '', 'type' => 'string'), array('id' => '', 'label' => '', 'pattern' => '', 'type' => 'number'));
				$count = 0;
				foreach($totals[1] as $key => $total){
					$rows[$count] = array('c' => array(array('v' => $key), array('v' => $total)));
					$count++;
				}
				//$newRows = array_pop($rows);
				$array['cols'] = $cols;
				$array['rows'] = $rows;
				$array['total'] = $totals[2];
				echo  json_encode($array);
				$this->autoRender = false;
				
			//MEASUREMENT SELECTED
			}elseif($id == 2){
				$this->loadModel('Body');
				$body = $this->Body->find('all', array('order' => 'Body.created DESC', 'conditions' => array('user_id' => $this->Session->read('User.id'))),$this->Session->read('User.metricMass'), $this->Session->read('User.metricLength'));
				$count = 0;
				$tempArray = array();
				$tempDate = array();
				$tempStat = array();
				$year = 2000;
				$cols = array(array('id' => '','label' => 'date', 'pattern' => '', 'type' => 'date'), array('id' => '','label' => strtoupper($selected), 'pattern' => '', 'type' => 'number'));
				foreach ($body as $bod){
					$date = explode('-', $bod['Body']['created']);
					$year = $date[0];
					$month = $date[1];
					$day = $date[2];
					$dateString = 'Date('.$year.','.$month.','.$day.')';
					$tempStat[$count] = array('c' => array(array('v' => 'Date('.$year.','.($month-1).','.$day.')'), array('v' => floor($bod['Body'][$selected]) ) ) );
					$count++;
				}
				$tempArray['cols'] = $cols;
				$tempArray['rows'] = $tempStat;
				echo json_encode($tempArray);
				$this->autoRender = false;
			}
		}
	}
	
	function ajax_progress_type($id){
		$id = Sanitize::clean($id);
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}else{
			if($id == 0){
				$this->loadModel('Workout');
				$workout = $this->Workout->find('all', array('recursive' => -1, 'fields' => array('DISTINCT exercise_id'), 'conditions' => array('user_id' => $this->Session->read('User.id'))));
				$workout = Set::extract($workout, '/Workout/exercise_id');
				if(empty($workout)){
					$message = 'No workout data yet, Get training man!';
					$this->set(compact('id', 'message'));
					return;
				}
				$temp = array();
				foreach($workout as $key => $work){
					$exerciseName = $this->requestAction('workouts/getExercise/'.$work);
					$temp[$exerciseName['Exercise']['id']] = $exerciseName['Exercise']['name'];
				}
				if(!empty($temp)){
					$options = $temp;
					$this->set(compact('options', 'id'));	
				}
				
			}elseif($id == 1){
				$this->loadModel('Dailydiet');
				$dailydiet = $this->Dailydiet->find('list', array('fields' => array('Dailydiet.created'), 'conditions' => array('user_id' => $this->Session->read('User.id') ) ) );
				if(empty($dailydiet)){
					$message = 'No meals added yet, Grab a fork!';
					$this->set(compact('id', 'message'));
					return;
				}
				foreach($dailydiet as $key => $diet){
					$niceDate[$key] = date("F j, Y", strtotime($diet));
				}
				$options = $niceDate;
				$this->set(compact('options', 'id'));
				
			}elseif($id == 2){
				$this->loadModel('Body');
				$body = $this->Body->find('first', array('conditions' => array('user_id' => $this->Session->read('User.id')) ) );
				if(empty($body) || !isset($body['Body']['id'])){
					$message = 'No measurements added yet, Need some tape?';
					$this->set(compact('id', 'message'));
					return;
				}
				if(!empty($body)){
					$options = array('weight' => 'weight', 'bodyfat' => 'bodyfat', 'chest' => 'chest', 'arms' => 'arms', 'hips' => 'hips'
						, 'waist' => 'waist', 'thighs' => 'thighs', 'forearms' => 'forearms', 'calves' => 'calves', 'shoulders' => 'shoulders',
						'neck' => 'neck');
					$this->set(compact('options', 'id'));
				}
				
			}
			
		}
		
	}
	
	function ajax_pictures(){
		header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
		if(!$this->Session->read('User.id')){
			//$this->Session->setFlash('You must be logged in to view Pictures index.');
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}
		$this->layout = 'ajax';
		$user_id =  $this->Session->read('User.id');
		$this->loadModel('Picture');/*C:\wamp\www\fitness\webroot\img\uploads\users*/
		$temp = explode("fitness", __DIR__);
		$urlString = $temp[0].'fitness\webroot\img\uploads\users\\';
		$pictures = $this->Picture->find('all', array('conditions' => array('user_id' => $user_id) ) );	
		$totalSize = 0;
		foreach($pictures as $picture){
			$totalSize += filesize($urlString.$picture['Picture']['image']);
		}
		$this->set(compact('totalSize', 'pictures'));
		
	}
	
	function showMore($array = array(), $page_no = 0, $limit = 0){
		$page_no = Sanitize::clean($page_no);
		$limit = Sanitize::clean($limit);
		$page_no++;
		$limit = $limit * $page_no;
		$array = array_slice($array, 0, $limit, false);
		return $array;
	}
	
	
	function index($page_no = 0){
		$page_no = Sanitize::clean($page_no);
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}
		//pr($this->Session->read('User'));
		$this->loadModel('User');
		$this->loadModel('Like');
		$this->loadModel('Post');
		$user_id = $this->Session->read('User.id');
		$this->set('users', $this->User->find('first', array('conditions' => array('id' => $user_id) ) ) );
		$posts = $this->Post->find('all');
		$tempArray = array();
		$count2 = 0;
		foreach($posts as $post){
			$postUser = $this->User->find('first', array('conditions' => array('id' => $post['Post']['user_id'])));
			if($postUser['User']['hideProfile'] == 0 && $postUser['User']['hidePublic'] == 0 || $postUser['User']['id'] == $this->Session->read('User.id')){
				$tempArray[$count2] = $post;
				$count2++;	
			}
		}
		$this->set('likes', $this->Like->find('all'));
		$this->set('totalPosts', $tempArray);
		$tempArray = $this->showMore($tempArray, $page_no, 5);
		$this->set('page_no', $page_no);
		$this->set('posts', $tempArray);
	}
	
	function ajax_feed($page_no = 0){
		$page_no = Sanitize::clean($page_no);
		header('P3P:CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}
		$this->layout = 'ajax';
		$this->loadModel('User');
		$this->loadModel('Like');
		$this->loadModel('Post');
		$user_id = $this->Session->read('User.id');
		$this->set('users', $this->User->find('first', array('conditions' => array('id' => $user_id) ) ) );
		$posts = $this->Post->find('all');
		$tempArray = array();
		$count2 = 0;
		foreach($posts as $post){
			$postUser = $this->User->find('first', array('conditions' => array('id' => $post['Post']['user_id'])));
			if($postUser['User']['hideProfile'] == 0 && $postUser['User']['hidePublic'] == 0 || $postUser['User']['id'] == $this->Session->read('User.id')){
				$tempArray[$count2] = $post;
				$count2++;	
			}
		}
		$this->set('likes', $this->Like->find('all'));
		$this->set('totalPosts', $tempArray);
		$tempArray = $this->showMore($tempArray, $page_no, 5);
		$this->set('page_no', $page_no);
		$this->set('posts', $tempArray);
		
	}
	
	function ajax_manage(){
		$this->layout = 'ajax';	
		if(!$this->Session->read('User.id')){
			$this->redirect($this->referer());
		}else{
			$this->loadModel('Food');
			$foodlist = $this->Food->find('list', array('conditions' => array('user_id' => $this->Session->read('User.id') ) ) );
			if(!isset($foodlist) || empty($foodlist)){
				$message = 'Create a your own food';	
				$this->set(compact('message'));
				return;
			}
			
			$this->set(compact('foodlist'));
		}
	}
	
	function ajax_bmr(){
		$this->layout = 'ajax';
		if(!$this->Session->read('User.id')){
			$this->redirect($this->referer());
		}else{
			$this->loadModel('User');
			$user = $this->User->find('first', array('conditions' => array('id' => $this->Session->read('User.id') ) ) );
			$this->set(compact('user'));
		}
	}
	
	function ajax_bodyfat(){
		$this->layout = 'ajax';	
		if(!$this->Session->read('User.id')){
			$this->redirect($this->referer());
		}else{
			$this->loadModel('User');
			$user = $this->User->find('first', array('conditions' => array('id' => $this->Session->read('User.id') ) ) );
			$this->set(compact('user'));
		}
	}
	
	function ajax_bmi(){
		$this->layout = 'ajax';
		if(!$this->Session->read('User.id')){
			$this->redirect($this->referer());
		}else{
			$this->loadModel('User');
			$user = $this->User->find('first', array('conditions' => array('id' => $this->Session->read('User.id') ) ) );
			$this->set(compact('user'));
		}
	}
	
	function ajax_addFood(){
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}else{
			$this->layout = 'ajax';
		}	
	}
	
	function deleteFood($id = null){
		$id = Sanitize::clean($id);
		$this->loadModel('Food');
		$food = $this->Food->find('first', array('conditions' => array('Food.id' => $id)));
		if(!$this->Session->read('User.id') || $this->Session->read('User.id') != $food['Food']['user_id']){
			$this->Session->setFlash('Test');
			$this->redirect($this->referer());
		}else{
			$this->Food->delete($id);
			$this->Session->setFlash(''.$food['Food']['name'].' has been deleted');
			$this->redirect(array('controller' => 'profiles', 'action' => 'tools'));
		}
	}
	
	function ajax_editFood($id = null){
		$id = Sanitize::clean($id);
		$this->loadModel('Food');
		$food = $this->Food->find('first', array('conditions' => array('Food.id' => $id)));
		if(!$this->Session->read('User.id') || $this->Session->read('User.id') != $food['Food']['user_id']){
			$this->Session->setFlash('Test');
			$this->redirect($this->referer());
		}else{
			$this->layout = 'ajax';
			$this->set(compact('food'));
			
			$this->Food->id = $id;
			if (empty($this->data)) {
				$this->data = $this->Food->read();
				$this->data = $this->unConvertFood($this->data);
				$this->data['Profile'] = $this->data['Food'];
				unset($this->data['Food']);
			} else {
				$this->data['Food'] = $this->data['Profile'];
				unset($this->data['Profile']);
				$this->Food->set($this->data);
				if(!$this->Food->validates()){
					$this->Session->setFlash('shits not validated!');	
					$this->redirect(array('controller' => 'profiles', 'action' => 'tools'));
				}else{
					$this->data = $this->convertFood($this->data);
					if ($this->Food->save($this->data)) {
						$this->Session->setFlash('Your food has been updated.');
						$this->redirect(array('controller' => 'profiles', 'action' => 'tools'));
					}
				}
			}
		}
	}
	
	function addFood(){
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}else{
			$this->loadModel('Food');
			if(!empty($this->data)){
				$this->data['Food'] = $this->data['Profile'];
				unset($this->data['Profile']);
				$this->Food->set($this->data);
				if(!$this->Food->validates()){
					$this->Session->setFlash('shits not validated!');	
					$this->redirect(array('controller' => 'profiles', 'action' => 'tools'));
				}else{
					$this->data = $this->convertFood($this->data);
					$this->Food->create();
					if($this->Food->save($this->data)){
						$this->Session->setFlash('New food has been added');
						$this->redirect(array('controller' => 'profiles', 'action' => 'tools'));
					}
				}
			}
			//pr($this->data);die;
		}
	}
	function unConvertFood($data = null){
		if($data['Food']['food_type'] == 0){
			$data['Food']['protein'] = $data['Food']['protein'] * $data['Food']['default_value'];
			$data['Food']['carbs'] = $data['Food']['carbs'] * $data['Food']['default_value'];
			$data['Food']['fat'] = $data['Food']['fat'] * $data['Food']['default_value'];
			$data['Food']['fibre'] = $data['Food']['fibre'] * $data['Food']['default_value'];
			$data['Food']['calories'] = $data['Food']['calories'] * $data['Food']['default_value'];
			return $data;
		}elseif($data['Food']['food_type'] == 1){
			$data['Food']['protein'] = round($data['Food']['protein'] * $data['Food']['default_value'],3);
			$data['Food']['carbs'] = round($data['Food']['carbs'] * $data['Food']['default_value'],3);
			$data['Food']['fat'] = round($data['Food']['fat'] *  $data['Food']['default_value'],3);
			$data['Food']['fibre'] = round($data['Food']['fibre'] *  $data['Food']['default_value'],3);
			$data['Food']['calories'] = round($data['Food']['calories'] *  $data['Food']['default_value'],3);
			$newDefault = ($data['Food']['default_value'] / 28.35);
			$data['Food']['default_value'] = $newDefault;
			return $data;	
		}elseif($data['Food']['food_type'] == 2){
			$data['Food']['protein'] = $data['Food']['protein'] * $data['Food']['default_value'];
			$data['Food']['carbs'] = $data['Food']['carbs'] * $data['Food']['default_value'];
			$data['Food']['fat'] = $data['Food']['fat'] * $data['Food']['default_value'];
			$data['Food']['fibre'] = $data['Food']['fibre'] * $data['Food']['default_value'];
			$data['Food']['calories'] = $data['Food']['calories'] * $data['Food']['default_value'];
			return $data;
		}elseif($data['Food']['food_type'] == 3){
			$data['Food']['protein'] = round($data['Food']['protein'] *  $data['Food']['default_value'],3);
			$data['Food']['carbs'] = round($data['Food']['carbs'] *  $data['Food']['default_value'],3);
			$data['Food']['fat'] = round($data['Food']['fat'] *  $data['Food']['default_value'],3);
			$data['Food']['fibre'] = round($data['Food']['fibre'] *  $data['Food']['default_value'],3);
			$data['Food']['calories'] = round($data['Food']['calories'] *  $data['Food']['default_value'],3);
			$newDefault = round(($data['Food']['default_value'] / 0.5683), 3);
			$data['Food']['default_value'] = $newDefault;
			return $data;		
		}
		
	}
	
	
	function convertFood($data = null){
		if($data['Food']['food_type'] == 0){
			$data['Food']['protein'] = 	round($data['Food']['protein'] / $data['Food']['default_value'],4);
			$data['Food']['carbs'] = 	round($data['Food']['carbs'] / $data['Food']['default_value'],4);
			$data['Food']['fat'] = 		round($data['Food']['fat'] / $data['Food']['default_value'],4);
			$data['Food']['fibre'] =	round($data['Food']['fibre'] / $data['Food']['default_value'],4);
			$data['Food']['calories'] = round($data['Food']['calories'] / $data['Food']['default_value'],4);
			return $data;
		}elseif($data['Food']['food_type'] == 1){
			$newDefault = ($data['Food']['default_value'] * 28.35);
			$data['Food']['protein'] = 	round($data['Food']['protein'] / $newDefault,4);
			$data['Food']['carbs'] = 	round($data['Food']['carbs'] / $newDefault,4);
			$data['Food']['fat'] = 		round($data['Food']['fat'] / $newDefault,4);
			$data['Food']['fibre'] = 	round($data['Food']['fibre'] / $newDefault,4);
			$data['Food']['calories'] = round($data['Food']['calories'] / $newDefault,4);
			$data['Food']['default_value'] = round($newDefault,4);
			return $data;	
		}elseif($data['Food']['food_type'] == 2){
			$data['Food']['protein'] = 		round($data['Food']['protein'] / $data['Food']['default_value'],4);
			$data['Food']['carbs'] = 		round($data['Food']['carbs'] / $data['Food']['default_value'],4);
			$data['Food']['fat'] = 			round($data['Food']['fat'] / $data['Food']['default_value'],4);
			$data['Food']['fibre'] = 		round($data['Food']['fibre'] / $data['Food']['default_value'],4);
			$data['Food']['calories'] = 	round($data['Food']['calories'] / $data['Food']['default_value'],4);
			return $data;
		}elseif($data['Food']['food_type'] == 3){
			$newDefault = ($data['Food']['default_value'] * 0.5683);
			$data['Food']['protein'] = 		round($data['Food']['protein'] / $newDefault,4);
			$data['Food']['carbs'] =		round( $data['Food']['carbs'] / $newDefault,4);
			$data['Food']['fat'] = 			round($data['Food']['fat'] / $newDefault,4);
			$data['Food']['fibre'] = 		round($data['Food']['fibre'] /$newDefault,4);
			$data['Food']['calories'] = 	round($data['Food']['calories'] / $newDefault,4);
			$data['Food']['default_value'] =round($newDefault,4);
			return $data;		
		}
		
	}
	
		
	function tools(){
		if(!$this->Session->read('User.id')){
			$this->redirect($this->referer());
		}else{
			$this->loadModel('Food');
			$foodlist = $this->Food->find('list', array('conditions' => array('user_id' => $this->Session->read('User.id') ) ) );
			if(!isset($foodlist) || empty($foodlist)){
				$message = 'Create a your own food';	
				$this->set(compact('message'));
				return;
			}
			$this->set(compact('foodlist'));
		}
		
		/*$user_id = $this->Session->read('User.id');
		if(!$this->Session->read('User.id')){
			$this->Session->setFlash('Your must be logged in to view tools page');
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}else{
			$this->loadModel('User');
			$this->loadModel('Body');
			$metricMass = $this->Session->read('User.metricMass');
			$metricLength = $this->Session->read('User.metricLength');
			$this->set('metricMass', $this->Session->read('User.metricMass') );
			$this->set('metricLength', $this->Session->read('User.metricLength') );
			$this->set('weight', $this->Body->find('first', array('order' =>'Body.created DESC', 'conditions' => array('user_id' => $user_id) ),$metricMass, $metricLength ) ); 
			$this->set('height', $this->User->find('first', array('conditions' => array('User.id' => $user_id) ) ) );
		}*/
	}
	
	function getDietTotals($dailydiet){
		$this->loadModel('Dailydiet');
		$total = array();
		$totalProtein = 0;
		$totalCarbs = 0;
		$totalFat = 0;
		$totalFibre = 0;
		$totalCalories = 0;
		foreach($dailydiet['Foodentry'] as $foodentry){
			$food = $this->requestAction('dailydiets/getFood/'.$foodentry['food_id']);
			$totalProtein = 	$totalProtein + round(($foodentry['quantity'] * $food['Food']['protein']),1) ;
			$totalCarbs = 		$totalCarbs + round(($foodentry['quantity'] * $food['Food']['carbs']),1) ;
			$totalFat = 		$totalFat + round(($foodentry['quantity'] * $food['Food']['fat']),1) ;
			$totalFibre =		$totalFibre + round(($foodentry['quantity'] * $food['Food']['fibre']),1) ;
			$totalCalories = 	$totalCalories + round(($foodentry['quantity'] * $food['Food']['calories']),1) ;
		}
		$total = array(1 => array('protein' => $totalProtein, 'carbs' => $totalCarbs, 'fat' => $totalFat, 'fibre' => $totalFibre),2 => array('calories' => $totalCalories));
		return $total;
	}
	
	
	/*function stats(){
		if (!$this->Session->read('User.id')){
			$this->Session->setFlash('You must be logged in to view Profiles stats page');
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}else{ 	
			$this->loadModel('Picture');
			$this->loadModel('Body');
			$this->loadModel('Workout');
			$this->loadModel('Dailydiet');
			$metricMass = $this->Session->read('User.metricMass');
			$metricLength = $this->Session->read('User.metricLength');
			$this->set('firstPicture', $this->Picture->find('first', array('conditions' => array('user_id' => $this->Session->read('User.id') ) ) ) );
			$this->Picture->order = 'Picture.id DESC';
			$this->set('lastPicture', $this->Picture->find('first',  array('conditions' => array('user_id' => $this->Session->read('User.id') ) ) ) );
			$this->Picture->order = 'Picture.id ASC';
			$this->loadModel('User');
			$this->set('users', $this->User->find('first', array('conditions' => array('id' => $this->Session->read('User.id') ) ) ) );
			$body = $this->Body->find('all', array('conditions' => array('user_id' => $this->Session->read('User.id') ) ) );
			$user_id = $this->Session->read('User.id');
			$this->set('current', $this->Body->find('first', array('order' => array('Body.created DESC'), 'conditions' => array('user_id' => $user_id) ),$metricMass, $metricLength ) );
			$this->set('starting', $this->Body->find('first', array('order' => array('Body.created ASC'), 'conditions' => array('user_id' => $user_id) ),$metricMass, $metricLength  ) );
			$this->set('lightestWeight', $this->Body->find('first', array('order' => array('Body.weight ASC'), 'conditions' => array('user_id' => $user_id) ),$metricMass, $metricLength  ) );
			$this->set('lowestBf', $this->Body->find('first', array('order' => array('Body.bodyfat ASC'), 'conditions' => array('user_id' => $user_id) ),$metricMass, $metricLength  ) );
			$this->set('lowestChest', $this->Body->find('first', array('order' => array('Body.chest ASC'), 'conditions' => array('user_id' => $user_id) ),$metricMass, $metricLength  ) );
			$this->set('biggestChest', $this->Body->find('first', array('order' => array('Body.chest DESC'), 'conditions' => array('user_id' => $user_id) ),$metricMass, $metricLength  ) );
			$this->set('lowestArms', $this->Body->find('first', array('order' => array('Body.arms ASC'), 'conditions' => array('user_id' => $user_id) ),$metricMass, $metricLength  ) );
			$this->set('biggestArms', $this->Body->find('first', array('order' => array('Body.chest DESC'), 'conditions' => array('user_id' => $user_id) ),$metricMass, $metricLength  ) );
			$this->set('lowestThighs', $this->Body->find('first', array('order' => array('Body.thighs ASC'), 'conditions' => array('user_id' => $user_id) ),$metricMass, $metricLength ) );
			$this->set('biggestThighs', $this->Body->find('first', array('order' => array('Body.chest DESC'), 'conditions' => array('user_id' => $user_id) ),$metricMass, $metricLength  ) );
		
			$tempBench = $this->Workout->find('first', array('order' => array('Workout.created DESC'), 'conditions' => array('user_id' => $user_id, 'exercise_id' => '1')),$metricMass, $metricLength);
			$this->compare($tempBench, 'currentBench');
			$tempBench = $this->Workout->find('first', array('order' => array('Workout.created ASC'), 'conditions' => array('user_id' => $user_id, 'exercise_id' => '1')),$metricMass, $metricLength);
			$this->compare($tempBench, 'startingBench');
			$tempBench = $this->Workout->find('all', array('conditions' => array('user_id' => $user_id, 'exercise_id' => '1')),$metricMass, $metricLength);
			$this->megaCompare($tempBench, 'strongestBench');
			
			$tempSquat = $this->Workout->find('first', array('order' => array('Workout.created DESC'), 'conditions' => array('user_id' => $user_id, 'exercise_id' => '2')),$metricMass, $metricLength);
			$this->compare($tempSquat, 'currentSquat');
			$tempSquat = $this->Workout->find('first', array('order' => array('Workout.created ASC'), 'conditions' => array('user_id' => $user_id, 'exercise_id' => '2')),$metricMass, $metricLength);
			$this->compare($tempSquat, 'startingSquat');
			$tempSquat = $this->Workout->find('all', array('conditions' => array('user_id' => $user_id, 'exercise_id' => '2')),$metricMass, $metricLength);
			$this->megaCompare($tempSquat, 'strongestSquat');
			
			$temp = $this->Workout->find('first', array('order' => array('Workout.created DESC'), 'conditions' => array('user_id' => $user_id, 'exercise_id' => '3')),$metricMass, $metricLength);
			$this->compare($temp, 'currentDeadlift');
			$temp = $this->Workout->find('first', array('order' => array('Workout.created ASC'), 'conditions' => array('user_id' => $user_id, 'exercise_id' => '3')),$metricMass, $metricLength);
			$this->compare($temp, 'startingDeadlift');
			$temp = $this->Workout->find('all', array('conditions' => array('user_id' => $user_id, 'exercise_id' => '3')),$metricMass, $metricLength);
			$this->megaCompare($temp, 'strongestDeadlift');
			
			$temp = $this->Workout->find('first', array('order' => array('Workout.created DESC'), 'conditions' => array('user_id' => $user_id, 'exercise_id' => '4')),$metricMass, $metricLength);
			$this->compare($temp, 'currentRow');
			$temp = $this->Workout->find('first', array('order' => array('Workout.created ASC'), 'conditions' => array('user_id' => $user_id, 'exercise_id' => '4')),$metricMass, $metricLength);
			$this->compare($temp, 'startingRow');
			$temp = $this->Workout->find('all', array('conditions' => array('user_id' => $user_id, 'exercise_id' => '4')),$metricMass, $metricLength);
			$this->megaCompare($temp, 'strongestRow');
			
			$temp = $this->Workout->find('first', array('order' => array('Workout.created DESC'), 'conditions' => array('user_id' => $user_id, 'exercise_id' => '5')),$metricMass, $metricLength);
			$this->compare($temp, 'currentCurl');
			$temp = $this->Workout->find('first', array('order' => array('Workout.created ASC'), 'conditions' => array('user_id' => $user_id, 'exercise_id' => '5')),$metricMass, $metricLength);
			$this->compare($temp, 'startingCurl');
			$temp = $this->Workout->find('all', array('conditions' => array('user_id' => $user_id, 'exercise_id' => '5')),$metricMass, $metricLength);
			$this->megaCompare($temp, 'strongestCurl');
			
			$temp = $this->Workout->find('first', array('order' => array('Workout.created DESC'), 'conditions' => array('user_id' => $user_id, 'exercise_id' => '6')),$metricMass, $metricLength);
			$this->compare($temp, 'currentPress');
			$temp = $this->Workout->find('first', array('order' => array('Workout.created ASC'), 'conditions' => array('user_id' => $user_id, 'exercise_id' => '6')),$metricMass, $metricLength);
			$this->compare($temp, 'startingPress');
			$temp = $this->Workout->find('all', array('conditions' => array('user_id' => $user_id, 'exercise_id' => '6')),$metricMass, $metricLength);
			$this->megaCompare($temp, 'strongestPress');
			
			$diets = $this->Dailydiet->find('all', array('conditions' => array('user_id' => $user_id)));
			$this->dietCompare($diets);
		}
	
	}*/
	/*function dietCompare($array = null, $check = null){
		$this->loadModel('Food');
		$foods = $this->Food->find('all');
		$count2 = 0;
		foreach($array as $diet){
			$totalProtein = 0;
			$totalCarbs = 0;
			$totalFat = 0;
			$totalFibre = 0;
			$totalCalories = 0;
			foreach ($diet['Foodentry'] as $foodentry){
					$totalProtein = $totalProtein + $foodentry['quantity'] * $foods[$foodentry['food_id']-1]['Food']['protein'];
					$totalCarbs = $totalCarbs + $foodentry['quantity'] * $foods[$foodentry['food_id']-1]['Food']['carbs'];
					$totalFat = $totalFat + $foodentry['quantity'] * $foods[$foodentry['food_id']-1]['Food']['fat'];
					$totalFibre = $totalFibre + $foodentry['quantity'] * $foods[$foodentry['food_id']-1]['Food']['fibre'];
					$totalCalories = $totalCalories + $foodentry['quantity'] * $foods[$foodentry['food_id']-1]['Food']['calories'];
			}
			if($check == 1){
				return $total = array(0 => round($totalCalories,2), 1 => round($totalProtein,2), 2 => round($totalCarbs,2), 3 => round($totalFat,2));
				
				
			}else{
				$this->set('totalProtein'.$count2, $totalProtein);
				$this->set('totalCarbs'.$count2, $totalCarbs);
				$this->set('totalFat'.$count2, $totalFat);
				$this->set('totalFibre'.$count2, $totalFibre);
				$this->set('totalCalories'.$count2, $totalCalories);
			}
			$count2++;
		}
	}*/
	
	/*function megaCompare($array = null, $name =  null){
		$maxRep = 0;
		if (!empty($array)){
			foreach ($array as $workout){
				foreach ($workout['Activity'] as $activity){
					$offset = ($activity['reps'] -1) * 2.50;
					$tempRep = $activity['value'] * ((100+$offset)/100);
					if ($tempRep > $maxRep){
						$maxRep = $tempRep;	
					}
				}
			}
			$this->set($name, $maxRep);
		}else{
			$this->set($name, '0');	
		}
	}*/
	
	/*function compare($array = null, $name = null, $check = null){
		$maxRep = 0;
		if (isset($array['Workout']['id'])){
			foreach ($array['Activity'] as $activity){
				$offset = ($activity['reps']-1) * 2.50;
				$tempRep = $activity['value'] * ((100+$offset)/100);
				if ($tempRep > $maxRep){
					$maxRep = $tempRep;	
				}
					
			}
			if($check == 1){
				return $maxRep;	
			}else{
				$this->set($name, $maxRep);
			}
		}else{
			if($check == 1){
				return 0;
			}else{
				$this->set($name, '0');
			}
		}
		
	}*/
	
	/*function table($id = null, $sort = -1){
		$user_id = $this->Session->read('User.id');
		if ($id == $user_id){
			$this->loadModel('Body');
			$this->loadModel('Workout');
			$this->loadModel('Dailydiet');
			$metricLength = $this->Session->read('User.metricLength');
			$metricMass = $this->Session->read('User.metricMass');
			$bodies = $this->Body->find('all', array('order' => array('Body.created DESC'), 'conditions' => array('user_id' => $user_id)),$metricMass, $metricLength );
			$workouts = $this->Workout->find('all', array('order' => array('Workout.created DESC'), 'conditions' => array('user_id' => $user_id)),$metricMass );
			$dailydiets = $this->Dailydiet->find('all', array('order' => array('Dailydiet.created DESC'), 'conditions' => array('user_id' => $user_id)));

			$totalArray = array();
			$count = 0;
			foreach($bodies as $body){
				$totalArray[$count] = $body;
				$count++;
			};
			$totalArray  = array_merge($totalArray, $dailydiets);
			usort($totalArray, 'cmp');
			$count = -1;
			$skip = 0;
			foreach($totalArray as $total){
				$count++;
				if($skip == 1){
					$skip = 0;
				}else{
					$tempArray[$count] = $total;
				}
				foreach($totalArray as $total2){
					if(isset($total['Body']) && isset($total2['Dailydiet'])){
						if ($total['Body']['created'] == $total2['Dailydiet']['created']){
							$tempArray[$count]['Body'] = $total['Body'];
							$tempArray[$count]['Dailydiet'] = $total2['Dailydiet'];
							$count--;
							$skip = 1;
							break;
					 	}
					}
					if(isset($total['Dailydiet']) && isset($total2['Body'])){
						if ($total['Dailydiet']['created'] == $total2['Body']['created']){
							$tempArray[$count]['Body'] = $total2['Body'];
							$tempArray[$count]['Dailydiet'] = $total['Dailydiet'];
							$count--;
							$skip = 1;
							break;
					 	}
					}
				}
			}
			if(isset($tempArray)){
				$totalArray = $tempArray;
			}else{
				$tempArray = array();
			}
			$tempArray = array();
			$count = -1;
			$count2 = 0;
			$skip =  0;
			foreach($workouts as $workout){
				$count++;
				$count2 = 0;
				if($skip <=0){
					foreach($workouts as $workout2){
						if($workout['Workout']['created'] == $workout2['Workout']['created']){
							$tempArray[$count]['Workout'][$count2] = $workout2['Workout'];
							$count2++;
							$skip = $count2-1;
						}
					}
				}else{
					$count--;
					$skip--;
				}
			}
			$totalArray = array_merge($totalArray, $tempArray);
			usort($totalArray, 'cmp2');
			$count = -1;
			$skip = 0;
			foreach($totalArray as $total){
				$count++;
				if($skip == 1){
					$skip = 0;
				}else{
					$tempArray[$count] = $total;
					foreach($totalArray as $total2){
					if(isset($total['Body']) && isset($total2['Workout'])){
						if ($total['Body']['created'] == $total2['Workout']['0']['created']){
							$tempArray[$count]['Body'] = $total['Body'];
							if(isset($total['Dailydiet'])){
								$tempArray[$count]['Dailydiet'] = $total['Dailydiet'];
							}
							$tempArray[$count]['Workout'] = $total2['Workout'];
							$count--;
							$skip = 1;
							break;
					 	}
					}elseif(isset($total['Dailydiet']) && isset($total2['Workout'])){ 
						if ($total['Dailydiet']['created'] == $total2['Workout']['0']['created']){
							$tempArray[$count]['Dailydiet'] = $total['Dailydiet'];
							if(isset($total['Body'])){
								$tempArray[$count]['Body'] = $total['Body'];
							}
							$tempArray[$count]['Workout'] = $total2['Workout'];
							$count--;
							$skip = 1;
							break;
						}
					}elseif(isset($total['Workout']) && isset($total2['Body'])){ 
						if ($total['Workout']['0']['created'] == $total2['Body']['created']){
							$tempArray[$count]['Workout'] = $total['Workout'];
							if(isset($total2['Dailydiet'])){
								$tempArray[$count]['Dailydiet'] = $total2['Dailydiet'];
							}
							$tempArray[$count]['Body'] = $total2['Body'];
							$count--;
							$skip = 1;
							break;
						}
					}elseif(isset($total['Workout']) && isset($total2['Dailydiet'])){ 
						if ($total['Workout']['0']['created'] == $total2['Dailydiet']['created']){
							$tempArray[$count]['Workout'] = $total['Workout'];
							if(isset($total['Body'])){
								$tempArray[$count]['Body'] = $total2['Body'];
							}
							$tempArray[$count]['Dailydiet'] = $total2['Dailydiet'];
							$count--;
							$skip = 1;
							break;
							}
						}
					}
				}
			}
			$totalArray = $tempArray;
			$count = 0;
			$bench = array(); $squat = array(); $deadlift = array(); $totals = array();
			foreach($totalArray as $total){
				if(isset($total['Workout'])){
					$count2 = 0;
					foreach($total['Workout'] as $workout){
						if($workout['exercise_id'] == 1){
							$temp = $this->Workout->find('first', array('conditions' => array('Workout.id' => $workout['id']) ),$metricMass );
							$bench[$count] = $this->compare($temp, 'bench', 1);
							$totalArray[$count]['Workout']['value1'] = $bench[$count]; 
						}elseif($workout['exercise_id'] == 2){
							$temp = $this->Workout->find('first', array('conditions' => array('Workout.id' => $workout['id']) ),$metricMass  );
							$squat[$count] = $this->compare($temp, 'squat', 1);
							$totalArray[$count]['Workout']['value2'] = $squat[$count]; 
						}elseif($workout['exercise_id'] == 3){
							$temp = $this->Workout->find('first', array('conditions' => array('Workout.id' => $workout['id']) ),$metricMass  );
							$deadlift[$count] = $this->compare($temp, 'deadlift', 1);
							$totalArray[$count]['Workout']['value3'] = $deadlift[$count]; 
						}
						$count2++;
					}
				}
				if(isset($total['Dailydiet'])){
					$temp = $this->Dailydiet->find('all', array('conditions'=> array('Dailydiet.id' => $total['Dailydiet']['id']) ) );
					$totalArray[$count]['Dailydiet']['values'] = $this->dietCompare($temp, 1);
				}
				$count++;
			}
			
			if($sort == 0){
				usort($totalArray, 'cmp2');
			}elseif($sort == 1){
				usort($totalArray, 'cmp3');
			}elseif($sort == 2){
				usort($totalArray, 'cmp4');
			}elseif($sort == 3){
				usort($totalArray, 'cmp5');
			}elseif($sort == 4){
				usort($totalArray, 'cmp6');	
			}elseif($sort == 5){
				usort($totalArray, 'cmp7');	
			}elseif($sort == 6){
				usort($totalArray, 'cmp8');	
			}elseif($sort == 7){
				usort($totalArray, 'cmp9');	
			}elseif($sort == 8){
				usort($totalArray, 'cmp10');	
			}elseif($sort == 9){
				usort($totalArray, 'cmp11');	
			}elseif($sort == 10){
				usort($totalArray, 'cmp12');	
			}elseif($sort == 11){
				usort($totalArray, 'cmp13');	
			}elseif($sort == 12){
				usort($totalArray, 'cmp14');	
			}elseif($sort == 13){
				usort($totalArray, 'cmp15');	
			}elseif($sort == 14){
				usort($totalArray, 'cmp16');	
			}elseif($sort == 15){
				usort($totalArray, 'cmp17');	
			}elseif($sort == 16){
				usort($totalArray, 'cmp18');	
			}elseif($sort == 17){
				usort($totalArray, 'cmp19');	
			}elseif($sort == 18){
				usort($totalArray, 'cmp20');	
			}elseif($sort == 19){
				usort($totalArray, 'cmp21');	
			}
			
			$this->set('totalArray', $totalArray);
			$this->set('id', $id);
			$this->set('sort', $sort);
		}else{
			$this->Session->setFlash('You must be logged in or the correct user to view this table');
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}
	}*/
}
?>