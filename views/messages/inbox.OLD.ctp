<div class = 'panel'>
	<table class = 'inbox', border="1px">
    <tr><th colspan="20">Inbox</th></tr>
    <tr><td id = 'inboxDelete'></td><td id = 'inboxFrom'>From</td><td id = 'inboxTitle'>Title</td><td id = 'inboxDate'>Date</td></tr>
    <?php foreach($messages as $message){
		$test = strtotime($message['Message']['created']);
		$time = date('d, M, Y', $test);
	?>

	<tr>
        <td><?php echo $html->link('X', array('controller' => 'messages', 'action' => 'deleteMessage',$message['Message']['id'],0))?></td>
        <td><?php echo $html->link($message['User']['username'], array('controller' => 'users', 'action' => 'view', $message['User']['id']))?></td>
		
        <?php if($message['Message']['read'] == 1){?>
        	<td><?php echo $html->link($message['Message']['title'], array('controller' => 'messages', 'action' => 'view', $message['Message']['id'],0))?></td>
        <?php }else{ ?>
        	<td><?php echo $html->link($message['Message']['title'], array('controller' => 'messages', 'action' => 'view', $message['Message']['id'],0), array('class' => 'unread'))?></td>
        <?php }?>
        <td><?php echo $time?></td>
    </tr>
		
	<?php }?>
    
    </table>
</div>