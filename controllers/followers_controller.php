<?php 
App::import('Sanitize');
class FollowersController extends AppController{
		var $name = 'Followers';
		
	function getUserFollowings($id = null) {
		$id = Sanitize::clean($id);
		$userFollowings = $this->Follower->find('all', array('recursive' => -1, 'conditions' => array('user_id' => $id) ) );
		if (isset($this->params['requested'])) {
			return $userFollowings;
		}
		
	}
	
	function getUserFollowed($id = null) {
		$id = Sanitize::clean($id);
		$userFollowed = $this->Follower->find('all', array('recursive' => -1, 'conditions' => array('following_id' => $id ) ) );
		if (isset($this->params['requested'])) {
			return $userFollowed;
		}
		
	}
	
	function add($id = null, $user_id = null){
		$id = Sanitize::clean($id);
		$user_id = Sanitize::clean($user_id);
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}else{
			$this->layout = 'ajax';
			$this->Follower->create();
			$this->data['Follower']['user_id'] = $this->Session->read('User.id');
			$this->data['Follower']['following_id'] = $id;
			$this->Follower->save($this->data);
			
			$this->loadModel('User');
			$user = $this->User->find('first', array('conditions' => array('id' => $id) ) );
			if($user['User']['notification_type3'] == 1){
				$this->loadModel('Notification');
				$this->Notification->create();
				$noteID = $this->Notification->getInsertID();
				$this->Notification->id = $noteID;
				$this->Notification->saveField('user_id', $this->Session->read('User.id'));
				$this->Notification->saveField('recipient_id', $this->data['Follower']['following_id']);
				$this->Notification->saveField('content', 'is now following you');
				$this->Notification->saveField('source_controller', 'users');
				$this->Notification->saveField('source_action', 'view');
				$this->Notification->saveField('type', 3);
				$this->Notification->saveField('source_id', $this->Session->read('User.id'));
			}
			$this->set(compact('user_id'));
		}
	}
	
	function delete($id = null, $user_id = null){
		$id = Sanitize::clean($id);
		$user_id = Sanitize::clean($user_id);
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));
		}else{
			$this->layout = 'ajax';
			$temp = $this->Follower->find('first', array('conditions' => array('following_id' => $id) ) );
			$this->Follower->delete($temp['Follower']['id']);
			
			$this->loadModel('User');
			$user = $this->User->find('first', array('conditions' => array('id' => $temp['Follower']['following_id']) ) );
			if($user['User']['notification_type3'] == 1){
				$this->loadModel('Notification');
				$this->Notification->create();
				$noteID = $this->Notification->getInsertID();
				$this->Notification->id = $noteID;
				$this->Notification->saveField('user_id', $temp['Follower']['user_id']);
				$this->Notification->saveField('recipient_id', $temp['Follower']['following_id']);
				$this->Notification->saveField('content', 'is no longer following you');
				$this->Notification->saveField('source_controller', 'users');
				$this->Notification->saveField('source_action', 'view');
				$this->Notification->saveField('type', 3);
				$this->Notification->saveField('source_id', $temp['Follower']['user_id']);	
			}
			$this->set(compact('user_id'));
		}
	}
	
	
}
	