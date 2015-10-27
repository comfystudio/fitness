<?php
class Body extends Appmodel{
	var $name = 'Body';
	var $order = 'Body.created DESC';
	
	var $validate = array(
		 'weight' => array(
			'between' =>array(
				'rule' => '/^\d+(\.\d{1})?$/',
				'allowEmpty' => true,
				'message' => 'Weight must be numeric with and at most one decimal place',
			),
			'max' => array(
				'rule' => array('maxLength', 10),
				'message' => 'Weight must be no longer than 25 characters',
			),
        ),
		 'bodyfat' => array(
			'numeric' => array(
				'rule' => '/^\d+(\.\d{1})?$/',
				'allowEmpty' => true,
				'message' => 'Bodyfat must be numeric with and at most one decimal place',
				),
			'between' => array(
				'rule' => array('maxLength', 10),
				'message' => 'Bodyfat must be no longer than 25 characters',
				)
        ),

		'chest' => array(
			'between' =>array(
				'rule' => '/^\d{1,4}(\.\d{1})?$/',
				'allowEmpty' => true,
				'message' => 'Chest must be numeric with and at most one decimal place',
			)
        ),
		
		'arms' => array(
			'between' =>array(
				'rule' => '/^\d{1,4}(\.\d{1})?$/',
				'allowEmpty' => true,
				'message' => 'Arms must be numeric with and at most one decimal place',
			)
        ),
		
		'hips' => array(
			'between' =>array(
				'rule' => '/^\d{1,4}(\.\d{1})?$/',
				'allowEmpty' => true,
				'message' => 'Hips must be numeric with and at most one decimal place',
			)
        ),
		
		'waist' => array(
			'between' =>array(
				'rule' => '/^\d{1,4}(\.\d{1})?$/',
				'allowEmpty' => true,
				'message' => 'Waist must be numeric with and at most one decimal place',
			)
        ),
		
		'thighs' => array(
			'between' =>array(
				'rule' => '/^\d{1,4}(\.\d{1})?$/',
				'allowEmpty' => true,
				'message' => 'Thighs must be numeric with and at most one decimal place',
			)
        ),
		
		'forearms' => array(
			'between' =>array(
				'rule' => '/^\d{1,4}(\.\d{1})?$/',
				'allowEmpty' => true,
				'message' => 'Forearms must be numeric with and at most one decimal place',
			)
        ),
		
		'calves' => array(
			'between' =>array(
				'rule' => '/^\d{1,4}(\.\d{1})?$/',
				'allowEmpty' => true,
				'message' => 'Calves must be numeric with and at most one decimal place',
			)
        ),
		
		'shoulders' => array(
			'between' =>array(
				'rule' => '/^\d{1,4}(\.\d{1})?$/',
				'allowEmpty' => true,
				'message' => 'Shoulders must be numeric with and at most one decimal place',
			)
        ),
		
		'neck' => array(
			'between' =>array(
				'rule' => '/^\d{1,4}(\.\d{1})?$/',
				'allowEmpty' => true,
				'message' => 'Neck must be numeric with and at most one decimal place',
			)
        )
	);
	
	var $belongsTo = array (
		'User'
	);	
	
