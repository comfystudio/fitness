<table class = 'Total' border="1px">
<tr><th colspan="20">Total Summary</th></tr>
<tr class = 'header'>
	<?php if ($sort == 0){?>
    	<td><?php echo $html->link('Date v', array('controller' => 'profiles', 'action' => 'table',$id,10 ));?></td>
    <?php }elseif ($sort == 10){?>
    	<td><?php echo $html->link('Date ^', array('controller' => 'profiles', 'action' => 'table',$id,0 ));?></td>
    <?php }else{?>
		<td><?php echo $html->link('Date', array('controller' => 'profiles', 'action' => 'table',$id,0 ));?></td>
	<?php }?>
    
    <?php if ($sort == 1){?>
    	<td><?php echo $html->link('Weight v', array('controller' => 'profiles', 'action' => 'table',$id,11 ));?></td>
    <?php }elseif ($sort == 11){?>
    	<td><?php echo $html->link('Weight ^', array('controller' => 'profiles', 'action' => 'table',$id,1 ));?></td>
    <?php }else{?>
		<td><?php echo $html->link('Weight', array('controller' => 'profiles', 'action' => 'table',$id,1 ));?></td>
	<?php }?>
    
    <?php if ($sort == 2){?>
    	<td><?php echo $html->link('Bodyfat% v', array('controller' => 'profiles', 'action' => 'table',$id,12 ));?></td>
    <?php }elseif ($sort == 12){?>
    	<td><?php echo $html->link('Bodyfat% ^', array('controller' => 'profiles', 'action' => 'table',$id,2 ));?></td>
    <?php }else{?>
		<td><?php echo $html->link('Bodyfat%', array('controller' => 'profiles', 'action' => 'table',$id,2 ));?></td>
	<?php }?>
    
    <?php if ($sort == 3){?>
    	<td><?php echo $html->link('Bench v', array('controller' => 'profiles', 'action' => 'table',$id,13 ));?></td>
    <?php }elseif ($sort == 13){?>
    	<td><?php echo $html->link('Bench ^', array('controller' => 'profiles', 'action' => 'table',$id,3 ));?></td>
    <?php }else{?>
		<td><?php echo $html->link('Bench', array('controller' => 'profiles', 'action' => 'table',$id,3 ));?></td>
	<?php }?>
    
    <?php if ($sort == 4){?>
    	<td><?php echo $html->link('Squat v', array('controller' => 'profiles', 'action' => 'table',$id,14 ));?></td>
    <?php }elseif ($sort == 14){?>
    	<td><?php echo $html->link('Squat ^', array('controller' => 'profiles', 'action' => 'table',$id,4 ));?></td>
    <?php }else{?>
		<td><?php echo $html->link('Squat', array('controller' => 'profiles', 'action' => 'table',$id,4 ));?></td>
	<?php }?>
    
    <?php if ($sort == 5){?>
    	<td><?php echo $html->link('Deadlift v', array('controller' => 'profiles', 'action' => 'table',$id,15 ));?></td>
    <?php }elseif ($sort == 15){?>
    	<td><?php echo $html->link('Deadlift ^', array('controller' => 'profiles', 'action' => 'table',$id,5 ));?></td>
    <?php }else{?>
		<td><?php echo $html->link('Deadlift', array('controller' => 'profiles', 'action' => 'table',$id,5 ));?></td>
	<?php }?>
    
    <?php if ($sort == 6){?>
    	<td><?php echo $html->link('Calories v', array('controller' => 'profiles', 'action' => 'table',$id,16 ));?></td>
    <?php }elseif ($sort == 16){?>
    	<td><?php echo $html->link('Calories ^', array('controller' => 'profiles', 'action' => 'table',$id,6 ));?></td>
    <?php }else{?>
		<td><?php echo $html->link('Calories', array('controller' => 'profiles', 'action' => 'table',$id,6 ));?></td>
	<?php }?>
    
    <?php if ($sort == 7){?>
    	<td><?php echo $html->link('Protein v', array('controller' => 'profiles', 'action' => 'table',$id,17 ));?></td>
    <?php }elseif ($sort == 17){?>
    	<td><?php echo $html->link('Protein ^', array('controller' => 'profiles', 'action' => 'table',$id,7 ));?></td>
    <?php }else{?>
		<td><?php echo $html->link('Protein', array('controller' => 'profiles', 'action' => 'table',$id,7 ));?></td>
	<?php }?>
    
    <?php if ($sort == 8){?>
    	<td><?php echo $html->link('Carbs v', array('controller' => 'profiles', 'action' => 'table',$id,18 ));?></td>
    <?php }elseif ($sort == 18){?>
    	<td><?php echo $html->link('Carbs ^', array('controller' => 'profiles', 'action' => 'table',$id,8 ));?></td>
    <?php }else{?>
		<td><?php echo $html->link('Carbs', array('controller' => 'profiles', 'action' => 'table',$id,8 ));?></td>
	<?php }?>
    
    <?php if ($sort == 9){?>
    	<td><?php echo $html->link('Fat v', array('controller' => 'profiles', 'action' => 'table',$id,19 ));?></td>
    <?php }elseif ($sort == 19){?>
    	<td><?php echo $html->link('Fat ^', array('controller' => 'profiles', 'action' => 'table',$id,9 ));?></td>
    <?php }else{?>
		<td><?php echo $html->link('Fat', array('controller' => 'profiles', 'action' => 'table',$id,9 ));?></td>
	<?php }?>
</tr>
<?php $count = 0;?>
<?php if ($this->Session->read('User.metricMass') == 1){$units = 'kg';}else{$units = 'lb';}?>
<?php foreach($totalArray as $entry){?>
<?php if(isset($entry['Body'])){
		$date = $entry['Body']['created'];
		$weight = ($entry['Body']['weight']).$entry['Body']['units'];
		$bodyfat = $entry['Body']['bodyfat'];
	}elseif(isset($entry['Dailydiet'])){
		$date = $entry['Dailydiet']['created'];
		$weight = 0;
		$bodyfat = 0;
	}else{
		$date = $entry['Workout']['0']['created'];
		$weight = 0;
		$bodyfat = 0;
	}
	$bench[$count] = '0'.$units;
	$squat[$count] = '0'.$units;
	$deadlift[$count] = '0'.$units;
	
	if(!isset($entry['Dailydiet']['values'])){
		$entry['Dailydiet']['values'][0] = 0;
		$entry['Dailydiet']['values'][1] = 0;
		$entry['Dailydiet']['values'][2] = 0;
		$entry['Dailydiet']['values'][3] = 0;
	}
	if(isset($entry['Workout'])){
		if(isset($entry['Workout']['value1'])){
			$bench[$count] = $entry['Workout']['value1'].$units;
		}
		if(isset($entry['Workout']['value2'])){
			$squat[$count] = $entry['Workout']['value2'].$units;
		}
		if(isset($entry['Workout']['value3'])){
			$deadlift[$count] = $entry['Workout']['value3'].$units;
		}
	}
?>
<tr class = 'data'><td><?php echo $date;?></td><td><?php echo $weight;?></td><td><?php echo $bodyfat ?>%</td><td><?php echo $bench[$count]?></td><td><?php echo $squat[$count]?></td><td><?php echo $deadlift[$count]?></td><td><?php echo $entry['Dailydiet']['values'][0];?></td><td><?php echo $entry['Dailydiet']['values'][1];?></td><td><?php echo $entry['Dailydiet']['values'][2];?></td><td><?php echo $entry['Dailydiet']['values'][3];?></td></tr>

<?php $count++;?>
<?php }?>
</table>