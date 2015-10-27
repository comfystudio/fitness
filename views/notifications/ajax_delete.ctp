 <?php $urlString = '/img/uploads/users/';?>
 <?php $notifications = $this->requestAction('notifications/index/'.$this->Session->read('User.id'));?>
 <table>
	<?php foreach($notifications as $notification){?>
        <?php $userAvatar = $this->requestAction('pictures/getAvatar/'.$notification['User']['id'])?>
        <tr>
            <td class = 'notifications-pictures'>
                <?php if(!empty($userAvatar)){
                        echo '<a href = "users/view/'.$notification['Notification']['user_id'].'">'.$html->image($urlString.$userAvatar['Picture']['image'], array ('height' => '64', 'width' => '64', 'alt' => 'avatar', 'title' => 'This guy!')).'</a>';
                     }else {
                        echo '<a href = "users/view/'.$notification['Notification']['user_id'].'">'.$html->image('/img/avatar.png', array ('height' => '64', 'width' => '64', 'alt' => 'avatar', 'title' => 'This guy!')).'</a>';
                }?>
            </td>
            <td class = 'notifications-info'>
                <a href = '<?php echo $notification['Notification']['source_controller']."/".$notification['Notification']['source_action']."/#".$notification['Notification']['source_id']?>'>
                    <p class = 'info-username'><?php echo $notification['User']['username'];?></p>
                    <p class = 'info-notification'><?php echo $notification['Notification']['content'];?></p>
                </a>
            </td>
            
            <td class = 'notifications-other'>
                <?php $time = $this->requestAction('users/getTime/'.strtotime($notification['Notification']['created']));?>
                <p class = 'notifications-date'><?php echo $time;?></p>
                <p id = 'notifications-delete_<?php echo $notification['Notification']['id']?>' class = 'notifications-delete'><?php echo 'Delete X'//echo $html->link('Delete X', array('controller' => 'notifications', 'action' => 'delete',$notification['Notification']['id']))?></p>
        </tr>
        
        
    <?php }?>
</table>