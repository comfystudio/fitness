<?php 
class FoodentriesController extends AppController{
		var $name = 'Foodentries';
		
		
		/*function index($id = null){
			$this->set('foodentries', $this->Foodentry->find('all', array('conditions' => array('dailydiet_id' => $id) ) ) );
		}*/
		/*function deleteIndex($id = null){
			$this->set('foodentries', $this->Foodentry->find('all', array('conditions' => array('dailydiet_id' => $id) ) ) );	
		}*/
		
		/*function delete($id = null){
			$user_id = $this->Session->read('User.id');
			$foodentry_userid = $this->Foodentry->read('user_id');
			$dailydiet_id = $this->Foodentry->find('first', array('conditions' => array('Foodentry.id' =>$id ) ) );
			if (!$this->Session->read('User.id') || $user_id != $foodentry_userid['Foodentry']['user_id']) {
				$this->redirect(array('controller' => 'users', 'action'=>'index'));
			} else {
				$this->Foodentry->delete($id);
				$this->Session->setFlash('The Foodentry with id: '.$id.' has been deleted.');
				$this->redirect(array('controller'=>'dailydiets', 'action'=>'view',$dailydiet_id['Foodentry']['dailydiet_id']));
			}
		}
		
		function add($id = null){
			$this->loadModel('Food');
			$this->loadModel('Dailydiet');
			$this->set('foods', $this->Food->find('all'));
			$this->set('dailydiets', $this->Dailydiet->find('first', array('conditions' =>array('Dailydiet.id' => $id) ) ) );
			$dailydiet_id = $this->Foodentry->find('first', array('conditions' => array('Foodentry.id' =>$id ) ) );
			if(!$this->Session->read('User.id')){
				$this->redirect(array('controller' => 'users', 'action' => 'index') );	
			}else{
				if(!empty($this->data)){
					$this->Foodentry->create();	
					if ($this->Foodentry->save($this->data)){
						$this->Session->setFlash('Your daily diet has been added!');
						$this->redirect(array('controller'=>'dailydiets', 'action'=>'index') );
					}	
				}
			}
		}
		
		function edit($id = null){
			$this->loadModel('Food');
			$this->set('foods', $this->Food->find('all'));
			$user_id = $this->Foodentry->read('user_id');
			$dailydiet_id = $this->Foodentry->find('first', array('conditions' => array('Foodentry.id' =>$id ) ) );
			if(!$this->Session->read('User.id') || $this->Session->read('User.id') != $user_id['Foodentry']['user_id']){
				$this->redirect(array('controller' => 'users', 'action' => 'index'));
			} else {
				$this->Foodentry->id = $id;
				if(empty($this->data)){
					$this->data = $this->Foodentry->read();	
				} else{
					if($this->Foodentry->save($this->data)){
						$this->Session->setFlash('Your daily meal has been edited');
						$this->redirect(array('controller' =>'dailydiets', 'action' => 'view', $dailydiet_id['Foodentry']['dailydiet_id']));
					}	
				}
			}	
		}*/
}
?>