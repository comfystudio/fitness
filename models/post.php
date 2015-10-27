<?php

class Post extends AppModel {
    var $name = 'Post';
	var $order = 'Post.created DESC';
	var $belongsTo = array (
		'User'
	);

	var $hasMany = array(
		'Comment' => array(
			'order' =>'created ASC'
		)
	);
	
	var $validate = array(
        'body' => array(
			/*'max' => array(
				'rule' => array('maxLength', 200),
				'message' => 'post must be no longer than 200 characters'
			),*/
			/*'alphaNumeric' => array(
				'rule' => '/^[a-zA-Z0-9\s!\.<>="\(\)#/:]*$/',
				//'allowEmpty' => true,
				'message' => 'post must contain only alphabetic characters'
			)*/
		),
	);
	
}

?>