<?php
class User extends AppModel 
{ 
    var $name = 'User'; 
	var $hasMany = array(
		'Comment' => array('foreignKey' => 'user_id',
    						'dependent'=> true,
					),
		'Workout' => array('foreignKey' => 'user_id',
    						'dependent'=> true,
					),
		'Post' => array('foreignKey' => 'user_id',
    						'dependent'=> true,
					),
		'Picture'=> array('foreignKey' => 'user_id',
    						'dependent'=> true,
					),
		'Follower'=> array('foreignKey' => 'user_id',
    						'dependent'=> true,
					),
		'Notification',
		
		'Dailydiet' => array('foreignKey' => 'user_id',
    						'dependent'=> true,
					),
		'Body' => array('foreignKey' => 'user_id',
    						'dependent'=> true,
					),
	);
	var $validate = array(
        'username' => array(
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This username has already been taken.'
			),
            'alphaNumeric' => array(
				'rule' => 'alphaNumeric',
				'message' => 'Username must contain alphabetic and numeric values'
			),
			'between' => array(
				'rule' => array('between', 4, 15),
				'message' => 'Username must be between 4 to 15 characters'
            )
        ),
		'password' => array(
            'rule' => array('between', 5, 40),
            'message' => 'Password must be between 5 and 40 characters'
        ),
        'email' =>  array(
			'email' => array(
				'rule' => 'email', 
				'message' => 'Email must be a valid email.'
			),
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'This email has already been used.'
			),
		),
		
		'forname' => array(
			'alpha' => array(
				'rule' => '/^[a-zA-Z]+(\.\.\.)?$/',
				'allowEmpty' => true,
				'message' => 'Forname must contain only alphabetic characters'
			),
			'max' => array(
				'rule' => array('maxLength', 25),
				'message' => 'Forname must be no longer than 25 characters'
			)
		),
		'surname' => array(
			'alpha' => array(
				'rule' => '/^[a-zA-Z]+(\.\.\.)?$/',
				'allowEmpty' => true,
				'message' => 'Surname must contain only alphabetic characters'
			),
			'max' => array(
				'rule' => array('maxLength', 25),
				'message' => 'Surname must be no longer than 25 characters'
			)
		),
		'height' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'allowEmpty' => true,
				'message' => 'Height must be a numeric value'
			),
			'max' => array(
				'rule' => array('maxLength', 4),
				'message' => 'height must be no longer than 4 characters'
			)
		),
		'about' => array(
			'alphaNumeric' => array(
				'rule' => '/^[a-z0-9\s]*(\.\.\.)?$/i',
				'message' => 'About must contain only alphaNumeric characters'
			),
			'max' => array(
				'rule' => array('maxLength', 200),
				'message' => 'About must be no longer than 200 characters'
			)
		),
		'location' => array(
			'alphaNumeric' => array(
				'rule' => '/^[a-z0-9\s]*$/i',
				'allowEmpty' => true,
				'message' => 'Location must contain only alphaNumeric characters'
			),
			'max' => array(
				'rule' => array('maxLength', 25),
				'message' => 'Location must be no longer than 25 characters'
			)
		)
    );
     
    function validateLogin($data) 
    { 
        $user = $this->find(array('username' => $data['username'], 'password' => md5($data['password']))); 
        if(empty($user) == false) 
            return $user['User']; 
        return false; 
    } 
	
	function createUser($data)
	{
		$username = $data['User']['username'];
		$condition = array ('username'=>$username);
		$temp = $this->find('first', array('conditions'=>$condition));
		
		if(empty($temp)){
			return $this->save($data);
		}
		else{
			return false;		
		}
				
				
		
	}
	
	function getActivationHash()
	{
		if (!isset($this->id)) {
			return false;
		}
		return substr(Security::hash(Configure::read('Security.salt') . $this->field('created') . date('Ymd')), 0, 8);
	}
     
} 
?>