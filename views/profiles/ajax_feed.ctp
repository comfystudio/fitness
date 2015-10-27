
<div class = 'social-post'  id = 'paginator_<?php echo ($page_no);?>'>
	<?php
        echo $form->create('Post', array('action' => 'add/feed'));
        echo $this->Form->hidden('user_id', array('value' => $this->Session->read('User.id')));
        
        echo $form->input('body', array('class' => 'textarea', 'rows' => '1', 'type' => 'textarea', 'placeholder' => 'Write a Post...', 'label' => false));
        echo $form->end('post.png');
    ?>
</div>
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
                        echo $html->link('Delete', array('action'=>'delete', $post['Post']['id']), array('class' => 'post_options'), "are you sure?");
                    }
                ?>
        </div>
        <div class = 'social-text'>
              <?php echo $post['Post']['body']; ?>
              <div class = 'comment-select-wrapper'>
              <div class = 'comment-select' id = 'commentSelect-<?php echo $post['Post']['id']?>'>Comment</div>
              
              <?php $count2 = 0;$count3 =  0; $test = array();

                    foreach($likes as $like){
                        if($post['Post']['id'] == $like['Like']['post_id'] && $like['Like']['user_id'] == $this->Session->read('User.id')){
                            $count2++;
                        }
                        if($post['Post']['id'] == $like['Like']['post_id']){
                            $test[$count3]['username'] = $like['User']['username'];
                            $test[$count3]['user_id'] = $like['Like']['user_id'];
                            $test[$count3]['break'] = ', ';
                            $count3++;
                        }
                    }
                    if($count2 == 0 && $post['Post']['user_id'] != $this->Session->read('User.id') && $this->Session->read('User.id') != null){
                                echo "<a class = 'like' id = 'like_".$post['Post']['id']."'>Like</a>";
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
                                echo '<div class = "comment-date">'.$date.' - ';
                                    echo '<a class = "comment-like" id = "commentLike-'.$comment['id'].'">Like </a>';
                                    echo '<div class = "new-likes" id = "new-likes_'.$comment['id'].'">('.$comment['likes'].' likes)</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                        
                        }
                    ?>
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
                </div>
        </div>
    </div>
</div>		
<?php endforeach; ?>
<a name = 'paginator'> </a>
<?php $page_no++;
if(count($totalPosts) > $page_no * 5){?>
   <div class='paginator'>
        <?php echo $html->link('Show More', array('controller' => 'profiles', 'action' => 'index', $page_no, '#paginator'), array('id' => 'paginator'))?>
    </div>
<?php }?>