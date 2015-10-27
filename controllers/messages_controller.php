<?php 
App::import('Sanitize');
class MessagesController extends AppController{
		var $name = 'Messages';
	
	/*function deleteMessage($id = null, $origin = null){
		$this->loadModel('Message_set');
		$message = $this->Message_set->find('first', array('conditions' => array('Message_set.id' => $id) ) );
		if($message != null){
			if($message['Message_set']['user_id'] != $this->Session->read('User.id') && $message['Message_set']['recipient_id'] != $this->Session->read('User.id')){
				$this->Session->setFlash('You must be either the sender or the recipient to delete this message');
				$this->redirect(array('controller' => 'users', 'action' => 'login'));	
			}else{
				$this->Message_set->id = $id;
				if($this->Session->read('User.id') == $message['Message_set']['user_id']){
					$this->Message_set->saveField('user_delete', 1);
					$messageUpdate = $this->Message_set->find('first', array('conditions' => array('Message_set.id' => $id) ) );
					if($messageUpdate['Message_set']['recipient_delete'] == 1){
						$contents = $this->Message->find('all', array('conditions' => array('message_set_id' => $id) ) );
						foreach($contents as $content){
							$this->Message->delete($content['Message']['id']);	
						}
						$this->Message_set->delete($id);			
					}
				}
				
				if($this->Session->read('User.id') == $message['Message_set']['recipient_id']){
					$this->Message_set->saveField('recipient_delete', 1);
					$messageUpdate = $this->Message_set->find('first', array('conditions' => array('Message_set.id' => $id) ) );
					if($messageUpdate['Message_set']['user_delete'] == 1){
						$contents = $this->Message->find('all', array('conditions' => array('message_set_id' => $id) ) );
						foreach($contents as $content){
							$this->Message->delete($content['Message']['id']);	
						}
						$this->Message_set->delete($id);			
					}		
				}
				$this->Session->setFlash('The Message has been deleted');
				$this->redirect($this->referer());
			}
		}else{
			$this->Session->setFlash('This message doesnt exist sorry brah!');
			$this->redirect(array('action' => 'index'));	
		}	
	}*/
	
	function ajax_messages(){
		if(!$this->Session->read('User.id')){
			$this->redirect($this->referer());	
		}else{
			$this->layout = 'ajax';
			$this->loadModel('Message_set');
			$messages = $this->Message_set->find('all', array('conditions' =>
				array('OR' => array(
						array('recipient_id' => $this->Session->read('User.id'), 'recipient_delete' => 0),
						array('user_id' => $this->Session->read('User.id'), 'user_delete' => 0))
					),'order' => array('Message_set.modified DESC'),
				)
			);
			$this->set('messages', $messages);
			
		}
		
	}
	
	function ajax_delete($id = null){
		$id = Sanitize::clean($id);
		$this->autoRender = false;
		$this->loadModel('Message_set');
		$message = $this->Message_set->find('first', array('conditions' => array('Message_set.id' => $id) ) );
		if($message != null){
			if($message['Message_set']['user_id'] != $this->Session->read('User.id') && $message['Message_set']['recipient_id'] != $this->Session->read('User.id')){
				$this->Session->setFlash('You must be either the sender or the recipient to delete this message');
				$this->redirect(array('controller' => 'users', 'action' => 'login'));	
			}else{
				$this->Message_set->id = $id;
				if($this->Session->read('User.id') == $message['Message_set']['user_id']){
					$this->Message_set->saveField('user_delete', 1);
					$messageUpdate = $this->Message_set->find('first', array('conditions' => array('Message_set.id' => $id) ) );
					if($messageUpdate['Message_set']['recipient_delete'] == 1){
						$contents = $this->Message->find('all', array('conditions' => array('message_set_id' => $id) ) );
						foreach($contents as $content){
							$this->Message->delete($content['Message']['id']);	
						}
						$this->Message_set->delete($id);			
					}
				}
				
				if($this->Session->read('User.id') == $message['Message_set']['recipient_id']){
					$this->Message_set->saveField('recipient_delete', 1);
					$messageUpdate = $this->Message_set->find('first', array('conditions' => array('Message_set.id' => $id) ) );
					if($messageUpdate['Message_set']['user_delete'] == 1){
						$contents = $this->Message->find('all', array('conditions' => array('message_set_id' => $id) ) );
						foreach($contents as $content){
							$this->Message->delete($content['Message']['id']);	
						}
						$this->Message_set->delete($id);			
					}		
				}
			}
		}else{
		}	
	}
	
