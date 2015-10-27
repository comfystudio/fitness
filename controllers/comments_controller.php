<?php 
App::import('Sanitize');
class CommentsController extends AppController{
	var $name = 'comments';
	
	/*function add() {
		if (!$this->Session->read('User')) {
			$this->redirect(array('controller'=>'posts', 'action'=>'index'));
		} else {
			if (!empty($this->data)) {
				$this->data['Comment']['user_id'] = $this->Session->read('User.id');
				if ($this->Comment->save($this->data)) {
					$commentID = $this->Comment->getInsertID();
					$this->Session->setFlash('Your comment has been saved.');
				
				$this->loadModel('Post');
				$this->loadModel('User');
				$post = $this->Post->find('first', array('conditions' => array('Post.id' => $this->data['Comment']['post_id'])));
				$user = $this->User->find('first', array('conditions' => array('id' => $post['Post']['user_id']) ) );
					if($user['User']['notification_type2'] == 1){	
						$this->loadModel('Notification');
						$this->Notification->create();
						$noteID = $this->Notification->getInsertID();
						$this->Notification->id = $noteID;
						$this->Notification->saveField('user_id', $this->Session->read('User.id'));
						$this->Notification->saveField('recipient_id', $post['Post']['user_id']);
						$this->Notification->saveField('content', 'has commented on your post');
						$this->Notification->saveField('source_controller', 'posts');
						$this->Notification->saveField('source_action', 'index/999');
						$this->Notification->saveField('type', 2);
					}	
					$this->redirect($this->referer());
				}
			}
		}
	}*/
	
	function ajax_add($data = null, $post_id = null) {
		$data = Sanitize::clean($data);
		$post_id = Sanitize::clean($post_id);
		if (!$this->Session->read('User')) {
			$this->redirect(array('controller'=>'posts', 'action'=>'index'));
		} else {
			$this->layout = 'ajax';
			if (!empty($data) && !empty($post_id)) {
				$this->data['Comment']['user_id'] = $this->Session->read('User.id');
				$this->data['Comment']['text'] = $data;
				$this->data['Comment']['post_id'] = $post_id;
				$this->Comment->save($this->data);
				$commentID = $this->Comment->getInsertID();
				$this->loadModel('Post');
				$this->loadModel('User');
				$this->loadModel('Like');
				$post = $this->Post->find('first', array('conditions' => array('Post.id' => $this->data['Comment']['post_id'])));
				$user = $this->User->find('first', array('conditions' => array('id' => $post['Post']['user_id']) ) );
					if($user['User']['notification_type2'] == 1){	
						$this->loadModel('Notification');
						$this->Notification->create();
						$noteID = $this->Notification->getInsertID();
						$this->Notification->id = $noteID;
						$this->Notification->saveField('user_id', $this->Session->read('User.id'));
						$this->Notification->saveField('recipient_id', $post['Post']['user_id']);
						$this->Notification->saveField('content', 'has commented on your post');
						$this->Notification->saveField('source_controller', 'posts');
						$this->Notification->saveField('source_action', 'index/999');
						$this->Notification->saveField('type', 2);
						$this->Notification->saveField('source_id', '#post_'.$post['Post']['id']);
					}	
				$this->set(compact('post'));
				$this->set('likes', $this->Like->find('all'));
			}
		}
	}
	
	function add_like($id = null){	
		 $id = Sanitize::clean($id);
		 if (!$this->Session->read('User.id')) {
			$this->redirect($this->referer());
		 } else {
			$this->layout = 'ajax';
			$this->loadModel('User');
			$comment = $this->Comment->find('first', array('conditions' => array('Comment.id' => $id) ) );
			$newLikes = $comment['Comment']['likes']+1;
			$this->Comment->id = $id;
			$this->Comment->saveField('likes', $newLikes);
			$user = $this->User->find('first', array('conditions' => array('id' => $comment['Comment']['user_id']) ) );
			if($user['User']['notification_type2'] == 1){	
				$this->loadModel('Notification');
				$this->Notification->create();
				$noteID = $this->Notification->getInsertID();
				$this->Notification->id = $noteID;
				$this->Notification->saveField('user_id', $this->Session->read('User.id'));
				$this->Notification->saveField('recipient_id', $comment['Comment']['user_id']);
				$this->Notification->saveField('content', 'has liked one of your post');
				$this->Notification->saveField('source_controller', 'posts');
				$this->Notification->saveField('source_action', 'index');
				$this->Notification->saveField('type', 2);
				$this->Notification->saveField('source_id', '#comment_'.$comment['Comment']['id']);
			}	
			$this->set('likes', $newLikes);
		 }
	}
	
	/*function delete($id) {
		$id = Sanitize::clean($id);
		if ($this->Session->read('User.level') != 1) {
			$this->redirect(array('controller'=>'posts', 'action'=>'index'));
		} else {
		$post_id = $this->Comment->find('first', array('conditions' => array('Comment.id' => $id)));
		$this->Comment->delete($id);
		$this->Session->setFlash('The comment with id: '.$id.' has been deleted.');
		$this->redirect(array('controller'=>'posts', 'action'=>'view', $post_id['Comment']['post_id']));
   		 }
	}*/
	
	/*function edit($id = null) {
		$id = Sanitize::clean($id);
		$user_id = $this->Comment->read('user_id');
		if ($this->Session->read('User.level') != 1  || $user_id['Comment']['user_id'] != $this->Session->read('User.id')) {
			$this->redirect(array('controller'=>'posts', 'action'=>'index'));
		} else {
			$this->Comment->id = $id;
			if (empty($this->data)) {
				$this->data = $this->Comment->read();
			} else {
				if ($this->Comment->save($this->data)) {
					$post_id = $this->Comment->find('first', array('conditions' => array('Comment.id' => $id)));
					$this->Session->setFlash('Your Comment has been updated.');
					$this->redirect(array('controller'=>'posts','action' => 'view', $post_id['Comment']['post_id']));
				}
			}
		}
	}*/
}
?>