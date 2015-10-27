<?php 
App::import('Sanitize');
class WorkoutsController extends AppController{
		var $name = 'Workouts';
		var $helpers = array('Html', 'Form', 'Js' => array('Jquery')); 
		var $components = array('RequestHandler');

		
	function index(){
		if (!$this->Session->read('User.id')){
			$this->Session->setFlash('You must be logged in to view this page');
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}else{
			$this->loadModel('User');
			$user = $this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('User.id') ) ) );
			$date = date("Y-m-d");
			$frequents = $this->Workout->find('all', array('fields' => 'DISTINCT Workout.exercise_id', 'limit' => 8, 'recursive' => -1, 'order' => 'Workout.created DESC', 'conditions' => array('user_id' => $this->Session->read('User.id') ) ) );
			$workouts = $this->Workout->find( 'all', array( 'conditions' => array('Workout.created' => $date, 'user_id' => $this->Session->read('User.id')) ),$this->Session->read('User.metricMass') );
			$this->set(compact('user', 'workouts', 'date', 'frequents'));
		}
	}
		
	function json_getEntry(){
		$this->autoRender = false;
		$workouts = $this->Workout->find('all', array('fields' => 'Workout.created', 'recursive' => -1,  'conditions' => array('user_id' => $this->Session->read('User.id'))));
		echo json_encode($workouts);
			
	}
	
	function ajax_results($category = 0, $subcategory = 9){
		$category = Sanitize::clean($category);
		$subcategory = Sanitize::clean($subcategory);
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}else{
			$this->layout = 'ajax';
			$this->loadModel('Exercise');
			if($subcategory == 9){
				$results = $this->Exercise->find('all', array('fields' => array('DISTINCT Exercise.id', 'name'), 'recursive' => -1, 'conditions' => array('category' => $category) ) );
			}else{
				$results = $this->Exercise->find('all', array('fields' => array('DISTINCT Exercise.id', 'name'), 'recursive' => -1, 'conditions' => array('category' => $category, 'subcat' => $subcategory) ) );
			}
			$this->set(compact('results'));	
		}
		
		
	}
		
	function ajax_workout ( $date = null, $id = null ) {
		//For displaying workouts when selected by calendar
		$date = Sanitize::clean($date);
		$id = Sanitize::clean($id);
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}else{
			$this->layout = 'ajax';
			$frequents = $this->Workout->find('all', array('fields' => 'DISTINCT Workout.exercise_id', 'limit' => 8, 'recursive' => -1, 'order' => 'Workout.created DESC', 'conditions' => array('user_id' => $this->Session->read('User.id') ) ) );
			$metricMass = $this->Session->read('User.metricMass');
			$workouts = $this->Workout->find( 'all', array( 'conditions' => array('Workout.created' => $date, 'user_id' => $this->Session->read('User.id')) ),$metricMass );
			$this->set(compact('frequents', 'workouts', 'date'));	
		}
	}
	
	function ajax_search($search = null){
		$search = Sanitize::clean($search);
		$this->loadModel('Exercise');
		$this->layout = 'ajax';
		$exercises = $this->Exercise->find('all', array('fields' => array('Exercise.id', 'Exercise.name'), 'conditions' => array('name LIKE' => '%'.$search.'%') ) );
		$this->set(compact('exercises'));
	}
	
	function getExercise($id){
		$id = Sanitize::clean($id);
		$this->loadModel('Exercise');
		$exercises = $this->Exercise->find('all');
		$result = NULL;
		foreach($exercises as $exercise){
			if($id == $exercise['Exercise']['id']){
				$result = $exercise;
				break;
			}
		}
		if (isset($this->params['requested'])) {
			return $result;
		}
		if($this->RequestHandler->isAjax()){
			$this->autoRender = false;
			return json_encode($result);
		}
		
		return $result;

	}
	
	function ajax_addworkout ( $id = null, $date = null) {
		$id = Sanitize::clean($id);
		$date = Sanitize::clean($date);
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}else{
			$this->layout = 'ajax';
			$this->loadModel('Exercise');
			$this->loadModel('Activity');
			$exercise = $this->Exercise->find('first', array('conditions' => array('Exercise.id' => $id) ) );
			
			$this->set(compact('exercise', 'date'));
			$workout = $this->Workout->find('first', array('conditions' => array('user_id' => $this->Session->read('User.id'), 'Workout.created' => $date, 'Workout.exercise_id' => $id) ) );
			if(!isset($workout['Workout']['user_id'])){
	
			}else{
				$this->autoRender = false;
				$temp = '#'.$exercise['Exercise']['name'];
				return $temp;
			}
		}
	}
	
	function weightConvert($convert = null, $variable = null){
		if ($convert == 0){
			$imperial =  $variable * 2.2046;
			return number_format($imperial, 1);	
		} else {
			$kg =  $variable * 	0.4536;
			return number_format($kg, 1);	
		}
	}
	
	function ajax_deleteOldExercise($date = null, $exercise_id = null){
		$date = Sanitize::clean($date);
		$exercise_id = Sanitize::clean($exercise_id);
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}else{
			$workout = $this->Workout->find('first', array('conditions' => array('user_id' => $this->Session->read('User.id'), 'Workout.created' => $date, 'Workout.exercise_id' => $exercise_id) ) );
			$this->loadModel('Activity');
			foreach($workout['Activity'] as $activity){
				$id = $activity['id'];
				$this->Activity->id = $id;
				$this->Activity->delete($id);
			}
			$workout_id  = $workout['Workout']['id'];
			$this->Workout->id = $workout_id;
			$this->Workout->delete($workout_id);
			//$this->Session->setFlash('Workout has been deleted');
			//$this->redirect(array('controller' => 'workouts', 'action' => 'index'));
		}
	}
	
	function ajax_deleteOldSet($id = null){
		$id = Sanitize::clean($id);
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}else{
			$this->loadModel('Activity');
			$this->Activity->delete($id);
		}
	}
	
	function save($date = null) {
		$date = Sanitize::clean($date);
		//saves multiple activites
		$this->loadModel( "Activity" );
		if ( !empty ( $this->data ) ) {
			$this->data = Sanitize::clean($this->data);
			foreach ($this->data as $key => $workout){
				$total = count($workout);
				$count = 0;
				$notes = '';
				if(isset($workout['Workout']['Activity']['id'])){
					$workout_id = $workout['Workout']['Activity']['id'];
					$this->Workout->id = $workout_id;
				}else{
					$this->Workout->create();
					$workoutData = array('Workout' => array('user_id' =>$this->Session->read('User.id'), 'exercise_id' => $key, 'created' => $date) );
					$this->Workout->save($workoutData);
					$workout_id = $this->Workout->getInsertID();
				}
				foreach ( $workout as $activity ) {
					//checking if note has been added then assgins it to a var.
					if(isset($activity['Activity']['notes'])){
						$notes = $activity['Activity']['notes'];	
					}
					
					if ( !empty ( $activity['Activity']['id'] ) ) {
						$this->Activity->id = $activity['Activity']['id'];
					} else {
						$activity['Activity']['workout_id'] = $workout_id;
						$this->Activity->create();
					}
					if($this->Session->read('User.metricMass') == 0){
						$activity['Activity']['value'] = $this->weightConvert(1,$activity['Activity']['value']);	
					}
					
					if(!isset($activity['Activity']['reps']) && !isset($activity['Activity']['value'])){
						if($activity['Activity']['time'] != NULL || $activity['Activity']['distance'] != NULL){
							if($this->Session->read('User.metricLength') == 0){
								$activity['Activity']['distance'] = $activity['Activity']['distance']*1.6093;	
							}
							$this->Activity->save ( $activity );
						}else{
							$count++;
							$this->Activity->delete($activity['Activity']['id']);
						}
						
					}elseif(!isset($activity['Activity']['time']) && !isset($activity['Activity']['distance'])){
						if($activity['Activity']['reps'] != NULL || $activity['Activity']['value'] != NULL ){
							$this->Activity->save ( $activity );
						}else{
							$count++;
							$this->Activity->delete($activity['Activity']['id']);
						}
					}
				}
				$this->Workout->id = $workout_id;
				$this->Workout->saveField('note', $notes);
				if($count >=$total){
					$this->Workout->delete($workout_id);	
				}
			}
		}
		$this->createPost($date);
		$this->Session->setFlash('Your workout has been saved');
		$this->redirect($this->referer());
	}
	
	function createPost($date){
		$date = Sanitize::clean($date);
		$workouts = $this->Workout->find('all', array('conditions' => array('Workout.created' => $date, 'user_id' => $this->Session->read('User.id')) ) );
		$count = 0;
		foreach ($workouts as $workout){
			if($workout['Workout']['new'] != 0){
				$count++;	
			}
		}
		
		if($count == 0){
			$this->loadModel('Post');
			$this->Post->create();
			$newData['Post']['user_id'] = $this->Session->read('User.id');
			$string = '<p style = "color:#272824"><strong>Added Workout!</strong></p><br/>';
			foreach ($workouts as $workout){
				$this->Workout->id = $workout['Workout']['id'];
				$this->Workout->saveField('new', 1);
				$exerciseName = $this->getExercise($workout['Workout']['exercise_id']);
				$string = $string.'<p style = "color:#272824"><strong>'.$exerciseName['Exercise']['name'].'</strong></p>';
				$string = $string.'<p class = "createPost">';
					foreach($workout['Activity'] as $activity){
						if(isset($activity['value']) && $activity['value'] != 0){
							$string = $string.$activity['reps'].' reps x '.round($activity['value']).' (kg) <br/>';	
						}elseif(isset($activity['time']) && isset($activity['distance'])){
							$string = $string.round($activity['distance'],1).' kilometres (km) in '.$activity['time'].' <br/>';
						}
						
					}
				if(isset($workout['Workout']['note'])){
					$string = $string.'<br/><strong>Note: </strong>'.$workout['Workout']['note'].' <br/><br/>';
				}
				$string = $string.'</p>';
			}
			$newData['Post']['body'] = $string;
			$this->Post->save($newData);
		}
	}
	
	
	
	/*function ajax_activity_remove($id = null){
		$this->autoRender = false;
		$this->loadModel('Activity');
		$deleteActivity = $this->Activity->find('first', array('conditions' => array('Activity.id' => $id)));
		if (!empty($deleteActivity ) ){
			$activity_id = $deleteActivity['Activity']['id'];
			$this->Activity->delete($activity_id);	
		}
		
	}*/
	
	/*function ajax_category($cat = null, $subcat = null){
		$this->layout = 'ajax';
		$this->loadModel('exercise');
		if($subcat == 9){
			$temp = $this->exercise->find('list', array('conditions' => array('category' => $cat) ) );
		}else{
			$temp = $this->exercise->find('list', array('conditions' => array('category' => $cat, 'subcat' => $subcat) ) );
		}
		$this->set('exercises', $temp);
	}*/
	
	function ajax_delete($id = null) {
		$id = Sanitize::clean($id);
		$this->autoRender = false;
		$this->loadModel('Activity');
		$activities = $this->Activity->find('all', array('conditions' => array('workout_id' => $id ) ) );
		foreach($activities as $item) {
			$activities_id = $item['Activity']['id'];
			$this->Activity->delete($activities_id);	
		}
		$this->Workout->delete($id);
	}
}
?>