	function ajax_reply($message_set_id = null, $text = null){
		$message_set_id = Sanitize::clean($message_set_id);
		$text = Sanitize::clean($text);
		if(!$this->Session->read('User.id')){
			$this->Session->setFlash('You must be logged in to access this page');
			$this->redirect($this->referer());	
		}else{
			$this->data['Message']['user_id'] = $this->Session->read('User.id');
			$this->data['Message']['message_set_id'] = $message_set_id;
			$this->data['Message']['content'] = $text;
			if(!empty($this->data)){
				$this->layout = 'ajax';
				$this->Message->create();
				$this->data = Sanitize::clean($this->data);
				$this->Message->save($this->data);
				$messageID = $this->Message->getInsertID();
				$this->loadModel('Message_set');
				$this->loadModel('User');
				$message_set = $this->Message_set->find('first', array('conditions' => array('Message_set.id' => $this->data['Message']['message_set_id']) ) );
				if($this->Session->read('User.id') == $message_set['Message_set']['recipient_id']){
					$user =  $this->User->find('first', array('conditions' => array('User.id' => $message_set['Message_set']['user_id']) ) );
				}else{
					$user =  $this->User->find('first', array('conditions' => array('User.id' => $message_set['Message_set']['user_id']) ) );
				}
				if($user['User']['notification_type1'] == 1){
					$this->loadModel('Notification');
					$this->Notification->create();
					$noteID = $this->Notification->getInsertID();
					$this->Notification->id = $noteID;
					$this->Notification->saveField('user_id', $this->Session->read('User.id'));
					if($this->Session->read('User.id') == $message_set['Message_set']['recipient_id']){
						$this->Notification->saveField('recipient_id', $message_set['Message_set']['user_id']);	
					}else{
						$this->Notification->saveField('recipient_id', $message_set['Message_set']['recipient_id']);	
					}
					$this->Notification->saveField('content', 'has sent you a message');
					$this->Notification->saveField('source_controller', 'posts');
					$this->Notification->saveField('source_action', 'index');
					$this->Notification->saveField('type', 1);
					$this->Notification->saveField('source_id', '#message_'.$message_set['Message_set']['id']);
				}
				
				//reseting user and recipient delete back to zero so both can view reply.
				$this->Message_set->id = $message_set['Message_set']['id'];
				$this->Message_set->saveField('user_delete', 0);
				$this->Message_set->saveField('recipient_delete', 0);
				$content = $this->Message->find('first', array('conditions' => array('Message.id' => $messageID)));
				$this->set(compact('content'));
			}
		}
	}
	
