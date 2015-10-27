<div id = 'home'> 
	<?php $urlString = '/img/uploads/users/';?>
	<div class = 'home-left-shadow'> 
        <div id = 'journal-calendar' class = 'journal-calendar'>
        </div> 
        
        <div class = 'home-info'>
        	<div class = 'username'><?php echo $user['User']['username']?></div>
            <table>
            <tr>
            <?php if($user['User']['forname'] != NULL && $user['User']['hideName'] == 0){
					echo '<td><p>'.$user['User']['forname'].'</p></td>';
					echo '<td><p class = "right-p">'.$user['User']['surname'].'</p></td>';
				}
			echo '</tr>';
 			echo '<tr>';	
				echo '<td><p>'.$user['User']['sex'].'</p></td>';
				
				if($user['User']['age'] != NULL && $user['User']['hideAge'] == 0){
					/*This is required to pull the user date and work out the number of years between the date and todays current date*/
					$age = $this->requestAction('users/getAge/'.$user['User']['age']);
					echo '<td><p class = "right-p">'.$age.'</p></td>';
				}
			echo '</tr>';
			echo '<tr>';
				if($user['User']['height'] != NULL && $user['User']['heightFoot'] != NULL && $user['User']['hideHeight'] == 0){
					if($user['User']['metricLength'] == 1){
							echo '<td><p>'.$user['User']['height'], 'cm</p></td>';
						} else{
							echo '<td><p>'.$user['User']['heightFoot'],"' ";
							echo $user['User']['heightInch'],"''</p></td> ";
						}
				}
				
				if($user['User']['location'] != NULL && $user['User']['hideLocation'] == 0){
					echo '<td><p class = "right-p">'.$user['User']['location'].'</p></td>';
				}
			
			?>
            </tr>
            </table>
        </div>
        <div class = 'home-about'>
        	About Me
        	<?php if($user['User']['about'] != NULL){?>
           		<p><?php echo $user['User']['about'];?></p>
           <?php }?>
        </div>
        <div class = 'social-others'>
        <?php $allUsers = $this->requestAction('users/getAllUsers/');?>
        <?php $userFollowings = $this->requestAction('followers/getUserFollowings/'.$this->Session->read('User.id'));?>
        <?php $userFollowed = $this->requestAction('followers/getUserFollowed/'.$this->Session->read('User.id'));?> 
        <?php $meets = $this->requestAction('users/getOthers/');?>
        	Meet Other Members <p id = 'meet-others-hide'>hide</p>
            <div class = 'meet-others'>
            <?php foreach ($meets as $meet):
				$count = 0;
				foreach($meet['Picture'] as $picture):
					if($picture['avatar'] == 1){
						$count = $picture['image'];
						break;
					}else {
						$count = 0;
					}
					endforeach;
					if($count == '0'){
						echo $html->link($html->image('/img/avatar.png',array('width' => '32', 'height' => '32')), array('controller' => 'users', 'action' => 'view',$meet['User']['id']), array('escape' => false, 'title' => $meet['User']['username']));

					}else {
						echo $html->link($html->image($urlString.$count, array('width' => '32', 'height' => '32')), array('controller' => 'users', 'action' => 'view',$meet['User']['id']), array('escape' => false, 'title' => $meet['User']['username']));

					}
                endforeach;?>
           </div>
        	
        </div>
        <div class = 'home-following'>
        	Following	<p id = 'following-hide'>hide</p>
            <div class = 'following'>
             <?php foreach ($allUsers as $allUser):
                		foreach($userFollowings as $userFollowing):
                    		if($allUser['User']['id'] == $userFollowing['Follower']['following_id']){
								$count = 0;
								foreach($allUser['Picture'] as $picture):
								if($picture['avatar'] == 1){
									$count = $picture['image'];
									break;
								}else {
									$count = 0;
								}
								endforeach;
								if($count == '0'){
									echo $html->link($html->image('/img/avatar.png',array('width' => '32', 'height' => '32')), array('controller' => 'users', 'action' => 'view',$userFollowing['Follower']['following_id']), array('escape' => false, 'title' => $allUser['User']['username']));

								}else {
									echo $html->link($html->image($urlString.$count, array('width' => '32', 'height' => '32')), array('controller' => 'users', 'action' => 'view',$userFollowing['Follower']['following_id']), array('escape' => false, 'title' => $allUser['User']['username']));
 
								}
							}
                	endforeach;
                endforeach;?>
               </div>
        </div>
        
        <div class = 'home-followers'>
        	Followers	<p id = 'followers-hide'>hide</p>
             <div class = 'followers'>
            <?php foreach ($allUsers as $allUser):
						foreach ($userFollowed as $userFollow):
						if($allUser['User']['id'] == $userFollow['Follower']['user_id']){
							$count = 0;
							foreach($allUser['Picture'] as $picture):
							if($picture['avatar'] == 1){
								$count = $picture['image'];
								break;
							}else {
								$count = 0;
							}
							endforeach;
							if($count == '0'){
								//echo '<div class = "followers">';
								echo $html->link($html->image('/img/avatar.png', array('width' => '32', 'height' => '32')), array('controller' => 'users', 'action' => 'view',$userFollow['Follower']['user_id']), array('escape' => false, 'title' => $allUser['User']['username']));
								//echo '</div>';
							}else {
								//echo '<div class = "followers">';
								echo $html->link($html->image($urlString.$count, array('width' => '24', 'height' => '24')), array('controller' => 'users', 'action' => 'view',$userFollow['Follower']['user_id']), array('escape' => false, 'title' => $allUser['User']['username']));
								//echo '</div>';
							}
						}
						endforeach;
				endforeach;?>
             </div>
        </div>
        <!--<div class = 'left-nav-advertisement'>
               Advertisement
         </div>-->
     </div>