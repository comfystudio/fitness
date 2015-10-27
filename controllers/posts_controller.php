<?php
App::import('Sanitize');
class PostsController extends AppController {
    var $name = 'Posts';
	var $helpers = array('Html', 'Form', 'Js' => array('Jquery')); 
	var $components = array('RequestHandler');
	
	
	function showMore($array = array(), $page_no = 0, $limit = 0){
		//$array = Sanitize::clean($array);
		$page_no = Sanitize::clean($page_no);
		$limit = Sanitize::clean($limit);
		
		$page_no++;
		$limit = $limit * $page_no;
		$array = array_slice($array, 0, $limit, false);
		return $array;
	}
	
	/*function json($id = null){
			
		
	}*/
		
	function index($page_no = 0){
		$page_no = Sanitize::clean($page_no);
		if(!$this->Session->read('User.id')){
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}
		$this->loadModel('User');
		$this->loadModel('Like');
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
		if($page_no == 999){
			
		}else{
			$tempArray = $this->showMore($tempArray, $page_no, 5);
		}
		$this->set('page_no', $page_no);
		$this->set('posts', $tempArray);
	}
	
	function ajax_everyone($page_no = 0){
		$page_no = Sanitize::clean($page_no);
		if(!$this->Session->read('User.id')){
			$this->redirect($this->referer());	
		}
		$this->loadModel('User');
		$this->loadModel('Like');
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
	
	function ajax_friends($page_no = 0){
		$page_no = Sanitize::clean($page_no);
		if(!$this->Session->read('User.id')){
			$this->redirect($this->referer());	
		}
		$this->loadModel('User');
		$this->loadModel('Like');
		$user_id = $this->Session->read('User.id');
		$this->set('users', $this->User->find('first', array('conditions' => array('id' => $user_id) ) ) );
		$posts = $this->Post->find('all');
		$tempArray = array();
		$count2 = 0;
		$followings = $this->requestAction('followers/getUserFollowings/'.$user_id);
		foreach($posts as $post){
			foreach($followings as $following){
				if($post['User']['hideProfile'] == 0 && $following['Follower']['following_id'] == $post['User']['id']){
					$tempArray[$count2] = $post;
					$count2++;
					break;	
				}
			}
		}
		$this->set('likes', $this->Like->find('all'));
		$this->set('totalPosts', $tempArray);
		$posts = $this->showMore($tempArray, $page_no, 5);
		$this->set('page_no', $page_no);
		$this->set('posts', $tempArray);
	}
	
	function ajax_search_update($search = null){
		$search = Sanitize::clean($search);
		$this->loadModel('User');
		$user_id = $this->Session->read('User.id');
		$users = $this->User->find('all', array('conditions' => array('hideProfile' => 0, 'hidePublic' => 0, 'username LIKE' => '%'.$search.'%') ) );
		$this->set('users', $users);		
	}
	
	function ajax_search(){
		$this->layout = 'ajax';
		$users = $this->requestAction('users/getUser');
		$this->set('users', $users);
		
	}
	
	/*function view($id = null, $page_no = 0){
		$this->loadModel('Comment');
		$this->loadModel('User');
		$this->set('users', $this->User->find('list', array('fields' => array('User.username'))));
		$comment = $this->Comment->find('all', array('conditions' => array('post_id' => $id) ) );
		$this->Post->id = $id;
		$this->set('post',$this->Post->read());
		$this->set('comments', $comment);
		}
	
	function json_rating( $id = null, $score = 1) {
				
		$this->loadModel('Comment');
		$comment = $this->Comment->find('first', array('conditions' =>array('Comment.id' => $id) ) );
		$currentScore = $comment['Comment']['rating'];
		if($score >0){
			$data = array('Comment' =>array('id' => $id, 'rating' => $currentScore + 1));
			$this->Comment->save($data);
		} else {
			$data = array('Comment' =>array('id' => $id, 'rating' => $currentScore - 1));
			$this->Comment->save($data);
		}
		echo json_encode ($data);
		
		die;
	}*/
	
	function add($origin = null) {
		if (!$this->Session->read('User.id')) {
			$this->redirect(array('action'=>'index'));
		} else {
			$this->autoRender = false;
			if (!empty($this->data)) {
				$this->data['Post']['user_id'] = $this->Session->read('User.id');
				$this->Post->create();
				$this->Post->set($this->data);
				if($this->Post->validates()){
					if ($this->Post->save($this->data)) {
						$this->Session->setFlash('Your post has been saved.');
						$this->redirect($this->referer());
					}
				}else{
					$this->Session->setFlash('Post must contain only alphaNumeric and at most 200 characters');
					if($origin == 'everyone'){
						$this->redirect(array('controller' => 'posts', 'action' => 'index','#'));
					}elseif($origin == 'feed'){
						$this->redirect(array('controller' => 'profiles', 'action' => 'index'));
					}elseif($origin == 'friends'){
						$this->redirect(array('controller' => 'posts', 'action' => 'index','#friends'));
					}
				}
			}
		}
	}
	
	function delete($id = null) {
		$id = Sanitize::clean($id);
		$post  = $this->Post->find('first', array('conditions' => array('Post.id' => $id)));
		$user_id = $this->Session->read('User.id');
		if ($this->Session->read('User.level') != 1 && $post['Post']['user_id'] != $user_id) {
			$this->Session->setFlash('You must be an admin or the correct user to delete this post.');
			$this->redirect(array('action'=>'index'));
		} else {
			$this->Post->delete($id);
			$this->Session->setFlash('The post with id: '.$id.' has been deleted.');
			$this->redirect($this->referer());
		}
    }
	
	/*function edit($id = null) {
		$post  = $this->Post->find('first', array('conditions' => array('Post.id' => $id)));
		if ($this->Session->read('User.level') != 1 && $post['Post']['user_id'] != $this->Session->read('User.id')) {
			$this->Session->setFlash('You must be an admin or the correct user to edit this post.');
			$this->redirect(array('action'=>'index'));
		} else {
			$this->Post->id = $id;
			if (empty($this->data)) {
				$this->data = $this->Post->read();
			} else {
				if ($this->Post->save($this->data)) {
					$this->Session->setFlash('Your post has been updated.');
					$this->redirect(array('action' => 'index'));
				}
			}
		}
	}*/
}
?>