	/*function reply(){
		if(!$this->Session->read('User.id')){
			$this->Session->setFlash('You must be logged in to access this page');
			$this->redirect($this->referer());	
		}else{
			if(!empty($this->data)){
				$this->Message->create();
				$this->Message->save($this->data);
				$messageID = $this->Message->getInsertID();
				$this->loadModel('Message_set');
				$this->loadModel('User');
				$message_set = $this->Message_set->find('first', array('conditions' => array('Message_set.id' => $this->data['Message']['message_set_id']) ) );
				if($this->Session->read('User.id') == $message_set['Message_set']['recipient_id']){
					$user =  $this->User->find('first', array('conditions' => array('User.id' => $message_set['Message_set']['user_id']) ) );
				}else{
					$user =  $this->User->find('first', array('conditions' => array('User.id' => $message_set['Message_set']['user_id']) ) );
				}
				if($user['User']['notification_type1'] == 1){
					$this->loadModel('Notification');
					$this->Notification->create();
					$noteID = $this->Notification->getInsertID();
					$this->Notification->id = $noteID;
					$this->Notification->saveField('user_id', $this->Session->read('User.id'));
					if($this->Session->read('User.id') == $message_set['Message_set']['recipient_id']){
						$this->Notification->saveField('recipient_id', $message_set['Message_set']['user_id']);	
					}else{
						$this->Notification->saveField('recipient_id', $message_set['Message_set']['recipient_id']);	
					}
					$this->Notification->saveField('content', 'has sent you a message');
					$this->Notification->saveField('source_controller', 'posts');
					$this->Notification->saveField('source_action', 'index');
					$this->Notification->saveField('type', 1);
					$this->Notification->saveField('source_id', '#message_'.$message_set['Message_set']['id']);
				}
				
				//reseting user and recipient delete back to zero so both can view reply.
				$this->Message_set->id = $message_set['Message_set']['id'];
				$this->Message_set->saveField('user_delete', 0);
				$this->Message_set->saveField('recipient_delete', 0);
				$this->redirect($this->referer());
			}
		}
	}*/
	
	function compose($id = null /*$title = null, $content = null*/){
		$id = Sanitize::clean($id);
		if ($this->Session->read('User.id') != $id){
			$this->Session->setFlash('You must be logged in as the correct user to access this page');
			$this->redirect($this->referer());
		}else{
			if(!empty($this->data)){
				$this->loadModel('User');
				$nameExist = $this->User->find('first', array('conditions' => array('username' => $this->data['Message']['To'])));
				if($nameExist == null){
					$this->Session->setFlash('The user specified does not exsist, sorry');	
					$this->redirect(array('controller' => 'posts', 'action' => 'index', '#message'));
				}else{
						//$this->data['Message_set']['recipient_id'] = $nameExist['User']['id'];
						$userExist = $nameExist['User']['id'];
						$this->Message->create();
						$this->Message->set($this->data);
						
						if(!$this->Message->validates()){
							$this->Session->setFlash('Message must contain at most 200 alphaNumeric characters');	
							$this->redirect(array('controller' => 'posts', 'action' => 'index', '#message'));
							
						}else{
							$this->Message->save($this->data);
							$messageID = $this->Message->getInsertID();
							$this->Session->setFlash('Message has been sent');
							
							//creating message_set
							$this->loadModel('Message_set');
							$this->Message_set->create();
							$this->Message_set->save();
							$message_set_id = $this->Message_set->getInsertID();
							$this->Message_set->id = $message_set_id;
							$this->Message_set->saveField('message_id', $messageID);
							$this->Message_set->saveField('recipient_id', $userExist);
							$this->Message_set->saveField('user_id', $this->Session->read('User.id'));
							
							//updating message with message_set_id
							$this->Message->id = $messageID;
							$this->Message->saveField('message_set_id', $message_set_id);
							
							$user = $this->User->find('first', array('conditions' => array('id' => $userExist) ) );
							if($user['User']['notification_type1'] == 1){
								$this->loadModel('Notification');
								$this->Notification->create();
								$noteID = $this->Notification->getInsertID();
								$this->Notification->id = $noteID;
								$this->Notification->saveField('user_id', $this->Session->read('User.id'));
								$this->Notification->saveField('recipient_id', $userExist);
								$this->Notification->saveField('content', 'has sent you a message');
								$this->Notification->saveField('source_controller', 'posts');
								$this->Notification->saveField('source_action', 'index');
								$this->Notification->saveField('type', 1);
								$this->Notification->saveField('source_id', '#message_'.$message_set_id);
							}
							
							$this->redirect(array('controller' => 'posts', 'action' => 'index','#message'));
						}
				}
			}
		}
	}
}