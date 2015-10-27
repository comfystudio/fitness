<?php echo $this->Html->script('calendar', FALSE);?>
<?php echo $this->Html->script('dailydiets', FALSE);?>
<?php echo $this->Html->script('dynamicDiet', FALSE);?>

<h2>Select Date</h2> 
<script type="text/javascript">
//Had to use document.ready to ensure the full DOM had been loaded before applying Javascript 
$(document).ready(function(){
  	var cal = new Calendar();
});
</script>
<!-- Div holds the calendar from Javascript -->
<div id = "calendar"></div>
<br/>
<form>
<input type="text" value= 'Please select a date..' id="dateOutput"/>
</form>
<?php echo $this->Form->hidden('user_id', array('value' => $this->Session->read('User.id')));?>
<form action="/dailydiets/save/" method="post">
    <a href="#" id="addDailyDiet">Add a diet entry</a>
    <br/>
    <br/>
    <div class = 'panel'>
        <h2>Help</h2>
        <table>
            <tr><td>One Teaspoon is 5mL</td><td>One Teaspoon is 0.01 pt</td></tr>
            <tr><td>One Tablespoon is 15mL</td><td>One Tablespoon is 0.031 pt</td></tr>
            <tr><td>One Standard cup is 284 mL</td><td>One Standard cup is 0.4 pt</td></tr>
        </table>
	</div>
	<div id = 'statsadd'></div>
    <input type="submit" value="Save" />
</form>
