<div class = 'panel'>
	<table class = 'sent', border="1px">
    <tr><th colspan="20">Sent</th></tr>
    <tr><td id = 'inboxDelete'></td><td id = 'inboxFrom'>From</td><td id = 'inboxTitle'>Title</td><td id = 'inboxDate'>Date</td></tr>
    <?php foreach($messages as $message){
		$test = strtotime($message['Message']['created']);
		$time = date('d, M, Y', $test);
	?>

	<tr>
        <td><?php echo $html->link('X', array('controller' => 'messages', 'action' => 'deleteMessage',$message['Message']['id'],1))?></td>
        <?php foreach($users as $user):
        		if ($user['User']['id'] == $message['Message']['recipient_id']){?>
        	<td><?php echo $html->link($user['User']['username'], array('controller' => 'users', 'action' => 'view', $message['Message']['recipient_id']))?></td>
            <?php }
			endforeach;?>
        <td><?php echo $html->link($message['Message']['title'], array('controller' => 'messages', 'action' => 'view', $message['Message']['id'],1))?></td>
        <td><?php echo $time?></td>
    </tr>
		
	<?php }?>
    
    </table>
</div>