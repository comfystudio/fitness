<?php 
App::import('Sanitize');
class PicturesController extends AppController{
	var $name = 'Pictures';
	var $helpers = array('Form', 'Html');
	
	/*function viewUser($id = null){
		$this->set('pictures', $this->Picture->find('all', array('conditions' => array('user_id' => $id) ) ) );
		
	}*/
	
	
	/*function index(){
		if(!$this->Session->read('User.id')){
			$this->Session->setFlash('You must be logged in to view Pictures index.');
			$this->redirect(array('controller' => 'users', 'action' => 'login'));	
		}
		$user_id =  $this->Session->read('User.id');
		$this->set('pictures', $this->Picture->find('all', array('conditions' => array('user_id' => $user_id) ) ) );
	}*/
	
	function getAvatar($id = null){
		$id = Sanitize::clean($id);
		$allPictures = $this->Picture->find('all', array('conditions' => array('Picture.user_id' => $id ) ));
		$avatar = NULL;
		foreach($allPictures as $allPicture){
			if($allPicture['Picture']['avatar'] == 1){
				$avatar = $allPicture;
				break;	
			}
		}
		
		if (isset($this->params['requested'])) {
			return $avatar;
		}
	}
	
	/*function view($id = null){
		if(!$this->Session->read('User.id')){
			$this->Session->setFlash('You must be logged in to access pictures view page');
			$this->redirect(array('controller' => 'posts', 'action' => 'index'));	
		}
		$this->layout = 'bare';
		$this->set('pictures', $this->Picture->find('first', array('conditions' => array('Picture.id' => $id) ) ) );
	}*/
		
	function add() {
		if (!$this->Session->read('User.id')) {
			$this->Session->setFlash('You must be logged in to access the add pictures page');
			$this->redirect(array('controller' => 'users', 'action'=>'login'));
		} else {
			$this->autoRender = false;
			if (!empty($this->data)) {
				$this->data['Picture']['user_id'] = $this->Session->read('User.id');
				$this->Picture->create();
				$this->Picture->set($this->data);
				if($this->Picture->validates()){
					if ($this->Picture->save($this->data)) {
						$this->Session->setFlash('Your picture has been saved.');
						$this->redirect(array('controller' => 'profiles', 'action' => 'index', '#pictures'));
					}else{
						//File has validated but not saved due to attachable allowed Mime types	
						$this->Session->setFlash('Image must be a valid gif, bmp, jpeg and png.');
						$this->redirect(array('controller' => 'profiles', 'action' => 'index', '#pictures'));
					}
				}else{
					//About has not passed Validation checks
					$this->Session->setFlash('About must contain at most 50 alphaNumeric characters. Must attach image');
					$this->redirect(array('controller' => 'profiles', 'action' => 'index', '#pictures'));
				}
			}
		}
	}
	
	function delete($id =  null) {
		$id = Sanitize::clean($id);
		$user_id = $this->Session->read('User.id');
		$this->set('pictures', $this->Picture->find('all', array('conditions' => array('user_id' => $user_id) ) ) );
		$picture = $this->Picture->find('first', array('conditions' => array('user_id' => $user_id, 'Picture.id' =>$id) ) );
		if (!$this->Session->read('User.id') || $this->Session->read('User.id') != $picture['Picture']['user_id']) {
			$this->Session->setFlash('You must be logged in or be the current user to delete this image');
			$this->redirect($this->referer());
		} else {
			$this->Picture->delete($id);
			$this->Session->setFlash('Image'.$picture['Picture']['image'].' has been deleted');
			$this->redirect(array('controller' => 'profiles', 'action' => 'index', '#pictures'));
		}
    }
	
	function avatar($id = null){
		$id = Sanitize::clean($id);
		$this->autoRender = false;
		$pictures = $this->Picture->find('all', array('conditions' => array('user_id' => $this->Session->read('User.id') ) ) );
		foreach($pictures as $picture):
			$this->Picture->id = $picture['Picture']['id'];
			$this->data = $this->Picture->read();
			$this->data['Picture']['avatar'] = 0;
			$this->Picture->save($this->data);
		endforeach;

		$this->Picture->id = $id;
		$this->data = $this->Picture->read();
		$this->data['Picture']['avatar'] = 1;
		$this->Picture->save($this->data);
		
	}		
}
?>