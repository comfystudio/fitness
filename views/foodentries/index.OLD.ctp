<h2>Select meal to edit!</h2>
<?php $count = 0;?>
<table border='1'>
<?php foreach($foodentries as $item) {?>
<tr>
	<td><?php echo $html->link('Edit Meal', array('controller' =>'foodentries', 'action'=>'edit', $foodentries[$count]['Foodentry']['id'] ) )?></td>
    <?php $count++;?>	
</tr>


<?php }?>
</table>

