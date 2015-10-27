<?php
class Message extends AppModel {
	var $name = 'Message';
	var $order = 'Message.created DESC';
	var $belongsTo = array(
		//'User'
		'Message_set'
	);
	var $validate = array(
		'content' => array(
			'alphaNumeric' => array(
				'rule' => '/^[a-z0-9\s!\.]*(\.\.\.)?$/i',
				'required' =>  true,
				'message' => 'Message must contain only alphaNumeric characters'
			),
			'max' => array(
				'rule' => array('maxLength', 200),
				'message' => 'Message must be no longer than 200 characters'
			)
		)
	);
}
?>