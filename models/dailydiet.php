<?php
class Dailydiet extends AppModel {
	var $name = 'Dailydiet';
	var $order = 'Dailydiet.created DESC';
	
	var $belongsTo = array (
		'User'
	);
	
	var $hasMany = array(
		'Foodentry'=> array('foreignKey' => 'dailydiet_id',
    						'dependent'=> true,
					)
	);

	/*function find($type, $queryData = array(), $metric = 1){
		if($metric == 1){
			$temp  = parent::find($type, $queryData);
			if($type == 'all'){
				$count = 0;
				foreach($temp as $item){
					$temp[$count]['Dailydiet']['units'] = "grams(g)";
					$temp[$count]['Dailydiet']['units2'] = "millilitres(mL)";
					$count++;
				}
				return $temp;
			}elseif($type == 'first'){
				$temp['Dailydiet']['units'] = "grams(g)";
				$temp['Dailydiet']['units2'] = "millilitres(mL)";
				return $temp;
			}else{
				return($temp);	
			}
		}else{
			$temp  = parent::find($type, $queryData);
			if($type == 'all'){
				$count = 0;
				foreach($temp as $item){
					$temp[$count]['Dailydiet']['units'] = "ounce(oz)";
					$temp[$count]['Dailydiet']['units2'] = "pint(pt)";
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
				$temp['Dailydiet']['units'] = "ounce(oz)";
				$temp['Dailydiet']['units2'] = "pint(pt)";
				$count = 0;
				if(isset($temp['Foodentry'])){
					foreach($temp['Foodentry'] as $foodentry){
						$temp['Activity'][$count]['value'] = round(($activity['value'] * 2.2046),1);
						$count++;
						
					}
				}else{
					$temp['Foodentry'] = array(0 => 0);	
				}
				return $temp;
			}else{
				return $temp;	
			}
		}
	}*/


}
?>