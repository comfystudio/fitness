<div id = 'home'> 
	<?php $urlString = '/img/uploads/users/';?>
     <?php $user = $this->requestAction('users/getSelectedUser/'.$id);?>
	<div class = 'home-left-shadow'> 
        	<div class = 'home-avatar'>
            	<?php $avatar = $this->requestAction('pictures/getAvatar/'.$user['User']['id']);?> 
                <?php if(!empty($avatar)){
						echo $html->image($urlString.$avatar['Picture']['image'], array ('height' => '350', 'width' => '350', 'alt' => 'avatar', 'title' => 'Looking Fine!'));
					}else{
						echo $html->image('/img/avatar.png', array ('height' => '350', 'width' => '350', 'alt' => 'avatar', 'title' => 'This you brah?'));
					}?>
            
            </div> 
  <?php if($this->Session->read('User.id')){?>
        <div class = 'view-follow'>
        	<?php 
			$followings = $this->requestAction('followers/getUserFollowings/'.$this->Session->read('User.id'));
			$count = 0;
			foreach($followings as $following){
				if($following['Follower']['following_id'] == $user['User']['id']){
					$count++;
				}
				
			}
			if($user['User']['id'] != $this->Session->read('User.id')){
				if($count <= 0){
					?><a class = 'follow' id = 'follow_<?php echo $user['User']['id']?>'><img src="../../webroot/img/follow.png"></a>
					  <a style="display:none" class = 'unfollow' id = 'unfollow_<?php echo $user['User']['id']?>'><img src="../../webroot/img/unfollow.png"></a>
					<?php
					
				}else{
					?><a style="display:none" class = 'follow' id = 'follow_<?php echo $user['User']['id']?>'><img src="../../webroot/img/follow.png"></a>
					  <a class = 'unfollow' id = 'unfollow_<?php echo $user['User']['id']?>'><img src="../../webroot/img/unfollow.png"></a>
					<?php
				}
			}
		
		?>
        </div>
  <?php }?>
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
        	<h1>About Me</h1>
        	<?php if($user['User']['about'] != NULL){?>
           		<p><?php echo $user['User']['about'];?></p>
           <?php }?>
        </div>
        <?php $allUsers = $this->requestAction('users/getAllUsers/');?>
        <?php $userFollowings = $this->requestAction('followers/getUserFollowings/'.$id);?>
        <?php $userFollowed = $this->requestAction('followers/getUserFollowed/'.$id);?> 
        
<?php if ($this->Session->read('User.id')){?>
        <div class = 'social-others'>
        <?php $meets = $this->requestAction('users/getOthers/');?>
        	<h1>Other Members</h1><p id = 'meet-others-hide'>hide</p>
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
   <?php }?>
        <div class = 'home-following'>
        	<h1>Following</h1>	<p id = 'following-hide'>hide</p>
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
        	<h1>Followers</h1>	<p id = 'followers-hide'>hide</p>
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
								echo $html->link($html->image($urlString.$count, array('width' => '32', 'height' => '32')), array('controller' => 'users', 'action' => 'view',$userFollow['Follower']['user_id']), array('escape' => false, 'title' => $allUser['User']['username']));
								//echo '</div>';
							}
						}
						endforeach;
				endforeach;?>
             </div>
        </div>
        <!--<div class = 'left-nav-advertisement'>
               <script type="text/javascript"><!--
					google_ad_client = "ca-pub-7534023795746626";
					/* nav */
					google_ad_slot = "1179611794";
					google_ad_width = 336;
					google_ad_height = 280;
					
					</script>
					<script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
         </div>-->
        
    </div>

<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script>
     google.load('visualization', '1', {'packages':['corechart']});
</script>
<?php echo $this->Html->script('view');?>
    
