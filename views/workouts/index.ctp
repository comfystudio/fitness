<?php echo $this->element('journal-left'); ?>
<?php echo $this->Html->script('journal');?>
<div class = 'home-right-shadow'>
    <div class = 'right-nav-content'>
        <?php 
			echo $this->Session->flash(); 
			echo $form->hidden('dateOutput2', array('label' => false, 'class' => 'textbox'));
		?>
        <div class = 'ajax-date' id = 'dateOutput'>
        	
        </div>
        
        <div class = 'journal-header'>
            <ul>
                <li class = 'li-active' id = "journal-workout">Workout</li>
                <li id = "journal-food">Food</li>
                <li id = "journal-measure">Measurement</li>
            </ul>
        </div>
        
        <div class = 'user-mass' id = 'user-mass_<?php echo $this->Session->read('User.metricMass')?>'></div>
        <div class = 'user-length' id = 'user-length_<?php echo $this->Session->read('User.metricLength')?>'></div>
        <div class = 'user-volume' id = 'user-volume_<?php echo $this->Session->read('User.metricVolume')?>'></div>
        
        <div id="LoadingImage" style="display: none">
            <img src="../../webroot/img/ajax-loader.gif" />
        </div>
        <div class = 'journal-wrapper' id = 'journal-wrapper_workout'>
        	<div class = 'workout-wrapper'>
            	<div class = 'workout-add'><img src="../../webroot/img/addworkout.png"></div>
                <div class = 'workout-frequent'>
                    <p>Frequent Activities</p>
                    <?php 
                        $count = null;
                        foreach($frequents as $frequent){
                            $frequentExercise = $this->requestAction('workouts/getExercise/'.$frequent['Workout']['exercise_id']);
                            echo '<a id = "exercise-select_'.$frequentExercise['Exercise']['id'].'" class = "exercise-select">'
                                    .$frequentExercise['Exercise']['name'].
                                '</a>' ;
                            $count++;
                        }
                    ?>
                
                </div>
                
                <div class = 'workout-search'>
                    <?php
                        echo $form->input('search', array('id' => 'SearchActivites', 'class' => 'textbox', 'type' => 'text', 'placeholder' => 'Search for Activities by name...', 'label' => false));
                    ?>
                
                    <div class = 'workout-search-ajax'></div>
                </div>
                
                <div class = 'workout-manual'>
                    <div class = 'workout-category'>
                        <p>Select Category</p>
                        <a class = 'category-select' id = 'category-select_0'>Abs</a>
                        <a class = 'category-select' id = 'category-select_1'>Arms</a>
                        <a class = 'category-select' id = 'category-select_2'>Back</a>
                        <a class = 'category-select' id = 'category-select_3'>Chest</a>
                        <a class = 'category-select' id = 'category-select_4'>Legs</a>
                        <a class = 'category-select' id = 'category-select_5'>Shoulders</a>
                        <a class = 'category-select' id = 'category-select_6'>Olympic Lifts</a>
                        <a class = 'category-select' id = 'category-select_7'>Aerobic</a>
                        <?php echo $this->Form->input('select', array('type' => 'hidden', 'id' => 'workout-selected') ); ?>
                    </div>
                    
                    <div class = 'workout-equipment'>
                        <p>Equipment</p>
                        
                        <?php
                            echo $this->Form->input('select', array('type' => 'hidden', 'id' => 'equipment-selected') );
                            $options = array('Barbell', 'Dumbell', 'Machine', 'Cable', 'Kettlebell', 'Bodyweight', 'Smithmachine', 'Ez Bar', 'Other', 'All'); 
                            echo $this->Form->input('equipment', array('type' => 'radio', 'options' => $options, 'value' => 9, 'id' => 'equipment-select') ); 
                        ?>
                    
                    </div>
                    
                    <div class = 'workout-results-ajax'></div>
                 </div>
                    
                    <form id = "workouts-form" action="/workouts/save/<?php echo $date?>" method="post">
                        <div class = 'workout-workout'>
                            <?php
                                
                                foreach($workouts as $workout){
                                    $exerciseName = $this->requestAction('workouts/getExercise/'.$workout['Workout']['exercise_id']);
                                    echo '<div id = "workout-set_'.$workout['Workout']['exercise_id'].'" class = "workout-set">';
                                        echo '<p>'.$exerciseName['Exercise']['name'].'</p><a name = "'.$exerciseName['Exercise']['name'].'"></a><a name = "exercise_id'.$workout['Workout']['exercise_id'].'"></a><a onclick="return confirm(\'are you sure?\')" class = "delete-exercise-old" id = "delete-exercise-old_'.$workout['Workout']['exercise_id'].'">Delete Exercise</a>';
                                        $count = 1;
                                        $count2 = 0;
                                        $activity_id = 0;
                                        foreach($workout['Activity'] as $activity){
                                            $activity_id = $activity['id'];
                                            echo '<div class = "old-set" id = "old-set_'.$activity['id'].'">';
                                                echo '<a class = "left">Set '.$count.'</a>';
                                                echo $form->input('workout', array('type' => 'hidden', 'label' => false, 'value' => $workout['Workout']['id'], 'name' => 'data['.$workout['Workout']['exercise_id'].'][Workout][Activity][id]'));
                                                echo $form->input('id', array('type' => 'hidden', 'label' => false, 'value' => $activity['id'], 'name' => 'data['.$workout['Workout']['exercise_id'].']['.$activity['id'].'][Activity][id]'));
                                                echo $form->input('workout_id', array('type' => 'hidden', 'label' => false, 'value' => $workout['Workout']['id'], 'name' => 'data['.$workout['Workout']['exercise_id'].']['.$activity['id'].'][Activity][workout_id]'));
                                                
                                                if($exerciseName['Exercise']['type'] == 0){
                                                    echo $form->input('reps', array('class' => 'textbox', 'label' => false, 'placeholder' => 'Reps', 'value' => $activity['reps'], 'name' => 'data['.$workout['Workout']['exercise_id'].']['.$activity['id'].'][Activity][reps]'));
                                                    if($this->Session->read('User.metricMass') == 1){
                                                        $placeholder = 'Weight (kg)';
                                                    }else{
                                                        $placeholder = 'Weight (lb)';
                                                    }
                                                    echo $form->input('value', array('class' => 'textbox', 'label' => false, 'placeholder' => $placeholder, 'value' => $activity['value'], 'name' => 'data['.$workout['Workout']['exercise_id'].']['.$activity['id'].'][Activity][value]'));
                                                }else{
                                                    echo $form->input('time', array('class' => 'textbox', 'label' => false, 'placeholder' => 'Time', 'value' => $activity['time'], 'name' => 'data['.$workout['Workout']['exercise_id'].']['.$activity['id'].'][Activity][time]'));
                                                    if($this->Session->read('User.metricLength') == 1){
                                                        $placeholder = 'Kilometre  (km)';
                                                        echo $form->input('distance', array('class' => 'textbox', 'label' => false, 'placeholder' => $placeholder, 'value' => $activity['distance'], 'name' => 'data['.$workout['Workout']['exercise_id'].']['.$activity['id'].'][Activity][distance]'));
                                                    }else{
                                                        $placeholder = 'Mile ';
                                                        echo $form->input('distance', array('class' => 'textbox', 'label' => false, 'placeholder' => $placeholder, 'value' => round($activity['distance']*0.6214), 'name' => 'data['.$workout['Workout']['exercise_id'].']['.$activity['id'].'][Activity][distance]'));
                                                    }
                                                    
                                                }
                                                    
                                                if($count2 == 0){
                                                    echo '<a class = "add-set-old" id = "add-set-old_'.$workout['Workout']['exercise_id'].'">Add Set +</a>';
                                                }else{
                                                    echo '<a class = "delete-set-old" id = "delete-set-old_'.$activity['id'].'">X</a>';
                                                }
                                            echo '</div>';
                                            $count++;
                                            $count2++;
                                        }
                                    echo "<div id = 'add-set-js-old_".$workout['Workout']['exercise_id']."' class = 'add-set-js-old'></div>";
                                    echo $form->input('notes', array('rows' => '1', 'type' => 'text', 'class' => 'textarea', 'value' => $workout['Workout']['note'], 'label' => false, 'placeholder' => 'Add notes...', 'name' => 'data['.$workout['Workout']['exercise_id'].']['.$activity_id.'][Activity][notes]'));
								    echo "<div class = 'exercise-type' id = 'exercise-type_".$exerciseName['Exercise']['type']."'></div>";
            
                                    echo '</div>';
                                }
                            ?>
                            <div class = 'workout-workout-ajax'></div>
                        </div>
                        
                       <div class = "error-message"></div>

                       <div class = 'submit'>
                        <input type="image" src="/img/save.png" />
                      </div>
                   </form>
            </div>
        
     	</div>
</div>
<script>
$(document).ready(function(e) {
	var megaDate = $('#dateOutput2').attr('value');	
	searchjs();
	results();
	addWorkout();
	deleteOldExercise(megaDate);
	deleteOldSet();
	addSetOld();
	workout();
});
</script>