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