<div class = 'home-right-shadow'>
    <div class = 'right-nav-content'>
        <?php echo $this->Session->flash(); ?>
        <div class = 'view-user' id = 'view-user_<?php echo $id?>'></div>
        <div class = 'home-header'>
            <ul>
                <li class = 'li-active' id = "home-feed"><a href = 'users/ajax_feed/<?php echo $id;?>'>Feed</a></li>
                <li id = "home-progress"><a href = 'users/ajax_progress'>Progress</a></li>
                <li id = "home-pictures"><a href = 'users/ajax_pictures/<?php echo $id;?>'>Pictures</a></li>
            </ul>
        </div>
        
        <div class = 'home-wrapper'>  
                <!--<div class = 'social-post'  id = 'paginator_<?php //echo ($page_no);?>'>
                	<?php
						/*echo $form->create('Post', array('action' => 'add'));
						echo $this->Form->hidden('user_id', array('value' => $this->Session->read('User.id')));
						
						echo $form->input('body', array('class' => 'textarea', 'rows' => '1', 'type' => 'textarea', 'placeholder' => 'Write a Post...', 'label' => false));
						echo $form->end('post.png');*/
                    ?>
                </div>-->
                	<?php foreach ($posts as $post): ?>
                <div class = 'social-content' id = 'social-content_<?php echo  $post['Post']['id']?>'>
                    <div class = 'social-all'>
                        <div class = 'social-avatar'>
                            <?php
								echo '<a name = "'.$post['Post']['id'].'"> </a>';
                                $urlString = '/img/uploads/users/'; 
                                $avatar = $this->requestAction('pictures/getAvatar/'.$post['Post']['user_id']);
                                if(!empty($avatar)){
                                    echo $html->link($html->image($urlString.$avatar['Picture']['image'], array('width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'view',$post['User']['id']), array('escape' => false, 'title' => $post['User']['username']));
                                }else{
                                    echo $html->link($html->image('/img/avatar.png',array('width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'view',$post['User']['id']), array('escape' => false, 'title' => $post['User']['username']));
                                
                                }
                               ?>
                        </div>
                         <div class = 'social-info'>
                        	  <?php echo $html->link($post['User']['username'], array('controller' => 'users', 'action' => 'view',$post['User']['id']));?>
                              
                              <?php   
									$date = $this->requestAction('users/getTime/'.strtotime($post['Post']['created']));
									echo '<p>'.$date.'</p>';
								?>
                              
                              <?php
									if($this->Session->read("User.level") == 1 || $this->Session->read('User.id') == $post['Post']['user_id']) {
										echo $html->link('Delete', array('controller' => 'posts', 'action'=>'delete', $post['Post']['id']), array('class' => 'post_options'), "are you sure?");
									}
								?>
                        </div>
                        <div class = 'social-text'>
                        	  <?php echo $post['Post']['body']; ?>
                              <div class = 'comment-select-wrapper'>
                              <div class = 'comment-select' id = 'commentSelect-<?php echo $post['Post']['id']?>'>Comment</div>
                              
                              <?php $count2 = 0;$count3 =  0; $test = array();
			
									/*foreach($likes as $like){
										if($post['Post']['id'] == $like['Like']['post_id'] && $like['Like']['user_id'] == $this->Session->read('User.id')){
											$count2++;
										}
										if($post['Post']['id'] == $like['Like']['post_id']){
											//$test[$count3]['id'] = $like['User']['username'];
											$test[$count3]['username'] = $like['User']['username'];
											$test[$count3]['user_id'] = $like['Like']['user_id'];
											$test[$count3]['break'] = ', ';
											$count3++;
										}
									}*/
									foreach($post['Like'] as $like){
										if($like['user_id'] == $this->Session->read('User.id')){
											$count2++;
										}
										
										$username = $this->requestAction('users/getSelectedUser/'.$like['user_id']);
										$test[$count3]['username'] = $username['User']['username'];
										$test[$count3]['user_id'] = $like['user_id'];
										$test[$count3]['break'] = ', ';
										$count3++;
									}
									
									
									if($count2 == 0 && $post['Post']['user_id'] != $this->Session->read('User.id') && $this->Session->read('User.id') != null){
												echo "<a class = 'like' id = 'like_".$post['Post']['id']."'>Like</a>";
									}elseif($post['Post']['user_id'] != $this->Session->read('User.id') && $this->Session->read('User.id') != null){
												echo "<a class = 'like' id = 'like_".$post['Post']['id']."'>Unlike</a>";
									}
									echo '</div>';
									
									echo '<div class = "comment-likes" id = "likes-'.$post['Post']['id'].'" >';
									foreach ($test as $item){
											$avatar = $this->requestAction('pictures/getAvatar/'.$item['user_id']);
											if(!empty($avatar)){
												echo $html->link($html->image($urlString.$avatar['Picture']['image'], array('width' => '32', 'height' => '32')), array('controller' => 'users', 'action' => 'view',$item['user_id']), array('escape' => false, 'title' => $item['username']));
											}else{
												echo $html->link($html->image('/img/avatar.png',array('width' => '32', 'height' => '32')), array('controller' => 'users', 'action' => 'view',$item['user_id']), array('escape' => false, 'title' => $item['username']));
											
											}
										}
									if(!empty($test)){
										echo 'Likes this!';
									}
									echo '</div>';
								?>
                                
                                <div class = 'comment' id = 'comment-<?php echo $post['Post']['id']?>'>
                                    <?php foreach($post['Comment'] as $comment){
										$commentNew = $this->requestAction('comments/getComment/'.$comment['id']);
										$count = count($commentNew['Like']);
										echo '<div class = "comment-each">';
											$avatar = $this->requestAction('pictures/getAvatar/'.$comment['user_id']);
											$username = $this->requestAction('users/getSelectedUser/'.$comment['user_id']);
											if(!empty($avatar)){
												echo $html->link($html->image($urlString.$avatar['Picture']['image'], array('width' => '32', 'height' => '32')), array('controller' => 'users', 'action' => 'view',$comment['user_id']), array('escape' => false, 'title' => $username['User']['username']));
											}else{
												echo $html->link($html->image('/img/avatar.png',array('width' => '32', 'height' => '32')), array('controller' => 'users', 'action' => 'view',$comment['user_id']), array('escape' => false, 'title' => $username['User']['username']));
											}
											
											echo '<div class = "comment-info">';
												echo '<a name = "'.$comment['id'].'"> </a>';
												echo '<p>'.$username['User']['username'].'</p>';
												echo $comment['text'];
												$time = strtotime($comment['created']);
												$date = $this->requestAction('users/getTime/'.$time);
												echo '<div class = "comment-date">';
													echo '<a class = "comment-date-holder">'.$date.' - </a>';
													
													$count4 = 0;
													foreach($commentNew['Like'] as $likeNew){
														if($likeNew['user_id'] == $this->Session->read('User.id')){
															$count4 = 1;	
														}
													}
													
													if($count4 == 0 && $comment['user_id'] != $this->Session->read('User.id') && $this->Session->read('User.id') != NULL){
														echo '<a class = "comment-like" id = "commentLike-'.$comment['id'].'">Like </a>';
													}elseif ($comment['user_id'] != $this->Session->read('User.id') && $this->Session->read('User.id') != NULL){
														echo '<a class = "comment-like" id = "commentLike-'.$comment['id'].'">Unlike </a>';
													}
													
													echo '<div class = "new-likes" id = "new-likes_'.$comment['id'].'">('.$count.' likes)</div>';
													
													#View comment likes.
													echo '<div class = "likes-table" id = "likes-table_'.$comment['id'].'">';
														foreach($commentNew['Like'] as $likeNew){
															echo '<div class = "likes-avatar">';
																$urlString = '/img/uploads/users/'; 
																$avatar = $this->requestAction('pictures/getAvatar/'.$likeNew['user_id']);
																$user = $this->requestAction('users/getSelectedUser/'.$likeNew['user_id']);
																if(!empty($avatar)){
																	echo $html->link($html->image($urlString.$avatar['Picture']['image'], array('width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'view',$user['User']['id']), array('escape' => false, 'title' => $user['User']['username']));
																}else{
																	echo $html->link($html->image('/img/avatar.png',array('width' => '64', 'height' => '64')), array('controller' => 'users', 'action' => 'view',$user['User']['id']), array('escape' => false, 'title' => $user['User']['username']));
																
																}
															echo '</div>';
															
															echo '<div class = "likes-info">';
																echo $html->link($user['User']['username'], array('controller' => 'users', 'action' => 'view',$user['User']['id']))?>
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
																					echo '<td>'.$user['User']['height'], 'cm</td>';
																				} else{
																					echo '<td>'.$user['User']['heightFoot'],"' ";
																					echo $user['User']['heightInch'],"''</td> ";
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
															
															<?php echo '</div>';
														}
													echo '</div>';
											
												echo '</div>';
											echo '</div>';
										echo '</div>';
										
										}
									?>
                                    <?php if($this->Session->read('User.id')){?>
                                    <div class = 'new-comment'>
                                    	<?php $avatar = $this->requestAction('pictures/getAvatar/'.$this->Session->read('User.id'));?> 
										<?php if(!empty($avatar)){
                                                echo $html->image($urlString.$avatar['Picture']['image'], array ('height' => '32', 'width' => '32', 'alt' => 'avatar', 'title' => 'Looking Fine!'));
                                            }else{
                                                echo $html->image('/img/avatar.png', array ('height' => '32', 'width' => '32', 'alt' => 'avatar', 'title' => 'This you brah?'));
                                            }
                                            	//echo $this->Form->create('Comment', array('action'=>'add'));
												echo $this->Form->hidden('post_id', array('value' => $post['Post']['id']));
												echo $this->Form->hidden('user_id', array('value' => $this->Session->read('User.id') ) );
												echo $this->Form->input('text', array('placeholder' => 'Add comment...', 'type' =>'textarea', 'class' => 'textarea', 'rows' => '1', 'label' => false));
												echo '<div class = "error-message" id = "error-message_'.$post['Post']['id'].'"></div>';
												echo '<div class = "submit" id = "submit_'.$post['Post']['id'].'">';
													echo $this->Form->submit('submit.png', array('div'=>false));
												echo '</div>';
										?>
                                    </div>
                                    <?php }?>
                                </div>
                        </div>
                    </div>
            </div>		
        <?php endforeach; ?>
        <a name = 'paginator'> </a>
        <?php $page_no++;
            if(count($totalPosts) > $page_no * 5){?>
        <div class='paginator'>
                <?php echo $html->link('Show More', array('controller' => 'users', 'action' => 'view', $id,$page_no, '#paginator'), array('id' => 'paginator'))?>
        </div>
            <?php }?>
  
                   
            </div>
         </div>
    </div>
</div> 
<script> feed(); follow(); commentViewLikes(); commentAdd(); like(); commentLike();</script>
