<?php
class Foodentry extends AppModel {
	var $name = 'Foodentry';
	var $order = 'Foodentry.created DESC';
	
	/*var $validate = array(
        'quantity' => array(
			'rule' => '/^\d{1,5}(\.\d{1,3})?$/',
			'message' => 'Quantity must be numeric',
			)
		);*/
	
	var $belongsTo = array (
		'Dailydiet'
	);
	
	/*var $hasOne = array(
		'Food'
	);*/
}
?>