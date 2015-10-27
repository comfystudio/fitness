<?php
class Food extends AppModel {
	var $name = 'Food';
	
	var $validate = array(
        'name' => array(
            'alphaNumeric' => array(
				'rule' => '/^[a-zA-Z0-9_\s]+(\.\.\.)?$/',
				'message' => 'Name must contain alphabetic and numeric values'
			),
			'between' => array(
				'rule' => array('between', 1, 50),
				'message' => 'Name must be between 1 to 50 characters'
            )
        ),
		'default_value' => array(
			'numeric' => array(
				'rule' => '/^\d{1,10}(\.\d{1,4})?$/',
				'message' => 'default_value must be between 1 and 10 numeric characters'
			)
        ),
        'food_type' =>  array(
			'numeric' => array(
				'rule' => 'numeric', 
				'message' => 'food_type must be numeric and is required',
				'required' => true,
			),
		),
		
		'default_label' => array(
			'alpha' => array(
				'rule' => '/^[a-zA-Z0-9_\s]+(\.\.\.)?$/',
				//'allowEmpty' => true,
				'message' => 'default_label must contain only alphaNumeric characters'
			),
			'max' => array(
				'rule' => array('maxLength', 50),
				'message' => 'default_label must be no longer than 50 characters'
			)
		),
		'protein' => array(
			'numeric' => array(
				'rule' => '/^\d{1,10}(\.\d{1,4})?$/',
				'message' => 'protein must be between 1 and 10 numeric characters'
			)
		),
		'calories' => array(
			'numeric' => array(
				'rule' => '/^\d{1,10}(\.\d{1,4})?$/',
				'message' => 'calories must be between 1 and 10 numeric characters'
			)
		),
		'carbs' => array(
			'numeric' => array(
				'rule' => '/^\d{1,10}(\.\d{1,4})?$/',
				'message' => 'carbs must be between 1 and 10 numeric characters'
			)
		),
		'fat' => array(
			'numeric' => array(
				'rule' => '/^\d{1,10}(\.\d{1,4})?$/',
				'message' => 'fat must be between 1 and 10 numeric characters'
			)
		),
		'fibre' => array(
			'numeric' => array(
				'rule' => '/^\d{1,10}(\.\d{1,4})?$/',
				'message' => 'fibre must be between 1 and 10 numeric characters'
			)
		)
    );
	
	
}
?>