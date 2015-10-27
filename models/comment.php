<?php
class Comment extends AppModel {
    var $name = 'Comment';
	
	var $belongsTo = array (
		'User', 
		'Post'
	);
		
	var $order = 'Comment.created ASC';
	
	var $validate = array(
        'text' => array(
			'max' => array(
				'rule' => array('maxLength', 200),
				'message' => 'comment must be no longer than 200 characters'
			),
			'alphaNumeric' => array(
				'rule' => '/^[a-z0-9\s!\.]*(\.\.\.)?$/i',
				'allowEmpty' => true,
				'message' => 'comment must contain only alphabetic characters'
			)
		),
	);
}
?>