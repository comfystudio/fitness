<?php
class Workout extends AppModel {
	var $name = 'Workout';
	var $order = 'Workout.created DESC';
	
	var $belongsTo = array (
		'User'
	);
	
	var $hasMany = array(
		'Activity' => array('foreignKey' => 'workout_id',
    						'dependent'=> true,
					)
	);

		function find($type, $queryData = array(), $metric = 1){
		if($metric == 1){
			$temp  = parent::find($type, $queryData);
			if($type == 'all'){
				$count = 0;
				foreach($temp as $item){
					$temp[$count]['Workout']['units'] = "kg";
					$count++;
				}
				return $temp;
			}elseif($type == 'first'){
				$temp['Workout']['units'] = "kg";
				return $temp;
			}else{
				return $temp;	
			}
		}else{
			$temp  = parent::find($type, $queryData);
			if($type == 'all'){
				$count = 0;
				foreach($temp as $item){
					$temp[$count]['Workout']['units'] = "lbs";
					$count2 = 0;
					if(isset($item['Activity'])){
						foreach($item['Activity'] as $activity){
							$temp[$count]['Activity'][$count2]['value'] = 	round(($activity['value'] * 2.2046),1);
							$count2++;
						}
						$count++;
					}else{
						$temp[$count]['Activity'] = array(0 => 0);
					}
						
				}
				return $temp;
			}elseif($type =='first'){
				$temp['Workout']['units'] = "lbs";
				$count = 0;
				if(isset($temp['Activity'])){
					foreach($temp['Activity'] as $activity){
						$temp['Activity'][$count]['value'] = round(($activity['value'] * 2.2046),1);
						$count++;
						
					}
				}else{
					$temp['Activity'] = array(0 => 0);	
				}
				return $temp;
			}else{
				return $temp;	
			}
		}
	}

}
?>