<?php echo $this->Html->script('calendar', FALSE);?>
<?php echo $this->Html->script('body', FALSE);?>
<h2>Select Date</h2> 
<script type="text/javascript">
//Had to use document.ready to ensure the full DOM had been loaded before applying Javascript 
$(document).ready(function(){
  	var cal = new Calendar();
	//bodies();
});
</script>
<!-- Div holds the calendar from Javascript -->
<div id = "calendar"></div>
<br/>
<form>
<input type="text" value= 'Please select a date..' id="dateOutput"/>

</form>

<div id = 'statsadd'></div>