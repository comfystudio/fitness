<?php 
App::import('Sanitize');
class LikesController extends AppController{
		var $name = 'Likes';
	
	function add($id = null){
		$id = Sanitize::clean($id);
		$this->layout = 'ajax';
		$this->Like->create();
		$this->data['Like']['user_id'] = $this->Session->read('User.id');
		$this->data['Like']['post_id'] = $id;
		$this->Like->save($this->data);
		
		$this->loadModel('Post');
		$this->loadModel('User');
		$post = $this->Post->find('first', array('conditions' => array('Post.id' => $this->data['Like']['post_id'])));
		$user = $this->User->find('first', array('conditions' => array('id' => $post['Post']['user_id'])));
		if ($user['User']['notification_type4'] == 1){
			$this->loadModel('Notification');
			$this->Notification->create();
			$noteID = $this->Notification->getInsertID();
			$this->Notification->id = $noteID;
			$this->Notification->saveField('user_id', $this->data['Like']['user_id']);
			$this->Notification->saveField('recipient_id', $post['Post']['user_id']);
			$this->Notification->saveField('content', 'has liked one of your posts');
			$this->Notification->saveField('source_controller', 'posts');
			$this->Notification->saveField('source_action', 'index');
			$this->Notification->saveField('type', 4);
			$this->Notification->saveField('source_id', $post['Post']['id']);
		}
		$this->set('post', $post);
		$this->set('likes', $this->Like->find('all') );
	}
	
	function delete($id = null){
		$id = Sanitize::clean($id);
		$this->autoRender = false;
		$temp = $this->Like->find('first', array('conditions' => array('post_id' => $id) ) );
		$this->Like->delete($temp['Follower']['id']);	
	}
}
?>