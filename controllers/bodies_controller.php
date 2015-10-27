<?php 
App::import('Sanitize');
class BodiesController extends AppController{
	var $name = 'Bodies';
	var $helpers = array('Form', 'Html');
	
	function json_getEntry(){
		$this->autoRender = false;
		$bodies = $this->Body->find('all', array('fields' => 'Body.created', 'recursive' => -1,  'conditions' => array('user_id' => $this->Session->read('User.id'))));
		echo json_encode($bodies);	
	}
	
	function json($date = null){
		$date = Sanitize::clean($date);
		$user_id = $this->Session->read('User.id');
		$test = $this->Body->find('first', array('conditions' => array('user_id' => $user_id, 'Body.created' => $date) ) );
		
		if (!isset($test['Body']['id'] ) ){
			$number = array(0 => 0);	
		}else{
			$number = array(0 => 1, 1 => $test['Body']['id']);
		}
		echo json_encode($number);
		$this->autoRender = false;
	}
	
	
	/*function index($date = null){
		$user_id = $this->Session->read('User.id');
		$this->set('bodies', $this->Body->find('first', array('conditions' => array('user_id' => $user_id, 'Body.created' => $date) ) ) );
		if(!$this->Session->read('User.id') ) {
			$this->Session->setFlash('You must be logged in to view Bodies index.');
			$this->redirect(array('controller' => 'users', 'action'=>'login'));
		}
	}*/
	
	function weightConvert($metric = null, $variable = null){
		if ($metric == 0){
			$imperial =  $variable * 2.2046;
			return number_format($imperial, 1);
		} else {
			$kg =  $variable * 	0.4536;
			return number_format($kg, 1);	
		}
	}
	
	function lengthConvert($metric = null, $variable = null){
		if($metric == 0){
			$imperial = $variable * 0.3937;
			return number_format($imperial, 1);
		}else{
			$cm = $variable * 2.54;
			return number_format($cm, 1);
		}
	}
	
	function createPost($data){
		$data = Sanitize::clean($data);
		$this->loadModel('Post');
		$this->Post->create();
		$newData['Post']['user_id'] = $data['Body']['user_id'];
		$string = '<p style = "color:#272824"><strong>Added Measurements!</strong></p>';
		$string = $string.'<p class = "createPost">';
			if(isset($data['Body']['weight']) && $data['Body']['weight'] != 0.0){
				$string = $string.'Weight: '.$data['Body']['weight'].' (kg) <br/>';
			}
			
			if(isset($data['Body']['bodyfat']) && $data['Body']['bodyfat'] != null){
				$string = $string.'Bodyfat: '.$data['Body']['bodyfat'].' (%) <br/>';
			}
			
			if(isset($data['Body']['waist']) && $data['Body']['waist'] != 0.0){
				$string = $string.'Waist: '.$data['Body']['waist'].' (cm) <br/>';
			}
			
			if(isset($data['Body']['hips']) && $data['Body']['hips'] != 0.0){
				$string = $string.'Hips: '.$data['Body']['hips'].' (cm) <br/>';
			}
			
			if(isset($data['Body']['chest']) && $data['Body']['chest'] != 0.0){
				$string = $string.'Chest: '.$data['Body']['chest'].' (cm) <br/>';
			}
			
			if(isset($data['Body']['arms']) && $data['Body']['arms'] != 0.0){
				$string = $string.'Arms: '.$data['Body']['arms'].' (cm) <br/>';
			}
			
			if(isset($data['Body']['thighs']) && $data['Body']['thighs'] != 0.0){
				$string = $string.'Thighs: '.$data['Body']['thighs'].' (cm) <br/>';
			}
			
			if(isset($data['Body']['forearms']) && $data['Body']['forearms'] != 0.0){
				$string = $string.'Forearms: '.$data['Body']['forearms'].' (cm) <br/>';
			}
			
			if(isset($data['Body']['calves']) && $data['Body']['calves'] != 0.0){
				$string = $string.'Calves: '.$data['Body']['calves'].' (cm) <br/>';
			}
			
			if(isset($data['Body']['shoulders']) && $data['Body']['shoulders'] != 0.0){
				$string = $string.'Shoulders: '.$data['Body']['shoulders'].' (cm) <br/>';
			}
			
			if(isset($data['Body']['neck']) && $data['Body']['neck'] != 0.0){
				$string = $string.'Neck: '.$data['Body']['neck'].' (cm) <br/>';
			}
		$string = $string.'</p>';
		$newData['Post']['body'] = $string;
		$this->Post->save($newData);
	}
	
