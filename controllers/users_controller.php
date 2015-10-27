<?php 
App::import('Sanitize');
class UsersController extends AppController 
{ 
    var $name = "Users"; 
    var $helpers = array('Html', 'Js' => array('Jquery')); 
	
	function help(){
			
	}
	
	function terms(){
		
	}
	
	function privacy(){
		
	}
	
	function contact(){
		
	}
	
	function home(){
		$this->layout = 'home';
		$this->loadModel('Post');
		$article = $this->Post->find('first', array('order' => 'Post.created DESC', 'recursive' => '-1', 'conditions' =>array('Post.article' => 1) ) );
		$this->set(compact('article'));
	}
	
	function about(){
		
	}
	
	function ajax_setting_password(){
		if(!$this->Session->read('User.id')){
			$this->Session->SetFlash('Please login to view this page');
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}else{
			$this->layout = 'ajax';	
		}
	}
	
	function ajax_setting_privacy(){
		if(!$this->Session->read('User.id')){
			$this->Session->SetFlash('Please login to view this page');
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}else{
			$this->layout = 'ajax';	
			$users = $this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('User.id')) ) );
			$this->set('users', $users);
		}
	}
	
	function ajax_setting_notifications(){
		if(!$this->Session->read('User.id')){
			$this->Session->SetFlash('Please login to view this page');
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}else{
			$this->layout = 'ajax';
			$users = $this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('User.id')) ) );
			$this->set('users', $users);
		}
	}
	
	function ajax_setting_general(){
		if(!$this->Session->read('User.id')){
			$this->Session->SetFlash('Please login to view this page');
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}else{
			$this->layout = 'ajax';	
			$users = $this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('User.id')) ) );
			$this->set('users', $users);
		}
	}
	
	function getOthers(){
		//returns 20 users who, arent already being followed by user.
		$this->loadModel('Follower');
		$users = $this->User->find('all', array('limit' => 20, 'conditions' => array('hideProfile' => 0, 'hidePublic' => 0)));
		$followings = $this->Follower->find('all', array('conditions' => array('User_id' => $this->Session->read('User.id')) ) );
		
		$count_following = count($followings);
		$tempArray = array();
		$count2 =  0;
		foreach($users as $user){
			$count = 0;
			//IF there is actually followings for the current user
			if(isset($followings) && !empty($followings)){
				foreach($followings as $following){
					if($following['Follower']['following_id'] != $user['User']['id'] && $user['User']['id'] != $this->Session->read('User.id')){
						$count++;
					}
				}
				if($count >= $count_following){
					$tempArray[$count2] = $user;
					$count2++;	
				}
			}else{
				if($user['User']['id'] != $this->Session->read('User.id')){
					$tempArray[$count2] = $user;
					$count2++;	
				}
			}
		}
		$users = $tempArray;
		
		if (isset($this->params['requested'])) {
			return $users;
		}
	}
	
	function getOthersHelp(){
		//$this->loadModel('Picture');
		$this->User->Behaviors->attach('Containable');
		$users = $this->User->find('all', array('contain' => array('Picture'), 'fields' =>  array('User.id', 'User.username'), 'limit' => 20, 'conditions' => array('hideProfile' => 0, 'hidePublic' => 0, 'NOT' => array('id' => $this->Session->read('User.id')))));
		if (isset($this->params['requested'])) {
			return $users;
		}
	}
	
	function getAllUsers(){
		//$allUsers = $this->User->find('all', array('recursive' => 1, 'fields' => array('User.id','user_id')));
		
   		$this->User->Behaviors->attach('Containable');

		$allUsers = $this->User->find('all', array('contain' => array('Picture')));
		if (isset($this->params['requested'])) {
			return $allUsers;
		}
	}
	
	function getUser(){
		$user = $this->User->find('first', array('fields' =>array('id', 'username', 'level', 'forname', 'surname', 'age', 'about', 'location', 'height', 'heightFoot', 'heightInch', 'active', 'sex', 'metricLength', 'metricMass', 'metricVolume', 'notification_type1', 'notification_type2', 'notification_type3', 'notification_type4', 'hideAge', 'hideName', 'hideHeight', 'hideLocation', 'hideProfile', 'hidePublic'), 'conditions' => array('User.id' => $this->Session->read('User.id'))));	
		if (isset($this->params['requested'])) {
			return $user;
		}
		echo json_encode($user['User']);
		$this->autoRender = false;
	}
	
	function getSelectedUser($id = null){
		$id = Sanitize::clean($id);
		//$user = $this->User->find('first', array('conditions' => array('User.id' => $id)));	
		$user = $this->User->find('first', array('fields' => array('id', 'username', 'level', 'forname', 'surname', 'age', 'about', 'location', 'height', 'heightFoot', 'heightInch', 'active', 'sex', 'metricLength', 'metricMass', 'metricVolume', 'notification_type1', 'notification_type2', 'notification_type3', 'notification_type4', 'hideAge', 'hideName', 'hideHeight', 'hideLocation', 'hideProfile', 'hidePublic'), 'recursive' => '-1', 'conditions' => array('User.id' => $id)));	
		if (isset($this->params['requested'])) {
			return $user;
		}
	}
	
	function getAge($date = null){
		$date = Sanitize::clean($date);
		$today = getdate(); 
		$year = (60*60*24*365.35);
		$difference = ($today[0] - strtotime($date));
		$age = $difference / $year ;
		$age = floor($age);
		
		if (isset($this->params['requested'])) {
			return $age;
		}
	}
	
	function getTime($date = null){
		$date = Sanitize::clean($date);
		$today = getdate();
		//$date = strtotime($date);
		$newDate = $date /*- (60*60)*/;
		$minute = 60;
		$hour = 60*60;
		$day = (60*60*24);
		$week = (60*60*24*7);
		$string = '';
		$difference = $today[0] - $newDate;
		if (($difference) < $minute) {
			$string = floor($difference).' Seconds ago';
		}elseif ($difference < $hour){
			$difference = floor($difference/60);
			$string = $difference.' Minutes ago';
		}elseif ($difference < $day){
			$difference = floor($difference/(60*60));
			$string = $difference.' Hours ago';
		}elseif ($difference < $week){
			$difference = floor($difference/(60*60*24));
			$string = $difference.' Days ago';
		}else{
			$string = date("d, M, Y", $newDate);
		}
		
		if (isset($this->params['requested'])) {
			return $string;
		}
		
	}
	
	function showMore($array = array(), $page_no = 0, $limit = 0){
		$page_no = Sanitize::clean($page_no);
		$limit = Sanitize::clean($limit);
		$page_no++;
		$limit = $limit * $page_no;
		$array = array_slice($array, 0, $limit, false);
		return $array;
	}
	
	function view($id = null, $page_no = 0){
		$page_no = Sanitize::clean($page_no);
		$id = Sanitize::clean($id);
		$user = $this->User->find('first', array('recursive' => -1, 'conditions' => array('User.id' => $id)));
		$userFollowings = $this->requestAction('followers/getUserFollowings/'.$id);
		$count = 0;
		foreach($userFollowings as $userFollowing){
			if($userFollowing['Follower']['following_id'] == $this->Session->read('User.id')){
				$count = 1;
				break;	
			}
		}
		if($user['User']['hideProfile'] == 1){
			$this->Session->setFlash('The user has hidden his profile');
			$this->redirect($this->referer());
			
		}elseif($count == 0 && $user['User']['hidePublic'] == 1){
			$this->Session->setFlash('This user only allows friends to view his profile.');
			$this->redirect($this->referer());
		
		/*}elseif(!$this->Session->read('User.id')){
			$this->Session->setFlash('You must be logged in to view users profiles');
			$this->redirect(array('controller' => 'users', 'action' => 'login'));*/
		}else{
			$this->loadModel('Post');
			$this->loadModel('Like');
			$posts = $this->Post->find('all', array('conditions' => array('user_id' => $id, 'Post.article' => 0)));
			$tempArray = array();
			$count2 = 0;
			foreach($posts as $post){
				$postUser = $this->User->find('first', array('conditions' => array('id' => $post['Post']['user_id'])));
				if($postUser['User']['hideProfile'] == 0 && $postUser['User']['hidePublic'] == 0){
					$tempArray[$count2] = $post;
					$count2++;	
				}
			}
			$this->set('likes', $this->Like->find('all', array('recursive' => '-1')));
			$this->set('totalPosts', $tempArray);
			$tempArray = $this->showMore($tempArray, $page_no, 5);
			$this->set('posts', $tempArray);
			$this->set(compact('id', 'page_no'));
		}
	}
	
	function ajax_feed($id = null, $page_no = 0){
		$page_no = Sanitize::clean($page_no);
		$id = Sanitize::clean($id);
		//if(!$this->Session->read('User.id')){
			//$this->Session->setFlash('You must be logged in to view users profiles');
			//$this->redirect(array('controller' => 'users', 'action' => 'login'));
		//}else{
			$this->layout = 'ajax';
			$this->loadModel('Post');
			$this->loadModel('Like');
			$posts = $this->Post->find('all', array('conditions' => array('user_id' => $id, 'Post.article' => 0)));
			$tempArray = array();
			$count2 = 0;
			foreach($posts as $post){
				$postUser = $this->User->find('first', array('conditions' => array('id' => $post['Post']['user_id'])));
				if($postUser['User']['hideProfile'] == 0 && $postUser['User']['hidePublic'] == 0){
					$tempArray[$count2] = $post;
					$count2++;	
				}
			}
			$this->set('likes', $this->Like->find('all', array('recursive' => '-1')));
			$this->set('totalPosts', $tempArray);
			$tempArray = $this->showMore($tempArray, $page_no, 5);
			$this->set('posts', $tempArray);
			$this->set(compact('id', 'page_no'));
		//}
	}
	
	function ajax_pictures($user_id = null){
		$user_id = Sanitize::clean($user_id);
		//if(!$this->Session->read('User.id')){
			//$this->Session->setFlash('You must be logged in to view Pictures index.');
			//$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		//}
		$this->layout = 'ajax';
		//$user_id =  $this->Session->read('User.id');
		$this->loadModel('Picture');/*C:\wamp\www\fitness\webroot\img\uploads\users*/
		//$temp = explode("fitness", __DIR__);
		//$urlString = $temp[0].'fitness\webroot\img\uploads\users\\';
		$pictures = $this->Picture->find('all', array('conditions' => array('user_id' => $user_id) ) );	
		//$totalSize = 0;
		//foreach($pictures as $picture){
			//$totalSize += filesize($urlString.$picture['Picture']['image']);
		//}
		$this->set(compact('pictures'));
	}
	
	function ajax_progress(){
		//if(!$this->Session->read('User.id')){
			//$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		//}else{
			$this->layout = 'ajax';
		//}
	}
	
	function ajax_progress_type($id = null, $user_id = null){
		$id = Sanitize::clean($id);
		$user_id = Sanitize::clean($user_id);
		//if(!$this->Session->read('User.id')){
			//$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		//}else{
			$this->layout = 'ajax';
			if($id == 0){
				$this->loadModel('Workout');
				$workout = $this->Workout->find('all', array('recursive' => -1, 'fields' => array('DISTINCT exercise_id'), 'conditions' => array('user_id' => $user_id)));
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
				$dailydiet = $this->Dailydiet->find('list', array('fields' => array('Dailydiet.created'), 'conditions' => array('user_id' => $user_id ) ) );
				foreach($dailydiet as $key => $diet){
					$niceDate[$key] = date("F j, Y", strtotime($diet));
				}
				$options = $niceDate;
				$this->set(compact('options', 'id'));
				
			}elseif($id == 2){
				$this->loadModel('Body');
				$body = $this->Body->find('first', array('conditions' => array('user_id' => $user_id) ) );
				if(!empty($body)){
					$options = array('weight' => 'weight', 'bodyfat' => 'bodyfat', 'chest' => 'chest', 'arms' => 'arms', 'hips' => 'hips'
						, 'waist' => 'waist', 'thighs' => 'thighs', 'forearms' => 'forearms', 'calves' => 'calves', 'shoulders' => 'shoulders',
						'neck' => 'neck');
					$this->set(compact('options', 'id'));
				}
			}
		//}
	}
	
	function ajax_graph($selected = null, $id = null, $user_id = null, $time = null){
		$selected = Sanitize::clean($selected);
		$id = Sanitize::clean($id);
		$user_id = Sanitize::clean($user_id);
		//if(!$this->Session->read('User.id')){
			//$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		//}else{
			//ASSIGN TIME RANGE
			$today = getdate();
			if($time == 0){
				$date = $today[0]-(60*60*24*365.25*25);
			}elseif($time == 1){
				$date = $today[0]-(60*60*24*365.25);
			}elseif($time == 2){
				$date = $today[0]-(60*60*24*30);
			}elseif($time == 3){
				$date = $today[0]-(60*60*24*7);
			}
			$date = date('Y-m-d H:i:s', $date);
			
			//WORKOUT SELECTED
			if($id == 0){
				$this->loadModel('Workout');
				if($this->Session->read('User.id')){
					$workouts = $this->Workout->find('all', array('order' => 'Workout.created DESC', 'conditions' => array('Workout.created >=' => $date, 'exercise_id' => $selected, 'user_id' => $user_id)), $this->Session->read('User.metricMass'));
				}else{
					$workouts = $this->Workout->find('all', array('order' => 'Workout.created DESC', 'conditions' => array('Workout.created >=' => $date, 'exercise_id' => $selected, 'user_id' => $user_id)));
				}
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
							if($this->Session->read('User.id')){
								if($this->Session->read('metricLength') == 0){
									$activity['distance'] = round(($activity['distance'] * 0.6214),1);
								}
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
				$body = $this->Body->find('all', array('order' => 'Body.created DESC', 'conditions' => array('Body.created >=' => $date, 'user_id' => $user_id)),$this->Session->read('User.metricMass'), $this->Session->read('User.metricLength'));
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
		//}
	}
	
	function getDietTotals($dailydiet = null){
		$dailydiet = Sanitize::clean($dailydiet);
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
	
	
	function dietCompare($array = null, $check = null){
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
	}
	
	function megaCompare($array = null, $name =  null){
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
	}
	
	function compare($array = null, $name = null, $check = null){
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
		
	}
	
    function search(){
		$this->loadModel('Follower');
		$user_id = $this->Session->read('User.id');
		$search = $this->data['User']['search'];
		$results = $this->User->find('all', array('conditions' => array('username LIKE' => '%'.$search.'%') ) );
		$this->set('results', $results);
		$this->set('currentFollowings', $this->Follower->find('all', array('conditions' => array('Follower.user_id' => $user_id) ) ) );

	}
	   
   /* function beforeFilter() 
    { 
        //$this->__validateLoginStatus();
		parent::beforeFilter();
    }*/
	 
	function thanks(){
	}
	
	function forgotThanks(){	
	}
	
	
	/*function test(){
		$comp = mail ( "william@rehabstudio.com", "testing", "This is a test message" );
		die( $comp ? "Worked" : "failed" );	
		
	}*/
	
	function forgot(){
		if(!empty($this->data)){
			$usernameCheck = $this->User->find('first', array('conditions' => array('username' =>$this->data['User']['username'])));
			if(empty($usernameCheck)){
				$this->Session->setFlash('That Username does not exsist');
				$this->redirect('forgot');	
				
			}elseif ($usernameCheck['User']['email'] != $this->data['User']['email']){
				$this->Session->setFlash('That email does not match the username');
				$this->redirect('forgot');	
			}else{
				
				$password  = rand(100000000, 1000000000);
				$dbpassword = md5($password);
				$this->User->id = $usernameCheck['User']['id'];
				$this->User->saveField('password', $dbpassword);
				$this->set('username', $usernameCheck['User']['username']);
				$this->set('password', $password);
				$this->Email->to = $this->data['User']['email'];
				$this->Email->subject =  'Witness the Fitness - Password reset';
				$this->Email->from = 'noreply@wtfitness.net';
				$this->Email->template = 'user_reset';
				$this->Email->sendAs = 'both';
				$this->Email->send();
				$this->redirect('forgotThanks');
			}
		}
	}
	
	function register()
	{
		if (!empty($this->data)) {
			$this->data['User']['password'] = md5($this->data['User']['password']);
			$copy = $this->User->find('first', array('conditions' => array('username' => $this->data['User']['username'])));
            if ($this->User->createUser($this->data)) {
				//pr($this->User->getLastInsertID());die;
				//$this->redirect(array('controller' => 'users', 'action' => 'thanks'));
				//$this->Session->write('User', $this->User->findByUsername($this->data['User']['username']));
				$this->__sendActivationEmail($this->User->getLastInsertID());
				$this->redirect(array('controller' => 'users', 'action' => 'thanks'));
               //$this->Session->setFlash('Your account has been created!');
                //$this->redirect(array('controller' => 'posts', 'action' => 'index'));
				//$this->redirect(array('/users/thanks'));
				
			}elseif(!empty($copy)){
				$this->Session->setFlash('This username already exists');
				 $this->data['User']['password'] = null;
			}else{
				 $this->Session->setFlash('The User could not be saved. Please, try again.');
				 $this->data['User']['password'] = null;
            }
        }
	}
	
	function __sendActivationEmail($user_id) {
		$user = $this->User->find(array('User.id' => $user_id), array('User.email', 'User.username'), null, false);
		$this->set('activate_url', 'http://' . $_SERVER['HTTP_HOST'] . '/users/activate/' . $user_id . '/' . $this->User->getActivationHash());
		$this->set('username', $this->data['User']['username']);
 
		$this->Email->to = $user['User']['email'];
		$this->Email->subject =  'Witness The Fitness - Please confirm your email address';
		$this->Email->from = 'noreply@wtfitness.net';
		$this->Email->template = 'user_confirm';
		$this->Email->sendAs = 'both';
		$this->Email->send();
	}
	
	function activate($user_id = null, $in_hash = null) {
		$this->autoRender = false;
		$this->User->id = $user_id;
		if ($this->User->exists() && ($in_hash == $this->User->getActivationHash()))
		{
			// Update the active flag in the database
			$this->User->saveField('active', 1);
	 
			// Let the user know they can now log in!
			$this->Session->setFlash('Your account has been activated, please log in below');
			$this->redirect('login');
		}
	}

	function setting($id = null){
		$user_id = $this->User->find('first', array('conditions' => array('id' => $this->Session->read('User.id'))));
		$this->set('users', $user_id);
		if (!$this->Session->read('User.id') || $this->Session->read('User.id') !=  $user_id['User']['id']){
			$this->redirect(array('controller' => 'posts', 'action' => 'index'));	
		} else{
			$this->User->id = $id;
		if (empty($this->data)){
				$this->data = $this->User->read();
			}else{
				if(isset($this->data['User']['height'])){
					$height = explode(" ", $this->data['User']['height']);
					$this->data['User']['height'] = $height[0];
				
					if($this->Session->read('User.metricLength') == 1)
						{
							//Checks metric is selected then converts cm height into feet and inches and saves it to the DB 
							$inches = $this->data['User']['height'] * 0.3937;
							$feet = $inches / 12; $feet = floor($feet);
							$inched =  $inches % 12; $inched =  floor($inched);
							
							$this->data['User']['heightFoot'] = $feet;
							$this->data['User']['heightInch'] = $inched;
							//$this->User->saveField('heightFoot', $feet);
							//$this->User->saveField('heightInch', $inched);
						}else{
							//Checks metric is not select then converts feet and inches into cm and saves it to the DB 
							$totalInches = ($this->data['User']['heightFoot']*12) +$this->data['User']['heightInch'];
							$cm = $totalInches * 2.54; $cm = number_format($cm,0);
							$this->data['User']['height'] = $cm;
							//$this->User->saveField('height',$cm);
						}
				}
					if(isset($this->data['User']['Current password']) && isset($this->data['User']['New password'])){
						if($this->data['User']['Current password'] != null || $this->data['User']['New password'] != null){
							if(md5($this->data['User']['Current password']) == $user_id['User']['password']){
								$dbpassword = md5($this->data['User']['New password']);
								$this->data['User']['password'] = $dbpassword;
								
								
							}else{
								$notSaved = 1;	
							}
						}
					}
				if ($this->User->save($this->data)){
					if(isset($this->data['User']['metricLength'])){
						$this->Session->write('User.metricLength', $this->data['User']['metricLength']);
						$this->Session->write('User.metricVolume', $this->data['User']['metricVolume']);
						$this->Session->write('User.metricMass', $this->data['User']['metricMass']);
					}
					
					if(isset($this->data['User']['hideName'])){
						$this->Session->write('User.hideName', $this->data['User']['hideName']);
						$this->Session->write('User.hideHeight', $this->data['User']['hideHeight']);
						$this->Session->write('User.hideAge', $this->data['User']['hideAge']);
						$this->Session->write('User.hideLocation', $this->data['User']['hideLocation']);
						
					}
					//$this->Session->write('User.notification_type1', $this->data['User']['notification_type1']);
					//$this->Session->write('User.notification_type2', $this->data['User']['notification_type2']);
					//$this->Session->write('User.notification_type3', $this->data['User']['notification_type3']);
					//$this->Session->write('User.notification_type4', $this->data['User']['notification_type4']);
					if(isset($notSaved)){
						$this->Session->setFlash('Incorrect password');
					}else{
						$this->Session->setFlash('Your settings have been saved.');
					}
					$this->redirect($this->referer());
				}	
			}	
		}
	}
	
	function deleteProfile(){
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}elseif($this->data['User']['id'] != $this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}else{
			//pr($this->data);die;
			//if(md5($this->data['User']['Current password']) == $user_id['User']['password']){
			if(isset($this->data) && !empty($this->data)){
				$dbpassword = md5($this->data['User']['passworddelete']);
				$user = $this->User->find('first', array('conditions' => array('username' => $this->data['User']['username'], 'password' => $dbpassword)));
				if($user['User']['id'] == $this->Session->read('User.id')){
					$this->User->delete($user['User']['id']);
					$this->Session->setFlash('Your legend will live on!');
					$this->Session->destroy(); 
					$this->redirect(array('controller' => 'users', 'action' => 'login'));
				}else{
					$this->Session->setFlash('Wrong information');
					$this->redirect($this->referer());	
				}
			}
		}
		
		
	}
     
    function login() 
    { 
		if(!$this->Session->read('User.id')){
			if(empty($this->data) == false) 
			{ 
				if(($user = $this->User->validateLogin($this->data['User'])) == true) 
				{ 
					if($user['active'] == 1){
						$this->Session->write('User', $user); 
						$this->Session->setFlash('You\'ve successfully logged in.'); 
						$this->redirect(array('controller' => 'profiles', 'action' => 'index'));
						exit(); 
					}else{
						$this->Session->setFlash('Sorry your account has not been activated yet');
						$this->redirect(array('controller' => 'users', 'action' => 'login'));
					}
				} 
				else 
				{ 
					$this->Session->setFlash('Sorry, the information you\'ve entered is incorrect.'); 
					$this->redirect(array('controller' => 'users', 'action' => 'login')) ;
					exit(); 
				} 
			}
		}else{
			$this->Session->setFlash('You are already logged in man');
			$this->redirect(array('controller' => 'profiles', 'action' => 'index'));
		}
    } 
     
    function logout() 
    { 
        $this->Session->destroy('User'); 
        $this->Session->setFlash('You\'ve successfully logged out.'); 
        $this->redirect(array('controller' => 'users', 'action' => 'login')) ; 
    } 
         
    function __validateLoginStatus() 
    { 
        if($this->action != 'login' && $this->action != 'logout' && $this->action != 'register' ) 
        { 
            if($this->Session->check('User') == false) 
            { 
                $this->redirect('login'); 
                $this->Session->setFlash('The URL you\'ve followed requires you login.'); 
            } 
        } 
    }
	/*function table($id = null, $sort = -1){
		$user_id = $this->Session->read('User.id');
		if ($user_id != null){
			$this->loadModel('Body');
			$this->loadModel('Workout');
			$this->loadModel('Dailydiet');
			$metricMass =  $this->Session->read('User.metricMass');
			$metricLength = $this->Session->read('User.metricLength');
			$bodies = $this->Body->find('all', array('order' => array('Body.created DESC'), 'conditions' => array('user_id' => $id)),$metricMass, $metricLength);
			$workouts = $this->Workout->find('all', array('order' => array('Workout.created DESC'), 'conditions' => array('user_id' => $id)),$metricMass);
			$dailydiets = $this->Dailydiet->find('all', array('order' => array('Dailydiet.created DESC'), 'conditions' => array('user_id' => $id)));

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
					foreach($total['Workout'] as $workout){
						if($workout['exercise_id'] == 1){
							$temp = $this->Workout->find('first', array('conditions' => array('Workout.id' => $workout['id']) ),$metricMass );
							$bench[$count] = $this->compare($temp, 'bench', 1);
							$totalArray[$count]['Workout']['value1'] = $bench[$count]; 
						}elseif($workout['exercise_id'] == 2){
							$temp = $this->Workout->find('first', array('conditions' => array('Workout.id' => $workout['id']) ),$metricMass );
							$squat[$count] = $this->compare($temp, 'squat', 1);
							$totalArray[$count]['Workout']['value2'] = $squat[$count];
						}elseif($workout['exercise_id'] == 3){
							$temp = $this->Workout->find('first', array('conditions' => array('Workout.id' => $workout['id']) ),$metricMass );
							$deadlift[$count] = $this->compare($temp, 'deadlift', 1);
							$totalArray[$count]['Workout']['value3'] = $deadlift[$count]; 
						}
					}
				}
				if(isset($total['Dailydiet'])){
					$temp = $this->Dailydiet->find('all', array('conditions'=> array('Dailydiet.id' => $total['Dailydiet']['id']) ) );
					$totalArray[$count]['Dailydiet']['values'] = $this->dietCompare($temp, 1);
				}
				/*if(!isset($totals[$count])){
					$totals[$count] = 0;
				}
				if(!isset($bench[$count])){
					$bench[$count] = 0;
				}
				if(!isset($squat[$count])){
					$squat[$count] = 0;
				}
				if(!isset($deadlift[$count])){
					$deadlift[$count] = 0;
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