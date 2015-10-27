<?php echo $this->Html->script('calendar', FALSE);?>
<?php echo $this->Html->script('workout', FALSE);?>
<?php echo $this->Html->script('addworkout', FALSE);?>
<h2>Select Date</h2> 
<script type="text/javascript">
//Had to use document.ready to ensure the full DOM had been loaded before applying Javascript 
$(document).ready(function(){
  	var cal= new Calendar();
});
</script>
<!-- Div holds the calendar from Javascript -->
<div id = "calendar"></div>
<br/>
<form>
<input type="text" value= 'Please select a date..' id="dateOutput"/>

</form>
<?php 
	$subcategories = array('Abs', 'Arms', 'Back', 'Chest', 'Legs', 'Shoulders', 'Olympic lifts', 'Aerobic');
	echo $this->Form->input('exerciseCategory', array('options' => $subcategories));
	echo '<br/>';
    //0 = Barbell, 1 = Dumbbell, 2 = Machine, 3 = Cable, 4 = Kettlebell, 5 = Bodyweight, 6 = SmithMachine, 7 = EZ bar, 8 Other
	$options = array('Barbell', 'Dumbell', 'Machine', 'Cable', 'Kettlebell', 'Bodyweight', 'Smithmachine', 'Ez Bar', 'Other', 'All');?>
	<div id = 'subcategory'>
		<?php echo $this->Form->input('equipment', array('type' => 'radio', 'options' => $options, 'value' => 9, 'id' => 'test') ); ?>
    </div>
    <br/>
    <div id = 'equipment'></div>
    <br/>
    <div id = 'exercises'></div>
	<?php echo $this->Form->hidden('user_id', array('value' => $this->Session->read('User.id')));?>
<form action="/workouts/save/" method="post">
    <a href="#" id="addWorkout">Add an Exercise</a>
	<div id = 'statsadd'>
    </div>
    <div class = 'addWorkout' id = 'addWorkout0'></div>
    <input type="submit" value="Save" />
</form>
<div id = 'message'></div>



