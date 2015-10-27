<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * App::build(array(
 *     'plugins' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'models' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'views' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'controllers' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'datasources' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'behaviors' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'components' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'helpers' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */

/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */
 
/*function cmp($a, $b){
	if(isset($a['Body'])){
		$a_date = strtotime ($a['Body']['created']);
	}else{
		$a_date = strtotime ($a['Dailydiet']['created']);
	}
	
	if(isset($b['Body'])){
		$b_date = strtotime ($b['Body']['created']);
	}else{
		$b_date = strtotime ($b['Dailydiet']['created']);
	}
	
	if ($a_date == $b_date){
		return 0;
	}
	if ($a_date < $b_date){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp2($a, $b){
	if(isset($a['Body'])){
		$a_date = strtotime ($a['Body']['created']);
	}elseif(isset($a['Dailydiet'])){
		$a_date = strtotime ($a['Dailydiet']['created']);
	}else{
		$a_date = strtotime ($a['Workout']['0']['created']);
	}
	
	if(isset($b['Body'])){
		$b_date = strtotime ($b['Body']['created']);
	}elseif(isset($b['Dailydiet'])){
		$b_date = strtotime ($b['Dailydiet']['created']);
	}else{
		$b_date = strtotime ($b['Workout']['0']['created']);
	}
	
	if ($a_date == $b_date){
		return 0;
	}
	if ($a_date < $b_date){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp3($a, $b){
	if(isset($a['Body'])){
		$a_weight = $a['Body']['weight'];
	}elseif(isset($a['Dailydiet'])){
		$a_weight = 0;
	}else{
		$a_weight = 0;
	}
	
	if(isset($b['Body'])){
		$b_weight = $b['Body']['weight'];
	}elseif(isset($b['Dailydiet'])){
		$b_weight = 0;
	}else{
		$b_weight = 0;
	}
	
	if ($a_weight == $b_weight){
		return 0;
	}
	if ($a_weight < $b_weight){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp4($a, $b){
	if(isset($a['Body'])){
		$a_bodyfat = $a['Body']['bodyfat'];
	}elseif(isset($a['Dailydiet'])){
		$a_bodyfat = 0;
	}else{
		$a_bodyfat = 0;
	}
	
	if(isset($b['Body'])){
		$b_bodyfat = $b['Body']['bodyfat'];
	}elseif(isset($b['Dailydiet'])){
		$b_bodyfat = 0;
	}else{
		$b_bodyfat = 0;
	}
	
	if ($a_bodyfat == $b_bodyfat){
		return 0;
	}
	if ($a_bodyfat < $b_bodyfat){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp5($a, $b){
	$a_bench = 0;
	$b_bench = 0;
	if(isset($a['Workout'])){
		if(isset($a['Workout']['value1'])){
			$a_bench = $a['Workout']['value1'];
		}
	}elseif(isset($a['Dailydiet'])){
		$a_bench = 0;
	}else{
		$a_bench = 0;
	}
	
	if(isset($b['Workout'])){
		if(isset($b['Workout']['value1'])){
			$b_bench = $b['Workout']['value1'];
		}
	}elseif(isset($b['Dailydiet'])){
		$b_bench = 0;
	}else{
		$b_bench = 0;
	}
	
	if ($a_bench == $b_bench){
		return 0;
	}
	if ($a_bench < $b_bench){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp6($a, $b){
	$a_squat = 0;
	$b_squat = 0;
	if(isset($a['Workout'])){
		if(isset($a['Workout']['value2'])){
			$a_squat = $a['Workout']['value2'];
		}
	}elseif(isset($a['Dailydiet'])){
		$a_squat = 0;
	}else{
		$a_squat = 0;
	}
	
	if(isset($b['Workout'])){
		if(isset($b['Workout']['value2'])){
			$b_squat = $b['Workout']['value2'];
		}
	}elseif(isset($b['Dailydiet'])){
		$b_squat = 0;
	}else{
		$b_squat = 0;
	}
	
	if ($a_squat == $b_squat){
		return 0;
	}
	if ($a_squat < $b_squat){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp7($a, $b){
	$a_deadlift = 0;
	$b_deadlift = 0;
	if(isset($a['Workout'])){
		if(isset($a['Workout']['value3'])){
			$a_deadlift = $a['Workout']['value3'];
		}
	}elseif(isset($a['Dailydiet'])){
		$a_deadlift = 0;
	}else{
		$a_deadlift = 0;
	}
	
	if(isset($b['Workout'])){
		if(isset($b['Workout']['value3'])){
			$b_deadlift = $b['Workout']['value3'];
		}
	}elseif(isset($b['Dailydiet'])){
		$b_deadlift = 0;
	}else{
		$b_deadlift = 0;
	}
	
	if ($a_deadlift == $b_deadlift){
		return 0;
	}
	if ($a_deadlift < $b_deadlift){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp8($a, $b){
	$a_calories = 0;
	$b_calories = 0;
	if(isset($a['Dailydiet'])){
		if(isset($a['Dailydiet']['values'])){
			$a_calories = $a['Dailydiet']['values'][0];
		}
	}elseif(isset($a['Workout'])){
		$a_calories = 0;
	}else{
		$a_calories = 0;
	}
	
	if(isset($b['Dailydiet'])){
		if(isset($b['Dailydiet']['values'])){
			$b_calories = $b['Dailydiet']['values'][0];
		}
	}elseif(isset($b['Workout'])){
		$b_calories = 0;
	}else{
		$b_calories = 0;
	}
	
	if ($a_calories == $b_calories){
		return 0;
	}
	if ($a_calories < $b_calories){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp9($a, $b){
	$a_protein = 0;
	$b_protein = 0;
	if(isset($a['Dailydiet'])){
		if(isset($a['Dailydiet']['values'])){
			$a_protein = $a['Dailydiet']['values'][1];
		}
	}elseif(isset($a['Workout'])){
		$a_protein = 0;
	}else{
		$a_protein = 0;
	}
	
	if(isset($b['Dailydiet'])){
		if(isset($b['Dailydiet']['values'])){
			$b_protein = $b['Dailydiet']['values'][1];
		}
	}elseif(isset($b['Workout'])){
		$b_protein = 0;
	}else{
		$b_protein = 0;
	}
	
	if ($a_protein == $b_protein){
		return 0;
	}
	if ($a_protein < $b_protein){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp10($a, $b){
	$a_carbs = 0;
	$b_carbs = 0;
	if(isset($a['Dailydiet'])){
		if(isset($a['Dailydiet']['values'])){
			$a_carbs = $a['Dailydiet']['values'][2];
		}
	}elseif(isset($a['Workout'])){
		$a_carbs = 0;
	}else{
		$a_carbs = 0;
	}
	
	if(isset($b['Dailydiet'])){
		if(isset($b['Dailydiet']['values'])){
			$b_carbs = $b['Dailydiet']['values'][2];
		}
	}elseif(isset($b['Workout'])){
		$b_carbs = 0;
	}else{
		$b_carbs = 0;
	}
	
	if ($a_carbs == $b_carbs){
		return 0;
	}
	if ($a_carbs < $b_carbs){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp11($a, $b){
	$a_fat = 0;
	$b_fat = 0;
	if(isset($a['Dailydiet'])){
		if(isset($a['Dailydiet']['values'])){
			$a_fat = $a['Dailydiet']['values'][3];
		}
	}elseif(isset($a['Workout'])){
		$a_fat = 0;
	}else{
		$a_fat = 0;
	}
	
	if(isset($b['Dailydiet'])){
		if(isset($b['Dailydiet']['values'])){
			$b_fat = $b['Dailydiet']['values'][3];
		}
	}elseif(isset($b['Workout'])){
		$b_fat = 0;
	}else{
		$b_fat = 0;
	}
	
	if ($a_fat == $b_fat){
		return 0;
	}
	if ($a_fat < $b_fat){
		return 1;	
	}else{
		return -1;	
	}	
}

function cmp12($a, $b){
	if(isset($a['Body'])){
		$a_date = strtotime ($a['Body']['created']);
	}elseif(isset($a['Dailydiet'])){
		$a_date = strtotime ($a['Dailydiet']['created']);
	}else{
		$a_date = strtotime ($a['Workout']['0']['created']);
	}
	
	if(isset($b['Body'])){
		$b_date = strtotime ($b['Body']['created']);
	}elseif(isset($b['Dailydiet'])){
		$b_date = strtotime ($b['Dailydiet']['created']);
	}else{
		$b_date = strtotime ($b['Workout']['0']['created']);
	}
	
	if ($a_date == $b_date){
		return 0;
	}
	if ($a_date > $b_date){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp13($a, $b){
	if(isset($a['Body'])){
		$a_weight = $a['Body']['weight'];
	}elseif(isset($a['Dailydiet'])){
		$a_weight = 0;
	}else{
		$a_weight = 0;
	}
	
	if(isset($b['Body'])){
		$b_weight = $b['Body']['weight'];
	}elseif(isset($b['Dailydiet'])){
		$b_weight = 0;
	}else{
		$b_weight = 0;
	}
	
	if ($a_weight == $b_weight){
		return 0;
	}
	if ($a_weight > $b_weight){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp14($a, $b){
	if(isset($a['Body'])){
		$a_bodyfat = $a['Body']['bodyfat'];
	}elseif(isset($a['Dailydiet'])){
		$a_bodyfat = 0;
	}else{
		$a_bodyfat = 0;
	}
	
	if(isset($b['Body'])){
		$b_bodyfat = $b['Body']['bodyfat'];
	}elseif(isset($b['Dailydiet'])){
		$b_bodyfat = 0;
	}else{
		$b_bodyfat = 0;
	}
	
	if ($a_bodyfat == $b_bodyfat){
		return 0;
	}
	if ($a_bodyfat > $b_bodyfat){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp15($a, $b){
	$a_bench = 0;
	$b_bench = 0;
	if(isset($a['Workout'])){
		if(isset($a['Workout']['value1'])){
			$a_bench = $a['Workout']['value1'];
		}
	}elseif(isset($a['Dailydiet'])){
		$a_bench = 0;
	}else{
		$a_bench = 0;
	}
	
	if(isset($b['Workout'])){
		if(isset($b['Workout']['value1'])){
			$b_bench = $b['Workout']['value1'];
		}
	}elseif(isset($b['Dailydiet'])){
		$b_bench = 0;
	}else{
		$b_bench = 0;
	}
	
	if ($a_bench == $b_bench){
		return 0;
	}
	if ($a_bench > $b_bench){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp16($a, $b){
	$a_squat = 0;
	$b_squat = 0;
	if(isset($a['Workout'])){
		if(isset($a['Workout']['value2'])){
			$a_squat = $a['Workout']['value2'];
		}
	}elseif(isset($a['Dailydiet'])){
		$a_squat = 0;
	}else{
		$a_squat = 0;
	}
	
	if(isset($b['Workout'])){
		if(isset($b['Workout']['value2'])){
			$b_squat = $b['Workout']['value2'];
		}
	}elseif(isset($b['Dailydiet'])){
		$b_squat = 0;
	}else{
		$b_squat = 0;
	}
	
	if ($a_squat == $b_squat){
		return 0;
	}
	if ($a_squat > $b_squat){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp17($a, $b){
	$a_deadlift = 0;
	$b_deadlift = 0;
	if(isset($a['Workout'])){
		if(isset($a['Workout']['value3'])){
			$a_deadlift = $a['Workout']['value3'];
		}
	}elseif(isset($a['Dailydiet'])){
		$a_deadlift = 0;
	}else{
		$a_deadlift = 0;
	}
	
	if(isset($b['Workout'])){
		if(isset($b['Workout']['value3'])){
			$b_deadlift = $b['Workout']['value3'];
		}
	}elseif(isset($b['Dailydiet'])){
		$b_deadlift = 0;
	}else{
		$b_deadlift = 0;
	}
	
	if ($a_deadlift == $b_deadlift){
		return 0;
	}
	if ($a_deadlift > $b_deadlift){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp18($a, $b){
	$a_calories = 0;
	$b_calories = 0;
	if(isset($a['Dailydiet'])){
		if(isset($a['Dailydiet']['values'])){
			$a_calories = $a['Dailydiet']['values'][0];
		}
	}elseif(isset($a['Workout'])){
		$a_calories = 0;
	}else{
		$a_calories = 0;
	}
	
	if(isset($b['Dailydiet'])){
		if(isset($b['Dailydiet']['values'])){
			$b_calories = $b['Dailydiet']['values'][0];
		}
	}elseif(isset($b['Workout'])){
		$b_calories = 0;
	}else{
		$b_calories = 0;
	}
	
	if ($a_calories == $b_calories){
		return 0;
	}
	if ($a_calories > $b_calories){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp19($a, $b){
	$a_protein = 0;
	$b_protein = 0;
	if(isset($a['Dailydiet'])){
		if(isset($a['Dailydiet']['values'])){
			$a_protein = $a['Dailydiet']['values'][1];
		}
	}elseif(isset($a['Workout'])){
		$a_protein = 0;
	}else{
		$a_protein = 0;
	}
	
	if(isset($b['Dailydiet'])){
		if(isset($b['Dailydiet']['values'])){
			$b_protein = $b['Dailydiet']['values'][1];
		}
	}elseif(isset($b['Workout'])){
		$b_protein = 0;
	}else{
		$b_protein = 0;
	}
	
	if ($a_protein == $b_protein){
		return 0;
	}
	if ($a_protein > $b_protein){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp20($a, $b){
	$a_carbs = 0;
	$b_carbs = 0;
	if(isset($a['Dailydiet'])){
		if(isset($a['Dailydiet']['values'])){
			$a_carbs = $a['Dailydiet']['values'][2];
		}
	}elseif(isset($a['Workout'])){
		$a_carbs = 0;
	}else{
		$a_carbs = 0;
	}
	
	if(isset($b['Dailydiet'])){
		if(isset($b['Dailydiet']['values'])){
			$b_carbs = $b['Dailydiet']['values'][2];
		}
	}elseif(isset($b['Workout'])){
		$b_carbs = 0;
	}else{
		$b_carbs = 0;
	}
	
	if ($a_carbs == $b_carbs){
		return 0;
	}
	if ($a_carbs > $b_carbs){
		return 1;	
	}else{
		return -1;	
	}	
	
}

function cmp21($a, $b){
	$a_fat = 0;
	$b_fat = 0;
	if(isset($a['Dailydiet'])){
		if(isset($a['Dailydiet']['values'])){
			$a_fat = $a['Dailydiet']['values'][3];
		}
	}elseif(isset($a['Workout'])){
		$a_fat = 0;
	}else{
		$a_fat = 0;
	}
	
	if(isset($b['Dailydiet'])){
		if(isset($b['Dailydiet']['values'])){
			$b_fat = $b['Dailydiet']['values'][3];
		}
	}elseif(isset($b['Workout'])){
		$b_fat = 0;
	}else{
		$b_fat = 0;
	}
	
	if ($a_fat == $b_fat){
		return 0;
	}
	if ($a_fat > $b_fat){
		return 1;	
	}else{
		return -1;	
	}	
}*/
?>