	function find($type, $queryData = array(), $metricMass = 1, $metricLength = 1){
		$temp  = parent::find($type, $queryData);
		if($metricLength == 1){
			$temp  = parent::find($type, $queryData);
			if($type == 'all'){
				$count = 0;
				foreach($temp as $item){
					if($metricMass == 1){
						$temp[$count]['Body']['units'] = "kg";
					}else{
						$temp[$count]['Body']['units'] = "lb";
						$temp[$count]['Body']['weight'] = round(($item['Body']['weight']* 2.2),1);
					}
					$temp[$count]['Body']['units2'] = "cm";
					if(!isset($temp[$count]['Body']['id'])){
						$temp[$count]['Body']['weight'] = 0;
						$temp[$count]['Body']['bodyfat'] = 0;
						$temp[$count]['Body']['chest'] = 0;
						$temp[$count]['Body']['arms'] = 0;
						$temp[$count]['Body']['hips'] = 0;
						$temp[$count]['Body']['waist'] = 0;
						$temp[$count]['Body']['thighs'] = 0;
						$temp[$count]['Body']['forearms'] = 0;
						$temp[$count]['Body']['calves'] = 0;
						$temp[$count]['Body']['shoulders'] = 0;
						$temp[$count]['Body']['neck'] = 0;
						
					}
					$count++;
				}
				return $temp;
			}elseif($type == 'first'){
				if($metricMass == 1){
						$temp['Body']['units'] = "kg";
					}else{
						$temp['Body']['units'] = "lb";
						$temp['Body']['weight'] = round(($temp['Body']['weight']* 2.2),1);
					}
				$temp['Body']['units2'] = "cm";
				if(!isset($temp['Body']['id'])){
					$temp['Body']['weight'] = 0;
					$temp['Body']['bodyfat'] = 0;
					$temp['Body']['chest'] = 0;
					$temp['Body']['arms'] = 0;
					$temp['Body']['hips'] = 0;
					$temp['Body']['waist'] = 0;
					$temp['Body']['thighs'] = 0;
					$temp['Body']['forearms'] = 0;
					$temp['Body']['calves'] = 0;
					$temp['Body']['shoulders'] = 0;
					$temp['Body']['neck'] = 0;
						
				}
				return $temp;
			}else{
				return $temp;
			}
			
		}elseif($metricLength == 0){
			$temp  = parent::find($type, $queryData);
			if($type == 'all'){
				$count = 0;
				foreach($temp as $item){
					if($metricMass == 1){
						$temp[$count]['Body']['units'] = "kg";
					}else{
						$temp[$count]['Body']['units'] = "lb";
						$temp[$count]['Body']['weight'] = round(($item['Body']['weight']* 2.2),1);
					}
					$temp[$count]['Body']['units2'] = "in";
					if(!isset($temp[$count]['Body']['id'])){
						$item['Body']['weight'] = 0;
						$item['Body']['bodyfat'] = 0;
						$item['Body']['chest'] = 0;
						$item['Body']['arms'] = 0;
						$item['Body']['hips'] = 0;
						$item['Body']['waist'] = 0;
						$item['Body']['thighs'] = 0;
						$item['Body']['forearms'] = 0;
						$item['Body']['calves'] = 0;
						$item['Body']['shoulders'] = 0;
						$item['Body']['neck'] = 0;
					}
					$temp[$count]['Body']['chest'] = round(($item['Body']['chest'] * 0.3937),1);
					$temp[$count]['Body']['arms'] = round(($item['Body']['arms'] * 0.3937),1);
					$temp[$count]['Body']['hips'] = round(($item['Body']['hips'] * 0.3937),1);
					$temp[$count]['Body']['waist'] = round(($item['Body']['waist'] * 0.3937),1);
					$temp[$count]['Body']['thighs'] = round(($item['Body']['thighs'] * 0.3937),1);
					$temp[$count]['Body']['forearms'] = round(($item['Body']['forearms'] * 0.3937),1);
					$temp[$count]['Body']['calves'] = round(($item['Body']['calves'] * 0.3937),1);
					$temp[$count]['Body']['shoulders'] = round(($item['Body']['shoulders'] * 0.3937),1);
					$temp[$count]['Body']['neck'] = round(($item['Body']['neck'] * 0.3937),1);
					$count++;	
						
				}
				return $temp;
			}elseif($type == 'first'){
				if($metricMass == 1){
						$temp['Body']['units'] = "kg";
					}else{
						$temp['Body']['units'] = "lbs";
						$temp['Body']['weight'] = round(($temp['Body']['weight']* 2.2),1);
					}
				$temp['Body']['units2'] = "in";
				if(!isset($temp['Body']['id'])){
					$temp['Body']['weight'] = 0;
					$temp['Body']['bodyfat'] = 0;
					$temp['Body']['chest'] = 0;
					$temp['Body']['arms'] = 0;
					$temp['Body']['hips'] = 0;
					$temp['Body']['waist'] = 0;
					$temp['Body']['thighs'] = 0;
					$temp['Body']['forearms'] = 0;
					$temp['Body']['calves'] = 0;
					$temp['Body']['shoulders'] = 0;
					$temp['Body']['neck'] = 0;
				}
				$temp['Body']['chest'] = round(($temp['Body']['chest'] * 0.3937),1);
				$temp['Body']['arms'] = round(($temp['Body']['arms'] * 0.3937),1);
				$temp['Body']['hips'] = round(($temp['Body']['hips'] * 0.3937),1);
				$temp['Body']['waist'] = round(($temp['Body']['waist'] * 0.3937),1);
				$temp['Body']['thighs'] = round(($temp['Body']['thighs'] * 0.3937),1);
				$temp['Body']['forearms'] = round(($temp['Body']['forearms'] * 0.3937),1);
				$temp['Body']['calves'] = round(($temp['Body']['calves'] * 0.3937),1);
				$temp['Body']['shoulders'] = round(($temp['Body']['shoulders'] * 0.3937),1);
				$temp['Body']['neck'] = round(($temp['Body']['neck'] * 0.3937),1);
				return $temp;
			}else{
				return $temp;	
			}
		}
	}
}





?>