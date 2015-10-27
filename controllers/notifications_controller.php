<?php 
App::import('Sanitize');
class NotificationsController extends AppController{
		var $name = 'Notifications';
		
		function index($id = null){
			$id = Sanitize::clean($id);
			if($this->Session->read('User.id') != $id){
				$this->Session->setFlash('You must be the correct user to view this notification index');
				$this->redirect(array('controller' => 'users', 'action' => 'login'));	
			}else{
				$notifications2 = $this->Notification->find('all', array('conditions' => array('recipient_id' => $this->Session->read('User.id'), 'is_read' => 0) ) );
				if (isset($this->params['requested'])) {
					return $notifications2;
				}
				
				$notifications = $this->Notification->find('all', array('conditions' => array('recipient_id' => $id) ) );
				$this->set('notifications', $notifications);
				foreach($notifications as $item){
					$this->Notification->id = $item['Notification']['id'];
					$this->Notification->saveField('is_read', 1);	
				}
				$this->loadModel('User');
				$this->set('users', $this->User->find('all'));
			}
		}
		
		function ajax_delete($id = null, $url = null){
			$id = Sanitize::clean($id);
			$url = Sanitize::clean($url);
			$note =  $this->Notification->find('first', array('conditions' => array('Notification.id' => $id)));
			if($note != null){
				if($this->Session->read('User.id') != $note['Notification']['recipient_id']){
					$this->Session->setFlash('You must be logged in as the correct user to delete this notification');	
					$this->redirect(array('controller' => 'users', 'action' => 'login'));
				}else{
					$this->layout = 'ajax';
					$this->Notification->delete($id);
				}
			}else{
				$this->layout = 'ajax';	
			}
		}
}
?>