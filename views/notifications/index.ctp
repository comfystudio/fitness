<div class = 'panel'>
	<table class = 'inbox', border="1px">
    <tr><th colspan="20">Notifications</th></tr>
    <tr><td id = 'noteDelete'></td><td id = 'noteSummary'>Notification</td><td id = 'noteDate'>Date</td></tr>
    <?php foreach ($notifications as $item){ 
		$test = strtotime($item['Notification']['created']);
		$time = date('d, M, Y', $test);
	?>
    
    <tr>
    	<td><?php echo $html->link('X', array('controller' => 'notifications', 'action' => 'delete',$item['Notification']['id']))?></td>
        <?php foreach($users as $user):
				if($user['User']['id'] == $item['Notification']['user_id']){
					$username = $user['User']['username'];	
				}
		endforeach;
		
		?>
       
        <td> <?php if($item['Notification']['is_read'] == 1){?><div class = 'notification_read'><?php }else {?><div class = 'notification_unread'><?php } 
			echo $html->link($username.' ', array('controller' => 'users', 'action' => 'view', $item['Notification']['user_id']));
			echo $item['Notification']['content'];
			echo $html->link(' Click here to view', array('controller' => $item['Notification']['source_controller'], 'action' => $item['Notification']['source_action'],'#'.$item['Notification']['source_id']))?>
        </div>
        </td>
       
        
        
        <td><?php echo $time?></td>
    
    </tr>
	
	<?php }?>
    </table>
</div>