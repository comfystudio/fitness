<?php 

class AppController extends Controller {
	
	public $helpers = array('Session', 'Menu', 'Form');
	var $components = array('Email', 'Session');
		
	public function beforeFilter() {
	}
}

?>