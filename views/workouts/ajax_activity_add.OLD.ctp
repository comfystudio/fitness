<div class="activity">
    	<p class = 'setLabel'>Set <?php echo $count;?></p>
        <input type="hidden" name="data[<?php echo $activityId; ?>][Activity][id]" value="<?php echo $activityId; ?>" />
        <input type="hidden" name="data[<?php echo $activityId; ?>][Activity][workout_id]" value="<?php echo $id; ?>" />
        <?php if($exercise['exercise']['type'] == 0){?>       
            <div class = 'reps'>
            	<input type="text" class='ActivityReps' name="data[<?php echo $activityId; ?>][Activity][reps]" value="0" />
            </div>
            
            <div class = 'value'>
           		 <input type="text" class='ActivityValue' name="data[<?php echo $activityId; ?>][Activity][value]" value="0.0" />
            </div>
        
        <?php }elseif($exercise['exercise']['type'] == 1){?>
            <div class = 'time'>
          	 	 <input type="text" class='ActivityTime' name="data[<?php echo $activityId; ?>][Activity][time]" value="00:00:00" />
            </div>
            
            <div class = 'distance'>
           		 <input type="text" class='ActivityDistance' name="data[<?php echo $activityId; ?>][Activity][distance]" value="0.0" />
            </div>
        
        <?php }?>
        <div class = 'delete'>
        	<a class = 'delete' id = '<?php echo $activityId?>'>X</a>
        </div>
</div>