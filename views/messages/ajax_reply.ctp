<?php
	echo '<div class = "message-container">';
		echo "<div class = 'message-avatar'>";
	
			$urlString = '/img/uploads/users/'; 
			$avatar = $this->requestAction('pictures/getAvatar/'.$content['Message']['user_id']);
			if(!empty($avatar)){
				echo $html->link($html->image($urlString.$avatar['Picture']['image'], array('width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'view',$content['Message']['user_id']), array('escape' => false, 'title' => $content['Message']['user_id']));
			}else{
				echo $html->link($html->image('/img/avatar.png',array('width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'view',$content['Message']['user_id']), array('escape' => false, 'title' => $content['Message']['user_id']));
			
			}
	
		echo "</div>";
		
		echo "<div class = 'message-info'>";
			$user = $this->requestAction('users/getSelectedUser/'.$content['Message']['user_id']);
			echo $html->link($user['User']['username'], array('controller' => 'users', 'action' => 'view',$content['Message']['user_id']));
			echo '<p>'.$content['Message']['content'].'</p>';
		echo "</div>";
		
		echo "<div class = 'message-text'>";
				$date = $this->requestAction('users/getTime/'.strtotime($content['Message']['created']));
				echo $date;
		echo "</div>"; 
	echo '</div>';
?>