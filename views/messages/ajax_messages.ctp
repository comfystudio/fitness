<div class = 'social-messages-border'>
    <div class = 'social-messages'>
        <a class = 'new-message'><img src="../../webroot/img/new-message.png"></a>
        <div style="display:none"class = 'new-message-form'>
		<?php
           echo $form->create('Message', array('url' => array('controller' => 'messages', 'action' => 'compose',$this->Session->read('User.id'))));
				echo $this->Form->hidden('user_id', array('value' => $this->Session->read('User.id')));
				echo $form->input('To', array('label' => false, 'type' => 'text', 'class' => 'textbox', 'placeholder' => 'To...'));
				echo $form->input('content', array('label' => false, 'type' => 'textarea', 'class' => 'textarea', 'placeholder' => 'Messages...'));
				?><a class = 'cancel-message'><img src="../../webroot/img/cancel.png"></a><?php
			echo $form->end('send.png');
        ?>
        
        </div>
    </div>
</div>

<div class = 'social-content-messages'>
	<?php foreach($messages as $message){?>
   	<div class = 'social-wrapper' id = "social-wrapper_<?php echo $message['Message_set']['id']?>">
		<div class = 'social-avatar'>
			<?php
				$message_count = count($message['Message'])-1;
                $urlString = '/img/uploads/users/'; 
                $avatar = $this->requestAction('pictures/getAvatar/'.$message['Message'][$message_count]['user_id']);
                if(!empty($avatar)){
                    echo $html->link($html->image($urlString.$avatar['Picture']['image'], array('width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'view',$message['Message_set']['user_id']), array('escape' => false, 'title' => $message['Message_set']['user_id']));
                }else{
                    echo $html->link($html->image('/img/avatar.png',array('width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'view',$message['Message_set']['user_id']), array('escape' => false, 'title' => $message['Message_set']['user_id']));
                
                }
            ?>
   		</div>
        
        <div class = 'social-info'>
        	<?php
				$temp = count($message['Message']);
				$numOfMessages = $temp -1;
				$user = $this->requestAction('users/getSelectedUser/'.$message['Message_set']['user_id']);
				echo $html->link($user['User']['username'], array('controller' => 'users', 'action' => 'view',$message['Message_set']['user_id']));
				echo '<p>'.$message['Message'][$numOfMessages]['content'].'</p>';
        	?>
        </div>
        
        <div class = 'social-text'>
        	<?php
				$date = $this->requestAction('users/getTime/'.strtotime($message['Message'][$numOfMessages]['created']));
				echo $date;
				//echo '<p>'.$html->link('Delete X', array('controller' => 'messages', 'action' => 'deleteMessage',$message['Message_set']['id'],0)).'</p>';
				echo '<p><a class = "delete-message" id = "delete-message_'.$message['Message_set']['id'].'">Delete X</a></p>';
			?>
        </div>
     
        
        <a id = 'view-message_<?php echo $message['Message_set']['id']?>' class = 'view-message'><img src="../../webroot/img/view.png"></a>
        <a style="display:none" id = 'hide-message_<?php echo $message['Message_set']['id']?>' class = 'hide-message'><img src="../../webroot/img/hide.png"></a>
     </div>
     	<a name = "message_<?php echo $message['Message_set']['id']?>"> </a> 
        <div style="display:none" class = 'messages-reply' id = 'message-reply_<?php echo $message['Message_set']['id']?>'>
        	<?php
				foreach($message['Message'] as $content){
				echo '<div class = "message-container">';
					echo "<div class = 'message-avatar'>";
				
						$urlString = '/img/uploads/users/'; 
						$avatar = $this->requestAction('pictures/getAvatar/'.$content['user_id']);
						if(!empty($avatar)){
							echo $html->link($html->image($urlString.$avatar['Picture']['image'], array('width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'view',$content['user_id']), array('escape' => false, 'title' => $content['user_id']));
						}else{
							echo $html->link($html->image('/img/avatar.png',array('width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'view',$content['user_id']), array('escape' => false, 'title' => $content['user_id']));
						
						}
			 
					echo "</div>";
					
					echo "<div class = 'message-info'>";
						$user = $this->requestAction('users/getSelectedUser/'.$content['user_id']);
						echo $html->link($user['User']['username'], array('controller' => 'users', 'action' => 'view',$content['user_id']));
						echo '<p>'.$content['content'].'</p>';
        			echo "</div>";
					
					echo "<div class = 'message-text'>";
							$date = $this->requestAction('users/getTime/'.strtotime($content['created']));
							echo $date;
					echo "</div>"; 
				echo '</div>';
				}
				echo '<div class = "newMessages">';
				echo '</div>';
				
				echo '<div id = "MessageAjaxMessagesForm_'.$message['Message_set']['id'].'" class = "MessageAjaxMessagesForm">';
					//echo $form->create('Message', array('url' => array('controller' => 'messages', 'action' => 'reply',$this->Session->read('User.id'))));
						echo $this->Form->hidden('user_id', array('value' => $this->Session->read('User.id')));
						echo $this->Form->hidden('message_set_id', array('value' => $message['Message_set']['id']));
						//echo $form->input('To', array('label' => false, 'type' => 'text', 'class' => 'textbox', 'placeholder' => 'To...'));
						echo $form->input('content', array('label' => false, 'type' => 'textarea', 'rows' => '1', 'class' => 'textarea', 'placeholder' => 'Write a reply...'));
						echo '<div class = "error-message" id = "error-message_'.$message['Message_set']['id'].'"></div>';
					echo $form->end('reply.png');
				echo '</div>';
			?>
        </div>
		
	<?php }?>

</div>
  