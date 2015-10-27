<?php
	if(empty($users) || !isset($users)){
		echo '<div id = "flashMessage">No users match this search</div>';	
	}


?>

<?php foreach($users as $user){?>
<div class = 'social-content-search'>
        <div class = 'social-avatar'>
        <?php 
			$urlString = '/img/uploads/users/'; 
			$avatar = $this->requestAction('pictures/getAvatar/'.$user['User']['id']);
			if(!empty($avatar)){
				echo $html->link($html->image($urlString.$avatar['Picture']['image'], array('width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'view',$user['User']['id']), array('escape' => false, 'title' => $user['User']['username']));
			}else{
				echo $html->link($html->image('/img/avatar.png',array('width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'view',$user['User']['id']), array('escape' => false, 'title' => $user['User']['username']));
			
			}
		?>   
        </div>
         <div class = 'social-info'>
         	<?php echo $html->link($user['User']['username'], array('controller' => 'users', 'action' => 'view',$user['User']['id']))?>
            <table>
            	<tr>
                	<td><?php echo $user['User']['sex'];?></td>
               
                	<?php $age = $this->requestAction('users/getAge/'.$user['User']['age']);?>
                	<td>
						<?php 
								if($user['User']['age'] != NULL && $user['User']['hideAge'] != 1){
									echo $age;
								}
						?>
                    </td>
   
                </tr>
                <tr>
                	<?php 
						if($user['User']['height'] != NULL && $user['User']['hideHeight'] != 1){
							if($user['User']['metricLength'] == 1){
								echo '<td><p>'.$user['User']['height'], 'cm</p></td>';
							} else{
								echo '<td><p>'.$user['User']['heightFoot'],"' ";
								echo $user['User']['heightInch'],"''</p></td> ";
							}
						}
					?>
                    
                    <td>
						<?php
							if($user['User']['location'] != NULL && $user['User']['hideLocation'] != 1){ 
								echo  $user['User']['location'];
							}
						?>
                    </td>
               </tr>
       		 </table>
            </div>
       				
        <div class = 'social-text'>
        	<?php echo $user['User']['about']?>
        </div>
        
       	<?php 
			$followings = $this->requestAction('followers/getUserFollowings/'.$this->Session->read('User.id'));
			$count = 0;
			foreach($followings as $following){
				if($following['Follower']['following_id'] == $user['User']['id']){
					$count++;
				}
				
			}
			if($count <= 0){
				?><a class = 'follow' id = 'follow_<?php echo $user['User']['id']?>'><img src="../../webroot/img/follow.png"></a>
                  <a style="display:none" class = 'unfollow' id = 'unfollow_<?php echo $user['User']['id']?>'><img src="../../webroot/img/unfollow.png"></a>
                <?php
				
			}else{
				?><a style="display:none" class = 'follow' id = 'follow_<?php echo $user['User']['id']?>'><img src="../../webroot/img/follow.png"></a>
                  <a class = 'unfollow' id = 'unfollow_<?php echo $user['User']['id']?>'><img src="../../webroot/img/unfollow.png"></a>
                <?php
			}
		
		?>
        </div>
<?php } ?>
