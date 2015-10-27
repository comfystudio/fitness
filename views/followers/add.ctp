<?php $allUsers = $this->requestAction('users/getAllUsers/');?>
<?php $userFollowings = $this->requestAction('followers/getUserFollowings/'.$user_id);?>
<?php $userFollowed = $this->requestAction('followers/getUserFollowed/'.$user_id);?> 
<?php $urlString = '/img/uploads/users/';?>

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
                        echo $html->link($html->image('/img/avatar.png', array('width' => '32', 'height' => '32')), array('controller' => 'users', 'action' => 'view',$userFollow['Follower']['user_id']), array('escape' => false, 'title' => $allUser['User']['username']));
                    }else {
                        echo $html->link($html->image($urlString.$count, array('width' => '32', 'height' => '32')), array('controller' => 'users', 'action' => 'view',$userFollow['Follower']['user_id']), array('escape' => false, 'title' => $allUser['User']['username']));
                    }
                }
                endforeach;
        endforeach;?>
     </div>
</div>