	function add($date = null) {
		$date = Sanitize::clean($date);
		$this->layout = 'bare';
		$this->set('selectedDate', $date);
		$user_id = $this->Session->read('User.id');
		if (!$this->Session->read('User.id')){
				$this->redirect(array('controller' =>'users', 'action'=>'login'));
		} else {
			$this->Body->set($this->data);
			if(!$this->Body->validates()){
				$this->Session->setFlash('Fields must contain at most 4 numbers followed by 1 decimal point');
				$this->redirect(array('controller' => 'workouts', 'action' => 'index#measure'));
				
			}else{
				if (!empty($this->data)) {
					$this->Body->create();
					if($this->Session->read('User.metricMass') == 0){
						$this->data['Body']['weight'] = $this->weightConvert(1,$this->data['Body']['weight']);
					}
					if($this->Session->read('User.metricLength') == 0){
						$this->data['Body']['chest'] = $this->lengthConvert(1,$this->data['Body']['chest']);
						$this->data['Body']['arms'] = $this->lengthConvert(1,$this->data['Body']['arms']);
						$this->data['Body']['hips'] = $this->lengthConvert(1,$this->data['Body']['hips']);
						$this->data['Body']['waist'] = $this->lengthConvert(1,$this->data['Body']['waist']);
						$this->data['Body']['thighs'] = $this->lengthConvert(1,$this->data['Body']['thighs']);
						$this->data['Body']['forearms'] = $this->lengthConvert(1,$this->data['Body']['forearms']);
						$this->data['Body']['calves'] = $this->lengthConvert(1,$this->data['Body']['calves']);
						$this->data['Body']['shoulders'] = $this->lengthConvert(1,$this->data['Body']['shoulders']);
						$this->data['Body']['neck'] = $this->lengthConvert(1,$this->data['Body']['neck']);
					}
					//pr($this->data);die;
					if ($this->Body->save($this->data)) {
						$this->createPost($this->data);
						$this->Session->setFlash('Your measurements have been saved.');
						$this->redirect(array('controller' => 'workouts', 'action' => 'index#measure'));
					}
				}
			}
		}
	}

	function edit($id = null, $date = null) {
		$id = Sanitize::clean($id);
		$date = Sanitize::clean($date);
		$this->layout = 'bare';
		$this->set('id', $id);
		$this->set('selectedDate', $date);
		$user_id = $this->Session->read('User.id');
		$body = $this->Body->find('first', array('conditions' => array('user_id' => $this->Session->read('User.id'), 'Body.created' => $date ) ) );
		$contentId = $this->Body->find('first', array('conditions' => array('user_id' => $user_id, 'Body.id' => $id) ) );
		if (!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action'=>'login'));
		} else {
			$this->Body->set($this->data);
			if(!$this->Body->validates()){
				$this->Session->setFlash('Fields must contain at most 4 numbers followed by 1 decimal point');
				$this->redirect(array('controller' => 'workouts', 'action' => 'index#measure'));
				
			}else{
				$this->Body->id = $id;
				if (empty($this->data)) {
					$this->data = $this->Body->read();
					if($this->Session->read('User.metricMass') == 0){
						$this->data['Body']['weight'] = $this->weightConvert($this->Session->read('User.metricMass'),$body['Body']['weight']);
					}
					if($this->Session->read('User.metricLength') == 0){
						$this->data['Body']['chest'] = $this->lengthConvert($this->Session->read('User.metricLength'),$this->data['Body']['chest']);
						$this->data['Body']['arms'] = $this->lengthConvert($this->Session->read('User.metricLength'),$this->data['Body']['arms']);
						$this->data['Body']['hips'] = $this->lengthConvert($this->Session->read('User.metricLength'),$this->data['Body']['hips']);
						$this->data['Body']['waist'] = $this->lengthConvert($this->Session->read('User.metricLength'),$this->data['Body']['waist']);
						$this->data['Body']['thighs'] = $this->lengthConvert($this->Session->read('User.metricLength'),$this->data['Body']['thighs']);
						$this->data['Body']['forearms'] = $this->lengthConvert($this->Session->read('User.metricLength'),$this->data['Body']['forearms']);
						$this->data['Body']['calves'] = $this->lengthConvert($this->Session->read('User.metricLength'),$this->data['Body']['calves']);
						$this->data['Body']['shoulders'] = $this->lengthConvert($this->Session->read('User.metricLength'),$this->data['Body']['shoulders']);
						$this->data['Body']['neck'] = $this->lengthConvert($this->Session->read('User.metricLength'),$this->data['Body']['neck']);
					}
				} else {
						if($this->Session->read('User.metricMass') == 0){
							$this->data['Body']['weight'] = $this->weightConvert(1,$this->data['Body']['weight']);
						}
						if($this->Session->read('User.metricLength') == 0){
							$this->data['Body']['chest'] = $this->lengthConvert(1,$this->data['Body']['chest']);
							$this->data['Body']['arms'] = $this->lengthConvert(1,$this->data['Body']['arms']);
							$this->data['Body']['hips'] = $this->lengthConvert(1,$this->data['Body']['hips']);
							$this->data['Body']['waist'] = $this->lengthConvert(1,$this->data['Body']['waist']);
							$this->data['Body']['thighs'] = $this->lengthConvert(1,$this->data['Body']['thighs']);
							$this->data['Body']['forearms'] = $this->lengthConvert(1,$this->data['Body']['forearms']);
							$this->data['Body']['calves'] = $this->lengthConvert(1,$this->data['Body']['calves']);
							$this->data['Body']['shoulders'] = $this->lengthConvert(1,$this->data['Body']['shoulders']);
							$this->data['Body']['neck'] = $this->lengthConvert(1,$this->data['Body']['neck']);
						}
						if ($this->Body->save($this->data['Body'])) {
							$this->Session->setFlash('Your measurements have been updated.');
							$this->redirect(array('controller' => 'workouts', 'action' => 'index#measure'));
							
						}
					}
				}
			}
		}
		
	function delete($id) {
		$id = Sanitize::clean($id);
		$body = $this->Body->find('first',array('conditions' => array('user_id' => $this->Session->read('User.id'), 'id' => $id ) ) );
		if (!$this->Session->read('User.id')) {
			$this->redirect(array('controller' => 'posts', 'action'=>'index'));
		} else {
			$this->Body->delete($id);
			$this->Session->setFlash('Body Stats for '.$body['Body']['created'].' have been deleted');
			$this->redirect(array('controller' => 'workouts', 'action' => 'index#measure'));
		}
    }
}
?>