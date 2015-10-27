<?php
class Activity extends AppModel {
	var $name = 'Activity';
	var $order = 'Activity.created DESC';
	
	/*var $validate = array(
        'value' => array(
			/*'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Value must be numeric',
				),
			'between' =>array(
				'rule' => array('/^\d{1,4}(\.\d{1})?$/'),
				'message' => 'Value must be numeric with and at most one decimal place',
				)
			),
		'reps' => array(
			'numeric' => array(
				'rule' => 'numeric',
				'message' => 'Reps must be numeric',
				),
			'between' =>array(
				'rule' => array('between',1, 3),
				'message' => 'Reps must be between 1 to 3 numbers',
				)
			)
		);*/
	
	var $belongsTo = array (
		'Workout'
	);
	
	/*var $hasOne = array(
		'Exercise'
	);*/
	


}
?>