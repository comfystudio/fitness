<h2>Select meal to delete!</h2>
<?php $count = 0;?>
<table border='1'>
<?php foreach($foodentries as $item) {?>
<tr>
	<td><?php echo $html->link('Delete Meal', array('controller' =>'foodentries', 'action'=>'delete', $foodentries[$count]['Foodentry']['id'] ) )?></td>
    <?php $count++;?>	
</tr>


<?php }?>
</table>

